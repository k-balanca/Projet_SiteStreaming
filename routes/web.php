<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
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

Route::post('/like-movie', [MovieController::class, 'like'])->name('like.movie');
Route::post('/unlike-movie', [MovieController::class, 'unlike'])->name('unlike.movie');

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
        $users = User::All();

        return view('admin.dashboard', compact('userCount','adminCount','users'));
    })->name('admin.dashboard');

    Route::get('/admin/users', function () {
        $users = User::All();
        return view('admin.users', compact('users')); 
    })->name('admin.users');

});

//Protection avec auth pour que seul l’utilisateur connecté modifie son profil.

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.compte');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

