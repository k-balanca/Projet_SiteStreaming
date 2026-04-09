<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MovieController;

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

Route::get('/favoris', [MovieController::class, 'favorites'])->name('favoris');

Route::get('/profile/compte', function () {
    return view('profile.compte');
})->name('profile.compte');

Route::get('/profile/edit', function () {
    return view('profile.edit');
})->name('profile.edit');

Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');


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

Route::get('/api/movies', function (Request $request) {
    include_once base_path('config/get_api.php');

    $query = $request->query('query', 'a');
    $page = max(1, intval($request->query('page', 1)));
    $type = $request->query('type', 'movie');

    $result = fetchMoviesFromOmdb($query, $type, $page);

    if (isset($result['Error']) && !empty($result['Error'])) {
        return response()->json(['success' => false, 'message' => $result['Error']], 400);
    }

    return response()->json([
        'success' => true,
        'query' => $query,
        'type' => $type,
        'page' => $page,
        'totalResults' => isset($result['totalResults']) ? intval($result['totalResults']) : 0,
        'movies' => isset($result['Search']) ? $result['Search'] : [],
    ]);

    
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
Route::post('/login', [AuthController::class, 'login'])->name('login');