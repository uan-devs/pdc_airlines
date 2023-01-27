<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function index()
    {
        $users = DB::table("users")
            ->select("users.name","users.id","users.email")
            ->distinct()->get();

        // dd($users);
        return view("admin.pages.usuarios.index",[
            "users" => $users
        ]);
    }


    public function create()
    {
        return view("admin.pages.usuarios.create");
    }
    
    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->nome;
        $user->email = $request->email;
        $user->password = Hash::make("1234");

        try{
            $user->save();
            return redirect()->back()->with("sucess","Utilizador Cadastrado");
        }catch(\Exception $e)
        {
            return redirect()->back()->with("error",$e->getMessage());
        }
    }
}
