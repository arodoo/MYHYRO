<?php
if (!empty($user)) {
    $req_select3 = $bdd->prepare("SELECT * FROM membres_panier_details WHERE id_membre=?");
    $req_select3->execute(array($id_oo));
    $ligne_select3 = $req_select3->fetch();
    $req_select3->closeCursor();

    $req_select_Abonnement = $bdd->prepare("SELECT * FROM membres WHERE pseudo=?");
    $req_select_Abonnement->execute(array($user));
    $ligne_select_membre = $req_select_Abonnement->fetch();
    $req_select_Abonnement->closeCursor();

    $Abonnement_demande = $ligne_select_membre['Abonnement_demande'];


?>

    <script>
        $(document).ready(function() {

            $(document).on("click", ".commande", function() {
                var abonnementDemande = <?php echo json_encode($Abonnement_demande); ?>;
                if ((abonnementDemande == 2 || abonnementDemande == 3) && Abonnement_id == 1) {
                    popup_alert("vous avez déjà une demande en cours", "red filledlight", "#CC0000", "uk-icon-times");
                    return;
                }
                $.post({
                    url: '/pages/Abonnements/Abonnements-popup-panier-ajax.php',
                    type: 'POST',
                    data: {
                        idaction: $(this).attr('data-id')
                    },
                    dataType: "json",
                    success: function(res) {
                        if (res.retour_validation == "ok") {
                            location.href = "/Paiement";
                        }

                        //$("#modal-abonnement-retour").html(res);
                    }
                });
            });


        });
    </script>

<?php
}

///////////////////////////////SELECT
$req_select1 = $bdd->prepare("SELECT * FROM configurations_abonnements WHERE id=1");
$req_select1->execute();
$ligne_select1 = $req_select1->fetch();
$req_select1->closeCursor();

$req_select2 = $bdd->prepare("SELECT * FROM configurations_abonnements WHERE id=2");
$req_select2->execute();
$ligne_select2 = $req_select2->fetch();
$req_select2->closeCursor();

$req_select3 = $bdd->prepare("SELECT * FROM configurations_abonnements WHERE id=3");
$req_select3->execute();
$ligne_select3 = $req_select3->fetch();
$req_select3->closeCursor();

$req_selectp = $bdd->prepare("SELECT * FROM configurations_modes_paiement_conditions");
$req_selectp->execute();
$ligne_selectp = $req_selectp->fetch();
$req_selectp->closeCursor();
$abo_1_paiement_3_fois = $ligne_selectp["abo_1_paiement_3_fois"];
$abo_2_paiement_3_fois = $ligne_selectp["abo_2_paiement_3_fois"];
$abo_3_paiement_3_fois = $ligne_selectp["abo_3_paiement_3_fois"];
$abo_1_avancement_60_pourcent =  $ligne_selectp["abo_1_avancement_60_pourcent"];
$abo_2_avancement_60_pourcent =  $ligne_selectp["abo_2_avancement_60_pourcent"];
$abo_3_avancement_60_pourcent =  $ligne_selectp["abo_3_avancement_60_pourcent"];





//////////////////////Abonnement uttilisateur
if (!empty($user)) {
    //include('panel/include-abonnements-en-cours-menu.php');
?>
    <div class="card-header">
        <h5>Liste des abonnements</h5>
    </div>
<?php
}
?>

<div class="block">
    <div class="container">
        <div class="table-responsive">
            <table class="compare-table" style="background: #2f2f2f05;">
                <tbody>
                    <tr>
                        <th class="th-hidden col-md-3"></th>
                        <td style=" border-top: 5px solid #18c9cbd6; border-radius: 10px 10px 0 0" class="large-colonne box_shadow1">
                            <a class="compare-table__product-link">
                                <h5 class="compare-table__product-name" style="color: #18c9cbd6">
                                    <?php
                                    if ($Abonnement_id == 1) {
                                        echo "<span class='uk-icon-check' ></span> ";
                                    }
                                    echo "" . $ligne_select1['nom_abonnement'] . "";
                                    ?>
                                </h5>
                                <p class="price-abo"><?= $ligne_select1['Prix'] ?></p>
                                <!--button data-id="1" class="btn btn-primary-light text-uppercase 
                                        <?php if (!empty($user)) {
                                            echo "commande";
                                        } else {
                                            echo "pxp-header-user";
                                        } ?>">
                                        <?php if ($Abonnement_id == 1) {
                                            echo "";
                                        }
                                        // echo "" . $ligne_select1['Prix'] . ""; 
                                        ?> 
                                            Choisir</button-->
                            </a>
                        </td>
                        <td style="background: #fff;"></td>
                        <td style="border-top: 5px solid #18cb90bf; border-radius: 10px 10px 0 0" class="large-colonne box_shadow1">
                            <a class="compare-table__product-link">
                                <h5 class="compare-table__product-name" style="color: #18cb90bf">
                                    <?php if ($Abonnement_id == 2) {
                                        echo "<span class='uk-icon-check' ></span> ";
                                    }
                                    echo "" . $ligne_select2['nom_abonnement'] . "";
                                    ?>
                                </h5>
                                <p class="price-abo"><?= $ligne_select2['Prix']  ?><span class="ml-1" style="font-size: 16px; color: #9E9E9E;">/An</span></p>
                                <!--button data-id="1" 
                                        class="btn btn-primary-light text-uppercase 
                                        <?php if (!empty($user)) {
                                            echo "commande";
                                        } else {
                                            echo "pxp-header-user";
                                        } ?>">
                                        <?php if ($Abonnement_id == 2) {
                                            echo "";
                                        }
                                        //echo "" . $ligne_select2['Prix'] . ""; 
                                        ?> 
                                        
                                        Choisir
                                </button-->
                            </a>
                        </td>
                        <td style="background: #fff;"></td>
                        <td style="border-top: 5px solid #ff884ee3; border-radius: 10px 10px 0 0" class="large-colonne box_shadow1">
                            <a class="compare-table__product-link">
                                <h5 class="compare-table__product-name" style="color: #ff884ee3">
                                    <?php if ($Abonnement_id == 3) {
                                        echo "";
                                    }
                                    echo "" . $ligne_select3['nom_abonnement'] . "";
                                    ?>
                                </h5>
                                <p class="price-abo"><?= $ligne_select3['Prix']  ?><span class="ml-1" style="font-size: 16px; color: #9E9E9E;">/An</span></p>
                                <!--button data-id="1" 
                                        class="btn btn-primary-light text-uppercase 
                                        <?php if (!empty($user)) {
                                            echo "commande";
                                        } else {
                                            echo "pxp-header-user";
                                        } ?>">
                                        <?php if ($Abonnement_id == 3) {
                                            echo "";
                                        }
                                        // echo "" . $ligne_select3['Prix'] . ""; 
                                        ?>
                                        Choisir
                                </button-->
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <th class="th-hidden"></th>
                        <td colspan="5" style="border: none;" class="th-hidden td-colspan text-uppercase font-weight-bold">Nos services <span class="text-lowercase">en fcfa<span></td>
                    </tr>

                    <tr>
                        <th class="odd" style="border-radius: 10px 0 0 0;">Level</th>
                        <td><span class="compare-table__product-badge badge badge-warning">Hot</span></td>
                        <td style="background: #fff;"></td>
                        <td><span class="compare-table__product-badge badge badge-success">Standard</span></td>
                        <td style="background: #fff;"></td>
                        <td><span class="compare-table__product-badge badge badge-danger">Vip</span></td>
                    </tr>

                    <tr>
                        <th>Frais de gestion d'une commande</th>
                        <td><?php echo $ligne_select1['Frais_de_gestion_d_une_commande']; ?></td>
                        <td style="background: #fff;"></td>
                        <td><?php echo $ligne_select2['Frais_de_gestion_d_une_commande']; ?></td>
                        <td style="background: #fff;"></td>
                        <td><?php echo $ligne_select3['Frais_de_gestion_d_une_commande']; ?></td>
                    </tr>
                    <tr>
                        <th class="odd">Liste de souhaits (prospection)</th>
                        <td <?php echo ($ligne_select1['Liste_de_souhaits'] == "Gratuit") ? 'class="free"' : ''; ?>><?php echo $ligne_select1['Liste_de_souhaits']; ?></td>
                        <td style="background: #fff;"></td>
                        <td <?php echo ($ligne_select2['Liste_de_souhaits'] == "Gratuit") ? 'class="free"' : ''; ?>><?php echo $ligne_select2['Liste_de_souhaits']; ?></td>
                        <td style="background: #fff;"></td>
                        <td <?php echo ($ligne_select3['Liste_de_souhaits'] == "Gratuit") ? 'class="free"' : ''; ?>><?php echo $ligne_select3['Liste_de_souhaits']; ?></td>
                    </tr>
                    <tr>
                        <th>Frais de douane et transport possible à la livraison</th>
                        <td><i class="uk-icon-check-circle-o" style="color: green; font-size: 20px;"></i></td>
                        <td style="background: #fff;"></td>
                        <td><i class="uk-icon-check-circle-o" style="color: green; font-size: 20px;"></i></td>
                        <td style="background: #fff;"></td>
                        <td><i class="uk-icon-check-circle-o" style="color: green; font-size: 20px;"></i></td>
                    </tr>
                    <tr>
                        <th class="paiement_abonnement odd">Paiement en 2 ou 3 fois</th>
                        <td><?php echo ($abo_1_paiement_3_fois == "oui") ? '<i class="uk-icon-check-circle-o" style="color: green; font-size: 20px;"></i>' : '<i class="uk-icon-times-circle" style="color: red; font-size: 20px;"></i>'; ?></td>
                        <td style="background: #fff;"></td>
                        <td><?php echo ($abo_2_paiement_3_fois == "oui") ? '<i class="uk-icon-check-circle-o" style="color: green; font-size: 20px;"></i>' : '<i class="uk-icon-times-circle" style="color: red; font-size: 20px;"></i>'; ?></td>
                        <td style="background: #fff;"></td>
                        <td><?php echo ($abo_3_paiement_3_fois == "oui") ? '<i class="uk-icon-check-circle-o" style="color: green; font-size: 20px;"></i>' : '<i class="uk-icon-times-circle" style="color: red; font-size: 20px;"></i>'; ?></td>
                    </tr>
                    <tr>
                        <th class="paiement_abonnement" style="border-radius:  0 0 0 10px;">Avancement de 60% et le reste à la livraison</th>
                        <td><?php echo ($abo_1_avancement_60_pourcent == "oui") ? '<i class="uk-icon-check-circle-o" style="color: green; font-size: 20px;"></i>' : '<i class="uk-icon-times-circle" style="color: red; font-size: 20px;"></i>'; ?></td>
                        <td style="background: #fff;"></td>
                        <td><?php echo ($abo_2_avancement_60_pourcent == "oui") ? '<i class="uk-icon-check-circle-o" style="color: green; font-size: 20px;"></i>' : '<i class="uk-icon-times-circle" style="color: red; font-size: 20px;"></i>'; ?></td>
                        <td style="background: #fff;"></td>
                        <td><?php echo ($abo_3_avancement_60_pourcent == "oui") ? '<i class="uk-icon-check-circle-o" style="color: green; font-size: 20px;"></i>' : '<i class="uk-icon-times-circle" style="color: red; font-size: 20px;"></i>'; ?></td>
                    </tr>
                    <tr>
                        <th class="th-hidden"></th>
                        <td colspan="5" style="border: none;" class="th-hidden td-colspan text-uppercase font-weight-bold">Nos modes de livraisons <span class="text-lowercase">en fcfa<span></td>
                    </tr>
                    <?php

                    $oddRow = true;

                    $req_selectg = $bdd->prepare("SELECT nom_livraison, prix_1, prix_2, prix_3 FROM configurations_livraisons_gabon WHERE activer = ?");
                    $req_selectg->execute(array("oui"));

                    while ($ligne_selectg = $req_selectg->fetch()) {
                        $nom_livraison = $ligne_selectg['nom_livraison'];
                        $prix_1 = $ligne_selectg['prix_1'];
                        $prix_2 = $ligne_selectg['prix_2'];
                        $prix_3 = $ligne_selectg['prix_3'];

                        $rowClass = $oddRow ? 'odd' : '';
                        $borderStyle = ($nom_livraison == "Point de retrait LBV") ? 'border-radius : 10px 0 0 0;' : '';

                    ?>
                        <tr>
                            <th class="<?php echo $rowClass; ?>" style="<?php echo $borderStyle; ?>"><?= $nom_livraison ?></th>
                            <td <?php echo ($prix_1 == "Gratuit") ? 'class="free"' : ''; ?>>
                                <?php echo ($prix_1 != null) ? $prix_1 : '<i class="uk-icon-times-circle" style="color: red; font-size: 20px;"></i>'; ?>
                                <?php echo ($prix_1 != "Gratuit" && $prix_1 != null) ? '' : ''; ?>
                            </td>
                            <td></td>
                            <td <?php echo ($prix_2 == "Gratuit") ? 'class="free"' : ''; ?>><?= $prix_2 ?></td>
                            <td></td>
                            <td <?php echo ($prix_3 == "Gratuit") ? 'class="free"' : ''; ?>><?= $prix_3 ?></td>
                        </tr>
                    <?php
                        $oddRow = !$oddRow;
                    }

                    $req_selectg->closeCursor();
                    ?>

                    <!--     <tr>
                        <th class="odd" style="border-radius: 0 0 0 10px;">Panier</th>
                        <td>
                            <button data-id="1"
                                class="btn btn-primary-light 
                                <?php if (!empty($user)) {
                                    echo "commande";
                                } else {
                                    echo "pxp-header-user";
                                } ?>" <?php if ($Abonnement_id >= 1) {
                                            echo "disabled";
                                        }                                    ?>>

                                Sélectionner
                            </button>
                        </td>
                        <td></td>
                        <td><button data-id="2" class="btn btn-primary-light <?php if (!empty($user)) {
                                                                                    echo "commande";
                                                                                } else {
                                                                                    echo "pxp-header-user";
                                                                                } ?> "
                                <?php if ($Abonnement_id >= 2) {
                                    echo "disabled";
                                } ?>> Sélectionner
                            </button>
                        </td>
                        <td></td>
                        <td><button data-id="3" class="btn btn-primary-light <?php if (!empty($user)) {
                                                                                    echo "commande";
                                                                                } else {
                                                                                    echo "pxp-header-user";
                                                                                } ?>"
                                <?php if ($Abonnement_id > 2) {
                                    echo "disabled";
                                } ?>> Sélectionner
                            </button>
                        </td>
                    </tr> -->

                    <tr>
                        <th class="odd" style="border-radius: 0 0 0 10px;">Panier</th>
                        <td>
                            <button data-id="1"
                                class="btn btn-primary-light 
            <?php if (!empty($user)) {
                echo "commande";
            } else {
                echo "pxp-header-user";
            } ?>" <?php if ($Abonnement_id > 1) {
                        echo "disabled";
                    } ?>>

                                Sélectionner
                            </button>
                        </td>
                        <td></td>
                        <td><button data-id="2" class="btn btn-primary-light <?php if (!empty($user)) {
                                                                                    echo "commande";
                                                                                } else {
                                                                                    echo "pxp-header-user";
                                                                                } ?> "
                                <?php if ($Abonnement_id > 1) {
                                    echo "disabled";
                                } ?>> Sélectionner
                            </button>
                        </td>
                        <td></td>
                        <td><button data-id="3" class="btn btn-primary-light <?php if (!empty($user)) {
                                                                                    echo "commande";
                                                                                } else {
                                                                                    echo "pxp-header-user";
                                                                                } ?>"
                                <?php if ($Abonnement_id > 1) {
                                    echo "disabled";
                                } ?>> Sélectionner
                            </button>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="modal fade" id="modal-abonnement" tabindex="-1" role="dialog" aria-labelledby="modal-abonnement" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header" style="text-align: left;">
                <h2 class="modal-title style_color" id="pxpSigninModal" style="float: left;">Abonnement</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div style="clear: both;"></div>
            </div>
            <div class="modal-body" style="text-align: left;">
                <div id="modal-abonnement-retour"></div>
            </div>
        </div>
    </div>
</div>