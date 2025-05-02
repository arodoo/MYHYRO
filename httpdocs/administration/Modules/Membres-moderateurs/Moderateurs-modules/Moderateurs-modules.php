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
isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 4 ){

?>

<script>
$(document).ready(function (){

//AJAX SOUMISSION DU FORMULAIRE - MODIFIER - AJOUTER
$(document).on("click", "#bouton-formulaire-module-moderateur", function (){
//ON SOUMET LE TEXTAREA TINYMCE
tinyMCE.triggerSave();
$.post({
url : '/administration/Modules/Membres-moderateurs/Moderateurs-modules/Moderateurs-modules-action-ajouter-modifier-ajax.php',
type : 'POST',
<?php if ($_GET['action'] == "Modifier"){ ?>
data: new FormData($("#formulaire-module-moderateur")[0]),
<?php }else{ ?>
data: new FormData($("#formulaire-module-moderateur")[0]),
<?php } ?>
processData: false,
contentType: false,
dataType: "json",
success: function (res) {
if(res.retour_validation == "ok"){
popup_alert(res.Texte_rapport,"green filledlight","#009900","uk-icon-check");
<?php if ($_GET['action'] != "Modifier"){ ?>
$("#formulaire-module-moderateur")[0].reset();
<?php } ?>
}else{
popup_alert(res.Texte_rapport,"#CC0000 filledlight","#CC0000","uk-icon-times");
}
}
});
listeModuleModerateur();
});

//AJAX - SUPPRIMER
$(document).on("click", ".supprimer-module-moderateur-liste", function (){
$.post({
url : '/administration/Modules/Membres-moderateurs/Moderateurs-modules/Moderateurs-modules-action-supprimer-ajax.php',
type : 'POST',
data: {idaction:$(this).attr("data-id")},
dataType: "json",
success: function (res) {
if(res.retour_validation == "ok"){
popup_alert(res.Texte_rapport,"green filledlight","#009900","uk-icon-check");
}else{
popup_alert(res.Texte_rapport,"#CC0000 filledlight","#CC0000","uk-icon-times");
}
}
});
listeModuleModerateur();
});

//FUNCTION AJAX - LISTE 
function listeModuleModerateur(){
$.post({
url : '/administration/Modules/Membres-moderateurs/Moderateurs-modules/Moderateurs-modules-liste-ajax.php',
type : 'POST',
dataType: "html",
success: function (res) {
$("#liste-Module-Moderateur").html(res);
}
});
}
listeModuleModerateur();

/////////////////////////////////////////////// RAPPORTS ///////////////////////////////////////////////
<?php
include('Moderateurs-modules-include-jquery-rapport.php');
?>

///////////////////////////////////////////////ON AFFICHE LA POP-UP AVEC LES GROUPES ASSOCIES AU MODULE
$(document).on("click" , ".associer-groupe-liste", function (){
$('#association-groupe-module-jquery').modal({ backdrop: 'static', keyboard: false, show: true });
idclick = $(this).attr("data-id");
listeGroupesAssocies(idclick);
});

//AJAX SOUMISSION DU FORMULAIRE - MODIFIER - AJOUTER
$(document).on("click", "#bouton-formulaire-associaion-groupe", function (){
idclick = $(this).attr("data-id");
$.post({
url : '/administration/Modules/Membres-moderateurs/Moderateurs-modules/Moderateurs-modules-groupes-associes-actons-ajax.php',
type : 'POST',
data: new FormData($("#formulaire-associaion-groupe-module")[0]),
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
listeGroupesAssocies(idclick);
});

function listeGroupesAssocies(idclick){
$.post({
url : '/administration/Modules/Membres-moderateurs/Moderateurs-modules/Moderateurs-modules-groupes-associes-liste-ajax.php',
type : 'POST',
data: {idaction:idclick},
dataType: "html",
success: function (res) {
$("#liste-groupes-associes-module").html(res);
}
});
}

});

</script>

<ol class="breadcrumb">
  <li><a href="<?php echo $http; ?><?php echo $nomsiteweb; ?>">Accueil</a></li>
  <li><a href="<?php echo $mode_back_lien_interne; ?>">Administration</a></li>
  <?php if(empty($_GET['action'])){ ?> <li class="active">Gestion des modules déclarés pour les groupes </li> <?php }else{ ?> <li><a href="?page=Moderateurs-modules">Gestion des modules déclarés pour les groupes </a></li> <?php } ?>
  <?php if($_GET['action'] == "Modifier" ){ ?> <li class="active">Modifications</li> <?php } ?>
  <?php if($_GET['action'] == "Ajouter" ){ ?> <li class="active">Ajouter</li> <?php } ?>
</ol>

<div id='bloctitre' style='text-align: left;' ><h1>Gestion des modules déclarés pour les groupes </h1></div><br /><br />
<div style='clear: both;'></div>

<?php

$action = $_GET['action'];
$idaction = $_GET['idaction'];

////////////////////Bouton administration
echo "<a href='".$mode_back_lien_interne."'><button type='button' class='btn btn-default' style='margin-right: 5px;' ><span class='uk-icon-cogs'></span> Administration</button></a>";

echo "<a href='?page=Moderateurs'><button type='button' class='btn btn-primary' style='margin-right: 5px;' ><span class='uk-icon-users'></span> Gestion des modérateurs </button></a>";
echo "<a href='?page=Moderateurs-modules'><button type='button' class='btn btn-info' style='margin-right: 5px;' ><span class='uk-icon-check-square'></span> Gestion des modules déclarés </button></a>";
echo "<a href='?page=Moderateurs-groupes'><button type='button' class='btn btn-primary' style='margin-right: 5px;' ><span class='uk-icon-share-alt-square'></span> Gestion des groupes</button></a>";
echo "<a href='?page=Moderateurs-groupes-modules'><button type='button' class='btn btn-primary' style='margin-right: 5px;' ><span class='uk-icon-sign-out'></span> Associations groupes et modules </button></a>";

if(!empty($action)){
echo "<a href='?page=Moderateurs-modules'><button type='button' class='btn btn-success' style='margin-right: 5px;' ><span class='uk-icon-file-text'></span> Liste des modules</button></a>";
}
echo "<div style='clear: both;'></div><br />";
////////////////////Bouton administration
?>

<div style='padding: 5px;' align="center">

<?php
////////////////////////////SI APS D'ACTION 
if(empty($_GET['action'])){
?>

<!-- RAPPORT -->
<div id='Module-Moderateur-rapport'></div>

<!-- LISTE -->
<div id='liste-Module-Moderateur'></div>

<?php
}
////////////////////////////SI APS D'ACTION 
?>

</div>

<?php
}else{
header("location: index.html");
}

?>