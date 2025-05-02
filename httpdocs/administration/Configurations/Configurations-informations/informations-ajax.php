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

	$sql_update = $bdd->prepare("UPDATE informations_structure SET 
		Nom_i=?,
		statut_entreprise_i=?,
		Siret_i=?,
		TVA_intra_i=?,
		adresse_i=?,
		ville_i=?,
		cp_dpt_i=?,
		pays_i=?,
		telephone_fixe_i=?,
		telephone_portable_i=?,
		text_i=?
		WHERE id=?");
	$sql_update->execute(array(
		$_POST['Nom_i_post'],
		$_POST['statut_entreprise_i_post'],
		$_POST['Siret_i_post'],
		$_POST['TVA_intra_i_post'],
		$_POST['adresse_i_post'],
		$_POST['ville_i_post'],
		$_POST['cp_dpt_i_post'],
		$_POST['pays_i_post'],
		$_POST['telephone_fixe_i_post'],
		$_POST['telephone_portable_i_post'],
		$_POST['text_i_post'],
		'1'));                     
	$sql_update->closeCursor();

	$result = array("Texte_rapport"=>"Action effectuée avec succès!","retour_validation"=>"ok","retour_lien"=>"");
	echo json_encode($result);

} else{
	header('location: /index.html');
}

ob_end_flush();
?>