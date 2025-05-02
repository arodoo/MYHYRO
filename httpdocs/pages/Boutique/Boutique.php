<?php

define('BASE_PATH', $_SERVER['DOCUMENT_ROOT']);


require_once(BASE_PATH . '/Configurations_bdd.php');
require_once(BASE_PATH . '/Configurations.php');
require_once(BASE_PATH . '/Configurations_modules.php');


$response = ["status" => "error", "message" => "Aucun terme de recherche n'a été fourni."];

$searchResults = [];

//Recevoir des données de la barre de recherche mobile
if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST["search"])) {
    // Récupérer et assainir le terme de recherche
    $searchValue = htmlspecialchars($_POST["search"]);



    // Déboguer le terme de recherche reçu
    /*  echo "<h2>Terme de recherche reçu :</h2>";
    echo "<pre>";
    var_dump($searchValue);
    echo "</pre>"; */

    try {
        // Préparer la requête en utilisant LIKE pour permettre des correspondances partielles
        $query = "SELECT * FROM configurations_references_produits WHERE nom_produit LIKE ?";
        $stmt = $bdd->prepare($query);
        $stmt->execute(["%" . $searchValue . "%"]);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Déboguer les résultats de la requête
        /*   echo "<h2>Résultats de la requête :</h2>";
        echo "<pre>";
        var_dump($results);
        echo "</pre>"; */

        if (!empty($results)) {
            $response = [
                "status" => "success",
                "message" => "Produits trouvés.",
                "results" => $results
            ];
            $searchResults = $results;
        } else {
            $response = [
                "status" => "no_results",
                "message" => "Aucun produit trouvé pour votre recherche."
            ];
        }
    } catch (PDOException $e) {
        $response = [
            "status" => "error",
            "message" => "Erreur lors de l'exécution de la requête."
        ];

        /*   echo "<h2>Erreur lors de la requête :</h2>";
        echo "<pre>";
        var_dump($e->getMessage());
        echo "</pre>"; */
    }
    //Recevoir des données de la barre de recherche desktop
} elseif ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["search_desktop"]) && !empty($_POST["search_desktop"])) {


    $searchValue = htmlspecialchars($_POST["search_desktop"]);
    $category    = htmlspecialchars($_POST["Category"]);


    /*     echo "<h2>Terme de recherche desktop reçu :</h2>";
    echo "<pre>";
    var_dump($searchValue, $category);
    echo "</pre>"; */

    try {

        $query  = "SELECT * FROM configurations_references_produits WHERE nom_produit LIKE ?";
        $params = ["%" . $searchValue . "%"];


        if ($category !== "all") {
            $query  .= " AND categorie = ?";
            $params[] = $category;
        }

        $stmt = $bdd->prepare($query);
        $stmt->execute($params);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        /* 
        echo "<h2>Résultats de la requête desktop :</h2>";
        echo "<pre>";
        var_dump($results);
        echo "</pre>"; */

        if (!empty($results)) {
            $response = [
                "status"  => "success",
                "message" => "Produits trouvés.",
                "results" => $results
            ];
            $searchResults = $results;
        } else {
            $response = [
                "status"  => "no_results",
                "message" => "Aucun produit trouvé pour votre recherche desktop."
            ];
        }
    } catch (PDOException $e) {
        $response = [
            "status"  => "error",
            "message" => "Erreur lors de l'exécution de la requête desktop."
        ];
    }
}

/* echo json_encode($response); */

//end



if (!empty($user)) {
    $sql_select = $bdd->prepare('SELECT * FROM membres_commandes WHERE id=?');
    $sql_select->execute(array($_SESSION['id_commande']));
    $commande = $sql_select->fetch();
    $sql_select->closeCursor();
    if ($commande) {
        $id_commande = $commande['id'];
    }

    /*  if (isset($_POST["submit"])) {
        $searchValue = $_POST["search"];
        $selectedCategory = $_POST["Category"];
        $redirectionURL = "/Boutique/" . $selectedCategory;
        header("Location: " . $redirectionURL);
    } */
}


?>

<script>
    const quickview = {
        cancelPreviousModal: function() {},
        clickHandler: function() {
            const modal = $('#quickview-modal');
            const button = $(this);
            const doubleClick = button.is('.product-card__quickview--preload');

            quickview.cancelPreviousModal();

            if (doubleClick) {
                return;
            }

            button.addClass('product-card__quickview--preload');

            let xhr = null;
            // timeout ONLY_FOR_DEMO!
            const timeout = setTimeout(function() {
                xhr = $.ajax({
                    url: '/pages/Boutique/quickview.php',
                    type: 'POST',
                    data: {
                        id: button.data('id')
                    },
                    success: function(data) {
                        quickview.cancelPreviousModal = function() {};
                        button.removeClass('product-card__quickview--preload');

                        modal.find('.modal-content').html(data);
                        modal.find('.quickview__close').on('click', function() {
                            modal.modal('hide');
                        });
                        modal.modal('show');
                    }
                });
            }, 1000);

            quickview.cancelPreviousModal = function() {
                button.removeClass('product-card__quickview--preload');

                if (xhr) {
                    xhr.abort();
                }

                // timeout ONLY_FOR_DEMO!
                clearTimeout(timeout);
            };
        }
    };


    $(function() {
        const modal = $('#quickview-modal');

        modal.on('shown.bs.modal', function() {
            modal.find('.product').each(function() {
                const gallery = $(this).find('.product-gallery');

                if (gallery.length > 0) {
                    initProductGallery(gallery[0], $(this).data('layout'));
                }
            });

            $('.input-number', modal).customNumber();
        });

        $('.product-card__quickview').on('click', function() {
            quickview.clickHandler.apply(this, arguments);
        });
    });

    $(document).ready(function() {


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


        $(document).on("click", "#ajouterPanier", function() {

            quantite = 1
            if (document.getElementById('product-quantity')) {
                quantite = document.getElementById('product-quantity').value ?? 1
            }
            let id_produit = $(this).attr('data-id');
            let id_commande = $(this).attr('data-commande');

            var formData = new FormData();
            formData.append('idaction', id_produit);
            formData.append('idCommande', id_commande)
            formData.append('quantite', quantite);
            formData.append('action', 'addToCart');

            $.post({
                url: '/pages/Boutique/Boutique-action-ajouter-ajax.php',
                type: 'POST',
                data: formData,
                // data: {
                //     idaction: $(this).attr('data-id'),
                //     quantite: quantite,
                // },
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(res) {

                    if (res.retour_validation == "ok") {
                        popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                        listeCart();
                    } else {
                        popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                    }

                }
            });
        });

        /*  $(document).on("submit", "#searchForm", function(event) {
             event.preventDefault();
             $.ajax({
                 url: '/pages/Boutique/Boutique-search.php',
                 type: 'POST',
                 data: $(this).serialize(),
                 dataType: 'json',
                 success: function(response) {
                     if (response.status === "success") {
                         window.location.href = response.success;
                     } else {
                         alert(response.message);
                     }
                 },
                 error: function(xhr, status, error) {
                     console.error("Error AJAX:", error);
                 }
             });
         }); */

    });
</script>



<!-- site__body -->
<div class="site__body">
    <div class="container">
        <div class="shop-layout shop-layout--sidebar--start">
            <div class="shop-layout__sidebar">
                <div class="block block-sidebar block-sidebar--offcanvas--mobile">
                    <div class="block-sidebar__backdrop"></div>
                    <div class="block-sidebar__body">
                        <div class="block-sidebar__header">
                            <div class="block-sidebar__title">Filters</div>
                            <button class="block-sidebar__close" type="button">
                                <svg width="20px" height="20px">
                                    <use xlink:href="images/sprite.svg#cross-20"></use>
                                </svg>
                            </button>
                        </div>
                        <div class="block-sidebar__item">
                            <div class="widget-filters widget widget-filters--offcanvas--mobile" data-collapse data-collapse-opened-class="filter--opened">
                                <h4 class="widget-filters__title widget__title">Filtres</h4>
                                <div class="widget-filters__list">
                                    <div class="widget-filters__item">
                                        <div class="filter filter--opened" data-collapse-item>
                                            <button type="button" class="filter__title" data-collapse-trigger>
                                                Categories
                                                <svg class="filter__arrow" width="12px" height="7px">
                                                    <use xlink:href="images/sprite.svg#arrow-rounded-down-12x7"></use>
                                                </svg>
                                            </button>
                                            <div class="filter__body" data-collapse-content>
                                                <div class="filter__container">
                                                    <div class="filter-categories">
                                                        <ul class="filter-categories__list">
                                                            <?php
                                                            $req_boucle = $bdd->prepare("SELECT * FROM categories WHERE activer = ? ORDER BY nom_categorie ASC");
                                                            $req_boucle->execute(array("oui"));
                                                            while ($ligne_boucle = $req_boucle->fetch()) {
                                                                $id_categorie = $ligne_boucle['id'];
                                                                $nom_categorie = $ligne_boucle['nom_categorie'];
                                                                $url_categorie = $ligne_boucle['url_categorie'];
                                                                $title_categorie = $ligne_boucle['title_categorie'];
                                                                $meta_description_categorie = $ligne_boucle['meta_description_categorie'];
                                                                $meta_keyword_categorie = $ligne_boucle['meta_keyword_categorie'];
                                                                $activer = $ligne_boucle['activer'];

                                                                $nombre_produits = 0;
                                                                $req_boucle_produits = $bdd->prepare("SELECT COUNT(id) FROM configurations_references_produits WHERE id_categorie = ?");
                                                                $req_boucle_produits->execute(array($id_categorie));
                                                                $nombre_produits = $req_boucle_produits->fetch();
                                                            ?>
                                                                <li class="filter-categories__item filter-categories__item--parent">
                                                                    <svg class="filter-categories__arrow" width="6px" height="9px">
                                                                        <use xlink:href="images/sprite.svg#arrow-rounded-left-6x9"></use>
                                                                    </svg>
                                                                    <a href="/Boutique/<?= $url_categorie ?>"><?= $nom_categorie ?></a>
                                                                    <div class="filter-categories__counter"><?= $nombre_produits[0]   ?></div>
                                                                </li>
                                                            <?php
                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="block-sidebar__item d-none d-lg-block">
                            <div class="widget-products widget">
                                <h4 class="widget__title">Derniers produits</h4>
                                <div class="widget-products__list">
                                    <?php
                                    $req_produits_boucle = $bdd->prepare("SELECT * FROM configurations_references_produits ORDER BY nom_produit DESC LIMIT 3");
                                    $req_produits_boucle->execute();
                                    while ($ligne_boucle = $req_produits_boucle->fetch()) {
                                        $idd = $ligne_boucle['id'];
                                        $uuid = $ligne_boucle['uuid'];
                                        $photo = $ligne_boucle['photo'];
                                        $url = $ligne_boucle['url_produit'];
                                        $prix = $ligne_boucle['prix'];
                                        $nom_produit = $ligne_boucle['nom_produit'];
                                        $refproduithyro = $ligne_boucle['ref_produit_hyro'];
                                        $description = $ligne_boucle['description'];
                                        $url_produit_0 = $ligne_boucle['url'];
                                        $stock = $ligne_boucle['stock'];
                                        $title = $ligne_boucle['title'];
                                        $meta_description = $ligne_boucle['meta_description'];
                                        $ActiverActiver = $ligne_boucle['Activer'];
                                        $meta_keyword = $ligne_boucle['meta_keyword'];
                                        $lien = $ligne_boucle['lien_chez_un_marchand'];
                                        $date = $ligne_boucle['date_ajout'];
                                    ?>
                                        <?php
                                        $nouvelle_valeur_nbr_vue = 1;
                                        $sql_update = $bdd->prepare("UPDATE configurations_references_produits SET nbr_vue = nbr_vue + 1 WHERE id = ?");
                                        $sql_update->execute(array($idd));
                                        $sql_update->closeCursor();
                                        ?>
                                        <div class="widget-products__item">
                                            <div class="widget-products__image">
                                                <div class="product-image">
                                                    <a href="#" class="product-image__body">
                                                        <img class="product-image__img" src="<?= $photo ?>" alt="">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="widget-products__info">
                                                <div class="widget-products__name">
                                                    <a href="/Boutique-fiche/<?= $url_produit_0 ?>"><?= $nom_produit ?></a>
                                                </div>
                                                <div class="widget-products__prices">
                                                    <?= $prix ?> F CFA
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="shop-layout__content">
                <div class="block">
                    <div class="products-view">
                        <div class="products-view__options">
                            <div class="view-options view-options--offcanvas--mobile">
                                <div class="view-options__filters-button">
                                    <button type="button" class="filters-button">
                                        <svg class="filters-button__icon" width="16px" height="16px">
                                            <use xlink:href="images/sprite.svg#filters-16"></use>
                                        </svg>
                                        <span class="filters-button__title">Filters</span>
                                        <span class="filters-button__counter">3</span>
                                    </button>
                                </div>
                                <div class="view-options__layout">
                                    <div class="layout-switcher">
                                        <div class="layout-switcher__list">
                                            <button data-layout="grid-3-sidebar" data-with-features="false" title="Grid" type="button" class="layout-switcher__button ">
                                                <svg width="16px" height="16px">
                                                    <use xlink:href="images/sprite.svg#layout-grid-16x16"></use>
                                                </svg>
                                            </button>

                                            <button data-layout="list" data-with-features="false" title="List" type="button" class="layout-switcher__button  layout-switcher__button--active ">
                                                <svg width="16px" height="16px">
                                                    <use xlink:href="images/sprite.svg#layout-list-16x16"></use>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="view-options__legend">
                                    <?php
                                    /*    var_dump($searchValue);
                                    echo $searchValue; */
                                    $action = $_GET['action'];
                                    $categorie_filter = " ";
                                    $query = "";
                                    $array = [];
                                    if ($action) {
                                        $req_categorie = $bdd->prepare("SELECT * FROM categories WHERE url_categorie = ? LIMIT 1");
                                        $req_categorie->execute(array($action));
                                        $categorie_f = $req_categorie->fetch();
                                        // var_dump($categorie_f);
                                        if ($categorie_f) {
                                            $id_categorie_filtre = $categorie_f['id'];
                                            $nom_categorie_filtre = $categorie_f['nom_categorie'];
                                            $url_categorie_filtre = $categorie_f['url_categorie'];
                                            $title_categorie_filtre = $categorie_f['title_categorie'];
                                            $meta_description_categorie_filtre = $categorie_f['meta_description_categorie'];
                                            $meta_keyword_categorie_filtre = $categorie_f['meta_keyword_categorie'];
                                            $activer_filtre = $categorie_f['activer'];
                                            $categorie_filter = "Les produits de " . $categorie_f['nom_categorie'] . " : ";
                                            $query = "WHERE id_categorie = ? ";
                                            $array = array($id_categorie_filtre);
                                        }
                                    }
                                    $req_boucle = $bdd->prepare("SELECT COUNT(id) FROM configurations_references_produits $query ORDER BY nom_produit ASC");
                                    $req_boucle->execute($array);
                                    $count_produits = $req_boucle->fetch();
                                    $nombre_produits = $count_produits[0];

                                    echo "$categorie_filter Il y a $nombre_produits  produits"
                                    ?>

                                </div>
                                <div class="view-options__divider"></div>
                                <div class="view-options__control">
                                    <div>
                                        <select class="form-control form-control-sm" name="" id="">
                                            <option value="">Default</option>
                                            <option value="">Name (A-Z)</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="products-view__list products-list" data-layout="list" data-with-features="false" data-mobile-grid-columns="2">
                            <div class="products-list__body">
                                <?php if (!empty($searchResults)) { ?>
                                    <?php foreach ($searchResults as $result) { ?>
                                        <div class="products-list__item">
                                            <div class="product-card product-card--hidden-actions ">
                                                <button class="product-card__quickview" type="button" data-id="<?= $result['id'] ?>">
                                                    <svg width="16px" height="16px">
                                                        <use xlink:href="images/sprite.svg#quickview-16"></use>
                                                    </svg>
                                                    <span class="fake-svg-icon"></span>
                                                </button>
                                                <div class="product-card__image product-image">
                                                    <a href="/Boutique-fiche/<?= $result['url_produit'] ?>" class="product-image__body">
                                                        <img class="product-image__img" src="<?= $result['photo'] ?>" alt="">
                                                    </a>
                                                </div>
                                                <div class="product-card__info">
                                                    <div class="product-card__name">
                                                        <a href="/Boutique-fiche/<?= $result['url_produit'] ?>"><?= $result['nom_produit'] ?></a>
                                                    </div>
                                                    <div class="product-card__features-list">
                                                        <?= $result['description'] ?>
                                                    </div>
                                                </div>
                                                <div class="product-card__actions">
                                                    <div class="product-card__availability">
                                                        Disponibilité:
                                                        <?php if ($result['stock'] > 0) { ?>
                                                            <span class="text-success">En Stock</span>
                                                        <?php } else { ?>
                                                            <span class="text-danger">En Rupture</span>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="product-card__prices">
                                                        <?= $result['prix'] ?> F CFA
                                                    </div>
                                                    <?php if ($result['stock'] > 0) { ?>
                                                        <div class="product-card__buttons">
                                                            <button data-id="<?= $result['id'] ?>" data-commande="<?= $id_commande; ?>" onclick="event.preventDefault()" style="height:35px" class="btn btn-primary product-card__addtocart <?php if (!empty($user)) {
                                                                                                                                                                                                                                                echo "commande";
                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                echo "pxp-header-user";
                                                                                                                                                                                                                                            } ?>">Ajouter au panier</button>
                                                            <button id="ajouterPanier" data-id="<?= $result['id'] ?>" data-commande="<?= $id_commande; ?>" onclick="event.preventDefault()" style="height:35px" class="btn btn-primary product-card__addtocart product-card__addtocart--list <?php if (!empty($user)) {
                                                                                                                                                                                                                                                                                                } ?>">Ajouter au panier</button>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } else { ?>
                                    <?php
                                    $req_produits_boucle = $bdd->prepare("SELECT * FROM configurations_references_produits $query ORDER BY nom_produit DESC");
                                    $req_produits_boucle->execute($array);
                                    while ($ligne_boucle = $req_produits_boucle->fetch()) {

                                        $idd = $ligne_boucle['id'];
                                        $uuid = $ligne_boucle['uuid'];
                                        $photo = $ligne_boucle['photo'];
                                        $url_produit = $ligne_boucle['url_produit'];
                                        $prix = $ligne_boucle['prix'];
                                        $nom_produit = $ligne_boucle['nom_produit'];
                                        $refproduithyro = $ligne_boucle['ref_produit_hyro'];
                                        $description = $ligne_boucle['description'];
                                        $url = $ligne_boucle['url'];
                                        $stock = $ligne_boucle['stock'];
                                        $title = $ligne_boucle['title'];
                                        $meta_description = $ligne_boucle['meta_description'];
                                        $ActiverActiver = $ligne_boucle['Activer'];
                                        $meta_keyword = $ligne_boucle['meta_keyword'];
                                        $lien = $ligne_boucle['lien_chez_un_marchand'];
                                        $date = $ligne_boucle['date_ajout'];
                                    ?>
                                        <div class="products-list__item">
                                            <div class="product-card product-card--hidden-actions ">
                                                <button class="product-card__quickview" type="button" data-id="<?= $idd ?>">
                                                    <svg width="16px" height="16px">
                                                        <use xlink:href="images/sprite.svg#quickview-16"></use>
                                                    </svg>
                                                    <span class="fake-svg-icon"></span>
                                                </button>
                                                <div class="product-card__image product-image">
                                                    <a href="/Boutique-fiche/<?= $url_produit ?>" class="product-image__body">
                                                        <img class="product-image__img" src="<?= $photo ?>" alt="">
                                                    </a>
                                                </div>
                                                <div class="product-card__info">
                                                    <div class="product-card__name">
                                                        <a href="/Boutique-fiche/<?= $url_produit ?>"><?= $nom_produit ?></a>
                                                    </div>
                                                    <div class="product-card__rating">
                                                        <div class="product-card__rating-stars">
                                                            <div class="rating">
                                                                <div class="rating__body">
                                                                    <svg class="rating__star rating__star--active" width="13px" height="12px">
                                                                        <g class="rating__fill">
                                                                            <use xlink:href="images/sprite.svg#star-normal"></use>
                                                                        </g>
                                                                        <g class="rating__stroke">
                                                                            <use xlink:href="images/sprite.svg#star-normal-stroke"></use>
                                                                        </g>
                                                                    </svg>
                                                                    <div class="rating__star rating__star--only-edge rating__star--active">
                                                                        <div class="rating__fill">
                                                                            <div class="fake-svg-icon"></div>
                                                                        </div>
                                                                        <div class="rating__stroke">
                                                                            <div class="fake-svg-icon"></div>
                                                                        </div>
                                                                    </div>
                                                                    <svg class="rating__star rating__star--active" width="13px" height="12px">
                                                                        <g class="rating__fill">
                                                                            <use xlink:href="images/sprite.svg#star-normal"></use>
                                                                        </g>
                                                                        <g class="rating__stroke">
                                                                            <use xlink:href="images/sprite.svg#star-normal-stroke"></use>
                                                                        </g>
                                                                    </svg>
                                                                    <div class="rating__star rating__star--only-edge rating__star--active">
                                                                        <div class="rating__fill">
                                                                            <div class="fake-svg-icon"></div>
                                                                        </div>
                                                                        <div class="rating__stroke">
                                                                            <div class="fake-svg-icon"></div>
                                                                        </div>
                                                                    </div>
                                                                    <svg class="rating__star rating__star--active" width="13px" height="12px">
                                                                        <g class="rating__fill">
                                                                            <use xlink:href="images/sprite.svg#star-normal"></use>
                                                                        </g>
                                                                        <g class="rating__stroke">
                                                                            <use xlink:href="images/sprite.svg#star-normal-stroke"></use>
                                                                        </g>
                                                                    </svg>
                                                                    <div class="rating__star rating__star--only-edge rating__star--active">
                                                                        <div class="rating__fill">
                                                                            <div class="fake-svg-icon"></div>
                                                                        </div>
                                                                        <div class="rating__stroke">
                                                                            <div class="fake-svg-icon"></div>
                                                                        </div>
                                                                    </div>
                                                                    <svg class="rating__star rating__star--active" width="13px" height="12px">
                                                                        <g class="rating__fill">
                                                                            <use xlink:href="images/sprite.svg#star-normal"></use>
                                                                        </g>
                                                                        <g class="rating__stroke">
                                                                            <use xlink:href="images/sprite.svg#star-normal-stroke"></use>
                                                                        </g>
                                                                    </svg>
                                                                    <div class="rating__star rating__star--only-edge rating__star--active">
                                                                        <div class="rating__fill">
                                                                            <div class="fake-svg-icon"></div>
                                                                        </div>
                                                                        <div class="rating__stroke">
                                                                            <div class="fake-svg-icon"></div>
                                                                        </div>
                                                                    </div>
                                                                    <svg class="rating__star " width="13px" height="12px">
                                                                        <g class="rating__fill">
                                                                            <use xlink:href="images/sprite.svg#star-normal"></use>
                                                                        </g>
                                                                        <g class="rating__stroke">
                                                                            <use xlink:href="images/sprite.svg#star-normal-stroke"></use>
                                                                        </g>
                                                                    </svg>
                                                                    <div class="rating__star rating__star--only-edge ">
                                                                        <div class="rating__fill">
                                                                            <div class="fake-svg-icon"></div>
                                                                        </div>
                                                                        <div class="rating__stroke">
                                                                            <div class="fake-svg-icon"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- div class="product-card__rating-legend">9 Reviews</div-->
                                                    <div class="product-card__features-list">
                                                        <?= $description ?>
                                                    </div>
                                                </div>
                                                <div class="product-card__actions">
                                                    <div class="product-card__availability">
                                                        Disponibilité:
                                                        <?php if ($stock > 0) { ?>
                                                            <span class="text-success">En Stock</span>
                                                        <?php } else { ?>
                                                            <span class="text-danger">En Rupture</span>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="product-card__prices">
                                                        <?= $prix ?> F CFA
                                                    </div>
                                                    <?php if ($stock > 0) { ?>
                                                        <div class="product-card__buttons">
                                                            <button data-id="<?= $idd ?>" data-commande="<?= $id_commande; ?>" onclick="event.preventDefault()" style="height:35px" class="btn btn-primary product-card__addtocart <?php if (!empty($user)) {
                                                                                                                                                                                                                                        echo "commande";
                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                        echo "pxp-header-user";
                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                    ?>">Ajouter au panier</button>
                                                            <button id="ajouterPanier" data-id="<?= $idd ?>" data-commande="<?= $id_commande; ?>" onclick="event.preventDefault()" style="height:35px" class="btn btn-primary product-card__addtocart product-card__addtocart--list <?php if (!empty($user)) {
                                                                                                                                                                                                                                                                                    }                                                                                 ?>">Ajouter au panier</button>

                                                            <button class="btn btn-light btn-svg-icon btn-svg-icon--fake-svg product-card__wishlist" type="button">
                                                                <svg width="16px" height="16px">
                                                                    <use xlink:href="/template2/black/images/sprite.svg#wishlist-16"></use>

                                                                </svg>
                                                                <span class="fake-svg-icon fake-svg-icon--wishlist-16"></span>
                                                            </button>
                                                            <!--    <button class="btn btn-light btn-svg-icon btn-svg-icon--fake-svg product-card__compare" type="button">
                                                                <svg width="16px" height="16px">
                                                                    <use xlink:href="/template2/black/images/sprite.svg#compare-16"></use>
                                                                </svg>
                                                                <span class="fake-svg-icon fake-svg-icon--compare-16"></span>
                                                            </button> -->



                                                        </div>



                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php

                                    }
                                    ?>
                                <?php } ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="quickview-modal mt-3" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content"></div>
    </div>
</div>


<div class="modal fade" id="modal-boutique" tabindex="-1" role="dialog" aria-labelledby="modal-boutique" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header" style="text-align: left;">
                <h2 class="modal-title style_color" id="pxpSigninModal" style="float: left;">Panier</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div style="clear: both;"></div>
            </div>
            <div class="modal-body" style="text-align: left;">
                <div id="modal-boutique-retour"></div>
            </div>
        </div>
    </div>
</div>