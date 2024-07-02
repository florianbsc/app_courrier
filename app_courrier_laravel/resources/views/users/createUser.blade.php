<!-- Ajoute le titre de la page -->
@extends('layout.app')
@section('title', 'Nouveau Utilisateur')

<!-- Section de la barre de navigation -->
@section('nav')
    <h1 class="h2 mb-0 ls-tight"> Nouveau Utilisateur</h1>

    <!-- Onglets de navigation -->
    <ul class="nav nav-tabs mt-4 overflow-x border-0">
        <li class="nav-item">
            <a href="{{route('liste_users')}}" class="nav-link font-regular">Liste</a>
        </li>
        <li class="nav-item">
            <a href="{{route('creation_user')}}" class="nav-link active">Ajouter</a>
        </li>
    </ul>
@endsection

<!-- Contenu de la page -->
@section('contenu')
  <!-- Affiche les messages de succes/erreur de validation -->
  <x-alert type="danger" :message="$errors->all()" />
    <x-alert type="success" :message="session('success')" />
    <x-alert type="danger" :message="session('error')" />

{{-- {{dd($services)}} --}}
<div class="container-fluid">
 <!-- Formulaire d'ajout d'utilisateur -->
    <div class="card shadow border-0 mb-7">
        <div class="table-responsive">
            <form method='post' action = "{{route('creation_user')}}">
                @csrf
                <label for="nom_user" name="nom_user">Utilisateur</label>
                <input type="text" name="nom_user" placeholder="Nom" value="{{ old('nom_user') }}" autofocus required>

                <label for="prenom_user" name="prenom_user"></label>
                <input type="text" name="prenom_user" placeholder="Prénom" value="{{ old('prenom_user') }}" required>

                <label for="mail_user" name="mail_user"></label>
                <input type="mail" name="mail_user" placeholder="Mail" value="{{ old('mail_user') }}" required>
               
                <label for="id_services">Affecter à ou plusieur services</label>
                <select id="id_service" name="id_services[]" multiple required>
                    @foreach($services as $service)
                        <option value="{{ $service->id_service }}">{{ $service->nom_service }}</option>
                    @endforeach
                </select>

                <label for="privilege_user">Niveau de privilège</label>
                <select name="privilege_user" id="privilege_user" >
                    <option selected disabled>-- Privilège --</option required>
                    @foreach(['1' => 'Invité', '2' => 'Employer', '3' => 'Directeur', '4' => 'Admin', '0' => 'Désactivé'] as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>

                <label for="password" name="password">Mot de passe</label>
                <input type="password" name="password" placeholder="8 caratères minimum" value="{{ old('password') }}" required>

                <label for="password_confirmation"></label>
                <input type="password" name="password_confirmation" placeholder="Confirmer mot de passe" required >

                <button type="submit">Envoyer</button>
            </form>
        </div>
    </div>
</div>
@endsection