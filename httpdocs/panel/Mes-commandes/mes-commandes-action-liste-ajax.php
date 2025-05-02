<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../Configurations_bdd.php');
require_once('../../Configurations.php');
require_once('../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction = "../../";
require_once('../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

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

?>
<style>
    .btn-details {
        border: none;
        background-color: rgba(0, 0, 0, 0);
        color: #FF9900;
    }

    #Tableau_a_info {
        display: none;
    }

    #Tableau_a_paginate {
        display: none;
    }

    #Tableau_a_length {
        display: none;
    }

    .btn-visualiser {
        display: none;
        width: 100%;
    }

    .btn-visualiser-annuler {
        display: none;
        width: 100%;
    }

    @media screen and (max-width: 612px) {

        .btn-visualiser {
            display: block;
            width: 100%;
        }

        .btn-visualiser-annuler {
            display: block;
            width: 100%;
        }

        .btn-predeterminate {
            display: none;
        }

        .btn-predeterminate-annuler {
            display: none;
        }
    }
</style>
<div style='clear: both;'></div>


<script>
    function handleClick(id) {
        datas = {
            id: id
        }

        $.post({
            url: '/panel/Mes-commandes/mes-commandes-action-supprimer-ajax.php',
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
        })
    }

    function handleShow(id) {
        datas = {
            id: id
        }
        $.post({
            url: '/panel/Mes-commandes/mes-commandes-action-details-ajax.php',
            type: 'POST',
            data: datas,
            dataType: "html",
            success: function(res) {
                $("#commandDetail").html(res);
                $("#commandDetail").modal('show');
                $('body').addClass('overflow-hidden'); // Désactive le défilement dans le corps
            }
        });
    }



    $('#commandDetail').on('hidden.bs.modal', function() {
        $('body').removeClass('overflow-hidden');
    });



    function handleRegul(id) {
        datas = {
            id: id
        }
        $.post({
            url: '/panel/Mes-commandes/mes-commandes-action-regulation-ajax.php',
            type: 'POST',
            data: datas,
            success: function(res) {
                res = JSON.parse(res);
                if (res.retour_validation == "ok") {
                    document.location.replace('/Regulation');
                } else if (res.retour_validation == "non") {
                    document.location.reload();
                }
            }
        });
    }


    function handleUpdate(id) {
        datas = {
            id: id
        }
        $.post({
            url: '/panel/Mes-commandes/mes-commandes-action-redirect-ajax.php',
            type: 'POST',
            data: datas,
            success: function(res) {
                res = JSON.parse(res);
                if (res.retour_validation == "ok") {
                    document.location.replace('/Mes-commandes/Modifier');
                } else if (res.retour_validation == "non") {
                    document.location.reload();
                }
            }
        });
    }

    $(document).ready(function() {

        $('.tst').on('click', function() {

            $.post({
                url: '/panel/Mes-commandes/mes-commandes-pagination-ajax.php',
                type: 'POST',
                data: {
                    page: $(this).attr('data-id')
                },
                success: function(res) {
                    location.href = "";
                }
            });
        });

        $('#before').on('click', function() {
            page = <?= $_SESSION['page'] - 1 ?>;
            if (page > 0) {
                $.post({
                    url: '/panel/Mes-commandes/mes-commandes-pagination-ajax.php',
                    type: 'POST',
                    data: {
                        page: page
                    },
                    success: function(res) {
                        location.href = "";
                    }
                });
            }

        });

        $('#after').on('click', function() {
            $.post({
                url: '/panel/Mes-commandes/mes-commandes-pagination-ajax.php',
                type: 'POST',
                data: {
                    page: $(this).attr('data-id')
                },
                success: function(res) {
                    location.href = "";
                }
            });
        });



        $(document).on("click", "#annuler_commande", function() {

            var idd = $(this).data('id')

            $.post({
                url: '/panel/Mes-commandes/mes-commandes-annuler-ajax.php',
                type: 'POST',
                data: {
                    id: idd
                },
                success: function(res) {
                    res = JSON.parse(res);
                    if (res.retour_validation == "ok") {
                        popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                        document.location.reload();
                    } else {
                        popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                    }
                }
            });

        });

        $('#Tableau_a').DataTable({
            responsive: true,
            stateSave: true,
            "order": [],
            "searching": false,
            buttons: [{
                extend: 'colvis',
                text: "Colonnes visibles",
            }],
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
            $(this).html('<input type="text" class="form-control" placeholder="' + title + '" style="width:100%; font-weight: normal;"/>');
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



        $(document).on("click", "#annuler_commande", function() {
            var idd = $(this).data('id');
            $.post({
                url: '/panel/Mes-commandes/mes-commandes-annuler-ajax.php',
                type: 'POST',
                data: {
                    id: idd
                },
                success: function(res) {
                    res = JSON.parse(res);
                    if (res.retour_validation == "ok") {
                        popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                        document.location.reload();
                    } else {
                        popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                    }
                }
            });
        });


    });
</script>

<div class="modal" id="commandDetail"></div>

<?php

if (empty($_SESSION['page'])) {
    $_SESSION['page'] = 1;
}

$sql_select = $bdd->prepare('SELECT * FROM membres_commandes WHERE id=?');
$sql_select->execute(array(
    intval($id)
));
$commande = $sql_select->fetch();
$sql_select->closeCursor();

$statut_2 = $commande['statut_2'];

$req_select = $bdd->prepare("SELECT * FROM configurations_suivi_achat Where id=?");
$req_select->execute(array($commande['statut_2']));
$ligne_select2 = $req_select->fetch();
$req_select->closeCursor();

$req_select = $bdd->prepare("SELECT * FROM configurations_suivi_expedition Where id=?");
$req_select->execute(array($commande['statut_expedition']));
$ligne_select22 = $req_select->fetch();
$req_select->closeCursor();

$req_boucle = $bdd->prepare("SELECT count(*) as c FROM membres_commandes WHERE type=2 AND statut>3 AND user_id=? ORDER BY id DESC");
$req_boucle->execute(array($id_oo));
$boucle = $req_boucle->fetch();
$req_boucle->closeCursor();

$c = $boucle['c'];

$salt = 5;

$pag = ceil($c / $salt);

$aide = ($_SESSION['page'] - 1) * $salt;





$req_boucle = $bdd->prepare("SELECT * FROM membres_commandes WHERE type=2 AND statut>3 AND user_id=? ORDER BY id DESC limit $aide,5");
$req_boucle->execute(array($id_oo));
$boucle = $req_boucle->fetchAll();
$req_boucle->closeCursor();

for ($i = 0; $i < count($boucle); $i++) {
    if ($boucle[$i]['statut'] == "4" || $boucle[$i]['statut'] == "5" || $boucle[$i]['statut'] == "6") {
        $count += 1;
    }
}

if ($count == 0) { ?>
    <div class="card" style="width:100%">
        <div class="card-body" style="padding:1rem">
            <div class="row" style="justify-content:center;flex-direction:column;align-content:center">
                <img src="../../images/empty.jpeg" style="max-width:30vh;align-self:center" />
                <span style="text-align:center">Aucune commande</span>
            </div>
        </div>
    </div>


<?php } else { ?>
    <div>
        <?php
        for ($i = 0; $i < count($boucle); $i++) {
            $id = $boucle[$i]['id'];
            $url = $boucle[$i]['url'];
            $category = $boucle[$i]['categorie'];
            $quantity = $boucle[$i]['quantite'];
            $comment = $boucle[$i]['comment'];
            $statut = $boucle[$i]['statut'];
            $price = $boucle[$i]['prix_total'];
            $statut_2 = $boucle[$i]['statut_2'];
            $message = $boucle[$i]['message'];
            $created_at = $boucle[$i]['created_at'];



            $req_select = $bdd->prepare("SELECT * FROM configurations_suivi_achat Where id=?");
            $req_select->execute(array($statut_2));
            $ligne_select2 = $req_select->fetch();
            $req_select->closeCursor();

            $req_select = $bdd->prepare("SELECT * FROM configurations_messages_predefini Where id=?");
            $req_select->execute(array($message));
            $ligne_message = $req_select->fetch();
            $req_select->closeCursor();



            if ($statut == "4" || $statut == "5" || $statut == "6") { ?>
                <div class="card" style="border: 1px black solid; width:100%; margin-bottom:1rem">
                    <div class="card-body" style="padding:1rem">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-md-6 text-left">

                                    <div>
                                        <p><i class="uk-icon-info-circle"></i> <?= $ligne_select2['nom_suivi'] ?></p>
                                    </div>
                                    <hr>
                                    <div>
                                        Numéro de commande : <?= $id; ?>
                                    </div>
                                </div>

                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6 text-left">
                                    Passage de commande : <?= date('d/m/Y G:i:s', $created_at); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 text-left">
                                    Destinataire : <?= $prenom_oo ?> <?= $nom_oo; ?>
                                </div>
                                <div class="col-6 text-right">
                                    <button class="btn btn-primary btn-predeterminate" onclick="handleShow(<?= $id; ?>)">Visualiser ma commande</button>
                                    <button class="btn btn-primary btn-visualiser" onclick="handleShow(<?= $id; ?>)">Visualiser </button>


                                    <button style="border-radius: 5px;" id="annuler_commande" class="btn btn-danger btn-predeterminate" data-id="<?= $id; ?>" <?= $statut_2 == "3" || $cstatut_2 == "2" ? "disabled" : "" ?>>
                                        <?= $statut_2 == "3" ? "Commande annulée" : "Annuler commande" ?>
                                    </button>
                                    <button style="border-radius: 5px;" id="annuler_commande" class="btn btn-danger btn-visualiser-annuler" data-id="<?= $id; ?>" <?= $statut_2 == "3" || $cstatut_2 == "2" ? "disabled" : "" ?>>
                                        <?= $statut_2 == "3" ? "Annulée" : "Annuler" ?>
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 text-left">

                                </div>

                            </div>
                            <div class="row mt-3">
                                <div class="col-6 text-left">
                                    <?php
                                    $ii = 0;
                                    $art_boucle = $bdd->prepare("SELECT * FROM membres_commandes_details WHERE commande_id=? ORDER BY id ASC");
                                    $art_boucle->execute(array($id));

                                    while ($article = $art_boucle->fetch()) {
                                        $ii++;
                                    ?>
                                        <div><?= $article['quantite'] ?> x <a href="<?= $article['url']; ?>" target="_blank" style="color:#FF9900">Article <?= $ii ?></a></div>
                                    <?php }
                                    $art_boucle->closeCursor();
                                    ?>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 text-left">
                                    Commentaire :
                                    <div>
                                        <?= $comment; ?>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row mt-3">
                                <div class="col-12 text-left">
                                    Message : <?= $ligne_message['message'] ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            <?php } ?>

            <!--
        <table id='Tableau_a' class="display nowrap" style="text-align: center; width: 100%">
            <thead>
                <tr>
                    <th scope="col" style="text-align: center;">NUMÉRO DE COMMANDE</th>
                    <th style="text-align: center;" >PRIX</th>
                    <th style="text-align: center;" >STATUT</th>
                    <th style="text-align: center;" >GESTION</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th style="text-align: center;" >NUMÉRO DE COMMANDE</th>
                    <th style="text-align: center;" >PRIX</th>
                    <th style="text-align: center;" >STATUT</th>
                    <th style="text-align: center;" >GESTION</th>
                </tr>
            </tfoot>

            <tbody>
                <?php
                ///////////////////////////////SELECT BOUCLE
                $req_boucle = $bdd->prepare("SELECT * FROM membres_commandes WHERE type=2 AND user_id=? ORDER BY id ASC");
                $req_boucle->execute(array($id_oo));
                while ($ligne_boucle = $req_boucle->fetch()) {
                    $id = $ligne_boucle['id'];
                    $url = $ligne_boucle['url'];
                    $category = $ligne_boucle['categorie'];
                    $quantity = $ligne_boucle['quantite'];
                    $comment = $ligne_boucle['comment'];
                    $statut = $ligne_boucle['statut'];
                    $price = $ligne_boucle['prix_total'];
                    $statut_2 = $ligne_boucle['statut_2'];
                    if ($statut == "4" || $statut == "5" || $statut == "6") {
                ?>
                            <tr>
                                <td style="text-align: center;">
                                    <?= $id ?>
                                </td>
                                <td style="text-align: center;">
                                    <?= $price ?> F CFA
                                </td>
                                <td>
                                    <?php if ($statut == 4) { ?>
                                        <span class="badge badge-success">Payé</span>
                                    <?php } else if ($statut == 5) { ?>
                                        <span class="badge badge-danger">En attente de régulation</span>
                                    <?php } else if ($statut == 6) { ?>
                                        <span class="badge badge-success">Terminé</span>
                                    <?php } ?>
                                </td>
                                <td style="text-align: center;">
                                    <?php
                                    //Paiement Régulation
                                    if ($statut == 5) {
                                        $sql_select = $bdd->prepare("SELECT * FROM membres_regulation WHERE id_membre=? AND id_commande=?");
                                        $sql_select->execute(array(htmlspecialchars($id_oo), htmlspecialchars($id)));
                                        $regulation = $sql_select->fetch();
                                        $sql_select->closeCursor();
                                    ?>
                                        <button class="btn-details" onclick={handleRegul(<?= $id; ?>)} data-id=<?= $id ?>><span data-id=<?= $id ?> class="uk-icon-shopping-cart"></span></button>
                                    <?php } ?>

                                    Details commande
                                    <button class="btn-details" onclick={handleShow(<?= $id; ?>)} data-id=<?= $id ?>><span data-id=<?= $id ?> class="uk-icon-info"></span></button>
                                    
                                    <?php if ($statut == 3) {
                                        //Modification commande
                                    ?>
                                        <button class="btn-details" onclick={handleUpdate(<?= $id; ?>)}><span class="uk-icon-file-text"></span></button>
                                    <?php } ?>

                                    Supprimer commande
                                    <button class="btn-details" id="delete" href="#" onclick={handleClick(<?= $id; ?>)} data-id=<?= $id ?>><span class='uk-icon-trash-o' ></span></button>
                                    
                                </td>
                            </tr>
                    <?php }
                }
                $req_boucle->closeCursor();
                    ?>
            </tbody>
        </table>
        -->
        <?php }



        ?>
        <div class="pagination">
            <a href="#" id="before" onclick="return false;">&laquo;</a>
            <?php for ($i = 1; $i <= $pag; $i++) { ?>
                <a href="#" data-id="<?= $i ?>" onclick="return false;" class="tst <?php if ($_SESSION['page'] == $i) {
                                                                                        echo "active";
                                                                                    } ?>"><?= $i ?></a>
            <?php }

            ?>
            <a href="#" id="after" onclick="return false;" data-id="<?php if ($_SESSION['page'] == $pag) {
                                                                        echo '1';
                                                                    } else {
                                                                        echo $_SESSION['page'] + 1;
                                                                    } ?>">&raquo;</a>
        </div>
    </div>


<?php
}
$req_boucle->closeCursor();

ob_end_flush();

?>