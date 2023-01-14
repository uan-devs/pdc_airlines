<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Tarifas_regalia;

use Exception;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;




class Tarifa_regaliasController extends Controller
{
    
        public function create() 
        {
            $tarifas = DB::table("tarifas")
            ->select("tarifas.id as id","tarifas.nome as nome")
            ->get();
            $regalias = DB::table("regalias")
            ->select("regalias.id as id","regalias.nome as nome")
            ->get();
            return view("admin.pages.regalias.juntar",[
                "tarifa" => $tarifas,
                "regalia" => $regalias
            ]);
        }


    public function store(Request $request) {
        $regalia = new Tarifas_regalia;
        $regalia->id_tarifa = $request->tarifa;
        $regalia->id_regalia = $request->regalia;
        $regalia->save();
        
        return redirect("/admin/regalia/juntar");
    }

    public function show()
    {
        /*$tarifas = DB::table("tarifas")
        ->select("tarifas.id as id","tarifas.nome as nome")
        ->get();
        
        $regalias = DB::table("regalias")
        ->select("regalias.id as id","regalias.nome as nome")
        ->get();*/
        
        $regaliast = DB::table("tarifas_regalias")
        ->join("tarifas","tarifas.id","=","id_tarifa")
        ->join("regalias","regalias.id","=","id_regalia")
        ->select("tarifas.nome as tarifa","regalias.nome as regalia")
        ->get();  
        
       return view("admin.pages.regalias.show",[
         "regaliast" =>$regaliast   
        ]);
    }
}
