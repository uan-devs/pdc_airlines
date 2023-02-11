<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use App\Http\Controllers\AviaoController;
use App\Http\Controllers\BilheteController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\TarifaController;
use App\Http\Controllers\VooController;
use App\Http\Controllers\AeroportoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccessController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\MembroController;
use App\Http\Controllers\RegaliaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PortalController;
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
    return Inertia::render('index');
})->name('portal');



// ROTAS PARA O MEMBRO PDC
Route::get('/membro/login',[MembroController::class, "login"])->name("membro.entrar")->middleware(['require-membro-logout']);
Route::post('/membro/login',[MembroController::class, "setLogin"])->name("membro.login")->middleware(['require-membro-logout']);
Route::get('/membro/registo',[MembroController::class, "registo"])->name("membro.registo")->middleware(['require-membro-logout']);
Route::middleware(['require-membro-login'])->group(function(){

    Route::get('/membro/dashboard',[MembroController::class, "dashboard"])->name("membro.dashboard");
    Route::get("/membro/{id}/perfil",[MembroController::class, "perfil"])->name("membro.perfil");
    Route::get("/membro/{id}/compras",[MembroController::class, "compras"])->name("membro.compras");
    Route::get('/membro/logout',[MembroController::class, "logout"])->name("membro.logout");
    
    Route::get('/membro/home',[MembroController::class, "index"])->name("portal.home");
    Route::post('/membro/search',[MembroController::class, "searchFLights"])->name("portal.voos");
    Route::get("/membro/compra",[MembroController::class,"compra"])->name("portal.compra");
    Route::get("/membro/passageiros",[MembroController::class,"setPassageiros"])->name("portal.passageiros");
    Route::post("/membro/compra/efectuar",[MembroController::class,"efectuarCompra"])->name("portal.efectuar");
    Route::get("/membro/compras/result",[MembroController::class,"getResult"])->name("compra.result");
    
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
    Route::get('/admin/voos/{id}/edit',[VooController::class, "edit"])->name('voos.edit');
    Route::post('/admin/voos/update',[VooController::class, "update"])->name('voos.update');
    Route::post("/admin/voos/tarifas",[VooController::class, "addTarifa"])->name("voos.addTarifa");
    Route::get('/admin/voos/{id}/activate',[VooController::class, "activate"])->name('voos.activate');
    Route::get('/admin/voos/{id}/lugares',[VooController::class, "getLugares"])->name('voos.lugares');
    Route::get('/admin/voos/{id}/cancelar',[VooController::class, "cancelar"])->name('voos.cancel');
    Route::get('/teste/{id}',[VooController::class, "EnviarMensagem"]);

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
    Route::get("admin/bilhetes/{id}/notify",[BilheteController::class,"notificar"])->name("notificar");

    // ROTAS TARIFAS E CLASSES
    Route::get("admin/tarifas",[TarifaController::class,"index"])->name("tarifas");
    Route::post("admin/tarifas",[TarifaController::class,"create"])->name("tarifas.create");
    Route::post("admin/classes",[ClasseController::class,"create"])->name("classes.create");
    Route::get("admin/tarifas/{id}/regalias",[TarifaController::class,"getRegalias"])->name("tarifas.regalias");

     // ROTAS REGALIAS
     Route::get("admin/regalias",[RegaliaController::class,"index"])->name("regalias");
     Route::post("admin/regalias",[RegaliaController::class,"create"])->name("regalias.create");
     Route::post("admin/tarifas/add-regalia",[RegaliaController::class,"atribuir"])->name("regalias.atribuir");


    /**Access control routes */
    Route::get("/admin/papeis",[AccessController::class, "getPapeis"])->name("papeis");
    Route::get("/admin/papeis/{id}/permissoes",[AccessController::class, "getPapelPermissoes"])->name("papeis.permissoes");
    Route::post("/admin/papeis/store",[AccessController::class, "setPapeis"])->name("papeis.store");
    Route::get("/admin/permissoes",[AccessController::class, "getPermissoes"])->name("permissoes");
    Route::post("/admin/permissoes",[AccessController::class, "setPermissoes"])->name("permissoes.store");
    Route::post("/admin/papeis/new-permissao",[AccessController::class, "atribuirPermissao"])->name("permissoes.atribuir");
    Route::get("/admin/users/{id}/permissoes",[AccessController::class, "getUserPermissoes"])->name("users.permissoes");
    Route::post("/admin/users/new-papel",[AccessController::class, "atribuirPapel"])->name("papeis.atribuir");

    /**Users Routes */
       Route::get('/admin/users', [UserController::class, "index"])->name('users');
       Route::get('/admin/users/create', [UserController::class, "create"])->name('users-create');
       Route::post('/admin/users/store', [UserController::class, "store"])->name('users-store');
   
    
}); 


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
