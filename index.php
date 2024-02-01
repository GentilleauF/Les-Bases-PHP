<?php
include 'data.php';

$tabData = [];
array_push($tabData, $USERS_HUMAN);
array_push($tabData, $USERS_PET);
array_push($tabData, $USERS_XENO);


function afficherHumain($tab){
    $nom = $tab['name'];
    $email = $tab['email'];
    $age = $tab['age'];

    echo "
    <article style= 'border-bottom : 3px solid black '>
        <h2>nom : $nom </h2>
        <p>email : $email </p>
        <p>age : $age ans</p>
    </article>
    ";
}



function afficherAnimal($tab){
    $nom = $tab['name'];
    $espece = $tab['espece'];
    $age = $tab['age'];
    $propriétaire = $tab['propriétaire'];

    echo "
    <article style= 'border-bottom : 3px solid black '>
        <h2>nom : $nom </h2>
        <p>email : $espece </p>
        <p>age : $age ans</p>
        <p>propriétaire : $propriétaire</p>
    </article>
    ";
}


function afficherXeno($tab){
    $nom = $tab['name'];
    $espece = $tab['espece'];
    $age = $tab['age'];
    $menace = $tab['menace'];

    echo "
    <article style= 'border-bottom : 3px solid black '>
        <h2>nom : $nom </h2>
        <p>email : $espece </p>
        <p>age : $age ans</p>
        <p>niveau de la menace : $menace</p>
    </article>
    ";
}

function profil($tab){
    foreach ($tab as $tab2) {
        $type = $tab2['type'];
    
        if ($type === 'humain') {
            afficherHumain($tab2);
          }
          else if ($type === 'animal de compagnie') {
            afficherAnimal($tab2);
          }
          else if ($type === 'Xeno') {
            afficherXeno($tab2);
          }
          else {
            echo 'Type de Profil non Existant';
          }
      }
   }

function profilAll($tab) {
    foreach ($tab as $tab2) {
        profil($tab2);
    }
}
   


echo afficherHumain($USERS_HUMAN[0]);
echo afficherAnimal($USERS_PET[0]);
echo afficherXeno($USERS_XENO[0]);
?>

<br><br><br>
<?php
profil($USERS_PET);
profil($USERS_HUMAN);
profil($USERS_XENO);
?>

<br><br><br><br><br><br><br><br>
<?php
profilAll($tabData)
?>

