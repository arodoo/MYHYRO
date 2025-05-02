<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../../Configurations_bdd.php');
require_once('../../../Configurations.php');
require_once('../../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction = "../../../";
require_once('../../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

$result = array();

if (!empty($id_oo) && !empty($_POST['address_id']) && $_POST['default'] === 'oui') {
    $address_id = intval($_POST['address_id']);
    try {
       
        $bdd->prepare("UPDATE membres_informations_livraison SET prefere = 'non' WHERE id_membre = ?")
            ->execute(array($id_oo));

      
        $bdd->prepare("UPDATE membres_informations_livraison SET prefere = 'oui' WHERE id = ? AND id_membre = ?")
            ->execute(array($address_id, $id_oo));

        $result = array(
            "Texte_rapport"     => "L'adresse par défaut a été mise à jour avec succès.",
            "retour_validation" => "ok",
            "retour_lien"       => ""
        );
    } catch (Exception $e) {
        $result = array(
            "Texte_rapport"     => "Erreur lors de la mise à jour de l'adresse par défaut.",
            "retour_validation" => "error",
            "retour_lien"       => ""
        );
    }
} else {
    $result = array(
        "Texte_rapport"     => "Données invalides.",
        "retour_validation" => "error",
        "retour_lien"       => ""
    );
}

echo json_encode($result);
ob_end_flush();
?>
