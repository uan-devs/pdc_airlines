<?php

namespace App\Http\Controllers;

use App\Models\Aviao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AviaoController extends Controller
{
    //

    public function show($id)
    {
        $aviao = Aviao::find($id);
        if(!$aviao){
            return redirect()->
                            route("dashboard")
                            ->with("error","Ocorreu um erro inexperado. Tente novamente.");
        }
        $colunas = DB::table("colunas")
                ->where("id_aviao","=",$id)
                ->select("id","identificador")
                ->get();

        $lugares = DB::table("lugares")
                ->where("id_aviao","=",$id)
                ->select("lugares.id","lugares.numero","lugares.id_coluna","lugares.in_janela")
                ->get();

        return view("admin.pages.avioes.show",[
            "aviao" => $aviao,
            "lugares" => $lugares,
            "colunas" => $colunas
        ]);

    }
}
