<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Aeroporto;
use Exception;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;

use function PHPUnit\Framework\isEmpty;


class AeroportoController extends Controller
{
    public function show()
    {
        $aeroporto = Aeroporto :: all();  //DB::table("aeroportos")
               // ->join("aeroportos.id_cidade","cidade.id")
               // ->where("aeroportos.id","=",$id)
               // ->select("aeroportos.id as id_aeroporto","aeroportos.nome as nome")
               // ->first();
               $cidade = DB::table("cidades")
                        ->select("cidades.id as id","cidades.nome as nome")
                        ->get();


        //$values = array_values($id->values()->toArray());
    
       return view("admin.pages.aeroportos.show",[
            "aeroporto" => $aeroporto,
            "cidade" => $cidade,
        ]);
    }
         
    public function create() 
    {
        $cidade = DB::table("cidades")
                        ->select("cidades.id as id","cidades.nome as nome")
                        ->get();

        return view("admin.pages.aeroportos.create",[
           "cidade" => $cidade
        ]);
    }
public function store(Request $request) {
    $aeroporto = new Aeroporto;
    $aeroporto->nome = $request->nome;
    $aeroporto->id_cidade = $request->cidade;

    $aeroporto->save();
    return redirect("/admin/aeroporto/create");
}
    
}
