<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\Admin\TechnologyController;
use App\Http\Controllers\GitHubController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('projects/trash', [ProjectController::class, 'trash_projects'])->name('projects.trash');
    Route::put('/admin/trash/{project}/restore', [ProjectController::class, 'restore'])->name('restore');
    Route::delete('/admin/trash/{project}/destroy', [ProjectController::class, 'forceDelete'])->name('forceDelete');
    Route::resource('projects', ProjectController::class)->parameters([
        'projects' => 'project:slug'
    ]);
    Route::get('types/trash', [TypeController::class, 'trashed'])->name('types.trash');
    Route::put('types/{type}/restore', [TypeController::class, 'restoreTrash'])->name('types.restore');
    Route::delete('types/{type}/destroy', [TypeController::class, 'forceDestroy'])->name('types.forceDestroy');
    Route::resource('types', TypeController::class)->parameters([
        'types' => 'type:slug'
    ]);

    //da sistemare
    //Route::get('/repositories', [GitHubController::class, 'fetchRepositories'])->name('repositories');

    Route::get('technologies/trash', [TechnologyController::class, 'trashed'])->name('technologies.trash');
    Route::put('technologies/{technology}/restore', [TechnologyController::class, 'restoreTrash'])->name('technologies.restore');
    Route::delete('technologies/{technology}/destroy', [TechnologyController::class, 'forceDestroy'])->name('technologies.forceDestroy');
    Route::resource('technologies', TechnologyController::class)->parameters([
        'technologies' => 'technology:slug'
    ]);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
