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
    // Get data from POST
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $montant = isset($_POST['montant']) ? floatval($_POST['montant']) : 0;
    $type_regulation = isset($_POST['type_regulation']) ? htmlspecialchars($_POST['type_regulation']) : '';
    $moyen_paiement = isset($_POST['moyen_paiement']) ? htmlspecialchars($_POST['moyen_paiement']) : '';
    $date_regulation = isset($_POST['date_regulation']) ? $_POST['date_regulation'] : date('d/m/Y');
    $motif = isset($_POST['motif']) ? htmlspecialchars($_POST['motif']) : '';
    $echeance_du = isset($_POST['echeance_du']) ? $_POST['echeance_du'] : '';
    $mode_encaissement = isset($_POST['mode_encaissement']) ? htmlspecialchars($_POST['mode_encaissement']) : '';

    // Convert date to timestamp
    $date_timestamp = !empty($date_regulation) ? strtotime(str_replace('/', '-', $date_regulation)) : time();
    $now = time();

    if ($id > 0 && $montant > 0) {
        try {
            // Begin transaction for data integrity
            $bdd->beginTransaction();

            // Get current order details
            $get_order = $bdd->prepare("SELECT montant_paye_client, total_rembourse, prix_total FROM membres_commandes WHERE id = ?");
            $get_order->execute(array($id));

            if ($row = $get_order->fetch(PDO::FETCH_ASSOC)) {
                // Update order based on regulation type
                if ($type_regulation == 'paiement') {
                    // Add payment to customer's total paid amount
                    $new_montant_paye = floatval($row['montant_paye_client']) + $montant;

                    // Update order with new payment amount
                    $update_order = $bdd->prepare("UPDATE membres_commandes SET 
                        montant_paye_client = ?, 
                        statut_paiement = CASE 
                            WHEN ? >= prix_total THEN 'Payée' 
                            WHEN ? > 0 AND ? < prix_total THEN 'Partiellement payée' 
                            ELSE statut_paiement END 
                        WHERE id = ?");

                    $update_order->execute(array(
                        $new_montant_paye,
                        $new_montant_paye,
                        $new_montant_paye,
                        $new_montant_paye,
                        $id
                    ));

                    // Record payment transaction
                    $insert_transaction = $bdd->prepare("INSERT INTO membres_transactions_commande
                    (
                        id_membre,
                        id_commande,
                        date,
                        type,
                        moyen,
                        montant,
                        echeance_du,
                        motif,
                        mode_encaissement
                    )
                    VALUES (?,?,?,?,?,?,?,?,?)");

                    $insert_transaction->execute(array(
                        $id_oo,
                        $id,
                        $date_timestamp,
                        "Paiement",
                        $moyen_paiement,
                        $montant,
                        $echeance_du,
                        $motif,
                        $mode_encaissement
                    ));

                    $action_type = 'paiement';
                    $message = "Paiement enregistré avec succès";

                } elseif ($type_regulation == 'remboursement') {
                    // Add refund to total refunds
                    $new_total_rembourse = floatval($row['total_rembourse']) + $montant;

                    // Update order with new refund amount
                    $update_order = $bdd->prepare("UPDATE membres_commandes SET 
                        total_rembourse = ? 
                        WHERE id = ?");

                    $update_order->execute(array(
                        $new_total_rembourse,
                        $id
                    ));

                    // Record refund transaction
                    $insert_transaction = $bdd->prepare("INSERT INTO membres_transactions_commande
                    (
                        id_membre,
                        id_commande,
                        date,
                        type,
                        moyen,
                        montant,
                        motif
                    )
                    VALUES (?,?,?,?,?,?,?)");

                    $insert_transaction->execute(array(
                        $id_oo,
                        $id,
                        $date_timestamp,
                        "Remboursement",
                        $moyen_paiement,
                        $montant,
                        $motif
                    ));

                    $action_type = 'remboursement';
                    $message = "Remboursement enregistré avec succès";

                } else {
                    throw new Exception("Type de régulation non valide");
                }

                // Create a record in the history table
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
                    'regulation_' . $action_type
                ));

                // Commit transaction
                $bdd->commit();

                // Return success response
                $result = array(
                    "Texte_rapport" => $message,
                    "retour_validation" => "ok",
                    "retour_lien" => "",
                    "montant" => $montant,
                    "type" => $action_type
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
                "Texte_rapport" => "Erreur lors de la régulation: " . $e->getMessage(),
                "retour_validation" => "non",
                "retour_lien" => ""
            );
        }
    } else {
        $result = array(
            "Texte_rapport" => "Erreur: ID de commande ou montant non valide.",
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