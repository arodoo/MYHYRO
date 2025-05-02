<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../Configurations_bdd.php');
require_once('../Configurations.php');
require_once('../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction = "../";
require_once('../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');
////INCLUDE FUNCTION HAUT CMS CODI ONE - ADMINISTRATION
require_once('../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');
require_once('../administration/index-admin-modules-liste-fonction.php');

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

if (isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo > 0) {

  //ON CHERCHE L'URL COURANTE POUR LA SAUVEGARDE DANS L'EXPORT DE JSPANEL
  if ($mode_back_office == "jspanel") {
    $pageencoursm301 = $_SERVER['REQUEST_URI'];
    $pageencoursuuuuooi = utf8_decode(urldecode($pageencoursm301));
    $pageencoursuuuuooi = explode("" . $http . "$nomsiteweb", $pageencoursuuuuooi);
    $_SESSION['JSPANEL_URL_IFRAME'] = $pageencoursuuuuooi['0'];

    $pageencoursuuuuooi2 = explode("?", $_SESSION['JSPANEL_URL_IFRAME']);
    $JSPANEL_URL_IFRAME_INDEX = $pageencoursuuuuooi2['0'];
  }

?>

  <!DOCTYPE html>
  <html lang="fr">

  <head>

    <meta charset="utf-8">
    <meta name="description" content="Administration">
    <meta name="keywords" content="Administration">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, width=device-width">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <link rel="icon" type="image/png" href="<?php echo "$http"; ?><?php echo "$nomsiteweb"; ?>/<?php echo "$favicon_ico"; ?>">
    <!-- link rel="shortcut icon" type="image/x-icon" href="<?php echo "$http"; ?><?php echo "$nomsiteweb"; ?>/<?php echo "$favicon_png"; ?>" /-->
    <link rel="shortcut icon" type="image/x-icon" href="/template2/black/images/Mfavi.png" />
    <title>Panel d'administration</title>
    <link rel="stylesheet" type="text/css" href="/js/ajax/select2/select2.min.css">

    <?php
    ////INCLUDE JS BAS CMS CODI ONE
    include('../administration/Assets/js/INCLUDE-JS-HAUT-CMS-CODI-ONE.php');
    ?>

  </head>

  <body>

    <?php
    $dir_back_office = "../";
    $panel_admin_jspanel_index = "oui";

    ////////////////////////////////////////////////////////////LISTE DES MODULES DISPONIBLENT DANS LE PANEL ADMINISTRATION
    ?>
    <div class='container' style='padding: 10px;'>
      <?php
      ////INCLUDE MENU ADMINISTRATEUR
      include('../administration/index-admin-menu-deprecated.php');

      ////INCLUDE MODULE DECLARATION MODULE
      if (!empty($_GET['page'])) {
        include('../administration/Modules/Membres-moderateurs/Moderateurs-modules-include-declarations-jquery.php');
      }
      ////SWITCH PAGES
      include('../administration/pages-deprecated.php');
      ?>
    </div>
    <?php
    ////////////////////////////////////////////////////////////LISTE DES MODULES DISPONIBLENT DANS LE PANEL ADMINISTRATION

    ////INCLUDE CSS BAS CMS CODI ONE
    include('../administration/Assets/css/INCLUDE-CSS-BAS-CMS-CODI-ONE-d.php');

    ////INCLUDE JS BAS CMS CODI ONE
    include('../administration/Assets/js/INCLUDE-JS-BAS-CMS-CODI-ONE-d.php');

    ////INCLUDE POP-UP BAS CMS CODI ONE
    include('../pop-up/INCLUDE-POP-UP-BAS-CMS-CODI-ONE.php');

    ?>
    <script type="text/javascript" src="/js/ajax/select2/select2.min.js"></script>
  </body>

  </html>

<?php

} else {
  header('location: /index.html');
}

ob_end_flush();
?>