<?php

//////////////////////////////////////////PASSAGE COMMANDE ET COLIS
//////////////////////////////////////////CALCULS DE TOUS LES FRAIS POUR AJOUTER AUX COMMANDES

unset($_SESSION['prix_prospection_total']);
unset($_SESSION['prix_frais_de_gestion_total']);


	unset($_SESSION['prix_expedition_total2']);


	unset($_SESSION['prix_expedition_colis_total2']);


if(empty($Abonnement_id)){
	$Abonnement_id = 1;
}

///////////////////////////////SELECT ABONNEMENT
$req_select = $bdd->prepare("SELECT * FROM configurations_abonnements WHERE id=?");
$req_select->execute(array($Abonnement_id));
$abonnement = $req_select->fetch();
$req_select->closeCursor();
$abonnement_id = $ligne_select['id'];

///////////////////////////////SELECT BOUCLE
$req_boucle = $bdd->prepare("SELECT * FROM membres_panier_details WHERE id_membre=? ORDER BY id ASC");
$req_boucle->execute(array($id_oo));
while ($ligne_boucle = $req_boucle->fetch()) {

	///////////////////////////////COMMANDES & COMMANDES SOUHAITS
	if($ligne_boucle['action_module_service_produit'] == "Commande" || $ligne_boucle['action_module_service_produit'] == "Commande souhait" || $ligne_boucle['action_module_service_produit'] == "Commande boutique"){
	
		///////////////////////////////Frais de gestion d'une commande
		if ($abonnement['Frais_de_gestion_d_une_commande'] == "Gratuit" || $admin_oo == "1") {
			$prix_frais_de_gestion = 0;
		}else{
			$prix_frais_de_gestion = $abonnement['Frais_de_gestion_d_une_commande'];
		} 
		
		$prix_frais_de_gestion_total = ($prix_frais_de_gestion);
		
		$_SESSION['prix_frais_de_gestion_total'] = $prix_frais_de_gestion_total;
		//echo "Frais gestion : $prix_frais_de_gestion | Total $prix_frais_de_gestion_total <br />";

	}

	///////////////////////////////COMMANDES SOUHAITS
	if($ligne_boucle['action_module_service_produit'] == "Commande souhait" ){

		///////////////////////////////Liste de souhaits (prospection)
		if ($abonnement['Liste_de_souhaits'] == "Gratuit" || $admin_oo == "1") {
			$prix_prospection = 0;
		}else{
			$prix_prospection = $abonnement['Liste_de_souhaits'];
		} 
		$prix_prospection_total = ($prix_prospection_total+$prix_prospection);
		$_SESSION['prix_prospection_total'] = $prix_prospection_total;
		//echo "Frais liste de souhait : $prix_prospection | Total $prix_prospection_total <br />";

	}
	if($_SESSION['prix_expedition_total'] != '0'){
	///////////////////////////////COMMANDES & COMMANDES SOUHAITS
	if($ligne_boucle['action_module_service_produit'] == "Commande" || $ligne_boucle['action_module_service_produit'] == "Commande souhait" || $ligne_boucle['action_module_service_produit'] == "Commande boutique" ){
	
		///////////////////////////////Douane et transport commande normale
		$req_select = $bdd->prepare("SELECT * FROM categories WHERE nom_categorie=?");
		$req_select->execute(array($ligne_boucle['categorie']));
		$categorie = $req_select->fetch();
		$req_select->closeCursor();
		$prix_expedition = (($ligne_boucle['quantite']*$ligne_boucle['PU_HT'])*($categorie['value_commande']/100)); //$ligne_boucle['quantite']*
		$prix_expedition = round($prix_expedition,0);
		$prix_expedition_total = ($prix_expedition_total+$prix_expedition);
		

		$_SESSION['prix_expedition_total'] = $prix_expedition_total;
		$_SESSION['prix_expedition_total2'] = $prix_expedition_total;
		//echo "Frais expédition commande : $prix_expedition | Total $prix_expedition_total <br />";

	}
	}
	if($_SESSION['prix_expedition_colis_total'] != '0'){
	///////////////////////////////COLIS
	if($ligne_boucle['action_module_service_produit'] == "Commande colis" ){
		
		$prix_expedition_colis_total = $ligne_boucle['TTC_colis'];
		$_SESSION['prix_expedition_colis_total'] = $prix_expedition_colis_total;
		$_SESSION['prix_expedition_colis_total2'] = $prix_expedition_colis_total;
		//echo "Frais expédition colis : $prix_expedition_colis | Total $prix_expedition_colis_total <br />";
	}
	}

}
$req_boucle->closeCursor();

	//Total tout compris
	//var_dump($prix_prospection_total,$prix_frais_de_gestion_total,$prix_expedition_total,$prix_expedition_colis_total);
	$prix_total_frais_expedition_HT = ($prix_prospection_total+$prix_frais_de_gestion_total);
	$prix_total_frais_expedition_TTC = ($prix_total_frais_expedition_HT*1.18);
	$prix_total_frais_expedition_TTC = round($prix_total_frais_expedition_TTC,2);
	$prix_total_frais_expedition_TVA = ($prix_total_frais_expedition_TTC-$prix_total_frais_expedition_HT);
	$prix_total_frais_expedition_TVA = round($prix_total_frais_expedition_TVA, 2);
	//echo "HT $prix_total_frais_expedition_HT TVA $prix_total_frais_expedition_TVA TTC $prix_total_frais_expedition_TTC <br />";

///////////////////////////////////////////////////////AJOUT AU PANIER

	///////////////////////////////DELETE PANIER DETAILS FRAIS 
	//$sql_delete = $bdd->prepare("DELETE FROM membres_panier_details WHERE action_module_service_produit=? AND pseudo=?");
	//$sql_delete->execute(array("Frais gestion de commande",$user));                     
	//$sql_delete->closeCursor();

	//$sql_delete = $bdd->prepare("DELETE FROM membres_panier_details WHERE action_module_service_produit=? AND pseudo=?");
	//$sql_delete->execute(array("Frais liste souhait",$user));                     
	//$sql_delete->closeCursor();

	//$sql_delete = $bdd->prepare("DELETE FROM membres_panier_details WHERE action_module_service_produit=? AND pseudo=?");
	//$sql_delete->execute(array("Frais expédition commande",$user));                     
	//$sql_delete->closeCursor();

	//$sql_delete = $bdd->prepare("DELETE FROM membres_panier_details WHERE action_module_service_produit=? AND pseudo=?");
	//$sql_delete->execute(array("Frais expédition colis",$user));                     
	//$sql_delete->closeCursor();

	///////////////////////////////INSERT PANIER DETAILS FRAIS 
	if(!empty($_SESSION['prix_frais_de_gestion_total'])){
		//$libelle_tva_article = ($_SESSION['prix_frais_de_gestion_total']*1.20);
		//$libelle_tva_article = ($libelle_tva_article-$_SESSION['prix_frais_de_gestion_total']);
		//ajout_panier("Frais gestion de commande", 1, $_SESSION['prix_frais_de_gestion_total'], $libelle_tva_article, "1.20", "Frais gestion de commande", "", $libelle_id_article, $user);
	}
	if(!empty($_SESSION['prix_prospection_total'])){
		//$libelle_tva_article = ($_SESSION['prix_frais_de_gestion_total']*1.20);
		//$libelle_tva_article = ($libelle_tva_article-$_SESSION['prix_frais_de_gestion_total']);
		//ajout_panier("Frais liste souhait", 1, $_SESSION['prix_frais_de_gestion_total'], $libelle_tva_article, "1.20", "Frais liste souhait", "", $libelle_id_article, $user);	
	}
	if(!empty($_SESSION['prix_expedition_total'])){
		//$libelle_tva_article = ($_SESSION['prix_frais_de_gestion_total']*1.20);
		//$libelle_tva_article = ($libelle_tva_article-$_SESSION['prix_frais_de_gestion_total']);
		//ajout_panier("Frais expédition commande", 1, $_SESSION['prix_frais_de_gestion_total'], $libelle_tva_article, "1.20", "Frais expédition commande", "", $libelle_id_article, $user);		
	}
	if(!empty($_SESSION['prix_expedition_colis_total'])){
		//$libelle_tva_article = ($_SESSION['prix_frais_de_gestion_total']*1.20);
		//$libelle_tva_article = ($libelle_tva_article-$_SESSION['prix_frais_de_gestion_total']);
		//ajout_panier("Frais expédition colis", 1, $_SESSION['prix_frais_de_gestion_total'], $libelle_tva_article, "1.20", "Frais expédition colis", "", $libelle_id_article, $user);		
	}
	
	///////////////////////////////UPDATE PANIER GENERALE
	$sql_update = $bdd->prepare("UPDATE membres_panier SET
	  	prix_frais_de_gestion_total=?,
		prix_prospection_total=?,
		prix_expedition_total=?,
		prix_expedition_colis_total=?
	WHERE id_membre=?");
	$sql_update->execute(array(
		$_SESSION['prix_frais_de_gestion_total'],
		$_SESSION['prix_prospection_total'],
		$_SESSION['prix_expedition_total'],
		$_SESSION['prix_expedition_colis_total'],
		$id_oo
	));                     
	$sql_update->closeCursor();

///////////////////////////////////////////////////////AJOUT AU PANIER

?>