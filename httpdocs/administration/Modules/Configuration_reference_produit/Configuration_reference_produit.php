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
    // imageProduit.onchange = evt => {
    //   const [file] = imgInp.files
    //   if (file) {
    //     preview.style.display ="";
    //     preview.src = URL.createObjectURL(file)
    //   }
    // }
    $(document).ready(function() {

      //AJAX SOUMISSION DU FORMULAIRE - MODIFIER - AJOUTER
      $(document).on("click", "#Configuration_reference_produit", function() {

        $.post({
          url: '/administration/Modules/Configuration_reference_produit/Configuration_reference_produit_modifier_ajax.php',
          type: 'POST',
          <?php if ($_GET['action'] == "Modifier") { ?>
            data: new FormData($("#formulaire_modifier_configuration_reference_produit")[0]),
          <?php } else { ?>
            data: new FormData($("#Configuration_reference_produit_ajouter")[0]),
          <?php } ?>
          processData: false,
          contentType: false,
          dataType: "json",
          success: function(res) {
            if (res.retour_validation == "ok") {
              console.log(res.Texte_rapport);
              popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
              <?php if ($_GET['action'] != "Modifier") { ?>
                $("#configurations_references_produits")[0].reset();
              <?php } ?>
            } else {
              popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
            }
          },
          error: function(xhtml, error, code) {
            console.log(xhtml.responseText);
          }
        });
        liste - produit();
      });

      //FUNCTION AJAX - LISTE Produit
      function listeproduit() {
        $.post({
          url: '/administration/Modules/Configuration_reference_produit/Configuration_reference_produit_liste_ajax.php',
          type: 'POST',
          dataType: "html",
          success: function(res) {
            $("#liste-produit").html(res);
          }
        });
      }
      listeproduit();

      let btn = document.getElementById('addNewColor');
      let allColor = document.getElementById('allColor');
      btn.addEventListener('click', () => {
        // alert('ici');
        let newDiv = document.createElement('div');
        let newInput = document.createElement('input');
        newInput.setAttribute('type', 'color');

        let closeBtn = document.createElement('button');
        let btnText = document.createTextNode('Retirer');

        let id = Date.now();
        newDiv.setAttribute('id', id);
        closeBtn.setAttribute('onclick', 'event.preventDefault();retirer(' + id + ')');
        closeBtn.appendChild(btnText);
        newDiv.appendChild(newInput);
        newDiv.appendChild(closeBtn);
        allColor.appendChild(newDiv);
      });

      function retirer(id) {
        let div = document.getElementById(id);
        div.remove();
      }

    });
  </script>

  <?php

  $action = $_GET['action'];
  $idaction = $_GET['idaction'];
  ?>

  <ol class="breadcrumb">
    <li><a href="<?php echo $http; ?><?php echo $nomsiteweb; ?>">Accueil</a></li>
    <li><a href="<?php echo $mode_back_lien_interne; ?>">Administration</a></li>
    <li><a href="<?php echo $addm; ?>">Ajouter un produit</a></li>
    <?php if (empty($_GET['action'])) { ?> <li class="active">Configuration des produits</li> <?php } else { ?> <li><a href="?page=Configuration_reference_produit">Références des produits</a></li> <?php } ?>
    <?php if ($_GET['action'] == "modifier") { ?> <li class="active">Modifications</li> <?php } ?>
    <?php if ($_GET['action'] == "addm") { ?> <li class="active">Ajouter</li> <?php } ?>
    <?php if ($_GET['action'] == "Graphique") { ?> <li class="active">Graphique</li> <?php } ?>
  </ol>

  <?php
  echo "<div id='bloctitre' style='text-align: left;'><h1>Configuration des produits</h1></div><br />
<div style='clear: both;'></div>";

  ////////////////////Boutton administration
  echo "<a href='" . $mode_back_lien_interne . "'><button type='button' class='btn btn-default' style='margin-right: 5px;' ><span class='uk-icon-file-text'></span> Administration</button></a>";
  if (isset($_GET['action'])) {
    echo "<a href='?page=Configuration_reference_produit'><button type='button' class='btn btn-success' style='margin-right: 5px;' ><span class='uk-icon-file-text'></span> Liste des produits</button></a>";
  }
  if ($action != "ajouter") {
    echo "<a href='?page=Configuration_reference_produit&action=Ajouter'><button type='button' class='btn btn-success' style='margin-right: 5px;' ><span class='uk-icon-plus-circle'></span> Ajouter un produit</button></a>";
  }
  if (!empty($action)) {
    echo "<a href='?page=Configurations_references_produits'><button type='button' class='btn btn-success' style='margin-right: 5px;' ><span class='uk-icon-file-text'></span> Configuration des produits</button></a>";
  }
  echo "<div style='clear: both;'></div><br />";
  ////////////////////Boutton administration
  ?>

  <div style='padding: 5px; text-align: center;'>


    <?php
    ////////////////////////////////////////////////////////////////////////////////////////////FORMULAIRE AJOUTER - MODIFIER
    if ($action == "Ajouter" || $action == "Modifier") {

      if ($action == "Modifier") {
        $req_select = $bdd->prepare("SELECT * FROM configurations_references_produits WHERE id=?");
        $req_select->execute(array($idaction));
        $ligne_select = $req_select->fetch();
        $req_select->closeCursor();
        $idd = $ligne_select['id'];
        $photo = $ligne_select['photo'];
        $prix = $ligne_select['prix'];
        $couleur = $ligne_select['couleur'];
        $couleur2 = $ligne_select['couleur2'];
        $nomproduit = $ligne_select['nom_produit'];
        $urlproduit = $ligne_select['url_produit'];
        $refproduithyro = $ligne_select['ref_produit_hyro'];
        $description = $ligne_select['description'];
        $url = $ligne_select['url'];
        $title = $ligne_select['title'];
        $stock = $ligne_select['stock'];
        $meta_description = $ligne_select['meta_description'];
        $meta_keyword = $ligne_select['meta_keyword'];
        $lien = $ligne_select['lien_chez_un_marchand'];
        $ActiverActiver = $ligne_select['Activer'];
        $date = $ligne_select['date_ajout'];
        $stock = $ligne_select['stock'];
        $nouveaucontenu = "$nom_categorie";
        $url_categorie = $nouveaucontenu;
    ?>

        <form id='formulaire_modifier_configuration_reference_produit' method='post' action='#'>
          <input name="idaction" class="form-control" type="hidden" value="<?php echo "$idaction"; ?>" style='width: 100%;' />
          <input name="action" class="form-control" type="hidden" value="<?php echo "Modifier-action"; ?>" style='width: 100%;' />

          <div style='text-align: center; max-width: 700px; margin-right: auto; margin-left: auto;'>
            <div style='text-align: left;'>
              <h2>Configurer le produit</h2><br /><br />
              <?php
              echo $idaction;
              echo $action;
              ?>
            </div>
            <?php
            $icon1 = $_FILES['image']['name'];
            //////////////////////////////////////POST ACTION UPLOAD 1
            if (!empty($icon1)) {
              if (!empty($icon1) && substr($icon1, -4) == "jpeg" || !empty($icon1) && substr($icon1, -3) == "jpg" || !empty($icon1) && substr($icon1, -3) == "JPEG" || !empty($icon1) && substr($icon1, -3) == "JPG" || !empty($icon1) && substr($icon1, -3) == "png" || !empty($icon1) && substr($icon1, -3) == "PNG" || !empty($icon1) && substr($icon1, -3) == "gif" || !empty($icon1) && substr($icon1, -3) == "GIF") {
                $image_a_uploader = $_FILES['image']['name'];
                $icon = $_FILES['image']['name'];
                $taille = $_FILES['image']['size'];
                $tmp = $_FILES['image']['tmp_name'];
                $type = $_FILES['image']['type'];
                $erreur = $_FILES['image']['error'];
                $source_file = $_FILES['image']['tmp_name'];
                $destination_file = "../../../images/categories/" . $icon . "";

                ////////////Upload des images
                if (move_uploaded_file($tmp, $destination_file)) {
                  $namebrut = explode('.', $image_a_uploader);
                  $namebruto = $namebrut[0];
                  $namebruto_extansion = $namebrut[1];
                  $nouveaucontenu = "$namebruto";
                  include('../../../function/cara_replace.php');
                  $namebruto = "$nouveaucontenu";
                  $nouveau_nom_fichier = "" . $namebruto . "-" . $now . ".$namebruto_extansion";
                  rename("../../../images/categories/$icon", "../../../images/categories/$nouveau_nom_fichier");
                  $image_ok = "ok";
                }
                ////////////Upload des images

              } elseif (!empty($icon1)) {
                $tous_les_fichiers_non_pas_l_extension = "oui";
              }
            }
            ?>

          <?php
        } elseif ($action == "Ajouter") { ?>
            <form id='Configuration_reference_produit_ajouter' method='post' action='#'>
              <input name="idaction" class="form-control" type="hidden" value="<?php echo "$idaction"; ?>" style='width: 100%;' />
              <input name="action" class="form-control" type="hidden" value="Ajouter-action" style='width: 100%;' />

              <div style='text-align: center; max-width: 700px; margin-right: auto; margin-left: auto;'>
                <div style='text-align: left;'>
                  <h2>Ajouter un produit</h2><br /><br />
                </div>
              <?php } ?>

              <div class="well well-sm" style="width: 100%; text-align: left;">
                <!-- <h3>Meilleurs ventes</h3> -->
                <div class="row">
                  <div class="col-lg-6 col-mg-6">
                    <div class="form-group">
                      <label for="meilleur_vente">Meilleurs ventes </label>
                      <select name="meilleur_vente" id="meilleur_vente" class="form-control" style='width: 100%;' required>
                        <option value="Non"> <?php echo "Non"; ?></option>
                        <option value="Oui"> <?php echo "Oui"; ?></option>
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-6 col-mg-6">
                    <div class="form-group">
                      <label for="refproduithyro">Reference du produit </label>
                      <input type='text' name="refproduithyro" id="refproduithyro" class="form-control" value="<?php echo "$title"; ?>" style='width: 100%;' />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12 col-mg-12">
                    <div class="form-group">
                      <label for="nomproduit">Nom du produit </label>
                      <input type='text' name="nomproduit" id="nomproduit" class="form-control" value="<?php echo "$nomproduit"; ?>" style='width: 100%;' />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6 col-mg-6">
                    <div class="form-group">
                      <label for="title">Titre </label>
                      <input type='text' name="title" id="title" class="form-control" value="<?php echo "$nomproduit"; ?>" style='width: 100%;' />
                    </div>
                  </div>
                  <div class="col-lg-6 col-mg-6">
                    <div class="form-group">
                      <label for="prix">Prix </label>
                      <input type='number' name="prix" id="prix" min="0" class="form-control" value="<?php echo "$prix"; ?>" style='width: 100%;' />
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-6 col-mg-6">
                    <div class="form-group">
                      <label for="categories">Categorie</label>
                      <select id="categories" name="id_categorie" class="form-control">
                        <?php
                        $req_boucle = $bdd->prepare("SELECT * FROM categories WHERE activer = ? ORDER BY nom_categorie ASC");
                        $req_boucle->execute(array("oui"));
                        while ($ligne_boucle = $req_boucle->fetch()) {
                          $idd = $ligne_boucle['id'];
                          $nom_categorie = $ligne_boucle['nom_categorie'];
                          $url_categorie = $ligne_boucle['url_categorie'];
                          $title_categorie = $ligne_boucle['title_categorie'];
                          $meta_description_categorie = $ligne_boucle['meta_description_categorie'];
                          $meta_keyword_categorie = $ligne_boucle['meta_keyword_categorie'];
                          $activer = $ligne_boucle['activer'];

                        ?>
                          <option value="<?= $idd ?>"> <?= $nom_categorie ?> </option>
                        <?php

                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-6 col-mg-6">
                    <div class="form-group">
                      <label for="image">Photos</label>
                      <br />
                      <!-- <a href='/administration/index-admin.php?page=Photos-blog&amp;action=<?php echo "$action"; ?>' target='top_'>
                        <button type='button' class='btn btn-success'>Gestion photos</button>
                      </a> -->
                      <input type="file" name="image" id="image" class="form-control" multiple>
                    </div>
                  </div>

                </div>
                <div class="row">
                  <div class="col-lg-6 col-mg-6">
                    <div class="form-group">
                      <label for="couleur">Couleur </label>

                      <div class="row">
                        <div id="allColor"></div>
                      </div>
                      <div class="row">
                        <button id="addNewColor" onclick="event.preventDefault()">Ajouter une autre couleur</button>
                      </div>
                      <div class="row">

                        <div class="col-lg-3 col-md-3">
                          <input type='color' name="couleur" class="form-control" value="<?php echo "$couleur"; ?>" style='width: 100%;' />
                          <!-- <input type='color' name="couleur[]" class="form-control" value="<?php echo "$couleur"; ?>" style='width: 100%;' /> -->
                        </div>
                        <!-- <div class="col-lg-4 col-md-3">
                          <button class="btn btn-success" onclick="event.preventDefault();addColor()" >Ajouter</button>
                        </div> -->
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6 col-mg-6">
                    <div class="form-group">
                      <label for="refproduithyro">Nom de la couleur</label>
                      <input type='text' name="couleur2" id="couleur2" class="form-control" value="<?php echo "$couleur2"; ?>" style='width: 100%;' />
                    </div>
                  </div>
                </div>
                <div class="row">
                </div>
                <div class="row">
                  <div class="col-lg-12 col-md-12">
                    <div class="form-group">
                      <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" cols="30" rows="10" class="form-control"><?php echo $description; ?></textarea>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12 col-md-12">
                  <div class="form-group">
                        <label for="meta_description">Meta description</label>
                        <textarea name="meta_description" id="meta_description" cols="30" rows="10" class="form-control"><?php echo $meta_description; ?></textarea>
                      </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12 col-md-12">
                    <div class="form-group">
                      <label for="url">Url </label>
                      <input type='text' name="nomproduit" id="nomproduit" class="form-control" value="<?php echo "$url"; ?>" style='width: 100%;' />                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12 col-md-12">
                    <div class="form-group">
                      <label for="lien">Lien chez un marchand </label>
                      <input type='text' name="nomproduit" id="nomproduit" class="form-control" value="<?php echo "$lien"; ?>" style='width: 100%;' />                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6 col-md-6">
                    <div class="form-group">
                      <label for="stock">Stock</label>
                      <input type="number" name="stock" id="stock" class="form-control" min="0" value="<?php echo "$stock"; ?>">
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6">
                    <div class="form-group">
                      <label>Activer</label>
                      <select name="Activer" id="Activer" class="form-control" style='width: 100%;' required>
                        <option value="Non"> <?php echo "Non"; ?></option>
                        <option value="Oui"> <?php echo "Oui"; ?></option>
                      </select>
                    </div>
                  </div>
                </div>
                <table style='text-align: center; width: 100%;' cellpadding='2' cellspacing='2'>

                  <!-- <tr>
                    <td style='text-align: left; width: 150px; font-weight: bold;'>Meilleurs ventes</td>
                    <td style='text-align: left;'>
                      <select name="Activer" id="Activer" class="form-control" style='width: 100%;' required>
                        <option value="Non"> <?php echo "Non"; ?></option>
                        <option value="Oui"> <?php echo "Oui"; ?></option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>

                  </td>
                  </tr>

                  <tr>
                    <td style='text-align: left; min-width: 120px;'>id</td>
                    <td style='text-align: left;'>
                      <?php //echo $ligne_select['id']; 
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr> -->
                  <!-- 

                  <tr>
                    <td style='text-align: left; min-width: 120px;'>Titre</td>
                    <td style='text-align: left;'>
                      <?php //echo date($ligne_select['title']); 
                      ?>
                      <input type='text' name="title" class="form-control" value="<?php //echo "$title"; 
                                                                                  ?>" style='width: 100%;' />
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr> -->
                  <!-- 
                  <tr>
                    <td style='text-align: left; min-width: 120px;'>Photo</td>
                    <td style='text-align: left;'>
                      <?php //echo $ligne_select['photo']; 
                      ?>
                      <action="ajouter" method="post" enctype="multipart/form-data">
                        <input type="$_FILES" name="MAX_FILE_SIZE" value="20000">
                        <label>Votre fichier</label> :
                        <input type="file" name="image"><br>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr> -->
                  <!-- 
                  <tr>
                    <td style='text-align: left; min-width: 120px;'>Date</td>
                    <td style='text-align: left;'>
                      <?php //echo date('m-d-Y', $ligne_select['date']); 
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr> -->

                  <!-- <tr>
                    <td style='text-align: left; min-width: 120px;'>couleur</td>
                    <td style='text-align: left;'>
                      <?php //echo date($ligne_select['couleur']); 
                      ?>
                      <input type='text' name="couleur" class="form-control" value="<?php //echo "$color"; 
                                                                                    ?>" style='width: 100%;' />
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr> -->

                  <!-- <tr>
                    <td style='text-align: left; min-width: 120px;'>Nom produit</td>
                    <td style='text-align: left;'>
                      <?php //echo date($ligne_select['nomproduit']); 
                      ?>
                      <input type='text' name="nomproduit" class="form-control" value="<?php //echo "$nomproduit"; 
                                                                                        ?>" style='width: 100%;' />
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr> -->
                  <!-- 
                  <tr>
                    <td style='text-align: left; min-width: 120px;'>Ref produit</td>
                    <td style='text-align: left;'>
                      <?php //echo date($ligne_select['refproduithyro']); 
                      ?>
                      <input type='text' name="refproduithyro" class="form-control" value="<?php //echo "$refproduithyro"; 
                                                                                            ?>" style='width: 100%;' />
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>

                  <tr>
                    <td style='text-align: left; min-width: 120px;'>Description</td>
                    <td style='text-align: left;'>
                      <?php //echo date($ligne_select['description']); 
                      ?>
                      <input type='text' name="description" class="form-control" value="<?php //echo "$description"; 
                                                                                        ?>" style='width: 100%;' />
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>

                  <tr>
                    <td style='text-align: left; min-width: 120px;'>Url</td>
                    <td style='text-align: left;'>
                      <?php //echo date($ligne_select['url']); 
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
 

                  <tr>
                    <td style='text-align: left; min-width: 120px;'>Meta description</td>
                    <td style='text-align: left;'>
                      <?php //echo date($ligne_select['meta_description']); 
                      ?>
                      <input type='text' name="meta_description" class="form-control" value="<?php echo "$meta_description"; ?>" style='width: 100%;' />
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>

                  <tr>
                    <td style='text-align: left; min-width: 120px;'>Lien chez un marchand</td>
                    <td style='text-align: left;'>
                      <?php echo date($ligne_select['lien']); ?>
                      <input type='text' name="lien" class="form-control" value="<?php echo "$lien"; ?>" style='width: 100%;' />
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>


                  <tr>
                    <td style='text-align: left; min-width: 120px;'>Stock</td>
                    <td style='text-align: left;'>
                      <?php echo date($ligne_select['stock']); ?>
                      <input type='text' name="stock" class="form-control" value="<?php echo "$stock"; ?>" style='width: 100%;' />
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>



                  <tr>
                    <td style='text-align: left; width: 150px; font-weight: bold;'>Activer</td>
                    <td style='text-align: left;'>
                      <select name="Activer" id="Activer" class="form-control" style='width: 100%;' required>
                        <option value="Non"> <?php echo "Non"; ?></option>
                        <option value="Oui"> <?php echo "Oui"; ?></option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>

                  <tr>
                    <td style='text-align: left; min-width: 120px; font-weight: bold;'>Changer l'expiration</td>
                    <td style='text-align: left;'>
                      <input name="date_new_expiration" class="form-control" type="date" id="nom" value="" style='width: 100%; min-width: 200px;' required />
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
-->
                </table>
              </div>

              <br />
              <!--button id='modifier-produit' type='button' class='btn btn-success' onclick="return false;" style='width: 150px;'>ENREGISTRER</button-->
              <button id='Configuration_reference_produit' type='button' class='btn btn-success' style='width: 150px;'>ENREGISTRER</button>

            </form>

          <?php
        }
        if (!isset($action)) {
          ?>

            <div id='liste-produit' style='clear: both;'></div>

        <?php
        }
        echo "</div>";
      } else {
        header('location: /index.html');
      }
        ?>