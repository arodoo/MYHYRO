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

if(isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 1 ||
isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 4 ){

?>

<script>
$(document).ready(function (){

//AJAX SOUMISSION DU FORMULAIRE - MODIFIER - AJOUTER
$(document).on("click", "#bouton_formulaire_blog_categorie", function (){
  //ON SOUMET LE TEXTAREA TINYMCE
   
  tinyMCE.triggerSave();
    $.post({
// alert('dskfjsk'); Voir l'endroit ou se trouve l'eureur du formulaire

    url : '/administration/Modules/Blog/Categories/categories-du-blog-action-ajouter-modifier-ajax.php',
    type : 'POST',
    <?php if ($_GET['action'] == "modifier"){ ?>
    data: new FormData($("#formulaire_categorie_blog_modifier")[0]),
    <?php }else{ ?>
    data: new FormData($("#formulaire_categorie_blog_ajout")[0]),
    <?php } ?>
    processData: false,
    contentType: false,
    dataType: "json",
    success: function (res) {
      if(res.retour_validation == "ok"){
        popup_alert(res.Texte_rapport,"green filledlight","#009900","uk-icon-check");
        <?php if ($_GET['action'] != "modifier"){ ?>
          $("#formulaire_categorie_blog_ajout")[0].reset();
        <?php } ?>
      }else{
        popup_alert(res.Texte_rapport,"#CC0000 filledlight","#CC0000","uk-icon-times");
      }
    }

  });

  listeCategorieBlog();
});

//AJAX - SUPPRIMER
$(document).on("click", ".categorie-blog-supprimer", function (){
$.post({
url : '/administration/Modules/Blog/Categories/categories-du-blog-action-supprimer-ajax.php',
type : 'POST',
data: {idaction:$(this).attr("data-id")},
dataType: "json",
success: function (res) {
if(res.retour_validation == "ok"){
popup_alert(res.Texte_rapport,"green filledlight","#009900","uk-icon-check");
}else{
popup_alert(res.Texte_rapport,"#CC0000 filledlight","#CC0000","uk-icon-times");
}
}
});
listeCategorieBlog();
});

//FUNCTION AJAX - LISTE 
function listeCategorieBlog(){
$.post({
url : '/administration/Modules/Blog/Categories/categories-du-blog-liste-ajax.php',
type : 'POST',
dataType: "html",
success: function (res) {
$("#liste-categorie-blog").html(res);
}
});
}

listeCategorieBlog();

$(document).on('click', '#btnSupprModal', function(){
  $.post({
    url: '/administration/Modules/Blog/Categories/modal-supprimer-ajax.php',
    type: 'POST',
    data: {
      idaction: $(this).attr("data-id")
    },
    dataType: "html",
    success: function(res) {
      $("body").append(res)
      $("#modalSuppr").modal('show')
    }
  })
});

$(document).on("click", "#btnSuppr", function() {
  // $(".modal").show();
  $.post({
    url: '/administration/Modules/Blog/Categories/categories-du-blog-action-supprimer-ajax.php',
    type: 'POST',
    data: {
      idaction: $(this).attr("data-id")
    },
    dataType: "json",
    success: function(res) {
      if (res.retour_validation == "ok") {
        popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
      } else {
        popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
      }
      listeCategorieBlog();
      $("#modalSuppr").modal('hide')
      // $("#modalSuppr").hide(1000);
      // $(this).hide(1000);
    }
  });
});

$(document).on("click", "#btnNon", function() {
  $("#modalSuppr").modal('hide')
});

$(document).on('hidden.bs.modal', "#modalSuppr", function(){
  $(this).remove()
})

});

</script>

<ol class="breadcrumb">
  <li><a href="<?php echo $http; ?><?php echo $nomsiteweb; ?>">Accueil</a></li>
  <li><a href="<?php echo $mode_back_lien_interne; ?>">Administration</a></li>
  <?php if(empty($_GET['action'])){ ?> <li class="active">Catégories du blog</li> <?php }else{ ?> <li><a href="?page=Categories-du-blog">Catégories du blog</a></li> <?php } ?>
  <?php if($_GET['action'] == "modifier" ){ ?> <li class="active">Modifications</li> <?php } ?>
  <?php if($_GET['action'] == "ajouter" ){ ?> <li class="active">Ajouter</li> <?php } ?>
</ol>

<div id='bloctitre' style='text-align: left;' ><h1>Catégories du blog</h1></div><br />
<div style='clear: both;'></div>

<?php

$action = $_GET['action'];
$idaction = $_GET['idaction'];

////////////////////Boutton administration
echo "<a href='".$mode_back_lien_interne."'><button type='button' class='btn btn-default' style='margin-right: 5px;' ><span class='uk-icon-cogs'></span> Administration</button></a>";
echo "<a href='?page=Pages&amp;action=modification&amp;idaction=4'><button type='button' class='btn btn-primary' style='margin-right: 5px;' ><span class='uk-icon-cog'></span> Gestion de la page</button></a>";
echo "<a href='?page=Configurations-du-blog'><button type='button' class='btn btn-primary' style='margin-right: 5px;' ><span class='uk-icon-file'></span> Configuration du blog</button></a>";
echo "<a href='/Blog' target='_top'><button type='button' class='btn btn-primary' style='margin-right: 5px;' ><span class='uk-icon-search'></span> Consulter le blog</button></a>";
echo "<a href='?page=Gestions-du-blog'><button type='button' class='btn btn-primary' style='margin-right: 5px;' ><span class='uk-icon-file-text-o'></span> Gestion des articles</button></a>";
if($action != "ajouter"){
echo "<a href='?page=Categories-du-blog&amp;action=ajouter'><button type='button' class='btn btn-success' style='margin-right: 5px;' ><span class='uk-icon-plus-circle'></span> Ajouter une catégorie</button></a>";
}
if(!empty($action)){
echo "<a href='?page=Categories-du-blog'><button type='button' class='btn btn-success' style='margin-right: 5px;' ><span class='uk-icon-file-text'></span> Liste des catégories</button></a>";
}
echo "<div style='clear: both;'></div><br />";
////////////////////Boutton administration
?>

<div style='padding: 5px;' align="center">

<?php

////////////////////////////FORMULAIRE AJOUTER / MODIFIER
if($action == "ajouter" || $action == "modifier" ){

if($action == "modifier" ){

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM codi_one_blog_categories WHERE id=?");
$req_select->execute(array($idaction));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$idoneinfos = $ligne_select['id'];
$nom_categorie = $ligne_select['nom_categorie'];
$nom_url_categorie = $ligne_select['nom_url_categorie'];
$text_categorie = $ligne_select['text_categorie'];
$nbr_consultation_blog = $ligne_select['nbr_consultation_blog'];
$Title = $ligne_select['Title'];
$Metas_description = $ligne_select['Metas_description'];
$Metas_mots_cles = $ligne_select['Metas_mots_cles'];
$activer_categorie_blog = $ligne_select['activer'];
$date_categorie_blog = $ligne_select['date'];
$Position_categorie = $ligne_select['Position_categorie'];
$Ancre_menu = $ligne_select['Ancre_menu'];

if(!empty($date_categorie_blog)){
$date_categorie_blog_date = date('d-m-Y', $date_categorie_blog);
}else{
$date_categorie_blog_date = "- -";
}

if($activer_categorie_blog == "oui"){
$selectedstatut1 = "selected='selected'";
}elseif($Declaree_dans_site_map_xml == "non"){
$selectedstatut2 = "selected='selected'";
}

?>

<div align='left'>
<h2>Modifier la catégorie <?php echo "$nom_categorie"; ?></h2>
</div><br />
<div style='clear: both;'></div>

<form id="formulaire_categorie_blog_modifier" method="post" action="?page=Categories-du-blog&amp;action=modifier-action&amp;idaction=<?php echo "$idaction"; ?>">
<input id="action" type="hidden" name="action" value="modifier-action" >
<input id="idaction" type="hidden" name="idaction" value="<?php echo "$idaction"; ?>" >

<?php
}else{
?>

<div align='left'>
<h2>Ajouter une catégorie</h2>
</div><br />
<div style='clear: both;'></div>

<form id="formulaire_categorie_blog_ajout" method="post" action="?page=Categories-du-blog&amp;action=ajouter-action">
<input id="action" type="hidden" name="action" value="ajouter-action" >

<?php
}
?>

<table style="text-align: left; width: 100%; text-align: center;" cellpadding="2" cellspacing="2"><tbody>

<?php
if($action != "ajouter"){
?>
<tr><td style="text-align: left;" colspan='2'>
<a href='/<?php echo "$nom_url_categorie"; ?>' style='float: left; text-decoration: none; margin-right: 5px;' target='_top'>
<button type='button' class='btn btn-success' >Consulter la catégorie</button>
</a>
</td></tr>
<tr><td colspan="2" >&nbsp;</td></tr>
<?php
}
?>

<tr><td style="text-align: left; width: 190px;">Nom de la catégorie</td>
<td style="text-align: left;">
<input type='text' name="nom_categorie_post" class="form-control" value="<?php echo "$nom_categorie"; ?>" style='width: 100%;' />
</td></tr>
<tr><td colspan="2" >&nbsp;</td></tr>

<tr><td style="text-align: left; width: 190px;">Ancre menu</td>
<td style="text-align: left;">
<input type='text' name="Ancre_menu" class="form-control" value="<?php echo "$Ancre_menu"; ?>" style='width: 100%;' />
</td></tr>
<tr><td colspan="2" >&nbsp;</td></tr>

<tr><td style="text-align: left; width: 190px;">Position</td>
<td style="text-align: left;">
<input type='text' name="Position_categorie" class="form-control" value="<?php echo "$Position_categorie"; ?>" style='width: 50%;' />
</td></tr>
<tr><td colspan="2" >&nbsp;</td></tr>

<tr><td style="text-align: left; vertical-align: top; width: 190px;">Description</td>
<td style="text-align: left;"><textarea class='mceEditor' id='description_categorie_post' name='description_categorie_post' style='width: 100%; height: 150px;'><?php echo "$text_categorie"; ?></textarea></td></tr>
<tr><td colspan="2" >&nbsp;</td></tr>

<tr><td style="text-align: left; width: 190px;">Title</td>
<td style="text-align: left;">
<input type='text' name="title_categorie_post" class="form-control" value="<?php echo "$Title"; ?>" style='width: 100%;' />
</td></tr>
<tr><td colspan="2" >&nbsp;</td></tr>

<tr><td style="text-align: left; vertical-align: top; width: 190px;">Méta déscription</td>
<td style="text-align: left;"><textarea name='meta_description_post' class='form-control' style='width: 100%; height: 50px;'><?php echo "$Metas_description"; ?></textarea></td></tr>
<tr><td colspan="2" >&nbsp;</td></tr>

<tr><td style="text-align: left; vertical-align: top; width: 190px;">Méta keywords</td>
<td style="text-align: left;"><textarea name='meta_keyword_post' class='form-control' style='width: 100%; height: 50px;'><?php echo "$Metas_mots_cles"; ?></textarea></td></tr>
<tr><td colspan="2" >&nbsp;</td></tr>

<tr><td style="text-align: left; width: 190px; margin-right: 5px;">Statut de la catégorie </td>
<td style="text-align: left;">
<select name='statut_activer_post' class='form-control' style='width: 150px; display: inline-block;'>
<option <?php echo "$selectedstatut1"; ?> value='oui'> Activée &nbsp; &nbsp;</option>
<option <?php echo "$selectedstatut2"; ?> value='non'> Désactivée &nbsp; &nbsp;</option>
</select>
</td></tr>

<tr><td colspan="2" >&nbsp;</td></tr> 

</table>
<button id='bouton_formulaire_blog_categorie' type='button' class='btn btn-success' onclick="return false;" style='width: 150px;' >ENREGISTRER</button>
</form>
<br /><br />

<?php
}
////////////////////////////FORMULAIRE AJOUTER / MODIFIER


////////////////////////////SI PAS D'ACTION 
if(empty($_GET['action'])){
?>

<!-- LISTE DES CATEGORIES DU BLOG -->
<div id='liste-categorie-blog'></div>

<?php
}
////////////////////////////SI PAS D'ACTION 
?>

</div>

<?php
}else{
header("location: index.html");
}

?>