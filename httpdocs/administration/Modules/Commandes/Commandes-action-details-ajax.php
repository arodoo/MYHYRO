<?php
ob_start();
require_once('../../../Configurations_bdd.php');
require_once('../../../Configurations.php');
require_once('../../../Configurations_modules.php');

$dir_fonction = "../../../";
require_once('../../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

$lasturl = $_SERVER['HTTP_REFERER'];
$alert = "non"; // Default value for alert

if (isset($user) && isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && ($admin_oo == 1 || $admin_oo == 2 || $admin_oo == 3)) {

    // Load order data
    $sql_select = $bdd->prepare('SELECT * FROM membres_commandes WHERE id=?');
    $sql_select->execute(array(intval($_POST['idaction'])));
    $commande = $sql_select->fetch();
    $sql_select->closeCursor();

    if (!$commande) {
        echo "<div class='alert alert-danger'>Commande introuvable</div>";
        exit;
    }

    // Load related data
    // Customer info
    $id_membre = $commande['user_id'];
    $sql_select = $bdd->prepare('SELECT * FROM membres WHERE id=?');
    $sql_select->execute(array($id_membre));
    $membre = $sql_select->fetch();
    $sql_select->closeCursor();
    $pseudo_membre = $membre['prenom'] . ' ' . $membre['nom'];

    // Order status
    $sql_select = $bdd->prepare('SELECT * FROM configurations_suivi_achat WHERE id=?');
    $sql_select->execute(array($commande['statut_2']));
    $statut_commande = $sql_select->fetch();
    $sql_select->closeCursor();

    // Check for linked package/colis
    $colis_lie = array();
    $sql_select = $bdd->prepare('SELECT * FROM colis WHERE id_commande=? LIMIT 1');
    $sql_select->execute(array($commande['id']));
    if ($sql_select->rowCount() > 0) {
        $colis_lie = $sql_select->fetch();
    }
    $sql_select->closeCursor();

    // Get order products
    $sql_select = $bdd->prepare('SELECT * FROM membres_commandes_details WHERE commande_id=? ORDER BY id ASC');
    $sql_select->execute(array($commande['id']));
    $produits_commande = $sql_select->fetchAll(PDO::FETCH_ASSOC);
    $sql_select->closeCursor();

    // Get order shipping rates
    $sql_select = $bdd->prepare('SELECT * FROM expedition_tarifs WHERE zone_geo=? AND poids_min <= ? AND poids_max >= ? LIMIT 1');
    $sql_select->execute(array($commande['zone_geo'], $commande['poids'], $commande['poids']));
    $tarif_expedition = $sql_select->fetch();
    $sql_select->closeCursor();

    // Get order transactions
    $sql_select = $bdd->prepare('SELECT * FROM membres_transactions_commande WHERE id_commande=? ORDER BY date DESC');
    $sql_select->execute(array($commande['id']));
    $transactions = $sql_select->fetchAll(PDO::FETCH_ASSOC);
    $sql_select->closeCursor();

    // Calculate product totals
    $sous_total = 0;
    foreach ($produits_commande as $produit) {
        $sous_total += $produit['prix_unitaire'] * $produit['quantite'];
    }

    // Define constant for template structure
    define('CODI_ONE', true);

    // Check if we're in dashboard template
    $is_dashboard = isset($_POST['is_dashboard']) && $_POST['is_dashboard'] == 'true';
    $template_class = $is_dashboard ? 'dashboard-content' : '';

    // Include each section
    include('includes/details-header.php');
    include('includes/details-products.php');
    include('includes/details-shipping.php');
    include('includes/details-payment.php');
    include('includes/details-transactions.php');
    include('includes/details-notes.php');

} else {
    header('location: /index.html');
}

// Output the content
echo ob_get_clean();
?>