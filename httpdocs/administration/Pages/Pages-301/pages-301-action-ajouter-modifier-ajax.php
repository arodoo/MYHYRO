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

if(isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 1 ||
isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 4 ){

	$idaction = $_POST['idaction'];

	$categorieone = $_POST['categorieone'];
	$postancienne = utf8_decode(urldecode($_POST['postancienne']));
	$postpagenouvelle = $_POST['postpagenouvelle'];
	$cateproduit = "";
	$produitone = "";
	$newsinfo301 = "";
	$partenaire301one = "";
	$photoone301 = "";
	$videosoneone301 = "";
	$infodeivers301 = "";

	if($categorieone == 1){
		$cateproduit = "oui";
	}elseif($categorieone == 2){
		$produitone = "oui";
	}elseif($categorieone == 3){
		$newsinfo301 = "oui";
	}elseif($categorieone == 4){
		$partenaire301one = "oui";
	}elseif($categorieone == 5){
		$photoone301 = "oui";
	}elseif($categorieone == 6){
		$videosoneone301 = "oui";
	}elseif($categorieone == 7){
		$infodeivers301 = "oui";
	}

	////////////////////////////AJOUTER
	if($_POST['action'] == "Ajouter-action"){
		unset($_SESSION['idsessionp404']);
		$sql_insert = $bdd->prepare("INSERT INTO pages_redirections_301
			(
			ancienne_page,
			nouvelle_page,
			categorie_produit,
			produit,
			photos,
			videos,
			news,
			parenariat,
			plus,
			plus1,
			plus2)
			VALUES (?,?,?,?,?,?,?,?,?,?,?)");
		$sql_insert->execute(array(
			$postancienne,
			'',
			$cateproduit,
			$produitone,
			$photoone301,
			$videosoneone301,
			$newsinfo301,
			$partenaire301one,
			$infodeivers301,
			'',
			''));                     
		$sql_insert->closeCursor();
		$result = array("Texte_rapport"=>"Ajouté avec succès !","retour_validation"=>"ok","retour_lien"=>"");
	}

	////////////////////////////MODIFIER
	if($_POST['action'] == "Modifier-action"){
		$sql_update = $bdd->prepare("UPDATE pages_redirections_301 SET 
			ancienne_page=?, 
			categorie_produit=?, 
			produit=?, 
			photos=?, 
			videos=?, 
			news=?, 
			parenariat=?, 
			plus=? 
			WHERE id=?");
		$sql_update->execute(array(
			$postancienne, 
			$cateproduit, 
			$produitone, 
			$photoone301, 
			$videosoneone301, 
			$newsinfo301, 
			$partenaire301one, 
			$infodeivers301, 
			$idaction));                     
		$sql_update->closeCursor();

		$result = array("Texte_rapport"=>"Modifié avec succès !","retour_validation"=>"ok","retour_lien"=>"");
	}

	echo json_encode($result);

} else{
	header('location: /index.html');
}
ob_end_flush();
?>