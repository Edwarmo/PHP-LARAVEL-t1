<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
|
*/

// Home
Route::get('/', function () {
    return view('welcome-custom');
})->name('home');

// Students Routes
Route::prefix('students')->name('students.')->group(function () {
    Route::get('/', [StudentController::class, 'index'])->name('index');
    Route::get('/create', [StudentController::class, 'create'])->name('create');
    Route::post('/store', [StudentController::class, 'store'])->name('store');
    Route::get('/export-pdf', [StudentController::class, 'exportPdf'])->name('export-pdf');
});

// Shippings Routes
Route::prefix('shippings')->name('shippings.')->group(function () {
    Route::get('/', [ShippingController::class, 'index'])->name('index');
    Route::get('/create', [ShippingController::class, 'create'])->name('create');
    Route::post('/store', [ShippingController::class, 'store'])->name('store');
});

// Finance Routes
Route::prefix('finance')->name('finance.')->group(function () {
    Route::get('/', [FinanceController::class, 'index'])->name('index');
    Route::get('/contributions', [FinanceController::class, 'withContributions'])->name('contributions');
});

// Payroll Routes
Route::prefix('payroll')->name('payroll.')->group(function () {
    Route::get('/', [PayrollController::class, 'index'])->name('index');
});

// Profile Routes
Route::prefix('profile')->name('profile.')->group(function () {
    Route::get('/create', [ProfileController::class, 'create'])->name('create');
    Route::post('/store', [ProfileController::class, 'store'])->name('store');
    Route::get('/show', [ProfileController::class, 'show'])->name('show');
});
