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

require_once('Configurations_bdd.php');
require_once('Configurations.php');
require_once('Configurations_modules.php');

$nowdatesitemap = date('Y-m-d');

header("Content-Type: text/xml");

////////////////////////////////////CONDITIONS SELON MODULES ACTIVES
if($inscription != "oui"){
$inscription_activer_non = "AND Page_inscription!='oui'";
}
if($portefolio != "oui"){
$portefolio_activer_non = "AND Page_portefolio!='oui'";
}
if($blog_actualite != "oui"){
$blog_actualite_activer_non = "AND Page_blog_actualite!='oui'";
}
if($livre_d_or != "oui"){
$livre_d_or_activer_non = "AND Page_livre_d_or!='oui'";
}
////////////////////////////////////CONDITIONS SELON MODULES ACTIVES

echo '<?xml version="1.0" encoding="ISO-8859-1"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';

//////////////////////////////////ACCUEIL
echo "<url>
    <loc>".$http."".$nomsiteweb."/</loc>
    <priority>1.00</priority>
    <lastmod>$nowdatesitemap</lastmod>
    <changefreq>daily</changefreq>";
echo "</url>";
//////////////////////////////////ACCUEIL

//////////////////////////////////PAGES
///////////////////////////////SELECT BOUCLE
$req_boucle = $bdd->prepare("SELECT * FROM pages
	WHERE Declaree_dans_site_map_xml=? 
	AND Statut_page=? 
	ORDER BY Site_map_xml_propriete DESC");
$req_boucle->execute(array(
	'oui',
	'oui'));
while($ligne_boucle = $req_boucle->fetch()){
$id_page_s = $ligne_boucle['id'];
$pagesa_page_s = $ligne_boucle['Page'];
$categorie_menu_page_s = $ligne_boucle['categorie_menu'];
$Ancre_lien_menu_page_s = $ligne_boucle['Ancre_lien_menu'];
$Titre_h1_page_s = $ligne_boucle['Titre_h1'];
$Ancre_fil_ariane_page_s = $ligne_boucle['Ancre_fil_ariane'];
$TitreTitrea_page_s = $ligne_boucle['Title'];
$Metas_description_page_s = $ligne_boucle['Metas_description'];
$Metas_mots_cles_page_s = $ligne_boucle['Metas_mots_cles'];
$Site_map_xml_date_mise_a_jour_page_s = $ligne_boucle['Site_map_xml_date_mise_a_jour'];
$Site_map_xml_propriete_page_s = $ligne_boucle['Site_map_xml_propriete'];
$Site_map_xml_frequence_mise_a_jour_page_s = $ligne_boucle['Site_map_xml_frequence_mise_a_jour'];
$Declaree_dans_site_map_xml_page_s = $ligne_boucle['Declaree_dans_site_map_xml'];
$Statut_page_page_s = $ligne_boucle['Statut_page'];
$Page_index_page_s = $ligne_boucle['Page_index'];

$Page_inscription_page_s = $$ligne_boucle['Page_inscription'];
$Page_portefolio_page_s = $ligne_boucle['Page_portefolio'];
$Page_blog_actualite_page_s = $ligne_boucle['Page_blog_actualite'];
$Page_livre_d_or_page_s = $ligne_boucle['Page_livre_d_or'];

$Page_admin_page_s = $ligne_boucle['Page_admin'];
$Page_fixe_page_s = $ligne_boucle['Page_fixe'];
$date_upadte_p_page_s = $ligne_boucle['date'];

if($pagesa_page_s !="Blog"){
echo "<url>
    <loc>".$http."".$nomsiteweb."/$pagesa_page_s</loc>
    <priority>$Site_map_xml_propriete_page_s</priority>
    <lastmod>$Site_map_xml_date_mise_a_jour_page_s</lastmod>
    <changefreq>$Site_map_xml_frequence_mise_a_jour_page_s</changefreq>";
echo "</url>";
}
}
//////////////////////////////////PAGES

//////////////////////////////////BLOG CATEGORIE
///////////////////////////////SELECT BOUCLE
$req_boucle = $bdd->prepare("SELECT * FROM codi_one_blog_categories WHERE activer='oui' ORDER BY nom_categorie ASC");
$req_boucle->execute();
while($ligne_boucle = $req_boucle->fetch()){
$idoneinfos = $ligne_boucle['id'];
$nom_categorie = $ligne_boucle['nom_categorie'];
$nom_url_categorie = $ligne_boucle['nom_url_categorie'];
$text_categorie = $ligne_boucle['text_categorie'];
$nbr_consultation_blog = $ligne_boucle['nbr_consultation_blog'];
$Title = $ligne_boucle['Title'];
$Metas_description = $ligne_boucle['Metas_description'];
$Metas_mots_cles = $ligne_boucle['Metas_mots_cles'];
$activer_categorie_blog = $ligne_boucle['activer'];
$date_categorie_blog = $ligne_boucle['date'];
$date_categorie_blog_sitemap = date('Y-m-d', $date_categorie_blog);

echo "<url>
    <loc>".$http."".$nomsiteweb."/$nom_url_categorie</loc>
    <priority>0.8</priority>
    <lastmod>$date_categorie_blog_sitemap</lastmod>
    <changefreq>weekly</changefreq>";

echo "</url>";
}
//////////////////////////////////BLOG CATEGORIE

//////////////////////////////////BLOG ARTICLE
///////////////////////////////SELECT BOUCLE
$req_boucle1 = $bdd->prepare("SELECT * FROM codi_one_blog WHERE activer='oui' ORDER BY date_blog DESC");
$req_boucle1->execute();
while($ligne_boucle1 = $req_boucle1->fetch()){
$idoneinfos_artciles_blog = $ligne_boucle1['id'];
$id_categorie_artciles_blog = $ligne_boucle1['id_categorie'];
$titre_blog_1_artciles_blog = $ligne_boucle1['titre_blog_1'];
$titre_blog_2_artciles_blog = $ligne_boucle1['titre_blog_2'];
$url_fiche_blog_artciles_blog = $ligne_boucle1['url_fiche_blog'];
$date_blog_artciles_blog = $ligne_boucle1['date_blog'];
$date_blog_artciles_blog_sitemap = date('Y-m-d', $date_blog_artciles_blog);

echo "<url>
    <loc>".$http."".$nomsiteweb."/$url_fiche_blog_artciles_blog</loc>
    <priority>0.7</priority>
    <lastmod>$date_blog_artciles_blog_sitemap</lastmod>
    <changefreq>weekly</changefreq>";

///////////////////////////////SELECT BOUCLE
$req_boucle2 = $bdd->prepare("SELECT * FROM codi_one_blog_a_b_image WHERE id_page=? ORDER BY id ASC");
$req_boucle2->execute(array($idoneinfos_artciles_blog));
while($ligne_boucle2 = $req_boucle2->fetch()){
$idimmmagee_image_ii = $ligne_boucle2['id'];
$img_lien_image_ii = $ligne_boucle2['img_lien'];
$img_lien2_image_ii = $ligne_boucle2['img_lien2'];
$img_title_image_ii = $ligne_boucle2['img_title'];

if(isset($idimmmagee_image_ii)){
$i++;
echo "<image:image>
<image:loc>".$http."".$nomsiteweb."/images/blog/$img_lien2_image_ii</image:loc>
<image:caption>$titre_blog_1_artciles_blog - $i</image:caption>
<image:title>$titre_blog_1_artciles_blog - $i</image:title>
</image:image>";
unset($idimmmagee_image_ii);
unset($img_title_image_ii);
}

}
unset($i);
echo "</url>";

}
//////////////////////////////////BLOG ARTICLE

echo "</urlset>";

?>