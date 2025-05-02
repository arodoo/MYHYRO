<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../../Configurations_bdd.php');
require_once('../../../Configurations.php');
require_once('../../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction = "../../../";
require_once('../../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

?>
<script>
  $(document).on('click', '.delete-address', function(e) {
    e.preventDefault();
    var addressId = $(this).data('address-id');
    // Confirmer la suppression
    if (confirm("Êtes-vous sûr de vouloir supprimer cette adresse ?")) {
      $.post({
        url: '/pages/paiements/Panier/popup-Informations-livraison-ajax-supprimer.php',
        type: 'POST',
        data: { address_id: addressId },
        dataType: 'json',
        success: function(res) {
          if (res.retour_validation === "ok") {
            popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
            // Supprimer la carte de l'adresse du DOM
            $("#card_" + addressId).fadeOut(function(){
              $(this).remove();
            });
          } else {
            popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
          }
        },
        error: function(err) {
          popup_alert("Erreur.", "#CC0000 filledlight", "#CC0000", "uk-icon-times");
         /*  console.error(err); */
        }
      });
    }
  });

  $(document).on('click', '.set-default-address', function(e) {
    e.preventDefault();
    var addressId = $(this).data('address-id');
    $.post({
      url: '/pages/paiements/Panier/popup-Informations-livraison-ajax-modifier.php',
      type: 'POST',
      data: { address_id: addressId, default: 'oui' },
      dataType: 'json',
      success: function(res) {
        if (res.retour_validation === "ok") {
          popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
          location.href = "";
        } else {
          popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
        }
      },
      error: function(err) {
        popup_alert("Erreur.", "#CC0000 filledlight", "#CC0000", "uk-icon-times");
      }
    });
  });

  $(document).ready(function() {
    // Afficher le formulaire pour une nouvelle adresse
    $("#btnNewAddress").click(function() {
      if ($("#existingAddresses .card").length >= 4) {
        popup_alert("Vous ne pouvez pas ajouter plus de 4 adresses.", "#CC0000 filledlight", "#CC0000", "uk-icon-times");
        return;
      }
      $("#addressExistingSection").hide();
      $("#addressNewSection").show();
    });

    // Soumission du formulaire de nouvelle adresse via AJAX
    $("#livraisonForm").submit(function(e) {
      e.preventDefault();

      $.post({
        url: '/pages/paiements/Panier/popup-Informations-livraison-ajax.php',
        type: 'POST',
        data: {
          modal_pays: $("#modal_pays").val(),
          modal_nom: $("#modal_nom").val(),
          modal_prenom: $("#modal_prenom").val(),
          modal_mail: $("#modal_mail").val(),
          modal_portable: $("#modal_portable").val(),
          modal_fixe: $("#modal_fixe").val(),
          modal_adresse: $("#modal_adresse").val(),
          modal_code_postal: $("#modal_code_postal").val(),
          modal_ville: $("#modal_ville").val(),
          modal_complement: $("#modal_complement").val()
        },
        dataType: "json",
        success: function(res) {
          if (res.retour_validation === "ok") {
            popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
            closeModal();
          } else {
            popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
          }
        },
        error: function(err) {
          popup_alert("Erreur lors de la requête AJAX.", "#CC0000 filledlight", "#CC0000", "uk-icon-times");
          console.error(err);
        }
      });
    });

    // Fonction pour fermer le modal
    function closeModal() {
      $('#envoyerMessageModal').modal('hide');
    }
  });

  // Pour que closeModal soit disponible globalement
  function closeModal() {
    $('#envoyerMessageModal').modal('hide');
  }
</script>

<div id="envoyerMessageModal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Informations de Livraison</h5>
        <button type="button" class="close" aria-label="Close" onclick="closeModal()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="container-fluid">
          <!-- SECTION: Adresses existantes -->
          <div id="addressExistingSection">
            <h5 class="mb-3">Adresses existantes</h5>
            <div id="existingAddresses" class="row">
              <?php
              // On suppose que $id_oo vient de la session
              if (!empty($id_oo)) {
                $stmt = $bdd->prepare("SELECT * FROM membres_informations_livraison WHERE id_membre = ?");
                $stmt->execute(array($id_oo));

                if ($stmt->rowCount() > 0) {
                  while ($row = $stmt->fetch()) {
                    // Vous pouvez ajuster les champs selon les noms de vos colonnes
                    // Par exemple, si 'nom' et 'prenom' sont les colonnes de nom
                    $livraison_fullName     = trim($row['nom'] . ' ' . $row['prenom']);
                    $livraison_adresse      = $row['adresse'];
                    $livraison_codePostal   = $row['code_postal'];
                    $livraison_ville        = $row['ville'];
                    $livraison_pays         = $row['pays'];
                    $livraison_portable     = $row['portable'];
                    $livraison_complement   = $row['Complement']; // ou le nom que vous utilisez
              ?>

                    <!-- Dans la boucle qui affiche chaque carte -->
                    <div class="col-12 col-md-6 mb-3">
                      <div class="card p-3" style="border: 1px solid #ccc;" id="card_<?= $row['id'] ?>">
                        <h5 class="mb-2"><?= htmlspecialchars($livraison_fullName) ?></h5>
                        <div><?= htmlspecialchars($livraison_adresse) ?></div>
                        <div><?= htmlspecialchars($livraison_ville) ?>, <?= htmlspecialchars($livraison_codePostal) ?></div>
                        <div><?= htmlspecialchars($livraison_pays) ?></div>
                        <?php if (!empty($livraison_portable)): ?>
                          <div>Numéro de téléphone: <?= htmlspecialchars($livraison_portable) ?></div>
                        <?php endif; ?>
                        <?php if (!empty($livraison_complement)): ?>
                          <div>Instructions: <?= htmlspecialchars($livraison_complement) ?></div>
                        <?php else: ?>
                          <a href="#" class="text-primary">Ajouter des instructions de livraison</a>
                        <?php endif; ?>
                        <!-- Actions -->
                        <div class="mt-2">
                       <!--    <a href="#" class="text-primary">Éditer</a> | -->
                          <a href="#" class="text-danger delete-address" data-address-id="<?= $row['id'] ?>">Supprimer</a> |
                          <a href="#" class="text-secondary set-default-address" data-address-id="<?= $row['id'] ?>">Définir comme adresse par défaut</a>
                        </div>
                      </div>
                    </div>


              <?php
                  }
                } else {
                  echo "<div class='col-12'><p>Aucune adresse trouvée.</p></div>";
                }
                $stmt->closeCursor();
              } else {
                echo "<div class='col-12'><p>Utilisateur non identifié.</p></div>";
              }
              ?>
            </div>
            <div class="text-center mt-3">
              <button type="button" class="btn btn-secondary" id="btnNewAddress">Entrer une nouvelle adresse</button>
            </div>
          </div>

          <!-- SECTION: Formulaire pour entrer une nouvelle adresse (caché par défaut) -->
          <div id="addressNewSection" style="display: none;">
            <form id="livraisonForm" action="" method="POST">
              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label for="modal_pays">Pays*</label>
                    <select class="form-control" id="modal_pays" name="modal_pays" placeholder="*Pays">
                      <?php
                      $req_pays = $bdd->query("SELECT * FROM pays ORDER BY pays ASC");
                      while ($pays = $req_pays->fetch()) { ?>
                        <option value="<?= $pays["pays"] ?>"><?= $pays["pays"] ?></option>
                      <?php }
                      $req_pays->closeCursor();
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="modal_nom">Nom*</label>
                    <input type="text" class="form-control" id="modal_nom" name="modal_nom" required>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label for="modal_prenom">Prénom*</label>
                    <input type="text" class="form-control" id="modal_prenom" name="modal_prenom" required>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="modal_mail">Mail*</label>
                    <input type="email" class="form-control" id="modal_mail" name="modal_mail" required>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label for="modal_portable">Portable*</label>
                    <input type="tel" class="form-control" id="modal_portable" name="modal_portable" required>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="modal_fixe">Fixe</label>
                    <input type="tel" class="form-control" id="modal_fixe" name="modal_fixe">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label for="modal_adresse">Adresse*</label>
                    <input type="text" class="form-control" id="modal_adresse" name="modal_adresse" required>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="modal_code_postal">Code postal*</label>
                    <input type="text" class="form-control" id="modal_code_postal" name="modal_code_postal" required>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label for="modal_ville">Ville*</label>
                    <input type="text" class="form-control" id="modal_ville" name="modal_ville" required>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="modal_complement">Complément d'adresse</label>
                    <textarea class="form-control" id="modal_complement" name="modal_complement" rows="2"></textarea>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-12 text-center">
                  <button type="submit" class="btn btn-primary">Envoyer</button>
                </div>
              </div>
            </form>
          </div>

        </div><!-- /.container-fluid -->
      </div><!-- /.modal-body -->

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /#envoyerMessageModal -->