<?php include(base_path('config/get_api.php')); ?>

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
        <nav style="margin-right: 30%; gap = 10px">
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

    <section class="movie-row">
    <h2>Tous les films</h2>
    

    <div class="search-container">
        <input type="text" id="searchInput" placeholder="Rechercher un film...">
        <button id="clearSearch">✕</button>
    </div>
    
    <div id="movieGrid" class="movie-grid">
        <?php afficherTousLesFilms(); ?>
    </div>
</section>

    <main style="margin-top: 150px;">
        <section class="movie-row">
            <h2>Tous les films</h2>
            <div class="movie-grid">
                <?php afficherTousLesFilms(); ?>
            </div>
        </section>
    </main>

    @include('footer')

</body>

</html>









<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const clearBtn = document.getElementById('clearSearch');
    const movieGrid = document.getElementById('movieGrid');

    searchInput.addEventListener('input', function() {
        const query = this.value.trim();
        if (query.length >= 2) {
            searchMovies(query);
        } else {
            // Restaure tous les films
            movieGrid.innerHTML = '<?php ob_start(); afficherTousLesFilms(); $output = ob_get_clean(); echo addslashes($output); ?>';
        }
    });

    clearBtn.addEventListener('click', function() {
        searchInput.value = '';
        movieGrid.innerHTML = '<?php ob_start(); afficherTousLesFilms(); $output = ob_get_clean(); echo addslashes($output); ?>';
    });

    function searchMovies(query) {
        const apiKey = '738abeff';
        const url = `https://www.omdbapi.com/?apikey=${apiKey}&s=${encodeURIComponent(query)}&type=movie`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.Search && data.Search.length > 0) {
                    movieGrid.innerHTML = data.Search.map(movie => `
                        <div class="card">
                            <div class="poster-container">
                                <img src="${movie.Poster !== 'N/A' ? movie.Poster : 'https://via.placeholder.com/300x450'}" alt="${movie.Title}">
                                <span class="badge">New Added</span>
                            </div>
                            <p class="movie-title">${movie.Title}</p>
                        </div>
                    `).join('');
                } else {
                    movieGrid.innerHTML = '<p style="grid-column: 1/-1; text-align: center; color: #aaa;">Aucun film trouvé pour "' + query + '"</p>';
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                movieGrid.innerHTML = '<p style="grid-column: 1/-1; text-align: center; color: #ff0000;">Erreur de recherche</p>';
            });
    }
});
</script>
