@extends('layout.app')

@section('title', 'Modifier Centre')

@section('nav')
    <h1 class="h2 mb-0 ls-tight">Modifier Utilisateur</h1>

        <ul class="nav nav-tabs mt-4 overflow-x border-0">
            <li class="nav-item">
                <a href="{{route('liste_users')}}" class="nav-link font-regular">Liste</a>
            </li>
            <li class="nav-item">
                <a href="{{route('creation_user')}}" class="nav-link font-regular">Ajouter</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link active">Modifier</a>
            </li>
        </ul>
@endsection

@section('contenu')

  <!-- Affiche les messages de succes/erreur de validation -->
  <x-alert type="danger" :message="$errors->all()" />
    <x-alert type="success" :message="session('success')" />
    <x-alert type="danger" :message="session('error')" />
    
    <div class="container-fluid">
        <div class="card shadow border-0 mb-7">
            <div class="table-responsive">

                <form action="{{ route('update_user', ['id_user' => $user->id_user]) }}" method="POST">
                    @csrf
                    @method('PUT')
                
                    <label for="nom_user">Nom</label>
                    <input type="text" name="nom_user" value="{{ $user->nom_user }}" required>
                
                    <label for="prenom_user">Prénom</label>
                    <input type="text" name="prenom_user" value="{{ $user->prenom_user }}" required>
                    
                    <label for="mail_user">Mail</label>
                    <input type="email" name="mail_user" value="{{ $user->mail_user }}" >

                    <label for="login_user">Identifiant</label>
                    <input type="text" name="login_user" value="{{ $user->login_user }}" required>
                    
                    <label for="id_services">Affecter au service</label>
                    <select name="id_services[]" id="id_service" multiple>
                        @foreach($services as $service)
                            <option value="{{ $service->id_service }}"
                                @if($user->services->contains($service->id_service)) selected @endif>
                                {{ $service->nom_service }}
                            </option>
                        @endforeach
                    </select>
                    
                    <label for="privilege_user">Privilège</label>
                    <select name="privilege_user" id="privilege_user" required>
                        @foreach(['1' => 'Invité', '2' => 'Employer', '3' => 'Directeur', '4' => 'Admin', '0' => 'Désactivé'] as $value => $label)
                            <option value="{{ $value }}" {{ $user->privilege_user == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    <label for="password">Mot de passe</label>
                    <input type="text" name="password" value="{{$user->password}}" required >

                    <button type="submit">Mettre à jour</button>
                </form>
                
            
            </div>
        </div>
    </div>

@endsection
