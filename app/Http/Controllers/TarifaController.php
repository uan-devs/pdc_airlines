<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TarifaController extends Controller
{
    //

    public function index()
    {
        $classes = DB::table("classes")->get();
        $tarifas = DB::table("tarifas")
                    ->join("classes","classes.id","=","tarifas.id_classe")
                    ->select("tarifas.id","tarifas.nome as tarifa","classes.nome as classe")
                    ->get();
        return view("admin.pages.tarifas.index",[
            "tarifas" => $tarifas,
            "classes" => $classes
        ]);
    }

    public function create(Request $request)
    {
        if(!$request->tarifa)
        {
            return redirect()->back()->with("error","Preencha os campos obrigatórios");
        }

        try{
            $classe = DB::table("tarifas")->insertGetId([
                "nome"=> $request->tarifa,
                "id_classe" => $request->id_classe 
            ]);
            return redirect()->back()->with("success","Tarifa adicionada");
        }catch(Exception $e)
        {
            return redirect()->back()->with("error","Ocorreu um erro. tente novamente");
        }
        
    }
}
