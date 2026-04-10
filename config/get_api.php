<?php

if (!function_exists('fetchMoviesFromOmdb')) {
function fetchMoviesFromOmdb($query, $type = 'movie', $page = 1) {
    $apiKey = "738abeff";
    $cacheDir = __DIR__ . '/../storage/cache/';
    $cacheFile = $cacheDir . md5($query . '|' . $type . '|' . $page) . '.json';
    $cacheTime = 3600;

    if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < $cacheTime) {
        $response = file_get_contents($cacheFile);
    } else {
        $url = "https://www.omdbapi.com/?apikey=" . $apiKey . "&s=" . urlencode($query) . "&type=" . urlencode($type) . "&page=" . intval($page);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Erreur cURL : ' . curl_error($ch);
            curl_close($ch);
            return ['Search' => [], 'totalResults' => 0, 'Error' => 'Erreur cURL : ' . curl_error($ch)];
        }

        curl_close($ch);

        if (!is_dir($cacheDir)) {
            mkdir($cacheDir, 0755, true);
        }

        file_put_contents($cacheFile, $response);
    }

    $data = json_decode($response, true);

    if (isset($data['Error']) && $data['Error'] === 'Too many results.') {
        return ['Search' => [], 'totalResults' => 0, 'Error' => 'Trop de résultats, utilisez la barre de recherche ou cliquez sur Afficher +.'];
    }

    if (isset($data['Search']) && isset($data['totalResults'])) {
        $data['totalResults'] = intval($data['totalResults']);
    }

    return $data;
}
}

//

if (!function_exists('renderMovieCards')) {
function renderMovieCards($items) {
    if (!isset($items['Search']) || !is_array($items['Search'])) {
        $errorMsg = isset($items['Error']) ? $items['Error'] : 'Inconnu';
        echo '<p>Erreur API : ' . htmlspecialchars($errorMsg) . '</p>';
        return;
    }

    foreach ($items['Search'] as $movie) {
        if ($movie['Poster'] === 'N/A') {
            continue; // Skip movies without posters
        }
        $poster = $movie['Poster'];
        ?>
        <div class="card" data-imdbid="<?php echo htmlspecialchars($movie['imdbID']); ?>" onclick="showMovieDetails(this)">
            <div class="poster-container">
                <img src="<?php echo $poster; ?>" alt="<?php echo htmlspecialchars($movie['Title']); ?>">
                <span class="badge">New Added</span>
            </div>
            <p class="movie-title"><?php echo htmlspecialchars($movie['Title']); ?></p>
        </div>
        <?php
    }
}
}

// listing de la page films

if (!function_exists('afficherTousLesFilms')) {
    function afficherTousLesFilms($query = 'a', $page = 1, $limit = 10) {
        $result = fetchMoviesFromOmdb($query, 'movie', $page);

        if (isset($result['Error']) && !empty($result['Error'])) {
            echo '<p style="grid-column: 1 / -1; text-align: center; color: #ffcccc;">' . htmlspecialchars($result['Error']) . '</p>';
            return;
        }

        // Limiter le nombre de films affichés
        if (isset($result['Search']) && is_array($result['Search'])) {
            $result['Search'] = array_slice($result['Search'], 0, $limit);
        }

        renderMovieCards($result);
    }
}

// listing de la page séries

if (!function_exists('afficherToutesLesSeries')) {
function afficherToutesLesSeries($query = 'a', $page = 1, $limit = 10) {
    $result = fetchMoviesFromOmdb($query, 'series', $page);
    if (isset($result['Error']) && !empty($result['Error'])) {
        echo '<p style="grid-column: 1 / -1; text-align: center; color: #ffcccc;">' . htmlspecialchars($result['Error']) . '</p>';
        return;
    }

    // Limiter le nombre de séries affichées
    if (isset($result['Search']) && is_array($result['Search'])) {
        $result['Search'] = array_slice($result['Search'], 0, $limit);
    }

    renderMovieCards($result);
}




// listing de la page accueil (films et séries mélangés)

}

if (!function_exists('afficherFilms')) {
function afficherFilms($recherche, $page = 1) {
    $result = fetchMoviesFromOmdb($recherche, 'movie', $page);
    if (isset($result['Error']) && !empty($result['Error'])) {
        echo '<p style="grid-column: 1 / -1; text-align: center; color: #ffcccc;">' . htmlspecialchars($result['Error']) . '</p>';
        return;
    }
    renderMovieCards($result);
}
}

// details d'un film 

if (!function_exists('getMovieDetails')) {
function getMovieDetails($imdbid) {

    $apiKey = "738abeff";
    $cacheDir = __DIR__ . '/../storage/cache/';
    $cacheFile = $cacheDir . 'details_' . md5($imdbid) . '.json';
    $cacheTime = 3600;

    if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < $cacheTime) {
        $response = file_get_contents($cacheFile);
    } else {

        $url = "https://www.omdbapi.com/?apikey=".$apiKey."&i=".urlencode($imdbid);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            curl_close($ch);
            return null;
        }

        curl_close($ch);

        if (!is_dir($cacheDir)) {
            mkdir($cacheDir, 0755, true);
        }

        file_put_contents($cacheFile, $response);
    }

    return json_decode($response, true);
}
}

// fonction recherche film

if (!function_exists('afficherFilmsAlphabet')) {
function afficherFilmsAlphabet($lettres = null, $maxPagesParLettre = 2) {

    $apiKey = "738abeff";

    if ($lettres === null) {
        $lettres = range('a', 'z');
    }

    foreach ($lettres as $letter) {

        for ($page = 1; $page <= $maxPagesParLettre; $page++) {

            $url = "https://www.omdbapi.com/?apikey=$apiKey&s=".urlencode($letter)."&type=movie&page=".$page;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                echo 'Erreur cURL : '.curl_error($ch);
                curl_close($ch);
                continue 2;
            }

            curl_close($ch);

            $data = json_decode($response, true);

            if (isset($data['Search']) && is_array($data['Search'])) {

                foreach ($data['Search'] as $movie) {

                    $poster = ($movie['Poster'] !== 'N/A') ? $movie['Poster'] : 'https://via.placeholder.com/300x450';

                    ?>
                    <div class="card">
                        <div class="poster-container">
                            <img src="<?php echo $poster; ?>" alt="<?php echo htmlspecialchars($movie['Title']); ?>">
                            <span class="badge">New Added</span>
                        </div>
                        <p class="movie-title"><?php echo htmlspecialchars($movie['Title']); ?></p>
                    </div>
                    <?php

                }

            } else {

                if (isset($data['Error']) && $data['Error'] === 'Too many results.') {
                    break;
                }

            }

        }

    }

}
}


if (!function_exists('rechercherSeries')) {
    function rechercherSeries($query, $page = 1, $limit = 10) {
        $apiKey = "738abeff";

        // Préparer la requête OMDb pour les séries uniquement
        $url = "https://www.omdbapi.com/?apikey=$apiKey&s=" . urlencode($query) . "&type=series&page=" . intval($page);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo '<p>Erreur cURL : ' . curl_error($ch) . '</p>';
            curl_close($ch);
            return;
        }

        curl_close($ch);

        $data = json_decode($response, true);

        if (isset($data['Error']) && $data['Error'] === 'Too many results.') {
            echo '<p style="color:red;">Trop de résultats, veuillez préciser votre recherche.</p>';
            return;
        }

        if (!isset($data['Search']) || !is_array($data['Search'])) {
            echo '<p style="color:red;">Aucune série trouvée pour "<strong>' . htmlspecialchars($query) . '</strong>".</p>';
            return;
        }

        // Limiter l'affichage à $limit résultats
        $results = array_slice($data['Search'], 0, $limit);

        foreach ($results as $series) {
            $poster = ($series['Poster'] !== 'N/A') ? $series['Poster'] : 'https://via.placeholder.com/300x450';
            ?>
            <div class="card">
                <div class="poster-container">
                    <img src="<?php echo $poster; ?>" alt="<?php echo htmlspecialchars($series['Title']); ?>">
                    <span class="badge">New Added</span>
                </div>
                <p class="movie-title"><?php echo htmlspecialchars($series['Title']); ?></p>
            </div>
            <?php
        }
    }
}