<!--
Exercice : Connexion
a) créer une page index.php avec un formulaire de connexion
b) créer une seconde page compte.php qui devra les information de compte
c) créer un bouton de déconnexion (deco.php)
d) en utilisant la table user de la BDD task, vous allez créer sur index.php un système de connexion
e) sur la page deco.php, vous allez créer la déconnexion du compte.
f) la page compte.php doit afficher les information du user connecté

NOTE : aidez-vous du diagramme de séquence
-->

<?php
session_start();

if (isset($_POST['submit'])) {

    if (
        isset($_POST['name']) and !empty($_POST['name'])
        and isset($_POST['pwd']) and !empty($_POST['pwd'])
    ) {

        $name = htmlentities(strip_tags(stripslashes(trim($_POST['name']))));
        $pwd = htmlentities(strip_tags(stripslashes(trim($_POST['pwd']))));

        try {

            //ETAPE 2 : Connexion à la BDD
            $bdd = new PDO('mysql:host=localhost;dbname=tasks', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

            //ETAPE 3 : Préparer notre requête SELECT
            $req = $bdd->prepare('SELECT users.name_user, users.id_user, users.mdp_user FROM users WHERE name_user = ? ');
            //BINDING
            $req->bindParam(1, $name, PDO::PARAM_STR);
            //ETAPE 4 : Exécuter la requête
             $req->execute();

            //ETAPE 5 : Récupération des datas envoyée par la BDD
            $data = $req->fetchAll(PDO::FETCH_ASSOC);
            // var_dump($data[0]);

            // ETAPE 6 Verif sil correspond à l'utilisateur de la bdd
            if ($name === $data[0]['name_user'] and password_verify($pwd, $data[0]['mdp_user'])) {
                echo 'yess !';
                $_SESSION['id'] = $data[0]['id_user'];
                $_SESSION['name'] = $data[0]['name_user'];


            } else {
                echo 'nope';
            }
        } catch (Exception $error) {
            $profil = $error->getMessage();
        }
    } else {
        $message = 'Les mots de passes ne correspondent pas';
    }
} else {
    $message = 'Veuillez remplir tout les champs';
}

if(isset($_SESSION['compte'])){
    echo '<p>Nous avons visité la compte.php</p>';
    } 

    if(isset($_SESSION['name'])){
        echo $_SESSION['name'];
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

    <h2>Connexion</h2>
    <form action="index.php" method="post">
        <p>Votre Pseudo : <input type="text" name="name"></p>
        <p>Mot de passe : <input type="text" name="pwd"></p>
        <p><input type="submit" name="submit"></p>
    </form>

    <nav>
        <p><a href="index.php">Page accueil</a></p>
        <p><a href="compte.php">Mon compte</a></p>
    </nav>

</body>

</html>