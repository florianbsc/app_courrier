
<a href="{{route('accueil')}} ">home</a>

<form action="#" method="POST">
    @csrf
    <label for="utilisateurs">Sélectionnez les utilisateurs :</label><br>
    <select name="utilisateurs[]" id="utilisateurs" multiple>
        <option value="1">Utilisateur 1</option>
        <option value="2">Utilisateur 2</option>
        <option value="3">Utilisateur 3</option>
        <!-- Ajoutez d'autres options ici -->
    </select><br><br>
    <button type="submit">Valider</button>
</form>
