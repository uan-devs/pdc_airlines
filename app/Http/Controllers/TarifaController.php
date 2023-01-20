<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TarifaController extends Controller
{
    //

    public function index()
    {
        $tarifas = DB::table("tarifas")
                    ->join("classes","classes.id","=","tarifas.id_classe")
                    ->select("tarifas.id","tarifas.nome as tarifa","classes.nome as classe")
                    ->get();
        return view("admin.pages.tarifas.index",[
            "tarifas" => $tarifas
        ]);
    }
}
