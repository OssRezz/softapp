<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ClienteSeriviciosController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ServicioController;
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

Route::get('/', [IndexController::class, 'index'])->name('index');

Route::get('login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('login/singin', [LoginController::class, 'login'])->name('login/singin');
Route::post('login/logout', [LoginController::class, 'logout'])->name('login/logout');

Route::get('clientes', [ClienteController::class, 'index'])->name('clientes')->middleware('auth');
Route::post('clientes/store', [ClienteController::class, 'store'])->name('clientes/store');
Route::post('clientes/show', [ClienteController::class, 'show'])->name('clientes/show');
Route::post('clientes/detalle', [ClienteController::class, 'datalleCliente'])->name('clientes/detalle');
Route::post('clientes/edit', [ClienteController::class, 'edit'])->name('clientes/edit');
Route::post('clientes/update', [ClienteController::class, 'update'])->name('clientes/update');
Route::post('clientes/modalDestroy', [ClienteController::class, 'modalDestroy'])->name('clientes/modalDestroy');
Route::post('clientes/destroy', [ClienteController::class, 'destroy'])->name('clientes/destroy');

Route::get('servicios', [ServicioController::class, 'index'])->name('servicios')->middleware('auth');
Route::post('servicios/store', [ServicioController::class, 'store'])->name('servicios/store');
Route::post('servicios/create', [ServicioController::class, 'create'])->name('servicios/create');


Route::post('clienteservicios/create', [ClienteSeriviciosController::class, 'create'])->name('clienteservicios/create');
Route::post('clienteservicios/store', [ClienteSeriviciosController::class, 'store'])->name('clienteservicios/store');
