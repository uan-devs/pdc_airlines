<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Exception;

class BookingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(Request $request)
    {
        $id = $request->route('id');
        $preco = DB::table("voo_tarifas")
                    ->where("id","=",$id)
                    ->select("preco")
                    ->first();
        return Inertia::render('Booking/index', [
            'token' => csrf_token(),
            'id' => $id,
            'preco' => $preco
        ]);
    }

    public function guardarDados(Request $request)
    {
        
        // $nome = "nome1";
        // dd($request->$nome);
        try{
            DB::beginTransaction();
        if (!$request->has(["qtd", "tipo"])) return redirect()->route("book");
        $idCompra = DB::table("compras")->insertGetId([
            "valor_total" => 1000,
            "pago"        => 0,
            "referencia_pagamento" => "REF32",
            "estado"      => 1,
            "data" => date("Y-m-d")
        ]);
        
        for ($i = 1; $i <= $request->qtd; $i++) {
            $nome = "nome" . $i;
            $titulo = "titulo" . $i;
            $sobrenome = "sobrenome" . $i;
            $email = "email" . $i;
            $telefone = "telefone" . $i;
            $data = "data" . $i;
            // dd($request->titulo);
            $idCliente = DB::table("clientes")->insertGetId([
                "titulo" => $request->$titulo,
                "nome"   => $request->$nome,
                "sobrenome" => $request->$sobrenome,
                "email" => $request->$email,
                "telefone" => $request->$telefone,
                "data" => $request->$data,
                "estado" => 1
            ]);
            $idBilhete = DB::table("bilhetes")->insertGetId([
                "id_compra" => $idCompra,
                "id_cliente" => $idCliente,
                "tipo"      => $request->tipo,
                "estado"    => 1
            ]);
            $idPlace = $this->getRandomPlaces($request->id_voo_tarifa);
            $idLugar = DB::table("bilhete_lugares")->insertGetId([
                "id_bilhete" => $idBilhete,
                "id_voo_lugar" => $idPlace->id_lugar,
                "tipo"      => "ida",
                "estado"    => 1
            ]);
            DB::table('voo_lugares')
                ->where('id', $idPlace->id_lugar)
                ->update(['estado' => 1]);
        }

        DB::commit();
        return true;
        }catch(Exception $e)
        {
            DB::rollBack();
            return false;
        }
    }
        
    public function getRandomPlaces($id_voo_tarifa)
    {
        $lugar = DB::table("voo_lugares")
            ->where("voo_lugares.id_voo_tarifa", "=", $id_voo_tarifa)
            ->where("voo_lugares.estado", "=", "0")
            ->select("voo_lugares.id as id_lugar")
            ->inRandomOrder()
            ->first();
        return $lugar;
    }
}
