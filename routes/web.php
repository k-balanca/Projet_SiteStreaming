<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Models\User;

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

Route::get('/', function () {
    return view('connexion');
})->name('connexion');

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/login', function () {
    return view('connexion'); 
});

Route::get('/inscription', function () {
    return view('inscription');
})->name('inscription');

Route::post('/inscription', [UserController::class, 'store'])->name('inscription.store');

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

Route::get('/films', function () {
    return view('Films');
})->name('films');

Route::get('/series', function () {
    return view('series');
})->name('series');

Route::get('/favoris', function () {
    return view('favoris');
})->name('favoris');

Route::get('/compte', function () {
    return view('profile.compte');
})->name('compte');
// Mettre à jour les infos
Route::get('/profile/edit', [UserController::class, 'edit'])->name('profile.edit');
Route::post('/profile/update', [UserController::class, 'update'])->name('profile.update');

// Movie detail JSON API (used by welcome.blade.php showMovieDetails)

Route::get('/movie/{imdbid}', function ($imdbid) {
    include_once base_path('config/get_api.php');
    $details = getMovieDetails($imdbid);
    if (!$details) {
        return response()->json(['error' => 'Detail not found'], 404);
    }
    return response()->json($details);
});

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::middleware('auth')->post('/logout', [AuthController::class, 'logout'])->name('logout');

//Route côté admin
Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/admin', function () {

        $userCount = User::count();
        $adminCount = User::where('is_admin', true)->count();

        return view('admin.dashboard', compact('userCount','adminCount'));
    })->name('admin.dashboard');

});

