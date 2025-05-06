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
    ?>
    <div class="sa-datatables-header">
        <div class="sa-datatables-header__title">
            <h2>Liste des colis</h2>
        </div>
        <div class="sa-datatables-header__search">
            <input type="text" placeholder="Recherche" class="form-control form-control--search" id="table-search">
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Add modal HTML at the bottom of the page
            $('body').append(`
                <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteConfirmModalLabel">Confirmer la suppression</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Êtes-vous sûr de vouloir supprimer ce colis ?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                <button type="button" class="btn btn-danger" id="confirmDelete">Supprimer</button>
                            </div>
                        </div>
                    </div>
                </div>
            `);
            
            // Store the ID to delete
            let idToDelete = null;
            
            // Delete action handler - open modal instead of browser confirm
            $(document).on("click", "#deleteThis", function (e) {
                e.preventDefault();
                idToDelete = $(this).attr('data');
                
                // Show the modal instead of browser confirm
                var deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
                deleteModal.show();
            });
            
            // Confirm delete button in modal
            $(document).on("click", "#confirmDelete", function() {
                if (idToDelete) {
                    $.post({
                        url: '/administration/Modules/Envoyer-colis/Envoyer-colis-action-supprimer-ajax.php',
                        type: 'POST',
                        data: { id: idToDelete },
                        success: function (res) {
                            res = JSON.parse(res);
                            if (res.retour_validation == "ok") {
                                // Hide the modal
                                bootstrap.Modal.getInstance(document.getElementById('deleteConfirmModal')).hide();
                                
                                // Show success message
                                popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                                
                                // Refresh the list
                                if (window.parent && window.parent.listeColis) {
                                    window.parent.listeColis();
                                } else {
                                    // Fallback if parent function isn't accessible
                                    setTimeout(() => {
                                        $.post({
                                            url: '/administration/Modules/Envoyer-colis/Envoyer-colis-action-liste-ajax.php',
                                            type: 'POST',
                                            data: { idmembre: "<?php echo $_POST['idmembre'] ?? ''; ?>" },
                                            dataType: "html",
                                            success: function(res) {
                                                $("#liste-colis", window.parent.document).html(res);
                                            }
                                        });
                                    }, 1000);
                                }
                            } else {
                                // Show error message
                                popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                            }
                        }
                    });
                }
            });
        });
    </script>

    <table id="Tableau_a" class="sa-datatables-init" data-order='[[ 0, "desc" ]]' data-sa-search-input="#table-search">
        <thead>
            <tr>
                <th>ID</th>
                <th>CLIENT</th>
                <th>PRIX</th>
                <th>STATUT</th>
                <th>CRÉÉE LE</th>
                <th>ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Keep database query code as is
            if (empty($_POST['idmembre'])) {
                $req_boucle = $bdd->prepare("SELECT * FROM membres_colis WHERE statut != ? ORDER BY id DESC");
                $req_boucle->execute(array("1"));
            } else {
                $req_boucle = $bdd->prepare("SELECT * FROM membres_colis WHERE user_id=? ORDER BY id DESC");
                $req_boucle->execute(array($_POST['idmembre']));
            }

            while ($ligne_boucle = $req_boucle->fetch()) {
                $id = $ligne_boucle['id'];
                $statut = $ligne_boucle['statut'];
                $price = $ligne_boucle['prix_total'];
                $created_at = $ligne_boucle['created_at'];
                $user_id = $ligne_boucle['user_id'];

                $sql_select = $bdd->prepare("SELECT * FROM membres WHERE id=?");
                $sql_select->execute(array($user_id));
                $ligne_select = $sql_select->fetch();
                $sql_select->closeCursor();
                $user_name = $ligne_select['prenom'] . " " . $ligne_select['nom'];

                $sql_select = $bdd->prepare("SELECT * FROM configurations_suivi_achat WHERE id=?");
                $sql_select->execute(array($statut));
                $ligne_statut = $sql_select->fetch();
                $sql_select->closeCursor();
                ?>
                <tr>
                    <td><?= $id ?></td>
                    <td><?= $user_name ?></td>
                    <td><?= $price ?> F CFA</td>
                    <td>
                        <span class="badge badge-sa-primary"><?= $ligne_statut["nom_suivi"] ?></span>
                    </td>
                    <td>
                        <?php if ($created_at > 0): ?>
                            <?= date("d/m/Y H:i:s", $created_at) ?>
                        <?php else: ?>
                            Non disponible
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sa-muted btn-sm" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false" aria-label="More">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item"
                                        href="?page=Envoyer-colis&action=Details&idaction=<?= $id ?>">Détails</a></li>
                                <li><a class="dropdown-item text-danger" href="#" id="deleteThis"
                                        data="<?= $id ?>">Supprimer</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                <?php
            }
            $req_boucle->closeCursor();
            ?>
        </tbody>
    </table>

<?php
} else {
    header('location: /index.html');
}

ob_end_flush();
?>