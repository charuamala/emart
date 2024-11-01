<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BannerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');    
})->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Auth::routes(['register'=>false]);
//Admin Dashboard
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['prefix'=>'admin/','middleware'=>'auth'], function(){
    Route::get('/',[App\Http\Controllers\AdminController::class,'admin'])->name('admin');
});
Route::group(['prefix'=>'vendor/','middleware'=>'auth'], function(){
    Route::get('/',[App\Http\Controllers\AdminController::class,'vendor'])->name('vendor');
});
Route::group(['prefix'=>'customer/','middleware'=>'auth'], function(){
    Route::get('/',[App\Http\Controllers\AdminController::class,'customer'])->name('customer');
});
// Banner section
Route::get('/banner', [App\Http\Controllers\BannerController::class, 'index'])->name('banner');
Route::post('banner/status', [BannerController::class, 'updateStatus'])->name('banner.status');
