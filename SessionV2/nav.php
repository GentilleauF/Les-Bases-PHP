<?php
$linkProfil = "";

//-> Permet d'afficher le lien vers Mon Compte et le Boutton de Déconnexion, si on est connecté
if(isset($_SESSION['connected'])){
    $linkProfil = '<a href="compte.php">Mon Compte</a><button><a href="deco.php">Deconnexion</a></button>';
}
?>

<nav>
    <a href="index.php">Accueil</a>
    <?= $linkProfil ?>
</nav>