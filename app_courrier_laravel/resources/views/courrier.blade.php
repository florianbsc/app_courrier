<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afficher courrier</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="hidden"] {
            display: none;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }
</style>

</head>

<body>



<!-- Ta structure HTML existante... -->

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>objet</th>
            <th>Destinataire</th>
            <th>Description</th>
            <th>user</th>
            <th>Centre</th>
            <th>Service</th>
            <!-- Ajoute d'autres colonnes au besoin -->
        </tr>
    </thead>
    <tbody>
        @foreach ($courriers as $courrier)
            <tr>
                <td>{{ $courrier->id_courrier }}</td>
                <td>{{ $courrier->date_courrier }}</td>
                <td>{{ $courrier->objet_courrier }}</td>
                <td>{{ $courrier->destinataire_courrier }}</td>
                <td>{{ $courrier->description_courrier }}</td>
                <td>{{$courrier->nom_user}}</td>
                <td>{{ $courrier->nom_centre }}</td>
                <td>{{ $courrier->nom_service }}</td>
                
                <!-- Ajoute d'autres cellules au besoin -->
            </tr>
        @endforeach
    </tbody>
</table>

    <form action="">
    <label for="courrier">Centre</label>
            <select name="id_centre" id="centre">
                @foreach($centres as $centre)
                <option value="{{$centre->id_centre}}">{{$centre->nom_centre}}</option>
                @endforeach        
            </select>

    <label for="courrier">Service</label>
        <select name="id_service" id="service">
            @foreach($services as $service)
            <option value="{{service->id_service}}">{{service->nom_service}}</option>
            @endforeach
        </select>


    </form>

</body>

</html>