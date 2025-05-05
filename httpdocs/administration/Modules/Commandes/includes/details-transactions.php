<?php
// No direct access
if (!defined('CODI_ONE')) {
    exit('No direct access allowed');
}
?>

<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Historique des transactions</h5>
    </div>
    <div class="card-body p-0">
        <?php if (empty($transactions)): ?>
            <div class="p-4 text-center text-muted">
                <i class="fas fa-receipt fa-3x mb-3"></i>
                <p>Aucune transaction enregistrée pour cette commande</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Montant</th>
                            <th>Moyen de paiement</th>
                            <th>Échéance</th>
                            <th>Motif</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transactions as $transaction):
                            $type_badge_class = $transaction['type'] == 'Paiement' ? 'bg-success' : 'bg-warning text-dark';
                            $date_formatted = date('d/m/Y', $transaction['date']);
                            $echeance_formatted = !empty($transaction['echeance_du']) ? date('d/m/Y', strtotime($transaction['echeance_du'])) : '';
                            ?>
                            <tr>
                                <td><?= $date_formatted ?></td>
                                <td>
                                    <span class="badge <?= $type_badge_class ?>">
                                        <?= $transaction['type'] ?>
                                    </span>
                                </td>
                                <td class="fw-bold <?= $transaction['type'] == 'Remboursement' ? 'text-danger' : '' ?>">
                                    <?= $transaction['type'] == 'Remboursement' ? '-' : '' ?>        <?= number_format($transaction['montant'], 2, ',', ' ') ?>
                                    €
                                </td>
                                <td><?= $transaction['moyen'] ?></td>
                                <td><?= $echeance_formatted ?></td>
                                <td>
                                    <?php if (!empty($transaction['motif'])): ?>
                                        <span class="text-truncate d-inline-block" style="max-width: 200px;"
                                            title="<?= htmlspecialchars($transaction['motif']) ?>">
                                            <?= htmlspecialchars($transaction['motif']) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-outline-info transaction-details"
                                            data-id="<?= $transaction['id'] ?>" title="Voir détails">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <?php if ($admin_oo == 1): // Super admin only ?>
                                            <button type="button" class="btn btn-outline-danger delete-transaction"
                                                data-id="<?= $transaction['id'] ?>" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <div class="card-footer bg-white">
        <div class="row">
            <div class="col-md-4">
                <div class="card border-success h-100">
                    <div class="card-body p-3">
                        <h6 class="card-title text-success mb-0">Total payé</h6>
                        <div class="display-6 fw-bold mb-0">
                            <?= number_format($commande['montant_paye_client'], 2, ',', ' ') ?> €
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-warning h-100">
                    <div class="card-body p-3">
                        <h6 class="card-title text-warning mb-0">Total remboursé</h6>
                        <div class="display-6 fw-bold mb-0">
                            <?= number_format($commande['total_rembourse'], 2, ',', ' ') ?> €
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-primary h-100">
                    <div class="card-body p-3">
                        <h6 class="card-title text-primary mb-0">Solde</h6>
                        <?php
                        $solde = $commande['montant_paye_client'] - $commande['total_rembourse'];
                        $reste_a_payer = $commande['prix_total'] - $solde;
                        $solde_class = $solde >= $commande['prix_total'] ? 'text-success' : 'text-danger';
                        ?>
                        <div class="display-6 fw-bold mb-0 <?= $solde_class ?>">
                            <?= number_format($solde, 2, ',', ' ') ?> €
                        </div>
                        <?php if ($reste_a_payer > 0): ?>
                            <div class="text-danger mt-1">
                                <small>Reste à payer: <?= number_format($reste_a_payer, 2, ',', ' ') ?> €</small>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Transaction Details Modal -->
<div class="modal fade" id="transactionDetailsModal" tabindex="-1" aria-labelledby="transactionDetailsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="transactionDetailsModalLabel">Détails de la transaction</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="transaction-details-content">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Chargement...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>