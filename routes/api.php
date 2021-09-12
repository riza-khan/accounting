<?php

use App\Http\Controllers\CarsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\QuickBooksAPIController;
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

Route::middleware('auth:sanctum')->group(function () {

    // Quickbooks
    Route::prefix('/quickbooks')->group(function () {
        Route::get('/connect', [ConnectionController::class, 'index']);
        Route::post('/connect', [ConnectionController::class, 'getAuthorizationTokens'])->middleware('auth');
        Route::get('/company', [QuickBooksAPIController::class, 'getInfo']);
        Route::post('/batch-delete/{category}', [QuickBooksAPIController::class, 'batchDelete']);
    });

    // Companies
    Route::prefix('/companies')->group(function () {
        Route::get('', [CompaniesController::class, 'index']);
    });

    // Categories
    Route::prefix('/categories')->group(function () {
        Route::get('', [CategoriesController::class, 'index']);
        Route::post('{category}', [QuickBooksAPIController::class, 'getAllByCategory']);
    });

    // Quickbooks entities:
    // Invoices
    Route::prefix('/invoice')->group(function () {
        Route::get('', [CarsController::class, 'index']);
        Route::post('import', [ImportController::class, 'invoices']);
    });

    // Bills
    Route::prefix('/bill')->group(function () {
        Route::post('import', [ImportController::class, 'invoices']);
    });
});
