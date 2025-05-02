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

$page = $_GET['page'];

if(!empty($page)){

    switch("$page"){

        case "page-introuvable-404":include ("function/404/404r.php");break;

        ////////////////////////////////////////////////////////////////////////////////////////////////ADMINISTRATION

        //administration
        case "admin-1xDs47f58g511jha5T6yv7s87":include ("administration/admin-1xDs47f58g511jha5T6yv7s87.php");break;

        //Configurations
        //Configurations / Configurations-preferences
        case "Preferences":include ("../administration/Configurations/Configurations-preferences/configurations.php");break;
        //Configurations / Configurations-mails
        case "Mise-en-page-mail":include ("../administration/Configurations/Configurations-mails/configurations.php");break;
        //Configurations / Configurations-informations
        case "Informations":include ("../administration/Configurations/Configurations-informations/Informations.php");break;
        //Configurations / Configurations-mails-contacts
        case "Contacts-mail":include ("../administration/Configurations/Configurations-mails-contacts/contacts-mail.php");break;
        //Configurations / Cms
        case "Cms": include("../administration/Configurations/Configurations-cms/Cms.php");break;

        //Configurations / Configurations-mails-bibliotheques / bibliotheques
        case "configurations-bibliotheques": include("../administration/Configurations/Configurations-mails-bibliotheques/bibliotheques/configurations-bibliotheques.php");break;
        //Configurations / Configurations-mails-bibliotheques / bibliotheques-cles
        //case "configurations-bibliotheques": include("../administration/Configurations/Configurations-mails-bibliotheques/bibliotheques-cles/configurations-bibliotheques.php");break;
        //Configurations / Configurations-mails-bibliotheques / bibliotheques-groupes
        case "configurations-bibliotheques-groupes": include("../administration/Configurations/Configurations-mails-bibliotheques/bibliotheques-groupes/configurations-bibliotheques-groupes.php");break;

        //Modules
        //Modules / Membres
        case "Membres":include ("../administration/Modules/Membres-deprecated/membres.php");break;
        //Modules / Membres logs
        case "Membres-logs":include ("../administration/Modules/Membres-logs/membres-logs.php");break;
        //Modules / Newsletter
        case "Newsletter":include ("../administration/Modules/Newsletters/configurations.php");break;

        //Modules /Blog
        //Modules / Blog / Configurations
        case "Configurations-du-blog":include ("../administration/Modules/Blog/Configurations/configurations-du-blog.php");break;
        //Modules / Blog / Categorie
        case "Categories-du-blog":include ("../administration/Modules/Blog/Categories/categories-du-blog.php");break;
        //Modules / Blog / Article
        case "Gestions-du-blog":include ("../administration/Modules/Blog/Articles/gestions-du-blog.php");break;
        //Modules / Blog / Photos
        case "Photos-blog":include ("../administration/Modules/Blog/Articles/photos-blog.php");break;
        //Modules / Membres-moderateurs / Moderateurs
        case "Moderateurs": include("../administration/Modules/Membres-moderateurs/Moderateurs/Moderateurs.php"); break;
        //Modules / Membres-moderateurs / Moderateurs-groupes
        case "Moderateurs-groupes": include("../administration/Modules/Membres-moderateurs/Moderateurs-groupes/Moderateurs-groupes.php"); break;
        //Modules / Membres-moderateurs / Moderateurs-groupes-modules
        case "Moderateurs-groupes-modules": include("../administration/Modules/Membres-moderateurs/Moderateurs-groupes-modules/Moderateurs-groupes-modules.php"); break;
        //Modules / Membres-moderateurs / Moderateurs-modules
        case "Moderateurs-modules": include("../administration/Modules/Membres-moderateurs/Moderateurs-modules/Moderateurs-modules.php"); break;
        //Modules / Blocs-publicites
        case "Blocs-publicites": include("../administration/Modules/Blocs-publicites/Blocs-publicites.php"); break;
        case "Photos-publicites-banniere": include("../administration/Modules/Blocs-publicites/photos-banniere.php"); break;
        //Modules / Code promo
        case "Codes-promotion": include("../administration/Modules/Codes-promotions/Codes-promotion.php"); break;
        //Modules / Factures
        case "Facturations": include("../administration/Modules/Facturations/Facturations.php"); break;

        //Modules / Modes-de-livraison
        case "Modes-de-livraison": include("../administration/Modules/Modes-de-livraison/Modes-de-livraison.php"); break;

        //Modules / Catégorie
        case "Categories": include("../administration/Modules/Categories/Categories.php"); break;

        //Modules / Commandes
        case "Commandes": include("../administration/Modules/Commandes/Commandes.php"); break;

        //Demandes-de-souhaits / Demandes-de-souhaits
        case "Demandes-de-souhaits": include("../administration/Modules/Demandes-de-souhaits/Demandes-de-souhaits.php"); break;

        //Modules / Envoyer-colis
        case "Envoyer-colis": include("../administration/Modules/Envoyer-colis/Envoyer-colis.php"); break;

        //Modules / Abonnements
        case "Abonnements": include("../administration/Modules/Abonnements/Abonnements.php"); break;

        //Modules / Abonnes
        case "Abonnes": include("../administration/Modules/Abonnes/Abonnes.php"); break;
   
        //Modules / Configuration_reference_produit
        case "Configuration_reference_produit": include("../administration/Modules/Configuration_reference_produit/Configuration_reference_produit.php"); break;

           //Modules / Configurations_livraisons_gabon
        case "configurations_livraisons_gabon": include("../administration/Modules/configurations_livraisons_gabon/configurations_livraisons_gabon.php"); break;

           //Modules / Ecommerces
        case "Ecommerces": include("../administration/Modules/Ecommerces/Ecommerces.php"); break;

        //Pages
        //Pages / Pages
        case "Pages":include ("../administration/Pages/Pages/pages.php");break;
        //Pages / Pages / Photos
        case "Photos-page":include ("../administration/Pages/Pages/photos-pages.php");break;
        //Pages / Pages-301
        case "Pages-301":include ("../administration/Pages/Pages-301/pages-301.php");break;
        //Pages / Pages-404
        case "Pages-404":include ("../administration/Pages/Pages-404/pages-404.php");break;
        //Pages / Pages-bandeaux
        case "Pages-bandeaux":include ("../administration/Pages/Pages-bandeaux/pages-bandeaux.php");break;
        //Pages /  Pages         

    }

////////////////////////////////////////////////////////////////////////////////////////////////PAGE HOME

}
elseif(empty($page))
{

    include ("../administration/index-admin-modules-deprecated.php");

}

?>