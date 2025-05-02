<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../../Configurations_bdd.php');
require_once('../../../Configurations.php');
require_once('../../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction= "../../../";
require_once('../../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

include('../../../pages/paiements/Api-Paypal/paypal.php');

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
  if(isset($user)){
    // SELECT PANIER
    $sql_select = $bdd->prepare('SELECT * FROM membres_panier WHERE id=? and pseudo=?');
    $sql_select->execute(array(
        $_GET['id'],
        htmlspecialchars($user)
    ));
    
    $ligne = $sql_select->fetch();
    $sql_select->closeCursor();

    if($ligne){
        $_SESSION['idpanier'] = $_GET['id'];
        $_SESSION['panier'] = "true";
        $result = array("Texte_rapport" => "", "retour_validation" => "ok", "retour_lien" => "");
    }else{
        unset($_SESSION['idpanier']);
        unset($_SESSION['panier']);
        $result = array("Texte_rapport" => "", "retour_validation" => "non", "retour_lien" => "");
    }
  }else{
    $result = array("Texte_rapport" => "", "retour_validation" => "non", "retour_lien" => "");
  }
  
  $result = json_encode($result);
  echo $result;

  ob_end_flush();
?>