<?php
if (!function_exists('afficherFilms')) {
function afficherFilms($recherche) {
    $apiKey = "738abeff";
    $url = "https://www.omdbapi.com/?apikey=" . $apiKey . "&s=" . urlencode($recherche);
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
        return;
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
        $errorMsg = isset($data['Error']) ? $data['Error'] : "Inconnu";
        echo "<p>Erreur API pour '$recherche' : " . htmlspecialchars($errorMsg) . "</p>";
    }
}
}