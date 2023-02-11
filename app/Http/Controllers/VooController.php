<?php

namespace App\Http\Controllers;
use Throwable;
use App\Mail\NotificacaoCancelamento;
use App\Mail\NotificacaoMudanca;
use App\Models\Aviao;
use App\Models\Voo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Mail;


use function PHPUnit\Framework\isEmpty;
use Illuminate\Support\Facades\Crypt;

class VooController extends Controller
{
    //

    public function index()
    {
        
        
        $voos = DB::table("voos")
                ->join("aeroportos AS ORIGEM","ORIGEM.id","=","voos.id_aeroporto_origem")
                ->join("cidades as CIDADE_ORIGEM","CIDADE_ORIGEM.id","=","ORIGEM.id_cidade")
                ->join("aeroportos AS DESTINO","DESTINO.id","=","voos.id_aeroporto_destino")
                ->join("cidades as CIDADE_DESTINO","CIDADE_DESTINO.id","=","DESTINO.id_cidade")
                ->select("voos.id as id_voo","voos.data_partida","voos.hora","voos.estado",
                "ORIGEM.id as id_origem","ORIGEM.nome as aeroporto_origem","CIDADE_ORIGEM.nome as cidade_origem",
                "DESTINO.id as id_destino","DESTINO.nome as aeroporto_destino","CIDADE_DESTINO.nome as cidade_destino")
                ->paginate(4);
        // dd($voos);
        return view("admin.pages.voos.index",[
            "voos" => $voos
        ]);
    }

    public function show($id)
    {
        $id = Crypt::decryptString($id);
        
        $voo = DB::table("voos")
                ->join("aeroportos AS ORIGEM","ORIGEM.id","=","voos.id_aeroporto_origem")
                ->join("cidades as CIDADE_ORIGEM","CIDADE_ORIGEM.id","=","ORIGEM.id_cidade")
                ->join("aeroportos AS DESTINO","DESTINO.id","=","voos.id_aeroporto_destino")
                ->join("cidades as CIDADE_DESTINO","CIDADE_DESTINO.id","=","DESTINO.id_cidade")
                ->join("avioes","voos.id_aviao","=","avioes.id")
                ->where("voos.id","=",$id)
                ->select("voos.id as id_voo","voos.data_partida","voos.hora","voos.estado",
                "ORIGEM.id as id_origem","ORIGEM.nome as aeroporto_origem","CIDADE_ORIGEM.nome as cidade_origem",
                "DESTINO.id as id_destino","DESTINO.nome as aeroporto_destino","CIDADE_DESTINO.nome as cidade_destino")
                ->first();
// dd($voo);
        $tarifas = DB::table("voo_tarifas")
                    ->join("tarifas","tarifas.id","=","voo_tarifas.id_tarifa")
                    ->join("classes","classes.id","=","tarifas.id_classe")
                    ->join("voo_lugares", "voo_lugares.id_voo_tarifa", "=", "voo_tarifas.id", "right")
                    ->where("voo_tarifas.id_voo","=",$id)
                    ->select("voo_tarifas.id as id_tarifa","tarifas.nome as tarifa","voo_tarifas.preco",
                    "voo_tarifas.taxa_retorno","classes.nome as classe")
                    ->selectRaw("count(voo_lugares.id) as lugares,voo_lugares.estado")
                    ->groupBy(
                        "voo_tarifas.id",
                        "tarifas.nome",
                        "voo_tarifas.preco",
                        "voo_tarifas.taxa_retorno",
                        "classes.nome",
                        "voo_lugares.estado"
                    )
                    ->having("voo_lugares.estado", "=", "0")
                    ->distinct()
                    ->get();
        $ids = DB::table("voo_tarifas")
                    ->join("tarifas","tarifas.id","=","voo_tarifas.id_tarifa")
                    ->join("classes","classes.id","=","tarifas.id_classe")
                    ->where("voo_tarifas.id_voo","=",$id)
                    ->select("tarifas.id")
                    ->get();
        // dd($ids->values()->toArray());
        $values = array_values($ids->values()->toArray());
        $values2 = array_map(function($item){
            return $item->id;
        },$values);

        $outrasTarifas = DB::table("tarifas")
                        ->whereNotIn("tarifas.id",$values2)
                        ->select("tarifas.id as id_tarifa","tarifas.nome as tarifa")
                        ->get();
        // dd($outrasTarifas);
            
        return view("admin.pages.voos.show",[
            "voo" => $voo,
            "tarifas" => $tarifas,
            "outrasTarifas" => $outrasTarifas
        ]);
        
    }


    public function edit($id){

        $idVoo = Crypt::decryptString($id);

        $voo = Voo::find($idVoo);
        if(!$voo)
        {
            return redirect()->back()->with("error","Não foi possível carregar o voo."); 
        }
        $aeroportos = DB::table("aeroportos")
                        ->join("cidades","cidades.id","=","aeroportos.id_cidade")
                        ->select("aeroportos.id as id","aeroportos.nome","cidades.nome as cidade")
                        ->get();

        $avioes = Aviao::all();

        return view("admin.pages.voos.edit",[
            "voo" => $voo,
            "aeroportos" => $aeroportos,
            "avioes" => $avioes
        ]);
    }
    public function update(Request $request)
    {
        if(!$request->idVoo)
        {
            return redirect()->back()->with("error","Não foi possível carregar o voo."); 
        }
        $idVoo = base64_decode($request->idVoo);

        try{
            $voo = Voo::find($idVoo);
            if(!$voo)
            {
                return redirect()->back()->with("error","Não foi possível carregar o voo."); 
            }
            $voo->data_partida = $request->nova_data;
            $voo->hora = $request->nova_hora;
            $voo->id_aviao = $request->aviao;
            $voo->duracao_estimada = $request->nova_duracao;

            $voo->save();
            $this->notificarVooAlterado($idVoo);
            //$this->notificarVooAlteradoSMS($idVoo);

            return redirect()->route("voos.show",Crypt::encryptString($idVoo))->with("success","Voo alterado com sucesso. Os clientes serão notificados");
        }catch(Exception $e)
        {
            return redirect()->back()->with("error","Não foi possível alterar o voo. Tente Novamente.");
        }

    }
    
    public function addTarifa(Request $request)
    {
        if( !isset($request->tarifa) || !isset($request->preco) || !isset($request->taxa))
        {
            return redirect()->back()->with("error", "Ocorreu um Erro. Preencha os campos obrigatórios");
        }

        try{
            
            DB::table('voo_tarifas')->insert([
                'id_voo'        => $request->id_voo,
                'id_tarifa'     => $request->tarifa,
                "preco"         => $request->preco,
                "taxa_retorno"          => $request->taxa
            ]);
            return redirect()->back()->with("success", "Tarifa Adicionada");

        }catch(Exception $e)
        {
            return redirect()->back()->with("error", "Ocorreu um Erro. Tente Novamente".$e->getMessage());
        }
    }

    public function activate($id)
    {
        try{

            $tarifa = DB::table("voo_tarifas")
            ->join("tarifas","tarifas.id","=","voo_tarifas.id_tarifa")
            ->join("classes","classes.id","=","tarifas.id_classe")
            ->join('voos',"voos.id","=","voo_tarifas.id_voo")
            ->join("avioes","avioes.id","=","voos.id_aviao")
            ->where("voo_tarifas.id_voo","=",$id)
            ->select("voo_tarifas.id as id_tarifa","voo_tarifas.id_voo","avioes.id as id_aviao")
            ->first();

            if(!($tarifa)){
                return redirect()->back()->with("error", "Não tem tarifas definidas");
            }
            
            $lugares = DB::table("lugares")
            ->where("id_aviao","=",$tarifa->id_aviao)
            ->select("lugares.id")
            ->get()->toArray();

            if(empty($lugares))
            {
                return redirect()->back()->with("error", "Avião sem lugares definidos");
            }
            foreach($lugares as $item)
            {
                DB::table('voo_lugares')->insert([
                    'id_voo_tarifa'        => $tarifa->id_tarifa,
                    'id_lugar'     => $item->id,
                    "estado"         => 0
                ]);
            }

            $voo = (new Voo())->find($tarifa->id_voo);
            $voo->estado = 1;
            $voo->save();

            return redirect()->back()->with("success", "Voo activado com sucesso!");
            
            dd($lugares);
        }catch(Exception $e){
            return redirect()->back()->with("error", "Ocorreu um erro inexperado. Tente novamente");
        }


    }

    public function getLugares2($id)
    {
        $voo = DB::table("voos")
                ->join("avioes","voos.id_aviao","=","avioes.id")
                ->where("voos.id","=",$id)
                ->select("voos.id as id_voo","voos.data_partida","voos.hora","voos.estado",
                            "avioes.capacidade")
                 ->first();
        $lugaresPorFila = (intval($voo->capacidade)/4);
        
        $lugares = DB::table("voo_lugares")
        ->join("lugares","lugares.id","=","voo_lugares.id_lugar")
        ->join("voo_tarifas","voo_tarifas.id","=","voo_lugares.id_voo_tarifa")
        ->join("tarifas","tarifas.id","=","voo_tarifas.id_tarifa")
        ->where("voo_tarifas.id_voo","=",$id)
        ->select("voo_lugares.id as id_lugar","voo_lugares.estado","lugares.numero","lugares.in_janela",
        "voo_tarifas.id_tarifa","tarifas.nome as tarifa")
        ->get()->toArray();
        
        return view("admin.pages.voos.lugares",[
            "voo" => $voo, 
            "lugares" => $lugares,
            "lugaresPorFila" => $lugaresPorFila
            
        ]);
    }

    public function getLugares($id)
    { 
        $id= Crypt::decryptString($id);
        $voo = DB::table("voos")
                ->join("avioes","voos.id_aviao","=","avioes.id")
                ->where("voos.id","=",$id)
                ->select("voos.id as id_voo","voos.data_partida","voos.hora","voos.estado",
                            "avioes.capacidade","avioes.id as id_aviao")
                 ->first();
        $colunas = DB::table("filas")
                ->where("id_aviao","=",$voo->id_aviao)
                ->select("id","identificador")
                ->get();
        
        $lugares = DB::table("voo_lugares")
        ->join("lugares","lugares.id","=","voo_lugares.id_lugar")
        ->join("voo_tarifas","voo_tarifas.id","=","voo_lugares.id_voo_tarifa")
        ->join("tarifas","tarifas.id","=","voo_tarifas.id_tarifa")
        ->where("voo_tarifas.id_voo","=",$id)
        ->orderBy("voo_lugares.id")
        ->select("voo_lugares.id as id_lugar","voo_lugares.estado","lugares.numero","lugares.id_fila","lugares.in_janela",
        "voo_tarifas.id_tarifa","tarifas.nome as tarifa")
        ->get()->toArray();
            

                array_walk($lugares,function($item){
                    if($item->estado == 1)
                    {
                        return  $item->cliente = $cliente = DB::table("voo_lugares")
                                                    ->join("bilhete_lugares","bilhete_lugares.id_voo_lugar","=","voo_lugares.id")
                                                    ->join("bilhetes","bilhetes.id","=","bilhete_lugares.id_bilhete")
                                                    ->join("clientes","clientes.id","=","bilhetes.id_cliente")
                                                    ->where("voo_lugares.id","=",$item->id_lugar)
                                                    ->select("clientes.nome","clientes.sobrenome","clientes.email",
                                                    "clientes.telefone","clientes.data")
                                                    ->distinct()
                                                    ->first();
                    }else{
                        return $item->cliente = null;
                    }
                   
                });
                // dd($lugares);

        $tarifas = DB::table("voo_tarifas")
            ->join("tarifas","tarifas.id","=","voo_tarifas.id_tarifa")
            ->where("voo_tarifas.id_voo","=",$id)
            ->select("voo_tarifas.id as id_tarifa","tarifas.nome as tarifa","voo_tarifas.preco",
            "voo_tarifas.taxa_retorno")
            ->get();

        return view("admin.pages.voos.lugares",[
            "voo" => $voo, 
            "lugares" => $lugares,
            "colunas" => $colunas,
            "tarifas" => $tarifas
        ]);
    }

    public function alterarTarifa(Request $request)
    {
        $lugares = $request->lugares;
        $tarifa = $request->id_tarifa;
        $places = explode(",",$lugares);

        foreach($places as $place)
        {
            DB::table("voo_lugares")
                ->where("id","=",$place)
                ->update(["id_voo_tarifa"=>$tarifa]);
        }
        return [
            "status" => "sucesso"
        ];
    }

    public function create()
    {
        $aeroportos = DB::table("aeroportos")
                        ->join("cidades","cidades.id","=","aeroportos.id_cidade")
                        ->select("aeroportos.id as id","aeroportos.nome","cidades.nome as cidade")
                        ->get();

        $avioes = Aviao::all();

        return view("admin.pages.voos.create",[
           "aeroportos" => $aeroportos,
            "avioes" => $avioes
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        if(!$request->data || !$request->hora || !$request->duracao)
        {
            return redirect()->back()->with("error","Preencha todos os campos obrigatórios");
        }else if($request->origem == $request->destino){
            return redirect()->back()->with("error","Origem e Destino devem ser diferentes");
        }else if($this->hasConflict($request)){
            return redirect()->back()->with("error","Conflito de Horários. Selecione uma outra data ou outro avião");
        }else if(!($this->isAviaoActivo($request->aviao))){
            return redirect()->back()->with("error","Avião não está em funcionamento.Provavelmente não tem lugares definidos ou foi retirado de circulação");
        }
        try{

            $voo = new Voo();   
            $voo->id_aeroporto_origem = $request->origem;
            $voo->id_aeroporto_destino = $request->destino;
            $voo->data_partida = $request->data;
            $voo->hora = $request->hora;
            $voo->duracao_estimada = $request->duracao;
            $voo->id_aviao = $request->aviao;
            $voo->estado = 0;
            $voo->save();
            $id = $voo->getAttribute("id");
            return redirect()->route("voos.show",Crypt::encryptString($id))->with("success","Voo Cadastrado com sucesso");
    
        }catch(Exception $e)
        {
            return redirect()->back()->with("error","Tente Novamente mais tarde");
        }
    }

    public function hasConflict(Request $request)
    {
        return false;
        // "voos.data_partida"." "."voos.hora"
        // new DateTime("voos.data_partida"." "."voos.hora"))->modify('+5 hour')->format('Y-m-d H:i')
        // Carbon::createFromFormat("Y-m-d H:i","voos.data_partida"." "."voos.hora")
        $voo_data = $request->data." ".$request->hora;
        // $voo_data = ($voo_data->toDateTimeString());
        // dd($voo_data->toDateTimeString());
        // var_dump($voo_data);
        // $voos = DB::table("voos")
        //         ->join("aeroportos as ORIGEM","ORIGEM.id","=","voos.id_aeroporto_origem")
        //         ->join("aeroportos as DESTINO","DESTINO.id","=","voos.id_aeroporto_destino")
        //         ->whereBetween((DB::raw(" (\"".$voo_data."\") ")),
        //                                 [" (concat(voos.data_partida,' ', voos.hora))", 
        //                                 ("(date_add(concat(voos.data_partida,' ',voos.hora), INTERVAL voos.duracao_estimada HOUR)) ")
        //                                  ])
        //         ->select("voos.id","voos.data_partida","voos.hora"  ,"voos.duracao_estimada")
                
        //         ->get();
        $voos = DB::table("voos")
                ->join("aeroportos as ORIGEM","ORIGEM.id","=","voos.id_aeroporto_origem")
                ->join("aeroportos as DESTINO","DESTINO.id","=","voos.id_aeroporto_destino")
                ->where("(concat(voos.data_partida,' ', voos.hora)","<=",DB::raw(" (\"".$voo_data."\") "))
                ->where("(date_add(concat(voos.data_partida,' ',voos.hora), INTERVAL voos.duracao_estimada HOUR)) ",">=",DB::raw(" (\"".$voo_data."\") "))
                ->select("voos.id","voos.data_partida","voos.hora"  ,"voos.duracao_estimada")
                ->get();

            dd($voos);
                return false;
    }
    public function isAviaoActivo($id_aviao)
    {
        $aviao = Aviao::find($id_aviao);
        return ($aviao->estado == 1);
    }

    public function cancelar($id)
    {
        try{
            $voo = (new Voo())->find($id);
            $voo->estado = -1;
            $voo->save();

            $this->notificarVooCancelado($id);
            return redirect()->back()->with("success", "Voo Cancelado!");
            
        }catch(Exception $e){
            return redirect()->back()->with("error", "Ocorreu um erro inexperado. Tente novamente");
        }

    }

    public function notificarVooCancelado($id)
    {
        try{
            $clientes = DB::table("bilhetes")
            ->join("clientes","clientes.id","=","bilhetes.id_cliente")
            ->join("bilhete_lugares","bilhete_lugares.id_bilhete","=","bilhetes.id")
            ->join("voo_lugares","voo_lugares.id","=","bilhete_lugares.id_voo_lugar")
            ->join("lugares","lugares.id","=","voo_lugares.id_lugar")
            ->join("voo_tarifas","voo_tarifas.id","=","voo_lugares.id_voo_tarifa")
            ->join("voos","voos.id","=","voo_tarifas.id_voo")
            ->join("aeroportos AS DESTINO","DESTINO.id","=","voos.id_aeroporto_destino")
            ->join("cidades as CIDADE_DESTINO","CIDADE_DESTINO.id","=","DESTINO.id_cidade")
            ->where("voos.id","=",$id)
            ->select("bilhetes.id as id_bilhete","clientes.id as id_cliente",
                    "clientes.nome as nome_cliente","clientes.sobrenome as sobrenome_cliente","clientes.email",
                    "voos.id as id_voo","voos.data_partida","voos.hora","CIDADE_DESTINO.nome as cidade"
                        )
            ->get();

            foreach($clientes as $cliente)
            {
                try{
                    dispatch(function () use ($cliente){
                        $message = Mail::to($cliente)->send(new NotificacaoCancelamento($cliente));
                        DB::table("sent_emails")->insert([
                           "nome" => $cliente->nome_cliente,
                           "email"=> $cliente->email,
                           "id_voo" => $cliente->id_voo,
                           "message"=> "" 
                        ]);
                    });
                    
                }catch(Exception $e)
                {
                    continue;
                }
            }
            
            return "Clientes Notificados";
        }catch(Exception $e)
        {
            return $e->getMessage();
        }
        
    }

    public function notificarVooAlterado($id)
    {
        try{
            $clientes = DB::table("bilhetes")
            ->join("clientes","clientes.id","=","bilhetes.id_cliente")
            ->join("bilhete_lugares","bilhete_lugares.id_bilhete","=","bilhetes.id")
            ->join("voo_lugares","voo_lugares.id","=","bilhete_lugares.id_voo_lugar")
            ->join("lugares","lugares.id","=","voo_lugares.id_lugar")
            ->join("voo_tarifas","voo_tarifas.id","=","voo_lugares.id_voo_tarifa")
            ->join("voos","voos.id","=","voo_tarifas.id_voo")
            ->join("aeroportos AS DESTINO","DESTINO.id","=","voos.id_aeroporto_destino")
            ->join("cidades as CIDADE_DESTINO","CIDADE_DESTINO.id","=","DESTINO.id_cidade")
            ->where("voos.id","=",$id)
            ->where("voo_lugares.estado","=","1")
            ->select("bilhetes.id as id_bilhete","clientes.id as id_cliente",
                    "clientes.nome as nome_cliente","clientes.sobrenome as sobrenome_cliente","clientes.email",
                    "voos.id as id_voo","voos.data_partida","voos.hora","CIDADE_DESTINO.nome as cidade"
                        )
            ->get();

            foreach($clientes as $cliente)
            {
                try{
                    dispatch(function () use ($cliente){
                        $message = Mail::to($cliente)->send(new NotificacaoMudanca($cliente));
                        DB::table("sent_emails")->insert([
                           "nome" => $cliente->nome_cliente,
                           "email"=> $cliente->email,
                           "id_voo" => $cliente->id_voo,
                           "message"=> "" 
                        ]);
                    });
                    
                }catch(Exception $e)
                {
                    continue;
                }
            }
            
            return "Clientes Notificados";
        }catch(Exception $e)
        {
            return $e->getMessage();
        }
    }

    public function notificarVooAlteradoSMS($id)
    {
        $basic = new \Vonage\Client\Credentials\Basic("55b688b2","0QNqZ7NphtLpMJIN");
        $client= new \Vonage\Client($basic);

        try{
            $clientes = DB::table("bilhetes")
            ->join("clientes","clientes.id","=","bilhetes.id_cliente")
            ->join("bilhete_lugares","bilhete_lugares.id_bilhete","=","bilhetes.id")
            ->join("voo_lugares","voo_lugares.id","=","bilhete_lugares.id_voo_lugar")
            ->join("lugares","lugares.id","=","voo_lugares.id_lugar")
            ->join("voo_tarifas","voo_tarifas.id","=","voo_lugares.id_voo_tarifa")
            ->join("voos","voos.id","=","voo_tarifas.id_voo")
            ->join("aeroportos AS DESTINO","DESTINO.id","=","voos.id_aeroporto_destino")
            ->join("cidades as CIDADE_DESTINO","CIDADE_DESTINO.id","=","DESTINO.id_cidade")
            ->where("voos.id","=",$id)
            ->where("voo_lugares.estado","=","1")
            ->select("bilhetes.id as id_bilhete","clientes.id as id_cliente",
                    "clientes.nome as nome_cliente","clientes.sobrenome as sobrenome_cliente",
                    "clientes.email","clientes.telefone",
                    "voos.id as id_voo","voos.data_partida","voos.hora","CIDADE_DESTINO.nome as cidade"
                        )
            ->get();

            foreach($clientes as $cliente)
            {
                try{
                    dispatch(function () use ($cliente,$client){
                         $response = $client->sms()->send(
                        new \Vonage\SMS\Message\SMS("244".$cliente->telefone,"PDC Airlines",
                                            "O seu voo com destino a {$cliente->cidade} foi reagendado para {$cliente->data_partida} as {$cliente->hora}. Caso nao esteja de acordo, pode contactar a compania para cancelar a sua viagem e pedir o reembolso.</br>")
                        );
    
                        $message = $response->current();

                        if($message->getStatus() == 0)
                        {
                            DB::table("sent_emails")->insert([
                                "nome" => $cliente->nome_cliente,
                                "email"=> $cliente->telefone,
                                "id_voo" => $cliente->id_voo,
                                "message"=> "enviada" 
                             ]);
                        }else{
                            DB::table("sent_emails")->insert([
                                "nome" => $cliente->nome_cliente,
                                "email"=> $cliente->telefone,
                                "id_voo" => $cliente->id_voo,
                                "message"=> "falhou" 
                             ]);
                        }
                    });
                    
                }catch(Exception $e)
                {
                    continue;
                }
            }
            
            return "Clientes Notificados";
        }catch(Exception $e)
        {
            return $e->getMessage();
        }
    }

    public function EnviarMensagem($id)
    {   $basic = new \Vonage\Client\Credentials\Basic("55b688b2","0QNqZ7NphtLpMJIN");
        $client= new \Vonage\Client($basic);
        try{
            $cliente = DB::table("clientes")
                        ->where("id","=",$id)
                        ->select("clientes.nome as nome_cliente","clientes.sobrenome as sobrenome_cliente",
                                    "clientes.email","clientes.telefone"
                                    )
                        ->first();
            $response = $client->sms()->send(
                new \Vonage\SMS\Message\SMS("+244".$cliente->telefone,"PDC Airlines",
                                            "Seja Bem vindo ao PDC Airlines, a sua compania de confianca")
            );
    
            $message = $response->current();
            dd($message);
            if($message->getStatus() == 0)
            {
                return "Mensagem Enviada";
            }else{
                return "Mensagem Não Enviada";
            }
            
        }catch(Exception $e)
        {
            return $e->getMessage();
        }
        
    }

    public function editTarifa($id)
    {
        $id = Crypt::decryptString($id);
        $tarifaVoo =  DB::table("voo_tarifas")
        ->join("tarifas","tarifas.id","=","voo_tarifas.id_tarifa")
        ->join("classes","classes.id","=","tarifas.id_classe")
        ->join("voo_lugares", "voo_lugares.id_voo_tarifa", "=", "voo_tarifas.id", "right")
        ->where("voo_tarifas.id","=",$id)
        ->select("voo_tarifas.id as id_tarifa","tarifas.nome as tarifa","voo_tarifas.preco",
        "voo_tarifas.taxa_retorno","classes.nome as classe")
        
        ->first();
        
        return view("admin.pages.voos.edit_tarifa",[
            "tarifa" => $tarifaVoo
        ]);
    }

    public function updateTarifaVoo(Request $request)
    {
        if(!$request->preco || !$request->taxa)
        {
            return redirect()->back()->with("error","Preencha os campos obriatórios");
        }
        try{

            $tarifaVoo = DB::table("voo_tarifas")->where("id","=",$request->id_tarifa)->first();
            if(!$tarifaVoo)
            {
                return redirect()->back()->with("error","Dados não encontrados");
            }
            DB::table("voo_tarifas")
                ->where("id","=",$request->id_tarifa)
                ->update(
                    [
                    "preco" => $request->preco,
                    "taxa_retorno" => $request->taxa
                    ]
                    );

            return redirect()->back()->with("success","Tarifa Actualizada");
        }catch(Exception $e)
        {
            redirect()->back()->with("error","Ocorreu um erro");
        }
    }

}
