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
isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 2 ||
isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 3 ){

$action = $_POST['action'];
$idaction = $_POST['idaction'];
$now = time();

$titre_code_promo = $_POST['titre_code_promo'];
$code_promo_number = $_POST['code_promo_number'];
$jours_offerts_post = $_POST['jours_offerts_post'];
$nbr_utilisation_LIMITE_post = $_POST['nbr_utilisation_LIMITE_post'];
$nbr_utilisation_ENCOURS_post = $_POST['nbr_utilisation_ENCOURS_post'];
$destination_post = $_POST['destination_post'];
$afficher_page = $_POST['afficher_page'];

$date_debut_post = mktime(0, 0, 0, intval($_POST['mois1']), intval($_POST['jour1']), intval($_POST['annee1']));
$date_fin_post = mktime(0, 0, 0, intval($_POST['mois2']), intval($_POST['jour2']), intval($_POST['annee2']));

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM codes_promotion WHERE id=?");
$req_select->execute(array($idaction));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$idnewwsm_code_actuel = $ligne_select['id'];
$numero_code = $ligne_select['numero_code'];

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM codes_promotion WHERE numero_code=? AND numero_code!=?");
$req_select->execute(array($code_promo_number,$numero_code));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$idnewwsm = $ligne_select['id'];

////////////////////////////////////////////////////////////////////////////////AJOUTER / ACTION
if($action == "Ajouter-action" && empty($idnewwsm) && !empty($code_promo_number)){

///////////////////////////////INSERT
$sql_insert = $bdd->prepare("INSERT INTO codes_promotion
	(Titre_promo,
	numero_code,
	prix_offert,
	nbr_utilisation_fin,
	nbr_utilisation_en_cours,
	date_debut,
	date_fin,
	destination,
	plus,
	plus1)
	VALUES (?,?,?,?,?,?,?,?,?,?)");
$sql_insert->execute(array(
	$titre_code_promo,
	$code_promo_number,
	$jours_offerts_post,
	$nbr_utilisation_LIMITE_post,
	$nbr_utilisation_ENCOURS_post,
	$date_debut_post,
	$date_fin_post,
	$destination_post,
	$afficher_page,
	''));                     
$sql_insert->closeCursor();

$result = array("Texte_rapport"=>"Code promo ajouté avec succès !","retour_validation"=>"ok","retour_lien"=>"");

}elseif(empty($code_promo_number) && $action == "Ajouter-action"){
$result = array("Texte_rapport"=>"Indiquer un code promotion !","retour_validation"=>"","retour_lien"=>"");

}elseif(!empty($idnewwsm) && $action == "Ajouter-action"){
$result = array("Texte_rapport"=>"Le code existe déjà !","retour_validation"=>"","retour_lien"=>"");

}

////////////////////////////////////////////////////////////////////////////////AJOUTER / ACTION


////////////////////////////////////////////////////////////////////////////////MODIFIER / ACTION
if($action == "Modifier-action" && !empty($code_promo_number) && empty($idnewwsm) ){

///////////////////////////////UPDATE
$sql_update = $bdd->prepare("UPDATE codes_promotion SET 
	destination=?, 
	Titre_promo=?, 
	numero_code=?, 
	prix_offert=?,
	nbr_utilisation_fin=?, 
	nbr_utilisation_en_cours=?, 
	date_debut=?, 
	date_fin=?,
	plus=?
	WHERE id=?");
$sql_update->execute(array(
	$destination_post, 
	$titre_code_promo, 
	$code_promo_number, 
	$jours_offerts_post,
	$nbr_utilisation_LIMITE_post, 
	$nbr_utilisation_ENCOURS_post, 
	$date_debut_post, 
	$date_fin_post,
	$afficher_page,
	$idaction));                     
$sql_update->closeCursor();

$result = array("Texte_rapport"=>"Code promotion modifié avec succès !","retour_validation"=>"ok","retour_lien"=>"");

}elseif(empty($code_promo_number) && $action == "Modifier-action"){
$result = array("Texte_rapport"=>"Indiquer un code promotion !","retour_validation"=>"","retour_lien"=>"");

}elseif(!empty($idnewwsm) && $action == "Modifier-action"){
$result = array("Texte_rapport"=>"Le code existe déja !","retour_validation"=>"","retour_lien"=>"");

}
////////////////////////////////////////////////////////////////////////////////MODIFIER / ACTION

$result = json_encode($result);
echo $result;

}else{
header('location: /index.html');
}

ob_end_flush();
?>