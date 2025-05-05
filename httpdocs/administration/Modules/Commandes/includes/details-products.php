<?php
// No direct access
if (!defined('CODI_ONE')) {
    exit('No direct access allowed');
}
?>

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Produits</h5>
        <div>
            <button class="btn btn-sm btn-outline-primary me-2" id="add-product-btn">
                <i class="fas fa-plus"></i> Ajouter un produit
            </button>
            <button class="btn btn-sm btn-primary" id="new_prix">
                <i class="fas fa-save"></i> Valider
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <form id="form-produits" method="post" action="#">
                <input id="id" name="idCommande" type="hidden" value="<?= $commande['id']; ?>" />
                <table class="table table-striped table-hover mb-0">
                    <thead>
                        <tr>
                            <th width="25%">Produit</th>
                            <th>Référence</th>
                            <th>Quantité</th>
                            <th>Prix unitaire</th>
                            <th>Remise</th>
                            <th>Total</th>
                            <th width="10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $req_boucle = $bdd->prepare("SELECT * FROM membres_commandes_details WHERE commande_id=? ORDER BY id DESC");
                        $req_boucle->execute(array($_POST['idaction']));
                        $product_count = $req_boucle->rowCount();
                        
                        if ($product_count == 0) {
                            echo '<tr><td colspan="7" class="text-center py-4 text-muted">Aucun produit dans cette commande</td></tr>';
                        }
                        
                        $total_produits = 0;
                        
                        while ($ligne_boucle = $req_boucle->fetch()) {
                            $is_canceled = $ligne_boucle['annule'] == 'oui';
                            $row_class = $is_canceled ? "text-muted" : "";
                            $text_decoration = $is_canceled ? "text-decoration-line-through" : "";
                            
                            // Calculate line total
                            $prix_ligne = $ligne_boucle['prix_unitaire'] * $ligne_boucle['quantite'];
                            if (!empty($ligne_boucle['remise'])) {
                                $prix_ligne = $prix_ligne * (1 - ($ligne_boucle['remise'] / 100));
                            }
                            
                            if (!$is_canceled) {
                                $total_produits += $prix_ligne;
                            }
                        ?>
                        <tr class="<?= $row_class ?> line<?= $ligne_boucle['id'] ?>">
                            <td class="<?= $text_decoration ?>">
                                <div class="d-flex align-items-center">
                                    <i class="fas <?= $is_canceled ? "fa-check-circle text-success" : "fa-times-circle text-danger" ?> annuler me-2" 
                                       data-id="<?= $ligne_boucle['id'] ?>" data-champ="annule"></i>
                                    <input type="hidden" id="annule_champ<?= $ligne_boucle['id'] ?>" 
                                           name="annule<?= $ligne_boucle['id'] ?>" value="<?= $ligne_boucle['annule'] ?>">
                                           
                                    <?php if (!empty($ligne_boucle['url'])): ?>
                                    <div class="btn-group btn-group-sm me-2">
                                        <a href="<?= $ligne_boucle['url'] ?>" target="_blank" class="btn btn-outline-primary product-link">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                        <button type="button" onclick="copyToClipboard('<?= $ligne_boucle['url'] ?>')" 
                                                class="btn btn-outline-secondary" title="Copier le lien">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?= $ligne_boucle['libelle'] ?>
                                </div>
                            </td>
                            <td class="<?= $text_decoration ?>"><?= $ligne_boucle['reference'] ?></td>
                            <td class="<?= $text_decoration ?>">
                                <input type="number" class="form-control form-control-sm" name="quantite<?= $ligne_boucle['id'] ?>" 
                                       value="<?= $ligne_boucle['quantite'] ?>" min="1" max="999" style="width: 70px;">
                            </td>
                            <td class="<?= $text_decoration ?>">
                                <div class="input-group input-group-sm">
                                    <input type="number" step="0.01" class="form-control form-control-sm" name="prix_unitaire<?= $ligne_boucle['id'] ?>" 
                                           id="prix_unitaire<?= $ligne_boucle['id'] ?>" value="<?= $ligne_boucle['prix_unitaire'] ?>" style="width: 80px;">
                                    <span class="input-group-text">€</span>
                                </div>
                            </td>
                            <td class="<?= $text_decoration ?>">
                                <div class="input-group input-group-sm">
                                    <input type="number" step="0.01" class="form-control form-control-sm" name="remise<?= $ligne_boucle['id'] ?>" 
                                           value="<?= $ligne_boucle['remise'] ?>" style="width: 70px;">
                                    <span class="input-group-text">%</span>
                                </div>
                            </td>
                            <td class="<?= $text_decoration ?>">
                                <?= number_format($prix_ligne, 2, ',', ' ') ?> €
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-danger delete-product" data-id="<?= $ligne_boucle['id'] ?>" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr class="fw-bold bg-light">
                            <td colspan="5" class="text-end">Total produits :</td>
                            <td><?= number_format($total_produits, 2, ',', ' ') ?> €</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </form>
        </div>
    </div>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Ajouter un produit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="add-product-form">
                    <div class="form-group mb-3">
                        <label class="form-label">Libellé du produit</label>
                        <input type="text" id="new-product-libelle" class="form-control" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Référence</label>
                                <input type="text" id="new-product-reference" class="form-control">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">URL du produit</label>
                                <input type="url" id="new-product-url" class="form-control">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label">Quantité</label>
                                <input type="number" id="new-product-quantity" class="form-control" min="1" value="1" required>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label">Prix unitaire</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" id="new-product-price" class="form-control" required>
                                    <span class="input-group-text">€</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label">Remise (%)</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" id="new-product-discount" class="form-control" value="0">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" id="save-new-product">Ajouter</button>
            </div>
        </div>
    </div>
</div>