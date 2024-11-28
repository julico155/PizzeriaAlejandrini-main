<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarritoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/urlcallback', [CarritoController::class, 'urlCallback']);
Route::get('/test', function () {
    return response()->json([
        'success' => true,
        'message' => 'La API está funcionando correctamente'
    ]);
});
Route::post('/consultartransaccion', [CarritoController::class, 'ConsultarEstado']);