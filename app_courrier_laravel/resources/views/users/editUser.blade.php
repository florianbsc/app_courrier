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
                {{-- {{dd($user)}} --}}

                <form action="{{ route('update_user', ['id_user' => $user[0]->id_user]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <label for="nom_user">Nom</label>
                    <input type="text" name="nom_user" value="{{$user[0]->nom_user}}" required>

                    <label for="prenom_user">Prénom</label>
                    <input type="text" name="prenom_user" value="{{ $user[0]->prenom_user }}" required>

                    <label for="mail_user">Mail</label>
                    <input type="text" name="mail_user" value="{{ $user[0]->mail_user }}" required>
                    
                    <label for="privilege_user">Privilège</label>
                    <select name="privilege_user" id="privilege_user" value="{{ $user[0]->privilege_user }}" required>
                        @foreach(['1' => 'Lecture', '2' => 'Ecriture', '3' => 'Admin'] as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>

                    <label for="id_services">Affecter au service</label>
                    <select name="id_services[]" id="id_service" value="{{ $services[0]->id_service }}" multiple>
                        @foreach($services as $service)
                            <option value="{{ $service->id_service }}">{{ $service->nom_service }}</option>
                        @endforeach
                    </select>

                    <button type="submit">Mettre à jour</button>
                </form>
            </div>
        </div>
    </div>

@endsection
