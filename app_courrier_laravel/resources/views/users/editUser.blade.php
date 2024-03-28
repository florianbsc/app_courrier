@extends('layout.app')

@section('title', 'Modifier Centre')

@section('nav')
<h1 class="h2 mb-0 ls-tight">Liste users</h1>

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

                <form action="{{ route('update_user', ['id_user' => $user->id_user]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <label for="nom_user">Nom</label>
                    <input type="text" name="nom_user" value="{{$user->nom_user}}" required>

                    <label for="prenom_user">Prenom</label>
                    <input type="text" name="prenom_user" value="{{ $user->prenom_user }}" required>

                    <label for="mail_user">mail</label>
                    <input type="text" name="mail_user" value="{{ $user->mail_user }}" required>

                    <button type="submit">Mettre à jour</button>
                </form>
            </div>
        </div>
    </div>

@endsection
