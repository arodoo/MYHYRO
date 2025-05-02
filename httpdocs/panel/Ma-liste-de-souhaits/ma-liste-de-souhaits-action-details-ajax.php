<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../Configurations_bdd.php');
require_once('../../Configurations.php');
require_once('../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction = "../../";
require_once('../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

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

$id = $_POST['id'];

if (isset($id)) {
    $sql_select = $bdd->prepare('SELECT * FROM membres_souhait WHERE id=?');
    $sql_select->execute(array(
        intval($id)
    ));
    $liste = $sql_select->fetch();
    $sql_select->closeCursor();

    $req_details = $bdd->prepare("
        SELECT 
            ms.*,
            msd.*
        FROM 
            membres_souhait ms
        INNER JOIN 
            membres_souhait_details msd
        ON 
            ms.id = msd.liste_id 
        WHERE 
            ms.statut = 4 
            AND ms.user_id = ? 
            AND ms.id = ?
    ");
    $req_details->execute(array($id_oo, $id));
    $details = $req_details->fetch();


    var_dump($details);
?>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Détails de la liste de souhaits n°<?= $liste['id'] ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div>
                            <h6>Statut :</h6>
                            <p>
                                <?php if ($liste['statut'] == 1) { ?>
                                    <span class="badge badge-primary">En cours de traitement</span>
                                <?php } else if ($liste['statut'] == 2) { ?>
                                    <span class="badge badge-warning">À payer</span>
                                <?php } else if ($liste['statut'] == 3) { ?>
                                    <span class="badge badge-delete">Refusée</span>
                                <?php } else if ($liste['statut'] == 4) { ?>
                                    <span class=" badge badge-success">Traité</span>
                                <?php } ?>
                            </p>
                        </div>
                        <div>
                            <h6>Titre :</h6>
                            <p>
                                <?= $liste['titre']; ?>
                            </p>
                        </div>
                        <div>
                            <h6>Description :</h6>
                            <p style="word-wrap: break-word">
                                <?= $liste['description']; ?>
                            </p>
                        </div>
                        <?php if ($liste['filename'] != null) { ?>
                            <div>
                                <h6>Fichier :</h6>
                                <img style="width:50%; height:50%" src="../../images/uploads/users/<?= $id_oo; ?>/<?= $liste['filename']; ?>" />
                            </div>
                        <?php } ?>

                    </div>
                    <div class="col">


                        <div>
                            <h6>Catégorie :</h6>
                            <p><?= $details['categorie']; ?></p>
                        </div>
                        <div>
                            <h6>Quantité :</h6>
                            <p><?= $details['quantite']; ?></p>
                        </div>
                        <div>
                            <h6>Prix :</h6>
                            <p><?= $details['prix']; ?> €</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close" style="color:#fff;background-color:#5a6268;border-color:#545b62;padding:0.375rem 1.25rem" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>

<?php }

ob_end_flush();
?>