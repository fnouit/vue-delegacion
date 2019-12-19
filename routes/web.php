<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware'=>['guest']],function(){
    Route::get('/','Auth\LoginController@showLoginForm')->name('form.login');
    Route::post('/login','Auth\LoginController@login')->name('login');
    Route::get('/register','Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('/register','Auth\RegisterController@register');
});

/* Route::group(['middleware'=>['auth']],function(){
    
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('/main', function () {
        return view('content/content');
    })->name('main');
    Route::get('/categoria', 'CategoriaController@index');
    Route::post('/categoria/registrar', 'CategoriaController@store');
    Route::put('/categoria/actualizar', 'CategoriaController@update');
    Route::put('/categoria/desactivar', 'CategoriaController@desactivar');
    Route::put('/categoria/activar', 'CategoriaController@activar');
    Route::get('/editorial', 'EditorialController@index');
    Route::post('/editorial/registrar', 'EditorialController@store');
    Route::put('/editorial/actualizar', 'EditorialController@update');
    Route::put('/editorial/desactivar', 'EditorialController@desactivar');
    Route::put('/editorial/activar', 'EditorialController@activar');
    
}); */

Route::group(['middleware'=>['auth']],function(){
    
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('/main', function () {
        return view('content/content');
    })->name('main');
    Route::get('/regiones', 'RegionController@index');
    Route::post('/regiones/registrar', 'RegionController@store');
    Route::put('/regiones/actualizar', 'RegionController@update');
    Route::put('/regiones/desactivar', 'RegionController@desactivar');
    Route::put('/regiones/activar', 'RegionController@activar');
    Route::get('/editorial', 'EditorialController@index');
    Route::post('/editorial/registrar', 'EditorialController@store');
    Route::put('/editorial/actualizar', 'EditorialController@update');
    Route::put('/editorial/desactivar', 'EditorialController@desactivar');
    Route::put('/editorial/activar', 'EditorialController@activar');
    
});