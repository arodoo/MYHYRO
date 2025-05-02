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

	////////////////METHODE

function update_panier($pseudo_panier){

global $bdd;
global $user;
global $id_oo;
global $nomsiteweb;

//////////////ON MET A JOUR LES TOTAUX DU PANIER
///////////////////////////////SELECT BOUCLE
$req_boucle = $bdd->prepare("SELECT * FROM membres_panier_details
	WHERE pseudo=? ");
$req_boucle->execute(array(
	htmlspecialchars($pseudo_panier)
	));
while($ligne_boucle = $req_boucle->fetch()){
	$resultat_fonction_panier_update = "oui";
	$idoneinfos_artciles_fiche_panier = $ligne_boucle['id'];
	$numero_panier = $ligne_boucle['numero_panier'];
	$PU_HT_artciles_fiche_panier = $ligne_boucle['PU_HT'];
	$TVA = $ligne_boucle['TVA'];
	$TVA_TAUX = $ligne_boucle['TVA_TAUX'];
	$quantite_artciles_fiche_panier = $ligne_boucle['quantite'];

	$PU_HT_TOTAUX = ($PU_HT_TOTAUX+($PU_HT_artciles_fiche_panier*$quantite_artciles_fiche_panier));

	if($ligne_boucle['TVA_TAUX'] == "1.20"){
		$PU_TVA_TOTAUX = ($PU_TVA_TOTAUX+($TVA*$quantite_artciles_fiche_panier));
		$Taux_tva = "1.20";	
	}
	if($ligne_boucle['TVA_TAUX'] == "1.055"){
		$PU_TVA2_TOTAUX = ($PU_TVA2_TOTAUX+($TVA*$quantite_artciles_fiche_panier));
		$Taux2_tva = "1.055";	
	}
}
$PU_TTC_TOTAUX = ($PU_HT_TOTAUX+$PU_TVA_TOTAUX+$PU_TVA2_TOTAUX);


if(!empty($resultat_fonction_panier_update)){

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
	WHERE pseudo=?");
$sql_update->execute(array(
	htmlspecialchars($PU_HT_TOTAUX), 
	htmlspecialchars($PU_HT_TOTAUX), 
	htmlspecialchars($PU_TTC_TOTAUX), 
	htmlspecialchars($PU_TVA_TOTAUX),
	htmlspecialchars($Taux_tva),
	htmlspecialchars($PU_TVA2_TOTAUX),
	htmlspecialchars($Taux2_tva),
	htmlspecialchars($pseudo_panier)));                     
$sql_update->closeCursor();

}else{

///////////////////////////////DELETE
$sql_delete = $bdd->prepare("DELETE FROM membres_panier WHERE pseudo=?");
$sql_delete->execute(array($pseudo_panier));                     
$sql_delete->closeCursor();

}

//////////////ON MET A JOUR LES TOTAUX DU PANIER

	return $informations_cretaion_panier;

}

?>