<?php
$message ="";
$profil = "";

//RECUPERATION DES PROFILS UTILISATEURS
//ETAPE 1 : Entamer la procédure pour récupérer les datas en BDD
try{

    //ETAPE 2 : Connexion à la BDD
    $bdd = new PDO('mysql:host=localhost;dbname=users2','root','root',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    //ETAPE 3 : Préparer notre requête SELECT
    $req = $bdd->prepare('SELECT users.lastname, users.firstname, users.email FROM users');

    //ETAPE 4 : Exécuter la requête
    $req->execute();

    //ETAPE 5 : Récupération des datas envoyée par la BDD
    $data = $req->fetchAll(PDO::FETCH_ASSOC);

    var_dump($data);

    //ETAPE 6 : formate mon affichage
    //VERSION BUFFER
    ob_start();
    foreach($data as $user){
    ?>
    <article>
        <h2><?= $user['firstname'] ?> <?= $user['lastname'] ?></h2>
        <p><?= $user['email'] ?></p>
    </article>
    <?php
    }
    $profil = ob_get_clean();


    //VERSION SANS BUFFER : STRING + Concacténation
    $profil = "";
    foreach($data as $user){
        $profil =$profil."<article><h2>".$user['firstname']." ".$user['lastname']."</h2><p>".$user['email']."</p></article>";
    }


}catch(Exception $error){
    $profil = $error->getMessage();
}

//TRAITEMENT DU FORMULAIRE
if(isset($_POST['submit'])){

    //ETAPE 2 : Vérification des inputs
    if(isset($_POST['nom']) and !empty($_POST['nom'])
        and isset($_POST['prenom']) and !empty($_POST['prenom'])
        and isset($_POST['mail']) and !empty($_POST['mail'])
        and isset($_POST['password']) and !empty($_POST['password'])
        and isset($_POST['password_verify']) and !empty($_POST['password_verify'])){

            //ETAPE 3 : Vérifier que les 2 passwords correspondent
            if($_POST['password'] === $_POST['password_verify']){

                //ETAPE 4 : Nettoyer les données
                $name = htmlentities(strip_tags(stripslashes(trim($_POST['nom']))));
                $firstName = htmlentities(strip_tags(stripslashes(trim($_POST['prenom']))));
                $mail = htmlentities(strip_tags(stripslashes(trim($_POST['mail']))));
                $password = htmlentities(strip_tags(stripslashes(trim($_POST['password']))));

                //ETAPE 5 : Hachage du mot de passe
                $password = password_hash($password, PASSWORD_BCRYPT);

                //ETAPE 6 : Vérification du format de donnée
                if(filter_var($mail, FILTER_VALIDATE_EMAIL)){

                    //ETAPE 7 : Enregistrement de l'utilisateur
                    try{

                        //ETAPE 8 : Connexion à la BDD
                        $bdd = new PDO('mysql:host=localhost;dbname=users2','root','root',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

                        //ETAPE 9 : Requête préparée
                        $req = $bdd->prepare('INSERT INTO users (lastname, firstname, email, psswrd) VALUES (?,?,?,?)');

                        //ETAPe 10 : Binding Param
                        $req->bindParam(1,$name,PDO::PARAM_STR);
                        $req->bindParam(2,$firstName,PDO::PARAM_STR);
                        $req->bindParam(3,$mail,PDO::PARAM_STR);
                        $req->bindParam(4,$password,PDO::PARAM_STR);

                        //ETAPE 11 : Exécution de la requête
                        $req->execute();

                        //ETAPE 12 : Message de Confirmation
                        $message = "Vous avez été enregistré avec succès !";

                    }catch(Exception $error){
                        $message = $error->getMessage();
                    }

                }else{
                    $message = "Votre mail n'est pas écrit correctement.";
                }
            }else{
                $message = "Vos mots de passe ne correspondent pas.";
            }

    }else{
        $message = "Veuillez remplir tous les champs";
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
        <label for="">Inscription Utilisateur</label>
        <p>Nom : <input type="text" name="nom"></p>
        <p>Prénom : <input type="text" name="prenom"></p>
        <p>Mail : <input type="text" name="mail"></p>
        <p>Mot de Passe : <input type="text" name="password"></p>
        <p>Retapper le Mot de Passe : <input type="text" name="password_verify"></p>
        <input type="submit" name="submit" value="SUBMIT !">
    </form>

    <p><?=$message ?></p>

    <section>
        <?= $profil ?>
    </section>

</body>
</html>