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
    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <main class="account-section">
        <div class="account-wrapper">
           <section class="contact-section">
           <h1>Modification du profil</h1>
           <form action="{{ route('profile.update') }}" method="POST" class="contact-form">
                @csrf
                <div class="input-group">
                    <label>Nom</label>
                    <input type="text" name="name" value="{{ $user->name }}">
                </div>
                <div class="input-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ $user->email }}">
                </div>
                <br>
                <br>
                <div class="input-group">
                    <label>Mot de passe actuel</label>
                    <input type="password" name="current_password">
                </div>
                <div class="input-group">
                    <label>Nouveau mot de passe</label>
                    <input type="password" name="password">

                    <label>Confirmer mot de passe</label>
                    <input type="password" name="password_confirmation">
                </div>
                <br>
                <div class="btn-group">
                    <button type="submit" class="contact-btn" href="{{ route('profile.update')}}">
                        Enregistrer
                    </button>

                    <button href="{{ route('compte') }}" class="contact-btn cancel-btn">
                        Annuler
                    </button>
                </div>
            </form>
            </section>
        </div>
    </main>    
</body>
</html>
