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
            <section class="profile-panel">
                <h2>Mon compte</h2>
               @if(Auth::check())
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&size=100" alt="Photo profil">

                    <h3>{{ Auth::user()->name }}</h3>
                    <p>{{ Auth::user()->email }}</p>
                    <div class="profile-details">
                    <p><strong>ID :</strong> {{ Auth::user()->id }}</p>
                    <p><strong>Compte créé :</strong> {{ Auth::user()->created_at }}</p>
                </div>
                @else
                    <p>Utilisateur non connecté</p>
                @endif

                <a href="{{route('profile.edit')}}" class="bouton">Modifier le profil</a>
            </section>

            <section class="list-panel">
                <h2>Liste des Favoris</h2>
                <p>Votre liste de films favoris apparaîtra ici.</p>
            </section>

            <section class="list-panel">
                <h2>À regarder plus tard</h2>
                <p>Votre watchlist apparaîtra ici.</p>
            </section>
        </div>
    </main>

    @include('footer')

</body>
</html>