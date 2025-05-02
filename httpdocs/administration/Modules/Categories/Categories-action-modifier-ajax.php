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

$idaction = $_POST['idaction'];
$action = $_POST['action'];

$now = time();

	///////////////////////////////SELECT
	$req_select = $bdd->prepare("SELECT * FROM categories WHERE id=?");
	$req_select->execute(array($idaction));
	$ligne_select = $req_select->fetch();
	$req_select->closeCursor();
	

if(isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 1 ||
isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 2 ||
isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 3 ){

$now = time ();

$nom_categorie = $_POST['nom_categorie'];
$title_categorie = $_POST['title_categorie'];
$meta_description_categorie = $_POST['meta_description_categorie'];
$meta_keyword_categorie = $_POST['meta_keyword_categorie'];
$title_categorie_demandes = $_POST['title_categorie_demandes'];
$meta_description_categorie_demandes = $_POST['meta_description_categorie_demandes'];
$meta_keyword_categorie_demandes = $_POST['meta_keyword_categorie_demandes'];
$activer = $_POST['activer'];
$type2 = $_POST['type'];
$value = $_POST['value'];
$command = $_POST['command'];

$nouveaucontenu = "$nom_categorie";
include ("../../../function/cara_replace.php");
$url_categorie = $nouveaucontenu;


        $icon1 = $_FILES['image']['name'];
        //////////////////////////////////////POST ACTION UPLOAD 1
        if (!empty($icon1))
        {
            if (!empty($icon1) && substr($icon1, -4) == "jpeg" || !empty($icon1) && substr($icon1, -3) == "jpg" || !empty($icon1) && substr($icon1, -3) == "JPEG" || !empty($icon1) && substr($icon1, -3) == "JPG" || !empty($icon1) && substr($icon1, -3) == "png" || !empty($icon1) && substr($icon1, -3) == "PNG" || !empty($icon1) && substr($icon1, -3) == "gif" || !empty($icon1) && substr($icon1, -3) == "GIF")
            {
                $image_a_uploader = $_FILES['image']['name'];
                $icon = $_FILES['image']['name'];
                $taille = $_FILES['image']['size'];
                $tmp = $_FILES['image']['tmp_name'];
                $type = $_FILES['image']['type'];
                $erreur = $_FILES['image']['error'];
                $source_file = $_FILES['image']['tmp_name'];
                $destination_file = "../../../images/categories/" . $icon . "";

                ////////////Upload des images
                if (move_uploaded_file($tmp, $destination_file))
                {
                    $namebrut = explode('.', $image_a_uploader);
                    $namebruto = $namebrut[0];
                    $namebruto_extansion = $namebrut[1];
                    $nouveaucontenu = "$namebruto";
                    include ('../../../function/cara_replace.php');
                    $namebruto = "$nouveaucontenu";
                    $nouveau_nom_fichier = "" . $namebruto . "-" . $now . ".$namebruto_extansion";
                    rename("../../../images/categories/$icon", "../../../images/categories/$nouveau_nom_fichier");
			$image_ok = "ok";
                }
                ////////////Upload des images
                
            }
            elseif (!empty($icon1))
            {
                $tous_les_fichiers_non_pas_l_extension = "oui";
            }
        }

////////////////////////////////////////////////////AJOUTER
if($action == "Ajouter-action"){

$sql_update = $bdd->prepare("INSERT INTO categories
	(
		nom_categorie, 
		url_categorie,
		title_categorie, 
		meta_description_categorie, 
		meta_keyword_categorie, 
		title_categorie_demandes,
		meta_description_categorie_demandes,
		meta_keyword_categorie_demandes,
		activer,
		type,
		value,
		value_commande,
		nom_categorie_image
	)
	VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
$sql_update->execute(
				array(
					$nom_categorie, 
					$url_categorie,
					$title_categorie, 
					$meta_description_categorie, 
					$meta_keyword_categorie, 
					$title_categorie_demandes,
					$meta_description_categorie_demandes,
					$meta_keyword_categorie_demandes,
					$activer,
					$type2,
					$value,
					$command,
					$nouveau_nom_fichier
					)
				);   
				
$sql_update->closeCursor();

$result = array("Texte_rapport"=>"Catégorie créée avec succès !","retour_validation"=>"ok","retour_lien"=>"");

}
////////////////////////////////////////////////////AJOUTER


////////////////////////////////////////////////////MODIFIER
if($action == "Modifier-action"){

if($image_ok == "ok" ){
///////////////////////////////UPDATE
$sql_update = $bdd->prepare("UPDATE categories SET 
	nom_categorie_image=?
	WHERE id=?");
$sql_update->execute(array(
	$nouveau_nom_fichier, 
	$_POST['idaction']));                     
$sql_update->closeCursor();

}

///////////////////////////////UPDATE
$sql_update = $bdd->prepare("UPDATE categories SET 
	nom_categorie=?, 
	url_categorie=?, 
	title_categorie=?, 
	meta_description_categorie=?, 
	meta_keyword_categorie=?, 
	title_categorie_demandes=?,
	meta_description_categorie_demandes=?,
	meta_keyword_categorie_demandes=?,
	activer=?,
	type=?,
	value=?,
	value_commande=?
	WHERE id=?");
	
$sql_update->execute(array(
	$nom_categorie, 
	$url_categorie,
	$title_categorie, 
	$meta_description_categorie, 
	$meta_keyword_categorie, 
	$title_categorie_demandes,
	$meta_description_categorie_demandes,
	$meta_keyword_categorie_demandes,
	$activer,
	$type2,
	$value,
	$command,
	$_POST['idaction']));                     
$sql_update->closeCursor();

$result = array("Texte_rapport"=>"Catégorie modifiée avec succès !","retour_validation"=>"ok","retour_lien"=>"");

}
////////////////////////////////////////////////////MODIFIER

$result = json_encode($result);
echo $result;

}else{
header('location: /index.html');
}

ob_end_flush();
?>