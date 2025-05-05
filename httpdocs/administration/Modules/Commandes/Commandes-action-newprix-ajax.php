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
    // Get order ID and new price from POST data
    $id_commande = isset($_POST['id_commande']) ? intval($_POST['id_commande']) : 0;
    $nouveau_prix = isset($_POST['nouveau_prix']) ? floatval($_POST['nouveau_prix']) : 0;
    $motif = isset($_POST['motif']) ? htmlspecialchars($_POST['motif']) : '';
    $now = time();

    if ($id_commande > 0 && $nouveau_prix >= 0) {
        try {
            // Begin transaction for data integrity
            $bdd->beginTransaction();

            // Check if the order exists and get current price
            $check_order = $bdd->prepare("SELECT id, prix_total FROM membres_commandes WHERE id = ?");
            $check_order->execute(array($id_commande));

            if ($row_order = $check_order->fetch(PDO::FETCH_ASSOC)) {
                $old_prix = floatval($row_order['prix_total']);

                // Update order with new price
                $update_order = $bdd->prepare("UPDATE membres_commandes SET 
                    prix_total = ?,
                    prix_ajuste = 1
                    WHERE id = ?");

                $update_order->execute(array(
                    $nouveau_prix,
                    $id_commande
                ));

                // Record price change in history
                $details = "Modification du prix: " . number_format($old_prix, 2) . " € → " . number_format($nouveau_prix, 2) . " €";
                if (!empty($motif)) {
                    $details .= " | Motif: " . $motif;
                }

                $history_sql = $bdd->prepare("INSERT INTO admin_commandes_historique
                (
                    id_commande, 
                    id_membre,
                    pseudo,
                    date,
                    action,
                    details
                )
                VALUES (?,?,?,?,?,?)");

                $history_sql->execute(array(
                    $id_commande,
                    $id_oo,
                    $user,
                    $now,
                    'price_change',
                    $details
                ));

                // Commit transaction
                $bdd->commit();

                // Return success response
                $result = array(
                    "Texte_rapport" => "Le prix de la commande a été mis à jour avec succès",
                    "retour_validation" => "ok",
                    "retour_lien" => "",
                    "old_price" => $old_prix,
                    "new_price" => $nouveau_prix
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
                "Texte_rapport" => "Erreur lors de la modification du prix: " . $e->getMessage(),
                "retour_validation" => "non",
                "retour_lien" => ""
            );
        }
    } else {
        $result = array(
            "Texte_rapport" => "Erreur: ID de commande ou prix non valide.",
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