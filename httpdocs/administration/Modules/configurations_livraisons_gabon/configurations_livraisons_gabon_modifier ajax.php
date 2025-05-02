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

$idaction = $_POST['idaction'];
$action = $_POST['action'];

$now = time();

	///////////////////////////////SELECT
	$req_select = $bdd->prepare("SELECT * FROM categories WHERE id=?");
	$req_select->execute(array($idaction));
	$ligne_select = $req_select->fetch();
	$req_select->closeCursor();
	

if(isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 1 ||
isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 2 ||
isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 3 ){

$now = time ();

$nom_livraison = $_POST['nom_livraison'];
$ville_livraison = $_POST['ville_livraison'];
$commentaire_livraison = $_POST['commentaire_livraison'];
$activer = $_POST['activer'];

////////////////////////////////////////////////////AJOUTER
if($action == "Ajouter-action"){

$sql_update = $bdd->prepare("INSERT INTO configurations_livraisons_gabon
	(
	nom_livraison,
	ville_livraison,
	commentaire_livraison,
	activer
	)
	VALUES (?,?,?,?)");
$sql_update->execute(
				array(
				$nom_livraison,
				$ville_livraison,
				$commentaire_livraison,
				$activer
					)
				);   
				
$sql_update->closeCursor();

$result = array("Texte_rapport"=>"Livraison créée avec succès !","retour_validation"=>"ok","retour_lien"=>"");

}
////////////////////////////////////////////////////AJOUTER


////////////////////////////////////////////////////MODIFIER
if($action == "Modifier-action"){

///////////////////////////////UPDATE
$sql_update = $bdd->prepare("UPDATE configurations_livraisons_gabon SET 
		nom_livraison=?,
		ville_livraison=?,
		commentaire_livraison=?,
		activer=?
	WHERE id=?");
$sql_update->execute(array(
		$nom_livraison,
		$ville_livraison,
		$commentaire_livraison,
		$activer,
		$_POST['idaction']));                     
$sql_update->closeCursor();

$result = array("Texte_rapport"=>"Livraison modifiée avec succès !","retour_validation"=>"ok","retour_lien"=>"");

}
////////////////////////////////////////////////////MODIFIER

$result = json_encode($result);
echo $result;

}else{
header('location: /index.html');
}

ob_end_flush();
?>