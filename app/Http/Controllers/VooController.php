<?php

namespace App\Http\Controllers;

use App\Models\Voo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VooController extends Controller
{
    //

    public function index()
    {
        $voos = DB::table("flights")
                ->join("airports AS ORIGIN","ORIGIN.id","=","flights.airport_origin")
                ->join("cities as ORIGIN_CITY","ORIGIN_CITY.id","=","ORIGIN.id_city")
                ->join("airports AS DESTINY","DESTINY.id","=","flights.airport_destiny")
                ->join("cities as DESTINY_CITY","DESTINY_CITY.id","=","DESTINY.id_city")
                ->select("flights.id as id_flight","flights.date_","flights.time_","flights.state",
                "ORIGIN.id as id_origin","ORIGIN.name as origin_airport","ORIGIN_CITY.name as origin_city",
                "DESTINY.id as id_destiny","DESTINY.name as destiny_airport","DESTINY_CITY.name as destiny_city")
                ->get();
        // dd($voos);
        return view("admin.pages.voos.index",[
            "voos" => $voos
        ]);
    }
}
