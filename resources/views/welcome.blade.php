<?php include(base_path('config/get_api.php')); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>HYPER - Streaming</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="body1">

    <header>
        <div class="logo">HYPER</div>
        <nav style ="margin-right: 30%; gap = 10px">
            <ul>
                <li><a href="{{ route('welcome') }}">Accueil</a></li>
                <li><a href="{{ route('films') }}">Films</a></li>
                <li><a href="{{ route('series') }}">Series</a></li>
                <li><a href="{{ route('favoris') }}">Favoris</a></li>
                <li><a href="{{ route('compte') }}">Mon Compte</a></li>
                <li><a href="{{ route('contact') }}">Contact</a></li>
            </ul>
        </nav>
    </header>


    <section>
        <div style ="margin-top: 500px; margin-left: 100px;">
            <h1 style ="font-size: 100px">San Andreas</h1>
            <p>Alors qu'un séisme vient de frapper, un pilote d'hélicoptère et sa future ex-femme doivent sauver leur fille avant que la terre se mette à trembler</p>
            <div class="buttons">
                <button class="bouton">regarder maintenant</button>
                <button class="bouton">rajouter aux favoris</button>
            </div>
        </div>
    </section>


    <main style ="margin-top: 350px;">


<section class="movies">

    <section class="movie-row">
        <h2>Latest Movies</h2>
        <div class="movie-grid">
            <?php afficherFilms("latest"); ?>
        </div>
    </section>

    <section class="movie-row">
        <h2>Films d'action</h2>
        <div class="movie-grid">
            <?php afficherFilms("action"); ?>
        </div>
    </section>

    <section class="movie-row">
        <h2>Films d'horreur</h2>
        <div class="movie-grid">
            <?php afficherFilms("horror"); ?>
        </div>
    </section>

    <section class="movie-row">
        <h2>Films de comédie</h2>
        <div class="movie-grid">
            <?php afficherFilms("comedy"); ?>
        </div>
    </section>

    <section class="movie-row">
        <h2>Films populaires</h2>
        <div class="movie-grid">
            <?php afficherFilms("popular"); ?>
        </div>
    </section>

</section>

    @include('footer')


    </main>

</body>
</html>


