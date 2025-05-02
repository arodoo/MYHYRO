<?php
define('BASE_PATH', $_SERVER['DOCUMENT_ROOT']);

require_once(BASE_PATH . '/Configurations_bdd.php');
require_once(BASE_PATH . '/Configurations.php');
require_once(BASE_PATH . '/Configurations_modules.php');


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $productId = htmlspecialchars($_POST['id']);
}


$query = "SELECT * FROM configurations_references_produits WHERE id = ?";
$stmt = $bdd->prepare($query);
$stmt->execute([$productId]);
$product = $stmt->fetch();

$idCategorie = $product['id_categorie'];


$req_categorie = $bdd->prepare("SELECT * FROM categories WHERE id=?");
$req_categorie->execute(array($idCategorie));
$categorie = $req_categorie->fetch(PDO::FETCH_ASSOC);
$nom_categorie = $categorie['nom_categorie'];


?>

<script>
 
    function ajoutPanier() {
       
        let quantite = 1;
        if (document.getElementById('product-quantity')) {
            quantite = document.getElementById('product-quantity').value ?? 1;
        }
    
        let id_produit = $("#ajouterPanierQuickview").attr('data-id');
        let id_commande = $("#ajouterPanierQuickview").attr('data-commande');

     
        var formData = new FormData();
        formData.append('idaction', id_produit);
        formData.append('idCommande', id_commande);
        formData.append('quantite', quantite);
        formData.append('action', 'addToCart');

        $.post({
            url: '/pages/Boutique/Boutique-action-ajouter-ajax.php',
            type: 'POST',
            data: formData,
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

    
    $(document).ready(function() {
        $(document).on("click", "#ajouterPanierQuickview", function() {
            ajoutPanier();
        });

        // Incrementar cantidad
        $(document).on("click", ".input-number__add", function() {
            let quantityInput = $(this).siblings('.input-number__input');
            let currentValue = parseInt(quantityInput.val());
            quantityInput.val(currentValue + 1);
        });

        // Decrementar cantidad
        $(document).on("click", ".input-number__sub", function() {
            let quantityInput = $(this).siblings('.input-number__input');
            let currentValue = parseInt(quantityInput.val());
            if (currentValue > 1) {
                quantityInput.val(currentValue - 1);
            }
        });
    });
</script>

<div class="quickview mt-3">
    <button class="quickview__close" type="button">
        <i class="fas fa-times"></i>
    </button>
    <div class="product product--layout--quickview" data-layout="quickview">
        <div class="product__content">
          
            <div class="product__gallery">
                <div class="product-gallery">
                    <div class="product-gallery__featured">
                        <button class="product-gallery__zoom">
                            <svg width="24px" height="24px">
                                <use xlink:href="images/sprite.svg#zoom-in-24"></use>
                            </svg>
                        </button>
                        <div class="product-image product-image--location--gallery">
                            <a href="<?= $product['photo']; ?>" data-width="700" data-height="700" class="product-image__body" target="_blank">
                                <img class="product-image__img" src="<?= $product['photo']; ?>" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
          
            <div class="product__info">
                <div class="product__wishlist-compare">
                    <button type="button" class="btn btn-sm btn-light btn-svg-icon" data-toggle="tooltip" data-placement="right" title="Wishlist">
                        <svg width="16px" height="16px">
                            <use xlink:href="images/sprite.svg#wishlist-16"></use>
                        </svg>
                    </button>
                    <button type="button" class="btn btn-sm btn-light btn-svg-icon" data-toggle="tooltip" data-placement="right" title="Compare">
                        <svg width="16px" height="16px">
                            <use xlink:href="images/sprite.svg#compare-16"></use>
                        </svg>
                    </button>
                </div>
                <h1 class="product__name"><?php echo $product['nom_produit']; ?></h1>
                <div class="product__rating">
                    <div class="product__rating-stars">
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
                             
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product__description">
                    <?php echo $product['description']; ?>
                </div>
                <ul class="product__meta">
                    <li class="product__meta-availability">Disponiblité:
                        <?php if ($product['stock'] > 0) { ?>
                            <span class="text-success">En Stock</span>
                        <?php } else { ?>
                            <span class="text-danger">En Rupture</span>
                        <?php } ?>
                    </li>
                    <li>Catégorie: <a href=""><?= $nom_categorie ?></a></li>
                </ul>
            </div>
         
            <div class="product__sidebar">
                <div class="product__availability">
                    Disponiblité:
                    <?php if ($product['stock'] > 0) { ?>
                        <span class="text-success">En Stock</span>
                    <?php } else { ?>
                        <span class="text-danger">En Rupture</span>
                    <?php } ?>
                </div>
                <div class="product__prices">
                    <?= $product['prix'] ?> F CFA
                </div>
              
                <form class="product__options">
                    <div class="form-group product__option">
                        <label class="product__option-label" for="product-quantity">Quantity</label>
                        <div class="product__actions">
                            <div class="product__actions-item">
                                <div class="input-number product__quantity">
                                    <input id="product-quantity" class="input-number__input form-control form-control-lg" type="number" min="1" value="1">
                                    <div class="input-number__add"></div>
                                    <div class="input-number__sub"></div>
                                </div>
                            </div>
                            <div class="product__actions-item product__actions-item--addtocart">
                              
                                <button onclick="event.preventDefault()" class="btn btn-primary btn-lg commande" 
                                    id="ajouterPanierQuickview" 
                                    data-id="<?php echo $product['id']; ?>" 
                                    data-commande="<?php echo (isset($id_commande)) ? $id_commande : ''; ?>">
                                    Ajouter au panier
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
          
        </div>
    </div>
</div>
