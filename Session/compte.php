<?php
session_start();
$_SESSION['compte'] = "";

if (isset($_SESSION['compte'])) {
    echo '<p>Nous avons visité la compte.php</p>';
}

if (isset($_SESSION['name'])) {
    echo '<p>je suis connécté</p>';
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
    <nav>
        <p><a href="index.php">Page accueil</a></p>
        <p><a href="compte.php">Mon compte</a></p>
    </nav>

    <h2></h2>

    <button type="button"><a href="deco.php">Se déconnecter</a></button>

</body>

</html>