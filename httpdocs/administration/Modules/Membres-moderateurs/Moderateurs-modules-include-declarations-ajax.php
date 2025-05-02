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

if(isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user)){

$idaction = $_POST['idaction'];

$nom_module_moderateur = $_POST['nom_module_moderateur'];
$url_page_module_moderateur = $_POST['url_page_module_moderateur'];

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM configuration_membres_moderateurs_modules_liste WHERE url_page_module_moderateur=?");
$req_select->execute(array($url_page_module_moderateur));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$id = $ligne_select['id'];
$nom_module_moderateur = $ligne_select['nom_module_moderateur'];
$url_page_module_moderateur = $ligne_select['url_page_module_moderateur'];

////////////////////////////AJOUTER
if(empty($ligne_select['id'])){

///////////////////////////////INSERT
$sql_insert = $bdd->prepare("INSERT INTO configuration_membres_moderateurs_modules_liste 
	(nom_module_moderateur,
	url_page_module_moderateur)
	VALUES (?,?)");
$sql_insert->execute(array(
	$nom_module_moderateur,
	$url_page_module_moderateur));                     
$sql_insert->closeCursor();
///////////////////////////////On nomme l'url de la page si ce n'est pas un module

$result = array("Texte_rapport"=>"Module déclaré avec succès !","retour_validation"=>"ok","retour_lien"=>"");

////////////////////////////AJOUTER

////////////////////////////RETIRER
}else{

///////////////////////////////DELETE
$sql_delete = $bdd->prepare("DELETE FROM configuration_membres_moderateurs_modules_liste WHERE url_page_module_moderateur=?");
$sql_delete->execute(array($url_page_module_moderateur));                     
$sql_delete->closeCursor();

$result = array("Texte_rapport"=>"Module retiré avec succès !","retour_validation"=>"ok","retour_lien"=>"");

}
////////////////////////////RETIRER

$result = json_encode($result);
echo $result;

}else{
header('location: /index.html');
}
ob_end_flush();
?>