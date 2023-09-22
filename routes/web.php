<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('/search', [IndexController::class, 'searchSchools'])->name('index.search');
Route::get('/chart', [IndexController::class, 'schoolMembersChartData'])->name('index.chart');
Route::get('/csv-download', [IndexController::class, 'downloadCsv'])->name('index.csv');

Route::resource('members', MemberController::class)->only([
    'create', 'store',
]);
