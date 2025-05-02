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

    $idaction = $_POST['idaction'];

    $nom_fichier = "Logs des membres";
    $nom_fichier_datatable = "Logs-des-membres-" . date('d-m-Y', time()) . "-$nomsiteweb";
    ?>

    <div class="card">
        <div class="p-4">
            <input
                type="text"
                placeholder="Rechercher des logs..."
                class="form-control form-control--search mx-auto"
                id="table-search" />
        </div>
        <div class="sa-divider"></div>
        <table class="sa-datatables-init" data-order='[[ 0, "desc" ]]' data-sa-search-input="#table-search">
            <thead>
                <tr>
                    <th scope="col" style="text-align: center;">DATE</th>
                    <th style="text-align: center;">PSEUDO</th>
                    <th style="text-align: center;">E-MAIL</th>
                    <th style="text-align: center;">SUJET</th>
                    <th style="text-align: center; width: 90px;">CONSULTER</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($idaction)) {
                    // Your existing code for fetching data
                    ///////////////////////////////SELECT
                    $req_select = $bdd->prepare("SELECT * FROM membres WHERE id=?");
                    $req_select->execute(array($idaction));
                    $ligne_select = $req_select->fetch();
                    $req_select->closeCursor();
                    $idd2dddf = $ligne_select['id'];
                    $loginm = $ligne_select['pseudo'];
                    $emailm = $ligne_select['mail'];
                    $adminm = $ligne_select['admin'];
                    $nomm = $ligne_select['nom'];
                    $prenomm = $ligne_select['prenom'];

                    ///////////////////////////////SELECT BOUCLE
                    $req_boucle = $bdd->prepare("SELECT * FROM membres_logs WHERE mail_compte_concerne=? AND mail_compte_concerne!=? ORDER BY date_seconde DESC");
                    $req_boucle->execute(array($emailm, ''));
                } else {
                    ///////////////////////////////SELECT BOUCLE
                    $req_boucle = $bdd->prepare("SELECT * FROM membres_logs ORDER BY date_seconde DESC");
                    $req_boucle->execute();
                }

                while ($ligne_boucle = $req_boucle->fetch()) {
                    $idd = $ligne_boucle['id'];
                    $id_membre = $ligne_boucle['id_membre'];
                    $pseudo = $ligne_boucle['pseudo'];
                    $mail_compte_concerne = $ligne_boucle['mail_compte_concerne'];
                    $module = $ligne_boucle['module'];
                    $action_sujet = $ligne_boucle['action_sujet'];
                    $action_libelle = $ligne_boucle['action_libelle'];
                    $action = $ligne_boucle['action'];
                    $date = $ligne_boucle['date'];
                    $date_seconde = $ligne_boucle['date_seconde'];
                    $heure = $ligne_boucle['heure'];
                    $ip = $ligne_boucle['ip'];
                    $navigateur = $ligne_boucle['navigateur'];
                    $navigateur_version = $ligne_boucle['navigateur_version'];
                    $referrer = $ligne_boucle['referrer'];
                    $uri = $ligne_boucle['uri'];
                    $cookies_autorisees = $ligne_boucle['cookies_autorisees'];
                    $os = $ligne_boucle['os'];
                    $langue = $ligne_boucle['langue'];
                    $niveau = $ligne_boucle['niveau'];
                    $lieu = $ligne_boucle['lieu'];
                    $compte_bloque = $ligne_boucle['compte_bloque'];

                    if ($compte_bloque == "oui") {
                        $compte_bloque_rapport = "oui";
                    } else {
                        $compte_bloque_rapport = "--";
                    }

                    ///////////////////////////////SELECT
                    $req_select = $bdd->prepare("SELECT * FROM membres WHERE mail=?");
                    $req_select->execute(array($mail_compte_concerne));
                    $ligne_select = $req_select->fetch();
                    $req_select->closeCursor();
                    $login_membre = $ligne_select['pseudo'];
                    $email_membre = $ligne_select['mail'];
                    ?>

                    <tr>
                        <td style='text-align: center;'><?php echo "$date à $heure"; ?></td>
                        <td style='text-align: center;'><?php echo "$pseudo"; ?></td>
                        <td style='text-align: center;'><?php echo "$mail_compte_concerne"; ?></td>
                        <td style='text-align: center;'>
                            <?php
                            if ($compte_bloque == "oui") {
                                echo "<span class='badge bg-danger'>Compte bloqué</span>";
                            }
                            if ($niveau == 1) {
                                echo "<span class='badge bg-danger'>Niveau important</span>";
                            }
                            if ($niveau == 2) {
                                echo "<span class='badge bg-warning'>Niveau moyen</span>";
                            }
                            if ($niveau == 3) {
                                echo "<span class='badge bg-info'>Niveau faible</span>";
                            }
                            if ($niveau > 3) {
                                echo "<span class='badge bg-secondary'>Information</span>";
                            }
                            ?>
                            <br />
                            <?php echo html_entity_decode($action_sujet) ?>
                        </td>
                        <td style='text-align: center;'>
                            <a href='?page=Membres-logs&amp;action=consulter&amp;idaction=<?php echo $idd; ?>' class="btn btn-sm btn-light">
                                <i class="far fa-file-alt"></i>
                            </a>
                        </td>
                    </tr>
                    <?php
                }
                $req_boucle->closeCursor();
                ?>
            </tbody>
        </table>
    </div>

    <!-- <script>
        $(document).ready(function() {
            // Initialize DataTable with configuration matching the template structure
            const table = $('.sa-datatables-init').DataTable({
                responsive: true,
                stateSave: true,
                dom: '<"sa-datatables-header"<"sa-datatables-header__inner"<"sa-datatables-header__start"f><"sa-datatables-header__end"<"d-flex align-items-center"<"me-auto"l>B>>>>' +
                     '<"sa-datatables-table"t>' +
                     '<"sa-datatables-footer"<"sa-datatables-footer__inner"<"sa-datatables-footer__start"i><"sa-datatables-footer__end"p>>>',
                buttons: [
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Imprimer',
                        className: 'btn btn-sm btn-secondary',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="far fa-file-pdf"></i> PDF',
                        className: 'btn btn-sm btn-secondary',
                        filename: "<?php echo "$nom_fichier_datatable"; ?>",
                        title: "<?php echo "$nom_fichier"; ?>",
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'csv',
                        text: '<i class="far fa-file-excel"></i> CSV',
                        className: 'btn btn-sm btn-secondary',
                        filename: "<?php echo "$nom_fichier_datatable"; ?>",
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'colvis',
                        text: '<i class="fas fa-columns"></i> Colonnes',
                        className: 'btn btn-sm btn-secondary',
                    }
                ],
                columnDefs: [
                    { orderable: false, targets: 4 }
                ],
                language: {
                    processing: "Traitement en cours...",
                    search: "Rechercher&nbsp;:",
                    lengthMenu: "Afficher _MENU_ éléments",
                    info: "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
                    infoEmpty: "Affichage de l'élément 0 à 0 sur 0 élément",
                    infoFiltered: "(filtré de _MAX_ éléments au total)",
                    infoPostFix: "",
                    loadingRecords: "Chargement en cours...",
                    zeroRecords: "Aucun élément à afficher",
                    emptyTable: "Aucune donnée disponible dans le tableau",
                    paginate: {
                        first: "Premier",
                        previous: "Précédent",
                        next: "Suivant",
                        last: "Dernier"
                    },
                    aria: {
                        sortAscending: ": activer pour trier la colonne par ordre croissant",
                        sortDescending: ": activer pour trier la colonne par ordre décroissant"
                    }
                }
            });

            // Apply proper styles to pagination for consistency
            $(table.table().container()).find('.pagination').addClass('pagination-sm');
        });
    </script> -->

<?php
} else {
    header('location: /index.html');
}

ob_end_flush();
?>