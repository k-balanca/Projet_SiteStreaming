<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //Fonction Connexion
    public function login(Request $request)
    {
        // Validation des champs
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        // Tentative de connexion
        if (Auth::attempt($credentials)) {

            // Regénère la session pour éviter les attaques de fixation de session
            $request->session()->regenerate();

            // Rediriger tous les utilisateurs vers la page d'accueil après connexion.
            return redirect()->route('welcome');
        }
        // Retour avec message d'erreur si email ou mot de passe incorrect
        return back()
            ->withInput($request->only('email')) // conserve l'email saisi
            ->with('error', 'Email ou mot de passe incorrect');
    }

    //Fonction Deconnexion
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalide la session pour sécurité
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Déconnexion réussie');
    }
}



