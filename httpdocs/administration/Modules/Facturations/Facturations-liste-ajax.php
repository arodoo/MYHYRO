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
isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 4 ){

$idaction = $_POST['idaction'];

$recherche = $_POST['recherche'];

$post_statut_facture = $_POST['post_statut_facture'];
$post_statut_compte_facture = $_POST['post_statut_compte_facture'];
$type_service_produit = $_POST['type_service_produit'];

$now = time();
$now_1_mois = (86400*30);

//////////////////////////////////////Recherche par état
if($recherche == "etat"){
$_SESSION['recherche_actived_factureF'] = "oui";
$date_debut22 = mktime(0, 0, 0, intval($_POST['mois1']), intval($_POST['jour1']), intval($_POST['annee1']));
$date_fin22 = mktime(0, 0, 0, intval($_POST['mois2']), intval($_POST['jour2']), intval($_POST['annee2']));
$_SESSION['mois2_date_debut22_facture'] = "$date_debut22";
$_SESSION['mois2_date_fin22_facture'] = "$date_fin22";
$_SESSION['sql_date_docF'] = "date_edition BETWEEN '".$_SESSION['mois2_date_debut22_facture']."' AND '".$_SESSION['mois2_date_fin22_facture']."' AND ";
unset($_SESSION['recherche_facture_number']);
unset($_SESSION['sql_numero_docF']);
unset($_SESSION['sql_mots_cles_docF']);
}
//////////////////////////////////////Recherche par état

//////////////////////////////////////Recherche par mot clé
if(isset($_POST['recherche_mots_cles'])){
$_SESSION['recherche_mots_clesF'] = $_POST['recherche_mots_cles'];
$_SESSION['sql_mots_cles_docF'] = " ".$_SESSION['sql_date_docF']." REFERENCE_NUMERO LIKE '%".$_SESSION['recherche_mots_clesF']."%' || ".$_SESSION['sql_date_docF']." pseudo LIKE '%".$_SESSION['recherche_mots_clesF']."%' || ".$_SESSION['sql_date_docF']." numero_facture LIKE '%".$_SESSION['recherche_mots_clesF']."%' || ".$_SESSION['sql_date_docF']." Titre_facture  LIKE '%".$_SESSION['recherche_mots_clesF']."%' AND ";
unset($_SESSION['post_statut_facture']);
unset($_SESSION['recherche_facture_number']);
unset($_SESSION['id_commercial_postF']);
unset($_SESSION['sql_numero_docF']);
unset($_SESSION['sql_id_commercial_docF']);
}
//////////////////////////////////////Recherche par mot clé

//////////////////////////////////////Recherche par Commercial
if(!empty($_POST['recherche_commercial_post'])){
$_SESSION['id_commercial_postF'] = $_POST['id_commercial_post'];
if(!empty($_POST['id_commercial_post'])){
$_SESSION['sql_id_commercial_docF'] = " id_commercial='".$_SESSION['id_commercial_postF']."' AND ";
}else{
$_SESSION['sql_id_commercial_docF'] = "";
}
unset($_SESSION['recherche_facture_number']);
unset($_SESSION['recherche_mots_clesF']);
unset($_SESSION['sql_numero_docF']);
unset($_SESSION['sql_mots_cles_docF']);
}
//////////////////////////////////////Recherche par Commercial

//////////////////////////////////////Recherche statut facture
if(!empty($_POST['post_statut_facture'])){
$_SESSION['post_statut_facture'] = $_POST['post_statut_facture'];
if($_POST['post_statut_facture'] == "non payer" ){
$_SESSION['sql_statut_docF'] = " (Suivi='".$_SESSION['post_statut_facture']."' OR Suivi='' ) AND ";
}else{
$_SESSION['sql_statut_docF'] = " Suivi='".$_SESSION['post_statut_facture']."' AND ";
}
unset($_SESSION['recherche_mots_clesF']);
unset($_SESSION['recherche_facture_number']);
unset($_SESSION['sql_numero_docF']);
unset($_SESSION['sql_mots_cles_docF']);
}
//////////////////////////////////////Recherche statut facture

//////////////////////////////////////Recherche numéro facture
if(!empty($_POST['recherche_facture_number'])){
$_SESSION['recherche_facture_number'] = $_POST['recherche_facture_number'];
$_SESSION['sql_numero_docF'] = "REFERENCE_NUMERO='".$_SESSION['recherche_facture_number']."' AND ";
unset($_SESSION['mois2_date_debut22_facture']);
unset($_SESSION['mois2_date_fin22_facture']);
unset($_SESSION['recherche_mots_clesF']);
unset($_SESSION['post_statut_facture']);
unset($_SESSION['id_commercial_postF']);
unset($_SESSION['sql_date_docF']);
unset($_SESSION['sql_mots_cles_docF']);
unset($_SESSION['sql_statut_docF']);
unset($_SESSION['sql_id_commercial_docF']);
}
//////////////////////////////////////Recherche numéro facture

//SI PAS DE REQUETE
if(empty($_SESSION['sql_generale_facture']) && empty($_SESSION['sql_id_commercial_docF']) && empty($_SESSION['sql_numero_docF']) && empty($_SESSION['sql_statut_docF']) && empty($_SESSION['sql_date_docF']) && empty($_SESSION['sql_mots_cles_docF']) ){
$_SESSION['mois2_date_debut22_facture'] = (time()-((date('d', time())-1)*86400));
$_SESSION['mois2_date_fin22_facture'] = (time()+86400);
$_SESSION['sql_date_docF'] = "date_edition BETWEEN '".$_SESSION['mois2_date_debut22_facture']."' AND '".$_SESSION['mois2_date_fin22_facture']."' AND ";
}

//REQUÊTE SQL
$_SESSION['sql_generale_facture'] = " ".$_SESSION['sql_id_commercial_docF']." ".$_SESSION['sql_numero_docF']." ".$_SESSION['sql_statut_docF']." ".$_SESSION['sql_date_docF']." ".$_SESSION['sql_mots_cles_docF']." Type_compte_F=''";

$lasturrloo1114455 = $_SERVER['REQUEST_URI'];
$_SESSION['lasturrloo1111224455'] = $lasturrloo1114455;

	///////////////////////////////SELECT BOUCLE

	if(empty($_POST['idmembre'])){
		$req_boucle = $bdd->prepare("SELECT * FROM membres_prestataire_facture WHERE ".$_SESSION['sql_generale_facture']." ORDER BY date_edition ASC");
		$req_boucle->execute();
	}else{
		$req_boucle = $bdd->prepare("SELECT * FROM membres_prestataire_facture WHERE ".$_SESSION['sql_generale_facture']." AND id_membre=? ORDER BY date_edition ASC");
		$req_boucle->execute(array($_POST['idmembre']));
	}
	
	while($ligne_boucle = $req_boucle->fetch()){
	$id_facturecc = $ligne_boucle['id'];
	$date_editioncc = $ligne_boucle['date_edition'];
	$Tarif_HTcc = $ligne_boucle['Tarif_HT'];
	$Remisecc = $ligne_boucle['Remise'];
	$Tarif_HT_netcc = $ligne_boucle['Tarif_HT_net'];
	$Tarif_TTCcc = $ligne_boucle['Tarif_TTC'];
	$Total_Tvacc = $ligne_boucle['Total_Tva'];

        $Tarif_HT_netcc_total = ($Tarif_HT_netcc+$Tarif_HT_netcc_total);
        $Tarif_TTCcc_total = ($Tarif_TTCcc+$Tarif_TTCcc_total);
        $Total_Tvacc_total = ($Total_Tvacc+$Total_Tvacc_total);
	if(!empty($Total_Tvacc_total) && !empty($Remisecc) ){
        	$Remisecc_total = ($Remisecc+$Remisecc_total);
	}
        }
	$req_boucle->closeCursor();

if($Tarif_HT_netcc_total == "" || $Tarif_HT_netcc_total == "0"){
$Tarif_HT_netcc_total = "0";
}
if($Tarif_TTCcc_total == ""){
$Tarif_TTCcc_total = "0";
}
if($Total_Tvacc_total == ""){
$Total_Tvacc_total = "0";
}
if($Remisecc_total == ""){
$Remisecc_total = "0";
}

?>

<!--
<p style='text-align: left; margin-bottom: 10px;'><span style='color: green;'>Total HT: <?php echo round($Tarif_HT_netcc_total,2); ?>€ </span> - <span style='color: #3366FF;'>TOTAL TTC: <?php echo round($Tarif_TTCcc_total,2); ?>€ </span> - <span style='color: #FF6600;'>TOTAL TVA: <?php echo round($Total_Tvacc_total,2); ?>€ </span> - <span style='color: red;'>TOTAL REMISE: <?php echo round($Remisecc_total,2); ?>€ </span></p>
-->

<!--

<form id='recherche-etat' method='post' action='#' style='text-align: left;'>
<input id="action" type="hidden" name="recherche" value="etat" >

<div style='display: inline-block; margin-bottom: 10px;'>
<?php
echo "<select name='jour1' class='form-control' style='display: inline-block; margin-bottom: 10px; width: 100px;'>";
echo "<option value='' > Jour &nbsp; </option>";
for ($ie = 1 ; $ie <= 31 ; $ie++){
echo "<option value='$ie'";
if (!empty($_SESSION['mois2_date_debut22_facture']) && date("j", $_SESSION['mois2_date_debut22_facture']) == $ie){ echo " selected"; }
echo ">$ie &nbsp;&nbsp;</option>";
}
echo "</select>";
			
echo "<select name='mois1' class='form-control' style='display: inline-block; margin-bottom: 10px; width: 150px;' >";
echo "<option value='' > Mois &nbsp; </option>";
for ($iee = 1 ; $iee <= 12 ; $iee++){
echo "<option value='$iee'";
if (!empty($_SESSION['mois2_date_debut22_facture']) && date("n", $_SESSION['mois2_date_debut22_facture']) == $iee){ echo " selected"; }
echo ">".$mois_annee[$iee]."&nbsp;&nbsp;</option>";
}
echo "</select>";
			
$cette_annee_la = date("Y");
echo "<select name='annee1' class='form-control' style='display: inline-block; width: 100px;' >";
echo "<option value='' > Année &nbsp; </option>";
for ($iaa = $cette_annee_la-2 ; $iaa <= $cette_annee_la+10 ; $iaa++){
echo "<option value='$iaa'";
if (!empty($_SESSION['mois2_date_debut22_facture']) && date("Y", $_SESSION['mois2_date_debut22_facture']) == $iaa){ echo " selected"; }
echo ">$iaa &nbsp;&nbsp;</option>";
}
echo "</select>";
?>
</div>

<div style='display: inline-block; margin-bottom: 10px;'>
&nbsp; Entre &nbsp;
</div>

<div style='display: inline-block;'>
<?php
echo "<select name='jour2' class='form-control' style='display: inline-block; margin-bottom: 10px; width: 100px;'>";
echo "<option value='' > Jour &nbsp; </option>";
for ($iey = 1 ; $iey <= 31 ; $iey++){
echo "<option value='$iey'";
if (!empty($_SESSION['mois2_date_fin22_facture']) && date("j", $_SESSION['mois2_date_fin22_facture']) == $iey){ echo " selected"; }
echo ">$iey &nbsp;&nbsp;</option>";
}
echo "</select>";
			
echo "<select name='mois2' class='form-control' style='width: 150px; display: inline-block;' >";
echo "<option value='' > Mois &nbsp; </option>";
for ($ieey = 1 ; $ieey <= 12 ; $ieey++){
echo "<option value='$ieey'";
if (!empty($_SESSION['mois2_date_fin22_facture']) && date("n", $_SESSION['mois2_date_fin22_facture']) == $ieey){ echo " selected"; }
echo ">".$mois_annee[$ieey]."&nbsp;&nbsp;</option>";
}
echo "</select>";
			
$cette_annee_la = date("Y");
echo "<select name='annee2' class='form-control' style='margin-right: 10px; width: 100px; display: inline-block;'>";
echo "<option value='' > Année &nbsp; </option>";
for ($iaay = $cette_annee_la-2 ; $iaay <= $cette_annee_la+10 ; $iaay++){
echo "<option value='$iaay'";
if ( date("Y", $_SESSION['mois2_date_fin22_facture']) == $iaay){ echo " selected"; }
echo ">$iaay &nbsp;&nbsp;</option>";
}
echo "</select>";
?>

<input id='recherche-etat-bouton' data-formid='recherche-etat' type='submit' class='form-control btn btn-secondary' value='RECHERCHER' style='width: 150px;' onclick='return false;' />
</form>

</div>
<div style='clear: both;'></div>

<div style='text-align: left;'>

<?php
if($_SESSION['post_statut_facture'] == "payer"){
$selected33 = "selected='selected'";
}elseif($_SESSION['post_statut_facture'] == "non payer" || $_SESSION['post_statut_facture'] == "" ){
$selected44 = "selected='selected'";
}

?>

<div style='display: inline-block; margin-right: 10px; margin-bottom: 10px;'>
<form id='recherche-statut' method='post' action='#'>
<select class='form-control' name='post_statut_facture' style='margin-right: 10px; width: 205px; display: inline-block; '>
<option <?php echo "$selected33"; ?> value='payer'> Factures payées &nbsp; &nbsp; </option>
<option <?php echo "$selected44"; ?> value='non payer'> Factures non payées &nbsp; &nbsp; </option>
</select> 
<input id='recherche-statut-bouton' data-formid='recherche-statut' class='form-control btn btn-secondary' type='submit' value='RECHERCHER' onclick='return false;' style='width: 150px;' />
</form>
</div>

<div style='clear: both;'></div>

<div style='display: inline-block; margin-bottom: 10px; margin-right: 20px;'>
<form id='recherche-mots' method='post' action='#'>
<input class='form-control' type='text' id='recherche_mots_cles' name='recherche_mots_cles' placeholder="Recherche par mot clé" value="<?php echo $_SESSION['recherche_mots_clesF']; ?>" style='margin-right: 10px; width: 200px; display: inline-block;' onclick="document.getElementById(this.id).value='';"  />
<input id='recherche-mots-bouton' data-formid='recherche-mots' class='form-control btn btn-secondary' type='submit' value='RECHERCHER' style='width: 150px;' onclick='return false;' />
</form>
</div>

<div style='display: inline-block; margin-bottom: 10px;'>
<form id='recherche-numero' method='post' action='#'>
<input class='form-control' type='Text' id='recherche_facture_number' name='recherche_facture_number' placeholder="Numéro de facture" value="<?php echo $_SESSION['recherche_facture_number']; ?>"; style='margin-right: 10px; width: 200px; display: inline-block;' onclick="document.getElementById(this.id).value='';"/>
<input id='recherche-numero-bouton' data-formid='recherche-numero' class='form-control btn btn-secondary' type='submit' value='RECHERCHER' style='width: 150px;'onclick='return false;' />
</form>
</div>
<div style='clear: both; margin-bottom: 20px;'></div>

</div>
-->

<?php

$lasturrloo111 = $_SERVER['REQUEST_URI'];
$_SESSION['lasturrloo11112255541'] = $lasturrloo111;
?>

<?php
$nom_fichier = "Factures";
$nom_fichier_datatable = "Factures-".date('d-m-Y', time())."-$nomsiteweb"; 
?>
<script>
$(document).ready(function(){
    $('#Tableau_a').DataTable(
{
responsive: true,
stateSave: true,
"order": [],
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
    { "orderable": false, "targets": 7, },
    { "orderable": false, "targets": 8, },
  ],
"language": {
	"sProcessing":     "Traitement en cours...",
	"sSearch":         "Rechercher&nbsp;:",
    "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
	"sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
	"sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
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

///////////////CHAMPS DE RECHERCHE SUR COLONNE
    $('#Tableau_a tfoot .search_table').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" class="form-control" placeholder="'+title+'" style="width:100%; font-weight: normal;"/>' );
    } );
    var table = $('#Tableau_a').DataTable();
    table.columns().every( function () {
        var that = this;
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );

});
</script>

	<table id='Tableau_a' class="display nowrap" style="text-align: center; width: 100%; margin-top: 15px;" cellpadding="2" cellspacing="2">

<thead>
<tr>
<th scope="col" style="text-align: center;">N°</th>
<th style="text-align: center;" >CLIENT</th>
<th style="text-align: center;" >N°CLIENT</th>
<th style="text-align: center;" >STATUT</th>
<th style="text-align: center; width: 90px;">SUIVI</th>
<th style="text-align: center;">H.T</th>
<th style="text-align: center; width: 90px;" >DATE</th>
<th style="text-align: center; width: 90px;">PDF</th>
<th style="text-align: center; width: 90px;" >MODIFIER</th>
<!-- <th style="text-align: center; width: 90px;">SUPPRIMER</th> -->
</tr>
</thead>
<tfoot>
<tr>
<th class="search_table" style="text-align: center;">N°</th>
<th class="search_table" style="text-align: center;" >CLIENT</th>
<th class="search_table" style="text-align: center;" >N°CLIENT</th>
<th class="search_table" style="text-align: center;" >STATUT</th>
<th class="search_table" style="text-align: center; width: 90px;">SUIVI</th>
<th class="search_table" style="text-align: center;">H.T</th>
<th class="search_table" style="text-align: center; width: 90px;" >DATE</th>
<th style="text-align: center; width: 90px;">PDF</th>
<th style="text-align: center; width: 90px;" >MODIFIER</th>
<!-- <th style="text-align: center; width: 90px;">SUPPRIMER</th> -->
</tr>
</tfoot>
<tbody>

<?php

	///////////////////////////////SELECT BOUCLE
	if(empty($_POST['idmembre'])){
		$req_boucle = $bdd->prepare("SELECT * FROM membres_prestataire_facture ORDER BY date_edition ASC");
		$req_boucle->execute();
	}
	else{
		$req_boucle = $bdd->prepare("SELECT * FROM membres_prestataire_facture WHERE id_membre=? ORDER BY date_edition ASC");
		$req_boucle->execute(array($_POST['idmembre']));
	}

	
	while($ligne_boucle = $req_boucle->fetch()){
	$id_facture = $ligne_boucle['id'];
	$id_membre = $ligne_boucle['id_membre'];
	$id_membrepseudo = $ligne_boucle['pseudo'];
	$numero_facture = $ligne_boucle['numero_facture'];
	$Titre_facture = $ligne_boucle['Titre_facture'];
	$Contenu = $ligne_boucle['Contenu'];
	$Suivi = $ligne_boucle['Suivi'];
	$date_edition = $ligne_boucle['date_edition'];
	$date_edition = date('d-m-Y', $date_edition);
	$mod_paiement = $ligne_boucle['mod_paiement'];
	$Tarif_HT = $ligne_boucle['Tarif_HT'];
	$Remise = $ligne_boucle['Remise'];
	$Tarif_HT_net = $ligne_boucle['Tarif_HT_net'];
	if(empty($Tarif_HT_net)){
		$Tarif_HT_net = "0";
	}
	$Tarif_TTC = $ligne_boucle['Tarif_TTC'];
	$Total_Tva = $ligne_boucle['Total_Tva'];
	$taux_tva = $ligne_boucle['taux_tva'];
	$condition_reglement = $ligne_boucle['condition_reglement'];
	$delai_livraison = $ligne_boucle['delai_livraison'];
	$REFERENCE_NUMERO = $ligne_boucle['REFERENCE_NUMERO'];

	/*
	$Tarif_HT = ($PU_HTPU_HT*$quantite);
	$Tarif_HT_TOTAL = ($Tarif_HT+$Tarif_HT_TOTAL);
	$Tarif_HT_net = round(($Tarif_HT_TOTAL-$Remise),2);
	$Total_Tva = round(($Tarif_HT_net/100*20),2);
	$Tarif_TTC = ($Total_Tva+$Tarif_HT_net);
	*/

	if($Suivi == "payer"){
		$Suivi = "<b>Payée</b>";
	}elseif($Suivi == "non payer"){
		$Suivi = "Non payée";
	}
	$statut = $ligne_boucle['statut'];

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
	$numero_client = $ligne_select['numero_client'];
	$villem = $ligne_select['ville'];
	$IM = $ligne_select['IM'];
	$IM_REGLEMENT = $ligne_select['IM_REGLEMENT'];
	$telephonepost = $ligne_select['Telephone'];

if($_SESSION['Modification_facture'] == "$id_facture"){
$colorback = "background-color: $couleurbordure; color: black;";
$colorlien = "color: black;";
}

if(!empty($nomm) || !empty($prenomm) ){
$nom_prenom = "<b>(".$nomm." ".$prenomm.")</b>";
}

echo "<tr>
<td  style='text-align: center; width: 20px; ".$colorback."'><div id='ancre_p".$id_facture."'>$numero_facture</div></td>
<td style='text-align: center; ".$colorback."'>$id_membrepseudo ".$nom_prenom."</td>
<td style='text-align: center; ".$colorback."'>$numero_client</td>
<td style='text-align: center; ".$colorback."'>$statut</td>
<td style='text-align: center; ".$colorback."'>$Suivi</td>
<td style='text-align: center; ".$colorback."'>".$Tarif_HT_net."€</td>
<td style='text-align: center; ".$colorback."'>$date_edition</td>
<td style='text-align: center; ".$colorback."'>
<a href='/facture/".$numero_facture."/".$nomsiteweb."' target='_top' style='".$colorlien."'><span class='uk-icon-file-pdf-o' ></span></a>
</td>
<td style='text-align: center; ".$colorback."'><a target='_blank' href='?page=Facturations&amp;action=Facture&amp;idaction=".$id_facture."' style='".$colorlien."' ><span class='uk-icon-file-text' ></span></a></td>
<!-- <td style='text-align: center; ".$colorback."'><a class='lien-supprimer' href='?page=Facturations&amp;action=supprimer&amp;idaction=".$id_facture."' style='".$colorlien."' data-id='".$id_facture."' onclick='return false;' ><span class='uk-icon-times' ></span></a></td> -->
</tr>";
unset($colorlien);
unset($colorback);
}
$req_boucle->closeCursor();

echo '</tbody></table><br /><br />';

}else{
header('location: /index.html');
}

ob_end_flush();
?>