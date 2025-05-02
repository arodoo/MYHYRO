<?php

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

if(!empty($_SESSION['4M8e7M5b1R2e8s']) && !empty($user)){
?>

<div class="row" >

	<?php
	include('panel/menu.php');
	?>

	<div class="col-12 col-lg-9 mt-4 mt-lg-0">
	
		<?php
		include('panel/include-messages.php');
		?>

		<div class="card" >

			<div class="card-header" >
				<h5>Factures</h5>
			</div>
			<div class="card-divider" ></div>
			<div class="card-body" >

<?php
$nom_fichier = "Mes-factures";
$nom_fichier_datatable = "Mes-factures-".date('d-m-Y', time())."-$nomsiteweb"; 
?>
<script>
$(document).ready(function(){
    $('#Tableau_e').DataTable(
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
    $('#Tableau_e tfoot .search_table').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" class="form-control" placeholder="'+title+'" style="width:100%; font-weight: normal;"/>' );
    } );
    var table = $('#Tableau_e').DataTable();
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

	<table id='Tableau_e' class="display nowrap" style="text-align: center; width: 100%; margin-top: 15px;" cellpadding="2" cellspacing="2">

<thead>
<tr>
<th scope="col" style="text-align: center;" >REFERENCE</th>
<th style="text-align: center;">LIBELLE</th>
<th style="text-align: center;">DATE</th>
<th style="text-align: center; width: 90px;">PDF</th>
</tr>
</thead>
<tfoot>
<tr>
<th class="search_table" style="text-align: center;" >REFERENCE</th>
<th class="search_table" style="text-align: center;">LIBELLE</th>
<th class="search_table" style="text-align: center;" >DATE</th>
<th style="text-align: center; width: 90px;">PDF</th>
</tr>
</tfoot>

<tbody>

<?php
///////////////////////////////SELECT BOUCLE
	$req_boucle = $bdd->prepare("SELECT * FROM membres_prestataire_facture WHERE pseudo=? ORDER BY date_edition DESC");
	$req_boucle->execute(array($user));
	while($ligne_boucle = $req_boucle->fetch()){
    $id_facture = $ligne_boucle['id'];
    $id_membre = $ligne_boucle['id_membre'];
    $id_membrepseudo = $ligne_boucle['pseudo'];
    $numero_facture = $ligne_boucle['numero_facture'];
    $REFERENCE_NUMERO = $ligne_boucle['REFERENCE_NUMERO'];
    $Titre_facture = $ligne_boucle['Titre_facture'];
    $Contenu = $ligne_boucle['Contenu'];
    $Suivi = $ligne_boucle['Suivi'];
    $date_edition = $ligne_boucle['date_edition'];
    if(!empty($date_edition)){
    $date_edition = date('d-m-Y', $date_edition);
    }
    $mod_paiement = $ligne_boucle['mod_paiement'];
    $Tarif_HT = $ligne_boucle['Tarif_HT'];
    $Remise = $ligne_boucle['Remise'];
    $Tarif_HT_net = $ligne_boucle['Tarif_HT_net'];
    $Tarif_TTC = $ligne_boucle['Tarif_TTC'];
    $Total_Tva = $ligne_boucle['Total_Tva'];
    $taux_tva = $ligne_boucle['taux_tva'];
    $condition_reglement = $ligne_boucle['condition_reglement'];
    $delai_livraison = $ligne_boucle['delai_livraison'];
    $id_devis = $ligne_boucle['id_devis'];

    if(!empty($id_devis_dd)){
    $REFERENCE_NUMERO_DEVIS = "<a href='/".$lien_devis_traduction."-".$numero_devis_dd."-".$nomsiteweb.".html'> <span class='uk-icon-file'></span> $REFERENCE_NUMERO_DEVIS </a>";
    }else{
    $REFERENCE_NUMERO_DEVIS = "--";
    }

?>
<tr class="odd" >
<td class="dtr-control"><?php echo "$REFERENCE_NUMERO"; ?></td>
<td><?php echo "$Titre_facture"; ?></td>
<td><?php echo "$date_edition"; ?></td>
<td><?php echo "<a href='/facture/".$numero_facture."/".$nomsiteweb."' target='_top' ><span class='uk-icon-file-pdf-o'></span></a>"; ?></td>
</tr>
<?php
}
$req_boucle->closeCursor();

?>

</tbody>
</table>

			</div>

		</div>

	</div>

</div>

<?php
}else{
header('location: /index.html');
}
?>