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
$(document).on("click", "#bouton_configurations_blog", function (){
//ON SOUMET LE TEXTAREA TINYMCE
tinyMCE.triggerSave();
if (validateForm()){
  $.post({
    url : '/administration/Modules/Blog/Configurations/configurations-du-blog-action-modifier-ajax.php',
    type : 'POST',
    data: new FormData($("#formulaire_configurations_blog")[0]),
    processData: false,
    contentType: false,
    dataType: "json",
    success: function (res) {
      if(res.retour_validation == "ok"){
        popup_alert(res.Texte_rapport,"green filledlight","#009900","uk-icon-check");
      }else{
        popup_alert(res.Texte_rapport,"#CC0000 filledlight","#CC0000","uk-icon-times");
      }
    }
  });
}
else{
  alert("Il manque des informations")
}
});

});

</script>

<ol class="breadcrumb">
  <li><a href="<?php echo $http; ?><?php echo $nomsiteweb; ?>">Accueil</a></li>
  <li><a href="<?php echo $mode_back_lien_interne; ?>">Administration</a></li>
  <?php if(empty($_GET['action'])){ ?> <li class="active">Configurations du blog</li> <?php }else{ ?> <li><a href="?page=Configurations-du-blog">Configurations du blog</a></li> <?php } ?>
</ol>

<div id='bloctitre' style='text-align: left;' ><h1>Configurations du blog</h1></div><br />
<div style='clear: both;'></div>

<?php

////////////////////Boutton administration
echo "<a href='".$mode_back_lien_interne."'><button type='button' class='btn btn-default' style='margin-right: 5px;' ><span class='uk-icon-cogs'></span> Administration</button></a>";
echo "<a href='?page=Pages&amp;action=modification&amp;idaction=4'><button type='button' class='btn btn-primary' style='margin-right: 5px;' ><span class='uk-icon-cog'></span> Gestion de la page</button></a>";
echo "<a href='/Blog' target='_top'><button type='button' class='btn btn-primary' style='margin-right: 5px;' ><span class='uk-icon-search'></span> Consulter le blog</button></a>";
echo "<a href='?page=Categories-du-blog'><button type='button' class='btn btn-primary' style='margin-right: 5px;' ><span class='uk-icon-file-text'></span> Catégories du blog</button></a>";
echo "<a href='?page=Gestions-du-blog'><button type='button' class='btn btn-primary' style='margin-right: 5px;' ><span class='uk-icon-file-text-o'></span> Gestion des articles</button></a>";
echo "<div style='clear: both;'></div><br />";
////////////////////Boutton administration

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM codi_one_blog_a_cfg WHERE id=?");
$req_select->execute(array(""));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$id_blog_cfg = $ligne_select['id'];
$Contenu_cfg_blog = $ligne_select['Contenu_cfg_blog'];
$limitation_texte_liste_blog_cfg = $ligne_select['limitation_texte_liste_cfg_blog'];
$nbr_liste_menu_cfg_blog = $ligne_select['nbr_liste_menu_cfg_blog'];
$nbr_article_page_blog = $ligne_select['nbr_article_page_blog'];

?>
<script>
function validateForm() {
  var limit_caracteres = document.forms["formulaire_configurations_blog"]["post_limitation_caracteres"].value;
  var nbr_article_menu = document.forms["formulaire_configurations_blog"]["post_nbr_article_menu"].value;
  var nbr_article_blog = document.forms["formulaire_configurations_blog"]["nbr_article_page_blog"].value;
  if (limit_caracteres == "" || nbr_article_menu == "" || nbr_article_blog == "") {
    return false;
  }
  else{
    return true;
  }
}
</script>

<form id='formulaire_configurations_blog' method='post' action='?page=Configurations-du-blog&action=modifier'>
<table style="text-align: left; width: 100%; text-align: center;" cellpadding="2" cellspacing="2"><tbody>

<tr><td style="text-align: left; width: 150px; vertical-align: top;">Texte de présentation</td>
<td style="text-align: left;"><textarea name='post_blog_text' class='mceEditor' style='width: 100%; ' ><?= "$Contenu_cfg_blog"; ?></textarea>
</td></tr>
<tr><td colspan="2" rowspan="1">&nbsp;</td></tr>

<tr><td style="text-align: left; width: 150px;">Limitation caractère</td>
<td style="text-align: left;">
<input type='text' name='post_limitation_caracteres' class='form-control' placeholder='ex : 185' value='<?php echo "$limitation_texte_liste_blog_cfg"; ?>' style='width: 100%;' required/></td></tr>
<tr><td style="text-align: left;"> </td>
<td style="text-align: left;"> Limitation du nombre de caractères par fiche dans la liste du blog (Ex:185).</td></tr>
<tr><td colspan="2" rowspan="1">&nbsp;</td></tr>

<tr><td style="text-align: left;">Article dans menu</td>
<td style="text-align: left;">
<input type='text' name='post_nbr_article_menu' class='form-control' placeholder='ex : 2' value='<?php echo "$nbr_liste_menu_cfg_blog"; ?>' style='width: 50%;' required/>
<tr><td style="text-align: left;"> </td>
<td style="text-align: left;"> Nombre d'articles dans le menu (Ex:2).</td></tr>
<tr><td colspan="2" rowspan="1">&nbsp;</td></tr>

<tr><td style="text-align: left;">Article par page </td>
<td style="text-align: left;">
<input type='text' name='nbr_article_page_blog' class='form-control' placeholder='ex : 4' value='<?php echo "$nbr_article_page_blog"; ?>' style='width: 50%;' required/>
<tr><td style="text-align: left;"> </td>
<td style="text-align: left;"> Nombre de lignes par page (Ex:4).</td></tr>
<tr><td colspan="2" rowspan="1">&nbsp;</td></tr>

<tr><td style="text-align: center;" colspan='2'>
<button id='bouton_configurations_blog' type='submit' class='btn btn-success'>ENREGISTRER</button>
</td></tr>

</tbody></table>

</form>

<?php
}else{
header("location: index.html");
}

?>