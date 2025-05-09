<?php

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
      <div class="sa-app__content">
          <!-- sa-app__body -->
          <div id="top" class="sa-app__body">
              <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
                  <div class="container container--max--xl">
                      <div class="py-5">
                          <div class="row g-4 align-items-center">
                              <div class="col">
                                  <nav class="mb-2" aria-label="breadcrumb">
                                      <ol class="breadcrumb breadcrumb-sa-simple">
                                          <li class="breadcrumb-item"><a href="<?php echo $mode_back_lien_interne; ?>">Administration</a></li>
                                          <?php if (empty($_GET['action'])) { ?> 
                                                <li class="breadcrumb-item active" aria-current="page">Abonnés</li> 
                                          <?php } else { ?> 
                                                <li class="breadcrumb-item"><a href="?page=Abonnes">Abonnés</a></li> 
                                                <?php if ($_GET['action'] == "Modifier") { ?> 
                                                      <li class="breadcrumb-item active" aria-current="page">Modifier</li> 
                                                <?php } ?>
                                                <?php if ($_GET['action'] == "Ajouter") { ?> 
                                                      <li class="breadcrumb-item active" aria-current="page">Ajouter</li> 
                                                <?php } ?>
                                                <?php if ($_GET['action'] == "Graphique") { ?> 
                                                      <li class="breadcrumb-item active" aria-current="page">Graphique</li> 
                                                <?php } ?>
                                          <?php } ?>
                                      </ol>
                                  </nav>
                                  <h1 class="h3 m-0">Gestion des abonnés</h1>
                              </div>
                              <div class="col-auto d-flex">
                                  <?php if (isset($_GET['action'])) { ?>
                                        <a href="?page=Abonnes" class="btn btn-primary">Liste des abonnés</a>
                                  <?php } ?>
                              </div>
                          </div>
                      </div>

                      <script>
                          // Make listeCompteMembre accessible globally
                          window.listeCompteMembre = function() {
                              $.post({
                                  url: '/administration/Modules/Abonnes/Abonnes-action-liste-ajax.php',
                                  type: 'POST',
                                  dataType: "html",
                                  success: function(res) {
                                      $("#liste-compte-membre").html(res);
                                      initializeDataTables();
                                  }
                              });
                          }
                        
                          // Initialize DataTables with proper styling
                          function initializeDataTables() {
                              if ($.fn.DataTable.isDataTable('.sa-datatables-init')) {
                                  $('.sa-datatables-init').DataTable().destroy();
                              }

                              setTimeout(function () {
                                  const template =
                                      '<"sa-datatables"' +
                                      '<"sa-datatables__table"t>' +
                                      '<"sa-datatables__footer"' +
                                      '<"sa-datatables__pagination"p>' +
                                      '<"sa-datatables__controls"' +
                                      '<"sa-datatables__legend"i>' +
                                      '<"sa-datatables__divider">' +
                                      '<"sa-datatables__page-size"l>' +
                                      '>' +
                                      '>' +
                                      '>';

                                  $('.sa-datatables-init').each(function () {
                                      const table = $(this).DataTable({
                                          dom: template,
                                          paging: true,
                                          ordering: true,
                                          info: true,
                                          language: {
                                              search: "",
                                              searchPlaceholder: "Rechercher...",
                                              lengthMenu: "Afficher _MENU_ éléments",
                                              info: "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
                                              infoEmpty: "Affichage de l'élément 0 à 0 sur 0 élément",
                                              infoFiltered: "(filtré de _MAX_ éléments au total)",
                                              paginate: {
                                                  first: "Premier",
                                                  previous: "Précédent",
                                                  next: "Suivant",
                                                  last: "Dernier"
                                              }
                                          },
                                          drawCallback: function () {
                                              $(this).find('.pagination').addClass('pagination-sm');
                                          }
                                      });

                                      const searchSelector = $(this).data('sa-search-input');
                                      if (searchSelector) {
                                          $(searchSelector).off('input').on('input', function () {
                                              table.search(this.value).draw();
                                          });

                                          $(searchSelector).off('keypress.prevent-form-submit').on('keypress.prevent-form-submit', function (e) {
                                              return e.which !== 13;
                                          });
                                      }
                                  });
                              }, 10);
                          }

                          $(document).ready(function() {
                              //AJAX SOUMISSION DU FORMULAIRE - MODIFIER - AJOUTER
                              $(document).on("click", "#modifier", function() {
                                  $.post({
                                      url: '/administration/Modules/Abonnes/Abonnes-action-modifier-ajax.php',
                                      type: 'POST',
                                      <?php if (isset($_GET['action']) && $_GET['action'] == "Modifier") { ?> 
                                            data: new FormData($("#formulaire-modifier")[0]),
                                      <?php } else { ?> 
                                            data: new FormData($("#formulaire-ajouter")[0]),
                                      <?php } ?> 
                                      processData: false,
                                      contentType: false,
                                      dataType: "json",
                                      success: function(res) {
                                          if (res.retour_validation == "ok") {
                                              popup_alert(res.Texte_rapport, "green filledlight", "#009900", "fas fa-check");
                                              location.reload();
                                          } else {
                                              popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "fas fa-times");
                                          }
                                      },
                                      error: function(xhtml, error, code) {
                                          console.log(xhtml.responseText);
                                      }
                                  });
                                  listeCompteMembre();
                              });

                              listeCompteMembre();
                          });
                      </script>

                      <?php
                      $action = $_GET['action'] ?? '';
                      $idaction = $_GET['idaction'] ?? '';

                      if ($action == "Modifier" || $action == "Ajouter") {
                        if ($action == "Modifier") {
                          // Load member data
                          $req_select = $bdd->prepare("SELECT * FROM membres WHERE id=?");
                          $req_select->execute(array($idaction));
                          $ligne_select = $req_select->fetch();
                          $req_select->closeCursor();

                          // Variables from database
                          $idd2dddf = $ligne_select['id'];
                          $loginm = $ligne_select['pseudo'];
                          $emailm = $ligne_select['mail'];
                          $nomm = $ligne_select['nom'];
                          $prenomm = $ligne_select['prenom'];
                          $adminm = $ligne_select['admin'];
                          $statut_compte = $ligne_select['statut_compte'];
                          $adressem = $ligne_select['adresse'];
                          $cpm = $ligne_select['cp'];
                          $villem = $ligne_select['ville'];
                          $telephonepost = $ligne_select['Telephone'];
                          $telephoneposportable = $ligne_select['Telephone_portable'];
                          $ActiverActiver = $ligne_select['Activer'];
                          $photo = $ligne_select['photo'];
                          $abonnement_id = $ligne_select['Abonnement_id'];
                          $abonnement_paye = $ligne_select['Abonnement_paye'];
                          $abonnement_paye_demande = $ligne_select['Abonnement_paye_demande'];
                          $abonnement_date_paye = $ligne_select['Abonnement_date_paye'];
                          $abonnement_date_expiration = $ligne_select['Abonnement_date_expiration'];
                          $abonnement_statut_demande = $ligne_select['Abonnement_statut_demande'];

                          // Calculate remaining days
                          if ($ligne_select['Abonnement_date_expiration'] > time()) {
                            $nbr_jour_abonnement = ($ligne_select['Abonnement_date_expiration'] - time());
                            if ($nbr_jour_abonnement > 86400) {
                              $nbr_jour_abonnement = ($nbr_jour_abonnement / 86400);
                            }
                            $nbr_jour_abonnement = round($nbr_jour_abonnement);
                            if ($nbr_jour_abonnement > 1) {
                              $nbr_jour_abonnement = "$nbr_jour_abonnement Jours";
                            } else {
                              $nbr_jour_abonnement = "1 Jour";
                            }
                          } else {
                            $nbr_jour_abonnement = "0 Jours";
                          }
                          ?>
                                  <div class="card">
                                      <div class="card-header">
                                          <h5 class="m-0">Modifier l'abonnement du membre</h5>
                                      </div>
                                      <div class="card-body">
                                          <form id="formulaire-modifier" method="post" action="#">
                                              <input name="idaction" type="hidden" value="<?= $idaction ?>">
                                              <input name="action" type="hidden" value="Modifier-action">
                                        
                                              <div class="card mb-4">
                                                  <div class="card-body">
                                                      <h5 class="mb-3">Abonnement</h5>
                                                
                                                      <div class="mb-4 row">
                                                          <label class="col-sm-3 col-form-label">Abonnement actuel</label>
                                                          <div class="col-sm-9">
                                                              <select name="Abonnement_id" id="Abonnement_id" class="form-select" required>
                                                                  <option value="">Pas d'abonnement</option>
                                                                  <?php
                                                                  $req_boucle = $bdd->prepare("SELECT * FROM configurations_abonnements ORDER by id");
                                                                  $req_boucle->execute();
                                                                  while ($ligne_boucle = $req_boucle->fetch()) {
                                                                    ?>
                                                                        <option <?php if ($ligne_boucle['id'] == $ligne_select['Abonnement_id']) {
                                                                          echo "selected";
                                                                        } ?>
                                                                            value="<?= $ligne_boucle['id'] ?>"><?= $ligne_boucle['nom_abonnement'] ?></option>
                                                                        <?php
                                                                  }
                                                                  $req_boucle->closeCursor();
                                                                  ?>
                                                              </select>
                                                          </div>
                                                      </div>
                                                
                                                      <div class="mb-4 row">
                                                          <label class="col-sm-3 col-form-label">Abonnement demandé</label>
                                                          <div class="col-sm-9">
                                                              <?php
                                                              $req_boucle = $bdd->prepare("SELECT * FROM configurations_abonnements Where id=?");
                                                              $req_boucle->execute(array($ligne_select['Abonnement_demande']));
                                                              $ligne_boucle = $req_boucle->fetch();
                                                              $req_boucle->closeCursor();
                                                              echo $ligne_boucle['nom_abonnement'];
                                                              ?>
                                                              <input type="hidden" name="abo_demande" value="<?= $ligne_boucle['id'] ?>">
                                                          </div>
                                                      </div>
                                                
                                                      <div class="mb-4 row">
                                                          <label class="col-sm-3 col-form-label">Date demande</label>
                                                          <div class="col-sm-9">
                                                              <?= date('d-m-Y', $ligne_select['Abonnement_dernier_demande_date']) ?>
                                                          </div>
                                                      </div>
                                                
                                                      <div class="mb-4 row">
                                                          <label class="col-sm-3 col-form-label">Fiche</label>
                                                          <div class="col-sm-9">
                                                              <a href="?page=Membres&amp;action=Modifier&amp;idaction=<?= $ligne_select['id'] ?>"
                                                                  target="blank_" class="btn btn-danger">Fiche client</a>
                                                          </div>
                                                      </div>
                                                
                                                      <div class="mb-4 row">
                                                          <label class="col-sm-3 col-form-label">N°Client</label>
                                                          <div class="col-sm-9">
                                                              <?= $ligne_select['numero_client'] ?>
                                                          </div>
                                                      </div>
                                                
                                                      <div class="mb-4 row">
                                                          <label class="col-sm-3 col-form-label">Nom</label>
                                                          <div class="col-sm-9">
                                                              <?= $ligne_select['nom'] ?>
                                                          </div>
                                                      </div>
                                                
                                                      <div class="mb-4 row">
                                                          <label class="col-sm-3 col-form-label">Prénom</label>
                                                          <div class="col-sm-9">
                                                              <?= $ligne_select['prenom'] ?>
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>
                                        
                                              <div class="card mb-4">
                                                  <div class="card-body">
                                                      <h5 class="mb-3">Dates</h5>
                                                
                                                      <div class="mb-4 row">
                                                          <label class="col-sm-3 col-form-label">Date commande</label>
                                                          <div class="col-sm-9">
                                                              <?= date('d-m-Y', $ligne_select['Abonnement_date']) ?>
                                                          </div>
                                                      </div>
                                                
                                                      <div class="mb-4 row">
                                                          <label class="col-sm-3 col-form-label">Expire le</label>
                                                          <div class="col-sm-9">
                                                              <?php if (!empty($ligne_select['Abonnement_date_expiration'])) {
                                                                echo date('d-m-Y', $ligne_select['Abonnement_date_expiration']);
                                                              } else {
                                                                echo "-";
                                                              } ?>
                                                          </div>
                                                      </div>
                                                
                                                      <div class="mb-4 row">
                                                          <label class="col-sm-3 col-form-label">Date paiement</label>
                                                          <div class="col-sm-9">
                                                              <?php if (!empty($ligne_select['Abonnement_date_paye'])) {
                                                                echo date('d-m-Y', $ligne_select['Abonnement_date_paye']);
                                                              } else {
                                                                echo "-";
                                                              } ?>
                                                          </div>
                                                      </div>
                                                
                                                      <div class="mb-4 row">
                                                          <label class="col-sm-3 col-form-label">Jours restant</label>
                                                          <div class="col-sm-9">
                                                              <?= $nbr_jour_abonnement ?>
                                                          </div>
                                                      </div>
                                                
                                                      <div class="mb-4 row">
                                                          <label class="col-sm-3 col-form-label">Modifier l'expiration</label>
                                                          <div class="col-sm-9">
                                                              <input name="date_new_expiration" class="form-control" type="date" id="date_new_expiration" value="" required />
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>
                                        
                                              <div class="card mb-4">
                                                  <div class="card-body">
                                                      <h5 class="mb-3">Paiement</h5>
                                                
                                                      <?php if (!empty($ligne_select['Abonnement_last_facture_numero'])) { ?>
                                                        <div class="mb-4 row">
                                                            <label class="col-sm-3 col-form-label">Dernière facture</label>
                                                            <div class="col-sm-9">
                                                                <a href="/facture/<?= $ligne_select['Abonnement_last_facture_numero'] ?>/<?= $nomsiteweb ?>"
                                                                    target="blank_" class="btn btn-danger">Facture abonnement</a>
                                                            </div>
                                                        </div>
                                                      <?php } ?>
                                                
                                                      <div class="mb-4 row">
                                                          <label class="col-sm-3 col-form-label">Payé</label>
                                                          <div class="col-sm-9">
                                                              <select name="Abonnement_paye" id="Abonnement_paye" class="form-select" required>
                                                                  <option <?php if ($ligne_select['Abonnement_paye'] == "non") {
                                                                    echo "selected";
                                                                  } ?> value="non">Non</option>
                                                                  <option <?php if ($ligne_select['Abonnement_paye'] == "oui") {
                                                                    echo "selected";
                                                                  } ?> value="oui">Oui</option>
                                                              </select>
                                                          </div>
                                                      </div>
                                                
                                                      <div class="mb-4 row">
                                                          <label class="col-sm-3 col-form-label">Mode de paiement</label>
                                                          <div class="col-sm-9">
                                                              <select name="Abonnement_mode_paye" id="Abonnement_mode_paye" class="form-select" required>
                                                                  <option value="">Sélection</option>
                                                                  <?php
                                                                  $req_boucle = $bdd->prepare("SELECT * FROM configurations_modes_paiement ORDER by id");
                                                                  $req_boucle->execute();
                                                                  while ($ligne_boucle = $req_boucle->fetch()) {
                                                                    ?>
                                                                        <option <?php if ($ligne_select['Abonnement_paye_demande'] == $ligne_boucle['nom_mode']) {
                                                                          echo "selected";
                                                                        } ?> 
                                                                            value="<?= $ligne_boucle['nom_mode'] ?>"><?= $ligne_boucle['nom_mode'] ?></option>
                                                                        <?php
                                                                  }
                                                                  $req_boucle->closeCursor();
                                                                  ?>
                                                              </select>
                                                          </div>
                                                      </div>
                                                
                                                      <div class="mb-4 row">
                                                          <label class="col-sm-3 col-form-label">Modifier date paiement</label>
                                                          <div class="col-sm-9">
                                                              <input name="Abonnement_date_paye" class="form-control" type="date" id="Abonnement_date_paye" value="" required />
                                                          </div>
                                                      </div>
                                                
                                                      <div class="mb-4 row">
                                                          <div class="col-sm-9 offset-sm-3">
                                                              <div class="form-check">
                                                                  <input class="form-check-input" type="checkbox" name="generer_facture" id="generer_facture" value="oui" />
                                                                  <label class="form-check-label" for="generer_facture">
                                                                      Générer une facture pour l'abonnement (La facture aura la date du jour)
                                                                  </label>
                                                              </div>
                                                          </div>
                                                      </div>
                                                
                                                      <div class="mb-4 row">
                                                          <label class="col-sm-3 col-form-label">Activer l'abonnement demandé</label>
                                                          <div class="col-sm-9">
                                                              <div class="form-check form-check-inline">
                                                                  <input class="form-check-input" type="radio" name="activer_abo" id="activer_abo_oui" value="oui">
                                                                  <label class="form-check-label" for="activer_abo_oui">OUI</label>
                                                              </div>
                                                              <div class="form-check form-check-inline">
                                                                  <input class="form-check-input" type="radio" name="activer_abo" id="activer_abo_non" value="non" checked>
                                                                  <label class="form-check-label" for="activer_abo_non">NON</label>
                                                              </div>
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>
                                        
                                              <div class="card mb-4">
                                                  <div class="card-body">
                                                      <h5 class="mb-3">Suivi de la commande</h5>
                                                
                                                      <div class="mb-4 row">
                                                          <label class="col-sm-3 col-form-label">Suivi achat</label>
                                                          <div class="col-sm-9">
                                                              <select id="statut_2" name="statut_2" class="form-select">
                                                                  <option value=""></option>
                                                                  <?php
                                                                  $req_boucle = $bdd->prepare("SELECT * FROM configurations_suivi_achat where type=2");
                                                                  $req_boucle->execute();
                                                                  while ($ligne_boucle = $req_boucle->fetch()) {
                                                                    ?>
                                                                        <option value="<?= $ligne_boucle['id'] ?>" <?php if ($ligne_select['Abonnement_statut_demande'] == $ligne_boucle['id']) { ?> selected <?php } ?>>
                                                                            <?= $ligne_boucle['nom_suivi'] ?>
                                                                        </option>
                                                                        <?php
                                                                  }
                                                                  $req_boucle->closeCursor();
                                                                  ?>
                                                              </select>
                                                          </div>
                                                      </div>
                                                
                                                      <div class="mb-4 row">
                                                          <label class="col-sm-3 col-form-label">Messages prédéfinis</label>
                                                          <div class="col-sm-9">
                                                              <select id="message" name="message" class="form-select">
                                                                  <?php
                                                                  $req_boucle = $bdd->prepare("SELECT * FROM configurations_messages_predefini where type=2");
                                                                  $req_boucle->execute();
                                                                  while ($ligne_boucle = $req_boucle->fetch()) {
                                                                    ?>
                                                                        <option value="<?= $ligne_boucle['id'] ?>" <?php if ($ligne_select['Abonnement_message_demande'] == $ligne_boucle['id']) { ?> selected <?php } ?>>
                                                                            <?= $ligne_boucle['message'] ?>
                                                                        </option>
                                                                        <?php
                                                                  }
                                                                  $req_boucle->closeCursor();
                                                                  ?>
                                                              </select>
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>
                                        
                                              <!-- Include your payment and refund tracking section here if needed -->
                                        
                                              <div class="card mb-4">
                                                  <div class="card-body">
                                                      <h5 class="mb-3">Notes</h5>
                                                
                                                      <div class="mb-4 row">
                                                          <div class="col-sm-12">
                                                              <textarea id="notes" name="notes" class="form-control"><?= $commande['notes'] ?? '' ?></textarea>
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>
                                        
                                              <div class="mt-4">
                                                  <button id="modifier" type="button" class="btn btn-success">
                                                      <i class="fas fa-save me-2"></i>ENREGISTRER
                                                  </button>
                                              </div>
                                          </form>
                                      </div>
                                  </div>
                                  <?php
                        } else if ($action == "Ajouter") {
                          ?>
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="m-0">Ajouter un nouvel abonné</h5>
                                        </div>
                                        <div class="card-body">
                                            <form id="formulaire-ajouter" method="post" action="#">
                                                <input name="action" type="hidden" value="Ajouter-action">
                                        
                                                <!-- Add form fields similar to Modifier form but with empty values -->
                                        
                                                <div class="mt-4">
                                                    <button id="modifier" type="button" class="btn btn-success">
                                                        <i class="fas fa-save me-2"></i>ENREGISTRER
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                  <?php
                        }
                      } else {
                        ?>
                            <div class="card">
                                <div class="card-body" id="liste-compte-membre">
                                    <!-- Content will be loaded via AJAX -->
                                </div>
                            </div>
                            <?php
                      }
                      ?>
                  </div>
              </div>
          </div>
          <!-- sa-app__body / end -->
      </div>
      <?php
} else {
  header('location: /index.html');
}
?>