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

/////////////////////////////////////////////////////////////////////////////////////Requêtes des pages

$pageencours = urlencode($_SERVER['REQUEST_URI']);
$pageencours = urldecode($pageencours); 
$pageencours = utf8_decode($pageencours);

$pageencoursnew_len = strlen($pageencours);
$pageencoursnew = substr($pageencours,1);

///////////////////////////////SELECT
if($_GET['page'] == "blog"){
$req_select = $bdd->prepare("SELECT * FROM pages WHERE Page=?");
$req_select->execute(array("Blog"));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();

}elseif($_GET['page'] == "page-dynamique" ){
$req_select = $bdd->prepare("SELECT * FROM pages WHERE Page=? ORDER BY id DESC");
$req_select->execute(array($pageencoursnew));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();

}elseif(!empty($_GET['page'])){
$req_select = $bdd->prepare("SELECT * FROM pages WHERE Page=? || Page=? ORDER BY id DESC");
$req_select->execute(array($pageencoursnew,""));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();

}else{
/////////////////////SI PAGINATION PAGE - CONDITION
/////////////////////SINON PAR DEFAULT
$req_select = $bdd->prepare("SELECT * FROM pages WHERE Page=?");
$req_select->execute(array(""));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();

}

/////////////////////SINON PAR DEFAULT
$id_page = $ligne_select['id'];
$id_page_page = $ligne_select['id'];
$id_categorie = $ligne_select['id_categorie'];
$id_image_parallaxe_banniere = $ligne_select['id_image_parallaxe_banniere'];
$pagesa_page = $ligne_select['Page'];
$pagesa_nom_page = $ligne_select['Page_nom'];
$contenu_page = $ligne_select['contenu_de_la_page'];
$categorie_menu_page = $ligne_select['categorie_menu'];
$Ancre_lien_menu_page = $ligne_select['Ancre_lien_menu'];
$Titre_h1_page = $ligne_select['Titre_h1'];
$Ancre_fil_ariane_page = $ligne_select['Ancre_fil_ariane'];
$Page_inscription_page = $ligne_select['Page_inscription'];
$Page_portefolio_page = $ligne_select['Page_portefolio'];
$Page_blog_actualite_page = $ligne_select['Page_blog_actualite'];
$Page_livre_d_or_page = $ligne_select['Page_livre_d_or'];

$TitreTitrea_page = $ligne_select['Title'];
$Metas_description_page = $ligne_select['Metas_description'];
$Metas_mots_cles_page = $ligne_select['Metas_mots_cles'];

$Site_map_xml_date_mise_a_jour_page = $ligne_select['Site_map_xml_date_mise_a_jour'];
$Site_map_xml_propriete_page = $ligne_select['Site_map_xml_propriete'];
$Site_map_xml_frequence_mise_a_jour_page = $ligne_select['Site_map_xml_frequence_mise_a_jour'];
$Declaree_dans_site_map_xml_page = $ligne_select['Declaree_dans_site_map_xml'];
$Statut_page_page = $ligne_select['Statut_page'];
$Page_index_page = $ligne_select['Page_index'];
$Page_admin_page = $ligne_select['Page_admin'];
$Page_fixe_page = $ligne_select['Page_fixe'];
$date_upadte_p_page = $ligne_select['date'];

$Page_index_accueil_bloc_Item = $ligne_select['Page_index_accueil_bloc_Item'];
$Page_index_accueil_bloc_Item_Titre = $ligne_select['Page_index_accueil_bloc_Item_Titre'];
$Page_index_accueil_bloc_Item_paragraphe = $ligne_select['Page_index_accueil_bloc_Item_paragraphe'];

$Page_index_accueil_bloc_Icones = $ligne_select['Page_index_accueil_bloc_Icones'];
$Page_index_accueil_bloc_Icones_Titre = $ligne_select['Page_index_accueil_bloc_Icones_Titre'];
$Page_index_accueil_bloc_Icones_paragraphe = $ligne_select['Page_index_accueil_bloc_Icones_paragraphe'];
$Page_index_accueil_bloc_Icones_height_bloc = $ligne_select['Page_index_accueil_bloc_Icones_height_bloc'];

$Page_index_accueil_bloc_Bandeau_image = $ligne_select['Page_index_accueil_bloc_Bandeau_image'];
$Page_index_accueil_bloc_Bandeau_image_upload = $ligne_select['Page_index_accueil_bloc_Bandeau_image_upload'];
$Page_index_accueil_bloc_Bandeau_image_Titre = $ligne_select['Page_index_accueil_bloc_Bandeau_image_Titre'];
$Page_index_accueil_bloc_Bandeau_image_paragraphe = $ligne_select['Page_index_accueil_bloc_Bandeau_image_paragraphe'];

$Page_index_accueil_bloc_blog = $ligne_select['Page_index_accueil_bloc_blog'];
$Page_index_accueil_bloc_blog_Titre = $ligne_select['Page_index_accueil_bloc_blog_Titre'];
$Page_index_accueil_bloc_blog_paragraphe = $ligne_select['Page_index_accueil_bloc_blog_paragraphe'];

$Page_index_accueil_bloc_avis = $ligne_select['Page_index_accueil_bloc_avis'];
$Page_index_accueil_bloc_avis_Titre = $ligne_select['Page_index_accueil_bloc_avis_Titre'];
$Page_index_accueil_bloc_avis_paragraphe = $ligne_select['Page_index_accueil_bloc_avis_paragraphe'];

$Page_index_accueil_bloc_newsletter = $ligne_select['Page_index_accueil_bloc_newsletter'];
$Page_index_accueil_bloc_newsletter_Titre = $ligne_select['Page_index_accueil_bloc_newsletter_Titre'];
$Page_index_accueil_bloc_newsletter_paragraphe = $ligne_select['Page_index_accueil_bloc_newsletter_paragraphe'];

$Prix_services_produits = $ligne_select['Prix_services_produits'];
$Libelle_services_produits = $ligne_select['Libelle_services_produits'];
$Stock_services_produits = $ligne_select['Stock_services_produits'];
$Destination_services_produits = $ligne_select['Destination_services_produits'];
$Gestion_des_stocks_services_produits = $ligne_select['Gestion_des_stocks_services_produits'];
$Stocks_services_produits = $ligne_select['Stocks_services_produits'];
$Type_de_quantite = $ligne_select['Type_de_quantite'];
$afficher_reseaux_sociaux_page = $ligne_select['afficher_reseaux_sociaux_page'];

$contenu_video = $ligne_select['contenu_video'];

/////////////SI PAGINATION
if(!empty($_GET['n'])){
$title_page_numero = "/ Page ".$_GET['n']."";
$TitreTitrea_page = "$TitreTitrea_page - Page ".$_GET['n']."";
$page_number_Metas_description = "Page ".$_GET['n']."";
$page_number_metas_keyword = "".$Metas_mots_cles_page.", Page ".$_GET['n']."";
}
/////////////SI PAGINATION

///////////BLOG
if($_GET['page'] == "blog" && !empty($_GET['fiche']) && !empty($_GET['idaction'])){

////////////SI FICHE BLOG
///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM codi_one_blog WHERE id=?");
$req_select->execute(array($_GET['idaction']));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$idoneinfos_artciles_blog = $ligne_select['id'];
$id_categorie_artciles_blog = $ligne_select['id_categorie'];
$url_fiche_blog_artciles_blog = $ligne_select['url_fiche_blog'];
$titre_blog_1_artciles_blog = $ligne_select['titre_blog_1'];
$Title_artciles_blog = $ligne_select['Title'];
$Metas_description_artciles_blog = $ligne_select['Metas_description'];
$Metas_mots_cles_artciles_blog = $ligne_select['Metas_mots_cles'];

$TitreTitrea_page = "$Title_artciles_blog $title_page_numero";
$Metas_description_page = "$Metas_description_artciles_blog $page_number_Metas_description";
$Metas_mots_cles_page = "$Metas_mots_cles_artciles_blog $page_number_metas_keyword";
////////////SI FICHE BLOG

}elseif($_GET['page'] == "blog" && $_GET['action'] == "Categorie" && !empty($_GET['idaction'])){

////////////SI CATEGORIE BLOG
///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM codi_one_blog_categories WHERE id=?");
$req_select->execute(array($_GET['idaction']));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$idoneinfos_categorie_blog = $ligne_select['id'];
$nom_url_categorie = $ligne_select['nom_url_categorie'];
$Title_categorie_blog = $ligne_select['Title'];
$Metas_description_categorie_blog = $ligne_select['Metas_description'];
$Metas_mots_cles_categorie_blog = $ligne_select['Metas_mots_cles'];

$TitreTitrea_page = "$Title_categorie_blog $title_page_numero";
$Metas_description_page = "$Metas_description_categorie_blog $page_number_Metas_description";
$Metas_mots_cles_page = "$Metas_mots_cles_categorie_blog $page_number_metas_keyword";
////////////SI CATEGORIE BLOG


}elseif($_GET['page'] == "Sites-d-achats-recommandes" && !empty($_GET['idaction'])){

////////////////////////Si url est lié à une page
///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM categories WHERE id=?");
$req_select->execute(array($_GET['idaction']));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();

$TitreTitrea_page = "".$ligne_select['nom_categorie']." - $TitreTitrea_page";
$Metas_description_page = "".$ligne_select['nom_categorie']." - $Metas_description_page ";
$Metas_mots_cles_page = "".$ligne_select['nom_categorie']." - $Metas_mots_cles_page";
////////////////////////Si url est lié à une page

}elseif(isset($id_page)){

////////////////////////Si url est lié à une page
$TitreTitrea_page = "$TitreTitrea_page";
$Metas_description_page = "$Metas_description_page ";
$Metas_mots_cles_page = "$Metas_mots_cles_page";
////////////////////////Si url est lié à une page

}else{

///////////////////////Page accueil
$TitreTitrea_page = "$TitreTitrea_page_defaut $title_page_numero";
$Metas_description_page = "$Metas_description_page_defaut $page_number_Metas_description";
$Metas_mots_cles_page = "$Metas_mots_cles_page_defaut $page_number_metas_keyword";
///////////////////////Page accueil

}
//METAS

/////////////////////////////////////////////////////////////////////////////////////Requêtes des pages

///////////////////////////////PAGINATION PAR DEFAUT
if(empty($_GET['n'])){ $_GET['n'] = 1; }
///////////////////////////////PAGINATION PAR DEFAUT

?>

