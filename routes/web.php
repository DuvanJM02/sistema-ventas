<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IngresoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VentaController;
use Barryvdh\DomPDF\PDF;

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

Route::get('/', function(){
    return view('auth/login');
});

Route::resource('almacen/articulo', ArticuloController::class);
Route::resource('almacen/categoria', CategoriaController::class);
Route::resource('ventas/cliente', ClienteController::class);
Route::resource('compras/ingreso', IngresoController::class);
Route::resource('compras/proveedor', ProveedorController::class);
Route::resource('seguridad/usuario', UsuarioController::class);
Route::resource('ventas/venta', VentaController::class);

// UI Busqueda autocompletada
Route::get('search/personas', [SearchController::class, 'personas'])->name('search.personas');
Route::get('search/articulos', [SearchController::class, 'articulos'])->name('search.articulos');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/{slug?}', [HomeController::class, 'index'])->name('home');

//Imprimir

// Route::get('ventas/venta', Ven);

Route::get('almacen/imprimir', [ArticuloController::class, 'imprimir'])->name('articulo.imprimir');

// Route::get('/almacen/imprimir', function(){
//     $pdf = App::make('dompdf.wrapper');
//     $pdf->loadHTML('<h1>Test</h1>');
//     return $pdf->stream();
// })->name('articulo.imprimir'); 