@extends('layout.app')
@section('title', 'Ajoute Centre')
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