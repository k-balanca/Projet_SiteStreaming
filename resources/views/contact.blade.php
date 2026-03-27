
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nom = htmlspecialchars($_POST['nom']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    if (!empty($nom) && !empty($email) && !empty($message)) {

        $to = "yldz.ma60@gmail.com";
        $subject = "Nouveau message de contact";

        $body = "Nom: $nom\n";
        $body .= "Email: $email\n\n";
        $body .= "Message:\n$message";

        $headers = "From: $email";

        if (mail($to, $subject, $body, $headers)) {
            echo "<p style='color:green;text-align:center;'>Message envoyé avec succès !</p>";
        } else {
            echo "<p style='color:red;text-align:center;'>Erreur lors de l'envoi.</p>";
        }

    } else {
        echo "<p style='color:red;text-align:center;'>Tous les champs sont requis.</p>";
    }
}

?>

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

    @if ($errors->any())
        <div style="color: red; text-align: center;">
            <ul style="list-style: none;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <p style="color: green; text-align: center;">{{ session('success') }}</p>
    @endif

    @if (session('error'))
        <p style="color: red; text-align: center;">{{ session('error') }}</p>
    @endif

<form class="contact-form" action="{{ route('contact.store') }}" method="POST">
    @csrf

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

    <button type="submit" name="envoyer" class="contact-btn">Envoyer</button>

</form>

</section>

</body>
</html>