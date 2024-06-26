@extends('layout.app')

@section('title', 'Liste Services')


@php
        $hasAccess1 = \App\Http\Controllers\UserController::hasAccess(2);
        $hasAccess2 = \App\Http\Controllers\UserController::hasAccess(3);
        $hasAccess3 = \App\Http\Controllers\UserController::hasAccess(4);
@endphp

@section('nav')
<h1 class="h2 mb-0 ls-tight">Liste Services</h1>

        <ul class="nav nav-tabs mt-4 overflow-x border-0">
            <li class="nav-item">
                <a href="{{route('liste_services')}}" class="nav-link active">Liste</a>
            </li>
            @if($hasAccess3)
                <li class="nav-item">
                    <a href="{{route('creation_service')}}" class="nav-link font-regular">Ajouter</a>
                </li>
            @endif 
        </ul>
@endsection

@section('contenu')

    <!-- Affiche les messages de succes/erreur de validation -->
    <x-alert type="danger" :message="$errors->all()" />
    <x-alert type="success" :message="session('success')" />
    <x-alert type="danger" :message="session('error')" />

<div class="container-fluid">
    <div class="col-sm-6 col-12 mb-4 mb-sm-0" style="display: flex">
        <!-- En-tête avec le titre et le nombre de centres -->
        <span class="text-muted text-sm" style="margin-left: 10px; margin-top: 1.5%">
            Nombre de courrier : {{ count($services) }}
        </span>
    </div>
     <!-- Formulaire de recherche avec le bouton de recherche -->
     <div class="col-sm-6 col-12 mb-2 mb-sm-0" style="display: flex;margin-top:5px;">
        <form method="POST" action="{{ route('liste_service_recherche') }}" style="display:flex">
            @csrf
            <input type="text" name="recherche" placeholder="Rechercher..." value="{{ $valeur_recherche ?? '' }}" style="width:250px">
            <button type="submit" style="margin-left:15px">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                </svg>
            </button>
        </form>
    </div>
    <div class="card shadow border-0 mb-7">
        <div class="table-responsive">
            <table class="table table-hover table-nowrap">
                <thead>
                    <tr>
                        <th scope="col"><b>Nom</b></th>
                        <th scope="col"><b>Téléphone</b></th>
                        @if( $hasAccess3 )<th scope="col"><b>Action</b></th>@endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($services as $service)
                        <tr>
                            <td>{{$service->nom_service}}</td>
                            <td>{{$service->telephone_service}}</td>
                            @if( $hasAccess3 )

                            <td>
                                <ul class="nav">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('delete_service', ['id_service' => $service->id_service]) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                            <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                                            </svg>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('edit_service', ['id_service' => $service->id_service]) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                            </svg>
                                        </a>    
                                    </li>
                                    
                                </ul>
                            </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
