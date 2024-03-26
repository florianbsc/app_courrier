@extends('layout.app')
@section('title', 'Ajoute Centre')
@section('nav')
<h1 class="h2 mb-0 ls-tight"> Ajouter centre</h1>

        <ul class="nav nav-tabs mt-4 overflow-x border-0">
            <li class="nav-item">
                <a href="{{route('liste_centres')}}" class="nav-link font-regular">Liste</a>
            </li>
            <li class="nav-item">
                <a href="{{route('creation_centre')}}" class="nav-link active">Ajouter</a>
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

<!-- @section('message')
@show 

-->
<div class="container-fluid">

    <div class="card shadow border-0 mb-7">
        <div class="table-responsive">
            <form method='POST' action = "{{route('creation_centre')}}">
                @csrf
                <label for="nom_centre" name="nom_centre" >Centre</label>
                <input type="text" name="nom_centre" placeholder="Nom" value="{{ old('nom_centre') }}" required>

                <label for="adresse_centre" name="adresse_centre" ></label>
                <input type="text" name="adresse_centre" placeholder="Adresse" value="{{ old('adresse_centre') }}" required>

                <label for="CP_centre" name="CP_centre" ></label>
                <input type="number" name="CP_centre" placeholder="Code postal" value="{{ old('CP_centre') }}" required>

                <label for="telephone_centre" name="telephone_centre" ></label>
                <input type="text" name="telephone_centre" placeholder="Téléphone" value="{{ old('telephone_centre') }}" required>

                <button type="submit">Envoyer</button>
            </form>
        </div>
    </div>
</div>
@endsection