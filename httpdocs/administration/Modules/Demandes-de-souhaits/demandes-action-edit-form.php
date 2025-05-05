<?php
// Ensure this file is included within the main component
if (!defined('CODI_ADMIN')) {
    die('Accès direct interdit');
}

// Get the wish details
$id = $idaction;
$req_select = $bdd->prepare("SELECT * FROM membres_souhait WHERE id = ?");
$req_select->execute(array($id));
$wish = $req_select->fetch();
$req_select->closeCursor();

if (!$wish) {
    echo '<div class="alert alert-danger">Demande non trouvée</div>';
    return;
}

// Get user details
$req_select = $bdd->prepare("SELECT * FROM membres WHERE id = ?");
$req_select->execute(array($wish['user_id']));
$client = $req_select->fetch();
$req_select->closeCursor();
?>

<div id="top" class="sa-app__body">
    <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
        <div class="container">
            <div class="py-5">
                <div class="row g-4 align-items-center">
                    <div class="col">
                        <nav class="mb-2" aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-sa-simple">
                                <li class="breadcrumb-item"><a href="index-admin.php">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="index-admin.php?page=Demandes-de-souhaits">Demandes
                                        de souhaits</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Modification</li>
                            </ol>
                        </nav>
                        <h1 class="h3 m-0">Modification de la demande #<?php echo $id; ?></h1>
                    </div>
                </div>
            </div>

            <form id="editWishForm" method="post" action="index-admin.php?page=Demandes-de-souhaits">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <div class="card mb-4">
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="client-name" class="form-label">Client</label>
                                    <input type="text" class="form-control" id="client-name"
                                        value="<?php echo $client['prenom'] . ' ' . $client['nom']; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="status" class="form-label">Statut</label>
                                    <select class="form-select" id="status" name="status">
                                        <option value="0" <?php echo ($wish['statut'] == 0) ? 'selected' : ''; ?>>En
                                            attente</option>
                                        <option value="1" <?php echo ($wish['statut'] == 1) ? 'selected' : ''; ?>>Traitée
                                        </option>
                                        <option value="2" <?php echo ($wish['statut'] == 2) ? 'selected' : ''; ?>>Refusée
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-4">
                                    <label for="title" class="form-label">Titre</label>
                                    <input type="text" class="form-control" id="title" name="title"
                                        value="<?php echo htmlspecialchars($wish['titre']); ?>">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-4">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description"
                                        rows="5"><?php echo htmlspecialchars($wish['description']); ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Articles</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Référence</th>
                                        <th>Nom</th>
                                        <th>Quantité</th>
                                        <th>Prix</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="articles-container">
                                    <?php
                                    // Get wish list items
                                    $sql_items = $bdd->prepare("SELECT * FROM membres_souhait_details WHERE liste_id=?");
                                    $sql_items->execute(array($id));

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
                                        <tr id="article-row-<?php echo $item['id']; ?>">
                                            <td><?php echo $product_ref; ?></td>
                                            <td><?php echo $product_name; ?></td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm"
                                                    name="quantity[<?php echo $item['id']; ?>]"
                                                    value="<?php echo $item['quantite']; ?>" min="1">
                                            </td>
                                            <td><?php echo $product_price; ?> €</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    onclick="removeArticle('<?php echo $item['id']; ?>')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    $sql_items->closeCursor();
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            <button type="button" class="btn btn-success" id="add-article-btn">
                                <i class="fas fa-plus"></i> Ajouter un article
                            </button>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-3">
                    <a href="index-admin.php?page=Demandes-de-souhaits" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Form submission handler
        $("#editWishForm").on("submit", function (e) {
            e.preventDefault();

            $.ajax({
                url: '/administration/Modules/Demandes-de-souhaits/demandes-action-modifier-ajax.php',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function (res) {
                    if (res.retour_validation == "ok") {
                        popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                        setTimeout(function () {
                            window.location.href = "index-admin.php?page=Demandes-de-souhaits";
                        }, 1500);
                    } else {
                        popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                    }
                }
            });
        });

        // Add article button handler
        $("#add-article-btn").on("click", function () {
            // Open product selection modal
            // This functionality would need to be implemented based on the original component
            alert("Fonctionnalité à implémenter: Ajout d'article");
        });
    });

    // Article removal function
    function removeArticle(articleId) {
        if (confirm("Voulez-vous vraiment supprimer cet article ?")) {
            $.ajax({
                url: '/administration/Modules/Demandes-de-souhaits/demandes-action-supprimer-article-ajax.php',
                type: 'POST',
                data: {
                    id: articleId,
                    wish_id: <?php echo $id; ?>
                },
                dataType: 'json',
                success: function (res) {
                    if (res.retour_validation == "ok") {
                        $("#article-row-" + articleId).remove();
                        popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                    } else {
                        popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                    }
                }
            });
        }
    }
</script>