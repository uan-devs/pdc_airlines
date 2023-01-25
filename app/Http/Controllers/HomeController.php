<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
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
    public function searchFlights(Request $request,)
    {
        if(!$request->has(["tipo", "origem"])) return redirect()->route("ini");

        $tipo = $request->tipo ?? 'ida';
        $origem = $request->origem ?? '1';
        $destino = $request->destino ?? '3';
        $data_partida = $request->data_partida ?? "2023-01-31";
        $data_regresso = $request->data_regresso ?? "2023-04-01";
        $passageiros = $request->qtd;
        $voos = [];

        $voos = DB::table("voos")
            ->join("aeroportos AS ORIGEM", "ORIGEM.id", "=", "voos.id_aeroporto_origem")
            ->join("cidades as CIDADE_ORIGEM", "CIDADE_ORIGEM.id", "=", "ORIGEM.id_cidade")
            ->join("aeroportos AS DESTINO", "DESTINO.id", "=", "voos.id_aeroporto_destino")
            ->join("cidades as CIDADE_DESTINO", "CIDADE_DESTINO.id", "=", "DESTINO.id_cidade")
            ->where("ORIGEM.id", "=", $origem)
            ->where("DESTINO.id", "=", $destino)
            ->where("voos.data_partida", "=", $data_partida)
            ->where("voos.estado", "=", "1")
            ->select(
                "voos.id as id_voo",
                "voos.data_partida",
                "voos.hora as hora",
                "voos.duracao_estimada",
                "ORIGEM.id as id_origem",
                "ORIGEM.nome as aeroporto_origem",
                "CIDADE_ORIGEM.nome as cidade_origem",
                "DESTINO.id as id_destino",
                "DESTINO.nome as aeroporto_destino",
                "CIDADE_DESTINO.nome as cidade_destino"
            )
            ->selectRaw("DATE_ADD(concat(voos.data_partida,' ', voos.hora),INTERVAL voos.duracao_estimada HOUR) as chegada", [])
            ->get();

        $voo_array = $voos->toArray();
        array_walk($voo_array, function ($item) {
            return  $item->classes = $tarifas = DB::table("voo_tarifas")
                ->join("tarifas", "tarifas.id", "=", "voo_tarifas.id_tarifa")
                ->join("classes", "classes.id", "=", "tarifas.id_classe")
                ->where("voo_tarifas.id_voo", "=", $item->id_voo)
                ->select("classes.nome", "classes.id", "voo_tarifas.id_voo")
                ->distinct()
                ->get();
        });

        array_walk($voo_array, function ($item) {
            return  $item->tarifas = DB::table("voo_tarifas")
                ->join("tarifas", "tarifas.id", "=", "voo_tarifas.id_tarifa")
                ->join("classes", "classes.id", "=", "tarifas.id_classe")
                ->join("voo_lugares", "voo_lugares.id_voo_tarifa", "=", "voo_tarifas.id", "right")
                ->where("voo_tarifas.id_voo", "=", $item->id_voo)
                ->select(
                    "tarifas.id as tarifa_id",
                    "tarifas.nome as tarifa",
                    "voo_tarifas.preco",
                    "voo_tarifas.id as id_voo_tarifa",
                    "classes.nome as classe_nome",
                    "classes.id as classe_id"
                )
                ->selectRaw("count(voo_lugares.id) as lugares,voo_lugares.estado")
                ->groupBy(
                    "tarifas.id",
                    "tarifas.nome",
                    "voo_tarifas.preco",
                    "voo_tarifas.id",
                    "classes.nome",
                    "classes.id",
                    "voo_lugares.estado"
                )
                ->having("voo_lugares.estado", "=", "0")
                ->distinct()
                ->get();
        });


        return Inertia::render('FlySearchResult/index', [
            "voos" => $voo_array,
            "tipo" => $tipo
        ]);
    }

    public function index()
    {
        $cidades = DB::table("cidades")
            ->join("aeroportos", "cidades.id", "=", "aeroportos.id_cidade")
            ->select("cidades.nome as cidade", "cidades.id as id")
            ->get();

        return Inertia::render('index', [
            "cidades" => $cidades
        ]);
    }
}
