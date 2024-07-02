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
  <!-- Affiche les messages de succes/erreur de validation -->
  <x-alert type="danger" :message="$errors->all()" />
    <x-alert type="success" :message="session('success')" />
    <x-alert type="danger" :message="session('error')" />

<div class="container-fluid">
<div class="card shadow border-0 mb-7">
    <div class="table-responsive">
        <form action="{{ route('update_courrier', ['id_courrier' => $courrier->id_courrier]) }}" method="POST">
            @csrf
            @method('PUT')

            <label for="objet_courrier">Objet</label>
            <input type="text" name="objet_courrier" value="{{$courrier->objet_courrier}}"  required>

            <label for="id_service">Service</label>
            <select name="id_service" id="id_service" >
                @foreach($services as $service)
                    <option value="{{ $service->id_service }}" {{ $service->id_service == $courrier->id_service ? 'selected' : '' }}>
                        {{ $service->nom_service}}
                    </option>
                @endforeach
            </select>
            
            <label for="destinataire_courrier">Destinataire</label>
            <select name="destinataire_courrier" id="destinataire_courrier" >
                @foreach($users as $user)
                    <option value="{{ $user->id_user }}" {{ $user->id_user == $courrier->destinataire_courrier ? 'selected' : '' }}>
                        {{ $user->nom_user . ' ' . $user->prenom_user }}
                    </option>
                @endforeach
            </select>

            {{-- <label for="id_centre">Centre</label>  --}}
            <select name="id_centre" id="id_centre" hidden >
                <option value="{{$courrier->id_centre}}" selected>{{$courrier->centre->nom_centre}}</option>
                @foreach($centres as $centre)
                    <option value="{{ $centre->id_centre }}">{{ $centre->nom_centre }}</option>
                @endforeach
            </select>

            <button type="submit">Mise à jour</button>
        </form>
    </div>
</div>
</div>
@endsection
