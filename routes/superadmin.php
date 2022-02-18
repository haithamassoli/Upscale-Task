<?php

use App\Http\Controllers\Superadmin\SuperadminController;
use Illuminate\Support\Facades\Route;

Route::prefix('superadmin')->name('superadmin.')->group(function(){

  Route::middleware(['guest:superadmin','PreventBackHistory'])->group(function(){
       Route::view('/login','dashboard.superadmin.login')->name('login');
       Route::view('/register','dashboard.superadmin.register')->name('register');
       Route::post('/create',[SuperadminController::class,'create'])->name('create');
       Route::post('/check',[superadminController::class,'check'])->name('check');
  });

  Route::middleware(['auth:superadmin','PreventBackHistory'])->group(function(){
       Route::view('/home','dashboard.superadmin.home')->name('home');
       Route::post('logout',[SuperadminController::class,'logout'])->name('logout');
  });

});