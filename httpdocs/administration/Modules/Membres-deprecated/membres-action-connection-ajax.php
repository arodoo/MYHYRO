<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../../Configurations_bdd.php');
require_once('../../../Configurations.php');
require_once('../../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction= "../../../";
require_once('../../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

$lasturl = $_SERVER['HTTP_REFERER'];

  /*****************************************************\
  * Adresse e-mail => direction@codi-one.fr             *
  * La conception est assujettie � une autorisation     *
  * sp�ciale de codi-one.com. Si vous ne disposez pas de*
  * cette autorisation, vous �tes dans l'ill�galit�.    *
  * L'auteur de la conception est et restera            *
  * codi-one.fr                                         *
  * Codage, script & images (all contenu) sont r�alis�s * 
  * par codi-one.fr                                     *
  * La conception est � usage unique et priv�.          *
  * La tierce personne qui utilise le script se porte   *
  * garante de disposer des autorisations n�cessaires   *
  *                                                     *
  * Copyright ... Tous droits r�serv�s auteur (Fabien B)*
  \*****************************************************/

if(isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 1 ||
isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 2 ){

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM membres WHERE id=?");
$req_select->execute(array($_POST['idaction']));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$iddpseudo = $ligne_select['id']; 
$logllll = $ligne_select['pseudo'];

$_SESSION['pseudo'] = "$iddpseudo";
$_SESSION['4M8e7M5b1R2e8s'] = "A9lKJF0HJ12YtG7WxCl12";

$result = array("Texte_rapport"=>"","retour_validation"=>"ok","retour_lien"=>"/");

$result = json_encode($result);
echo $result;

}else{
header('location: /');
}

ob_end_flush();
?>