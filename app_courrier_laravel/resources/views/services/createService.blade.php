@extends('layout.app')
@section('title', 'Ajouter Service')
@section('nav')
<h1 class="h2 mb-0 ls-tight"> Ajouter Service</h1>

        <ul class="nav nav-tabs mt-4 overflow-x border-0">
            <li class="nav-item">
                <a href="{{route('liste_services')}}" class="nav-link font-regular">Liste</a>
            </li>
            <li class="nav-item">
                <a href="{{route('creation_service')}}" class="nav-link active">Ajouter</a>
            </li>
        </ul>
@endsection

<!-- Contenu de la page -->
@section('contenu')
  <!-- Affiche les messages de succes/erreur de validation -->
  <x-alert type="danger" :message="$errors->all()" />
    <x-alert type="success" :message="session('success')" />
    <x-alert type="danger" :message="session('error')" />

<div class="container-fluid">
<div class="card shadow border-0 mb-7">
    <div class="table-responsive">
        <form method="post" action="{{route('creation_service')}}">
            @csrf
            <label for="nom_service">Service</label>
            <input type="text" name="nom_service" placeholder="Nom" value="{{ old('nom_service') }}" required>

            <label for="telephone_service"></label>
            <input type="text" name="telephone_service" placeholder="Téléphone" value="{{ old('telephone_service') }}" >

            <button type="submit">Envoyer</button>
        </form>
    </div>
</div>
</div>


@endsection