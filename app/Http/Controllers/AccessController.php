<?php

namespace App\Http\Controllers;

use App\Models\Papel;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AccessController extends Controller
{
    //

    public function getPapeis()
    {
        $papeis = DB::table("papeis")->get();
        return view("admin.pages.accesso.papeis",[
            "papeis" => $papeis
        ]);
    }

    public function getPermissoes()
    {
        $permissoes = DB::table("permissoes")->get();
        return view("admin.pages.accesso.permissoes",[
            "permissoes" => $permissoes
        ]);
    }

    public function setPapeis(Request $request)
    {
        if(!$request->nome)
        {
            return redirect()->back()->with("error","Preencha os campos obrigatórios");
        }

        $id = DB::table("papeis")->insertGetId([
            "papel" => $request->nome
        ]);

        if($id){
            return redirect()->back()->with("success","Papel Adicionado com sucesso!");
        }else{
            return redirect()->back()->with("error","Falha ao adicionar o papel");
        }
    }

    public function setPermissoes(Request $request)
    {
        if(!$request->permissao)
        {
            return redirect()->back()->with("error","Preencha os campos obrigatórios");
        }

        try{
            $id = DB::table("permissoes")->insertGetId([
                "nome" => $request->permissao
            ]);
    
            if($id){
                return redirect()->back()->with("success","Permissão Adicionada com sucesso!");
            }else{
                return redirect()->back()->with("error","Falha ao adicionar o permissão");
            }
        }catch(Exception $e)
        {
            return redirect()->back()->with("error","Falha ao adicionar o permissão");
        }
    }

    public function getPapelPermissoes($idPapel)
    {
        $id = base64_decode($idPapel);
        $papel = Papel::find($id);

        $permissoes = DB::table("papel_permissoes")
                        ->join("permissoes","permissoes.id","=","papel_permissoes.id_permissao")
                        ->where("id_papel","=",$id)
                        ->select("permissoes.nome","permissoes.id as id_permissao")
                        ->get();
        $ids = DB::table("papel_permissoes")
                        ->join("permissoes","permissoes.id","=","papel_permissoes.id_permissao")
                        ->where("id_papel","=",$id)
                        ->select("permissoes.id")
                        ->get();
        
        $values = array_values($ids->values()->toArray());
        $values2 = array_map(function($item){
            return $item->id;
        },$values);
        // dd($values2);
        $outrasPermissoes = DB::table("permissoes")
                        // ->join("papel_permissoes","permissoes.id","=","papel_permissoes.id_permissao")
                        // ->whereNot("id_papel","=",$id)
                        ->whereNotIn("permissoes.id",$values2)
                        ->select("permissoes.nome","permissoes.id as id_permissao")
                        ->get();
        
        if($permissoes){
            return view("admin.pages.accesso.papel_permissoes",[
                "permissoes" => $permissoes,
                "outrasPermissoes" => $outrasPermissoes,
                "papel" => $papel
            ]);
        }else{
            return redirect()->back()->with("error","Falha ao carregar permissões");
        }
    }

    public function atribuirPermissao(Request $request)
    {
        if( !($request->has(["id_papel","id_permissao"])))
        {
            return redirect()->back()->with("error","Falha ao atribuir permissão");
        }

       try{
            $id = DB::table("papel_permissoes")->insertGetId([
                "id_papel" => $request->id_papel,
                "id_permissao" => $request->id_permissao
            ]);
            return redirect()->back()->with("success","Permissão atribuída");
       }catch(Exception $e)
       {
            return redirect()->back()->with("error","Falha ao atribuir permissão");
       }
        
    }
    public function getUserPermissoes($idUser)
    {
        $id = base64_decode($idUser);
        $user = User::find($id);
        if(!$user)
        {
            return redirect()->back()->with("error","Falha ao carregar permissões");
        }

        $permissoes = DB::table("papel_users")
                        ->join("papeis","papeis.id","=","papel_users.id_papel")
                        ->join("papel_permissoes","papel_permissoes.id_papel","papeis.id")
                        ->join("permissoes","permissoes.id","=","papel_permissoes.id_permissao")
                        ->where("papel_users.id_user","=",$id)
                        ->select("papeis.papel","permissoes.nome as permissao","permissoes.id as id_permissao")
                        ->get();
        $ids = DB::table("papeis")
                        ->join("papel_users","papel_users.id_papel","=","papeis.id")
                        ->where("papel_users.id_user","=",$id)
                        ->select("papeis.id")
                        ->get();
        
        $values = array_values($ids->values()->toArray());
        $values2 = array_map(function($item){
            return $item->id;
        },$values);
        // dd($values2);
        $outrosPapeis = DB::table("papeis")
                        // ->join("papel_permissoes","permissoes.id","=","papel_permissoes.id_permissao")
                        // ->whereNot("id_papel","=",$id)
                        ->whereNotIn("papeis.id",$values2)
                        ->select("papeis.papel","papeis.id as id_papel")
                        ->get();
        
        if($permissoes){
            return view("admin.pages.accesso.user_permissoes",[
                "permissoes" => $permissoes,
                "outrosPapeis" => $outrosPapeis,
                "user" => $user
            ]);
        }else{
            return redirect()->back()->with("error","Falha ao carregar permissões");
        }


    }

    public function atribuirPapel(Request $request)
    {
        if( !($request->has(["id_papel","id_user"])))
        {
            return redirect()->back()->with("error","Falha ao atribuir papel");
        }

       try{
            $id = DB::table("papel_users")->insertGetId([
                "id_papel" => $request->id_papel,
                "id_user" => $request->id_user
            ]);
            return redirect()->back()->with("success","Papel atribuído");
       }catch(Exception $e)
       {
            return redirect()->back()->with("error","Falha ao atribuir papel");
       }
        
    }
}
