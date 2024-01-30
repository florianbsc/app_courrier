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
<!--
    <li class="nav-item">
        <a href="#" class="nav-link font-regular">Modifier</a>
    </li>
    <li class="nav-item">
        <a href="#" class="nav-link font-regular">Supprimer</a>
    </li>
-->

        </ul>
@endsection

@section('contenu')

<div class="card shadow border-0 mb-7">
    <div class="table-responsive">
        <form method='POST' action = "{{route('creation_centre')}}">
            @csrf
            <label for="nom_centre" >Centre</label>
            <input type="text" name="nom_centre" placeholder="Nom" >

            <label for="adresse_centre" ></label>
            <input type="text" name="adresse_centre" placeholder="Adresse" >

            <label for="CP_centre" ></label>
            <input type="number" name="CP_centre" placeholder="Code postal" >

            <label for="telephone_centre" ></label>
            <input type="text" name="telephone_centre" placeholder="Téléphone" >

            <button type="submit">Envoyer</button>
        </form>
    </div>
</div>

@stop