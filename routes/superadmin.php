<?php

use App\Http\Controllers\Superadmin\SuperadminController;
use App\Http\Controllers\Superadmin\ManageUserController;
use App\Http\Controllers\Superadmin\ManageCompanyController;
use Illuminate\Support\Facades\Route;

Route::prefix('superadmin')->name('superadmin.')->group(function(){

  Route::middleware(['guest:superadmin','PreventBackHistory'])->group(function(){
       Route::view('/login','dashboard.superadmin.login')->name('login');
       Route::view('/register','dashboard.superadmin.register')->name('register');
       Route::post('/create',[SuperadminController::class,'create'])->name('create');
       Route::post('/check',[superadminController::class,'check'])->name('check');
  });

  Route::middleware(['auth:superadmin','PreventBackHistory'])->group(function(){
       Route::view('/dashboard','dashboard.superadmin.index')->name('dashboard');
       Route::resource('users', ManageUserController::class);
       Route::resource('companies', ManageCompanyController::class);
       Route::post('logout',[SuperadminController::class,'logout'])->name('logout');
  });

});