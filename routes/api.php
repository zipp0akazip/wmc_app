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
Route::middleware(['auth:api'])->group(function () {
    Route::rpc('/v1', [
        Procedures\ArtistProcedure::class,
        Procedures\LabelProcedure::class,
        Procedures\RawReleaseProcedure::class,
        Procedures\StyleProcedure::class,
        Procedures\UnapprovedArtistProcedure::class,
        Procedures\UnapprovedLabelProcedure::class,
        Procedures\UnapprovedStyleProcedure::class,
        Procedures\UserProcedure::class,
    ]);
});
