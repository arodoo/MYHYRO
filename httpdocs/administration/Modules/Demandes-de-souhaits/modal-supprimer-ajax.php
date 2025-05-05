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
    $id = $_POST['id'];

    // Get wish details for displaying in modal
    $req_select = $bdd->prepare("SELECT ms.*, m.prenom, m.nom FROM membres_souhait ms 
                                LEFT JOIN membres m ON ms.user_id = m.id WHERE ms.id=?");
    $req_select->execute(array($id));
    $ligne_select = $req_select->fetch();
    $req_select->closeCursor();

    $title = $ligne_select['titre'];
    $client = $ligne_select['prenom'] . ' ' . $ligne_select['nom'];
    ?>

    <!-- Modal -->
    <div class="modal fade" id="modalSuppr" tabindex="-1" aria-labelledby="modalSupprLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSupprLabel">Confirmation de suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Êtes-vous sûr(e) de vouloir supprimer cette demande de souhaits ?</p>
                    <div class="alert alert-warning">
                        <strong>Titre :</strong> <?php echo $title; ?><br>
                        <strong>Client :</strong> <?php echo $client; ?>
                    </div>
                    <p>Cette action est irréversible.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-danger" id="btnSuppr" data-id="<?php echo $id; ?>">Oui,
                        supprimer</button>
                </div>
            </div>
        </div>
    </div>

    <?php
} else {
    header('location: /index.html');
}
ob_end_flush();
?>