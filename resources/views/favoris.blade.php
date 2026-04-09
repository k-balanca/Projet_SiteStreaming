<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Favoris - HYPER Streaming</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="body">

@include('header')

<main class="movies" style="padding-top: 120px;">
    <section class="movie-row">
        <h2>Favoris</h2>
        <div class="movie-grid">
            @forelse($favorites as $movie)
                <article class="movie-card">
                    <img src="{{ $movie['Poster'] != 'N/A' ? $movie['Poster'] : 'https://via.placeholder.com/200x300' }}" alt="{{ $movie['Title'] }}">
                    <h3>{{ $movie['Title'] }}</h3>
                    <p>{{ $movie['Year'] }}</p>
                    <button class="bouton" onclick="unlikeMovie('{{ $movie['imdbID'] }}')">Disliker</button>
                </article>
            @empty
                <p>Vous n'avez pas encore de favoris.</p>
            @endforelse
        </div>
    </section>
</main>

@include('footer')

<script>
    const csrfToken = '{{ csrf_token() }}';

    function unlikeMovie(imdbid) {
        fetch('{{ route("unlike.movie") }}', {
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
                alert('Film retiré des favoris');
                window.location.reload();
            } else {
                alert('Erreur: ' + (data.message || 'Impossible de retirer le favori'));
            }
        })
        .catch(() => {
            alert('Erreur réseau');
        });
    }
</script>

</body>
</html>






