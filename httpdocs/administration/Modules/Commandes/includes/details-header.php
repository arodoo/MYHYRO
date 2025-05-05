<?php
// No direct access
if (!defined('CODI_ONE')) {
    exit('No direct access allowed');
}
?>

<div class="card mb-4">
    <div class="card-body">
        <?php if ($is_dashboard): ?>
            <div class="mb-4">
                <a href="javascript:history.back()" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Retour à la liste
                </a>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-8">
                <h2 class="mb-0">Commande #<?= $commande['id'] ?></h2>
                <div class="text-muted mb-3">
                    <?php echo date('d/m/Y à H:i', $commande['created_at']); ?>
                </div>

                <?php if ($commande['statut_2'] == '3'): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i> Cette commande a été annulée
                    </div>
                <?php endif; ?>

                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0">Historique des modifications</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive" style="max-height: 200px; overflow-y: auto;">
                            <table class="table table-sm table-hover mb-0">
                                <tbody>
                                    <?php
                                    $req_boucle = $bdd->prepare("SELECT * FROM admin_commandes_historique WHERE id_commande=? ORDER BY id DESC");
                                    $req_boucle->execute(array($_POST['idaction']));
                                    $has_history = false;

                                    while ($ligne_boucle = $req_boucle->fetch()) {
                                        $has_history = true;
                                        $req_select = $bdd->prepare("SELECT * FROM membres WHERE id=?");
                                        $req_select->execute(array($ligne_boucle['id_membre']));
                                        $ligne_admin = $req_select->fetch();
                                        $req_select->closeCursor();

                                        $action_text = !empty($ligne_boucle['action']) ? ' - ' . $ligne_boucle['action'] : '';
                                        ?>
                                        <tr>
                                            <td>
                                                <small>
                                                    <i class="fas fa-user"></i> <?= $ligne_admin['prenom'] ?>
                                                    <i class="fas fa-clock ms-2"></i>
                                                    <?= date('d-m-Y à H:i', $ligne_boucle['date']) ?>
                                                    <?= $action_text ?>
                                                    <?= !empty($ligne_boucle['details']) ? '<br>' . $ligne_boucle['details'] : '' ?>
                                                </small>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                    <?php if (!$has_history): ?>
                                        <tr>
                                            <td class="text-center py-3 text-muted">Aucune modification enregistrée</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">Informations client</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-1">
                            <strong>Client:</strong>
                            <a href="?page=Membres&action=Modifier&idaction=<?= $id_membre ?>"><?= $pseudo_membre ?></a>
                        </p>
                        <p class="mb-1"><strong>Email:</strong> <?= $membre['email'] ?></p>
                        <p class="mb-1"><strong>Téléphone:</strong> <?= $membre['telephone'] ?: 'Non renseigné' ?></p>

                        <?php if (!empty($colis_lie["id"])): ?>
                            <hr>
                            <div class="alert alert-info mb-0">
                                <i class="fas fa-box"></i>
                                <a href='?page=Envoyer-colis&action=Details&idaction=<?= $colis_lie["id"] ?>'>
                                    Cette commande est rattachée à un colis #<?= $colis_lie["id"] ?>, cliquez ici pour le
                                    traiter
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <input id="idWish" type="hidden" value="<?= $commande['id']; ?>" />
        <input id="idMembre" type="hidden" value="<?= $id_membre; ?>" />

        <div class="mt-4">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="btn-group">
                        <button id="annuler_commande"
                            class="btn <?= $commande['statut_2'] == 3 ? "btn-danger" : "btn-outline-danger" ?> update"
                            data-annuler="oui" <?= $commande['statut_2'] == 2 || $commande['statut_2'] == 3 ? "disabled" : "" ?>>
                            <?= $commande['statut_2'] == 3 ? '<i class="fas fa-ban me-1"></i> Commande annulée' : '<i class="fas fa-times me-1"></i> Annuler commande' ?>
                        </button>

                        <button class="btn btn-primary" id="openAllProductLinks">
                            <i class="fas fa-shopping-cart me-1"></i> COMMANDER
                        </button>

                        <?php if ($commande['statut_2'] != 3): ?>
                            <button class="btn btn-success update" data-annuler="">
                                <i class="fas fa-save me-1"></i> ENREGISTRER
                            </button>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="input-group">
                        <select id="statut_2" class="form-select">
                            <?php
                            $req_boucle = $bdd->prepare("SELECT * FROM configurations_suivi_achat ORDER BY id ASC");
                            $req_boucle->execute();

                            while ($ligne_boucle = $req_boucle->fetch()) {
                                $selected = ($commande['statut_2'] == $ligne_boucle['id']) ? 'selected' : '';
                                echo '<option value="' . $ligne_boucle['id'] . '" ' . $selected . '>' . $ligne_boucle['nom_suivi'] . '</option>';
                            }
                            ?>
                        </select>
                        <button class="btn btn-primary update" data-annuler="">
                            <i class="fas fa-check"></i> Changer statut
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>