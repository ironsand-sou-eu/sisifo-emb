<?php

use App\Http\Controllers\CamposController;
use App\Http\Controllers\DajeController;
use App\Http\Controllers\EseloComarcasController;
use App\Http\Controllers\EseloConfigsController;
use App\Http\Controllers\EseloJuizosController;
use App\Http\Controllers\EspaiderComarcasController;
use App\Http\Controllers\EspaiderJuizosController;
use App\Http\Controllers\EspaiderOrgaosController;
use App\Http\Controllers\EspaiderUfsController;
use App\Http\Controllers\GenerosController;
use App\Http\Controllers\LogAlteracoesController;
use App\Http\Controllers\PermissoesController;
use App\Http\Controllers\SistemasJudJuizosController;
use App\Http\Controllers\TabelasController;
use App\Http\Controllers\TiposPermissoesController;
use App\Http\Controllers\UsersController;
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

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::group([
    'middleware' => ['auth.frontend'],
], function ($router) {
        Route::get('/', function () {
            return view('dashboard');
        })->name('dashboard');

        Route::resources([
            'campos' => CamposController::class,
            'eselo-comarcas' => EseloComarcasController::class,
            'eselo-juizos' => EseloJuizosController::class,
            'eselo-configs' => EseloConfigsController::class,
            'espaider-comarcas' => EspaiderComarcasController::class,
            'espaider-juizos' => EspaiderJuizosController::class,
            'espaider-orgaos' => EspaiderOrgaosController::class,
            'espaider-ufs' => EspaiderUfsController::class,
            'generos' => GenerosController::class,
            'log-alteracoes' => LogAlteracoesController::class,
            'permissoes' => PermissoesController::class,
            'sistemas-jud-juizos' => SistemasJudJuizosController::class,
            'tabelas' => TabelasController::class,
            'tipos-permissoes' => TiposPermissoesController::class,
            'users' => UsersController::class,
            'dajes' => DajeController::class,
        ]);
    }
);
