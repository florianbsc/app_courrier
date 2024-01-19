@extends('layout.app')
@section('title', 'Ajouter Service')
@section('contenu')
<h1 class="h2 mb-0 ls-tight">Ajouter Service</h1>

<div class="card shadow border-0 mb-7">
    <div class="table-responsive">
        <form method="post" action="{{route('creation_service')}}">
            @csrf
            <label for="nom_service">Service</label>
            <input type="text" name="nom_service" placeholder="Nom" required>

            <label for="telephone_service"></label>
            <input type="text" name="telephone_service" placeholder="Téléphone" required>

            <button type="submit">Envoyer</button>
        </form>
    </div>
</div>


@stop