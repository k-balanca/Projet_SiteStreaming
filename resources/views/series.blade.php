<?php include(base_path('config/get_api.php')); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Séries - HYPER Streaming</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="body1">

    @include('header')

    <main class="movies">
        <section class="movie-row">
            <h2>Top Séries</h2>
            <div class="movie-grid">
                <?php afficherToutesLesSeries('a'); ?>
            </div>
        </section>

        <section class="movie-row">
            <h2>Séries d'Action</h2>
            <div class="movie-grid">
                <?php afficherToutesLesSeries('action'); ?>
            </div>
        </section>

    </main>

    @include('footer')

</body>
</html>
