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
header("Content-Type: text/plain");
echo "User-agent: *";
echo "Disallow: /icons.html";
echo "Disallow: /pop-up/cookies/cookies_acceptes_popup.php";
echo "Disallow: /J-ai-perdu-le-mot-de-passe-de-mon-compte.html";
echo "Disallow: /J-ai-perdu-le-mot-de-passe-de-mon-compte-action.html";
echo "Disallow: /pop-up/inscription_popup.php";
echo "Disallow: /pop-up/password_popup.php";
echo "Disallow: /pop-up/login_popup.php";
echo "Disallow: /pages/contact/contact-ajax.php";
echo "Disallow: /pages/avis/Avis-ajax.php";
echo "Disallow: /pages/avis/Avis-liste-ajax.php";
echo "Disallow: /pages/blog/blog-commentaires-ajax.php";
echo "Disallow: /pages/blog/blog-commentaires-liste-ajax.php";
echo "Disallow: /pages/abonnement.php";
echo "Disallow: /paiements/Panier/Panier-informations-action-ajax.php";
echo "Disallow: /paiements/Panier/Panier-ajax.php";
echo "Disallow: /pages/page-dynamique/page-dynamique-panier-ajax.php";
echo "Disallow: /js/ajax/newsletter.php";
echo "Disallow: /pages/annuaire/annuaire-fiche/reservation-bien-ajax.php";
echo "Disallow: /pages/annuaire/annuaire-fiche/reservation-bien-calcul-ajax.php";
echo "Disallow: /pages/annuaire/annuaire-fiche/annuaire-fiche-add-favoris-ajax.php";
echo "Disallow: /pages/annuaire/annuaire-fiche/annuaire-fiche-reservations-pop-up-ajax.php";
echo "Disallow: /pop-up/avis-annonce/avis-popup-ajax.php";
echo "Sitemap: http://".$nomsiteweb."/sitemap.xml";
?>