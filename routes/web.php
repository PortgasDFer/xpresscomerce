<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/*RUTAS DE ADMINISTRACIÓN*/
Route::resource('/categories','CategoriasController');
Route::get('/obtenerCategorias','CategoriasController@datatable')->name('categorias.datatable');
Route::resource('/marca', 'MarcasController');
Route::get('/obtenerMarcas','MarcasController@datatable')->name('marcas.datatable');
Route::resource('/products','ProductosController');
Route::get('/obtenerProductos','ProductosController@datatable')->name('productos.datatable');
/**/