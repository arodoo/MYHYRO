<?php

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

//include('../../function/function_ajout_panier.php');
//ajout_panier($libelle_details_article,$libelle_quantite_article,$libelle_prix_article,$action_module_apres_paiement,$action_parametres_valeurs_explode,$type_panier);
//$action_module_apres_paiement => Permet de récupérer uen valeur après paiement et d'effectuer des conditions pour les actions ... (Optionnel)
//$action_parametres_valeurs_explode => On peut y passer des valeurs afin de els récupérer avec un explode après paiement ex : 50,100,action1 ... (Optionnel)
//$libelle_id_article => id de l'article si il y en a un ... (Optionnel)

//METHODE ajout_panier("Le libellé du produit","1","100.00","Services quotas","","","Paypal"); // RETURN => $informations_cretaion_panier;

////////////////METHODE

function ajout_panier($libelle_details_article, $libelle_quantite_article, $libelle_prix_article, $libelle_tva_article, $libelle_taux_tva_article, $action_module_apres_paiement, $action_parametres_valeurs_explode, $libelle_id_article, $pseudo_panier, $categorie, $id_service, $date)
{

	global $bdd;
	global $user;
	global $id_oo;
	global $nomsiteweb;

	//$sql_delete = $bdd->prepare("DELETE FROM membres_panier WHERE pseudo=?");
	//$sql_delete->execute(array($pseudo_panier));
	//$sql_delete->closeCursor();

	//$sql_delete = $bdd->prepare("DELETE FROM membres_panier_details WHERE pseudo=?");
	//$sql_delete->execute(array($pseudo_panier));
	//$sql_delete->closeCursor();

	///////////////////////////////SELECT
	$req_select = $bdd->prepare("SELECT * FROM membres WHERE pseudo=?");
	$req_select->execute(array($pseudo_panier));
	$ligne_select = $req_select->fetch();
	$req_select->closeCursor();
	$id_oo = $ligne_select['id'];

	$now = time();

	///////////////ON CONTRÔLE SI UN PANIER EXISTE PAS
	///////////////////////////////SELECT
	$req_select = $bdd->prepare("SELECT * FROM membres_panier 
	WHERE pseudo=?
	AND Suivi=?");
	$req_select->execute(array(
		$pseudo_panier,
		"non traite"
	));
	$ligne_select = $req_select->fetch();
	$req_select->closeCursor();
	$id_panier = $ligne_select['id'];
	$numero_panier_ff = $ligne_select['numero_panier'];

	///////////////////////////Si pas de panier courant
	if (empty($id_panier)) {

		if ($action_module_apres_paiement == "Abonnement") {
			$objet_panier = "Abonnement";
		} else {
			$objet_panier = "Commande";
		}

		///////////////////////////////INSERT
		$sql_insert = $bdd->prepare("INSERT INTO membres_panier
	(id_membre,
	pseudo,
	numero_panier,
	id_facture,
	Titre_panier,
	Contenu,
	Suivi,
	date_edition,
	mod_paiement,
	Tarif_HT,
	Remise,
	Tarif_HT_net,
	Tarif_TTC,
	Total_Tva,
	taux_tva,
	Total_tva2,
	taux_tva2,
	Type_compte_F,
	type_panier
	)
	VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
		$sql_insert->execute(array(
			$id_oo,
			$pseudo_panier,
			'',
			'',
			$objet_panier,
			$objet_panier,
			'non traite',
			$now,
			'',
			htmlspecialchars($Tarif_HT),
			'',
			htmlspecialchars($Tarif_HT_net),
			htmlspecialchars($Tarif_TTC),
			htmlspecialchars($Total_Tva),
			htmlspecialchars($taux_tva),
			htmlspecialchars($Total_Tva2),
			htmlspecialchars($taux_tva2),
			$statut_compte_oo,
			$type_panier
		));
		$sql_insert->closeCursor();

		////////////////////////////On cherche le numéro de l'id du panier créé pour auto-incrémenter numéro de facture
		///////////////////////////////SELECT
		$req_select = $bdd->prepare("SELECT * FROM membres_panier WHERE date_edition=?");
		$req_select->execute(array($now));
		$ligne_select = $req_select->fetch();
		$req_select->closeCursor();
		$id_numero_panier_ff = $ligne_select['id'];
		$numero_panier_ff = ($id_numero_panier_ff);

		///////////////////////////////UPDATE
		$sql_update = $bdd->prepare("UPDATE membres_panier SET 
	numero_panier=? 
	WHERE id=?");
		$sql_update->execute(array(
			htmlspecialchars($numero_panier_ff),
			htmlspecialchars($id_numero_panier_ff)
		));
		$sql_update->closeCursor();

		////////////////////////////On cherche le numéro de l'id du panier créé pour auto-incrémenter numéro de facture
	}
	///////////////ON CONTRÔLE SI UN PANIER EXISTE PAS

	if ($action_module_apres_paiement == "Commande colis") {

		///////////////ON RAJOUTE LIBELLE DANS LE PANIER
		///////////////////////////////INSERT
		$sql_insert = $bdd->prepare("INSERT INTO membres_panier_details
	(id_membre,
	pseudo,
	id_panier_SERVICE_PRODUIT,
	numero_panier,
	libelle,
	PU_HT,
	TVA,
	TVA_TAUX,
	quantite,
	action_module_service_produit,
	Duree_service,
	verif_panier,
	pseudo_vendeur,
	categorie,
	id_colis_detail,
	date
	)
	VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
		$sql_insert->execute(array(
			$id_oo,
			$pseudo_panier,
			htmlspecialchars($libelle_id_article),
			htmlspecialchars($numero_panier_ff),
			htmlspecialchars($libelle_details_article),
			htmlspecialchars($libelle_prix_article),
			htmlspecialchars($libelle_tva_article),
			htmlspecialchars($libelle_taux_tva_article),
			htmlspecialchars($libelle_quantite_article),
			htmlspecialchars($action_module_apres_paiement),
			htmlspecialchars($action_parametres_valeurs_explode),
			htmlspecialchars($verif_panier),
			htmlspecialchars($pseudo_membres_profil),
			htmlspecialchars($categorie),
			htmlspecialchars($id_service),
			htmlspecialchars($date)
		));
		$sql_insert->closeCursor();
	} elseif ($action_module_apres_paiement == "Commande") {

		///////////////ON RAJOUTE LIBELLE DANS LE PANIER
		///////////////////////////////INSERT
		$sql_insert = $bdd->prepare("INSERT INTO membres_panier_details
	(id_membre,
	pseudo,
	id_panier_SERVICE_PRODUIT,
	numero_panier,
	libelle,
	PU_HT,
	TVA,
	TVA_TAUX,
	quantite,
	action_module_service_produit,
	Duree_service,
	verif_panier,
	pseudo_vendeur,
	categorie,
	id_commande_detail,
	date
	)
	VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
		$sql_insert->execute(array(
			$id_oo,
			$pseudo_panier,
			htmlspecialchars($libelle_id_article),
			htmlspecialchars($numero_panier_ff),
			htmlspecialchars($libelle_details_article),
			htmlspecialchars($libelle_prix_article),
			htmlspecialchars($libelle_tva_article),
			htmlspecialchars($libelle_taux_tva_article),
			htmlspecialchars($libelle_quantite_article),
			htmlspecialchars($action_module_apres_paiement),
			htmlspecialchars($action_parametres_valeurs_explode),
			htmlspecialchars($verif_panier),
			htmlspecialchars($pseudo_membres_profil),
			htmlspecialchars($categorie),
			htmlspecialchars($id_service),
			htmlspecialchars($date)
		));
		$sql_insert->closeCursor();
	} else {

		///////////////ON RAJOUTE LIBELLE DANS LE PANIER
		///////////////////////////////INSERT
		$sql_insert = $bdd->prepare("INSERT INTO membres_panier_details
	(id_membre,
	pseudo,
	id_panier_SERVICE_PRODUIT,
	numero_panier,
	libelle,
	PU_HT,
	TVA,
	TVA_TAUX,
	quantite,
	action_module_service_produit,
	Duree_service,
	verif_panier,
	pseudo_vendeur,
	categorie,
	id_service,
	date
	)
	VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
		$sql_insert->execute(array(
			$id_oo,
			$pseudo_panier,
			htmlspecialchars($libelle_id_article),
			htmlspecialchars($numero_panier_ff),
			htmlspecialchars($libelle_details_article),
			htmlspecialchars($libelle_prix_article),
			htmlspecialchars($libelle_tva_article),
			htmlspecialchars($libelle_taux_tva_article),
			htmlspecialchars($libelle_quantite_article),
			htmlspecialchars($action_module_apres_paiement),
			htmlspecialchars($action_parametres_valeurs_explode),
			htmlspecialchars($verif_panier),
			htmlspecialchars($pseudo_membres_profil),
			htmlspecialchars($categorie),
			htmlspecialchars($id_service),
			htmlspecialchars($date)
		));
		$sql_insert->closeCursor();
	}


	//////////////ON MET A JOUR LES TOTAUX DU PANIER
	///////////////////////////////SELECT BOUCLE
	$req_boucle = $bdd->prepare("SELECT * FROM membres_panier_details
	WHERE pseudo=? 
	AND numero_panier=?");
	$req_boucle->execute(array(
		htmlspecialchars($pseudo_panier),
		htmlspecialchars($numero_panier_ff)
	));
	while ($ligne_boucle = $req_boucle->fetch()) {
		$idoneinfos_artciles_fiche_panier = $ligne_boucle['id'];
		$PU_HT_artciles_fiche_panier = $ligne_boucle['PU_HT'];
		$TVA = $ligne_boucle['TVA'];
		$TVA_TAUX = $ligne_boucle['TVA_TAUX'];
		$quantite_artciles_fiche_panier = $ligne_boucle['quantite'];

		$PU_HT_TOTAUX = ($PU_HT_TOTAUX + ($PU_HT_artciles_fiche_panier * $quantite_artciles_fiche_panier));

		if ($ligne_boucle['TVA_TAUX'] == "1.20") {
			$PU_TVA_TOTAUX = ($PU_TVA_TOTAUX + ($TVA * $quantite_artciles_fiche_panier));
			$Taux_tva = "0";
		}
		if ($ligne_boucle['TVA_TAUX'] == "1.055") {
			$PU_TVA2_TOTAUX = ($PU_TVA2_TOTAUX + ($TVA * $quantite_artciles_fiche_panier));
			$Taux2_tva = "1.055";
		}
	}
	$PU_TTC_TOTAUX = ($PU_HT_TOTAUX + $PU_TVA_TOTAUX + $PU_TVA2_TOTAUX);

	//UPDATE SQL
	///////////////////////////////UPDATE
	$sql_update = $bdd->prepare("UPDATE membres_panier SET 
	Tarif_HT=?, 
	Tarif_HT_net=?, 
	Tarif_TTC=?, 
	Total_Tva=?,
	taux_tva=?,
	Total_Tva2=?,
	taux_tva2=?
	WHERE numero_panier=? 
	AND pseudo=?");
	$sql_update->execute(array(
		htmlspecialchars($PU_HT_TOTAUX),
		htmlspecialchars($PU_HT_TOTAUX),
		htmlspecialchars($PU_TTC_TOTAUX),
		htmlspecialchars($PU_TVA_TOTAUX),
		htmlspecialchars($Taux_tva),
		htmlspecialchars($PU_TVA2_TOTAUX),
		htmlspecialchars($Taux2_tva),
		htmlspecialchars($numero_panier_ff),
		htmlspecialchars($pseudo_panier)
	));
	$sql_update->closeCursor();

	//////////////ON MET A JOUR LES TOTAUX DU PANIER

	return $informations_cretaion_panier;
}
