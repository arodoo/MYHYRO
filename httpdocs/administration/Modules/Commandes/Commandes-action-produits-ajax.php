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
    // Get order ID and action type
    $id_commande = isset($_POST['id_commande']) ? intval($_POST['id_commande']) : 0;
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    $now = time();

    if ($id_commande > 0) {
        try {
            // Begin transaction for data integrity
            $bdd->beginTransaction();

            // Check if the order exists
            $check_order = $bdd->prepare("SELECT id, prix_total FROM membres_commandes WHERE id = ?");
            $check_order->execute(array($id_commande));

            if ($row_order = $check_order->fetch(PDO::FETCH_ASSOC)) {
                $current_total = floatval($row_order['prix_total']);

                // Handle different actions
                switch ($action) {
                    case 'add':
                        // Add product to order
                        $id_produit = isset($_POST['id_produit']) ? intval($_POST['id_produit']) : 0;
                        $quantite = isset($_POST['quantite']) ? intval($_POST['quantite']) : 1;
                        $prix_unitaire = isset($_POST['prix_unitaire']) ? floatval($_POST['prix_unitaire']) : 0;
                        $remise = isset($_POST['remise']) ? floatval($_POST['remise']) : 0;
                        $tva = isset($_POST['tva']) ? floatval($_POST['tva']) : 0;
                        $libelle = isset($_POST['libelle']) ? htmlspecialchars($_POST['libelle']) : '';
                        $reference = isset($_POST['reference']) ? htmlspecialchars($_POST['reference']) : '';

                        if ($id_produit > 0 && $quantite > 0) {
                            // If no libelle provided, get product details from database
                            if (empty($libelle) && $id_produit > 0) {
                                $get_product = $bdd->prepare("SELECT titre, reference, prix, tva FROM produits WHERE id = ?");
                                $get_product->execute(array($id_produit));
                                if ($product = $get_product->fetch(PDO::FETCH_ASSOC)) {
                                    $libelle = $product['titre'];
                                    $reference = $product['reference'];
                                    $prix_unitaire = !empty($prix_unitaire) ? $prix_unitaire : $product['prix'];
                                    $tva = !empty($tva) ? $tva : $product['tva'];
                                }
                            }

                            // Calculate total price for this product entry
                            $prix_total_ligne = ($prix_unitaire * $quantite) * (1 - ($remise / 100));

                            // Insert product into order
                            $insert_product = $bdd->prepare("INSERT INTO membres_commandes_details 
                            (
                                commande_id,
                                id_produit,
                                libelle,
                                reference,
                                prix_unitaire,
                                quantite,
                                remise,
                                tva,
                                prix_total,
                                date
                            )
                            VALUES (?,?,?,?,?,?,?,?,?,?)");

                            $insert_product->execute(array(
                                $id_commande,
                                $id_produit,
                                $libelle,
                                $reference,
                                $prix_unitaire,
                                $quantite,
                                $remise,
                                $tva,
                                $prix_total_ligne,
                                $now
                            ));

                            // Update order total price
                            $new_total = $current_total + $prix_total_ligne;
                            $update_order = $bdd->prepare("UPDATE membres_commandes SET prix_total = ? WHERE id = ?");
                            $update_order->execute(array($new_total, $id_commande));

                            $message = "Produit ajouté à la commande";
                            $success = true;
                        } else {
                            throw new Exception("Produit ou quantité non valide");
                        }
                        break;

                    case 'remove':
                        // Remove product from order
                        $id_ligne = isset($_POST['id_ligne']) ? intval($_POST['id_ligne']) : 0;

                        if ($id_ligne > 0) {
                            // Get product line details before deletion
                            $get_line = $bdd->prepare("SELECT prix_total FROM membres_commandes_details WHERE id = ? AND commande_id = ?");
                            $get_line->execute(array($id_ligne, $id_commande));

                            if ($line = $get_line->fetch(PDO::FETCH_ASSOC)) {
                                $line_total = floatval($line['prix_total']);

                                // Delete product from order
                                $delete_product = $bdd->prepare("DELETE FROM membres_commandes_details WHERE id = ? AND commande_id = ?");
                                $delete_product->execute(array($id_ligne, $id_commande));

                                // Update order total price
                                $new_total = $current_total - $line_total;
                                $new_total = max(0, $new_total); // Ensure total is not negative

                                $update_order = $bdd->prepare("UPDATE membres_commandes SET prix_total = ? WHERE id = ?");
                                $update_order->execute(array($new_total, $id_commande));

                                $message = "Produit supprimé de la commande";
                                $success = true;
                            } else {
                                throw new Exception("Ligne de produit introuvable");
                            }
                        } else {
                            throw new Exception("ID de ligne non valide");
                        }
                        break;

                    case 'update':
                        // Update product quantity or details
                        $id_ligne = isset($_POST['id_ligne']) ? intval($_POST['id_ligne']) : 0;
                        $quantite = isset($_POST['quantite']) ? intval($_POST['quantite']) : 0;
                        $prix_unitaire = isset($_POST['prix_unitaire']) ? floatval($_POST['prix_unitaire']) : 0;
                        $remise = isset($_POST['remise']) ? floatval($_POST['remise']) : 0;

                        if ($id_ligne > 0 && $quantite > 0) {
                            // Get current product line details
                            $get_line = $bdd->prepare("SELECT prix_unitaire, prix_total, tva, remise FROM membres_commandes_details WHERE id = ? AND commande_id = ?");
                            $get_line->execute(array($id_ligne, $id_commande));

                            if ($line = $get_line->fetch(PDO::FETCH_ASSOC)) {
                                $old_total = floatval($line['prix_total']);
                                $current_pu = !empty($prix_unitaire) ? $prix_unitaire : floatval($line['prix_unitaire']);
                                $current_remise = isset($_POST['remise']) ? $remise : floatval($line['remise']);

                                // Calculate new price for this product entry
                                $new_prix_total_ligne = ($current_pu * $quantite) * (1 - ($current_remise / 100));

                                // Update product line
                                $update_product = $bdd->prepare("UPDATE membres_commandes_details SET 
                                    quantite = ?,
                                    prix_unitaire = ?,
                                    remise = ?,
                                    prix_total = ?
                                    WHERE id = ? AND commande_id = ?");

                                $update_product->execute(array(
                                    $quantite,
                                    $current_pu,
                                    $current_remise,
                                    $new_prix_total_ligne,
                                    $id_ligne,
                                    $id_commande
                                ));

                                // Update order total price
                                $new_total = $current_total - $old_total + $new_prix_total_ligne;

                                $update_order = $bdd->prepare("UPDATE membres_commandes SET prix_total = ? WHERE id = ?");
                                $update_order->execute(array($new_total, $id_commande));

                                $message = "Produit mis à jour dans la commande";
                                $success = true;
                            } else {
                                throw new Exception("Ligne de produit introuvable");
                            }
                        } else {
                            throw new Exception("ID de ligne ou quantité non valide");
                        }
                        break;

                    case 'list':
                        // Get list of products in the order
                        $get_products = $bdd->prepare("SELECT p.*, 
                            IFNULL(prod.titre, p.libelle) as titre_produit,
                            IFNULL(prod.reference, p.reference) as reference_produit
                            FROM membres_commandes_details p
                            LEFT JOIN produits prod ON p.id_produit = prod.id
                            WHERE p.commande_id = ?
                            ORDER BY p.id DESC");
                        $get_products->execute(array($id_commande));

                        $products = array();
                        while ($product = $get_products->fetch(PDO::FETCH_ASSOC)) {
                            $products[] = $product;
                        }

                        // Create history entry for viewing products
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
                            $id_commande,
                            $id_oo,
                            $user,
                            $now,
                            'view_products'
                        ));

                        $bdd->commit();

                        // Return success with products data
                        echo json_encode(array(
                            "Texte_rapport" => "Liste des produits récupérée",
                            "retour_validation" => "ok",
                            "retour_lien" => "",
                            "products" => $products
                        ));
                        exit;

                    default:
                        throw new Exception("Action non reconnue");
                }

                // Create history entry for modifying products
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
                    $id_commande,
                    $id_oo,
                    $user,
                    $now,
                    'modify_products_' . $action
                ));

                // Commit transaction
                $bdd->commit();

                // Return success response
                $result = array(
                    "Texte_rapport" => $message,
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
                "Texte_rapport" => "Erreur lors de la modification des produits: " . $e->getMessage(),
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

    // Return JSON response for all actions except 'list' (which returns earlier)
    echo json_encode($result);
} else {
    // Redirect if not logged in
    header('location: /index.html');
}

ob_end_flush();
?>