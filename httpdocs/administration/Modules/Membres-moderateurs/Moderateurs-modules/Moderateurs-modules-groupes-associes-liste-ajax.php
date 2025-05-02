<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../../../Configurations_bdd.php');
require_once('../../../../Configurations.php');
require_once('../../../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction= "../../../../";
require_once('../../../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

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
isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 2 ||
isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 3 ){

?>

<div style='clear: both;'></div>

<script>
$(document).ready(function(){
    $('#Tableau_b').DataTable(
{
        columnDefs: [ {
            visible: false
       } ],
  "columnDefs": [
    { "orderable": false, "targets": 2, },
  ],
"bPaginate": false,
"bFilter": false,
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
});
</script>

<?php
///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM configuration_membres_moderateurs_modules_liste WHERE id=?");
$req_select->execute(array($_POST['idaction']));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$id_module_selectionne = $ligne_select['id'];
$nom_module_moderateur = $ligne_select['nom_module_moderateur'];
$url_page_module_moderateur = $ligne_select['url_page_module_moderateur'];
?>

<form id='formulaire-associaion-groupe-module' method='post' action='#'>

<div style='text-align: left;' >
<h2>Module : <?php echo "$nom_module_moderateur"; ?></h2>
</div>

<input id="action" type="hidden" name="action" value="Modifier-action" >
<input id="idaction" type="hidden" name="idaction" value="<?php echo $_POST['idaction']; ?>" >

<table id='Tableau_b' class="display" style="text-align: center; width: 100%; margin-top: 15px;" cellpadding="2" cellspacing="2">

<thead>
<tr>
<th style="text-align: center;">ID</th>
<th style="text-align: center;" >NOM GROUPE</th>
<th style="text-align: center; width: 90px;" >ASSOCIE</th>
</tr>
</thead>
<tfoot>
<tr>
<th style="text-align: center;">ID</th>
<th style="text-align: center;" >NOM GROUPE</th>
<th style="text-align: center; width: 90px;" >ASSOCIE</th>
</tr>
</tfoot>
<tbody>

<?php
///////////////////////////////SELECT BOUCLE
$req_boucle = $bdd->prepare("SELECT * FROM configuration_membres_moderateurs_groupes WHERE activer_groupe_moderateur='oui'");
$req_boucle->execute();
while($ligne_boucle = $req_boucle->fetch()){
$idoneinfos = $ligne_boucle['id'];
$nom_groupe_moderateur = $ligne_boucle['nom_groupe_moderateur'];
$activer_groupe_moderateur = $ligne_boucle['activer_groupe_moderateur'];

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM configuration_membres_moderateurs_groupes_modules WHERE id_groupe=? AND id_module=? ORDER BY id ASC");
$req_select->execute(array($idoneinfos,$_POST['idaction']));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$id_groupe_module = $a_groupes['id'];
$id_groupe = $a_groupes['id_groupe'];
$id_module = $a_groupes['id_module'];
$activer = $a_groupes['activer'];

?>
<tr>
<td style="text-align: center;"><?php echo "$idoneinfos"; ?></td>
<td style="text-align: center;"><?php echo "$nom_groupe_moderateur"; ?></td>
<?php
if($idoneinfos != 1 && $idoneinfos != 2){
?>
<td style="text-align: center;"><input type='checkbox' name='associer_groupe_id[]' <?php if(!empty($id_groupe_module)){ echo "checked"; } ?> value='<?php echo "$idoneinfos"; ?>'></td>
<?php
}else{
?>
<td style="text-align: center; width: 90px;">--</td>
<?php
}
?>
</tr>
<?php
}
$req_boucle->closeCursor();
?>

</tbody></table><br /><br />

<div style='text-align: center;' >
<button id='bouton-formulaire-associaion-groupe' type='button' data-id='<?php echo $_POST['idaction']; ?>' class='btn btn-success' onclick="return false;" >ENREGISTRER</button>
</div>

</form>

<?php
}else{
header('location: /index.html');
}

ob_end_flush();
?>