<?php

namespace App\Http\Controllers;

use App\Models\Aviao;
use App\Models\Voo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;

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
                ->get();
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
                    ->where("voo_tarifas.id_voo","=",$id)
                    ->select("voo_tarifas.id as id_tarifa","tarifas.nome as tarifa","voo_tarifas.preco",
                    "voo_tarifas.taxa_retorno","classes.nome as classe")
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
            return redirect()->route("voos.show",base64_encode($id))->with("success","Voo Cadastrado com sucesso");
    
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

}
