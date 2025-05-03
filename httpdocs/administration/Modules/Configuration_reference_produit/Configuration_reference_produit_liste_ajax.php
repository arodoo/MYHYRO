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

  $nom_fichier = "Configuration_reference_produit";
  $nom_fichier_datatable = "Configuration_reference_produit" . date('d-m-Y', time()) . "-$nomsiteweb";
?>

  <div class="card">
    <div class="p-4">
      <input
        type="text"
        placeholder="Rechercher des produits..."
        class="form-control form-control--search mx-auto"
        id="table-search" />
    </div>
    <div class="sa-divider"></div>
    <table class="sa-datatables-init" data-order='[[ 0, "desc" ]]' data-sa-search-input="#table-search">
      <thead>
        <tr>
          <th style="text-align: center;">REFERENCE</th>
          <th scope="col" style="text-align: center;">NOM DU PRODUIT</th>
          <th style="text-align: center;">PRIX</th>
          <th style="text-align: center;">CATEGORIE</th>
          <th style="text-align: center; width: 90px;">ACTIONS</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $req_boucle = $bdd->prepare("SELECT c.*, p.* FROM configurations_references_produits p
    LEFT JOIN categories c ON p.id_categorie = c.id
    ORDER BY p.id DESC");
        $req_boucle->execute();
        while ($ligne_boucle = $req_boucle->fetch()) {
          $iddd = $ligne_boucle['id'];
          $photo = $ligne_boucle['photo'];
          $prix = $ligne_boucle['prix'];
          $id_categorie = $ligne_boucle['id_categorie'];
          $nomproduit = $ligne_boucle['nom_produit'];
          $refproduithyro = $ligne_boucle['ref_produit_hyro'];
          $description = $ligne_boucle['description'];
          $url = $ligne_boucle['url'];
          $title = $ligne_boucle['title'];
          $meta_description = $ligne_boucle['meta_description'];
          $ActiverActiver = $ligne_boucle['Activer'];
          $meta_keyword = $ligne_boucle['meta_keyword'];
          $lien = $ligne_boucle['lien_chez_un_marchand'];
          $date = $ligne_boucle['date_ajout'];
          $nom_categorie = $ligne_boucle['nom_categorie']; // Nom de la catégorie

          ///////////////////////////////SELECT
          $req_select = $bdd->prepare("SELECT * FROM configurations_references_produits WHERE id=?");
          $req_select->execute(array($nomproduit));
          $ligne_select = $req_select->fetch();
          $req_select->closeCursor();
          $idd = $ligne_select['nomproduit'];
        ?>
          <tr>
            <td style='text-align: center;'><?php echo $refproduithyro; ?></td>
            <td style='text-align: center;'><?php echo $nomproduit; ?></td>
            <td style='text-align: center;'><?php echo $prix; ?> F CFA</td>
            <td style='text-align: center;'><?php echo $nom_categorie; ?></td>
            <td style='text-align: center;'>
              <div class="dropdown">
                <button class="btn btn-sa-muted btn-sm" type="button" id="product-context-menu-<?php echo $iddd; ?>" data-bs-toggle="dropdown" aria-expanded="false" aria-label="More">
                  <i class="fas fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="product-context-menu-<?php echo $iddd; ?>">
                  <li>
                    <a class="dropdown-item" href="?page=Configuration_reference_produit&amp;action=Modifier&amp;idaction=<?php echo $iddd; ?>">
                      <i class="fas fa-eye me-2"></i>Voir
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="?page=Configuration_reference_produit&amp;action=Modifier&amp;idaction=<?php echo $iddd; ?>">
                      <i class="fas fa-edit me-2"></i>Modifier
                    </a>
                  </li>
                  <li>
                    <hr class="dropdown-divider" />
                  </li>
                  <li>
                    <a class="dropdown-item text-danger btnSupprModal" href="#" data-id="<?php echo $iddd; ?>">
                      <i class="fas fa-trash me-2"></i>Supprimer
                    </a>
                  </li>
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
  </div>
  
  <!-- Modal container -->
  <div id="modal-container"></div>

<?php
} else {
  header('location: /index.html');
}

ob_end_flush();
?>