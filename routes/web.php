<?php

use App\Http\Controllers\ProfileController;
use App\Filament\Pages\CompanyDashboard;
use App\Http\Livewire\CompanyLogin;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::get('/company/dashboard', function () {
//     return app(CompanyDashboard::class)->render();
// })->name('company.dashboard');

Route::middleware(['web', 'auth:company'])->group(function () {
    Route::get('/company/dashboard', CompanyDashboard::class)
        ->name('company.dashboard');
});

Route::get('/company/login', CompanyLogin::class)->name('company.login');

Route::post('/company/logout', function () {
    Auth::guard('company')->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('company.login');
})->name('company.logout');

require __DIR__.'/auth.php';
