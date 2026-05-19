<?php

use App\Http\Controllers\Admin\AdminComplaintController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('landing');
})->name('landing');
Route::get('/trackrecord', function () {
    return view('guests.trackrecord');
})->name('trackrecord');
Route::get('/newcomplaint', function () {
    return view('guests.newcomplaint');
})->name('newcomplaint');
Route::get('/about', function () {
    return view('guests.about');
})->name('about');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// User Complaint Actions
Route::post('/complaints', [ComplaintController::class, 'store'])->name('complaints.store');
Route::get('/track', [ComplaintController::class, 'track'])->name('complaints.track');

// Route::get('/dashboard', function () {
//     if (auth()->user()->is_admin) {
//         return redirect()->route('admin.dashboard');
//     }

//     return app(ComplaintController::class)->index();
// })->name('dashboard');

// Profile Management
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

/*
/*
|--------------------------------------------------------------------------
| Authenticated Routes (Traffic Controller)
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Admin-Only Routes (Command Center)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Management Operations
    Route::get('/dashboard', [AdminComplaintController::class, 'index'])->name('dashboard');
    Route::get('/complaints/{complaint}', [AdminComplaintController::class, 'show'])->name('show');
    Route::patch('/complaints/{complaint}', [AdminComplaintController::class, 'update'])->name('update');
    Route::get('/analytics', [AdminComplaintController::class, 'analytics'])->name('analytics');

    Route::middleware('can:manage-admins')->group(function () {
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
        Route::post('/users', [SettingsController::class, 'store'])->name('users.store');
        Route::delete('/users/{user}', [SettingsController::class, 'destroy'])->name('users.destroy');
        Route::get('/logs', [LogController::class, 'index'])->name('logs');
    });
});

require __DIR__.'/auth.php';
