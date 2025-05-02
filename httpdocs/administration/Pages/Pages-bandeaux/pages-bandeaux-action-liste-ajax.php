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

$actionn = $_POST['actionn'];
$idactionn = $_POST['idactionn'];

$nom_fichier = "Bandeaux-pages";
$nom_fichier_datatable = "Bandeaux-pages-".date('d-m-Y', time())."-$nomsiteweb"; 
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
    { "orderable": false, "targets": 1, },
    { "orderable": false, "targets": 2, },
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
<th scope="col" style="text-align: center;">PAGE</th>
<th style="text-align: center;" >TYPE BANDEAU</th>
<th style="text-align: center;" >ICÔNE</th>
<th style="text-align: center;" >ACTIVER</th>
<th style="text-align: center; width: 90px;" >MODIFIER</th>
<th style="text-align: center; width: 90px;">SUPPRIMER</th>
</tr>
</thead>
<tfoot>
<tr>
<th class="search_table" style="text-align: center;">PAGE</th>
<th class="search_table" style="text-align: center;" >TYPE BANDEAU</th>
<th class="search_table" style="text-align: center;" >ICÔNE</th>
<th class="search_table" style="text-align: center;" >ACTIVER</th>
<th style="text-align: center; width: 90px;" >MODIFIER</th>
<th style="text-align: center; width: 90px;">SUPPRIMER</th>
</tr>
</tfoot>
<tbody>

<?php

///////////////////////////////SELECT BOUCLE
$req_boucle = $bdd->prepare("SELECT * FROM pages_bandeaux order by page_bandeau DESC");
$req_boucle->execute();
while($ligne_boucle = $req_boucle->fetch()){
$id = $ligne_boucle['id'];
$page_bandeau = $ligne_boucle['page_bandeau'];
$activer_bandeau_page = $ligne_boucle['activer_bandeau_page'];
$type_bandeau_page = $ligne_boucle['type_bandeau_page'];
$type_cible_page = $ligne_boucle['type_cible_page'];
$type_icone_page = $ligne_boucle['type_icone_page'];
$contenu_bandeau_page = $ligne_boucle['contenu_bandeau_page'];

?>
<tr>
<td style="text-align: center;"><a href='/<?php echo "$page_bandeau"; ?>' target='_top' style='<?php echo "$colorlien"; ?>' ><?php echo "$page_bandeau"; ?></a></td>
<td style="text-align: center;"><?php echo "$type_bandeau_page"; ?></td>
<td style="text-align: center;"><?php echo "<span class='".$type_icone_page."'></span>"; ?></td>
<td style="text-align: center;"><?php echo "$activer_bandeau_page"; ?></td>
<td style="text-align: center; width: 90px;"><?php echo "<a href='?page=Pages-bandeaux&amp;action=Modifier&amp;idaction=".$id."' style='".$colorback."'><span class='uk-icon-file-text' ></span></a>"; ?></td>
<td style="text-align: center; width: 90px;">
<?php echo "<a class='lien-supprimer-pages' href='?page=Pages-bandeauxs&amp;action=Supprimer&amp;idaction=".$id."' style='".$colorback."' data-id='".$id."' onclick='return false;' ><span class='uk-icon-times'></span></a>"; ?>
</td>
</tr>
<?php
}
$req_boucle->closeCursor();
?>
</tbody></table><br />

<?php

}else{
header('location: /index.html');
}

ob_end_flush();
?>