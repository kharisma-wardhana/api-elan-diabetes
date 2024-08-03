<?php

use App\Http\Controllers\Api\ArtikelController;
use App\Http\Controllers\Api\Assesment\AktifitasController;
use App\Http\Controllers\Api\Assesment\AntropometriController;
use App\Http\Controllers\Api\Assesment\AsamUratController;
use App\Http\Controllers\Api\Assesment\AssesmentController;
use App\Http\Controllers\Api\Assesment\GinjalController;
use App\Http\Controllers\Api\Assesment\GulaDarahController;
use App\Http\Controllers\Api\Assesment\HbController;
use App\Http\Controllers\Api\Assesment\KolesterolController;
use App\Http\Controllers\Api\Assesment\KonsumsiAirController;
use App\Http\Controllers\Api\Assesment\TekananDarahController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NakesController;
use App\Http\Controllers\Api\NutrisiController;
use App\Http\Controllers\Api\ObatController;
use App\Http\Controllers\Api\VideoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResources([
        '/medicines' => ObatController::class,
        '/doctors' => NakesController::class,
        '/videos' => VideoController::class,
        '/articles' => ArtikelController::class,
        '/nutritions' => NutrisiController::class,
        // Assesment
        '/assesments' => AssesmentController::class,
        '/anthropometrics' => AntropometriController::class,
        '/activities' => AktifitasController::class,
        '/blood-sugars' => GulaDarahController::class,
        '/gouts' => AsamUratController::class,
        '/cholesterols' => KolesterolController::class,
        '/hbs' => HbController::class,
        '/blood-pressures' => TekananDarahController::class,
        '/waters' => KonsumsiAirController::class,
        '/kidneys' => GinjalController::class,
    ]);
});