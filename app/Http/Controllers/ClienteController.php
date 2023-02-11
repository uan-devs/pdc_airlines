<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    //

    public function getNormals()
    {
        $membros = DB::table("membros")->select("id_cliente");
        $clientes = Cliente::whereNotIn("id",$membros)->select()->paginate(4);

        return view("admin.pages.clientes.index_normal",[
            "clientes" => $clientes
        ]);
    }

    public function getMembros()
    {
        $membros = DB::table("membros")
                    ->join("clientes","clientes.id","=","membros.id_cliente")
                    ->select("clientes.id","clientes.titulo","clientes.nome","clientes.sobrenome","clientes.email",
                    "clientes.telefone","clientes.data","membros.genero","membros.morada","membros.idioma","membros.milhas")
                    ->paginate(4    );
        return view("admin.pages.clientes.index_membros",[
            "membros" => $membros
        ]);
    }

}
