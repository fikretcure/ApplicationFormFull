<?php

use App\Http\Controllers\AppealController;
use App\Http\Controllers\CountryCodeController;
use App\Http\Controllers\ReferanceController;
use App\Models\Appeal;
use App\Models\CountryCodes;
use App\Models\Referance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/appeal/order', [AppealController::class, "order"])->name("appeal.order");
Route::apiResources([
    'appeal' => AppealController::class,
    'country_code' => CountryCodeController::class,
    'referance' => ReferanceController::class
]);
Route::get('/test_a', [AppealController::class, "order"])->name("appeal.order");
