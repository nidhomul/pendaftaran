<?php

use App\Http\Controllers\CaptchaValidationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\MasterKridaSakaMilenialController;
use App\Http\Controllers\MasterKwarranController;
use App\Http\Controllers\MasterScoutLevelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::get('reload_captcha', [CaptchaValidationController::class, 'reloadCaptcha'])->name('reload_captcha');
Route::post('captcha_validation', [CaptchaValidationController::class, 'captchaValidation'])->name('captcha_validation');

Route::post('register', [RegistrationController::class, 'register'])->name('registration.register');

Auth::routes(['register' => false]);

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::controller(FormController::class)->group(function () {
    Route::get('form', 'index')->name('form');

    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('form/detail/{id}', 'detail')->name('form.detail');
        Route::post('form/accept', 'accept')->name('form.accept');
        Route::post('form/reject', 'reject')->name('form.reject');

        Route::put('form/update/{id}', 'update')->name('form.update');
    });
});

Route::controller(ProfileController::class)->group(function () {
    Route::get('profile', 'index')->name('profile');
    Route::put('profile/update_user', 'updateUser')->name('profile.update_user');

    Route::group(['middleware' => ['role:admin']], function () {
        Route::put('profile/update_admin', 'updateAdmin')->name('profile.update_admin');
    });
});

Route::group(['middleware' => ['role:admin']], function () {
    Route::controller(MasterKwarranController::class)->group(function () {
        Route::get('master/kwarran', 'index')->name('master.kwarran');
        Route::get('master/kwarran/create', 'create')->name('master.kwarran.create');
        Route::post('master/kwarran/store', 'store')->name('master.kwarran.store');
        Route::get('master/kwarran/edit/{id}', 'edit')->name('master.kwarran.edit');
        Route::put('master/kwarran/update/{id}', 'update')->name('master.kwarran.update');
        Route::delete('master/kwarran/destroy/{id?}', 'destroy')->name('master.kwarran.destroy');
    });
    
    Route::controller(MasterScoutLevelController::class)->group(function () {
        Route::get('master/scout_level', 'index')->name('master.scout_level');
        Route::get('master/scout_level/create', 'create')->name('master.scout_level.create');
        Route::post('master/scout_level/store', 'store')->name('master.scout_level.store');
        Route::get('master/scout_level/edit/{id}', 'edit')->name('master.scout_level.edit');
        Route::put('master/scout_level/update/{id}', 'update')->name('master.scout_level.update');
        Route::delete('master/scout_level/destroy/{id?}', 'destroy')->name('master.scout_level.destroy');
    });
    
    Route::controller(MasterKridaSakaMilenialController::class)->group(function () {
        Route::get('master/krida_saka_milenial', 'index')->name('master.krida_saka_milenial');
        Route::get('master/krida_saka_milenial/create', 'create')->name('master.krida_saka_milenial.create');
        Route::post('master/krida_saka_milenial/store', 'store')->name('master.krida_saka_milenial.store');
        Route::get('master/krida_saka_milenial/edit/{id}', 'edit')->name('master.krida_saka_milenial.edit');
        Route::put('master/krida_saka_milenial/update/{id}', 'update')->name('master.krida_saka_milenial.update');
        Route::delete('master/krida_saka_milenial/destroy/{id?}', 'destroy')->name('master.krida_saka_milenial.destroy');
    });
});
