<?php

use App\Http\Controllers\VooController;
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
    
    
    Route::get('/admin/voos',[VooController::class, "index"])->name("voos");

});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
