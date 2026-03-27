<?php include(base_path('config/get_api.php')); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>HYPER - Streaming</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="body1">

    @include('header')

    <main class="movies" style="padding-top: 120px;">
        <section class="movie-row">
            <h2>Tous les films</h2>

            <div class="search-container">
                <input type="text" id="searchInput" placeholder="Rechercher un film...">
                <button id="clearSearch">✕</button>
            </div>

            <div id="movieGrid" class="movie-grid">
                <?php afficherTousLesFilms('a', 1); ?>
            </div>

            <div style="text-align:center; margin-top:20px;">
                <button id="loadMoreBtn" class="bouton">Afficher +</button>
            </div>
        </section>
    </main>

    @include('footer')

</body>

</html>









<script>
    let currentPage = 1;
    let currentQuery = 'a';
    const movieGrid = document.getElementById('movieGrid');
    const searchInput = document.getElementById('searchInput');
    const clearBtn = document.getElementById('clearSearch');
    const loadMoreBtn = document.getElementById('loadMoreBtn');

    function renderCards(items) {
        if (!items || !Array.isArray(items)) return;
        const charles = items.map(movie => {
            const poster = movie.Poster !== 'N/A' ? movie.Poster : 'https://via.placeholder.com/300x450';
            return `
                    <div class="card" data-imdbid="${movie.imdbID}" onclick="showMovieDetails(this)">
                        <div class="poster-container">
                            <img src="${poster}" alt="${movie.Title}">
                            <span class="badge">New Added</span>
                        </div>
                        <p class="movie-title">${movie.Title}</p>
                    </div>
                `;
        }).join('');
        movieGrid.insertAdjacentHTML('beforeend', charles);
    }

    function fetchMovies(query, page = 1, append = false) {
        fetch(`/api/movies?query=${encodeURIComponent(query)}&page=${page}&type=movie`)
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    movieGrid.innerHTML = `<p style="grid-column: 1/-1; text-align:center; color:#ff7373;">${data.message}</p>`;
                    return;
                }

                if (!append) {
                    movieGrid.innerHTML = '';
                }

                if (!data.movies || data.movies.length === 0) {
                    movieGrid.innerHTML = '<p style="grid-column: 1/-1; text-align:center; color:#aaa;">Aucun film trouvé.</p>';
                    return;
                }

                renderCards(data.movies);
            })
            .catch(error => {
                console.error('Erreur API :', error);
                movieGrid.innerHTML = '<p style="grid-column: 1/-1; text-align:center; color:#ff0000;">Erreur de chargement</p>';
            });
    }

    searchInput.addEventListener('input', function () {
        const query = this.value.trim();
        if (query.length >= 2) {
            currentQuery = query;
            currentPage = 1;
            fetchMovies(currentQuery, currentPage, false);
        } else {
            currentQuery = 'a';
            currentPage = 1;
            fetchMovies('a', 1, false);
        }
    });

    clearBtn.addEventListener('click', function () {
        searchInput.value = '';
        currentQuery = 'a';
        currentPage = 1;
        fetchMovies('a', 1, false);
    });

    loadMoreBtn.addEventListener('click', function () {
        currentPage += 1;
        fetchMovies(currentQuery, currentPage, true);
    });

    window.showMovieDetails = function (element) {
        const imdbid = element.getAttribute('data-imdbid');
        fetch(`/movie/${imdbid}`)
            .then(res => res.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                    return;
                }
                const details = `Titre : ${data.Title}\nAnnée : ${data.Year}\nGenre : ${data.Genre}\nRéalisateur : ${data.Director}\nActeurs : ${data.Actors}\nDescription : ${data.Plot}`;
                alert(details);
            })
            .catch(err => console.error('Erreur détails :', err));
    };
</script>
