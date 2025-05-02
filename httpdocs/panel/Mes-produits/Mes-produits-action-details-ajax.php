<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../Configurations_bdd.php');
require_once('../../Configurations.php');
require_once('../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction= "../../";
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
    
    if(isset($id)){
        $sql_select = $bdd->prepare('SELECT * FROM membres_souhait_details WHERE id=?');
        $sql_select->execute(array(
            intval($id)
        ));
        $article = $sql_select->fetch();
        $sql_select->closeCursor();

        
        ?>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Détails du produit retrouvé</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="max-height: 400px; overflow:auto">
                <div class="row">
                    <div class="col">
                        <div>
                            <h6>Type :</h6>
                            <p>
                                <?php if($article['type'] == "1"){?>
                                    Article identique
                                <?php }else{?>
                                    Article similaire
                                <?php }?>
                            </p>
                        </div>
                        <div>
                            <h6>Nom :</h6>
                            <p>
                                <?= $article['nom']; ?>
                            </p>
                        </div>
                        <?php if($article['description'] != null){?>
                            <div>
                                <h6>Description :</h6>
                                <p style="word-wrap: break-word">
                                    <?= $article['description']; ?>
                                </p>
                            </div>
                        <?php }?>
                        <div>
                            <h6>Catégorie :</h6>
                            <p>
                                <?= $article['categorie']; ?>
                            </p>
                        </div>
                        <?php if($article['couleur'] != null){?>
                            <div>
                                <h6>Couleur :</h6>
                                <p>
                                    <?= $article['couleur']; ?>
                                </p>
                            </div>
                        <?php }?>
                        <?php if($article['taille'] != null){?>
                            <div>
                                <h6>Taille :</h6>
                                <p>
                                    <?= $article['taille']; ?>
                                </p>
                            </div>
                        <?php }?>
                        <div>
                            <h6>Quantité :</h6>
                            <p>
                                <?= $article['quantite']; ?>
                            </p>
                        </div>
                        <div>
                            <h6>Prix :</h6>
                            <p>
                                <?= $article['prix']; ?> F CFA
                            </p>
                        </div>
                        <div>
                            <a href="<?= $article['url']; ?>" target="_blank" class="btn btn-primary">Voir l'article</a>
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