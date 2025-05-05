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

// Check if user is logged in
if (isset($user)) {
    // Get order ID from POST data
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    if ($id > 0) {
        try {
            // Begin transaction for data integrity
            $bdd->beginTransaction();

            // First check if the order exists
            $check_sql = $bdd->prepare("SELECT id FROM membres_commandes WHERE id = ?");
            $check_sql->execute(array($id));

            if ($check_sql->rowCount() > 0) {
                // Check if order has colis records before deletion
                $check_colis = $bdd->prepare("SELECT id FROM membres_colis WHERE panier_id = ?");
                $check_colis->execute(array($id));
                
                if ($check_colis->rowCount() > 0) {
                    // There are linked colis records - handle accordingly
                    // Either prevent deletion or handle the relationship
                    $bdd->rollBack();
                    $result = array(
                        "Texte_rapport" => "Erreur: Cette commande est liée à un ou plusieurs colis. Veuillez d'abord supprimer les colis associés.",
                        "retour_validation" => "non",
                        "retour_lien" => ""
                    );
                    echo json_encode($result);
                    exit;
                }

                // Create a record in the history table before deletion
                $now = time();
                $history_sql = $bdd->prepare("INSERT INTO admin_commandes_historique
                (
                    id_commande, 
                    id_membre,
                    pseudo,
                    date,
                    action
                )
                VALUES (?,?,?,?,?)");

                $history_sql->execute(array(
                    $id,
                    $id_oo,
                    $user,
                    $now,
                    'suppression'
                ));

                // Delete related records first (foreign key constraints)
                // Delete transaction records
                $delete_transactions = $bdd->prepare("DELETE FROM membres_transactions_commande WHERE id_commande = ?");
                $delete_transactions->execute(array($id));

                // Delete order items
                $delete_items = $bdd->prepare("DELETE FROM membres_commandes_details  WHERE commande_id = ?");
                $delete_items->execute(array($id));

                // Delete order
                $delete_sql = $bdd->prepare("DELETE FROM membres_commandes WHERE id = ?");
                $delete_sql->execute(array($id));

                // Commit transaction
                $bdd->commit();

                // Return success response
                $result = array(
                    "Texte_rapport" => "La commande a été supprimée avec succès.",
                    "retour_validation" => "ok",
                    "retour_lien" => ""
                );
            } else {
                $bdd->rollBack();
                $result = array(
                    "Texte_rapport" => "Erreur: La commande n'existe pas.",
                    "retour_validation" => "non",
                    "retour_lien" => ""
                );
            }
        } catch (Exception $e) {
            $bdd->rollBack();
            $result = array(
                "Texte_rapport" => "Erreur lors de la suppression: " . $e->getMessage(),
                "retour_validation" => "non",
                "retour_lien" => ""
            );
        }
    } else {
        $result = array(
            "Texte_rapport" => "Erreur: ID de commande non valide.",
            "retour_validation" => "non",
            "retour_lien" => ""
        );
    }

    // Return JSON response
    echo json_encode($result);
} else {
    // Redirect if not logged in
    header('location: /index.html');
}

ob_end_flush();
?>