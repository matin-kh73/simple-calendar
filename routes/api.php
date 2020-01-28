<?php

use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\EventController;
use App\Http\Controllers\API\UserController;
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

Route::group(['namespace' => 'API', 'prefix' => 'v1'], function () {
    Route::group(['namespace' => 'Auth'], function ($route) {
        $route->post('login', [LoginController::class, 'login'])->name('login');
        $route->post('register', [RegisterController::class, 'register'])->name('register');
        $route->post('logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth:api');
    });
    Route::group(['middleware' => 'auth:api'], function ($route) {
        //event routes
        $route->get('events', [EventController::class, 'index'])->name('events.index')->middleware('isAdmin');
        $route->get('events/show/{event}', [EventController::class, 'show'])->name('events.show');
        $route->post('events/create', [EventController::class, 'store'])->name('events.store');
        $route->put('events/update/{event}', [EventController::class, 'update'])->name('events.update');
        $route->delete('events/destroy/{event}', [EventController::class, 'destroy'])->name('events.destroy');

        // user routes
        $route->get('user/events', [EventController::class, 'userEvents'])->name('user.events.index');
        $route->get('user', function (Request $request) {
            return $request->user();
        });
    });
});
