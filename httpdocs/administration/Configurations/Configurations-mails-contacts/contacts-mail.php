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

$action = $_GET['action'];
$idaction = $_GET['idaction'];

?>

<script>
$(document).ready(function (){

//AJAX SOUMISSION DU FORMULAIRE - MODIFIER - AJOUTER
$(document).on("click", "#bouton_admin_contacts", function (){
$.post({
url : '/administration/Configurations/Configurations-mails-contacts/contacts-mail-ajouter-modifier.php',
type : 'POST',
<?php if ($_GET['action'] == "Modifier"){ ?>
data: new FormData($("#formulaire_admin_contacts_modifier")[0]),
<?php }else{ ?>
data: new FormData($("#formulaire_admin_contacts_ajouter")[0]),
<?php } ?>
processData: false,
contentType: false,
dataType: "json",
success: function (res) {
if(res.retour_validation == "ok"){
popup_alert(res.Texte_rapport,"green filledlight","#009900","uk-icon-check");
<?php if ($_GET['action'] != "Modifier"){ ?>
$("#formulaire_admin_contacts_ajouter")[0].reset();
<?php } ?>
}else{
popup_alert(res.Texte_rapport,"#CC0000 filledlight","#CC0000","uk-icon-times");
}
}
});
listeContact();
});

//AJAX - SUPPRIMER
$(document).on("click", ".supprimer_admin_contacts", function (){
$.post({
url : '/administration/Configurations/Configurations-mails-contacts/contacts-mail-supprimer.php',
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
listeContact();
});

//FUNCTION AJAX - LISTE
function listeContact(){
$.post({
url : '/administration/Configurations/Configurations-mails-contacts/contacts-mail-liste.php',
type : 'POST',
dataType: "html",
success: function (res) {
$("#liste-des-contacts").html(res);
}
});
}

listeContact();

$(document).on('click', '#btnSupprModal', function(){
  $.post({
    url: '/administration/Configurations/Configurations-mails-contacts/modal-supprimer-ajax.php',
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
    url: '/administration/Configurations/Configurations-mails-contacts/contacts-mail-supprimer.php',
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
      listeContact();
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
  <?php if(empty($_GET['action'])){ ?> <li class="active">Gestion des contacts</li><?php }else{ ?> <li><a href="?page=Contacts-mail">Gestion des contacts</a></li> <?php } ?>
  <?php if($_GET['action'] == "Modifier" ){ ?> <li class="active">Modifications</li> <?php } ?>
  <?php if($_GET['action'] == "Ajouter" ){ ?> <li class="active">Ajouter</li> <?php } ?>
  <?php if($_GET['action'] == "Graphique" ){ ?> <li class="active">Graphique</li> <?php } ?>
</ol>

<?php

echo "<div id='bloctitre' style='text-align: left;' ><h1>Gestion des contacts</h1></div><br />
<div style='clear: both;'></div>";

////////////////////Boutton administration
echo "<a href='".$mode_back_lien_interne."'><button type='button' class='btn btn-default' style='margin-right: 5px;' ><span class='uk-icon-cogs'></span> Administration</button></a>";
echo "<a href='?page=Pages&action=modification&idaction=2'><button type='button' class='btn btn-primary' style='margin-right: 5px;' ><span class='uk-icon-cog'></span> Gestion de la page</button></a>";
echo "<a href='/Contact' target='_top'><button type='button' class='btn btn-primary' style='margin-right: 5px;' ><span class='uk-icon-search'></span> Consulter la page</button></a>";
if(!empty($_GET['action'])){
echo "<a href='?page=Contacts-mail'><button type='button' class='btn btn-success' style='margin-right: 5px;' ><span class='uk-icon-plus-circle'></span> Ajouter un contact</button></a>";
}
echo "<div style='clear: both;'></div><br />"; 
////////////////////Boutton administration
?>

<div style='width: 100%; padding: 5px; text-align: center;'>

<?php

//////////Si action modifier
if($action == "Modifier"){

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM contact WHERE id=?");
$req_select->execute(array($idaction));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$idgcontactm = $ligne_select['id'];	
$postservice = $ligne_select['service'];
$mailonemailm = $ligne_select['mail'];
$activeronemailm = $ligne_select['activer'];
$mailmsujet = $ligne_select['sujet'];
$position = $ligne_select['position'];
?>

<form id='formulaire_admin_contacts_modifier' method='post' action='?page=Contacts-mail&amp;action=Modifier-action&amp;idaction=<?php echo "$idaction"; ?>'>
<h2 style='text-align: left;'>Modification du service <?php echo "$postmailservice"; ?></h2>
<input type="hidden" name="idaction" value="<?php echo "$idaction"; ?>" >
<input type="hidden" name="action" value="<?php echo "Modifier"; ?>" >

<?php
}else{
?>

<form id='formulaire_admin_contacts_ajouter' method='post' action='?page=Contacts-mail&amp;action=Ajouter'>
<input type="hidden" name="action" value="<?php echo "Ajouter"; ?>" >

<div style='text-align: left;' >
<h2>Ajouter contact mail</h2>
</div><br />
<div style='clear: both;'></div>

<?php
}
//////////Si action modifier
?>

<table style="text-align: left; width: 100%;" cellpadding="2" cellspacing="2"><tbody>

<tr><td style="text-align: left; width: 150px;">Nom du contact</td>
<td style="text-align: left;"><input type='text' name='postservice' class='form-control' value='<?php echo "$postservice"; ?>' style='width: 100%;' /></td></tr>
<tr><td colspan="2" rowspan="1"></td></tr>

<tr><td style="text-align: left; width: 150px;">Mail du contact</td>
<td style="text-align: left;"><input type='text' name='postmailservice' class='form-control' value='<?php echo "$mailonemailm"; ?>' style='width: 100%;' /></td></tr>
<tr><td colspan="2" rowspan="1"></td></tr>

<tr><td style="text-align: left; width: 150px;">Position</td>
<td style="text-align: left;"><input type='text' name='position' class='form-control' value='<?php echo "$position"; ?>' style='width: 40px;' /></td></tr>
<tr><td colspan="2" rowspan="1"></td></tr>

<tr><td style="text-align: left;">Activé </td>
<td style="text-align: left;">
<?php
if($_GET['action'] == "Modifier"){
if($activeronemailm == "oui"){
$selectedpost = "selected='selected'";
}elseif($activeronemailm == "non"){
$selectedpostd = "selected='selected'";
}
}
?>
<select name='statutpostmail' class='form-control' style='width: 150px; display: inline-block;'>
<option value='oui' <?php echo "$selectedpost"; ?> >Oui</option>
<option value='non' <?php echo "$selectedpostd"; ?> >Non</option>
</select>
</td></tr>
<tr><td colspan="2" rowspan="1">&nbsp;</td></tr>
<tr><td style="text-align: center;" colspan="2">
  <button id='bouton_admin_contacts' type='button' class='btn btn-success' onclick="return false;" style=' width: 150px;' >ENREGISTRER</button>
</tr></td>

<tr><td colspan="2" rowspan="1">&nbsp;</td></tr>
<!-- <tr><td colspan="2" rowspan="1" style="text-align: right;"></td></tr> -->

</tbody></table>

</form>
</div><br />

<!-- LISTE DES CONTACTS -->
<div id='liste-des-contacts'></div>

<?php

///////////////////////////////////////////////////////////////////////////////////////////////////////////////Service - Contact e-mail

}else{
header('location: /index.html');
}
?>