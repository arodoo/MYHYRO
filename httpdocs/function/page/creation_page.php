<?php

  /*****************************************************\
  * Adresse e-mail => staff@codi-one.com                *
  * La conception est assujettie à une autorisation     *
  * spéciale de codi-one.com. Si vous ne disposez pas de*
  * cette autorisation, vous êtes dans l'illégalité.    *
  * L'auteur de la conception est et restera            *
  * codi-one.com                                        *
  * Codage, script & images (all contenu) sont réalisés *
  * par codi-one.com                                    *
  * La conception est à usage unique et privé.          *
  * La tierce personne qui utilise le script se porte   *
  * garant de disposer des autorisations nécessaires    *
  *                                                     *
  * Copyright ... Tous droits réservés auteur (Fabien B)*
  \*****************************************************/

/////CALL FONCTION CREATION PAGE
//page("codi_one_blog","1","$nomsiteweb/Blog","Blog");

/////FONCTION PAGE

/////////////////////////////////////////FONCTION INSERT PAGE - FULL

function page($Page_web_categorie,
$postpagetitle,
$contenupagepost,
$menu_pagepost,
$positiondansmenupostpage,
$ancrelienmenupostpage,
$presence_footer,
$positiondansfooterpostpage,
$ancrelienfooterpostpage,
$titreh1postpage,
$ancrefildarianepostpage,
$titlepagepost,
$metadescriptionpagepost,
$metamotsclespagepost,
$nowdatesitemap,
$levelpagepost,
$frequencepagepost,
$declaree_dans_site_map_xml_pagepost,
$statut_pagepost,
$Page_fixepost,
$Page_type_module_ou_page,
$Page_admin_associeepost
){

global $bdd;

page_insert();

}

/////////////////////////////////////////FONCTION INSERT PAGE
fonction page_insert(){

global $bdd;

$now = time();
$nowdatesitemap = date('Y-m-d');

///////////////////////////////INSERT
$sql_insert = $bdd->prepare("INSERT INTO pages
	(id_categorie,
	Page,
	Page_nom,
	contenu_de_la_page,
	categorie_menu,
	position_menu, 
	Ancre_lien_menu, 
	presence_footer, 
	position_footer, 
	Ancre_lien_footer, 
	Titre_h1, 
	Ancre_fil_ariane, 
	Title, 
	Metas_description, 
	Metas_mots_cles, 
	Site_map_xml_date_mise_a_jour, 
	Site_map_xml_propriete, 
	Site_map_xml_frequence_mise_a_jour, 	
	Declaree_dans_site_map_xml, 
	Statut_page, 
	Page_fixe, 
	Page_type_module_ou_page, 
	Page_admin_associee, 
	date)
	VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
$sql_insert->execute(array(
	'',
	$Page_web_categorie,
	$postpagetitle,
	$postpagetitle,
	$contenupagepost,
	$menu_pagepost,
	$positiondansmenupostpage,
	$ancrelienmenupostpage,
	$presence_footer,
	$positiondansfooterpostpage,
	$ancrelienfooterpostpage,
	$titreh1postpage,
	$ancrefildarianepostpage,
	$titlepagepost,
	$metadescriptionpagepost,
	$metamotsclespagepost,
	$nowdatesitemap,
	$levelpagepost,
	$frequencepagepost,
	$declaree_dans_site_map_xml_pagepost,
	$statut_pagepost,
	$Page_fixepost,
	$Page_type_module_ou_page,
	$Page_admin_associeepost,
	$now
));                     
$sql_insert->closeCursor();

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM pages WHERE Plus=?");
$req_select->execute(array($now));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$id_page = $ligne_select['id'];

//////////////////////////////////////On nome l'url de la page si ce n'est pas un module
if($Page_type_module_ou_page != "Module"){
$nouveaucontenu = "$postpagetitle";
include("function/cara_replace.php");
$postpagetitle = "$nouveaucontenu";
$postpagetitle = "".$postpagetitle."";
}
//////////////////////////////////////On nome l'url de la page si ce n'est pas un module

///////////////////////////////UPDATE
$sql_update = $bdd->prepare("UPDATE pages SET 
	Page=? 
	WHERE id=?");
$sql_update->execute(array(
	$postpagetitle,
	$id_page));                     
$sql_update->closeCursor();


}


?>