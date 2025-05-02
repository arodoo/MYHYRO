<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../../../Configurations_bdd.php');
require_once('../../../../Configurations.php');
require_once('../../../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction= "../../../../";
require_once('../../../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

$lasturl = $_SERVER['HTTP_REFERER'];

$now =  time();

  /*****************************************************\
  * Adresse e-mail => direction@codi-one.fr             *
  * La conception est assujettie à une autorisation     *
  * spéciale de codi-one.com. Si vous ne disposez pas de*
  * cette autorisation, vous êtes dans l'illégalité.    *
  * L'auteur de la conception est et restera            *
  * codi-one.fr                                         *
  * Codage, script & images (all contenu) sont réalisés * 
  * par codi-one.fr                                     *
  * La conception est à usage unique et privé.          *
  * La tierce personne qui utilise le script se porte   *
  * garante de disposer des autorisations nécessaires   *
  *                                                     *
  * Copyright ... Tous droits réservés auteur (Fabien B)*
  \*****************************************************/

if(isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 1 ||
isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 4 ){

$idaction = $_POST['idaction'];

$id_module = $_POST['id_module'];
$id_groupe = $_POST['id_groupe'];

////////////////////////////AJOUTER
if($_POST['action'] == "Ajouter-action"){

///////////////////////////////INSERT
$sql_insert = $bdd->prepare("INSERT INTO configuration_membres_moderateurs_groupes_modules
	(id_module,
	id_groupe)
	VALUES (?,?)");
$sql_insert->execute(array(
	$id_module,
	$id_groupe));                     
$sql_insert->closeCursor();

$result = array("Texte_rapport"=>"Groupe rattaché au module !","retour_validation"=>"ok","retour_lien"=>"");

}
////////////////////////////AJOUTER


////////////////////////////MODIFIER
if($_POST['action'] == "Modifier-action"){

///////////////////////////////UPDATE
$sql_update = $bdd->prepare("UPDATE configuration_membres_moderateurs_groupes_modules SET 
	id_module=?, 
	id_groupe=?
	WHERE id=?");
$sql_update->execute(array(
	$id_module, 
	$id_groupe,
	$idaction));                     
$sql_update->closeCursor();

$result = array("Texte_rapport"=>"Modifications apportées avec succès !","retour_validation"=>"ok","retour_lien"=>"");

}
////////////////////////////MODIFIER

$result = json_encode($result);
echo $result;

}else{
header('location: /index.html');
}
ob_end_flush();
?>