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

$_SESSION['id_livraison'] = $_POST['checkout_payment_method'];

///////////////////////////////DELETE
$sql_delete = $bdd->prepare("DELETE FROM membres_panier_details WHERE id_membre=? AND action_module_service_produit=?");
$sql_delete->execute(array($id_oo,"Frais de livraison"));                     
$sql_delete->closeCursor();

///////////////////////////////SELECT ABONNEMENT
$req_selectap = $bdd->prepare("SELECT * FROM configurations_livraisons_gabon WHERE id=?");
$req_selectap->execute(array($_POST['checkout_payment_method']));
$ligne_selectap = $req_selectap->fetch();
$req_selectap->closeCursor();

if($Abonnement_id == 1){
	$prix = $ligne_selectap['prix_1'];

}elseif($Abonnement_id == 2){
	$prix = $ligne_selectap['prix_2'];

}elseif($Abonnement_id == 3){
	$prix = $ligne_selectap['prix_3'];

}


if($prix > 0){
	$prix = ($prix);
	$prix = round($prix,2);
	$prix_ttc = ($prix*1.18);
	$prix_ttc = round($prix_ttc,2); 
	$prix_tva = ($prix_ttc-$prix);

}else{

	$prix = 0;
	$prix_ttc = 0; 
	$prix_tva = 0;

}


//$libelle = "Frais de livraison";
$_SESSION['frais_livraison'] = $prix; 
//ajout_panier($libelle, 1, $prix, $prix_tva, "1.20", $libelle, "", $libelle_id_article, $user,"Livraison", $_POST['checkout_payment_method'], time());		


$result = array("Texte_rapport"=>"Livraison mise à jour.","retour_validation"=>"ok","retour_lien"=>"");

$result = json_encode($result);
echo $result;

ob_end_flush();
?>