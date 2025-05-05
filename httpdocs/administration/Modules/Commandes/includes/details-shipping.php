<?php
// No direct access
if (!defined('CODI_ONE')) {
    exit('No direct access allowed');
}
?>

<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Expédition et livraison</h5>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Adresse de livraison</h6>
                        <button class="btn btn-sm btn-outline-primary modif-liv">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="adresse-livraison-view">
                            <?= nl2br(htmlspecialchars($commande['adresse_liv'])) ?>
                        </div>
                        <div id="adresse-livraison-edit" style="display: none;">
                            <textarea id="adresse_liv" class="form-control" rows="5"><?= htmlspecialchars($commande['adresse_liv']) ?></textarea>
                            <div class="mt-2 text-end">
                                <button class="btn btn-sm btn-outline-secondary cancel-modif">Annuler</button>
                                <button class="btn btn-sm btn-primary update" data-annuler="">Enregistrer</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Adresse de facturation</h6>
                        <button class="btn btn-sm btn-outline-primary modif-fac">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="adresse-facturation-view">
                            <?= nl2br(htmlspecialchars($commande['adresse_fac'])) ?>
                        </div>
                        <div id="adresse-facturation-edit" style="display: none;">
                            <textarea id="adresse_fac" class="form-control" rows="5"><?= htmlspecialchars($commande['adresse_fac']) ?></textarea>
                            <div class="mt-2 text-end">
                                <button class="btn btn-sm btn-outline-secondary cancel-modif">Annuler</button>
                                <button class="btn btn-sm btn-primary update" data-annuler="">Enregistrer</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label">Statut d'expédition</label>
                    <select id="statut_expedition" class="form-select">
                        <option value="Non expédié" <?= $commande['statut_expedition'] == "Non expédié" ? "selected" : "" ?>>Non expédié</option>
                        <option value="En cours de préparation" <?= $commande['statut_expedition'] == "En cours de préparation" ? "selected" : "" ?>>En cours de préparation</option>
                        <option value="Expédié" <?= $commande['statut_expedition'] == "Expédié" ? "selected" : "" ?>>Expédié</option>
                        <option value="En transit" <?= $commande['statut_expedition'] == "En transit" ? "selected" : "" ?>>En transit</option>
                        <option value="Livré" <?= $commande['statut_expedition'] == "Livré" ? "selected" : "" ?>>Livré</option>
                    </select>
                </div>
                
                <div class="form-group mb-3">
                    <label class="form-label">Numéro de lot d'expédition</label>
                    <input type="text" id="lot_expedition" class="form-control" value="<?= $commande['lot_expedition'] ?>">
                </div>
                
                <div class="form-group mb-3">
                    <label class="form-label">Date d'envoi</label>
                    <input type="date" id="date_envoi" class="form-control" value="<?= !empty($commande['date_envoi']) ? date('Y-m-d', $commande['date_envoi']) : '' ?>">
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label">Poids total (kg)</label>
                    <div class="input-group">
                        <input type="number" step="0.01" id="poids" class="form-control" value="<?= $commande['poids'] ?>" onchange="douanetrans()">
                        <span class="input-group-text">kg</span>
                    </div>
                </div>
                
                <div class="form-group mb-3">
                    <label class="form-label">Mode de livraison</label>
                    <input type="text" class="form-control" value="<?= $commande['mode_livraison'] ?>" readonly>
                </div>
                
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="douane_a_la_liv" <?= $commande['douane_a_la_liv'] == 1 ? 'checked' : '' ?>>
                    <label class="form-check-label" for="douane_a_la_liv">
                        Douanes à la livraison
                    </label>
                </div>
            </div>
        </div>
        
        <hr>
        
        <div class="row">
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label class="form-label">Prix du kg</label>
                    <div class="input-group">
                        <input type="number" step="0.01" id="prix_du_kg" class="form-control" value="<?= !empty($tarif_expedition['tarif_kg']) ? $tarif_expedition['tarif_kg'] : '0' ?>" onchange="douanetrans()">
                        <span class="input-group-text">€</span>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label class="form-label">Estimation frais d'expédition</label>
                    <div class="input-group">
                        <input type="number" step="0.01" id="prix_expedition" class="form-control" value="<?= $commande['frais_livraison'] ?>" onchange="douaneCalc()">
                        <span class="input-group-text">€</span>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label class="form-label">Douane et transport réel</label>
                    <div class="input-group">
                        <input type="number" step="0.01" id="douane_et_transport_reel" class="form-control" value="0" onchange="douaneCalc()">
                        <span class="input-group-text">€</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label class="form-label">Écart</label>
                    <div class="input-group">
                        <input type="number" step="0.01" id="ecart" class="form-control" value="0" readonly>
                        <span class="input-group-text">€</span>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 align-self-end">
                <div class="form-group mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="dette_payee_pf" <?= $commande['dette_payee_pf'] == 1 ? 'checked' : '' ?>>
                        <label class="form-check-label" for="dette_payee_pf">
                            Dette payée à l'expédition
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 align-self-end">
                <div class="form-group mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="dette_payee_pf2" <?= $commande['dette_payee_pf2'] == 1 ? 'checked' : '' ?>>
                        <label class="form-check-label" for="dette_payee_pf2">
                            Dette payée au prestataire
                        </label>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="d-flex justify-content-end mt-3">
            <button class="btn btn-primary update" data-annuler="">
                <i class="fas fa-save me-1"></i> Enregistrer les informations d'expédition
            </button>
        </div>
    </div>
</div>