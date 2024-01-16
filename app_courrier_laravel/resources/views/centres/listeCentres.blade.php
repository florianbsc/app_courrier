@extends('layout.app')
@section('title', 'Liste Centre')
@section('contenu')

<div class="card shadow border-0 mb-7">
        <div class="table-responsive">
            <table class="table table-hover table-nowrap">

                <thead class="thead-light">
                    <tr>
                        <th scope="col"><b>Nom Prenom</b></th>
                        <th scope="col"><b>Mail</b></th>
                        <th scope="col"><b>Code postal</b></th>
                        <th scope="col"><b>Telephone</b></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($centres as $centre)
                        <tr>
                            <td>
                                {{$centre->nom_centre}}
                            </td>
                            <td>
                                {{$centre->adresse_centre}}
                            </td>
                            <td>
                                {{$centre->CP_centre}}
                            </td>
                            <td>
                                {{$centre->telephone_centre}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
@stop