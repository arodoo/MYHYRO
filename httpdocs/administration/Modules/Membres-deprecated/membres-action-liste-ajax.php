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
<th scope="col" style="text-align: center;">NOM PRENOM</th>
<th style="text-align: center;" >N°CLIENT</th>
<th style="text-align: center;" >E-MAIL/TEL</th>
<th style="text-align: center;" >ACTIF</th>
<th style="text-align: center;" >ABONNEMENT</th>
<th style="text-align: center; width: 100px;">GESTION</th>
</tr>
</thead>
<tfoot>
<tr>
<th class="search_table" style="text-align: center;" >NOM PRENOM</th>
<th class="search_table" style="text-align: center;" >N°CLIENT</th>
<th class="search_table" style="text-align: center;" >E-MAIL/TEL</th>
<th class="search_table" style="text-align: center;" >ACTIF</th>
<th class="search_table" style="text-align: center;" >ABONNEMENT</th>
<th style="text-align: center; width: 90px;">GESTION</th>
</tr>
</tfoot>
<tbody>

<?php
	///////////////////////////////SELECT BOUCLE
	$req_boucle = $bdd->prepare("SELECT * FROM membres ".$_SESSION['recherche_par_type_WHERE']." ORDER BY id DESC");
	$req_boucle->execute();
	while($ligne_boucle = $req_boucle->fetch()){
	$idd = $ligne_boucle['id']; 
  	$log = $ligne_boucle['pseudo'];
  	$parrain = $ligne_boucle['numero_parrain'];
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
 	$compte_bloque = $ligne_boucle['compte_bloque'];
 	$demande_de_suppression = $ligne_boucle['demande_de_suppression'];
 	$demande_de_suppression_date = $ligne_boucle['demande_de_suppression_date'];
 	$datenaissance = date('d/m/Y', (int) $ligne_boucle['datenaissance']);
 	$supprimer = $ligne_boucle['supprimer'];
 	$supprimer_date = $ligne_boucle['supprimer_date'];
	if(!empty($supprimer_date)){ $supprimer_date = date('d-m-Y', $supprimer_date); }

	$numero_client = $ligne_boucle['numero_client'];
	$Abonnement_id = $ligne_boucle['Abonnement_id'];
	$Abonnement_date  = $ligne_boucle['Abonnement_date'];
	$Abonnement_date_expiration = $ligne_boucle['Abonnement_date_expiration'];

	if($Abonnement_date_expiration > time() ){
		$nbr_jour_abonnement = ($Abonnement_date_expiration-time());
		if($nbr_jour_abonnement > 86400){
			$nbr_jour_abonnement = ($nbr_jour_abonnement/86400);
		}
		$nbr_jour_abonnement = round($nbr_jour_abonnement);
		if($nbr_jour_abonnement > 1){
			$nbr_jour_abonnement = "$nbr_jour_abonnement Jours";
		}else{
			$nbr_jour_abonnement = "1 Jour";
		}
	}else{
		$nbr_jour_abonnement = "0 Jours";
	}

	if(!empty($Abonnement_date)){ 
		$Abonnement_date = date ('d-m-Y', $Abonnement_date );
	}else{
		$Abonnement_date = "-";
	}
	if(!empty($Abonnement_date_expiration)){ 
		$Abonnement_date_expiration = date ('d-m-Y', $Abonnement_date_expiration);
	}else{
		$Abonnement_date_expiration = "";
	}

	$req_selecta = $bdd->prepare("SELECT * FROM configurations_abonnements WHERE id=?");
	$req_selecta->execute(array($Abonnement_id));
	$ligne_selecta = $req_selecta->fetch();
	$req_selecta->closeCursor();
	$nom_abonnement = $ligne_selecta['nom_abonnement']; 
	if(empty($nom_abonnement)){
		$nom_abonnement = "<span class='label label-danger' >Il n'y a pas d'abonnement</span>";
	}

	///////////////////////////////SELECT
	$req_select = $bdd->prepare("SELECT * FROM membres_type_de_compte WHERE id=?");
	$req_select->execute(array($statut_compt));
	$ligne_select = $req_select->fetch();
	$req_select->closeCursor();
	$Nom_type = $ligne_select['Nom_type']; 

	if($compte_bloque == "oui"){
		$compte_bloque_rapport = "oui";
	}else{
		$compte_bloque_rapport = "--";
	}

echo "<tr><td style='text-align: center;'>$prenomm $nomm($log)";
if($supprimer == "oui"){
	echo "<span class='label label-danger' style='margin-right: 5px;' >Compte supprimé</span>";
	echo "<span class='label label-danger'>Le $supprimer_date</span>";
	echo "<br />";
}
echo "</td>";
?>
<td style='text-align: center;'> <?php echo "$numero_client";  ?> </td>
<td style='text-align: center;'>
<?php 
if($demande_de_suppression == "oui"){
	echo "<span class='label label-danger' style='margin-right: 5px;' >Demande de suppression</span>";
	echo "<span class='label label-danger'>Le ".date('d-m-Y à H:i', $demande_de_suppression_date)."</span><br />";
} 
echo "$email <br /> $telephoneposportable";  ?>
</td>
<?php
echo "<td style='text-align: center;'>$ActiverActiver</td> 
<td style='text-align: center;'><b>$nom_abonnement</b> <br /> $Abonnement_date_expiration</td> 
<td style='text-align: center;'>
<a href='?page=Membres-logs&idaction=".$idd."' title='Logs du membre' data-id='".$idd."' ><span class='uk-icon-file-text-o' ></span></a> &nbsp; &nbsp;
<a href='?page=Membres&amp;action=Modifier&amp;idaction=".$idd."' title='Modifier' data-id='".$idd."' ><span class='uk-icon-file-text' ></span></a> &nbsp; &nbsp;
<a href='#' class='connection-compte-membre' title='Connection' data-id='" . $idd . "' onclick='return false;' ><span class='uk-icon-user' ></span></a> &nbsp;
<a data-id='".$idd."' href='?page=Membres&amp;action=supprimer&idaction=".$idd."' ><span class='uk-icon-times' ></span></a>
</td>

</tr>";
}
$req_boucle->closeCursor();

echo '</tbody></table><br /><br />';

}else{
header('location: /index.html');
}

ob_end_flush();
?>