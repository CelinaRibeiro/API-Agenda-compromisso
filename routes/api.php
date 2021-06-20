<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompromissoController;
use App\Http\Controllers\AuthController;

use App\Models\Compromisso;
use App\Models\User;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/ping', function() {
    return ['pong' => true];
});

Route::get('/unauthenticated', function() {
    return ['error' => 'Usuário não está logado.'];
})->name('login');

Route::post('user', [AuthController::class, 'create'] );
Route::post('/auth/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->post('/auth/logout', [AuthController::class, 'logout']);

Route::middleware('auth:api')->get('/auth/me', [AuthController::class, 'me']);

Route::middleware('auth:api')->post('/compromisso', [CompromissoController::class, 'createCompromisso']);
Route::get('/compromissos', [CompromissoController::class, 'readAllCompromissos']);
Route::get('/compromisso/{id}', [CompromissoController::class, 'readCompromisso']);
Route::middleware('auth:api')->put('/compromisso/{id}', [CompromissoController::class, 'updateCompromisso']);
Route::middleware('auth:api')->delete('/compromisso/{id}', [CompromissoController::class, 'deleteCompromisso']);
