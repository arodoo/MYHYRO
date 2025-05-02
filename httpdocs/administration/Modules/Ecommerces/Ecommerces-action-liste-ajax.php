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
isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 2 ||
isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 3 ){

?>

<div style='clear: both;'></div>

<?php
$nom_fichier = "Categories";
$nom_fichier_datatable = "Categories-".date('d-m-Y', time())."-$nomsiteweb"; 
?>
<script>
$(document).ready(function(){
    $('#Tableau_a').DataTable(
{
responsive: true,
stateSave: true,
dom: 'Bftipr',
"order": [],
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
                that.search( this.value )
                    .draw();
            }
        } );
    } );

});
</script>

	<table id='Tableau_a' class="display nowrap" style="text-align: center; width: 100%; margin-top: 15px;" cellpadding="2" cellspacing="2">

<thead>
<tr>
	<th scope="col" style="text-align: center;">CATEGORIE</th>
	<th style="text-align: center;" >TITRE</th>
	<th style="text-align: center;" >ACTIF</th>
	<th style="text-align: center; width: 90px;" >MODIFIER</th>
	<th style="text-align: center; width: 90px;">SUPPRIMER</th>
</tr>
</thead>
<tfoot>
<tr>
	<th scope="col" class="search_table" style="text-align: center;">CATEGORIE</th>
	<th style="text-align: center;"class="search_table" >TITRE</th>
	<th style="text-align: center;"class="search_table" >ACTIF</th>
	<th style="text-align: center; width: 90px;" >MODIFIER</th>
	<th style="text-align: center; width: 90px;">SUPPRIMER</th>
</tr>
</tfoot>

<tbody>

<?php
	///////////////////////////////SELECT BOUCLE
	$req_boucle = $bdd->prepare("SELECT * FROM categories_liens ORDER BY nom ASC");
	$req_boucle->execute();
	while($ligne_boucle = $req_boucle->fetch()){
	$idd = $ligne_boucle['id']; 
  	$nom = $ligne_boucle['nom'];
  	$lien = $ligne_boucle['lien'];
	$activer = $ligne_boucle['activer'];
	$id_categorie = $ligne_boucle['id_categorie'];
  
	///////////////////////////////SELECT
	$req_select = $bdd->prepare("SELECT * FROM categories WHERE id=?");
	$req_select->execute(array($id_categorie));
	$ligne_select = $req_select->fetch();
	$req_select->closeCursor();
	$nom_categorie = $ligne_select['nom_categorie'];

echo "<tr>";
echo "<td style='text-align: center;'>$nom_categorie</td> 
<td style='text-align: center;'>$nom</td>";
echo "<td style='text-align: center;'>$activer</td> 
<td style='text-align: center;'><a href='?page=Ecommerces&amp;action=Modifier&amp;idaction=".$idd."' title='Modifier' data-id='".$idd."' ><span class='uk-icon-file-text' ></span></a></td>
<td style='text-align: center; width: 90px;'><a id='btnSupprModal' data-id='".$idd."' href='#' ><span class='uk-icon-times' ></span></a></td>";
echo "</tr>";
}
$req_boucle->closeCursor();

echo '</tbody></table><br /><br />';

}else{
header('location: /index.html');
}

ob_end_flush();
?>