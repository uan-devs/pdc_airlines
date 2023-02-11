<?php

namespace App\Http\Controllers;

use App\Models\Aviao;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class AviaoController extends Controller
{
    //

    public function show($id)
    {
        $id = Crypt::decryptString($id);
        try{

        $aviao = Aviao::find($id);
        if(!$aviao){
            return redirect()
                        ->route("dashboard")
                            ->with("error","Ocorreu um erro inexperado. Tente novamente.");
        }
        $colunas = DB::table("filas")
                ->where("id_aviao","=",$id)
                ->select("id","identificador")
                ->get();

        $lugares = DB::table("lugares")
                ->where("id_aviao","=",$id)
                ->select("lugares.id","lugares.numero","lugares.id_fila","lugares.in_janela")
                ->get();

        return view("admin.pages.avioes.show",[
            "aviao" => $aviao,
            "lugares" => $lugares,
            "colunas" => $colunas,
            "definidos" => count($lugares)
        ]);
    } catch(Exception $e)
    {
        return redirect()
                        ->route("dashboard")
                            ->with("error","Ocorreu um erro inexperado. Tente novamente.");
    }
    }
    public function listagem()
    {
        $aviao = Aviao :: all();
       return view("admin.pages.avioes.listagem",[
            "aviao" => $aviao,
        ]);
    }
    
    public function create() 
    {
        return view("admin.pages.avioes.create",[
           
        ]);
    }
    
public function store(Request $request) {
    $aviao = new Aviao;
    
    $aviao->modelo = $request->modelo;
    $aviao->descricao = $request->descricao;
    $aviao->capacidade = $request->capacidade;

    $aviao->save();
    return redirect("/admin/avioes/create");
}
    public function addFila(Request $request)
    {
        if(!$request->identificador || !$request->qtd || !$request->id_aviao)
        {
            return redirect()->back()->with("error","Prencha os campos obrigatórios.");
        }

        $qtd = intval($request->qtd);
        $identificador = $request->identificador;
        $aviao = $request->id_aviao;
        try{
            DB::beginTransaction();

            $id_fila = DB::table("filas")->insertGetId([
                "identificador" => $request->identificador,
                "id_aviao" => $aviao
            ]);

            for($i = 1; $i <= $qtd; $i++)
            {
                DB::table("lugares")->insert([
                    "numero" => $identificador.$i,
                    "in_janela" => 0,
                    "id_aviao"  => $aviao,
                    "id_fila" => $id_fila,
                    "estado"    => 1
                ]);
            }
            // se foram definidos todos os lugares de acordo a capacidade, coloca o aviao em funcionamento
            if($this->lugaresCompletados($aviao))$this->activarAviao($aviao);

            DB::commit();
            return redirect()->back()->with("success","Fileira adicionada com sucesso.");
        }catch(Exception $e)
        {
            DB::rollBack();
            return redirect()->back()->with("error","Ocorreu um erro inexperado. Tente novamente.");
        }
    }

    public function lugaresCompletados($id_aviao)
    {
        $aviao = Aviao::find($id_aviao);
        $lugares = DB::table("lugares")
                ->where("id_aviao","=",$id_aviao)
                ->select("lugares.id")
                ->get()->count();
                
        return ($aviao->capacidade == $lugares);
    }

    public function activarAviao($id_aviao)
    {

        $aviao = Aviao::find($id_aviao);
        $aviao->estado = 1;
        $aviao->save();
        return true;
    }
}
