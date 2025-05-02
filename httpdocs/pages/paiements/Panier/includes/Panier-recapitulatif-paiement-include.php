<style>
	.card {
		border: 2px solid #f0f0f0;
		border-radius: 5px;
		box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
		padding: 10px;
		margin-top: 20px;
	}

	.card-title {
		font-size: 24px;
		font-weight: bold;
		color: #F4B85C;
	}

	.cart__totals {
		width: 100%;
		border-collapse: collapse;
		/* margin-bottom: 20px; */
	}

	.cart__totals th,
	.cart__totals td {
		padding: 5px 10px;
		text-align: left;
		font-size: 16px;
	}

	.cart__totals th {
		font-weight: bold;
		color: #333;
	}

	.cart__totals td {
		font-weight: normal;
		text-align: right;
	}

	.cart__totals-footer th {
		font-size: 18px;
		color: #333;
	}

	.cart__totals-footer td {
		font-weight: bold;
		font-size: 18px;
	}


	.col-6 img {
		width: 100%;
		max-width: 250px;
		height: auto;
		display: block;
		margin: 0 auto;
	}



	@media only screen and (max-width: 768px) {
		.card {
			margin-top: 20px;
		}

		.cart__totals th,
		.cart__totals td {
			padding: 8px 10px;
			font-size: 14px;
		}


	}

	@media (max-width: 992px) {
		.panier {
			justify-content: center !important;
		}

		#Remise_bouton {
			width: 30% !important;
		}
	}


	.image-container {
		text-align: center;

		margin-bottom: 20px;
	}

	.responsive-image {
		width: 100%;

		max-width: 200px;

		height: auto;

	}

	@media (max-width: 768px) {

		/* .responsive-image {
					max-width: 400px;

				} */
		.responsive-image {
			/* visibility: hidden; */
			/* height: 0 !important; */
		}
	}

	@media (max-width: 580px) {
		.panier {
			display: block;
		}
	}

	.cart__checkout-button:hover {
		background-color: #F4B85C !important;
		border: 1px solid #F4B85C;
	}

	.btn.cart__checkout-button {
		width: 50%;
		font-size: medium;
		margin: 0 auto;
		height: 50px;
		background-color: #FFA500;
		color: #333;
		font-weight: bold;
		text-align: center;
		display: flex;
		align-items: center;
		justify-content: center;
		border-radius: 7px;
		cursor: pointer;

	}

	.price-info {
		color: rgba(0, 0, 0, 0.5);
		font-size: 12px;
		text-align: center;
		margin-top: 5px;
		font-style: italic;
	}

	@media (max-width: 768px) {
		.fn2 {
			flex-direction: row-reverse;
			align-items: center;
		}
	}

	table {
		border-collapse: separate !important;
	}
</style>

<script>
	$(document).ready(function() {
		$("#formulaire-abonnement-btn").click(function() {
			var modePaiementValue = $("input[name='mode_paiement']:checked").val();
			var messageContainer = $("#message-container");
			if (modePaiementValue !== undefined) {
				messageContainer.html("Vous avez choisi le mode de paiement : " + modePaiementValue);

				$("#modalPaiement").modal("show");
			} else {
				messageContainer.html("Veuillez choisir un mode de paiement.");
			}
		});

		$(document).on("click", ".show-more", function() {
			var $showElements = $('.show_d');
			$showElements.css('display', '');
			$(this).text('[-]');
			$(this).attr('class', 'show-less');
		});

		$(document).on("click", ".show-less", function() {
			var $showElements = $('.show_d');
			$showElements.css('display', 'none');
			$(this).text('[+]');
			$(this).attr('class', 'show-more');
		});

		$(document).on("change", "#quantity", function() {
			var id = $(this).attr("data-id");
			var puht = document.getElementById("puht" + id);
			var puhtValue = parseFloat(puht.innerHTML);

			var total = puhtValue * $(this).val();
			var tt = document.getElementById("total" + id);
			tt.innerHTML = total.toFixed(2) + ' CFA'
			$("#modif_quantite" + id).css("display", "");
		});

		$('#backButton').click(function(e) {
			e.preventDefault();
			window.history.back();
		});

	});
</script>

<?php
//////////////////////////////CALCULS FRAIS ET PANIER
include('calculs-frais-douane-expeditions.php');

?>

<div>
	<a href="/Passage-de-commande" class="footer-newsletter__form-button btn btn-outline-dark"
		style="border-radius: 7px;">Etape précédente</a>

</div>

<div class="row">
	<hr />
</div>

<style>
	.container table th {
		justify-content: space-evenly;
	}
</style>
<div class="cart block">
	<div class="container">

		<div class="row panier">

			<div class="col col-lg-9 col-md-12 col-sm-12" style="padding-left: 0px;">
				<div class="table-responsive" style="  border: 1px solid #ebebeb; border-radius: 7px; /*max-height: 500px;  overflow-y: auto; position: relative; */">
					<table class="cart__table cart-table" style=" ">
						<thead class="cart-table__head" style="position: sticky; top: 0;  z-index: 1; ">
							<tr class="cart-table__row">
								<th class="cart-table__column cart-table__column--remove" style="padding: 10px;">IMAGE</th>
								<th class="cart-table__column cart-table__column--product">LIBELLÉ</th>
								<th class="cart-table__column cart-table__column--price" style=" min-width: 150px; ">PRIX</th>
								<th class="cart-table__column cart-table__column--quantity">QUANTITÉ</th>
								<th class="cart-table__column cart-table__column--total" style=" min-width: 150px; ">TOTAL</th>
								<th class="cart-table__column cart-table__column--remove"></th>
							</tr>
						</thead>

						<tbody class="cart-table__body">

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
								$Taux_tva = "1.18";

								$PU_HT_total_panier = sprintf('%.2f', ($PU_HT_total_panier));
								$PU_TVA_total_panier = sprintf('%.2f', ($PU_TTC_totald_panierd - $PU_HT_total_panier));

								$_SESSION['total_HT'] = $PU_HT_total_panier;
								$_SESSION['total_HT_net'] = $_SESSION['total_HT'];

								$_SESSION['total_TVA'] = "$PU_TVA_total_panier";

								//////////////////////////////////////////TOTAUX
								$image = '';

								if ($action_module_service_produit == 'Commande') {
									///////////////////////////////SELECT URL
									$req_select = $bdd->prepare("SELECT * FROM membres_commandes_details WHERE id=?");
									$req_select->execute(array($ligne_boucle['id_commande_detail']));
									$ligne_select = $req_select->fetch();
									$req_select->closeCursor();
									$url_vers = $ligne_select['url'];
									$comm = 'oui';

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
									$PU_HT_total = $ligne_boucle['TTC_colis'];
									$col = 'oui';

									///////////////////////////////SELECT URL
									$req_select = $bdd->prepare("SELECT * FROM categories WHERE nom_categorie=?");
									$req_select->execute(array($ligne_boucle['categorie']));
									$ligne_cat = $req_select->fetch();
									$req_select->closeCursor();

									if (!empty($ligne_cat['nom_categorie_image'])) {
										$image = '/images/categories/' . $ligne_cat['nom_categorie_image'];
									}
								} elseif ($action_module_service_produit == 'Abonnement') {
									$url_vers = '/Abonnement';

									$pos = strpos($libelle, ' - Date expiration');
									$date_expiration_libelle = substr($libelle, $pos);
									$libelle = substr($libelle, 0, $pos);
								}

								if (!empty($ligne_boucle['id_produit'])) {
									$comm = 'oui';
									///////////////////////////////SELECT URL
									$req_select = $bdd->prepare("SELECT * FROM configurations_references_produits WHERE id=?");
									$req_select->execute(array($ligne_boucle['id_produit']));
									$ligne_p = $req_select->fetch();
									$req_select->closeCursor();

									if (!empty($ligne_p['photo'])) {
										$image = $ligne_p['photo'];
									}
								}

								$Taux_tva = "20";




							?>
								<tr class="cart-table__row">
									<td class="cart-table__column cart-table__column--image"><img src="<?= $image ?>" width="70px" height="70px;"></td>
									<td class="cart-table__column cart-table__column--product">
										<a target="_blank" href="<?= $url_vers ?>"><?php echo " $libelle "; ?></a>
										<?php echo " $date_expiration_libelle "; ?>
									</td>
									<td id="puht<?php echo $ligne_boucle['id'] ?>" class="cart-table__column cart-table__column--price" data-title="PRIX"><?php echo number_format($PU_HT, 0, '.', ' '); ?> F CFA</td>
									<td class="cart-table__column cart-table__column--quantity" data-title="QUANTITÉ"><?php if ($action_module_service_produit == 'Commande' || $action_module_service_produit == 'Commande boutique') {
																														?>
											<!--div style="border: #e0e0e0 1px solid">
						<div class="d-flex justify-content-between" style="margin: 5px 5px;">
						<span data-id="<?php echo $ligne_boucle['id'] ?>" class="uk-icon-minus bouton-moins"  style="cursor: pointer; color:#e0e0e0"></span>
						<div class="quantite<?php echo $ligne_boucle['id'] ?>"><?php echo $quantite; ?></div>
						<span data-id="<?php echo $ligne_boucle['id'] ?>" class="uk-icon-plus bouton-plus"  style="cursor: pointer; color:#e0e0e0"></span>
						</div>
						</div-->
											<div class="input-number">
												<input id="quantit" data-id="<?php echo $ligne_boucle['id'] ?>" class="form-control input-number__input quantite<?php echo $ligne_boucle['id'] ?>" type="number" min="1" value="<?php echo $quantite; ?>">
												<div data-id="<?php echo $ligne_boucle['id'] ?>" class="input-number__add"></div>
												<div data-id="<?php echo $ligne_boucle['id'] ?>" class="input-number__sub"></div>
											</div>

										<?php
																														} else {
																															echo $quantite;
																														}
										?>
									</td>
									<td id="total<?php echo $ligne_boucle['id'] ?>" class="cart-table__column cart-table__column--total" data-title="TOTAL"><?php echo number_format($PU_HT_total, 0, '.', ' '); ?> F CFA</td>
									<td class="cart-table__column cart-table__column--remove"><?php if ($action_module_service_produit == 'Commande' || $action_module_service_produit == 'Commande colis' || $action_module_service_produit == 'Commande boutique') {
																								?><a id="delete-panier" data-id="<?= $ligne_boucle['id'] ?>" href="#" style="color: #FF9900;margin-left:0.5rem"><span class="uk-icon-trash-o"></span></a><?php
																																																														}
																																																															?></td>
								</tr>
							<?php
								unset($PU_HT_total);
							}
							$req_boucle->closeCursor();



							//Si pas de résultat 
							if (empty($count)) {
							?>
								<tr>
									<td class='ligne_paiement' colspan='4' style='text-align: center;'><?php echo "Votre panier est vide pour le moment !"; ?></td>
								</tr>
							<?php
							}
							//$prix_total_frais_expedition_TTC = $_SESSION['prix_expedition_colis_total']+$_SESSION['prix_expedition_total'];
							///////////////////////////////SELECT
							$req_selectpa = $bdd->prepare("SELECT * FROM membres_panier WHERE id_membre=?");
							$req_selectpa->execute(array($id_oo));
							$ligne_selectpa = $req_selectpa->fetch();
							$req_selectpa->closeCursor();

							$_SESSION['total_HT_commande'] = round(($_SESSION['total_HT']));
							$_SESSION['total_HT'] = round(($_SESSION['total_HT_commande'] + $prix_total_frais_expedition_HT), 0);
							$_SESSION['total_HT_net'] = round(($_SESSION['total_HT'] + $prix_total_frais_expedition_HT), 0);
							//var_dump($_SESSION['total_HT_commande'], $prix_total_frais_expedition_TTC);
							$_SESSION['total_TTC'] = round(($_SESSION['total_HT_commande'] + $prix_total_frais_expedition_TTC + $prix_expedition_colis_total + $prix_expedition_total), 2);

							$_SESSION['total_TVA'] = round($prix_total_frais_expedition_TVA, 0);

							if ($ligne_selectpa['Titre_panier'] == "Abonnement" || $ligne_selectpa['Titre_panier'] == "Liste") {
								$_SESSION['total_TVA'] = round($_SESSION['total_HT_commande'] * .18, 0);
								$_SESSION['total_TTC'] = round(($_SESSION['total_HT_commande'] + $_SESSION['total_TVA']), 0);
							}

							///////////////////////////////UPDATE PANIER GENERALE
							$sql_update = $bdd->prepare("UPDATE membres_panier SET
									Tarif_HT=?,
									Total_tva=?,
									prix_frais_de_gestion_total=?
									WHERE pseudo=?");
							$sql_update->execute(array(
								$_SESSION['total_HT_commande'],
								$_SESSION['total_TVA'],
								$_SESSION['prix_frais_de_gestion_total'],
								$user
							));
							$sql_update->closeCursor();

							?>
						</tbody>
					</table>

				</div>

				<?php


				if ($ligne_selectpa['Titre_panier'] != "Abonnement") {
				?>

					<div class="cart__actions" style="/* max-width: 800px; */ margin: 30px 0;">

						<div class="code">
							<div>Vous disposez d'un code promo ?</div>
							<form class="footer-newsletter__form fn2" method='post' action='#'>
								<input class='footer-newsletter__form-input form-control' type='text' id='Remise' name='code_promo' value=""
									placeholder="<?php echo "Entrez-le ici"; ?>"
									style='width: 240px; margin-right: 5px; display: inline-block; font-style: italic;' />

								<button id='Remise_bouton' class="footer-newsletter__form-button btn btn-primary cart__update-button commande" style="text-transform : uppercase;" onclick="return false;"> OK </button>
							</form>
						</div>

						<div class="cart__buttons" style="width: auto;">
							<!--a href="/" class="btn btn-light">Continuer vos achats</a-->
							<!-- data-toggle="modal" data-target="#modalPaiement" -->

							<!-- <a href="/Passage-de-commande" class=" cart__update-button commande" style="text-decoration: underline;">Modifier Panier</a> -->
							<a href="<?php echo (strpos($libelle, 'Colis') !== false) ? '/Passage-de-colis' : '/Passage-de-commande'; ?>"
								class="cart__update-button commande"
								style="text-decoration: underline;">
								Modifier Panier
							</a>

							<?php if (empty($user) && $_SESSION['total_HT'] > 0) { ?>
								<span class="uk-icon-warning"></span> Vous devez vous identifiez afin de pouvoir procéder au paiement sécurisé en ligne.
							<?php } elseif ($Abonnement_id < 1) { ?>
								<a href="/Mon-abonnement"><span class="uk-icon-warning"></span> Vous devez opter pour un abonnement.</a>
							<?php
							}
							?>
						</div>
					</div>

				<?php
				}
				?>
			</div>




			<div class="col col-lg-3 col-md-12 col-sm-12" style=" align-self: flex-start; position: sticky; top: 40px; padding: 0;">
				<div class="card" style="border: 2px solid #f0f0f0; border-radius: 7px; margin-top: 0!important; background-color: #f7f7f7">
					<div class="card-body" style="padding: 0!important;">
						<h2 class="card-title">Total Panier</h2>
						<div class="cart__totals">

							<div class="cart__totals-header" style="line-height: 15px; padding: 10px 0; border-bottom: 1px solid #ddd;">
								<b>
									<div style="display: flex; justify-content: space-between;">
										<div style="font-size: 14px;">Sous-total articles
											<?php if ($comm == 'oui' && $col == 'oui') { ?>
												<span style="font-size: 11px; font-weight: 400; display: block; color:gray">(total articles hors colis)</span>
											<?php } ?>
										</div>
										<div style="font-size: 14px;"><?php echo number_format($_SESSION['total_HT_commande'], 0, '.', ' '); ?> F CFA</div>
									</div>
								</b>
							</div>

							<div class="cart__totals-body">
								<?php if (!empty($_SESSION['prix_frais_de_gestion_total'])) { ?>
									<div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #ddd;">
										<div style="font-size: 14px;">Frais de gestion HT</div>
										<div style="font-size: 14px;"><?php echo number_format($_SESSION['prix_frais_de_gestion_total'], 0, '.', ' '); ?> F CFA</div>
									</div>
								<?php } ?>

								<div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #ddd;">
									<div style="font-size: 14px;">TVA 18%</div>
									<div style="font-size: 14px;"><?php echo number_format($_SESSION['total_TVA'], 0, '.', ' '); ?> F CFA</div>
								</div>

								<?php if ($ligne_selectpa['Titre_panier'] != "Abonnement") { ?>
									<div style="display: flex; justify-content: space-between; padding: 10px 0">
										<div style="font-weight: bold;">
											<div style="font-size: 14px;">Douane et transport
												<?php if ($comm == 'oui' && $col == 'oui') { ?>
													<span id="show_D" class="show-more" style="color: #4f7baf; cursor: pointer; font-weight: 1 !important;">[+]</span>
												<?php } ?>
											</div>
											<?php if ($comm == 'oui' && $col == 'oui') { ?>
												<div class="show_d" style="display: none; font-size: 12px; font-weight: 400;">
													<div>Commande</div>
													<div>Colis</div>
												</div>
											<?php } ?>
										</div>
										<div style="font-weight: bold;">
											<div><?php echo number_format($_SESSION['prix_expedition_colis_total2'] + $_SESSION['prix_expedition_total2'], 0, '.', ' '); ?> F CFA</div>
											<?php if ($comm == 'oui' && $col == 'oui') { ?>
												<div class="show_d" style="display: none; font-size: 12px; font-weight: 400;">
													<div><?php echo number_format($_SESSION['prix_expedition_total2'], 0, '.', ' '); ?> F CFA</div>
													<div><?php echo number_format($_SESSION['prix_expedition_colis_total2'], 0, '.', ' '); ?> F CFA</div>
												</div>
											<?php } ?>
										</div>
									</div>

									<div style="padding: 10px 0; border-bottom: 1px solid #ddd;">
										<?php if ($comm == 'oui') { ?>
											<div class="d-flex justify-content-between">
												<div>
													<label style="color: #FF9900; font-size: 14px;">Payer la douane et transport à la livraison ?</label>
													<?php if ($comm == 'oui' && $col == 'oui') { ?>
														<a style="color: #FF9900;" class="uk-icon-info" title="Uniquement pour vos commandes"></a>
													<?php } ?>
												</div>

												<div style="display: flex;">
													<span style="color: #FF9900; font-size: 14px; padding-right: 3px;">Oui</span> <input type="checkbox" style="width: 15px;height: 15px;" id="payer_ala_livraison" name="payer_livraison" value="oui" <?php if ($_SESSION['prix_expedition_total'] == '0') {
																																																															echo 'checked';
																																																														} ?> />
												</div>
											</div>


										<?php } ?>
									</div>
								<?php } ?>
							</div>

							<div class="cart__totals-footer" style="padding: 10px 5px; background: #daf6e3;">
								<div style="display: flex; justify-content: space-between; font-weight: bold;">
									<div style="font-size: 16px; ">Total TTC</div>
									<div style="font-size: 16px;"><?php echo number_format($_SESSION['total_TTC'], 0, '.', ' '); ?> F CFA</div>
								</div>
							</div>

						</div>

						<?php if ($_SESSION['total_TTC'] > 0 && !empty($user) && $Abonnement_id > 0) { ?>
							<div style=" background: #daf6e3; padding: 10px; border-bottom-left-radius: 7px; border-bottom-right-radius: 7px;">
								<a class="btn cart__checkout-button" href="/Paiement-2">VALIDER</a>
								<p class="price-info">Prix TTC, TVA appliquée sur la base du pays : Gabon</p>
							</div>
						<?php } elseif (empty($user) && $_SESSION['total_TTC'] > 0) { ?>
							<div class="alert alert-danger" style="text-align: left; margin-top: 20px;">
								<span class="uk-icon-warning"></span> Vous devez vous identifiez afin de pouvoir procéder au paiement sécurisé en ligne.
							</div>
						<?php } elseif (empty($user) && $_SESSION['total_TTC'] > 0) { ?>
							<div class="alert alert-danger" style="text-align: left; margin-top: 20px;">
								<a href="/Mon-abonnement"><span class="uk-icon-warning"></span> Vous devez opter pour un abonnement.</a>
							</div>
						<?php } /*elseif(isset($user) && $_SESSION['total_TTC'] > 0 && $ligne_selectpa['Titre_panier'] == "Abonnement" && $admin_oo == 1){ ?>
							<div style="text-align: center; margin-top: 20px; width: 100%;">
								<a href="/Traitements-admin" id='valider-admin' class='btn btn-primary' style='color: #ffffff !important; text-decoration: none;'> PAYER EN ADMIN </a>
							</div>
						<?php }*/ ?>

						<?php /*if (isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $_SESSION['total_HT'] > 0) { ?>
							<div style="text-align: center; margin-top: 20px; width: 100%;">
								<a href="/Traitements-admin" id='valider-admin' class='btn btn-primary' style='color: #ffffff !important; text-decoration: none;'> VALIDER EN ADMIN </a>
							</div>
						<?php }*/ ?>

						<?php /*if ($_SESSION['total_HT'] > 0 && $count > 0) {
							include('../../../../pages/paiements/Panier/includes/Panier-paypal-include.php');
						}*/ ?>
					</div>
				</div>

				<br>
				<!-- <p style="font-size:14px;">Réglez vos achats en 2 ou 3 fois.<a href="#" onclick="popupFunction()">Plus d'infos</a></p> -->
				<p style="font-size:12px; color: gray;">Les frais de douane et transport sont estimés. Ils pourront être ajustés en fonction du poids réel et/ou valeur douanière réelle. Le cas échéant, vous serez notifié.</p>
				<div style="display: flex; justify-content: center;">
					<img src="/images/bags_panier.jpg" alt="bags" class="responsive-image">
				</div>
			</div>
		</div>


		<div>

		</div>
		<div class="row pt-7">

		</div>



		<div id="popup" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 999;">
			<div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: white; padding: 20px;">
				<p>Et quoniam mirari posse quosdam peregrinos existimo haec lecturos forsitan, si contigerit, quamobrem cum oratio ad ea monstranda deflexerit quae Romae gererentur, nihil praeter seditiones narratur et tabernas et vilitates harum similis alias, summatim causas perstringam nusquam a veritate sponte propria digressurus.
					Et quoniam inedia gravi adflictabantur, locum petivere Paleas nomine, vergentem in mare, valido muro firmatum, ubi conduntur nunc usque commeatus distribui militibus omne latus Isauriae defendentibus adsueti. circumstetere igitur hoc munimentum per triduum et trinoctium et cum neque adclivitas ipsa sine discrimine adiri letali, nec cuniculis quicquam geri posset, nec procederet ullum obsidionale commentum, maesti excedunt postrema vi subigente maiora viribus adgressuri.
					Iis igitur est difficilius satis facere, qui se Latina scripta dicunt contemnere. in quibus hoc primum est in quo admirer, cur in gravissimis rebus non delectet eos sermo patrius, cum idem fabellas Latinas ad verbum e Graecis expressas non inviti legant. quis enim tam inimicus paene nomini Romano est, qui Ennii Medeam aut Antiopam Pacuvii spernat aut reiciat, quod se isdem Euripidis fabulis delectari dicat, Latinas litteras oderit?.</p>
				<button style="background-color:#FF9900; border:none; color:#fff; border-radius: 10px; padding: 6px 20px 6px 20px;" onclick="closePopup()">Fermer</button>
			</div>
		</div>
		<script>
			function popupFunction() {
				var popup = document.getElementById("popup");
				popup.style.display = "block";
			}

			function closePopup() {
				var popup = document.getElementById("popup");
				popup.style.display = "none";
			}
		</script>


		<div class="col-12 col-md-7 col-lg-6 col-xl-5">

		</div>
	</div>
</div>
</div>