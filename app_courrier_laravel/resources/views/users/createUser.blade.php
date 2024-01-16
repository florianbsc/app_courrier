@extends('layout.app')
@section('title', 'Ajouter Utilisateur')
@section('contenu')

<h5>new user</h5>

<div class="card shadow border-0 mb-7">
    <div class="table-responsive">
        <form methode='POST' action = "{{route('creation_user')}}">
        @csrf
            <label for="nom_user" name="nom_user"></label>
            <input type="text" name="nom_user" placeholder="Nom">

            <label for="prenom_user" name="prenom_user"></label>
            <input type="text" name="prenom_user" placeholder="Prénom">

            <label for="mail_user" name="mail_user"></label>
            <input type="text" name="mail_user" placeholder="Mail">

            <label for="mdp_user" name="mdp_user"></label>
            <input type="text" name="mdp_user" placeholder="Mot de passe">

            <label for="privilege_user" name="privilege_user"></label>
            <input type="number" name="privilege_user" placeholder="privilege_user">

            <button type="submit">Envoyer</button>

        </form>
    </div>
</div>
@stop