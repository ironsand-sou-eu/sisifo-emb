<?php

use App\Http\Controllers\AuthController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post("/login", [AuthController::class, "login"]);
// Route::post("/register", [AuthController::class, "register"]);

Route::group([
    'middleware' => ['jwt.verify'],
    // 'prefix' => 'auth'
    ], function ($router) {
        // Route::post("/logout", [AuthController::class, "logout"]);
        Route::post("/refresh", [AuthController::class, "refresh"]);
        Route::get("/user-profile", [AuthController::class, "userProfile"]);

        Route::get("campos/{id}", [CamposController::class, "show"]);
        Route::get("eselo-comarcas/{id}", [EseloComarcasController::class, "show"]);
        Route::get("eselo-juizos/{id}", [EseloJuizosController::class, "show"]);
        Route::get("espaider-comarcas/{id}", [EspaiderComarcasController::class, "show"]);
        Route::get("espaider-juizos/{id}", [EspaiderJuizosController::class, "show"]);
        Route::get("espaider-orgaos/{id}", [EspaiderOrgaosController::class, "show"]);
        Route::get("espaider-ufs/{id}", [EspaiderUfsController::class, "show"]);
        Route::get("generos/{id}", [GenerosController::class, "show"]);
        Route::get("log-alteracoes/{id}", [LogAlteracoesController::class, "show"]);
        Route::get("permissoes/{id}", [PermissoesController::class, "show"]);
        Route::get("sistemas-jud-juizos/{id}", [SistemasJudJuizosController::class, "show"]);
        Route::get("tabelas/{id}", [TabelasController::class, "show"]);
        Route::get("tipos-permissoes/{id}", [TiposPermissoesController::class, "show"]);
        Route::get("users/{id}", [UsersController::class, "show"]);
        
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
        
        Route::put("campos/{id}", [CamposController::class, "update"]);
        Route::put("eselo-comarcas/{id}", [EseloComarcasController::class, "update"]);
        Route::put("eselo-juizos/{id}", [EseloJuizosController::class, "update"]);
        Route::put("espaider-comarcas/{id}", [EspaiderComarcasController::class, "update"]);
        Route::put("espaider-juizos/{id}", [EspaiderJuizosController::class, "update"]);
        Route::put("espaider-orgaos/{id}", [EspaiderOrgaosController::class, "update"]);
        Route::put("espaider-ufs/{id}", [EspaiderUfsController::class, "update"]);
        Route::put("generos/{id}", [GenerosController::class, "update"]);
        Route::put("log-alteracoes/{id}", [LogAlteracoesController::class, "update"]);
        Route::put("permissoes/{id}", [PermissoesController::class, "update"]);
        Route::put("sistemas-jud-juizos/{id}", [SistemasJudJuizosController::class, "update"]);
        Route::put("tabelas/{id}", [TabelasController::class, "update"]);
        Route::put("tipos-permissoes/{id}", [TiposPermissoesController::class, "update"]);
        Route::put("users/{id}", [UsersController::class, "update"]);
        
        Route::delete("campos/{id}", [CamposController::class, "destroy"]);
        Route::delete("eselo-comarcas/{id}", [EseloComarcasController::class, "destroy"]);
        Route::delete("eselo-juizos/{id}", [EseloJuizosController::class, "destroy"]);
        Route::delete("espaider-comarcas/{id}", [EspaiderComarcasController::class, "destroy"]);
        Route::delete("espaider-juizos/{id}", [EspaiderJuizosController::class, "destroy"]);
        Route::delete("espaider-orgaos/{id}", [EspaiderOrgaosController::class, "destroy"]);
        Route::delete("espaider-ufs/{id}", [EspaiderUfsController::class, "destroy"]);
        Route::delete("generos/{id}", [GenerosController::class, "destroy"]);
        Route::delete("log-alteracoes/{id}", [LogAlteracoesController::class, "destroy"]);
        Route::delete("permissoes/{id}", [PermissoesController::class, "destroy"]);
        Route::delete("sistemas-jud-juizos/{id}", [SistemasJudJuizosController::class, "destroy"]);
        Route::delete("tabelas/{id}", [TabelasController::class, "destroy"]);
        Route::delete("tipos-permissoes/{id}", [TiposPermissoesController::class, "destroy"]);
        Route::delete("users/{id}", [UsersController::class, "destroy"]);
    }
);
