<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MembroController extends Controller
{
    //

    public function login()
    {
        return view("portal.membros.login");
    }

    public function setLogin(Request $request)
    {
        if(!$request->email || !$request->pin)
        {
            return redirect()->back()->with("error","Preencha os campos obrigatórios");
        }
        $email = $request->email;
        $pin = $request->pin;
        // dd($request);
        $membro = DB::table("clientes")
                        ->join("membros","membros.id_cliente","=","clientes.id")
                        ->where("clientes.email","=",$email)
                        ->where("membros.pin","=",$pin)
                        ->select("membros.*","clientes.id as id_cliente","clientes.nome","clientes.sobrenome",
                        "clientes.titulo","clientes.email","clientes.telefone","clientes.data")
                        ->first();
        // dd($membro);
        if(!$membro){
            
            return redirect()->back()->with("error","Usuário ou pin errado");
        }

        Session::put("membro",$membro);
        return redirect()->route("membro.dashboard");
    }

    public function registo()
    {
        return view("portal.membros.registo");
    } 
    public function dashboard()
    {
        return view("portal.membros.dashboard");
    }

    public function perfil($id)
    {
         $membro = DB::table("clientes")
        ->join("membros","membros.id_cliente","=","clientes.id")
        ->where("membros.id","=",$id)
        ->select("membros.*","clientes.id as id_cliente","clientes.nome","clientes.sobrenome",
        "clientes.titulo","clientes.email","clientes.telefone","clientes.data")
        ->first();
        // dd($membro);
        return view("portal.membros.perfil",[
            "membro" => $membro
        ]);
    }

    public function compras($id)
    {
        $bilhetes = DB::table("compras")
                        ->join("bilhetes","bilhetes.id_compra","=","compras.id")
                        ->join("clientes","clientes.id","=","bilhetes.id_cliente")
                        ->join("membros","membros.id_cliente","=","clientes.id")
                        ->join("bilhete_lugares","bilhete_lugares.id_bilhete","=","bilhetes.id")
                        ->join("voo_lugares","voo_lugares.id","=","bilhete_lugares.id_voo_lugar")
                        ->join("lugares","lugares.id","=","voo_lugares.id_lugar")
                        ->join("voo_tarifas","voo_tarifas.id","=","voo_lugares.id_voo_tarifa")
                        ->join("voos","voos.id","=","voo_tarifas.id_voo")
                        ->join("aeroportos AS ORIGEM","ORIGEM.id","=","voos.id_aeroporto_origem")
                        ->join("cidades as CIDADE_ORIGEM","CIDADE_ORIGEM.id","=","ORIGEM.id_cidade")
                        ->join("aeroportos AS DESTINO","DESTINO.id","=","voos.id_aeroporto_destino")
                        ->join("cidades as CIDADE_DESTINO","CIDADE_DESTINO.id","=","DESTINO.id_cidade")
                        ->join("bilhete_lugares as bilhete_volta","bilhete_volta.id_bilhete","=","bilhetes.id","right")
                        ->join("voo_lugares as voo_lugar_volta","voo_lugar_volta.id","=","bilhete_volta.id_voo_lugar","right")
                        ->join("lugares as lugar_volta","lugar_volta.id","=","voo_lugar_volta.id_lugar","left")
                        ->join("voo_tarifas as voo_tarifa_volta","voo_tarifa_volta.id","=","voo_lugar_volta.id_voo_tarifa","right")
                        ->join("voos as voo_volta","voo_volta.id","=","voo_tarifa_volta.id_voo","right")
                        // ->where("bilhete_lugares.tipo","=",DB::raw("\"ida\""))
                        // ->where("bilhete_volta.tipo","=","ida")
                        ->where("bilhetes.tipo","=","so-ida")
                        ->where("membros.id","=",$id)
                        // ->where("bilhete_lugares.id","<>","bilhete_volta.id")
                        // ->where("bilhete_lugares.tipo","<>",DB::raw("bilhete_volta.tipo"))
                        ->select("compras.id as id_compra","bilhetes.id as id_bilhete","clientes.id as id_cliente",
                                    "clientes.nome as nome_cliente","clientes.sobrenome as sobrenome_cliente","voos.id as id_voo","bilhetes.tipo",
                                    "ORIGEM.id as id_origem","ORIGEM.nome as aeroporto_origem","CIDADE_ORIGEM.nome as cidade_origem",
                                    "DESTINO.id as id_destino","DESTINO.nome as aeroporto_destino",
                                    "CIDADE_DESTINO.nome as cidade_destino","bilhetes.estado","lugares.numero as lugar",
                                    "bilhete_lugares.estado as state","bilhete_lugares.tipo as tipo_ida",
                                    "bilhete_volta.tipo as tipo_volta","lugar_volta.numero as lugar_volta",
                                    "bilhete_lugares.id as id_bilhete_ida","bilhete_volta.id as id_bilhete_volta",
                                    "voos.data_partida","voos.hora")
                        ->orderBy("compras.id")
                        ->get();
    

    return view("portal.membros.compras",[
        "bilhetes" => $bilhetes ,
        "tipo"     => "ida"
    ]);

    }

    public function voos()
    {

    }

    public function index()
    {
        $aeroportos = DB::table("aeroportos")
                    ->join("cidades","cidades.id","=","aeroportos.id_cidade")
                    ->join("paises","paises.id","=","cidades.id_pais")
                    ->select("aeroportos.id","aeroportos.nome as aeroporto","cidades.nome as cidade","paises.nome as pais")
                    ->get();

        return view('portal.pages.home',[
            "aeroportos" => $aeroportos
        ]);
    }

    public function searchFlights(Request $request,)
    {
        $tipo = $request->tipo ?? 'ida';
        $origem = $request->origem ?? '1';
        $destino = $request->destino ?? '1';
        $data_partida = $request->data_partida ?? "2023-04-01";
        $data_regresso = $request->data_regresso ?? "2023-04-01";
        $passageiros = $request->qtd;
        $voos = [];

        if($tipo == "ida")
        {
            $voos = DB::table("voos")
                    ->join("aeroportos AS ORIGEM","ORIGEM.id","=","voos.id_aeroporto_origem")
                    ->join("cidades as CIDADE_ORIGEM","CIDADE_ORIGEM.id","=","ORIGEM.id_cidade")
                    ->join("aeroportos AS DESTINO","DESTINO.id","=","voos.id_aeroporto_destino")
                    ->join("cidades as CIDADE_DESTINO","CIDADE_DESTINO.id","=","DESTINO.id_cidade")
                    ->where("ORIGEM.id","=",$origem)
                    ->where("DESTINO.id","=",$destino)
                    ->where("voos.data_partida","=",$data_partida)
                    ->where("voos.estado","=","1")
                    ->select("voos.id as id_voo","voos.data_partida","voos.hora as hora","voos.duracao_estimada",
                    "ORIGEM.id as id_origem","ORIGEM.nome as aeroporto_origem","CIDADE_ORIGEM.nome as cidade_origem",
                    "DESTINO.id as id_destino","DESTINO.nome as aeroporto_destino","CIDADE_DESTINO.nome as cidade_destino")
                    ->selectRaw("DATE_ADD(concat(voos.data_partida,' ', voos.hora),INTERVAL voos.duracao_estimada HOUR) as chegada",[])
                    ->get();

                $voo_array = $voos->toArray();
                array_walk($voo_array,function($item){
                   return  $item->classes = $tarifas = DB::table("voo_tarifas")
                                                    ->join("tarifas","tarifas.id","=","voo_tarifas.id_tarifa")
                                                    ->join("classes","classes.id","=","tarifas.id_classe")
                                                    ->where("voo_tarifas.id_voo","=",$item->id_voo)
                                                    ->select("classes.nome","classes.id","voo_tarifas.id_voo")
                                                    ->distinct()
                                                    ->get();
                });

                array_walk($voo_array,function($item){
                    return  $item->tarifas = DB::table("voo_tarifas")
                                                     ->join("tarifas","tarifas.id","=","voo_tarifas.id_tarifa")
                                                     ->join("classes","classes.id","=","tarifas.id_classe")
                                                     ->join("voo_lugares","voo_lugares.id_voo_tarifa","=","voo_tarifas.id","right")
                                                     ->where("voo_tarifas.id_voo","=",$item->id_voo)
                                                     ->select("tarifas.id as tarifa_id","tarifas.nome as tarifa","voo_tarifas.preco",
                                                     "voo_tarifas.id as id_voo_tarifa","classes.nome as classe_nome","classes.id as classe_id")
                                                     ->selectRaw("count(voo_lugares.id) as lugares,voo_lugares.estado")
                                                     ->groupBy("tarifas.id","tarifas.nome","voo_tarifas.preco","voo_tarifas.id"
                                                            ,"classes.nome","classes.id","voo_lugares.estado")
                                                     ->having("voo_lugares.estado","=","0")
                                                     ->distinct()
                                                     ->get();
                 });

                
                    // dd($voo_array);
                    Session::put("search",[
                        "id_origem" => $origem,
                        "id_destino"=> $destino,
                        "partida"   => $data_partida,
                        "qtd"       => $passageiros,
                        "tipo"      => "so-ida"
                    ]);
        }else{
            $voos = DB::table("voos")
                    ->join("aeroportos AS ORIGEM","ORIGEM.id","=","voos.id_aeroporto_origem")
                    ->join("cidades as CIDADE_ORIGEM","CIDADE_ORIGEM.id","=","ORIGEM.id_cidade")
                    ->join("aeroportos AS DESTINO","DESTINO.id","=","voos.id_aeroporto_destino")
                    ->join("cidades as CIDADE_DESTINO","CIDADE_DESTINO.id","=","DESTINO.id_cidade")
                    ->where("ORIGEM.id","=",$origem)
                    ->where("DESTINO.id","=",$destino)
                    ->where("voos.data_partida","=",$data_partida)
                    ->select("voos.id as id_voo","voos.data_partida","voos.hora as time",
                    "ORIGEM.id as id_origem","ORIGEM.nome as aeroporto_origem","CIDADE_ORIGEM.nome as cidade_origem",
                    "DESTINO.id as id_destino","DESTINO.nome as aeroporto_destino","CIDADE_DESTINO.nome as cidade_destino")
                    ->get();
        }
        // $t = date_add(new DateTime("2022-10-10"),new DateInterval("PT5H"));
        // dd($t);
        // dd($voos);
        
        return view("portal.pages.compras.voos",[
            "voos" => $voo_array
        ]);
    }


    public function compra(Request $request)
    {
        $tipo = $request->query("tipo");
        
        if($tipo == "so-ida"){
           return redirect()->route("portal.passageiros",$request->query());
        }else{
            return redirect()->back();;
        }


    }

    public function setPassageiros(Request $request)
    {

        $voo = DB::table("voos")
        ->join("aeroportos AS ORIGEM","ORIGEM.id","=","voos.id_aeroporto_origem")
        ->join("cidades as CIDADE_ORIGEM","CIDADE_ORIGEM.id","=","ORIGEM.id_cidade")
        ->join("aeroportos AS DESTINO","DESTINO.id","=","voos.id_aeroporto_destino")
        ->join("cidades as CIDADE_DESTINO","CIDADE_DESTINO.id","=","DESTINO.id_cidade")
        ->where("voos.id","=",$request->query("id_voo"))
        ->select("voos.id as id_voo","voos.data_partida","voos.hora","voos.estado","voos.duracao_estimada",
        "ORIGEM.id as id_origem","ORIGEM.nome as aeroporto_origem","CIDADE_ORIGEM.nome as cidade_origem",
        "DESTINO.id as id_destino","DESTINO.nome as aeroporto_destino","CIDADE_DESTINO.nome as cidade_destino")
        ->selectRaw("DATE_ADD(concat(voos.data_partida,' ', voos.hora),INTERVAL voos.duracao_estimada HOUR) as chegada",[])
        ->first();
        return view("portal.pages.compras.passageiros",[
            "detalhes" => $request->query(),
            "voo" => $voo
        ]);
    }

    public function efectuarCompra(Request $request)
    {
        if(!($request->has(["id_voo","id_voo_tarifa","qtd","tipo"])))
        {
            return redirect()->back()->with("error","Ocorreu um erro. Tente novamente");
        }

        if($request->tipo == "so-ida")
        {
            
            if($this->guardarDados($request)){
                return redirect()->route("compra.result")->with("success","Compra efectuada");
            }else{
                return redirect()->back()->with("error","Ocorreu um erro. Tente novamente");
            }

        }else{
            return redirect()->back()->with("error","Ocorreu um erro. Tente novamente");
        }

    }

    public function getRandomPlaces($id_voo_tarifa)
    {
        $lugar = DB::table("voo_lugares")
                    ->where("voo_lugares.id_voo_tarifa","=",$id_voo_tarifa)
                    ->where("voo_lugares.estado","=","0")
                    ->select("voo_lugares.id as id_lugar")
                    ->inRandomOrder()
                    ->first();
        return $lugar;
    }

    public function getResult()
    {
        return view("portal.pages.compras.result");
    }

    public function guardarDados(Request $request)
    {
        // $nome = "nome1";
        // dd($request->$nome);
        try{

            $idCompra = DB::table("compras")->insertGetId([
                "valor_total" => 1000,
                "pago"        => 0,
                "referencia_pagamento" => "REF32",
                "estado"      => 1
            ]);

            for($i=1;$i <= $request->qtd;$i++ )
            {
                $nome = "nome".$i;
                $titulo = "titulo".$i;
                $sobrenome = "sobrenome".$i;
                $email = "email".$i;
                $telefone = "telefone".$i;
                // dd($request->titulo);
                if($i == 1)
                {
                    $idCliente = (Session::get("membro"))->id_cliente;

                }else{
                    $idCliente = DB::table("clientes")->insertGetId([
                        "titulo" => $request->$titulo,
                        "nome"   => $request->$nome,
                        "sobrenome"=> $request->$sobrenome,
                        "email" =>$request->$email,
                        "telefone" =>$request->$telefone,
                        "data" =>"2023-10-10",
                        "estado"=> 1
                    ]);
                }
                

                $idBilhete = DB::table("bilhetes")->insertGetId([
                    "id_compra" => $idCompra,
                    "id_cliente"=> $idCliente,
                    "tipo"      => $request->tipo,
                    "estado"    => 1
                ]);

                $idPlace = $this->getRandomPlaces($request->id_voo_tarifa);
                
                $idLugar = DB::table("bilhete_lugares")->insertGetId([
                    "id_bilhete" => $idBilhete,
                    "id_voo_lugar"=> $idPlace->id_lugar,
                    "tipo"      => "ida",
                    "estado"    => 1
                ]);

                DB::table('voo_lugares')
                    ->where('id', $idPlace->id_lugar)
                    ->update(['estado' => 1]);

            }

            return true;
        }catch(Exception $e){
            dd($e);
            return false;
        }

    }

    public function logout()
    {
        Session::remove('membro');
        return redirect()->route('portal');
    }
}
