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

$nom_categorie_post = $_POST['nom_categorie_post'];
$statut_activer_post = $_POST['statut_activer_post'];
$position_post = $_POST['position_post'];

if($_POST['recherchepageone'] == "all"){
unset($_SESSION['recherche_page_one']);
$_SESSION['recherche_page_one_titre'] = "";
$_SESSION['checked_filtre_page'] = "all";

}elseif(is_numeric($_POST['recherchepageone']) == true){

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM pages_categorie WHERE id=?");
$req_select->execute(array($_POST['recherchepageone']));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$nom_categorie_ss = $ligne_select['nom_categorie'];

$_SESSION['recherche_page_one'] = "AND id_categorie='".mysql_real_escape_string($_POST['recherchepageone'])."' ";
$_SESSION['recherche_page_one_titre'] = " - Catégorie : $nom_categorie_ss - ";
$_SESSION['checked_filtre_page'] = $_POST['recherchepageone'];

}elseif($_POST['recherchepageone'] == "Sans"){
$_SESSION['recherche_page_one'] = "AND id_categorie='' ";
$_SESSION['recherche_page_one_titre'] = " - Sans catégorie -";
$_SESSION['checked_filtre_page'] = "Sans";

}elseif($_POST['recherchepageone'] == "footer"){
$_SESSION['recherche_page_one'] = "AND presence_footer='oui' ";
$_SESSION['recherche_page_one_titre'] = " du footer";
$_SESSION['checked_filtre_page'] = "footer";

}elseif($_POST['recherchepageone'] == "menu"){
$_SESSION['recherche_page_one'] = "AND categorie_menu='oui' AND id_categorie=''";
$_SESSION['recherche_page_one_titre'] = "du menu générales ";
$_SESSION['checked_filtre_page'] = "menu";

}elseif($_POST['recherchepageone'] == "activer"){
$_SESSION['recherche_page_one'] = "AND Statut_page='oui' ";
$_SESSION['recherche_page_one_titre'] = "activées ";
$_SESSION['checked_filtre_page'] = "activer";

}elseif($_POST['recherchepageone'] == "desactiver"){
$_SESSION['recherche_page_one'] = "AND Statut_page='non' ";
$_SESSION['recherche_page_one_titre'] = "désactivées ";
$_SESSION['checked_filtre_page'] = "desactiver";

}elseif($_POST['recherchepageone'] == "fixe"){
$_SESSION['recherche_page_one'] = "AND Page_fixe='oui' ";
$_SESSION['recherche_page_one_titre'] = "fixées ";
$_SESSION['checked_filtre_page'] = "fixe";

}elseif($_POST['recherchepageone'] == "index"){
$_SESSION['recherche_page_one'] = "AND Page_index='oui' ";
$_SESSION['recherche_page_one_titre'] = "- Accueil - ";
$_SESSION['checked_filtre_page'] = "index";

}elseif($_POST['recherchepageone'] == "pas_dans_sitemap"){
$_SESSION['recherche_page_one'] = "AND Declaree_dans_site_map_xml='non' ";
$_SESSION['recherche_page_one_titre'] = "présentes dans le sitemap.xml (Plan du site) ";
$_SESSION['checked_filtre_page'] = "pas_dans_sitemap";

}

}else{
header('location: /index.html');
}

ob_end_flush();
?>