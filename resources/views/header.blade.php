    
    
    <header>
        <div class="logo">HYPER</div>
        <nav style ="margin-right: 20%">
            <ul>
                <li><a href="{{ route('welcome') }}">Accueil</a></li>
                <li><a href="{{ route('films') }}">Films</a></li>
                <li><a href="{{ route('series') }}">Series</a></li>
                <li><a href="{{ route('favoris') }}">Favoris</a></li>
                <li><a href="{{ route('compte') }}">Mon Compte</a></li>
                <li><a href="{{ route('contact') }}">Contact</a></li>
            </ul>
        </nav>
        <form action="{{ route('logout') }}" method="POST" class="logout-form">
            @csrf
            <button type="submit" class="logout-btn">Déconnexion</button>
        </form>
    </header>