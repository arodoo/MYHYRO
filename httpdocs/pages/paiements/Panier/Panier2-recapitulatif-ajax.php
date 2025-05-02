<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../../Configurations_bdd.php');
require_once('../../../Configurations.php');
require_once('../../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction = "../../../";
require_once('../../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

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

if (!empty($user)) {


?>
	<?php

	///////////////////////////////SELECT ABONNEMENT
	$req_selectap = $bdd->prepare("SELECT * FROM configurations_modes_paiement WHERE id=?");
	$req_selectap->execute(array($_SESSION['id_paiement']));
	$ligne_selectap = $req_selectap->fetch();
	$req_selectap->closeCursor();

	if (empty($_SESSION['paiement_pf'])) {
		$_SESSION['frais_gestion_pf'] = 0;
	}

	///////////////////////////////UPDATE
	$sql_update = $bdd->prepare("UPDATE membres_panier SET 
id_livraison=?,
frais_livraison=?,
frais_gestion_pf=?,
id_paiement_pf=?,
id_paiement=?,
mod_paiement=?
WHERE id_membre=?");
	$sql_update->execute(array(
		$_SESSION['id_livraison'],
		$_SESSION['frais_livraison'],
		$_SESSION['frais_gestion_pf'],
		$_SESSION['paiement_pf'],
		$_SESSION['id_paiement'],
		$ligne_selectap['nom_mode'],
		$id_oo
	));
	$sql_update->closeCursor();

	///////////////////////////////SELECT ABONNEMENT
	$req_select = $bdd->prepare("SELECT * FROM membres_panier WHERE id_membre=?");
	$req_select->execute(array($id_oo));
	$ligne_select = $req_select->fetch();
	$req_select->closeCursor();

	$Titre_panier = $ligne_select['Titre_panier'];

	$ligne_select['Tarif_HT_frais'] = ($ligne_select['Tarif_HT'] + $ligne_select['prix_frais_de_gestion_total'] + $ligne_select['prix_prospection_total'] + $ligne_select['prix_expedition_colis_total'] + $ligne_select['prix_expedition_total']);
	$prix_total_frais_expedition_TTC = round(($ligne_select['prix_frais_de_gestion_total'] + $ligne_select['prix_prospection_total']) * 1.18, 0);
	$ligne_select['Tarif_HT'] = ($ligne_select['Tarif_HT']);
	$ligne_select['Tarif_HT_net'] = ($ligne_select['Tarif_HT']);

	if ($_SESSION['frais_livraison'] != 0) {
		$tva_livraison = round(($_SESSION['frais_livraison'] * .18));
		$ligne_select['Total_Tva'] = $_SESSION['total_TVA'] + $tva_livraison;
	} else {
		$tva_livraison = 0;
		$ligne_select['Total_Tva'] = $_SESSION['total_TVA'];
	}
	//var_dump($prix_total_frais_expedition_TTC);
	$ligne_select['Tarif_TTC'] = ($_SESSION['total_HT_commande'] + $prix_total_frais_expedition_TTC + $ligne_select['prix_expedition_total'] + $ligne_select['prix_expedition_colis_total'] + $ligne_select['frais_gestion_pf'] + $_SESSION['frais_livraison'] + $tva_livraison);

	///////////////////////////////UPDATE PANIER GENERALE
	$sql_update = $bdd->prepare("UPDATE membres_panier SET
Tarif_TTC=?,
Total_Tva=?
WHERE id_membre=?");
	$sql_update->execute(array(
		$ligne_select['Tarif_TTC'],
		$ligne_select['Total_Tva'],
		$id_oo
	));
	$sql_update->closeCursor();

	if (!empty($_SESSION['id_commande'])) {

		///////////////////////////////UPDATE
		$sql_update = $bdd->prepare("UPDATE membres_commandes SET 
		prix_total=?
		WHERE id=?");
		$sql_update->execute(array(
			$ligne_select['Tarif_TTC'],
			$_SESSION['id_commande']
		));
		$sql_update->closeCursor();
	}


	?>
	<script>
		/*function show(element){
	$('#show2').attr('class');
	if(element == ".show-less"){

	}
	console.log(element);
}*/
		$(document).ready(function() {
			function showi() {
				element = "<?= $_POST["datashow"] ?>";
				if (element == "show-more") {
					var $showElements = $('.show');
					$showElements.css('display', 'none');
					//$('.show-less').text('[-]');
					//$(this).attr('class','show-more');
				} else {
					var $showElements = $('.show');
					$showElements.css('display', '');
				}
			}

			showi()
		})
	</script>


	<table id="panier_recap_pri" class=" table cart__totals pt-3">

		<tbody class="cart__totals-body">

			<tr class="show">
				<th style="border: none">Produit</th>
				<th style="border: none">Total</th>
			</tr>
			<?php ///////////////////////////////SELECT BOUCLE
			$req_boucle = $bdd->prepare("SELECT * FROM membres_panier_details WHERE id_membre=? ORDER BY id ASC");
			$req_boucle->execute(array($id_oo));
			$count = 0;

			while ($ligne_boucle = $req_boucle->fetch()) {

				if ($ligne_boucle['action_module_service_produit'] == 'Commande' || $ligne_boucle['action_module_service_produit'] == 'Commande boutique') {
					///////////////////////////////SELECT URL
					$req_select = $bdd->prepare("SELECT * FROM membres_commandes_details WHERE id=?");
					$req_select->execute(array($ligne_boucle['id_commande_detail']));
					$ligne_selec = $req_select->fetch();
					$req_select->closeCursor();
					$url_vers = $ligne_selec['url'];
					$totalht = $ligne_boucle['quantite'] * $ligne_boucle['PU_HT'];
					$commande = 'oui';
				} elseif ($ligne_boucle['action_module_service_produit'] == 'Commande colis') {
					$totalht = $ligne_boucle['TTC_colis'];
					$url_vers = '/Passage-de-colis';
					$colis = 'oui';
				} else {
					$totalht = $ligne_boucle['PU_HT'];
				} ?>
				<tr class="show">
					<?php
					$libelle = $ligne_boucle['libelle'];
					$pos = strpos($libelle, ' - Date expiration');
					$abonnement_libelle = substr($libelle, 0, $pos);
					$date_expiration_libelle = substr($libelle, $pos);
					?>
					<td style="border: none"><a target="_blank" href="/Abonnements"><?= $abonnement_libelle ?></a> <?= $date_expiration_libelle ?> x <?= $ligne_boucle['quantite'] ?></td>
					<td style="border: none"><?= number_format($totalht, 0, '.', ' ') . ' F CFA'; ?></td>
				</tr>
			<?php } ?>
			<tr class="show">
				<th style="padding-top: 50px;">Sous-total articles</th>
				<td style="padding-top: 50px;"><?php echo number_format($_SESSION['total_HT_commande'], 0, '.', ' '); ?> F CFA</td>
			</tr>


			<?php if (!empty($ligne_select['prix_frais_de_gestion_total'])) { ?>

				<tr class="show">
					<th>Frais gestion HT</th>
					<td><?php echo number_format($ligne_select['prix_frais_de_gestion_total'], 0, '.', ' '); ?> F CFA</td>
				</tr>

			<?php } ?>

			<?php if (!empty($ligne_select['frais_livraison'])) { ?>

				<tr class="show">
					<th>Frais de livraison</th>
					<td><?php echo number_format($ligne_select['frais_livraison'], 0, '.', ' '); ?> F CFA</td>
				</tr>

			<?php } ?>

			<?php if (!empty($ligne_select['Remise'])) { ?>

				<tr class="show">
					<th>Code promo <?= $ligne_select['code_promotion'] ?></th>
					<td>- <?php echo number_format($ligne_select['Remise'], 0, '.', ' '); ?> F CFA</td>
				</tr>

			<?php } ?>

			<?php /*if(!empty($ligne_select['prix_expedition_total'])){ ?>
							
								<tr>
									<th>Frais douane et expédition commande</th>
									<td><?php echo $ligne_select['prix_expedition_total']; ?> CFA</td>
								</tr>
							
							<?php } ?>

							<?php if(!empty($ligne_select['prix_expedition_colis_total'])){ ?>
							
								<tr>
									<th>Frais douane et expédition colis</th>
									<td><?php echo $ligne_select['prix_expedition_colis_total']; ?> CFA</td>
								</tr>
							
							<?php } */ ?>


			<?php if (!empty($_SESSION['frais_gestion_pf'])) { ?>

				<tr>
					<th>Frais gestion de paiement plusieurs fois</th>
					<td><?php echo number_format($_SESSION['frais_gestion_pf'], 0, '.', ' '); ?> F CFA</td>
				</tr>

			<?php } ?>

			<tr class="show">
				<th style="border-bottom: 1px solid #dee2e6;">TVA 18%</th>
				<td style="border-bottom: 1px solid #dee2e6;">
					<?php echo number_format($ligne_select['Total_Tva'], 0, '.', ' '); ?> F CFA
				</td>
			</tr>
			<?php if ($Titre_panier != "Abonnement") { ?>
				<tr>
					<th style="font-weight: bold; border: none; text-align: left;">
						<div>Douane et transport</div>
						<?php if ($commande == 'oui') { ?>
							<label style="color: #FF9900;" for="oui">Payez à la livraison</label>
							<input type="checkbox" id="payer_ala_livraison" name="payer_livraison" value="oui"
								<?php if ($_SESSION['prix_expedition_total'] == '0') {
									echo 'checked';
								} ?> />
							<a style="color: #FF9900;" class="uk-icon-info" title="Uniquement pour vos commandes"></a>

						<?php } ?>
					</th>
					<td style="font-weight: bold; border: none; text-align: right;">
						<?php echo number_format($_SESSION['prix_expedition_colis_total2'] + $_SESSION['prix_expedition_total2'], 0, '.', ' ') ?> F CFA
					</td>
				</tr>
				<!-- <tr>
					<td style="color: #FF9900; font-weight: bold; padding: 5px;">Total :</td>
					<td style="color: #FF9900; text-align: right; padding: 5px;">
						<?php echo !empty($_SESSION['PU_HT_ORIGINAL']) ? implode(', ', $_SESSION['PU_HT_ORIGINAL']) : 'N/A'; ?>
					</td>
				</tr>
				<tr>
					<td style="color: #FF9900; font-weight: bold; padding: 5px;">Prix avec réduction :</td>
					<td style="color: #FF9900; text-align: right; padding: 5px;">
						<?php echo !empty($_SESSION['PU_HT_UPDATED']) ? implode(', ', $_SESSION['PU_HT_UPDATED']) : 'N/A'; ?>
					</td>
				</tr>
				<tr>
					<td style="color: #FF9900; font-weight: bold; padding: 5px;">Remise appliquée :</td>
					<td style="color: #FF9900; text-align: right; padding: 5px;">
						<?php echo $_SESSION['remise_panier_facture_infos'] ?? 'N/A'; ?>
					</td>
				</tr> -->


			<?php
			} ?>
		</tbody>
	</table>
	<table style="width: 100%;">
		<tfoot class="cart__totals-footer">
			<tr style="background :#FFF3CD">
				<?php if ($Titre_panier != "Abonnement" && $Titre_panier != "Liste") { ?>
					<th style="width: 20px;">Total</th>
					<td style="text-align: right;"><?php echo number_format($ligne_select['Tarif_TTC'], 0, '.', ' '); ?> F CFA</td>
				<?php } else {
				?>
					<th style="width: 20px;">Total</th>
					<td style="text-align: right;"><?php echo number_format(($ligne_select['Tarif_TTC'] + $ligne_select['Total_Tva']), 0, '.', ' '); ?> F CFA

					</td>
				<?php
				} ?>
			</tr>


		</tfoot>
	</table>


	<input type="hidden" id="totalttc" value="<?= $Titre_panier != "Abonnement" && $Titre_panier != "Liste" ? round($ligne_select['Tarif_TTC']) : round($ligne_select['Tarif_TTC'] + $ligne_select['Total_Tva']) ?>">

<?php

}


ob_end_flush();
