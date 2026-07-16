<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ClienteController;

// Una sola línea crea las 5 rutas del CRUD
Route::apiResource('clientes', ClienteController::class);

// Hola mundo de la API
Route::get('/hola', function () {
    return response()->json([
        'mensaje' => 'Hola desde la API',
        'version' => '1.0',
        'timestamp' => now()->toISOString(),
    ]);
});

// Ruta con parámetro
Route::get('/saludo/{nombre}', function (string $nombre) {
    return response()->json([
        'mensaje' => "Hola, $nombre! Bienvenido a la API",
    ]);
});