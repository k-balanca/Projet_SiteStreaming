<div class="sidebar">
        <div class="logo">HYPER</div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">Se déconnecter</button>
        </form>
        <a href="{{ route('profile.compte') }}" class="logout-btn">Retour à mon compte</a>
</div>