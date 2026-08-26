<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\RecordsController;
use App\Http\Controllers\Settings\AuthorController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Auth/Login');
});

Route::middleware('auth')->group(function(){
    Route::controller(AdminController::class)->group(function(){
        Route::get('/admin/dashboard', 'AdminDashboard')->name('admin.dash');
    });

    Route::controller(RecordsController::class)->group(function(){
        Route::get('/admin/records', 'RecordDashboard')->name('rec.dash');
    });
    
    Route::controller(AuthorController::class)->group(function(){
        Route::get('/admin/settings/authors', 'SettingAuthor')->name('gear.author');
        Route::post('/admin/settings/authors/add', 'AddAuthor')->name('author.add');
        Route::post('/admin/settings/authors/edit/{id}', 'EditAuthor')->name('author.edit');
    });
});

require __DIR__.'/auth.php';
