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

if(isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 1 ||
isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 4 ){

$idaction = $_POST['idaction'];

$En_Tete_Pdf = $_POST['En_Tete_Pdf'];
$Pied_de_page_Pdf = $_POST['Pied_de_page_Pdf'];
$Taux_tva = $_POST['Taux_tva'];
$LISTE_MAIL_CC = $_POST['LISTE_MAIL_CC'];
$MODE_REFERENCE_1_2_3 = $_POST['MODE_REFERENCE_1_2_3'];

$Tva_coef = ($Taux_tva/100);
$icon = $_FILES['icon']['name'];
$tmp = $_FILES['icon']['tmp_name'];

$Description_defaut_devis =  $_POST['Description_defaut_devis'];
$Description_defaut_facture =  $_POST['Description_defaut_facture'];
$Mode_couleur_SITE_DEFAUT =  $_POST['Mode_couleur_SITE_DEFAUT'];
$RIB = $_FILES['RIB']['name'];

$Banque_nom = $_POST['Banque_nom'];
$Banque_code = $_POST['Banque_code'];
$Banque_numero_compte = $_POST['Banque_numero_compte'];
$Banque_cle_rib = $_POST['Banque_cle_rib'];
$Banque_iban = $_POST['Banque_iban'];
$Banque_bic = $_POST['Banque_bic'];

$text_demande_de_devis = $_POST['text_demande_de_devis'];

//////////////////////////////////////////////////TELECHARGEMENT DU LOGO
if(!empty($icon)){

if(substr($icon, -4) == "jpeg" || substr($icon, -4) == "JPEG" || substr($icon, -3) == "jpg" || substr($icon, -3) == "JPG" || substr($icon, -3) == "png" || substr($icon, -3) == "PNG" || substr($icon, -3) == "gif" || substr($icon, -3) == "GIF"){

///////////////////////////////ACTIONS
$repertoire_move = "".$dir_fonction."images/$icon";
move_uploaded_file($tmp, $repertoire_move);

$update_logo_PDF = "logo_pdf=?, ";
$update_logo_PDF_valeur = "".$icon.", ";

///////////////////////////////UPDATE
$sql_update = $bdd->prepare("UPDATE configurations_pdf_devis_factures SET 
	logo_pdf=?
	WHERE id=? ");
$sql_update->execute(array(
	$icon,
	'1'));                     
$sql_update->closeCursor();

///////////////////////////////ACTIONS

////////////Si n'est pas une image ou si aucune image choisie
}elseif(!empty($icon)){
$erreur_upload = "Seulement les images sont autorisées";
}else{
$erreur_upload = "Vous devez choisir une image !";
}
////////////Si n'est pas une image ou si aucune image choisie

}
////////////Erreur autre
//////////////////////////////////////////////////TELECHARGEMENT DU LOGO

//////////////////////////////////////////////////TELECHARGEMENT DU RIB

if(!empty($RIB)){

        if(substr($RIB, -4) == "jpeg" || substr($RIB, -4) == "JPEG" || substr($RIB, -3) == "jpg" || substr($RIB, -3) == "JPG" || substr($RIB, -3) == "png" || substr($RIB, -3) == "PNG" || substr($RIB, -3) == "gif" || substr($RIB, -3) == "GIF"){

	if (!empty($RIB)){

	$RIB = $_FILES['RIB']['name'];
	$taille = $_FILES['RIB']['size'];
	$tmp = $_FILES['RIB']['tmp_name'];
	$type = $_FILES['RIB']['type'];
	$erreur = $_FILES['RIB']['error'];
	$source_file = $_FILES['RIB']['tmp_name'];

$nouvelle_image = "$RIB";

///////////////////////////////ACTIONS
$namebrut = explode('.', $nouvelle_image);
$namebruto = $namebrut[0];
$namebruto1 = $namebrut[1];

$nouveaucontenu = "$namebruto";
include("../../../function/cara_replace.php");
$namebruto = "$nouveaucontenu";

$new_image = "$namebruto.".$namebruto1."";

$repertoire_move_2 = "images/$new_image";
move_uploaded_file($tmp, $repertoire_move_2);

///////////////////////////////UPDATE
$sql_update = $bdd->prepare("UPDATE configurations_pdf_devis_factures SET 
	RIB=?
	WHERE id=? ");
$sql_update->execute(array(
	$nouvelle_image,
	'1'));                     
$sql_update->closeCursor();

///////////////////////////////ACTIONS

////////////Si n'est pas une image ou si aucune image choisie
}else{
$erreur_upload = "Vous devez choisir une image !";
}

}elseif(!empty($RIB)){
$erreur_upload = "Seulement les images sont autorisées";
}
////////////Si n'est pas une image ou si aucune image choisie

}
////////////Erreur autre
//////////////////////////////////////////////////TELECHARGEMENT DU RIB

///////////////////////////////UPDATE
$sql_update = $bdd->prepare("UPDATE configurations_pdf_devis_factures SET 
	Pied_de_page_Pdf=?,
	En_Tete_Pdf=?,
	Tva_coef=?,
	Taux_tva=?,
	LISTE_MAIL_CC=?,
	MODE_REFERENCE_1_2_3=?,
	Description_defaut_devis=?,
	Description_defaut_facture=?,
	Banque_nom=?,
	Banque_code=?,
	Banque_numero_compte=?,
	Banque_cle_rib =?,
	Banque_iban=?,
	Banque_bic=?,
	text_demande_de_devis=?,
	Mode_couleur_SITE_DEFAUT=?,
	date_mise_a_jour=?
	WHERE id=? ");
$sql_update->execute(array(
	$Pied_de_page_Pdf,
	$En_Tete_Pdf,
	$Tva_coef,
	$Taux_tva,
	$LISTE_MAIL_CC,
	$MODE_REFERENCE_1_2_3,
	$Description_defaut_devis,
	$Description_defaut_facture,
	$Banque_nom,
	$Banque_code,
	$Banque_numero_compte,
	$Banque_cle_rib,
	$Banque_iban,
	$Banque_bic,
	$text_demande_de_devis,
	$Mode_couleur_SITE_DEFAUT,
	time(),
	'1'));                     
$sql_update->closeCursor();

$result = array("Texte_rapport"=>"Configurations modifiées !","retour_validation"=>"ok","retour_lien"=>"");

$result = json_encode($result);
echo $result;

}else{
header('location: /index.html');
}

ob_end_flush();
?>