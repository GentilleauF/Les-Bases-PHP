<!--
1) créer un formulaire demandant la liste de vos trucs préférés.
Ce doit être sous forme de checkbox

2) Après avoir mis en places chaque sécurité, vous afficherez la liste des trucs préférés sous forme de <ul>
------------------------------
-->

<?php
$result = [];

if (isset($_POST['submit'])) {

    if (isset($_POST['mesPref']) and !empty($_POST['mesPref'])) {
        $mesPref = $_POST['mesPref'];
        foreach ($mesPref as $item) {
            $itemfiltered = htmlentities(strip_tags(trim(stripslashes($item))));
            array_push($result, $itemfiltered);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="Checkbox.php" method="post">
        <label for="">Vos activitées préféres</label>
        <p><input type="checkbox" name="mesPref[]" value="la Pizza">La Pizza</p>
        <p><input type="checkbox" name="mesPref[]" value="Le seigneur des anneaux">Le seigneur des anneaux</p>
        <p><input type="checkbox" name="mesPref[]" value="<h1>test sécu</h1>">Le Rugby</p>
        <p><input type="submit" name="submit" value="submit"></p>
    </form>

    <?= var_dump($result) ?>

    <h2>Vos activitées favorites sont:</h2>
    <ul>
        <?php foreach ($result as $item) { ?>

        <li> <?= $item ?> </li>
        <?php } ?>
    </ul>
</body>

</html>