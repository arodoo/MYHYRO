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
 * \*****************************************************/



$id = $_POST['id'];

if (isset($id)) {



    $sql_select = $bdd->prepare('SELECT * FROM membres_commandes WHERE id=?');
    $sql_select->execute(array(
        intval($id)
    ));
    $commande = $sql_select->fetch();
    $sql_select->closeCursor();

    $sql_select = $bdd->prepare('SELECT * FROM configurations_livraisons_gabon WHERE id=?');
    $sql_select->execute(array(
        $commande['id_livraison']
    ));
    $livraison = $sql_select->fetch();
    $sql_select->closeCursor();


    $sql_boucle = $bdd->prepare('SELECT * FROM membres_commandes_details WHERE commande_id=?');
    $sql_boucle->execute(array(
        htmlspecialchars($commande['id'])
    ));
    $articles = $sql_boucle->fetchAll();
    $sql_boucle->closeCursor();

    $req_select = $bdd->prepare("SELECT * FROM configurations_suivi_achat Where id=?");
    $req_select->execute(array($commande['statut_2']));
    $ligne_select2 = $req_select->fetch();
    $req_select->closeCursor();

    $req_select = $bdd->prepare("SELECT * FROM configurations_suivi_expedition Where id=?");
    $req_select->execute(array($commande['statut_expedition']));
    $ligne_select22 = $req_select->fetch();
    $req_select->closeCursor();

    $req_select = $bdd->prepare("SELECT * FROM configurations_messages_predefini Where id=?");
    $req_select->execute(array($commande['message']));
    $ligne_message = $req_select->fetch();
    $req_select->closeCursor();
?>


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


        /* Estilos para pantallas grandes (desktops) */
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

        /* Estilos para pantallas pequeñas (teléfonos móviles) */
        @media (max-width: 768px) {
            .table thead {
                display: none;
                /* Ocultar encabezado de la tabla */
            }

            .table,
            .table tbody,
            .table tr,
            .table td {
                display: block;
                /* Cambiar las filas a formato de bloque */
                width: 100%;
            }

            .table tr {
                margin-bottom: 1rem;
                /* Espacio entre cada "fila" (ahora lista) */
                min-height: 150px;
                /* Altura mínima de cada fila para que un producto sea visible */
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

            .table-container {
                max-height: 50vh !important;
            }

            .montant {
                justify-content: center !important;
            }

            .adresse-text {
                text-align: center;
            }
        }
    </style>


    <div class="modal-dialog" style="max-width: 80%;" role="document">
        <div class="modal-content">
            <div class="modal-header" style="display: flex;">
                <h5 class="modal-title">Détails de la commande n°<?= $commande['id'] ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="font-size: 32px">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="max-height: 85vh;overflow-y: auto; font-size: 12px; display: flex; padding-left: 0px !important">
                <div class="body-container" style="width: 80%">

                    <div class="modal-container" style="display: flex; justify-content: space-between; margin-bottom: 1rem; margin: 10px;">
                        <div class="details-container" style="border: 3px solid #dee2e6; border-radius: 5px; padding: 1rem; display: flex; width: 70%; height: auto;">

                            <i class="uk-icon-info-circle" style="margin: 0 1rem 0 0;"></i>


                            <div style="width: 100%">
                                <p>Etat de l'achat : <?= $ligne_select2['nom_suivi'] ?></p>
                                <p>Etat de l'expédition : <?= $ligne_select22['nom_suivi'] ?></p>
                                <p style="margin-bottom: auto">Message :
                                    <?= $commande['statut_2'] == "3" ? "La commande a été annulée" : $ligne_message['message'] ?>
                                </p>
                                <!-- Comment section -->
                                <div class="mt-2" style="margin-bottom: 1rem">
                                    Commentaire :
                                    <textarea class="form-control" disabled><?= $commande['commentaire_livraison']; ?></textarea>
                                </div>

                            </div>
                        </div>

                        <!-- <div style="border: 3px solid black; border-radius: 5px; padding: 1rem; margin-left: 1rem; color:#ff9900; width: 23%;">
                            <p><strong>Mon échéancier : </strong>AUCUN</p>
                            <p>1er : </p>
                            <p>2e  : </p>
                            <p>3e  : </p>

                            <p>Total de la commande : </p>
                            <p style="color: black">Par airtel Money</p>
                            <p><strong>Poids du colis : </strong> 4</p>

                        </div> -->
                        <div class="details-container" style="border: 3px solid #dee2e6; border-radius: 5px; padding: 1rem; width: 27%;  height: fit-content;">
                            <!-- <p style="color:#ff9900;"><strong>Mon échéancier : </strong>AUCUN</p> -->

                            <div>
                                <p><?php if (!empty($commande['id_paiement_pf'])) {
                                        $req_select = $bdd->prepare("SELECT * FROM configurations_modes_paiement_plusieurs_fois Where id=?");
                                        $req_select->execute(array($commande['id_paiement_pf']));
                                        $ligne_select55 = $req_select->fetch();
                                        $req_select->closeCursor();

                                        echo "Payé en plusieurs fois " . $ligne_select55['nom'];
                                    ?>
                                        <span onmouseover="showEcheancier()" onmouseout="hideEcheancier()"
                                            style="color: #1a66ff; cursor: context-menu;">- Voir échéancier</span>
                                    <?php
                                    } elseif ($commande['id_paiement'] != 2 && $commande['id_paiement'] != 3) {
                                        $req_select = $bdd->prepare("SELECT * FROM configurations_modes_paiement Where id=?");
                                        $req_select->execute(array($commande['id_paiement']));
                                        $ligne_select55 = $req_select->fetch();
                                        $req_select->closeCursor();

                                        echo "Payé au comptant " . $ligne_select55['nom_mode'];
                                    } elseif ($commande['id_paiement'] == 2 || $commande['id_paiement'] == 3) {
                                        $req_select = $bdd->prepare("SELECT * FROM configurations_modes_paiement Where id=?");
                                        $req_select->execute(array($commande['id_paiement']));
                                        $ligne_select55 = $req_select->fetch();
                                        $req_select->closeCursor();

                                        echo "Payé en " . $ligne_select55['nom_mode'];
                                    } ?>
                                </p>
                            </div>

                            <div id="echeancier"
                                style="display: none; position: absolute; background-color: white; border: 1px solid #dee2e6; padding: 1rem; z-index: 1; width:10rem;">
                                <p>1er : <?= $commande['dette_montant_pf'] ?></p>
                                <p>2e : <?= $commande['dette_montant_pf2'] ?></p>
                                <p>3e : <?= $commande['dette_montant_pf3'] ?></p>
                            </div>

                            <p>Total de la commande : <?= number_format($commande['prix_total'], 0, '.', ' '); ?> F CFA</p>
                            <p style="margin-bottom: auto"><strong>Poids du colis : </strong> <?= $commande['poids']; ?></p>
                        </div>


                        <!--                        <div>-->
                        <!--                            Mode de livraison : --><?php //= $livraison['nom_livraison'] 
                                                                                ?>
                        <!--                        </div>-->
                        <!---->
                        <!--                        --><?php
                                                        //                        if (!empty($commande['id_paiement_pf'])) {
                                                        //                            echo "Paiement en plusieur fois <br>";
                                                        //                            if ($commande['id_paiement_pf'] == '2' || $commande['id_paiement_pf'] == '1') {
                                                        //
                                                        //                                echo $commande['dette_montant_pf'] . "   Statut: " . $commande['dette_payee_pf'] . "<br>";
                                                        //                                echo $commande['dette_montant_pf2'] . "   Statut: " . $commande['dette_payee_pf2'] . "<br>";
                                                        //
                                                        //                            } elseif ($commande['id_paiement_pf'] == '4' || $commande['id_paiement_pf'] == '3') {
                                                        //
                                                        //                                echo $commande['dette_montant_pf'] . " Statut: " . $commande['dette_payee_pf'] . "<br>";
                                                        //                                echo $commande['dette_montant_pf2'] . " Statut: " . $commande['dette_payee_pf2'] . "<br>";
                                                        //
                                                        //                            } elseif ($commande['id_paiement_pf'] == '6' || $commande['id_paiement_pf'] == '5') {
                                                        //
                                                        //                                echo $commande['dette_montant_pf'] . " Statut: " . $commande['dette_payee_pf'] . "<br>";
                                                        //                                echo $commande['dette_montant_pf2'] . " Statut: " . $commande['dette_payee_pf2'] . "<br>";
                                                        //                                echo $commande['dette_montant_pf3'] . " Statut: " . $commande['dette_payee_pf3'] . "<br>";
                                                        //
                                                        //                            }
                                                        //
                                                        //                        }
                                                        //                        
                                                        ?>

                    </div>


                    <div class="table-container" style="border: 3px solid #ff9900; border-radius: 5px; padding: 0 1rem 1rem 1rem; margin-top: 1rem; max-height: 20vh; overflow-y: auto; scrollbar-color: #ff9900 #dee2e6 ; margin: 10px;">
                        <table class="table">
                            <thead>
                                <tr style="color: #ff9900; text-align: center;">
                                    <th>Produit</th>
                                    <th>Nom du Produit</th>
                                    <th>Couleur</th>
                                    <th>Taille</th>
                                    <th>Categorie</th>
                                    <th>Quantité</th>
                                    <th>Prix U.</th>
                                </tr>
                            </thead>
                            <tbody>


                                <!-- Article details in separate horizontal tables -->
                                <?php
                                $ar = 0;
                                $req_boucle = $bdd->prepare("SELECT * FROM membres_commandes_details WHERE commande_id=? ORDER BY id DESC");
                                $req_boucle->execute(array($id));
                                while ($ligne_boucle = $req_boucle->fetch()) {
                                    $ar++;

                                    $prix_rr = $ligne_boucle['prix_reel'] ? $ligne_boucle['prix_reel'] : $ligne_boucle['prix'];
                                ?>

                                    <tr>
                                        <td data-title="Produit" style="text-align: center; ">
                                            <a href="<?= isset($ligne_boucle['url']) && !empty($ligne_boucle['url']) ? $ligne_boucle['url'] : '#' ?>"
                                                target="_blank">Article <?= $ar ?></a>
                                        </td>
                                        <td data-title="Nom du Produit" style="text-align: center;">
                                            <?= isset($ligne_boucle['nom']) && !empty($ligne_boucle['nom']) ? $ligne_boucle['nom'] : '---' ?>
                                        </td>
                                        <td data-title="Couleur" style="text-align: center;">
                                            <?= isset($ligne_boucle['couleur']) && !empty($ligne_boucle['couleur']) ? $ligne_boucle['couleur'] : '---' ?>
                                        </td>
                                        <td data-title="Taille" style="text-align: center;">
                                            <?= isset($ligne_boucle['taille']) && !empty($ligne_boucle['taille']) ? $ligne_boucle['taille'] : '---' ?>
                                        </td>
                                        <td data-title="Categorie" style="text-align: center;">
                                            <?= isset($ligne_boucle['categorie']) && !empty($ligne_boucle['categorie']) ? $ligne_boucle['categorie'] : '---' ?>
                                        </td>
                                        <td data-title="Quantité" style="text-align: center;">
                                            <?= isset($ligne_boucle['quantite']) && !empty($ligne_boucle['quantite']) ? $ligne_boucle['quantite'] : '---' ?>
                                        </td>
                                        <td data-title="Prix U." style="text-align: center;">
                                            <?php
                                            // En caso de que $prix_rr no tenga valor, mostramos el valor por defecto
                                            if (!isset($prix_rr) || empty($prix_rr)) {
                                                echo '---';
                                            } else {
                                                echo number_format($prix_rr, 0, '.', ' ');
                                                echo " F CFA (" . round($prix_rr * 0.00152449, 2) . "€)";
                                            }
                                            ?>
                                        </td>
                                    </tr>

                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="montant" style="display: flex;justify-content: flex-end; width: 100%; margin-top: 1rem;">
                        <div style="/* width: 20%; */ border: 1px solid #dee2e6; border-radius:1rem; padding:0.5rem; margin-right: 1rem; ">
                            Montant dû : <?= $commande['restant_payer'] ? number_format($commande['restant_payer'], 0, '.', ' ') : 0 ?> F CFA
                        </div>
                        <div style="/* width: 20%;  */ border: 1px solid #dee2e6; border-radius:1rem; padding:0.5rem;">Montant
                            avoir : <?= $commande['restant_rembourser'] ? $commande['restant_rembourser'] : 0 ?> F CFA
                        </div>
                    </div>
                </div>



                <div class="adresse-container" style="width: 20%; border-left: 1px solid #dee2e6;">
                    <!--                    <h5 class="modal-title">Adresses liées à cette commande</h5>-->

                    <div>


                        <div style="width: 100%;">
                            <div style="text-align: center; border-bottom: 1px solid #dee2e6;">
                                <strong style='color: black;'>Adresse de Facturation</strong>
                            </div>

                            <div class="adresse-text" style="margin-top: 1rem;">
                                <?= nl2br($commande['adresse_fac'])  ?>
                            </div>

                        </div>

                        <div style="width: 100%; margin-top: 2rem ">
                            <div style="text-align: center;  border-bottom: 1px solid #ff9900;">
                                <strong style='color: #ff9900;'>Adresse de Livraison</strong>
                            </div>

                            <div class="adresse-text" style="margin-top: 1rem;">
                                <?= nl2br($commande['adresse_liv'])  ?>
                            </div>

                        </div>
                        <div style="margin-top : 3rem;">
                            <?php
                            $req_facture = $bdd->prepare("SELECT * FROM membres_prestataire_facture WHERE id_commande=?");
                            $req_facture->execute(array($commande['id']));
                            $facture = $req_facture->fetch();
                            $req_facture->closeCursor();

                            if ($facture && $facture['statut'] == "Activée") {
                                $reference_numero = $facture['REFERENCE_NUMERO'];
                                echo '<div style=" display: flex; justify-content: center; align-content: center">
                                    <a class="btn btn-primary" href="/facture/' . $reference_numero . '/' . $nomsiteweb . '">
                                        Recevoir ma facture
                                    </a>
                                  </div>';
                            }


                            ?>
                            <div style="display: flex; justify-content: center; align-content: center">
                       
                                <button style="border-radius: 10px;" id="annuler_commande" class="btn btn-danger" data-id="<?= $commande['id'] ?>" <?= $commande['statut_2'] == "3" || $commande['statut_2'] == "2" ? "disabled" : "" ?>>
                                    <?= $commande['statut_2'] == "3" ? "Commande annulée" : "Annuler commande" ?>
                                </button>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>
        <!-- <div class="modal-footer">
            <button type="button" class="btn btn-secondary close"
                    style="color:#fff;background-color:#5a6268;border-color:#545b62;padding:0.375rem 1.25rem"
                    data-dismiss="modal">Fermer
            </button>
        </div> -->
    </div>


<?php }

ob_end_flush();
?>

<script>
    function showEcheancier() {
        var echeancier = document.getElementById("echeancier");
        echeancier.style.display = "block";
    }

    function hideEcheancier() {
        var popup = document.getElementById("echeancier");
        popup.style.display = "none";
    }
</script>