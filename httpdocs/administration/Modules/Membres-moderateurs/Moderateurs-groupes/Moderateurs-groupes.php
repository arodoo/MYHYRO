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
$(document).on("click", "#bouton-formulaire-Moderateurs-groupes", function (){
//ON SOUMET LE TEXTAREA TINYMCE
tinyMCE.triggerSave();
$.post({
url : '/administration/Modules/Membres-moderateurs/Moderateurs-groupes/Moderateurs-groupes-action-ajouter-modifier-ajax.php',
type : 'POST',
<?php if ($_GET['action'] == "Modifier"){ ?>
data: new FormData($("#formulaire-Moderateurs-groupes")[0]),
<?php }else{ ?>
data: new FormData($("#formulaire-Moderateurs-groupes")[0]),
<?php } ?>
processData: false,
contentType: false,
dataType: "json",
success: function (res) {
if(res.retour_validation == "ok"){
popup_alert(res.Texte_rapport,"green filledlight","#009900","uk-icon-check");
<?php if ($_GET['action'] != "Modifier"){ ?>
$("#formulaire-Moderateurs-groupes")[0].reset();
<?php } ?>
}else{
popup_alert(res.Texte_rapport,"#CC0000 filledlight","#CC0000","uk-icon-times");
}
}
});
listeModuleModerateur();
});

//AJAX - SUPPRIMER
$(document).on("click", ".supprimer-Moderateurs-groupes-liste", function (){
$.post({
url : '/administration/Modules/Membres-moderateurs/Moderateurs-groupes/Moderateurs-groupes-action-supprimer-ajax.php',
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
url : '/administration/Modules/Membres-moderateurs/Moderateurs-groupes/Moderateurs-groupes-liste-ajax.php',
type : 'POST',
dataType: "html",
success: function (res) {
$("#liste-Moderateurs-groupes").html(res);
}
});
}

listeModuleModerateur();

/////////////////////////////////////////////// RAPPORTS ///////////////////////////////////////////////
<?php
include('../administration/Modules/Membres-moderateurs/Moderateurs-modules/Moderateurs-modules-include-jquery-rapport.php');
?>

});

</script>

<ol class="breadcrumb">
  <li><a href="<?php echo $http; ?><?php echo $nomsiteweb; ?>">Accueil</a></li>
  <li><a href="<?php echo $mode_back_lien_interne; ?>">Administration</a></li>
  <?php if(empty($_GET['action'])){ ?> <li class="active">Gestion des groupes</li> <?php }else{ ?> <li><a href="?page=Moderateurs-groupes">Gestion des groupes</a></li> <?php } ?>
  <?php if($_GET['action'] == "Modifier" ){ ?> <li class="active">Modifications</li> <?php } ?>
  <?php if($_GET['action'] == "Ajouter" ){ ?> <li class="active">Ajouter</li> <?php } ?>
</ol>

<div id='bloctitre' style='text-align: left;' ><h1>Gestion des groupes</h1></div><br /><br />
<div style='clear: both;'></div>

<?php

$action = $_GET['action'];
$idaction = $_GET['idaction'];

////////////////////Boutton administration
echo "<a href='".$mode_back_lien_interne."'><button type='button' class='btn btn-default' style='margin-right: 5px;' ><span class='uk-icon-cogs'></span> Administration</button></a>";

echo "<a href='?page=Moderateurs'><button type='button' class='btn btn-primary' style='margin-right: 5px;' ><span class='uk-icon-users'></span> Gestion des modérateurs </button></a>";
echo "<a href='?page=Moderateurs-modules'><button type='button' class='btn btn-primary' style='margin-right: 5px;' ><span class='uk-icon-check-square'></span> Gestion des modules déclarés </button></a>";
echo "<a href='?page=Moderateurs-groupes'><button type='button' class='btn btn-info' style='margin-right: 5px;' ><span class='uk-icon-share-alt-square'></span> Gestion des groupes</button></a>";
echo "<a href='?page=Moderateurs-groupes-modules'><button type='button' class='btn btn-primary' style='margin-right: 5px;' ><span class='uk-icon-sign-out'></span> Associations groupes </button></a>";

if($action != "Ajouter" && $action != "Modifier"){
echo "<a href='?page=Moderateurs-groupes&amp;action=Ajouter'><button type='button' class='btn btn-success' style='margin-right: 5px;' ><span class='uk-icon-plus-circle'></span> Ajouter un groupe</button></a>";
}
if(!empty($action)){
echo "<a href='?page=Moderateurs-groupes'><button type='button' class='btn btn-success' style='margin-right: 5px;' ><span class='uk-icon-file-text'></span> Liste des groupes </button></a>";
}
echo "<div style='clear: both;'></div><br />";
////////////////////Boutton administration
?>

<div style='padding: 5px;' align="center">

<?php

////////////////////////////FORMULAIRE AJOUTER / MODIFIER
if($action == "Ajouter" || $action == "Modifier" ){

if($action == "Modifier" ){

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM configuration_membres_moderateurs_groupes WHERE id=?");
$req_select->execute(array($idaction));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$idoneinfos = $ligne_select['id'];
$nom_groupe_moderateur = $ligne_select['nom_groupe_moderateur'];
$activer_groupe_moderateur = $ligne_select['activer_groupe_moderateur'];

if($activer_groupe_moderateur == "oui"){
$selectedstatut1 = "selected='selected'";
}elseif($activer_groupe_moderateur == "non"){
$selectedstatut2 = "selected='selected'";
}

?>

<div align='left'>
<h2>Modifier le groupe</h2>
</div><br />
<div style='clear: both;'></div>

<form id="formulaire-Moderateurs-groupes" method="post" action="?page=Moderateurs-groupes&amp;action=Modifier-action&amp;idaction=<?php echo "$idaction"; ?>">
<input id="action" type="hidden" name="action" value="Modifier-action" >
<input id="idaction" type="hidden" name="idaction" value="<?php echo "$idaction"; ?>" >

<?php
}else{
?>

<div align='left'>
<h2>Ajouter un groupe</h2>
</div><br />
<div style='clear: both;'></div>

<form id="formulaire-Moderateurs-groupes" method="post" action="?page=Moderateurs-groupes&amp;action=Ajouter-action">
<input id="action" type="hidden" name="action" value="Ajouter-action" >

<?php
}
?>

<table style="text-align: left; width: 100%; text-align: center;" cellpadding="2" cellspacing="2"><tbody>

<tr><td style="text-align: left; width: 190px;">Nom du groupe</td>
<td style="text-align: left;">
<input type='text' name="nom_groupe_moderateur" class="form-control" value="<?php echo "$nom_groupe_moderateur"; ?>" style='width: 100%;' />
</td></tr>
<tr><td colspan="2" >&nbsp;</td></tr>

<tr><td style="text-align: left; width: 190px; margin-right: 5px;">Statut de la catégorie </td>
<td style="text-align: left;">
<select name='activer_groupe_moderateur' class='form-control' style='width: 150px; display: inline-block;'>
<option <?php echo "$selectedstatut1"; ?> value='oui'> Activée &nbsp; &nbsp;</option>
<option <?php echo "$selectedstatut2"; ?> value='non'> Désactivée &nbsp; &nbsp;</option>
</select>
<button id='bouton-formulaire-Moderateurs-groupes' type='button' class='btn btn-success' onclick="return false;" >ENREGISTRER</button>
</td></tr>
<tr><td colspan="2" >&nbsp;</td></tr>

</table>
</form>
<br /><br />

<?php
}
////////////////////////////FORMULAIRE AJOUTER / MODIFIER


////////////////////////////SI APS D'ACTION 
if(empty($_GET['action'])){
?>

<!-- RAPPORT -->
<div id='Module-Moderateur-rapport'></div>

<!-- LISTE -->
<div id='liste-Moderateurs-groupes'></div>

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