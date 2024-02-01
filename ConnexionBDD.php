<!--
a) Créer une base de données MYSQL avec les informations suivantes :
-Nom de la bdd : « articles »,
-une table nommée article qui va posséder les champs suivants :
id_article (clé primaire),
nom_article de type varchar(50),
contenu_article de type varchar (255),

b) Créer une page php qui va contenir un formulaire html avec comme méthode POST (balise form)
-A l’intérieur du formulaire rajouter les champs suivants :
Un champ input avec comme attribut html name = «nom_article »,
Un champ input avec comme attribut html name = «contenu_article »,
Un champ input de type submit avec comme attribut html value = «ajouter»

c) Ajouter le code php suivant :
-Créer 2 variables $name, $content
-Importer le contenu des 2 super globales $_POST[‘nom_article’], $_POST[‘contenu_article’] et tester les avec la méthode isset() dans les variables créés précédemment ($name et $content),
-Ajouter le code de connexion à la base de données en vous inspirant des exemples vus dans ce chapitre,
-Ajouter une requête préparée qui va insérer le contenu des 2 champs dans un nouvel enregistrement (requête SQL insert),
-->

<?php
// $bdd = new PDO('mysql:host=localhostdbname=nom', 'root')
$name = '';
$content = '';

//RECUPERER
function showAllArticle($bdd): array
{
    try {
     $req = $bdd->prepare('SELECT nom_article FROM article');
        $req->execute();
        $data = $req->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    } catch (Exception $e) {
        //affichage d'une exception en cas d’erreur
        die('Erreur : ' . $e->getMessage());
    }
}

// return $data;
ob_start();
$data = showAllArticle($bdd); 
foreach ($data as $row) {
    echo 'test';
?>
<p>Nom de larticle : <?=  $row['nom_article'] ?> '</p>';
<<?php
}
$profil = ob_get_clean();



if (isset($_POST['ajouter'])) {
    if (
        isset($_POST['nom_article']) and !empty($_POST['nom_article'])
        and isset($_POST['contenu_article']) and !empty($_POST['contenu_article'])
    ) {
        $name = htmlentities(strip_tags(stripslashes(trim($_POST['nom_article']))));
        $content = htmlentities(strip_tags(stripslashes(trim($_POST['contenu_article']))));
    }

    try {
        //Connexion à la base de données
        $bdd = new PDO(
            'mysql:host=localhost;dbname=articles',
            'root',
            '',
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
        );
    
    
        //Préparation de la requête SQL nous stockons dans une variable $req la requête à exécuter
        $req = $bdd->prepare("INSERT INTO article (nom_article, contenu_article) VALUES(?, ?)");
    
        //Binding de Paramètre, nous attribuons une valeur à chaque ? de notre requête, en indiquant sa position et son typage dans les paramètres
        $req->bindParam(1, $name, PDO::PARAM_STR);
        $req->bindParam(2, $content, PDO::PARAM_STR);
    
        //Exécution de la requête SQL création à l’aide d’un tableau qui va contenir le ou les paramètres à affecter à la requête SQL
        $req->execute();
     
    } catch (Exception $e) {
        //affichage d'une exception en cas d’erreur
        die('Erreur : ' . $e->getMessage());
    }

    $_POST['nom_article'] = '';
    $_POST['contenu_article'] = '';
}








?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion à la BDD</title>
</head>

<body>
    <form action="ConnexionBDD.php" method="post">
        <label for="">Envoyer votre article :</label>
        <input type="text" name="nom_article">
        <input type="text" name="contenu_article">
        <input type="submit" name="ajouter" value="SUBMIT !">
    </form>

    <p> 
        <?php
        $profil;
        ?>
    </p>

</body>

</html>