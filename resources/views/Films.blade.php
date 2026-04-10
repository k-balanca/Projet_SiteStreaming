<?php include(base_path('config/get_api.php')); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>HYPER - Streaming</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="body">

    @include('header')

    <main class="movies" style="padding-top: 120px;">
        <section class="movie-row">
            <h2>Barre de recherche</h2>

            <div class="search-container">
                <input type="text" id="searchInput" placeholder="Rechercher un film...">
                <button id="clearSearch">✕</button>
            </div>
            
            <h2>Top Films</h2>
            
            <button class="scroll-left" data-target="movieGrid1">&lt;</button>
            <div id="movieGrid1" class="movie-grid">
                <?php afficherTousLesFilms('new', 1); ?>
            </div>
            <button class="scroll-right" data-target="movieGrid1">&gt;</button>
            
            <button class="scroll-left" data-target="movieGrid2">&lt;</button>
            <div id="movieGrid2" class="movie-grid">
                <?php afficherTousLesFilms('ara', 1); ?>
            </div>
            <button class="scroll-right" data-target="movieGrid2">&gt;</button>


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
    let currentQuery = '';
    const movieGrid1 = document.getElementById('movieGrid1');
    const movieGrid2 = document.getElementById('movieGrid2');
    const searchInput = document.getElementById('searchInput');
    const clearBtn = document.getElementById('clearSearch');
    const loadMoreBtn = document.getElementById('loadMoreBtn');

    const initialMovieGrid1 = movieGrid1.innerHTML;
    const initialMovieGrid2 = movieGrid2.innerHTML;

    function renderCards(items, targetGrid) {
        if (!items || !Array.isArray(items)) return;
        const charles = items.filter(movie => movie.Poster !== 'N/A').map(movie => {
            return `
                    <div class="card" data-imdbid="${movie.imdbID}" onclick="showMovieDetails(this)">
                        <div class="poster-container">
                            <img src="${movie.Poster}" alt="${movie.Title}">
                            <span class="badge">New Added</span>
                        </div>
                        <p class="movie-title">${movie.Title}</p>
                    </div>
                `;
        }).join('');
        targetGrid.insertAdjacentHTML('beforeend', charles);
    }


    function fetchMovies(query, page = 1, append = false) {
        fetch(`/api/movies?query=${encodeURIComponent(query)}&page=${page}&type=movie`)
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    movieGrid1.innerHTML = `<p style="grid-column: 1/-1; text-align:center; color:#ff7373;">${data.message}</p>`;
                    return;
                }

                if (!append) {
                    movieGrid1.innerHTML = '';
                }

                if (!data.movies || data.movies.length === 0) {
                    movieGrid1.innerHTML = '<p style="grid-column: 1/-1; text-align:center; color:#aaa;">Aucun film trouvé.</p>';
                    return;
                }

                renderCards(data.movies, movieGrid1);
            })
            .catch(error => {
                console.error('Erreur API :', error);
                movieGrid1.innerHTML = '<p style="grid-column: 1/-1; text-align:center; color:#ff0000;">Erreur de chargement</p>';
            });
    }

    function resetToInitialGrid() {
        movieGrid1.innerHTML = initialMovieGrid1;
        movieGrid2.innerHTML = initialMovieGrid2;
        currentQuery = '';
        currentPage = 1;
    }

    searchInput.addEventListener('input', function () {
        const query = this.value.trim();
        if (query.length >= 2) {
            currentQuery = query;
            currentPage = 1;
            fetchMovies(currentQuery, currentPage, false);
        } else {
            resetToInitialGrid();
        }
    });

    clearBtn.addEventListener('click', function () {
        searchInput.value = '';
        resetToInitialGrid();
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

    // Gestion des boutons de navigation
    document.querySelectorAll('.scroll-left').forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const grid = document.getElementById(targetId);
            grid.scrollBy({ left: -300, behavior: 'smooth' });
        });
    });

    document.querySelectorAll('.scroll-right').forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const grid = document.getElementById(targetId);
            grid.scrollBy({ left: 300, behavior: 'smooth' });
        });
    });
</script>
