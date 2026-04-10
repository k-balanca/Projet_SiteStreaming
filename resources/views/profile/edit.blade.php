<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mon compte - HYPER Streaming</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
</head>
<body class="body1">
    @include('header')
    <main class="account-section">
        <div class="account-wrapper">
           <section class="contact-section">
           <h1>Modification du profil</h1>

            {{-- Erreurs globales (optionnel mais pratique) --}}
            @if ($errors->any())
                <div class="alert alert-danger mt-3">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

           <form action="{{ route('profile.update') }}" method="POST" class="contact-form">
                @csrf
                @method('PUT')
                
                {{-- NOM --}}
                <div class="input-group">
                    <label class="form-label">Nom</label>
                    <input
                        type="text"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $user->name) }}"
                        required
                    >
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- EMAIL --}}
                <div class="input-group">
                    <label class="form-label">Nom</label>
                    <input
                        type="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $user->email) }}"
                        required
                    >
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <br>
                <br>
                <h5>Changer le mot de passe (optionnel)</h5>
                
                {{-- MDP ACTUEL --}}
                <div class="input-group">
                    <label class="form-label">Mot de passe actuel</label>
                    <input
                        type="password"
                        name="current_password"
                        class="form-control @error('current_password') is-invalid @enderror"
                        autocomplete="current-password"
                    >
                    @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                
                {{-- NOUVEAU MDP --}}
                <div class="input-group">
                    <label class="form-label">Nouveau mot de passe</label>
                    <input
                        type="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        autocomplete="new-password"
                    >
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <div class="form-text">Laisse vide si tu ne veux pas changer ton mot de passe.</div>
                </div>
                {{-- CONFIRMATION --}}
                <div class="input-group">
                    <label class="form-label">Confirmer le nouveau mot de passe</label>
                    <input
                        type="password"
                        name="password_confirmation"
                        class="form-control"
                        autocomplete="new-password"
                    >
                </div>
                <br>
                <div class="actions">
                    <button class="contact-btn" type="submit">
                        Enregistrer
                    </button>
                    <button href="{{ route('profile.compte') }}" class="contact-btn">
                        Annuler
                    </button>
                </div>
            </form>
            </section>
        </div>
    </main>    
</body>
</html>