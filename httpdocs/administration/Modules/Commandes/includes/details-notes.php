<?php
// No direct access
if (!defined('CODI_ONE')) {
    exit('No direct access allowed');
}
?>

<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Notes et commentaires</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label">Notes internes (non visibles par le client)</label>
                    <textarea id="notes" class="form-control" rows="5"><?= $commande['notes'] ?></textarea>
                    <small class="text-muted">Ces notes sont uniquement destinées à l'équipe administrative.</small>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label">Message au client</label>
                    <textarea id="message" class="form-control" rows="5"><?= $commande['message'] ?></textarea>
                    <small class="text-muted">Ce message sera visible par le client dans son espace.</small>
                </div>
            </div>
        </div>
        
        <div class="row mt-3">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label">Commentaire de livraison</label>
                    <textarea id="commentaire_livraison" class="form-control" rows="3"><?= $commande['commentaire_livraison'] ?></textarea>
                    <small class="text-muted">Instructions spécifiques pour la livraison.</small>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label">Commentaire client</label>
                    <div class="form-control bg-light" style="height: auto; min-height: 5rem;">
                        <?= !empty($commande['commentaire_client']) ? nl2br(htmlspecialchars($commande['commentaire_client'])) : '<span class="text-muted">Aucun commentaire du client</span>' ?>
                    </div>
                    <small class="text-muted">Commentaires laissés par le client lors de la commande (lecture seule).</small>
                </div>
            </div>
        </div>
        
        <div class="d-flex justify-content-end mt-3">
            <button class="btn btn-primary update" data-annuler="">
                <i class="fas fa-save me-1"></i> Enregistrer les notes
            </button>
        </div>
    </div>
</div>

<?php if ($is_dashboard): ?>
    <div class="mb-4 pt-3 text-center">
        <a href="javascript:history.back()" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Retour à la liste des commandes
        </a>
    </div>
<?php endif; ?>