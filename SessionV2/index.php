<?php
session_start();
$formCo = "<h1>Accueil</h1>"; //-> Affiche Accueil à la place du Formulaire de Connexion si on est Connecté
$message = "";


//-> Affiche le Formulaire de Connexion si on n'est pas Connecté
if(!isset($_SESSION['connected'])){
    $formCo = '<form action="index.php" method="post">
    <h2>Connexion</h2>
    <input type="text" name="login" placeholder="Votre Login">
    <input type="password" name="password" placeholder="Votre Mot de Passe">
    <input type="submit" name="submit" value="Se Connecter">
    </form>';
}

//ETAPE 4 Du Diagramme de Sequence : Vérification des infos envoyées par le formulaire
if(isset($_POST['submit'])){
    //Vérification du remplissage des champs
    if(isset($_POST['login']) and !empty($_POST['login'])
        and isset($_POST['password']) and !empty($_POST['password'])){
            //Nettoyer les datas
            $login = htmlentities(strip_tags(stripslashes(trim($_POST['login']))));
            $password = htmlentities(strip_tags(stripslashes(trim($_POST['password']))));

            //Validation de format de data
            //-> je n'attends que des string non formatées, donc pas de vérification

            //ETAPE 5 Du Diagramme de Sequence : demander à la BDD si l'utilisateur existe
            try{
                //Connexion à la BDD
                $bdd = new PDO('mysql:host=localhost;dbname=task3','root','root',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

                //Préparation de la requête
                $req = $bdd->prepare('SELECT users.id_user, users.name_user, users.first_name_user, users.login_user, users.mdp_user FROM users WHERE login_user = ?');

                //Binding de Paramètre
                $req->bindParam(1,$login,PDO::PARAM_STR);

                //ETAPE 6 Du Diagramme de Sequence : exécution de la requête
                $req->execute();

                //ETAPE 7 Du Diagramme de Sequence : récupérer la réponse de la BDD
                $data = $req->fetchAll(PDO::FETCH_ASSOC);

                //ETAPE 8 Du Diagramme de Sequence : vérifier l'existence de l'utilidateur, et vérifier le mot de passe
                if(!empty($data) or (isset($data[0]['mdp_user']) and password_verify($password,$data[0]['mdp_user']))){
                   
                    //ETAPE 9 Du Diagramme de Sequence : enregistrer les datas en $_SESSION
                    $_SESSION['id']=$data[0]['id_user'];
                    $_SESSION['name']=$data[0]['name_user'];
                    $_SESSION['firstname']=$data[0]['first_name_user'];
                    $_SESSION['login']=$data[0]['login_user'];
                    $_SESSION['connected']=true;

                    //ETAPE 10 Du Diagramme de Sequence : message de confirmation
                    $message = 'Vous êtes bien connecté.';

                    //Redirection vers index.php pour rafraîchir la page
                    header('refresh:0');

                }else{
                    $message = "Utilisateur ou Mot de Passe incorrecte.";
                }
            }catch(Exception $error){
                $message = $error->getMessage();
            }

    }else{
        $message = "Veuillez remplir tous les champs.";
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
    <?php include 'nav.php' //-> affiche la navbar?>
    <main>
        <?= $formCo //->Permet l'affichage du formulaire de connexion ou de Accueil ?>
        <p><?= $message ?></p>
    </main>
</body>
</html>