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
            <section class="profile-panel">
                <h2>Mon compte</h2>
                <div class="profile-avatar">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&size=100" alt="Photo profil">
                </div>
                <h3>{{ Auth::user()->name }}</h3>
                <p>{{ Auth::user()->email }}</p>
                <div class="profile-details">
                    <p><strong>ID :</strong> {{ Auth::user()->id }}</p>
                    <p><strong>Compte créé :</strong> {{ Auth::user()->created_at }}</p>
                </div>
                <div class="profile-actions">
                    <a href="{{ route('profile.edit') }}" class="bouton">Modifier le profil</a>
                    @if(Auth::user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="bouton admin-btn">Accéder à l'espace admin</a>
                    @endif
                </div>
            </section>

        </div>
    </main>

    @include('footer')

</body>
</html>