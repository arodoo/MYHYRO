<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../Configurations_bdd.php');
require_once('../../Configurations.php');
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

if (!empty($user)) {

	$idaction = $_POST['idaction'];

?>

	<script>
		$(document).ready(function() {

			$(document).on("click", "#formulaire-abonnement-btn", function() {
				$.post({
					url: "<?php echo "/pages/Abonnements/Abonnements-popup-panier-ajax.php"; ?>",
					type: 'POST',
					data: {
						Abonnement_mode_paye: $('input[name=Abonnement_mode_paye]:checked', '#formulaire-abonnement').val(),
						idaction: "<?php echo $idaction; ?>"
					},
					dataType: "json",
					success: function(res) {
						if (res.retour_lien == "redirect") {
							location.href = "/Paiement";
						} else {
							$("#retour_mode").html(res.Texte_rapport);
							$(".mode_paiement_bloc").css("display", "none");
							$("#panier_payer_abonnement").css("display", "none");
						}
					}
				});

			});

		});
	</script>

	<?php

	$req_select3 = $bdd->prepare("SELECT * FROM configurations_abonnements WHERE id=?");
	$req_select3->execute(array($idaction));
	$ligne_select3 = $req_select3->fetch();
	$req_select3->closeCursor();

		$now = (time()+(30*86400*12));
		$now_expiration = date('d-m-Y', $now);

	if($idaction == 1){
		$sql_update = $bdd->prepare("UPDATE membres SET 
		Abonnement_date=?,
		Abonnement_id=?,
		Abonnement_paye=?,
		Abonnement_mode_paye=?,
		Abonnement_date_expiration=?
		WHERE id=?");
	$sql_update->execute(array(
		time(),
		$idaction,
		'oui',
		$Abonnement_mode_paye,
		$now,
		$id_oo));                     
	$sql_update->closeCursor();

		///////////////////////Mail support
		$de_nom = "$nom_oo $prenom_oo"; //Nom de l'envoyeur
		$de_mail = "$mail_oo"; //Email de l'envoyeur
		$vers_nom = "$nomsiteweb"; //Nom du receveur
		$vers_mail = "$emaildefault"; //Email du receveur
		$sujet = "Nouvelle souscription abonnement gratuit sur $nomsiteweb";

		$message_principalone = "<b>Objet :</b> $sujet<br /><br />
		<b>Bonjour, </b><br /><br />  
		Vous avez un nouveau abonné sur " . $nomsiteweb . " associé à l'abonnement <b>" . $ligne_select3['nom_abonnement'] . "</b>.<br /><br />
		<b>Numéro client :</b> $numero_client <br /><br />
		<b>Nom d'usage :</b> $Nom <br />
		<b>Prénom :</b> $Prenom <br />
		<br />
		Cordialement, l'équipe
		<br />";
		mailsend($vers_mail, $vers_nom, $de_mail, $de_nom, $sujet, $message_principalone);
	}

	

	?>

	<form id="formulaire-abonnement" class="mt-4" method='post' action='#'>

		<div style="margin-bottom: 20px;">
			Vous avez sélectionné l'abonnement <b><?php echo $ligne_select3['nom_abonnement']; ?> </b>
			pour le prix de <b><?php echo $ligne_select3['Prix']; ?> </b> fcfa.
		</div>

		<?php
		if ($ligne_select3['Prix'] == 0) {


		?>

			<p style="text-align: left;">Merci pour votre souscription à l'abonnement <b><?php echo $ligne_select3['nom_abonnement']; ?></b>.
				Vous pouvez maintenant profiter des différents services associés à l'abonnement.<br />
			<a class="btn btn-primary" href="/Passage-de-commande" > Passer une commande </a> </p>

		<?php
		} else {
		?>

			<div class="form-group mode_paiement_bloc">
				<h3>Choisissez le mode de paiement</h3>
				<div class="row">
					<?php
					///////////////////////////////SELECT BOUCLE
					$req_boucle = $bdd->prepare("SELECT * FROM configurations_modes_paiement WHERE (id='1' || id='2' || id='3') AND statut_mode=? ORDER by id");
					$req_boucle->execute(array("oui"));
					while ($ligne_boucle = $req_boucle->fetch()) {
					?>
						<div class="col-6">
							<input <?php if ($ligne_boucle['nom_mode'] == "Paypal") {
										echo "checked";
									} ?> type="radio" class="form-control Abonnement_mode_paye" name="Abonnement_mode_paye" data-id="<?php echo $ligne_boucle['id']; ?>" value="<?php echo $ligne_boucle['id']; ?>" style="height: 15px; width: 15px; display: inline-block;">
							<?php echo $ligne_boucle['nom_mode']; ?>
						</div>
					<?php
					}
					$req_boucle->closeCursor();
					?>
				</div>
			</div>

			<div id="retour_mode"></div>

			<div id="panier_payer_abonnement" class="form-group" style="display: inline-block; text-align: center; width: 100%;">
				<a href="#" id='formulaire-abonnement-btn' class="pxp-agent-contact-modal-btn btn btn-primary" onclick="return false;">Valider</a>
			</div>

		<?php
		}
		?>

		<div style="clear: both;"></div>
	</form>

<?php
} else {
	echo "Vous devez vous identifier";
}
ob_end_flush();
?>