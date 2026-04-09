<?php include(base_path('config/get_api.php')); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Séries - HYPER Streaming</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="body">

    @include('header')

    <main class="movies" style="padding-top: 120px;">
        <section class="movie-row">
            <h2>Barre de recherche</h2>

            <div class="search-container">
                <input type="text" id="searchInput" placeholder="Rechercher une série...">
                <button id="clearSearch">✕</button>
            </div>

            <h2>Top Séries</h2>

            <div id="movieGrid1" class="movie-grid">
                <?php afficherToutesLesSeries('orange', 1); ?>
            </div>
            <div class="scroll-indicator">→</div>

            <div id="movieGrid2" class="movie-grid">
                <?php afficherToutesLesSeries('noir', 1); ?>
            </div>
            <div class="scroll-indicator">→</div>

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
    let currentQuery = 'orange'; // Correspond au query PHP initial
    const movieGrid1 = document.getElementById('movieGrid1');
    const movieGrid2 = document.getElementById('movieGrid2');
    const searchInput = document.getElementById('searchInput');
    const clearBtn = document.getElementById('clearSearch');
    const loadMoreBtn = document.getElementById('loadMoreBtn');

    function renderCards(items) {
        if (!items || !Array.isArray(items)) return;
        const cards = items.map(series => {
            const poster = series.Poster !== 'N/A' ? series.Poster : 'https://via.placeholder.com/300x450';
            return `
                <div class="card" data-imdbid="${series.imdbID}" onclick="showMovieDetails(this)">
                    <div class="poster-container">
                        <img src="${poster}" alt="${series.Title}">
                        <span class="badge">New Added</span>
                    </div>
                    <p class="movie-title">${series.Title}</p>
                </div>
            `;
        }).join('');

        movieGrid1.insertAdjacentHTML('beforeend', cards);
        
        // Vérifier si le contenu dépasse et afficher l'indicateur
        checkOverflow(movieGrid1);
    }

    function checkOverflow(grid) {
        const indicator = grid.nextElementSibling;
        if (indicator && indicator.classList.contains('scroll-indicator')) {
            if (grid.scrollWidth > grid.clientWidth) {
                indicator.classList.add('show');
            } else {
                indicator.classList.remove('show');
            }
        }
    }

    function fetchSeries(query, page = 1, append = false) {
        fetch(`/api/movies?query=${encodeURIComponent(query)}&page=${page}&type=series`)
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
                    movieGrid1.innerHTML = '<p style="grid-column: 1/-1; text-align:center; color:#aaa;">Aucune série trouvée.</p>';
                    return;
                }

                renderCards(data.movies);
            })
            .catch(error => {
                console.error('Erreur API :', error);
                movieGrid1.innerHTML = '<p style="grid-column: 1/-1; text-align:center; color:#ff0000;">Erreur de chargement</p>';
            });
    }

    searchInput.addEventListener('input', function () {
        const query = this.value.trim();
        if (query.length >= 2) {
            currentQuery = query;
            currentPage = 1;
            fetchSeries(currentQuery, currentPage, false);
        } else if (query.length === 0) {
            currentQuery = 'orange';
            currentPage = 1;
            movieGrid1.innerHTML = '';
            fetchSeries('orange', 1, false); // recharge la grille 1
        }
    });

    clearBtn.addEventListener('click', function () {
        searchInput.value = '';
        currentQuery = 'orange';
        currentPage = 1;
        movieGrid1.innerHTML = '';
        fetchSeries('orange', 1, false);
    });

    loadMoreBtn.addEventListener('click', function () {
        currentPage += 1;
        fetchSeries(currentQuery, currentPage, true);
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

    // Vérifier le scroll au chargement initial
    checkOverflow(movieGrid1);
    checkOverflow(movieGrid2);
</script>