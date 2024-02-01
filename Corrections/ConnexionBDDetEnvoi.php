<?php
$message ="";
//TRAITEMENT DU FORMULAIRE
if(isset($_POST['submit'])){
    //Je veux enregistrer le remier pokemon coché
    $pokemon = $_POST['message'][0];

    //ETAPE 1 : CONNECTION A LA BDD
    $bdd = new PDO('mysql:host=localhost;dbname=pokemon','root','root',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

    //ETAPE 2 : Envoie de la requête à la BDD
    try{
        //Requête Préparé
        $req=$bdd->prepare("INSERT INTO pokemon (nom) VALUES(?)");

        //Binding de Paramètre
        $req->bindParam(1,$pokemon,PDO::PARAM_STR);

        //Exécution de la requête
        $req->execute();

        echo "$pokemon est enregistré avec succès";

    }catch(Exception $error){
        die('Erreur :'.$error->getMessage());
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
        <label for="">Vos Pokemon préféres</label>
        <p><input type="checkbox" name="message[]" value="pikachu"> Pikachu</p>
        <p><input type="checkbox" name="message[]" value="bulbizard"> Bulbizard</p>
        <p><input type="checkbox" name="message[]" value="salamèche"> Salamèche</p>
        <p><input type="checkbox" name="message[]" value="evoli"> Evoli</p>
        <input type="submit" name="submit" value="SUBMIT !">
    </form>

    <p><?=$message ?></p>

</body>
</html>