<!-- a) Créer une base de données MYSQL depuis le MLD ci-dessous :
-Nom de la BDD : «task»,

b) Créer une page php qui va contenir un formulaire html avec comme méthode POST (balise form) cette page va nous permettre de créer nos comptes utilisateurs et les sauvegarder dans la base de données.
-A l’intérieur du formulaire ajouter les champs suivants :
Un champ input avec comme attribut html name = «name_user»,
Un champ input avec comme attribut html name = «first_name_user»,
Un champ input avec comme attribut html name = «login_user»,
Un champ input avec comme attribut html name = «mdp_user»,
Un champ input de type submit avec comme attribut html value = « submit »

c) Ajouter le code php suivant :
-Créer 4 variables $name_user, $first_name_user, $login_user, $mdp_user,
-Importer le contenu des super globales $_POST[‘name_user’], $_POST[‘first_name_user’], $_POST[‘login_user’], $_POST[‘mdp_user’], et tester les avec la méthode isset() (dans la condition if) dans les variables créées précédemment ($name_user, $first_name_user, $login_user, $mdp_user),
-Ajouter le code de connexion à la base de données en vous inspirant des exemples vus dans ce chapitre,
-Ajouter une requête préparée avec Binding de Paramètres qui va insérer le contenu des 4 champs dans un nouvel enregistrement (requête SQL insert),
-Afficher après l’insertion en base de données les informations que vous avez saisies (nom, prenom, login, mot de passe).

d)Bonus :
-Afficher en bas de la page la liste des comptes utilisateurs créés avec une requête SQL select,
-Utiliser une requête SQL préparée. -->
<?php
// $name_user = '';
// $first_name_user = '';
// $login_user = '';
// $mdp_user = '';
$message = '';

try {

    //ETAPE 2 : Connexion à la BDD
    $bdd = new PDO('mysql:host=localhost;dbname=tasks', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    //ETAPE 3 : Préparer notre requête SELECT
    $req = $bdd->prepare('SELECT users.name_user, users.first_name_user, users.login_user FROM users');

    //ETAPE 4 : Exécuter la requête
    $req->execute();

    //ETAPE 5 : Récupération des datas envoyée par la BDD
    $data = $req->fetchAll(PDO::FETCH_ASSOC);

    ob_start();
    foreach ($data as $user) {
?>
        <li><?= $user['name_user'] ?> <?= $user['first_name_user'] ?> --- Pseudo: <?= $user['login_user'] ?></li>

<?php
    }

    $profil = ob_get_clean();
} catch (Exception $error) {
    $profil = $error->getMessage();
}


if (isset($_POST['submit'])) {

    if (
        isset($_POST['name_user']) and !empty($_POST['name_user'])
        and isset($_POST['first_name_user']) and !empty($_POST['first_name_user'])
        and isset($_POST['login_user']) and !empty($_POST['login_user'])
        and isset($_POST['mdp_user']) and !empty($_POST['mdp_user'])
    ) {

        $name_user = htmlentities(strip_tags(stripslashes(trim($_POST['name_user']))));
        $first_name_user = htmlentities(strip_tags(stripslashes(trim($_POST['first_name_user']))));
        $login_user = htmlentities(strip_tags(stripslashes(trim($_POST['login_user']))));
        $password_user = htmlentities(strip_tags(stripslashes(trim($_POST['mdp_user']))));

        $password_user = password_hash($password_user, PASSWORD_BCRYPT);



        try {

            //ETAPE 8 : Connexion à la BDD
            $bdd = new PDO('mysql:host=localhost;dbname=tasks', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

            //ETAPE 9 : Requête préparée
            $req = $bdd->prepare('INSERT INTO users (name_user, first_name_user, login_user, mdp_user) VALUES (?,?,?,?)');

            //ETAPe 10 : Binding Param
            $req->bindParam(1, $name_user, PDO::PARAM_STR);
            $req->bindParam(2, $first_name_user, PDO::PARAM_STR);
            $req->bindParam(3, $login_user, PDO::PARAM_STR);
            $req->bindParam(4, $password_user, PDO::PARAM_STR);

            //ETAPE 11 : Exécution de la requête
            $req->execute();

            //ETAPE 12 : Message de Confirmation
            $message = "Vous avez été enregistré avec succès !";
        } catch (Exception $error) {
            $message = $error->getMessage();
        }
    }
}

include 'AddTask.php';

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h2>Ajouter un Utilisateur</h2>
    <form action="ProjetTask.php" method="post">
        <p>Nom :<input type="text" name="name_user"></p>
        <p>Prénom: <input type="text" name="first_name_user"></p>
        <p>Pseudo: <input type="text" name="login_user"></p>
        <p>Mot de passe : <input type="text" name="mdp_user"></p>
        <p><input type="submit" name="submit"></p>
    </form>

    <p> <?= $message ?></p>
    <h3>Mes profils</h3>
    <p> mes profils : <?= $profil ?></p>


    <h2>Ajouter un Article</h2>
    <form action="ProjetTask.php" method="post">
        <p>ID de l'auteur :
            <select name="id_user">
                <?= $TaskAuthor ?>
            </select>
        </p>
        <p>Nom de la task: <input type="text" name="nom_task"></p>
        <p>Contenu de la task: <input type="text" name="content_task"></p>
        <p>Date de la task : <input type="date" name="date_task"></p>
        <p><input type="submit" name="submitTask"></p>
    </form>

    <p> <?= $messageTask ?></p>
    <p> <?= $Task ?></p>



</body>

</html>