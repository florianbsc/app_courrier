@extends('layout.app')

@section('title', 'Modifier Centre')

@section('nav')
<h1 class="h2 mb-0 ls-tight">Liste centres</h1>

        <ul class="nav nav-tabs mt-4 overflow-x border-0">
            <li class="nav-item">
                <a href="{{route('liste_centres')}}" class="nav-link font-regular">Liste</a>
            </li>
            <li class="nav-item">
                <a href="{{route('creation_centre')}}" class="nav-link font-regular">Ajouter</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link active">Modifier</a>
            </li>
        </ul>
@endsection

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

        <form action="{{ route('update_centre', ['id_centre' => $centre->id_centre]) }}" method="POST">
            @csrf
            @method('PUT')

            <label for="nom_centre">Nom</label>
            <input type="text" name="nom_centre" value="{{ $centre->nom_centre }}" required>

            <label for="adresse_centre">Adresse</label>
            <input type="text" name="adresse_centre" value="{{ $centre->adresse_centre }}" required>

            <label for="CP_centre">Code postal</label>
            <input type="number" name="CP_centre" value="{{ $centre->CP_centre }}" required>

            <label for="telephone_centre">Téléphone</label>
            <input type="text" name="telephone_centre" value="{{ $centre->telephone_centre }}" required>

            <button type="submit">Mettre à jour</button>
        </form>
    </div>
</div>
</div>
@endsection
