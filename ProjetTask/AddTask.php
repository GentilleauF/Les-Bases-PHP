<?php
$TaskAuthor = '';
$Task = '';
$messageTask = '';
// RECUPERER LE ID USER
try {
    //ETAPE 2 : Connexion à la BDD
    $bdd = new PDO('mysql:host=localhost;dbname=tasks', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    //ETAPE 3 : Préparer notre requête SELECT
    $req = $bdd->prepare('SELECT * FROM users');

    //ETAPE 4 : Exécuter la requête
    $req->execute();

    //ETAPE 5 : Récupération des datas envoyée par la BDD
    $data = $req->fetchAll(PDO::FETCH_ASSOC);

    ob_start();
    foreach ($data as $user) {
?>
        <option value="<?= $user['id_user'] ?>" name="<?= $user['id_user'] ?>"><?= $user['name_user'] ?></option>

    <?php

    }
    $TaskAuthor = ob_get_clean();
} catch (Exception $error) {
    $TaskAuthor = $error->getMessage();
}


// RECUPERER LES ARTICLES
try {
    //ETAPE 2 : Connexion à la BDD
    $bdd = new PDO('mysql:host=localhost;dbname=tasks', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    //ETAPE 3 : Préparer notre requête SELECT
    $req = $bdd->prepare('SELECT * FROM task');

    //ETAPE 4 : Exécuter la requête
    $req->execute();

    //ETAPE 5 : Récupération des datas envoyée par la BDD
    $data = $req->fetchAll(PDO::FETCH_ASSOC);

    ob_start();
    foreach ($data as $task) {
    ?>
        <article><?= $task['nom_task'] ?> : <?= $task['content_task'] ?></article>
        <p>Ecrit par <?= $task['id_user'] ?>, A faire avant : <?= $task['date_task'] ?></p>

<?php

    }
    $Task = ob_get_clean();
} catch (Exception $error) {
    $Task = $error->getMessage();
}




if (isset($_POST['submitTask'])) {

    if (
        isset($_POST['nom_task']) and !empty($_POST['nom_task'])
        and isset($_POST['content_task']) and !empty($_POST['content_task'])
        and isset($_POST['id_user']) and !empty($_POST['id_user'])
        and isset($_POST['date_task']) and !empty($_POST['date_task'])
    ) {
        echo 'etape1';

        $nom_task = htmlentities(strip_tags(stripslashes(trim($_POST['nom_task']))));
        $content_task = htmlentities(strip_tags(stripslashes(trim($_POST['content_task']))));
        $date_task = $_POST['date_task'];
        $id_user = $_POST['id_user']; // A Sécuriser

        try {

            //ETAPE 8 : Connexion à la BDD
            $bdd = new PDO('mysql:host=localhost;dbname=tasks', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

            //ETAPE 9 : Requête préparée
            $req = $bdd->prepare('INSERT INTO task (nom_task, content_task, id_user) VALUES (?,?,?)');

            //ETAPe 10 : Binding Param
            $req->bindParam(1, $nom_task, PDO::PARAM_STR);
            $req->bindParam(2, $content_task, PDO::PARAM_STR);
            $req->bindParam(3, $id_user, PDO::PARAM_STR);
            // $req->bindParam(4, $date_task, PDO::PARAM_STR);

            //ETAPE 11 : Exécution de la requête
            $req->execute();

            //ETAPE 12 : Message de Confirmation
            $messageTask = "Vous avez été enregistré avec succès !";
        } catch (Exception $error) {
            $messageTask = $error->getMessage();
        }
    }
}
?>