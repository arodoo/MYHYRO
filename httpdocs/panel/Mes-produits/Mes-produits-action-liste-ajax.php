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
        border: none;
    }

    .btn-primary-produits {
        background-color: #f8f9fa;
        border-radius: 4px;
    }

    .btn-primary-produits:hover {
        background-color: #f8f8f9;
        ;
    }
</style>
<div style='clear: both;'></div>


<script>
    $(document).ready(function() {
        $('.tst').on('click', function() {

            $.post({
                url: '/panel/Mes-produits/Mes-produits-pagination-ajax.php',
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
            page = <?= $_SESSION['page_produits'] - 1 ?>;
            if (page > 0) {
                $.post({
                    url: '/panel/Mes-produits/Mes-produits-pagination-ajax.php',
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
                url: '/panel/Mes-produits/Mes-produits-pagination-ajax.php',
                type: 'POST',
                data: {
                    page: $(this).attr('data-id')
                },
                success: function(res) {
                    location.href = "";
                }
            });
        });
    });

    function listeCart() {
        $.post({
            url: '/panel/Passage-de-commande/passage-de-commande-action-liste-cart-ajax.php',
            type: 'POST',
            dataType: "html",
            success: function(res) {
                $("#cardNav").html(res);
            }
        });
    }

    function handleShow(id) {
        datas = {
            id: id
        }
        $.post({
            url: '/panel/Mes-produits/Mes-produits-action-details-ajax.php',
            type: 'POST',
            data: datas,
            dataType: "html",
            success: function(res) {
                $("#produitDetail").html(res);
                $("#produitDetail").modal('show');
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
        let prices = document.getElementsByName('price');
        for (let i = 0; i < prices.length; i++) {
            prices[i].innerHTML = parseInt(prices[i].innerHTML).toLocaleString();
        }
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
<div class="modal" id="produitDetail"></div>

<?php
if (empty($_SESSION['page_produits'])) {
    $_SESSION['page_produits'] = 1;
}


$req_boucle = $bdd->prepare("SELECT count(*) as c FROM membres_souhait WHERE user_id=?");
$req_boucle->execute(array($id_oo));
$boucle = $req_boucle->fetch();
$req_boucle->closeCursor();

$c = $boucle['c'];
$salt = 10;


$pag = ceil($c / $salt);


$aide = ($_SESSION['page_produits'] - 1) * $salt;


$req_boucle = $bdd->prepare("SELECT * FROM membres_souhait WHERE user_id=? ORDER BY id DESC LIMIT $aide, $salt");
$req_boucle->execute(array($id_oo));
$boucle = $req_boucle->fetchAll();
$req_boucle->closeCursor();

$articles = [];


foreach ($boucle as $item) {
    $slc_req = $bdd->prepare("SELECT * FROM membres_souhait_details WHERE liste_id=?");
    $slc_req->execute(array($item['id']));
    $articles_bcl = $slc_req->fetchAll();
    $slc_req->closeCursor();


    foreach ($articles_bcl as $article) {
        array_push($articles, $article);
    }
}

if (count($articles) == 0) { ?>
    <div class="card" style="width:100%">
        <div class="card-body" style="padding:1rem">
            <div class="row" style="justify-content:center;flex-direction:column;align-content:center">
                <img src="../../images/empty.jpeg" style="max-width:30vh;align-self:center" />
                <span style="text-align:center">Aucun articles n'a été retrouvé</span>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="article-cards">
        <?php

        $req_boucle = $bdd->prepare("SELECT * FROM membres_souhait WHERE user_id=? ORDER BY id DESC LIMIT $aide, $salt");
        $req_boucle->execute(array($id_oo));
        $boucle = $req_boucle->fetchAll();
        $req_boucle->closeCursor();

        foreach ($articles as $article) {
            $id = $article['id'];
            $name = $article['nom'];
            $price = $article['prix'];
            $url = $article['url'];
            $type = $article['type'];



        ?><div class="card mb-3" style="border: 1px solid black;">
                <div class="card-body container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div>
                                <p><strong>ID:</strong> <?= $id; ?></p>
                            </div>

                            <div>
                                <strong>Nom:</strong>
                                <a href="<?= $url; ?>" target="_blank"><?= $name; ?></a>
                            </div>

                            <div>
                                <strong>Type:</strong>
                                <?php
                                if ($type == 1) {
                                    echo "Article exact";
                                } else {
                                    echo "Article similaire";
                                }
                                ?>
                            </div>

                            <div class="mt-3">
                                <strong>Prix:</strong>
                                <span name="price"><?= $price; ?></span> F CFA
                            </div>
                        </div>


                        <div class="d-flex justify-content-end align-items-center mt-3" style="width: 100%;">
                            <div style="margin-right: 15px;" class="btn btn-primary-produits">
                                <a href="#" onclick="handleAdd(<?= $id; ?>)" class="btn-details lineRef" style="position:relative;font-size: 20px;color: green!important;">
                                    <span class="uk-icon-shopping-cart"></span>
                                    <span class="uk-icon-plus" style="/* position:absolute ;*/top:0;font-size:10px"></span>
                                </a>
                            </div>

                            <div style="margin-right: 15px;">
                                <button data-id="<?= $id; ?>" class="btn btn-info" title="Plus de détails" onclick="handleShow(<?= $id; ?>)">
                                    <span class="uk-icon-info"></span>
                                </button>
                            </div>

                            <div>
                                <button id="delete" title="Supprimer" class="btn btn-danger" onclick="handleClick(<?= $id; ?>)" data-id="<?= $id; ?>">
                                    <span class="uk-icon-trash-o" style="font-size: medium !important;"></span>
                                </button>
                            </div>
                        </div>

                      


                    </div>
                </div>
            </div>

        <?php } ?>
    </div>
    <!-- Pagination Section -->
    <div class="pagination" style="text-align: center; margin-top: 1rem;">
        <a href="#" id="before" onclick="return false;">&laquo;</a>
        <?php for ($i = 1; $i <= $pag; $i++) { ?>
            <a href="#" data-id="<?= $i ?>" onclick="return false;" class="tst <?php if ($_SESSION['page_produits'] == $i) {
                                                                                    echo "active";
                                                                                } ?>">
                <?= $i ?>
            </a>
        <?php } ?>
        <a href="#" id="after" onclick="return false;" data-id="<?php if ($_SESSION['page_produits'] == $pag) {
                                                                    echo '1';
                                                                } else {
                                                                    echo $_SESSION['page_produits'] + 1;
                                                                } ?>">&raquo;</a>
    </div>
<?php }
ob_end_flush();
?>