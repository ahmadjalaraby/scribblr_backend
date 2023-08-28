<?php

use App\Http\Controllers\Web\ArticleController;
use App\Http\Controllers\Web\CountryController;
use App\Http\Controllers\Web\LanguageController;
use App\Http\Controllers\Web\ProfileController;
use App\Http\Controllers\Web\TagController;
use App\Http\Controllers\Web\TranslationController;
use App\Http\Controllers\Web\UserController;
use Illuminate\Http\Request;
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

Route::post('/locale', function (Request $request) {
    $request->validate([
        'locale' => 'required',
    ]);

    $locale = $request->get('locale');
    session(['locale' => $locale]);
    return back();
})->name('change.language');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });
    Route::get('/dashboard', function () {
        return inertia('Dashboard');
    })->name('dashboard');

    Route::resource('tags', TagController::class)->except(['show']);

    Route::resource('languages', LanguageController::class)
        ->only(['index', 'create', 'store']);

    Route::resource('translations', TranslationController::class)
        ->only(['index', 'create', 'store']);

    Route::resource('users', UserController::class)->except(['show']);

    Route::resource('countries', CountryController::class)->except(['show']);

    Route::resource('articles', ArticleController::class)->except(['show']);

    Route::get('/notifications', function () {
        return inertia('Dashboard');
    })->name('notifications');
});


Route::fallback(function () {
    return inertia('Error/404');
});


require __DIR__ . '/auth.php';
