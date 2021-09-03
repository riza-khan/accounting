<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CarsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\QuickBooksAPIController;
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

Route::middleware('auth:sanctum')->group(function () {

    // Cars
    Route::get('/cars', [CarsController::class, 'index']);
    Route::post('/cars-import', [ImportController::class, 'cars']);

    // Invoices
    Route::get('/invoices', [CarsController::class, 'index']);
    Route::post('/invoice-import', [ImportController::class, 'invoices']);

    // Companies
    Route::prefix('/companies')->group(function () {
        Route::get('', [CompaniesController::class, 'index']);
    });

    // Categories
    Route::prefix('/categories')->group(function () {
        Route::get('', [CategoriesController::class, 'index']);
        Route::post('{category}', [QuickBooksAPIController::class, 'getAllByCategory']);
    });

    Route::prefix('/quickbooks')->group(function () {
        Route::get('/connect', [QuickBooksAPIController::class, 'index']);
        Route::post('/connect', [QuickBooksAPIController::class, 'getAuthorizationTokens']);
        Route::get('/company', [QuickBooksAPIController::class, 'getInfo']);
        Route::get('/batch-invoices', [QuickBooksAPIController::class, 'batchInvoices']);
    });
});
