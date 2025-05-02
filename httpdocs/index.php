<?php
ob_start();

////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('Configurations_bdd.php');
require_once('Configurations.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
include('function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

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

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <meta name="description" content="<?php echo str_replace('"', '', $Metas_description_page); ?>">
    <meta name="keywords" content="<?php echo str_replace('"', '', $Metas_mots_cles_page); ?>">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, width=device-width">

    <link rel="icon" type="image/png" href="/template2/black/images/Mfavi.png">
    <!-- fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,400i,500,500i,700,700i">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600&display=swap" rel="stylesheet">
    <!-- css -->
    <link rel="stylesheet" href="/template2/black/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/template2/black/vendor/owl-carousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="/template2/black/vendor/photoswipe/photoswipe.css">
    <link rel="stylesheet" href="/template2/black/vendor/photoswipe/default-skin/default-skin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/template2/black/vendor/select2/css/select2.min.css">
    <link rel="stylesheet" href="/template2/black/css/style.css?v=<?php echo time(); ?>">
    <!-- font - fontawesome -->
    <link rel="stylesheet" href="/template2/black/vendor/fontawesome/css/all.min.css">
    <!-- font - stroyka -->
    <link rel="stylesheet" href="/template2/black/fonts/stroyka/stroyka.css">

    <!-- liens pour éliminer l'erreur selectpicker -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script> -->
    <!-- liens pour éliminer l'erreur selectpicker -->



    <?php
    ////INCLUDE JS BAS CMS CODI ONE
    include('js/INCLUDE-JS-HAUT-CMS-CODI-ONE.php');

    echo "<title>$TitreTitrea_page</title>";

    ////GOOGLE ANALYTICS
    echo "$Google_analytic";
    ?>

</head>

<body>



    <script>
        /*   $(document).ready(function() {
            $('#searchForm-desktop').on('submit', function() {
            
                var formData = $(this).serialize();

                $.ajax({
                    type: 'POST',
                    url: '/Boutique',
                    data: formData,
                    dataType: 'json',
                });
            });
        }); */


        $(document).ready(function() {
            $('#searchForm-desktop').on('submit', function() {
                // Nous obtenons la valeur saisie dans le champ « recherche sur le bureau »
                var searchText = $('[name="search_desktop"]').val().trim();

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

                                setTimeout(function() {
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
                    // Nous renvoyons false pour annuler la soumission du formulaire lorsqu'une URL est saisie
                    return false;
                }

               // S'il ne s'agit pas d'une URL, le code d'origine est exécuté :
                var formData = $(this).serialize();

                $.ajax({
                    type: 'POST',
                    url: '/Boutique',
                    data: formData,
                    dataType: 'json',
                });
                
            });
        });
    </script>

    <!-- site -->
    <div class="site">

        <?php
        ////INCLUDE POP-UP HAUT CMS CODI ONE
        include('pop-up/INCLUDE-POP-UP-HAUT-CMS-CODI-ONE.php');
        ?>

        <?php
        ////HEADER
        include('index-header.php');
        ?>

        <!-- desktop site__header -->
        <header class="site__header d-lg-block d-none">
            <div class="site-header">

                <?php
                ////HEADER 2
                include('index-header2.php');
                ?>

                <div class="site-header__middle container">

                    <div class="site-header__logo">
                        <a href="/">
                            <img src="/images/logo header.png">
                        </a>
                    </div>

                    <div class="site-header__search">
                        <div class="search search--location--header">
                            <div class="search__body">
                                <form class="search__form" method="post" action="/Boutique" id="searchForm-desktop">
                                    <select class="search__categories" aria-label="Category" name="Category">
                                        <option value="all">Toutes Catégories</option>
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
                                        ?>
                                            <option value="<?php echo $url_categorie; ?>"><?php echo $nom_categorie; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <input class="search__input_desktop" name="search_desktop" placeholder="Recherchez un produit ou collez un lien d’article" aria-label="Site search" type="text" autocomplete="off">
                                    <button class="search__button search__button--type--submit" type="submit" name="submit" value="submit">
                                        <svg width="20px" height="20px">
                                            <use xlink:href="/template2/black/images/sprite.svg#search-20"></use>
                                        </svg>
                                    </button>
                                    <div class="search__border"></div>
                                </form>
                                <div class="search__suggestions suggestions suggestions--location--header"></div>
                            </div>
                        </div>
                    </div>
                    <div class="site-header__phone">
                        <div class="site-header__phone-title">Service client</div>
                        <div class="site-header__phone-number"><?php echo $telephone_fixe_ii; ?></div>
                    </div>

                </div>

                <div class="site-header__nav-panel">
                    <!-- data-sticky-mode - one of [pullToShow, alwaysOnTop] -->
                    <div class="nav-panel nav-panel--sticky" data-sticky-mode="pullToShow">
                        <div class="nav-panel__container container">
                            <div class="nav-panel__row">

                                <?php
                                ////MENU
                                include('index-header-menu.php');
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- desktop site__header / end -->

        <!-- site__body -->
        <div class="site__body">

            <?php

            /////////Fil d'ariane
            include('index-fil-ariane.php');

            ////////////////////On appelle la page demandée
            if ($p404_existe != "oui") {
                ////PAGE BANDEAU
                page_bandeaux();
                ////SWITCH DES PAGES
                if (isset($_GET['page'])) {
            ?> <div class="container"> <?php
                                        include('pages.php');
                                        ?> </div><?php
                                                } else {
                                                    include('pages.php');
                                                }
                                                ////SWITCH DES PAGES
                                            } elseif ($p404_existe == "oui") {
                                                include("function/404/404r.php");
                                            }
                                            ////////////////////On apelle la page demandée
                                                    ?>

        </div>
        <!-- site__body / end -->

        <?php
        ////FOOTER
        include('index-footer.php');
        ?>

    </div>
    <!-- site / end -->

    <!-- quickview-modal -->
    <div id="quickview-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content"></div>
        </div>
    </div>
    <!-- quickview-modal / end -->

    <?php
    include('index-menu-responsive.php');
    ?>

    <!-- js -->
    <script src="/template2/black/vendor/jquery/jquery.min.js"></script>
    <script src="/template2/black/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/template2/black/vendor/owl-carousel/owl.carousel.min.js"></script>
    <script src="/template2/black/vendor/nouislider/nouislider.min.js"></script>
    <script src="/template2/black/vendor/photoswipe/photoswipe.min.js"></script>
    <script src="/template2/black/vendor/photoswipe/photoswipe-ui-default.min.js"></script>
    <script src="/template2/black/vendor/select2/js/select2.min.js"></script>
    <script src="/template2/black/js/number.js"></script>
    <script src="/template2/black/js/main.js"></script>
    <script src="/template2/black/js/header.js?v=1"></script>
    <script src="/template2/black/vendor/svg4everybody/svg4everybody.min.js"></script>
    <script>
        svg4everybody();
    </script>

    <?php
    ////INCLUDE CSS BAS CMS CODI ONE
    include('css/INCLUDE-CSS-BAS-CMS-CODI-ONE.php');
    ////INCLUDE JS BAS CMS CODI ONE
    include('js/INCLUDE-JS-BAS-CMS-CODI-ONE.php');
    ////INCLUDE POP-UP BAS CMS CODI ONE
    include('pop-up/INCLUDE-POP-UP-BAS-CMS-CODI-ONE.php');
    ?>

</body>

</html>

<?php
ob_end_flush();
?>