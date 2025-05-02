<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../../../Configurations_bdd.php');
require_once('../../../../Configurations.php');
require_once('../../../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction = "../../../../";
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

$idaction = $_POST['idaction'];
$quantite = $_POST['quantite'];
$id = $_SESSION['id_commande'];


$sql_select = $bdd->prepare("SELECT * FROM membres_panier_details WHERE id=?");
$sql_select->execute(array($idaction));
$panier = $sql_select->fetch();
$sql_select->closeCursor();

if ($panier['action_module_service_produit'] == 'Commande' || $panier['action_module_service_produit'] == 'Commande boutique') {

  $idArticle = $panier['id_commande_detail'];

  $sql_update = $bdd->prepare("UPDATE membres_commandes_details SET quantite=? WHERE id=?");
  $sql_update->execute(array(
    htmlspecialchars($quantite),
    intval($idArticle)
  ));
  $sql_update->closeCursor();
} elseif ($panier['action_module_service_produit'] == 'Commande colis') {

  $idcolis = $panier['id_colis_detail'];

  $sql_update = $bdd->prepare("UPDATE membres_colis_details SET quantite=? WHERE id=?");
  $sql_update->execute(array(
    htmlspecialchars($quantite),
    intval($idcolis)
  ));
  $sql_update->closeCursor();
}

$sql_update = $bdd->prepare("UPDATE membres_panier_details SET quantite=? WHERE id=?");
$sql_update->execute(array(
  htmlspecialchars($quantite),
  $idaction
));
$sql_update->closeCursor();

$update = update_commande($id);

if ($update) {
  $result = array("Texte_rapport" => "Quantité modifié !", "retour_validation" => "ok", "retour_lien" => "");
} else {
  $result = array("Texte_rapport" => "Erreur !", "retour_validation" => "non", "retour_lien" => "");
}

$result = json_encode($result);
echo $result;

ob_end_flush();
