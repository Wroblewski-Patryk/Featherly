<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Tutaj rejestrujemy główne grupy tras. Używamy modularnego podejścia,
| dzieląc routing na auth, dashboard i public.
|
*/

// --- 1. Root & Technical Routes ---
Route::get('sitemap.xml', [\App\Http\Controllers\SeoController::class, 'sitemap'])->name('sitemap');
Route::get('robots.txt', [\App\Http\Controllers\SeoController::class, 'robots'])->name('robots');
Route::get('lang/{lang}', [\App\Http\Controllers\LocaleController::class, 'switch'])->name('locale.switch');

// --- 2. Fallbacks dla nie-prefixed URLs ---
// Przekierowania z /login, /admin oraz innych bez prefiksu językowego na lokalizowane wersje
Route::group(['middleware' => ['locale']], function() {
    Route::get('login', [\App\Http\Controllers\FallbackController::class, 'login'])->name('login');
    
    Route::get('admin', [\App\Http\Controllers\FallbackController::class, 'admin']);

    Route::get('dashboard/{any?}', [\App\Http\Controllers\FallbackController::class, 'dashboard'])->where('any', '.*');

    Route::get('/', [\App\Http\Controllers\FallbackController::class, 'home']);

    // Przekieruj wszystkie niedopasowane trasy (które nie pasują do {locale}) na zaprefiksowaną wersję
    Route::get('/{path}', [\App\Http\Controllers\FallbackController::class, 'catchAll'])->where('path', '^(?![a-z]{2}(?:/|$))(?!build|storage|api|livewire|sitemap|robots|admin|login|dashboard|lang).*$');
});

// --- 3. Public Routes (Catch-all) ---
// UWAGA: routes/public.php (w tym główny wyłapywacz adresów) jest teraz 
// ładowany na samym końcu poprzez metode `then` w `bootstrap/app.php`,
// by nie nadpisywać ścieżek należących do panelu zarządzania (admin.*).
