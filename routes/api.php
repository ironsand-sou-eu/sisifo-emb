<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CamposController;
use App\Http\Controllers\DajeController;
use App\Http\Controllers\EseloComarcasController;
use App\Http\Controllers\CustasConfigsController;
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
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', [AuthController::class, 'login'])->name('apiLogin');
// Route::post("/register", [AuthController::class, "register"]);

Route::middleware('jwt.verify')->group(function ($router) {
    // Route::post("/logout", [AuthController::class, "logout"]);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    Route::get('/info-eselo-via-espaider/{slug}', [EseloJuizosController::class, 'getEseloInfoFromEspaiderJuizoSlug']);

    Route::apiResources([
        'campos' => CamposController::class,
        'eselo-comarcas' => EseloComarcasController::class,
        'eselo-juizos' => EseloJuizosController::class,
        'custas-configs' => CustasConfigsController::class,
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
