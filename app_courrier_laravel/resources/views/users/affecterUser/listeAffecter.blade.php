
{{dd($affecterUser)}};

@extends('layout.app')
@section('title', 'liste user sersvice')

@section('nav')
    <h1 class="h2 mb-0 ls-tight">Utilisateurs</h1>

    <ul class="nav nav-tabs mt-4 overflow-x border-0">
        <li class="nav-item">
            <a href="{{route('liste_users')}}" class="nav-link active">Liste</a>
        </li>
        <li class="nav-item">
            <a href="{{route('creation_user')}}" class="nav-link font-regular">Ajouter</a>
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
