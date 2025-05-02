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
$(document).on("click", "#bouton-gestion-des-pages", function (){
//ON SOUMET LE TEXTAREA TINYMCE
tinyMCE.triggerSave();
$.post({
url : '/administration/Pages/Pages-bandeaux/pages-bandeaux-action-ajouter-modification-ajax.php',
type : 'POST',
<?php if ($_GET['action'] == "Modifier" ){ ?>
data: new FormData($("#formulaire-gestion-des-pages-modifier")[0]),
<?php }else{ ?>
data: new FormData($("#formulaire-gestion-des-pages-ajouter")[0]),
<?php } ?>
processData: false,
contentType: false,
dataType: "json",
success: function (res) {
if(res.retour_validation == "ok"){
popup_alert(res.Texte_rapport,"green filledlight","#009900","uk-icon-check");
<?php if ($_GET['action'] != "Modifier" ){ ?>
$("#formulaire-gestion-des-pages-ajouter")[0].reset();
<?php } ?>
}else{
popup_alert(res.Texte_rapport,"#CC0000 filledlight","#CC0000","uk-icon-times");
}
}
});
listeGestionPage();
});

//AJAX - SUPPRIMER
$(document).on("click", ".lien-supprimer-pages", function (){
$.post({
url : '/administration/Pages/Pages-bandeaux/pages-bandeaux-action-supprimer-ajax.php',
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
listeGestionPage();
});

//FUNCTION AJAX - LISTE
function listeGestionPage(){
$.post({
url : '/administration/Pages/Pages-bandeaux/pages-bandeaux-action-liste-ajax.php',
type : 'POST',
dataType: "html",
success: function (res) {
$("#liste-des-pages").html(res);
}
});
}

listeGestionPage();

});

</script>

<ol class="breadcrumb">
  <li><a href="<?php echo $http; ?><?php echo $nomsiteweb; ?>">Accueil</a></li>
  <li><a href="<?php echo $mode_back_lien_interne; ?>">Administration</a></li>
  <?php if(empty($_GET['action'])){ ?> <li class="active">Gestion des bandeaux</li> <?php }else{ ?> <li><a href="?page=Pages-bandeaux">Gestion des bandeaux</a></li> <?php } ?>
  <?php if($_GET['action'] == "Modifier" ){ ?> <li class="active">Modifications</li> <?php } ?>
  <?php if($_GET['action'] == "Ajouter" ){ ?> <li class="active">Ajouter</li> <?php } ?>
</ol>

<?php

echo "<div id='bloctitre' style='text-align: left;' ><h1>Gestion des bandeaux</h1></div><br /><br />
<div style='clear: both;'></div>";

////////////////////Boutton administration
echo "<a href='".$mode_back_lien_interne."'><button type='button' class='btn btn-default' style='margin-right: 5px;' ><span class='uk-icon-cogs'></span> Administration</button></a>";
////////////////////////////////////////////////////////////SI MODULE AJOUTER PAGE ACTIVE
if($page_ajouter_module == "oui"){
echo "<a href='?page=Pages-bandeaux&amp;action=Ajouter'><button type='button' class='btn btn-success' style='margin-right: 5px;' ><span class='uk-icon-plus-circle'></span> Ajouter un bandeau</button></a>";
}
////////////////////////////////////////////////////////////SI MODULE AJOUTER PAGE ACTIVE
if(!empty($_GET['action'])){
echo "<a href='?page=Pages-bandeaux'><button type='button' class='btn btn-success' style='margin-right: 5px;' ><span class='uk-icon-file-powerpoint-o'></span> Liste des bandeaux</button></a>";
}
echo "<div style='clear: both;'></div><br />";
////////////////////Boutton administration
?>

<div style='padding: 5px; text-align: center;'>

<?php

$action = $_GET['action'];
$idaction = $_GET['idaction'];

/////////////////////////////////////////Modification et Ajouter
if($action == "Modifier" || $action == "Ajouter"){

if($action == "Modifier"){

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM pages_bandeaux WHERE id=?");
$req_select->execute(array($idaction));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$id = $ligne_select['id'];
$page_bandeau = $$ligne_select['page_bandeau'];
$activer_bandeau_page = $$ligne_select['activer_bandeau_page'];
$type_bandeau_page = $$ligne_select['type_bandeau_page'];
$type_cible_page = $$ligne_select['type_cible_page'];
$type_icone_page = $$ligne_select['type_icone_page'];
$contenu_bandeau_page = $$ligne_select['contenu_bandeau_page'];

echo '<div style="width: 100%; text-align: center;">
<form id="formulaire-gestion-des-pages-modifier" method="post" action="?page=Pages-bandeaux&amp;action=Modifier-action&amp;idaction='.$idaction.'">';
echo "<div align='left'><h2>Modifier un bandeau</h2></div>
<div style='clear: both;'></div><br />";
echo '<input id="action" type="hidden" name="action" value="Modifier-action" >';
echo '<input id="idaction" type="hidden" name="idaction" value="'. $idaction.'" >';

}else{

echo '<div style="width: 100%; text-align: center;">
<form id="formulaire-gestion-des-pages-ajouter" method="post" action="?page=Pages-bandeaux&amp;action=Ajout-action">';
echo "<div align='left'><h2>Déclarer un bandeau</h2></div>
<div style='clear: both;'></div><br />";
echo '<input id="action" type="hidden" name="action" value="Ajouter-action" >';

}

?>

<div align='left'>
<h3>Configuration du bandeau</h3>
</div><br />
<div style='clear: both;'></div>

<hr />

<table style="text-align: left; width: 100%;" border="0" cellpadding="2" cellspacing="2" ><tbody>

<tr><td style="text-align: left; width: 200px;">Page</td>
<td style='text-align: left;'>
<input type='text' class='form-control'^id='page_bandeau' name='page_bandeau' value='<?php echo "$page_bandeau"; ?>' >
</td></tr>
<tr><td style="text-align: left; width: 200px;"></td>
<td style='text-align: left;'>
Vous devez indiquer une page sans le protocole et sans le nom de domaine. Ex : Contact
</td></tr>
<tr><td>&nbsp;</td></tr>

<tr><td style="text-align: left; width: 200px;">Activer bandeau</td>
<td style='text-align: left;'>
<select id='activer_bandeau_page' name='activer_bandeau_page' class='form-control' >
<option value='non' <?php if($activer_bandeau_page == "non"){ echo "selected"; } ?> > Non </option>
<option value='oui' <?php if($activer_bandeau_page == "oui"){ echo "selected"; } ?> > Oui </option>
</select>
</td></tr>
<tr><td>&nbsp;</td></tr>

<tr><td style="text-align: left; width: 200px;  vertical-align: top;">Type bandeau</td>
<td style='text-align: left;'>
<div class="alert alert-success" role="alert">
<b><input type="radio" name="type_bandeau_page" value="alert-success" <?php if($type_bandeau_page == "alert-success"){ echo "checked"; } ?> > alert-success</b>
</div>
<div class="alert alert-info" role="alert">
<b><input type="radio" name="type_bandeau_page" value="alert-info" <?php if($type_bandeau_page == "alert-info"){ echo "checked"; } ?> > alert-info</b>
</div>
<div class="alert alert-warning" role="alert">
<b><input type="radio" name="type_bandeau_page" value="alert-warning" <?php if($type_bandeau_page == "alert-warning"){ echo "checked"; } ?> > alert-warning</b>
</div>
<div class="alert alert-danger" role="alert">
<b><input type="radio" name="type_bandeau_page" value="alert-danger" <?php if($type_bandeau_page == "alert-danger"){ echo "checked"; } ?> > alert-danger</b>
</div>
</td></tr>
<tr><td>&nbsp;</td></tr>

<tr><td style="text-align: left; width: 200px;">Type cible</td>
<td style='text-align: left;'>
<select id='type_cible_page' name='type_cible_page' class='form-control' >
<option value='Tout le monde' <?php if($type_cible_page == "Tout le monde"){ echo "selected"; } ?> > Tout le monde </option>
<option value='Utilisateurs identifiés' <?php if($type_cible_page == "Utilisateurs identifiés"){ echo "selected"; } ?> > Utilisateurs identifiés </option>
<?php
///////////////////////////////SELECT BOUCLE
$req_boucle = $bdd->prepare("SELECT * FROM membres_type_de_compte WHERE activer='oui' ORDER BY position ASC");
$req_boucle->execute();
while($ligne_boucle = $req_boucle->fetch()){
$id_type = $ligne_boucle['id'];
$Nom_type_type = $ligne_boucle['Nom_type'];
if($id_type == $type_cible_page){
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
<tr><td>&nbsp;</td></tr>

<tr><td style="text-align: left; width: 200px;">Type icône</td>
<td style='text-align: left;'>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-warning' name='type_icone_page' <?php if($type_icone_page == "uk-icon-warning"){ echo "checked"; } ?> > <span class='uk-icon-warning'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-bell' name='type_icone_page' <?php if($type_icone_page == "uk-icon-bell"){ echo "checked"; } ?> > <span class='uk-icon-bell'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-exclamation-circle' name='type_icone_page' <?php if($type_icone_page == "uk-icon-exclamation-circle"){ echo "checked"; } ?> > <span class='uk-icon-exclamation-circle'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-check-square-o' name='type_icone_page' <?php if($type_icone_page == "uk-icon-check-square-o"){ echo "checked"; } ?> > <span class='uk-icon-check-square-o'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-tags' name='type_icone_page' <?php if($type_icone_page == "uk-icon-tags"){ echo "checked"; } ?> > <span class='uk-icon-tags'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-thumbs-up' name='type_icone_page' <?php if($type_icone_page == "uk-icon-thumbs-up"){ echo "checked"; } ?> > <span class='uk-icon-thumbs-up'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-star' name='type_icone_page' <?php if($type_icone_page == "uk-icon-star"){ echo "checked"; } ?> > <span class='uk-icon-star'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-shopping-cart' name='type_icone_page' <?php if($type_icone_page == "uk-icon-shopping-cart"){ echo "checked"; } ?> > <span class='uk-icon-shopping-cart'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-sign-in' name='type_icone_page' <?php if($type_icone_page == "uk-icon-sign-in"){ echo "checked"; } ?> > <span class='uk-icon-sign-in'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-gift' name='type_icone_page' <?php if($type_icone_page == "uk-icon-gift"){ echo "checked"; } ?> > <span class='uk-icon-gift'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-envelope' name='type_icone_page' <?php if($type_icone_page == "uk-icon-envelope"){ echo "checked"; } ?> > <span class='uk-icon-envelope'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-volume-up' name='type_icone_page' <?php if($type_icone_page == "uk-icon-volume-up"){ echo "checked"; } ?> > <span class='uk-icon-volume-up'></span> </div>
</td></tr>
<tr><td>&nbsp;</td></tr>

<tr><td style="text-align: left;" colspan='2'>Contenu bandeau</td></tr>
<tr><td style='text-align: left;' colspan='2'><textarea class='form-control mceEditor' id='contenu_bandeau_page' name='contenu_bandeau_page' style='width: 100%; height: 80px;'><?php echo "$contenu_bandeau_page"; ?></textarea></td></tr>
<tr><td>&nbsp;</td></tr>

<tr><td colspan="2" style="text-align: center;">
<button id='bouton-gestion-des-pages' type='button' class='btn btn-success' onclick="return false;" >ENREGISTRER</button>
</tbody></table>
</form>
</div><br /><br />

<?php
}
/////////////////////////////////////////Modification et Ajouter

/////////////////////////////////////////Si aucune action
if(empty($action)){
?>

<!-- LISTE DES PAGES -->
<div id='liste-des-pages'></div>

<?php
}
/////////////////////////////////////////Si aucune action

echo "</div>";

}else{
header('location: /index.html');
}
?>