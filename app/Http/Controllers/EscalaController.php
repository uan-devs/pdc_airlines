<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Escala;
use Exception;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;

use function PHPUnit\Framework\isEmpty;

class EscalaController extends Controller
{
    public function show()
    {
        $escala = Escala:: all();
        $aeroporto = DB::table("aeroportos")
        ->select("aeroportos.id as id","aeroportos.nome as nome","aeroportos.id_cidade as id_cidade")
        ->get();
        $cidade = DB::table("cidades")
        ->select("cidades.id as id","cidades.nome as nome")
        ->get();
 
        $voo = DB::table("voos")
        ->select("voos.id as id"/*,"voo.nome as nome"*/)
        ->get();
 ; 
               
       return view("admin.pages.escalas.show",[
            "escala" => $escala,
            "aeroporto" => $aeroporto,
            "voo" => $voo,
           "cidade" => $cidade
        ]);
    }
         
    public function create() 
    {
       $aeroporto = DB::table("aeroportos")
       ->select("aeroportos.id as id","aeroportos.nome as nome","aeroportos.id_cidade as id_cidade")
       ->get();

       $voo = DB::table("voos")
       ->select("voos.id as id")
       ->get();

        return view("admin.pages.escalas.create",[
            "aeroporto" => $aeroporto,
            "voo" => $voo,
        
        ]);
    }
public function store(Request $request) {
    $escala = new Escala;
    $escala->id_aeroporto = $request->aeroporto;
    $escala->id_voo = $request->voo;

    $escala->save();
    return redirect("/admin/escala/create");
}
}
