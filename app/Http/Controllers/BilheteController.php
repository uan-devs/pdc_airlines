<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session as FacadesSession;

class BilheteController extends Controller
{
    //
        public function getIda()
        {
            $bilhetes = DB::table("compras")
                        ->join("bilhetes","bilhetes.id_compra","=","compras.id")
                        ->join("clientes","clientes.id","=","bilhetes.id_cliente")
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
                        // ->where("bilhete_lugares.id","<>","bilhete_volta.id")
                        // ->where("bilhete_lugares.tipo","<>",DB::raw("bilhete_volta.tipo"))
                        ->select("compras.id as id_compra","bilhetes.id as id_bilhete","clientes.id as id_cliente",
                                    "clientes.nome as nome_cliente","clientes.sobrenome as sobrenome_cliente","voos.id as id_voo","bilhetes.tipo",
                                    "ORIGEM.id as id_origem","ORIGEM.nome as aeroporto_origem","CIDADE_ORIGEM.nome as cidade_origem",
                                    "DESTINO.id as id_destino","DESTINO.nome as aeroporto_destino",
                                    "CIDADE_DESTINO.nome as cidade_destino","bilhetes.estado","lugares.numero as lugar",
                                    "bilhete_lugares.estado as state","bilhete_lugares.tipo as tipo_ida",
                                    "bilhete_volta.tipo as tipo_volta","lugar_volta.numero as lugar_volta",
                                    "bilhete_lugares.id as id_bilhete_ida","bilhete_volta.id as id_bilhete_volta")
                        ->orderBy("compras.id")
                        ->get();
                        // dd($bilhetes);
                        
            return view("admin.pages.bilhetes.index",[
                "bilhetes"=> $bilhetes,
                "tipo" => "ida"
            ]); 
        }

        public function getIdaVolta()
        {
            $bilhetes = DB::table("compras")
            ->join("bilhetes","bilhetes.id_compra","=","compras.id")
            ->join("clientes","clientes.id","=","bilhetes.id_cliente")
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
            ->join("aeroportos AS ORIGEM_VOLTA","ORIGEM_VOLTA.id","=","voo_volta.id_aeroporto_origem","right")
            ->join("cidades as CIDADE_ORIGEM_VOLTA","CIDADE_ORIGEM_VOLTA.id","=","ORIGEM_VOLTA.id_cidade","right")
            ->join("aeroportos AS DESTINO_VOLTA","DESTINO_VOLTA.id","=","voo_volta.id_aeroporto_destino","right")
            ->join("cidades as CIDADE_DESTINO_VOLTA","CIDADE_DESTINO_VOLTA.id","=","DESTINO_VOLTA.id_cidade","right")
            
            ->where("bilhete_lugares.tipo","=",DB::raw("\"ida\""))
            ->where("bilhete_volta.tipo","=","volta")
            // ->where("bilhetes.tipo","=","ida-volta")
            // ->where("bilhete_lugares.id","<>","bilhete_volta.id")
            // ->where("bilhete_lugares.tipo","<>",DB::raw("bilhete_volta.tipo"))
            ->select("compras.id as id_compra","bilhetes.id as id_bilhete","clientes.id as id_cliente",
                        "clientes.nome as nome_cliente","clientes.sobrenome as sobrenome_cliente","voos.id as id_voo","bilhetes.tipo",
                        "ORIGEM.id as id_origem","ORIGEM.nome as aeroporto_origem","CIDADE_ORIGEM.nome as cidade_origem",
                        "DESTINO.id as id_destino","DESTINO.nome as aeroporto_destino",
                        "CIDADE_DESTINO.nome as cidade_destino","bilhetes.estado","lugares.numero as lugar",
                        "ORIGEM_VOLTA.nome as aeroporto_origem_volta","CIDADE_ORIGEM_VOLTA.nome as cidade_origem_volta",
                        "DESTINO_VOLTA.nome as aeroporto_destino_volta","CIDADE_DESTINO_VOLTA.nome as cidade_destino_volta",
                        "bilhete_lugares.estado as state","bilhete_lugares.tipo as tipo_ida",
                        "bilhete_volta.tipo as tipo_volta","bilhete_volta.estado as state_volta","lugar_volta.numero as lugar_volta",
                        "bilhete_lugares.id as id_bilhete_ida","bilhete_volta.id as id_bilhete_volta")
            ->orderBy("compras.id")
            ->get();
            // dd($bilhetes);
            
            return view("admin.pages.bilhetes.index",[
                "bilhetes"=> $bilhetes,
                "tipo" => "ida-volta"
            ]);
        }
}
