<?php

if (!function_exists('afficherFilms')) {
function afficherFilms($recherche) {

    $apiKey = "738abeff";
    $cacheDir = __DIR__ . '/../storage/cache/';
    $cacheFile = $cacheDir . md5($recherche) . '.json';
    $cacheTime = 3600;

    if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < $cacheTime) {
        $response = file_get_contents($cacheFile);
    } else {

        $url = "https://www.omdbapi.com/?apikey=".$apiKey."&s=".urlencode($recherche);

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
            return;
        }

        curl_close($ch);

        if (!is_dir($cacheDir)) {
            mkdir($cacheDir, 0755, true);
        }

        file_put_contents($cacheFile, $response);
    }

    $data = json_decode($response, true);

    if (isset($data['Search']) && is_array($data['Search'])) {

        foreach ($data['Search'] as $movie) {

            $poster = ($movie['Poster'] !== 'N/A') ? $movie['Poster'] : 'https://via.placeholder.com/300x450';

            ?>
            <div class="card" data-imdbid="<?php echo $movie['imdbID']; ?>" onclick="showMovieDetails(this)">
                <div class="poster-container">
                    <img src="<?php echo $poster; ?>" alt="<?php echo htmlspecialchars($movie['Title']); ?>">
                    <span class="badge">New Added</span>
                </div>
                <p class="movie-title"><?php echo htmlspecialchars($movie['Title']); ?></p>
            </div>
            <?php

        }

    } else {

        $errorMsg = isset($data['Error']) ? $data['Error'] : "Inconnu";
        echo "<p>Erreur API pour '".htmlspecialchars($recherche)."' : ".htmlspecialchars($errorMsg)."</p>";

    }

}
}


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