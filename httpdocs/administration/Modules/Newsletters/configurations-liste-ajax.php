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
  isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 3
) {

  $nom_fichier = "Newsletters";
  $nom_fichier_datatable = "Newsletters" . date('d-m-Y', time()) . "-$nomsiteweb";
?>

<table class="sa-datatables-init" data-order='[[ 1, "desc" ]]' data-sa-search-input="#table-search">
  <thead>
    <tr>
      <th>EMAIL</th>
      <th>DATE</th>
      <th style="width: 90px;">ACTIONS</th>
    </tr>
  </thead>
  <tbody>
    <?php
    // Query to get newsletter subscribers
    $req_boucle = $bdd->prepare("SELECT * FROM Newsletter_listing ORDER BY id DESC");
    $req_boucle->execute();
    while ($ligne_boucle = $req_boucle->fetch()) {
      $iddd = $ligne_boucle['id'];
      $email = $ligne_boucle['Mail'];
      $date = date('d/m/Y', time());
    ?>
      <tr>
        <td><?php echo $email; ?></td>
        <td><?php echo $date; ?></td>
        <td>
          <div class="dropdown">
            <button class="btn btn-sa-muted btn-sm" type="button" id="newsletter-context-menu-<?php echo $iddd; ?>" data-bs-toggle="dropdown" aria-expanded="false" aria-label="More">
              <i class="fas fa-ellipsis-v"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="newsletter-context-menu-<?php echo $iddd; ?>">
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

<?php
} else {
  header('location: /index.html');
}

ob_end_flush();
?>