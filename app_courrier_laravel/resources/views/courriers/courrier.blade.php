@extends('layout.app')
@section('title', 'Liste courriers')

@section('nav')
<h1 class="h2 mb-0 ls-tight">Liste Courrier</h1>

        <ul class="nav nav-tabs mt-4 overflow-x border-0">
            <li class="nav-item">
                <a href="#" class="nav-link active">Liste</a>
            </li>
            <li class="nav-item">
                <a href="{{route('creation_courrier')}}" class="nav-link font-regular">Ajouter</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link font-regular">Modifier</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link font-regular">Supprimer</a>
            </li>
        </ul>
@endsection
@section('contenu')

<div class="card shadow border-0 mb-7">
    <div class="table-responsive">
        <table class="table table-hover table-nowrap">
            <thead>
                <tr>
                    <th scope="col"><b>ID</b></th>
                    <th scope="col"><b>Date</b></th>
                    <th scope="col"><b>objet</b></th>
                    <th scope="col"><b>Destinataire</b></th>
                    <th scope="col"><b>Description</b></th>
                    <th scope="col"><b>user</b></th>
                    <th scope="col"><b>Centre</b></th>
                    <th scope="col"><b>Service</b></th>
                    <th scope="col"><b>Action</b></th>
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
                        <td>
                        <ul class="nav">
                            <li class="nav-item">
                                <a class="nav-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                                </svg>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                </svg>
                                </a>    
                            </li>
                            
                        </ul>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@stop