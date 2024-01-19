@extends('layout.app')
@section('title', 'Liste Services')
@section('contenu')
<h1 class="h2 mb-0 ls-tight">Liste Services</h1>

<div class="card shadow border-0 mb-7">
    <div class="table-responsive">
        <table class="table table-hover table-nowrap">
        <thead>
            <tr>
                <th scope="col"><b>Nom</b></th>
                <th scope="col"><b>Téléphone</b></th>
            </tr>
        </thead>
        <tbody>
                @foreach($services as $service)
                <tr>
                    <td>{{$service->nom_service}}</td>
                    <td>{{$service->telephone_service}}</td>
                </tr>
                @endforeach
        </tbody>
        </table>
    </div>
</div>       


@stop