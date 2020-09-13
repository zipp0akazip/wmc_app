<?php

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

Route::get('/test', function(Request $request) {
    return 123;
});

Route::prefix('v1')->group(function () {
    Route::rpc('/user', [\App\Http\Procedures\UserProcedure::class])
        ->name('rpc.user')
        ->middleware(['auth:api']);

    Route::rpc('/test', [\App\Http\Procedures\TestProcedure::class])
        ->name('rpc.test')
        ->middleware(['auth:api', 'can:tracks:view']);
});

