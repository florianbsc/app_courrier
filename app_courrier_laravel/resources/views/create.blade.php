<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>new mail</title>
</head>

<body>
    <h1>NEW MAIL</h1>

    <form action="{{ route('creation_de_courrier')}}" method="post">
        @csrf

        <label type="hidden" for="courrier">Date</label>
        <input type="hidden" name="date_courrier" value=$date_maintenant>

        <label for="courrier">Destinataire</label>
        <input type="text" name="destinataire_courrier" >

        <label for="courrier">Objet</label>
        <input type="text" name="objet_courrier">

        <label for="courrier">Description</label>
        <input type="text" name="description_courrier">

        <!-- <label for="courrier">Nom du centre</label>
        <select name="id_centre" id="centre">
            @foreach($centres as $centre)
                <option value="{{$centre->id_centre}}">{{$centre->nom_centre}}</option>
            @endforeach
        </select> -->

        <label for=""></label>
    </form>


</body>

</html>