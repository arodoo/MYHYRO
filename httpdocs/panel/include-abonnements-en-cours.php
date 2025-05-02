<?php
if ($_GET['page'] == "Mon-abonnement") {

	if (!empty($Abonnement_id)) {

		$reqFacture = $bdd->prepare("SELECT * FROM membres_prestataire_facture WHERE id_membre = ?  ORDER BY id DESC LIMIT 1");
		$reqFacture->execute([$id_oo]);
		$ligneFacture = $reqFacture->fetch();
		$numeroFacture = $ligneFacture['numero_facture'];

		///////////////////////////////SELECT
		$req_selecta = $bdd->prepare("SELECT * FROM configurations_abonnements WHERE id=?");
		$req_selecta->execute(array($Abonnement_id));


		$ligne_selecta = $req_selecta->fetch();
		$req_selecta->closeCursor();

		///////////////////////////////SELECT
		$req_selectaa = $bdd->prepare("SELECT * FROM membres WHERE id=?");
		$req_selectaa->execute(array($id_oo));
		$ligne_selectaa = $req_selectaa->fetch();
		$req_selectaa->closeCursor();
		$Abonnement_id = $ligne_selectaa['Abonnement_id'];
		$Abonnement_date  = $ligne_selectaa['Abonnement_date'];
		$Abonnement_date_expiration = $ligne_selectaa['Abonnement_date_expiration'];
		$Abonnement_paye = $ligne_selectaa['Abonnement_paye'];
		$Abonnement_date_paye = $ligne_selectaa['Abonnement_date_paye'];
		$Abonnement_mode_paye = $ligne_selectaa['Abonnement_mode_paye'];
		$Abonnement_paye_demande = $ligne_selectaa['Abonnement_paye_demande'];
		$Abonnement_demande = $ligne_selectaa['Abonnement_demande'];
		$Abonnement_dernier_demande_date = $ligne_selectaa['Abonnement_dernier_demande_date'];
		$Abonnement_statut_demande = $ligne_selectaa['Abonnement_statut_demande'];
		$Abonnement_message_demande = $ligne_selectaa['Abonnement_message_demande'];

		///////////////////////////////SELECT
		$req_selecta = $bdd->prepare("SELECT * FROM configurations_abonnements WHERE id=?");
		$req_selecta->execute(array($Abonnement_demande));
		$ligne_selecta2 = $req_selecta->fetch();
		$req_selecta->closeCursor();

		///////////////////////////////SELECT
		$req_selecta = $bdd->prepare("SELECT * FROM configurations_suivi_achat WHERE id=?");
		$req_selecta->execute(array($Abonnement_statut_demande));
		$ligne_selecta22 = $req_selecta->fetch();
		$req_selecta->closeCursor();

		///////////////////////////////SELECT
		$req_selecta = $bdd->prepare("SELECT * FROM configurations_messages_predefini WHERE id=?");
		$req_selecta->execute(array($Abonnement_message_demande));
		$ligne_selecta222 = $req_selecta->fetch();
		$req_selecta->closeCursor();

		if (!empty($Abonnement_date_paye) && $Abonnement_paye == "oui") {
			$Abonnement_date_paye = date('d-m-Y', $ligne_selectaa['Abonnement_date_paye']);
			$Abonnement_date_paye = ", le $Abonnement_date_paye";
		} else {
			$Abonnement_date_paye = "";
		}
		$etat_abonnement = "Inactif";
		if ($ligne_selectaa['Abonnement_date_expiration'] > time()) {
			$etat_abonnement = "Actif";
			$nbr_jour_abonnement = ($ligne_selectaa['Abonnement_date_expiration'] - time());

			if ($nbr_jour_abonnement > 86400) {
				$nbr_jour_abonnement = ($nbr_jour_abonnement / 86400);
			}

			$nbr_jour_abonnement = round($nbr_jour_abonnement);

			if ($nbr_jour_abonnement > 1) {
				$nbr_jour_abonnement = "$nbr_jour_abonnement Jours";
			} else {
				$nbr_jour_abonnement = "1 Jour";
			}


			$etat_abonnement_class = "bg-success text-white";
		} else {
			$nbr_jour_abonnement = "0 Jours";

			$etat_abonnement_class = "bg-danger text-white";
		}



		if (!empty($ligne_selectaa['Abonnement_date'])) {
			$Abonnement_date = date('d-m-Y', $ligne_selectaa['Abonnement_date']);
		} else {
			$Abonnement_date = "-";
		}
		if (!empty($ligne_selectaa['Abonnement_date_expiration'])) {
			$Abonnement_date_expiration = date('d-m-Y', $ligne_selectaa['Abonnement_date_expiration']);
		} else {
			$Abonnement_date_expiration = "-";
		}

?>

		<script>
			$(document).ready(function() {
				$(document).on("click", "#cancel-subscription", function(e) {
					e.preventDefault();

					var dataToSend = {
						id: $(this).attr('data-id')
					};

/* 					console.log("Datos enviados al backend:", dataToSend); */

					$.post({
						url: '/pages/Abonnements/Abonnements-popup-supprimer-ajax.php',
						type: 'POST',
						data: dataToSend,
						dataType: "json",
						success: function(res) {
							if (res.retour_validation == "ok") {
								/* alert('Abonnement annulé avec succès'); */
								popup_alert("Abonnement annulé avec succès", "red filledlight", "#CC0000", "uk-icon-times");
								location.href = "";
							}
						}
					});
				});
			});
		</script>


		<div class="card" style="margin-bottom: 20px; border: 2px solid #f0f0f0; border-radius: 2px; box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;">
			<div class="card-header d-flex flex-wrap align-items-center">
				<?php if ($Abonnement_id == 1) { ?>
					<h5>Vous n'êtes pas abonné</h5>
				<?php } else { ?>
					<h5>Votre abonnement</h5>
				<?php } ?>
				<?php if ($Abonnement_id != 1) { ?>

					<div class="rounded <?php echo $etat_abonnement_class; ?>" style="margin: 20px; padding: .2rem;">
						<label for="checkout-address" class="fw-bold mb-0">
							<?php echo $etat_abonnement; ?>
						</label>
					</div>
				<?php } ?>

			</div>




			<div class="card-divider"></div>
			<div class="card-body">
				<div class="row no-gutters">
					<div class="col-12 col-lg-12">
						<!-- <?php if ($Abonnement_id == 1) { ?>
							
							<div>
								<a href="/Abonnements" class="btn btn-primary btn-lg">S'abonner</a>
							</div>
						<?php } else { ?>
						
							<div class="form-group">
								<label for="checkout-street-address" style="font-weight: bold;">Formule actuelle : </label>
								<?php echo $ligne_selecta['nom_abonnement']; ?>
							</div>
							<div class="form-group">
								<label for="checkout-address" style="font-weight: bold;">Date commande de l'abonnement : </label>
								<?php echo $Abonnement_date; ?>
							</div>
							<div class="form-group">
								<label for="checkout-address" style="font-weight: bold;">Expiration de l'abonnement : </label>
								<?php echo $Abonnement_date_expiration; ?>
							</div>
							<div class="form-group">
								<label for="checkout-address" style="font-weight: bold;">Reste : </label>
								<?php echo $nbr_jour_abonnement; ?>
							</div>

							<?php if ($Abonnement_id > 1 && !empty($Abonnement_paye)) { ?>
								<div class="form-group">
									<label for="checkout-address" style="font-weight: bold;">Payé : </label>
									<?php if ($Abonnement_paye == "oui") {
											echo "<span class='product-card__badge product-card__badge--new'><span class='uk-icon-check'></span> $Abonnement_paye</span>";
										} else {
											echo "<span class='product-card__badge product-card__badge--sale'><span class='uk-icon-times'></span> $Abonnement_paye</span>";
										} ?>
									par <?php echo "$Abonnement_mode_paye $Abonnement_date_paye"; ?>
								</div>
							<?php } ?>

							<?php if (!empty($Abonnement_demande)) { ?>
								<hr>
								<div class="form-group">
									<label for="checkout-street-address" style="font-weight: bold;">Demande d'Abonnement : </label>
									<?php echo $ligne_selecta2['nom_abonnement']; ?>
								</div>
								<div class="form-group">
									<label for="checkout-street-address" style="font-weight: bold;">Statut demande: </label>
									<?php echo $ligne_selecta22['nom_suivi']; ?>
								</div>
								<div class="form-group">
									<label for="checkout-street-address" style="font-weight: bold;">Messsage Abonnement : </label>
									<?php echo $ligne_selecta222['message']; ?>
								</div>
							<?php } ?>

							<?php if (!empty($ligne_selectaa['Abonnement_last_facture_numero'])) { ?>
								<div class="form-group">
									<a href="/facture/<?php echo $ligne_selectaa['Abonnement_last_facture_numero']; ?>/<?php echo $nomsiteweb; ?>" target="_blank" class="btn btn-danger" style="border-radius: 10px; width: 251px;">Dernière facture</a>
								</div>
							<?php } ?>

							<?php if (floatval($ligne_selectaa['Abonnement_date_expiration']) - 1209600 < time()) { ?>
								<div>
									<a href="/Abonnements" class="btn btn-primary btn-lg">Renouveler</a>
								</div>
							<?php } ?>

							<div>
								<a href="/Abonnements" class="btn btn-primary btn-lg">Changer d'abonnement</a>
							</div>
						<?php } ?> -->


						<div class="form-group">
							<label for="checkout-street-address" style="font-weight: bold;">Formule actuelle : </label>
							<?php echo $ligne_selecta['nom_abonnement']; ?>
						</div>


						<?php if ($Abonnement_id > 1 && !empty($Abonnement_paye)) { ?>
							<div class="form-group">
								<label for="checkout-address" style="font-weight: bold;">Date commande de l'abonnement : </label>
								<?php echo $Abonnement_date; ?>
							</div>

							<div class="form-group">
								<label for="checkout-address" style="font-weight: bold;">Expiration de l'abonnement : </label>
								<?php echo $Abonnement_date_expiration; ?>
							</div>
							<div class="form-group">
								<label for="checkout-address" style="font-weight: bold;">Reste : </label>
								<?php echo $nbr_jour_abonnement; ?>
							</div>
							<div class="form-group">
								<label for="checkout-address" style="font-weight: bold;">Payé : </label>
								<?php if ($Abonnement_paye == "oui") {
									echo "<span class='product-card__badge product-card__badge--new'><span class='uk-icon-check'></span> $Abonnement_paye</span>";
								} else {
									echo "<span class='product-card__badge product-card__badge--sale'><span class='uk-icon-times'></span> $Abonnement_paye</span>";
								} ?>
								par <?php echo "$Abonnement_mode_paye $Abonnement_date_paye"; ?>
							</div>
						<?php } ?>

						<?php if (!empty($Abonnement_demande)) { ?>
							<hr>
							<div class="form-group">
								<label for="checkout-street-address" style="font-weight: bold;">Demande d'Abonnement : </label>
								<?php echo $ligne_selecta2['nom_abonnement']; ?>
							</div>
							<div class="form-group">
								<label for="checkout-street-address" style="font-weight: bold;">Statut demande: </label>
								<?php echo $ligne_selecta22['nom_suivi']; ?>
							</div>
							<div class="form-group">
								<label for="checkout-street-address" style="font-weight: bold;">Messsage Abonnement : </label>
								<?php echo $ligne_selecta222['message']; ?>
							</div>
						<?php } else if ($Abonnement_id == 1) {
						?>
							<div>
								<a href="/Abonnements" class="btn btn-primary btn-lg">S'abonner</a>
							</div>

						<?php
						} ?>

						<?php if (!empty($ligne_selectaa['Abonnement_last_facture_numero'])) { ?>
							<div class="form-group">
								<a href="/facture/<?php echo $numeroFacture; ?>/<?php echo $nomsiteweb; ?>"
									target="_blank"
									class="btn btn-danger"
									style="border-radius: 10px; width: 251px;">
									Dernière facture
								</a>

							</div>
						<?php } ?>

						<?php if ($Abonnement_id == 2 || $Abonnement_id == 3) { ?>
							<div>
								<?php if ($ligne_selectaa['Abonnement_date_expiration']  < time()) { ?>
									<a href="/Abonnements" class="btn btn-primary btn-lg">Renouveler abonnement</a>
								<?php } elseif ($ligne_selectaa['Abonnement_date_expiration'] - 1209600 < time()) { ?>
									<div class="alert alert-warning">Pensez à renouveler votre abonnement dans <?php echo $nbr_jour_abonnement; ?></div>
								<?php } ?>
							</div>
						<?php } ?>


						<?php if ($Abonnement_id > 1 && ($Abonnement_id != 2 && $Abonnement_id != 3)) { ?>
							<div>
								<a href="/Abonnements" class="btn btn-primary btn-lg">Changer d'abonnement</a>
							</div>
						<?php } ?>

						<?php if ($Abonnement_id > 1) { ?>
							<div>
								<a href="" class="btn btn-danger" data-id="<?php echo $id_oo; ?>" id="cancel-subscription">annuler l'abonnement</a>
							</div>
						<?php } ?>
					</div>

				</div>
			</div>
		</div>

		</div>
	<?php
	} else {
	?>
		<div class="card" style="margin-bottom: 20px;">
			<div class="card-header">
				<?php if ($Abonnement_id == 1) { ?>
					<h5>Vous n'êtes pas abonné</h5>
				<?php } else { ?>
					<h5>Votre abonnement</h5>
				<?php } ?>
			</div>
			<div class="card-divider"></div>
			<div class="card-body">
				<div class="row no-gutters">
					<div class="col-12 col-lg-12">
						<div class="form-group">
							Vous n'avez pas d'abonnement <br /><br />
							<a href="/Abonnements" class="btn btn-primary btn-lg">Abonnements</a>
						</div>
					</div>
				</div>
			</div>
		</div>

<?php
	}
}
?>