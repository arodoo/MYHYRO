<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../Configurations_bdd.php');
require_once('../../Configurations.php');
require_once('../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction= "../../";
require_once('../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

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

if(isset($user)){

	$sql_delete = $bdd->prepare("DELETE FROM membres_panier WHERE id_membre=?");
	$sql_delete->execute(array($id_oo));
	$sql_delete->closeCursor();

	$sql_delete = $bdd->prepare("DELETE FROM membres_panier_details WHERE id_membre=?");
	$sql_delete->execute(array($id_oo));
	$sql_delete->closeCursor();

	$req_bouclere = $bdd->prepare("SELECT * FROM membres_commandes WHERE user_id=? AND statut=3");
	$req_bouclere->execute(array(
		array($id_oo)
	));
	$ligne_bouclere = $req_bouclere->fetch();
	$req_bouclere->closeCursor();

	$sql_delete = $bdd->prepare("DELETE FROM membres_commandes WHERE user_id=? AND statut=3");
	$sql_delete->execute(array($id_oo));
	$sql_delete->closeCursor();

	$sql_delete = $bdd->prepare("DELETE FROM membres_commandes_details WHERE commande_id=?");
	$sql_delete->execute(array($ligne_bouclere['id']));
	$sql_delete->closeCursor();

	unset($_SESSION['id_commande']);

	$req_bouclere = $bdd->prepare("SELECT * FROM membres_colis WHERE user_id=? AND statut = 1");
	$req_bouclere->execute(array(
		array($id_oo)
	));
	$ligne_bouclere = $req_bouclere->fetch();
	$req_bouclere->closeCursor();


		$sql_delete = $bdd->prepare("DELETE FROM membres_colis WHERE user_id=? AND statut = 1");
		$sql_delete->execute(array($id_oo));
		$sql_delete->closeCursor();

		$sql_delete = $bdd->prepare("DELETE FROM membres_colis_details WHERE colis_id=?");
		$sql_delete->execute(array($ligne_bouclere['id']));
		$sql_delete->closeCursor();

		unset($_SESSION['id_colis']);

	$Abonnement_mode_paye = $_POST['Abonnement_mode_paye'];
	$_SESSION['Abonnement_mode_paye'] = $_POST['Abonnement_mode_paye'];

	$req_select3 = $bdd->prepare("SELECT * FROM configurations_abonnements WHERE id=?");
	$req_select3->execute(array($idaction));
	$ligne_select3 = $req_select3->fetch();
	$req_select3->closeCursor();

		$now = time();
		$now_expiration = date('d-m-Y', strtotime('+1 year', $now));

	/*$sql_update = $bdd->prepare("UPDATE membres SET 
		Abonnement_date=?,
		Abonnement_id=?,
		Abonnement_paye=?,
		Abonnement_mode_paye=?,
		Abonnement_date_expiration=?
		WHERE id=?");
	$sql_update->execute(array(
		time(),
		$idaction,
		'non',
		$Abonnement_mode_paye,
		$now,
		$id_oo));                     
	$sql_update->closeCursor();*/

	$libelle_details_article = "Abonnement : ".$ligne_select3['nom_abonnement']." - Date expiration $now_expiration";
	//var_dump($Tva_coef);
	$libelle_prix_articleht = ($ligne_select3['Prix']/(1+$Tva_coef));
	$libelle_prix_articleht = round($libelle_prix_articleht,2);
	$libelle_tva_article = ($ligne_select3['Prix']-$libelle_prix_articleht);
	$libelle_taux_tva_article = "$Taux_tva";
	$libelle_id_article = "$idaction"; 



	ajout_panier($libelle_details_article,"1",$libelle_prix_articleht,$libelle_tva_article,(1+$Tva_coef),"Abonnement",$action_parametres_valeurs_explode,$libelle_id_article,$user,"Abonnement","$idaction",time());



	if($Abonnement_mode_paye == 1 || $Abonnement_mode_paye == 4 || $Abonnement_mode_paye == 5 || $Abonnement_mode_paye == 6 || $Abonnement_mode_paye == 7 ){

		$req_select3 = $bdd->prepare("SELECT * FROM configurations_abonnements WHERE id=?");
		$req_select3->execute(array($idaction));
		$ligne_select3 = $req_select3->fetch();
		$req_select3->closeCursor();

		$result = array("Texte_rapport"=>"","retour_validation"=>"ok","retour_lien"=>"redirect");

	}else{

		$req_select33 = $bdd->prepare("SELECT * FROM configurations_modes_paiement WHERE id=?");
		$req_select33->execute(array($Abonnement_mode_paye));
		$ligne_select33 = $req_select33->fetch();
		$req_select33->closeCursor();

		$result = array("Texte_rapport"=>"Vous avez sélectionné le mode de paiement <b>".$ligne_select3['nom_mode']." </b>. Votre abonnement à été attribué, vous devez effectuer votre paiement. Pour effectuer le paiement : ".$ligne_select33['informations_mode'].". ","retour_validation"=>"ok","retour_lien"=>"");

	}

	$result = array("Texte_rapport"=>"","retour_validation"=>"ok","retour_lien"=>"");

	$result = json_encode($result);
	echo $result;

}else{
	header('location: /index.html');
}

ob_end_flush();
