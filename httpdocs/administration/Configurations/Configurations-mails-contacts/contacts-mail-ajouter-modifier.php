<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../../Configurations_bdd.php');
require_once('../../../Configurations.php');
require_once('../../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction= "../../../";
require_once('../../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

$lasturl = $_SERVER['HTTP_REFERER'];

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

if(isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 1){

$posttelportable = $_POST['posttelportable'];
$posttelfixe = $_POST['posttelfixe'];

$postmailservice = $_POST['postmailservice'];
$postservice = $_POST['postservice'];
$statutpostmail = $_POST['statutpostmail'];
$statutpostmailsujet = $_POST['statutpostmailsujet'];

$position = $_POST['position'];

/////////////////////////////////////si action ajout inser
if($_POST['action'] == "Ajouter"){

///////////////////////////////INSERT
$sql_insert = $bdd->prepare("INSERT INTO contact
	(service,
	mail,
	activer,
	position)
	VALUES (?,?,?,?)");
$sql_insert->execute(array(
	$postservice,
	$postmailservice,
	$statutpostmail,
	$position));                     
$sql_insert->closeCursor();

$result = array("Texte_rapport"=>"Ajout effectué avec succès !","retour_validation"=>"ok","retour_lien"=>"");

}
/////////////////////////////////////si action ajout insert


/////////////////////////////////////si action modifier update
if($_POST['action'] == "Modifier"){

///////////////////////////////UPDATE
$sql_update = $bdd->prepare("UPDATE contact SET 
	position=?, 
	service=?, 
	mail=?, 
	activer=? 
	WHERE id=?");
$sql_update->execute(array(
	$position, 
	$postservice, 
	$postmailservice, 
	$statutpostmail, 
	$_POST['idaction']));                     
$sql_update->closeCursor();


$result = array("Texte_rapport"=>"Modifications effectuées ! ","retour_validation"=>"ok","retour_lien"=>"");

}
/////////////////////////////////////si action modifier update

$result = json_encode($result);
echo $result;

}else{
header('location: /index.html');
}

ob_end_flush();
?>