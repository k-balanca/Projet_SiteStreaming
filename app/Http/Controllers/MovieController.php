<?php
namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{
    public function like(Request $request)
    {
        $request->validate(['imdbid' => 'required|string']);

        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['status' => 'error', 'message' => 'Vous devez être connecté pour ajouter un favori.'], 401);
        }

        Like::updateOrCreate(
            ['user_id' => $userId, 'imdb_id' => $request->imdbid],
            []
        );

        return response()->json(['status' => 'ok', 'message' => 'Film ajouté aux favoris']);
    }

    public function unlike(Request $request)
    {
        $request->validate(['imdbid' => 'required|string']);

        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['status' => 'error', 'message' => 'Vous devez être connecté pour supprimer un favori.'], 401);
        }

        $deleted = Like::where('user_id', $userId)->where('imdb_id', $request->imdbid)->delete();

        if ($deleted) {
            return response()->json(['status' => 'ok', 'message' => 'Film retiré des favoris']);
        }

        return response()->json(['status' => 'error', 'message' => 'Favori introuvable'], 404);
    }

    public function favorites()
    {
        $userId = Auth::id();
        if (!$userId) {
            return redirect()->route('connexion');
        }

        include_once base_path('config/get_api.php');

        $imdbIds = Like::where('user_id', $userId)->pluck('imdb_id')->toArray();

        $favorites = [];
        foreach ($imdbIds as $imdbid) {
            $movie = getMovieDetails($imdbid);

            if ($movie && isset($movie['Response']) && $movie['Response'] === 'True') {
                $favorites[] = $movie;
            } else {
                $favorites[] = [
                    'Title' => 'Titre indisponible',
                    'Year' => '-',
                    'Poster' => 'https://via.placeholder.com/200x300?text=No+Cover',
                    'Plot' => 'Détails indisponibles, vérifiez votre clé OMDB_API_KEY.',
                    'imdbID' => $imdbid,
                ];
            }
        }

        return view('favoris', ['favorites' => $favorites]);
    }

    protected function fetchMovieByImdb($imdbid)
    {
        include_once base_path('config/get_api.php');
        $movie = getMovieDetails($imdbid);
        if (!$movie) {
            return null;
        }
        return $movie;
    }
}
