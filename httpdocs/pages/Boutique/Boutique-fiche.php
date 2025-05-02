<?php

$url_produit = $_GET['action'];
$req_boucle = $bdd->prepare("SELECT * FROM configurations_references_produits WHERE url_produit=?");
$req_boucle->execute(array($url_produit));
$produit = $req_boucle->fetch(PDO::FETCH_ASSOC);

// print_r($result);
if ($produit) {

	// print_r($produit);
	// $produit = $result;
	$idd = $produit['id'];
	$photo = $produit['photo'];
	$prix = $produit['prix'];
	$stock   = $produit['stock'];
	$nomproduit = $produit['nom_produit'];
	$refproduithyro = $produit['ref_produit_hyro'];
	$description = $produit['description'];
	$url = $produit['url'];
	$title = $produit['title'];
	$meta_description = $produit['meta_description'];
	$ActiverActiver = $produit['Activer'];
	$meta_keyword = $produit['meta_keyword'];
	$lien = $produit['lien_chez_un_marchand'];
	$date = $produit['date_ajout'];
	$idCategorie = $produit['id_categorie'];


	$req_categorie = $bdd->prepare("SELECT * FROM categories WHERE id=?");
	$req_categorie->execute(array($idCategorie));
	$categorie = $req_categorie->fetch(PDO::FETCH_ASSOC);

	$nom_categorie = $categorie['nom_categorie'];

?>
	<script>
		$(document).ready(function() {


			$(document).on("click", "#ajouterPanier", function() {

				quantite = 1
				if (document.getElementById('product-quantity')) {
					quantite = document.getElementById('product-quantity').value ?? 1
				}

				$.post({
					url: '/pages/Boutique/Boutique-action-ajouter-ajax.php',
					type: 'POST',
					data: {
						idaction: <?= $idd ?>,
						quantite: quantite,
					},
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


		});

		// $(document).ready(function() {


		// 	$(document).on("click", "#ajouterPanier", function() {

		// 		quantite = 1
		// 		if (document.getElementById('product-quantity')) {
		// 			quantite = document.getElementById('product-quantity').value ?? 1
		// 		}
		// 		let id_produit = <?= $idd ?>;

		// 		var formData = new FormData();
		// 		formData.append('idaction', id_produit);
		// 		formData.append('quantite', quantite);
		// 		formData.append('action', 'addToCart');

		// 		$.post({
		// 			url: '/pages/Boutique/Boutique-action-ajouter-ajax.php',
		// 			type: 'POST',
		// 			data: formData,
		// 			// data: {
		// 			//     idaction: $(this).attr('data-id'),
		// 			//     quantite: quantite,
		// 			// },
		// 			processData: false,
		// 			contentType: false,
		// 			dataType: "json",
		// 			success: function(res) {

		// 				if (res.retour_validation == "ok") {
		// 					popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
		// 				} else {
		// 					popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
		// 				}

		// 			}
		// 		});
		// 	});


		// });
	</script>



	<!-- site__body -->
	<div class="site__body">
		<!--div class="page-header">
                <div class="page-header__container container">
                    <div class="page-header__breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.html">Home</a>
                                    <svg class="breadcrumb-arrow" width="6px" height="9px">
                                        <use xlink:href="images/sprite.svg#arrow-rounded-right-6x9"></use>
                                    </svg>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="">Breadcrumb</a>
                                    <svg class="breadcrumb-arrow" width="6px" height="9px">
                                        <use xlink:href="images/sprite.svg#arrow-rounded-right-6x9"></use>
                                    </svg>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Brandix Screwdriver SCREW1500ACC</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div-->



		<div class="block">
			<div class="container">
				<div class="product product--layout--standard" data-layout="standard">
					<div class="product__content">
						<!-- .product__gallery -->
						<div class="product__gallery">
							<div class="product-gallery">
								<div class="product-gallery__featured">
									<button class="product-gallery__zoom">
										<svg width="24px" height="24px">
											<use xlink:href="images/sprite.svg#zoom-in-24"></use>
										</svg>
									</button>
									<div class="owl-carousel" id="product-image">
										<div class="product-image product-image--location--gallery">
											<!--
                                The data-width and data-height attributes must contain the size of a larger version
                                of the product image.

                                If you do not know the image size, you can remove the data-width and data-height
                                attribute, in which case the width and height will be obtained from the naturalWidth
                                and naturalHeight property of img.product-image__img.
                                -->
											<a href="<?= $photo ?>" data-width="700" data-height="700" class="product-image__body" target="_blank">
												<img class="product-image__img" src="<?= $photo ?>" alt="">
											</a>
										</div>
										<!-- <div class="product-image product-image--location--gallery"> -->
										<!--
                                The data-width and data-height attributes must contain the size of a larger version
                                of the product image.

                                If you do not know the image size, you can remove the data-width and data-height
                                attribute, in which case the width and height will be obtained from the naturalWidth
                                and naturalHeight property of img.product-image__img.
                                -->
										<!-- <a href="<?= $photo ?>" data-width="700" data-height="700" class="product-image__body" target="_blank">
                                                    <img class="product-image__img" src="<?= $photo ?>" alt="">
                                                </a>
                                            </div> -->
										<!-- <div class="product-image product-image--location--gallery"> -->
										<!--
                                The data-width and data-height attributes must contain the size of a larger version
                                of the product image.

                                If you do not know the image size, you can remove the data-width and data-height
                                attribute, in which case the width and height will be obtained from the naturalWidth
                                and naturalHeight property of img.product-image__img.
                                -->
										<!-- <a href="images/products/product-16-2.jpg" data-width="700" data-height="700" class="product-image__body" target="_blank">
                                                    <img class="product-image__img" src="images/products/product-16-2.jpg" alt="">
                                                </a>
                                            </div> -->
										<!-- <div class="product-image product-image--location--gallery"> -->
										<!--
                                The data-width and data-height attributes must contain the size of a larger version
                                of the product image.

                                If you do not know the image size, you can remove the data-width and data-height
                                attribute, in which case the width and height will be obtained from the naturalWidth
                                and naturalHeight property of img.product-image__img.
                                -->
										<!-- <a href="images/products/product-16-3.jpg" data-width="700" data-height="700" class="product-image__body" target="_blank">
                                                    <img class="product-image__img" src="images/products/product-16-3.jpg" alt="">
                                                </a>
                                            </div> -->
										<!-- <div class="product-image product-image--location--gallery"> -->
										<!--
                                The data-width and data-height attributes must contain the size of a larger version
                                of the product image.

                                If you do not know the image size, you can remove the data-width and data-height
                                attribute, in which case the width and height will be obtained from the naturalWidth
                                and naturalHeight property of img.product-image__img.
                                -->
										<!-- <a href="images/products/product-16-4.jpg" data-width="700" data-height="700" class="product-image__body" target="_blank">
                                                    <img class="product-image__img" src="images/products/product-16-4.jpg" alt="">
                                                </a>
                                            </div> -->
									</div>
								</div>
								<!-- <div class="product-gallery__carousel">
                                        <div class="owl-carousel" id="product-carousel">
                                            <a href="images/products/product-16.jpg" class="product-image product-gallery__carousel-item">
                                                <div class="product-image__body">
                                                    <img class="product-image__img product-gallery__carousel-image" src="images/products/product-16.jpg" alt="">
                                                </div>
                                            </a>
                                            <a href="images/products/product-16-1.jpg" class="product-image product-gallery__carousel-item">
                                                <div class="product-image__body">
                                                    <img class="product-image__img product-gallery__carousel-image" src="images/products/product-16-1.jpg" alt="">
                                                </div>
                                            </a>
                                            <a href="images/products/product-16-2.jpg" class="product-image product-gallery__carousel-item">
                                                <div class="product-image__body">
                                                    <img class="product-image__img product-gallery__carousel-image" src="images/products/product-16-2.jpg" alt="">
                                                </div>
                                            </a>
                                            <a href="images/products/product-16-3.jpg" class="product-image product-gallery__carousel-item">
                                                <div class="product-image__body">
                                                    <img class="product-image__img product-gallery__carousel-image" src="images/products/product-16-3.jpg" alt="">
                                                </div>
                                            </a>
                                            <a href="images/products/product-16-4.jpg" class="product-image product-gallery__carousel-item">
                                                <div class="product-image__body">
                                                    <img class="product-image__img product-gallery__carousel-image" src="images/products/product-16-4.jpg" alt="">
                                                </div>
                                            </a>
                                        </div>
                                    </div> -->
							</div>
						</div>
						<!-- .product__gallery / end -->
						<!-- .product__info -->
						<div class="product__info">
							<!-- <div class="product__wishlist-compare">
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
                                </div> -->
							<h1 class="product__name"> <?= $nomproduit ?></h1>
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
										</div>
									</div>
								</div>
								<!-- <div class="product__rating-legend">
                                        <a href="">7 Reviews</a><span>/</span><a href="">Write A Review</a>
                                    </div> -->
							</div>
							<div class="product__description">
								<?= $description ?>
							</div>
							<!-- <ul class="product__features">
                                    <li>Speed: 750 RPM</li>
                                    <li>Power Source: Cordless-Electric</li>
                                    <li>Battery Cell Type: Lithium</li>
                                    <li>Voltage: 20 Volts</li>
                                    <li>Battery Capacity: 2 Ah</li>
                                </ul> -->
							<ul class="product__meta">
								<li class="product__meta-availability">Disponiblité:
									<!-- <span class="text-success">In Stock</span> -->
									<?php if ($stock > 0) { ?>
										<span class="text-success">En Stock</span>
									<?php } else { ?>
										<span class="text-danger">En Rupture</span>
									<?php } ?>
								</li>
								<li>Catégorie: <a href=""><?= $nom_categorie ?></a></li>
								<li>Reference : <?= $refproduithyro ?></li>
							</ul>
						</div>
						<!-- .product__info / end -->
						<!-- .product__sidebar -->
						<div class="product__sidebar">
							<div class="product__availability">
								Disponiblité:
								<!-- <span class="text-success">In Stock</span> -->
								<?php if ($stock > 0) { ?>
									<span class="text-success">En Stock </span>
								<?php } else { ?>
									<span class="text-danger">En Rupture </span>
								<?php } ?>
							</div>
							<div class="product__prices">
								<?= $prix ?> F CFA
							</div>
							<!-- .product__options -->
							<form class="product__options">
								<!-- <div class="form-group product__option">
                                        <label class="product__option-label">Color</label>
                                        <div class="input-radio-color">
                                            <div class="input-radio-color__list">
                                                <label class="input-radio-color__item input-radio-color__item--white" style="color: #fff;" data-toggle="tooltip" title="White">
                                                    <input type="radio" name="color">
                                                    <span></span>
                                                </label>
                                                <label class="input-radio-color__item" style="color: #ffd333;" data-toggle="tooltip" title="Yellow">
                                                    <input type="radio" name="color">
                                                    <span></span>
                                                </label>
                                                <label class="input-radio-color__item" style="color: #ff4040;" data-toggle="tooltip" title="Red">
                                                    <input type="radio" name="color">
                                                    <span></span>
                                                </label>
                                                <label class="input-radio-color__item input-radio-color__item--disabled" style="color: #4080ff;" data-toggle="tooltip" title="Blue">
                                                    <input type="radio" name="color" disabled>
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div> -->
								<!-- <div class="form-group product__option">
                                        <label class="product__option-label">Material</label>
                                        <div class="input-radio-label">
                                            <div class="input-radio-label__list">
                                                <label>
                                                    <input type="radio" name="material">
                                                    <span>Metal</span>
                                                </label>
                                                <label>
                                                    <input type="radio" name="material">
                                                    <span>Wood</span>
                                                </label>
                                                <label>
                                                    <input type="radio" name="material" disabled>
                                                    <span>Plastic</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div> -->
								<div class="form-group product__option">
									<label class="product__option-label" for="product-quantity">Quantité</label>
									<div class="product__actions">
										<div class="product__actions-item">
											<div class="input-number product__quantity">
												<input id="product-quantity" class="input-number__input form-control form-control-lg" type="number" min="1" value="1">
												<div class="input-number__add"></div>
												<div class="input-number__sub"></div>
											</div>
										</div>
										<div class="product__actions-item product__actions-item--addtocart">
											<button onclick="event.preventDefault(), ajoutPanier()" class="btn btn-primary btn-lg commande " id="ajouterPanier">
												Ajouter au panier 
											</button>


										</div>
										<!-- 
											<div class="product__actions-item product__actions-item--addtocart">
											<button onclick="event.preventDefault(), <?php if (!empty($user)) { ?> ajoutPanier() <?php } ?>" class="btn btn-primary btn-lg 
											<?php if (!empty($user)) {
												echo "commande";
											} else {
												echo "pxp-header-user";
											}
											?> " id="<?php if (!empty($user)) { ?>ajouterPanier<?php } ?>">
												Ajouter au panier
											</button>
										</div>
										
										<div class="product__actions-item product__actions-item--wishlist">
    	                                            <button type="button" class="btn btn-secondary btn-svg-icon btn-lg" data-toggle="tooltip" title="Wishlist">
    	                                                <svg width="16px" height="16px">
    	                                                    <use xlink:href="images/sprite.svg#wishlist-16"></use>
    	                                                </svg>
    	                                            </button>
    	                                        </div>
    	                                        <div class="product__actions-item product__actions-item--compare">
    	                                            <button type="button" class="btn btn-secondary btn-svg-icon btn-lg" data-toggle="tooltip" title="Compare">
    	                                                <svg width="16px" height="16px">
    	                                                    <use xlink:href="images/sprite.svg#compare-16"></use>
    	                                                </svg>
    	                                            </button>
    	                                        </div> -->
									</div>
								</div>
							</form>
							<!-- .product__options / end -->
						</div>
						<!-- .product__end -->
						<!-- <div class="product__footer">
    	                            <div class="product__tags tags">
    	                                <div class="tags__list">
    	                                    <a href="">Mounts</a>
    	                                    <a href="">Electrodes</a>
    	                                    <a href="">Chainsaws</a>
    	                                </div>
    	                            </div>
    	                            <div class="product__share-links share-links">
    	                                <ul class="share-links__list">
    	                                    <li class="share-links__item share-links__item--type--like"><a href="">Like</a></li>
    	                                    <li class="share-links__item share-links__item--type--tweet"><a href="">Tweet</a></li>
    	                                    <li class="share-links__item share-links__item--type--pin"><a href="">Pin It</a></li>
    	                                    <li class="share-links__item share-links__item--type--counter"><a href="">4K</a></li>
    	                                </ul>
    	                            </div>
    	                        </div> -->
					</div>
				</div>
				<div class="product-tabs  product-tabs--sticky">
					<div class="product-tabs__list">
						<div class="product-tabs__list-body">
							<div class="product-tabs__list-container container">
								<a href="#tab-description" class="product-tabs__item product-tabs__item--active">Description</a>
								<!-- <a href="#tab-specification" class="product-tabs__item">Specification</a> -->
							</div>
						</div>
					</div>
					<div class="product-tabs__content">
						<div class="product-tabs__pane product-tabs__pane--active" id="tab-description">
							<div class="typography">
								<h3>Product Full Description</h3>
								<p>
									Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas fermentum, diam non iaculis finibus,
									ipsum arcu sollicitudin dolor, ut cursus sapien sem sed purus. Donec vitae fringilla tortor, sed
									fermentum nunc. Suspendisse sodales turpis dolor, at rutrum dolor tristique id. Quisque pellentesque
									ullamcorper felis, eget gravida mi elementum a. Maecenas consectetur volutpat ante, sit amet molestie
									urna luctus in. Nulla eget dolor semper urna malesuada dictum. Duis eleifend pellentesque dui et
									finibus. Pellentesque dapibus dignissim augue. Etiam odio est, sodales ac aliquam id, iaculis eget
									lacus. Aenean porta, ante vitae suscipit pulvinar, purus dui interdum tellus, sed dapibus mi mauris
									vitae tellus.
								</p>
								<h3>Etiam lacus lacus mollis in mattis</h3>
								<p>
									Praesent mattis eget augue ac elementum. Maecenas vel ante ut enim mollis accumsan. Vestibulum vel
									eros at mi suscipit feugiat. Sed tortor purus, vulputate et eros a, rhoncus laoreet orci. Proin sapien
									neque, commodo at porta in, vehicula eu elit. Vestibulum ante ipsum primis in faucibus orci luctus et
									ultrices posuere cubilia Curae; Curabitur porta vulputate augue, at sollicitudin nisl molestie eget.
								</p>
								<p>
									Nunc sollicitudin, nunc id accumsan semper, libero nunc aliquet nulla, nec pretium ipsum risus ac
									neque. Morbi eu facilisis purus. Quisque mi tortor, cursus in nulla ut, laoreet commodo quam.
									Pellentesque et ornare sapien. In ac est tempus urna tincidunt finibus. Integer erat ipsum, tristique
									ac lobortis sit amet, dapibus sit amet purus. Nam sed lorem nisi. Vestibulum ultrices tincidunt turpis,
									sit amet fringilla odio scelerisque non.
								</p>
							</div>
						</div>
						<div class="product-tabs__pane" id="tab-specification">
							<div class="spec">
								<h3 class="spec__header">Specification</h3>
								<div class="spec__section">
									<h4 class="spec__section-title">General</h4>
									<div class="spec__row">
										<div class="spec__name">Material</div>
										<div class="spec__value">Aluminium, Plastic</div>
									</div>
									<div class="spec__row">
										<div class="spec__name">Engine Type</div>
										<div class="spec__value">Brushless</div>
									</div>
									<div class="spec__row">
										<div class="spec__name">Battery Voltage</div>
										<div class="spec__value">18 V</div>
									</div>
									<div class="spec__row">
										<div class="spec__name">Battery Type</div>
										<div class="spec__value">Li-lon</div>
									</div>
									<div class="spec__row">
										<div class="spec__name">Number of Speeds</div>
										<div class="spec__value">2</div>
									</div>
									<div class="spec__row">
										<div class="spec__name">Charge Time</div>
										<div class="spec__value">1.08 h</div>
									</div>
									<div class="spec__row">
										<div class="spec__name">Weight</div>
										<div class="spec__value">1.5 kg</div>
									</div>
								</div>
								<div class="spec__section">
									<h4 class="spec__section-title">Dimensions</h4>
									<div class="spec__row">
										<div class="spec__name">Length</div>
										<div class="spec__value">99 mm</div>
									</div>
									<div class="spec__row">
										<div class="spec__name">Width</div>
										<div class="spec__value">207 mm</div>
									</div>
									<div class="spec__row">
										<div class="spec__name">Height</div>
										<div class="spec__value">208 mm</div>
									</div>
								</div>
								<div class="spec__disclaimer">
									Information on technical characteristics, the delivery set, the country of manufacture and the appearance
									of the goods is for reference only and is based on the latest information available at the time of publication.
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- .block-products-carousel -->
		<?php
		$req_boucle = $bdd->prepare("SELECT * FROM configurations_references_produits WHERE id_categorie = ?");
		$req_boucle->execute(array($idCategorie));

		while ($produit = $req_boucle->fetch(PDO::FETCH_ASSOC)) {
			$photo = $produit['photo'];
			$prix = $produit['prix'];
			$stock = $produit['stock'];
			$nomproduit = $produit['nom_produit'];
			$refproduithyro = $produit['ref_produit_hyro'];
			$description = $produit['description'];
			$url = $produit['url'];
			$title = $produit['title'];
			$meta_description = $produit['meta_description'];
			$Activer = $produit['Activer'];
			$meta_keyword = $produit['meta_keyword'];
			$lien = $produit['lien_chez_un_marchand'];
			$date = $produit['date_ajout'];
			$idCategorie = $produit['id_categorie'];
		}

		$req_boucle->closeCursor(); // Fermez le curseur de la requête

		?>
		<div class="block block-products-carousel" data-layout="grid-5" data-mobile-grid-columns="2">
			<div class="container">
				<div class="block-header">
					<h3 class="block-header__title">Produits Similaires</h3>
					<div class="block-header__divider"></div>
					<div class="block-header__arrows-list">
						<button class="block-header__arrow block-header__arrow--left" type="button">
							<svg width="7px" height="11px">
								<use xlink:href="images/sprite.svg#arrow-rounded-left-7x11"></use>
							</svg>
						</button>
						<button class="block-header__arrow block-header__arrow--right" type="button">
							<svg width="7px" height="11px">
								<use xlink:href="images/sprite.svg#arrow-rounded-right-7x11"></use>
							</svg>
						</button>
					</div>
				</div>
				<div class="block-products-carousel__slider">
					<div class="block-products-carousel__preloader"></div>
					<div class="owl-carousel">
						<?php
						$req_boucle = $bdd->prepare("SELECT * FROM configurations_references_produits WHERE id_categorie = ?");
						$req_boucle->execute(array($idCategorie));

						while ($produit = $req_boucle->fetch(PDO::FETCH_ASSOC)) {
						?>
							<div class="block-products-carousel__column">
								<div class="block-products-carousel__cell">
									<div class="product-card product-card--hidden-actions">
										<button class="product-card__quickview" type="button">
											<span class="fake-svg-icon"></span>
										</button>
										<div class="product-card__image product-image">
											<a href="<?php echo $produit['url']; ?>" class="product-image__body">
												<img class="product-image__img" src="<?php echo $produit['photo']; ?>" alt="">
											</a>
										</div>
										<div class="product-card__info">
											<div class="product-card__name">
												<a href="<?php echo $produit['url']; ?>"><?php echo $produit['nom_produit']; ?></a>
											</div>
											<div class="product-card__rating">
												<!-- Ajoutez le code pour l'affichage de la note ici -->
											</div>
										</div>
										<div class="product-card__actions">
											<div class="product-card__prices">
												<?php echo '$' . $produit['prix']; ?>
											</div>
											<div class="product-card__buttons">
												<button class="btn btn-primary product-card__addtocart" type="button">Ajouter au panier  </button>
												<button class="btn btn-secondary product-card__addtocart product-card__addtocart--list" type="button">Ajouter au panier </button>

												

											</div>
										</div>
									</div>
								</div>
							</div>
						<?php
						}
						$req_boucle->closeCursor(); // Fermez le curseur de la requête
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
	</div>
	</div>
	<!-- .block-products-carousel / end -->
	</div>
	<!-- site__body / end -->
<?php
} else {
	header('location:../../function/404/404r.php');
}
?>