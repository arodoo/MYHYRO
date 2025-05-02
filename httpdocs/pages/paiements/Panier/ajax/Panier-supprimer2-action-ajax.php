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

$req_select = $bdd->prepare("SELECT * FROM membres_panier_details WHERE id=?");
$req_select->execute(array($idaction));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();

if($ligne_select['action_module_service_produit'] == 'Commande' || $ligne_select['action_module_service_produit'] == 'Commande boutique'){

$sql_delete = $bdd->prepare("DELETE FROM membres_commandes_details WHERE id=?");
$sql_delete->execute(array($ligne_select['id_commande_detail']));
$sql_delete->closeCursor();
}elseif($ligne_select['action_module_service_produit'] == 'Commande colis'){
$sql_delete = $bdd->prepare("DELETE FROM membres_colis WHERE id=?");
$sql_delete->execute(array($ligne_select['id_colis_detail']));
$sql_delete->closeCursor();

$sql_delete = $bdd->prepare("DELETE FROM membres_colis_details WHERE colis_id=?");
$sql_delete->execute(array($ligne_select['id_colis_detail']));
$sql_delete->closeCursor();
}

$sql_delete = $bdd->prepare("DELETE FROM membres_panier_details WHERE id=?");
$sql_delete->execute(array($idaction));
$sql_delete->closeCursor();

$update = update_commande($_SESSION['id_commande']);

///////////////////////////////SELECT URL
$req_select = $bdd->prepare("SELECT count(*) as val FROM membres_panier_details WHERE id_membre=?");
$req_select->execute(array($id_oo));
$ligne_ct = $req_select->fetch();
$req_select->closeCursor();
$cc = $ligne_ct['val'];

$result = array("Texte_rapport"=>"Modifié avec succès !","retour_validation"=>"ok","retour_lien"=>"$cc");

$result = json_encode($result);
echo $result;

}

ob_end_flush();
?>