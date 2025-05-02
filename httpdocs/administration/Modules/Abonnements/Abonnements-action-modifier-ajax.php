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

if(isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 1 ||
isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 2 ||
isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 3 ){

$now = time ();

$nom_abonnement = $_POST['nom_abonnement'];
$Gestion_de_la_commande = $_POST['Gestion_de_la_commande'];
$Prix = $_POST['Prix'];
$Frais_de_douane = $_POST['Frais_de_douane'];
$Douane_et_transport = $_POST['Douane_et_transport'];
$Livraison_a_vos_proche_en_France = $_POST['Livraison_a_vos_proche_en_France'];
$Fret_Envoyer_un_colis = $_POST['Fret_Envoyer_un_colis'];
$Liste_de_souhaits = $_POST['Liste_de_souhaits'];
$Passer_commande_en_agence = $_POST['Passer_commande_en_agence'];
$Service_client_vous_contact = $_POST['Service_client_vous_contact'];
$Livraison_a_domicile = $_POST['Livraison_a_domicile'];
$Paiement_en_2_ou_3_fois = $_POST['Paiement_en_2_ou_3_fois'];
$Avancement_de_60_pourcent = $_POST['Avancement_de_60_pourcent'];
$Frais_de_gestion_d_une_commande = $_POST['Frais_de_gestion_d_une_commande'];
$Montant_minimum = $_POST['Montant_minimum'];

////////////////////////////////////////////////////AJOUTER
if($action == "Ajouter-action"){

$sql_update = $bdd->prepare("INSERT INTO configurations_abonnements
	(
	nom_abonnement,
	Prix,
	Douane_et_transport,
	Liste_de_souhaits,
	Frais_de_gestion_d_une_commande,
	Montant_minimum
	)
	VALUES (?,?,?,?,?,?)");
$sql_update->execute(
				array(
	$nom_abonnement,
	$Prix,
	$Douane_et_transport,
	$Liste_de_souhaits,
	$Frais_de_gestion_d_une_commande,
	$Montant_minimum )
				);   
				
$sql_update->closeCursor();

$result = array("Texte_rapport"=>"Abonnement créé avec succès !","retour_validation"=>"ok","retour_lien"=>"");

}
////////////////////////////////////////////////////AJOUTER


////////////////////////////////////////////////////MODIFIER
if($action == "Modifier-action"){

///////////////////////////////UPDATE
$sql_update = $bdd->prepare("UPDATE configurations_abonnements SET 
	nom_abonnement=?,
	Prix=?,
	Douane_et_transport=?,
	Liste_de_souhaits=?,
	Frais_de_gestion_d_une_commande=?,
	Montant_minimum=?
	WHERE id=?");
$sql_update->execute(array(
	$nom_abonnement,
	$Prix,
	$Douane_et_transport,
	$Liste_de_souhaits,
	$Frais_de_gestion_d_une_commande,
	$Montant_minimum,
	$_POST['idaction']));                     
$sql_update->closeCursor();

$result = array("Texte_rapport"=>"Abonnement modifié avec succès !","retour_validation"=>"ok","retour_lien"=>"");

}
////////////////////////////////////////////////////MODIFIER

$result = json_encode($result);
echo $result;

}else{
header('location: /index.html');
}

ob_end_flush();
?>