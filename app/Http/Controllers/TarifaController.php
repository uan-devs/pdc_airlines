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

    public function getRegalias($idTarifa)
    {
        $id = base64_decode($idTarifa);
        $tarifa = DB::table("tarifas")->where("id","=",$id)->first();
        // dd($tarifa);
        $todasregalias = DB::table("regalias")->get();

        $regalias = DB::table("regalias_tarifas")
                        ->join("regalias","regalias.id","=","regalias_tarifas.id_regalia")
                        ->join("tarifas","tarifas.id","=","regalias_tarifas.id_tarifa")
                        ->where("regalias_tarifas.id_tarifa","=",$id)
                        ->select("regalias.id","regalias.nome","tarifas.nome as tarifa")
                        ->get();
        return view("admin.pages.tarifas.regalias",[
            "regalias" => $regalias,
            "todasregalias" => $todasregalias,
            "id_tarifa" => $id,
            "tarifa" => $tarifa
        ]);
    }
}
