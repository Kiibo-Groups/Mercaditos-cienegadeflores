<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::prefix(env('user'))->namespace('User')->group(static function() {
    Route::middleware('auth')->group(static function () {

        /*
        |-----------------------------------------
        |Dashboard and Account Setting & Logout
        |-----------------------------------------
        */  
        Route::get('/',[App\Http\Controllers\Admin\AdminController::class, 'home'])->name('dash');
        Route::get('dash',[App\Http\Controllers\Admin\AdminController::class, 'home'])->name('dash');
        Route::get('settings',[App\Http\Controllers\Admin\AdminController::class, 'settings'])->name('settings'); 
        Route::post('/settings',[App\Http\Controllers\Admin\AdminController::class, 'settings_update']);
        Route::get('/perfil_s',[App\Http\Controllers\Admin\AdminController::class, 'perfil_s'])->name('perfil_s'); 
        Route::post('/profile',[App\Http\Controllers\Admin\AdminController::class, 'update']);
        Route::get('logout',[App\Http\Controllers\Admin\AdminController::class, 'logout'])->name('logoutAdmin');

        /*
        |------------------------------
        |Manage Banner
        |------------------------------
        */
        Route::resource('banner','\App\Http\Controllers\Admin\BannerController');
        Route::get('banner',[App\Http\Controllers\Admin\BannerController::class, 'index'])->name('banners');
        Route::get('banner/delete/{id}',[App\Http\Controllers\Admin\BannerController::class, 'delete']);
        Route::get('banner/status/{id}',[App\Http\Controllers\Admin\BannerController::class, 'status']);
    
        /*
        |------------------------------
        |Manage AppUser
        |------------------------------
        */
        Route::resource('users','\App\Http\Controllers\Admin\AppUserController');
        Route::get('users',[App\Http\Controllers\Admin\AppUserController::class, 'index'])->name('users');
        Route::get('users/delete/{id}',[App\Http\Controllers\Admin\AppUserController::class, 'delete']);
        Route::get('users/status/{id}',[App\Http\Controllers\Admin\AppUserController::class, 'status']);
        Route::get('users/status/{id}',[App\Http\Controllers\Admin\AppUserController::class, 'status']);
        Route::post('users/reports',[App\Http\Controllers\Admin\AppUserController::class, 'reports']); 
        Route::get('users/{id}/viewqr',[App\Http\Controllers\Admin\AppUserController::class, 'viewqr']);

        /*
        |------------------------------
        |Manage Colonies
        |------------------------------
        */
        Route::resource('colonies','\App\Http\Controllers\Admin\ColoniesController');
        Route::get('colonies',[App\Http\Controllers\Admin\ColoniesController::class, 'index'])->name('colonies_list');
        Route::get('colonies/delete/{id}',[App\Http\Controllers\Admin\ColoniesController::class, 'delete']);
        Route::get('colonies/status/{id}',[App\Http\Controllers\Admin\ColoniesController::class, 'status']);
        Route::get('ImportColonies',[App\Http\Controllers\Admin\ColoniesController::class, 'import'])->name('importColonies');
        Route::post('colonies/import',[App\Http\Controllers\Admin\ColoniesController::class, '_import']);
        Route::get('getColonies',[App\Http\Controllers\Admin\ColoniesController::class, 'getColonies'])->name('getColonies');
        
        /*
        |------------------------------
        |Manage Bases de datos
        |------------------------------
        */
        Route::resource('mercaditos','\App\Http\Controllers\Admin\MercadosController');
        Route::get('mercaditos',[App\Http\Controllers\Admin\MercadosController::class, 'index'])->name('bd_list');
        Route::get('mercaditos/delete/{id}',[App\Http\Controllers\Admin\MercadosController::class, 'delete']);
        Route::get('mercaditos/status/{id}',[App\Http\Controllers\Admin\MercadosController::class, 'status']);
        Route::get('ImportMercados',[App\Http\Controllers\Admin\MercadosController::class, 'import'])->name('ImportMercados');
        Route::post('mercaditos/import',[App\Http\Controllers\Admin\MercadosController::class, '_import']);
        Route::get('ExportMercados',[App\Http\Controllers\Admin\MercadosController::class, 'export'])->name('ExportMercados');
    
        /*
        |------------------------------
        |Reportes
        |------------------------------
        */
        Route::resource('reports','\App\Http\Controllers\Admin\ReportsController');
        Route::get('reports',[App\Http\Controllers\Admin\ReportsController::class, 'index'])->name('reports'); 
        Route::get('exportData',[App\Http\Controllers\Admin\ReportsController::class, 'exportData']); 
    

        /*
        |------------------------------
        |Reportes de permisos
        |------------------------------
        */
        Route::resource('perms','\App\Http\Controllers\Admin\ReportsController');
        Route::get('perms_alcohol',[App\Http\Controllers\Admin\ReportsController::class, 'report_perms'])->name('perms_alcohol'); 
        Route::get('exportDataPerms',[App\Http\Controllers\Admin\ReportsController::class, 'exportDataPerms']);  
    });
});

// Control de fallos
Route::fallback(function () {
    return view('errors.404'); // template should exists
});