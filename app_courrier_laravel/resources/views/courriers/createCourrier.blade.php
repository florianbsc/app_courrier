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
            <input type="hidden" name="destinataire_courrier" placeholder="Destinataire" value="{{ old('destinataire_courrier') }}" >

            <label for="courriers"></label>
            <input type="hidden" name="description_courrier" placeholder="Description" value="{{ old('description_courrier') }}">
 
            <label for="centres">Centre</label>
            <select name="id_centre" id="id_centre" required>
                <option value="{{ old('id_centre') }}" selected>-- Choisir un centre --</option>
                @forelse($centres as $centre)
                    <option value="{{ $centre->id_centre }}">{{ $centre->nom_centre }}</option>
                @empty
                    <!-- Aucun centre disponible -->
                @endforelse
            </select>

            <label for="services">Service</label>
            <select name="id_service" id="id_service" required>
                <option value="{{ old('id_service') }}">-- Choisir un service --</option>
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
</div>
@endsection
