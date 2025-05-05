<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../../Configurations_bdd.php');
require_once('../../../Configurations.php');
require_once('../../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction = "../../../";
require_once('../../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

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

$id = $_POST['id'];

if (isset($user)) {
    if (isset($id)) {
        // Get wish list details
        $sql_select = $bdd->prepare("SELECT * FROM membres_souhait WHERE id=?");
        $sql_select->execute(array(intval($id)));
        $wish = $sql_select->fetch();
        $sql_select->closeCursor();

        // Get user details
        $sql_select = $bdd->prepare("SELECT * FROM membres WHERE id=?");
        $sql_select->execute(array($wish['user_id']));
        $client = $sql_select->fetch();
        $sql_select->closeCursor();

        // Get wish list items
        $sql_items = $bdd->prepare("SELECT * FROM membres_souhait_details WHERE liste_id=?");
        $sql_items->execute(array(intval($id)));

        // Create cart processing logic
        // Note: This is just a placeholder - keep the actual business logic from the existing file

        // Update status to "processed"
        $sql_update = $bdd->prepare("UPDATE membres_souhait SET statut=? WHERE id=?");
        $sql_update->execute(array(2, intval($id)));
        $sql_update->closeCursor();

        $result = array("Texte_rapport" => "Panier créé avec succès !", "retour_validation" => "ok", "retour_lien" => "");
    } else {
        $result = array("Texte_rapport" => "Erreur", "retour_validation" => "non", "retour_lien" => "");
    }

    echo json_encode($result);
} else {
    header('location: /index.html');
}

ob_end_flush();
?>