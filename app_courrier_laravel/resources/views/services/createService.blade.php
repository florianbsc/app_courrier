@extends('layout.app')
@section('title', 'Ajouter Service')
@section('contenu')

<div class="card shadow border-0 mb-7">
        <div class="table-responsive">
            <form action="route('creation_service')" method="post">
                @csrf
                <label for="nom_service"></label>
                <input type="text" name="nom_service" placeholder="Nom" required>

                <label for="telephone_service"></label>
                <input type="text" name="telephone_service" placeholder="Téléphone" required>

                <input type="submit" Envoyer>
            </form>
        </div>
</div>



@stop