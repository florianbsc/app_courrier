@extends('layout.app')
@section('title', 'Modifier Service')
@section('nav')
<h1 class="h2 mb-0 ls-tight"> Modifier Service</h1>

        <ul class="nav nav-tabs mt-4 overflow-x border-0">
            <li class="nav-item">
                <a href="{{route('liste_services')}}" class="nav-link font-regular">Liste</a>
            </li>
            <li class="nav-item">
                <a href="{{route('creation_service')}}" class="nav-link font-regular">Ajouter</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link active">Modifier</a>
            </li>
            
        </ul>
@endsection

@section('contenu')
<!-- Contenu de la page -->
@section('contenu')
  <!-- Affiche les messages de succes/erreur de validation -->
  <x-alert type="danger" :message="$errors->all()" />
    <x-alert type="success" :message="session('success')" />
    <x-alert type="danger" :message="session('error')" />

<div class="card shadow border-0 mb-7">
    <div class="table-responsive">
        <form action="{{route('update_service', ['id_service' => $service->id_service]) }}" method="POST">
            @csrf
            @method('PUT')

            <label for="nom_service">Nom du Service</label>
            <input type="text" name="nom_service" value="{{$service->nom_service}}" required>

            <label for="telephone_service">Téléphone</label>
            <input type="text" name="telephone_service" value="{{$service->telephone_service}}">

            <button type="submit">Metre à jour</button>
        </form>
    </div>
</div>


@endsection