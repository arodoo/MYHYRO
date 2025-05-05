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

if (
    isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 1 ||
    isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 2 ||
    isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 3
) {
    $id = $_POST['id'];

    // Get wish details
    $sql_select = $bdd->prepare("SELECT * FROM membres_souhait WHERE id=?");
    $sql_select->execute(array(intval($id)));
    $wish = $sql_select->fetch();
    $sql_select->closeCursor();

    // Get client details
    $sql_select = $bdd->prepare("SELECT * FROM membres WHERE id=?");
    $sql_select->execute(array($wish['user_id']));
    $client = $sql_select->fetch();
    $sql_select->closeCursor();

    // Format dates
    $created_at = date("d/m/Y H:i:s", $wish['created_at']);
    $updated_at = date("d/m/Y H:i:s", $wish['updated_at']);

    // Get status text
    $status_text = "";
    switch ($wish['statut']) {
        case 0:
            $status_text = "En attente";
            break;
        case 1:
            $status_text = "Traitée";
            break;
        case 2:
            $status_text = "Refusée";
            break;
        default:
            $status_text = "Inconnue";
    }
    ?>

    <!-- Modal -->
    <div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDetailLabel">Détails de la demande #<?php echo $wish['id']; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Client</label>
                                <div class="form-control-plaintext"><?php echo $client['prenom'] . ' ' . $client['nom']; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Statut</label>
                                <div class="form-control-plaintext"><?php echo $status_text; ?></div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Titre</label>
                                <div class="form-control-plaintext"><?php echo $wish['titre']; ?></div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Description</label>
                                <div class="form-control-plaintext"><?php echo nl2br($wish['description']); ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Date de création</label>
                                <div class="form-control-plaintext"><?php echo $created_at; ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Dernière modification</label>
                                <div class="form-control-plaintext"><?php echo $updated_at; ?></div>
                            </div>
                        </div>

                        <!-- Articles section -->
                        <div class="col-12 mt-4">
                            <h6>Articles</h6>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Référence</th>
                                            <th>Nom</th>
                                            <th>Quantité</th>
                                            <th>Prix</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Get wish list items
                                        $sql_items = $bdd->prepare("SELECT * FROM membres_souhait_details WHERE liste_id=?");
                                        $sql_items->execute(array(intval($id)));

                                        while ($item = $sql_items->fetch()) {
                                            // Get product info if available
                                            $product_name = "Produit non trouvé";
                                            $product_ref = "-";
                                            $product_price = "0";

                                            if (!empty($item['product_id'])) {
                                                $sql_product = $bdd->prepare("SELECT * FROM produits WHERE id=?");
                                                $sql_product->execute(array($item['product_id']));
                                                if ($product = $sql_product->fetch()) {
                                                    $product_name = $product['nom'];
                                                    $product_ref = $product['reference'];
                                                    $product_price = $product['prix'];
                                                }
                                                $sql_product->closeCursor();
                                            }
                                            ?>
                                            <tr>
                                                <td><?php echo $product_ref; ?></td>
                                                <td><?php echo $product_name; ?></td>
                                                <td><?php echo $item['quantite']; ?></td>
                                                <td><?php echo $product_price; ?> €</td>
                                            </tr>
                                            <?php
                                        }
                                        $sql_items->closeCursor();
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="index-admin.php?page=Demandes-de-souhaits&action=edit&idaction=<?php echo $id; ?>"
                        class="btn btn-warning">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <button type="button" class="btn btn-success" onclick="createCart(<?php echo $id; ?>)">
                        <i class="fas fa-shopping-cart"></i> Créer panier
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function createCart(id) {
            $.post({
                url: '/administration/Modules/Demandes-de-souhaits/demandes-action-creation-panier.php',
                type: 'POST',
                data: { id: id },
                dataType: "json",
                success: function (res) {
                    if (res.retour_validation == "ok") {
                        popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                        setTimeout(function () {
                            $("#modalDetail").modal('hide');
                            listeDemandes();
                        }, 1500);
                    } else {
                        popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                    }
                }
            });
        }
    </script>

    <?php
} else {
    header('location: /index.html');
}

ob_end_flush();
?>