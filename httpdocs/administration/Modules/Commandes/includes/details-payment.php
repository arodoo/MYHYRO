<?php
// No direct access
if (!defined('CODI_ONE')) {
    exit('No direct access allowed');
}
?>

<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Paiement et règlement</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label">Statut de paiement</label>
                    <select id="statut_paiement" class="form-select">
                        <option value="Payée" <?= $commande['statut_paiement'] == "Payée" ? "selected" : "" ?>>Payée</option>
                        <option value="Non payée" <?= $commande['statut_paiement'] == "Non payée" ? "selected" : "" ?>>Non payée</option>
                        <option value="Partiellement payée" <?= $commande['statut_paiement'] == "Partiellement payée" ? "selected" : "" ?>>Partiellement payée</option>
                    </select>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label">Montant total facturé</label>
                    <div class="input-group">
                        <input type="text" class="form-control" value="<?= number_format($commande['prix_total'], 2, ',', ' '); ?>" readonly>
                        <span class="input-group-text">€</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label">Montant payé par le client</label>
                    <div class="input-group">
                        <input type="text" id="montant_paye_client" class="form-control" value="<?= $commande['montant_paye_client'] ?>">
                        <span class="input-group-text">€</span>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label">Montant remboursé</label>
                    <div class="input-group">
                        <input type="text" id="total_rembourse" class="form-control" value="<?= $commande['total_rembourse'] ?>">
                        <span class="input-group-text">€</span>
                    </div>
                </div>
            </div>
        </div>

        <hr>
        
        <!-- New payment section -->
        <div class="row">
            <div class="col-12 mb-3">
                <h5>Enregistrer un paiement</h5>
            </div>
            
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label class="form-label">Montant reçu</label>
                    <div class="input-group">
                        <input type="number" step="0.01" id="montant_recu" class="form-control">
                        <span class="input-group-text">€</span>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label class="form-label">Moyen d'encaissement</label>
                    <select id="moyen_d_encaissement" class="form-select">
                        <option value="Espèce">Espèces</option>
                        <option value="Chèque">Chèque</option>
                        <option value="Carte bancaire">Carte bancaire</option>
                        <option value="Virement">Virement bancaire</option>
                        <option value="Paypal">Paypal</option>
                        <option value="Autres">Autres</option>
                    </select>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label class="form-label">Date de réception</label>
                    <input type="date" id="date_de_reception" class="form-control" value="<?= date('Y-m-d') ?>">
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label">Mode d'encaissement</label>
                    <select id="mode_encaissement" class="form-select">
                        <option value="comptant">Comptant</option>
                        <option value="différé">Différé</option>
                    </select>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label">Echéance du paiement</label>
                    <input type="date" id="echeance_du" class="form-control">
                </div>
            </div>
        </div>
        
        <div class="form-group mb-3">
            <label class="form-label">Motif d'encaissement</label>
            <input type="text" id="motif_encaissement" class="form-control" placeholder="Ex: Règlement facture n°...">
        </div>
        
        <div class="d-flex justify-content-end">
            <button class="btn btn-primary update" data-annuler="">
                <i class="fas fa-save me-1"></i> Enregistrer le paiement
            </button>
        </div>
        
        <hr>
        
        <!-- Refund section -->
        <div class="row">
            <div class="col-12 mb-3">
                <h5>Enregistrer un remboursement</h5>
            </div>
            
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label">Montant à régulariser</label>
                    <div class="input-group">
                        <input type="number" step="0.01" id="regulariser" class="form-control">
                        <span class="input-group-text">€</span>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label">Moyen de remboursement</label>
                    <select id="moyen_de_remboursement" class="form-select">
                        <option value="Espèce">Espèces</option>
                        <option value="Chèque">Chèque</option>
                        <option value="Carte bancaire">Carte bancaire</option>
                        <option value="Virement">Virement bancaire</option>
                        <option value="Paypal">Paypal</option>
                        <option value="Autres">Autres</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label">Date de remboursement</label>
                    <input type="date" id="date_rem" class="form-control" value="<?= date('Y-m-d') ?>">
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label">Motif de remboursement</label>
                    <input type="text" id="motif_remboursement" class="form-control" placeholder="Ex: Retour produit...">
                </div>
            </div>
        </div>
        
        <div class="d-flex justify-content-end">
            <button class="btn btn-warning update" data-annuler="">
                <i class="fas fa-exchange-alt me-1"></i> Effectuer le remboursement
            </button>
        </div>
    </div>
</div>