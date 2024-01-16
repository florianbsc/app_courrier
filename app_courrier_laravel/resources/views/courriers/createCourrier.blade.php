@extends('layout.app')
@section('title', 'Ajouter Courrier')
@section('contenu')

    <h5>NEW MAIL</h5>
<div class="card shadow border-0 mb-7">
<div class="table-responsive">
    <form action="{{ route('creation_courrier')}}" method="post">
        @csrf

        <label for="courrier"></label>
        <input type="text" name="objet_courrier" placeholder="Objet" required>

        <label for="courrier"></label>
        <input type="text" name="destinataire_courrier" placeholder="Destinataire" required>

        <label for="description"></label>
        <input type="text" name="description_courrier"placeholder="Description" >

        <label for="centre"></label>
        <select name="id_centre" id="centre" required>
            <option value="">--choisir un centre--</option>
            @foreach($centres as $centre)
                <option value="{{$centre->id_centre}}" >{{$centre->nom_centre}}</option>
            @endforeach
        </select>

        <label for="service">Service</label>
        <select name="id_service" id="service" required>
            <option value="">--choisir un service--</option>
            @foreach($services as $service)
                <option value="{{$service->id_service}}">{{$service->nom_service}}</option>
            @endforeach
        </select>

        <button type="submit">Envoyer</button>
    </form>
</div>
</div>
@stop