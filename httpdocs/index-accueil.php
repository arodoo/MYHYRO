<script>
    $(document).ready(function() {
        $(document).on("click", "#commander", function() {
            const url = document.getElementById('url').value;
            const datas = {
                url: url
            }
            $.post({
                url: '/function/redirect-command.php',
                type: 'POST',
                data: datas,
                success: function(res) {
                    res = JSON.parse(res);

                    if (res.retour_validation == "ok") {
                        setTimeout(() => {
                            document.location.href = res.retour_lien;
                        }, 1500)
                    } else {
                        popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                    }
                }
            });
        })
    });
</script>



<!-- .block-slideshow -->
<div class="block-slideshow block-slideshow--layout--full block" style="margin-top: 10px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="block-slideshow__body">
                    <div class="owl-carousel">
                        <a class="block-slideshow__slide" href="/Abonnements">
                            <div class="block-slideshow__slide-image block-slideshow__slide-image--desktop" style="background-image: url('/images/my-hyro-banner1.png'); background-size: cover; background-position: center right; border-radius:7px"></div>
                            <div class="block-slideshow__slide-content w-100" style="left: 0;">
                                <h1 class="block-slideshow__slide-title text-center" style="color: #232E3F;">Plateforme<br> e-commerce Hyro</h1>
                                <div class="block-slideshow__slide-text text-center">Des services avec des achats personnalisés en ligne.</div>
                                <div class="block-slideshow__slide-text text-center">Un service 100% sécurisé et simple de fonctionnement.</div>
                                <div class="block-slideshow__slide-text text-center">Une assistance à votre écoute.</div>
                                <div class="block-slideshow__slide-button w-100 text-center">
                                    <span class="btn btn-primary btn-lg">Abonnements</span>
                                </div>
                            </div>
                        </a>

                        <a class="block-slideshow__slide" href="/Abonnements">
                            <div class="block-slideshow__slide-image block-slideshow__slide-image--desktop" style="background-image: url('/images/my-hyro-banner2.png'); background-size: cover; background-position: center right; border-radius:7px"></div>
                            <div class="block-slideshow__slide-content w-100">
                                <h1 class="block-slideshow__slide-title" style="color: #232E3F;"></h1>
                                <div class="block-slideshow__slide-text">Des services avec des achats personnalisés en ligne.</div>
                                <div class="block-slideshow__slide-text">Un service 100% sécurisé et simple de fonctionnement.</div>
                                <div class="block-slideshow__slide-text">Une assistance à votre écoute.</div>
                                <div class="block-slideshow__slide-button">
                                    <span class="btn btn-primary btn-lg">Abonnements</span>
                                </div>
                            </div>
                        </a>

                        <a class="block-slideshow__slide" href="/Abonnements">
                            <div class="block-slideshow__slide-image block-slideshow__slide-image--desktop" style="background-image: url('/images/my-hyro-banner3.png'); background-size: cover; background-position: center right; border-radius:7px"></div>
                            <div class="block-slideshow__slide-content w-100">
                                <h1 class="block-slideshow__slide-title" style="color: #232E3F;">Plateforme<br> e-commerce Hyro</h1>
                                <div class="block-slideshow__slide-text">Des services avec des achats personnalisés en ligne.</div>
                                <div class="block-slideshow__slide-text">Un service 100% sécurisé et simple de fonctionnement.</div>
                                <div class="block-slideshow__slide-text">Une assistance à votre écoute.</div>
                                <div class="block-slideshow__slide-button">
                                    <span class="btn btn-primary btn-lg">Abonnements</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- .block-slideshow / end -->


<div class="block block-features block-features--layout--classic">
    <div class="container">
        <div class="block-features__list">
            <div class="block-features__item">
                <div class="block-features__icon">
                    <svg width="48px" height="48px">
                        <use xlink:href="/template2/black/images/sprite.svg#fi-free-delivery-48"></use>
                    </svg>
                </div>
                <div class="block-features__content">
                    <div class="block-features__title">Transport sécurié</div>
                    <div class="block-features__subtitle">Suivi personnalisé</div>
                </div>
            </div>
            <div class="block-features__divider"></div>
            <div class="block-features__item">
                <div class="block-features__icon">
                    <svg width="48px" height="48px">
                        <use xlink:href="/template2/black/images/sprite.svg#fi-24-hours-48"></use>
                    </svg>
                </div>
                <div class="block-features__content">
                    <div class="block-features__title">Support 24/7</div>
                    <div class="block-features__subtitle">Assistance privilégiée</div>
                </div>
            </div>
            <div class="block-features__divider"></div>
            <div class="block-features__item">
                <div class="block-features__icon">
                    <svg width="48px" height="48px">
                        <use xlink:href="/template2/black/images/sprite.svg#fi-payment-security-48"></use>
                    </svg>
                </div>
                <div class="block-features__content">
                    <div class="block-features__title">100% sécurisé</div>
                    <div class="block-features__subtitle">Paiements sont sécurisés</div>
                </div>
            </div>
            <div class="block-features__divider"></div>
            <div class="block-features__item">
                <div class="block-features__icon">
                    <svg width="48px" height="48px">
                        <use xlink:href="/template2/black/images/sprite.svg#fi-tag-48"></use>
                    </svg>
                </div>
                <div class="block-features__content">
                    <div class="block-features__title">Bons plans</div>
                    <div class="block-features__subtitle">Bons plans et réduction</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- .block-features -->
<div class="block block-features block-features--layout--boxed" style="margin-top: 40px;">
    <div class="container" style="padding-right: 24px;">
        <div class="block-header">
            <h3 class="block-header__title text-uppercase">Fonctionnement</h3>
            <div class="block-header__divider"></div>
        </div>

        <div class="block-products__body" style="min-height: 285px;">


            <div class="block-products__list-item background-color1" style="width: 100%; max-height: 285px;; border-radius: 10px;">
                <div class="product-card product-card--hidden-actions background-color1" style="border-radius: 10px;">
                    <div class="product-card__badges-list"></div>
                    <div class="product-card__image product-image">
                        <div class="product-card__badge product-card__badge--new" style="width: 70px; text-align: center;">Etape 1</div>
                        <div class="block-features__content">
                            <div class="block-features__title text-uppercase" style="text-align: center; margin-bottom: 10px;letter-spacing: 2px; color: #9e681a;"><i class="fa fa-link mr-2" style="font-size: 18px"></i>Lien d'achat</div>
                            <hr style="background: #fff;">
                            <div class="block-features__subtitle" style="font-weight: bold; font-size: 20px; text-align: center;">
                                Copie les liens et tes articles sur le site de ton choix</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-products__list-item background-color2" style="width: 100%; max-height: 285px;; border-radius: 10px;">
                <div class="product-card product-card--hidden-actions background-color2" style="border-radius: 10px;">
                    <div class="product-card__badges-list"></div>
                    <div class="product-card__image product-image">
                        <div class="product-card__badge product-card__badge--hot " style="width: 70px; text-align: center;">Etape 2</div>
                        <div class="block-features__content">
                            <div class="block-features__title text-uppercase" style="text-align: center; margin-bottom: 10px; letter-spacing: 2px; color: #7c6a22;"><i class="uk-icon-shopping-cart mr-2" style="font-size: 22px"></i>Panier</div>
                            <hr style="background: #fff;">
                            <div class="block-features__subtitle" style="font-weight: bold; font-size: 20px; text-align: center;">Colle les liens sur my-hyro et renseigne les prix, couleurs et tailles si nécessaire</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-products__list-item background-color3" style="width: 100%; max-height: 285px;; border-radius: 10px;">
                <div class="product-card product-card--hidden-actions background-color3" style="border-radius: 10px;">
                    <div class="product-card__badges-list"></div>
                    <div class="product-card__image product-image">
                        <div class="product-card__badge product-card__badge--sale" style="width: 70px; text-align: center;">Etape 3</div>
                        <div class="block-features__content">
                            <div class="block-features__title text-uppercase" style="text-align: center; margin-bottom: 10px; letter-spacing: 2px; color: #fddb74cc"><i class="fa fa-credit-card mr-2" style="font-size: 19px"></i>Paiement</div>
                            <hr style="background: #fff;">
                            <div class="block-features__subtitle" style="font-weight: bold; font-size: 20px; text-align: center;">Paie et suis l'évolution de ta commande sur my-hyro. Recois tes produits chez toi</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-products__list-item d-md-none d-lg-block" style="width: 100%; height: 285px;">
                <div class="product-card product-card--hidden-actions">
                    <div class="product-card__badges-list">
                    </div>
                    <div class="product-card__image product-image">
                        <img src="/images/my-pro-service.jpeg" alt="my-pro-service.jpeg" style="width: 90%;">
                    </div>
                </div>
            </div>

        </div>
        <div class="mt-3 commande-accueil"><i class="fa fa-hand-point-down mr-2" style="color: #ffc733"></i> Test en collant le lien de ton article ! <i class="fa fa-hand-point-down ml-2" style="color: #ffc733"></i></div>
        <div class="block-header mt-3 form-commande-accueil">
            <input id="url" class="col-md-8 col-sm-12 mb-2 form-control form-lien" style="border-radius: 10px" placeholder="http://www..." type="text" name="url" />
            <button id="commander" class="w-100 mb-2 btn btn-primary mb-0" style="border-radius: 10px">Commander</button>
        </div>
    </div>
</div>
<!-- .block-features / end -->

<div class="container" style="margin-bottom: 60px;">

    <div class="block-header" style="margin-bottom: 0px;">
        <h3 class="block-header__title text-uppercase">Nos plans</h3>
        <div class="block-header__divider"></div>
    </div>

    <div class="w-100 text-center mt-3"><a href="/Abonnements" class="btn-border-bottom text-uppercase">Comparer</a></div>

    <div class="row justify-content-center">
        <div class="col-lg-3 col-md-4">
            <div class="card flex-grow-1 mb-0 mt-5" style="min-height: 312px;">
                <div class="card-abonnement ">
                    <div class="card-title-abo bg-electric1 text-center">

                        <h2 style="color: #0a6f70;"> <?php if ($Abonnement_id == 1) {
                                                            echo "<span class='uk-icon-check' ></span> ";
                                                        } ?>
                            Aucun abonnement</h2>
                        <h3 class="text-white">One shot</h3>
                    </div>
                    <p class="mb-5 pt-2" style="text-align: center; padding: 0px 25px;">
                        Des tarifs proposés au prix du marché <br>
                    </p>
                    <div class="bg-electric1 abo-price py-3">0 FCFA <span style="font-size: 16px; color: #0a6f70;"> / An</span></div>

                </div>
            </div>
            <div class="pt-3">
                <button type="submit" style="border-radius: 20px;" class="btn text-white bg-electric1 btn-block text-uppercase <?php if (!empty($user)) {
                                                                                                                                    echo "commande";
                                                                                                                                } else {
                                                                                                                                    echo "pxp-header-user";
                                                                                                                                } ?>"> <?php if ($Abonnement_id == 1) {
                                                                                                                                            echo "<span class='' ></span> ";
                                                                                                                                        } ?> Sélectionner</button>
            </div>
        </div>

        <div class="col-lg-3 col-md-4">
            <div class="card flex-grow-1 mb-0 mt-5">
                <div class="card-abonnement ">
                    <div class="card-title-abo bg-electric2 text-center">
                        <h2 style="color: #007267;"><?php if ($Abonnement_id == 2) {
                                                        echo "<span class='uk-icon-check' ></span> ";
                                                    } ?> Abonnement</h2>
                        <h3 class="text-white">Hyro Standard</h3>
                    </div>
                    <p class="mb-4 pt-2" style="text-align: center; padding: 0px 25px;">
                        <span style="font-weight: bold">Accès illimité sans frais supplémentaires</span> à des prix adaptés pour tous
                    </p>
                    <div class="bg-electric2 abo-price py-3">19 900 FCFA <span style="font-size: 16px; color: #007267;"> / An</span></div>

                </div>
            </div>
            <div class="pt-3">
                <button type="submit" style="border-radius: 20px;" class="btn text-white bg-electric2 btn-block text-uppercase <?php if (!empty($user)) {
                                                                                                                                    echo "commande";
                                                                                                                                } else {
                                                                                                                                    echo "pxp-header-user";
                                                                                                                                } ?> "> <?php if ($Abonnement_id == 2) {
                                                                                                                                            echo "<span class='' ></span> ";
                                                                                                                                        } ?> Sélectionner</button>
            </div>
        </div>


        <div class="col-lg-3 col-md-4">

            <div class="card flex-grow-1 mb-0 mt-5">
                <div class="card-abonnement">
                    <img src="/images/suivi-personnalise.png" alt="" style="width: 134px; height: 100px; top: -48px;right: 44px;position: absolute;">
                    <div class="card-title-abo bg-electric3 text-center">
                        <h2 style="color: #ab0812;"><?php if ($Abonnement_id == 3) {
                                                        echo "<span class='uk-icon-check' ></span> ";
                                                    } ?>Abonnement</h2>
                        <h3 class="text-white">Hyro Prémium</h3>
                    </div>
                    <p class="mb-4 pt-2" style="text-align: center; padding: 0px 25px;">
                        <span style="font-weight: bold">Accès illimité</span> avec services et <span style="font-weight: bold">suivis personnalisés</span> pour répondre à tous vos besoins
                    </p>
                    <div class="bg-electric3 abo-price py-3">49 900 FCFA <span style="font-size: 16px; color: #ab0812;"> / An</span></div>

                </div>
            </div>
            <div class="pt-3">
                <button type="submit" style="border-radius: 20px;" class="btn text-white bg-electric3 btn-block text-uppercase <?php if (!empty($user)) {
                                                                                                                                    echo "commande";
                                                                                                                                } else {
                                                                                                                                    echo "pxp-header-user";
                                                                                                                                } ?>"> <?php if ($Abonnement_id == 3) {
                                                                                                                                            echo "<span class='' ></span> ";
                                                                                                                                        } ?> Sélectionner</button>
            </div>
        </div>

        <!-- <div class="col-lg-3 col-md-3">
            <div class="card flex-grow-1 mb-0 mt-5">
                <div class="card-body">
                    <img src="/images/suivi.jpg" alt="Suivi" style="width: 100%; max-width: 150px;">
                </div>
            </div>
        </div> -->

    </div>

</div>


<!-- .block-banner -->
<div class="block block-banner">
    <div class="container">
        <a href="/Comment-ca-marche" class="block-banner__body">
            <div class="block-banner__image block-banner__image--desktop" style="background-image: url('/template2/black/images/banners/economie.jpg')"></div>
            <div class="block-banner__image block-banner__image--mobile" style="background-image: url('/template2/black/images/banners/economie-mobile.jpg')"></div>
            <div class="block-banner__title"> Economisez !! Plus de transfert d'argent coûteux, <br class="block-banner__mobile-br">zéro frais de douane</div>
            <div class="block-banner__text">Commandez vous même, de chez vous, et choisissez de faire livrer<br /> vos articles en France chez un de vos proches susceptible de vous les apporter.</div>
        </a>
    </div>
</div>
<!-- .block-banner / end -->
<?php
$req_boucle = $bdd->prepare("SELECT * FROM `configurations_references_produits` ORDER BY `configurations_references_produits`.`id` ASC LIMIT 7");
$req_boucle->execute();

$ids = array();
$nomsProduits = array();
$prix = array();
$stocks = array();
$refProduitsHyro = array();
$descriptions = array();
$urls = array();
$titles = array();
$metaDescriptions = array();
$activerActiver = array();
$metaKeywords = array();
$liens = array();
$dates = array();
$idCategories = array();
$photos = array(); // Ajoutez le tableau pour les photos

while ($produit = $req_boucle->fetch(PDO::FETCH_ASSOC)) {
    $idd = $produit['id'];
    $nomproduit = $produit['nom_produit'];
    $prixProduit = $produit['prix'];
    $stockProduit = $produit['stock'];
    $refProduitHyro = $produit['ref_produit_hyro'];
    $descriptionProduit = $produit['description'];
    $urlProduit = $produit['url'];
    $titleProduit = $produit['title'];
    $metaDescriptionProduit = $produit['meta_description'];
    $activerActiverProduit = $produit['Activer'];
    $metaKeywordProduit = $produit['meta_keyword'];
    $lienProduit = $produit['lien_chez_un_marchand'];
    $dateProduit = $produit['date_ajout'];
    $idCategorieProduit = $produit['id_categorie'];
    $photoProduit = $produit['photo'];

    $ids[] = $idd;
    $nomsProduits[] = $nomproduit;
    $prix[] = $prixProduit;
    $stocks[] = $stockProduit;
    $refProduitsHyro[] = $refProduitHyro;
    $descriptions[] = $descriptionProduit;
    $urls[] = $urlProduit;
    $titles[] = $titleProduit;
    $metaDescriptions[] = $metaDescriptionProduit;
    $activerActiver[] = $activerActiverProduit;
    $metaKeywords[] = $metaKeywordProduit;
    $liens[] = $lienProduit;
    $dates[] = $dateProduit;
    $idCategories[] = $idCategorieProduit;
    $photos[] = $photoProduit; // Stockez les photos dans le tableau
}

$deuxiemeId = $ids[1];
$deuxiemeNomProduit = $nomsProduits[1];
$deuxiemePrix = $prix[1];
$deuxiemeStock = $stocks[1];
$deuxiemeRefProduitHyro = $refProduitsHyro[1];
$deuxiemeDescription = $descriptions[1];
$deuxiemeUrl = $urls[1];
$deuxiemeTitle = $titles[1];
$deuxiemeMetaDescription = $metaDescriptions[1];
$deuxiemeActiverActiver = $activerActiver[1];
$deuxiemeMetaKeyword = $metaKeywords[1];
$deuxiemeLien = $liens[1];
$deuxiemeDate = $dates[1];
$deuxiemeIdCategorie = $idCategories[1];
$deuxiemePhotos = $photos[1];


$troisiemeId = $ids[2];
$troisiemeNomProduit = $nomsProduits[2];
$troisiemePrix = $prix[2];
$troisiemeStock = $stocks[2];
$troisiemeRefProduitHyro = $refProduitsHyro[2];
$troisiemeDescription = $descriptions[2];
$troisiemeUrl = $urls[2];
$troisiemeTitle = $titles[2];
$troisiemeMetaDescription = $metaDescriptions[2];
$troisiemeActiverActiver = $activerActiver[2];
$troisiemeMetaKeyword = $metaKeywords[2];
$troisiemeLien = $liens[2];
$troisiemeDate = $dates[2];
$troisiemeIdCategorie = $idCategories[2];
$troisiemePhotos = $photos[2];


$quatriemeId = $ids[3];
$quatriemeNomProduit = $nomsProduits[3];
$quatriemePrix = $prix[3];
$quatriemeStock = $stocks[3];
$quatriemeRefProduitHyro = $refProduitsHyro[3];
$quatriemeDescription = $descriptions[3];
$quatriemeUrl = $urls[3];
$quatriemeTitle = $titles[3];
$quatriemeMetaDescription = $metaDescriptions[3];
$quatriemeActiverActiver = $activerActiver[3];
$quatriemeMetaKeyword = $metaKeywords[3];
$quatriemeLien = $liens[3];
$quatriemeDate = $dates[3];
$quatriemeIdCategorie = $idCategories[3];
$quatriemePhotos = $photos[3];


$cinquiemeId = $ids[4];
$cinquiemeNomProduit = $nomsProduits[4];
$cinquiemePrix = $prix[4];
$cinquiemeStock = $stocks[4];
$cinquiemeRefProduitHyro = $refProduitsHyro[4];
$cinquiemeDescription = $descriptions[4];
$cinquiemeUrl = $urls[4];
$cinquiemeTitle = $titles[4];
$cinquiemeMetaDescription = $metaDescriptions[4];
$cinquiemeActiverActiver = $activerActiver[4];
$cinquiemeMetaKeyword = $metaKeywords[4];
$cinquiemeLien = $liens[4];
$cinquiemeDate = $dates[4];
$cinquiemeIdCategorie = $idCategories[4];
$cinquiemePhotos = $photos[4];

$sixiemeId = $ids[5];
$sixiemeNomProduit = $nomsProduits[5];
$sixiemePrix = $prix[5];
$sixiemeStock = $stocks[5];
$sixiemeRefProduitHyro = $refProduitsHyro[5];
$sixiemeDescription = $descriptions[5];
$sixiemeUrl = $urls[5];
$sixiemeTitle = $titles[5];
$sixiemeMetaDescription = $metaDescriptions[5];
$sixiemeActiverActiver = $activerActiver[5];
$sixiemeMetaKeyword = $metaKeywords[5];
$sixiemeLien = $liens[5];
$sixiemeDate = $dates[5];
$sixiemeIdCategorie = $idCategories[5];
$sixiemePhotos = $photos[5];

$septiemeId = $ids[6];
$septiemeNomProduit = $nomsProduits[6];
$septiemePrix = $prix[6];
$septiemeStock = $stocks[6];
$septiemeRefProduitHyro = $refProduitsHyro[6];
$septiemeDescription = $descriptions[6];
$septiemeUrl = $urls[6];
$septiemeTitle = $titles[6];
$septiemeMetaDescription = $metaDescriptions[6];
$septiemeActiverActiver = $activerActiver[6];
$septiemeMetaKeyword = $metaKeywords[6];
$septiemeLien = $liens[6];
$septiemeDate = $dates[6];
$septiemeIdCategorie = $idCategories[6];
$septiemePhotos = $photos[6];
?>

<div id="ventes" class="block block-products block-products--layout--large-first" data-mobile-grid-columns="2">
    <div class="container">
        <div class="block-header">
            <h3 class="block-header__title text-uppercase">Meilleurs ventes</h3>
            <div class="block-header__divider"></div>
        </div>
        <div class="block-products__body">
            <div class="block-products__featured">
                <div class="block-products__featured-item">
                    <div class="product-card product-card--hidden-actions ">
                        <div class="product-card__image product-image">
                            <a href="product.html" class="product-image__body">
                                <img class="product-image__img" src='<?php echo $photoProduit; ?>' alt="" width="700" height="700">
                            </a>
                        </div>
                        <div class="product-card__info">
                            <div class="product-card__name">
                                <a href="product.html"><?php echo $nomproduit ?></a>
                            </div>
                            <div class="product-card__rating">
                                <div class="product-card__rating-stars">
                                    <div class="rating">
                                        <div class="rating__body">

                                            <div class="rating__star rating__star--only-edge rating__star--active">
                                                <div class="rating__fill">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                                <div class="rating__stroke">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                            </div>

                                            <div class="rating__star rating__star--only-edge rating__star--active">
                                                <div class="rating__fill">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                                <div class="rating__stroke">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                            </div>

                                            <div class="rating__star rating__star--only-edge rating__star--active">
                                                <div class="rating__fill">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                                <div class="rating__stroke">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                            </div>

                                            <div class="rating__star rating__star--only-edge rating__star--active">
                                                <div class="rating__fill">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                                <div class="rating__stroke">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                            </div>

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
                            <ul class="product-card__features-list">
                                <li>Speed: 750 RPM</li>
                                <li>Power Source: Cordless-Electric</li>
                                <li>Battery Cell Type: Lithium</li>
                                <li>Voltage: 20 Volts</li>
                                <li>Battery Capacity: 2 Ah</li>
                            </ul>
                        </div>
                        <div class="product-card__actions">
                            <div class="product-card__availability">
                                Availability: <span class="text-success">In Stock</span>
                            </div>
                            <div class="product-card__prices">
                                <?php echo $prixProduit ?>
                            </div>
                            <div class="product-card__buttons">
                                <button class="btn btn-primary product-card__addtocart" type="button">Ajouter</button>
                                <button class="btn btn-secondary product-card__addtocart product-card__addtocart--list" type="button">Ajouter</button>
                                <button class="btn btn-light btn-svg-icon btn-svg-icon--fake-svg product-card__wishlist" type="button">

                                    <span class="fake-svg-icon fake-svg-icon--wishlist-16"></span>
                                </button>
                                <button class="btn btn-light btn-svg-icon btn-svg-icon--fake-svg product-card__compare" type="button">

                                    <span class="fake-svg-icon fake-svg-icon--compare-16"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-products__list">
                <div class="block-products__list-item">
                    <div class="product-card product-card--hidden-actions ">
                        <div class="product-card__image product-image">
                            <a href="product.html" class="product-image__body">
                                <img class="product-image__img" src='<?php echo $deuxiemePhotos; ?>' alt="" width="700" height="700">
                            </a>
                        </div>
                        <div class="product-card__info">
                            <div class="product-card__name">
                                <a href="product.html"><?php echo $deuxiemeNomProduit ?></a>
                            </div>
                            <div class="product-card__rating">
                                <div class="product-card__rating-stars">
                                    <div class="rating">
                                        <div class="rating__body">

                                            <div class="rating__star rating__star--only-edge rating__star--active">
                                                <div class="rating__fill">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                                <div class="rating__stroke">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                            </div>

                                            <div class="rating__star rating__star--only-edge rating__star--active">
                                                <div class="rating__fill">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                                <div class="rating__stroke">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                            </div>

                                            <div class="rating__star rating__star--only-edge rating__star--active">
                                                <div class="rating__fill">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                                <div class="rating__stroke">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                            </div>

                                            <div class="rating__star rating__star--only-edge rating__star--active">
                                                <div class="rating__fill">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                                <div class="rating__stroke">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                            </div>

                                            <div class="rating__star rating__star--only-edge rating__star--active">
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
                            <ul class="product-card__features-list">
                                <li>Speed: 750 RPM</li>
                                <li>Power Source: Cordless-Electric</li>
                                <li>Battery Cell Type: Lithium</li>
                                <li>Voltage: 20 Volts</li>
                                <li>Battery Capacity: 2 Ah</li>
                            </ul>
                        </div>
                        <div class="product-card__actions">
                            <div class="product-card__availability">
                                Availability: <span class="text-success">In Stock</span>
                            </div>
                            <div class="product-card__prices">
                                <a><?php echo $deuxiemePrix ?> F Cfa</a>
                            </div>
                            <div class="product-card__buttons">
                                <button class="btn btn-primary product-card__addtocart" type="button">Ajouter</button>
                                <button class="btn btn-secondary product-card__addtocart product-card__addtocart--list" type="button">Ajouter</button>
                                <button class="btn btn-light btn-svg-icon btn-svg-icon--fake-svg product-card__wishlist" type="button">

                                    <span class="fake-svg-icon fake-svg-icon--wishlist-16"></span>
                                </button>
                                <button class="btn btn-light btn-svg-icon btn-svg-icon--fake-svg product-card__compare" type="button">

                                    <span class="fake-svg-icon fake-svg-icon--compare-16"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block-products__list-item">
                    <div class="product-card product-card--hidden-actions ">
                        <div class="product-card__image product-image">
                            <a href="product.html" class="product-image__body">
                                <img class="product-image__img" src='<?php echo $troisiemePhotos; ?>' alt="" width="700" height="700">
                            </a>
                        </div>
                        <div class="product-card__info">
                            <div class="product-card__name">
                                <a href="product.html"><?php echo $troisiemeNomProduit ?></a>
                            </div>
                            <div class="product-card__rating">
                                <div class="product-card__rating-stars">
                                    <div class="rating">
                                        <div class="rating__body">

                                            <div class="rating__star rating__star--only-edge rating__star--active">
                                                <div class="rating__fill">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                                <div class="rating__stroke">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                            </div>

                                            <div class="rating__star rating__star--only-edge rating__star--active">
                                                <div class="rating__fill">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                                <div class="rating__stroke">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                            </div>

                                            <div class="rating__star rating__star--only-edge rating__star--active">
                                                <div class="rating__fill">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                                <div class="rating__stroke">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                            </div>

                                            <div class="rating__star rating__star--only-edge rating__star--active">
                                                <div class="rating__fill">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                                <div class="rating__stroke">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                            </div>

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
                            <ul class="product-card__features-list">
                                <li>Speed: 750 RPM</li>
                                <li>Power Source: Cordless-Electric</li>
                                <li>Battery Cell Type: Lithium</li>
                                <li>Voltage: 20 Volts</li>
                                <li>Battery Capacity: 2 Ah</li>
                            </ul>
                        </div>
                        <div class="product-card__actions">
                            <div class="product-card__availability">
                                Availability: <span class="text-success">In Stock</span>
                            </div>
                            <div class="product-card__prices">
                                <?php echo $troisiemePrix ?>F Cfa
                            </div>
                            <div class="product-card__buttons">
                                <button class="btn btn-primary product-card__addtocart" type="button">Ajouter</button>
                                <button class="btn btn-secondary product-card__addtocart product-card__addtocart--list" type="button">Ajouter</button>
                                <button class="btn btn-light btn-svg-icon btn-svg-icon--fake-svg product-card__wishlist" type="button">
                                    <span class="fake-svg-icon fake-svg-icon--wishlist-16"></span>
                                </button>
                                <button class="btn btn-light btn-svg-icon btn-svg-icon--fake-svg product-card__compare" type="button">
                                    <span class="fake-svg-icon fake-svg-icon--compare-16"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block-products__list-item">
                    <div class="product-card product-card--hidden-actions ">
                        <div class="product-card__image product-image">
                            <a href="product.html" class="product-image__body">
                                <img class="product-image__img" src='<?php echo $quatriemePhotos; ?>' alt="" width="700" height="700">
                            </a>
                        </div>
                        <div class="product-card__info">
                            <div class="product-card__name">
                                <a href="product.html"><?php echo $quatriemeNomProduit ?></a>
                            </div>
                            <div class="product-card__rating">
                                <div class="product-card__rating-stars">
                                    <div class="rating">
                                        <div class="rating__body">

                                            <div class="rating__star rating__star--only-edge rating__star--active">
                                                <div class="rating__fill">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                                <div class="rating__stroke">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                            </div>

                                            <div class="rating__star rating__star--only-edge rating__star--active">
                                                <div class="rating__fill">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                                <div class="rating__stroke">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                            </div>

                                            <div class="rating__star rating__star--only-edge rating__star--active">
                                                <div class="rating__fill">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                                <div class="rating__stroke">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                            </div>

                                            <div class="rating__star rating__star--only-edge ">
                                                <div class="rating__fill">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                                <div class="rating__stroke">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                            </div>

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
                            <ul class="product-card__features-list">
                                <li>Speed: 750 RPM</li>
                                <li>Power Source: Cordless-Electric</li>
                                <li>Battery Cell Type: Lithium</li>
                                <li>Voltage: 20 Volts</li>
                                <li>Battery Capacity: 2 Ah</li>
                            </ul>
                        </div>
                        <div class="product-card__actions">
                            <div class="product-card__availability">
                                Availability: <span class="text-success">In Stock</span>
                            </div>
                            <div class="product-card__prices">
                                <?php echo $quatriemePrix ?>F Cfa
                                <span class="product-card__old-price">237.00F Cfa</span>
                            </div>
                            <div class="product-card__buttons">
                                <button class="btn btn-primary product-card__addtocart" type="button">Ajouter</button>
                                <button class="btn btn-secondary product-card__addtocart product-card__addtocart--list" type="button">Ajouter</button>
                                <button class="btn btn-light btn-svg-icon btn-svg-icon--fake-svg product-card__wishlist" type="button">
                                    <span class="fake-svg-icon fake-svg-icon--compare-16"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block-products__list-item">
                    <div class="product-card product-card--hidden-actions ">
                        <div class="product-card__image product-image">
                            <a href="product.html" class="product-image__body">
                                <img class="product-image__img" src='<?php echo $cinquiemePhotos; ?>' alt="" width="700" height="700">
                            </a>
                        </div>
                        <div class="product-card__info">
                            <div class="product-card__name">
                                <a href="product.html"><?php echo $cinquiemeNomProduit ?></a>
                            </div>
                            <div class="product-card__rating">
                                <div class="product-card__rating-stars">
                                    <div class="rating">
                                        <div class="rating__body">

                                            <div class="rating__star rating__star--only-edge rating__star--active">
                                                <div class="rating__fill">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                                <div class="rating__stroke">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                            </div>

                                            <div class="rating__star rating__star--only-edge rating__star--active">
                                                <div class="rating__fill">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                                <div class="rating__stroke">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                            </div>

                                            <div class="rating__star rating__star--only-edge rating__star--active">
                                                <div class="rating__fill">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                                <div class="rating__stroke">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                            </div>

                                            <div class="rating__star rating__star--only-edge rating__star--active">
                                                <div class="rating__fill">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                                <div class="rating__stroke">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                            </div>

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
                            <ul class="product-card__features-list">
                                <li>Speed: 750 RPM</li>
                                <li>Power Source: Cordless-Electric</li>
                                <li>Battery Cell Type: Lithium</li>
                                <li>Voltage: 20 Volts</li>
                                <li>Battery Capacity: 2 Ah</li>
                            </ul>
                        </div>
                        <div class="product-card__actions">
                            <div class="product-card__availability">
                                Availability: <span class="text-success">In Stock</span>
                            </div>
                            <div class="product-card__prices">
                                <?php echo $cinquiemePrix ?>F Cfa
                            </div>
                            <div class="product-card__buttons">
                                <button class="btn btn-primary product-card__addtocart" type="button">Ajouter</button>
                                <button class="btn btn-secondary product-card__addtocart product-card__addtocart--list" type="button">Ajouter</button>
                                <button class="btn btn-light btn-svg-icon btn-svg-icon--fake-svg product-card__wishlist" type="button">

                                    <span class="fake-svg-icon fake-svg-icon--compare-16"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block-products__list-item">
                    <div class="product-card product-card--hidden-actions ">
                        <div class="product-card__image product-image">
                            <a href="product.html" class="product-image__body">
                                <img class="product-image__img" src='<?php echo $sixiemePhotos; ?>' alt="" width="700" height="700">
                            </a>
                        </div>
                        <div class="product-card__info">
                            <div class="product-card__name">
                                <a href="product.html"><?php echo $sixiemeNomProduit ?></a>
                            </div>
                            <div class="product-card__rating">
                                <div class="product-card__rating-stars">
                                    <div class="rating">
                                        <div class="rating__body">

                                            <div class="rating__star rating__star--only-edge rating__star--active">
                                                <div class="rating__fill">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                                <div class="rating__stroke">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                            </div>

                                            <div class="rating__star rating__star--only-edge rating__star--active">
                                                <div class="rating__fill">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                                <div class="rating__stroke">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                            </div>

                                            <div class="rating__star rating__star--only-edge rating__star--active">
                                                <div class="rating__fill">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                                <div class="rating__stroke">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                            </div>

                                            <div class="rating__star rating__star--only-edge ">
                                                <div class="rating__fill">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                                <div class="rating__stroke">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                            </div>

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
                            <ul class="product-card__features-list">
                                <li>Speed: 750 RPM</li>
                                <li>Power Source: Cordless-Electric</li>
                                <li>Battery Cell Type: Lithium</li>
                                <li>Voltage: 20 Volts</li>
                                <li>Battery Capacity: 2 Ah</li>
                            </ul>
                        </div>
                        <div class="product-card__actions">
                            <div class="product-card__availability">
                                Availability: <span class="text-success">In Stock</span>
                            </div>
                            <div class="product-card__prices">
                                <?php echo $sixiemePrix ?>F Cfa
                            </div>
                            <div class="product-card__buttons">
                                <button class="btn btn-primary product-card__addtocart" type="button">Ajouter</button>
                                <button class="btn btn-secondary product-card__addtocart product-card__addtocart--list" type="button">Ajouter</button>
                                <button class="btn btn-light btn-svg-icon btn-svg-icon--fake-svg product-card__wishlist" type="button">

                                    <span class="fake-svg-icon fake-svg-icon--wishlist-16"></span>
                                </button>
                                <button class="btn btn-light btn-svg-icon btn-svg-icon--fake-svg product-card__compare" type="button">

                                    <span class="fake-svg-icon fake-svg-icon--compare-16"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block-products__list-item">
                    <div class="product-card product-card--hidden-actions ">
                        <div class="product-card__image product-image">
                            <a href="product.html" class="product-image__body">
                                <img class="product-image__img" src='<?php echo $sixiemePhotos; ?>' alt="" width="700" height="700">
                            </a>
                        </div>
                        <div class="product-card__info">
                            <div class="product-card__name">
                                <a href="product.html"><?php echo $septiemeNomProduit ?></a>
                            </div>
                            <div class="product-card__rating">
                                <div class="product-card__rating-stars">
                                    <div class="rating">
                                        <div class="rating__body">

                                            <div class="rating__star rating__star--only-edge rating__star--active">
                                                <div class="rating__fill">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                                <div class="rating__stroke">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                            </div>

                                            <div class="rating__star rating__star--only-edge rating__star--active">
                                                <div class="rating__fill">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                                <div class="rating__stroke">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                            </div>

                                            <div class="rating__star rating__star--only-edge ">
                                                <div class="rating__fill">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                                <div class="rating__stroke">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                            </div>

                                            <div class="rating__star rating__star--only-edge ">
                                                <div class="rating__fill">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                                <div class="rating__stroke">
                                                    <div class="fake-svg-icon"></div>
                                                </div>
                                            </div>

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
                            <ul class="product-card__features-list">
                                <li>Speed: 750 RPM</li>
                                <li>Power Source: Cordless-Electric</li>
                                <li>Battery Cell Type: Lithium</li>
                                <li>Voltage: 20 Volts</li>
                                <li>Battery Capacity: 2 Ah</li>
                            </ul>
                        </div>
                        <div class="product-card__actions">
                            <div class="product-card__availability">
                                Availability: <span class="text-success">In Stock</span>
                            </div>
                            <div class="product-card__prices">
                                <?php echo $septiemePrix ?>F Cfa
                            </div>
                            <div class="product-card__buttons">
                                <button class="btn btn-primary product-card__addtocart" type="button">Ajouter</button>
                                <button class="btn btn-secondary product-card__addtocart product-card__addtocart--list" type="button">Ajouter</button>
                                <button class="btn btn-light btn-svg-icon btn-svg-icon--fake-svg product-card__wishlist" type="button">

                                    <span class="fake-svg-icon fake-svg-icon--wishlist-16"></span>
                                </button>
                                <button class="btn btn-light btn-svg-icon btn-svg-icon--fake-svg product-card__compare" type="button">
                                    <span class="fake-svg-icon fake-svg-icon--compare-16"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .item-carrusel {
        margin: 0 auto;
    }


    #ventes-carousel {
        position: relative;
        width: 100%;
        overflow: hidden;
    }

    .ventes-carousel-track-container {
        display: flex;
        justify-content: center;
    }

    .ventes-carousel-track {
        display: flex;
        transition: transform 0.5s ease;
    }

    .ventes-carousel-item {
        min-width: 100%;
        box-sizing: border-box;
        text-align: center;
        max-width: 120px;
        padding: 40px;
        padding-bottom: 0;
    }

    .ventes-carousel-item-info {
        padding: 10px;
    }


    .ventes-carousel-control {
        position: absolute;
        top: 50%;
        background-color: rgba(0, 0, 0, 0.5);
        color: white;
        border: none;
        cursor: pointer;
        padding: 10px;
    }

    .ventes-carousel-control-prev {
        left: 10px;
    }

    .ventes-carousel-control-next {
        right: 10px;
    }


    .ventes-carousel-indicators {
        text-align: center;
        margin-top: 10px;
    }

    .ventes-dot {
        display: inline-block;
        width: 10px;
        height: 10px;
        margin: 0 5px;
        background-color: #ccc;
        border-radius: 50%;
        cursor: pointer;
    }

    .ventes-dot.active {
        background-color: #333;
    }

    #ventes {
        display: block;
    }

    #ventes-carousel {
        display: none;
    }

    @media screen and (max-width: 768px) {
        #ventes {
            display: none;
        }

        #ventes-carousel {
            display: block;
        }
    }
</style>
<script>

</script>

<!-- Carrusel mobile -->
<div id="ventes-carousel" class="ventes-carousel">
    <div class="container">
        <div class="block-header">
            <h3 class="block-header__title text-uppercase">Meilleurs ventes</h3>
            <div class="block-header__divider"></div>
        </div>
        <div class="ventes-carousel-track-container">
            <div class="ventes-carousel-track">

                <div class="ventes-carousel-item">
                    <div class="block-products__list-item item-carrusel ">
                        <div class="product-card product-card--hidden-actions">
                            <div class="product-card__image product-image">
                                <a href="product.html" class="product-image__body">
                                    <img class="product-image__img" src="<?php echo $photoProduit; ?>" alt="" width="700" height="700">
                                </a>
                            </div>
                            <div class="product-card__info">
                                <div class="product-card__name">
                                    <a href="product.html"><?php echo $nomproduit; ?></a>
                                </div>
                                <div class="product-card__rating">
                                    <div class="product-card__rating-stars">
                                        <div class="rating">
                                            <div class="rating__body">
                                                <!-- Estrellas de calificación -->
                                                <div class="rating__star rating__star--only-edge rating__star--active">
                                                    <div class="rating__fill">
                                                        <div class="fake-svg-icon"></div>
                                                    </div>
                                                    <div class="rating__stroke">
                                                        <div class="fake-svg-icon"></div>
                                                    </div>
                                                </div>
                                                <!-- Puedes agregar más estrellas según sea necesario -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <ul class="product-card__features-list">
                                    <li>Speed: 750 RPM</li>
                                    <li>Power Source: Cordless-Electric</li>
                                    <li>Battery Cell Type: Lithium</li>
                                    <li>Voltage: 20 Volts</li>
                                    <li>Battery Capacity: 2 Ah</li>
                                </ul>
                            </div>
                            <div class="product-card__actions">
                                <div class="product-card__availability">
                                    Availability: <span class="text-success">In Stock</span>
                                </div>
                                <div class="product-card__prices">
                                    <?php echo $prixProduit; ?>
                                </div>
                                <div class="product-card__buttons">
                                    <button class="btn btn-primary product-card__addtocart" type="button">Ajouter</button>
                                    <button class="btn btn-secondary product-card__addtocart product-card__addtocart--list" type="button">Ajouter</button>
                                    <button class="btn btn-light btn-svg-icon btn-svg-icon--fake-svg product-card__wishlist" type="button">
                                        <span class="fake-svg-icon fake-svg-icon--wishlist-16"></span>
                                    </button>
                                    <button class="btn btn-light btn-svg-icon btn-svg-icon--fake-svg product-card__compare" type="button">
                                        <span class="fake-svg-icon fake-svg-icon--compare-16"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="ventes-carousel-item">
                    <div class="block-products__list-item item-carrusel">
                        <div class="product-card product-card--hidden-actions">
                            <div class="product-card__image product-image">
                                <a href="product.html" class="product-image__body">
                                    <img class="product-image__img" src="<?php echo $deuxiemePhotos; ?>" alt="" width="700" height="700">
                                </a>
                            </div>
                            <div class="product-card__info">
                                <div class="product-card__name">
                                    <a href="product.html"><?php echo $deuxiemeNomProduit; ?></a>
                                </div>
                                <div class="product-card__rating">
                                    <div class="product-card__rating-stars">
                                        <div class="rating">
                                            <div class="rating__body">
                                                <!-- Estrellas dinámicas de calificación -->
                                                <div class="rating__star rating__star--only-edge rating__star--active">
                                                    <div class="rating__fill">
                                                        <div class="fake-svg-icon"></div>
                                                    </div>
                                                    <div class="rating__stroke">
                                                        <div class="fake-svg-icon"></div>
                                                    </div>
                                                </div>
                                                <!-- Repite este bloque para más estrellas -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <ul class="product-card__features-list">
                                    <li>Speed: 750 RPM</li>
                                    <li>Power Source: Cordless-Electric</li>
                                    <li>Battery Cell Type: Lithium</li>
                                    <li>Voltage: 20 Volts</li>
                                    <li>Battery Capacity: 2 Ah</li>
                                </ul>
                            </div>
                            <div class="product-card__actions">
                                <div class="product-card__availability">
                                    Availability: <span class="text-success">In Stock</span>
                                </div>
                                <div class="product-card__prices">
                                    <a><?php echo $deuxiemePrix; ?> F Cfa</a>
                                </div>
                                <div class="product-card__buttons">
                                    <button class="btn btn-primary product-card__addtocart" type="button">Ajouter</button>
                                    <button class="btn btn-secondary product-card__addtocart product-card__addtocart--list" type="button">Ajouter</button>
                                    <button class="btn btn-light btn-svg-icon btn-svg-icon--fake-svg product-card__wishlist" type="button">

                                        <span class="fake-svg-icon fake-svg-icon--wishlist-16"></span>
                                    </button>
                                    <button class="btn btn-light btn-svg-icon btn-svg-icon--fake-svg product-card__compare" type="button">

                                        <span class="fake-svg-icon fake-svg-icon--compare-16"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ventes-carousel-item">
                    <div class="block-products__list-item item-carrusel">
                        <div class="product-card product-card--hidden-actions">
                            <div class="product-card__image product-image">
                                <a href="product.html" class="product-image__body">
                                    <img class="product-image__img" src="<?php echo $troisiemePhotos; ?>" alt="" width="700" height="700">
                                </a>
                            </div>
                            <div class="product-card__info">
                                <div class="product-card__name">
                                    <a href="product.html"><?php echo $troisiemeNomProduit; ?></a>
                                </div>
                                <div class="product-card__rating">
                                    <div class="product-card__rating-stars">
                                        <div class="rating">
                                            <div class="rating__body">
                                                <!-- Estrellas dinámicas de calificación -->
                                                <div class="rating__star rating__star--only-edge rating__star--active">
                                                    <div class="rating__fill">
                                                        <div class="fake-svg-icon"></div>
                                                    </div>
                                                    <div class="rating__stroke">
                                                        <div class="fake-svg-icon"></div>
                                                    </div>
                                                </div>
                                                <!-- Repite este bloque para más estrellas -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <ul class="product-card__features-list">
                                    <li>Speed: 750 RPM</li>
                                    <li>Power Source: Cordless-Electric</li>
                                    <li>Battery Cell Type: Lithium</li>
                                    <li>Voltage: 20 Volts</li>
                                    <li>Battery Capacity: 2 Ah</li>
                                </ul>
                            </div>
                            <div class="product-card__actions">
                                <div class="product-card__availability">
                                    Availability: <span class="text-success">In Stock</span>
                                </div>
                                <div class="product-card__prices">
                                    <?php echo $troisiemePrix; ?>F Cfa
                                </div>
                                <div class="product-card__buttons">
                                    <button class="btn btn-primary product-card__addtocart" type="button">Ajouter</button>
                                    <button class="btn btn-secondary product-card__addtocart product-card__addtocart--list" type="button">Ajouter</button>
                                    <button class="btn btn-light btn-svg-icon btn-svg-icon--fake-svg product-card__wishlist" type="button">
                                        <span class="fake-svg-icon fake-svg-icon--wishlist-16"></span>
                                    </button>
                                    <button class="btn btn-light btn-svg-icon btn-svg-icon--fake-svg product-card__compare" type="button">
                                        <span class="fake-svg-icon fake-svg-icon--compare-16"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ventes-carousel-item">
                    <div class="block-products__list-item item-carrusel">
                        <div class="product-card product-card--hidden-actions">
                            <div class="product-card__image product-image">
                                <a href="product.html" class="product-image__body">
                                    <img class="product-image__img" src="<?php echo $quatriemePhotos; ?>" alt="" width="700" height="700">
                                </a>
                            </div>
                            <div class="product-card__info">
                                <div class="product-card__name">
                                    <a href="product.html"><?php echo $quatriemeNomProduit; ?></a>
                                </div>
                                <div class="product-card__rating">
                                    <div class="product-card__rating-stars">
                                        <div class="rating">
                                            <div class="rating__body">
                                                <!-- Estrellas dinámicas de calificación -->
                                                <div class="rating__star rating__star--only-edge rating__star--active">
                                                    <div class="rating__fill">
                                                        <div class="fake-svg-icon"></div>
                                                    </div>
                                                    <div class="rating__stroke">
                                                        <div class="fake-svg-icon"></div>
                                                    </div>
                                                </div>
                                                <!-- Repite este bloque para más estrellas -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <ul class="product-card__features-list">
                                    <li>Speed: 750 RPM</li>
                                    <li>Power Source: Cordless-Electric</li>
                                    <li>Battery Cell Type: Lithium</li>
                                    <li>Voltage: 20 Volts</li>
                                    <li>Battery Capacity: 2 Ah</li>
                                </ul>
                            </div>
                            <div class="product-card__actions">
                                <div class="product-card__availability">
                                    Availability: <span class="text-success">In Stock</span>
                                </div>
                                <div class="product-card__prices">
                                    <?php echo $quatriemePrix; ?>F Cfa
                                    <span class="product-card__old-price">237.00F Cfa</span>
                                </div>
                                <div class="product-card__buttons">
                                    <button class="btn btn-primary product-card__addtocart" type="button">Ajouter</button>
                                    <button class="btn btn-secondary product-card__addtocart product-card__addtocart--list" type="button">Ajouter</button>
                                    <button class="btn btn-light btn-svg-icon btn-svg-icon--fake-svg product-card__wishlist" type="button">
                                        <span class="fake-svg-icon fake-svg-icon--wishlist-16"></span>
                                    </button>
                                    <button class="btn btn-light btn-svg-icon btn-svg-icon--fake-svg product-card__compare" type="button">
                                        <span class="fake-svg-icon fake-svg-icon--compare-16"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="ventes-carousel-item">
                    <div class="block-products__list-item item-carrusel">
                        <div class="product-card product-card--hidden-actions">
                            <div class="product-card__image product-image">
                                <a href="product.html" class="product-image__body">
                                    <img class="product-image__img" src="<?php echo $cinquiemePhotos; ?>" alt="" width="700" height="700">
                                </a>
                            </div>
                            <div class="product-card__info">
                                <div class="product-card__name">
                                    <a href="product.html"><?php echo $cinquiemeNomProduit; ?></a>
                                </div>
                                <div class="product-card__rating">
                                    <div class="product-card__rating-stars">
                                        <div class="rating">
                                            <div class="rating__body">
                                                <!-- Estrellas de calificación -->
                                                <div class="rating__star rating__star--only-edge rating__star--active">
                                                    <div class="rating__fill">
                                                        <div class="fake-svg-icon"></div>
                                                    </div>
                                                    <div class="rating__stroke">
                                                        <div class="fake-svg-icon"></div>
                                                    </div>
                                                </div>
                                                <!-- Más estrellas si es necesario -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <ul class="product-card__features-list">
                                    <li>Speed: 750 RPM</li>
                                    <li>Power Source: Cordless-Electric</li>
                                    <li>Battery Cell Type: Lithium</li>
                                    <li>Voltage: 20 Volts</li>
                                    <li>Battery Capacity: 2 Ah</li>
                                </ul>
                            </div>
                            <div class="product-card__actions">
                                <div class="product-card__availability">
                                    Availability: <span class="text-success">In Stock</span>
                                </div>
                                <div class="product-card__prices">
                                    <?php echo $cinquiemePrix; ?>F Cfa
                                </div>
                                <div class="product-card__buttons">
                                    <button class="btn btn-primary product-card__addtocart" type="button">Ajouter</button>
                                    <button class="btn btn-secondary product-card__addtocart product-card__addtocart--list" type="button">Ajouter</button>
                                    <button class="btn btn-light btn-svg-icon btn-svg-icon--fake-svg product-card__wishlist" type="button">
                                        <span class="fake-svg-icon fake-svg-icon--wishlist-16"></span>
                                    </button>
                                    <button class="btn btn-light btn-svg-icon btn-svg-icon--fake-svg product-card__compare" type="button">
                                        <span class="fake-svg-icon fake-svg-icon--compare-16"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ventes-carousel-item">
                    <div class="block-products__list-item item-carrusel">
                        <div class="product-card product-card--hidden-actions">
                            <div class="product-card__image product-image">
                                <a href="product.html" class="product-image__body">
                                    <img class="product-image__img" src="<?php echo $sixiemePhotos; ?>" alt="" width="700" height="700">
                                </a>
                            </div>
                            <div class="product-card__info">
                                <div class="product-card__name">
                                    <a href="product.html"><?php echo $sixiemeNomProduit; ?></a>
                                </div>
                                <div class="product-card__rating">
                                    <div class="product-card__rating-stars">
                                        <div class="rating">
                                            <div class="rating__body">
                                                <!-- Estrellas de calificación -->
                                                <div class="rating__star rating__star--only-edge rating__star--active">
                                                    <div class="rating__fill">
                                                        <div class="fake-svg-icon"></div>
                                                    </div>
                                                    <div class="rating__stroke">
                                                        <div class="fake-svg-icon"></div>
                                                    </div>
                                                </div>
                                                <!-- Más estrellas si es necesario -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <ul class="product-card__features-list">
                                    <li>Speed: 750 RPM</li>
                                    <li>Power Source: Cordless-Electric</li>
                                    <li>Battery Cell Type: Lithium</li>
                                    <li>Voltage: 20 Volts</li>
                                    <li>Battery Capacity: 2 Ah</li>
                                </ul>
                            </div>
                            <div class="product-card__actions">
                                <div class="product-card__availability">
                                    Availability: <span class="text-success">In Stock</span>
                                </div>
                                <div class="product-card__prices">
                                    <?php echo $sixiemePrix; ?>F Cfa
                                </div>
                                <div class="product-card__buttons">
                                    <button class="btn btn-primary product-card__addtocart" type="button">Ajouter</button>
                                    <button class="btn btn-secondary product-card__addtocart product-card__addtocart--list" type="button">Ajouter</button>
                                    <button class="btn btn-light btn-svg-icon btn-svg-icon--fake-svg product-card__wishlist" type="button">
                                        <span class="fake-svg-icon fake-svg-icon--wishlist-16"></span>
                                    </button>
                                    <button class="btn btn-light btn-svg-icon btn-svg-icon--fake-svg product-card__compare" type="button">
                                        <span class="fake-svg-icon fake-svg-icon--compare-16"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="ventes-carousel-item">
                    <div class="block-products__list-item item-carrusel">
                        <div class="product-card product-card--hidden-actions">
                            <div class="product-card__image product-image">
                                <a href="product.html" class="product-image__body">
                                    <img class="product-image__img" src="<?php echo $sixiemePhotos; ?>" alt="" width="700" height="700">
                                </a>
                            </div>
                            <div class="product-card__info">
                                <div class="product-card__name">
                                    <a href="product.html"><?php echo $septiemeNomProduit; ?></a>
                                </div>
                                <div class="product-card__rating">
                                    <div class="product-card__rating-stars">
                                        <div class="rating">
                                            <div class="rating__body">

                                                <div class="rating__star rating__star--only-edge rating__star--active">
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
                                <ul class="product-card__features-list">
                                    <li>Speed: 750 RPM</li>
                                    <li>Power Source: Cordless-Electric</li>
                                    <li>Battery Cell Type: Lithium</li>
                                    <li>Voltage: 20 Volts</li>
                                    <li>Battery Capacity: 2 Ah</li>
                                </ul>
                            </div>
                            <div class="product-card__actions">
                                <div class="product-card__availability">
                                    Availability: <span class="text-success">In Stock</span>
                                </div>
                                <div class="product-card__prices">
                                    <?php echo $septiemePrix; ?>F Cfa
                                </div>
                                <div class="product-card__buttons">
                                    <button class="btn btn-primary product-card__addtocart" type="button">Ajouter</button>
                                    <button class="btn btn-secondary product-card__addtocart product-card__addtocart--list" type="button">Ajouter</button>
                                    <button class="btn btn-light btn-svg-icon btn-svg-icon--fake-svg product-card__wishlist" type="button">
                                        <span class="fake-svg-icon fake-svg-icon--wishlist-16"></span>
                                    </button>
                                    <button class="btn btn-light btn-svg-icon btn-svg-icon--fake-svg product-card__compare" type="button">
                                        <span class="fake-svg-icon fake-svg-icon--compare-16"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <button class="ventes-carousel-control ventes-carousel-control-prev">❮</button>
        <button class="ventes-carousel-control ventes-carousel-control-next">❯</button>

        <div class="ventes-carousel-indicators">
            <span class="ventes-dot" data-index="0"></span>
            <span class="ventes-dot" data-index="1"></span>
            <span class="ventes-dot" data-index="2"></span>
            <span class="ventes-dot" data-index="3"></span>
            <span class="ventes-dot" data-index="4"></span>
            <span class="ventes-dot" data-index="5"></span>
            <span class="ventes-dot" data-index="6"></span>
        </div>
    </div>



</div>
<!-- Carrusel mobile -->



<!-- .block-banner -->
<div class="block block-banner">
    <div class="container">
        <a href="/Suivi-personnalise" class="block-banner__body">
            <div class="block-banner__image block-banner__image--desktop" style="background-image: url('/template2/black/images/banners/suivi-perso.jpg')"></div>
            <div class="block-banner__image block-banner__image--mobile" style="background-image: url('/template2/black/images/banners/suivi-perso-mobile.jpg')"></div>
            <div class="block-banner__title"> Suivi <br class="block-banner__mobile-br">personnalisé</div>
            <div class="block-banner__text">Facilité de paiement et solution adaptée</div>
            <div class="block-banner__button">
                <span class="btn btn-sm btn-primary">Suivi personnalisé</span>
            </div>
        </a>
    </div>
</div>
<!-- .block-banner / end -->

<!-- .block-categories visible -->
<div id="desktopContent" class="block block--highlighted block-categories block-categories--layout--compact visible-desktop">
    <div class="container">
        <div class="block-header">
            <h3 class="block-header__title">Hyro et vous</h3>
            <div class="block-header__divider"></div>
        </div>

        <div id="" class="block-categories__list row">

            <div class="block-categories__item category-card col-xs-12 colsm-4 col-md-4" style="margin: 0px; margin-bottom: 10px;">
                <div class="category-card__body">
                    <div class="category-card__content" style="text-align: center; width: 100%;">
                        <div class="product-card__badge product-card__badge--hot" style="width: 50px; text-align: center;">Hot</div>
                        <div class="category-card__name">
                            Liste de souhaits
                        </div>
                        <ul class="category-card__links" style="display: block;">
                            <li>Dîtes ce que vous acheter</li>
                            <li>Nous prospections pour vous</li>
                            <li>Payer et suivez votre commande</li>
                            <li></li>
                        </ul>
                        <img src="/template2/black/images/banners/colis.png" style="width: 100%; max-width: 200px; display: inline-block; margin: auto;">
                    </div>
                </div>
            </div>

            <div class="block-categories__item category-card col-xs-12 colsm-4 col-md-4" style="margin: 0px; margin-bottom: 10px;">
                <div class="category-card__body">
                    <div class="category-card__content" style="text-align: center; width: 100%;">
                        <div class="product-card__badge product-card__badge--hot" style="width: 50px; text-align: center;">Hot</div>
                        <div class="category-card__name">
                            Envoyer un colis
                        </div>
                        <ul class="category-card__links" style="display: block; height: auto;">
                            <li>Faîtes votre demande</li>
                            <li>Recevez le devis</li>
                            <li>Confiez nous votre colis</li>
                            <!-- <li>Suivez son expédition</li> -->
                        </ul>
                        <img src="/template2/black/images/banners/avion.jpg" style="width: 100%; max-width: 200px; display: inline-block; margin: auto;">
                    </div>
                </div>
            </div>

            <div class="block-categories__item category-card col-xs-12 colsm-4 col-md-4" style="margin: 0px; margin-bottom: 10px;">
                <div class="category-card__body">
                    <div class="category-card__content" style="text-align: center; width: 100%;">
                        <div class="product-card__badge product-card__badge--sale" style="width: 50px; text-align: center;">Sale</div>
                        <div class="category-card__name">
                            Agence Hyro
                        </div>
                        <ul class="category-card__links" style="display: block;">
                            <li>Des ordinateurs et tablettes</li>
                            <li>à votre disposition</li>
                            <li>pour passer commande</li>
                        </ul>
                        <img src="/template2/black/images/banners/ordi.png" style="width: 100%; max-width: 200px; display: inline-block; margin: auto;">
                    </div>
                </div>
            </div>

        </div>


    </div>
</div>
<!-- .block-categories / end -->


<!-- slider mobile ocult-->
<div id="mobileContent" class="block block--highlighted block-categories block-categories--layout--compact visible-mobile">

    <div class="container">

        <div class="block-header">
            <h3 class="block-header__title">Hyro et vous</h3>
            <div class="block-header__divider"></div>
        </div>

        <div class="slider">
            <div class="slider-track">

                <div class="slider-item">
                    <div class="category-card__body" style="height: 369px;">
                        <div class="category-card__content" style="text-align: center; width: 100%;">
                            <div class="product-card__badge product-card__badge--hot" style="width: 50px; text-align: center;">Hot</div>
                            <div class="category-card__name">Liste de souhaits</div>
                            <ul class="category-card__links" style="display: block;">
                                <li>Dîtes ce que vous acheter</li>
                                <li>Nous prospections pour vous</li>
                                <li>Payer et suivez votre commande</li>
                            </ul>
                            <img src="/template2/black/images/banners/colis.png" style="width: 100%; max-width: 200px; align-self: center;">
                        </div>
                    </div>
                </div>


                <div class="slider-item">
                    <div class="category-card__body" style="height: 369px;">
                        <div class="category-card__content" style="text-align: center; width: 100%;">
                            <div class="product-card__badge product-card__badge--hot" style="width: 50px; text-align: center;">Hot</div>
                            <div class="category-card__name">Envoyer un colis</div>
                            <ul class="category-card__links" style="display: block;">
                                <li>Faîtes votre demande</li>
                                <li>Recevez le devis</li>
                                <li>Confiez nous votre colis</li>
                            </ul>
                            <img src="/template2/black/images/banners/avion.jpg" style="width: 100%; max-width: 200px; align-self: center;">
                        </div>
                    </div>
                </div>

                <div class="slider-item">
                    <div class="category-card__body" style="height: 369px;">
                        <div class="category-card__content" style="text-align: center; width: 100%;">
                            <div class="product-card__badge product-card__badge--sale" style="width: 50px; text-align: center;">Sale</div>
                            <div class="category-card__name">Agence Hyro</div>
                            <ul class="category-card__links" style="display: block;">
                                <li>Des ordinateurs et tablettes</li>
                                <li>à votre disposition</li>
                                <li>pour passer commande</li>
                            </ul>
                            <img src="/template2/black/images/banners/ordi.png" style="width: 100%; max-width: 200px; align-self: center;">
                        </div>
                    </div>
                </div>
            </div>


            <button class="slider-prev">❮</button>
            <button class="slider-next">❯</button>

            <div class="carousel-indicators">
                <span class="dot" data-index="0"></span>
                <span class="dot" data-index="1"></span>
                <span class="dot" data-index="2"></span>
            </div>
        </div>
    </div>

</div>
<!-- end slide mobile -->



<!-- .block-banner -->
<div class="block block-banner">
    <div class="container">
        <a href="/Abonnements" class="block-banner__body">
            <div class="block-banner__image block-banner__image--desktop" style="background-image: url('/template2/black/images/banners/bons-achat.jpg')"></div>
            <div class="block-banner__image block-banner__image--mobile" style="background-image: url('/template2/black/images/banners/bons-achat-mobile.jpg')"></div>
            <div class="block-banner__title"> Bons d'achat <br class="block-banner__mobile-br">et des réductions</div>
            <div class="block-banner__text">Gagner toute l'année des bons d'achat et des réductions jusqu'à 60%</div>
            <div class="block-banner__button">
                <span class="btn btn-sm btn-primary">Informations</span>
            </div>
        </a>
    </div>
</div>
<!-- .block-banner / end -->

<!-- .block-categories -->
<div class="block block--highlighted block-categories block-categories--layout--compact">
    <div class="container">
        <div class="block-header">
            <h3 class="block-header__title">Sites populaires</h3>
            <div class="block-header__divider"></div>
        </div>

        <div class="block-categories__list row">

            <div class="block-categories__item category-card col-xs-12 colsm-4 col-md-4" style="margin: 0px; margin-bottom: 10px;">
                <div class="category-card__body">
                    <div class="category-card__content">
                        <div class="category-card__name">
                            Outils électroportatifs
                        </div>
                        <ul class="category-card__links" style="display: block;">
                            <li><a href="">Screwdrivers</a></li>
                            <li><a href="">Milling Cutters</a></li>
                            <li><a href="">Sanding Machines</a></li>
                            <li><a href="">Wrenches</a></li>
                            <li><a href="">Drills</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="block-categories__item category-card col-xs-12 colsm-4 col-md-4" style="margin: 0px; margin-bottom: 10px;">
                <div class="category-card__body">
                    <div class="category-card__content">
                        <div class="category-card__name">
                            Outils mains
                        </div>
                        <ul class="category-card__links" style="display: block;">
                            <li><a href="">Screwdrivers</a></li>
                            <li><a href="">Hammers</a></li>
                            <li><a href="">Spanners</a></li>
                            <li><a href="">Handsaws</a></li>
                            <li><a href="">Paint Tools</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="block-categories__item category-card col-xs-12 colsm-4 col-md-4" style="margin: 0px; margin-bottom: 10px;">
                <div class="category-card__body">
                    <div class="category-card__content">
                        <div class="category-card__name">
                            Machine outils
                        </div>
                        <ul class="category-card__links" style="display: block;">
                            <li><a href="">Lathes</a></li>
                            <li><a href="">Milling Machines</a></li>
                            <li><a href="">Grinding Machines</a></li>
                            <li><a href="">CNC Machines</a></li>
                            <li><a href="">Sharpening Machines</a></li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- .block-categories / end -->

<?php
$req_test_blog = $bdd->prepare("SELECT * FROM codi_one_blog WHERE activer=? AND type_blog_artciles=? ORDER BY date_blog DESC LIMIT 0,3");
$req_test_blog->execute(array("oui", "standard"));
if ($req_test_blog->fetch()) {
?>
    <!-- .block-posts -->
    <div class="block block-posts" data-layout="list" data-mobile-columns="1">
        <div class="container">
            <div class="block-header">
                <h3 class="block-header__title">Dernières news et tendances</h3>
                <div class="block-header__divider"></div>
                <div class="block-header__arrows-list">
                    <button class="block-header__arrow block-header__arrow--left" type="button">
                        <svg width="7px" height="11px">
                            <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-left-7x11"></use>
                        </svg>
                    </button>
                    <button class="block-header__arrow block-header__arrow--right" type="button">
                        <svg width="7px" height="11px">
                            <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-right-7x11"></use>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="block-posts__slider">
                <div class="owl-carousel">
                    <?php
                    ///////////////////////////////SELECT BOUCLE
                    $req_boucle = $bdd->prepare("SELECT * FROM codi_one_blog WHERE activer=? AND type_blog_artciles=? ORDER BY date_blog DESC LIMIT 0,10");
                    $req_boucle->execute(array("oui", "standard"));
                    while ($ligne_boucle = $req_boucle->fetch()) {
                        ///////////////////////////////SELECT
                        $req_select = $bdd->prepare("SELECT * FROM codi_one_blog_a_b_image WHERE id_page=?");
                        $req_select->execute(array($ligne_boucle['id']));
                        $ligne_select = $req_select->fetch();
                        $req_select->closeCursor();
                        $img_lienii = $ligne_select['img_lien2'];
                        //affichage date
                        $date_fiche = $ligne_boucle['date_blog'];
                        $jour = date('d', $date_fiche);
                        $mois = date('m', $date_fiche);
                        $annee = date('y', $date_fiche);
                        $b++;
                        $texte_article_blog_source = strip_tags($ligne_boucle['texte_article']);
                        $texte_article_blog_len = strlen($texte_article_blog_source);
                        $texte_article_blog = substr($texte_article_blog_source, "0", "100");
                        $texte_article_blog_texte = mb_substr($texte_article_blog_source, "0", 100 * 2);
                        if ($texte_article_blog_len > $limitation_texte_liste_blog_cfg && $type_blog_artciles_blog != "texte") {
                            $texte_article_blog = "$texte_article_blog ...";
                        } elseif ($texte_article_blog_len > ($limitation_texte_liste_blog_cfg * 2) && $type_blog_artciles_blog == "texte") {
                            $texte_article_blog = "$texte_article_blog_texte ...";
                        }
                    ?>

                        <div class="post-card ">
                            <div class="post-card__image">
                                <a href="/<?= $ligne_boucle['url_fiche_blog']; ?>">
                                    <img src="/images/blog/<?= $img_lienii; ?>" alt="">
                                </a>
                            </div>
                            <div class="post-card__info">
                                <div class="post-card__name">
                                    <a href="/<?= $ligne_boucle['url_fiche_blog']; ?>"><?= $ligne_boucle['titre_blog_1']; ?></a>
                                </div>
                                <div class="post-card__date"><?php echo "" . $jour . "-" . $mois . "-" . $annee . ""; ?></div>
                                <div class="post-card__content">
                                    <?php echo $texte_article_blog; ?>
                                </div>
                                <div class="post-card__read-more" style="display: block;">
                                    <a href="/<?= $ligne_boucle['url_fiche_blog']; ?>" class="btn btn-secondary btn-sm">Détails</a>
                                </div>
                            </div>
                        </div>

                    <?php
                    }
                    $req_boucle->closeCursor();
                    ?>
                </div>
            </div>
        </div>
    </div>

<?php } ?>

<script>
    $(document).ready(function() {
        $('.owl-carousel').owlCarousel({
            items: 1,
            autoplay: true, // Activer le défilement automatique
            autoplayTimeout: 5000,
            loop: true, // Activer la lecture en boucle
        });
    });
</script>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        const prevButton = document.querySelector('.slider-prev');
        const nextButton = document.querySelector('.slider-next');
        const sliderTrack = document.querySelector('.slider-track');
        const items = document.querySelectorAll('.slider-item');
        let currentIndex = 0;

        function showItem(index) {
            const itemWidth = items[0].clientWidth;
            sliderTrack.style.transform = `translateX(${-index * itemWidth}px)`;
        }

        prevButton.addEventListener('click', () => {
            currentIndex = (currentIndex > 0) ? currentIndex - 1 : items.length - 1;
            showItem(currentIndex);
        });

        nextButton.addEventListener('click', () => {
            currentIndex = (currentIndex < items.length - 1) ? currentIndex + 1 : 0;
            showItem(currentIndex);
        });


        window.addEventListener('resize', () => {
            showItem(currentIndex);
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const prevButton = document.querySelector('.slider-prev');
        const nextButton = document.querySelector('.slider-next');
        const sliderTrack = document.querySelector('.slider-track');
        const items = document.querySelectorAll('.slider-item');
        const dots = document.querySelectorAll('.dot');
        let currentIndex = 0;


        function showItem(index) {
            const itemWidth = items[0].clientWidth;
            sliderTrack.style.transform = `translateX(${-index * itemWidth}px)`;


            dots.forEach(dot => dot.classList.remove('active'));
            dots[index].classList.add('active');
        }


        prevButton.addEventListener('click', () => {
            currentIndex = (currentIndex > 0) ? currentIndex - 1 : items.length - 1;
            showItem(currentIndex);
        });


        nextButton.addEventListener('click', () => {
            currentIndex = (currentIndex < items.length - 1) ? currentIndex + 1 : 0;
            showItem(currentIndex);
        });


        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                currentIndex = index;
                showItem(currentIndex);
            });
        });


        window.addEventListener('resize', () => {
            showItem(currentIndex);
        });


        showItem(currentIndex);
    });


    /* Carrusel mobile */
    document.addEventListener('DOMContentLoaded', function() {
        const track = document.querySelector('.ventes-carousel-track');
        const slides = Array.from(track.children);
        const nextButton = document.querySelector('.ventes-carousel-control-next');
        const prevButton = document.querySelector('.ventes-carousel-control-prev');
        const dotsNav = document.querySelector('.ventes-carousel-indicators');
        const dots = Array.from(dotsNav.children);
        let currentIndex = 0;
        let startX = 0;
        let currentX = 0;
        let isDragging = false;

        function updateCarousel() {
            const slideWidth = slides[0].getBoundingClientRect().width;
            track.style.transform = `translateX(${ -slideWidth * currentIndex }px)`;
            dots.forEach(dot => dot.classList.remove('active'));
            dots[currentIndex].classList.add('active');
        }

        nextButton.addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % slides.length;
            updateCarousel();
        });

        prevButton.addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + slides.length) % slides.length;
            updateCarousel();
        });

        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                currentIndex = index;
                updateCarousel();
            });
        });

        // Touch and mouse events for swiping
        track.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
            isDragging = true;
        });

        track.addEventListener('touchmove', (e) => {
            if (!isDragging) return;
            currentX = e.touches[0].clientX;
            const deltaX = startX - currentX;

            // Only swipe when the difference is significant
            if (Math.abs(deltaX) > 50) {
                if (deltaX > 0 && currentIndex < slides.length - 1) {
                    currentIndex++;
                } else if (deltaX < 0 && currentIndex > 0) {
                    currentIndex--;
                }
                isDragging = false;
                updateCarousel();
            }
        });

        track.addEventListener('touchend', () => {
            isDragging = false;
        });

        track.addEventListener('mousedown', (e) => {
            startX = e.clientX;
            isDragging = true;
        });

        track.addEventListener('mousemove', (e) => {
            if (!isDragging) return;
            currentX = e.clientX;
            const deltaX = startX - currentX;

            if (Math.abs(deltaX) > 50) {
                if (deltaX > 0 && currentIndex < slides.length - 1) {
                    currentIndex++;
                } else if (deltaX < 0 && currentIndex > 0) {
                    currentIndex--;
                }
                isDragging = false;
                updateCarousel();
            }
        });

        track.addEventListener('mouseup', () => {
            isDragging = false;
        });

        track.addEventListener('mouseleave', () => {
            isDragging = false;
        });

        window.addEventListener('resize', updateCarousel);

        updateCarousel();
    });

    /* Carrusel mobile */



    /* Carrusel 
    Hyro et vous
     */
    document.addEventListener('DOMContentLoaded', function() {

        const sliderTrack = document.querySelector('.slider-track');
        const slides = Array.from(document.querySelectorAll('.slider-item'));
        const prevButton = document.querySelector('.slider-prev');
        const nextButton = document.querySelector('.slider-next');
        const dots = Array.from(document.querySelectorAll('.dot'));

        let currentIndex = 0;
        let slideWidth = slides[0].offsetWidth;


        let isDragging = false;
        let startPos = 0;
        let currentTranslate = 0;
        let prevTranslate = 0;
        let animationID = 0;
        let currentSlideIndex = 0;

        function setSliderPosition() {
            sliderTrack.style.transform = `translateX(${currentTranslate}px)`;
        }

        function updateDots(index) {
            dots.forEach(dot => dot.classList.remove('active'));
            if (dots[index]) {
                dots[index].classList.add('active');
            }
        }

        function goToSlide(index) {
            if (index < 0) index = 0;
            if (index >= slides.length) index = slides.length - 1;

            currentIndex = index;
            currentTranslate = -slideWidth * currentIndex;
            prevTranslate = currentTranslate;
            setSliderPosition();
            updateDots(currentIndex);
        }

        prevButton.addEventListener('click', () => {
            goToSlide(currentIndex - 1);
        });

        nextButton.addEventListener('click', () => {
            goToSlide(currentIndex + 1);
        });


        dots.forEach((dot, idx) => {
            dot.addEventListener('click', () => {
                goToSlide(idx);
            });
        });


        slides.forEach((slide, index) => {

            const img = slide.querySelector('img');
            if (img) {
                img.addEventListener('dragstart', (e) => e.preventDefault());
            }


            slide.addEventListener('touchstart', touchStart(index));
            slide.addEventListener('touchend', touchEnd);
            slide.addEventListener('touchmove', touchMove);


            slide.addEventListener('mousedown', touchStart(index));
            slide.addEventListener('mouseup', touchEnd);
            slide.addEventListener('mouseleave', touchEnd);
            slide.addEventListener('mousemove', touchMove);
        });

        window.addEventListener('resize', () => {
            slideWidth = slides[0].offsetWidth;
            goToSlide(currentIndex);
        });


        function touchStart(index) {
            return function(event) {
                isDragging = true;
                currentSlideIndex = index;
                startPos = getPositionX(event);
                animationID = requestAnimationFrame(animation);
                sliderTrack.classList.add('grabbing');
            };
        }

        function touchEnd() {
            isDragging = false;
            cancelAnimationFrame(animationID);


            const movedBy = currentTranslate - prevTranslate;


            if (movedBy < -50) {

                goToSlide(currentIndex + 1);
            } else if (movedBy > 50) {

                goToSlide(currentIndex - 1);
            } else {

                goToSlide(currentIndex);
            }

            sliderTrack.classList.remove('grabbing');
        }

        function touchMove(event) {
            if (isDragging) {
                const currentPosition = getPositionX(event);
                currentTranslate = prevTranslate + (currentPosition - startPos);
            }
        }

        function getPositionX(event) {
            return event.type.includes('mouse') ?
                event.pageX :
                event.touches[0].clientX;
        }

        function animation() {
            setSliderPosition();
            if (isDragging) requestAnimationFrame(animation);
        }


        goToSlide(currentIndex);
    });
</script>