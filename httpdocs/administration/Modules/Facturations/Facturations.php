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
isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 2 ){
?>

<script>
$(document).ready(function (){

//AJAX SOUMISSION DU FORMULAIRE - CONFIGURATIONS PDF
$(document).on("click", "#configurations-pdf-bouton", function (){
//ON SOUMET LE TEXTAREA TINYMCE
tinyMCE.triggerSave();
$.post({
url : '/administration/Modules/Facturations/Facturations-action-configurations.php',
type : 'POST',
data: new FormData($("#configurations-pdf")[0]),
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
liste();
});

//AJAX SOUMISSION DU FORMULAIRE - MODIFIER
$(document).on("click", "#Enregistrer_informations", function (){
//ON SOUMET LE TEXTAREA TINYMCE
tinyMCE.triggerSave();
$.post({
url : '/administration/Modules/Facturations/Facturations-action-factures-modifier-ajax.php',
type : 'POST',
data: new FormData($("#formulaire-modifier")[0]),
processData: false,
contentType: false,
dataType: "json",
success: function (res) {
if(res.retour_validation == "ok"){
	if(res.retour_lien == "refresh"){
		$(location).attr("href", "");
	}else{
		popup_alert(res.Texte_rapport,"green filledlight","#009900","uk-icon-check");
	}
}else{
popup_alert(res.Texte_rapport,"#CC0000 filledlight","#CC0000","uk-icon-times");
}
}
});
liste();
$("html, body").animate({ scrollTop: 0 }, "slow");
});

//AJAX SOUMISSION DU FORMULAIRE - AJOUTER
$(document).on("click", "#creation-document-bouton", function (){
//ON SOUMET LE TEXTAREA TINYMCE
tinyMCE.triggerSave();
$.post({
url : '/administration/Modules/Facturations/Facturations-action-factures-ajouter-ajax.php',
type : 'POST',
data: new FormData($("#creation-document")[0]),
processData: false,
contentType: false,
dataType: "json",
success: function (res) {
if(res.retour_validation == "ok"){
popup_alert(res.Texte_rapport,"green filledlight","#009900","uk-icon-check");
$(location).attr("href", "?page=Facturations&action=Facture&idaction="+res.retour_lien);
$("#formulaire_ajout")[0].reset();
}else{
popup_alert(res.Texte_rapport,"#CC0000 filledlight","#CC0000","uk-icon-times");
}
}
});
liste();
});

//AJAX SOUMISSION DU FORMULAIRE - MAIL FACTURES
$(document).on("click", "#mail_post_client", function (){
$.post({
url : '/administration/Modules/Facturations/Facturations-action-factures-mail-client-ajax.php',
type : 'POST',
data: new FormData($("#formulaire-mail-facture")[0]),
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
liste();
});

//AJAX SOUMISSION DU FORMULAIRE - MAIL FACTURES - PAIEMENT
$(document).on("click", "#mail_post_client_paiement", function (){
$.post({
url : '/administration/Modules/Facturations/Facturations-action-factures-mail-client-ajax.php',
type : 'POST',
data: new FormData($("#formulaire-mail-facture-paiement")[0]),
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
liste();
$("html, body").animate({ scrollTop: 0 }, "slow");
});


//AJAX - SUPPRIMER
$(document).on("click", ".lien-supprimer", function (){
$.post({
url : '/administration/Modules/Facturations/Facturations-action-factures-supprimer-ajax.php',
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
liste();
});

//AJAX RECHERCHE - LISTE
$(document).on("click", "#recherche-etat-bouton, #recherche-commercial-bouton, #recherche-statut-bouton, #recherche-mots-bouton, #recherche-numero-bouton", function (){
$.post({
url : '/administration/Modules/Facturations/Facturations-liste-ajax.php',
type : 'POST',
data: new FormData($("#"+$(this).attr("data-formid"))[0]),
processData: false,
contentType: false,
dataType: "html",
success: function (res) {
$("#liste").html(res);
}
});
liste();
});

//FUNCTION AJAX - LISTE 
function liste(){
$.post({
url : '/administration/Modules/Facturations/Facturations-liste-ajax.php',
type : 'POST',
data:{ idmembre: "<?= $_GET['idmembre'] ? $_GET['idmembre'] : ""?>" },
dataType: "html",
success: function (res) {
$("#liste").html(res);
}
});
}
liste();

});

</script>


<ol class="breadcrumb">
  <li><a href="<?php echo $http; ?><?php echo $nomsiteweb; ?>">Accueil</a></li>
  <li><a href="<?php echo $mode_back_lien_interne; ?>">Administration</a></li>
  <?php if(empty($_GET['action'])){ ?> <li class="active">Gestion des factures</li> <?php }else{ ?> <li><a href="?page=Facturations">Gestion des factures</a></li> <?php } ?>
  <?php if($_GET['action'] == "Modifier" ){ ?> <li class="active">Modifications</li> <?php } ?>
  <?php if($_GET['action'] == "Ajouter" ){ ?> <li class="active">Ajouter</li> <?php } ?>
  <?php if($_GET['action'] == "Graphique" ){ ?> <li class="active">Graphique</li> <?php } ?>
  <?php if($_GET['action'] == "Configurations" ){ ?> <li class="active">Configurations</li> <?php } ?>
</ol>

<?php

echo "<div id='bloctitre' style='text-align: left;' ><h1>Gestion des factures1</h1></div><br />
<div style='clear: both;'></div>";

////////////////////Boutton administration
echo "<a href='".$mode_back_lien_interne."'><button type='button' class='btn btn-default' style='margin-right: 5px;' ><span class='uk-icon-cogs'></span> Administration</button></a>";
echo "<a href='?page=Facturations&amp;action=Configurations'><button type='button' class='btn btn-primary' style='margin-right: 5px;' ><span class='uk-icon-cog'></span> Configurations</button></a>";
/* if($action != "Graphique" ){
echo "<a href='?page=Facturations&amp;action=Graphique'><button type='button' class='btn btn-primary' style='margin-right: 5px;' ><span class='uk-icon-bar-chart-o'></span> Statistiques en graphique</button></a>";
} */
//echo "<a href='?page=Facturations&amp;action=Ajouter'><button type='button' class='btn btn-success' style='margin-right: 5px;' ><span class='uk-icon-plus-circle'></span> Ajouter une facture</button></a>";
if(!empty($_GET['action'])){
echo "<a href='?page=Facturations'><button type='button' class='btn btn-success' style='margin-right: 5px;' ><span class='uk-icon-history'></span> Liste des factures </button></a>";
}
echo "<div style='clear: both;'></div><br />";
////////////////////Boutton administration

?>

<div style='padding: 5px;' align="center">

<?php

$action = $_GET['action'];
$idaction = $_GET['idaction'];

$actionn = $_GET['actionn'];
$idactionn = $_GET['idactionn'];

//////////////////////////////////////////////////////////////////////////////////////////GRAPHIQUE
if($action == "Graphique"){
?>
<div style='text-align: left;'>
<?php
///////////////////////////////////////////////////////////////////MODULE GRAPHIQUE
$titre_statistique = " - Chiffres d'affaires H.T";
graphique(1,"membres_prestataire_facture","date_edition","jour_edition","mois_edition","annee_edition","Montant","Tarif_HT","Factures","Factures","departement-active","departement","code-promotion-active","code_promotion","","","");
///////////////////////////////////////////////////////////////////MODULE GRAPHIQUE
?>
</div>
<?php
}
//////////////////////////////////////////////////////////////////////////////////////////GRAPHIQUE

////////////////////////////////////////////////////////////////////////////////FACTURE MODIFICATION
if($action == "Facture"){

$_SESSION['Modification_facture'] = $idaction;

	///////////////////////////////SELECT
	$req_select = $bdd->prepare("SELECT * FROM membres_prestataire_facture WHERE id=?");
	$req_select->execute(array($idaction));
	$ligne_select = $req_select->fetch();
	$req_select->closeCursor();
	$id_facture = $ligne_select['id'];
	$id_membre = $ligne_select['id_membre'];
	$REFERENCE_NUMERO_SQL = $ligne_select['REFERENCE_NUMERO'];
	$id_membrepseudo = $ligne_select['pseudo'];
	$id_commercial = $ligne_select['id_commercial'];
	$pseudo_commercial = $ligne_select['pseudo_commercial'];
	$numero_facture = $ligne_select['numero_facture'];
	$Titre_facture = $ligne_select['Titre_facture'];
	$Contenu = $ligne_select['Contenu'];
	$Suivi = $ligne_select['Suivi'];
	$date_edition = $ligne_select['date_edition'];
	$date_edition = date('d-m-Y', $date_edition);
	$mod_paiement = $ligne_select['mod_paiement'];
	$Tarif_HT = $ligne_select['Tarif_HT'];
	$Remise = $ligne_select['Remise'];
	$Tarif_HT_net = $ligne_select['Tarif_HT_net'];
	$Tarif_TTC = $ligne_select['Tarif_TTC'];
	$Total_Tva = $ligne_select['Total_Tva'];
	$taux_tva = $ligne_select['taux_tva'];
	$condition_reglement = $ligne_select['condition_reglement'];
	$delai_livraison = $ligne_select['delai_livraison'];
	$Commentaire_information = $ligne_select['Commentaire_information'];
	$statut = $ligne_select['statut'];

	///////////////////////////////SELECT
	$req_select = $bdd->prepare("SELECT * FROM membres WHERE pseudo=?");
	$req_select->execute(array($id_membrepseudo));
	$ligne_select = $req_select->fetch();
	$req_select->closeCursor();
	$idd2dddf = $ligne_select['id']; 
	$loginm = $ligne_select['pseudo'];
	$emailm = $ligne_select['mail'];
	$adminm = $ligne_select['admin'];
	$nomm = $ligne_select['nom'];
	$prenomm = $ligne_select['prenom'];
        $adressem = $ligne_select['adresse'];
	$cpm = $ligne_select['cp'];
	$villem = $ligne_select['ville'];
	$IM = $ligne_select['IM'];
	$IM_REGLEMENT = $ligne_select['IM_REGLEMENT'];
	$telephonepost = $ligne_select['Telephone'];
	$telephoneposportable = $ligne_select['Telephone_portable'];
	$cba = $ligne_select['newslettre'];
	$cbb = $ligne_select['reglement_accepte'];
	$FH = $ligne_select['femme_homme'];
	$datenaissance = $ligne_select['datenaissance'];
	$pdate_etatdate_etat = $ligne_select['date_etat'];
	$date_enregistrement = $ligne_select['date_enregistrement'];
	$ip_inscription = $ligne_select['ip_inscription'];
	$statut_compte = $ligne_select['statut_compte'];

if($statut == "Brouillon" ){
$selected9 = "selected";
}elseif($Suivi == "Activée"){
$selected10 = "selected";
}

if($Suivi == "payer" ){
$selected7 = "selected";
}elseif($Suivi == "non payer"){
$selected8 = "selected";
}

if($mod_paiement == "Paypal" ){
$selected1 = "selected";
}elseif($mod_paiement == "Virement" ){
$selected2 = "selected";
}elseif($mod_paiement == "Chèque" ){
$selected3 = "selected";
}elseif($mod_paiement == "Espèce" ){ 
$selected4 = "selected";
}elseif($mod_paiement == "Mandat cash" ){
$selected5 = "selected";
}elseif($mod_paiement == "Carte bancaire" ){
$selected6 = "selected";
}

if(empty($nomm) && empty($prenomm)){
$nom_prenom = "- -";
}else{
$nom_prenom = "$nomm $prenomm";
}
if(empty($emailm)){
$emailm = "- -";
}
if(empty($telephonepost)){
$telephonepost = "- -";
}
if(empty($telephoneposportable)){
$telephoneposportable = "- -";
}

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM membres_professionnel WHERE pseudo=?");
$req_select->execute(array($loginm));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$id_pro_a = $ligne_select['id'];
$Nom_societe_pro_a = $ligne_select['Nom_societe'];
$Votre_role_a = $ligne_select['Votre_role'];
$Type_societe_pro_a = $ligne_select['Type_societe'];
$Effectif_pro_a = $ligne_select['Effectif'];
$Numero_identification_pro_a = $ligne_select['Numero_identification'];
$Non_assujetti_pro_a = $ligne_select['Non_assujetti'];
$Numero_tva_pro_a = $ligne_select['Numero_tva'];

?>

<div style='margin-right: auto; margin-left:auto; text-align: center; max-width:850px;'>
<div style='text-align: left; margin-bottom: 20px;'>
<h2>Edition de la facture N°<?php echo "$numero_facture"; ?></h2>
</div>

<table style='width: 100%;'>

<tr><td style='text-align: left; width: 180px;'>Envoyé la facture PDF</td>
<td style='text-align: left;'>
<form id='formulaire-mail-facture' method='post' action='#' >
<input id="action" type="hidden" name="action" value="Mail-action" >
<input id="idaction" type="hidden" name="idaction" value="<?php echo "$idaction"; ?>" >
<input class='form-control btn btn-warning' type='submit' id='mail_post_client' name='mail_post_client' onclick="return false;" value='ENVOYER LA FACTURE AU CLIENT' style='width: 280px;' />
</form>
</td>
</tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>

</table>

<form id="formulaire-modifier" method='post' action='#'>

<input id="action" type="hidden" name="action" value="Modifier-action" >
<input id="idaction" type="hidden" name="idaction" value="<?php echo "$idaction"; ?>" >

<table style='width: 100%;'>

<tr><td style='text-align: left;' colspan='2'><h3>Informations</h3></td></tr>

<tr><td style='text-align: left; width: 180px;'>Espace membre</td>
<td style='text-align: left;'><a class='btn btn-info' href='?page=Membres&amp;action=modifier&amp;idaction=<?php echo "$idd2dddf"; ?>'><span class='uk-icon-user'></span> Modifier information </a></td>
</tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>

<tr><td style='text-align: left; width: 180px;'>Facture PDF</td>
<td style='text-align: left;'>
<a class='btn btn-danger' href='/facture/<?php echo "$numero_facture"; ?>/<?php echo "$nomsiteweb"; ?>' target='_top'><span class='uk-icon-file-pdf-o'></span> Facture PDF</a>
</td>
</tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>

<tr><td style='text-align: left; width: 180px;'>Numéro facture</td>
<td style='text-align: left;'><?php echo "<b>N°$numero_facture</b>"; ?></td>
</tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>

<?php
/*
///////////////////////////////////////////////SI MODULE TYPE DE COMPTE ACTIVE
if($type_de_compte_module == "oui" ){

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM membres_type_de_compte WHERE id=?");
$req_select->execute(array($statut_compte));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$id_statut_compte_membre = $ligne_select['Nom_type'];

?>
<tr>
<td style='text-align: left; width: 150px;'>Type de compte</td>
<td style='text-align: left;'><?php echo "$id_statut_compte_membre"; ?></td></tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>
<?php
}
*/
///////////////////////////////////////////////SI MODULE TYPE DE COMPTE ACTIVE
?>

<tr><td style='text-align: left; width: 180px;'>Pseudo</td>
<td style='text-align: left;'><?php echo "$loginm"; ?></td>
</tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>

<?php
/////////////////////////////////////////SI SOCIETE
if(!empty($Nom_societe_pro_a)){
?>
<tr><td style='text-align: left;' colspan='2'><h3>Informations professionnelles</h3></td></tr>
<tr><td style='text-align: left; width: 180px;'>Société</td>
<td style='text-align: left;'><?php echo "<b>$Nom_societe_pro_a</b>"; ?></td>
</tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>
<tr><td style='text-align: left; width: 180px;'>Siret</td>
<td style='text-align: left;'><?php echo "$Numero_identification_pro_a"; ?></td>
</tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>
<?php
}
/////////////////////////////////////////SI SOCIETE
?>

<tr><td style='text-align: left;' colspan='2'><h3>Informations complémentaires</h3></td></tr>

<tr><td style='text-align: left; width: 180px;'>Nom &amp; prénom client</td>
<td style='text-align: left;'><?php echo "$nom_prenom"; ?></td>
</tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>
<tr><td style='text-align: left; width: 180px;'>Mail client</td>
<td style='text-align: left;'><?php echo "<a href='mailto:".$emailm."'>$emailm</a>"; ?></td>
</tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>
<tr><td style='text-align: left; width: 180px;'>Téléphone client</td>
<td style='text-align: left;'><?php echo "$telephonepost"; ?></td>
</tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>
<tr><td style='text-align: left; width: 180px;'>Portable client</td>
<td style='text-align: left;'><?php echo "$telephoneposportable"; ?></td>
</tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>
<tr><td style='text-align: left;' colspan='2'><h3>Informations de la facture</h3></td></tr>

<!--
<tr><td style='text-align: left; width: 180px;'>REFERENCE FACTURE</td>
<td style='text-align: left;'><input class='form-control' id='REFERENCE_NUMERO' type='text' value="<?php echo "$REFERENCE_NUMERO_SQL"; ?>" name='REFERENCE_NUMERO' style='width: 100%;' /></td>
</tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>
-->

<?php /////////MODE BROUILLON
if($statut == "Brouillon"){ 
?>

<tr><td style='text-align: left; width: 180px;'>Statut</td>
<td style='text-align: left;'>
<select class='form-control' name='statut' style='width: 100%;' > 
<option <?php echo $selected9; ?> value='Brouillon'> Brouillon &nbsp;</option>
<option <?php echo $selected10; ?> value='Activée'> Activée &nbsp;</option>
</select> 
</td>
</tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>

<?php
////////////////////////SI MODULE FACTURE COMMERCIAL ACTIVE
if($Module_facture_commercial_active == "oui"){
?>

<tr><td style="text-align: left; width: 240px;">Commercial</td>
<td style="text-align: left;">
<select class='form-control' name='id_commercial' onchange="affiche_infos_commercial(this.value)">
<option value=""> Choix du commercial &nbsp; &nbsp;</option>
<?php
///////////////////////////////SELECT BOUCLE
$req_boucle = $bdd->prepare("SELECT * FROM membres WHERE commercial='oui' || agent_commercial='oui' || franchise='oui'");
$req_boucle->execute();
while($ligne_boucle = $req_boucle->fetch()){
$idd_co = $ligne_boucle['id']; 
$email_co = $ligne_boucle['mail'];
$pseudo_co = $ligne_boucle['pseudo'];
$nomm_co = $ligne_boucle['nom'];
$prenomm_co = $ligne_boucle['prenom'];
$telephoneposportable_co = $ligne_boucle['Telephone_portable'];
$commercial_co = $ligne_boucle['commercial'];
$agent_commercial_co = $ligne_boucle['agent_commercial'];
$franchise_co = $ligne_boucle['franchise'];

if($commercial_co == "oui"){
$informations_commercial = "Commercial agence";
}elseif($agent_commercial_co == "oui"){
$informations_commercial = "Agent commercial";
}elseif($franchise_co == "oui"){
$informations_commercial = "Franchise commercial";
}

if($idd_co == $id_commercial){
?>
<option selected value="<?php echo "$idd_co"; ?>"> <?php echo "$pseudo_co (".$informations_commercial.")"; ?> &nbsp; &nbsp;</option>
<?php
}else{
?>
<option value="<?php echo "$idd_co"; ?>"> <?php echo "$pseudo_co (".$informations_commercial.")"; ?> &nbsp; &nbsp;</option>
<?php
}
}
$req_boucle->closeCursor();
?>
</td></tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>

<?php
///////////////////////////////SELECT BOUCLE
$req_boucle = $bdd->prepare("SELECT * FROM membres WHERE commercial='oui' || agent_commercial='oui' || franchise='oui'");
$req_boucle->execute();
while($ligne_boucle = $req_boucle->fetch()){
$idd_coi = $ligne_boucle['id']; 
$email_coi = $ligne_boucle['mail'];
$pseudo_coi = $ligne_boucle['pseudo'];
$nomm_coi = $ligne_boucle['nom'];
$prenomm_coi = $ligne_boucle['prenom'];
$telephoneposportable_coi = $ligne_boucle['Telephone_portable'];
$commercial_coi = $ligne_boucle['commercial'];
$agent_commercial_coi = $ligne_boucle['agent_commercial'];
$franchise_coi = $ligne_boucle['franchise'];
$franchise_coi = $ligne_boucle['franchise'];
?>
<tr id='commercial1<?php echo "$idd_coi"; ?>' style='display: none;' ><td style="text-align: left; width: 240px; vertical-align: top;">Informations commercial</td>
<td style="text-align: left;">
<?php echo "$nomm_coi $prenomm_coi"; ?><br />
<?php echo "$email_coi"; ?> <br />
<?php echo "Skype : pseudo_skype"; ?> <br />
<?php echo "$telephoneposportable_coi"; ?><br /><br />
</td></tr>
<?php
}
$req_boucle->closeCursor();
?>

<script>
function affiche_infos_commercial(id){
var id;
<?php
///////////////////////////////SELECT BOUCLE
$req_boucle = $bdd->prepare("SELECT * FROM membres WHERE commercial='oui' || agent_commercial='oui' || franchise='oui'");
$req_boucle->execute();
while($ligne_boucle = $req_boucle->fetch()){
$idd_coo = $ligne_boucle['id']; 
?>
document.getElementById('commercial1<?php echo "$idd_coo"; ?>').style.display='none';
<?php
}
$req_boucle->closeCursor();
?>
document.getElementById("commercial1"+id).style.display='';
}
affiche_infos_commercial("commercial1<?php echo "$id_commercial"; ?>");
</script>

<?php
}
////////////////////////SI MODULE FACTURE COMMERCIAL ACTIVE
?>

<tr><td style='text-align: left; width: 180px;'>Titre de la facture</td>
<td style='text-align: left;'><input class='form-control' id='Titre_facture' type='text' value="<?php echo "$Titre_facture"; ?>" name='Titre_facture' style='width: 100%;' /></td>
</tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>

<tr><td style='text-align: left; width: 180px;'>Conditions de règlement</td>
<td style='text-align: left;'><input class='form-control' id='condition_reglement' type='text' value="<?php echo "$condition_reglement"; ?>" name='condition_reglement' style='width: 100%;' /></td>
</tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>

<tr><td style='text-align: left; width: 180px;'>Délai de livraison</td>
<td style='text-align: left;'><input class='form-control' id='delai_livraison' type='text' value="<?php echo "$delai_livraison"; ?>" name='delai_livraison' style='width: 100%;' /></td>
</tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>

<?php 
}
/////////MODE BROUILLON
?>


<tr><td style='text-align: left; width: 180px;'>Mode de paiement</td>
<td style='text-align: left;'>
<select class='form-control' name='mod_paiement' style='width: 100%;' > 
<option <?php echo $selected1; ?> value='Paypal'> Paypal &nbsp;</option>
<option <?php echo $selected2; ?> value='Virement'> Virement &nbsp;</option>
<option <?php echo $selected3; ?> value='Chèque'> Chèque &nbsp;</option>
<option <?php echo $selected4; ?> value='Espèce'> Espèce &nbsp;</option>
<option <?php echo $selected5; ?> value='Mandat cash'> Mandat cash &nbsp;</option>
<option <?php echo $selected6; ?> value='Carte bancaire'> Carte bancaire &nbsp;</option>
</select> 
</td>
</tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>

<tr><td style='text-align: left; width: 180px;'>Statut</td>
<td style='text-align: left;'>
<select class='form-control' name='Suivi' style='width: 100%;'>
<option <?php echo "$selected7"; ?> value='payer'> Factures payées &nbsp; &nbsp; </option>
<option <?php echo "$selected8"; ?> value='non payer'> Factures non payées &nbsp; &nbsp; </option>
</select> 
</td>
</tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>

<?php /////////MODE BROUILLON
if($statut == "Brouillon"){ 
?>

<?php
///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM configurations_pdf_devis_factures WHERE id=?");
$req_select->execute(array('1'));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$Description_defaut_facture = $ligne_select['Description_defaut_facture'];

if(empty($Commentaire_information)){
$Commentaire_information = "$Description_defaut_facture";
}
?>

<tr><td style='text-align: left; width: 180px; vertical-align: top;'>Commentaire</td>
<td style='text-align: left;'>
<textarea style='width: 100%; height: 100px;' name='Commentaire_information' ><?php echo "$Commentaire_information"; ?></textarea>
</td>
</tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>

<?php 
}
/////////MODE BROUILLON
?>

<tr><td style='text-align: center;' colspan='2'><input class='form-control btn btn-success' type='submit' id='Enregistrer_informations' name='Enregistrer_informations' value="ENREGISTRER" onclick="return false;" /></td></tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>

</table>
</form>

<?php 
/////////MODE BROUILLON
if($statut == "Brouillon"){ 
?>

<div style='text-align: left; margin-bottom: 20px;'>
<h3>Ajouter un libell&eacute;</h3>
<form method='post' action='' onclick='event.preventDefault();'>
<textarea id='libelle_postt' name='libelle_post' value='' placeholder='Libell&eacute;' style='width: 99%; height: 40px; padding: 5px;'></textarea><br />
<input class='form-control' type='text' id='reference_postt' name='reference_post' value='' placeholder='Référence' style='display: inline-block; width: 32%; margin-right: 1%;'/>
<input class='form-control' type='number' id='quantite_postt' name='quantite_post' pattern="[0-9]+"  value='' placeholder='Qts' style='display: inline-block; width: 32%; margin-right: 1%;'/>
<input class='form-control' type='text' id='prix_ut_ht_postt' name='prix_ut_ht_post' pattern="[0-9]+[.]*[0-9]{0,2}" value='' placeholder='P.U HT &euro;' style='display: inline-block; width: 32%;'/>
<input class='form-control btn-success' type='submit' name='post_details' value='ENREGISTRER' style='width: 99%;' onclick="mafonctionadd()" />
</form>
</div>

<script>
function mafonctionadd(){
var param1 = document.getElementById("libelle_postt").value;
var param2 = document.getElementById("prix_ut_ht_postt").value;
var param3 = document.getElementById("quantite_postt").value;
var param4 = document.getElementById("reference_postt").value;
maFonctionAjaxa2("Ajouter",param1,param2,param3,param4);
}
</script>
								<script>
									function maFonctionAjaxa2(OnAjoutea1,parametre1,parametre2,parametre3,parametre4){
										var MonAjaxa2;

										// Mozilla, Safari, ...
										if (window.XMLHttpRequest){
											MonAjaxa2 = new XMLHttpRequest();
										// IE
										}else if(window.ActiveXObject){  
											MonAjaxa2 = new ActiveXObject('Microsoft.XMLHTTP');
										}else{
											alert("Votre navigateur n'est pas adapté pour faire des requêtes AJAX..."); 
											MonAjaxa2 = false;
										}
										  
										MonAjaxa2.open('GET',"/administration/Modules/Facturations/Facturations-details-ajax.php?a=1&idactionnn=<?php echo "$idaction"; ?>&onajoute11="+ OnAjoutea1 +"&parametre1="+ parametre1 +"&parametre2="+ parametre2 +"&parametre3="+ parametre3 +"&parametre4="+ parametre4 +"&t=" + Math.random(),true); 
										
										MonAjaxa2.onreadystatechange = function(){
											if (MonAjaxa2.readyState == 4 && MonAjaxa2.status == 200){
												document.getElementById('boutonsValidation2').innerHTML = MonAjaxa2.responseText;
											}
										}
										MonAjaxa2.send(); 
									}
									maFonctionAjaxa2();
								</script>

								<div id='boutonsValidation2'></div>

<div style='text-align: left; margin-bottom: 20px;'>
<h3>Appliquer une remise</h3>
<form method='post' action='' onclick='event.preventDefault();'>
<input class='form-control' type='text' id='Remise' name='Remise' value="<?php echo ""; ?>" placeholder='Remise en % | ex: 10' style='width: 49%; margin-right: 5px; display: inline-block;'/>
<input class='form-control btn btn-success' type='submit' name='post_Remise' value='ENREGISTRER' style='width: 49%; display: inline-block;' onclick="mafonctionremise()" />
</form>
</div>

<script>
function mafonctionremise(){
var param1 = document.getElementById("Remise").value;
maFonctionAjaxa2("Remise",param1);
}
</script>

<?php 
}
/////////MODE BROUILLON 
?>

<div style='text-align: left; margin-bottom: 20px;'>
<form id='formulaire-mail-facture-paiement' method='post' action='#' >
<input id="action" type="hidden" name="action" value="Mail-action" >
<input id="idaction" type="hidden" name="idaction" value="<?php echo "$idaction"; ?>" >
<input type='checkbox' name='demande_paiement' value='oui' style='margin-right: 10px; float: left;  /> 
<div style='float: left; margin-top: -2px;'>
Envoyer dans le mail une demande de paiement par Paypal (Virement ou carte bancaire) 
</div>
<input class='form-control btn-warning' type='submit' id='mail_post_client_paiement' name='mail_post_client'  onclick='return false;'  value='ENVOYER LA FACTURE PAR MAIL AU CLIENT' style='width: 100%;' />
</form>
</div>

</div>

</div>

<?php
}
////////////////////////////////////////////////////////////////////////////////FACTURE MODIFICATION


////////////////////////////////////////////////////////////////////////////////AJOUTER UNE FACTURE
if($action == "Ajouter"){
?>

<form id='creation-document' method='post' action='#'>
<div style='margin-right: auto; margin-left:auto; text-align: center; max-width: 500px;'>
<div style='text-align: left; margin-bottom: 20px;'>
<h2>Ajouter une facture</h2>
</div>

<table style='width: 100%;'>

<tr><td style='text-align: left;' colspan='2'><h3>Choix du type de client</h3></td></tr>

<tr>
<td style='text-align: left; width: 100px;'>Type de client</td>
<td style='text-align: left;'>
<select class='form-control' name='Type_client' style='width: 100%; ' onchange="type_client_js(this.value);">
<option value=''> - Aucune sélection - </option>
<option <?php echo "selected1"; ?> value='Client enregistré ?'>Client enregistré ? </option>
<option <?php echo "selected2"; ?> value='Client non enregistré ?'>Client non enregistré ? </option>
</select>

</td>
</tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>

</table>

<script>
function type_client_js(valueselect){
var valueselect;
if(valueselect == "Client enregistré ?"){
document.getElementById("deja_compte_client").style.display='inline-block';
document.getElementById("creation_compte_client").style.display='none';
}
if(valueselect == "Client non enregistré ?"){
document.getElementById("creation_compte_client").style.display='inline-block';
document.getElementById("deja_compte_client").style.display='none';
}
}
</script>

<table id='deja_compte_client' style='width: 100%; display: none;'>

<tr><td style='text-align: left; width: 100%;' colspan='2' ><h3>Déja client</h3></td></tr>

<tr >
<td style='text-align: left;'>Pseudo</td>
<td style='text-align: left; width: 100%;'>
<select class='form-control' name='Pseudo_post' style='width: 100%;'>
<option value=''>- Pseudo -</option>
<?php
///////////////////////////////SELECT BOUCLE
$req_boucle = $bdd->prepare("SELECT * FROM membres ORDER BY pseudo ASC");
$req_boucle->execute();
while($ligne_boucle = $req_boucle->fetch()){
$pseudopseudo = $ligne_boucle['pseudo'];
echo "<option value='".$pseudopseudo."'># $pseudopseudo</option>";
}
$req_boucle->closeCursor();
?>
</select>
</td>
</tr>
<tr><td style='text-align: left;' colspan='2' >&nbsp;</td></tr>

</table>

<table id='creation_compte_client' style='width: 100%; display: none;'>

<tr><td style='text-align: left;' colspan='2'><h3>Création de compte client</h3></td></tr>

<?php
///////////////////////////////////////////////SI MODULE TYPE DE COMPTE ACTIVE
if($type_de_compte_module == "oui" ){
?>
<tr>
<td style='text-align: left; width: 150px;'>Type de compte</td>
<td style='text-align: left; width: 100%;'>
<select name="type_compte" id="type_compte" class="form-control" style='width: 100%;'>
<?php
///////////////////////////////SELECT BOUCLE
$req_boucle = $bdd->prepare("SELECT * FROM membres_type_de_compte WHERE activer='oui' ORDER BY position ASC");
$req_boucle->execute();
while($ligne_boucle = $req_boucle->fetch()){
$id_type = $ligne_boucle['id'];
$Nom_type_type = $ligne_boucle['Nom_type'];
?>
<option value="<?php echo "$Nom_type_type"; ?>"> <?php echo "$Nom_type_type"; ?></option>
<?php
}
$req_boucle->closeCursor();
?>
</select>
</td></tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>
<?php
}
///////////////////////////////////////////////SI MODULE TYPE DE COMPTE ACTIVE
?>

<tr><td colspan='2'><hr /></td></tr>
<tr><td style='text-align: left;'><h3>Société</h3></td></tr>
<tr>
<td style='text-align: left; width: 150px;'>Société</td>
<td style='text-align: left; width: 100%;'><input id='Societe' class='form-control' type='text' value="" name='Societe' style='width: 100%;' /></td>
</tr>
<tr><td style='text-align: left; vertical-align: top; width: 150px;'></td>
<td style='text-align: left;'>Laissez vide si pas en société</td></tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>
<tr>
<td style='text-align: left; width: 150px;'>Siret</td>
<td style='text-align: left; width: 100%;'><input id='Siret' class='form-control' type='text' value="" name='Siret' style='width: 100%;' /></td>
</tr>
<tr><td style='text-align: left; vertical-align: top; width: 150px;'></td>
<td style='text-align: left;'>Laissez vide si pas en société</td></tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>
<tr>
<td style='text-align: left; width: 150px;'>N°TVA</td>
<td style='text-align: left; width: 100%;'><input id='N_TVA' class='form-control' type='text' value="" name='N_TVA' style='width: 100%;' /></td>
</tr>
<tr><td style='text-align: left; vertical-align: top; width: 150px;'></td>
<td style='text-align: left;'>Laissez vide si pas en société</td></tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>

<tr><td colspan='2'><hr /></td></tr>
<tr><td style='text-align: left;'><h3>Informations</h3></td></tr>
<tr>
<td style='text-align: left; vertical-align: top; width: 150px;'>Nom</td>
<td style='text-align: left; width: 100%;'><input id='Nom' class='form-control' type='text' value="" name='Nom' style='width: 100%;' /></td>
</tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>
<tr>
<td style='text-align: left; vertical-align: top; width: 150px;'>Prénom</td>
<td style='text-align: left; width: 100%;'><input id='Prenom' class='form-control' type='text' value="" name='Prenom' style='width: 100%;' /></td>
</tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>
<tr>
<td style='text-align: left; vertical-align: top; width: 150px;'>Adresse</td>
<td style='text-align: left; width: 100%;'><input id='Adresse' class='form-control' type='text' value="" name='Adresse' style='width: 100%;' /></td>
</tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>
<tr>
<td style='text-align: left; vertical-align: top; width: 150px;'>Ville</td>
<td style='text-align: left; width: 100%;'><input id='Ville' class='form-control' type='text' value="" name='Ville' style='width: 100%;' /></td>
</tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>
<tr>
<td style='text-align: left; vertical-align: top; width: 150px;'>Code postal</td>
<td style='text-align: left; width: 100%;'><input id='Codeal' class='form-control' type='text' value="" name='Codeal' style='width: 100%;' /></td>
</tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>
<tr>
<td style='text-align: left; width: 150px;'>Pays</td>
<td style='text-align: left;'>
<?php include("../function/pays-select.php"); ?>
</td>
</tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>

<tr><td colspan='2'><hr /></td></tr>
<tr><td style='text-align: left;'><h3>Contact</h3></td></tr>
<tr>
<td style='text-align: left; vertical-align: top; width: 150px;'>Téléphone</td>
<td style='text-align: left; width: 100%;'><input id='Telephone' class='form-control' type='text' value="" name='Telephone' style='width: 100%;' /></td>
</tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>
<tr>
<td style='text-align: left; vertical-align: top; width: 150px;'>Portable</td>
<td style='text-align: left; width: 100%;'><input id='Portable' class='form-control' type='text' value="" name='Portable' style='width: 100%;' /></td>
</tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>
<tr>
<td style='text-align: left; vertical-align: top; width: 150px;'>Mail</td>
<td style='text-align: left; width: 100%;'><input id='Mail' class='form-control' type='text' value="" name='Mail' style='width: 100%;' /></td>
</tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>
</table>

<table id='client_submit' style='width: 100%; '>
<tr><td style='text-align: center;' colspan='2'><input class='form-control btn btn-success' type='submit' id='creation-document-bouton' name='client_submit' value='ENREGISTRER' onclick='return false;' style='width: 150px;' /></td></tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>
</table>
</div>

</form>

<?php
}
////////////////////////////////////////////////////////////////////////////////AJOUTER UNE FACTURE

////////////////////////////////////////////////////////////////////////////////CONFIGURATIONS
if($action == "Configurations"){
	
	$req_select = $bdd->prepare("SELECT * FROM configurations_pdf_devis_factures WHERE id=?");
$req_select->execute(array('1'));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$Description_defaut_facture = $ligne_select['Description_defaut_facture'];
$En_Tete_Pdf = $ligne_select['En_Tete_Pdf'];
$logo_pdf = $ligne_select['logo_pdf'];
$Pied_de_page_Pdf = $ligne_select['Pied_de_page_Pdf'];
$Description_defaut_devis = $ligne_select['Description_defaut_devis'];
$text_demande_de_devis = $ligne_select['text_demande_de_devis'];
$Description_defaut_facture = $ligne_select['Description_defaut_facture'];
$Banque_nom = $ligne_select['Banque_nom'];
$Banque_code = $ligne_select['Banque_code'];
$Banque_numero_compte = $ligne_select['Banque_numero_compte'];
$Banque_cle_rib = $ligne_select['Banque_cle_rib'];
$Banque_iban = $ligne_select['Banque_iban'];
$Banque_bic = $ligne_select['Banque_bic'];
     
?>

<div style='margin-right: auto; margin-left:auto; text-align: center; max-width: 700px;'>
<div style='text-align: left; margin-bottom: 20px;'>
<h2>Configurations</h2>
</div>

<form method='post' id='configurations-pdf' action='#' enctype="multipart/form-data">

<table style='width: 100%;'>
<?php
if(!empty($logo_pdf)){
?>
<tr><td style='text-align: center;' colspan='2'>
<img src="/images/<?php echo "$logo_pdf"; ?>" alt="<?php echo "$logo_pdf"; ?>" style='cursor: pointer;' width="200" /><br />
<br /><input type='file' name='icon' id="images" style='display: inline-block;'  /><br /><br />
<div style='display: inline-block; font-weight: bold; cursor: pointer;'>Télécharger un logo</div>
</td></tr>
</tr>
<td style='text-align: center;' colspan='2'>Taille minimum 300px de largeur (.jpg)</td></tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>
<?php
}else{
?>
<tr><td style='text-align: center;' colspan='2'>
<img src="/images/pas-de-photo.png" alt="<?php echo "Logo"; ?>" width="150" style='cursor: pointer;' /><br />
<br /><input type='file' name='icon' id="images" style='display: inline-block;'  /><br /><br />
<div style='display: inline-block; font-weight: bold; cursor: pointer;' >Télécharger un logo</div>
</td></tr>
</tr>
<td style='text-align: center;' colspan='2'>Taille minimum 300px de largeur (.jpg)</td></tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>
<?php
}
?>
</table>

<table style='width: 100%;'>

<tr>
<td style='text-align: left; vertical-align: top;'>En-tête PDF</td>
<td style='text-align: left;'><textarea class='form-control' style='vertical-align: top; width: 100%; height: 100px;' name='En_Tete_Pdf'><?php echo "$En_Tete_Pdf"; ?></textarea></td>
</tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>

<tr>
<td style='text-align: left; vertical-align: top;'>Pied de page PDF</td>
<td style='text-align: left;'><textarea class='form-control' style='vertical-align: top; width: 100%; height: 100px;' name='Pied_de_page_Pdf'><?php echo "$Pied_de_page_Pdf"; ?></textarea></td>
</tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>

<?php
/////////////////////////////////////////////////SI MODULE DEMANDE DE DEVIS ACTIVE
if($Facturations_module == "oui"){
?>
<tr>
<td style='text-align: left; vertical-align: top;'>Description défaut facture</td>
<td style='text-align: left;'><textarea class='form-control' style='vertical-align: top; width: 100%; height: 100px;' name='Description_defaut_facture'><?php echo "$Description_defaut_facture"; ?></textarea></td>
</tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>
<?php
}
/////////////////////////////////////////////////SI MODULE DEMANDE DE DEVIS ACTIVE
?>

<tr><td style='text-align: left;' colspan='3'><h3>Configurations RIB</h3></td></tr>

<!--
<tr>
<td style='text-align: left; vertical-align: top;'>Télécharger le RIB</td>
<td style='text-align: left;'><input type='file' style=' width: 100%;' name='RIB' value="<?php echo "$RIB"; ?>" /></td>
</tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>
<?php
if(!empty($RIB)){
?>
<tr>
<td style='text-align: left; vertical-align: top;'>Consulter le RIB</td>
<td style='text-align: left;'><a href='/images/<?php echo "$RIB"; ?>' target='_top' > Voir le RIB</a> <a href='?page=Facturations&amp;action=Configurations&amp;actionn=Supprimer-RIB' ><span class='uk-icon-times' style='color: red;' ></span></a></td>
</tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>
<?php
}
?>
-->

<tr>
<td style='text-align: left; vertical-align: top;'>Nom de la banque</td>
<td style='text-align: left;' colspan='2'><input class='form-control' type='text' name='Banque_nom' value="<?php echo "$Banque_nom"; ?>" style='width: 100%;'></td>
</tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>
<tr>
<td style='text-align: left; vertical-align: top;'>Banque (Code)</td>
<td style='text-align: left;' colspan='2'><input class='form-control' type='text' name='Banque_code' value="<?php echo "$Banque_code"; ?>" style='width: 100%;'></td>
</tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>
<tr>
<td style='text-align: left; vertical-align: top;'>N° du compte</td>
<td style='text-align: left;' colspan='2'><input class='form-control' type='text' name='Banque_numero_compte' value="<?php echo "$Banque_numero_compte"; ?>" style='width: 100%;'></td>
</tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>
<tr>
<td style='text-align: left; vertical-align: top;'>Clé rib</td>
<td style='text-align: left;' colspan='2'><input class='form-control' type='text' name='Banque_cle_rib' value="<?php echo "$Banque_cle_rib"; ?>" style='width: 100%;'></td>
</tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>
<tr>
<td style='text-align: left; vertical-align: top;'>IBAN</td>
<td style='text-align: left;' colspan='2'><input class='form-control' type='text' name='Banque_iban' value="<?php echo "$Banque_iban"; ?>" style='width: 100%;'></td>
</tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>
<tr>
<td style='text-align: left; vertical-align: top;'>BIC</td>
<td style='text-align: left;' colspan='2'><input class='form-control' type='text' name='Banque_bic' value="<?php echo "$Banque_bic"; ?>" style='width: 100%;'></td>
</tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>

<tr><td style='text-align: left;' colspan='3'><h3>Informations</h3></td></tr>

<!--
<tr>
<td style='text-align: left;'>Mode couleur</td>
<td style='text-align: left;'>
<?php
if($Mode_couleur_SITE_DEFAUT == "SITE"){
$selected_couleur1 = "selected";
}elseif($Mode_couleur_SITE_DEFAUT == "DEFAUT"){
$selected_couleur2 = "selected";
}
?>
<select class='form-control' name='Mode_couleur_SITE_DEFAUT'>
<option <?php echo "$selected_couleur1"; ?> value="SITE"> Couleur du site internet &nbsp;</option>
<option <?php echo "$selected_couleur2"; ?> value="DEFAUT"> Couleur par défaut &nbsp;</option>
</select>
</td>
</tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>
-->

<tr>
<td style='text-align: left;'>Mode de référence</td>
<td style='text-align: left;'>
<?php
if($MODE_REFERENCE_1_2_3 == "1"){
$selected_reference1 = "selected";
}elseif($MODE_REFERENCE_1_2_3 == "2"){
$selected_tvareference2 = "selected";
}elseif($MODE_REFERENCE_1_2_3 == "3"){
$selected_tvareference2 = "selected";
}
?>
<select class='form-control' name='MODE_REFERENCE_1_2_3'>
<option <?php echo "$selected_reference1"; ?> value="1"> Numéros qui se suivent &nbsp;</option>
<option <?php echo "$selected_reference2"; ?> value="2"> Date avec numéros qui se suivent &nbsp;</option>
<option <?php echo "$selected_reference3"; ?> value="3"> Date inversée avec numéros qui se suivent &nbsp;</option>
</select>
</td>
</tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>

<tr>
<td style='text-align: left;'>Taux TVA</td>
<td style='text-align: left;'>
<?php
if($Taux_tva == "0"){
$selected_tva1 = "selected";
}elseif($Taux_tva == "5.5"){
$selected_tva2 = "selected";
}elseif($Taux_tva == "10"){
$selected_tva3 = "selected";
}elseif($Taux_tva == "20"){
$selected_tva4 = "selected";
}
?>
<select class='form-control' name='Taux_tva'>
<option <?php echo "$selected_tva1"; ?> value="0"> Pas assujetti &nbsp;</option>
<option <?php echo "$selected_tva2"; ?> value="5.5"> 5.5% &nbsp;</option>
<option <?php echo "$selected_tva3"; ?> value="10"> 10% &nbsp;</option>
<option <?php echo "$selected_tva4"; ?> value="20"> 20% &nbsp;</option>
</select>
</td>
</tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>

<tr><td style='text-align: center;' colspan='2'><input id='configurations-pdf-bouton' class='form-control btn btn-success' type='submit' onclick='return false;' value='ENREGISTRER' style='width: 150px;' ></td></tr>
<tr><td style='text-align: left;'>&nbsp;</td></tr>

</table>
</form>

</div>

<?php
}
////////////////////////////////////////////////////////////////////////////////CONFIGURATIONS

//////////////////////////////////////////////////////////////Si pas d'action
if(!isset($action)){
?>

<!-- LISTE -->
<div id='liste'></div>

<?php
} 
?>

</div>

<?php
}else{
header('location: /index.html');
}
?>