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
//Variables
//Pour adapté se module il faut juste changer le nom de $_SESSION['idsessionp404'] et $_SESSION['page_recherche404'] et $_SESSION['lasturrl404'] et $_SESSION['recherche_page_one404']

?>

<script>
$(document).ready(function (){

//AJAX SOUMISSION DU FORMULAIRE - MODIFIER - AJOUTER
$(document).on("click", "#bouton-gestion-des-pages", function (){
//ON SOUMET LE TEXTAREA TINYMCE
tinyMCE.triggerSave();
$.post({
url : '/administration/Pages/Pages-404/pages-404-action-ajouter-modifier-ajax.php',
type : 'POST',
<?php if ($_GET['action'] == "modification"){ ?>
data: new FormData($("#formulaire_modifier")[0]),
<?php }else{ ?>
data: new FormData($("#formulaire_ajout")[0]),
<?php } ?>
processData: false,
contentType: false,
dataType: "json",
success: function (res) {
console.log(res.retour_validation);
if(res.retour_validation == "ok"){
popup_alert(res.Texte_rapport,"green filledlight","#009900","uk-icon-check");
<?php if ($_GET['action'] != "modification"){ ?>
$("#formulaire_ajout")[0].reset();
<?php } ?>
}else{
popup_alert(res.Texte_rapport,"#CC0000 filledlight","#CC0000","uk-icon-times");
}
}
});
liste();
});

//AJAX - SUPPRIMER
// $(document).on("click", ".lien-supprimer", function (){
// $.post({
// url : '/administration/Pages/Pages-404/pages-404-action-supprimer-ajax.php',
// type : 'POST',
// data: {idaction:$(this).attr("data-id")},
// dataType: "json",
// success: function (res) {
// if(res.retour_validation == "ok"){
// popup_alert(res.Texte_rapport,"green filledlight","#009900","uk-icon-check");
// }else{
// popup_alert(res.Texte_rapport,"#CC0000 filledlight","#CC0000","uk-icon-times");
// }
// }
// });
// liste();
// });
//FUNCTION AJAX - LISTE 
function liste(){
$.post({
url : '/administration/Pages/Pages-404/pages-404-liste-ajax.php',
type : 'POST',
data:{},
dataType: "html",
success: function (res) {
$("#liste").html(res);
}
});
}

liste();

////////////////////////////////////////////////////////////////////MODAL CONFIRMATION SUPPRESSION
$(document).on('click', '#btnSupprModal', function(){
        $.post({
          url: '/administration/Pages/Pages-404/modal-supprimer-ajax.php',
          type: 'POST',
          data: {
            idaction: $(this).attr("data-id")
          },
          dataType: "html",
          success: function(res) {
            $("body").append(res)
            $("#modalSuppr").modal('show')
          }
        })
      });

      $(document).on("click", "#btnSuppr", function() {
        // $(".modal").show();
        $.post({
          url: '/administration/Pages/Pages-404/pages-404-action-supprimer-ajax.php',
          type: 'POST',
          data: {
            idaction: $(this).attr("data-id")
          },
          dataType: "json",
          success: function(res) {
            if (res.retour_validation == "ok") {
              popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
            } else {
              popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
            }
            liste();
            $("#modalSuppr").modal('hide')
            // $("#modalSuppr").hide(1000);
            // $(this).hide(1000);
          }
        });
      });
      
      $(document).on("click", "#btnNon", function() {
        $("#modalSuppr").modal('hide')
      });

      $(document).on('hidden.bs.modal', "#modalSuppr", function(){
        $(this).remove()
      })
    });
</script>

<ol class="breadcrumb">
  <li><a href="<?php echo $http; ?><?php echo $nomsiteweb; ?>">Accueil</a></li>
  <li><a href="<?php echo $mode_back_lien_interne; ?>">Administration</a></li>
  <?php if(empty($_GET['action'])){ ?> <li class="active">Gestion des erreurs 404/410</li> <?php }else{ ?> <li><a href="?page=Pages-404">Gestion des erreurs 404/410</a></li> <?php } ?>
  <?php if($_GET['action'] == "modification" ){ ?> <li class="active">Modifications</li> <?php } ?>
  <?php if($_GET['action'] == "add" ){ ?> <li class="active">Ajouter</li> <?php } ?>
</ol>

<?php

echo "<div id='bloctitre' style='text-align: left;' ><h1>Gestion des erreurs 404/410 </h1></div><br /><br />
<div style='clear: both;'></div>";

////////////////////Boutton administration
echo "<a href='".$mode_back_lien_interne."' ><button type='button' class='btn btn-default' style='margin-right: 5px;' ><span class='uk-icon-cogs'></span> Administration</button></a>";
echo "<a href='?page=Pages' ><button type='button' class='btn btn-primary' style='margin-right: 5px;' ><span class='uk-icon-file-powerpoint-o'></span> Gestion pages</button></a>";
echo "<a href='?page=Pages-301'><button type='button' class='btn btn-primary' style='margin-right: 5px;' ><span class='uk-icon-file-code-o'></span> Redirections 301</button></a>";
echo "<a href='?page=Pages-404&amp;action=Ajouter'><button type='button' class='btn btn-success' style='margin-right: 5px;' ><span class='uk-icon-plus-circle'></span> Ajouter une page</button></a>";
if(!empty($_GET['action'])){
echo "<a href='?page=Pages-404'><button type='button' class='btn btn-success' style='margin-right: 5px;' ><span class='uk-icon-trash-o'></span> Liste</button></a>";
}
echo "<div style='clear: both;'></div><br />";
////////////////////Boutton administration
?>

<div style='padding: 5px;' align="center">

<?php

$action = $_GET['action'];
$idaction = $_GET['idaction'];
$now = time();

if(isset($_POST['recherchepage'])){
$recherchepage = $_POST['recherchepage'];
$_SESSION['page_recherche404'] = "$recherchepage";
}

/////////////////////////////////////////Modification et Ajouter
if($action == "modification" || $action == "Ajouter"){

if($action == "modification"){

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM pages_404 WHERE id=?");
$req_select->execute(array($idaction));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$idoneinfos = $ligne_select['id'];
$ancienne_pagee301 = $ligne_select['ancienne_page'];
$nouvelle_pagee301 = $ligne_select['nouvelle_page'];
$categorie_produite301 = $ligne_select['categorie_produit'];
$produite301 = $ligne_select['produit'];
$photose301 = $ligne_select['photos'];
$videose301 = $ligne_select['videos'];
$newse301 = $ligne_select['news'];
$parenariate301 = $ligne_select['parenariat'];
$divers301 = $ligne_select['plus'];

echo '<div style="max-width: 700px; text-align: left;">
<form id="formulaire_modifier" method="post" action="#">';
?>

<input id="action" type="hidden" name="action" value="Modifier-action" >
<input id="idaction" type="hidden" name="idaction" value="<?php echo "$idaction"; ?>" >

<div style='text-align: left;' >
<h2>Modification redirection 404/410 / page N°<?php echo "$idaction"; ?> </h2>
</div><br />
<div style='clear: both;'></div>

<?php

if($categorie_produite301 == "oui"){
$selectedoness1 = "selected='selected'";
}elseif($produite301 == "oui"){
$selectedoness2 = "selected='selected'";
}elseif($photose301 == "oui"){
$selectedoness3 = "selected='selected'";
}elseif($videose301 == "oui"){
$selectedoness4 = "selected='selected'";
}elseif($newse301 == "oui"){
$selectedoness5 = "selected='selected'";
}elseif($parenariate301 == "oui"){
$selectedoness6 = "selected='selected'";
}elseif($divers301 == "oui"){
$selectedoness7 = "selected='selected'";
}

$_SESSION['idsessionp404'] = "$idaction";
}else{
echo '<div style="max-width: 700px; text-align: left; margin:auto;">
<form id="formulaire_ajout" method="post" action="#">';
?>

<input id="action" type="hidden" name="action" value="Ajouter-action" >

<div style='text-align: left;' >
<h2>Déclarer une redirection 404/410</h2>
</div><br />
<div style='clear: both;'></div>

<?php

}
?>

<table style="text-align: left; width: 100%;" border="0" cellpadding="2" cellspacing="2" align="center"><tbody>

<tr><td style="text-align: left; width: 100px;">Classification</td>
<td style="text-align: left;"></td>
<td style="text-align: left;">
<select name='categorieone' class='form-control' >
<option value='7' <?php echo "$selectedoness7"; ?> >Divers</option>
</select></td></tr>

<tr><td><br /></td></tr>

<tr><td style="text-align: left; width: 100px;">Ancienne page</td>
<td style="text-align: left;"></td>
<td style="text-align: left;"><input type='text' name='postancienne' class='form-control' value='<?php echo "$ancienne_pagee301"; ?>' style='width: 100%;'/></td></tr>
<tr><td >&nbsp;</td></tr>

<tr><td colspan="3" style="text-align: center;">
<input  type='submit' id='bouton-gestion-des-pages' class='btn btn-success' style='width: 150px;' onclick='return false;' value='ENREGISTRER' >
</td></tr>

</tbody></table>
</form></div><br /><br />

<?php
}
/////////////////////////////////////////Modification et Ajouter

/////////////////////////////////////////Si aucune action
if(empty($action)){
?>

<!-- LISTE -->
<div id='liste'></div>

<?php
}
/////////////////////////////////////////Si aucune action

echo "</div>";

}else{
header('location: /index.html');
}
?>