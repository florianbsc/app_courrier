@extends('layout.app')
@section('title', 'liste Employers')
@section('contenu')
<h1 class="h2 mb-0 ls-tight">Liste employers</h1>

<div class="card shadow border-0 mb-7">
    <div class="table-responsive">
        <table class="table table-hover table-nowrap">
            <thead class="thead-light">
                <tr>
                    <th scope="col"><b>Nom Prenom</b></th>
                    <th scope="col"><b>Mail</b></th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{$user->nom_user .' '. $user->prenom_user}}</td>
                        <td>{{$user->mail_user}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
    
@stop