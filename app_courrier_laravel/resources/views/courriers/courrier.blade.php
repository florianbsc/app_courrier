@extends('layout.app')
@section('title', 'Liste courrier')
@section('contenu')

    <div class="card shadow border-0 mb-7">
        <div class="table-responsive">
            <table>
            <thead>
            <tr>
            <th scope="col">ID</th>
            <th scope="col">Date</th>
            <th scope="col">objet</th>
            <th scope="col">Destinataire</th>
            <th scope="col">Description</th>
            <th scope="col">user</th>
            <th scope="col">Centre</th>
            <th scope="col">Service</th>
            <!-- Ajoute d'autres colonnes au besoin -->
            </tr>
            </thead>

            <tbody>
            @foreach ($courriers as $courrier)
            <tr>
            <td>
                {{ $courrier->id_courrier }}
            </td>
            <td>
                {{ $courrier->date_courrier }}
            </td>
            <td>
                {{ $courrier->objet_courrier }}
            </td>
            <td>
                {{ $courrier->destinataire_courrier }}
            </td>
            <td>
                {{ $courrier->description_courrier }}
            </td>
            <td>
                {{$courrier->nom_user}}
            </td>
            <td>
                {{ $courrier->nom_centre }}
            </td>
            <td>
                {{ $courrier->nom_service }}
            </td>

            <!-- Ajoute d'autres cellules au besoin -->
            </tr>
            @endforeach
            </tbody>
            </table>
        </div>
    </div>
    


    <form action="">

    <label for="courrier">Objet</label>
    <input type="text" name="objet_courrier" required>

    <label for="courrier">Destinataire</label>
    <input type="text" name="destinataire_courrier" required>

    <label for="description">Description</label>
    <input type="text" name="description_courrier">

    <label for="centre">Centre</label>
    <select name="id_centre" id="centre" required>
    <option value="">--choisir un centre--</option>
    @foreach($centres as $centre)
    <option value="{{$centre->id_centre}}" >{{$centre->nom_centre}}</option>
    @endforeach        
    </select>

    <label for="service">Service</label>
    <select name="id_service" id="service" required>            
    <option value="">--choisir un service--</option>
    @foreach($services as $service)
    <option value="{{$service->id_service}}">{{$service->nom_service}}</option>
    @endforeach
    </select>
    <input type="submit">

    </form>

@stop