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
    $idmembre = isset($_POST['idmembre']) ? $_POST['idmembre'] : '';

    // Prepare the WHERE clause for filtering by member if needed
    $where = '';
    $params = [];
    if (!empty($idmembre)) {
        $where = " WHERE user_id = ? ";
        $params[] = $idmembre;
    }

    $nom_fichier = "Demandes de souhaits";
    $nom_fichier_datatable = "Demandes-de-souhaits-" . date('d-m-Y', time()) . "-$nomsiteweb";
    ?>

    <table class="sa-datatables-init" data-order='[[ 0, "desc" ]]' data-sa-search-input="#table-search">
        <thead>
            <tr>
                <th>ID</th>
                <th>CLIENT</th>
                <th>TITRE</th>
                <th>STATUT</th>
                <th>DATE</th>
                <th style="width: 90px;">ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Query to get wishlist requests
            $req_boucle = $bdd->prepare("SELECT ms.*, m.nom, m.prenom FROM membres_souhait ms 
                                LEFT JOIN membres m ON ms.user_id = m.id $where ORDER BY ms.id DESC");
            $req_boucle->execute($params);
            while ($ligne = $req_boucle->fetch()) {
                $id = $ligne['id'];
                $client = $ligne['prenom'] . ' ' . $ligne['nom'];
                $title = $ligne['titre'];
                $created_at = date('d/m/Y', $ligne['created_at']);

                // Get status text
                $status_text = "";
                $status_class = "";
                switch ($ligne['statut']) {
                    case 0:
                        $status_text = "En attente";
                        $status_class = "badge-sa-warning";
                        break;
                    case 1:
                        $status_text = "Traitée";
                        $status_class = "badge-sa-success";
                        break;
                    case 2:
                        $status_text = "Refusée";
                        $status_class = "badge-sa-danger";
                        break;
                    default:
                        $status_text = "Inconnue";
                        $status_class = "badge-sa-secondary";
                }
                ?>
                <tr>
                    <td><?php echo $id; ?></td>
                    <td><?php echo $client; ?></td>
                    <td><?php echo $title; ?></td>
                    <td><span class="badge <?php echo $status_class; ?>"><?php echo $status_text; ?></span></td>
                    <td><?php echo $created_at; ?></td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sa-muted btn-sm" type="button" id="wish-context-menu-<?php echo $id; ?>"
                                data-bs-toggle="dropdown" aria-expanded="false" aria-label="More">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="wish-context-menu-<?php echo $id; ?>">
                                <li>
                                    <a class="dropdown-item btnDetailModal" href="#" data-id="<?php echo $id; ?>">
                                        <i class="fas fa-eye me-2"></i>Voir détails
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-warning"
                                        href="index-admin.php?page=Demandes-de-souhaits&action=edit&idaction=<?php echo $id; ?>">
                                        <i class="fas fa-edit me-2"></i>Modifier
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger btnSupprModal" href="#" data-id="<?php echo $id; ?>">
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