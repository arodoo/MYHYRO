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
$actionone = $_POST['actionone'];

$now = time();

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT COUNT(*) as ccnbrPAGE FROM pages");
$req_select->execute(array($idaction));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$ccnbrPAGE = $ligne_select['ccnbrPAGE'];

if($ccnbrPAGE > 1){
$ccnbrPAGE = "$ccnbrPAGE pages déclarés";
}elseif($ccnbrPAGE == 1 || $ccnbrPAGE < 1){
$ccnbrPAGE = "$ccnbrPAGE page  déclaré";
}

?>

<div style='text-align: left;'>
<h2>Liste des pages partie "visiteurs"</h2>
</div><br />
<div style='clear: both;'></div>

<?php
$nom_fichier = "Pages";
$nom_fichier_datatable = "Pages-".date('d-m-Y', time())."-$nomsiteweb"; 
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
<th scope="col" style="text-align: center;">PAGES <?php echo $_SESSION['recherche_page_one_titre']; ?></th>
<th style="text-align: center; width: 90px;">MODIFIER</th>
<th style="text-align: center; width: 90px;">SUPPRIMER</th>
</tr>
</thead>
<tfoot>
<tr>
<th style="text-align: center;">PAGES</th>
<th style="text-align: center; width: 90px;" >MODIFIER</th>
<th style="text-align: center; width: 90px;">SUPPRIMER</th>
</tr>
</tfoot>
<tbody>

<?php
///////////////////////////////SELECT BOUCLE
$req_boucle = $bdd->prepare("SELECT * FROM pages WHERE id!='' ".$_SESSION['recherche_page_one']." order by id DESC");
$req_boucle->execute();
while($ligne_boucle = $req_boucle->fetch()){
$idoneinfos = $ligne_boucle['id'];
$id_categorie = $ligne_boucle['id_categorie'];
$id_image_parallaxe_banniere = $ligne_boucle['id_image_parallaxe_banniere'];
$PagePage = $ligne_boucle['Page'];
$Ancre_lien_menu = $ligne_boucle['Ancre_lien_menu'];
$categorie_menu = $ligne_boucle['categorie_menu'];
$presence_footer = $ligne_boucle['presence_footer'];
$position_footer = $ligne_boucle['position_footer'];
$Ancre_lien_footer = $ligne_boucle['Ancre_lien_footer'];
$Titre_h1 = $ligne_boucle['Titre_h1'];
$Ancre_fil_ariane = $ligne_boucle['Ancre_fil_ariane'];
$TitreTitre = $ligne_boucle['Title'];
$Metas_description = $ligne_boucle['Metas_description'];
$Metas_mots_cles = $ligne_boucle['Metas_mots_cles'];
$Site_map_xml_date_mise_a_jour = $ligne_boucle['Site_map_xml_date_mise_a_jour'];
$Site_map_xml_propriete = $ligne_boucle['Site_map_xml_propriete'];
$Site_map_xml_frequence_mise_a_jour = $ligne_boucle['Site_map_xml_frequence_mise_a_jour'];
$Declaree_dans_site_map_xml = $ligne_boucle['Declaree_dans_site_map_xml'];
$Statut_page = $ligne_boucle['Statut_page'];

$Page_inscription = $ligne_boucle['Page_inscription'];
$Page_portefolio = $ligne_boucle['Page_portefolio'];
$Page_blog_actualite = $ligne_boucle['Page_blog_actualite'];
$Page_livre_d_or = $ligne_boucle['Page_livre_d_or'];

$Page_index = $ligne_boucle['Page_index'];
$Page_admin = $ligne_boucle['Page_admin'];
$Page_fixe = $ligne_boucle['Page_fixe'];
$date_upadte_p = $ligne_boucle['date'];
$Page_type_module_ou_page = $ligne_boucle['Page_type_module_ou_page'];

if($Page_index == "oui"){
$PagePage = "".$http."$nomsiteweb";
$PagePage_lien  = "$PagePage";
}else{
$PagePage = "$PagePage";
$PagePage_lien  = "".$http."$nomsiteweb/$PagePage";
}

if($_SESSION['idsessionp'] == "$idoneinfos"){
$colorback = "background-color: $couleurbordure; color: #00d7b3;";
$colorlien = "color: #00d7b3;";
}

?>
<tr><td style="text-align: center; <?php echo "$colorback"; ?>"><div id='ancre_p<?php echo "$idoneinfos"; ?>'><a href='<?php echo "$PagePage_lien"; ?>' target='_top' style='<?php echo "$colorlien"; ?>' ><?php echo "$PagePage"; ?></a></div></td>
<td style="text-align: center; width: 90px; <?php echo "$colorback"; ?>"><?php echo "<a href='?page=Pages&amp;action=modification&amp;idaction=".$idoneinfos."' style='".$colorback."'><span class='uk-icon-file-text' ></span></a>"; ?></td>
<td style="text-align: center; width: 90px; <?php echo "$colorback"; ?>">
<?php 
if($Page_fixe == "oui"){
echo "- -";
}else{
  echo "<a id='btnSupprModal' data-id='".$idoneinfos."' href='#' ><span class='uk-icon-times' ></span></a>";
}
?>
</td>
</tr>
<?php
unset($colorlien);
unset($colorback);
}
$req_boucle->closeCursor();

if(!isset($idoneinfos)){
?>
<tr><td colspan="5" rowspan="1" style="text-align: center;">Aucune donn&eacute;e disponible pour le moment!</td></tr>
<?php
}
?>
</tbody></table><br />

<?php

}else{
header('location: /index.html');
}

ob_end_flush();
?>