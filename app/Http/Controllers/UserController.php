<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(Request $request)
    {
       try {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        if ($user) {
            Auth::login($user);
        }

        return redirect()->route('welcome')->with('success', 'Utilisateur créé');

        } catch (QueryException $e) {
            return back()->with('error', 'Erreur : impossible de créer l’utilisateur.');
        }
    }
    public function compte()
    {
        $user = Auth::user(); // utilisateur actuellement connecté

        return view('compte', compact('user'));
    }
    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }
    public function update(Request $request)
    {
        $user = auth()->user();
        try {
            // Validation
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',

                'current_password' => 'required_with:password',
                'password' => 'nullable|min:6|confirmed',
            ]);
            // Données de base
            $data = [
                'name' => $validated['name'],
                'email' => $validated['email'],
            ];
            // Gestion du mot de passe
            if ($request->filled('password')) {

                if (!Hash::check($request->current_password, $user->password)) {
                    return back()
                        ->withErrors(['current_password' => 'Mot de passe actuel incorrect'])
                        ->withInput();
                }

                $data['password'] = Hash::make($request->password);
            }
            // Mise à jour
            $user->update($data);

            return redirect()
                ->route('compte')
                ->with('success', 'Profil mis à jour avec succès');
        } catch (ValidationException $e) {
            // Laravel gère déjà ça, mais au cas où
            return back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (QueryException $e) {
            // Erreur base de données (ex: email déjà utilisé)
            return back()
                ->with('error', 'Erreur base de données. Vérifie les informations.')
                ->withInput();

        } catch (\Exception $e) {

            // Toute autre erreur
            return back()
                ->with('error', 'Une erreur inattendue est survenue.')
                ->withInput();
        }
    }

    public function index()
    {
        $users = User::all(); // récupère tous les utilisateurs
        return view('admin.users.index', compact('users'));
    }
}


