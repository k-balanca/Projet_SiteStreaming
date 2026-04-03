
@if($errors->any())
    <div style="color:red;">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif



<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('css/style2.css') }}">
        <title>Page de connexion</title>
    </head>
    <body>
        <br>
        <br>
        <h1 class="text-light">Inscription</h1>
        <br>
        <br>
        <br>
        <div class="container d-flex justify-content-center">
            <form style="width: 500px;" method="POST" action="/inscription" class="flex-column align-items-center">
                 @csrf
                <div class="form-group">
                    <label class="text-light">Nom : </label>
                    <input type="text" class="form-control" name="name" placeholder="Entrez votre nom">
                </div>
                <div class="form-group">
                    <label class="text-light">Email : </label>
                    <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Entrer votre email">
                </div>
                <div class="form-group">
                    <label  class="text-light">Mot de passe : </label>
                    <input type="password" class="form-control" name="password" placeholder="Entrer un mot de passe">
                </div>
                <br>
                <button type="submit" class="btn btn-danger col-8 d-block mx-auto" >S'inscrire</button>  
                <br>
                <a href="{{ route('connexion') }}" class="col-6 d-block mx-auto">Cliquez ici pour se connecter</a>
            </form> 
        </div>
    </body>
</html>