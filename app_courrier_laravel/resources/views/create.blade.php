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

        <label for="courrier">Date</label>
        <ol name="date_courrier" id="courrier">
            @foreach($courriers as $courrier)
            <li value="{{$courrier->id_courrier}} ">{{$courrier->date_courrier}}</li>
            @endforeach        
    </ol>

        <label for="courrier">Objet</label>
        <select name="id_courrier" id="courrier">
            @foreach($courriers as $courrier)
            <option value="{{$courrier->id_courrier}} ">{{$courrier->description_courrier}}</option>
            @endforeach        
        </select>



        <label for="destinataire_courrier">Destinataire</label>
        <input type="text" name="destinataire_courrier">

        <label for="objet_courrier">Objet</label>
        <input type="text" name="objet_courrier">

        <label for="description_courrier">Description</label>
        <input type="text" name="description_courrier">

        <input type="submit" value="Envoyer">
    </form>


    <!-- <form action="{{ route('creation_de_courrier')}}" method="post">
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
    </form> -->


</body>

</html>