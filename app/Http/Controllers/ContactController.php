<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string|max:5000',
        ]);

        $to = "yldz.ma60@gmail.com";
        $subject = "Nouveau message de contact";

        $body = "Nom: {$validated['nom']}\n";
        $body .= "Email: {$validated['email']}\n\n";
        $body .= "Message:\n{$validated['message']}";

        try {
            Mail::raw($body, function ($message) use ($validated, $to, $subject) {
                $message->from($validated['email'], $validated['nom']);
                $message->to($to)->subject($subject);
            });
            return back()->with('success', 'Message envoyé avec succès !');
        } catch (\Exception $e) {
            Log::error('Contact mail error: ' . $e->getMessage());
            return back()->with('error', 'Erreur lors de l\'envoi. Vérifiez la configuration du mail.');
        }
    }
}
