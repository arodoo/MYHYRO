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
    ?>
    <div class="sa-app__content">
        <!-- sa-app__body -->
        <div id="top" class="sa-app__body">
            <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
                <div class="container container--max--xl">
                    <div class="py-5">
                        <div class="row g-4 align-items-center">
                            <div class="col">
                                <nav class="mb-2" aria-label="breadcrumb">
                                    <ol class="breadcrumb breadcrumb-sa-simple">
                                        <li class="breadcrumb-item"><a href="<?php echo $mode_back_lien_interne; ?>">Administration</a></li>
                                        <?php if (empty($_GET['action'])) { ?> 
                                            <li class="breadcrumb-item active" aria-current="page">Colis</li> 
                                        <?php } else { ?> 
                                            <li class="breadcrumb-item"><a href="?page=Envoyer-colis">Colis</a></li> 
                                            <?php if ($_GET['action'] == "Details") { ?> 
                                                <li class="breadcrumb-item active" aria-current="page">Détails</li> 
                                            <?php } ?>
                                        <?php } ?>
                                    </ol>
                                </nav>
                                <h1 class="h3 m-0">Gestion des colis</h1>
                            </div>
                            <div class="col-auto d-flex">
                                <?php if (isset($_GET['action'])) { ?>
                                    <a href="?page=Envoyer-colis" class="btn btn-primary">Liste des colis</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <script>
                        // Make listeColis accessible globally
                        window.listeColis = function() {
                            $.post({
                                url: '/administration/Modules/Envoyer-colis/Envoyer-colis-action-liste-ajax.php',
                                type: 'POST',
                                data: {
                                    idmembre: "<?php echo $_GET['idmembre'] ? $_GET['idmembre'] : ""; ?>"
                                },
                                dataType: "html",
                                success: function(res) {
                                    $("#liste-colis").html(res);
                                    initializeDataTables();
                                }
                            });
                        }
                        
                        // Initialize DataTables with proper styling
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

                        $(document).ready(function() {
                            listeColis();
                        });
                    </script>

                    <?php
                    $action = $_GET['action'] ?? '';
                    $idaction = $_GET['idaction'] ?? '';

                    if ($action == "Details") {
                        ?>
                        <div id="details-colis">
                            <!-- Content will be loaded via AJAX -->
                            <script>
                                $.post({
                                    url: '/administration/Modules/Envoyer-colis/Envoyer-colis-action-details-ajax.php',
                                    type: 'POST',
                                    data: {
                                        idaction: "<?php echo $_GET['idaction']; ?>"
                                    },
                                    dataType: "html",
                                    success: function (res) {
                                        $("#details-colis").html(res);
                                    }
                                });
                            </script>
                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="card">
                            <div class="card-body" id="liste-colis">
                                <!-- Content will be loaded via AJAX -->
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <!-- sa-app__body / end -->
    </div>
    <?php
} else {
    header('location: /index.html');
}
?>