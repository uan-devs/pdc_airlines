<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegaliaController extends Controller
{
    //
    public function index()
    {
        $regalias = DB::table("regalias")->get();
        return view("admin.pages.regalias.index",[
            "regalias" => $regalias
        ]);
    }

    public function create(Request $request)
    {
        if(!$request->regalia)
        {
            return redirect()->back()->with("error","Preencha os campos obrigatórios");
        }

        try{
            $classe = DB::table("regalias")->insertGetId([
                "nome"=> $request->regalia
            ]);
            return redirect()->back()->with("success","Regalia adicionada");
        }catch(Exception $e)
        {
            return redirect()->back()->with("error","Ocorreu um erro. tente novamente");
        }
        
    }
    public function atribuir(Request $request)
    {
        if(!$request->regalia || !$request->id_tarifa)
        {
            return redirect()->back()->with("error","Preencha os campos obrigatórios");
        }

        try{
            $classe = DB::table("regalias_tarifas")->insertGetId([
                "id_regalia"=> $request->regalia,
                "id_tarifa" => $request->id_tarifa,
                "estado" => 0
            ]);
            return redirect()->back()->with("success","Regalia atribuida");
        }catch(Exception $e)
        {
            return redirect()->back()->with("error","Ocorreu um erro. tente novamente");
        }
        
    }
}
