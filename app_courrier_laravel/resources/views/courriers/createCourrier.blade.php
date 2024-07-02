@extends('layout.app')
@section('title', 'Ajouter Courrier')

@section('nav')
    <!-- Titre de la page -->
    <h1 class="h2 mb-0 ls-tight"> Ajouter Courrier</h1>

    <!-- Navigation des onglets -->
    <ul class="nav nav-tabs mt-4 overflow-x border-0">
        <li class="nav-item">
            <a href="{{route('liste_courriers')}}" class="nav-link font-regular">Liste</a>
        </li>
        <li class="nav-item">
            <a href="{{route('creation_courrier')}}" class="nav-link active">Ajouter</a>
        </li>
    </ul>
@endsection

@section('contenu')
    <!-- Affichage des messages de succès/erreur de validation -->
    <x-alert type="danger" :message="$errors->all()" />
    <x-alert type="success" :message="session('success')" />
    <x-alert type="danger" :message="session('error')" />

    <div class="container-fluid">
        <div class="card shadow border-0 mb-7">
            <div class="table-responsive">
                <!-- Formulaire de création de courrier -->
                <form action="{{ route('creation_courrier')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Champ caché pour l'ID de l'utilisateur connecté -->
                    <input type="hidden" name="id_user" value="{{ auth()->user()->id_user }}">

                    <!-- Champ pour l'objet du courrier -->
                    <label for="courriers">Courrier</label>
                    <input type="text" name="objet_courrier" placeholder="Objet" value="{{ old('objet_courrier') }}" autofocus required>

                    <!-- Champ pour télécharger le scan du courrier -->
                    <label for="courriers">Scan du Courrier</label>
                    <input type="file" name="scan_courrier">

                    <!-- Champ caché pour la description du courrier -->
                    <input type="hidden" name="description_courrier" placeholder="Description" value="{{ old('description_courrier') }}">

                    <!-- Sélecteur pour choisir le centre (caché) -->
                    <select name="id_centre" id="id_centre" hidden>
                        <option value="6" selected>-- Choisir un centre --</option>
                        @forelse($centres as $centre)
                            <option value="{{ $centre->id_centre }}">{{ $centre->nom_centre }}</option>
                        @empty
                            <!-- Aucun centre disponible -->
                        @endforelse
                    </select>

                    <!-- Sélecteur pour choisir le service -->
                    <label for="id_service">Service</label>
                    <select name="id_service" id="id_service">
                        <option value="11" selected>-- Choisir un service --</option>
                        @forelse($services as $service)
                            <option value="{{ $service->id_service }}">{{ $service->nom_service }}</option>
                        @empty
                            <option value="" disabled>Aucun service disponible</option>
                        @endforelse
                    </select>
                    
                    <!-- Sélecteur pour choisir le destinataire -->
                    {{-- <label for="destinataire_courrier">Déstinataire</label>
                    <select name="destinataire_courrier" id="destinataire_courrier">
                        <option value="54" selected>-- Choisir un déstinataire --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id_user }}">{{ $user->nom_user.' '.$user->prenom_user }}</option>
                        @endforeach
                    </select> --}}

                    <label for="destinataire_courrier">Destinataire</label>
                    <select name="destinataire_courrier" id="destinataire_courrier">
                        <option value="54" {{ old('destinataire_courrier', $courrier->destinataire_courrier ?? 54) == 54 ? 'selected' : '' }}>-- Choisir un destinataire --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id_user }}" {{ old('destinataire_courrier', $courrier->destinataire_courrier ?? '') == $user->id_user ? 'selected' : '' }}>
                                {{ $user->nom_user . ' ' . $user->prenom_user }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Bouton pour envoyer le formulaire -->
                    <button type="submit">Envoyer</button>
                </form>
            </div>
        </div>
    </div>
@endsection
