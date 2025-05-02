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

<?php
$nom_fichier = "Membres";
$nom_fichier_datatable = "Membres-".date('d-m-Y', time())."-$nomsiteweb"; 
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
<th scope="col" style="text-align: center;" >GROUPE MODERATEUR</th>
<th style="text-align: center;">PSEUDO</th>
<th style="text-align: center;" >E-MAIL</th>
<th style="text-align: center; width: 90px;" >MODIFIER</th>
<th style="text-align: center; width: 90px;">DESACTIVER</th>
</tr>
</thead>
<tfoot>
<tr>
<th style="text-align: center;" >GROUPE MODERATEUR</th>
<th class="search_table" style="text-align: center;">PSEUDO</th>
<th class="search_table" style="text-align: center;" >E-MAIL</th>
<th style="text-align: center; width: 90px;" >MODIFIER</th>
<th style="text-align: center; width: 90px;">DESACTIVER</th>
</tr>
</tfoot>
<tbody>

<?php
	///////////////////////////////SELECT BOUCLE
	$req_boucle = $bdd->prepare("SELECT * FROM membres WHERE admin > 0 ORDER BY pseudo ASC");
	$req_boucle->execute();
	while($ligne_boucle = $req_boucle->fetch()){
	$idd = $ligne_boucle['id']; 
	$log = $ligne_boucle['pseudo'];
	$email = $ligne_boucle['mail'];
	$adm = $ligne_boucle['admin'];
	$nomm = $ligne_boucle['nom'];
	$prenomm = $ligne_boucle['prenom'];
        $adressem = $ligne_boucle['adresse'];
        $statut_compt = $ligne_boucle['statut_compte'];
        $ActiverActiver = $ligne_boucle['Activer'];
	$telephoneposportable = $ligne_boucle['Telephone_portable'];
	$FH = $ligne_boucle['civilites'];
 	$faxpost = $ligne_boucle['Fax'];

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM configuration_membres_moderateurs_groupes WHERE id=?");
$req_select->execute(array($adm));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$idoneinfos = $a['id'];
$nom_groupe_moderateur = $ligne_select['nom_groupe_moderateur'];
$ligne_selectctiver_groupe_moderateur = $ligne_select['activer_groupe_moderateur'];

echo "<tr><td style='text-align: center;'>$nom_groupe_moderateur</td>
<td style='text-align: center;'>$log</td>
<td style='text-align: center;'>$email</td>
<td style='text-align: center;'><a href='?page=Membres&amp;action=modifier&amp;idaction=".$idd."' title='Modifier' data-id='".$idd."' target='top_' ><span class='uk-icon-file-text' ></span></a></td>";
echo "<td style='text-align: center;'><a class='supprimer-moderateur' href='#' title='Désactiver' data-id='".$idd."' onclick='return false;' ><span class='uk-icon-times' ></span></a></td></tr>";
}
$req_boucle->closeCursor();

if(!isset($idd)){
echo "<tr><td style='text-align: center; height: 10px;' colspan='10'>Aucun enregistrement disponible pour le moment !</td></tr>";
}

echo '</tbody></table><br /><br />';

}else{
header('location: /index.html');
}

ob_end_flush();
?>