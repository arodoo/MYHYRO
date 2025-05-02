<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../../../Configurations_bdd.php');
require_once('../../../../Configurations.php');
require_once('../../../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction= "../../../../";
require_once('../../../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

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

if(isset($user) ){

$idaction = $_POST['idaction'];
$id_commande = $_SESSION['id_commande'];

if($idaction == 'oui'){
    ///////////////////////////////UPDATE PANIER GENERALE
	$sql_update = $bdd->prepare("UPDATE membres_commandes SET
    dette_montant=?,
    dette_payee=?,
    douane_a_la_liv=?
WHERE id=?");
$sql_update->execute(array(
($_SESSION['prix_expedition_total']),
'non',
'oui',
$id_commande
));                     
$sql_update->closeCursor();

$_SESSION['prix_expedition_total'] = '0';


    ///////////////////////////////UPDATE PANIER GENERALE
	$sql_update = $bdd->prepare("UPDATE membres_panier SET
      prix_expedition_total=?,
      prix_expedition_colis_total=?
WHERE pseudo=?");
$sql_update->execute(array(
  $_SESSION['prix_expedition_total'],
  $_SESSION['prix_expedition_colis_total'],
  $user
));                     
$sql_update->closeCursor();
}else{
    unset($_SESSION['prix_expedition_total']);
    ///////////////////////////////UPDATE PANIER GENERALE
	$sql_update = $bdd->prepare("UPDATE membres_commandes SET
    dette_montant=?,
    dette_payee=?,
    douane_a_la_liv=?
WHERE id=?");
$sql_update->execute(array(
'',
'',
'non',
$id_commande
));                     
$sql_update->closeCursor();
}

$result = array("Texte_rapport"=>"Modifié avec succès !","retour_validation"=>"ok","retour_lien"=>"");
$result = json_encode($result);
echo $result;
}

ob_end_flush();
?>