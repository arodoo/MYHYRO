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

if (
    isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 1 ||
    isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 2 ||
    isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 3
) {
    ?>

    <div class="table-responsive">
        <table class="sa-datatables-init" data-order='[[ 0, "desc" ]]' data-sa-search-input="#table-search">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>CLIENT</th>
                    <th>PRIX</th>
                    <th>STATUT</th>
                    <th>DATE</th>
                    <th width="100">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (empty($_POST['idmembre'])) {
                    $req_boucle = $bdd->prepare("SELECT * FROM membres_commandes WHERE type=2 AND statut!='3' ORDER BY id DESC");
                    $req_boucle->execute();
                } else {
                    $req_boucle = $bdd->prepare("SELECT * FROM membres_commandes WHERE type=2 AND statut!='3' AND user_id = ? ORDER BY id DESC");
                    $req_boucle->execute(array($_POST['idmembre']));
                }

                while ($ligne_boucle = $req_boucle->fetch()) {
                    $id = $ligne_boucle['id'];
                    $user_id = $ligne_boucle['user_id'];
                    $prix_total = number_format($ligne_boucle['prix_total'], 0, '.', ' ');
                    $statut = $ligne_boucle['statut'];
                    $statut_2 = $ligne_boucle['statut_2'];
                    $created_at = date('d-m-Y', $ligne_boucle['created_at']);

                    // Get user info
                    $sql_select = $bdd->prepare("SELECT * FROM membres WHERE id=?");
                    $sql_select->execute(array($user_id));
                    $ligne_select = $sql_select->fetch();
                    $sql_select->closeCursor();
                    $user_name = $ligne_select['prenom'] . " " . $ligne_select['nom'];

                    // Get status info
                    $req_select = $bdd->prepare("SELECT * FROM configurations_suivi_achat Where id=?");
                    $req_select->execute(array($statut_2));
                    $ligne_select2 = $req_select->fetch();
                    $req_select->closeCursor();

                    $statut_class = '';
                    $statut_text = '';

                    if ($statut_2 == 1) {
                        $statut_class = 'sa-badge--success';
                        $statut_text = 'En cours';
                    } elseif ($statut_2 == 2) {
                        $statut_class = 'sa-badge--warning';
                        $statut_text = 'En attente';
                    } elseif ($statut_2 == 3) {
                        $statut_class = 'sa-badge--danger';
                        $statut_text = 'Annulée';
                    } else {
                        $statut_class = 'sa-badge--info';
                        $statut_text = $ligne_select2['nom_suivi'] ?? 'N/A';
                    }
                    ?>
                    <tr>
                        <td><?= $id ?></td>
                        <td><?= $user_name ?></td>
                        <td><?= $prix_total ?> F CFA</td>
                        <td>
                            <div class="sa-badge <?= $statut_class ?>"><?= $statut_text ?></div>
                        </td>
                        <td><?= $created_at ?></td>
                        <td>
                            <a href="?page=Commandes&action=Details&idaction=<?= $id ?>" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="<?= $id ?>">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php
                }
                $req_boucle->closeCursor();
                ?>
            </tbody>
        </table>
    </div>

    <script>
        // Initialize DataTables
        $(document).ready(function () {
            const table = $('.sa-datatables-init').DataTable({
                responsive: true,
                language: {
                    "sProcessing": "Traitement en cours...",
                    "sSearch": "Rechercher :",
                    "sLengthMenu": "Afficher _MENU_ éléments",
                    "sInfo": "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
                    "sInfoEmpty": "Affichage de l'élément 0 à 0 sur 0 élément",
                    "sInfoFiltered": "(filtré de _MAX_ éléments au total)",
                    "sInfoPostFix": "",
                    "sLoadingRecords": "Chargement en cours...",
                    "sZeroRecords": "Aucun élément à afficher",
                    "sEmptyTable": "Aucune donnée disponible dans le tableau",
                    "oPaginate": {
                        "sFirst": "Premier",
                        "sPrevious": "Précédent",
                        "sNext": "Suivant",
                        "sLast": "Dernier"
                    },
                    "oAria": {
                        "sSortAscending": ": activer pour trier la colonne par ordre croissant",
                        "sSortDescending": ": activer pour trier la colonne par ordre décroissant"
                    }
                }
            });

            // Delete button action
            $('.btn-delete').on('click', function () {
                const id = $(this).data('id');

                if (confirm('Êtes-vous sûr de vouloir supprimer cette commande ?')) {
                    $.post({
                        url: '/administration/Modules/Commandes/Commandes-action-supprimer-ajax.php',
                        type: 'POST',
                        data: { id: id },
                        success: function (res) {
                            res = JSON.parse(res);

                            if (res.retour_validation == "ok") {
                                // Show success message
                                const toastContainer = $(".sa-app__toasts");
                                const toastHTML = `
                                <div class="toast align-items-center border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                                    <div class="d-flex">
                                        <div class="toast-body text-success">
                                            <strong>Succès:</strong> ${res.Texte_rapport}
                                        </div>
                                        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                    </div>
                                </div>
                            `;
                                toastContainer.append(toastHTML);
                                setTimeout(function () {
                                    toastContainer.find('.toast').first().remove();
                                    // Reload data
                                    location.reload();
                                }, 3000);
                            } else {
                                // Show error message
                                const toastContainer = $(".sa-app__toasts");
                                const toastHTML = `
                                <div class="toast align-items-center border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                                    <div class="d-flex">
                                        <div class="toast-body text-danger">
                                            <strong>Erreur:</strong> ${res.Texte_rapport}
                                        </div>
                                        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                    </div>
                                </div>
                            `;
                                toastContainer.append(toastHTML);
                                setTimeout(function () {
                                    toastContainer.find('.toast').first().remove();
                                }, 3000);
                            }
                        }
                    });
                }
            });
        });
    </script>

    <?php
} else {
    header('location: /index.html');
}
ob_end_flush();
?>