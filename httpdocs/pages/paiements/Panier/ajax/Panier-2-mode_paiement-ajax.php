<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../../../Configurations_bdd.php');
require_once('../../../../Configurations.php');
require_once('../../../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction= "../../../../";
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

$id_panier_detail = $_POST['id_panier_detail'];
$id_page_panier = $_POST['id_page_panier'];
$type_action = $_POST['type_action'];

$_SESSION['id_paiement'] = $_POST['checkout_payment_method2'];


///////////////////////////////SELECT ABONNEMENT
$req_selectap = $bdd->prepare("SELECT * FROM configurations_modes_paiement WHERE id=?");
$req_selectap->execute(array($_POST['checkout_payment_method2']));
$ligne_selectap = $req_selectap->fetch();
$req_selectap->closeCursor();

						/*///////////////////////////////SELECT ABONNEMENT
						$req_selecta = $bdd->prepare("SELECT * FROM configurations_modes_paiement_conditions WHERE id=?");
						$req_selecta->execute(array("1"));
						$ligne_selecta = $req_selecta->fetch();
						$req_selecta->closeCursor();

						if($Abonnement_id == 1){

							$taux_avance_60_pourcent = $ligne_selecta['abo_1_avancement_60_pourcent_taux_avance'];
							$taux_avance_2_fois = $ligne_selecta['abo_1_paiement_2_fois_taux_avance'];
							$taux_avance_3_fois = $ligne_selecta['abo_1_paiement_3_fois_taux_avance'];

							$frais_gestion_60_pourcent = $ligne_selecta['abo_1_avancement_60_pourcent_frais_gestion'];
							$frais_gestion_paiement_2_fois = $ligne_selecta['abo_1_paiement_2_fois_frais_gestion'];
							$frais_gestion_paiement_3_fois = $ligne_selecta['abo_1_paiement_3_fois_frais_gestion'];

						}elseif($Abonnement_id == 2){

							$taux_avance_60_pourcent = $ligne_selecta['abo_2_avancement_60_pourcent_taux_avance'];
							$taux_avance_2_fois = $ligne_selecta['abo_2_paiement_2_fois_taux_avance'];
							$taux_avance_3_fois = $ligne_selecta['abo_2_paiement_3_fois_taux_avance'];

							$frais_gestion_60_pourcent = $ligne_selecta['abo_2_avancement_60_pourcent_frais_gestion'];
							$frais_gestion_paiement_2_fois = $ligne_selecta['abo_2_paiement_2_fois_frais_gestion'];
							$frais_gestion_paiement_3_fois = $ligne_selecta['abo_2_paiement_3_fois_frais_gestion'];

						}elseif($Abonnement_id == 3){

							$taux_avance_60_pourcent = $ligne_selecta['abo_3_avancement_60_pourcent_taux_avance'];
							$taux_avance_2_fois = $ligne_selecta['abo_3_paiement_2_fois_taux_avance'];
							$taux_avance_3_fois = $ligne_selecta['abo_3_paiement_3_fois_taux_avance'];

							$frais_gestion_60_pourcent = $ligne_selecta['abo_3_avancement_60_pourcent_frais_gestion'];
							$frais_gestion_paiement_2_fois = $ligne_selecta['abo_3_paiement_2_fois_frais_gestion'];
							$frais_gestion_paiement_3_fois = $ligne_selecta['abo_3_paiement_3_fois_frais_gestion'];

						}
	
						///////////////////////////////DELETE
						$sql_delete = $bdd->prepare("DELETE FROM membres_panier_details WHERE id_membre=? AND action_module_service_produit=?");
						$sql_delete->execute(array($id_oo,"Frais gestion de paiement"));                     
						$sql_delete->closeCursor();

						//FRAIS DE GESTION
						//avance 60%
						if($_POST['checkout_payment_method'] == 7 && $frais_gestion_60_pourcent > 0 ){
							
							$frais_gestion_60_pourcent = ($ligne_select['Tarif_TTC']*$frais_gestion_60_pourcent);
							$frais_gestion_60_pourcent = round($frais_gestion_60_pourcent,2);
							$frais_gestion_60_pourcent_ttc = ($frais_gestion_60_pourcent*1.20); 
							$frais_gestion_60_pourcent_ttc = round($frais_gestion_60_pourcent_ttc,2); 
							$frais_gestion_60_pourcent_tva = ($frais_gestion_60_pourcent_ttc-$frais_gestion_60_pourcent); 
							$libelle = "Frais gestion de paiement";
							$_SESSION['frais_gestion'] = $frais_gestion_60_pourcent; 
							ajout_panier($libelle, 1, $frais_gestion_60_pourcent, $frais_gestion_60_pourcent_tva, "1.20", $libelle, "", $libelle_id_article, $user);		

						}
						//avance 3 fois
						if($_POST['checkout_payment_method'] == 6 && $frais_gestion_paiement_3_fois > 0 ){
						
							$frais_gestion_3_fois = ($ligne_select['Tarif_TTC']*$frais_gestion_3_fois);
							$frais_gestion_3_fois = round($frais_gestion_3_fois,2);
							$frais_gestion_3_fois_ttc = ($frais_gestion_3_fois*1.20); 
							$frais_gestion_3_fois_ttc = round($frais_gestion_3_fois_ttc,2); 
							$frais_gestion_3_fois_tva = ($frais_gestion_3_fois_ttc-$frais_gestion_3_fois);
							$libelle = "Frais gestion de paiement";
							$_SESSION['frais_gestion'] = $frais_gestion_3_fois; 
							ajout_panier($libelle, 1, $frais_gestion_3_fois, $frais_gestion_3_fois_tva, "1.20", $libelle, "", $libelle_id_article, $user);		

						}
						//avance 2 fois
						if($_POST['checkout_payment_method'] == 5 && $frais_gestion_paiement_2_fois > 0 ){

							$frais_gestion_2_fois = ($ligne_select['Tarif_TTC']*$frais_gestion_2_fois);
							$frais_gestion_2_fois = round($frais_gestion_2_fois,2);
							$frais_gestion_2_fois_ttc = ($frais_gestion_2_fois*1.20); 
							$frais_gestion_2_fois_ttc = round($frais_gestion_2_fois_ttc,2); 
							$frais_gestion_2_fois_tva = ($frais_gestion_2_fois_ttc-$frais_gestion_2_fois);	
							$libelle = "Frais gestion de paiement";
							$_SESSION['frais_gestion'] = $frais_gestion_2_fois; 
							ajout_panier($libelle, 1, $frais_gestion_2_fois, $frais_gestion_2_fois_tva, "1.20", $libelle, "", $libelle_id_article, $user);		
				
						}*/

	///////////////////////////////UPDATE
	$sql_update = $bdd->prepare("UPDATE membres_panier SET 
	id_paiement=?
	WHERE id_membre=?");
	$sql_update->execute(array(
	$_SESSION['id_paiement'],
	$id_oo));                     
	$sql_update->closeCursor();


$result = array("Texte_rapport"=>"Mode de paiement mise à jour.","retour_validation"=>"ok","retour_lien"=>"");

$result = json_encode($result);
echo $result;

ob_end_flush();
?>