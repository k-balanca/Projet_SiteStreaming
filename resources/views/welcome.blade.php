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
        <div class="scroll-indicator">→</div>
    </section>

    <section class="movie-row">
        <h2>Films d'action</h2>
        <div class="movie-grid">
            <?php afficherFilms("action"); ?>
        </div>
        <div class="scroll-indicator">→</div>
    </section>

    <section class="movie-row">
        <h2>Films d'horreur</h2>
        <div class="movie-grid">
            <?php afficherFilms("horror"); ?>
        </div>
        <div class="scroll-indicator">→</div>
    </section>

    <section class="movie-row">
        <h2>Films de comédie</h2>
        <div class="movie-grid">
            <?php afficherFilms("comedy"); ?>
        </div>
        <div class="scroll-indicator">→</div>
    </section>

    <section class="movie-row">
        <h2>Films populaires</h2>
        <div class="movie-grid">
            <?php afficherFilms("popular"); ?>
        </div>
        <div class="scroll-indicator">→</div>
    </section>

</section>

    @include('footer')

    <!-- Modal -->
    <div id="movieModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="movieDetails">
                <!-- Movie details will be loaded here -->
            </div>
        </div>
    </div>


    <script>
        function showMovieDetails(element) {
            var imdbid = element.getAttribute('data-imdbid');
            fetch('/movie/' + imdbid)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('HTTP error ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    var details = document.getElementById('movieDetails');
                    var poster = data.Poster !== 'N/A' ? data.Poster : 'https://via.placeholder.com/300x450';
                    details.innerHTML = `
                    <div class="movie-content">
                        <img src="${poster}" alt="${data.Title}" style="width: 300px; border-radius: 8px;">

                        <div class="movie-info">

                            <h1>${data.Title} (${data.Year})</h1>
                            <p><strong>Genre :</strong> ${data.Genre}</p>
                            <p><strong>Auteur :</strong> ${data.Director}</p>
                            <p><strong>Acteur :</strong> ${data.Actors}</p>
                            <p><strong>description :</strong> ${data.Plot}</p>

                            <div style="margin-top: 30%;">

                            <button class="bouton" onclick="likeMovie('${imdbid}')">Liker</button>
                            <button class="bouton" onclick="watch('${imdbid}')">Regarder maintenant</button>

                            </div>
                        </div>
                        </div>
                    `;
                    document.getElementById('movieModal').style.display = 'block';
                })
                .catch(error => {
                    console.error('Error fetching movie details:', error);
                });
        }

        function likeMovie(imdbid) {
            alert('Film ajouté aux favoris: ' + imdbid);
        }

        document.querySelector('.close').onclick = function() {
            document.getElementById('movieModal').style.display = 'none';
        }

        window.onclick = function(event) {
            var modal = document.getElementById('movieModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }

        // Fonction pour vérifier et afficher les indicateurs de scroll
        function checkOverflow() {
            const grids = document.querySelectorAll('.movie-grid');
            grids.forEach(grid => {
                const indicator = grid.nextElementSibling;
                if (indicator && indicator.classList.contains('scroll-indicator')) {
                    if (grid.scrollWidth > grid.clientWidth) {
                        indicator.classList.add('show');
                    } else {
                        indicator.classList.remove('show');
                    }
                }
            });
        }

        const csrfToken = '{{ csrf_token() }}';

    function likeMovie(imdbid) {
        fetch('{{ route("like.movie") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ imdbid })
        })
        .then(r => r.json())
        .then(data => {
            if (data.status === 'ok') {
                alert('Ajouté aux favoris');
            } else {
                alert('Erreur: ' + (data.message || ''));
            }
        })
        .catch(err => {
            console.error(err);
            alert('Erreur de connexion');
        });
    }

        // Vérifier au chargement de la page et au redimensionnement
        window.addEventListener('load', checkOverflow);
        window.addEventListener('resize', checkOverflow);
    </script>

</body>
</html>


