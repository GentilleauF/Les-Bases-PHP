<?php
$list = "";

//Je vérifie que Submit a été cliqué (c.à.d formulaire soumis)
if(isset($_POST['submit'])){
    /*PETIT POINT SECURITE : La Sainte Trinité
    1er Mesure : Vérifier que les champs reçus et obligatoires ne sont pas vide*/
    if(isset($_POST['list']) and !empty($_POST['list'])){

        /* 2nd Mesure de sécurité : nettoyer les données, enlever le code malveillant*/
        //-> activation du buffer
        ob_start();
        foreach($_POST['list'] as $pokemon){
?>

            <li><?= htmlentities(strip_tags(stripslashes(trim($pokemon)))) ?></li>

<?php
        }

        //-> récupération de toutes les données d'un coup
        $list = ob_get_clean();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="index.php" method="post">
        <label for="">Vos Pokemon préféres :</label>
        <p><input type="checkbox" name="list[]" value="pikachu"> Pikachu</p>
        <p><input type="checkbox" name="list[]" value="bulbizard"> Bulbizard</p>
        <p><input type="checkbox" name="list[]" value="salamèche"> Salamèche</p>
        <p><input type="checkbox" name="list[]" value="evoli"> Evoli</p>
        <input type="submit" name="submit" value="SUBMIT !">
    </form>

    <ul><?= $list ?></ul>
</body>
</html>