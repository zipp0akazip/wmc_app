<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Enums\PermissionEnum;
use App\Http\Procedures;

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

Route::prefix('v1')->group(function () {
    Route::rpc('/user', [Procedures\UserProcedure::class])
        ->name('rpc.user')
        ->middleware(['auth:api']);

    Route::rpc('/test', [Procedures\TestProcedure::class])
        ->name('rpc.test')
        ->middleware(['auth:api', 'can:tracks:view']);

    Route::rpc('/raw-releases', [Procedures\RawReleasesProcedure::class])
        ->name('raw-releases.list')
        ->middleware(['auth:api', 'can:' . PermissionEnum::RawReleaseList]);
});

