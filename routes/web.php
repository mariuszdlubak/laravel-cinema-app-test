<?php

use App\Http\Controllers\AdminCinemaHallsController;
use App\Http\Controllers\AdminCodesController;
use App\Http\Controllers\AdminMoviesController;
use App\Http\Controllers\AdminPanelController;
use App\Http\Controllers\AdminSchedulesController;
use App\Http\Controllers\AdminSchedulesHallController;
use App\Http\Controllers\AdminTypesController;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PopularController;
use App\Http\Controllers\TicketController;
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

Route::get('/', [HomeController::class, 'index'])
    ->name('home.index');

Route::resource('movies', MovieController::class)
    ->only(['index', 'show']);

Route::resource('popular', PopularController::class)
    ->only(['index']);

Route::get('login', fn () => to_route('auth.create'))->name('login');
Route::resource('auth', AuthController::class)
    ->only(['create', 'store']);

Route::get('/auth/forgot-password', [AuthController::class, 'index'])
    ->name('auth.forgotpassword');

Route::get('/auth/register', [AuthController::class, 'index'])
    ->name('auth.register');

Route::delete('logout', fn () => to_route('auth.destroy'))->name('logout');
Route::delete('auth', [AuthController::class, 'destroy'])
    ->name('auth.destroy');

Route::middleware('auth')->group(function() {
    Route::get('/balance', [BalanceController::class, 'create'])
        ->name('balance.create');
    Route::post('/balance', [BalanceController::class, 'store'])
        ->name('balance.store');
    Route::get('/tickets', [TicketController::class, 'index'])
        ->name('tickets.index');
    Route::get('/tickets/{movieSchedule}/buy', [TicketController::class, 'create'])
        ->name('ticket.buy');
    Route::post('/tickets/{movieSchedule}/buy', [TicketController::class, 'store'])
        ->name('ticket.store');
    Route::middleware('admin')->group(function() {
        Route::resource('admin', AdminPanelController::class)
            ->only(['index']);
        Route::prefix('admin')->group(function () {
            Route::resource('movies', AdminMoviesController::class)->names([
                'index' => 'admin.movies.index',
                'create' => 'admin.movies.create',
                'store' => 'admin.movies.store',
                'edit' => 'admin.movies.edit',
                'update' => 'admin.movies.update'
            ])->only(['index', 'create', 'store', 'edit', 'update']);
            Route::resource('movies.schedules', AdminSchedulesController::class)->names([
                'index' => 'admin.movies.schedules.index',
                'create' => 'admin.movies.schedules.create',
                'store' => 'admin.movies.schedules.store',
                'edit' => 'admin.movies.schedules.edit',
                'update' => 'admin.movies.schedules.update'
            ])->only(['index', 'create', 'store', 'edit', 'update']);
            Route::resource('movies.types', AdminTypesController::class)->names([
                'create' => 'admin.movies.types.create',
                'store' => 'admin.movies.types.store',
                'edit' => 'admin.movies.types.edit',
                'update' => 'admin.movies.types.update'
            ])->only(['create', 'store', 'edit', 'update']);
            Route::resource('cinema-halls', AdminCinemaHallsController::class)->names([
                'index' => 'admin.cinemahalls.index',
                'create' => 'admin.cinemahalls.create',
                'store' => 'admin.cinemahalls.store',
                'edit' => 'admin.cinemahalls.edit',
                'update' => 'admin.cinemahalls.update'
            ])->only(['index', 'create', 'store', 'edit', 'update']);
            Route::resource('codes', AdminCodesController::class)->names([
                'index' => 'admin.codes.index',
                'create' => 'admin.codes.create',
                'store' => 'admin.codes.store'
            ])->only(['index', 'create', 'store']);
        });
    });
});

Route::any('/{any}', function () {
    abort(404);
})->where('any', '.*');
