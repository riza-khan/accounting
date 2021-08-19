<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    if (!Auth::guest()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
});

Route::get('/dashboard/{any?}', [DashboardController::class, 'index'])->where('any', '.*')->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
