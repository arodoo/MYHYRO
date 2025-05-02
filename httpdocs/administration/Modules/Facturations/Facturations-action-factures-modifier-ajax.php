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

////////////////////////////MODIFIER
if($_POST['action'] == "Modifier-action"){

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM membres_prestataire_facture WHERE id=?");
$req_select->execute(array($idaction));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$id_facture = $ligne_select['id'];
$id_membre = $ligne_select['id_membre'];
$id_membrepseudo = $ligne_select['pseudo'];
$id_commercial = $ligne_select['id_commercial'];
$pseudo_commercial = $ligne_select['pseudo_commercial'];
$REFERENCE_NUMERO = $ligne_select['REFERENCE_NUMERO'];

$Titre_facture = $_POST['Titre_facture'];
$condition_reglement = $_POST['condition_reglement'];
$delai_livraison = $_POST['delai_livraison'];
$mod_paiement = $_POST['mod_paiement'];
$Suivi = $_POST['Suivi'];
$Commentaire_information = $_POST['Commentaire_information'];
$id_commercial = $_POST['id_commercial'];
$statut = $_POST['statut'];

//Commercial
///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM membres WHERE id=?");
$req_select->execute(array($id_commercial));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$idd_com = $ligne_select['id']; 
$pseudo_commercial = $ligne_select['pseudo']; 
$email_com = $ligne_select['mail'];
$nomm_com = $ligne_select['nom'];
$prenomm_com = $ligne_select['prenom'];
$telephoneposportable_com = $ligne_select['Telephone_portable'];
$pseudo_skype_com = $ligne_select['pseudo_skype'];

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM membres WHERE pseudo=?");
$req_select->execute(array($id_membrepseudo));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$idd2dddf = $ligne_select['id']; 
$loginm = $ligne_select['pseudo'];
$emailm = $ligne_select['mail'];
$adminm = $ligne_select['admin'];
$nomm = $ligne_select['nom'];
$prenomm = $ligne_select['prenom'];
$adressem = $ligne_select['adresse'];
$cpm = $ligne_select['cp'];
$villem = $ligne_select['ville'];

if($statut == "Activée"){

	///////////////////////////////SELECT
	$req_select = $bdd->prepare("SELECT * FROM configurations_pdf_devis_factures WHERE id=1");
	$req_select->execute();
	$ligne_select = $req_select->fetch();
	$req_select->closeCursor();
	$LAST_REFERENCE_FACTURE = $ligne_select['LAST_REFERENCE_FACTURE'];
	$LAST_REFERENCE_FACTURE = ($LAST_REFERENCE_FACTURE+1);

	///////////////////////////////UPDATE
	$sql_update = $bdd->prepare("UPDATE membres_prestataire_facture SET 
		REFERENCE_NUMERO=?,
		numero_facture=?
		WHERE id=?");
	$sql_update->execute(array(
		"FA-".$LAST_REFERENCE_FACTURE."", 
		"FA-".$LAST_REFERENCE_FACTURE."", 
		$idaction));                     
	$sql_update->closeCursor();

	$sql_update = $bdd->prepare("UPDATE configurations_pdf_devis_factures SET 
		LAST_REFERENCE_FACTURE=?
		WHERE id=?");
	$sql_update->execute(array(
		$LAST_REFERENCE_FACTURE,
		'1'));                     
	$sql_update->closeCursor();

///////////////////////////////UPDATE REFERENCE FACTURE - FACTURE DETAILS
$sql_update = $bdd->prepare("UPDATE membres_prestataire_facture_details SET 
	numero_facture=?
	WHERE numero_facture=?");
$sql_update->execute(array(
	"FA-".$LAST_REFERENCE_FACTURE."", 
	$REFERENCE_NUMERO));                     
$sql_update->closeCursor();

///////////////////////////////UPDATE
$sql_update = $bdd->prepare("UPDATE membres_prestataire_facture SET 
	mod_paiement=?, 
	Suivi=?,
	statut=?
	WHERE id=?");
$sql_update->execute(array(
	$mod_paiement, 
	$Suivi,
	$statut,
	$idaction));                     
$sql_update->closeCursor();

$result = array("Texte_rapport"=>"Modifié avec succès !","retour_validation"=>"ok","retour_lien"=>"refresh");

}else{

///////////////////////////////UPDATE
$sql_update = $bdd->prepare("UPDATE membres_prestataire_facture SET 
	id_commercial=?,
	pseudo_commercial=?,
	Titre_facture=?, 
	condition_reglement=?, 
	delai_livraison=?, 
	mod_paiement=?, 
	Suivi=?,
	Commentaire_information=?,
	statut=?
	WHERE id=?");
$sql_update->execute(array(
	$id_commercial,
	$pseudo_commercial,
	$Titre_facture, 
	$condition_reglement, 
	$delai_livraison, 
	$mod_paiement, 
	$Suivi,
	$Commentaire_information,
	$statut,
	$idaction));                     
$sql_update->closeCursor();

$result = array("Texte_rapport"=>"Modifié avec succès !","retour_validation"=>"ok","retour_lien"=>"");

}

}
////////////////////////////MODIFIER

$result = json_encode($result);
echo $result;

}else{
header('location: /index.html');
}
ob_end_flush();
?>