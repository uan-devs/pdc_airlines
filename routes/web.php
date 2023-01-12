<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use App\Http\Controllers\AviaoController;
use App\Http\Controllers\BilheteController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\VooController;
use App\Http\Controllers\AeroportoController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Home/index', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// ROTAS PARA A AREA ADMINISTRATIVA
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
    
    Route::get("/admin/avioes/create",[AviaoController::class,"create"])->name("avioes.create");
    Route::get("/admin/avioes/listagem",[AviaoController::class,"listagem"])->name("avioes.listagem");
    Route::post("/admin/avioes/add-fila",[AviaoController::class, "addFila"])->name("avioes.add_fila");
    Route::post("/admin/avioes/create",[AviaoController::class, "store"]);
    Route::get("/admin/avioes/{id}",[AviaoController::class,"show"])->name("avioes.show");
    //rotas de aeroporto
  
    Route::get('/admin/aeroporto/',[AeroportoController::class, "show"])->name("aeroporto.show");
    Route::get('/admin/aeroporto/create',[AeroportoController::class, "create"])->name("aeroporto.create");
    Route::post("/admin/aeroporto/create",[AeroportoController::class, "store"]);
    
    // ROTAS DE CLIENTES
    Route::get("admin/clientes/normais",[ClienteController::class,"getNormals"])->name("clientes_normais");
    Route::get("admin/clientes/membros",[ClienteController::class,"getMembros"])->name("clientes_membros");

    // ROTAS PARA COMPRAS E BILHETES
    Route::get("admin/bilhetes",[BilheteController::class,"getIda"])->name("bilhetes");
    Route::get("admin/bilhetes/ida-volta",[BilheteController::class,"getIdaVolta"])->name("bilhetes.volta");
}); 

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
