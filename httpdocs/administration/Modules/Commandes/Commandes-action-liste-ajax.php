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
    <div class="p-4">
        <input type="text" placeholder="Rechercher des commandes..." 
               class="form-control form-control--search mx-auto" id="table-search" />
    </div>

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
                // Keep your existing query logic here...
                if (empty($_POST['idmembre'])) {
                    $req_boucle = $bdd->prepare("SELECT * FROM membres_commandes WHERE type=2 AND statut!='3' ORDER BY id DESC");
                    $req_boucle->execute();
                } else {
                    $req_boucle = $bdd->prepare("SELECT * FROM membres_commandes WHERE type=2 AND statut!='3' AND user_id = ? ORDER BY id DESC");
                    $req_boucle->execute(array($_POST['idmembre']));
                }

                while ($ligne_boucle = $req_boucle->fetch()) {
                    // Keep your existing row rendering code...
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
                            <div class="dropdown">
                                <button class="btn btn-sa-muted btn-sm" type="button" id="commande-context-menu-<?= $id ?>"
                                    data-bs-toggle="dropdown" aria-expanded="false" aria-label="More">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="commande-context-menu-<?= $id ?>">
                                    <li>
                                        <a class="dropdown-item" href="?page=Commandes&action=Details&idaction=<?= $id ?>">
                                            <i class="fas fa-eye me-2"></i>Voir détails
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-danger btn-delete" href="#" data-id="<?= $id ?>">
                                            <i class="fas fa-trash me-2"></i>Supprimer
                                        </a>
                                    </li>
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
    </div>

    <script>
        $(document).ready(function() {
            const template =
                '<"sa-datatables"' +
                '<"sa-datatables__table"t>' +
                '<"sa-datatables__footer"' +
                '<"sa-datatables__pagination"p>' +
                '<"sa-datatables__controls"' +
                '<"sa-datatables__legend"i>' +
                '<"sa-datatables__divider">' +
                '<"sa-datatables__page-size"l>' +
                '>' +
                '>' +
                '>';

            const table = $('.sa-datatables-init').DataTable({
                dom: template,
                paging: true,
                ordering: true,
                info: true,
                responsive: true,
                language: {
                    search: "",
                    searchPlaceholder: "Rechercher...",
                    lengthMenu: "Afficher _MENU_ éléments",
                    info: "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
                    infoEmpty: "Affichage de l'élément 0 à 0 sur 0 élément",
                    infoFiltered: "(filtré de _MAX_ éléments au total)",
                    sZeroRecords: "Aucun élément à afficher",
                    sEmptyTable: "Aucune donnée disponible dans le tableau",
                    paginate: {
                        first: "Premier",
                        previous: "Précédent",
                        next: "Suivant",
                        last: "Dernier"
                    }
                },
                drawCallback: function() {
                    $(this).find('.pagination').addClass('pagination-sm');
                }
            });

            // Search functionality
            const searchSelector = $('#table-search');
            if (searchSelector.length) {
                searchSelector.off('input').on('input', function() {
                    table.search(this.value).draw();
                });

                searchSelector.off('keypress.prevent-form-submit').on('keypress.prevent-form-submit', function(e) {
                    return e.which !== 13;
                });
            }

            // Delete button action
            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();
                const id = $(this).data('id');

                if (confirm('Êtes-vous sûr de vouloir supprimer cette commande ?')) {
                    $.post({
                        url: '/administration/Modules/Commandes/Commandes-action-supprimer-ajax.php',
                        type: 'POST',
                        data: { id: id },
                        success: function(res) {
                            res = JSON.parse(res);

                            if (res.retour_validation == "ok") {
                                showToast("success", "Succès", res.Texte_rapport);
                                setTimeout(function() {
                                    location.reload();
                                }, 1500);
                            } else {
                                showToast("error", "Erreur", res.Texte_rapport);
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