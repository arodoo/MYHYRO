<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../../../Configurations_bdd.php');
require_once('../../../../Configurations.php');
require_once('../../../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction= "../../../";
require_once('../../../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

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

$now = time();

$action = $_POST['action'];
$idaction = $_POST['idaction'];

$configurations_bandeau_avancement = $_POST['configurations_bandeau_avancement'];
$type_progress_bar = $_POST['type_progress_bar'];
$numero_progress_bar_panier = $_POST['numero_progress_bar_panier'];
$configurations_informations_champs_professionnels = $_POST['configurations_informations_champs_professionnels'];
$configurations_informations_champs_professionnels_obligatoire = $_POST['configurations_informations_champs_professionnels_obligatoire'];
$activer_bandeau_page_panier = $_POST['activer_bandeau_page_panier'];
$type_bandeau_page_panier = $_POST['type_bandeau_page_panier'];
$type_cible_page_panier = $_POST['type_cible_page_panier'];
$type_icone_page_panier = $_POST['type_icone_page_panier'];
$contenu_bandeau_page_panier = $_POST['contenu_bandeau_page_panier'];
$activer_bandeau_page_informations = $_POST['activer_bandeau_page_informations'];
$type_bandeau_page_informations = $_POST['type_bandeau_page_informations'];
$type_cible_page_informations = $_POST['type_cible_page_informations'];
$type_icone_page_informations = $_POST['type_icone_page_informations'];
$contenu_bandeau_page_informations = $_POST['contenu_bandeau_page_informations'];
$activer_bandeau_page_login = $_POST['activer_bandeau_page_login'];
$type_bandeau_page_login = $_POST['type_bandeau_page_login'];
$type_cible_page_login = $_POST['type_cible_page_login'];
$type_icone_page_login = $_POST['type_icone_page_login'];
$contenu_bandeau_page_login = $_POST['contenu_bandeau_page_login'];
$titre_page_paiement = $_POST['titre_page_paiement'];

///////////////////////////////UPDATE
$sql_update = $bdd->prepare("UPDATE configuration_paiement SET 
	titre_page_paiement =?,
	configurations_bandeau_avancement =?,
	type_progress_bar =?,
	numero_progress_bar_panier =?,
	configurations_informations_champs_professionnels =?,
	configurations_informations_champs_professionnels_obligatoire =?,
	activer_bandeau_page_panier =?,
	type_bandeau_page_panier =?,
	type_cible_page_panier =?,
	type_icone_page_panier =?,
	contenu_bandeau_page_panier =?,
	activer_bandeau_page_informations =?,
	type_bandeau_page_informations =?,
	type_cible_page_informations =?,
	type_icone_page_informations =?,
	contenu_bandeau_page_informations =?,
	activer_bandeau_page_login =?,
	type_bandeau_page_login =?,
	type_cible_page_login =?,
	type_icone_page_login =?,
	contenu_bandeau_page_login =?
	WHERE id=?");
$sql_update->execute(array(
	$titre_page_paiement,
	$configurations_bandeau_avancement,
	$type_progress_bar,
	$numero_progress_bar_panier,
	$configurations_informations_champs_professionnels,
	$configurations_informations_champs_professionnels_obligatoire,
	$activer_bandeau_page_panier,
	$type_bandeau_page_panier,
	$type_cible_page_panier,
	$type_icone_page_panier,
	$contenu_bandeau_page_panier,
	$activer_bandeau_page_informations,
	$type_bandeau_page_informations,
	$type_cible_page_informations,
	$type_icone_page_informations,
	$contenu_bandeau_page_informations,
	$activer_bandeau_page_login,
	$type_bandeau_page_login,
	$type_cible_page_login,
	$type_icone_page_login,
	$contenu_bandeau_page_login,
	'1'));                     
$sql_update->closeCursor();

$result = array("Texte_rapport"=>"Modifiées avec succès !","retour_validation"=>"ok","retour_lien"=>"");

$result = json_encode($result);
echo $result;

}else{
header('location: /index.html');
}

ob_end_flush();
?>