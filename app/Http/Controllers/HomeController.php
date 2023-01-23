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
    public function index()
    {
        $cidades = DB::table("cidades")
                ->join("aeroportos", "cidades.id", "=", "aeroportos.id_cidade")
                ->select("cidades.nome as cidade")
                ->get();

        return Inertia::render('index', [
            "cidades" => $cidades
        ]);
    }
}
