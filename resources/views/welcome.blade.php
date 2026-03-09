<?php include('../config/get_api.php'); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>HYPER - Streaming</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <header>
        <div class="logo">HYPER</div>
        <nav style ="margin-right: 200px;">
            <ul>
                <li>Horreur</li>
                <li>Adventure</li>
                <li>Survie</li>
                <li>Romantique</li>
                <li>fantastique</li>
            </ul>
        </nav>
    </header>


    <section>
        <div style ="margin-top: 500px; margin-left: 100px;">
            <h1 style ="font-size: 100px">San Andreas</h1>
            <p>Alors qu'un séisme vient de frapper, un pilote d'hélicoptère et sa future ex-femme doivent sauver leur fille avant que la terre se mette à trembler</p>
            <div class="buttons">
                <button class="bouton">▶ regarder maintenant</button>
                <button class="bouton">rajouter aux favoris</button>
            </div>
        </div>
    </section>


    <main style ="margin-top: 500px;">


<section class="movie-row">

    <h2>Latest Movies</h2>


    <section class="movie-row">
    <h2>Les films d'action</h2>
    <div class="movie-grid">
        <?php
            afficherFilms("action");
        ?>

    </div>
    </section>

        <section class="movie-row">
    <h2>Les films de horreur</h2>
    <div class="movie-grid">
        <?php
            afficherFilms("horror");
        ?>

    </div>
    </section>


    </main>

</body>
</html>


