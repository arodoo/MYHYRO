<?php
ob_start();
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

////////////////////////////////////DEMANDE DE DE DEVIS FRONT
if($Demande_de_devis_page_module == "oui"){

$now = time();
$nowdatesitemap = date('Y-m-d');

///////////////////////////////DELETE
$sql_delete = $bdd->prepare("DELETE FROM pages WHERE Page='Demande-de-devis-gratuit' ");
$sql_delete->execute(array($idaction));                     
$sql_delete->closeCursor();

///////////////////////////////INSERT
$sql_insert = $bdd->prepare("INSERT INTO pages
	(id,
	id_categorie,
	id_image_parallaxe_banniere,
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
	Page_index,
	Page_inscription,
	Page_portefolio,
	Page_blog_actualite,
	Page_livre_d_or,
	Page_fixe,
	Page_type_module_ou_page,
	Page_admin_associee,
	date,
	Page_index_accueil_bloc_Icones,
	Page_index_accueil_bloc_Icones_Titre,
	Page_index_accueil_bloc_Icones_paragraphe,
	Page_index_accueil_bloc_Icones_height_bloc,
	Page_index_accueil_bloc_Item,
	Page_index_accueil_bloc_Item_Titre,
	Page_index_accueil_bloc_Item_paragraphe,
	Page_index_accueil_bloc_blog,
	Page_index_accueil_bloc_blog_Titre,
	Page_index_accueil_bloc_blog_paragraphe,
	Page_index_accueil_bloc_avis,
	Page_index_accueil_bloc_avis_Titre,
	Page_index_accueil_bloc_avis_paragraphe,
	Page_index_accueil_bloc_newsletter,
	Page_index_accueil_bloc_newsletter_Titre,
	Page_index_accueil_bloc_newsletter_paragraphe,
	Page_index_accueil_bloc_Google_Map,
	Prix_services_produits,
	Libelle_services_produits,
	Stock_services_produits,
	Type_de_quantite,
	Destination_services_produits,
	Gestion_des_stocks_services_produits,
	Stocks_services_produits,
	afficher_reseaux_sociaux_page,
	contenu_video,
	plus,
	plus1)
	VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
$sql_insert->execute(array(
	'',
	'',
	'',
	'Demande-de-devis-gratuit',
	'Demande-de-devis-gratuit',
	'',
	'oui',
	'1',
	'Demande de devis',
	'oui',
	'1',
	'Demande de devis',
	'Demande de devis',
	'Demande de devis',
	'Demande de devis gratuit',
	'Demande de devis gratuit en ligne pour cotation, prix, estimation, renseignements, informations, tarif',
	'Demande de devis gratuit en ligne pour cotation, prix, estimation, renseignements, informations, tarif',
	$nowdatesitemap,
	'0.9',
	'weekly',
	'oui',
	'oui',
	'',
	'',
	'',
	'',
	'',
	'',
	'oui',
	'Module',
	'',
	$now,
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	''));                     
$sql_insert->closeCursor();

}else{

///////////////////////////////DELETE
$sql_delete = $bdd->prepare("DELETE FROM pages WHERE Page='Demande-de-devis-gratuit' ");
$sql_delete->execute(array($idaction));                     
$sql_delete->closeCursor();

}
////////////////////////////////////DEMANDE DE DE DEVIS FRONT

////////////////////////////////////SI TYPE CMS 1 PAS D'INSCRIPTION - PAS DE TRAITEMENT DE DONNEE NI DE CGU
if($id_type_cms != "1"){

$now = time();
$nowdatesitemap = date('Y-m-d');

$contenu_traitement_de_donne = "
<br /> <br /> La s&eacute;curit&eacute; et la protection de vos donn&eacute;es personnelles (ci-apr&egrave;s les &laquo; donn&eacute;es &raquo;) sont de la plus haute importance pour nous. Nous respectons strictement l'ensemble des normes Europ&eacute;ennes et la loi fran&ccedil;aise applicable sur la protection des donn&eacute;es lors de la collecte, du traitement et de l'utilisation (ci-apr&egrave;s d&eacute;sign&eacute;s collectivement par le &laquo; traitement &raquo;) de vos donn&eacute;es.<br /><br />La pr&eacute;sente Politique d'utilisation des donn&eacute;es personnelles vise &agrave; vous informer du traitement de vos donn&eacute;es dans le cadre de votre visite sur notre site internet et de votre utilisation des services suppl&eacute;mentaires propos&eacute;s par notre société. Nous nous r&eacute;servons le droit de modifier cette Politique d'utilisation des donn&eacute;es personnelles &agrave; tout moment. Les modifications seront publi&eacute;es sur notre site et prendront effet imm&eacute;diatement, sauf stipulation contraire. Par cons&eacute;quent, nous vous conseillons de consulter r&eacute;guli&egrave;rement cette Politique d'utilisation des donn&eacute;es personnelles afin d'acc&eacute;der &agrave; sa version la plus r&eacute;cente.<br />
<h2>1- Donn&eacute;es &agrave; caract&egrave;re personnel</h2>
<br />De mani&egrave;re g&eacute;n&eacute;rale, vous pouvez vous rendre sur notre site internet sans qu&rsquo;il soit besoin de communiquer des donn&eacute;es &agrave; caract&egrave;re personnel. Il se peut, afin de mieux r&eacute;pondre &agrave; vos besoins, que nous vous demandions de nous fournir des donn&eacute;es &agrave; caract&egrave;re personnel vous concernant, par exemple, pour &eacute;tablir une correspondance, traiter une demande&hellip;Par &laquo; donn&eacute;e &agrave; caract&egrave;re personnel &raquo;, nous entendons toute information relative &agrave; une personne identifi&eacute;e ou pouvant &ecirc;tre identifi&eacute;e, directement ou indirectement, en r&eacute;f&eacute;rence &agrave; un num&eacute;ro d'identification ou &agrave; des facteurs propres &agrave; ses caract&eacute;ristiques physiques, physiologiques, mentales, &eacute;conomiques, culturelles ou sociales, comme son nom, son adresse, son num&eacute;ro de t&eacute;l&eacute;phone ou son adresse e-mail.<br />
<h2>2- Traitement et collecte des donn&eacute;es</h2>
<br />Nous traitons vos donn&eacute;es uniquement dans la mesure du n&eacute;cessaire et dans la limite autoris&eacute;e par la loi (par exemple, lorsque cela s'av&egrave;re n&eacute;cessaire &agrave; des fins contractuelles ou pour vous permettre d'utiliser notre site), ou encore dans la mesure o&ugrave; vous nous y avez express&eacute;ment autoris&eacute;s. Ces restrictions s'appliquent &eacute;galement aux &eacute;changes de donn&eacute;es au sein de notre entreprise. Nous collectons des donn&eacute;es &agrave; caract&egrave;re personnel, et informe la personne concern&eacute;e au moment ou avant de les collecter et en tout cas avant de les utiliser dans les buts d&eacute;finis.<br />
<h2>3- Utilisation des donn&eacute;es collect&eacute;es</h2>
<br />Nous utilisons les donn&eacute;es &agrave; caract&egrave;re personnel dans la stricte limite des buts pour lesquels elles ont &eacute;t&eacute; collect&eacute;es.<br /><br />A titre d&rsquo;exemple, nous pourrions vous demander vos donn&eacute;es &agrave; caract&egrave;re personnel pour :<br /><br />&bull;&nbsp;&nbsp;&nbsp; Vous fournir des informations sur ses produits et services<br />&bull;&nbsp;&nbsp;&nbsp; Vous &eacute;diter des factures, devis, commandes<br />&bull;&nbsp;&nbsp;&nbsp; Vous &eacute;diter un cahier des charges pour chiffrer votre projet<br />&bull;&nbsp;&nbsp;&nbsp; Pour tous nos outils de suivi de projet<br />&bull;&nbsp;&nbsp; Vous fournir des informations sur ses produits et services<br />&bull;&nbsp;&nbsp;&nbsp; Ex&eacute;cuter et suivre vos transactions<br />&bull;&nbsp;&nbsp;&nbsp; Participer aux aspects interactifs de ses sites <br />&bull;&nbsp;&nbsp;&nbsp; Communiquer, d&eacute;velopper des relations commerciales avec vous<br /><br />Nous nous s&rsquo;engageons &agrave; ne pas utiliser vos donn&eacute;es &agrave; caract&egrave;re personnel &agrave; des fins de prospection commerciale sans avoir pr&eacute;alablement obtenu votre consentement. <br />
<h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3 - 1. Inscription et enregistrement</h3>
<br />Vous pouvez vous enregistrer pour acc&eacute;der &agrave; des services suppl&eacute;mentaires. Vous serez invit&eacute; &agrave; fournir des donn&eacute;es personnelles ainsi que des informations sp&eacute;cifiques au produit le cas &eacute;ch&eacute;ant. Nous utiliserons les donn&eacute;es collect&eacute;es via le formulaire d'enregistrement uniquement pour les finalit&eacute;s expliquer dans l&rsquo;article 3 de cette pr&eacute;sente politique de traitement &agrave; caract&egrave;re personnel.<br />
<h3>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;3 - 2. Contact</h3>
<br />Vous pouvez nous envoyer des questions &agrave; l'aide du formulaire de contact disponible sur notre site. Pour pouvoir r&eacute;pondre &agrave; votre question, nous avons besoin de vos coordonn&eacute;es, par exemple votre nom, pr&eacute;nom, soci&eacute;t&eacute;, le sujet, le contenu du message, num&eacute;ro de t&eacute;l&eacute;phone et/ou votre adresse e-mail. Vous pouvez &eacute;galement y joindre des pi&egrave;ces en les t&eacute;l&eacute;chargements sur le formulaire. Nous utiliserons les donn&eacute;es collect&eacute;es via le formulaire de contact uniquement pour r&eacute;pondre &agrave; votre question.<br />
<h2>4- Dur&eacute;e de conservation des donn&eacute;es</h2>
<br />Nous nous ne conserverons pas les donn&eacute;es &agrave; caract&egrave;re personnel plus longtemps qu&rsquo;il n&rsquo;est n&eacute;cessaire au regard des buts pour lesquels elles ont &eacute;t&eacute; collect&eacute;es ou plus longtemps que le pr&eacute;voit la loi en vigueur.<br />
<h2>5- Exercice des droits associ&eacute;s aux utilisateurs</h2>
<br />Le r&egrave;glement n&deg; 2016/679, dit r&egrave;glement g&eacute;n&eacute;ral sur la protection des donn&eacute;es (RGPD) (en anglais : General Data Protection Regulation, GDPR), constitue le texte de r&eacute;f&eacute;rence europ&eacute;en en mati&egrave;re de protection des donn&eacute;es &agrave; caract&egrave;re personnel. ll renforce et unifie la protection des donn&eacute;es pour les individus au sein de l'Union europ&eacute;enne.<br />Apr&egrave;s quatre ann&eacute;es de n&eacute;gociations l&eacute;gislatives, le nouveau r&egrave;glement europ&eacute;en sur la protection des donn&eacute;es a &eacute;t&eacute; d&eacute;finitivement adopt&eacute; par le Parlement europ&eacute;en le 14 avril 2016. Ses dispositions seront directement applicables dans l'ensemble des 28 &Eacute;tats membres de l'Union europ&eacute;enne &agrave; compter du 25 mai 2018.<br />Ce r&egrave;glement remplace la directive sur la protection des donn&eacute;es personnelles adopt&eacute;e en 1995 (article 94(1) du r&egrave;glement).<br /><br />Conform&eacute;ment aux r&egrave;glements Europ&eacute;ens sur le traitement des donn&eacute;es &agrave; caract&egrave;re personnel, toute personne peut obtenir l&rsquo;information, l&rsquo;acc&egrave;s, la communication, le portage, la rectification, droit &agrave; l&rsquo;opposition, la suppression, la limitation dans le temps de ses donn&eacute;es personnelles. Ce droit&nbsp; d'exerce au sein de notre société &nbsp; peut effectuer sa demande par postale avec un courrier recommand&eacute; par AR, aupr&egrave;s du responsable de la publication, en justifiant de son identit&eacute;. A r&eacute;ception nous traiterons votre demande dans un d&eacute;lai inf&eacute;rieur &agrave; un mois. Le courrier doit &ecirc;tre constitu&eacute; de (Par l&rsquo;utilisateur demand&eacute;) : nom pr&eacute;nom, adresse, t&eacute;l&eacute;phone, site internet concern&eacute;, le ca &eacute;ch&eacute;ant, la liste des donn&eacute;es personnelles ou la demande explicite associ&eacute; au portage, l&rsquo;adresse mail, photocopie recto-verso de la carte d&rsquo;identit&eacute;, la demande de droit concern&eacute;e.<br />
<h2>6- S&eacute;curit&eacute; des donn&eacute;es</h2>
<br />Nous avons mis en place des mesures de protection pour assurer la confidentialit&eacute;, la s&eacute;curit&eacute; et l&rsquo;int&eacute;grit&eacute; des donn&eacute;es &agrave; caract&egrave;re personnel vous concernant. L&rsquo;acc&egrave;s aux donn&eacute;es &agrave; caract&egrave;re personnel est restreint aux salari&eacute;s qui ont besoin de les conna&icirc;tre et qui ont &eacute;t&eacute; form&eacute;s &agrave; l&rsquo;observation de r&egrave;gles en mati&egrave;re de confidentialit&eacute;.<br />Nous veillons, notamment, &agrave; ce que vos donn&eacute;es &agrave; caract&egrave;re personnel ne soient pas d&eacute;form&eacute;es, endommag&eacute;es ou que des tiers non autoris&eacute;s n&rsquo;y aient acc&egrave;s.<br />
<h2>7- Cookies</h2>
<br />Nous recueillons des donn&eacute;es relatives &agrave; l&rsquo;utilisation que vous faites de nos sites internet pour offrir un meilleur service aux visiteurs et utilisateurs de ces sites, par l&rsquo;utilisation des cookies, qui sont des fichiers que votre navigateur internet place sur votre disque dur lorsque vous visitez un site. Les cookies ne permettent pas de vous identifier personnellement. Les donn&eacute;es enregistr&eacute;es peuvent &ecirc;tre les pages que vous avez consult&eacute;es, la date et l&rsquo;heure de consultation ou d&rsquo;autres donn&eacute;es de suivi. <br /><br />Vous pouvez param&eacute;trer votre navigateur pour qu&rsquo;il vous avertisse de la pr&eacute;sence de cookies vous laissant ainsi le loisir de les accepter ou non. Vous pouvez &eacute;galement param&eacute;trer votre navigateur pour d&eacute;sactiver les cookies.<br />&nbsp;
<h2>&nbsp;8- Liens vers des sites internet tiers</h2>
<br />Notre site internet peut comporter des liens vers des sites tiers. Nous ne contr&ocirc;lons pas ces sites et ainsi ne saurait &ecirc;tre tenu responsable de leurs pratiques en mati&egrave;re de confidentialit&eacute; ou de leur contenu. Ainsi, nous vous invitons &agrave; vous renseigner sur les politiques de ces sites en mati&egrave;re de protection des donn&eacute;es &agrave; caract&egrave;re personnel, avant de les utiliser ou de leur fournir des donn&eacute;es &agrave; caract&egrave;re personnel. <br /><br /><span>Consentement aux pr&eacute;sentes pratiques</span><br /><br /><strong>En utilisant ce site, vous consentez aux pr&eacute;sentes pratiques. Si vous &ecirc;tes en d&eacute;saccord avec les termes de ces pratiques, veuillez ne pas utiliser ce site et ne fournir aucune donn&eacute;e &agrave; caract&egrave;re personnel.</strong>
";

///////////////////////////////DELETE
$sql_delete = $bdd->prepare("DELETE FROM pages WHERE Page='Traitements-de-mes-donnees' ");
$sql_delete->execute();                     
$sql_delete->closeCursor();

///////////////////////////////DELETE
$sql_delete = $bdd->prepare("DELETE FROM pages WHERE Page='CGU-CGV' ");
$sql_delete->execute(array($idaction));                     
$sql_delete->closeCursor();

///////////////////////////////INSERT
$sql_insert = $bdd->prepare("INSERT INTO pages
	(id,
	id_categorie,
	id_image_parallaxe_banniere,
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
	Page_index,
	Page_inscription,
	Page_portefolio,
	Page_blog_actualite,
	Page_livre_d_or,
	Page_fixe,
	Page_type_module_ou_page,
	Page_admin_associee,
	date,
	Page_index_accueil_bloc_Icones,
	Page_index_accueil_bloc_Icones_Titre,
	Page_index_accueil_bloc_Icones_paragraphe,
	Page_index_accueil_bloc_Icones_height_bloc,
	Page_index_accueil_bloc_Item,
	Page_index_accueil_bloc_Item_Titre,
	Page_index_accueil_bloc_Item_paragraphe,
	Page_index_accueil_bloc_blog,
	Page_index_accueil_bloc_blog_Titre,
	Page_index_accueil_bloc_blog_paragraphe,
	Page_index_accueil_bloc_avis,
	Page_index_accueil_bloc_avis_Titre,
	Page_index_accueil_bloc_avis_paragraphe,
	Page_index_accueil_bloc_newsletter,
	Page_index_accueil_bloc_newsletter_Titre,
	Page_index_accueil_bloc_newsletter_paragraphe,
	Page_index_accueil_bloc_Google_Map,
	Prix_services_produits,
	Libelle_services_produits,
	Stock_services_produits,
	Type_de_quantite,
	Destination_services_produits,
	Gestion_des_stocks_services_produits,
	Stocks_services_produits,
	afficher_reseaux_sociaux_page,
	contenu_video,
	plus,
	plus1)	VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
$sql_insert->execute(array(
	'',
	'',
	'',
	'Traitements-de-mes-donnees',
	'Traitements-de-mes-donnees',
	$contenu_traitement_de_donne,
	'non',
	'',
	'',
	'non',
	'',
	'',
	'Traitements de mes données',
	'Traitements de mes données',
	'Traitements de mes données',
	'Traitements de mes données',
	'Traitements de mes données',
	$nowdatesitemap,
	'0.9',
	'weekly',
	'oui',
	'oui',
	'',
	'',
	'',
	'',
	'',
	'',
	'oui',
	'Module',
	'',
	$now,
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	''));                     
$sql_insert->closeCursor();

///////////////////////////////INSERT
$sql_insert = $bdd->prepare("INSERT INTO pages
	(id,
	id_categorie,
	id_image_parallaxe_banniere,
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
	Page_index,
	Page_inscription,
	Page_portefolio,
	Page_blog_actualite,
	Page_livre_d_or,
	Page_fixe,
	Page_type_module_ou_page,
	Page_admin_associee,
	date,
	Page_index_accueil_bloc_Icones,
	Page_index_accueil_bloc_Icones_Titre,
	Page_index_accueil_bloc_Icones_paragraphe,
	Page_index_accueil_bloc_Icones_height_bloc,
	Page_index_accueil_bloc_Item,
	Page_index_accueil_bloc_Item_Titre,
	Page_index_accueil_bloc_Item_paragraphe,
	Page_index_accueil_bloc_blog,
	Page_index_accueil_bloc_blog_Titre,
	Page_index_accueil_bloc_blog_paragraphe,
	Page_index_accueil_bloc_avis,
	Page_index_accueil_bloc_avis_Titre,
	Page_index_accueil_bloc_avis_paragraphe,
	Page_index_accueil_bloc_newsletter,
	Page_index_accueil_bloc_newsletter_Titre,
	Page_index_accueil_bloc_newsletter_paragraphe,
	Page_index_accueil_bloc_Google_Map,
	Prix_services_produits,
	Libelle_services_produits,
	Stock_services_produits,
	Type_de_quantite,
	Destination_services_produits,
	Gestion_des_stocks_services_produits,
	Stocks_services_produits,
	afficher_reseaux_sociaux_page,
	contenu_video,
	plus,
	plus1)	VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
$sql_insert->execute(array(
	'',
	'',
	'',
	'CGU-CGV',
	'CGU-CGV',
	'',
	'non',
	'',
	'',
	'non',
	'',
	'',
	'CGU / CGV',
	'CGU / CGV',
	'CGU / CGV',
	'CGU / CGV',
	'CGU / CGV',
	$nowdatesitemap,
	'0.9',
	'weekly',
	'oui',
	'oui',
	'',
	'',
	'',
	'',
	'',
	'',
	'oui',
	'Module',
	'',
	$now,
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	''));                     
$sql_insert->closeCursor();

}else{

///////////////////////////////DELETE
$sql_delete = $bdd->prepare("DELETE FROM pages WHERE Page='Traitements-de-mes-donnees' ");
$sql_delete->execute();                     
$sql_delete->closeCursor();

///////////////////////////////DELETE
$sql_delete = $bdd->prepare("DELETE FROM pages WHERE Page='CGU-CGV' ");
$sql_delete->execute(array($idaction));                     
$sql_delete->closeCursor();

}
////////////////////////////////////DEMANDE DE DE DEVIS FRONT

////////////////////////////////////SI TYPE CMS PAS D'INSCRIPTION - PAS DE TRAITEMENT DE DONNEE NI DE CGU

ob_end_flush();
?>