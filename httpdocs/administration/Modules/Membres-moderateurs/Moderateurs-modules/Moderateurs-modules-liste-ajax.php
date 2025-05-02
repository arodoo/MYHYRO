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

$nom_fichier = "Modules-moderateurs-liste";
$nom_fichier_datatable = "Modules-moderateurs-liste-".date('d-m-Y', time())."-$nomsiteweb"; 
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
    { "orderable": false, "targets": 2, },
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
<th style="text-align: center;" >NOM</th>
<th style="text-align: center;">URL</th>
<th style="text-align: center; width: 90px;" >ASSOCIATIONS GROUPES</th>
<th style="text-align: center; width: 90px;" >LIEN</th>
<th style="text-align: center; width: 90px;">SUPPRIMER</th>
</tr>
</thead>
<tfoot>
<tr>
<th style="text-align: center;">ID</th>
<th style="text-align: center;" >NOM</th>
<th style="text-align: center;">URL</th>
<th style="text-align: center; width: 90px;" >ASSOCIATIONS GROUPES</th>
<th style="text-align: center; width: 90px;" >LIEN</th>
<th style="text-align: center; width: 90px;">SUPPRIMER</th>
</tr>
</tfoot>
<tbody>

<?php
///////////////////////////////SELECT BOUCLE
$req_boucle = $bdd->prepare("SELECT * FROM configuration_membres_moderateurs_modules_liste ORDER BY id ASC");
$req_boucle->execute();
while($ligne_boucle = $req_boucle->fetch()){
$idoneinfos = $ligne_boucle['id'];
$nom_module_moderateur = $ligne_boucle['nom_module_moderateur'];
$url_page_module_moderateur = $ligne_boucle['url_page_module_moderateur'];

?>
<tr>
<td style="text-align: center;"><?php echo "$idoneinfos"; ?></td>
<td style="text-align: center;"> <?php echo "$nom_module_moderateur"; ?></td>
<td style="text-align: center;"> <a href='?page=<?php echo "$url_page_module_moderateur"; ?>' target='top_'><?php echo "$url_page_module_moderateur"; ?></a></td>
<td style="text-align: center; width: 90px;"><?php echo "<a class='associer-groupe-liste' href='#' data-id='".$idoneinfos."' onclick='return false;' ><span class='uk-icon-users' ></span></a>"; ?></td>
<td style="text-align: center; width: 90px;"> <a href='?page=<?php echo "$url_page_module_moderateur"; ?>' target='top_'><span class='uk-icon-link' ></span></a></td>
<td style="text-align: center; width: 90px;"><?php echo "<a class='supprimer-module-moderateur-liste' href='#' data-id='".$idoneinfos."' onclick='return false;' ><span class='uk-icon-times' ></span></a>"; ?></td>
</tr>
<?php
}
$req_boucle->closeCursor();
?>

</tbody></table><br /><br />

<!-- Modal PACK ICÔNES -->
<div class="modal" id="association-groupe-module-jquery" tabindex="association-groupe-module-jquery" role="dialog" aria-labelledby="myModalLabelassociation-groupe-module-jquery" aria-hidden="true" style='z-index:9999; text-align: center;'>
  <div class="modal-dialog" style='z-index:9999;'>
    <div class="modal-content">
	<!-- FORMULAIRE VALIDATION -->
      <div class="modal-header" style='text-align: left;'>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h2 class="modal-title" style="color: white !important; text-transform: uppercase; font-size: 20px;" ><?php echo "ASSOCIATION DES GROUPES"; ?></h2>
      </div>
      <div class="modal-body" style="text-align:left;" >

<div id='liste-groupes-associes-module' style="max-width: 100%;"></div>

	</div>
      </div>
    </div>
   </div>


<?php
}else{
header('location: /index.html');
}

ob_end_flush();
?>