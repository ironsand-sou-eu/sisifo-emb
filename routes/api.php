<?php

use App\Http\Controllers\CamposController;
use App\Http\Controllers\EseloComarcasController;
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
use App\Models\BizRules\EspaiderUf;
use Database\Seeders\EspaiderOrgaosSeeder;
use Database\Seeders\SistemasJudJuizosSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("campos", [CamposController::class, "index"]);
Route::get("eselo-comarcas", [EseloComarcasController::class, "index"]);
Route::get("eselo-juizos", [EseloJuizosController::class, "index"]);
Route::get("espaider-comarcas", [EspaiderComarcasController::class, "index"]);
Route::get("espaider-juizos", [EspaiderJuizosController::class, "index"]);
Route::get("espaider-orgaos", [EspaiderOrgaosController::class, "index"]);
Route::get("espaider-ufs", [EspaiderUfsController::class, "index"]);
Route::get("generos", [GenerosController::class, "index"]);
Route::get("log-alteracoes", [LogAlteracoesController::class, "index"]);
Route::get("permissoes", [PermissoesController::class, "index"]);
Route::get("sistemas-jud-juizos", [SistemasJudJuizosController::class, "index"]);
Route::get("tabelas", [TabelasController::class, "index"]);
Route::get("tipos-permissoes", [TiposPermissoesController::class, "index"]);
Route::get("users", [UsersController::class, "index"]);

Route::post("campos", [CamposController::class, "store"]);
Route::post("eselo-comarcas", [EseloComarcasController::class, "store"]);
Route::post("eselo-juizos", [EseloJuizosController::class, "store"]);
Route::post("espaider-comarcas", [EspaiderComarcasController::class, "store"]);
Route::post("espaider-juizos", [EspaiderJuizosController::class, "store"]);
Route::post("espaider-orgaos", [EspaiderOrgaosController::class, "store"]);
Route::post("espaider-ufs", [EspaiderUfsController::class, "store"]);
Route::post("generos", [GenerosController::class, "store"]);
Route::post("log-alteracoes", [LogAlteracoesController::class, "store"]);
Route::post("permissoes", [PermissoesController::class, "store"]);
Route::post("sistemas-jud-juizos", [SistemasJudJuizosController::class, "store"]);
Route::post("tabelas", [TabelasController::class, "store"]);
Route::post("tipos-permissoes", [TiposPermissoesController::class, "store"]);
Route::post("users", [UsersController::class, "store"]);