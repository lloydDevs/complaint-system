<?php

use App\Http\Controllers\Admin\AdminComplaintController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Traffic Controller)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // Main Dashboard Redirect Logic
    Route::get('/dashboard', function () {
        if (auth()->user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        return app(ComplaintController::class)->index();
    })->name('dashboard');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User Complaint Actions
    Route::post('/complaints', [ComplaintController::class, 'store'])->name('complaints.store');
});

/*
|--------------------------------------------------------------------------
| Admin-Only Routes (Command Center)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Admin Landing Page
    Route::get('/dashboard', [AdminComplaintController::class, 'index'])->name('dashboard');

    // Management Operations
    Route::get('/complaints/{complaint}', [AdminComplaintController::class, 'show'])->name('show');
    Route::patch('/complaints/{complaint}', [AdminComplaintController::class, 'update'])->name('update');
    Route::get('/analytics', [AdminComplaintController::class, 'analytics'])->name('analytics');
});

require __DIR__.'/auth.php';
