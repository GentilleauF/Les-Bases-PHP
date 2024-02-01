<?php
$resultat = "";

if(isset($_POST['submit'])){
    /*PETIT POINT SECURITE : La Sainte Trinité
    1er Mesure : Vérifier que les champs reçus et obligatoires ne sont pas vide
        -> isset() et empty()*/
    if(isset($_POST['nbr1']) and !empty($_POST['nbr1'])
    and isset($_POST['nbr2']) and !empty($_POST['nbr2'])){

        /* 2nd Mesure de sécurité : nettoyer les données, enlever le code malveillant
            -> Se souvenir que les formulaires nous envoient les données sous forme de String
            -> on peut utiliser des fonctions de String pour les nettoyer
             + htmlentities() : enlever les balises HTML et SCRIPT, et aussi les caractères spéciaux
             + strip_tags() : enlever les balises PHP (ainsi que d'autres balises)
             + trim() : enlever les espaces au début et en fin de chaîne de caractère
             + stripslashes() : enlever les antislash (c'est à dire les caractères d'échappement)
        */

        $nbr1 = htmlentities(strip_tags(stripslashes(trim($_POST['nbr1']))));
        $nbr2 = htmlentities(strip_tags(stripslashes(trim($_POST['nbr2']))));

        /*NOTE : il existe une autre manière de nettoyer nos données : filter_var() + Filtre de Nettoyage */
        $nbr1 = filter_var($_POST['nbr1'], FILTER_SANITIZE_NUMBER_INT);
        $nbr2 = filter_var($_POST['nbr2'], FILTER_SANITIZE_NUMBER_INT);


        /* 3eme Mesure de Sécurité : Vérifier le format des données
            -> filter_var() + Filtre de Validation
            -> ou les Regex (expression régulière) : je vous laisse faire les recherches
        */
        if(filter_var($nbr1, FILTER_VALIDATE_INT) and filter_var($nbr2, FILTER_VALIDATE_INT) ){

            //Les 3 Mesures de sécurités sont respecté, je peux utiliser mes données
            $resultat = $nbr1 + $nbr2;
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
        <input type="number" name="nbr1">
        <input type="number" name="nbr2">
        <input type="submit" name="submit">
    </form>

    <p>La somme est égale à : <?= $resultat ?></p>
</body>
</html>