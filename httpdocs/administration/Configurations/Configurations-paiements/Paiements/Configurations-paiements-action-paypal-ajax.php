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

if(isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 1){

$now = time();

$action = $_POST['action'];
$idaction = $_POST['idaction'];
$KnvFrEdtemporaire = create_password();

$mailpaypal = $_POST['mailpaypal'];
$identifiant_api_paypal = $_POST['identifiant_api_paypal'];
$private_pwd_paypal = $_POST['private_pwd_paypal'];
$signature_api_paypal = $_POST['signature_api_paypal'];
$activer_paypal = $_POST['activer_paypal'];

$icon = $_FILES['icon']['name'];
$tmp = $_FILES['icon']['tmp_name'];

$icon2 = $_FILES['icon2']['name'];
$tmp2 = $_FILES['icon2']['tmp_name'];

//////////////////////////////////////////////////////////////////////////////////ACTION MODIF PAYPAL
if(!empty($mailpaypal)){

//////////////////////////////////////////////////TELECHARGEMENT DU LOGO DE PAGE
if(!empty($icon)){

if(substr($icon, -4) == "jpeg" || substr($icon, -4) == "JPEG" || substr($icon, -3) == "jpg" || substr($icon, -3) == "JPG" || substr($icon, -3) == "png" || substr($icon, -3) == "PNG" || substr($icon, -3) == "gif" || substr($icon, -3) == "GIF"){

$nouvelle_image = "$icon";

///////////////////////////////ACTIONS
$namebrut = explode('.', $nouvelle_image);
$namebruto = $namebrut[0];
$namebruto1 = $namebrut[1];
$nouveaucontenu = "$namebruto";
include("../../../function/cara_replace.php");
$namebruto = "$nouveaucontenu";

$new_image = "$namebruto-".time().".".$namebruto1."";
$repertoire_move_2 = "../../../images/paypal/$new_image";
move_uploaded_file($tmp, $repertoire_move_2);

///////////////////////////////UPDATE
$sql_update = $bdd->prepare("UPDATE configuration_paypal SET 
	logo_page_paiement=?
	WHERE id=?");
$sql_update->execute(array(
	$new_image, 
	'1'));                     
$sql_update->closeCursor();

///////////////////////////////ACTIONS

////////////Si n'est pas une image ou si aucune image choisie
}elseif(!empty($icon)){
$result = array("Texte_rapport"=>"Seulement les images sont autorisées !","retour_validation"=>"","retour_lien"=>"");
}
////////////Si n'est pas une image ou si aucune image choisie

}
//////////////////////////////////////////////////TELECHARGEMENT DU LOGO DE PAGE

//////////////////////////////////////////////////TELECHARGEMENT DU LOGO DE PAGE
if(!empty($icon2)){

if(substr($icon2, -4) == "jpeg" || substr($icon2, -4) == "JPEG" || substr($icon2, -3) == "jpg" || substr($icon2, -3) == "JPG" || substr($icon2, -3) == "png" || substr($icon2, -3) == "PNG" || substr($icon2, -3) == "gif" || substr($icon2, -3) == "GIF"){

$nouvelle_image = "$icon2";

///////////////////////////////ACTIONS
$namebrut = explode('.', $nouvelle_image);
$namebruto = $namebrut[0];
$namebruto1 = $namebrut[1];
$nouveaucontenu = "$namebruto";
include("../../../function/cara_replace.php");
$namebruto = "$nouveaucontenu";

$new_image = "$namebruto-".time().".".$namebruto1."";
$repertoire_move_2 = "../../../images/paypal/$new_image";
move_uploaded_file($tmp2, $repertoire_move_2);

///////////////////////////////UPDATE
$sql_update = $bdd->prepare("UPDATE configuration_paypal SET 
	logo_page_panier=?
	WHERE id=?");
$sql_update->execute(array(
	$new_image, 
	'1'));                     
$sql_update->closeCursor();

///////////////////////////////ACTIONS

////////////Si n'est pas une image ou si aucune image choisie
}elseif(!empty($icon2)){
$result = array("Texte_rapport"=>"Seulement les images sont autorisées !","retour_validation"=>"","retour_lien"=>"");
}
////////////Si n'est pas une image ou si aucune image choisie

}
//////////////////////////////////////////////////TELECHARGEMENT DU LOGO DE PAGE

///////////////////////////////UPDATE
$sql_update = $bdd->prepare("UPDATE configuration_paypal SET 
	Adresse_paypal=?, 
	identifiant_api_paypal=?, 
	private_pwd_paypal=?, 
	signature_api_paypal=?, 
	activer_paypal=?
	WHERE id=?");
$sql_update->execute(array(
	$mailpaypal, 
	$identifiant_api_paypal, 
	$private_pwd_paypal, 
	$signature_api_paypal, 
	$activer_paypal, 
	'1'));                     
$sql_update->closeCursor();

$result = array("Texte_rapport"=>"Modification Paypal apportée avec succès !","retour_validation"=>"ok","retour_lien"=>"");

////////////RAPPORT JS
}elseif(empty($mailpaypal)){
$result = array("Texte_rapport"=>"Vous devez indiquer une adresse Paypal !","retour_validation"=>"","retour_lien"=>"");

}
//////////////////////////////////////////////////////////////////////////////////ACTION MODIF PAYPAL

$result = json_encode($result);
echo $result;

}else{
header('location: /index.html');
}

ob_end_flush();
?>