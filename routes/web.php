<?php

use App\Http\Controllers\backend\backendControler;
use App\Http\Controllers\backend\navController;
use App\Http\Controllers\backend\teacherProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontEnd\frontendController;
use App\Models\navigation;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::GET('/',[frontendController::class, 'navFatch'])->name('nav.fatech');
Auth::routes();

//**FRONT END **/
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//**BACK END */
// ***NAVIGATION
Route::GET('/back-end-nav',[navController::class,'backEndNav'])->name('backend.nav');
Route::POST('/nav-insert', [navController::class, 'navInsert'])->name('nav.insert');
Route::GET('/nav-edit/{navEdit:nav_phone}',[navController::class, 'navEdit'])->name('nav.edit');
Route::PUT('/nav-update/{navigation:nav_phone}',[navController::class,'navUpdate'])->name('nav.update');
Route::DELETE('/nav-delete/{navigation:id}',[navController::class,'navDelete'])->name('nav.delete');


//*******TEACHERS PROFILE ********/