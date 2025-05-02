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

if(isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 1 ||
isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 2 ||
isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 3 ){

?>

<script>
$(document).ready(function (){

//AJAX SOUMISSION DU FORMULAIRE - MODIFIER
$(document).on("click", "#bouton_formulaire_informations", function (){
//ON SOUMET LE TEXTAREA TINYMCE
tinyMCE.triggerSave();
$.post({
url : '/administration/Configurations/Configurations-cms/Cms-modifier-ajax.php',
type : 'POST',
data: new FormData($("#formulaire-codes-promotions-modifier")[0]),
processData: false,
contentType: false,
dataType: "json",
success: function (res) {
if(res.retour_validation == "ok"){
popup_alert(res.Texte_rapport,"green filledlight","#009900","uk-icon-check");
}else{
popup_alert(res.Texte_rapport,"#CC0000 filledlight","#CC0000","uk-icon-times");
}
}
});
$("html, body").animate({ scrollTop: 0 }, "slow");
});

//AJAX SOUMISSION DU FORMULAIRE - MODIFIER
$(document).on("change", "#id_type_cms", function (){
//ON SOUMET LE TEXTAREA TINYMCE
$.post({
url : '/administration/Configurations/Configurations-cms/Cms-modifier-ajax.php',
type : 'POST',
data: new FormData($("#formulaire-codes-promotions-modifier")[0]),
processData: false,
contentType: false,
dataType: "json",
success: function (res) {
if(res.retour_validation == "ok"){
popup_alert(res.Texte_rapport,"green filledlight","#009900","uk-icon-check");
document.location.replace("?page=Cms");
}else{
popup_alert(res.Texte_rapport,"#CC0000 filledlight","#CC0000","uk-icon-times");
}
}
});
});


$(document).on("change", "#type_de_compte_module", function (){
type_compte();
});
type_compte();

function type_compte(){
if($("#type_de_compte_module").val() == "oui"){
$(".statut_type_compte_jquery").css("display","");
$(".profil_public_jquery2").css("display","");
$(".profil_jquery2").css("display","");
}
if($("#type_de_compte_module").val() == "non" || $("#type_de_compte_module").val() == "" ){
$(".statut_type_compte_jquery").css("display","none");
$(".statut_type_compte_jquery select").val("tous");
$(".profil_public_jquery2").css("display","none");
$(".profil_public_jquery2 select").val("tous");
$(".profil_jquery2").css("display","none");
$(".profil_jquery2 select").val("tous");
}
}


$(document).on("change", "#Annuaire_bloc_souscription_activer", function (){
bloc_souscription();
});
bloc_souscription();

function bloc_souscription(){
if($("#Annuaire_bloc_souscription_activer").val() == "oui"){
$(".bloc_subscription_jquery").css("display","");
}
if($("#Annuaire_bloc_souscription_activer").val() == "non" || $("#Annuaire_bloc_souscription_activer").val() == "" ){
$(".bloc_subscription_jquery").css("display","none");
$(".bloc_subscription_jquery select").val("non");
$(".bloc_subscription_jquery input").val("");
$(".bloc_subscription_jquery textarea").val("");
}
}


$(document).on("change", "#Annuaire_bouton_souscription_activer", function (){
bouton_souscription();
});
bouton_souscription();

function bouton_souscription(){
if($("#Annuaire_bouton_souscription_activer").val() == "oui"){
$(".bouton_subscription_jquery").css("display","");
}
if($("#Annuaire_bouton_souscription_activer").val() == "non" || $("#Annuaire_bouton_souscription_activer").val() == "" ){
$(".bouton_subscription_jquery").css("display","none");
$(".bouton_subscription_jquery select").val("non");
$(".bouton_subscription_jquery input").val("");
$(".bouton_subscription_jquery textarea").val("");
}
}


$(document).on("change", "#Profil_module", function (){
profil_jquery();
});
profil_jquery();

function profil_jquery(){
if($("#Profil_module").val() == "oui"){
$(".profil_jquery").css("display","");
$(".profil_jquery2").css("display","");
}
if($("#Profil_module").val() == "non" || $("#Profil_module").val() == "" ){
$(".profil_jquery").css("display","none");
$(".profil_jquery2").css("display","tous");
$(".profil_jquery select").val("non");
$(".profil_jquery select").val("non");
$(".profil_public_jquery select").val("non");
$(".profil_public_jquery2 select").val("tous");
}
profil_public_jquery();
}


$(document).on("change", "#Profil_module_url_page", function (){
profil_public_jquery();
});
profil_public_jquery();

function profil_public_jquery(){
if($("#Profil_module_url_page").val() == "oui"){
$(".profil_public_jquery").css("display","");
$(".profil_public_jquery2").css("display","");
}
if($("#Profil_module_url_page").val() == "non" || $("#Profil_module_url_page").val() == "" ){
$(".profil_public_jquery").css("display","none");
$(".profil_public_jquery2").css("display","none");
$(".profil_public_jquery select").val("non");
$(".profil_public_jquery2 select").val("tous");
}
}

});

</script>

<?php

$action = $_GET['action'];
$idaction = $_GET['idaction'];

?>

<ol class="breadcrumb">
  <li><a href="<?php echo $http; ?><?php echo $nomsiteweb; ?>">Accueil</a></li>
  <li><a href="<?php echo $mode_back_lien_interne; ?>">Administration</a></li>
  <?php if(empty($_GET['action'])){ ?> <li class="active">Configurations CMS</li> <?php }else{ ?> <li><a href="?page=Cms">Configurations CMS</a></li> <?php } ?>
</ol>

<?php

echo "<div id='bloctitre' style='text-align: left;' ><h1>Configurations CMS</h1></div><br />
<div style='clear: both;'></div>";

////////////////////Boutton administration
echo "<a href='".$mode_back_lien_interne."'>
<button type='button' class='btn btn-default' style='margin-right: 5px;' ><span class='uk-icon-cogs'></span> Administration</button></a>";
if(!empty($action)){
echo "<a href='?page=Cms'>
<button type='button' class='btn btn-default' style='margin-right: 5px;' ><span class='uk-icon-plus-circle'></span> Page précédente</button></a>";
}
echo "<div style='clear: both;'></div><br />";
////////////////////Boutton administration

?>

<div style='padding: 5px;'>

<?php
//////////////////////////MODULES CMS CONFIGURATIONS
///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM CMS_MODULES_CONFIGURATIONS WHERE id=1");
$req_select->execute();
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$id_type_cms = $ligne_select['id_type_cms'];
$Annuaire_payant_gratuit = $ligne_select['Annuaire_payant_gratuit'];
$url_abonnement_sufix = $ligne_select['url_abonnement_sufix'];

$FRONTIERE_OPERATION_CODE_PROMOTION = $ligne_select['FRONTIERE_OPERATION_CODE_PROMOTION'];
$Operation_code_promotion= $ligne_select['Operation_code_promotion'];

$FRONTIERE_MODULE= $ligne_select['FRONTIERE_MODULE'];
$type_de_compte_module= $ligne_select['type_de_compte_module'];
$messagerie_module= $ligne_select['messagerie_module'];
$paiements_module= $ligne_select['paiements_module'];
$Facturations_module= $ligne_select['Facturations_module'];
$code_promo_module= $ligne_select['code_promo_module'];
$Devis_module= $ligne_select['Devis_module'];
$Demande_de_devis_page_module= $ligne_select['Demande_de_devis_page_module'];
$Module_facture_commercial_active= $ligne_select['Module_facture_commercial_active'];
$Calendrier_page_module = $ligne_select['Calendrier_page_module'];
$activer_option_menu_categorie_page_cms= $ligne_select['activer_option_menu_categorie_page_cms'];
$Services_et_produits= $ligne_select['Services_et_produits'];
$Commandes= $ligne_select['Commandes'];
$Commandes_tracking= $ligne_select['Commandes_tracking'];

$FRONTIERE_PROFIL= $ligne_select['FRONTIERE_PROFIL'];
$type_de_compte_profil= $ligne_select['type_de_compte_profil'];
$Profil_module= $ligne_select['Profil_module'];
$Remplissage_du_profil_obligatoire= $ligne_select['Remplissage_du_profil_obligatoire'];
$Profil_public_coordonnees= $ligne_select['Profil_public_coordonnees'];
$Profil_compte_avatar_image= $ligne_select['Profil_compte_avatar_image'];
$Profil_compte_avatar_image_obligatoire= $ligne_select['Profil_compte_avatar_image_obligatoire'];

$Profil_public_classement= $ligne_select['Profil_public_classement'];
$Profil_type_compte_service_ouvert= $ligne_select['Profil_type_compte_service_ouvert'];

$Profil_public_titre= $ligne_select['Profil_public_titre'];
$Profil_public_titre_obligatoire= $ligne_select['Profil_public_titre_obligatoire'];
$Profil_public_description= $ligne_select['Profil_public_description'];
$Profil_public_description_obligatoire= $ligne_select['Profil_public_description_obligatoire'];

$Profil_module_url_page= $ligne_select['Profil_module_url_page'];

$Profil_module_video= $ligne_select['Profil_module_video'];
$Profil_portfolio= $ligne_select['Profil_portfolio'];
$Profil_avis= $ligne_select['Profil_avis'];
$Profil_public_google_map= $ligne_select['Profil_public_google_map'];
$Profil_public_reseaux_sociaux= $ligne_select['Profil_public_reseaux_sociaux'];
$Profil_public_site_web= $ligne_select['Profil_public_site_web'];
$Profil_public_site_web_obligatoire= $ligne_select['Profil_public_site_web_obligatoire'];
$Profil_public_skype= $ligne_select['Profil_public_skype'];
$Profil_public_skype_obligatoire= $ligne_select['Profil_public_skype_obligatoire'];

$Profil_public_messagerie= $ligne_select['Profil_public_messagerie'];

$Profil_compte_mail_confirmer= $ligne_select['Profil_compte_mail_confirmer'];
$Profil_compte_mail_confirmer_obligatoire= $ligne_select['Profil_compte_mail_confirmer_obligatoire'];
$Profil_compte_telephone_confirmer= $ligne_select['Profil_compte_telephone_confirmer'];
$Profil_compte_telephone_confirmer_obligatoire= $ligne_select['Profil_compte_telephone_confirmer_obligatoire'];

$Module_commerciaux_type_compte= $ligne_select['Module_commerciaux_type_compte'];
$Profil_facture= $ligne_select['Profil_facture'];
$Profil_devis= $ligne_select['Profil_devis'];
$Profil_demande_de_devis= $ligne_select['Profil_demande_de_devis'];

$Abonnements_forfaits_activer = $ligne_select['Abonnements_forfaits_activer'];
$Abonnements_forfaits_type_de_compte = $ligne_select['Abonnements_forfaits_type_de_compte'];

$FRONTIERE_MISE_EN_RELATION= $ligne_select['FRONTIERE_MISE_EN_RELATION'];
$Mise_en_relation_module_litige = $ligne_select['Mise_en_relation_module_litige'];

$FRONTIERE_DIVERS= $ligne_select['FRONTIERE_DIVERS'];
$cookies_validation_module = $ligne_select['cookies_validation_module'];
$page_ajouter_module = $ligne_select['page_ajouter_module'];
$page_photos_module = $ligne_select['page_photos_module'];
$page_information_module = $ligne_select['page_information_module'];
$gestion_page_dans_menu = $ligne_select['gestion_page_dans_menu'];
$gestion_page_dans_footer = $ligne_select['gestion_page_dans_footer'];

//////////////////////////MODULES CMS
///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM CMS_MODULES WHERE id=?");
$req_select->execute(array($id_type_cms));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$id = $ligne_select['id'];
$description_type_cms = $ligne_select['description_type_cms'];
$type_de_compte_cms = $ligne_select['type_de_compte_cms'];
$Abonnement_module_cms = $ligne_select['Abonnement_module_cms'];
$Code_promotion_cms = $ligne_select['Code_promotion_cms'];
$messagerie_module_cms = $ligne_select['messagerie_module_cms'];
$paiements_module_cms = $ligne_select['paiements_module_cms'];
$Facturations_module_cms = $ligne_select['Facturations_module_cms'];
$code_promo_module = $ligne_select['code_promo_module'];
$Devis_module_cms = $ligne_select['Devis_module_cms'];
$Demande_de_devis_page_module_cms = $ligne_select['Demande_de_devis_page_module_cms'];
$Calendrier_page_module_cms = $ligne_select['Calendrier_page_module_cms'];
$Litige_page_module_cms = $ligne_select['Litige_page_module_cms'];
$activer_option_menu_categorie_page_cms= $ligne_select['activer_option_menu_categorie_page_cms'];
$Profil_module_cms = $ligne_select['Profil_module_cms'];
$Services_et_produits_cms=  $ligne_select['Services_et_produits_cms'];
$Commandes_cms= $ligne_select['Commandes_cms'];

?>

<form id="formulaire-codes-promotions-modifier" method="post" action="?page=Cms&amp;action=Modifier">

<div style=' width: 100%; padding: 5px;' align='center'>

<div align='left'>
<h2>Modifier les configurations du CMS </h2>
</div>
<div style='clear: both;'></div>

<table style="text-align: left; width: 100%;" border="0" cellpadding="2" cellspacing="2"><tbody>

<tr><td colspan="2" rowspan="1">&nbsp;</td></tr>

<tr><td colspan="2" rowspan="1"><hr /></td></tr>

<tr><td colspan="2" rowspan="1">&nbsp;</td></tr>

<tr><td colspan="2" rowspan="1"><h3>Mode CMS</h3></td></tr>

<tr><td style="text-align: left; width: 190px; font-weight: bold;">Type de CMS</td>
<td style="text-align: left;">
<select name='id_type_cms' id='id_type_cms' class='form-control'>
<?php
///////////////////////////////SELECT BOUCLE
$req_boucle = $bdd->prepare("SELECT * FROM CMS WHERE activer='oui' ORDER BY position ASC");
$req_boucle->execute();
while($ligne_boucle = $req_boucle->fetch()){
$id_type_cms_liste = $ligne_boucle['id'];
$NOM_cms = $ligne_boucle['NOM_cms'];
if($id_type_cms_liste == $id_type_cms){
?>
<option selected value="<?php echo "$id_type_cms_liste"; ?>"> <?php echo "$NOM_cms"; ?></option>
<?php
}else{
?>
<option value="<?php echo "$id_type_cms_liste"; ?>"> <?php echo "$NOM_cms"; ?></option>
<?php
}
}
$req_boucle->closeCursor();
?>
</select>
</td></tr>
<tr><td colspan="2" rowspan="1">&nbsp;</td></tr>

<tr><td colspan="2" rowspan="1" style="text-align: left;">
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><b>Description du CMS sélectionné :</b></h3>
  </div>
  <div class="panel-body"  >
<textarea name="description_type_cms" style="height: 200px; width: 100%;" ><?php echo $description_type_cms; ?></textarea>
  </div>
</div>
</div>
</td></tr>
<tr><td colspan="2" rowspan="1">&nbsp;</td></tr>

<tr><td colspan="2" rowspan="1"><hr /></td></tr>

<?php
////////////////////////////////////////////////////////////////////ABONNEMENT FORFAIT
if($Abonnement_module_cms == "oui"){
?>

<tr><td colspan="2" rowspan="1"><h3>Abonnements &amp; forfaits </h3></td></tr>

<tr><td style="text-align: left; width: 190px;">Activer ?</td>
<td style="text-align: left;">
<select name='Abonnements_forfaits_activer' id='Abonnements_forfaits_activer' class='form-control' >
<option value="oui" <?php if($Abonnements_forfaits_activer == "oui"){ echo "selected"; } ?> > Oui &nbsp; </option>
<option value="non" <?php if($Abonnements_forfaits_activer == "non" || empty($Abonnements_forfaits_activer)  ){ echo "selected"; } ?> > Non &nbsp; </option>
</select>
</td></tr>
<tr><td colspan="2" rowspan="1">&nbsp;</td></tr>

<?php
////////////////////////////////////////////////////////////////////TYPE COMPTE CMS
if($type_de_compte_cms == "oui"){
?>
<tr><td style="text-align: left; width: 190px;"> Type de compte </td>
<td style="text-align: left;">
<select name='Abonnements_forfaits_type_de_compte' id='Abonnements_forfaits_type_de_compte' class='form-control' >
<option value="tous" <?php if($Abonnements_forfaits_type_de_compte == "tous"){ echo "selected"; } ?> > Tous les comptes </option>
<?php
///////////////////////////////SELECT BOUCLE
$req_boucle = $bdd->prepare("SELECT * FROM membres_type_de_compte WHERE activer='oui' ORDER BY position ASC");
$req_boucle->execute();
while($ligne_boucle = $req_boucle->fetch()){
$id_type = $ligne_boucle['id'];
$Nom_type_type = $ligne_boucle['Nom_type'];
if($id_type == $Abonnements_forfaits_type_de_compte){
?>
<option selected value="<?php echo "$id_type"; ?>"> Type de compte : <?php echo "$Nom_type_type"; ?></option>
<?php
}else{
?>
<option value="<?php echo "$id_type"; ?>"> Type de compte : <?php echo "$Nom_type_type"; ?></option>
<?php
}
}
$req_boucle->closeCursor();
?>
</select>
</td></tr>
<tr><td colspan="2" rowspan="1">&nbsp;</td></tr>
<?php
}
////////////////////////////////////////////////////////////////////TYPE COMPTE CMS
?>
<tr><td colspan="2" rowspan="1"><hr /></td></tr>

<?php
}
////////////////////////////////////////////////////////////////////ABONNEMENT FORFAIT
?>

<?php
////////////////////////////////////////////////////////////////////SI OPTION CODE PROMOTION 
if($Code_promotion_cms == "oui"){
?>
<tr><td colspan="2" rowspan="1"><h3>Opération code promotion</h3></td></tr>

<tr><td style="text-align: left; width: 190px;">Bandeau code promotion</td>
<td style="text-align: left;">
<select name='Operation_code_promotion' id='Operation_code_promotion' class='form-control' >
<option value="oui" <?php if($Operation_code_promotion == "oui"){ echo "selected"; } ?> > Oui &nbsp; </option>
<option value="non" <?php if($Operation_code_promotion == "non" || empty($Operation_code_promotion) ){ echo "selected"; } ?> > Non &nbsp; </option>
</select>
</td></tr>
<tr><td colspan="2" rowspan="1">&nbsp;</td></tr>

<tr><td colspan="2" rowspan="1"><hr /></td></tr>

<?php
}
////////////////////////////////////////////////////////////////////SI OPTION CODE PROMOTION 
?>


<tr><td colspan="2" rowspan="1">&nbsp;</td></tr>

<tr><td colspan="2" rowspan="1"><h3>Activation des modules</h3></td></tr>

<?php
////////////////////////////////////////////////////////////////////CATEGORIES DES PAGES ACTIVE
if($activer_option_menu_categorie_page_cms == "oui"){
?>
<tr><td style="text-align: left; width: 190px;">Catégories des pages <br /> (Back office - Front)</td>
<td style="text-align: left;">
<select name='activer_option_menu_categorie_page' id='activer_option_menu_categorie_page' class='form-control' >
<option value="oui" <?php if($activer_option_menu_categorie_page == "oui"){ echo "selected"; } ?> > Oui &nbsp; </option>
<option value="non" <?php if($activer_option_menu_categorie_page == "non" || empty($activer_option_menu_categorie_page)){ echo "selected"; } ?> > Non &nbsp; </option>
</select>
</td></tr>
<tr><td colspan="2" rowspan="1">&nbsp;</td></tr>
<?php
}
////////////////////////////////////////////////////////////////////CATEGORIES DES PAGES ACTIVE
?>

<?php
////////////////////////////////////////////////////////////////////SERVICES ET PRODUITS ACTIVE
if($Services_et_produits_cms == "oui"){
?>
<tr><td style="text-align: left; width: 190px;">Services et produits<br /> (Back office - Front)</td>
<td style="text-align: left;">
<select name='Services_et_produits' id='Services_et_produits' class='form-control' >
<option value="oui" <?php if($Services_et_produits == "oui"){ echo "selected"; } ?> > Oui &nbsp; </option>
<option value="non" <?php if($Services_et_produits == "non" || empty($Services_et_produits)){ echo "selected"; } ?> > Non &nbsp; </option>
</select>
</td></tr>
<tr><td colspan="2" rowspan="1">&nbsp;</td></tr>
<?php
}
////////////////////////////////////////////////////////////////////SERVICES ET PRODUITS ACTIVE
?>

<?php
////////////////////////////////////////////////////////////////////COMMANDES ACTIVE
if($Commandes_cms == "oui"){
?>
<tr><td style="text-align: left; width: 190px;">Modules commandes<br /> (Back office - Front)</td>
<td style="text-align: left;">
<select name='Commandes' id='Commandes' class='form-control' >
<option value="oui" <?php if($Commandes == "oui"){ echo "selected"; } ?> > Oui &nbsp; </option>
<option value="non" <?php if($Commandes == "non" || empty($Commandes)){ echo "selected"; } ?> > Non &nbsp; </option>
</select>
</td></tr>
<tr><td colspan="2" rowspan="1">&nbsp;</td></tr>

<tr><td style="text-align: left; width: 190px;">Commandes tracking<br /> (Back office - Front)</td>
<td style="text-align: left;">
<select name='Commandes_tracking' id='Commandes_tracking' class='form-control' >
<option value="oui" <?php if($Commandes_tracking == "oui"){ echo "selected"; } ?> > Oui &nbsp; </option>
<option value="non" <?php if($Commandes_tracking == "non" || empty($Commandes_tracking)){ echo "selected"; } ?> > Non &nbsp; </option>
</select>
</td></tr>
<tr><td colspan="2" rowspan="1">&nbsp;</td></tr>
<?php
}
////////////////////////////////////////////////////////////////////COMMANDES ACTIVE
?>

<?php
////////////////////////////////////////////////////////////////////TYPE COMPTE CMS
if($type_de_compte_cms == "oui"){
?>
<tr><td style="text-align: left; width: 190px;">Module type de compte <br /> (Back office - Front)</td>
<td style="text-align: left;">
<select name='type_de_compte_module' id='type_de_compte_module' class='form-control' >
<option value="" > Choisir </option>
<option value="oui" <?php if($type_de_compte_module == "oui"){ echo "selected"; } ?> > Oui &nbsp; </option>
<option value="non" <?php if($type_de_compte_module == "non" || empty($type_de_compte_module) ){ echo "selected"; } ?> > Non &nbsp; </option>
</select>
</select>
</td></tr>
<tr><td colspan="2" rowspan="1">&nbsp;</td></tr>
<?php
}
////////////////////////////////////////////////////////////////////TYPE COMPTE CMS
?>

<?php
////////////////////////////////////////////////////////////////////MESSAGERIE CMS
if($messagerie_module_cms == "oui"){
?>
<tr><td style="text-align: left; width: 190px;">Messagerie <br /> (Back office - Front)</td>
<td style="text-align: left;">
<select name='messagerie_module' id='messagerie_module' class='form-control' >
<option value="oui" <?php if($messagerie_module == "oui"){ echo "selected"; } ?> > Oui &nbsp; </option>
<option value="non" <?php if($messagerie_module == "non" || empty($messagerie_module)  ){ echo "selected"; } ?> > Non &nbsp; </option>
</select>
</td></tr>
<tr><td colspan="2" rowspan="1">&nbsp;</td></tr>
<?php
}
////////////////////////////////////////////////////////////////////MESSAGERIE CMS
?>

<?php
////////////////////////////////////////////////////////////////////PAIEMENT CMS
if($paiements_module_cms == "oui"){
?>
<tr><td style="text-align: left; width: 190px;">Paiement <br /> (Back office)</td>
<td style="text-align: left;">
<select name='paiements_module' id='paiements_module' class='form-control' >
<option value="oui" <?php if($paiements_module == "oui"){ echo "selected"; } ?> > Oui &nbsp; </option>
<option value="non" <?php if($paiements_module == "non" || empty($paiements_module)  ){ echo "selected"; } ?> > Non &nbsp; </option>
</select>
</td></tr>
<tr><td colspan="2" rowspan="1">&nbsp;</td></tr>
<?php
}
////////////////////////////////////////////////////////////////////PAIEMENT CMS
?>

<?php
////////////////////////////////////////////////////////////////////FACTURATIONS CMS
if($Facturations_module_cms == "oui"){
?>
<tr><td style="text-align: left; width: 190px;">Facturation <br /> (Back office - Front) </td>
<td style="text-align: left;">
<select name='Facturations_module' id='Facturations_module' class='form-control' >
<option value="oui" <?php if($Facturations_module == "oui"){ echo "selected"; } ?> > Oui &nbsp; </option>
<option value="non" <?php if($Facturations_module == "non" || empty($Facturations_module)  ){ echo "selected"; } ?> > Non &nbsp; </option>
</select>
</td></tr>
<tr><td colspan="2" rowspan="1">&nbsp;</td></tr>

<tr><td style="text-align: left; width: 190px;">Commercial facture <br /> (Back office)</td>
<td style="text-align: left;">
<select name='Module_facture_commercial_active' id='Module_facture_commercial_active' class='form-control' >
<option value="oui" <?php if($Module_facture_commercial_active == "oui"){ echo "selected"; } ?> > Oui &nbsp; </option>
<option value="non" <?php if($Module_facture_commercial_active == "non" || empty($Module_facture_commercial_active)  ){ echo "selected"; } ?> > Non &nbsp; </option>
</select>
</td></tr>
<tr><td colspan="2" rowspan="1">&nbsp;</td></tr>
<?php
}
////////////////////////////////////////////////////////////////////FACTURATIONS CMS
?>

<?php
////////////////////////////////////////////////////////////////////CODE PROMOTION CMS
if($code_promo_module == "oui"){
?>
<tr><td style="text-align: left; width: 190px;">Code promotion <br /> (Back office - Panier)</td>
<td style="text-align: left;">
<select name='code_promo_module' id='code_promo_module' class='form-control' >
<option value="oui" <?php if($code_promo_module == "oui"){ echo "selected"; } ?> > Oui &nbsp; </option>
<option value="non" <?php if($code_promo_module == "non" || empty($code_promo_module)  ){ echo "selected"; } ?> > Non &nbsp; </option>
</select>
</td></tr>
<tr><td colspan="2" rowspan="1">&nbsp;</td></tr>
<?php
}
////////////////////////////////////////////////////////////////////CODE PROMOTION CMS
?>

<?php
////////////////////////////////////////////////////////////////////DEVIS CMS
if($Devis_module_cms == "oui"){
?>
<tr><td style="text-align: left; width: 190px;">Devis <br /> (Back office - Front)</td>
<td style="text-align: left;">
<select name='Devis_module' id='Devis_module' class='form-control' >
<option value="oui" <?php if($Demande_de_devis_page_module == "oui"){ echo "selected"; } ?> > Oui &nbsp; </option>
<option value="non" <?php if($Demande_de_devis_page_module == "non" || empty($Demande_de_devis_page_module)  ){ echo "selected"; } ?> > Non &nbsp; </option>
</select>
</td></tr>
<tr><td colspan="2" rowspan="1">&nbsp;</td></tr>
<?php
}
////////////////////////////////////////////////////////////////////DEVIS CMS
?>

<?php
////////////////////////////////////////////////////////////////////DEMANDE DE DEVIS CMS
if($Demande_de_devis_page_module_cms == "oui"){
?>
<tr><td style="text-align: left; width: 190px;">Demande de devis <br /> (Back office - Front)</td>
<td style="text-align: left;">
<select name='Demande_de_devis_page_module' id='Demande_de_devis_page_module' class='form-control' >
<option value="oui" <?php if($Demande_de_devis_page_module == "oui"){ echo "selected"; } ?> > Oui &nbsp; </option>
<option value="non" <?php if($Demande_de_devis_page_module == "non" || empty($Demande_de_devis_page_module)  ){ echo "selected"; } ?> > Non &nbsp; </option>
</select>
</td></tr>
<tr><td colspan="2" rowspan="1">&nbsp;</td></tr>
<?php
}
////////////////////////////////////////////////////////////////////DEMANDE DE DEVIS CMS
?>

<?php
////////////////////////////////////////////////////////////////////CALENDRIER
if($Calendrier_page_module_cms == "oui"){
?>
<tr><td style="text-align: left; width: 190px;"> Calendrier <br /> (Back office - Front)</td>
<td style="text-align: left;">
<select name='Calendrier_page_module' id='Calendrier_page_module' class='form-control' >
<option value="oui" <?php if($Calendrier_page_module == "oui"){ echo "selected"; } ?> > Oui &nbsp; </option>
<option value="non" <?php if($Calendrier_page_module == "non" || empty($Calendrier_page_module) ){ echo "selected"; } ?> > Non &nbsp; </option>
</select>
</td></tr>
<tr><td colspan="2" rowspan="1">&nbsp;</td></tr>
<?php
}
////////////////////////////////////////////////////////////////////CALENDRIER
?>

<?php
////////////////////////////////////////////////////////////////////LITIGE
if($Litige_page_module_cms == "oui"){
?>
<tr><td style="text-align: left; width: 190px;">Litige <br /> (Back office - Front)</td>
<td style="text-align: left;">
<select name='Mise_en_relation_module_litige' id='Mise_en_relation_module_litige' class='form-control' >
<option value="oui" <?php if($Mise_en_relation_module_litige == "oui"){ echo "selected"; } ?> > Oui &nbsp; </option>
<option value="non" <?php if($Mise_en_relation_module_litige == "non" || empty($Mise_en_relation_module_litige)){ echo "selected"; } ?> > Non &nbsp; </option>
</select>
</td></tr>
<tr><td colspan="2" rowspan="1">&nbsp;</td></tr>
<?php
}
////////////////////////////////////////////////////////////////////LITIGE
?>

<tr><td colspan="2" rowspan="1"><hr /></td></tr>

<?php
////////////////////////////////////////////////////////////////////PROFIL CMS
if($Profil_module_cms == "oui"){
?>
<tr><td colspan="2" rowspan="1">&nbsp;</td></tr>

<tr><td colspan="2" rowspan="1"><h3>Profil membre</h3></td></tr>

<tr><td style="text-align: left; width: 190px;">Module profil ?</td>
<td style="text-align: left;">
<select name='Profil_module' id='Profil_module' class='form-control' >
<option value="oui" <?php if($Profil_module == "oui"){ echo "selected"; } ?> > Oui &nbsp; </option>
<option value="non" <?php if($Profil_module == "non" || empty($Profil_module) ){ echo "selected"; } ?> > Non &nbsp; </option>
</select>
</td></tr>
<tr><td colspan="2" rowspan="1">&nbsp;</td></tr>

<?php
////////////////////////////////////////////////////////////////////TYPE COMPTE CMS
if($type_de_compte_cms == "oui"){
?>
<tr class="profil_jquery2" ><td style="text-align: left; width: 190px;"> Profil activé pour ? </td>
<td style="text-align: left;">
<select name='type_de_compte_profil' id='type_de_compte_profil' class='form-control' >
<option value="tous" <?php if($type_de_compte_profil == "tous"){ echo "selected"; } ?> > Tous les comptes </option>
<?php
///////////////////////////////SELECT BOUCLE
$req_boucle = $bdd->prepare("SELECT * FROM membres_type_de_compte WHERE activer='oui' ORDER BY position ASC");
$req_boucle->execute();
while($ligne_boucle = $req_boucle->fetch()){
$id_type = $ligne_boucle['id'];
$Nom_type_type = $ligne_boucle['Nom_type'];

if($id_type == $type_de_compte_profil){
?>
<option selected value="<?php echo "$id_type"; ?>"> Type de compte : <?php echo "$Nom_type_type"; ?></option>
<?php
}else{
?>
<option value="<?php echo "$id_type"; ?>"> Type de compte : <?php echo "$Nom_type_type"; ?></option>
<?php
}
}
$req_boucle->closeCursor();
?>
</select>
</td></tr>

<tr ><td colspan="2" rowspan="1">&nbsp;</td></tr>

<tr class="profil_jquery"><td style="text-align: left; width: 190px;">Remplissage du profil obligatoire + avancement (%) </td>
<td style="text-align: left;">
<select name='Remplissage_du_profil_obligatoire' id='Remplissage_du_profil_obligatoire' class='form-control' style='width:100%;'>
<option value="oui" <?php if($Remplissage_du_profil_obligatoire == "oui"){ echo "selected"; } ?> > Oui &nbsp; </option>
<option value="non" <?php if($Remplissage_du_profil_obligatoire == "non" || empty($Remplissage_du_profil_obligatoire)  ){ echo "selected"; } ?> > Non &nbsp; </option>
</select>
</td></tr>
<tr class="profil_jquery"><td colspan="2" rowspan="1">&nbsp;</td></tr>

<tr class="profil_jquery"><td style="text-align: left; width: 190px;">Confirmation : Mail </td>
<td style="text-align: left;">
<select name='Profil_compte_mail_confirmer' id='Profil_compte_mail_confirmer' class='form-control' style='width:49%; display: inline-block;'>
<option value="oui" <?php if($Profil_compte_mail_confirmer == "oui"){ echo "selected"; } ?> > Oui &nbsp; </option>
<option value="non" <?php if($Profil_compte_mail_confirmer == "non" || empty($Profil_compte_mail_confirmer)  ){ echo "selected"; } ?> > Non &nbsp; </option>
</select>
<select name='Profil_compte_mail_confirmer_obligatoire' id='Profil_compte_mail_confirmer_obligatoire' class='form-control' style='width:49%; display: inline-block;' >
<option value="oui" <?php if($Profil_compte_mail_confirmer_obligatoire == "oui"){ echo "selected"; } ?> > Obligatoire dans le formulaire &nbsp; </option>
<option value="avancement" <?php if($Profil_compte_mail_confirmer_obligatoire == "avancement"){ echo "selected"; } ?> > Présent dans la barre d'avancement &nbsp; </option>
<option value="non" <?php if($Profil_compte_mail_confirmer_obligatoire == "non" || empty($Profil_compte_mail_confirmer_obligatoire)  ){ echo "selected"; } ?> > Aucun choix &nbsp; </option>
</select>
</td></tr>
<tr class="profil_jquery"><td colspan="2" rowspan="1">&nbsp;</td></tr>

<tr class="profil_jquery"><td style="text-align: left; width: 190px;">Confirmation : Téléphone </td>
<td style="text-align: left;">
<select name='Profil_compte_telephone_confirmer' id='Profil_compte_telephone_confirmer' class='form-control' style='width:49%; display: inline-block;' >
<option value="oui" <?php if($Profil_compte_telephone_confirmer == "oui"){ echo "selected"; } ?> > Oui &nbsp; </option>
<option value="non" <?php if($Profil_compte_telephone_confirmer == "non" || empty($Profil_compte_telephone_confirmer)  ){ echo "selected"; } ?> > Non &nbsp; </option>
</select>
<select name='Profil_compte_telephone_confirmer_obligatoire' id='Profil_compte_telephone_confirmer_obligatoire' class='form-control' style='width:49%; display: inline-block;' >
<option value="oui" <?php if($Profil_compte_telephone_confirmer_obligatoire == "oui"){ echo "selected"; } ?> > Obligatoire dans le formulaire &nbsp; </option>
<option value="avancement" <?php if($Profil_compte_telephone_confirmer_obligatoire == "avancement"){ echo "selected"; } ?> > Présent dans la barre d'avancement &nbsp; </option>
<option value="non" <?php if($Profil_compte_telephone_confirmer_obligatoire == "non" || empty($Profil_compte_telephone_confirmer_obligatoire)  ){ echo "selected"; } ?> > Aucun choix &nbsp; </option>
</select>
</td></tr>
<tr class="profil_jquery"><td colspan="2" rowspan="1">&nbsp;</td></tr>

<tr class="profil_jquery"><td style="text-align: left; width: 190px;">Image/Avatar </td>
<td style="text-align: left;">
<select name='Profil_compte_avatar_image' id='Profil_compte_avatar_image' class='form-control' style='width:49%; display: inline-block;' >
<option value="oui" <?php if($Profil_compte_avatar_image == "oui"){ echo "selected"; } ?> > Oui &nbsp; </option>
<option value="non" <?php if($Profil_compte_avatar_image == "non" || empty($Profil_compte_telephone_confirmer)  ){ echo "selected"; } ?> > Non &nbsp; </option>
</select>
<select name='Profil_compte_avatar_image_obligatoire' id='Profil_compte_avatar_image_obligatoire' class='form-control' style='width:49%; display: inline-block;' >
<option value="avancement" <?php if($Profil_compte_avatar_image_obligatoire == "oui"){ echo "selected"; } ?> > Présent dans la barre d'avancement &nbsp; </option>
<option value="non" <?php if($Profil_compte_avatar_image_obligatoire == "non" || empty($Profil_compte_avatar_image_obligatoire)  ){ echo "selected"; } ?> > Aucun choix &nbsp; </option>
</select>
</td></tr>
<tr class="profil_jquery"><td colspan="2" rowspan="1">&nbsp;</td></tr>

<tr class="profil_jquery"><td style="text-align: left; width: 190px;">Réseaux sociaux </td>
<td style="text-align: left;">
<select name='Profil_public_reseaux_sociaux' id='Profil_public_reseaux_sociaux' class='form-control' >
<option value="oui" <?php if($Profil_public_reseaux_sociaux == "oui"){ echo "selected"; } ?> > Oui &nbsp; </option>
<option value="non" <?php if($Profil_public_reseaux_sociaux == "non" || empty($Profil_public_reseaux_sociaux)  ){ echo "selected"; } ?> > Non &nbsp; </option>
</select>
</td></tr>
<tr class="profil_jquery"><td colspan="2" rowspan="1">&nbsp;</td></tr>

<tr class="profil_jquery"><td style="text-align: left; width: 190px;">Site web </td>
<td style="text-align: left;">
<select name='Profil_public_site_web' id='Profil_public_site_web' class='form-control' style='width:49%; display: inline-block;' >
<option value="oui" <?php if($Profil_public_site_web == "oui"){ echo "selected"; } ?> > Oui &nbsp; </option>
<option value="non" <?php if($Profil_public_site_web == "non" || empty($Profil_public_site_web)  ){ echo "selected"; } ?> > Non &nbsp; </option>
</select>
<select name='Profil_public_site_web_obligatoire' id='Profil_public_site_web_obligatoire' class='form-control' style='width:49%; display: inline-block;' >
<option value="oui" <?php if($Profil_public_site_web_obligatoire == "oui"){ echo "selected"; } ?> > Obligatoire dans le formulaire &nbsp; </option>
<option value="avancement" <?php if($Profil_public_site_web_obligatoire == "avancement"){ echo "selected"; } ?> > Présent dans la barre d'avancement &nbsp; </option>
<option value="non" <?php if($Profil_public_site_web_obligatoire == "non" || empty($Profil_public_site_web_obligatoire)  ){ echo "selected"; } ?> > Aucun choix &nbsp; </option>
</select>

</td></tr>
<tr class="profil_jquery"><td colspan="2" rowspan="1">&nbsp;</td></tr>

<tr class="profil_jquery"><td style="text-align: left; width: 190px;">Skype </td>
<td style="text-align: left;">
<select name='Profil_public_skype' id='Profil_public_skype' class='form-control' style='width:49%; display: inline-block;'>
<option value="oui" <?php if($Profil_public_skype == "oui"){ echo "selected"; } ?> > Oui &nbsp; </option>
<option value="non" <?php if($Profil_public_skype == "non" || empty($Profil_public_skype)  ){ echo "selected"; } ?> > Non &nbsp; </option>
</select>
<select name='Profil_public_skype_obligatoire' id='Profil_public_skype_obligatoire' class='form-control' style='width:49%; display: inline-block;' >
<option value="oui" <?php if($Profil_public_skype_obligatoire == "oui"){ echo "selected"; } ?> > Obligatoire dans le formulaire &nbsp; </option>
<option value="avancement" <?php if($Profil_public_skype_obligatoire == "avancement"){ echo "selected"; } ?> > Présent dans la barre d'avancement &nbsp; </option>
<option value="non" <?php if($Profil_public_skype_obligatoire == "non" || empty($Profil_public_skype_obligatoire)  ){ echo "selected"; } ?> > Aucun choix &nbsp; </option>
</select>
</td></tr>
<tr class="profil_jquery"><td colspan="2" rowspan="1">&nbsp;</td></tr>
<tr><td colspan="2" rowspan="1"><hr /></td></tr>
<tr ><td colspan="2" rowspan="1">&nbsp;</td></tr>

<?php
}
////////////////////////////////////////////////////////////////////TYPE COMPTE CMS
?>

<tr class="profil_jquery"><td colspan="2" rowspan="1" ><h3>Profil public membre </h3></td></tr>

<tr class="profil_jquery"><td style="text-align: left; width: 190px;">Profil public ? </td>
<td style="text-align: left;">
<select name='Profil_module_url_page' id='Profil_module_url_page' class='form-control' >
<option value="oui" <?php if($Profil_module_url_page == "oui"){ echo "selected"; } ?> > Oui &nbsp; </option>
<option value="non" <?php if($Profil_module_url_page == "non" || empty($Profil_module_url_page) ){ echo "selected"; } ?> > Non &nbsp; </option>
</select>
</td></tr>
<tr class="profil_jquery" ><td colspan="2" rowspan="1">&nbsp;</td></tr>

<?php
////////////////////////////////////////////////////////////////////TYPE COMPTE CMS
if($type_de_compte_cms == "oui"){
?>
<tr class="profil_public_jquery2" ><td style="text-align: left; width: 190px;">Type de compte : Profil public </td>
<td style="text-align: left;">
<select name='Profil_type_compte_service_ouvert' id='Profil_type_compte_service_ouvert' class='form-control' >
<option value="tous" <?php if($Profil_type_compte_service_ouvert == "tous"){ echo "selected"; } ?> > Tous les comptes </option>
<?php
///////////////////////////////SELECT BOUCLE
$req_boucle = $bdd->prepare("SELECT * FROM membres_type_de_compte WHERE activer='oui' ORDER BY position ASC");
$req_boucle->execute();
while($ligne_boucle = $req_boucle->fetch()){
$id_type = $ligne_boucle['id'];
$Nom_type_type = $ligne_boucle['Nom_type'];
if($id_type == $Profil_type_compte_service_ouvert){
?>
<option selected value="<?php echo "$id_type"; ?>"> Type de compte : <?php echo "$Nom_type_type"; ?></option>
<?php
}else{
?>
<option value="<?php echo "$id_type"; ?>"> Type de compte : <?php echo "$Nom_type_type"; ?></option>
<?php
}
}
$req_boucle->closeCursor();
?>
</select>
</select>
</td></tr>
<tr class="profil_public_jquery2" ><td colspan="2" rowspan="1">&nbsp;</td></tr>
<?php
}
////////////////////////////////////////////////////////////////////TYPE COMPTE CMS
?>

<tr class="profil_public_jquery"><td style="text-align: left; width: 190px;">Profil public : Titre </td>
<td style="text-align: left;">
<select name='Profil_public_titre' id='Profil_public_titre' class='form-control' style='width:49%; display: inline-block;' >
<option value="oui" <?php if($Profil_public_titre == "oui"){ echo "selected"; } ?> > Oui &nbsp; </option>
<option value="non" <?php if($Profil_public_titre == "non" || empty($Profil_public_titre)  ){ echo "selected"; } ?> > Non &nbsp; </option>
</select>
<select name='Profil_public_titre_obligatoire' id='Profil_public_titre_obligatoire' class='form-control' style='width:49%; display: inline-block;' >
<option value="oui" <?php if($Profil_public_titre_obligatoire == "oui"){ echo "selected"; } ?> > Obligatoire dans le formulaire &nbsp; </option>
<option value="avancement" <?php if($Profil_public_titre_obligatoire == "avancement"){ echo "selected"; } ?> > Présent dans la barre d'avancement &nbsp; </option>
<option value="non" <?php if($Profil_public_titre_obligatoire == "non" || empty($Profil_public_titre_obligatoire)  ){ echo "selected"; } ?> > Aucun choix &nbsp; </option>
</select>
</td></tr>
<tr class="profil_public_jquery"><td colspan="2" rowspan="1">&nbsp;</td></tr>

<tr class="profil_public_jquery"><td style="text-align: left; width: 190px;">Profil public : Description </td>
<td style="text-align: left;">
<select name='Profil_public_description' id='Profil_public_description' class='form-control' style='width:49%; display: inline-block;' >
<option value="oui" <?php if($Profil_public_description == "oui"){ echo "selected"; } ?> > Oui &nbsp; </option>
<option value="non" <?php if($Profil_public_description == "non" || empty($Profil_public_description)  ){ echo "selected"; } ?> > Non &nbsp; </option>
</select>
<select name='Profil_public_description_obligatoire' id='Profil_public_description_obligatoire' class='form-control' style='width:49%; display: inline-block;' >
<option value="oui" <?php if($Profil_public_description_obligatoire == "oui"){ echo "selected"; } ?> > Obligatoire dans le formulaire &nbsp; </option>
<option value="avancement" <?php if($Profil_public_description_obligatoire == "avancement"){ echo "selected"; } ?> > Présent dans la barre d'avancement &nbsp; </option>
<option value="non" <?php if($Profil_public_description_obligatoire == "non" || empty($Profil_public_description_obligatoire)  ){ echo "selected"; } ?> > Aucun choix &nbsp; </option>
</select>
</td></tr>
<tr class="profil_public_jquery"><td colspan="2" rowspan="1">&nbsp;</td></tr>

<tr class="profil_public_jquery"><td style="text-align: left; width: 190px;">Profil public : Module vidéo </td>
<td style="text-align: left;">
<select name='Profil_module_video' id='Profil_module_video' class='form-control' >
<option value="oui" <?php if($Profil_module_video == "oui"){ echo "selected"; } ?> > Oui &nbsp; </option>
<option value="non" <?php if($Profil_module_video == "non" || empty($Profil_module_video)  ){ echo "selected"; } ?> > Non &nbsp; </option>
</select>
</td></tr>
<tr class="profil_public_jquery"><td colspan="2" rowspan="1">&nbsp;</td></tr>

<tr class="profil_public_jquery"><td style="text-align: left; width: 190px;">Profil public : Coordonnées </td>
<td style="text-align: left;">
<select name='Profil_public_coordonnees' id='Profil_public_coordonnees' class='form-control' >
<option value="oui" <?php if($Profil_public_coordonnees == "oui"){ echo "selected"; } ?> > Oui &nbsp; </option>
<option value="non" <?php if($Profil_public_coordonnees == "non" || empty($Profil_public_coordonnees)  ){ echo "selected"; } ?> > Non &nbsp; </option>
</select>
</td></tr>
<tr class="profil_public_jquery"><td colspan="2" rowspan="1">&nbsp;</td></tr>

<tr class="profil_public_jquery"><td style="text-align: left; width: 190px;">Profil public : Google map </td>
<td style="text-align: left;">
<select name='Profil_public_google_map' id='Profil_public_google_map' class='form-control' >
<option value="oui" <?php if($Profil_public_google_map == "oui"){ echo "selected"; } ?> > Oui &nbsp; </option>
<option value="non" <?php if($Profil_public_google_map == "non" || empty($Profil_public_google_map) ){ echo "selected"; } ?> > Non &nbsp; </option>
</select>
</td></tr>
<tr class="profil_public_jquery"><td colspan="2" rowspan="1">&nbsp;</td></tr>

<tr class="profil_public_jquery"><td style="text-align: left; width: 190px;">Profil public : Messagerie </td>
<td style="text-align: left;">
<select name='Profil_public_messagerie' id='Profil_public_messagerie' class='form-control' >
<option value="oui" <?php if($Profil_public_messagerie == "oui"){ echo "selected"; } ?> > Oui &nbsp; </option>
<option value="non" <?php if($Profil_public_messagerie == "non" || empty($Profil_public_messagerie) ){ echo "selected"; } ?> > Non &nbsp; </option>
</select>
</td></tr>
<tr class="profil_public_jquery"><td colspan="2" rowspan="1">&nbsp;</td></tr>

<tr><td colspan="2" rowspan="1" class="profil_jquery" ><hr /></td></tr>
<tr><td colspan="2" rowspan="1" class="profil_jquery" >&nbsp;</td></tr>

<tr class="profil_public_jquery"><td style="text-align: left; width: 190px;"> Profil public : Portfolio </td>
<td style="text-align: left;">
<select name='Profil_portfolio' id='Profil_portfolio' class='form-control' >
<option value="oui" <?php if($Profil_portfolio == "oui"){ echo "selected"; } ?> > Oui &nbsp; </option>
<option value="non" <?php if($Profil_portfolio == "non" || empty($Profil_portfolio) ){ echo "selected"; } ?> > Non &nbsp; </option>
</select>
</td></tr>
<tr class="profil_public_jquery"><td colspan="2" rowspan="1">&nbsp;</td></tr>

<tr class="profil_public_jquery"><td style="text-align: left; width: 190px;">Profil public : Avis </td>
<td style="text-align: left;">
<select name='Profil_avis' id='Profil_avis' class='form-control' >
<option value="oui" <?php if($Profil_avis == "oui"){ echo "selected"; } ?> > Oui &nbsp; </option>
<option value="non" <?php if($Profil_avis == "non" || empty($Profil_avis) ){ echo "selected"; } ?> > Non &nbsp; </option>
</select>
</td></tr>
<tr class="profil_public_jquery"><td colspan="2" rowspan="1">&nbsp;</td></tr>

<tr><td colspan="2" rowspan="1" class="profil_jquery" ><hr /></td></tr>
<tr><td colspan="2" rowspan="1" class="profil_jquery" >&nbsp;</td></tr>

<?php
}
////////////////////////////////////////////////////////////////////PROFIL CMS
?>

<?php
///////////////////////////////////////////////////////////////////SI MODULES COMMERCIAUX ACTIVES
if($Facturations_module_cms == "oui" || $Demande_de_devis_page_module_cms == "oui" || $Devis_module_cms == "oui" ){
?>
<tr><td colspan="2" rowspan="1"><h3>Modules commerciaux espace membre </h3></td></tr>

<?php
////////////////////////////////////////////////////////////////////TYPE COMPTE CMS
if($type_de_compte_cms == "oui"){
?>
<tr class="statut_type_compte_jquery"><td style="text-align: left; width: 190px;">Activés pour ? </td>
<td style="text-align: left;">
<select name='Module_commerciaux_type_compte' id='Module_commerciaux_type_compte' class='form-control' >
<option value="tous" <?php if($Module_commerciaux_type_compte == "tous"){ echo "selected"; } ?> > Tous les comptes </option>
<?php
///////////////////////////////SELECT BOUCLE
$req_boucle = $bdd->prepare("SELECT * FROM membres_type_de_compte WHERE activer='oui' ORDER BY position ASC");
$req_boucle->execute();
while($ligne_boucle = $req_boucle->fetch()){
$id_type = $ligne_boucle['id'];
$Nom_type_type = $ligne_boucle['Nom_type'];
if($id_type == $Module_commerciaux_type_compte){
?>
<option selected value="<?php echo "$id_type"; ?>"> Type de compte : <?php echo "$Nom_type_type"; ?></option>
<?php
}else{
?>
<option value="<?php echo "$id_type"; ?>"> Type de compte : <?php echo "$Nom_type_type"; ?></option>
<?php
}
}
$req_boucle->closeCursor();
?>
</select>
</td></tr>
<tr class="statut_type_compte_jquery"><td colspan="2" rowspan="1">&nbsp;</td></tr>
<?php
}
////////////////////////////////////////////////////////////////////TYPE COMPTE CMS
?>

<?php
////////////////////////////////////////////////////////////////////FACTURATIONS CMS
if($Facturations_module_cms == "oui"){
?>
<tr><td style="text-align: left; width: 190px;">Profil facture</td>
<td style="text-align: left;">
<select name='Profil_facture' id='Profil_facture' class='form-control' >
<option value="oui" <?php if($Profil_facture == "oui"){ echo "selected"; } ?> > Oui &nbsp; </option>
<option value="non" <?php if($Profil_facture == "non" || empty($Profil_facture) ){ echo "selected"; } ?> > Non &nbsp; </option>
</select>
</td></tr>
<tr><td colspan="2" rowspan="1">&nbsp;</td></tr>
<?php
}
////////////////////////////////////////////////////////////////////FACTURATIONS CMS
?>

<?php
////////////////////////////////////////////////////////////////////DEMANDE DE DEVIS CMS
if($Demande_de_devis_page_module_cms == "oui"){
?>
<tr><td style="text-align: left; width: 190px;">Profil demande de devis </td>
<td style="text-align: left;">
<select name='Profil_demande_de_devis' id='Profil_demande_de_devis' class='form-control' >
<option value="oui" <?php if($Profil_demande_de_devis == "oui"){ echo "selected"; } ?> > Oui &nbsp; </option>
<option value="non" <?php if($Profil_demande_de_devis == "non" || empty($Profil_demande_de_devis) ){ echo "selected"; } ?> > Non &nbsp; </option>
</select>
</td></tr>
<tr><td colspan="2" rowspan="1">&nbsp;</td></tr>
<?php
}
////////////////////////////////////////////////////////////////////DEMANDE DE DEVIS CMS
?>

<?php
////////////////////////////////////////////////////////////////////DEVIS CMS
if($Devis_module_cms == "oui"){
?>
<tr><td style="text-align: left; width: 190px;">Profil devis </td>
<td style="text-align: left;">
<select name='Profil_devis' id='Profil_devis' class='form-control' >
<option value="oui" <?php if($Profil_devis == "oui"){ echo "selected"; } ?> > Oui &nbsp; </option>
<option value="non" <?php if($Profil_devis == "non" || empty($Profil_devis) ){ echo "selected"; } ?> > Non &nbsp; </option>
</select>
</td></tr>
<tr><td colspan="2" rowspan="1">&nbsp;</td></tr>
<?php
}
////////////////////////////////////////////////////////////////////DEVIS CMS
?>

<tr><td colspan="2" rowspan="1"><hr /></td></tr>

<tr><td colspan="2" rowspan="1">&nbsp;</td></tr>

<?php
}
///////////////////////////////////////////////////////////////////SI MODULES COMMERCIAUX ACTIVES
?>

<tr><td colspan="2" rowspan="1"><h3>Divers</h3></td></tr>

<tr><td style="text-align: left; width: 190px;"> Bandeaux cookies <br /> (Front)</td>
<td style="text-align: left;">
<select name='cookies_validation_module' id='cookies_validation_module' class='form-control' >
<option value="oui" <?php if($cookies_validation_module == "oui"){ echo "selected"; } ?> > Oui &nbsp; </option>
<option value="non" <?php if($cookies_validation_module == "non" || empty($cookies_validation_module) ){ echo "selected"; } ?> > Non &nbsp; </option>
</select>
</td></tr>
<tr><td colspan="2" rowspan="1">&nbsp;</td></tr>

<tr><td style="text-align: left; width: 190px;">Module ajouter page <br /> (back office) </td>
<td style="text-align: left;">
<select name='page_ajouter_module' id='page_ajouter_module' class='form-control' >
<option value="oui" <?php if($page_ajouter_module == "oui"){ echo "selected"; } ?> > Oui &nbsp; </option>
<option value="non" <?php if($page_ajouter_module == "non" || empty($page_ajouter_module) ){ echo "selected"; } ?> > Non &nbsp; </option>
</select>
</td></tr>
<tr><td colspan="2" rowspan="1">&nbsp;</td></tr>

<tr><td style="text-align: left; width: 190px;">Module photo pour les pages <br /> (back office) </td>
<td style="text-align: left;">
<select name='page_photos_module' id='page_photos_module' class='form-control' >
<option value="oui" <?php if($page_photos_module == "oui"){ echo "selected"; } ?> > Oui &nbsp; </option>
<option value="non" <?php if($page_photos_module == "non" || empty($page_photos_module) ){ echo "selected"; } ?> > Non &nbsp; </option>
</select>
</td></tr>
<tr><td colspan="2" rowspan="1">&nbsp;</td></tr>

<tr><td style="text-align: left; width: 190px;">Page information <br /> (Back office)</td>
<td style="text-align: left;">
<select name='page_information_module' id='page_information_module' class='form-control' >
<option value="oui" <?php if($page_information_module == "oui"){ echo "selected"; } ?> > Oui &nbsp; </option>
<option value="non" <?php if($page_information_module == "non" || empty($page_information_module) ){ echo "selected"; } ?> > Non &nbsp; </option>
</select>
</td></tr>
<tr><td colspan="2" rowspan="1">&nbsp;</td></tr>

<tr><td style="text-align: left; width: 190px;">Gestion page menu ? <br /> (back office) </td>
<td style="text-align: left;">
<select name='gestion_page_dans_menu' id='gestion_page_dans_menu' class='form-control' >
<option value="oui" <?php if($gestion_page_dans_menu == "oui"){ echo "selected"; } ?> > Oui &nbsp; </option>
<option value="non" <?php if($gestion_page_dans_menu == "non" || empty($gestion_page_dans_menu)  ){ echo "selected"; } ?> > Non &nbsp; </option>
</select>
</td></tr>
<tr><td colspan="2" rowspan="1">&nbsp;</td></tr>

<tr><td style="text-align: left; width: 190px;">Gestion page footer ? <br /> (back office) </td>
<td style="text-align: left;">
<select name='gestion_page_dans_footer' id='gestion_page_dans_footer' class='form-control' >
<option value="oui" <?php if($gestion_page_dans_footer == "oui"){ echo "selected"; } ?> > Oui &nbsp; </option>
<option value="non" <?php if($gestion_page_dans_footer == "non" || empty($gestion_page_dans_footer)  ){ echo "selected"; } ?> > Non &nbsp; </option>
</select>
</td></tr>
<tr><td colspan="2" rowspan="1">&nbsp;</td></tr>

<tr><td style="text-align: center; margin-right: 5px;" colspan="2" rowspan="1" >
<button id='bouton_formulaire_informations' type='button' class='btn btn-success' onclick="return false;" style='width: 150px;' >ENREGISTRER</button>
</td></tr>

</tbody></table>
</div><br /><br />

</form>

</div>

<?php

}else{
header('location: /index.html');
}
