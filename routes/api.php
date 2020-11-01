<?php

use Illuminate\Support\Facades\Route;
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
        Route::rpc('/user', [Procedures\UserProcedure::class]);
    });

    Route::middleware(['auth:api', 'permissions'])->group(function () {
        Route::rpc('/raw-releases', [Procedures\RawReleaseProcedure::class]);
        Route::rpc('/unapproved-styles', [Procedures\UnapprovedStyleProcedure::class]);
        Route::rpc('/unapproved-labels', [Procedures\UnapprovedLabelProcedure::class]);
        Route::rpc('/unapproved-artists', [Procedures\UnapprovedArtistProcedure::class]);
        Route::rpc('/styles', [Procedures\StyleProcedure::class]);
        Route::rpc('/labels', [Procedures\LabelProcedure::class]);
    });
});
