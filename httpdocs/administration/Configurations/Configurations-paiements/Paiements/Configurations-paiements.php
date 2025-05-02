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

if(isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 1){

?>

<script>
$(document).ready(function (){

//AJAX SOUMISSION DU FORMULAIRE - MODIFIER - AJOUTER
$(document).on("change", "#images, #images2", function (){
//ON SOUMET LE TEXTAREA TINYMCE
tinyMCE.triggerSave();
$.post({
url : '/administration/Configurations/Configurations-paiements/Paiements/Configurations-paiements-action-paypal-ajax.php',
type : 'POST',
data: new FormData($("#formulaire-configuration-paypal")[0]),
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
});

//AJAX SOUMISSION DU FORMULAIRE - MODIFIER - AJOUTER
$(document).on("click", ".bouton-formulaire-paypal", function (){
//ON SOUMET LE TEXTAREA TINYMCE
tinyMCE.triggerSave();
$.post({
url : '/administration/Configurations/Configurations-paiements/Paiements/Configurations-paiements-action-paypal-ajax.php',
type : 'POST',
data: new FormData($("#formulaire-configuration-paypal")[0]),
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
});

//AJAX SOUMISSION DU FORMULAIRE - MODIFIER - AJOUTER
$(document).on("click","#bouton-formulaire-panier", function (){
//ON SOUMET LE TEXTAREA TINYMCE
tinyMCE.triggerSave();
$.post({
url : '/administration/Configurations/Configurations-paiements/Paiements/Configurations-paiements-action-ajax.php',
type : 'POST',
data: new FormData($("#formulaire-configuration-panier")[0]),
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
});

});

</script>

<ol class="breadcrumb">
  <li><a href="<?php echo $http; ?><?php echo $nomsiteweb; ?>">Accueil</a></li>
  <li><a href="<?php echo $mode_back_lien_interne; ?>">Administration</a></li>
  <?php if(empty($_GET['action'])){ ?> <li class="active">Gestion des paiements</li> <?php }else{ ?> <li><a href="?page=Configurations-paiements">Gestion des paiements</a></li> <?php } ?>
  <?php if($_GET['action'] == "Modifier" ){ ?> <li class="active">Modifications</li> <?php } ?>
  <?php if($_GET['action'] == "Ajouter" ){ ?> <li class="active">Ajouter</li> <?php } ?>
  <?php if($_GET['action'] == "Configurations" ){ ?> <li class="active">Configurations</li> <?php } ?>
</ol>

<?php

echo "<div id='bloctitre' style='text-align: left;' ><h1>Gestion des paiements</h1></div><br /><br />
<div style='clear: both;'></div>";

////////////////////Boutton administration
echo "<a href='".$mode_back_lien_interne."'><button type='button' class='btn btn-default' style='margin-right: 5px;' ><span class='uk-icon-cogs'></span> Administration</button></a>";
echo "<a href='?page=Configurations-paiements&amp;action=Configurations'><button type='button' class='btn btn-primary' style='margin-right: 5px;' ><span class='uk-icon-cog'></span> Configurations page panier</button></a>";
echo "<a href='?page=Liste-paniers'><button type='button' class='btn btn-primary' style='margin-right: 5px;' ><span class='uk-icon-shopping-cart'></span> Liste des paniers</button></a>";
echo "<a href='/Paiement'><button type='button' class='btn btn-primary' style='margin-right: 5px;' ><span class='uk-icon-euro'></span> Accéder à la page des paiements</button></a>";
if(isset($_GET['action'])){
echo "<a href='?page=Configurations-paiements'><button type='button' class='btn btn-success' style='margin-right: 5px;' ><span class='uk-icon-barcode'></span> Liste des paiements</button></a>";
}
echo "<div style='clear: both;'></div><br />";
////////////////////Boutton administration

?>

<div style='padding: 5px;'>

<?php

$now = time();

$action = $_GET['action'];
$idaction = $_GET['idaction'];

//////////////////////////////////////////////////////////////////////////////////CONFIGURATIONS PAIEMENTS
if($action == "Configurations"){

?>

<form id='formulaire-configuration-panier' method='post' action='?page=Configurations-paiements&amp;action=Configurations_action&amp;idaction=1' enctype="multipart/form-data">

<div style='padding: 5px; max-width: 700px; margin-left: auto; margin-right: auto; text-align: center;' >

<table style='text-align: center; width: 100%;' cellpadding='0' cellspacing='10'><tbody>

<tr><td colspan='2' style='text-align: left;'><h2>Configurations de la page panier</h2></td></tr>
<tr><td colspan='2'>&nbsp; </td></tr>

</table>

<table style="width:100%; margin-bottom: 20px;">

<tr><td style="text-align: left; width: 200px;  vertical-align: top;">Titre de la page</td>
<td style='text-align: left;'>
<input type="text" id="titre_page_paiement" name="titre_page_paiement" value="<?php echo "$titre_page_paiement"; ?>" class='form-control' >
</td></tr>

</table>

 					 <div class="panel panel-default">
 						  <a class="panel-default" role="button" data-toggle="collapse"  href="#collapseBandeau_panier" aria-expanded="true" aria-controls="collapseBandeau_panier" style='outline:none;'>
    							<div class="panel-heading" role="tab" id="headingTwo">
     								 <h4 class="panel-title" style="text-align: left; text-transform: uppercase;">
									<span class='uk-icon-angle-down' style='float: right; font-size: 18px;'></span> Bandeau panier (Bloc droit)
     								 </h4>
   							 </div>
  						 </a>


   					 <div id="collapseBandeau_panier" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="collapseBandeau_panier">
     					 	<div class="panel-body">
<table style="width:100%;">

<tr><td colspan='2' style='text-align: left;'>Le bandeau panier se trouve au-dessus du récapitulatif associé au panier.</td></tr>
<tr><td colspan='2'>&nbsp; </td></tr>

<tr><td style="text-align: left; width: 200px;">Activer bandeau panier</td>
<td style='text-align: left;'>
<select id='activer_bandeau_page_panier' name='activer_bandeau_page_panier' class='form-control' >
<option value='non' <?php if($activer_bandeau_page_panier == "non"){ echo "selected"; } ?> > Non </option>
<option value='oui' <?php if($activer_bandeau_page_panier == "oui"){ echo "selected"; } ?> > Oui </option>
</select>
</td></tr>
<tr><td>&nbsp;</td></tr>

<tr><td style="text-align: left; width: 200px;  vertical-align: top;">Type bandeau</td>
<td style='text-align: left;'>
<div class="alert alert-success" role="alert">
<b><input type="radio" name="type_bandeau_page_panier" value="alert-success" <?php if($type_bandeau_page_panier == "alert-success"){ echo "checked"; } ?> > alert-success</b>
</div>
<div class="alert alert-info" role="alert">
<b><input type="radio" name="type_bandeau_page_panier" value="alert-info" <?php if($type_bandeau_page_panier == "alert-info"){ echo "checked"; } ?> > alert-info</b>
</div>
<div class="alert alert-warning" role="alert">
<b><input type="radio" name="type_bandeau_page_panier" value="alert-warning" <?php if($type_bandeau_page_panier == "alert-warning"){ echo "checked"; } ?> > alert-warning</b>
</div>
<div class="alert alert-danger" role="alert">
<b><input type="radio" name="type_bandeau_page_panier" value="alert-danger" <?php if($type_bandeau_page_panier == "alert-danger"){ echo "checked"; } ?> > alert-danger</b>
</div>
</td></tr>
<tr><td>&nbsp;</td></tr>

<tr><td style="text-align: left; width: 200px;">Type cible</td>
<td style='text-align: left;'>
<select id='type_cible_page_panier' name='type_cible_page_panier' class='form-control' >
<option value='Tout le monde' <?php if($type_cible_page_panier == "Tout le monde"){ echo "selected"; } ?> > Tout le monde </option>
<option value='Utilisateurs identifiés' <?php if($type_cible_page_panier == "Utilisateurs identifiés"){ echo "selected"; } ?> > Utilisateurs identifiés </option>
</select>
</td></tr>
<tr><td>&nbsp;</td></tr>

<tr><td style="text-align: left; width: 200px;">Type icône panier</td>
<td style='text-align: left;'>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-warning' name='type_icone_page_panier' <?php if($type_icone_page_panier == "uk-icon-warning"){ echo "checked"; } ?> > <span class='uk-icon-warning'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-bell' name='type_icone_page_panier' <?php if($type_icone_page_panier == "uk-icon-bell"){ echo "checked"; } ?> > <span class='uk-icon-bell'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-exclamation-circle' name='type_icone_page_panier' <?php if($type_icone_page_panier == "uk-icon-exclamation-circle"){ echo "checked"; } ?> > <span class='uk-icon-exclamation-circle'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-check-square-o' name='type_icone_page_panier' <?php if($type_icone_page_panier == "uk-icon-check-square-o"){ echo "checked"; } ?> > <span class='uk-icon-check-square-o'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-tags' name='type_icone_page_panier' <?php if($type_icone_page_panier == "uk-icon-tags"){ echo "checked"; } ?> > <span class='uk-icon-tags'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-thumbs-up' name='type_icone_page_panier' <?php if($type_icone_page_panier == "uk-icon-thumbs-up"){ echo "checked"; } ?> > <span class='uk-icon-thumbs-up'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-star' name='type_icone_page_panier' <?php if($type_icone_page_panier == "uk-icon-star"){ echo "checked"; } ?> > <span class='uk-icon-star'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-shopping-cart' name='type_icone_page_panier' <?php if($type_icone_page_panier == "uk-icon-shopping-cart"){ echo "checked"; } ?> > <span class='uk-icon-shopping-cart'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-sign-in' name='type_icone_page_panier' <?php if($type_icone_page_panier == "uk-icon-sign-in"){ echo "checked"; } ?> > <span class='uk-icon-sign-in'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-gift' name='type_icone_page_panier' <?php if($type_icone_page_panier == "uk-icon-gift"){ echo "checked"; } ?> > <span class='uk-icon-gift'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-envelope' name='type_icone_page_panier' <?php if($type_icone_page_panier == "uk-icon-envelope"){ echo "checked"; } ?> > <span class='uk-icon-envelope'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-volume-up' name='type_icone_page_panier' <?php if($type_icone_page_panier == "uk-icon-volume-up"){ echo "checked"; } ?> > <span class='uk-icon-volume-up'></span> </div>
</td></tr>
<tr><td>&nbsp;</td></tr>

<tr><td style="text-align: left;" colspan='2'>Contenu bandeau panier</td></tr>
<tr><td style='text-align: left;' colspan='2'><textarea class='form-control mceEditor' id='contenu_bandeau_page_panier' name='contenu_bandeau_page_panier' style='width: 100%; height: 80px;'><?php echo "$contenu_bandeau_page_panier"; ?></textarea></td></tr>
<tr><td>&nbsp;</td></tr>

</table><br />
  					  	  </div>
   					 </div>
  					</div>


 					 <div class="panel panel-default">
 						  <a class="panel-default" role="button" data-toggle="collapse"  href="#collapseBandeau_informations" aria-expanded="true" aria-controls="collapseBandeau_informations" style='outline:none;'>
    							<div class="panel-heading" role="tab" id="headingTwo">
     								 <h4 class="panel-title" style="text-align: left; text-transform: uppercase;">
									<span class='uk-icon-angle-down' style='float: right; font-size: 18px;'></span> Bandeau informations (Bloc gauche)
     								 </h4>
   							 </div>
  						 </a>


   					 <div id="collapseBandeau_informations" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapseBandeau_informations">
     					 	<div class="panel-body">
<table style="width:100%;">

<tr><td colspan='2' style='text-align: left;'>Le bandeau informations, il est situé au dessus du formulaire de mise à jour associé aux informations client.</td></tr>
<tr><td colspan='2'>&nbsp; </td></tr>

<tr><td style="text-align: left; width: 200px;">Activer bandeau informations</td>
<td style='text-align: left;'>
<select id='activer_bandeau_page_informations' name='activer_bandeau_page_informations' class='form-control' >
<option value='non' <?php if($activer_bandeau_page_informations == "non"){ echo "selected"; } ?> > Non </option>
<option value='oui' <?php if($activer_bandeau_page_informations == "oui"){ echo "selected"; } ?> > Oui </option>
</select>
</td></tr>
<tr><td>&nbsp;</td></tr>

<tr><td style="text-align: left; width: 200px;  vertical-align: top;">Type bandeau</td>
<td style='text-align: left;'>
<div class="alert alert-success" role="alert">
<b><input type="radio" name="type_bandeau_page_informations" value="alert-success" <?php if($type_bandeau_page_informations == "alert-success"){ echo "checked"; } ?> > alert-success</b>
</div>
<div class="alert alert-info" role="alert">
<b><input type="radio" name="type_bandeau_page_informations" value="alert-info" <?php if($type_bandeau_page_informations == "alert-info"){ echo "checked"; } ?> > alert-info</b>
</div>
<div class="alert alert-warning" role="alert">
<b><input type="radio" name="type_bandeau_page_informations" value="alert-warning" <?php if($type_bandeau_page_informations == "alert-warning"){ echo "checked"; } ?> > alert-warning</b>
</div>
<div class="alert alert-danger" role="alert">
<b><input type="radio" name="type_bandeau_page_informations" value="alert-danger" <?php if($type_bandeau_page_informations == "alert-danger"){ echo "checked"; } ?> > alert-danger</b>
</div>
</td></tr>
<tr><td>&nbsp;</td></tr>

<tr><td style="text-align: left; width: 200px;">Type cible</td>
<td style='text-align: left;'>
<select id='ype_cible_page_informations' name='ype_cible_page_informations' class='form-control' >
<option value='Tout le monde' <?php if($ype_cible_page_informations == "Tout le monde"){ echo "selected"; } ?> > Tout le monde </option>
<option value='Utilisateurs identifiés' <?php if($ype_cible_page_informations == "Utilisateurs identifiés"){ echo "selected"; } ?> > Utilisateurs identifiés </option>
</select>
</td></tr>
<tr><td>&nbsp;</td></tr>

<tr><td style="text-align: left; width: 200px;">Type icône informations</td>
<td style='text-align: left;'>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-warning' name='type_icone_page_informations' <?php if($type_icone_page_informations == "uk-icon-warning"){ echo "checked"; } ?> > <span class='uk-icon-warning'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-bell' name='type_icone_page_informations' <?php if($type_icone_page_informations == "uk-icon-bell"){ echo "checked"; } ?> > <span class='uk-icon-bell'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-exclamation-circle' name='type_icone_page_informations' <?php if($type_icone_page_informations == "uk-icon-exclamation-circle"){ echo "checked"; } ?> > <span class='uk-icon-exclamation-circle'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-check-square-o' name='type_icone_page_informations' <?php if($type_icone_page_informations == "uk-icon-check-square-o"){ echo "checked"; } ?> > <span class='uk-icon-check-square-o'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-tags' name='type_icone_page_informations' <?php if($type_icone_page_informations == "uk-icon-tags"){ echo "checked"; } ?> > <span class='uk-icon-tags'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-thumbs-up' name='type_icone_page_informations' <?php if($type_icone_page_informations == "uk-icon-thumbs-up"){ echo "checked"; } ?> > <span class='uk-icon-thumbs-up'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-star' name='type_icone_page_informations' <?php if($type_icone_page_informations == "uk-icon-star"){ echo "checked"; } ?> > <span class='uk-icon-star'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-shopping-cart' name='type_icone_page_informations' <?php if($type_icone_page_informations == "uk-icon-shopping-cart"){ echo "checked"; } ?> > <span class='uk-icon-shopping-cart'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-sign-in' name='type_icone_page_informations' <?php if($type_icone_page_informations == "uk-icon-sign-in"){ echo "checked"; } ?> > <span class='uk-icon-sign-in'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-gift' name='type_icone_page_informations' <?php if($type_icone_page_informations == "uk-icon-gift"){ echo "checked"; } ?> > <span class='uk-icon-gift'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-envelope' name='type_icone_page_informations' <?php if($type_icone_page_informations == "uk-icon-envelope"){ echo "checked"; } ?> > <span class='uk-icon-envelope'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-volume-up' name='type_icone_page_informations' <?php if($type_icone_page_informations == "uk-icon-volume-up"){ echo "checked"; } ?> > <span class='uk-icon-volume-up'></span> </div>
</td></tr>
<tr><td>&nbsp;</td></tr>

<tr><td style="text-align: left;" colspan='2'>Contenu bandeau informations</td></tr>
<tr><td style='text-align: left;' colspan='2'><textarea class='form-control mceEditor' id='contenu_bandeau_page_informations' name='contenu_bandeau_page_informations' style='width: 100%; height: 80px;'><?php echo "$contenu_bandeau_page_informations"; ?></textarea></td></tr>
<tr><td>&nbsp;</td></tr>

</table><br />
  					  	  </div>
   					 </div>
  					</div>


 					 <div class="panel panel-default">
 						  <a class="panel-default" role="button" data-toggle="collapse"  href="#collapseBandeau_login" aria-expanded="true" aria-controls="collapseBandeau_login" style='outline:none;'>
    							<div class="panel-heading" role="tab" id="headingTwo">
     								 <h4 class="panel-title" style="text-align: left; text-transform: uppercase;">
									<span class='uk-icon-angle-down' style='float: right; font-size: 18px;'></span> Bandeau login (Bloc gauche)
     								 </h4>
   							 </div>
  						 </a>


   					 <div id="collapseBandeau_login" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapseBandeau_login">
     					 	<div class="panel-body">
<table style="width:100%;">

<tr><td colspan='2' style='text-align: left;'>Le bandeau login, s'affiche uniquement si l'utilisateur n'est pas connecté à son compte.</td></tr>
<tr><td colspan='2'>&nbsp; </td></tr>

<tr><td style="text-align: left; width: 200px;">Activer bandeau login</td>
<td style='text-align: left;'>
<select id='activer_bandeau_page_panier' name='activer_bandeau_page_login' class='form-control' >
<option value='non' <?php if($activer_bandeau_page_login == "non"){ echo "selected"; } ?> > Non </option>
<option value='oui' <?php if($activer_bandeau_page_login == "oui"){ echo "selected"; } ?> > Oui </option>
</select>
</td></tr>
<tr><td>&nbsp;</td></tr>

<tr><td style="text-align: left; width: 200px;  vertical-align: top;">Type bandeau</td>
<td style='text-align: left;'>
<div class="alert alert-success" role="alert">
<b><input type="radio" name="type_bandeau_page_login" value="alert-success" <?php if($type_bandeau_page_login == "alert-success"){ echo "checked"; } ?> > alert-success</b>
</div>
<div class="alert alert-info" role="alert">
<b><input type="radio" name="type_bandeau_page_login" value="alert-info" <?php if($type_bandeau_page_login == "alert-info"){ echo "checked"; } ?> > alert-info</b>
</div>
<div class="alert alert-warning" role="alert">
<b><input type="radio" name="type_bandeau_page_login" value="alert-warning" <?php if($type_bandeau_page_login == "alert-warning"){ echo "checked"; } ?> > alert-warning</b>
</div>
<div class="alert alert-danger" role="alert">
<b><input type="radio" name="type_bandeau_page_login" value="alert-danger" <?php if($type_bandeau_page_login == "alert-danger"){ echo "checked"; } ?> > alert-danger</b>
</div>
</td></tr>
<tr><td>&nbsp;</td></tr>

<tr><td style="text-align: left; width: 200px;">Type icône login</td>
<td style='text-align: left;'>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-warning' name='type_icone_page_login' <?php if($type_icone_page_login == "uk-icon-warning"){ echo "checked"; } ?> > <span class='uk-icon-warning'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-bell' name='type_icone_page_login' <?php if($type_icone_page_login == "uk-icon-bell"){ echo "checked"; } ?> > <span class='uk-icon-bell'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-exclamation-circle' name='type_icone_page_login' <?php if($type_icone_page_login == "uk-icon-exclamation-circle"){ echo "checked"; } ?> > <span class='uk-icon-exclamation-circle'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-check-square-o' name='type_icone_page_login' <?php if($type_icone_page_login == "uk-icon-check-square-o"){ echo "checked"; } ?> > <span class='uk-icon-check-square-o'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-tags' name='type_icone_page_login' <?php if($type_icone_page_login == "uk-icon-tags"){ echo "checked"; } ?> > <span class='uk-icon-tags'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-thumbs-up' name='type_icone_page_login' <?php if($type_icone_page_login == "uk-icon-thumbs-up"){ echo "checked"; } ?> > <span class='uk-icon-thumbs-up'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-star' name='type_icone_page_login' <?php if($type_icone_page_login == "uk-icon-star"){ echo "checked"; } ?> > <span class='uk-icon-star'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-shopping-cart' name='type_icone_page_login' <?php if($type_icone_page_login == "uk-icon-shopping-cart"){ echo "checked"; } ?> > <span class='uk-icon-shopping-cart'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-sign-in' name='type_icone_page_login' <?php if($type_icone_page_login == "uk-icon-sign-in"){ echo "checked"; } ?> > <span class='uk-icon-sign-in'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-gift' name='type_icone_page_login' <?php if($type_icone_page_login == "uk-icon-gift"){ echo "checked"; } ?> > <span class='uk-icon-gift'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-envelope' name='type_icone_page_login' <?php if($type_icone_page_login == "uk-icon-envelope"){ echo "checked"; } ?> > <span class='uk-icon-envelope'></span> </div>
<div style='display: inline-block; margin-right: 10px;'><input type='radio' value='uk-icon-volume-up' name='type_icone_page_login' <?php if($type_icone_page_login == "uk-icon-volume-up"){ echo "checked"; } ?> > <span class='uk-icon-volume-up'></span> </div>
</td></tr>
<tr><td>&nbsp;</td></tr>

<tr><td style="text-align: left;" colspan='2'>Contenu bandeau login</td></tr>
<tr><td style='text-align: left;' colspan='2'><textarea class='form-control mceEditor' id='contenu_bandeau_page_login' name='contenu_bandeau_page_login' style='width: 100%; height: 80px;'><?php echo "$contenu_bandeau_page_login"; ?></textarea></td></tr>
<tr><td>&nbsp;</td></tr>

</table><br />
  					  	  </div>
   					 </div>
  					</div>


 					 <div class="panel panel-default">
 						  <a class="panel-default" role="button" data-toggle="collapse"  href="#collapseBandeau-avancement" aria-expanded="true" aria-controls="collapseBandeau-avancement" style='outline:none;'>
    							<div class="panel-heading" role="tab" id="headingTwo">
     								 <h4 class="panel-title" style="text-align: left; text-transform: uppercase;">
									<span class='uk-icon-angle-down' style='float: right; font-size: 18px;'></span> Bandeau avancement
     								 </h4>
   							 </div>
  						 </a>


   					 <div id="collapseBandeau-avancement" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapseBandeau-avancement">
     					 	<div class="panel-body">

<table style="width:100%;">

<tr><td style='text-align: left;'>Activer bandeau avancement</td>
<td style='text-align: left;'>
<select name='configurations_bandeau_avancement' class='form-control' style='width: 100%;' >
<option value='oui' <?php if($configurations_bandeau_avancement == "oui"){ echo "selected"; } ?> > Oui &nbsp; </option>
<option value='non' <?php if($configurations_bandeau_avancement == "non"){ echo "selected"; } ?> > Non &nbsp; </option>
</select>
</td></tr>
<tr><td colspan='2' rowspan='1'>&nbsp; </td></tr>

<?php
if(empty($numero_progress_bar_panier)){
$numero_progress_bar_panier = "90";
}
?>

<tr><td colspan='2' rowspan='1' style='text-align: left;' >
    <input type='radio' value='progress-bar-success' name='type_progress_bar' <?php if($type_progress_bar == "progress-bar-success"){ echo "checked"; } ?> > Style (Success)
<div class="progress">
  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo "$numero_progress_bar_panier"; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo "$numero_progress_bar_panier"; ?>%">
 <?php echo "$numero_progress_bar_panier"; ?>% Complété 
  </div>
</div>
    <input type='radio' value='progress-bar-info' name='type_progress_bar' <?php if($type_progress_bar == "progress-bar-info"){ echo "checked"; } ?> > Style (Infos)
<div class="progress">
  <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="<?php echo "$numero_progress_bar_panier"; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo "$numero_progress_bar_panier"; ?>%">
    <?php echo "$numero_progress_bar_panier"; ?>% Complété
  </div>
</div>
    <input type='radio' value='progress-bar-warning' name='type_progress_bar' <?php if($type_progress_bar == "progress-bar-warning"){ echo "checked"; } ?> > Style (Warning)
<div class="progress">
  <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?php echo "$numero_progress_bar_panier"; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo "$numero_progress_bar_panier"; ?>%">
    <?php echo "$numero_progress_bar_panier"; ?>% Complété
  </div>
</div>
    <input type='radio' value='progress-bar-danger' name='type_progress_bar' <?php if($type_progress_bar == "progress-bar-danger"){ echo "checked"; } ?> > Style (Danger)
<div class="progress">
  <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="<?php echo "$numero_progress_bar_panier"; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo "$numero_progress_bar_panier"; ?>%">
    <?php echo "$numero_progress_bar_panier"; ?>% Complété
  </div>
</div>
</td></tr>
<tr><td colspan='2' rowspan='1'>&nbsp; </td></tr>

<tr><td style='text-align: left;'>% d'avancement sur le panier</td>
<td style='text-align: left;'>
<select name='numero_progress_bar_panier' class='form-control' style='width: 100%;' >
<option value='10' <?php if($numero_progress_bar_panier == "10"){ echo "selected"; } ?> > 10% &nbsp; </option>
<option value='20' <?php if($numero_progress_bar_panier == "20"){ echo "selected"; } ?> > 20% &nbsp; </option>
<option value='30' <?php if($numero_progress_bar_panier == "30"){ echo "selected"; } ?> > 30% &nbsp; </option>
<option value='40' <?php if($numero_progress_bar_panier == "40"){ echo "selected"; } ?> > 40% &nbsp; </option>
<option value='50' <?php if($numero_progress_bar_panier == "50"){ echo "selected"; } ?> > 50% &nbsp; </option>
<option value='60' <?php if($numero_progress_bar_panier == "60"){ echo "selected"; } ?> > 60% &nbsp; </option>
<option value='70' <?php if($numero_progress_bar_panier == "70"){ echo "selected"; } ?> > 70% &nbsp; </option>
<option value='80' <?php if($numero_progress_bar_panier == "80"){ echo "selected"; } ?> > 80% &nbsp; </option>
<option value='90' <?php if($numero_progress_bar_panier == "90"){ echo "selected"; } ?> > 90% &nbsp; </option>
<option value='100' <?php if($numero_progress_bar_panier == "100"){ echo "selected"; } ?> > 100% &nbsp; </option>
</select>
</td></tr>
<tr><td colspan='2' rowspan='1'>&nbsp; </td></tr>

</td></tr>
<tr><td colspan='2' rowspan='1'>&nbsp; </td></tr>

</tbody></table>

  					  	  </div>
   					 </div>
  					</div>


 					 <div class="panel panel-default">
 						  <a class="panel-default" role="button" data-toggle="collapse"  href="#collapsechamps-professionnels" aria-expanded="true" aria-controls="collapsechamps-professionnels" style='outline:none;'>
    							<div class="panel-heading" role="tab" id="headingTwo">
     								 <h4 class="panel-title" style="text-align: left; text-transform: uppercase;">
									<span class='uk-icon-angle-down' style='float: right; font-size: 18px;'></span> Informations - champs professionnels
     								 </h4>
   							 </div>
  						 </a>


   					 <div id="collapsechamps-professionnels" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapsechamps-professionnels">
     					 	<div class="panel-body">

<table style="width:100%;">

<tr><td style='text-align: left;'>Activer champs professionnels</td>
<td style='text-align: left;'>
<select name='configurations_informations_champs_professionnels' class='form-control' style='width: 100%;' >
<option value='oui' <?php if($configurations_informations_champs_professionnels == "oui"){  echo "selected"; } ?> > Oui &nbsp; </option>
<option value='non' <?php if($configurations_informations_champs_professionnels == "non"){  echo "selected"; } ?> > Non &nbsp; </option>
</select>
</td></tr>
<tr><td colspan='2' rowspan='1'>&nbsp; </td></tr>

<tr><td style='text-align: left;'>Champs professionnels obligatoires</td>
<td style='text-align: left;'>
<select name='configurations_informations_champs_professionnels_obligatoire' class='form-control' style='width: 100%;' >
<option value='oui' <?php if($configurations_informations_champs_professionnels_obligatoire == "oui"){  echo "selected"; } ?> > Oui &nbsp; </option>
<option value='non' <?php if($configurations_informations_champs_professionnels_obligatoire == "non"){  echo "selected"; } ?> > Non &nbsp; </option>
</select>
</td></tr>

</tbody></table>

  					  	  </div>
   					 </div>
  					</div>

<button id='bouton-formulaire-panier' type='button' class='btn btn-success' onclick="return false;" style='width: 150px;'>ENREGISTRER</button>

</div>

</form>

<?php

}
//////////////////////////////////////////////////////////////////////////////////CONFIGURATIONS PAIEMENTS


//////////////////////////////////////////////////////////////////////////////////ON MODIFIE PAYPAL
if($action == "Modifier"){

	///////////////////////////////SELECT
	$req_select = $bdd->prepare("SELECT * FROM configuration_paypal WHERE id='1'");
	$req_select->execute(array($idaction));
	$ligne_select = $req_select->fetch();
	$req_select->closeCursor();
        $Adresse_paypal = $ligne_select['Adresse_paypal'];
        $identifiant_api_paypal = $ligne_select['identifiant_api_paypal'];
        $private_pwd_paypal = $ligne_select['private_pwd_paypal'];
        $signature_api_paypal = $ligne_select['signature_api_paypal'];
        $activer_paypal = $ligne_select['activer_paypal'];
        $logo_page_paiement = $ligne_select['logo_page_paiement'];
        $logo_page_panier = $ligne_select['logo_page_panier'];

	if($activer_paypal == "oui" ){
	$selected_paypal_oui = "selected";
	}else{
	$selected_paypal_non  = "selected";
	}

?>

<form id='formulaire-configuration-paypal' method='post' action='?page=Configurations-paiements&amp;action=Modifier_action&amp;idaction=1' enctype="multipart/form-data">

<div style='padding: 5px; max-width: 600px; margin-left: auto; margin-right: auto; text-align: center;' >

<table style='text-align: center; width: 100%;' cellpadding='0' cellspacing='10'><tbody>

<tr><td colspan='3' rowspan='1' style='text-align: left;'><h2>Informations paypal</h2></td></tr>
<tr><td colspan='3' rowspan='1'>&nbsp; </td></tr>

<tr><td style='text-align: left;'>Adresse mail du compte</td>
<td style='text-align: left;'><input type='text' name='mailpaypal' class='form-control' value="<?php echo "$Adresse_paypal"; ?>" style='width: 100%;' /></td></tr>
<tr><td colspan='3' rowspan='1'>&nbsp; </td></tr>

<tr><td style='text-align: left;'>Identifiant API Paypal </td>
<td style='text-align: left;'><input type='text' name='identifiant_api_paypal' class='form-control' value="<?php echo "$identifiant_api_paypal"; ?>" style='width: 100%;' /></td></tr>
<tr><td colspan='3' rowspan='1'>&nbsp; </td></tr>

<tr><td style='text-align: left;'>PRIVATE PASSWORD API Paypal </td>
<td style='text-align: left;'><input type='text' name='private_pwd_paypal' class='form-control' value="<?php echo "$private_pwd_paypal"; ?>" style='width: 100%;' /></td></tr>
<tr><td colspan='3' rowspan='1'>&nbsp; </td></tr>

<tr><td style='text-align: left;'>SIGNATURE API Paypal </td>
<td style='text-align: center;'><input type='text' name='signature_api_paypal' class='form-control' value="<?php echo "$signature_api_paypal"; ?>" style='width: 100%;'/></td></tr>
<tr><td colspan='3' rowspan='1'>&nbsp; </td></tr>

<tr><td style='text-align: left;'>Activer Paypal</td>
<td style='text-align: left;'>
<select name='activer_paypal' class='form-control' style='width: 100%;' >
<option value='oui' <?php echo "$selected_paypal_oui"; ?> > Oui &nbsp; </option>
<option value='non' <?php echo "$selected_paypal_non"; ?> > Non &nbsp; </option>
</select>
</td></tr>
<tr><td colspan='3' rowspan='1'>&nbsp; </td></tr>

<tr><td colspan='3' rowspan='1' style='text-align: left;'>Vous vous portez garant de l'exactitude des informations transmises!<br /><br /></td></tr>

</tbody></table><br /><br />


<table style='width: 100%;'>
<?php
if(!empty($logo_page_paiement)){
?>
<tr><td style='text-align: center;' colspan='2'>
<img src="/images/paypal/<?php echo "$logo_page_paiement"; ?>" alt="<?php echo "$logo_page_paiement"; ?>" style='cursor: pointer;' />
<br /><br /><input type='file' name='icon' id="images" style='display: inline-block;'  /><br /><br />
<div style='display: inline-block; font-weight: bold; cursor: pointer;'>Télécharger un logo pour la page de paiement</div>
</td></tr>
</tr>
<td style='text-align: center;' colspan='2'>Taille conseillée 230px de largeur / 100 de hauteur (.jpg)</td></tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>
<?php
}else{
?>
<tr><td style='text-align: center;' colspan='2'>
<img src="/images/pas-de-photo.png" alt="<?php echo "Logo"; ?>" width="150" style='cursor: pointer;' />
<br /><br /><input type='file' name='icon' id="images" style='display: inline-block;'  /><br /><br />
<a href='#' onclick="return false; ">Cliquez ici</a><br />
<div style='display: inline-block; font-weight: bold; cursor: pointer;' >Télécharger un logo pour la page de paiement</div>
</td></tr>
</tr>
<td style='text-align: center;' colspan='2'>Taille conseillée 230px de largeur / 100 de hauteur (.jpg)</td></tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>
<?php
}
?>
</table>
<br />
<br />

<table style='width: 100%;'>
<?php
if(!empty($logo_page_panier)){
?>
<tr><td style='text-align: center;' colspan='2'>
<img src="/images/paypal/<?php echo "$logo_page_panier"; ?>" alt="<?php echo "$logo_page_panier"; ?>" onclick="clickinputfile('images2');" style='cursor: pointer;' />
<br /><br /><input type='file' name='icon2' id="images2" style='display: inline-block;'  /><br /><br />
<div style='display: inline-block; font-weight: bold; cursor: pointer;' ">Télécharger un logo pour la page de panier</div>
</td></tr>
</tr>
<td style='text-align: center;' colspan='2'>Taille minimum 300px de largeur (.jpg)</td></tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>
<?php
}else{
?>
<tr><td style='text-align: center;' colspan='2'>
<img src="/images/pas-de-photo.png" alt="<?php echo "Logo"; ?>" width="150" style='cursor: pointer;' />
<br /><br /><input type='file' name='icon2' id="images2" style='display: inline-block;'  /><br /><br />
<a href='#' onclick="return false; ">Cliquez ici</a><br />
<div style='display: inline-block; font-weight: bold; cursor: pointer;'>Télécharger un logo pour la page de panier</div>
</td></tr>
</tr>
<td style='text-align: center;' colspan='2'>Taille minimum 300px de largeur (.jpg)</td></tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>
<?php
}
?>
</table>
<br /><br />

<button type='button' class='btn btn-success bouton-formulaire-paypal' onclick="return false;" style='width: 150px;'>ENREGISTRER</button>

</div>

</form>

<br /><br />

<?php
}
//////////////////////////////////////////////////////////////////////////////////ON MODIFIE PAYPAL



//////////////////////////////////////////////////////////////////////////////////LISTING
if(empty($action)){

?>

<?php
$nom_fichier = "Configurations-paiements";
$nom_fichier_datatable = "Configurations-paiements-".date('d-m-Y', time())."-$nomsiteweb"; 
?>
<script>
$(document).ready(function(){
    $('#Tableau_a').DataTable(
{
dom: 'Bftipr',
          buttons: [
       {
         extend: 'print',
           text  : "Imprimer",
                exportOptions: {
                    columns: ':visible'
                }
          },
          {
           extend: 'pdf',
           filename : "<?php echo "$nom_fichier_datatable"; ?>",
           title : "<?php echo "$nom_fichier"; ?>",
                exportOptions: {
                    columns: ':visible'
                }
          },{
          extend: 'csv',
           filename : "<?php echo "$nom_fichier_datatable"; ?>",
                exportOptions: {
                    columns: ':visible'
                }
          },{
          extend: 'colvis',
	text  : "Colonnes visibles",
          }
             ],
        columnDefs: [ {
            visible: false
       } ],
  "columnDefs": [
    { "orderable": false, "targets": 2, },
  ],
"language": {
	"sProcessing":     "Traitement en cours...",
	"sSearch":         "Rechercher&nbsp;:",
    "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
	"sInfo":           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
	"sInfoEmpty":      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
	"sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
	"sInfoPostFix":    "",
	"sLoadingRecords": "Chargement en cours...",
    "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
	"sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
	"oPaginate": {
		"sFirst":      "Premier",
		"sPrevious":   "Pr&eacute;c&eacute;dent",
		"sNext":       "Suivant",
		"sLast":       "Dernier"
	},
	"oAria": {
		"sSortAscending":  ": activer pour trier la colonne par ordre croissant",
		"sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
	}
}
}
);
});
</script>

<table id='Tableau_a' class="display" style="text-align: center; width: 100%; margin-top: 15px; " cellpadding="2" cellspacing="2">

<thead>
<tr>
<th style="text-align: center;">N°</th>
<th style="text-align: center;" >TITRE</th>
<th style="text-align: center; width: 90px;" >MODIFIER</th>
</tr>
</thead>
<tfoot>
<tr>
<th style="text-align: center;">N°</th>
<th style="text-align: center;">TITRE</th>
<th style="text-align: center; width: 90px;" >MODIFIER</th>
</tr>
</tfoot>
<tbody>

<tr><td style='text-align: center; '>1</td>
<td style='text-align: center;'>Paypal</td>
<td style='text-align: center;'><a href='?page=Configurations-paiements&amp;action=Modifier&amp;idaction=1'><span class='uk-icon-file-text' ></span></a></td></tr>

<tr><td style='text-align: center;'>3</td>
<td style='text-align: center;'>CB via votre banque</td>
<td style='text-align: center;'>N/A</td></tr>

</tbody></table><br /><br />

<div style='padding: 5px;'>

<table style='text-align: left; width: 100%;' cellpadding='0' cellspacing='5' align='center'><tbody>

<tr><td style=' text-align: justify; padding: 5px;'>Certains modules de paiement tels que paypal et les modes de paiments reliés à un serveur distant (comme votre banque par exemple)
nécessitent des paramétrages particuliers (interface de paiement sécurisée ou bien la liaison entre votre site web et l'organisme) !</td></tr>
</tbody></table></div><br /><br />

<?php

}
//////////////////////////////////////////////////////////////////////////////////LISTING


?>

</div>

<?php

}else{
header('location: /index.html');
}
?>