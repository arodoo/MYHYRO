<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../../../Configurations_bdd.php');
require_once('../../../../Configurations.php');
require_once('../../../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction = "../../../../";
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

//////////////////////////////////////////////REMISE / CODE PROMOTION
if ($_POST['remise'] == "oui" && $_SESSION['total_HT'] > 0) {

	///////////////////////////////SELECT
	$req_select = $bdd->prepare("SELECT * FROM codes_promotion WHERE numero_code=?");
	$req_select->execute(array($_POST['code_promo']));
	$ligne_select = $req_select->fetch();
	$req_select->closeCursor();
	$id_Code_promotion_idd = $ligne_select['id'];
	$numero_code = $ligne_select['numero_code'];
	$prix_offert = $ligne_select['prix_offert'];
	$nbr_utilisation_fin = $ligne_select['nbr_utilisation_fin'];
	$nbr_utilisation_en_cours = $ligne_select['nbr_utilisation_en_cours'];
	$date_debut = $ligne_select['date_debut'];
	$date_fin = $ligne_select['date_fin'];
	$destination = $ligne_select['destination'];

	///////////////////////////////SELECT
	$req_select = $bdd->prepare("SELECT * FROM membres_codes_promo WHERE code_promo=? AND id_membre=?");
	$req_select->execute(array($_POST['code_promo'], $id_oo));
	$ligne_select_mc = $req_select->fetch();
	$req_select->closeCursor();
	$code_utilise = $ligne_select_mc['id'];

	///////////////////////////////SELECT
	$req_select = $bdd->prepare("SELECT * FROM membres_panier WHERE code_promotion=? AND (id_membre=?)");
	$req_select->execute(array($_POST['code_promo'], $id_oo));
	$ligne_select_mp = $req_select->fetch();
	$req_select->closeCursor();
	$code_utilise2 = $ligne_select_mp['id'];


	//////////////////////SI TOUS LES CONTRÔLES PASSENT
	if (empty($code_utilise) && empty($code_utilise2) && !empty($id_Code_promotion_idd) && !empty($prix_offert) && $nbr_utilisation_en_cours <= $nbr_utilisation_fin) {

		//////////////ON MET A JOUR LES TOTAUX DU PANIER
		///////////////////////////////SELECT BOUCLE
		$remisett = 0;
		$req_boucle = $bdd->prepare("SELECT * FROM membres_panier_details WHERE id_membre=? OR (pseudo=? || pseudo=? ) AND PU_HT > 0");
		$req_boucle->execute(array($id_oo, $user, $_SESSION['pseudo_panier']));
		while ($ligne_boucle = $req_boucle->fetch()) {
			$idoneinfos_artciles_fiche_panier = $ligne_boucle['id'];
			$PU_HT_artciles_fiche_panier = $ligne_boucle['PU_HT'];
			$TVA = $ligne_boucle['TVA'];
			$TVA_TAUX = $ligne_boucle['TVA_TAUX'];
			$action_module_service_produit = $ligne_boucle['action_module_service_produit'];
			$Duree_service = $ligne_boucle['Duree_service'];
			$quantite_artciles_fiche_panier = $ligne_boucle['quantite'];

			$PU_HT = ($PU_HT_artciles_fiche_panier);
			$_SESSION['PU_HT_ORIGINAL'][$idoneinfos_artciles_fiche_panier] = $PU_HT_artciles_fiche_panier;

			$PU_HT_REMISE = round(($PU_HT - ($PU_HT * ($prix_offert / 100))), 2);
			$TVA = (($PU_HT_REMISE * $TVA_TAUX) - $PU_HT_REMISE);
			$PU_TTC = ($PU_HT_REMISE + $TVA);

			$remise = $PU_HT - $PU_HT_REMISE;

			$remisett += $remise;

			$_SESSION['PU_HT_UPDATED'][$idoneinfos_artciles_fiche_panier] = $PU_HT_REMISE;


			$PU_HT_TOTAUX = (($PU_HT * $quantite_artciles_fiche_panier));
			$PU_HT_REMISE_TOTAUX = ($PU_HT_TOTAUX - ($PU_HT_TOTAUX * ($prix_offert / 100)));
			$TOTAL_REMISE = (($PU_HT_TOTAUX - $PU_HT_REMISE_TOTAUX));

			$TVA_TOTAUX = ($TVA_TOTAUX + $TVA);
			$PU_TTC_TOTAUX = ($PU_TTC_TOTAUX + ($PU_HT_REMISE_TOTAUX + $TVA_TOTAUX));

			if ($ligne_boucle['TVA_TAUX'] == "1.20") {
				$PU_TVA_TOTAUX += ($PU_TVA_TOTAUX + ($TVA * $quantite_artciles_fiche_panier));
			}
			if ($ligne_boucle['TVA_TAUX'] == "1.055") {
				$PU_TVA2_TOTAUX += ($PU_TVA2_TOTAUX + ($TVA * $quantite_artciles_fiche_panier));
			}

			//UPDATE SQL
			///////////////////////////////UPDATE
			$sql_update = $bdd->prepare("UPDATE membres_panier_details SET 
							PU_HT=?, 
							TVA=? 
							WHERE id=?");
			$sql_update->execute(array(
				$PU_HT_REMISE,
				$TVA,
				$ligne_boucle['id']
			));
			$sql_update->closeCursor();
		}

		//////////////ON MET A JOUR LES TOTAUX DU PANIER
		//var_dump($PU_TVA_TOTAUX, $PU_HT_REMISE, $PU_HT_REMISE_TOTAUX, $TVA);

		$prix = sprintf('%.2f', ($PU_HT_REMISE_TOTAUX));
		$tva = ($PU_HT_REMISE_TOTAUX * .20);

		//UPDATE SQL
		///////////////////////////////UPDATE
		$sql_update = $bdd->prepare("UPDATE membres_panier SET 
						Tarif_HT=?, 
						Tarif_HT_net=?, 
						Tarif_TTC=?, 
						Total_Tva=?,
						Total_Tva2=?,
						code_promotion=?, 
						Remise=?
						WHERE pseudo=? OR id_membre=? ");
		$sql_update->execute(array(
			$PU_HT_TOTAUX,
			$PU_HT_REMISE_TOTAUX,
			$PU_TTC_TOTAUX,
			$PU_TVA_TOTAUX,
			$PU_TVA2_TOTAUX,
			$_POST['code_promo'],
			$remisett,
			$user,
			$id_oo
		));
		$sql_update->closeCursor();

		if (!empty($_SESSION['id_commande'])) {

			$sql_update = $bdd->prepare("UPDATE membres_commandes SET 
						prix_reduction=?,
						code_promo=?
						WHERE id=? ");
			$sql_update->execute(array(
				$remisett,
				$_POST['code_promo'],
				$_SESSION['id_commande']
			));
			$sql_update->closeCursor();
		}

		if (!empty($_SESSION['id_colis'])) {

			$sql_update = $bdd->prepare("UPDATE membres_colis SET 
						prix_reduction=?,
						code_promo=?
						WHERE id=? ");
			$sql_update->execute(array(
				$remisett,
				$_POST['code_promo'],
				$_SESSION['id_colis']
			));
			$sql_update->closeCursor();
		}
		//ajout_panier("Code promotion ".$_POST['code_promo']." ".$prix_offert."% ($TOTAL_REMISE Euros)","1","0","0","0","Code promotion",$action_parametres_valeurs_explode,"",$user);


		/*///////////////////////////////DELETE
					$sql_delete = $bdd->prepare("DELETE FROM membres_panier WHERE pseudo=?");
					$sql_delete->execute(array($user));
					$sql_delete->closeCursor();

					///////////////////////////////DELETE
					$sql_delete = $bdd->prepare("DELETE FROM membres_panier_details WHERE pseudo=?");
					$sql_delete->execute(array($user));
					$sql_delete->closeCursor();*/

		//ajout_panier($quantite_artciles_fiche_panier." ".$action_module_service_produit." avec Code promotion ".$_POST['code_promo']." ".$prix_offert."% ($TOTAL_REMISE Euros)","1",$prix,$tva,"1.20",$action_module_service_produit,$Duree_service,$id_oo,$user);

		//UPDATE SQL
		///////////////////////////////UPDATE
		$sql_update = $bdd->prepare("UPDATE membres_panier SET 
						code_promotion=?
						WHERE pseudo=? || pseudo=? ");
		$sql_update->execute(array(
			$_POST['code_promo'],
			$user,
			$_SESSION['pseudo_panier']
		));
		$sql_update->closeCursor();
		/////////////////SESSION CODE PROMO
		$code_remise_valide = "oui";
		$_SESSION['code_promo'] = $_POST['code_promo'];
		$_SESSION['remise_panier_facture'] = "$prix_offert";
		$_SESSION['remise_panier_facture_infos'] = "-" . $prix_offert . "%";
		$_SESSION['code_promo'] = $_POST['code_promo'];
		/////////////////SESSION CODE PROMO
		$result = array("Texte_rapport" => "Le code promotion est valide  !", "retour_validation" => "ok", "retour_lien" => "");
	} elseif (!empty($code_utilise)) {
		$result = array("Texte_rapport" => "Vous avez déjà utilisé le code promotion !", "retour_validation" => "", "retour_lien" => "");
	} elseif (!empty($code_utilise2)) {
		$result = array("Texte_rapport" => "Vous ne pouvez pas utiliser le même code !", "retour_validation" => "", "retour_lien" => "");
	} else {
		$result = array("Texte_rapport" => "Le code promotion n'est pas valide !", "retour_validation" => "", "retour_lien" => "");
	}
} else {
	$result = array("Texte_rapport" => "Le montant doit être supérieur à 0€ !", "retour_validation" => "", "retour_lien" => "");
}

$result = json_encode($result);
echo $result;

ob_end_flush();
