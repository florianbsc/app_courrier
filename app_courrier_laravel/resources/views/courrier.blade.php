
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>afficher courrier</title>
</head>

<body>

<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Objet</th>
            <th>Destinataire</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($courriers as $courrier)
            <tr>
                <td>{{ $courrier->date_courrier }}</td>
                <td>{{ $courrier->objet_courrier}}</td>
                <td>{{ $courrier->destinataire_courrier }}</td>
                <td>{{ $courrier->description_courrier }}</td>
            </tr>
        @endforeach
    </tbody>
</table>



</body>


</html>