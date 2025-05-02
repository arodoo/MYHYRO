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

$action = $_POST['action'];
$idaction = $_POST['idaction'];
$actionn = $_POST['actionn'];

$now = time();

?>

<?php
$nom_fichier = "Codes-de-promotion";
$nom_fichier_datatable = "Codes-de-promotion-".date('d-m-Y', time())."-$nomsiteweb"; 
?>
<script>
$(document).ready(function(){
    $('#Tableau_a').DataTable(
{
"order": [],
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
    { "orderable": false, "targets": 4, },
    { "orderable": false, "targets": 5, },
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

<table id='Tableau_a' class="display" style="text-align: center; width: 100%; margin-top: 15px; " cellpadding="2" cellspacing="2">

<thead>
<tr scope="col" ><th style="text-align: center;">TITRE</th>
<th style="text-align: center; width: 90px;" >CODE</th>
<th style="text-align: center; width: 90px;">CODE LIMITE</th>
<th style="text-align: center;">CODE UTILISES</th>
<th style="text-align: center; width: 90px;" >MODIFIER</th>
<th style="text-align: center; width: 90px;">SUPPRIMER</th>
</tr>
</thead>
<tfoot>
<tr>
<th style="text-align: center;">TITRE</th>
<th style="text-align: center; width: 90px;" >CODE</th>
<th style="text-align: center; width: 90px;">CODE LIMITE</th>
<th style="text-align: center;">CODE UTILISES</th>
<th style="text-align: center; width: 90px;" >MODIFIER</th>
<th style="text-align: center; width: 90px;">SUPPRIMER</th>
</tr>
</tfoot>
<tbody>

<?php
	///////////////////////////////SELECT BOUCLE
	$req_boucle = $bdd->prepare("SELECT * FROM codes_promotion");
	$req_boucle->execute();
	while($ligne_boucle = $req_boucle->fetch()){
	$idd = $ligne_boucle['id']; 
	$Titre_promo = $ligne_boucle['Titre_promo'];
	$numero_code = $ligne_boucle['numero_code'];
	$nbr_utilisation_fin = $ligne_boucle['nbr_utilisation_fin'];
	$nbr_utilisation_en_cours = $ligne_boucle['nbr_utilisation_en_cours'];
	$date_debut = $ligne_boucle['date_debut'];
	if(!empty($date_debut)){
	$date_debut_2 = date('d-m-Y', $date_debut);
	}
	$date_fin = $ligne_boucle['date_fin'];
	if(!empty($date_fin)){
	$date_fin_2 = date('d-m-Y', $date_fin);
	}

if($nbr_utilisation_fin == $nbr_utilisation_en_cours || $nbr_utilisation_en_cours > $nbr_utilisation_fin || $now > $date_fin){
$color_etat = "color: red;";
$code_finioo = "oui";
$code_ouvert = "";
$code_a_venir = "";

}elseif($date_debut > $now){
$color_etat = "color: ;";
$code_finioo = "";
$code_ouvert = "";
$code_a_venir = "oui";

}else{
$color_etat = "color: green;";
$code_finioo = "";
$code_ouvert = "oui";
$code_a_venir = "";
}

if($code_finioo == "oui" && $_SESSION['codepromostatut'] == "2" || $code_ouvert == "oui" && $_SESSION['codepromostatut'] == "1" ||  $code_a_venir == "oui" && $_SESSION['codepromostatut'] == "3" || !isset($_SESSION['codepromostatut'])){
$ok_resultat = "oui";
echo "<tr class='odd' >
<td class='dtr-control' style='text-align: center; $color_etat '>$Titre_promo</td>
<td style='text-align: center; ".$color_etat."'>$numero_code</td>
<td style='text-align: center; ".$color_etat."'>$nbr_utilisation_fin</td>
<td style='text-align: center; ".$color_etat."'>$nbr_utilisation_en_cours</td>
<td style='text-align: center;'><a style='".$color_etat."' href='?page=Codes-promotion&amp;action=Modifier&amp;idaction=".$idd."'><span class='uk-icon-file-text' ></span></a></td>
<td style='text-align: center; width: 90px;'><a id='btnSupprModal' style='".$color_etat."' data-id='".$idd."' href='#' ><span class='uk-icon-times' ></span></a></td></tr>";

/*echo "<div class='modal fade' id='".$idd."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
  <div class='modal-dialog' role='document'>
    <div class='modal-content'>
      <div class='modal-header'>
        <b class='modal-title' id='exampleModalLabel'>Supprimer le code promo</b>
        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>
      <div class='modal-body'>
        Etes-vous sûr de vouloir supprimer ce code promo ?
      </div>
      <div class='modal-footer'>
        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Non</button>
        <button type='button' class='btn btn-primary'><a class='lien-supprimer-codes-promotions' href='?page=Codes-promotion&amp;action=Supprimer&amp;idaction=".$idd."' data-id='".$idd."' ><span onclick='javascript:history.go(-1);' >Oui</span></a></button>
      </div>
    </div>
  </div>
</div>";*/

}
}
$req_boucle->closeCursor();

if(!isset($ok_resultat)){
echo "<tr><td style='text-align: center;' colspan='10'>Aucun enregistrement disponible pour le moment !</td></tr>";
}

?>
</tbody></table>
<p style='text-align: left;'><i><span style='color: red;'>-- Code promo fini</span> <span style='color: green;'>-- Code promo ouvert</span> <span>-- Code promo à venir</span></i> </p><br /><br />

<?php
}else{
header('location: /index.html');
}

ob_end_flush();
?>