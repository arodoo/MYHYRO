<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../Configurations_bdd.php');
require_once('../../Configurations.php');
require_once('../../Configurations_modules.php');
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
include('../../pages/paiements/Panier/includes/calculs-frais-douane-expeditions.php');
if (!empty($user)) {


    if (isset($_SESSION['id_commande'])) {
        $sql_select = $bdd->prepare("SELECT * FROM membres_commandes WHERE id=? AND statut=3");
        $sql_select->execute(array(
            $_SESSION['id_commande']
        ));
        $panier = $sql_select->fetch();
        $sql_select->closeCursor();
    } else {
        /*$sql_select = $bdd->prepare("SELECT * FROM membres_commandes WHERE user_id=? AND statut=3");
            $sql_select->execute(array(
                $id_oo
            ));
            $panier = $sql_select->fetch();
            $sql_select->closeCursor();*/
    }

    /*if(isset($_SESSION['id_colis'])){
            $sql_select = $bdd->prepare("SELECT * FROM membres_colis WHERE id=? and user_id=?");
            $sql_select->execute(array(
                $_SESSION['id_colis'],
                $id_oo
            ));
            $panierColis = $sql_select->fetch();
            $sql_select->closeCursor();
        }else{
            $sql_select = $bdd->prepare("SELECT * FROM membres_colis WHERE user_id=?");
            $sql_select->execute(array(
                $id_oo
            ));
            $panierColis = $sql_select->fetch();
            $sql_select->closeCursor();
        }

        $sql_select = $bdd->prepare("SELECT * FROM membres_colis_details WHERE colis_id=?");
        $sql_select->execute(array(
            $panierColis['id']
        ));
        $articlesColis = $sql_select->fetchAll();
        $sql_select->closeCursor();

        $sql_select = $bdd->prepare("SELECT * FROM membres_commandes_details 
        WHERE commande_id=?");
        $sql_select->execute(array(
            $panier['id'],
        ));
        $articles = $sql_select->fetchAll();
        $sql_select->closeCursor();*/

    $req_select = $bdd->prepare("SELECT * FROM membres WHERE id=?");
    $req_select->execute(array(
        $id_oo
    ));
    $membre = $req_select->fetch();
    $req_select->closeCursor();

    $req_select = $bdd->prepare("SELECT * FROM configurations_abonnements WHERE id=?");
    $req_select->execute(array(
        $membre['Abonnement_id']
    ));
    $abonnement = $req_select->fetch();
    $req_select->closeCursor();

    $gestion = $abonnement['Frais_de_gestion_d_une_commande'];
    $gestionEuro = round(floatval($gestion * 0.00152449), 2);
} else {

    $id_oo = $_SESSION['id_ext'] . 'ext';

    //Utilisateur non connecté mais qui possède normalement une commande à sa commande_id stockée en session
    if ($_SESSION['id_commande'] === null) {
        $articles = [];
        $panier = [];
    } else {
        $sql_select = $bdd->prepare("SELECT * FROM membres_commandes WHERE id=? AND statut=3");
        $sql_select->execute(array(
            $_SESSION['id_commande']
        ));
        $panier = $sql_select->fetch();
        $sql_select->closeCursor();

        $sql_select = $bdd->prepare("SELECT * FROM membres_commandes_details 
            WHERE commande_id=?");
        $sql_select->execute(array(
            $panier['id'],
        ));
        $articles = $sql_select->fetchAll();
        $sql_select->closeCursor();
    }
    if (isset($_SESSION['id_colis'])) {
        $sql_select = $bdd->prepare("SELECT * FROM membres_colis WHERE id=?");
        $sql_select->execute(array(
            $_SESSION['id_colis'],
        ));
        $panierColis = $sql_select->fetch();
        $sql_select->closeCursor();
        $sql_select = $bdd->prepare("SELECT * FROM membres_colis_details WHERE colis_id=?");
        $sql_select->execute(array(
            $panierColis['id']
        ));
        $articlesColis = $sql_select->fetchAll();
        $sql_select->closeCursor();
    } else {
        $articlesColis = [];
        $panierColis = [];
    }
    //On récupère $panier et $articles
    $req_select = $bdd->prepare("SELECT * FROM configurations_abonnements WHERE id=?");
    $req_select->execute(array(
        1
    ));
    $abonnement = $req_select->fetch();
    $req_select->closeCursor();
    $gestion = $abonnement['Frais_de_gestion_d_une_commande'];
    $gestion = $gestion == "" ? 0 : $gestion;
    $gestionEuro = round(floatval($gestion * 0.00152449), 2);
}

/*$douane = 0;
    for($i=0; $i < count($articles); $i++){
        $req_select = $bdd->prepare("SELECT * FROM categories WHERE nom_categorie=?");
        $req_select->execute(array(
            $articles[$i]['categorie']
        ));
        $categorie = $req_select->fetch();
        $req_select->closeCursor();
        $pourcentage = $categorie['value_commande']/100;

        $douane += $articles[$i]['prix']*$pourcentage*$articles[$i]['quantite'];
    }
    $douaneEuro = round(floatval($douane*0.00152449),2);*/
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

<script>
    $(document).ready(function() {
        /*var subtotal = document.getElementById('subtotal');
                if(subtotal !== null){
                    var price = parseFloat(subtotal.innerHTML);
                    if(isNaN(price)){
                        subtotal.innerHTML = "0 €";
                    }else{
                        subtotal.innerHTML = parseFloat(price.toFixed(0)).toLocaleString() + " F CFA";
                    }
                }

                var douane = document.getElementById('douane');
                if(douane !== null){
                    var price = parseFloat(douane.innerHTML);
                    if(isNaN(price)){
                        douane.innerHTML = "0 €";
                    }else{
                        douane.innerHTML = parseFloat(price.toFixed(0)).toLocaleString() + " F CFA";
                    }
                }

                var gestion = document.getElementById('gestion');
                if(gestion !== null){
                    var price = parseFloat(gestion.innerHTML);
                    if(isNaN(price)){
                        gestion.innerHTML = "0 €";
                    }else{
                        gestion.innerHTML = parseFloat(price.toFixed(0)).toLocaleString() + " F CFA";
                    }
                }

                var total = document.getElementById('total');
                if(total !== null){
                    var price = parseFloat(total.innerHTML);
                    if(isNaN(price)){
                        total.innerHTML = "0 €";
                    }else{
                        total.innerHTML = parseFloat(price.toFixed(0)).toLocaleString() + " F CFA";
                    }
                }
*/

        /* Afficher le menu du panier avec le survol */
        function attachCartEvents() {
            let hideTimeout; // Variable pour contrôler la minuterie de masquage

            if (window.innerWidth > 768) {
                let cart = document.getElementById('cardNav');
                if (cart) {
                    cart.addEventListener("mouseenter", function(event) {
                        clearTimeout(hideTimeout);
                        cart.classList.add('indicator--open');
                        cart.classList.add('indicator--display');
                    }, false);

                    cart.addEventListener("mouseleave", function(event) {
                        hideTimeout = setTimeout(function() { // Démarre le chronomètre
                            cart.classList.remove('indicator--open');
                            cart.classList.remove('indicator--display');
                        }, 300); // Délai d'expiration en millisecondes
                    }, false);
                }
            } else {
                let mobileCart = document.getElementById('mobileCartNav');
                if (mobileCart) {
                    mobileCart.addEventListener("mouseenter", function(event) {
                        clearTimeout(hideTimeout);
                        $("#cardNav .indicator__dropdown").appendTo("#mobileCartNav");
                        mobileCart.classList.add('indicator--open');
                        mobileCart.classList.add('indicator--display');
                    }, false);

                    mobileCart.addEventListener("mouseleave", function(event) {
                        hideTimeout = setTimeout(function() { // Démarre le chronomètre
                            mobileCart.classList.remove('indicator--open');
                            mobileCart.classList.remove('indicator--display');
                        }, 300); // Délai d'expiration en millisecondes
                    }, false);
                }
            }
        }


        attachCartEvents();

        $(window).resize(function() {
            attachCartEvents();
        });
    });
</script>

<a id="cartButtonNav" class="indicator__button" href="<?=$panier_nbr['nbr_pan'] > 0 ? '/Recapitulatif-Panier' : "/Passage-de-commande" ?>">
    <span class="indicator__area">
        <svg width="20px" height="20px">
            <use xlink:href="/template2/black/images/sprite.svg#cart-20"></use>
        </svg>
        <span class="indicator__value">
            <?= $panier_nbr2['nbr_pan2'] ?>
        </span>
    </span>
</a>
<div class="indicator__dropdown" style="max-height: 538px;">
    <!-- .dropcart -->
    <div class="dropcart dropcart--style--dropdown">
        <div class="dropcart__body">
            <?php

            if ($panier_nbr['nbr_pan'] > 0) { ?>
                <div class="dropcart__products-list" style="max-height: 300px; overflow-y: auto;">
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
                                <?php if ($ligne_selectpa['Titre_panier'] != "Abonnement" && $ligne_selectpa['Titre_panier'] != "Liste") {
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