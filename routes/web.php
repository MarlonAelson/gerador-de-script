<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    ArquivoController
};

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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::redirect('/', '/login');

Auth::routes();

Route::get('/home', [ HomeController::class, 'index' ])->name('home');

Route::middleware(['auth'])->group(function(){
    Route::get('/gerar-script', [ ArquivoController::class, 'index' ])->name('index');
    Route::post('/gerar-script', [ ArquivoController::class, 'lerDiretorio' ])->name('ler-diretorio');
    Route::post('/gerar-scripts', [ ArquivoController::class, 'gerarScript' ])->name('gerar-script');
});
