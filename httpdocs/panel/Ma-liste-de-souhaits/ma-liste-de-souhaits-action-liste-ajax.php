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

    .card-equal {
        display: flex;
        flex-direction: column;
        min-height: 300px;
    }


    @media (max-width: 767px) {
        .card-equal {
            min-height: 250px;
        }
    }
</style>
<div style='clear: both;'></div>


<script>
    // function handleClick(id){
    //     datas = {
    //         id: id
    //     }

    //     $.post({
    //         url: '/panel/Ma-liste-de-souhaits/ma-liste-de-souhaits-action-supprimer-ajax.php',
    //         type: 'POST',
    //         data: datas,
    //         success: function(res) {
    //             res = JSON.parse(res);

    //             if (res.retour_validation == "ok") {
    //                 popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
    //                 setTimeout(() => {
    //                     document.location.reload();
    //                 }, 1500)
    //             }else{
    //                 popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
    //             }
    //         }
    //     })
    // }

    function handleShow(id) {
        datas = {
            id: id
        }
        $.post({
            url: '/panel/Ma-liste-de-souhaits/ma-liste-de-souhaits-action-details-ajax.php',
            type: 'POST',
            data: datas,
            dataType: "html",
            success: function(res) {
                $("#listeDetail").html(res);
                $("#listeDetail").modal('show');
            }
        });
    }

    function handleUpdate(id) {
        datas = {
            id: id
        }
        $.post({
            url: '/panel/Ma-liste-de-souhaits/ma-liste-de-souhaits-modifier-modal-ajax.php',
            type: 'POST',
            data: datas,
            dataType: "html",
            success: function(res) {
                $("#listeDetail").html(res);
                $("#listeDetail").modal('show');
            }
        });
    }


    function listeCart() {
        $.post({
            url: '/panel/Passage-de-commande/passage-de-commande-action-liste-cart-ajax.php',
            type: 'POST',
            dataType: "html",
            success: function(res) {
                $("#cardNav").html(res);
                $("#mobileCartNav").html(res);
            }
        });
    }


    function handleAdd(id) {
        $.post({
            url: '/panel/Mes-produits/Mes-produits-action-add-ajax.php',
            type: 'POST',
            data: {
                id: id
            },
            success: function(res) {
                res = JSON.parse(res);
          
                if (res.retour_validation == "ok") {
                    popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                    listeCart();

                } else {
                    popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                }
            }
        });
    }


    $(document).ready(function() {


        $('.tst').on('click', function() {

            $.post({
                url: '/panel/Ma-liste-de-souhaits/ma-liste-de-souhaits-pagination-ajax.php',
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
            page = <?= $_SESSION['page_souhaits'] - 1 ?>;
            if (page > 0) {
                $.post({
                    url: '/panel/Ma-liste-de-souhaits/ma-liste-de-souhaits-pagination-ajax.php',
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
                url: '/panel/Ma-liste-de-souhaits/ma-liste-de-souhaits-pagination-ajax.php',
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
<div class="modal" id="listeDetail"></div>

<?php

if (empty($_SESSION['page_souhaits'])) {
    $_SESSION['page_souhaits'] = 1;
}

$req_boucle = $bdd->prepare("SELECT count(*) as c FROM membres_souhait WHERE user_id=?");
$req_boucle->execute(array($id_oo));
$boucle = $req_boucle->fetch();
$req_boucle->closeCursor();

$c = $boucle['c'];

$salt = 5;

$pag = ceil($c / $salt);

$aide = ($_SESSION['page_souhaits'] - 1) * $salt;

$req_boucle = $bdd->prepare("SELECT * FROM membres_souhait WHERE user_id=? ORDER BY id DESC limit $aide, $salt");
$req_boucle->execute(array($id_oo));
$boucle = $req_boucle->fetchAll();
$req_boucle->closeCursor();

if (count($boucle) == 0) { ?>
    <div class="card" style="width:100%">
        <div class="card-body" style="padding:1rem; border: 2px solid #f0f0f0;">
            <div class="row" style="justify-content:center;flex-direction:column;align-content:center">
                <img src="../../images/empty.jpeg" style="max-width:30vh;align-self:center" />
                <span style="text-align:center">Aucune demande n'a été passée</span>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="row">
        <?php
        foreach ($boucle as $ligne_boucle) {
            $id = $ligne_boucle['id'];
            $title = $ligne_boucle['titre'];
            $statut = $ligne_boucle['statut'];
            $created = date('d/m/Y G:i:s', $ligne_boucle['created_at']);

            $req_details = $bdd->prepare("
                    SELECT 
                        ms.id,
                        ms.titre,
                        ms.statut,
                        ms.user_id,
                        ms.*,
                        msd.id as id_detail
                    FROM 
                        membres_souhait ms
                    INNER JOIN 
                        membres_souhait_details msd
                    ON 
                        ms.id = msd.liste_id 
                    WHERE 
                        ms.statut = 4 
                        AND ms.user_id = ? 
                        AND ms.id = ?
                ");
            $req_details->execute(array($id_oo, $id));
            $details = $req_details->fetch();
            $req_details->closeCursor();

            $id_detail = $details ? $details['id_detail'] : null;
        ?>
            <div class="col-md-12 align-items-stretch">
                <div class="card card-equal" style="border: 1px solid black; margin-bottom: 1rem; padding: 1rem;">
                    <div class="card-body d-flex flex-column">
                        <div style="font-weight: bold; color: #333;">
                            <?php if ($statut == 1) { ?>
                                <i class="uk-icon-info-circle"></i> Commande en cours de traitement
                            <?php } elseif ($statut == 2) { ?>
                                <i class="uk-icon-warning"></i> Commande à payer
                            <?php } elseif ($statut == 3) { ?>
                                <i class="uk-icon-times-circle"></i> Commande refusée
                            <?php } elseif ($statut == 4) { ?>
                                <i class="uk-icon-check-circle"></i> Commande traitée
                            <?php } ?>
                        </div>
                        <hr>
                        <p><strong>Numéro de commande : </strong><?= $id ?></p>
                        <p><strong>Passage de commande : </strong><?= $created ?></p>
                        <p><strong>Titre : </strong><?= $title ?></p>

                        <p><strong>Statut : </strong>
                            <?php if ($statut == 1) { ?>
                        <div class="badge badge-primary p-2 rounded">En cours de traitement</div>
                    <?php } elseif ($statut == 2) { ?>
                        <span class="badge badge-warning p-2 rounded">À payer</span>
                    <?php } elseif ($statut == 3) { ?>
                        <span class="badge badge-danger p-2 rounded">Refusée</span>
                    <?php } elseif ($statut == 4) { ?>
                        <span class="badge badge-success p-2 rounded">Traité</span>
                    <?php } ?>
                    </p>

                    <div class="mt-auto text-right">
                        <?php if ($statut == 2) { ?>
                            <a class='thissupprimer' data-id=<?= $id ?> href='?page=Demandes-de-souhaits&action=Supprimer&idaction=<?= $id ?>' onclick='return false;'><span class='uk-icon-times mr-2'></span></a>
                        <?php } ?>

                        <?php if ($statut == 4) { ?>
                            <a href="#" onclick="handleAdd(<?= $id_detail; ?>)" class="btn-details lineRef" style="position:relative;font-size: 20px;color: green!important;">
                                <span class="uk-icon-shopping-cart"></span>
                                <span class="uk-icon-plus" style="/* position:absolute ;*/top:0;font-size:10px"></span>
                            </a>
                        <?php } ?>

                        <button data-id=<?= $id ?> class="btn btn-info" title="Plus de détails" onclick={handleShow(<?= $id ?>)}><span class='uk-icon-info'></span></button>

                        <?php if ($statut == 1) { ?>
                            <button class="btn btn-warning" title="Modifier" onclick={handleUpdate(<?= $id; ?>)}><span class="uk-icon-file-text"></span></button>
                        <?php } ?>
                    </div>


                    <?php if ($statut == 4) { ?>
                        <div class="row mt-3">
                            <div class="col-12 text-left">

                                Message : les articles on été retrouvé
                            </div>

                        </div>
                    <?php } ?>

                    </div>



                </div>
            </div>
        <?php } ?>
    </div>

    <div class="pagination">
        <a href="#" id="before" onclick="return false;">&laquo;</a>
        <?php for ($i = 1; $i <= $pag; $i++) { ?>
            <a href="#" data-id="<?= $i ?>" onclick="return false;" class="tst <?php if ($_SESSION['page_souhaits'] == $i) {
                                                                                    echo "active";
                                                                                } ?>"><?= $i ?></a>
        <?php } ?>
        <a href="#" id="after" onclick="return false;" data-id="<?php if ($_SESSION['page_souhaits'] == $pag) {
                                                                    echo '1';
                                                                } else {
                                                                    echo $_SESSION['page_souhaits'] + 1;
                                                                } ?>">&raquo;</a>
    </div>

<?php } ?>

<?php
ob_end_flush();
?>