@extends('layout.app')
@section('title', 'Ajouter Courrier')
@section('nav')
<h1 class="h2 mb-0 ls-tight"> Ajouter Courrier</h1>

        <ul class="nav nav-tabs mt-4 overflow-x border-0">
            <li class="nav-item">
                <a href="{{route('liste_courriers')}}" class="nav-link font-regular">Liste</a>
            </li>
            <li class="nav-item">
                <a href="{{route('creation_courrier')}}" class="nav-link active">Ajouter</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link font-regular">Modifier</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link font-regular">Supprimer</a>
            </li>
        </ul>
@endsection

@section('contenu')

<div class="card shadow border-0 mb-7">
    <div class="table-responsive">
        <form action="{{ route('creation_courrier')}}" method="POST">
            @csrf

            <label for="objet_courrier">Objet du Courrier</label>
            <input type="text" name="objet_courrier" placeholder="Objet" required>

            <label for="destinataire_courrier">Destinataire du Courrier</label>
            <input type="text" name="destinataire_courrier" placeholder="Destinataire" required>

            <label for="description_courrier">Description du Courrier</label>
            <input type="text" name="description_courrier" placeholder="Description">

            <label for="id_centre">Centre</label>
            <select name="id_centre" id="id_centre" required>
                <option value="">-- Choisir un centre --</option>
                @forelse($centres as $centre)
                    <option value="{{ $centre->id_centre }}">{{ $centre->nom_centre }}</option>
                @empty
                    <!-- Aucun centre disponible -->
                @endforelse
            </select>

            <label for="id_service">Service</label>
            <select name="id_service" id="id_service" required>
                <option value="">-- Choisir un service --</option>
                @forelse($services as $service)
                    <option value="{{ $service->id_service }}">{{ $service->nom_service }}</option>
                @empty
                    <!-- Aucun service disponible -->
                @endforelse
            </select>

            <button type="submit">Envoyer</button>
        </form>
    </div>
</div>
@stop
