<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <title>Page de connexion</title>
    </head>
    <body>
        <h1 class="text-light">Connexion</h1>
        <br>
        <br>
        <br>
        <div class="col-md-6 offset-md-3">
            <form action="traitement_login.php" method="post">
                <div class="form-group">
                    <label class="text-light">Email : </label>
                    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Entrer votre mail">
                </div>
                <div class="form-group">
                    <label  class="text-light" >Password : </label>
                    <input type="password" class="form-control" id="password" placeholder="Mot de passe">
                </div>
                <button type="submit" class="btn btn-danger">Valider</button>
                <h6 class="text-light">Cliquez ici pour s'inscrire</h6>
            </form>
        </div>
    </body>
</html>