@extends('layout.app')
@section('title', 'Ajouter Utilisateur')
@section('contenu')

<form methode='GET' action = "{{route('creation_user')}}">
@csrf
    <label for="nom_user" name="nom_user">nom</label>
    <input type="text" name="nom_user" placeholder="nom">

    <label for="prenom_user" name="prenom_user"></label>
    <input type="text" name="prenom_user" placeholder="prenom">

    <label for="mail_user" name="mail_user"></label>
    <input type="text" name="mail_user" placeholder="mail">

    <label for="mdp_user" name="mdp_user">mdp</label>
    <input type="text" name="mdp_user" placeholder="mdp">

    <label for="privilege_user" name="privilege_user">nom</label>
    <input type="text" name="privilege_user" placeholder="privilege_user">

    <button type="submit">Envoyer</button>


    </form>

    @stop