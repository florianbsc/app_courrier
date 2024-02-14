<!-- Ajoute le titre de la page -->
@extends('layout.app')
@section('title', 'Nouveau Utilisateur')

<!-- Section de la barre de navigation -->
@section('nav')
    <h1 class="h2 mb-0 ls-tight"> Nouveau Utilisateur</h1>

    <!-- Onglets de navigation -->
    <ul class="nav nav-tabs mt-4 overflow-x border-0">
        <li class="nav-item">
            <a href="{{route('liste_users')}}" class="nav-link font-regular">Liste</a>
        </li>
        <li class="nav-item">
            <a href="{{route('creation_user')}}" class="nav-link active">Ajouter</a>
        </li>
    </ul>
@endsection

<!-- Contenu de la page -->
@section('contenu')
    <!-- Affiche les messages d'erreur de validation -->
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="container-fluid">
 <!-- Formulaire d'ajout d'utilisateur -->
    <div class="card shadow border-0 mb-7">
        <div class="table-responsive">
            <form method='post' action = "{{route('creation_user')}}">
                @csrf
                <label for="nom_user" name="nom_user">Utilisateur</label>
                <input type="text" name="nom_user" placeholder="Nom" value="{{ old('nom_user') }}" autofocus required>

                <label for="prenom_user" name="prenom_user"></label>
                <input type="text" name="prenom_user" placeholder="Prénom" value="{{ old('prenom_user') }}" required>

                <label for="mail_user" name="mail_user"></label>
                <input type="mail" name="mail_user" placeholder="Mail" value="{{ old('mail_user') }}" required>

                <label for="password" name="password"></label>
                <input type="text" name="password" placeholder="Mot de passe de 8 caratères" value="{{ old('password') }}" required>

                <label for="password_confirmation"></label>
                <input type="password_confirmation" name="password_confirmation" placeholder="Confirmer mot de passe" required >


                <!-- <label for="privilege_user" name="privilege_user"></label>
                <input type="number" name="privilege_user" placeholder="privilege_user"> -->

                <button type="submit">Envoyer</button>
            </form>
        </div>
    </div>
</div>
@endsection