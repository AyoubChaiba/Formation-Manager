<?php

use App\Http\Controllers\admin\homeAdminController;
use App\Http\Controllers\DatesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\adminController;
use App\Http\Controllers\BeneficiariesController;
use App\Http\Controllers\ContactBeneficiariesController;
use App\Http\Controllers\ContactTargetGroupsController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\ProgramsController;
use App\Http\Controllers\ResponsiblesController;
use App\Http\Controllers\TargetGroupsController;
use App\Http\Controllers\TempDateController;
use App\Http\Controllers\WishesController;

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

Route::get('wish/{id}/{ppr}', [WishesController::class, 'index'])->name('wish.index');
Route::post('wish', [WishesController::class, 'store'])->name('wish.store');

Route::group(['prefix' => 'admin'], function () {
    Route::group(['middleware' => 'admin.guest'], function () {
        Route::get('/', [adminController::class, 'index'])->name('admin.show');
        Route::post('/', [AdminController::class, 'login'])->name('admin.login');

    });
    Route::group(["middleware" => "admin.auth"], function () {

        // dashboard route
        Route::get('/dashboard', [homeAdminController::class, "index"])->name('admin.dashboard');

        // logout
        Route::get('/logOut', [HomeAdminController::class, "logout"])->name('admin.logOut');

        Route::get('temp-date', [TempDateController::class, 'index'])->name('temp-date');

        // date routes
        Route::group(['prefix' => 'date'], function () {
            Route::get('/', [DatesController::class, 'index'])->name('date.index');
            Route::get('/create', [DatesController::class, 'create'])->name('date.create');
            Route::post('/', [DatesController::class, 'store'])->name('date.store');
            Route::get('/{id}', [DatesController::class, 'edit'])->name('date.edit');
            Route::put('/{id}/edit', [DatesController::class, 'update'])->name('date.update');
            Route::delete('/{id}', [DatesController::class, 'delete'])->name('date.delete');
        });

        // project routes
        Route::group(['prefix' => 'program'], function () {
            Route::get('/', [ProgramsController::class, 'index'])->name('program.index');
            Route::get('/create', [ProgramsController::class, 'create'])->name('program.create');
            Route::post('/', [ProgramsController::class, 'store'])->name('program.store');
            Route::get('/{id}', [ProgramsController::class, 'edit'])->name('program.edit');
            Route::put('/{id}/edit', [ProgramsController::class, 'update'])->name('program.update');
            Route::delete('/{id}', [ProgramsController::class, 'delete'])->name('program.delete');
        });

        // responsibles routes
        Route::group(['prefix' => 'responsible'], function () {
            Route::get('/', [ResponsiblesController::class, 'index'])->name('responsible.index');
            Route::get('/create', [ResponsiblesController::class, 'create'])->name('responsible.create');
            Route::post('/', [ResponsiblesController::class, 'store'])->name('responsible.store');
            Route::get('/{id}', [ResponsiblesController::class, 'edit'])->name('responsible.edit');
            Route::put('/{id}/edit', [ResponsiblesController::class, 'update'])->name('responsible.update');
            Route::delete('/{id}', [ResponsiblesController::class, 'delete'])->name('responsible.delete');
        });

        // targetGroups routes
        Route::group(['prefix' => 'targetGroup'], function () {
            Route::get('/', [TargetGroupsController::class, 'index'])->name('targetGroup.index');
            Route::get('/create', [TargetGroupsController::class, 'create'])->name('targetGroup.create');
            Route::post('/', [TargetGroupsController::class, 'store'])->name('targetGroup.store');
            Route::get('/{id}', [TargetGroupsController::class, 'edit'])->name('targetGroup.edit');
            Route::put('/{id}/edit', [TargetGroupsController::class, 'update'])->name('targetGroup.update');
            Route::delete('/{id}', [TargetGroupsController::class, 'delete'])->name('targetGroup.delete');
        });

        // course routes
        Route::group(['prefix' => 'course'], function () {
            Route::get('/', [CoursesController::class, 'index'])->name('course.index');
            Route::get('/create', [CoursesController::class, 'create'])->name('course.create');
            Route::post('/', [CoursesController::class, 'store'])->name('course.store');
            Route::get('/{id}', [CoursesController::class, 'edit'])->name('course.edit');
            Route::put('/{id}/edit', [CoursesController::class, 'update'])->name('course.update');
            Route::delete('/{id}', [CoursesController::class, 'delete'])->name('course.delete');
        });

        Route::get('program-target', [CoursesController::class, 'programTarget'])->name('program-target.get');

        // beneficiarie routes
        Route::group(['prefix' => 'beneficiarie'], function () {
            Route::get('/', [BeneficiariesController::class, 'index'])->name('beneficiarie.index');
            Route::get('/create', [BeneficiariesController::class, 'create'])->name('beneficiarie.create');
            Route::post('/', [BeneficiariesController::class, 'store'])->name('beneficiarie.store');
            Route::get('/{id}', [BeneficiariesController::class, 'edit'])->name('beneficiarie.edit');
            Route::put('/{id}/edit', [BeneficiariesController::class, 'update'])->name('beneficiarie.update');
            Route::delete('/{id}', [BeneficiariesController::class, 'delete'])->name('beneficiarie.delete');
        });

        // Contact routes
        Route::group(['prefix' => 'contact'], function () {
            Route::get('/', [ContactTargetGroupsController::class, 'index'])->name('contact.index');
            Route::get('/create', [ContactTargetGroupsController::class, 'create'])->name('contact.create');
            Route::post('/', [ContactTargetGroupsController::class, 'store'])->name('contact.store');
            Route::delete('/{id}', [ContactTargetGroupsController::class, 'delete'])->name('contact.delete');
            Route::get('/show', [ContactBeneficiariesController::class, 'show'])->name('show.index');
            Route::get('/msg/{id}', [ContactBeneficiariesController::class, 'msg'])->name('msg.index');
        });

    });
});
