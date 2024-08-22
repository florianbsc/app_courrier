
@extends('layout.app')
@section('title', 'Liste courriers')

@section('nav')
    @php
        $is_inviter = \App\Http\Controllers\UserController::hasAccess(1);
        $is_employer = \App\Http\Controllers\UserController::hasAccess(2);
        $is_directeur = \App\Http\Controllers\UserController::hasAccess(3);
        $is_admin = \App\Http\Controllers\UserController::hasAccess(4);
        $is_desabled = \App\Http\Controllers\UserController::hasAccess(0);
        $userConnected = auth()->user()->id_user;
    @endphp

        <h1 class="h2 mb-0 ls-tight">Liste Courrier</h1>
            <ul class="nav nav-tabs mt-4 overflow-x border-0">
                <li class="nav-item">
                    <a href="{{ route('liste_courriers') }}" class="nav-link active">Liste</a>
                </li>
                @if( $is_employer)

                    <li class="nav-item">
                        <a href="{{ route('creation_courrier') }}" class="nav-link font-regular">Ajouter</a>
                    </li>
                @endif

            </ul>
@endsection
@section('contenu')
    <!-- Affiche les messages de succes/erreur de validation -->
    <x-alert type="danger" :message="$errors->all()" />
    <x-alert type="success" :message="session('success')" />
    <x-alert type="danger" :message="session('error')" />
        

        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Contenue de la page -->
        <div class="container-fluid">
            <div class="col-sm-6 col-12 mb-4 mb-sm-0" style="display: flex">
                <!-- En-tête avec le titre et le nombre de centres -->
                    <span class="text-muted text-sm" style="margin-left: 10px; margin-top: 1.5%">
                        Nombre de courrier : {{ count($courriers) }}
                    </span>
            </div>
            <!-- Formulaire de recherche avec le bouton de recherche -->
                <div class="col-sm-6 col-12 mb-2 mb-sm-0" style="display: flex;margin-top:5px;">
                    <form method="POST" action="{{ route('liste_courrier_recherche') }}" style="display:flex">
                        @csrf
                        <input type="text" name="recherche" placeholder="Rechercher..." value="{{ $valeur_recherche ?? '' }}" style="width:250px">
                        <button type="submit" style="margin-left:15px">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                            </svg>
                        </button>
                    </form>
                </div>
            <!-- Affichage des courriers sous forme de tableau -->
                <div class="card shadow border-0 mb-7">
                    <div class="table-responsive">
                        <table class="table table-hover table-nowrap">
                            <!-- Collone tableau -->
                                <thead>
                                    <tr>
                                        <th scope="col"><b>Date</b></th>
                                        <th scope="col"><b>objet</b></th>
                                        <th scope="col"><b>Service</b></th>
                                        <th scope="col"><b>Destinataire</b></th>
                                        <th scope="col"><b>Scan</b></th>
                                        <th scope="col"><b>Action</b></th>
                                    </tr>
                                </thead>
                            <!-- Ligne tableau -->
                                <tbody>
                                    @foreach ($courriers as $courrier)
                                    {{-- {{dd($courriers)}} --}}
                                        <tr>
                                            <td style="text-transform: capitalize;">{{ $courrier->date_courrier->translatedFormat('D j M Y') }}</td>
                                            <td>{{ $courrier->objet_courrier }}</td>
                                            <td>{{ $courrier->nom_service }}</td>
                                            <td>{{ $courrier->destinataire->nom_user }} {{ $courrier->destinataire->prenom_user }}</td>
                                            {{-- <td>{{ dd($courrier->destinataire_courrier)  }}</td> --}}
                                            <td>
                                                <!-- voir le scan -->
                                                @if($courrier->id_user === $userConnected ||                // auteur du courrier est l'user connecté
                                                    $courrier->destinataire_courrier === $userConnected ||  // destinataire du courrier est l'user connecté
                                                    auth()->user()->inService($courrier->id_service)    ||     // user connecté est dans le service attribué
                                                    auth()->user()->privilege_user >=3 )      
                                                    <!-- deposé un scan -->
                                                    @if(empty($courrier->scan_courrier) && $courrier->id_user === $userConnected || 
                                                        empty($courrier->scan_courrier) && $is_admin)      {{-- l'auteur du courrier est l'user connecté --}}
                                                        
                                                        <form method="POST" action="{{ route('depot_scan_courrier', ['id_courrier' => $courrier->id_courrier]) }}" enctype='multipart/form-data'>
                                                            @csrf
                                                            <label for="courriers" style="position: relative; display: inline-block; cursor: pointer;">
                                                                <input type="hidden" name="id_courrier" value="{{ $courrier->id_courrier }}">
                                                                <input name="scan_courrier" class="courrier_file" type="file" style="position: absolute; width: 100%; height: 100%; opacity: 0; top: 0; left: 0; cursor: pointer;">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-upload" viewBox="0 0 16 16">
                                                                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
                                                                    <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708z"/>
                                                                </svg>
                                                            </label> 
                                                        </form>
                                                    @endif
                                                    <!-- telecharger le scan -->
                                                    @if(!empty($courrier->scan_courrier) && auth()->user()->privilege_user >=2 ||
                                                        !empty($courrier->scan_courrier) && $courrier->id_user === $userConnected ||                // auteur du courrier est l'user connecté
                                                        !empty($courrier->scan_courrier) && $courrier->destinataire_courrier === $userConnected)
                                                        <a href="{{ route('download_scan_courrier', ['chemin' => $courrier->scan_courrier]) }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-down-circle" viewBox="0 0 16 16" style="color:  #3392ff ">
                                                                <path fill-rule="evenodd"
                                                                    d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293z"/>
                                                            </svg>
                                                        </a>
                                                    @endif
                                                    @if(!empty($courrier->scan_courrier) && $courrier->id_user === $userConnected ||
                                                        !empty($courrier->scan_courrier) && $is_admin)
                                                        <!-- Btn sup scan -->
                                                        <a href="{{ route('delete_scan_courrier', ['id_courrier' => $courrier->id_courrier]) }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-x-square-fill" viewBox="0 0 16 16">
                                                                <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm3.354 4.646L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708"></path>
                                                            </svg>
                                                        </a>                                                       
                                                    @endif
                                                @endif
                                            </td>
                                            
                                            <td>
                                                <!-- Bouton  action -->
                                                    @if($courrier->id_user === $userConnected || $is_admin )
                                                        <ul class="nav">
                                                            <!-- Btn sup -->
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="{{route('delete_courrier', ['id_courrier' => $courrier->id_courrier])}}">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                                        <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                                                                        </svg>
                                                                    </a>
                                                                </li>
                                                            <!-- btn edit -->
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="{{route('edit_courrier', ['id_courrier' => $courrier->id_courrier]) }}">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                                                        </svg>
                                                                    </a>
                                                                </li>
                                                        </ul>
                                                    @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                        </table>
                    </div>
                </div>
        </div>
        <script>
            $(document).ready(function () {
                $('.courrier_file').change(function () {
                    validateForm($(this));
                })

                function validateForm(courrier_input) {
                    let form = courrier_input.closest("form").get()[0];
                    form.submit();
                }
            })
        </script>
@endsection
