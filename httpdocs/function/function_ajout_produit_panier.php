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

function ajout_produit_panier($libelle_details_article, $categorie, $pourcentage_categorie, $libelle_quantite_article, $libelle_prix_article, $libelle_tva_article, $libelle_taux_tva_article, $action_module_apres_paiement, $action_parametres_valeurs_explode, $libelle_id_article, $pseudo_panier, $produit_id)
{

	global $bdd;
	global $user;
	global $id_oo;
	global $nomsiteweb;

	$Tarif_HT = 0;
	$Tarif_HT_NET = 0;
	$Tarif_TTC = 0;
	$Total_TVA = 0;

	
	///////////////////////////////SELECT
	$req_select = $bdd->prepare("SELECT * FROM membres WHERE pseudo=?");
	$req_select->execute(array($pseudo_panier));
	$membre = $req_select->fetch();
	$req_select->closeCursor();
	$id_oo = $membre['id'];
	$pseudo = $membre['pseudo'];
	$abonnement_id = $membre['Abonnement_id'];

	$now = time();

	///////////////ON CONTRÔLE SI UN PANIER EXISTE PAS
	///////////////////////////////SELECT
	$req_select = $bdd->prepare("SELECT * FROM membres_panier 
	WHERE id_membre=?
	AND Titre_panier=?");
	$req_select->execute(array(
		$id_oo,
		"Commande via boutique"
	));
	$ligne_select = $req_select->fetch();
	$req_select->closeCursor();
	$id_panier = $ligne_select['id'];

	$req_select = $bdd->prepare("SELECT * FROM configurations_abonnements
	WHERE id=?");
	$req_select->execute(array($abonnement_id));
	$abonnement = $req_select->fetch();
	$req_select->closeCursor();

	///////////////////////////Si pas de panier courant
	if (empty($id_panier)) {

		$PU_HT_artciles_fiche_panier = $libelle_prix_article;
		$TVA = $libelle_tva_article;
		$TVA_TAUX = $libelle_taux_tva_article;
		$quantite_artciles_fiche_panier = $libelle_quantite_article;

		$Tarif_HT += ($PU_HT_artciles_fiche_panier*$quantite_artciles_fiche_panier);
		$Tarif_HT_NET += ($PU_HT_artciles_fiche_panier*$quantite_artciles_fiche_panier);

		$Tarif_TTC += ($Tarif_HT + $TVA*$quantite_artciles_fiche_panier);
		$Total_TVA += $TVA*$quantite_artciles_fiche_panier;

		$Tarif_TTC = $Tarif_TTC*(1+($pourcentage_categorie/100));
	
		if($abonnement['Frais_de_gestion_d_une_commande'] != "Gratuit"){
			$Tarif_TTC += $abonnement['Frais_de_gestion_d_une_commande'];
		}
	
		if($abonnement['Frais_de_passage_d_une_commande'] != "Gratuit"){
			$Tarif_TTC += $abonnement['Frais_de_passage_d_une_commande'];
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
		Type_compte_F,
		type_panier
		)
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
			$sql_insert->execute(array(
				$id_oo,
				$pseudo,
				'',
				'',
				"Commande via boutique",
				"Commande via boutique",
				'non traite',
				$now,
				'',
				htmlspecialchars($Tarif_HT),
				'',
				htmlspecialchars($Tarif_HT_NET),
				htmlspecialchars($Tarif_TTC),
				htmlspecialchars($Total_TVA),
				htmlspecialchars($TVA_TAUX),
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

	///////////////ON RAJOUTE LIBELLE DANS LE PANIER
	///////////////////////////////INSERT

	$detail_panier = $bdd->prepare("SELECT * FROM membres_panier_details WHERE id_produit=? AND numero_panier=?  AND pseudo=?");
	$detail_panier->execute(array($produit_id, $id_panier, $pseudo));
	$panier_detail = $detail_panier->fetch();


	if($panier_detail){
		$ancien_quantite = $panier_detail['quantite'];
		$nouveau_quantite = $ancien_quantite + $libelle_quantite_article;
		
		$sql_update = $bdd->prepare("UPDATE membres_panier_details SET 
						quantite=? 
						WHERE id=?");
		$sql_update->execute(array(
			$nouveau_quantite,
			htmlspecialchars($panier_detail['id'])

		));

		$sql_update->closeCursor();
	}else{

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
		categorie,
		action_module_service_produit,
		Duree_service,
		verif_panier,
		pseudo_vendeur,
		date,
		id_produit
		)
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
		$sql_insert->execute(array(
			$id_oo,
			$pseudo,
			htmlspecialchars($libelle_id_article),
			htmlspecialchars($numero_panier_ff),
			htmlspecialchars($libelle_details_article),
			htmlspecialchars($libelle_prix_article),
			htmlspecialchars($libelle_tva_article),
			htmlspecialchars($libelle_taux_tva_article),
			htmlspecialchars($libelle_quantite_article),
			htmlspecialchars($categorie),
			htmlspecialchars($action_module_apres_paiement),
			htmlspecialchars($action_parametres_valeurs_explode),
			htmlspecialchars($verif_panier),
			htmlspecialchars($pseudo_membres_profil),
			(time() + 87400),
			$produit_id
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
		htmlspecialchars($id_panier)
	));
	$Tarif_HT = 0;
	$Tarif_HT_NET = 0;
	$Tarif_TTC = 0;
	$Total_TVA = 0;

	while ($ligne_boucle = $req_boucle->fetch()) {
		$category_query = $bdd->prepare('SELECT * FROM categories WHERE nom_categorie=?');
		$category_query->execute(array($ligne_boucle['categorie']));
		$categorie = $category_query->fetch();
		$category_query->closeCursor();

		$PU_HT_artciles_fiche_panier = $ligne_boucle['PU_HT'];
		$TVA = $ligne_boucle['TVA'];
		$TVA_TAUX = $ligne_boucle['TVA_TAUX'];
		$quantite_artciles_fiche_panier = $ligne_boucle['quantite'];

		$Tarif_HT += ($PU_HT_artciles_fiche_panier*$quantite_artciles_fiche_panier);
		$Tarif_HT_NET += ($PU_HT_artciles_fiche_panier*$quantite_artciles_fiche_panier);

		$Tarif_TTC += ($Tarif_HT + $TVA*$quantite_artciles_fiche_panier);

		$Tarif_TTC = $Tarif_TTC*(1+$categorie["value_commande"]/100);

		$Total_TVA += $TVA*$quantite_artciles_fiche_panier;
	}


	if($abonnement['Frais_de_gestion_d_une_commande'] != "Gratuit"){
		$Tarif_TTC += $abonnement['Frais_de_gestion_d_une_commande'];
	}

	if($abonnement['Frais_de_passage_d_une_commande'] != "Gratuit"){
		$Tarif_TTC += $abonnement['Frais_de_passage_d_une_commande'];
	}



	//UPDATE SQL
	///////////////////////////////UPDATE
	$sql_update = $bdd->prepare("UPDATE membres_panier SET 
	Tarif_HT=?, 
	Tarif_HT_net=?, 
	Tarif_TTC=?, 
	Total_Tva=?,
	taux_tva=?
	WHERE id=? 
	AND id_membre=?");
	$sql_update->execute(array(
		htmlspecialchars($Tarif_HT),
		htmlspecialchars($Tarif_HT_NET),
		htmlspecialchars($Tarif_TTC),
		htmlspecialchars($Total_TVA),
		htmlspecialchars(1.20),
		htmlspecialchars($id_panier),
		htmlspecialchars($id_oo)
	));
	$sql_update->closeCursor();

	//////////////ON MET A JOUR LES TOTAUX DU PANIER

	return $informations_cretaion_panier;
}
