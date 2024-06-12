@extends('layout.app')
@section('title', 'Modifier Courrier')
@section('nav')
<h1 class="h2 mb-0 ls-tight"> Modifier Courrier</h1>

        <ul class="nav nav-tabs mt-4 overflow-x border-0">
            <li class="nav-item">
                <a href="{{route('liste_courriers')}}" class="nav-link font-regular">Liste</a>
            </li>
            <li class="nav-item">
                <a href="{{route('creation_courrier')}}" class="nav-link font-regular">Ajouter</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link active ">Modifier</a>
            </li>
        </ul>
@endsection

<!-- Contenu de la page -->
@section('contenu')
    <!-- Affiche les messages d'erreur de validation -->
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="container-fluid">
<div class="card shadow border-0 mb-7">
    <div class="table-responsive">
        <form action="{{ route('update_courrier', ['id_courrier' => $courrier->id_courrier]) }}" method="POST">
            @csrf
            @method('PUT')

            <label for="objet_courrier">Objet</label>
            <input type="text" name="objet_courrier" value="{{$courrier->objet_courrier}}"  required>

             {{-- <label for="destinataire_courrier">Destinataire</label>
            <input type="text" name="destinataire_courrier" value="{{$courrier->destinataire_courrier}}"  required> --}}

            <!-- <label for="description_courrier">Description</label>
            <input type="text" name="description_courrier" value="{{$courrier->description_courrier}}" > -->

            <label for="id_centre">Centre</label>
            <select name="id_centre" id="id_centre" >
                <option value="{{$courrier->id_centre}}" selected>{{$courrier->centre->nom_centre}}</option>
                @forelse($centres as $centre)
                    <option value="{{ $centre->id_centre }}">{{ $centre->nom_centre }}</option>
                @empty
                    <option value="" disabled>Aucun centre disponible</option>
                @endforelse
            </select>

            <label for="id_service">Service</label>
            <select name="id_service" id="id_service" >
                <option value="{{$courrier->id_service}}" selected>{{$courrier->service->nom_service}}</option>
                @forelse($services as $service)
                    <option value="{{ $service->id_service }}">{{ $service->nom_service }}</option>
                @empty
                    <option value="" disabled>Aucun service disponible</option>
                @endforelse
            </select>
            
            <label for="destinataire_courrier">Destinataire</label>
            <select name="destinataire_courrier" id="destinataire_courrier" >
                {{-- <option value="{{$courrier->destinataire_courrier}}" selected>{{$courrier->user->nom_user.' '.$courrier->user->prenom_user}}</option> --}}
                <option value="{{$courrier->destinataire_courrier}}" selected>{{'faire une liaison pour recupe le nom/prenom du destinataire'}}</option>
                @forelse($users as $user)
                    <option value="{{ $user->id_user }}">{{ $user->nom_user.' '.$user->prenom_user }}</option>
                @empty
                    <option value="" disabled>Aucun service disponible</option>
                @endforelse
            </select>

            <button type="submit">Mise à jour</button>
        </form>
    </div>
</div>
</div>
@endsection
