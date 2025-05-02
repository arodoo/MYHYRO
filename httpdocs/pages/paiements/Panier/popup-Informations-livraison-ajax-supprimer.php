<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../../Configurations_bdd.php');
require_once('../../../Configurations.php');
require_once('../../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction = "../../../";
require_once('../../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');


$address_id = $_POST['address_id'] ?? null;
$result = array();

if (!empty($address_id)) {
  try {
   
    $sql_delete = $bdd->prepare("DELETE FROM membres_informations_livraison WHERE id = ?");
    $sql_delete->execute(array($address_id));
    $sql_delete->closeCursor();

    $result = array(
      "Texte_rapport"     => "Adresse supprimée avec succès.",
      "retour_validation" => "ok",
      "retour_lien"       => ""
    );
  } catch (Exception $e) {
    $result = array(
      "Texte_rapport"     => "Erreur lors de la suppression: " . $e->getMessage(),
      "retour_validation" => "error",
      "retour_lien"       => ""
    );
  }
} else {
  $result = array(
    "Texte_rapport"     => "ID d'adresse manquant.",
    "retour_validation" => "error",
    "retour_lien"       => ""
  );
}

echo json_encode($result);
ob_end_flush();
?>
