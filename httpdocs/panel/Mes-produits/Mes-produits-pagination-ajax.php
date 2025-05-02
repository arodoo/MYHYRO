<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../Configurations_bdd.php');
require_once('../../Configurations.php');
require_once('../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction= "../../";
require_once('../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

$lasturl = $_SERVER['HTTP_REFERER'];

  /*****************************************************\
  * Adresse e-mail => direction@codi-one.fr             *
  * La conception est assujettie   une autorisation     *
  * sp ciale de codi-one.com. Si vous ne disposez pas de*
  * cette autorisation, vous  tes dans l'ill galit .    *
  * L'auteur de la conception est et restera            *
  * codi-one.fr                                         *
  * Codage, script & images (all contenu) sont r alis s * 
  * par codi-one.fr                                     *
  * La conception est   usage unique et priv .          *
  * La tierce personne qui utilise le script se porte   *
  * garante de disposer des autorisations n cessaires   *
  *                                                     *
  * Copyright ... Tous droits r serv s auteur (Fabien B)*
  \*****************************************************/

    $_SESSION['page_produits'] = $_POST['page'];
    


ob_end_flush();
?>