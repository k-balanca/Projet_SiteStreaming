<?php

namespace App\Http\Controllers;

use App\Models\cr;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function toggle(Request $request)
    {
        $user = auth()->user();

        $favorite = Favorite::where('user_id', $user->id)
            ->where('movie_id', $request->movie_id)
            ->first();

        if ($favorite) {
            $favorite->delete(); // retirer des favoris
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'movie_id' => $request->movie_id
            ]);
        }

        return back();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(cr $cr)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(cr $cr)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, cr $cr)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(cr $cr)
    {
        //
    }
}
