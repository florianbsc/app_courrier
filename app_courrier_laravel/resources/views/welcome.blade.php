@extends('layout.app')
@section('title', 'Accueil')

@section('contenu')
    <div class="container-fluid text-center">
        <div class="welcome-container">
            <h2>Bienvenue {{auth()->user()->prenom_user}},  dans votre espace de gestion de courrier</h2>
            <img src="{{asset('images/gif2.gif')}}" alt="Your Image" class="welcome-image">
        </div>
    </div>
@endsection