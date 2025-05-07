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

    <div style='clear: both;'></div>

    <?php
    $nom_fichier = "Membres";
    $nom_fichier_datatable = "Membres-" . date('d-m-Y', time()) . "-$nomsiteweb";
    ?>
    <script>
        $(document).ready(function () {
            $(document).on("click", "#deleteThis", function (e) {
                datas = {
                    id: e.target.attributes.data.nodeValue
                }

                $.post({
                    url: '/administration/Modules/Commandes/Commandes-action-supprimer-ajax.php',
                    type: 'POST',
                    data: datas,
                    success: function (res) {
                        res = JSON.parse(res);

                        if (res.retour_validation == "ok") {
                            popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                            setTimeout(() => {
                                document.location.reload();
                            }, 1500)
                        } else {
                            popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                        }
                    }
                });
            });

            $('#Tableau_a').DataTable(
                {
                    responsive: true,
                    stateSave: true,
                    dom: 'Bftipr',
                    "order": [],
                    buttons: [
                        {
                            extend: 'print',
                            text: "Imprimer",
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: 'pdf',
                            filename: "<?php echo "$nom_fichier_datatable"; ?>",
                            title: "<?php echo "$nom_fichier"; ?>",
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: 'csv',
                            filename: "<?php echo "$nom_fichier_datatable"; ?>",
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: 'colvis',
                            text: "Colonnes visibles",
                        }
                    ],
                    columnDefs: [{
                        visible: false
                    }],
                    "language": {
                        "sProcessing": "Traitement en cours...",
                        "sSearch": "Rechercher&nbsp;:",
                        "sLengthMenu": "Afficher _MENU_ &eacute;l&eacute;ments",
                        "sInfo": "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                        "sInfoEmpty": "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
                        "sInfoFiltered": "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                        "sInfoPostFix": "",
                        "sLoadingRecords": "Chargement en cours...",
                        "sZeroRecords": "Aucun &eacute;l&eacute;ment &agrave; afficher",
                        "sEmptyTable": "Aucune donn&eacute;e disponible dans le tableau",
                        "oPaginate": {
                            "sFirst": "Premier",
                            "sPrevious": "Pr&eacute;c&eacute;dent",
                            "sNext": "Suivant",
                            "sLast": "Dernier"
                        },
                        "oAria": {
                            "sSortAscending": ": activer pour trier la colonne par ordre croissant",
                            "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
                        }
                    }
                }
            );


            ///////////////CHAMPS DE RECHERCHE SUR COLONNE
            $('#Tableau_a tfoot .search_table').each(function () {
                var title = $(this).text();
                $(this).html('<input type="text" class="form-control" placeholder="' + title + '" style="width:95%; font-weight: normal;"/>');
            });
            var table = $('#Tableau_a').DataTable();
            table.columns().every(function () {
                var that = this;
                $('input', this.footer()).on('keyup change', function () {
                    if (that.search() !== this.value) {
                        that.search(this.value)
                            .draw();
                    }
                });
            });

        });
    </script>
    <?php
    // Helper function to get status name - add this if it doesn't exist
    function getStatutName($statut)
    {
        switch ($statut) {
            case '2':
                return 'En cours';
            case '3':
                return 'Annulé';
            default:
                return 'Validé';
        }
    }
    ?>
    <div>
        <table class="sa-datatables-init" data-sa-search-input="#table-search">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NOM CLIENT</th>
                    <th>PRIX</th>
                    <th>STATUT</th>
                    <th>CRÉÉE LE</th>
                    <th>GESTION</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Keep database query code as is
                if (empty($_POST['idmembre'])) {
                    $req_boucle = $bdd->prepare("SELECT * FROM membres_commandes WHERE statut != ? ORDER BY id DESC");
                    $req_boucle->execute(array("1"));
                } else {
                    $req_boucle = $bdd->prepare("SELECT * FROM membres_commandes WHERE user_id=? ORDER BY id DESC");
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
                    $membre = $sql_select->fetch();
                    $sql_select->closeCursor();

                    // Get status badge class based on status
                    $badgeClass = "badge-sa-success";
                    if ($statut == "2") {
                        $badgeClass = "badge-sa-warning";
                    } else if ($statut == "3") {
                        $badgeClass = "badge-sa-danger";
                    }
                    ?>
                    <tr>
                        <td><?= $id ?></td>
                        <td><?= $membre['prenom'] ?>         <?= $membre['nom'] ?></td>
                        <td><?= number_format($price, 0, '.', ' ') ?> FCFA</td>
                        <td>
                            <span class="badge <?= $badgeClass ?>"><?= getStatutName($statut) ?></span>
                        </td>
                        <td><?= date('d/m/Y à H:i', $created_at) ?></td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sa-muted btn-sm" type="button" id="dropdown-<?= $id ?>"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdown-<?= $id ?>">
                                    <li><a class="dropdown-item" href="?page=Commandes&action=Details&idaction=<?= $id ?>">Voir
                                            détails</a></li>
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

<?php } else {
    header('location: /index.html');
}

ob_end_flush();
?>