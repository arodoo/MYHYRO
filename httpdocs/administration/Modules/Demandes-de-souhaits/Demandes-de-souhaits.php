<?php
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
    $idaction = isset($_GET['idaction']) ? $_GET['idaction'] : "";
    $action = isset($_GET['action']) ? $_GET['action'] : "";
    $idmembre = isset($_GET['idmembre']) ? $_GET['idmembre'] : "";
    define('CODI_ADMIN', true);

    // Check if we're in edit mode
    if ($action == 'edit' && !empty($idaction)) {
        // Include the edit form
        include('Modules/Demandes-de-souhaits/demandes-action-edit-form.php');
    } else {
        // Default view - show the list
        ?>

        <script>
            $(document).ready(function () {
                // Load all requests list
                function listeDemandes() {
                    $.post({
                        url: '/administration/Modules/Demandes-de-souhaits/demandes-action-liste-ajax.php',
                        type: 'POST',
                        data: { idmembre: "<?= $idmembre ?>" },
                        dataType: "html",
                        success: function (res) {
                            $("#liste-demandes").html(res);
                            initializeDataTables();
                        }
                    });
                }

                // Initialize DataTables
                function initializeDataTables() {
                    if ($.fn.DataTable.isDataTable('.sa-datatables-init')) {
                        $('.sa-datatables-init').DataTable().destroy();
                    }

                    setTimeout(function () {
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

                        $('.sa-datatables-init').each(function () {
                            const table = $(this).DataTable({
                                dom: template,
                                paging: true,
                                ordering: true,
                                info: true,
                                language: {
                                    search: "",
                                    searchPlaceholder: "Rechercher...",
                                    lengthMenu: "Afficher _MENU_ éléments",
                                    info: "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
                                    infoEmpty: "Affichage de l'élément 0 à 0 sur 0 élément",
                                    infoFiltered: "(filtré de _MAX_ éléments au total)",
                                    paginate: {
                                        first: "Premier",
                                        previous: "Précédent",
                                        next: "Suivant",
                                        last: "Dernier"
                                    }
                                },
                                // Fix: Corrected drawCallback implementation
                                drawCallback: function () {
                                    $(this).find('.pagination').addClass('pagination-sm');
                                }
                            });

                            const searchSelector = $(this).data('sa-search-input');
                            if (searchSelector) {
                                $(searchSelector).off('input').on('input', function () {
                                    table.search(this.value).draw();
                                });

                                $(searchSelector).off('keypress.prevent-form-submit').on('keypress.prevent-form-submit', function (e) {
                                    return e.which !== 13;
                                });
                            }
                        });
                    }, 10);
                }

                // View detail modal
                $(document).on('click', '.btnDetailModal', function () {
                    var id = $(this).data('id');
                    $.post({
                        url: '/administration/Modules/Demandes-de-souhaits/demandes-action-detail-ajax.php',
                        type: 'POST',
                        data: { id: id },
                        dataType: "html",
                        success: function (res) {
                            $("#modal-container").html(res);
                            $("#modalDetail").modal('show');
                        }
                    });
                });

                // Delete request event handler
                $(document).on("click", ".btnSupprModal", function () {
                    var id = $(this).data('id');
                    $.post({
                        url: '/administration/Modules/Demandes-de-souhaits/modal-supprimer-ajax.php',
                        type: 'POST',
                        data: { id: id },
                        dataType: "html",
                        success: function (res) {
                            $("#modal-container").html(res);
                            $("#modalSuppr").modal('show');
                        }
                    });
                });

                // Deletion confirmation button handler
                $(document).on("click", "#btnSuppr", function () {
                    var id = $(this).data('id');
                    $.post({
                        url: '/administration/Modules/Demandes-de-souhaits/demandes-action-supprimer-ajax.php',
                        type: 'POST',
                        data: { id: id },
                        dataType: "json",
                        success: function (res) {
                            if (res.retour_validation == "ok") {
                                popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                            } else {
                                popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                            }
                            listeDemandes();
                            $("#modalSuppr").modal('hide');
                        }
                    });
                });

                // Initialize
                listeDemandes();
            });
        </script>

        <div id="top" class="sa-app__body">
            <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
                <div class="container">
                    <div class="py-5">
                        <div class="row g-4 align-items-center">
                            <div class="col">
                                <nav class="mb-2" aria-label="breadcrumb">
                                    <ol class="breadcrumb breadcrumb-sa-simple">
                                        <li class="breadcrumb-item"><a href="index-admin.php">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Demandes de souhaits</li>
                                    </ol>
                                </nav>
                                <h1 class="h3 m-0">Gestion des demandes de souhaits</h1>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="p-4">
                            <input type="text" placeholder="Rechercher des demandes..."
                                class="form-control form-control--search mx-auto" id="table-search" />
                        </div>
                        <div class="sa-divider"></div>

                        <!-- Requests list will be loaded here via AJAX -->
                        <div id="liste-demandes"></div>
                    </div>

                    <!-- Modal container for dynamically loaded modals -->
                    <div id="modal-container"></div>
                </div>
            </div>
        </div>

        <?php
    } // End of list view
} else {
    header('location: /index.html');
}
?>