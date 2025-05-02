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
    .visualizer-mobile {
        display: none !important;
        width: 100%;
    }

    @media (max-width: 768px) {
        .visualizer-mobile {
            display: flex !important;
            width: 100%;
        }

        .visualizer-destop {
            display: none !important;
            width: 100%;
        }
    }

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
</style>
<div style='clear: both;'></div>


<script>
    function handleClick(id) {
        datas = {
            id: id
        }

        $.post({
            url: '/panel/Mes-colis/mes-colis-action-supprimer-ajax.php',
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
            url: '/panel/Mes-colis/mes-colis-action-details-ajax.php',
            type: 'POST',
            data: datas,
            dataType: "html",
            success: function(res) {
                $("#colisDetail").html(res);
                $("#colisDetail").modal('show');
                $('body').addClass('overflow-hidden'); // Désactive le défilement dans le corps
            }
        });
    }

    // Écoute l'événement de fermeture modale et restaure le scroll dans le corps
    $('#colisDetail').on('hidden.bs.modal', function() {
        $('body').removeClass('overflow-hidden'); // Active le défilement dans le corps lorsque le mode est verrouillé
    });

    function handleRegul(id) {
        datas = {
            id: id
        }
        $.post({
            url: '/panel/Mes-colis/mes-colis-action-regulation-ajax.php',
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
            url: '/panel/Mes-colis/mes-colis-action-redirect-ajax.php',
            type: 'POST',
            data: datas,
            success: function(res) {
                res = JSON.parse(res);
                if (res.retour_validation == "ok") {
                    document.location.replace('/Mes-colis/Modifier');
                } else if (res.retour_validation == "non") {
                    document.location.reload();
                }
            }
        });
    }

    function handleDelete(id) {
        datas = {
            id: id
        }

        $.post({
            url: '/panel/Mes-colis/mes-colis-action-supprimer-ajax.php',
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

    $(document).ready(function() {

        $('.tst').on('click', function() {

            $.post({
                url: '/panel/Mes-colis/mes-colis-pagination-ajax.php',
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
            page = <?= $_SESSION['page_colis'] - 1 ?>;
            if (page > 0) {
                $.post({
                    url: '/panel/Mes-colis/mes-colis-pagination-ajax.php',
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
                url: '/panel/Mes-colis/mes-colis-pagination-ajax.php',
                type: 'POST',
                data: {
                    page: $(this).attr('data-id')
                },
                success: function(res) {
                    location.href = "";
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

    });
</script>
<div class="modal" id="colisDetail"></div>
<?php

if (empty($_SESSION['page_colis'])) {
    $_SESSION['page_colis'] = 1;
}
$req_boucle = $bdd->prepare("SELECT count(*) as c FROM membres_colis WHERE user_id=? AND statut!='1' ORDER BY id ASC");
$req_boucle->execute(array($id_oo));
$boucle = $req_boucle->fetch();
$req_boucle->closeCursor();

$c = $boucle['c'];

$salt = 5;

$pag = ceil($c / $salt);

$aide = ($_SESSION['page_colis'] - 1) * $salt;

$req_boucle = $bdd->prepare("SELECT * FROM membres_colis WHERE user_id=? AND statut!='1' ORDER BY id DESC limit $aide,5");
$req_boucle->execute(array($id_oo));
$boucle = $req_boucle->fetchAll();
$req_boucle->closeCursor();

if (count($boucle) == 0) { ?>
    <div class="card" style="width:100%">
        <div class="card-body" style="padding:1rem">
            <div class="row" style="justify-content:center;flex-direction:column;align-content:center">
                <img src="../../images/empty.jpeg" style="max-width:30vh;align-self:center" />
                <span style="text-align:center">Aucun colis</span>
            </div>
        </div>
    </div>
<?php } else {
?>

    <div class="">
        <?php


        $req_boucle = $bdd->prepare("SELECT * FROM membres_colis WHERE user_id=? AND statut!='1' ORDER BY id DESC limit $aide,5");
        $req_boucle->execute(array($id_oo));
        $colis_list = $req_boucle->fetchAll();
        $req_boucle->closeCursor();

        $created_at = $colis_list['created_at'];





        foreach ($colis_list as $colis) {

            $req_select = $bdd->prepare("SELECT * FROM configurations_suivi_achat Where id=?");
            $req_select->execute(array($colis['statut']));
            $ligne_select2 = $req_select->fetch();
            $req_select->closeCursor();


            $req_select = $bdd->prepare("SELECT * FROM configurations_messages_predefini Where id=?");
            $req_select->execute(array($colis['message']));
            $ligne_message = $req_select->fetch();
            $req_select->closeCursor();


            $sql_boucle = $bdd->prepare('SELECT * FROM membres_colis_details WHERE colis_id=?');
            $sql_boucle->execute(array($colis['id']));
            $articles = $sql_boucle->fetchAll();
            $sql_boucle->closeCursor();





        ?>


            <div class="card mb-3" style="border: 1px solid black;">
                <div class="card-body container-fluid">
                    <div class="row">

                        <div class="col-12 col-md-8">
                            <div>
                                <p><i class="uk-icon-info-circle"></i> Colis n°<?= $colis['id'] ?></p>
                            </div>

                            <div>
                                Statut :
                                <span class="badge badge-primary"><?= $ligne_select2["nom_suivi"] ?></span>
                            </div>

                            <div class="mt-3">
                                <strong>Nombre d'articles :</strong> <?= count($articles) ?>
                            </div>
                            <div class="mt-3">
                                <strong>Passsage de colis :</strong> <?= date('d/m/Y G:i:s', $colis['created_at']); ?>
                            </div>


                            <div class="mt-3">
                                <strong>Prix total du colis :</strong>
                                <span name="price"><?= round($colis['prix_total'] * 0.00152449, 2) ?></span>€
                                (<span><?= number_format($colis['prix_total'], 0, '', ' ') ?></span> F CFA)
                            </div>

                        </div>

                        <div class="col-12 col-md-4 d-flex justify-content-end">


                            <div class="d-flex align-items-center visualizer-destop">
                                <button class="btn btn-primary" onclick="handleShow(<?= $colis['id']; ?>)">Visualiser mon coli</button>
                            </div>

                            <div class="d-flex align-items-center visualizer-mobile">
                                <button class="btn btn-primary" onclick="handleShow(<?= $colis['id']; ?>)">Visualiser</button>
                            </div>


                            <div class="d-flex align-items-center ml-2">

                                <button style="border-radius: 5px;" id="annuler_commande" class="btn btn-danger btn-predeterminate" data-id="<?= $colis['id']; ?>" <?= $statut_2 == "3" || $cstatut_2 == "2" ? "disabled" : "" ?> onclick="handleDelete(<?= $colis['id']; ?>)">
                                    <?= $statut_2 == "3" ? "Coli annulée" : "Annuler" ?>
                                </button>

                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row mt-3">
                        <div class="col-12">
                            <strong>Message :</strong>
                            <div>
                                <?= htmlspecialchars($ligne_message['message']); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php
        }
        $req_boucle->closeCursor();
        ?>
    </div>
    <div class="pagination">
        <a href="#" id="before" onclick="return false;">&laquo;</a>
        <?php for ($i = 1; $i <= $pag; $i++) { ?>
            <a href="#" data-id="<?= $i ?>" onclick="return false;" class="tst <?php if ($_SESSION['page_colis'] == $i) {
                                                                                    echo "active";
                                                                                } ?>"><?= $i ?></a>
        <?php }

        ?>
        <a href="#" id="after" onclick="return false;" data-id="<?php if ($_SESSION['page_colis'] == $pag) {
                                                                    echo '1';
                                                                } else {
                                                                    echo $_SESSION['page_colis'] + 1;
                                                                } ?>">&raquo;</a>
    </div>
<?php
}
?>






<?php ob_end_flush(); ?>