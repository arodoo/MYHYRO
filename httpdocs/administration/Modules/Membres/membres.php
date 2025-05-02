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

  $idaction = $_GET['idaction'];
  $action = $_GET['action'];



?>

  <script>
    $(document).ready(function() {

      //AJAX SOUMISSION DU FORMULAIRE - MODIFIER - AJOUTER
      $(document).on("click", "#modifier-compte-membre", function() {
        $.post({
          url: '/administration/Modules/Membres/membres-action-modifier-ajax.php',
          type: 'POST',
          <?php if ($_GET['action'] == "Modifier") { ?>
            data: new FormData($("#formulaire-modifier-compte-membre")[0]),
          <?php } else { ?>
            data: new FormData($("#formulaire-modifier-compte-membre-ajouter")[0]),
          <?php } ?>
          processData: false,
          contentType: false,
          dataType: "json",
          success: function(res) {
            if (res.retour_validation == "ok") {
              console.log(res.Texte_rapport);
              popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
              <?php if ($_GET['action'] != "Modifier") { ?>
                $("#formulaire-gestion-des-pages-ajouter")[0].reset();
              <?php } ?>
            } else {
              popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
            }
          },
          error: function(xhtml, error, code) {
            console.log(xhtml.responseText);
          }
        });
        listeCompteMembre();
      });

      //AJAX - MAIL CONNECTION
      $(document).on("click", ".connection-compte-membre", function() {
        $.post({
          url: '/administration/Modules/Membres/membres-action-connection-ajax.php',
          type: 'POST',
          data: {
            idaction: $(this).attr("data-id")
          },
          dataType: "json",
          success: function(res) {
            if (res.retour_validation == "ok") {
              $(top.location).attr("href", res.retour_lien);
            }
          }
        });
        listeCompteMembre();
      });

      $(document).on("change", "#Pays", function() {
        pays();
      });

      function pays() {
        if ($('#Pays option:selected').val() != "Gabon") {
          $('.france').css("display", "");
          $('.gabon').css("display", "none");
        }
        if ($('#Pays option:selected').val() == "Gabon") {
          $('.france').css("display", "none");
          $('.gabon').css("display", "");
        }
      }
      pays();

      //AJAX - SUPPRIMER MEMBRE
      $(document).on("click", "#supprimer-compte-membre-submit", function() {
        $.post({
          url: '/administration/Modules/Membres/membres-action-supprime-ajax.php',
          type: 'POST',
          data: new FormData($("#formulaire-supprimer-compte-membre")[0]),
          processData: false,
          contentType: false,
          dataType: "json",
          success: function(res) {
            if (res.retour_validation == "ok") {
              popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
              //setTimeout("Timerone()",2000);
              //document.location.href = "?page=Membres";
            } else {
              popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
            }
          }
        });
        listeCompteMembre();
      });

      //FUNCTION AJAX - LISTE NEWSLETTER
      function listeCompteMembre() {
        $.post({
          url: '/administration/Modules/Membres/membres-action-liste-ajax.php',
          type: 'POST',
          dataType: "html",
          success: function(res) {
            $("#liste-compte-membre").html(res);
          }
        });
      }
      listeCompteMembre();

      //AJAX - COMMENTAIRE LOG
      $(document).on("change", "#compte_log_mail", function() {
        if ($("#compte_log_mail").val() == "oui") {
          $(".commentaire_log_mail_utilisateur_bloc").css("display", "");
        }
        if ($("#compte_log_mail").val() == "non") {
          $(".commentaire_log_mail_utilisateur_bloc").css("display", "none");
        }
      });

      //AJAX - COMMENTAIRE LOG SUPPRIMER
      $(document).on("change", "#MODULE_ENVOYER_MAIL", function() {
        if ($("#MODULE_ENVOYER_MAIL").val() == "oui") {
          $(".commentaire_log_mail_utilisateur_bloc_supprimer").css("display", "");
        }
        if ($("#MODULE_ENVOYER_MAIL").val() == "non") {
          $(".commentaire_log_mail_utilisateur_bloc_supprimer").css("display", "none");
        }
      });

      $(document).on('click', '#btnSupprModal', function() {
        $.post({
          url: '/administration/Modules/Membres/modal-supprimer-ajax.php',
          type: 'POST',
          data: {
            idaction: $(this).attr("data-id")
          },
          dataType: "html",
          success: function(res) {
            $("body").append(res)
            $("#modalSuppr").modal('show')
          }
        })
      });

      $(document).on("click", "#btnSuppr", function() {
        $.post({
          url: '/administration/Modules/Membres/membres-action-supprime-ajax.php',
          type: 'POST',
          data: {
            idaction: $(this).attr("data-id")
          },
          dataType: "json",
          success: function(res) {
            if (res.retour_validation == "ok") {
              popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
            } else {
              popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
            }
            listeCompteMembre();
            $("#modalSuppr").modal('hide')
          }
        });
      });

      $(document).on("click", "#btnNon", function() {
        $("#modalSuppr").modal('hide')
      });

      $(document).on('hidden.bs.modal', "#modalSuppr", function() {
        $(this).remove()
      })

      $(document).on('change', "#statut_compte", function() {
        if (($('#statut_compte').val()) == 1) {
          $("#bie").hide();
        } else {
          $("#bie").show();
        }
      });
    });
  </script>

  <?php

  $action = $_GET['action'];
  $idaction = $_GET['idaction'];
  ?>

  <div id="top" class="sa-app__body">
    <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
      <div class="container">
        <div class="py-5">
          <div class="row g-4 align-items-center">
            <div class="col">
              <nav class="mb-2" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-sa-simple">
                  <li class="breadcrumb-item"><a href="index-admin.php">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Membres</li>
                </ol>
              </nav>
              <h1 class="h3 m-0">Membres</h1>
            </div>
            <?php
            ////////////////////////////////////////////////////////////////////////////////////////////FORMULAIRE SUPPRIMER
            if ($action != "Ajouter") {
            ?>
              <div class="col-auto d-flex"><a href="?page=Membres&action=Ajouter" class="btn btn-primary">Ajouter un membre</a></div>
            <?php
            }
            ?>
            <?php
            ////////////////////////////////////////////////////////////////////////////////////////////FORMULAIRE SUPPRIMER
            if (!empty($action)) {
            ?>
              <div class="col-auto d-flex"><a href="?page=Membres" class="btn btn-primary">Liste des membres</a></div>
            <?php
            }
            ?>
          </div>
        </div>
        <?php

        ////////////////////////////////////////////////////////////////////////////////////////////FORMULAIRE SUPPRIMER
        if ($action == "connection") {

          session_destroy();
          session_start();

          ///////////////////////////////SELECT
          $req_select = $bdd->prepare("SELECT * FROM membres WHERE id=?");
          $req_select->execute(array($_POST['idaction']));
          $ligne_select = $req_select->fetch();
          $req_select->closeCursor();
          $iddpseudo = $ligne_select['id'];
          $logllll = $ligne_select['pseudo'];

          $_SESSION['pseudo'] = "$iddpseudo";
          $_SESSION['4M8e7M5b1R2e8s'] = "A9lKJF0HJ12YtG7WxCl12";


          /*  $sql_select = $bdd->prepare('SELECT * from membres_commandes WHERE user_id=?');
      $sql_select->execute(array(
        intval($_POST['idaction'])
      ));
      $commande = $sql_select->fetch();
      $sql_select->closeCursor();

      var_dump($_POST['idaction']); */

          header("location: /");
        }

        ////////////////////////////////////////////////////////////////////////////////////////////FORMULAIRE SUPPRIMER
        if ($action == "supprimer") {

          echo "<form id='formulaire-supprimer-compte-membre' method='post' action='?page=Membres&amp;action=supprimer2&amp;idaction=" . $idaction . "'>
<div style='text-align: center; max-width: 700px; margin-right: auto; margin-left: auto;'>";

          ///////////////////////////////SELECT
          $req_select = $bdd->prepare("SELECT * FROM membres WHERE id=?");
          $req_select->execute(array($idaction));
          $ligne_select = $req_select->fetch();
          $req_select->closeCursor();
          $idd2dddf = $ligne_select['id'];
          $loginm = $ligne_select['pseudo'];
          $emailm = $ligne_select['mail'];
          $adminm = $ligne_select['admin'];
          $nomm = $ligne_select['nom'];
          $prenomm = $ligne_select['prenom'];
          $demande_de_suppression = $ligne_select['demande_de_suppression'];
          $demande_de_suppression_date = $ligne_select['demande_de_suppression_date'];

          echo "<div style='text-align: left; max-width: 700px;'>
<h2>Supprimer le membre : <br />$loginm (" . $nomm . " " . $prenomm . ")</h2><br /><br />
</div>";

        ?>

          <input id="action" type="hidden" name="action" value="supprimer-action">
          <input id="idaction" type="hidden" name="idaction" value="<?php echo "$idaction"; ?>">

          <h3>Supprimer les données personnelles d'un utilisateur enregistré</h3>

          <?php
          if ($demande_de_suppression == "oui") {
            echo "<div class='alert alert-danger' style='margin-right: 5px; text-align: left; margin-bottom: 0px;' ><b><span class='uk-icon-warning'></span> Demande de suppression pas encore traitée</b>, demandée le " . date('d-m-Y à H:i', $demande_de_suppression_date) . "<br />
</div>";
            echo "<br />";
          }
          ?>

          <div class="well well-sm" style="width: 100%; text-align: left;">
            <table style='text-align: center; width: 100%;' cellpadding='2' cellspacing='2'>
              <tr>
                <td style='text-align: left; font-weight: bold;' colspan='2'>
                  <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <span class="uk-icon-warning"></span> <strong>MODULES MEMBRES :</strong> MODULES MEMBRES : Regroupent tous les modules les plus importants pour le fonctionnement du site internet au niveau des utilisateurs et les administrateurs.
                  </div>
                </td>
              </tr>
              <tr>
                <td style='text-align: left; font-weight: bold;' colspan='2'>SUPPRIMER - MODULES MEMBRES</td>
              </tr>
              <tr>
                <td style='text-align: left;' colspan='2'><input name="MODULES_MEMBRES_SUPPRIMER" class="form-control" type="checkbox" value="oui" style='display: inline-block; width: 10px; height: 10px;' />
                  Les modules membres associés à cette partie, regroupent la plupart des données personnelles des utilisateurs, tels que nom, prénom, adresses ... Les modules membres sont constitués de plusieurs parties : membres, membres professionnels, newsletter mail, ... ATTENTION, les modules membres, constituent les identifiants uniques de connexion qui permettent également d'identifier l'utilisateur sur toutes les interactions entre utilisateurs ou les modules eux mêmes selon le type de site internet. Par cette action également, tous les dossiers, fichiers stockés physiquement seront supprimés intégralement.
                </td>
              </tr>
              <tr>
                <td style='text-align: left;'>&nbsp;</td>
              </tr>
            </table>
          </div>

          <div class="well well-sm" style="width: 100%; text-align: left;">
            <table style='text-align: center; width: 100%;' cellpadding='2' cellspacing='2'>
              <tr>
                <td style='text-align: left; font-weight: bold;' colspan='2'>
                  <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <span class="uk-icon-warning"></span> <strong>MODULES DOCUMENTS COMMERCIAUX :</strong> MODULES DOCUMENTS COMMERCIAUX : Regroupent tous les modules de panier, de facturation ...
                  </div>
                </td>
              </tr>
              <tr>
                <td style='text-align: left; font-weight: bold;' colspan='2'>SUPPRIMER - MODULES DOCUMENTS COMMERCIAUX</td>
              </tr>
              <tr>
                <td style='text-align: left;' colspan='2'><input name="MODULE_DOCUMENTS_COMMERCIAUX_SUPPRIMER" class="form-control" type="checkbox" value="oui" style='display: inline-block; width: 10px; height: 10px;' />
                  Cette action va supprmier le ou les paniers, le cas échéant les factures également ...
                </td>
              </tr>
              <tr>
                <td style='text-align: left;'>&nbsp;</td>
              </tr>
            </table>
          </div>

          <?php
          ////////////////////////////////////////////////////////////SI MODULE PROFIL ACTIVE
          if ($Profil_module == "oui") { ?>
            <div class="well well-sm" style="width: 100%; text-align: left;">
              <table style='text-align: center; width: 100%;' cellpadding='2' cellspacing='2'>
                <tr>
                  <td style='text-align: left; font-weight: bold;' colspan='2'>
                    <div class="alert alert-warning alert-dismissible" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <span class="uk-icon-warning"></span> <strong>MODULES PROFIL :</strong> Les modules associés aux profils, peuvent êtres divers et nécessaires au fonctionnement du site internet dans certains cas, tel qu'un site e-commerce, plateforme ... Ou bien dans l'utilisation de modules de facture ...
                    </div>
                  </td>
                </tr>

                <tr>
                  <td style='text-align: left; font-weight: bold;' colspan='2'>SUPPRIMER - MODULES PROFIL</td>
                </tr>
                <tr>
                  <td style='text-align: left;' colspan='2'><input name="MODULE_PROFIL_SUPPRIMER" class="form-control" type="checkbox" value="oui" style='display: inline-block; width: 10px; height: 10px;' />
                    Par cette action vous supprimez, les données personnelles des modules, profil, et tout ce qui peut s'y rapprocher, tel qu'un avatar, les messages, les données de configuration du compte ou du site internet ... Une action délicate, qu’il faut mesurer pleinement, car dans cette hypothèse il faut mieux supprimer le membre intégralement. Mais attention aux données personnelles légales à conserver le cas échéant si vous disposez d'un module de facturation en ligne sur votre site par exemple.
                  </td>
                </tr>
                <tr>
                  <td style='text-align: left;'>&nbsp;</td>
                </tr>
              </table>
            </div>
          <?php } ?>

          <div class="well well-sm" style="width: 100%; text-align: left;">
            <h3>Notification mail et log</h3>
            <table style='text-align: center; width: 100%;' cellpadding='2' cellspacing='2'>
              <tr>
                <td style='text-align: left; font-weight: bold;' colspan='2'>
                  Envoyer le mail de confirmation de suppression au client des données à caractère personnel, partiellement ou dans son intégralité
                  <select name='MODULE_ENVOYER_MAIL' id='MODULE_ENVOYER_MAIL' class='form-control' style='width: 100px; display: inline-block;'>
                    <option value='non'> Non </option>
                    <option value='oui'> Oui </option>
                  </select>
                </td>
              </tr>

              <tr class='commentaire_log_mail_utilisateur_bloc_supprimer' style='display: none;'>
                <td style='text-align: left;  font-weight: bold;' colspan='2'>Sujet à envoyer lors de la notification mail et du log à l'utilisateur :</td>
              </tr>
              <tr class='commentaire_log_mail_utilisateur_bloc_supprimer' style='display: none;'>
                <td style='text-align: left;' colspan='2'><input name="sujet_log_mail_utilisateur" class="form-control" type="text" value="<?php echo "Notification de suppression de compte sur $nomsiteweb"; ?>" style='width: 100%;' /></td>
              </tr>
              <tr class='commentaire_log_mail_utilisateur_bloc' style='display: none;'>
                <td colspan='2'><br /></td>
              </tr>

              <tr class='commentaire_log_mail_utilisateur_bloc_supprimer' style='display: none;'>
                <td style='text-align: left;  font-weight: bold;' colspan='2'>Commentaire à envoyer lors de la notification mail et du log à l'utilisateur :</td>
              </tr>
              <tr class='commentaire_log_mail_utilisateur_bloc_supprimer' style='display: none;'>
                <td style='text-align: left;' colspan='2'>
                  <textarea name='commentaire_log_mail_utilisateur' id='commentaire_log_mail_utilisateur' class='mceEditor' style='width: 100%; height: 100px;'><?php echo "Nous avons procédé à votre demande de suppression de vos données personnelles sur notre site internet."; ?></textarea>
                </td>
              </tr>
              <tr class='commentaire_log_mail_utilisateur_bloc_supprimer' style='display: none;'>
                <td style='text-align: left;'>&nbsp;</td>
              </tr>

            </table>
          </div>

          <table style='text-align: center; width: 100%;' cellpadding='2' cellspacing='2'>
            <tr>
              <td colspan='2' style='text-align: center;'>
                <button id='supprimer-compte-membre-submit' type='button' class='btn btn-success' onclick="return false;" style='width: 150px;'>CONFIRMER</button>
              </td>
            </tr>
          </table>

      </div>

      </form>
      <br /><br />

      <?php
        }


        ////////////////////////////////////////////////////////////////////////////////////////////FORMULAIRE AJOUTER - MODIFIER
        if ($action == "Ajouter" || $action == "Modifier") {

          if ($action == "Modifier") {
            $req_select = $bdd->prepare("SELECT * FROM membres WHERE id=?");
            $req_select->execute(array($idaction));
            $ligne_select = $req_select->fetch();
            $req_select->closeCursor();
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
            $zone = $ligne_select['zone'];
            $Code_securite = $ligne_select['Code_securite'];

            $CSP = $ligne_select['CSP'];
            $Votre_quartier = $ligne_select['Votre_quartier'];
            $Decrivez_un_peut_plus_chez_vous = $ligne_select['Decrivez_un_peut_plus_chez_vous'];
            $Complement_d_adresse = $ligne_select['Complement_d_adresse'];

            $message_administrateur = $ligne_select['message_administrateur'];
            $message_livraison = $ligne_select['message_livraison'];
            $message_commande = $ligne_select['message_commande'];
            $message_liste_souhait = $ligne_select['message_liste_souhait'];

            $numero_client = $ligne_select['numero_client'];
            $Abonnement_id = $ligne_select['Abonnement_id'];
            $Abonnement_date  = $ligne_select['Abonnement_date'];
            $Abonnement_date_expiration = $ligne_select['Abonnement_date_expiration'];




            $sql_select = $bdd->prepare('SELECT * from membres_commandes WHERE user_id=?');
            $sql_select->execute(array(
              intval($idaction)
            ));
            $commande = $sql_select->fetch();
            $sql_select->closeCursor();

            if ($Abonnement_date_expiration > time()) {
              $nbr_jour_abonnement = ($Abonnement_date_expiration - time());
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

            if (!empty($Abonnement_date)) {
              $Abonnement_date = date('d-m-Y', $Abonnement_date);
            } else {
              $Abonnement_date = "-";
            }
            if (!empty($Abonnement_date_expiration)) {
              $Abonnement_date_expiration = date('d-m-Y', $Abonnement_date_expiration);
            } else {
              $Abonnement_date_expiration = "-";
            }

            $req_selecta = $bdd->prepare("SELECT * FROM configurations_abonnements WHERE id=?");
            $req_selecta->execute(array($Abonnement_id));
            $ligne_selecta = $req_selecta->fetch();
            $req_selecta->closeCursor();
            $nom_abonnement = $ligne_selecta['nom_abonnement'];
            if (empty($nom_abonnement)) {
              $nom_abonnement = "Il n'y a pas d'abonnement";
            }
      ?>

        <form id='formulaire-modifier-compte-membre' method='post' action='#'>
          <input name="idaction" class="form-control" type="hidden" value="<?php echo "$idaction"; ?>" style='width: 100%;' />
          <input name="action" class="form-control" type="hidden" value="<?php echo "Modifier-action"; ?>" style='width: 100%;' />

          <div style='text-align: center; max-width: 700px; margin-right: auto; margin-left: auto;'>
            <div style='text-align: left;'>
              <h2>Modifier le membre</h2><br /><br />

            </div>

          <?php
            $req_select_entreprise = $bdd->prepare("SELECT * FROM membres_professionnel WHERE id_membre=?");
            $req_select_entreprise->execute(array($idaction));
            $ligne_select_entreprise = $req_select_entreprise->fetch();
            $req_select_entreprise->closeCursor();
            $identreprise = $ligne_select_entreprise['id'];
            $Nom_societe = $ligne_select_entreprise['Nom_societe'];
            $Numero_identification = $ligne_select_entreprise['Numero_identification'];
          } elseif ($action == "Ajouter") {
          ?>

            <form id='formulaire-modifier-compte-membre-ajouter' method='post' action='#'>
              <input name="idaction" class="form-control" type="hidden" value="<?php echo "$idaction"; ?>" style='width: 100%;' />
              <input name="action" class="form-control" type="hidden" value="Ajouter-action" style='width: 100%;' />

              <div style='text-align: center; max-width: 700px; margin-right: auto; margin-left: auto;'>
                <div style='text-align: left;'>
                  <h2>Ajouter un membre</h2><br /><br />
                </div>

              <?php } ?>

              <?php
              //NOMBRE DE COMMANDES
              $req_nbr_commandes = $bdd->prepare("SELECT COUNT(*) AS nombre_de_commandes FROM membres_commandes WHERE user_id = ? AND type = 2;");
              $req_nbr_commandes->execute(array($idaction));
              $ligne_nbr_commandes = $req_nbr_commandes->fetch();
              $req_nbr_commandes->closeCursor();
              $nombre_de_commandes = $ligne_nbr_commandes['nombre_de_commandes'];

              //NOMBRE DE DEMANDES DE SOUHAITS
              $req_nbr_demandes_souhaits = $bdd->prepare("SELECT COUNT(*) AS nombre_de_demandes_souhaits FROM membres_souhait WHERE user_id = ?;");
              $req_nbr_demandes_souhaits->execute(array($idaction));
              $ligne_nbr_demandes_souhaits = $req_nbr_demandes_souhaits->fetch();
              $req_nbr_demandes_souhaits->closeCursor();
              $nombre_de_demandes_souhaits = $ligne_nbr_demandes_souhaits['nombre_de_demandes_souhaits'];


              //NOMBRE DE LIVRAISONS & COLIS
              $req_nbr_livraisons = $bdd->prepare("SELECT COUNT(*) AS nombre_de_livraisons FROM membres_colis WHERE user_id = ?;");
              $req_nbr_livraisons->execute(array($idaction));
              $ligne_nbr_livraisons = $req_nbr_livraisons->fetch();
              $req_nbr_livraisons->closeCursor();
              $nombre_de_livraisons = $ligne_nbr_livraisons['nombre_de_livraisons'];


              //NOMBRE DE FACTURES
              $req_nbr_factures = $bdd->prepare("SELECT COUNT(*) AS nombre_de_factures FROM membres_prestataire_facture WHERE id_membre = ?;");
              $req_nbr_factures->execute(array($idaction));
              $ligne_nbr_factures = $req_nbr_factures->fetch();
              $req_nbr_factures->closeCursor();
              $nombre_de_factures = $ligne_nbr_factures['nombre_de_factures'];
              ?>
              <div style="margin-bottom: 20px; text-align: left;">
                <a href="?page=Commandes&amp;idmembre=<?php echo $idd2dddf; ?>" target="blank_"><button type="button" class="btn btn-info" style="margin-right: 5px; margin-bottom: 5px; "><span class="uk-icon-file"></span> Commandes (<?php echo $nombre_de_commandes ?>)</button></a>
                <a href="?page=Demandes-de-souhaits&amp;idmembre=<?php echo $idd2dddf; ?>" target="blank_"><button type="button" class="btn btn-info" style="margin-right: 5px; margin-bottom: 5px;"><span class="uk-icon-file"></span> Listes de souhaits (<?php echo $nombre_de_demandes_souhaits ?>)</button></a>
                <a href="?page=Envoyer-colis&amp;idmembre=<?php echo $idd2dddf; ?>" target="blank_"><button type="button" class="btn btn-info" style="margin-right: 5px; margin-bottom: 5px;"><span class="uk-icon-file"></span> Livraisons &amp; Colis (<?php echo $nombre_de_livraisons ?>)</button></a>
                <a href="?page=Facturations&amp;idmembre=<?php echo $idd2dddf; ?>" target="blank_"><button type="button" class="btn btn-info" style="margin-right: 5px; margin-bottom: 5px;"><span class="uk-icon-file"></span> Factures (<?php echo $nombre_de_factures ?>) </button></a>
              </div>

              <div class="well well-sm" style="width: 100%; text-align: left;">
                <h3>Compte</h3>
                <table style='text-align: center; width: 100%;' cellpadding='2' cellspacing='2'>

                  <tr>
                    <td style='text-align: left; min-width: 120px;'><strong>N°client</strong></td>
                    <td style='text-align: left;'>
                      <?php echo $numero_client; ?>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>

                  <tr>
                    <td style='text-align: left; width: 150px; font-weight: bold;'>Activer Compte : </td>
                    <td style='text-align: left;'>
                      <select name="activer" id="activer" class="form-control" style='width: 100%;' required>
                        <option value="Non" <?php if ($ActiverActiver == "Non") {
                                              echo "selected";
                                            } ?>> <?php echo "Non"; ?></option>
                        <option value="Oui" <?php if ($ActiverActiver == "Oui") {
                                              echo "selected";
                                            } ?>> <?php echo "Oui"; ?></option>
                      </select>
                    </td>
                  </tr>

                  <tr>
                    <td style='text-align: left; min-width: 120px;'><strong>Email</strong></td>
                    <td style='text-align: left;'>
                      <input name="email" class="form-control" type="text" value="<?php echo "$emailm"; ?>" style='width: 100%;' required />
                    </td>
                  </tr>

                  <tr>
                    <td style='text-align: left;'><strong>Password</strong></td>
                    <td style='text-align: left;'>
                      <input name="passwordpost" class="form-control" type="text" value="" style='width: 100%;' required />
                    </td>
                  </tr>

                  <tr>
                    <td style='text-align: left;'><strong>STATUT</strong></td>
                    <td style='text-align: left;'><label>
                        <select name="admin" class="form-control" id="admin" required>
                          <option <?php if ($adminm == 0) {
                                    echo "selected";
                                  } ?> value="0"> <?php echo "Membre"; ?> </option>
                          <option <?php if ($adminm == 1) {
                                    echo "selected";
                                  } ?> value="1"> <?php echo "Admin"; ?> </option>
                        </select></td>
                  </tr>

                </table>
              </div>

              <div class="well well-sm" style="width: 100%; text-align: left;">
                <h3>Abonnement</h3>
                <table style='text-align: center; width: 100%;' cellpadding='2' cellspacing='2'>

                  <tr>
                    <td style='text-align: left; min-width: 120px;'><strong>Aboonnement</strong></td>
                    <td style='text-align: left;'>
                      <?php echo "$nom_abonnement"; ?>
                    </td>
                  </tr>

                  <tr>
                    <td style='text-align: left; min-width: 120px;'><strong>Date commande</strong></td>
                    <td style='text-align: left;'>
                      <?php echo "$Abonnement_date"; ?>
                    </td>
                  </tr>

                  <tr>
                    <td style='text-align: left; min-width: 120px;'><strong>Expire le, </strong></td>
                    <td style='text-align: left;'>
                      <?php echo "$Abonnement_date_expiration"; ?>
                    </td>
                  </tr>

                  <tr>
                    <td style='text-align: left; min-width: 120px;'><strong>Reste jour</strong></td>
                    <td style='text-align: left;'>
                      <?php echo "$nbr_jour_abonnement"; ?>
                    </td>
                  </tr>

                  <tr>
                    <td style='text-align: left; min-width: 120px;'><strong>Gestion de l'abonnement</strong></td>
                    <td style='text-align: left;'>
                      <a href="?page=Abonnes&action=Modifier&idaction=<?php echo $idd2dddf; ?>" target="blank_"><button type="button" class="btn btn-info" style="margin-right: 5px; margin-bottom: 5px;"><span class="uk-icon-file"></span> Abonnement </button></a>
                    </td>
                  </tr>

                </table>
              </div>

              <div id="bie" class="well well-sm" style="width: 100%; text-align: left; <?php echo ($_GET['action'] == "Modifier" && $statut_compte == 2) ? "display: '';" : "display: none;"; ?>">
                <h3>Informations entreprises</h3>
                <table style='text-align: center; width: 100%;' cellpadding='2' cellspacing='2'>

                  <tr>
                    <td style='text-align: left; min-width: 120px;'>Nom société</td>
                    <td style='text-align: left;'>
                      <input name="Nom_societe" class="form-control" type="text" id="Nom_societe" value="<?php echo "$Nom_societe"; ?>" style='width: 100%; min-width: 200px;' />
                    </td>
                  </tr>

                  <tr>
                    <td style='text-align: left; min-width: 120px;'>Numéro identification</td>
                    <td style='text-align: left;'>
                      <input name='Numero_identification' class='form-control' type='text' id='Numero_identification' value="<?php echo "$Numero_identification"; ?>" style='width: 100%; min-width: 200px;' />
                    </td>
                  </tr>

                </table>
              </div>

              <div class="well well-sm" style="width: 100%; text-align: left;">
                <h3>Informations personnelles</h3>
                <table style='text-align: center; width: 100%;' cellpadding='2' cellspacing='2'>

                  <tr>
                    <td style='text-align: left; min-width: 120px;'>Nom</td>
                    <td style='text-align: left;'>
                      <input name="nom" class="form-control" type="text" id="nom" value="<?php echo "$nomm"; ?>" style='width: 100%; min-width: 200px;' required />
                    </td>
                  </tr>

                  <tr>
                    <td style='text-align: left; min-width: 120px;'>Pr&eacute;nom</td>
                    <td style='text-align: left;'>
                      <input name='prenom' class='form-control' type='text' id='prenom' value="<?php echo "$prenomm"; ?>" style='width: 100%; min-width: 200px;' required />
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>

                  <tr>
                    <td style='text-align: left; min-width: 120px;'>Date de naissance</td>
                    <td style='text-align: left;'>
                      <input type="date" id="datenaissance" name="datenaissance" class="form-control" placeholder="Date de naissance" value="199999999999" style="">
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>

                  <tr>
                    <td style='text-align: left; min-width: 120px;'>Code de paiement mobile</td>
                    <td style='text-align: left;'>
                      <input name='Code_securite' class='form-control' type='text' value="<?php echo "$Code_securite"; ?>" maxlength="6" style='width: 100%; min-width: 200px;' required />
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>

                  <tr>
                    <td style='text-align: left; min-width: 120px;'>CSP</td>
                    <td style='text-align: left;'>
                      <select id="CSP" name="CSP" class="form-control" style='margin-bottom: 15px;'>
                        <option <?php if ($CSP == "Elève") {
                                  echo "selected";
                                } ?> value="Elève">Elève</option>
                        <option <?php if ($CSP == "Etudiant") {
                                  echo "selected";
                                } ?> value="Etudiant">Etudiant</option>
                        <option <?php if ($CSP == "Salarié") {
                                  echo "selected";
                                } ?> value="Salarié">Salarié</option>
                        <option <?php if ($CSP == "Sans activité") {
                                  echo "selected";
                                } ?> value="Sans activité">Sans activité</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>

                  <tr>
                    <td style='text-align: left; min-width: 120px;'>Téléphone</td>
                    <td style='text-align: left;'>
                      <input name='telephonepost' class='form-control' type='text' value="<?php echo "$telephonepost"; ?>" style='width: 100%; min-width: 200px;' required />
                    </td>
                  </tr>

                  <tr>
                    <td style='text-align: left; min-width: 120px;'>Téléphone Portable</td>
                    <td style='text-align: left;'>
                      <input id="Telephone_portable" name='Telephone_portable' class='form-control' type='text' value="<?php echo "$Telephone_portable"; ?>" style='width: 100%; min-width: 200px;' required />
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>

                  <tr>
                    <td style='text-align: left; min-width: 120px;'>Adresse</td>
                    <td style='text-align: left;'>
                      <input name='adresse' class='form-control' type='text' value="<?php echo "$adresse"; ?>" style='width: 100%; min-width: 200px;' required />
                    </td>

                  <tr>
                    <td style='text-align: left; min-width: 120px;'>Ville</td>
                    <td style='text-align: left;'>
                      <input name='ville' class='form-control' type='text' value="<?php echo "$ville"; ?>" style='width: 100%; min-width: 200px;' required />
                    </td>
                  </tr>

                  <tr>
                    <td style='text-align: left; min-width: 120px;'>Zone</td>
                    <td style='text-align: left;'>
                      <input name='zone' class='form-control' type='text' value="<?php echo "$zone"; ?>" style='width: 100%; min-width: 200px;' required />
                    </td>
                  </tr>

                  <tr class="france">
                    <td style='text-align: left; min-width: 120px;'>Code postal</td>
                    <td style='text-align: left;'>
                      <input id="Code_postal" name='cp' class='form-control' type='text' value="<?php echo "$cp"; ?>" style='width: 100%; min-width: 200px;' required />
                    </td>
                  </tr>

                  <tr class="gabon">
                    <td style='text-align: left; min-width: 120px;'>Votre quartier</td>
                    <td style='text-align: left;'>
                      <input type="text" id='Votre_quartier' name='Votre_quartier' class="form-control" placeholder="" value="<?php echo "$Votre_quartier"; ?>" style='<?php echo "$coloorpaaa"; ?>' />
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>

                  <tr>
                    <td style='text-align: left; min-width: 120px;'>Pays</td>
                    <td style='text-align: left;'>
                      <select class="form-control" id="Pays" name="Pays" placeholder="*Pays" style='<?php echo "$coloorc"; ?>'>
                        <?php
                        $req_pays = $bdd->query("SELECT * FROM pays ORDER BY pays ASC");
                        while ($pays = $req_pays->fetch()) { ?>
                          <?php if ($pays["sigle"] == "FR") { ?>
                            <option value="<?= $pays["pays"] ?>" selected='selected'> <?= $pays["pays"] ?> </option>
                          <?php } else { ?>
                            <option value="<?= $pays["pays"] ?>"> <?= $pays["pays"] ?> </option>
                          <?php } ?>
                        <?php }
                        $req_pays->closeCursor(); ?>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>

                  <tr class="gabon">
                    <td colspan="2" style='text-align: left; min-width: 120px;'>Décrivez un peut plus chez vous</td>
                  </tr>
                  <tr class="gabon">
                    <td colspan="2" style='text-align: left;'>
                      <textarea id='Decrivez_un_peut_plus_chez_vous' name='Decrivez_un_peut_plus_chez_vous' class="form-control" placeholder="<?php echo "Décrivez un peut plus chez vous"; ?>" style='<?php echo "$coloorpaaa"; ?> height: 100px; width: 100%;;' /><?php echo "$Decrivez_un_peut_plus_chez_vous"; ?></textarea>
                    </td>
                  </tr>
                  <tr class="gabon">
                    <td>&nbsp;</td>
                  </tr>

                  <tr class="france">
                    <td colspan="2" style='text-align: left; min-width: 120px;'>Complément d'adresse</td>
                  </tr>
                  <tr class="france">
                    <td colspan="2" style='text-align: left;'>
                      <textarea id='Complement_d_adresse' name='Complement_d_adresse' class="form-control" placeholder="<?php echo "Complément d'adresse"; ?>" style='<?php echo "$coloorpaaa"; ?> height: 100px; width: 100%;' /><?php echo "$Complement_d_adresse"; ?></textarea>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>

                </table>
              </div>


              <div class="well well-sm" style="width: 100%; text-align: left;">
                <h3>Encaissements</h3>
                <table style='text-align: center; width: 100%;' cellpadding='2' cellspacing='2'>

                  <?php
                  $hasNonPaye = false;

                  if (isset($commande['dette_payee_pf']) && $commande['dette_payee_pf'] === 'Non payé') {
                    echo "<p>Dette Montant : " . $commande['dette_montant_pf'] . "</p>";
                    $hasNonPaye = true;
                  }

                  if (isset($commande['dette_payee_pf2']) && $commande['dette_payee_pf2'] === 'Non payé') {
                    echo "<p>Dette Montant : " . $commande['dette_montant_pf2'] . "</p>";
                    $hasNonPaye = true;
                  }

                  if (isset($commande['dette_payee_pf3']) && $commande['dette_payee_pf3'] === 'Non payé') {
                    echo "<p>Dette Montant : " . $commande['dette_montant_pf3'] . "</p>";
                    $hasNonPaye = true;
                  }

                  if (!$hasNonPaye) {

                    echo "<p>Il n'y a pas de dates à venir</p>";
                  }
                  ?>

                </table>
              </div>


              <br />
              <button id='modifier-compte-membre' type='button' class='btn btn-success' onclick="return false;" style='width: 150px;'>ENREGISTRER</button>
              <br />
              <br />
              <br />

              <div class="well well-sm" style="width: 100%; text-align: left;">
                <h3>Messages</h3>
                <table style='text-align: center; width: 100%;' cellpadding='2' cellspacing='2'>

                  <tr>
                    <td colspan="2" style='text-align: left; min-width: 120px;'>Message administrateur</td>
                  </tr>
                  <tr>
                    <td colspan="2" style='text-align: left;'>
                      <textarea id='message_administrateur' name='message_administrateur' class="form-control" placeholder="" style='<?php echo "$coloorpaaa"; ?> height: 80px; width: 100%;' /><?php echo "$message_administrateur"; ?></textarea>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>

                  <tr>
                    <td colspan="2" style='text-align: left; min-width: 120px;'>Message commande</td>
                  </tr>
                  <tr>
                    <td colspan="2" style='text-align: left;'>
                      <textarea id='message_commande' name='message_commande' class="form-control" placeholder="" style='<?php echo "$coloorpaaa"; ?> height: 80px; width: 100%;' /><?php echo "$message_commande"; ?></textarea>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>

                  <tr>
                    <td colspan="2" style='text-align: left; min-width: 120px;'>Message colis et livraison</td>
                  </tr>
                  <tr>
                    <td colspan="2" style='text-align: left;'>
                      <textarea id='message_livraison' name='message_livraison' class="form-control" placeholder="" style='<?php echo "$coloorpaaa"; ?> height: 80px; width: 100%;' /><?php echo "$message_livraison"; ?></textarea>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>

                  <tr>
                    <td colspan="2" style='text-align: left; min-width: 120px;'>Message liste de souhaits</td>
                  </tr>
                  <tr>
                    <td colspan="2" style='text-align: left;'>
                      <textarea id='message_liste_souhait' name='message_liste_souhait' class="form-control" placeholder="" style='<?php echo "$coloorpaaa"; ?> height: 80px; width: 100%;' /><?php echo "$message_liste_souhait"; ?></textarea>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>

                </table>
              </div>

              <br />
              <button id='modifier-compte-membre' type='button' class='btn btn-success' onclick="return false;" style='width: 150px;'>ENREGISTRER</button>

            </form>

          <?php
        }

        if (!isset($action)) {
          ?>
          

            <div id='liste-compte-membre' style='clear: both;'></div>

          <?php
        }

          ?>
          </div>
    </div>
  </div>
<?php
} else {
  header('location: /index.html');
}
?>