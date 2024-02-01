<?php
$message = "";
$profil = "";

//AFFICHAGE UTILISATEURS
try{
    //ETAPE 1 : connexion à la BDD
    $bdd = new PDO('mysql:host=localhost;dbname=task3','root','root',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    //ETAPE 2 : préparer ma requête SELECT
    $req = $bdd->prepare('SELECT users.name_user, users.first_name_user, users.login_user FROM users');

    //ETAPE 3 : exécution de la requête
    $req->execute();

    //ETAPE 4 : récupération des datas
    $data = $req->fetchAll(PDO::FETCH_ASSOC);

    //ETAPE 5 : Mise en forme de l'affichage avec BUFFER !!!
    ob_start();
    foreach($data as $user){
?>
        <article>
            <h2><?= $user['login_user']?></h2>
            <p><?= $user['name_user']?> <?= $user['first_name_user']?></p>
        </article>
<?php
    }

    $profil = ob_get_clean();

}catch(Exception $error){
    $profil = $error->getMessage();
}


//ENREGISTREMENT D'UN UTILISATEUR
//ETAPE 1 : Vérifier la soumission du formulaire
if(isset($_POST['submit'])){

    //ETAPE 2 : Vérifier si les champs sont bien remplis
    if(isset($_POST['nom']) and !empty($_POST['nom'])
        and isset($_POST['prenom']) and !empty($_POST['prenom']) 
        and isset($_POST['login']) and !empty($_POST['login'])
        and isset($_POST['password']) and !empty($_POST['password'])
        and isset($_POST['password_verify']) and !empty($_POST['password_verify'])){

            //ETAPE 3 : vérifier la concordance des 2 mots de passe
            if($_POST['password'] === $_POST['password_verify']){

                //ETAPE 4 : nettoyer les données
                $name = htmlentities(strip_tags(stripslashes(trim($_POST['nom']))));
                $firstName = htmlentities(strip_tags(stripslashes(trim($_POST['prenom']))));
                $login = htmlentities(strip_tags(stripslashes(trim($_POST['login']))));
                $password = htmlentities(strip_tags(stripslashes(trim($_POST['password']))));

                //ETAPE 5 : hashage du mot de passe
                $password = password_hash($password, PASSWORD_BCRYPT);

                //ETAPE 6 : validation du format de donnée
                //-> on n'attend que des string non formaté, donc on peut pas

                //ETAPE 7 : Requête d'insertion
                try{

                    //ETAPE 8 : Connexion à la BDD
                    $bdd = new PDO('mysql:host=localhost;dbname=task3','root','root',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

                    //ETAPE 9 : Préparer ma requête d'insertion
                    $req = $bdd->prepare('INSERT INTO users (name_user, first_name_user, login_user, mdp_user) VALUES (?,?,?,?)');

                    //ETAPE 10 : Binding de Param
                    $req->bindParam(1,$name,PDO::PARAM_STR);
                    $req->bindParam(2,$firstName,PDO::PARAM_STR);
                    $req->bindParam(3,$login,PDO::PARAM_STR);
                    $req->bindParam(4,$password,PDO::PARAM_STR);

                    //ETAPE 11 : Exécution de la requête
                    $req->execute();

                    //ETAPE 12 : afficher le message de confirmation
                    $message = $name.' '.$firstName.' a bien été enregistré avec le login : '.$login;

                }catch(Exception $error){
                    $message = $error->getMessage();
                }

            }else{
                $message="Vos mots de passe ne correspondent pas.";
            }

    }else{
        $message="Veuillez remplir tous les champs";
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
        <p>Login : <input type="text" name="login"></p>
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