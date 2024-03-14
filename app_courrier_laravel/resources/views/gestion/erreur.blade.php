<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Erreur</title>
    </head>
    <body>
        <h1>Vous ne pouvez accèder à cette page</h1>

        <img style="padding: 5% 10%" src="{{asset('images/nop.gif')}}" alt="Your Image" class="welcome-image"><br>

        <button ><a href="{{ route('accueil') }}">home</a></button><br>
    </body>
</html>