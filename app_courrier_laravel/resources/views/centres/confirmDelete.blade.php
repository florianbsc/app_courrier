<!-- @extends('layout.app')
@section('title', 'Confirmer la suppression')
@section('contenu')

<h5>Confirmation de suppression</h5>

<p>Voulez-vous vraiment supprimer le centre : {{ $centre->nom_centre }}?</p>

<form action="{{ route('delete_centre', ['id' => $centre->id_centre]) }}" method="post">
    @csrf
    @method('DELETE')
    <button type="submit">Oui, supprimer</button>
    <a href="{{ route('liste_centres') }}">Annuler</a>
</form>

@stop -->
