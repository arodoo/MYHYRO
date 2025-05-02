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
isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 4 ){

?>

<?php
$nom_fichier = "Nom-groupe-moderateur";
$nom_fichier_datatable = "Nom-groupe-moderateur-".date('d-m-Y', time())."-$nomsiteweb"; 
?>
<script>
$(document).ready(function(){
    $('#Tableau_a').DataTable(
{
responsive: true,
stateSave: true,
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
    { "orderable": false, "targets": 3, },
    { "orderable": false, "targets": 4, },
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
});
</script>

	<table id='Tableau_a' class="display nowrap" style="text-align: center; width: 100%; margin-top: 15px;" cellpadding="2" cellspacing="2">

<thead>
<tr>
<th scope="col" style="text-align: center;">ID</th>
<th style="text-align: center;" >NOM GROUPE</th>
<th style="text-align: center;">ACTIVER</th>
<th style="text-align: center; width: 90px;" >MODIFIER</th>
<th style="text-align: center; width: 90px;">SUPPRIMER</th>
</tr>
</thead>
<tfoot>
<tr>
<th style="text-align: center;">ID</th>
<th style="text-align: center;" >NOM GROUPE</th>
<th style="text-align: center;">ACTIVER</th>
<th style="text-align: center; width: 90px;" >MODIFIER</th>
<th style="text-align: center; width: 90px;">SUPPRIMER</th>
</tr>
</tfoot>
<tbody>

<?php
///////////////////////////////SELECT BOUCLE
$req_boucle = $bdd->prepare("SELECT * FROM configuration_membres_moderateurs_groupes ORDER BY id ASC");
$req_boucle->execute();
while($ligne_boucle = $req_boucle->fetch()){
$idoneinfos = $ligne_boucle['id'];
$nom_groupe_moderateur = $ligne_boucle['nom_groupe_moderateur'];
$activer_groupe_moderateur = $ligne_boucle['activer_groupe_moderateur'];

?>
<tr>
<td style="text-align: center;"><?php echo "$idoneinfos"; ?></td>
<td style="text-align: center;"><?php echo "$nom_groupe_moderateur"; ?></td>
<td style="text-align: center;"><?php echo "$activer_groupe_moderateur"; ?></td>
<?php
if($idoneinfos != 1 || $idoneinfos != 2){
?>
<td style="text-align: center; width: 90px;"><?php echo "<a href='?page=Moderateurs-groupes&amp;action=Modifier&amp;idaction=".$idoneinfos."'><span class='uk-icon-file-text' ></span></a>"; ?></td>
<td style="text-align: center; width: 90px;"><?php echo "<a class='supprimer-Moderateurs-groupes-liste' href='#' data-id='".$idoneinfos."' onclick='return false;' ><span class='uk-icon-times' ></span></a>"; ?></td>
<?php
}else{
?>
<td style="text-align: center; width: 90px;">--</td>
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

<?php
}else{
header('location: /index.html');
}

ob_end_flush();
?>