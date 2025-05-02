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

if(isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 1 ||
isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 4 ){

$action = $_POST['action'];
$idaction = $_POST['idaction'];

$page_bandeau = $_POST['page_bandeau'];
$activer_bandeau_page = $_POST['activer_bandeau_page'];
$type_bandeau_page = $_POST['type_bandeau_page'];
$type_cible_page = $_POST['type_cible_page'];
$type_icone_page = $_POST['type_icone_page'];
$contenu_bandeau_page = $_POST['contenu_bandeau_page'];

/////////////ON SUPPRIME LE PROTOCOLE ET LE DOMAINE
if(strrpos($page_bandeau, "https://$nomsiteweb") !== false){
$page_bandeau = explode("https://$nomsiteweb",$page_bandeau);
$page_bandeau = $page_bandeau[1];
}
if(strrpos($page_bandeau, "http://$nomsiteweb") !== false){
$page_bandeau = explode("http://$nomsiteweb",$page_bandeau);
$page_bandeau = $page_bandeau[1];
}
if(strrpos($page_bandeau, "http://www.$nomsiteweb") !== false ){
$page_bandeau = explode("http://www.$nomsiteweb",$page_bandeau);
$page_bandeau = $page_bandeau[1];
}
if(strrpos($page_bandeau, "https://www.$nomsiteweb") !== false ){
$page_bandeau = explode("https://www.$nomsiteweb",$page_bandeau);
$page_bandeau = $page_bandeau[1];
}
if(strrpos($page_bandeau, "www.$nomsiteweb") !== false ){
$page_bandeau = explode("www.$nomsiteweb",$page_bandeau);
$page_bandeau = $page_bandeau[1];
}
/////////////ON SUPPRIME LE PROTOCOLE ET LE DOMAINE

/////////////SI PREMIER CARACTERE /
if(substr($page_bandeau,0,1) == "/"){
$page_bandeau = substr($page_bandeau,1);
}
/////////////SI PREMIER CARACTERE /

/////////////////////////////////////////Ajouter action
if($action == "Ajouter-action"){

///////////////////////////////INSERT
$sql_insert = $bdd->prepare("INSERT INTO pages_bandeaux 
	(page_bandeau,
	activer_bandeau_page,
	type_bandeau_page,
	type_cible_page,
	type_icone_page,
	contenu_bandeau_page)
	VALUES (?,?,?,?,?,?)");
$sql_insert->execute(array(
	$page_bandeau,
	$activer_bandeau_page,
	$type_bandeau_page,
	$type_cible_page,
	$type_icone_page,
	$contenu_bandeau_page
));                     
$sql_insert->closeCursor();

$result = array("Texte_rapport"=>"Bandeau ajouté avec succès !","retour_validation"=>"ok","retour_lien"=>"");

}
/////////////////////////////////////////Ajouter action


/////////////////////////////////////////Modification action
if($action == "Modifier-action"){

///////////////////////////////UPDATE
$sql_update = $bdd->prepare("UPDATE pages_bandeaux SET 
	page_bandeau=?,
	activer_bandeau_page=?,
	type_bandeau_page=?,
	type_cible_page=?,
	type_icone_page=?,
	contenu_bandeau_page=?
	WHERE id=?");
$sql_update->execute(array(
	$page_bandeau,
	$activer_bandeau_page,
	$type_bandeau_page,
	$type_cible_page,
	$type_icone_page,
	$contenu_bandeau_page,
	$idaction));                     
$sql_update->closeCursor();


$result = array("Texte_rapport"=>"Bandeau modifié avec succès !","retour_validation"=>"ok","retour_lien"=>"");

}
/////////////////////////////////////////Modification action

$result = json_encode($result);
echo $result;

}else{
header('location: /index.html');
}

ob_end_flush();
?>