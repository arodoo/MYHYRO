<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../../Configurations_bdd.php');
require_once('../../../Configurations.php');
require_once('../../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction = "../../../";
require_once('../../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

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

if (
	isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 1 ||
	isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 2 ||
	isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 3
) {
	?>
	<div class="sa-datatables-header">
		<div class="sa-datatables-header__title">
			<h2>Liste des abonnés</h2>
		</div>
		<div class="sa-datatables-header__search">
			<input type="text" placeholder="Recherche" class="form-control form-control--search" id="table-search">
		</div>
	</div>

	<script>
		$(document).ready(function () {
			// Add modal HTML at the bottom of the page
			$('body').append(`
				<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="deleteConfirmModalLabel">Confirmer la suppression</h5>
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<div class="modal-body">
								Êtes-vous sûr de vouloir supprimer cet abonné ?
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
								<button type="button" class="btn btn-danger" id="confirmDelete">Supprimer</button>
							</div>
						</div>
					</div>
				</div>
			`);

			// Store the ID to delete
			let idToDelete = null;

			// Delete action handler - open modal instead of browser confirm
			$(document).on("click", "#deleteThis", function (e) {
				e.preventDefault();
				idToDelete = $(this).attr('data');

				// Show the modal instead of browser confirm
				var deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
				deleteModal.show();
			});

			// Confirm delete button in modal
			$(document).on("click", "#confirmDelete", function () {
				if (idToDelete) {
					$.post({
						url: '/administration/Modules/Abonnes/Abonnes-action-supprimer-ajax.php',
						type: 'POST',
						data: { id: idToDelete },
						success: function (res) {
							res = JSON.parse(res);
							if (res.retour_validation == "ok") {
								// Hide the modal
								bootstrap.Modal.getInstance(document.getElementById('deleteConfirmModal')).hide();

								// Show success message
								popup_alert(res.Texte_rapport, "green filledlight", "#009900", "fas fa-check");

								// Refresh the list
								if (window.parent && window.parent.listeCompteMembre) {
									window.parent.listeCompteMembre();
								} else {
									// Fallback if parent function isn't accessible
									setTimeout(() => {
										$.post({
											url: '/administration/Modules/Abonnes/Abonnes-action-liste-ajax.php',
											type: 'POST',
											dataType: "html",
											success: function (res) {
												$("#liste-compte-membre", window.parent.document).html(res);
											}
										});
									}, 1000);
								}
							} else {
								// Show error message
								popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "fas fa-times");
							}
						}
					});
				}
			});
		});
	</script>

	<table class="sa-datatables-init" data-order='[[ 0, "desc" ]]' data-sa-search-input="#table-search">
		<thead>
			<tr>
				<th>NOM PRENOM</th>
				<th>ABONNEMENT</th>
				<th>STATUT</th>
				<th>MOYEN PAIEMENT</th>
				<th>DATE DE PAIEMENT</th>
				<th>EXPIRATION</th>
				<th>JOURS RESTANT</th>
				<th>ACTIONS</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$req_boucle = $bdd->prepare("SELECT * FROM membres WHERE Abonnement_statut_demande IS NOT NULL ORDER BY id DESC");
			$req_boucle->execute();
			while ($ligne_boucle = $req_boucle->fetch()) {
				$id = $ligne_boucle['id'];
				$nom = $ligne_boucle['nom'];
				$prenom = $ligne_boucle['prenom'];
				$abonnement_id = $ligne_boucle['Abonnement_id'];
				$abonnement_paye = $ligne_boucle['Abonnement_paye'];
				$abonnement_paye_demande = $ligne_boucle['Abonnement_paye_demande'];
				$abonnement_date_paye = $ligne_boucle['Abonnement_date_paye'];
				$abonnement_date_expiration = $ligne_boucle['Abonnement_date_expiration'];
				$abonnement_statut_demande = $ligne_boucle['Abonnement_statut_demande'];

				// Get abonnement name
				$sql_select = $bdd->prepare("SELECT * FROM configurations_abonnements WHERE id=?");
				$sql_select->execute(array($abonnement_id));
				$ligne_abonnement = $sql_select->fetch();
				$sql_select->closeCursor();
				$abonnement_name = $ligne_abonnement ? $ligne_abonnement['nom_abonnement'] : 'Non défini';

				// Get status name
				$sql_select = $bdd->prepare("SELECT * FROM configurations_suivi_achat WHERE id=?");
				$sql_select->execute(array($abonnement_statut_demande));
				$ligne_statut = $sql_select->fetch();
				$sql_select->closeCursor();
				$statut_name = $ligne_statut ? $ligne_statut['nom_suivi'] : 'Non défini';

				// Calculate remaining days
				$nbr_jour_abonnement = "0 Jours";
				if ($abonnement_date_expiration > time()) {
					$nbr_jour_abonnement = ($abonnement_date_expiration - time());
					if ($nbr_jour_abonnement > 86400) {
						$nbr_jour_abonnement = ($nbr_jour_abonnement / 86400);
					}
					$nbr_jour_abonnement = round($nbr_jour_abonnement);
					if ($nbr_jour_abonnement > 1) {
						$nbr_jour_abonnement = "$nbr_jour_abonnement Jours";
					} else {
						$nbr_jour_abonnement = "1 Jour";
					}
				}
				?>
				<tr>
					<td><?= $prenom ?> 		<?= $nom ?></td>
					<td><?= $abonnement_name ?></td>
					<td>
						<span class="badge bg-primary"><?= $statut_name ?></span>
					</td>
					<td><?= $abonnement_paye_demande ?></td>
					<td>
						<?php if ($abonnement_date_paye > 0): ?>
							<?= date("d/m/Y", $abonnement_date_paye) ?>
						<?php else: ?>
							Non disponible
						<?php endif; ?>
					</td>
					<td>
						<?php if ($abonnement_date_expiration > 0): ?>
							<?= date("d/m/Y", $abonnement_date_expiration) ?>
						<?php else: ?>
							Non disponible
						<?php endif; ?>
					</td>
					<td><?= $nbr_jour_abonnement ?></td>
					<td>
						<div class="dropdown">
							<button class="btn btn-sa-muted btn-sm" type="button" data-bs-toggle="dropdown"
								aria-expanded="false" aria-label="More">
								<i class="fas fa-ellipsis-v"></i>
							</button>
							<ul class="dropdown-menu dropdown-menu-end">
								<li><a class="dropdown-item"
										href="?page=Abonnes&action=Modifier&idaction=<?= $id ?>">Modifier</a></li>
								<li><a class="dropdown-item text-danger" href="#" id="deleteThis"
										data="<?= $id ?>">Supprimer</a></li>
							</ul>
						</div>
					</td>
				</tr>
				<?php
			}
			$req_boucle->closeCursor();
			?>
		</tbody>
	</table>

	<?php
} else {
	header('location: /index.html');
}

ob_end_flush();
?>