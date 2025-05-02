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

if(!empty($_GET['page'])){
switch($_GET['page']){

case "page-introuvable-404":include ("function/404/404r.php");break;

//www
case "sitemap":include ("sitemap.php");break;

//Sites-d-achats-recommandes
case "Sites-d-achats-recommandes":include ("pages/Sites-d-achats-recommandes.php");break;

//Boutique
case "Boutique":include ("pages/Boutique/Boutique.php");break;

//Boutique-fiche
case "Boutique-fiche":include ("pages/Boutique/Boutique-fiche.php");break;

//Pages
case "Avis":include ("pages/avis/Avis.php");break;
// Comment-ca-marche
case "Comment-ca-marche":include ("pages/Comment-ca-marche.php");break;

//Contact
case "Contact":include ("pages/contact/contact.php");break;
//Page dynamique
case "page-dynamique":include ("pages/page-dynamique/page-dynamique.php");break;
//Page catégorie dynamique
case "page-categorie-dynamique":include ("pages/page-dynamique/page-categorie-dynamique.php");break;
//Pages / Blog
case "blog":include ("pages/blog/blog.php");break;
//Newsletter
case "Desabonnement-lettre-information":include ("function/Newsletter/Desabonnement-lettre-information.php");break;
case "Abonnement-lettre-information":include ("function/Newsletter/Abonnement-lettre-information.php");break;
//Abonnements
case "Abonnements":include ("pages/Abonnements/Abonnements.php");break;
//Recherche
case "Recherche":include ("pages/Recherche/Recherche.php");break;

//Paiements
case "Panier":include ("pages/paiements/Panier/Panier.php");break;
case "Panier2":include ("pages/paiements/Panier/Panier2.php");break;
// case "Traitement-Paiement":include ("pages/paiements/Traitement-paiement-mangopay.php");break;
case "Traitements-paypal":include ("pages/paiements/Api-Paypal/Traitements.php");break;
case "Traitements":include ("pages/paiements/Traitements.php");break;
case "Traitements-informations":include ("pages/paiements/Traitements-informations.php");break;
// case "Traitements-gratuit":include ("pages/paiements/Traitements-gratuit.php");break;
case "Traitements-admin":include ("pages/paiements/Traitements-admin.php");break;
case "Traitements-especes":include ("pages/paiements/Traitements-especes.php");break;
case "Traitements-cheque":include ("pages/paiements/Traitements-cheque.php");break;

//Pop-up
case "mot-de-passe-perdu":include ("pop-up/password_popup_actions.php");break;
//Confirmation inscription
case "inscription-confirmation":include ("pop-up/inscription/inscription-confirmation.php");break;

////////////////////////////////////////////////////////////////////////////////////////////////PANEL

//panel / Profil
case "Compte-modifications":include ("panel/Profil/Compte-modifications.php");break;
//panel / Profil / Confirmation-mail-telephone-ajax
case "Confirmation-mail":include ("panel/Profil/Confirmation-mail-telephone-ajax/Confirmation-mail.php");break;
//panel / Notifications
case 'Notifications': include("panel/Notifications/Notifications.php"); break;

//panel / Facturations
case "factures":include ("panel/Facturations/factures.php");break;

//panel / Messagerie
case "Messagerie":include ("panel/Messagerie/Messagerie.php");break;
case "Message":include ("panel/Messagerie/Message.php");break;

//panel / Avatar
case "Avatar":include ("panel/Avatar/Avatar.php");break;
case "modifier-profil-photo":include("panel/Profil/Modifier-profil-photo.php");break;

//panel / Passage-de-commandes
case "Passage-de-commande":include ('panel/Passage-de-commande/passage-de-commande.php');break;

//panel / Recapitulatif
case "Recapitulatif":include ('panel/Recapitulatif/recapitulatif.php');break;

case "Mes-commandes":include ("panel/Mes-commandes/mes-commandes.php");break;
//panel / Mon-abonnement
case "Mon-abonnement":include ("panel/Mon-abonnement/Mon-abonnement.php");break;
//panel / Ma-liste-de-souhaits
case "Mes-listes-de-souhaits":include ("panel/Ma-liste-de-souhaits/Ma-liste-de-souhaits.php");break;
case "Mes-produits":include ("panel/Mes-produits/Mes-produits.php");break;
//panel / Envoyer-un-colis
case "Mes-colis":include ("panel/Mes-colis/Mes-colis.php");break;
case "Passage-de-colis":include('panel/Passage-de-colis/passage-de-colis.php');break;

}

////////////////////////////////////////////////////////////////////////////////////////////////PAGE HOME

}elseif(empty($page)){
/////////////////////////////SI JSPANEL POUR PANEL ADMINISTRATEUR EN IFRAM

if(!empty($panel_admin_jspanel_index) && isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 1){
include ("$panel_admin_jspanel");
}else{
/////////////////////////////SI PAGES STATICS
include ("index-accueil.php");
}

}

?>