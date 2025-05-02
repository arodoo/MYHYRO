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
            // Initialize DataTable properly after AJAX content loads
            initializeProductsDataTable();
          }
        });
      }

      // Separate function to initialize DataTable
      function initializeProductsDataTable() {
        // Prevent duplicate initialization
        if ($.fn.DataTable.isDataTable('.sa-datatables-init')) {
          $('.sa-datatables-init').DataTable().destroy();
          $('.sa-datatables-init').empty(); // Clear the table completely
        }
        
        // Short timeout to ensure DOM is ready after AJAX content update
        setTimeout(function() {
          // Define clean template structure for consistent layout
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
          
          // Initialize with clean options
          $('.sa-datatables-init').each(function() {
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
                  // Apply proper styles to pagination for consistency
                  drawCallback: function() {
                      $(this.api().table().container()).find('.pagination').addClass('pagination-sm');
                  }
              });
              
              // Connect search input using data attribute for clean, declarative approach
              const searchSelector = $(this).data('sa-search-input');
              if (searchSelector) {
                  $(searchSelector).off('input').on('input', function() {
                      table.search(this.value).draw();
                  });
                  
                  // Prevent form submission on enter in search field
                  $(searchSelector).off('keypress.prevent-form-submit').on('keypress.prevent-form-submit', function(e) {
                      return e.which !== 13;
                  });
              }
          });
        }, 10);
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

  <div id="top" class="sa-app__body">
    <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
      <div class="container">
        <div class="py-5">
          <div class="row g-4 align-items-center">
            <div class="col">
              <nav class="mb-2" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-sa-simple">
                  <li class="breadcrumb-item"><a href="index-admin.php">Dashboard</a></li>
                  <?php if (empty($_GET['action'])) { ?>
                    <li class="breadcrumb-item active" aria-current="page">Configuration des produits</li>
                  <?php } else { ?>
                    <li class="breadcrumb-item"><a href="?page=Configuration_reference_produit">Configuration des produits</a></li>
                  <?php } ?>
                  <?php if ($_GET['action'] == "Modifier") { ?>
                    <li class="breadcrumb-item active">Modifications</li>
                  <?php } ?>
                  <?php if ($_GET['action'] == "Ajouter") { ?>
                    <li class="breadcrumb-item active">Ajouter</li>
                  <?php } ?>
                  <?php if ($_GET['action'] == "Graphique") { ?>
                    <li class="breadcrumb-item active">Graphique</li>
                  <?php } ?>
                </ol>
              </nav>
              <h1 class="h3 m-0">Configuration des produits</h1>
            </div>
            <div class="col-auto d-flex">
              <?php if (isset($_GET['action'])) { ?>
                <a href="?page=Configuration_reference_produit" class="btn btn-primary me-3">
                  <i class="fas fa-list me-2"></i>Liste des produits
                </a>
              <?php } ?>
              <?php if ($action != "Ajouter") { ?>
                <a href="?page=Configuration_reference_produit&action=Ajouter" class="btn btn-primary">
                  <i class="fas fa-plus me-2"></i>Ajouter un produit
                </a>
              <?php } ?>
            </div>
          </div>
        </div>

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

            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Configurer le produit</h5>
              </div>
              <div class="card-body">
                <form id='formulaire_modifier_configuration_reference_produit' method='post' action='#'>
                  <input name="idaction" type="hidden" value="<?php echo "$idaction"; ?>" />
                  <input name="action" type="hidden" value="<?php echo "Modifier-action"; ?>" />

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

                  <div class="row g-4 mb-4">
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label" for="meilleur_vente">Meilleurs ventes</label>
                        <select name="meilleur_vente" id="meilleur_vente" class="form-select" required>
                          <option value="Non">Non</option>
                          <option value="Oui">Oui</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label" for="refproduithyro">Référence du produit</label>
                        <input type='text' name="refproduithyro" id="refproduithyro" class="form-control" value="<?php echo "$refproduithyro"; ?>" />
                      </div>
                    </div>
                  </div>

                  <div class="mb-4">
                    <label class="form-label" for="nomproduit">Nom du produit</label>
                    <input type='text' name="nomproduit" id="nomproduit" class="form-control" value="<?php echo "$nomproduit"; ?>" />
                  </div>

                  <div class="row g-4 mb-4">
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label" for="title">Titre</label>
                        <input type='text' name="title" id="title" class="form-control" value="<?php echo "$title"; ?>" />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label" for="prix">Prix</label>
                        <input type='number' name="prix" id="prix" min="0" class="form-control" value="<?php echo "$prix"; ?>" />
                      </div>
                    </div>
                  </div>

                  <div class="row g-4 mb-4">
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label" for="categories">Catégorie</label>
                        <select id="categories" name="id_categorie" class="form-select">
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
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label" for="image">Photos</label>
                        <input type="file" name="image" id="image" class="form-control" multiple>
                      </div>
                    </div>
                  </div>

                  <div class="row g-4 mb-4">
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label" for="couleur">Couleur</label>
                        <div class="row g-2 mb-2">
                          <div id="allColor"></div>
                        </div>
                        <div class="row g-2 mb-2">
                          <div class="col-auto">
                            <button id="addNewColor" class="btn btn-sm btn-secondary" onclick="event.preventDefault()">
                              <i class="fas fa-plus me-2"></i>Ajouter une autre couleur
                            </button>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <input type='color' name="couleur" class="form-control" value="<?php echo "$couleur"; ?>" />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label" for="couleur2">Nom de la couleur</label>
                        <input type='text' name="couleur2" id="couleur2" class="form-control" value="<?php echo "$couleur2"; ?>" />
                      </div>
                    </div>
                  </div>

                  <div class="mb-4">
                    <label class="form-label" for="description">Description</label>
                    <textarea name="description" id="description" rows="5" class="form-control"><?php echo $description; ?></textarea>
                  </div>

                  <div class="mb-4">
                    <label class="form-label" for="meta_description">Meta description</label>
                    <textarea name="meta_description" id="meta_description" rows="3" class="form-control"><?php echo $meta_description; ?></textarea>
                  </div>

                  <div class="mb-4">
                    <label class="form-label" for="url">Url</label>
                    <input type='text' name="url" id="url" class="form-control" value="<?php echo "$url"; ?>" />
                  </div>

                  <div class="mb-4">
                    <label class="form-label" for="lien">Lien chez un marchand</label>
                    <input type='text' name="lien" id="lien" class="form-control" value="<?php echo "$lien"; ?>" />
                  </div>

                  <div class="row g-4 mb-4">
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label" for="stock">Stock</label>
                        <input type="number" name="stock" id="stock" class="form-control" min="0" value="<?php echo "$stock"; ?>">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label" for="Activer">Activer</label>
                        <select name="Activer" id="Activer" class="form-select" required>
                          <option value="Non">Non</option>
                          <option value="Oui">Oui</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="text-end">
                    <button id='Configuration_reference_produit' type='button' class='btn btn-primary'>
                      <i class="fas fa-save me-2"></i>Enregistrer
                    </button>
                  </div>
                </form>
              </div>
            </div>

          <?php
          } elseif ($action == "Ajouter") { 
          ?>
          
          <div class="card">
            <div class="card-header">
              <h5 class="card-title">Ajouter un produit</h5>
            </div>
            <div class="card-body">
              <form id='Configuration_reference_produit_ajouter' method='post' action='#'>
                <input name="idaction" type="hidden" value="<?php echo "$idaction"; ?>" />
                <input name="action" type="hidden" value="Ajouter-action" />

                <!-- Form fields same as modify form but without values -->
                <div class="row g-4 mb-4">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label" for="meilleur_vente">Meilleurs ventes</label>
                      <select name="meilleur_vente" id="meilleur_vente" class="form-select" required>
                        <option value="Non">Non</option>
                        <option value="Oui">Oui</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label" for="refproduithyro">Référence du produit</label>
                      <input type='text' name="refproduithyro" id="refproduithyro" class="form-control" />
                    </div>
                  </div>
                </div>

                <div class="mb-4">
                  <label class="form-label" for="nomproduit">Nom du produit</label>
                  <input type='text' name="nomproduit" id="nomproduit" class="form-control" />
                </div>

                <!-- Continue with the same layout as modify form but without values -->
                <div class="row g-4 mb-4">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label" for="title">Titre</label>
                      <input type='text' name="title" id="title" class="form-control" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label" for="prix">Prix</label>
                      <input type='number' name="prix" id="prix" min="0" class="form-control" />
                    </div>
                  </div>
                </div>

                <!-- Rest of form fields -->
                <div class="text-end">
                  <button id='Configuration_reference_produit' type='button' class='btn btn-primary'>
                    <i class="fas fa-save me-2"></i>Enregistrer
                  </button>
                </div>
              </form>
            </div>
          </div>

          <?php
          }
        }
        ////////////////////////////////////////////////////////////////////////////////////////////PAS D'ACTION
        if (!isset($action)) {
        ?>
          <div id='liste-produit' class="card-table"></div>
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