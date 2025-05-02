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

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////MEMBRES ET MODULES
function AdminMembresEtModules(){ 
    global $tchat_module,$messagerie_module,$newsletter_sms_module;
    $AdminMembresEtModules = array(1=>array("Modules","Membres &amp; modules","user"));
    array_push($AdminMembresEtModules, array("Membres","folder","?page=Membres"));
    array_push($AdminMembresEtModules, array("Logs des membres","folder","?page=Membres-logs"));
    array_push($AdminMembresEtModules, array("Produits","tag","?page=Configuration_reference_produit"));
    array_push($AdminMembresEtModules, array("Newsletter","external-link","?page=Newsletter"));
    array_push($AdminMembresEtModules, array("Demandes de souhaits","folder-open","?page=Demandes-de-souhaits"));
    array_push($AdminMembresEtModules, array("Commandes","folder-open-o","?page=Commandes"));
    array_push($AdminMembresEtModules, array("Envoyer colis","cube","?page=Envoyer-colis"));
    array_push($AdminMembresEtModules, array("Abonnés","users","?page=Abonnes"));
    return $AdminMembresEtModules;
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////MEMBRES ET MODULES

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////SI OPERATION CODE PROMOTION ACTIVE
function AdminOperationCodePromotion(){ 
global $Operation_code_promotion;
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////SI OPERATION CODE PROMOTION ACTIVE

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////SI blog
function AdminBlogActualite(){ 
global $blog_actualite;
$AdminBlogActualite = array(1=>array("Blog","Gestions &amp; configurations du blog",""));
array_push($AdminBlogActualite, array("Gestion du Blog","file","?page=Configurations-du-blog"));
array_push($AdminBlogActualite, array("Catégories du Blog","file-text","?page=Categories-du-blog"));
array_push($AdminBlogActualite, array("Gestion des articles","file-text-o","?page=Gestions-du-blog"));
return $AdminBlogActualite;
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////SI blog

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////SI Préférences et configurations
function AdminPreferencesEtConfigurations(){ 
global $page_information_module,$activer_module_referencement;
$AdminPreferencesEtConfigurations = array(1=>array("Préférences","Préférences &amp; configurations",""));
array_push($AdminPreferencesEtConfigurations, array("Pages","file-powerpoint-o","?page=Pages"));
array_push($AdminPreferencesEtConfigurations, array("Préférences","cogs","?page=Preferences"));
array_push($AdminPreferencesEtConfigurations, array("Configurations mail","list-alt","?page=Mise-en-page-mail"));
array_push($AdminPreferencesEtConfigurations, array("Contacts mail","envelope-square","?page=Contacts-mail"));
//array_push($AdminPreferencesEtConfigurations, array("Catégories","share-alt","?page=Categories"));
// array_push($AdminPreferencesEtConfigurations, array("Modes de livraison","car","?page=Modes-de-livraison"));
array_push($AdminPreferencesEtConfigurations, array("Abonnements","cogs","?page=Abonnements"));
array_push($AdminPreferencesEtConfigurations, array("Catégories","cubes","?page=Categories"));
// array_push($AdminPreferencesEtConfigurations, array("Sites recommandés","shopping-cart","?page=Ecommerces"));
array_push($AdminPreferencesEtConfigurations, array("Références produits","users","?page=Configuration_reference_produit"));
array_push($AdminPreferencesEtConfigurations, array("Configurations livraisons","users","?page=configurations_livraisons_gabon"));

//////////////////////////////////////////////////////////////SI MODULE INFORMATIONS ACTIVE
array_push($AdminPreferencesEtConfigurations, array("Informations","exclamation-circle","?page=Informations"));
//array_push($AdminPreferencesEtConfigurations, array("Configurations CMS","cog","?page=Cms"));
return $AdminPreferencesEtConfigurations;
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////SI Préférences et configurations

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////SI Documents commerciaux / Paiement / Panier
function AdminDocumentsCommerciaux(){ 
global $Commandes,$Facturations_module,$paiements_module,$code_promo_module,$Demande_de_devis_page_module,$Devis_module;
$AdminDocumentsCommerciaux = array(1=>array("Documents","Documents commerciaux",""));
array_push($AdminDocumentsCommerciaux, array("Factures","file-pdf-o","?page=Facturations"));
array_push($AdminDocumentsCommerciaux, array("Codes promotions","euro","?page=Codes-promotion"));
//array_push($AdminDocumentsCommerciaux, array("Commandes","file-pdf-o","?page=Commandes"));
//////////////////////////////////////////////////////////////SI MODULE PAIEMENTS / PANIER
// array_push($AdminDocumentsCommerciaux, array("Liste des paniers","shopping-cart","?page=Liste-paniers"));
return $AdminDocumentsCommerciaux;
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////SI Documents commerciaux / Paiement / Panier

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////SI Développements web
function AdminDeveloppementsWeb(){ 
$AdminDeveloppementsWeb = array(1=>array("Développements","Développements web",""));
array_push($AdminDeveloppementsWeb, array("Pack d'icônes","picture-o","/css/icons/icons.html"));
//array_push($AdminDeveloppementsWeb, array("Librairies &amp; Plugins","share-alt","Librairies-plugins"));
//array_push($AdminDeveloppementsWeb, array("Documentations techniques","clipboard","?page=Documentations-techniques"));
//array_push($AdminDeveloppementsWeb, array("Php Infos","exclamation","?page=Php-infos"));
return $AdminDeveloppementsWeb;
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////SI Développements web

/*
echo"<xmp>";
print_r(AdminMembresEtModules());
echo"</xmp>";
exit();
*/

?>