<?php

ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../Configurations_bdd.php');
require_once('../../Configurations.php');
require_once('../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction= "../../";
require_once('../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

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

$id_annonce = $_POST['id_annonce'];
$avis_area = $_POST['note_post'];
$commentaire_area = $_POST['commentaire_area'];
$avis_area = intval($avis_area);

if (isset($avis_area) && preg_match("/^[0-5]$/", $avis_area)){

///////////////////////////////INSERT
$sql_insert = $bdd->prepare("INSERT INTO membres_biens_avis
	(id_annonce,
	 id_membre,
	 pseudo,
	 prenom,
	 nom,
	 avis,
	 commentaire,
	 date_avis
	)
	VALUES (?,?,?,?,?,?,?,?)");
$sql_insert->execute(array(
	$id_annonce,
	$id_oo,
	$user,
        $prenom_oo,
	$nom_oo,
	$avis_area,
	$commentaire_area,
	time()));                     
$sql_insert->closeCursor();

$result = array("Texte_rapport"=>"Avis envoyé avec succès ! ","retour_validation"=>"ok","retour_lien"=>"");

}else{
    $result = array("Texte_rapport"=>"* Entrée invalide *","retour_validation"=>"","retour_lien"=>"");
} 

$result = json_encode($result);
echo $result;

ob_end_flush();
