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

$post_blog_text = $_POST['post_blog_text'];
$post_limitation_caracteres = $_POST['post_limitation_caracteres'];
$post_nbr_article_menu = $_POST['post_nbr_article_menu'];
$nbr_article_page_blog = $_POST['nbr_article_page_blog'];

///////////////////////////////UPDATE
$sql_update = $bdd->prepare("UPDATE codi_one_blog_a_cfg SET 
	Contenu_cfg_blog=?,
	limitation_texte_liste_cfg_blog=?, 
	nbr_liste_menu_cfg_blog=?,
	nbr_article_page_blog=?
	WHERE id=?");
$sql_update->execute(array(
	$post_blog_text,
	$post_limitation_caracteres, 
	$post_nbr_article_menu,
	$nbr_article_page_blog, 
	'1'));                     
$sql_update->closeCursor();

$result = array("Texte_rapport"=>"Modifications effectuées avec succès !","retour_validation"=>"ok","retour_lien"=>"");

$result = json_encode($result);
echo $result;

}else{
header('location: /index.html');
}

ob_end_flush();
?>