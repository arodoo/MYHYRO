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
isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 2 ||
isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 3 ){

$action_post = $_POST['action_post'];
$now = time();

$id_type_cms = $_POST['id_type_cms'];

$Abonnements_forfaits_activer = $_POST['Abonnements_forfaits_activer'];
$Abonnements_forfaits_type_de_compte = $_POST['Abonnements_forfaits_type_de_compte'];

$Operation_code_promotion= $_POST['Operation_code_promotion'];

$type_de_compte_module= $_POST['type_de_compte_module'];
$messagerie_module= $_POST['messagerie_module'];
$paiements_module= $_POST['paiements_module'];
$Facturations_module= $_POST['Facturations_module'];
$code_promo_module= $_POST['code_promo_module'];
$Devis_module= $_POST['Devis_module'];
$Demande_de_devis_page_module= $_POST['Demande_de_devis_page_module'];
$Module_facture_commercial_active= $_POST['Module_facture_commercial_active'];
$Calendrier_page_module= $_POST['Calendrier_page_module'];
$activer_option_menu_categorie_page= $_POST['activer_option_menu_categorie_page'];
$Services_et_produits= $_POST['Services_et_produits'];
$Commandes= $_POST['Commandes'];
$Commandes_tracking= $_POST['Commandes_tracking'];

$FRONTIERE_PROFIL= $_POST['FRONTIERE_PROFIL'];
$type_de_compte_profil= $_POST['type_de_compte_profil'];
$Profil_module= $_POST['Profil_module'];
$Remplissage_du_profil_obligatoire= $_POST['Remplissage_du_profil_obligatoire'];

$Profil_public_coordonnees= $_POST['Profil_public_coordonnees'];

$Profil_public_classement= $_POST['Profil_public_classement'];
$Profil_type_compte_service_ouvert= $_POST['Profil_type_compte_service_ouvert'];
$Profil_module_url_page= $_POST['Profil_module_url_page'];
$Profil_public_titre= $_POST['Profil_public_titre'];
$Profil_public_titre_obligatoire= $_POST['Profil_public_titre_obligatoire'];
$Profil_public_description= $_POST['Profil_public_description'];
$Profil_public_description_obligatoire= $_POST['Profil_public_description_obligatoire'];

$Profil_module_video= $_POST['Profil_module_video'];
$Profil_portfolio= $_POST['Profil_portfolio'];
$Profil_avis= $_POST['Profil_avis'];
$Profil_public_google_map= $_POST['Profil_public_google_map'];
$Profil_public_reseaux_sociaux= $_POST['Profil_public_reseaux_sociaux'];
$Profil_public_site_web= $_POST['Profil_public_site_web'];
$Profil_public_site_web_obligatoire= $_POST['Profil_public_site_web_obligatoire'];
$Profil_public_skype= $_POST['Profil_public_skype'];
$Profil_public_skype_obligatoire= $_POST['Profil_public_skype_obligatoire'];

$Profil_public_messagerie= $_POST['Profil_public_messagerie'];

$Profil_compte_mail_confirmer= $_POST['Profil_compte_mail_confirmer'];
$Profil_compte_mail_confirmer_obligatoire= $_POST['Profil_compte_mail_confirmer_obligatoire'];
$Profil_compte_telephone_confirmer= $_POST['Profil_compte_telephone_confirmer'];
$Profil_compte_telephone_confirmer_obligatoire= $_POST['Profil_compte_telephone_confirmer_obligatoire'];

$Module_commerciaux_type_compte= $_POST['Module_commerciaux_type_compte'];
$Profil_facture= $_POST['Profil_facture'];
$Profil_devis= $_POST['Profil_devis'];
$Profil_demande_de_devis= $_POST['Profil_demande_de_devis'];

$Profil_compte_avatar_image= $_POST['Profil_compte_avatar_image'];
$Profil_compte_avatar_image_obligatoire= $_POST['Profil_compte_avatar_image_obligatoire'];

$cookies_validation_module = $_POST['cookies_validation_module'];
$page_ajouter_module = $_POST['page_ajouter_module'];
$page_photos_module = $_POST['page_photos_module'];

$page_information_module = $_POST['page_information_module'];
$gestion_page_dans_menu = $_POST['gestion_page_dans_menu'];
$gestion_page_dans_footer = $_POST['gestion_page_dans_footer'];

$Mise_en_relation_module_litige = $_POST['Mise_en_relation_module_litige'];

///////////////////////////////UPDATE
$sql_update = $bdd->prepare("UPDATE CMS_MODULES_CONFIGURATIONS SET 
	id_type_cms =?,
	Abonnements_forfaits_activer = ?,
	Abonnements_forfaits_type_de_compte = ?,
	type_de_compte_module= ?,
	messagerie_module= ?,
	paiements_module= ?,
	Facturations_module= ?,
	code_promo_module= ?,
	Devis_module= ?,
	Demande_de_devis_page_module= ?,
	Module_facture_commercial_active= ?,
	Calendrier_page_module= ?,
	activer_option_menu_categorie_page= ?,
	Services_et_produits= ?,
	Commandes= ?,
	Commandes_tracking= ?,
	type_de_compte_profil= ?,
	Profil_module= ?,
	Remplissage_du_profil_obligatoire= ?,
	Profil_public_coordonnees= ?,
	Profil_public_prix_moyen= ?,
	Profil_public_prix_moyen_obligatoire= ?,
	Profil_compte_avatar_image= ?,
	Profil_compte_avatar_image_obligatoire= ?,
	Profil_public_classement=  ?,
	Profil_type_compte_service_ouvert= ?,
	Profil_module_url_page= ?,
	Profil_public_titre= ?,
	Profil_public_titre_obligatoire= ?,
	Profil_public_description= ?,
	Profil_public_description_obligatoire= ?,
	Profil_module_video= ?,
	Profil_portfolio=?,
	Profil_avis= ?,
	Profil_public_google_map=?,
	Profil_public_reseaux_sociaux=?,
	Profil_public_site_web= ?,
	Profil_public_site_web_obligatoire=?,
	Profil_public_skype= ?,
	Profil_public_skype_obligatoire= ?,
	Profil_public_messagerie= ?,
	Profil_compte_mail_confirmer= ?,
	Profil_compte_mail_confirmer_obligatoire= ?,
	Profil_compte_telephone_confirmer= ?,
	Profil_compte_telephone_confirmer_obligatoire= ?,
	Module_commerciaux_type_compte= ?,
	Profil_facture= ?,
	Profil_devis= ?,
	Profil_demande_de_devis= ?,
	cookies_validation_module = ?,
	page_ajouter_module = ?,
	page_photos_module =?,
	page_information_module = ?,
	gestion_page_dans_menu = ?,
	gestion_page_dans_footer = ?,
	Mise_en_relation_module_litige = ?
WHERE id=?");
$sql_update->execute(array(
	$id_type_cms,
	$Abonnements_forfaits_activer,
	$Abonnements_forfaits_type_de_compte,
	$type_de_compte_module,
	$messagerie_module,
	$paiements_module,
	$Facturations_module,
	$code_promo_module,
	$Devis_module,
	$Demande_de_devis_page_module,
	$Module_facture_commercial_active,
	$Calendrier_page_module,
	$activer_option_menu_categorie_page,
	$Services_et_produits,
	$Commandes,
	$Commandes_tracking,
	$type_de_compte_profil,
	$Profil_module,
	$Remplissage_du_profil_obligatoire,
	$Profil_public_coordonnees,
	$Profil_public_prix_moyen,
	$Profil_public_prix_moyen_obligatoire,
	$Profil_compte_avatar_image,
	$Profil_compte_avatar_image_obligatoire,
	$Profil_public_classement,
	$Profil_type_compte_service_ouvert,
	$Profil_module_url_page,
	$Profil_public_titre,
	$Profil_public_titre_obligatoire,
	$Profil_public_description,
	$Profil_public_description_obligatoire,
	$Profil_module_video,
	$Profil_portfolio,
	$Profil_avis,
	$Profil_public_google_map,
	$Profil_public_reseaux_sociaux,
	$Profil_public_site_web,
	$Profil_public_site_web_obligatoire,
	$Profil_public_skype,
	$Profil_public_skype_obligatoire,
	$Profil_public_messagerie,
	$Profil_compte_mail_confirmer,
	$Profil_compte_mail_confirmer_obligatoire,
	$Profil_compte_telephone_confirmer,
	$Profil_compte_telephone_confirmer_obligatoire,
	$Module_commerciaux_type_compte,
	$Profil_facture,
	$Profil_devis,
	$Profil_demande_de_devis,
	$cookies_validation_module,
	$page_ajouter_module,
	$page_photos_module,
	$page_information_module,
	$gestion_page_dans_menu,
	$gestion_page_dans_footer,
	$Mise_en_relation_module_litige,
	'1'));                     
$sql_update->closeCursor();

///////////////////////////INCLUDE TITLE ET META PAGE SELON SELECTION TYPE CMS
include('Cms-include-title-meta-generiques-ajax.php');
///////////////////////////INCLUDE TITLE ET META PAGE SELON SELECTION TYPE CMS

$result = array("Texte_rapport"=>"Actions effectuées avec succès !","retour_validation"=>"ok","retour_lien"=>"");

////////////////////////////////////////////////////////////////////////////////MODIFIER / ACTION

$result = json_encode($result);
echo $result;

}else{
header('location: /index.html');
}

ob_end_flush();
?>