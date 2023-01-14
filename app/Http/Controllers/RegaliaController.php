<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Models\Regalia;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;


class RegaliaController extends Controller
{
    public function create() 
    {
        return view("admin.pages.regalias.create",[
        ]);
    }
public function store(Request $request) {
    $regalia = new Regalia;
    $regalia->nome = $request->nome;
    $regalia->save();
    
    return redirect("/admin/regalia/create");
}
    
}
