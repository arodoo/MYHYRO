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

	$idd = $_POST['id'];
	$activer = $_POST['activer'];
	$date_new_expiration = $_POST['date_new_expiration'];
	
	//////////////////////////////////////////////////AJOUTER
	// return $_POST['ccouleur'];
	if($action == "Ajouter-action"){
		
		$action = $_POST['action'];
		$meilleur_vente = $_POST['meilleur_vente']; 
		$refproduithyro = $_POST['refproduithyro']; 
		$nomproduit = $_POST['nomproduit']; 
		$id_categorie = $_POST['id_categorie']; 
		$title = $_POST['title']; 
		$couleur = $_POST['couleur'];
		$couleur2 = $_POST['couleur2'];
		$description = $_POST['description']; 
		$meta_description = $_POST['meta_description']; 
		$url = $_POST['url']; 
		$lien = $_POST['lien']; 
		$stock = $_POST['stock']; 
		$prix = $_POST['prix']; 
		$Activer = $_POST['Activer']; 

		$nouveaucontenu = "$nomproduit";
		include ("../../../function/cara_replace.php");
		$url_produit = $nouveaucontenu;

		
		$sql_insert = $bdd->prepare("INSERT INTO configurations_references_produits
		(
			uuid,
			id_categorie,
			photo,
			prix,
			couleur,
			couleur2,
			nom_produit,
			url_produit,
			ref_produit_hyro,
			description,
			url,
			title,
			meta_description,
			meta_keyword,
			lien_chez_un_marchand,
			activer,
			date_ajout,
			stock,
			meilleur_vente
		)VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

		$sql_insert->execute(array(
			 vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex(random_bytes(16)), 4)),
			 $id_categorie,
			'default.png',
			$prix,
			$couleur,
			$couleur2,
			$nomproduit,
			$url_produit,
			$refproduithyro,
			$description,
			$url,
			$title,
			$meta_description,
			'',
			$lien,
			$Activer,
			date('Y-m-d'),
			$stock,
			$meilleur_vente
		));
		$sql_insert->closeCursor();

		$result = array(
            "Texte_rapport" => "Produit ajouté avec succès !",
            "retour_validation" => "ok",
            "retour_lien" => ""
        );
	}



	////////////////////////////////////////////////////MODIFIER
	if($action == "Modifier-action"){

		if($Renouveler == "Oui" && !empty($date_new_expiration) ){

			$date_new_expiration = explode('-', $date_new_expiration);
			$date_new_expiration = mktime(0, 0, 0, intval($date_new_expiration[1]), intval($date_new_expiration[2]), intval($date_new_expiration[0]));

			$sql_update = $bdd->prepare("UPDATE configurations_references_produits SET 
				data=?,
				date=?
				WHERE id=?");
			$sql_update->execute(array(
				time(),
				$date_new_expiration,
				$_POST['idaction']));                     
			$sql_update->closeCursor();

		}

		$sql_update = $bdd->prepare("UPDATE configurations_references_produits SET 
			id=?
			WHERE id=?");
		$sql_update->execute(array(
			$_POST['idaction']));                     
		$sql_update->closeCursor();

		$result = array("Texte_rapport"=>"Produit modifié avec succès !","retour_validation"=>"ok","retour_lien"=>"");

		
	}

	echo json_encode($result);

}else{
	header('location: /index.html');
}

ob_end_flush();
?>
