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


if(isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 1 ||
isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 2 ||
isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 3 ){

	$Abonnement_id = $_POST['Abonnement_id'];
	$date_new_expiration = $_POST['date_new_expiration'];

	$Abonnement_paye = $_POST['Abonnement_paye'];
	$Abonnement_mode_paye = $_POST['Abonnement_mode_paye'];
	$Abonnement_date_paye = $_POST['Abonnement_date_paye'];

	$Abonnement_message_demande = $_POST['message'];
	$Abonnement_statut_demande = $_POST['statut_2'];

	$activer_abo = $_POST['activer_abo'];

	$generer_facture = $_POST['generer_facture'];

	$req_select = $bdd->prepare("SELECT * FROM membres WHERE id=?");
	$req_select->execute(array($idaction));
	$ligne_select = $req_select->fetch();
	$req_select->closeCursor();
	$id_membre = $ligne_select['id']; 
	$pseudo = $ligne_select['pseudo'];
	$mail = $ligne_select['mail'];
	$Abonnement_date_expiration = $ligne_select['Abonnement_date_expiration']; 

	///////////////////////////////SELECT
	$req_select = $bdd->prepare("SELECT * FROM configurations_abonnements WHERE id=?");
	$req_select->execute(array($Abonnement_id));
	$ligne_select = $req_select->fetch();
	$req_select->closeCursor();
	$nom_abonnement = $ligne_select['nom_abonnement']; 
	$Prix = $ligne_select['Prix'];
	if(!empty($Prix) && !empty($Tva_coef)){ 
		$Prixht = ($Prix/$Tva_coef);
		$Prixht = round($Prixht,2);
		$Prixttc = ($Prix);
		$Prixttc = round($Prixttc,2);
	}

	$sql_update = $bdd->prepare("UPDATE membres SET 
			Abonnement_message_demande=?,
			Abonnement_statut_demande=?
			WHERE id=?");
		$sql_update->execute(array(
			$Abonnement_message_demande,
			$Abonnement_statut_demande,
			$_POST['idaction']));                     
		$sql_update->closeCursor();

		if($activer_abo == "oui" && $Abonnement_paye == "non"){
			$activer = false;
		}else{
			$activer = true;
		}
	////////////////////////////////////////////////////MODIFIER

	if($generer_facture == "oui" && !empty($Abonnement_mode_paye) && !empty($Abonnement_date_paye)  && !empty($Abonnement_id) && ( !empty($Abonnement_date_expiration) || !empty($date_new_expiration) ) || $generer_facture !="oui" && $activer){	

	if($action == "Modifier-action"){

		if(!empty($date_new_expiration) ){

			$date_new_expiration = explode('-', $date_new_expiration);
			$date_new_expiration = mktime(0, 0, 0, intval($date_new_expiration[1]), intval($date_new_expiration[2]), intval($date_new_expiration[0]));

			$sql_update = $bdd->prepare("UPDATE membres SET 
				Abonnement_date=?,
				Abonnement_date_expiration=?
				WHERE id=?");
			$sql_update->execute(array(
				time(),
				$date_new_expiration,
				$_POST['idaction']));                     
			$sql_update->closeCursor();

		}

		if(!empty($Abonnement_date_paye) ){

			$Abonnement_date_paye = explode('-', $Abonnement_date_paye);
			$Abonnement_date_paye = mktime(0, 0, 0, intval($Abonnement_date_paye[1]), intval($Abonnement_date_paye[2]), intval($Abonnement_date_paye[0]));

			$sql_update = $bdd->prepare("UPDATE membres SET 
				Abonnement_date_paye=?
				WHERE id=?");
			$sql_update->execute(array(
				$Abonnement_date_paye,
				$_POST['idaction']));                     
			$sql_update->closeCursor();

		}

		if($generer_facture == "oui" ){

	if(!empty($Abonnement_date_expiration)){
		$Abonnement_date_expiration = date('d-m-Y', $Abonnement_date_expiration);
		$Abonnement_date_expiration = " - Expiration de l'abonnement : $Abonnement_date_expiration";
	}

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM configurations_pdf_devis_factures WHERE id=1");
$req_select->execute();
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$LAST_REFERENCE_FACTURE = $ligne_select['LAST_REFERENCE_FACTURE'];
$LAST_REFERENCE_FACTURE = ($LAST_REFERENCE_FACTURE+1);

$sql_update = $bdd->prepare("UPDATE configurations_pdf_devis_factures SET 
	LAST_REFERENCE_FACTURE=?
	WHERE id=?");
$sql_update->execute(array(
	$LAST_REFERENCE_FACTURE,
	'1'));                     
$sql_update->closeCursor();

///////////////////////////////INSERT
$sql_insert = $bdd->prepare("INSERT INTO membres_prestataire_facture
	(id_membre,
	pseudo,
	REFERENCE_NUMERO,
	numero_facture,
	Suivi,
	departement,
	date_edition,
	jour_edition, 
	mois_edition, 
	annee_edition,
	Titre_facture,
	Tarif_HT,
	Tarif_HT_net,
	Tarif_TTC,
	Total_Tva,
	taux_tva,
	mod_paiement, 
	condition_reglement,
	delai_livraison,
	statut)
	VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
$sql_insert->execute(array(
	$id_membre,
	$pseudo,
	$LAST_REFERENCE_FACTURE,
	$LAST_REFERENCE_FACTURE,
	'payer',
	$Code_departement,
	time(),
	date('d',time()),
	date('m',time()),
	date('Y',time()),
	"Abonnement",	
	$Prixht,
	$Prixht,
	$Prixttc,
	$Tva_coef,
	$Taux_tva,
	$Abonnement_mode_paye,
	'A réception',
	'A réception',
	'Activée'));                     
$sql_insert->closeCursor();

///////////////////////////////INSERT
$sql_insert = $bdd->prepare("INSERT INTO membres_prestataire_facture_details
	(id_membre,
	pseudo,
	numero_facture,
	libelle,
	PU_HT,
	quantite,
	REFERENCE_DETAIL,
	Type_detail)
	VALUES (?,?,?,?,?,?,?,?)");
$sql_insert->execute(array(
	$id_membre,
	$pseudo,
	$LAST_REFERENCE_FACTURE,
	"Abonnement : $nom_abonnement $Abonnement_date_expiration",
	$Prixht,
	"1",
	"1",
	""));                     
$sql_insert->closeCursor();

			$sql_update = $bdd->prepare("UPDATE membres SET 
				Abonnement_last_facture_numero=?
				WHERE id=?");
			$sql_update->execute(array(
				$LAST_REFERENCE_FACTURE,
				$_POST['idaction']));                     
			$sql_update->closeCursor();

		}

		if($activer_abo == "oui"){
			$Abonnement_id = $_POST['abo_demande'];
		}

		$sql_update = $bdd->prepare("UPDATE membres SET 
			Abonnement_id=?,
			Abonnement_paye=?,
			Abonnement_mode_paye=?
			WHERE id=?");
		$sql_update->execute(array(
			$Abonnement_id,
			$Abonnement_paye,
			$Abonnement_mode_paye,
			$_POST['idaction']));                     
		$sql_update->closeCursor();

		$result = array("Texte_rapport"=>"Abonnement modifié avec succès !","retour_validation"=>"ok","retour_lien"=>"");
	}

}elseif(empty($Abonnement_id)){
	$result = array("Texte_rapport"=>"Sélectionnez un abonnement !","retour_validation"=>"","retour_lien"=>"");

}elseif($activer == false){
	$result = array("Texte_rapport"=>"L'abonnement doit être payé pour l'activer !","retour_validation"=>"","retour_lien"=>"");

}else{
	$result = array("Texte_rapport"=>"Indiquez un mode et une date de paiement !","retour_validation"=>"","retour_lien"=>"");
}

	echo json_encode($result);

}else{
	header('location: /index.html');
}

ob_end_flush();
?>