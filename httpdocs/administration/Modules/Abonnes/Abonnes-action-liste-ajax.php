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
$nom_fichier = "Abonnes";
$nom_fichier_datatable = "Abonnes-".date('d-m-Y', time())."-$nomsiteweb"; 
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
<th style="text-align: center;" >ABONNEMENT</th>
<th style="text-align: center;" >STATUT</th>
<th style="text-align: center; width: 236px;" >MOYEN PAIEMENT</th>
<th style="text-align: center; width: 236px;" >DATE DE PAIEMENT</th>
<th style="text-align: center;" >EXPIRATION</th>
<th  style="text-align: center;" >JOURS RESTANT</th>
<th style="text-align: center; width: 90px;" >MODIFIER</th>
</tr>
</thead>
<tfoot>
<tr>
<th class="search_table" style="text-align: center;">NOM PRENOM</th>
<th class="search_table" style="text-align: center;" >ABONNEMENT</th>
<th class="search_table" style="text-align: center;" >STATUT</th>
<th class="search_table" style="text-align: center;width: 236px;" >MOYEN PAIEMENT</th>
<th class="search_table" style="text-align: center; width: 236px;" >DATE DE PAIEMENT</th>
<th class="search_table" style="text-align: center;" >EXPIRATION</th>
<th class="search_table" style="text-align: center;" >JOURS RESTANT</th>
<th style="text-align: center; width: 90px;" >MODIFIER</th>
</tr>
</tfoot>
<tbody>

<?php
	///////////////////////////////SELECT BOUCLE
	$req_boucle = $bdd->prepare("SELECT * FROM membres ORDER BY Abonnement_dernier_demande_date DESC");
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

 	$Abonnement_id = $ligne_boucle['Abonnement_id'];
 	$Abonnement_date = $ligne_boucle['Abonnement_date'];
	if(!empty($Abonnement_date)){ $Abonnement_date = date('d-m-Y', $Abonnement_date); }
 	$Abonnement_date_expiration = $ligne_boucle['Abonnement_date_expiration'];
	if(!empty($Abonnement_date_expiration)){ $Abonnement_date_expiration = date('d-m-Y', $Abonnement_date_expiration); }
 	$Abonnement_mode_paye = $ligne_boucle['Abonnement_mode_paye'];
 	$Abonnement_paye = $ligne_boucle['Abonnement_paye'];
	if($Abonnement_paye == "oui"){
		$Abonnement_paye = "<span class='label label-success' >Payé</span>";
	}else{
		$Abonnement_paye = "<span class='label label-danger' >Non payé</span>";
	}
 	$Abonnement_date_paye = $ligne_boucle['Abonnement_date_paye'];
	if(!empty($Abonnement_date_paye)){
		$Abonnement_date_paye = date('d-m-Y', $Abonnement_date_paye);
		$Abonnement_date_paye = "<br /> $Abonnement_date_paye";
	}

	if($ligne_boucle['Abonnement_date_expiration'] > time() ){
		$nbr_jour_abonnement = ($ligne_boucle['Abonnement_date_expiration']-time());
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

	///////////////////////////////SELECT
	$req_select = $bdd->prepare("SELECT * FROM configurations_abonnements WHERE id=?");
	$req_select->execute(array($Abonnement_id));
	$ligne_select = $req_select->fetch();
	$req_select->closeCursor();
	$nom_abonnement = $ligne_select['nom_abonnement']; 
	if(empty($nom_abonnement)){
		$nom_abonnement = "<span class='label label-danger' >Pas d'abonnement</span>";
	}

echo "<tr><td style='text-align: center;'>$prenomm $nomm($log)</td>";
echo "<td style='text-align: center;'>N°$Abonnement_id $nom_abonnement</td>";
echo "<td style='text-align: center;'>$Abonnement_paye </td>";
echo "<td style='text-align: center;'> $Abonnement_date_paye </td>";
echo "<td style='text-align: center;'> $Abonnement_date </td>";
echo "<td style='text-align: center;'>$Abonnement_date_expiration</td>";
echo "<td style='text-align: center;'>$nbr_jour_abonnement</td>";
echo "<td style='text-align: center;'><a href='?page=Abonnes&amp;action=Modifier&amp;idaction=".$idd."' title='Modifier' data-id='".$idd."' ><span class='uk-icon-file-text' ></span></a></td>";
echo "</tr>";
}
$req_boucle->closeCursor();

echo '</tbody></table><br /><br />';

}else{
header('location: /index.html');
}

ob_end_flush();
?>