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
  isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 4
) {

  $action = $_GET['action'];
  $idaction = $_GET['idaction'];

?>

  <script>
    $(document).ready(function() {

      //AJAX SOUMISSION DU FORMULAIRE - MODIFIER - AJOUTER
      $(document).on("click", "#bouton-formulaire-page", function() {
        //ON SOUMET LE TEXTAREA TINYMCE
        tinyMCE.triggerSave();
        $.post({
          url: '/administration/Pages/Pages-categories/pages-categories-action-ajouter-modifier-ajax.php',
          type: 'POST',
          <?php if ($_GET['action'] == "modifier") { ?>
            data: new FormData($("#formulaire-gestion-des-pages-modifier")[0]),
          <?php } else { ?>
            data: new FormData($("#formulaire-gestion-des-pages-ajouter")[0]),
          <?php } ?>
          processData: false,
          contentType: false,
          dataType: "json",
          success: function(res) {
            if (res.retour_validation == "ok") {
              popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
              <?php if ($_GET['action'] != "modifier") { ?>
                $("#formulaire-gestion-des-pages-ajouter")[0].reset();
              <?php } ?>
            } else {
              popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
            }
          }
        });
        $("html, body").animate({ scrollTop: 0 }, "slow");
        listeGestionPageCategorie();
      });

      //AJAX - SUPPRIMER
      $(document).on("click", ".lien-supprimer-categorie-page", function() {
        $.post({
          url: '/administration/Pages/Pages-categories/pages-categories-action-supprimer-ajax.php',
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
          }
        });
        listeGestionPageCategorie();
      });

      //FUNCTION AJAX - LISTE
      function listeGestionPageCategorie() {
        $.post({
          url: '/administration/Pages/Pages-categories/pages-categories-liste-ajax.php',
          type: 'POST',
          dataType: "html",
          success: function(res) {
            $("#liste-des-categories-des-pages").html(res);
          }
        });
      }
      listeGestionPageCategorie();

      $(document).on('click', '#btnSupprModal', function(){
        $.post({
          url: '/administration/Pages/Pages-categories/modal-supprimer-ajax.php',
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
        // $(".modal").show();
        $.post({
          url: '/administration/Pages/Pages-categories/pages-categories-action-supprimer-ajax.php',
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
            listeGestionPageCategorie();
            $("#modalSuppr").modal('hide')
            // $("#modalSuppr").hide(1000);
            // $(this).hide(1000);
          }
        });
      });
      
      $(document).on("click", "#btnNon", function() {
        $("#modalSuppr").modal('hide')
      });

      $(document).on('hidden.bs.modal', "#modalSuppr", function(){
        $(this).remove()
      })
    });
  </script>

  <ol class="breadcrumb">
    <li><a href="<?php echo $http; ?><?php echo $nomsiteweb; ?>">Accueil</a></li>
    <li><a href="<?php echo $mode_back_lien_interne; ?>">Administration</a></li>
    <?php if (empty($_GET['action'])) { ?> <li class="active">Gestion des catégories</li> <?php } else { ?> <li><a href="?page=Categories">Gestion des catégories</a></li> <?php } ?>
    <?php if ($_GET['action'] == "modification") { ?> <li class="active">Modifications</li> <?php } ?>
    <?php if ($_GET['action'] == "add") { ?> <li class="active">Ajouter</li> <?php } ?>
  </ol>

  <div id='bloctitre' style='text-align: left;'>
    <h1>Gestion des catégories</h1>
  </div><br />
  <div style='clear: both;'></div>

  <?php

  ////////////////////Boutton administration
  echo "<a href='" . $mode_back_lien_interne . "' style='float: left; text-decoration: none; margin-right: 5px;'><button type='button' class='btn btn-default' style='margin-right: 5px;' ><span class='uk-icon-cogs'></span> Administration</button></a>";
  echo "<a href='?page=Categories&amp;action=ajouter'><button type='button' class='btn btn-success' style='margin-right: 5px;' ><span class='uk-icon-plus-circle'></span> Ajouter une catégorie</button></a>";
  if (!empty($action)) {
    echo "<a href='?page=Categories'><button type='button' class='btn btn-success' style='margin-right: 5px;' ><span class='uk-icon-history'></span> Catégories</button></a>";
  }
  echo "<div style='clear: both;'></div><br />";
  ////////////////////Boutton administration
  ?>

  <div style='padding: 5px; text-align: center;'>

    <?php

    ////////////////////////////FORMULAIRE AJOUTER / MODIFIER
    if ($action == "ajouter" || $action == "modifier") {

      if ($action == "modifier") {

        ///////////////////////////////SELECT
        $req_select = $bdd->prepare("SELECT * FROM pages_categories WHERE id=?");
        $req_select->execute(array($idaction));
        $ligne_select = $req_select->fetch();
        $req_select->closeCursor();
        $idoneinfos = $ligne_select['id'];
        $description = $ligne_select['description'];
        $description_footer = $ligne_select['description_footer'];
        $title = $ligne_select['title'];
        $description_meta = $ligne_select['description_meta'];
        $keywords_meta = $ligne_select['keywords_meta'];
        $nom_categorie = $ligne_select['nom_categorie'];
        $nom_categorie_url = $ligne_select['nom_categorie_url'];
        $activer = $ligne_select['activer'];
        $position = $ligne_select['position'];
        $video_youtube_header = $ligne_select['video_youtube_header'];
        $video_youtube_footer = $ligne_select['video_youtube_footer'];

        if ($activer == "oui") {
          $selectedstatut1 = "selected='selected'";
        } elseif ($activer == "non") {
          $selectedstatut2 = "selected='selected'";
        }

    ?>

        <div align='left'>
          <h2>Modifier la catégorie <?php echo "$nom_categorie"; ?></h2>
        </div><br />
        <div style='clear: both;'></div>

        <form id='formulaire-gestion-des-pages-modifier' method="post" action="?page=Categories&amp;action=modifier-action&amp;idaction=<?php echo "$idaction"; ?>">
          <input id="action" type="hidden" name="action" value="modifier-action">
          <input id="idaction" type="hidden" name="idaction" value="<?php echo $_GET['idaction']; ?>">

        <?php
      } else {
        ?>

          <div align='left'>
            <h2>Ajouter une catégorie</h2>
          </div><br />
          <div style='clear: both;'></div>

          <form id='formulaire-gestion-des-pages-ajouter' method="post" action="?page=Categories&amp;action=ajouter-action&amp;idaction=<?php echo "$idaction"; ?>">
            <input id="action" type="hidden" name="action" value="ajouter-action">

          <?php
        }
          ?>

          <table style="text-align: left; width: 100%; text-align: center;" cellpadding="2" cellspacing="2">
            <tbody>

              <tr>
                <td style="text-align: left; width: 190px;">Nom</td>
                <td style="text-align: left;"><input type='text' class='form-control' placeholder="Nom" name='nom_categorie' value="<?php echo "$nom_categorie"; ?>" style='width: 100%;' /></td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>

              <tr>
                <td style="text-align: left; width: 190px;">Statut</td>
                <td style="text-align: left;">
                  <select name="activer" class="form-control">
                    <option <?php echo "$selectedstatut1"; ?> value='oui'> Activée &nbsp; &nbsp;</option>
                    <option <?php echo "$selectedstatut2"; ?> value='non'> Désactivée &nbsp; &nbsp;</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>

              <tr>
                <td style="text-align: left; width: 190px;">Position</td>
                <td style="text-align: left;">
                  <input type='text' class="form-control" name="position" value="<?php echo "$position"; ?>" style='width: 50px; margin-right: 5px; display: inline-block;' />
                </td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>

              <div id='description'>
                <table style="text-align: left; width: 100%;" cellpadding="2" cellspacing="2">
                  <tbody>
                    <tr>
                      <td colspan="2">
                        <hr />
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" style="text-align: left; vertical-align: top; width: 190px;">Description Header</td>
                    </tr>
                    <tr>
                      <td colspan="2" style="text-align: right;">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="2" style="text-align: left;"><textarea id='description' name='description' style='width: 100%; height: 60px;'><?php echo "$description"; ?></textarea></td>
                    </tr>
                  </tbody>
                </table><br /><br />
              </div>

              <div id='description_footer'>
                <table style="text-align: left; width: 100%;" cellpadding="2" cellspacing="2">
                  <tbody>
                    <tr>
                      <td colspan="2" style="text-align: left; vertical-align: top; width: 190px;">Description Footer</td>
                    </tr>
                    <tr>
                      <td colspan="2" style="text-align: right;">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="2" style="text-align: left;"><textarea id='description_footer' name='description_footer' style='width: 100%; height: 60px;'><?php echo "$description_footer"; ?></textarea></td>
                    </tr>
                  </tbody>
                </table><br /><br />
              </div>

              <div id='video_youtube_header'>
                <table style="text-align: left; width: 100%;" cellpadding="2" cellspacing="2">
                  <tbody>
                    <tr>
                      <td colspan="2">
                        <hr />
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" style="text-align: left; vertical-align: top; width: 190px;">Vidéo Iframe Youtube Header</td>
                    </tr>
                    <tr>
                      <td colspan="2" style="text-align: right;">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="2" style="text-align: left;"><textarea id='video_youtube_header' name='video_youtube_header' style='width: 100%; height: 60px;'><?php echo "$video_youtube_header"; ?></textarea></td>
                    </tr>
                  </tbody>
                </table><br /><br />
              </div>

              <div id='video_youtube_footer'>
                <table style="text-align: left; width: 100%;" cellpadding="2" cellspacing="2">
                  <tbody>
                    <tr>
                      <td colspan="2" style="text-align: left; vertical-align: top; width: 190px;">Vidéo Iframe Youtube Footer</td>
                    </tr>
                    <tr>
                      <td colspan="2" style="text-align: right;">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="2" style="text-align: left;"><textarea id='video_youtube_footer' name='video_youtube_footer' style='width: 100%; height: 60px;'><?php echo "$video_youtube_footer"; ?></textarea></td>
                    </tr>
                  </tbody>
                </table><br /><br />
              </div>

              <table style="text-align: left; width: 100%; text-align: center;" border="0" cellpadding="2" cellspacing="2">
                <tbody>

                  <tr>
                    <td colspan="2">
                      <hr />
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2" style="text-align: left;" ;>
                      <h3>Référencement SEO</h3>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2"><br /></td>
                  </tr>

                  <tr>
                    <td style="text-align: left; vertical-align: top; width: 190px;">Title</td>
                    <td style="text-align: left;"><input id='title' name='title' class='form-control' placeholder="Une phrase maximum" style='width: 100%;' value="<?php echo "$title"; ?>"></td>
                  </tr>
                  <tr>
                    <td colspan="2"><br /></td>
                  </tr>

                  <tr>
                    <td style="text-align: left; vertical-align: top; width: 190px;">Méta déscription</td>
                    <td style="text-align: left;"><textarea id='description_meta' name='description_meta' class='form-control' placeholder="Une phrase ou deux maximum" style='width: 100%; height: 90px;'><?php echo "$description_meta"; ?></textarea></td>
                  </tr>
                  <tr>
                    <td colspan="2"><br /></td>
                  </tr>

                  <tr>
                    <td style="text-align: left; vertical-align: top; width: 190px;">Méta mots clés</td>
                    <td style="text-align: left;"><textarea id='keywords_meta' name='keywords_meta' class='form-control' placeholder="Mot 1, Mot 2, Mot 3, Mot 4 ..." style='width: 100%; height: 90px;'><?php echo "$keywords_meta"; ?></textarea></td>
                  </tr>

                  <tr>
                    <td colspan="2">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="2">&nbsp;</td>
                  </tr>

                  <tr>
                    <td colspan="2" style="text-align: center;">
                      <button id='bouton-formulaire-page' type='button' class='btn btn-success' onclick="return false;" style='width: 150px;'>ENREGISTRER</button>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2">&nbsp;</td>
                  </tr>
                </tbody>
              </table>
              <br /><br />

            <?php
          }
          ////////////////////////////FORMULAIRE AJOUTER / MODIFIER


          /////////////////////////////////////////Si aucune action
          if (!isset($action)) {
            ?>

              <!-- LISTE DES CATEGORIES DES PAGES -->
              <div id='liste-des-categories-des-pages'></div>

          <?php
          }
          /////////////////////////////////////////Si aucune action

          echo "</div>";
        } else {
          header('location: /index.html');
        }
          ?>