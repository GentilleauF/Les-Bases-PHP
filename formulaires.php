<!--  Exercice 1 :
-Créer une page de formulaire dans laquelle on aura 2 champs de formulaire de type nombre.
-Afficher dans cette même page la somme des 2 champs avec un affichage du style :
La somme est égale à : valeur.

Exercice 2 :
-Créer une page de formulaire dans laquelle on aura 3 champs de formulaire de type nombre :
1 champ de formulaire qui demande un prix HT d’un article,
1 champ de formulaire qui demande le nombre d’article,
1 champ de formulaire qui demande le taux de TVA,
-Afficher dans cette même page le prix TTC (prix HTtaux TVAquantité) avec un affichage du style :
Le prix TTC est égal à : valeur €.

-->

<?php
$prixTTC = '';
$somme = '';

function nettoyage($var){
    strip_tags(stripslashes(trim(htmlentities($var))));
    return $var;
}

//1er formulaire
if (isset($_POST['nbr1']) and  !empty($_POST['nbr1'])
    and isset($_POST['nbr2']) and  !empty($_POST['nbr2'])) {
    // 1ere méthode de nettoyage
    $nbr1 = strip_tags(stripslashes(trim(htmlentities($_POST['nbr1']))));
    // 2eme méthode de sécu
    $nbr2 = filter_var($_POST['nbr2'], FILTER_SANITIZE_NUMBER_INT);

    //1ere méthode en métant dans une fonction
    nettoyage($nbr2);


    if (filter_var($nbr1, FILTER_VALIDATE_INT) and filter_var($nbr1, FILTER_VALIDATE_INT)) {
        
        //Les 3 mesures de sécurité sont respectée
        $somme = $nbr1  + $nbr2;
    };
}

/*Petit point sur la sécurité
- 1 : Verifier que les champs ne soient pas vides
        - isset() et empty() isset verfie qu'il existe et empty vérifie quil ne soit pas vide

- 2 : Nettoyer les données et enlever le code malveillant
        Se souvenir que les formulaires nous envoient les données sous forme de strings
        On peut donc utiliser des fonctions de string pour les nettoyer
         - htmlentities() : enlever les balises html / scripts et caractéres speciaux
         - strip_tags() :  enlever les balises PHP (et autres)
         - trim() : enlever les espaces du début et de la fin de la chaine de caractére
         - stripslashes() : enlever les antislash
        2eme possibilitée:  filter_var (mais la 1ere option est bien)

-3 : Verifier le format des données
        -> filter_var avec les filtres de validation (verifie par ex si un email ressemble à un email)

*/






//2eme Formulaire
if (isset($_POST['submit'])) { // Le isset se fait sur le name du submit
    $prixTTC = $_POST['prixHT'] * $_POST['nbrArticles'] + ($_POST['prixHT'] * $_POST['nbrArticles'] * $_POST['tauxTVA'] / 100);
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exo formulaires</title>
</head>

<body>
    <h2>Somme de 2 nombres</h2>
    <form action="formulaires.php" method="post">
        <input type="number" name="nbr1">
        <input type="number" name="nbr2">
        <input type="submit" value="Envoyer">
    </form>

    <p>La somme est égale à <?= $somme ?></p>

    <br><br>

    <h2>Calcul de la TVA</h2>
    <form action="formulaires.php" method="post">
        <input type="number" name="prixHT" placeholder="Prix HT">
        <input type="number" name="nbrArticles" placeholder="Nbr d'articles">
        <input type="number" name="tauxTVA" placeholder="TVA">
        <input type="submit" name="submit" value="Envoyer">
    </form>


    <p>Le prix TTC est égal à <?= $prixTTC ?> €</p>

</body>

</html>