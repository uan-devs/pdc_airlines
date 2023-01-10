<?php

use App\Http\Controllers\AviaoController;
use App\Http\Controllers\VooController;
use App\Http\Controllers\AeroportoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// PORTAL ROUTES 

Route::get('/', function () {
    return view('welcome');
});




// ADMIN ROUTES

Route::middleware(['auth'])->group(function(){


    Route::get('/admin/dashboard',function(){
        return view("admin.pages.dashboard");
    })->name("dashboard");
    
    
    // ROTAS DE VOOS
    Route::get('/admin/voos',[VooController::class, "index"])->name("voos");
    Route::get("/admin/voos/create",[VooController::class, "create"])->name("voos.create");
    Route::post("/admin/voos/store/",[VooController::class, "store"])->name("voos.store");
    Route::get('/admin/voos/{id}',[VooController::class, "show"])->name('voos.show');
    Route::post("/admin/voos/tarifas",[VooController::class, "addTarifa"])->name("voos.addTarifa");
    Route::get('/admin/voos/{id}/activate',[VooController::class, "activate"])->name('voos.activate');
    Route::get('/admin/voos/{id}/lugares',[VooController::class, "getLugares"])->name('voos.lugares');

    // ROTAS DE AVIOES
    Route::get("admin/avioes/{id}",[AviaoController::class,"show"])->name("avioes.show");
    Route::post("/admin/avioes/add-fila",[AviaoController::class, "addFila"])->name("avioes.add_fila");
    
    //rotas de aeroporto
  
    Route::get('/admin/aeroporto/{id}',[AeroportoController::class, "show"])->name("show");
    Route::get("/admin/aeroporto/create",[AeroportoController::class, "create"])->name("aeroporto.create");
}); 


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
