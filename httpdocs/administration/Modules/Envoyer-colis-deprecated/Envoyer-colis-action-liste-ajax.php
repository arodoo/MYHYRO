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
        $(document).ready(function() {
            $(document).on("click", "#deleteThis", function(e) {
                datas = {
                    id: e.target.attributes.data.nodeValue
                }

                $.post({
                    url: '/administration/Modules/Envoyer-colis/Envoyer-colis-action-supprimer-ajax.php',
                    type: 'POST',
                    data: datas,
                    success: function(res) {
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

            $('#Tableau_a').DataTable({
                responsive: true,
                stateSave: true,
                dom: 'Bftipr',
                "order": [],
                buttons: [{
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
            });

            ///////////////CHAMPS DE RECHERCHE SUR COLONNE
            $('#Tableau_a tfoot .search_table').each(function() {
                var title = $(this).text();
                $(this).html('<input type="text" class="form-control" placeholder="' + title + '" style="width:95%; font-weight: normal;"/>');
            });
            var table = $('#Tableau_a').DataTable();
            table.columns().every(function() {
                var that = this;
                $('input', this.footer()).on('keyup change', function() {
                    if (that.search() !== this.value) {
                        that.search(this.value)
                            .draw();
                    }
                });
            });

        });
    </script>

    <table id='Tableau_a' class="display nowrap" style="text-align: center; width: 100%; margin-top: 15px;" cellpadding="2" cellspacing="2">

        <thead>
            <tr>
                <th scope="col" style="text-align: center;">ID</th>
                <th scope="col" style="text-align: center;">NOM CLIENT</th>
                <th style="text-align: center;">PRIX</th>
                <th style="text-align: center;">STATUT</th>
                <th class="search_table" style="text-align: center;">CRÉÉE LE</th>
                <th style="text-align: center; width: 100px;">GESTION</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th class="search_table" style="text-align: center;">ID</th>
                <th class="search_table" style="text-align: center;">NOM CLIENT</th>
                <th style="text-align: center;">PRIX</th>
                <th class="search_table" style="text-align: center;">STATUT</th>
                <th class="search_table" style="text-align: center;">CRÉÉE LE</th>
                <th style="text-align: center; width: 90px;">GESTION</th>
            </tr>
        </tfoot>

        <tbody>
            <?php
            ///////////////////////////////SELECT BOUCLE

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
                $updated_at = $ligne_boucle['updated_at'];

                $sql_select = $bdd->prepare("SELECT * FROM membres WHERE id=?");
                $sql_select->execute(array($user_id));
                $ligne_select = $sql_select->fetch();
                $sql_select->closeCursor();
                $user_name = $ligne_select['prenom'] . " " . $ligne_select['nom'];
            ?>

                <tr>
                    <td style="text-align: center;">
                        <?= $id ?>
                    </td>
                    <td style="text-align: center;">
                        <?= $user_name ?>
                    </td>
                    <td style="text-align: center;">
                        <?= $price ?> F CFA
                    </td>
                    <td style="text-align: center;">
                        <?php 
                        $sql_select = $bdd->prepare("SELECT * FROM configurations_suivi_achat WHERE id=?");
                        $sql_select->execute(array($statut));
                        $ligne_statut = $sql_select->fetch();
                        $sql_select->closeCursor();
                        ?>
                            <span class="label label-primary"><?= $ligne_statut["nom_suivi"] ?></span>

                    </td>
                    <!-- changer la date de create_up à updarte_up -->
                    <td style="text-align: center">
                        <?php if ($created_at > 0) : ?>
                            <?= date("m/d/Y H:i:s", $created_at) ?>
                        <?php else : ?>
                            Non disponible
                        <?php endif; ?>

                    </td>
                    <td style="text-align: center;">
                        <a data-id=<?= $id ?> href='?page=Envoyer-colis&action=Details&idaction=<?= $id ?>' title='Plus de détails'><span class='uk-icon-file-text'></span></a>
                        <a id="deleteThis" data=<?= $id ?> href="#" title='Supprimer'><span data=<?= $id ?> class='uk-icon-trash-o'></span></a>
                    </td>

                </tr>

            <?php
            }
            $req_boucle->closeCursor();
            ?>
        </tbody>
    </table>

<?php } else {
    header('location: /index.html');
}

ob_end_flush();
?>