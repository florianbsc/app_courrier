@extends('layout.app')
@section('title', 'Liste courrier')
@section('contenu')

    <div class="card shadow border-0 mb-7">
        <div class="table-responsive">
            <table class="table table-hover table-nowrap">
                <thead class="thead-light">
                    <tr>
                        <th scope="col"><b>ID</b></th>
                        <th scope="col"><b>Date</b></th>
                        <th scope="col"><b>objet</b></th>
                        <th scope="col"><b>Destinataire</b></th>
                        <th scope="col"><b>Description</b></th>
                        <th scope="col"><b>user</b></th>
                        <th scope="col"><b>Centre</b></th>
                        <th scope="col"><b>Service</b></th>
                        <!-- Ajoute d'autres colonnes au besoin -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courriers as $courrier)
                        <tr>
                            <td>{{ $courrier->id_courrier }}</td>
                            <td>{{ $courrier->date_courrier }}</td>
                            <td>{{ $courrier->objet_courrier }}</td>
                            <td>{{ $courrier->destinataire_courrier }}</td>
                            <td>{{ $courrier->description_courrier }}</td>
                            <td>{{$courrier->nom_user}}</td>
                            <td>{{ $courrier->nom_centre }}</td>
                            <td>{{ $courrier->nom_service }}</td>
                            <!-- Ajoute d'autres cellules au besoin -->
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@stop