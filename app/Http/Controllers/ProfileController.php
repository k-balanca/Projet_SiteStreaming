<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.compte', ['user' => auth()->user()]);
    }

    public function edit()
    {
        return view('profile.edit', ['user' => auth()->user()]);
    }


public function update(ProfileUpdateRequest $request)
{
    $data = $request->validated(); // ✅ tableau propre

    $user = $request->user();

    $user->name  = $data['name'];
    $user->email = $data['email'];

    if (!empty($data['new_password'])) {
        $user->password = Hash::make($data['new_password']);
    }

    $user->save();

    return redirect()
        ->route('profile.compte')
        ->with('status', 'Profil mis à jour ✅');
}


}
?>
