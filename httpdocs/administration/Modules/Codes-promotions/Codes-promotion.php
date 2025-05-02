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

//AJAX SOUMISSION DU FORMULAIRE - MODIFIER - AJOUTER
$(document).on("click", "#bouton-formulaire-codes-promotions", function (){
//ON SOUMET LE TEXTAREA TINYMCE
tinyMCE.triggerSave();
$.post({
url : '/administration/Modules/Codes-promotions/Codes-promotion-action-ajouter-modifier-ajax.php',
type : 'POST',
<?php if ($_GET['action'] == "Modifier"){ ?>
data: new FormData($("#formulaire-codes-promotions-modifier")[0]),
<?php }else{ ?>
data: new FormData($("#formulaire-codes-promotions-ajouter")[0]),
<?php } ?>
processData: false,
contentType: false,
dataType: "json",
success: function (res) {
if(res.retour_validation == "ok"){
popup_alert(res.Texte_rapport,"green filledlight","#009900","uk-icon-check");
<?php if ($_GET['action'] != "Modifier"){ ?>
$("#formulaire-codes-promotions-ajouter")[0].reset();
<?php } ?>
}else{
popup_alert(res.Texte_rapport,"#CC0000 filledlight","#CC0000","uk-icon-times");
}
}
});
listeCodesPromotions();
});

//AJAX - FILTRE
$(document).on("click", "#bouton-codes-promotions-filtre", function (){
$.post({
url : '/administration/Modules/Codes-promotions/Codes-promotion-liste-filtre-ajax.php',
type : 'POST',
data: new FormData($("#formulaire-code-promotion-filtre")[0]),
dataType: "json",
processData: false,
contentType: false,
success: function (res) {
}
});
listeGestionPage();
});

//AJAX - SUPPRIMER
$(document).on("click", ".lien-supprimer-codes-promotions", function (){
$.post({
url : '/administration/Modules/Codes-promotions/Codes-promotion-action-supprimer-ajax.php',
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
listeCodesPromotions();
});

//FUNCTION AJAX - LISTE
function listeCodesPromotions(){
$.post({
url : '/administration/Modules/Codes-promotions/Codes-promotion-liste-ajax.php',
type : 'POST',
dataType: "html",
success: function (res) {
$("#liste-codes-promotions").html(res);
}
});
}

listeCodesPromotions();

$(document).on('click', '#btnSupprModal', function(){
        $.post({
          url: '/administration/Modules/Codes-promotions/modal-supprimer-ajax.php',
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
          url: '/administration/Modules/Codes-promotions/Codes-promotion-action-supprimer-ajax.php',
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
            listeCodesPromotions();
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

<?php

$action = $_GET['action'];
$idaction = $_GET['idaction'];

?>

<ol class="breadcrumb">
  <li><a href="<?php echo $http; ?><?php echo $nomsiteweb; ?>">Accueil</a></li>
  <li><a href="<?php echo $mode_back_lien_interne; ?>">Administration</a></li>
  <?php if(empty($_GET['action'])){ ?> <li class="active">Codes promotions</li> <?php }else{ ?> <li><a href="?page=Codes-promotion">Codes promotions</a></li> <?php } ?>
  <?php if($_GET['action'] == "Modifier" ){ ?> <li class="active">Modifications</li> <?php } ?>
  <?php if($_GET['action'] == "Ajouter" ){ ?> <li class="active">Ajouter</li> <?php } ?>
  <?php if($_GET['action'] == "Graphique" ){ ?> <li class="active">Graphique</li> <?php } ?>
</ol>

<?php

echo "<div id='bloctitre' style='text-align: left;' ><h1>Codes promotions</h1></div><br />
<div style='clear: both;'></div>";

////////////////////Boutton administration
echo "<a href='".$mode_back_lien_interne."'><button type='button' class='btn btn-default' style='margin-right: 5px;' ><span class='uk-icon-cogs'></span> Administration</button></a>";
echo "<a href='?page=Codes-promotion&amp;action=Ajouter'><button type='button' class='btn btn-success' style='margin-right: 5px;' ><span class='uk-icon-plus-circle'></span> Ajouter un code promotion</button></a>";
if(!empty($action)){
echo "<a href='?page=Codes-promotion'><button type='button' class='btn btn-success' style='margin-right: 5px;' ><span class='uk-icon-plus-circle'></span> Liste des codes promotions</button></a>";
}
echo "<div style='clear: both;'></div><br />";
////////////////////Boutton administration

?>

<div style='padding: 5px;'>

<?php

//////////////////////////////////////////////////////////////////////////////////////////GRAPHIQUE
if($action == "Graphique"){
?>
<div style='text-align: left;'>
<?php
///////////////////////////////////////////////////////////////////MODULE GRAPHIQUE
$titre_statistique = " - Chiffres d'affaires des codes promotions";
graphique(2,"membres_prestataire_facture","date_edition","jour_edition","mois_edition","annee_edition","Montant","Tarif_HT ","Factures","Factures","departement-active","departement","code-promotion-active","code_promotion","codes_promotion_groupes_documents","Nom_document","");
///////////////////////////////////////////////////////////////////MODULE GRAPHIQUE
?>
</div>
<?php
}
///////

////////////////////////////////////////////MODIFICATION / AJOUTE
if($action == "Modifier" || $action == "Ajouter" ){

if($action == "Modifier"){

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM codes_promotion WHERE id=?");
$req_select->execute(array($idaction));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$idd = $ligne_select['id']; 
$Titre_promo = $ligne_select['Titre_promo'];
$numero_code = $ligne_select['numero_code'];
$jours_offert = $ligne_select['jours_offert'];
$nbr_utilisation_fin = $ligne_select['nbr_utilisation_fin'];
$nbr_utilisation_en_cours = $ligne_select['nbr_utilisation_en_cours'];
$date_debut = $ligne_select['date_debut'];
$date_debut_2 = date('d-m-Y', $date_debut);
$date_fin = $ligne_select['date_fin'];
$date_fin_2 = date('d-m-Y', $date_fin);
$prix_offert = $ligne_select['prix_offert'];
$destination = $ligne_select['destination'];
$afficher_page_plus = $ligne_select['plus'];

if($afficher_page_plus == "oui"){
$selected1111 = "selected='selected'";
}else{
$selected2222 = "selected='selected'";
}

if($destination == "forfait"){
$selected3333 = "selected='selected'";
}elseif($destination == "positionnement"){
$selected4444 = "selected='selected'";
}elseif($destination == "classement"){
$selected5555 = "selected='selected'";
}

if($nbr_utilisation_en_cours == ""){
$nbr_utilisation_en_cours = "0";
}

$titreinfos = "Modifier le code promo N°$idaction";

?>
<form id='formulaire-codes-promotions-modifier' method='post' action='?page=Codes-promotion&amp;action=Modifier-action&amp;idaction=<?php echo "$idaction"; ?>' >
<input id="action" type="hidden" name="action" value="Modifier-action" >
<input id="idaction" type="hidden" name="idaction" value="<?php echo "$idaction"; ?>" >

<?php
}else{
$titreinfos = "Ajouter un code promo";
?>
<form id='formulaire-codes-promotions-ajouter' method='post' action='?page=Codes-promotion&amp;action=Ajouter-action&amp;idaction=<?php echo "$idaction"; ?>' >
<input id="action" type="hidden" name="action" value="Ajouter-action" >

<?php
}
?>

<div style='max-width: 500px; margin-left: auto; margin-right: auto;'>
<table style="text-align: left; width: 100%;" cellpadding="2" cellspacing="2"><tbody>

<tr><td style="text-align: left;" colspan='2'><h2><?php echo "$titreinfos"; ?></h2></td></tr>
<tr><td style="text-align: left;" colspan='2'>&nbsp;</td></tr>

<tr><td style="text-align: left;">Titre promo</td>
<td style="text-align: left;"><input type='text' name='titre_code_promo' class='form-control' value="<?php echo "$Titre_promo"; ?>" /></td></tr>
<tr><td style="text-align: left;" colspan='2'>&nbsp;</td></tr>

<tr><td style="text-align: left; vertical-align: top;">Numéro code promo</td>
<td style="text-align: left;">
<input type='text' id='nomduproduitrpost' name='code_promo_number' class='form-control' value="<?php echo "$numero_code"; ?>" />
</td></tr>
<tr><td style="text-align: left;" colspan='2'>&nbsp;</td></tr>

<tr><td style="text-align: left;">Remise en %</td>
<td style="text-align: left;"><input type='text' name='jours_offerts_post' class='form-control' value="<?php echo "$prix_offert"; ?>" style='width: 100px; display: inline-block;' / > %</td></tr>
<tr><td style="text-align: left;" colspan='2'>&nbsp;</td></tr>

<!--
<tr><td style="text-align: left;">Afficher sur la page</td>
<td style="text-align: left;">
<select name='afficher_page' class='form-control'>
<option <?php echo "$selected1111"; ?> value='oui'> Oui &nbsp; &nbsp; </option>
<option <?php echo "$selected2222"; ?> value='non'> Non&nbsp; &nbsp; </option>
</select>
</td></tr>
<tr><td style="text-align: left;" colspan='2'>&nbsp;</td></tr>
-->

<tr><td style="text-align: left;">Nbr utilisation limite</td>
<td style="text-align: left;"><input type='text' name='nbr_utilisation_LIMITE_post' class='form-control' value="<?php echo "$nbr_utilisation_fin"; ?>" style='width: 100px; display: inline-block;' /> ex => 20 </td></tr>
<tr><td style="text-align: left;" colspan='2'>&nbsp;</td></tr>

<tr><td style="text-align: left;">Nbr utilisation en cours</td>
<td style="text-align: left;"><input type='text' name='nbr_utilisation_ENCOURS_post' class='form-control' value="<?php echo "$nbr_utilisation_en_cours"; ?>" style='width: 100px; display: inline-block;' /> ex => 10 </td></tr>
<tr><td style="text-align: left;" colspan='2'>&nbsp;</td></tr>

<tr><td style="text-align: left;">Date début</td>
<td style="text-align: left;">
<?php
echo "<select name='jour1' class='form-control' style='display: inline-block; width: 100px;' >";
for ($ie = 1 ; $ie <= 31 ; $ie++){
echo "<option value='$ie'";
if ( date("j", $date_debut) == $ie){ echo " selected"; }
echo ">$ie &nbsp;&nbsp;</option>";
}

echo "</select>";
			
echo "<select name='mois1' class='form-control' style='display: inline-block; width: 150px;' >";
for ($iee = 1 ; $iee <= 12 ; $iee++){
echo "<option value='$iee'";
if ( date("n", $date_debut) == $iee){ echo " selected"; }
echo ">".$mois_annee[$iee]."&nbsp;&nbsp;</option>";
}

echo "</select>";
			
$cette_annee_la = date("Y");
echo "<select name='annee1' class='form-control' style='display: inline-block; width: 100px;'>";
for ($iaa = $cette_annee_la ; $iaa <= $cette_annee_la+10 ; $iaa++){
echo "<option value='$iaa'";
if ( date("Y", $date_debut) == $iaa){ echo " selected"; }
echo ">$iaa &nbsp;&nbsp;</option>";
}
echo "</select>";
?>
</td></tr>
<tr><td style="text-align: left;" colspan='2'>&nbsp;</td></tr>

<tr><td style="text-align: left;">Date fin</td>
<td style="text-align: left;">
<?php
echo "<select name='jour2' class='form-control' style='display: inline-block; width: 100px;'>";
for ($i = 1 ; $i <= 31 ; $i++){
echo "<option value='$i'";
if ( date("j", $date_fin) == $i){ echo " selected"; }
echo ">$i &nbsp;&nbsp;</option>";
}
echo "</select>";
			
echo "<select name='mois2' class='form-control' style='display: inline-block; width: 150px;' >";
for ($i = 1 ; $i <= 12 ; $i++){
echo "<option value='$i'";
if ( date("n", $date_fin) == $i){ echo " selected"; }
echo ">".$mois_annee[$i]."&nbsp;&nbsp;</option>";
}
echo "</select>";
			
$cette_annee_la = date("Y");
echo "<select name='annee2' class='form-control' style='display: inline-block; width: 100px;' >";
for ($i = $cette_annee_la ; $i <= $cette_annee_la+10 ; $i++){
echo "<option value='$i'";
if ( date("Y", $date_fin) == $i){ echo " selected"; }
echo ">$i&nbsp;&nbsp;</option>";
}
echo "</select>";
?>

</td></tr>
<tr><td style="text-align: left;" colspan='2'>&nbsp;</td></tr>
<tr><td style="text-align: left;" colspan='2'>&nbsp;</td></tr>

<tr><td style="text-align: center;" colspan='2'>
<button id='bouton-formulaire-codes-promotions' type='button' class='btn btn-success' onclick="return false;" style="width: 150px;">ENREGISTRER</button>
</td></tr>

</tbody></table>
</div>
</form>
<br /><br />

<?php
}
////////////////////////////////////////////MODIFICATION / AJOUT

////////////////////////////SI APS D'ACTION 
if(empty($_GET['action'])){
?>

<!-- LISTE DES CODES PROMOTIONS -->
<div id='liste-codes-promotions'></div>

<?php
}
////////////////////////////SI APS D'ACTION 

}else{
header('location: /index.html');
}
