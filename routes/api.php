<?php

use App\Models\Ordanance;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/ve/{num}',function (string $num) {
    
    $ord = Ordanance::where("num_eng","$num")->first();
    if($ord == null)
    return new JsonResponse([
        "status"=>true
    ],200);
    else
    return new JsonResponse([
            "status"=>false
    ],400);

});


