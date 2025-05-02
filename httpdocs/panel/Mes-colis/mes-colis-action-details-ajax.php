<script>

</script>


<style>
    @media (max-width: 564px) {
        .modal-container {
            display: block !important;

        }

        .details-container {
            width: 100% !important;
            margin-bottom: 10px !important;

        }
    }


    @media (max-width: 566px) {
        .modal-dialog {
            /*  display: flex;
                justify-content: center;
              
                align-items: center;
           
                min-height: 100vh;
                */
            margin: 0 auto !important;
            max-width: 100% !important;
        }

        .modal-body {
            display: block !important;
        }

        .adresse-container,
        .body-container {

            width: 100% !important;

        }

    }
</style>

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
    $sql_select = $bdd->prepare('SELECT * FROM membres_colis WHERE id=?');
    $sql_select->execute(array(
        intval($id)
    ));
    $colis = $sql_select->fetch();
    $sql_select->closeCursor();

    $sql_boucle = $bdd->prepare('SELECT * FROM membres_colis_details WHERE colis_id=?');
    $sql_boucle->execute(array(
        htmlspecialchars($colis['id'])
    ));
    $articles = $sql_boucle->fetchAll();
    $sql_boucle->closeCursor();


    $req_message = $bdd->prepare("SELECT message FROM configurations_messages_predefini WHERE id=?");
    $req_message->execute(array(21));
    $ligne_message = $req_message->fetch();
    $req_message->closeCursor();

    
    $sql_select = $bdd->prepare('SELECT * FROM configurations_livraisons_gabon WHERE id=?');
    $sql_select->execute(array(
        $colis['id_livraison']
    ));

    $req_select = $bdd->prepare("SELECT * FROM configurations_suivi_achat Where id=?");
    $req_select->execute(array($colis['statut']));
    $ligne_select2 = $req_select->fetch();
    $req_select->closeCursor();

    $req_select = $bdd->prepare("SELECT * FROM configurations_suivi_expedition Where id=?");
    $req_select->execute(array($colis['statut_expedition']));
    $ligne_select22 = $req_select->fetch();
    $req_select->closeCursor();

    $req_select = $bdd->prepare("SELECT * FROM configurations_messages_predefini Where id=?");
    $req_select->execute(array($colis['message']));
    $ligne_message = $req_select->fetch();
    $req_select->closeCursor();
?>
    <!--   <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Détails du colis n°<?= $colis['id'] ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table style='text-align: center; width: 100%;' cellpadding='2' cellspacing='2'>

                    <tr>
                        <td style='text-align: left; min-width: 120px;'>
                            Nombre d'articles :
                        </td>
                        <td style='text-align: left; min-width: 360px;'>
                            <?php
                            $quantity = 0;
                            for ($i = 0; $i < count($articles); $i++) {
                                $quantity += $articles[$i]['quantite'];
                            }
                            echo $quantity
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td style='text-align: left; min-width: 120px;'>
                            Prix total :
                        </td>
                        <td style='text-align: left; min-width: 360px;'>
                            <span name="price"><?= round($colis['prix_total'] * 0.00152449, 2); ?></span>€ (<span name="price"><?= round($colis['prix_total']); ?></span> F CFA)
                        </td>
                    </tr>
                </table>
                <div class="card">
                    <div class="accordion" id="accordionExample">
                        <?php
                        for ($i = 0; $i < count($articles); $i++) {
                            $req_select = $bdd->prepare("SELECT * FROM categories WHERE nom_categorie=?");
                            $req_select->execute(array(
                                $articles[$i]['categorie']
                            ));
                            $categorie = $req_select->fetch();
                            $req_select->closeCursor();

                            $value = $categorie['value'];
                            if ($articles[$i]['type_value'] == "1") {
                                //Prix au kg
                                $total = $articles[$i]['value'] * $categorie['value'];
                            } else if ($articles[$i]['type_value'] == "2") {
                                //Prix en pourcentage
                                $total = $articles[$i]['value'] * ($categorie['value'] / 100);
                            }

                        ?>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading<?= $i ?>">
                                    <button class="btn btn-link btn-block text-left" style="color:#FF9900" type="button" data-toggle="collapse" data-target="#<?= "collapse-" . $i ?>">
                                        Article n°<?= $i + 1 ?> (<span name="price"><?= $total ?></span>€)
                                    </button>
                                </h2>
                                <?php
                                if ($i == 0) { ?>
                                    <div id=<?= "collapse-" . $i ?> class="accordion-collapse collapse show" aria-labelledby="heading<?= $i ?>" data-parent="#accordionExample">
                                    <?php } else { ?>
                                        <div id=<?= "collapse-" . $i ?> class="accordion-collapse collapse" aria-labelledby="heading<?= $i ?>" data-parent="#accordionExample">
                                        <?php } ?>
                                        <div class="accordion-body">
                                            <div class="container">
                                                <table>
                                                    <tr>
                                                        <td style='text-align: left; min-width: 120px;'>Nom :</td>
                                                        <td style='text-align: left; max-width: 120px;'>
                                                            <?php if ($articles[$i]['nom'] == "") {
                                                                echo "Non défini";
                                                            } else {
                                                                echo $articles[$i]['nom'];
                                                            } ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style='text-align: left; min-width: 120px;'>Description :</td>
                                                        <td style='text-align: left; min-width: 120px'>
                                                            <?php if ($articles[$i]['description'] == "") {
                                                                echo "Non défini";
                                                            } else {
                                                                echo $articles[$i]['description'];
                                                            } ?>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td style='text-align: left; min-width: 120px;'>Catégorie :</td>
                                                        <td style='text-align: left;'>
                                                            <?php if ($articles[$i]['categorie'] == "") {
                                                                echo "Non défini";
                                                            } else {
                                                                echo $articles[$i]['categorie'];
                                                                echo " (";
                                                                echo $value;
                                                                if ($articles[$i]['type_value'] == "1") {
                                                                    echo "€/Kg";
                                                                } else {
                                                                    echo "% de la valeur";
                                                                }
                                                                echo ")";
                                                            } ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style='text-align: left; min-width: 120px;'>Quantité :</td>
                                                        <td style='text-align: left;'>
                                                            <?php if ($articles[$i]['quantite'] == "") {
                                                                echo "Non défini";
                                                            } else {
                                                                echo $articles[$i]['quantite'];
                                                            } ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style='text-align: left; min-width: 120px;'>Valeur :</td>
                                                        <td style='text-align: left;'>
                                                            <?php if ($articles[$i]['value'] == "") {
                                                                echo "Non défini";
                                                            } else { ?>
                                                                <span name="price"><?= $articles[$i]['value']; ?></span>
                                                                <?php
                                                                if ($articles[$i]['type_value'] == "1") {
                                                                    echo "Kg";
                                                                } else {
                                                                    echo "€";
                                                                } ?>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                    </div>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close" style="color:#fff;background-color:#5a6268;border-color:#545b62;padding:0.375rem 1.25rem" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div> -->





    <div class="modal-dialog modal-dialog-centered" style="max-width: 80%;" role="document">
        <div class="modal-content">
            <div class="modal-header" style="display: flex;">
                <h5 class="modal-title">Détails du colis n°<?= $colis['id'] ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="font-size: 32px">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="max-height: 85vh; overflow-y: auto; font-size: 12px; padding-left: 0px !important; display: flex;">
                <div class="body-container" style="width: 80%;">
                    <div class="modal-container" style="display: flex; justify-content: space-between; margin-bottom: 1rem; margin: 10px;">
                        <div class="details-container" style="border: 3px solid #dee2e6; border-radius: 5px; padding: 1rem; display: flex; width: 70%; height: auto;">
                            <i class="uk-icon-info-circle" style="margin: 0 1rem 0 0;"></i>
                            <div style="width: 100%;">
                                <p>Etat du colis : <?= $ligne_select2['nom_suivi'] ?></p>
                                <p>Etat de l'expédition : <?= $ligne_select22['nom_suivi'] ?></p>
                                <p style="margin-bottom: auto">Message : <?= $ligne_message['message'] ?></p>

                                <div class="mt-2" style="margin-bottom: 1rem;">
                                    Commentaire :
                                    <textarea class="form-control" disabled><?= $colis['commentaire_livraison']; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="details-container" style="border: 3px solid #dee2e6; border-radius: 5px; padding: 1rem; width: 27%; height: fit-content;">
                            <p><?php if ($colis['id_paiement_pf']) {
                                    echo "Payé en plusieurs fois : " . $ligne_select55['nom'];
                                } else {
                                    echo "Payé au comptant " . $ligne_select55['nom_mode'];
                                } ?></p>
                            <p>Total du colis : <?= number_format($colis['prix_total'], 0, '.', ' ') ?> F CFA</p>
                            <p style="margin-bottom: auto"><strong>Poids du colis : </strong> <?= $colis['poids'] ?> Kg</p>
                        </div>
                    </div>

                    <style>
                        .table {
                            width: 100%;
                            border-collapse: collapse;
                        }

                        .table thead {
                            display: table-header-group;
                        }

                        .table td {
                            text-align: center;
                            padding: 8px;
                        }

                        @media (max-width: 768px) {
                            .table thead {
                                display: none;
                            }

                            .table,
                            .table tbody,
                            .table tr,
                            .table td {
                                display: block;
                                width: 100%;
                            }

                            .table tr {
                                margin-bottom: 1rem;
                                min-height: 150px;
                                border-bottom: 1px solid #dee2e6;
                            }

                            .table td {
                                text-align: right;
                                position: relative;
                                padding-left: 50%;
                                padding-top: 10px;
                                padding-bottom: 10px;
                                border-bottom: 1px solid #dee2e6;
                            }

                            .table td::before {
                                content: attr(data-title);
                                position: absolute;
                                left: 0;
                                width: 50%;
                                padding-left: 10px;
                                font-weight: bold;
                                text-align: left;
                            }

                            .table-container{
                                max-height: 50vh!important;
                            }

                            .montant{
                                justify-content: center!important;
                            }
                        }
                    </style>
                    <div class="table-container" style="border: 3px solid #ff9900; border-radius: 5px; padding: 0 1rem 1rem 1rem; margin-top: 1rem; max-height: 20vh; overflow-y: auto; margin: 10px;">
                        <table class="table">
                            <thead>
                                <tr style="color: #ff9900; text-align: center;">
                                    <th>Nom du Produit</th>
                                    <th>Couleur</th>
                                    <th>Taille</th>
                                    <th>Categorie</th>
                                    <th>Quantité</th>
                                    <th>Prix U.</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($articles as $index => $article) { ?>
                                    <tr>
                                        <td data-title="Nom du Produit" style="text-align: center;">
                                            <?= $article['nom'] ?>
                                        </td>
                                        <td data-title="Couleur" style="text-align: center;">
                                            <?= $article['couleur'] ?: 'Non spécifiée' ?>
                                        </td>
                                        <td data-title="Taille" style="text-align: center;">
                                            <?= $article['taille'] ?: 'Non spécifiée' ?>
                                        </td>
                                        <td data-title="Categorie" style="text-align: center;">
                                            <?= $article['categorie'] ?: 'Non spécifiée' ?>
                                        </td>
                                        <td data-title="Quantité" style="text-align: center;">
                                            <?= $article['quantite'] ?>
                                        </td>
                                        <td data-title="Prix U." style="text-align: center;">
                                            <?= number_format($article['prix'], 0, '.', ' ') ?> F CFA (<?= round($article['prix'] * 0.00152449, 2) ?>€)
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="montant"  style="display: flex;justify-content: flex-end; width: 100%; margin-top: 1rem;">
                        <div style="border: 1px solid #dee2e6; border-radius:1rem; padding:0.5rem; margin-right: 1rem;">
                            Montant dû : <?= $colis['restant_payer'] ? number_format($colis['restant_payer'], 0, '.', ' ') : 0 ?> F CFA
                        </div>
                        <div style="border: 1px solid #dee2e6; border-radius:1rem; padding:0.5rem;">
                            Montant avoir : <?= $colis['restant_rembourser'] ?: 0 ?> F CFA
                        </div>
                    </div>
                </div>

                <div class="adresse-container" style="width: 20%; border-left: 1px solid #dee2e6;">
                    <div style="margin: 10px;">
                        <div style="width: 100%;">
                            <div style="text-align: center; border-bottom: 1px solid #dee2e6;">
                                <strong style='color: black;'>Adresse de Facturation</strong>
                            </div>
                            <div style="margin-top: 1rem;">
                                <?= nl2br($colis['adresse_fac']) ?>
                            </div>
                        </div>

                        <div style="width: 100%; margin-top: 2rem;">
                            <div style="text-align: center; border-bottom: 1px solid #ff9900;">
                                <strong style='color: #ff9900;'>Adresse de Livraison</strong>
                            </div>
                            <div style="margin-top: 1rem;">
                                <?= nl2br($colis['adresse_liv']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




<?php }

ob_end_flush();
?>