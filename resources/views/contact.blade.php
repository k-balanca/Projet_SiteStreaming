<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>HYPER - Streaming</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
     @include('header')
<section class="contact-section">

    <h1>Contactez-nous</h1>
    <p>Une question ? Envoyez-nous un message.</p>

<form class="contact-form" action="contact.php" method="POST">

    <div class="input-group">
        <label>Nom</label>
        <input type="text" name="nom" placeholder="Votre nom" required>
    </div>

    <div class="input-group">
        <label>Email</label>
        <input type="email" name="email" placeholder="Votre email" required>
    </div>

    <div class="input-group">
        <label>Message</label>
        <textarea name="message" placeholder="Votre message..." required></textarea>
    </div>

    <button type="submit" class="contact-btn">Envoyer</button>

</form>

</section>

</body>
</html>