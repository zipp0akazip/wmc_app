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
    Route::middleware(['auth:api'])->group(function () {
        Route::rpc('/user', [Procedures\UserProcedure::class])->name('rpc.user');
        Route::rpc('/raw-releases', [Procedures\RawReleasesProcedure::class])->name('rpc.raw-releases');
        Route::rpc('/unapproved-styles', [Procedures\UnapprovedStylesProcedure::class])->name('rpc.unapproved-styles');
        Route::rpc('/styles', [Procedures\StylesProcedure::class])->name('rpc.styles');
    });
});

