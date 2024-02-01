<?php
$resultat = "";

if(isset($_POST['submit'])){
    /*PETIT POINT SECURITE : La Sainte Trinité
    1er Mesure : Vérifier que les champs reçus et obligatoires ne sont pas vide*/
    if(isset($_POST['prixHT']) and !empty($_POST['prixHT'])
    and isset($_POST['tva']) and !empty($_POST['tva'])
    and isset($_POST['quantite']) and !empty($_POST['quantite'])){

        /* 2nd Mesure de sécurité : nettoyer les données, enlever le code malveillant        */
        $prixHT = htmlentities(strip_tags(stripslashes(trim($_POST['prixHT']))));
        $tva = htmlentities(strip_tags(stripslashes(trim($_POST['tva']))));
        $quantite = htmlentities(strip_tags(stripslashes(trim($_POST['quantite']))));


        /* 3eme Mesure de Sécurité : Vérifier le format des données*/
        if(filter_var($prixHT, FILTER_VALIDATE_FLOAT) and filter_var($tva, FILTER_VALIDATE_FLOAT) and filter_var ($quantite, FILTER_VALIDATE_INT)){

            //Les 3 Mesures de sécurités sont respecté, je peux utiliser mes données
            $resultat = $prixHT * $quantite * (1+($tva/100));
        }
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
        <input type="number" name="prixHT" step="0.01" placeholder="Prix" required>
        <input type="number" name="tva" step="0.1" placeholder="TVA" required>
        <input type="number" name="quantite" step="1" placeholder="Quantite" required>
        <input type="submit" name="submit">
    </form>

    <p>Le Prix TTC est de : <?= $resultat ?></p>
</body>
</html>