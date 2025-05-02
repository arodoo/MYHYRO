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
    
<div style='text-align: left;'>
<h2>Liste des articles du blog</h2>
</div>

<div style='clear: both; margin-bottom: 15px;'></div>

<?php
$nom_fichier = "Articles-du-blog";
$nom_fichier_datatable = "Articles-du-blog-".date('d-m-Y', time())."-$nomsiteweb"; 
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
<th scope="col" style="text-align: center;">PAGES</th>
<th style="text-align: center;" >CATEGORIE</th>
<th style="text-align: center; width: 90px;">ACTIVER</th>
<th style="text-align: center; width: 90px;" >MODIFIER</th>
<th style="text-align: center; width: 90px;">SUPPRIMER</th>
</tr>
</thead>
<tfoot>
<tr>
<th style="text-align: center;">PAGES</th>
<th style="text-align: center;">CATEGORIE</th>
<th style="text-align: center; width: 90px;">ACTIVER</th>
<th style="text-align: center; width: 90px;">MODIFIER</th>
<th style="text-align: center; width: 90px;">SUPPRIMER</th>
</tr>
</tfoot>
<tbody>

<?php
///////////////////////////////SELECT BOUCLE
if(!empty($_SESSION['recherche_page_one_2'])){
$req_boucle = $bdd->prepare("SELECT * FROM codi_one_blog WHERE plus1='' ".$_SESSION['recherche_page_one_2']." order by id DESC");
}else{
$req_boucle = $bdd->prepare("SELECT * FROM codi_one_blog order by id DESC");
}
$req_boucle->execute();
while($ligne_boucle = $req_boucle->fetch()){
$idoneinfos_artciles_blog = $ligne_boucle['id'];
$id_categorie_artciles_blog = $ligne_boucle['id_categorie'];
$titre_blog_1_artciles_blog = $ligne_boucle['titre_blog_1'];
$titre_blog_2_artciles_blog = $ligne_boucle['titre_blog_2'];
$texte_article_blog = $ligne_boucle['texte_article'];
$video_artciles_blog = $ligne_boucle['video'];
$url_fiche_blog_artciles_blog = $ligne_boucle['url_fiche_blog'];
$mot_cle_blog_1_artciles_blog = $ligne_boucle['mot_cle_blog_1'];
$mot_cle_blog_1_lien_artciles_blog = $ligne_boucle['mot_cle_blog_1_lien'];
$mot_cle_blog_2_artciles_blog = $ligne_boucle['mot_cle_blog_2'];
$mot_cle_blog_2_lien_artciles_blog = $ligne_boucle['mot_cle_blog_2_lien'];
$mot_cle_blog_3_artciles_blog = $ligne_boucle['mot_cle_blog_3'];
$mot_cle_blog_3_lien_artciles_blog = $ligne_boucle['mot_cle_blog_3_lien'];
$mot_cle_blog_4_artciles_blog = $ligne_boucle['mot_cle_blog_4'];
$mot_cle_blog_4_lien_artciles_blog = $ligne_boucle['mot_cle_blog_4_lien'];
$ID_IMAGE_BLOG_artciles_blog = $ligne_boucle['ID_IMAGE_BLOG'];
$nbr_consultation_blog_artciles_blog = $ligne_boucle['nbr_consultation_blog'];
$Title_artciles_blog = $ligne_boucle['Title'];
$Metas_description_artciles_blog = $ligne_boucle['Metas_description'];
$Metas_mots_cles_artciles_blog = $ligne_boucle['Metas_mots_cles'];
$activer_commentaire_artciles_blog = $ligne_boucle['activer_commentaire'];
$activer_artciles_blog = $ligne_boucle['activer'];
$date_blog_artciles_blog = $ligne_boucle['date_blog'];

if($_SESSION['idsessionpp'] == "$idoneinfos_artciles_blog"){
$colorback = "background-color: green; color: white;";
}

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM codi_one_blog_categories WHERE id=?");
$req_select->execute(array($id_categorie_artciles_blog));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$idoneinfos_r = $ligne_select['id'];
$nom_categorie_r = $ligne_select['nom_categorie'];
$nom_url_categorie_r = $ligne_select['nom_url_categorie'];
$nbr_consultation_blog_r = $ligne_select['nbr_consultation_blog'];
$Title_r = $ligne_select['Title'];
$Metas_description_r = $ligne_select['Metas_description'];
$Metas_mots_cles_r = $ligne_select['Metas_mots_cles'];
$activer_categorie_blog_r = $ligne_select['activer'];
$date_categorie_blog_r = $ligne_select['date'];

if(empty($nom_categorie_r)){
$nom_categorie_r = "- -";
}

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT COUNT(*) AS nbr_commentaire FROM codi_one_blog_commentaires WHERE id_article=?");
$req_select->execute(array($id_categorie_artciles_blog));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$nbr_commentaire = $ligne_select['nbr_commentaire'];
?>

<tr>
<td style="text-align: center; <?php echo "$colorback"; ?>"><div id='ancre_p<?php echo "$idoneinfos_artciles_blog"; ?>'><a href='/<?php echo "$url_fiche_blog_artciles_blog"; ?>' target='_top'><?php echo "$titre_blog_1_artciles_blog"; ?></a></div></td>
<td style="text-align: center; <?php echo "$colorback"; ?>"><a href='<?php echo "?page=Categories-du-blog&amp;action=modifier&amp;idaction=$idoneinfos_artciles_blog"; ?>'><?php echo "$nom_categorie_r"; ?></a></td>
<td style="text-align: center; <?php echo "$colorback"; ?> width: 90px;"><?php echo "$activer_artciles_blog"; ?></td>
<td style="text-align: center; <?php echo "$colorback"; ?> width: 90px;"><?php echo "<a href='?page=Gestions-du-blog&amp;action=modifier&amp;idaction=".$idoneinfos_artciles_blog."'><span class='uk-icon-file-text' ></span></a>"; ?></td>
<td style="text-align: center; width: 90px;"><?php echo "<a id='btnSupprModal' data-id='".$idoneinfos_artciles_blog."' href='#' ><span class='uk-icon-times' ></span></a>"; ?></td>
</tr>

<?php
unset($colorback);
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