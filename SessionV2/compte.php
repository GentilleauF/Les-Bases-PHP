<?php
    session_start();
    $login = "";
    $prenom = "";
    $nom = "";

    //-> Si on est connecté, permet l'affichage des informations du comptes (stoké en $_SESSION)
    if(isset($_SESSION['connected'])){
        $login = $_SESSION['login'];
        $prenom = $_SESSION['firstname'];
        $nom = $_SESSION['name'];
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
    <?php include 'nav.php' //-> affiche la navbar?>
    <main>
        <h1><?= $login ?></h1>
        <p>Prénom : <?= $prenom ?></p>
        <p>Nom : <?= $nom ?></p>
    </main>
</body>
</html>