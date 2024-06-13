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
        <form action="{{ route('creation_courrier')}}" method="POST" enctype="multipart/form-data">
            @csrf

            <label for="courriers"></label>
            <input type="hidden" name="id_user"  value="{{ auth()->user()->id_user }}">

            <label for="courriers">Courrier</label>
            <input type="text" name="objet_courrier" placeholder="Objet" value="{{ old('objet_courrier') }}" autofocus required>

            <label for="courriers">Scan du Courrier</label>
            <input type="file" name="scan_courrier">

            <label for="courriers"></label>
            <input type="hidden" name="description_courrier" placeholder="Description" value="{{ old('description_courrier') }}">
 
            <label for="centres">Centre</label>
            <select name="id_centre" id="id_centre" >
                <option value="{{ old('id_centre') }}" selected>-- Choisir un centre --</option>
                @forelse($centres as $centre)
                    <option value="{{ $centre->id_centre }}">{{ $centre->nom_centre }}</option>
                @empty
                    <!-- Aucun centre disponible -->
                @endforelse
            </select>

            <label for="id_service">Service</label>
            <select name="id_service[]" id="id_service" multiple>
                @forelse($services as $service)
                    <option value="{{ $service->id_service }}" {{ in_array($service->id_service, old('id_service', [])) ? 'selected' : '' }}>
                        {{ $service->nom_service }}
                    </option>
                @empty
                    <option value="" disabled>Aucun service disponible</option>
                @endforelse
            </select>
            
            
            <label for="destinataire_courrier">Déstinataire</label>
            <select name="destinataire_courrier[]" id="destinataire_courrier" multiple>
                <option value="{{ old('destinataire_courrier[]') }}">-- Choisir un déstinataire --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id_user }}">{{ $user->nom_user.' '.$user->prenom_user }}</option>
                    @endforeach
            </select>

            <button type="submit">Envoyer</button>
        </form>
    </div>
</div>
</div>
@endsection
