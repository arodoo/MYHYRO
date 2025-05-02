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

$action = $_POST['action'];
$idaction = $_POST['idaction'];

$nom_categorie = $_POST['nom_categorie'];
$activer = $_POST['activer'];
$position = $_POST['position'];
$description = $_POST['description'];
$description_footer = $_POST['description_footer'];
$title = $_POST['title'];
$description_meta = $_POST['description_meta'];
$keywords_meta = $_POST['keywords_meta'];
$video_youtube_header = $_POST['video_youtube_header'];
$video_youtube_footer = $_POST['video_youtube_footer'];

////////////////////////////AJOUTER
if($action == "ajouter-action"){

///////////////////////////////INSERT
$sql_insert = $bdd->prepare("INSERT INTO pages_categories
	(description,
	description_footer,
	nom_categorie,
	activer,
	position,
	title,
	description_meta,
	keywords_meta,
	video_youtube_header,
	video_youtube_footer)
	VALUES (?,?,?,?,?,?,?,?,?,?)");
$sql_insert->execute(array(
	$description, 
	$description_footer, 
	$nom_categorie, 
	$activer, 
	$position, 
	$title, 
	$description_meta, 
	$keywords_meta, 
	$video_youtube_header, 
	$video_youtube_footer));                  
$sql_insert->closeCursor();

$result = array("Texte_rapport"=>"Catégorie ajoutée avec succès !","retour_validation"=>"ok","retour_lien"=>"");

}
////////////////////////////AJOUTER

////////////////////////////MODIFIER
if($action == "modifier-action"){

///////////////////////////////UPDATE
$sql_update = $bdd->prepare("UPDATE  pages_categories SET 
	description=?, 
	description_footer=?, 
	nom_categorie=?, 
	activer=?, 
	position=?, 
	title=?, 
	description_meta=?, 
	keywords_meta=?, 
	video_youtube_header=?, 
	video_youtube_footer=?
	WHERE id=?");
$sql_update->execute(array(
	$description, 
	$description_footer,
	$nom_categorie, 
	$activer, 
	$position,
	$title, 
	$description_meta,
	$keywords_meta, 
	$video_youtube_header,
  $video_youtube_footer,
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
