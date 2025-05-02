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

$now =  time();

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


$idaction = $_POST['idaction'];

$nom_categorie_post = $_POST['nom_categorie_post'];
$title_categorie_post = $_POST['title_categorie_post'];
$description_categorie_post = $_POST['description_categorie_post'];
$meta_description_post = $_POST['meta_description_post'];
$meta_keyword_post = $_POST['meta_keyword_post'];
$statut_activer_post = $_POST['statut_activer_post'];
$Position_categorie = $_POST['Position_categorie'];
$Ancre_menu = $_POST['Ancre_menu'];

////////////////////////////AJOUTER
if($_POST['action'] == "ajouter-action"){

///////////////////////////////INSERT
$sql_insert = $bdd->prepare("INSERT INTO codi_one_blog_categories
	(nom_categorie,
	nom_url_categorie,
	text_categorie,
	nbr_consultation_blog,
	Title,
	Metas_description,
	Metas_mots_cles,
	activer,
	Position_categorie,
	Ancre_menu,
	date,
	plus,
	plus1)
	VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");

$sql_insert->execute(array(
	$nom_categorie_post,
	$nom_categorie_post_url_sql,
	$description_categorie_post,
	'0',
	$title_categorie_post,
	$meta_description_post,
	$meta_keyword_post,
	$statut_activer_post,
	$Position_categorie,
	$Ancre_menu,
	$now,
	$now,
	''));   
	// die("dskfjksdl");                  
$sql_insert->closeCursor(); 
///////////////////////////////On nomme l'url de la page si ce n'est pas un module

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM codi_one_blog_categories WHERE plus=?");
$req_select->execute(array($now));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$idoneinfos = $ligne_select['id'];

//////////////////////////////////////On nomme l'url
$nouveaucontenu = "$nom_categorie_post";
include("../../../../function/cara_replace.php");
$nom_categorie_post_url_sql = "$nouveaucontenu";
$nom_categorie_post_url_sql = "Blog/Categorie/".$nom_categorie_post_url_sql."/".$idoneinfos."";
//////////////////////////////////////On nome l'url

///////////////////////////////UPDATE
$sql_update = $bdd->prepare("UPDATE codi_one_blog_categories SET nom_url_categorie=? WHERE id=?");
$sql_update->execute(array($nom_categorie_post_url_sql,$idoneinfos));                     
$sql_update->closeCursor();

$result = array("Texte_rapport"=>"Catégorie du blog ajoutée avec succès !","retour_validation"=>"ok","retour_lien"=>"");

}
////////////////////////////AJOUTER


////////////////////////////MODIFIER
if($_POST['action'] == "modifier-action"){

//////////////////////////////////////On nomme l'url
$nouveaucontenu = "$nom_categorie_post";
include("../../../../function/cara_replace.php");
$nom_categorie_post_url_sql = "$nouveaucontenu";
$nom_categorie_post_url_sql = "Blog/Categorie/".$nom_categorie_post_url_sql."/".$idaction."";
//////////////////////////////////////On nome l'url

///////////////////////////////UPDATE
$sql_update = $bdd->prepare("UPDATE codi_one_blog_categories SET 
	nom_categorie=?, 
	nom_url_categorie=?,
	text_categorie=?,
	Title=?,
	Metas_description=?,
	Metas_mots_cles=?,
	date=?,
	activer=?,
	Position_categorie=?,
	Ancre_menu=?
	WHERE id=?");
$sql_update->execute(array(
	$nom_categorie_post, 
	$nom_categorie_post_url_sql,
	$description_categorie_post,
	$title_categorie_post,
	$meta_description_post,
	$meta_keyword_post,
	$now,
	$statut_activer_post,
	$Position_categorie,
	$Ancre_menu,
	$idaction));                     
$sql_update->closeCursor();


$result = array("Texte_rapport"=>"Modifications apportées !","retour_validation"=>"ok","retour_lien"=>"");

}
////////////////////////////MODIFIER

$result = json_encode($result);
echo $result;

}else{
header('location: /index.html');
}
ob_end_flush();
?>