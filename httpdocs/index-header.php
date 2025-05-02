<?php
ob_start();
session_start();

$sql_select = $bdd->prepare("SELECT Count(*) as nbr_pan FROM membres_panier_details WHERE id_membre=?");
$sql_select->execute(array(
    $id_oo
));
$panier_nbr = $sql_select->fetch();
$sql_select->closeCursor();

$sql_select = $bdd->prepare("SELECT SUM(quantite) as nbr_pan2 FROM membres_panier_details WHERE id_membre=?");
$sql_select->execute(array(
    $id_oo
));
$panier_nbr2 = $sql_select->fetch();
$sql_select->closeCursor();

if (empty($panier_nbr2['nbr_pan2'])) {
    $panier_nbr2['nbr_pan2'] = 0;
}

$sql_select = $bdd->prepare("SELECT Titre_panier FROM membres_panier WHERE id_membre=?");
$sql_select->execute(array(
    $id_oo
));
$ligne_selectpa = $sql_select->fetch();
$sql_select->closeCursor();

?>
<style>
    .site {
        min-height: 0 !important;
    }

    .mobile {
        display: flex;
        margin-left: auto;
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    /*     $(document).ready(function() {
        $("#searchButton").click(function() {
            let searchText = $("#searchInput").val().trim();

            if (searchText !== "") {
                $.ajax({
                    url: "/pages/Boutique/Boutique-search.php",
                    type: "POST",
                    data: {
                        search: searchText
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            console.log("Productos encontrados:", response.message);
                            // Redireccionar al usuario
                            location.href = response.redirect;
                         
                        } else if (response.status === "no_results") {
                            console.warn("Sin resultados:", response.message);
                        } else {
                            console.error("Error:", response.message);
                        }
                    },

                    error: function(xhr, status, error) {
                        console.error("Error AJAX:", error);
                    }
                });
            } else {
                alert("Veuillez entrer un terme de recherche !");
            }
        });
    }); */

    $(document).ready(function() {
        $("#mobileSearchButton").click(function(event) {
            event.preventDefault(); 

            let searchText = $("#mobileSearchInput").val().trim();

            if (searchText !== "") {
              // Vérifiez si la valeur saisie est une URL (par exemple, elle commence par http:// ou https://)
                var urlPattern = /^(https?:\/\/)/i;
                if (urlPattern.test(searchText)) {
                    
                    $.post({
                        url: '/function/redirect-command.php',
                        type: 'POST',
                        data: {
                            url: searchText
                        },
                        success: function(res) {
                          
                            res = JSON.parse(res);

                            if (res.retour_validation === "ok") {
                               
                                setTimeout(() => {
                                    document.location.href = res.retour_lien;
                                }, 500);
                            } else {
                              
                                popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error en la petición AJAX:", error);
                        }
                    });
                } else {
                    // S'il ne s'agit pas d'une URL, procédez comme d'habitude :
                    let form = $('<form>', {
                        action: "/Boutique",
                        method: 'POST'
                    });

                    form.append($('<input>', {
                        type: 'text',
                        name: 'search',
                        value: searchText,
                        readonly: true,
                        style: 'border: none; background-color: transparent; font-size: 14px; color: black;'
                    }));

                    $('body').append(form);
                    form.submit();
                }
            } else {
                alert("Veuillez entrer un terme de recherche !");
            }
        });
    });


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
    listeCart();

    function RecapitulatifPanier(i) {
        $.post({
            url: '/pages/paiements/Panier/Panier2-recapitulatif-ajax.php',
            type: 'POST',
            data: {},
            dataType: "html",
            success: function(res) {
                $("#panier_recap_prix").html(res);
                if (i == true) {
                    show();
                } else {
                    $('#show2').attr('class', 'show-less');
                    $('#show2').text('[-]');
                }
            }
        });

    }

    /* function listePanier() {
    $.post({
    url: '/panel/Passage-de-commande/passage-de-commande-action-liste-ajax.php',
    type: 'POST',
    dataType: "html",
    success: function(res) {
    $("#listePanier").html(res);
    }
    });
    } */

    function listePanier() {
        $.post({
            url: '/panel/Passage-de-commande/passage-de-commande-action-liste-ajax.php',
            type: 'POST',
            dataType: "html",
            success: function(res) {

                $("#listePanier").html(res);





                /* onChangePrice(); */
            },
            error: function(xhr, status, error) {

            }
        });

    }



    listePanier();


    function handlePaiement(e) {
        $.ajax({
            url: '/pages/paiements/Panier/Panier-action.php',
            dataType: "json",
            data: {
                id: e
            },
            success: function(res) {
                if (res.retour_validation == "ok") {
                    document.location.replace('/Paiement');
                } else if (res.retour_validation == "non") {
                    document.location.reload();
                }
            }
        })
    }
    $(document).ready(function() {

        let profil = document.getElementById('mobileCartNav');
        profil.addEventListener("mouseenter", function(event) {
            // on met l'accent sur la cible de mouseover
            profil.classList.add('indicator--open');
            profil.classList.add('indicator--display');
        }, false);
        profil.addEventListener("mouseleave", function(event) {
            // on met l'accent sur la cible de mouseover
            profil.classList.remove('indicator--open');
            profil.classList.remove('indicator--display');
        }, false);


        $(document).on('click', '#profilButton', function() {
            window.location.assign('/Gestion-de-votre-compte.html');
        });

        $(document).on('click', "#addList", function() {
            $('#demande_souhait').modal('show');
        })

        $(document).on('click', "#supp_pan", function() {
            $.post({
                url: '/panel/Passage-de-commande/passage-de-commande-action-supprimer-article-panier-ajax.php',
                type: 'POST',
                data: {
                    idaction: $(this).attr("data-id"),
                },
                dataType: "json",
                success: function(res) {
                    if (res.retour_validation == "ok") {
                        if (res.retour_lien == 0) {
                            location.href = '/Passage-de-commande';
                        }
                        listeCart();
                        RecapitulatifPanier();

                        listePanier();
                    } else {
                        popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                    }
                }
            });
        })
    });


    $(document).ready(function() {

        let profil = document.getElementById('profilButtonNavMobile');
        profil.addEventListener("mouseenter", function(event) {
            // on met l'accent sur la cible de mouseover
            profil.classList.add('indicator--open');
            profil.classList.add('indicator--display');
        }, false);
        profil.addEventListener("mouseleave", function(event) {
            // on met l'accent sur la cible de mouseover
            profil.classList.remove('indicator--open');
            profil.classList.remove('indicator--display');
        }, false);
    });

    function attachCartEvents() {
        if (window.innerWidth > 768) {
            let cart = document.getElementById('cardNav');
            if (cart) {
                cart.addEventListener("mouseenter", function(event) {
                    cart.classList.add('indicator--open');
                    cart.classList.add('indicator--display');
                }, false);

                cart.addEventListener("mouseleave", function(event) {
                    cart.classList.remove('indicator--open');
                    cart.classList.remove('indicator--display');
                }, false);
            }
        } else {
            let mobileCart = document.getElementById('mobileCartNav');
            if (mobileCart) {
                mobileCart.addEventListener("mouseenter", function(event) {
                    $("#cardNav .indicator__dropdown").appendTo("#mobileCartNav");
                    mobileCart.classList.add('indicator--open');
                    mobileCart.classList.add('indicator--display');
                }, false);

                mobileCart.addEventListener("mouseleave", function(event) {
                    mobileCart.classList.remove('indicator--open');
                    mobileCart.classList.remove('indicator--display');
                }, false);
            }
        }
    }

    attachCartEvents();

    $(window).resize(function() {
        attachCartEvents();
    });

    $(document).ready(function() {
        // $("#mobileCartNav").on('click', function(e) {
        // e.preventDefault();
        // window.location.assign('/Passage-de-commande');
        // });
    });
</script>




<!-- mobile site__header -->
<header class="site__header d-lg-none">
    <a href="#" style="font-size: 12px; height: 28px; background-color: #FFC107; color: #1C2833; padding: 5px 10px; font-weight: bold; display: inline-block; text-decoration: none; width: 100%; text-align: center;">
        <span style="margin-right: 5px;"></span> <strong style="color: white;">Livraison gratuite</strong> Hyro premium <strong style="color: white;">!</strong>
    </a>
    <div class="mobile-header mobile-header--sticky">
        <div class="mobile-header__panel">
            <div class="container">

                <div class="nav-panel__indicators" style="align-items: center;">

                    <div class="mobile-header__body" style="display: contents;">
                        <button class="mobile-header__menu-button">
                            <svg width="18px" height="14px">
                                <use xlink:href="/template2/black/images/sprite.svg#menu-18x14"></use>
                            </svg>
                        </button>
                        <a class="mobile-header__logo" href="/">
                            <!-- mobile-logo -->
                            <!-- <img src="/images/My-hyro-logo.jpg" alt="my-hyro"> -->

                            <img src="/images/logo footer.png" alt="my-hyro" style="width: 150px; height: auto;">
                            <!-- mobile-logo / end -->

                        </a>





                        <div class="mobile">

                            <div class="indicator__dropdown" style="max-height: 538px;">
                                <!-- .dropcart -->
                                <div class="dropcart dropcart--style--dropdown">
                                    <div class="dropcart__body">
                                        <?php

                                        if ($panier_nbr['nbr_pan'] > 0) { ?>
                                            <div class="dropcart__products-list">
                                                <?php
                                                ///////////////////////////////SELECT BOUCLE
                                                $req_boucle = $bdd->prepare("SELECT * FROM membres_panier_details WHERE id_membre=? ORDER BY id ASC");
                                                $req_boucle->execute(array($id_oo));
                                                $count = 0;
                                                while ($ligne_boucle = $req_boucle->fetch()) {
                                                    $count++;
                                                    $id_facture_panier_d = $ligne_boucle['id'];
                                                    $id_panier_facture_details_id = $ligne_boucle['id'];
                                                    $libelle = $ligne_boucle['libelle'];
                                                    $TVA = sprintf('%.2f', $ligne_boucle['TVA']);
                                                    $TVA_TAUX = $ligne_boucle['TVA_TAUX'];
                                                    $action_module_service_produit = $ligne_boucle['action_module_service_produit'];
                                                    $Duree_service = $ligne_boucle['Duree_service'];
                                                    $id_panier_SERVICE_PRODUIT = $ligne_boucle['id_panier_SERVICE_PRODUIT'];

                                                    $PU_HT = $ligne_boucle['PU_HT'];
                                                    $_SESSION['total_unitaire_HT'] = "$PU_HT";

                                                    $quantite = $ligne_boucle['quantite'];
                                                    $_SESSION['quantite'] = $quantite;

                                                    $PU_HT_total = (($PU_HT * $quantite) + $PU_HT_total);
                                                    $PU_HT_total_panier = ($PU_HT_total_panier + $PU_HT_total);
                                                    $PU_TTC_total = ($PU_HT_total + $TVA * $quantite);
                                                    $PU_TTC_totald_panierd = ($PU_TTC_totald_panierd + $PU_TTC_total);

                                                    $PU_TVA_TOTAUX = ($PU_TVA_TOTAUX + ($TVA * $quantite));
                                                    $Taux_tva = "1.20";

                                                    $PU_HT_total_panier = sprintf('%.2f', ($PU_HT_total_panier));
                                                    $PU_TVA_total_panier = sprintf('%.2f', ($PU_TTC_totald_panierd - $PU_HT_total_panier));

                                                    $_SESSION['total_HT'] = $PU_HT_total_panier;
                                                    $_SESSION['total_HT_net'] = $_SESSION['total_HT'];
                                                    $_SESSION['total_TTC'] = sprintf('%.2f', ($_SESSION['total_HT_net'] + $PU_TVA_TOTAUX + $PU_TVA2_TOTAUX));

                                                    $_SESSION['total_TVA'] = "$PU_TVA_total_panier";

                                                    $image = '';

                                                    if ($action_module_service_produit == 'Commande') {
                                                        ///////////////////////////////SELECT URL
                                                        $req_select = $bdd->prepare("SELECT * FROM membres_commandes_details WHERE id=?");
                                                        $req_select->execute(array($ligne_boucle['id_commande_detail']));
                                                        $ligne_select_commande = $req_select->fetch();
                                                        $req_select->closeCursor();
                                                        $url_vers = $ligne_select_commande['url'];
                                                        $couleur = $ligne_select_commande['couleur'];
                                                        $taille = $ligne_select_commande['taille'];

                                                        ///////////////////////////////SELECT URL
                                                        $req_select = $bdd->prepare("SELECT * FROM categories WHERE nom_categorie=?");
                                                        $req_select->execute(array($ligne_boucle['categorie']));
                                                        $ligne_cat = $req_select->fetch();
                                                        $req_select->closeCursor();

                                                        if (!empty($ligne_cat['nom_categorie_image'])) {
                                                            $image = '/images/categories/' . $ligne_cat['nom_categorie_image'];
                                                        }
                                                    } elseif ($action_module_service_produit == 'Commande colis') {
                                                        $url_vers = '/Passage-de-colis';
                                                        $PU_HT = $ligne_boucle['TTC_colis'];

                                                        ///////////////////////////////SELECT URL
                                                        $req_select = $bdd->prepare("SELECT * FROM categories WHERE nom_categorie=?");
                                                        $req_select->execute(array($ligne_boucle['categorie']));
                                                        $ligne_cat = $req_select->fetch();
                                                        $req_select->closeCursor();

                                                        if (!empty($ligne_cat['nom_categorie_image'])) {
                                                            $image = '/images/categories/' . $ligne_cat['nom_categorie_image'];
                                                        }
                                                    }
                                                    if (!empty($ligne_boucle['id_produit'])) {

                                                        ///////////////////////////////SELECT URL
                                                        $req_select = $bdd->prepare("SELECT * FROM configurations_references_produits WHERE id=?");
                                                        $req_select->execute(array($ligne_boucle['id_produit']));
                                                        $ligne_p = $req_select->fetch();
                                                        $req_select->closeCursor();

                                                        if (!empty($ligne_p['photo'])) {
                                                            $image = $ligne_p['photo'];
                                                        }
                                                    }

                                                ?>
                                                    <div class="dropcart__product">
                                                        <div class="product-image dropcart__product-image">
                                                            <a href="/" class="product-image__body">
                                                                <img class="product-image__img" src="<?= $image ?>" alt="">
                                                            </a>
                                                        </div>
                                                        <div class="dropcart__product-info">
                                                            <div class="dropcart__product-name">
                                                                <a href="<?= $url_vers ?>" target="_blank"><?= $libelle ?></a>
                                                            </div>
                                                            <ul class="dropcart__product-options">
                                                                <?php if ($couleur != "") { ?>
                                                                    <li>Couleur : <?= $couleur ?></li>
                                                                <?php } ?>
                                                                <?php if ($taille != "") { ?>
                                                                    <li>Taille : <?= $taille; ?></li>
                                                                <?php } ?>
                                                            </ul>
                                                            <div class="dropcart__product-meta">
                                                                <span class="dropcart__product-quantity"><?= $quantite; ?></span>
                                                                x
                                                                <span class="dropcart__product-price"><?= number_format($PU_HT, 0, '.', ' '); ?> F CFA</span>
                                                            </div>
                                                        </div>
                                                        <a id="supp_pan" data-id="<?= $ligne_boucle['id'] ?>" class="dropcart__product-remove btn btn-light btn-sm ml-2 px-2">
                                                            <span class="uk-icon-times"></span>
                                                        </a>
                                                    </div>
                                                <?php
                                                    unset($PU_HT_total);
                                                }
                                                $req_boucle->closeCursor();

                                                $_SESSION['total_HT_commande'] = round(($_SESSION['total_HT']));
                                                $_SESSION['total_HT'] = round(($_SESSION['total_HT_commande'] + $prix_total_frais_expedition_HT), 0);
                                                $_SESSION['total_HT_net'] = round(($_SESSION['total_HT'] + $prix_total_frais_expedition_HT), 0);
                                                $_SESSION['total_TVA'] = round($prix_total_frais_expedition_TVA, 0) + $PU_TVA_total_panier;
                                                //var_dump($_SESSION['total_HT_commande'], $prix_total_frais_expedition_TTC);
                                                $_SESSION['total_TTC'] = round(($_SESSION['total_HT_commande'] + $prix_total_frais_expedition_TTC + $prix_expedition_colis_total + $prix_expedition_total), 2);

                                                ///////////////////////////////UPDATE PANIER GENERALE
                                                $sql_update = $bdd->prepare("UPDATE membres_panier SET
                                            Tarif_HT=?
                                            WHERE id_membre=?");
                                                $sql_update->execute(array(
                                                    $_SESSION['total_HT_commande'],
                                                    $id_oo
                                                ));
                                                $sql_update->closeCursor();

                                                ///////////////////////////////SELECT
                                                $req_selectpa = $bdd->prepare("SELECT * FROM membres_panier WHERE id_membre=?");
                                                $req_selectpa->execute(array($id_oo));
                                                $ligne_selectpa = $req_selectpa->fetch();
                                                $req_selectpa->closeCursor();


                                                ?>
                                            </div>
                                            <div class="dropcart__totals">
                                                <table>
                                                    <tbody>
                                                        <tr>
                                                            <th>Sous-total articles</th>
                                                            <td><?php echo number_format($_SESSION['total_HT_commande'], 0, '.', ' '); ?> F CFA</td>
                                                        </tr>
                                                        <?php if (!empty($_SESSION['prix_frais_de_gestion_total'])) { ?>
                                                            <tr>
                                                                <th>Frais de gestion HT</th>
                                                                <td><?php echo number_format($_SESSION['prix_frais_de_gestion_total'], 0, '.', ' '); ?> F CFA</td>
                                                            </tr>
                                                        <?php } ?>
                                                        <tr>
                                                            <th>TVA 18%</th>
                                                            <td><?php echo number_format($_SESSION['total_TVA'], 0, '.', ' '); ?> F CFA</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Douane et tranport</th>
                                                            <td><?php
                                                                echo number_format($_SESSION['prix_expedition_colis_total2'] + $_SESSION['prix_expedition_total2'], 0, '.', ' '); ?> F CFA</td>
                                                        </tr>

                                                        <tr>
                                                            <?php if ($ligne_selectpa['Titre_panier'] != "Abonnement") {
                                                            ?>
                                                                <th>Total</th>
                                                                <td><?php echo number_format($_SESSION['total_TTC'], 0, '.', ' '); ?> F CFA</td>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <th>Total</th>
                                                                <td><?php echo number_format($_SESSION['total_TTC'] + $_SESSION['total_TVA'], 0, '.', ' '); ?> F CFA</td>
                                                            <?php
                                                            } ?>

                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="dropcart__buttons">
                                                <a class="btn btn-secondary <?php if (empty($user)) { ?> pxp-header-user <?php } ?>" <?php if (empty($user)) { ?> onclick="return false;" <?php } ?> href="<?php if (!empty($user)) { ?>/Recapitulatif-Panier<?php } ?>">Voir le panier</a>

                                                <a class="btn btn-primary <?php if (empty($user)) { ?> pxp-header-user <?php } ?>" <?php if (empty($user)) { ?> onclick="return false;" <?php } ?> href="<?php if (!empty($user)) { ?>/Paiement-2<?php } ?>">Payer</a>

                                            </div>
                                        <?php } else { ?>
                                            <div class="dropcart__products-list">
                                                <div style="text-align:center">
                                                    Votre panier est vide !
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>



                            <?php
                            if (true) {
                            ?>

                                <div id="profilButtonNavMobile" class="indicator">
                                    <a id="<?php if (!empty($user)) {
                                                echo "profilButton";
                                            } ?>" class="indicator__button <?php if (empty($user)) {
                                                                                echo "pxp-header-user";
                                                                            } ?>" <?php if (empty($user)) {
                                                                                        echo "onclick='return false;'";
                                                                                    } ?>>
                                        <span class="indicator__area">
                                            <svg width="20px" height="20px">
                                                <use xlink:href="/template2/black/images/sprite.svg#person-20"></use>
                                            </svg>
                                        </span>
                                    </a>
                                    <div class="indicator__dropdown" style="max-height: 538px;">
                                        <div class="account-menu">
                                            <div class="account-menu__divider"></div>

                                            <?php if (!empty($user)) { ?>
                                                <a href="/Gestion-de-votre-compte.html" class="account-menu__user">
                                                    <!-- <div class="account-menu__user-avatar">
                                                        <img src="/images/membres/<?php echo "$user"; ?>/<?php echo "$image_oo"; ?>" alt="<?php echo "$nom_oo $prenom_oo"; ?>">
                                                    </div> -->
                                                    <div class="account-menu__user-info">
                                                        <div class="account-menu__user-name"><?php echo "$nom_oo $prenom_oo"; ?></div>
                                                        <div class="account-menu__user-email"><?php echo "$mail_oo"; ?></div>
                                                    </div>
                                                </a>
                                            <?php } ?>
                                            <div class="account-menu__divider"></div>
                                            <ul class="account-menu__links">
                                                <?php if (!empty($user)) { ?>
                                                    <?php
                                                    //////////////////////////////////SI ADMIN
                                                    if ($admin_oo > 0) {
                                                    ?>
                                                        <li><a href="/administration/index-admin.php">Administration</a></li>
                                                    <?php
                                                    }
                                                    ?>

                                                    <li><a href="/Gestion-de-votre-compte.html">Mes informations</a></li>
                                                    <li><a href="/Mon-abonnement">Mon abonnement</a></li>
                                                    <li><a href="/Mes-commandes">Mes commandes</a></li>
                                                <?php } ?>
                                                <li><a style="margin-left:1rem" href="/Passage-de-commande">Nouvelle commande</a></li>
                                                <?php if (!empty($user)) { ?>
                                                    <li><a href="/Mes-listes-de-souhaits">Mes listes de souhaits</a></li>
                                                    <li><a style="margin-left:1rem" href="/Mes-listes-de-souhaits">Mes souhaits en cours</a></li>
                                                    <!--    <li><a style="margin-left:1rem" href="/Mes-produits">Mes produits retrouvés</a></li> -->
                                                <?php } ?>
                                                <li><a style="margin-left:1rem" href="#" id="addList">Créer une liste de souhaits</a></li>
                                                <?php if (!empty($user)) { ?>
                                                    <li><a href="/Mes-colis">Mes colis</a></li>
                                                <?php } ?>
                                                <li><a style="margin-left:1rem" href="/Passage-de-colis">Nouveau colis</a></li>
                                                <?php if (!empty($user)) { ?>
                                                    <li><a href="/Notifications">Notifications</a></li>
                                                    <li><a href="/Factures">Factures</a></li>
                                                <?php } ?>
                                            </ul>
                                            <?php if (!empty($user)) { ?>
                                                <div class="account-menu__divider"></div>
                                                <ul class="account-menu__links">
                                                    <li><a id="Deconnexion" href="#" onclick="return false;">Déconnexion</a></li>
                                                </ul>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>

                                <a id="mobileCartNav" class="indicator__button">
                                    <span class="indicator__area" style="padding: 0;">
                                        <svg width="20px" height="20px">
                                            <use xlink:href="/template2/black/images/sprite.svg#cart-20"></use>
                                        </svg>
                                        <span class="indicator__value">
                                            <?= $panier_nbr2['nbr_pan2'] ?>
                                        </span>
                                    </span>
                                </a>
                        </div>

                    </div>

                <?php
                            }
                ?>



                </div>


                <div class="mobile-search-container" style="display: flex; padding: 5px; border-radius: 5px 0 0 5px; overflow: hidden;">
                    <form id="mobileSearchForm" action="/pages/Boutique/Boutique.php" method="POST" style="display: flex; width: 100%;">
                        <input
                            type="text"
                            id="mobileSearchInput"
                            name="search"
                            class="mobile-search-input"
                            placeholder="Recherchez un produit ou collez un lien d’article"
                            style="flex: 1; padding: 7px; font-size: 12px; border: none; border-radius: 5px 0 0 5px; background-color: #E8F0F7; color: #5D6D7E;"
                            required />
                        <button
                            id="mobileSearchButton"
                            class="mobile-search-button"
                            type="submit"
                            style="background-color: #FFC107; border: none; padding: 7px; cursor: pointer; border-radius: 0 5px 5px 0;">
                            <img
                                src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/55/Magnifying_glass_icon.svg/512px-Magnifying_glass_icon.svg.png"
                                alt="Rechercher"
                                style="width: 20px; height: 20px;" />
                        </button>
                    </form>
                </div>


            </div>
        </div>
    </div>
</header>


<!-- mobile site__header / end -->