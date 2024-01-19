@extends('layout.app')
@section('title', 'Ajouter Utilisateur')
@section('contenu')

<h1 class="h2 mb-0 ls-tight">Ajouter Utilisateur</h1>

<div class="card shadow border-0 mb-7">
    <div class="table-responsive">
        <form method='post' action = "{{route('creation_user')}}">
            @csrf
            <label for="nom_user" name="nom_user">Utilisateur</label>
            <input type="text" name="nom_user" placeholder="Nom" required>

            <label for="prenom_user" name="prenom_user"></label>
            <input type="text" name="prenom_user" placeholder="Prénom" required>

            <label for="mail_user" name="mail_user"></label>
            <input type="mail" name="mail_user" placeholder="Mail" required>

            <label for="mdp_user" name="mdp_user"></label>
            <input type="text" name="mdp_user" placeholder="Mot de passe" required>

            <!-- <label for="privilege_user" name="privilege_user"></label>
            <input type="number" name="privilege_user" placeholder="privilege_user"> -->

            <button type="submit">Envoyer</button>
        </form>
    </div>
</div>
@stop