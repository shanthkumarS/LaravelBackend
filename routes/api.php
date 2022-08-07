<?php

use App\Http\Controllers\Authentication\LoginController;
use App\Http\Controllers\User\RoleController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\UserRolesController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\Authentication\ApiMiddleware;
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
Route::post('login', [LoginController::class, 'login']);

Route::middleware(ApiMiddleware::class)->group(function() {

    // Route::middleware(AdminMiddleware::class)->group(function() {

        Route::get('users', [UserController::class, 'index']);

        Route::prefix('user')->group(function() {

            Route::post('/', [UserController::class, 'create']);

            Route::put('/', [UserController::class, 'update']);

            Route::delete('/{user_id}', [UserController::class, 'delete']);
        });

        Route::prefix('roles')->group(function() {

            Route::get('/', [RoleController::class, 'index']);

            Route::get('/{user_id}', [UserRolesController::class, 'index']);
        });

    // });

    /** @todo: Add group of route and services for other role*/
});
