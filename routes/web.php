<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Models\Listing;
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

//all listings
Route::get('/',[ListingController::class,'index']);

//create listing
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');

//store listing
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');

//edit listing
Route::get('/listings/{listing}/edit',[ListingController::class,'edit'])->middleware('auth');

//submit edit
Route::put('/listings/{listing}',[ListingController::class,'update'])->middleware('auth');

//delete listing
Route::delete('/listings/{listing}',[ListingController::class,'delete'])->middleware('auth');

//manage listings
Route::get('/listings/manage',[ListingController::class,'manage'])->middleware('auth');

//one listing
Route::get('/listings/{listing}', [ListingController::class, 'show']);

//register form
Route::get('/register',[UserController::class,'create'])->middleware('guest');

//create new user
Route::post('/users',[UserController::class,'store']);

//logout
Route::post('/logout',[UserController::class,'logout'])->middleware('auth');

//login form
Route::get('/login',[UserController::class,'login'])->name('login')->middleware('guest');

//login user
Route::post('/users/authenticate',[UserController::class,'authenticate']);
