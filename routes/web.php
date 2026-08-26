<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\RecordsController;
use App\Http\Controllers\Settings\AuthorController;
use App\Http\Controllers\Settings\ClassController;
use App\Http\Controllers\Settings\SectorController;
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

    Route::controller(ClassController::class)->group(function(){
        Route::get('/admin/settings/classification', 'ClassDashboard')->name('class.dash');
        Route::post('/admin/settings/classification/add', 'ClassAdd')->name('class.add');
    });

    Route::controller(SectorController::class)->group(function(){
        Route::get('/admin/settings/secotr', 'SectorDashboard')->name('sector.dash');
        // Route::post('/admin/settings/classification/add', 'ClassAdd')->name('class.add');
    });
    
    Route::controller(AuthorController::class)->group(function(){
        Route::get('/admin/settings/authors', 'SettingAuthor')->name('gear.author');
        Route::post('/admin/settings/authors/add', 'AddAuthor')->name('author.add');
        Route::post('/admin/settings/authors/edit/{id}', 'EditAuthor')->name('author.edit');
    });
});

require __DIR__.'/auth.php';
