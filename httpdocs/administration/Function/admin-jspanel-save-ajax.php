<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../Configurations_bdd.php');
require_once('../Configurations.php');
require_once('../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction= "../";
require_once('../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

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

if(isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 1){

if(!empty($_POST['page_courante_iframe']) && $_POST['page_courante_iframe'] != "about:blank" ){
$_SESSION['page_courante_iframe'] = $_POST['page_courante_iframe'];
}
if(!empty($_POST['statutjspanel'])){
$_SESSION['statutjspanel'] = $_POST['statutjspanel'];
}
if(!empty($_POST['position_top'])){
$_SESSION['position_top'] = $_POST['position_top'];
}
if(!empty($_POST['position_left'])){
$_SESSION['position_left'] = $_POST['position_left'];
}

}else{
header('location: /index.html');
}

ob_end_flush();
?>