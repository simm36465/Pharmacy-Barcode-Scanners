<?php

use App\Http\Controllers\AddMedicament;
use App\Http\Controllers\DashbaordController;
use App\Http\Controllers\DeleteMedicament;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrdonnanceController;
use App\Http\Controllers\PharmacieController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\UpdateMedicament;
use App\Http\Controllers\SearchMedicament;
use App\Http\Controllers\ExportMedicaments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

Route::get("/dashboard", [DashbaordController::class, 'dashdata'])
->middleware(['auth', 'verified','auth:simo'])
->name('dashboard');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified','auth:simo'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::view("/addmedicament", "addmedicament")->name("addmedicament");
    Route::view("/editmedicament", "editmedicament")->name("editmedicament");
    Route::view("/delmedicament", "delmedicament")->name("delmedicament");
    Route::view("/searchmedi", "searchmedi")->name("searchmedi");
    
    Route::view("/exportmedidata", "exportmedidata")->name("exportmedidata");
    Route::post('/exportmedidata',[ExportMedicaments::class,'ExportMedi']);
    Route::get('/exportdata', [ExportController::class, 'exportdata'])->name('exportdata');
    Route::post('/num',[PharmacieController::class,'checkNum']);
    Route::get('/',[PharmacieController::class,"index"])->name('phar')->middleware(["num"]);
    Route::post('/',[PharmacieController::class,"fetchByNum"])->name('phar_post');
    Route::view('/num',"num")->name('num');
    Route::post('/ordonnance/new',[OrdonnanceController::class,'new']);
    Route::post('/newmedicament',[AddMedicament::class,'newMedicament']);
    Route::post('/updatemedicament',[UpdateMedicament::class,'updateMed']);
    Route::post('/medicamentUpdate',[UpdateMedicament::class,'Update']);
    Route::post('/deletemedicament',[DeleteMedicament::class,'delMedicament']);
    Route::post('/searchmedi',[SearchMedicament::class,'search'])->name('searchmedi');



});






require __DIR__.'/auth.php';
