<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClasseController extends Controller
{

    public function create(Request $request)
    {
        if(!$request->classe)
        {
            return redirect()->back()->with("error","Preencha os campos obrigatórios");
        }

        try{
            $classe = DB::table("classes")->insertGetId([
                "nome"=>$request->classe
            ]);
            return redirect()->back()->with("success","Classe adicionada");
        }catch(Exception $e)
        {
            return redirect()->back()->with("error","Ocorreu um erro. tente novamente");
        }
        
    }
    //
}
