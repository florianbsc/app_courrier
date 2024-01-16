@extends('layout.app')
@section('title', 'Ajoute Centre')
@section('contenu')

<h5>new centre</h5>
<div class="card shadow border-0 mb-7">
    <div class="table-responsive">
        <form methode='POST' action = "{{route('creation_centre')}}">
        @csrf
        
        <button type="submit">Envoyer</button>
        </form>
    </div>
</div>

@stop