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
if (!empty($user)) {

    $req_select = $bdd->prepare("SELECT * FROM membres_panier WHERE id_membre=?");
    $req_select->execute(array($id_oo));
    $ligne_select = $req_select->fetch();
    $req_select->closeCursor();

    $req_select = $bdd->prepare("SELECT count(*) as v2, TTC_colis FROM membres_panier_details WHERE numero_panier=? AND TTC_colis>0");
    $req_select->execute(array($ligne_select['id']));
    $ligne_val2 = $req_select->fetch();
    $req_select->closeCursor();



    $req_select = $bdd->prepare("SELECT count(*) as v FROM membres_panier_details WHERE numero_panier=?");
    $req_select->execute(array($ligne_select['id']));
    $ligne_val = $req_select->fetch();
    $req_select->closeCursor();

    if ($ligne_val['v'] > 0) {

        $_SESSION['type_paiement'] = $_GET['type_paiement'];
        $_SESSION['idaction'] = $_GET['idaction'];
        $idaction = $_GET['idaction'];

        if (empty($_GET['type_paiement'])) {
            $_SESSION['type_paiement'] = "Panier";
        }
        ////////////////////////////////////////////////////////////////////////////////REQUÊTE PANIER OU FACTURE
        if ($_GET['type_paiement'] == "Facture") {
            $table_update = "membres_prestataire_facture";
            ///////////////////////////////SELECT
            $req_select = $bdd->prepare("SELECT * FROM membres_prestataire_facture WHERE id=?");
            $req_select->execute(array($_GET['idaction']));
            $ligne_select = $req_select->fetch();
            $req_select->closeCursor();
        } elseif ($_GET['type_paiement'] == "Panier" && !empty($_GET['idaction'])) {
            $table_update = "membres_panier";
            ///////////////////////////////SELECT
            $req_select = $bdd->prepare("SELECT * FROM membres_panier WHERE id=?");
            $req_select->execute(array($_GET['idaction']));
            $ligne_select = $req_select->fetch();
            $req_select->closeCursor();
        } elseif ($_SESSION['panier'] == "true" && isset($_SESSION['idpanier'])) {
            ///////////////////////////////SELECT
            $table_update = "membres_panier";
            $req_select = $bdd->prepare("SELECT * FROM membres_panier WHERE pseudo=? AND id=?");
            $req_select->execute(array(
                $user,
                $_SESSION['idpanier']
            ));
            $ligne_select = $req_select->fetch();
            $req_select->closeCursor();
        } else {
            ///////////////////////////////SELECT
            $table_update = "membres_panier";
            $req_select = $bdd->prepare("SELECT * FROM membres_panier WHERE pseudo=?");
            $req_select->execute(array($user));
            $ligne_select = $req_select->fetch();
            $req_select->closeCursor();
        }

        $id_facture_panier = $ligne_select['id'];
        //On renomme la session pour la page de retour des paiements
        $_SESSION['idaction'] = $id_facture_panier;

        //Factures
        $numero_facture = $ligne_select['numero_facture'];
        $Titre_facture = $ligne_select['Titre_facture'];

        //Panier
        $numero_panier = $ligne_select['numero_panier'];
        $id_facture = $ligne_select['id_facture'];
        $Titre_panier = $ligne_select['Titre_panier'];
        $_SESSION['type_panier'] = $ligne_select['type_panier'];

        $Contenu = $ligne_select['Contenu'];
        $Suivi = $ligne_select['Suivi'];
        $date_edition = $ligne_select['date_edition'];
        $mod_paiement = $ligne_select['mod_paiement'];
        $Tarif_HT = $ligne_select['Tarif_HT'];
        $Remise = $ligne_select['Remise'];
        $Tarif_HT_net = $ligne_select['Tarif_HT_net'];
        $Tarif_TTC = $ligne_select['Tarif_TTC'];
        $Total_Tva = $ligne_select['Total_Tva'];
        $taux_tva = $ligne_select['taux_tva'];
        $condition_reglement = $ligne_select['condition_reglement'];
        $delai_livraison = $ligne_select['delai_livraison'];
        $Type_compte_F = $ligne_select['Type_compte_F'];

        if ($_GET['type_paiement'] == "Facture") {
            $table_liste_details = "membres_panier_details WHERE numero_facture=?";
            $table_liste_details_valeur = "$numero_facture";
            $titre_h1_page = "Paiement de la facture N°$numero_facture";
        } elseif ($_GET['type_paiement'] == "Panier" && !empty($_GET['idaction'])) {
            $table_liste_details = "membres_panier_details WHERE numero_panier=?";
            $table_liste_details_valeur = "$id_facture_panier";
            $titre_h1_page = "Paiement du panier";
        } else {
            $table_liste_details = "membres_panier_details WHERE numero_panier=?";
            $table_liste_details_valeur = "$id_facture_panier";
            $titre_h1_page = "$Paiementpanier_traduction";
        }
        $_SESSION['table_liste_detail'] = $table_liste_detail;

        ////////////////////////////////////////////////////////////////////////////////REQUÊTE PANIER OU FACTURE
?>

        <script>
            $(document).ready(function() {

                //AJAX SOUMISSION DU FORMULAIRE - CODE PROMOTION
                $(document).on("click", "#Remise_bouton", function() {
                    $.post({
                        url: '/pages/paiements/Panier/ajax/Panier-code-promotion-ajax.php',
                        type: 'POST',
                        data: {
                            remise: "oui",
                            code_promo: $("#Remise").val(),
                            table_update: "<?php echo $table_update; ?>",
                            id_facture_panier: "<?php echo $id_facture_panier; ?>",
                        },
                        dataType: "json",
                        success: function(res) {
                            if (res.retour_validation == "ok") {
                                popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                            } else {
                                popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                            }
                            RecapitulatifPanier();
                        }
                    });
                });

                //AJAX SOUMISSION DU FORMULAIRE - VIDER
                $(document).on("click", "#vider_panier", function() {
                    $.post({
                        url: '/pages/paiements/Panier/Panier-vider.php',
                        type: 'POST',
                        data: {},
                        dataType: "json",
                        success: function(res) {
                            if (res.retour_validation == "ok") {
                                RecapitulatifPanier();
                                popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                            } else {
                                popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                            }
                        }
                    });
                });

                //AJAX SOUMISSION DU FORMULAIRE - MODIFIER
                $(document).on("click", "#button-informations_mise_a_jour_panier", function() {
                    $.post({
                        url: '/pages/paiements/Panier/ajax/Panier-informations-action-ajax.php',
                        type: 'POST',
                        data: new FormData($("#form-informations_mise_a_jour_panier")[0]),
                        processData: false,
                        contentType: false,
                        dataType: "json",
                        success: function(res) {
                            if (res.retour_validation == "ok") {
                                popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                            } else {
                                popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                            }
                        }
                    });
                });

                //AJAX SOUMISSION DU FORMULAIRE - SUPPRIMER
                $(document).on("click", ".supprimer-item", function() {
                    $.post({
                        url: '/pages/paiements/Panier/ajax/Panier-supprimer-action-ajax.php',
                        type: 'POST',
                        data: {
                            idaction: $(this).attr("data-id")
                        },
                        dataType: "json",
                        success: function(res) {
                            if (res.retour_validation == "ok") {
                                RecapitulatifPanier();
                                popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                            } else {
                                popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                            }
                        }
                    });
                });

                //FUNCTION AJAX - RECAPITULATIF PAIEMENT
                function RecapitulatifPanier(no_recap) {
                    $.post({
                        url: '/pages/paiements/Panier/ajax/Panier-ajax.php',
                        type: 'POST',
                        data: {
                            <?php
                            if ($_GET['type_paiement'] == "Facture" || $_GET['type_paiement'] == "Panier") {
                            ?>
                                type_paiement: "<?php echo $_GET['type_paiement']; ?>",
                                idaction: <?php echo $_GET['idaction']; ?>,
                            <?php
                            } else if (isset($_SESSION['idpanier']) && $_SESSION['panier'] == "true") { ?>
                                type_paiement: "Panier",
                                idaction: <?= $_SESSION['idpanier']; ?>,
                            <?php } ?>

                        },
                        dataType: "html",
                        success: function(res) {
                            $("#recapitulatif-panier").html(res);
                        }
                    });
                }
                no_recap = "non";
                RecapitulatifPanier(no_recap);

                <?php
                if (empty($user)) {
                ?>
                    //AJAX SOUMISSION DU FORMULAIRE
                    $(document).on("click", "#login_post", function() {
                        $.post({
                            url: '/pop-up/login/login_popup-ajax.php',
                            type: 'POST',
                            data: {
                                login: $('#login').val(),
                                password: $('#password_login').val(),
                                login_post: $('#login_post').val()
                            },
                            dataType: "json",
                            success: function(res) {
                                if (res.retour_validation == "Ok") {
                                    RecapitulatifPanier();
                                } else {
                                    popup_alert(res.Texte_rapport_panier, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                                }
                            }
                        });
                    });
                <?php
                } ?>

                $(document).on("click", ".modif_quantite", function() {


                });

                $(document).on("click", ".input-number__sub", function() {
                    let $quantite = document.querySelector(".quantite" + $(this).attr("data-id"));
                    let $quantiteValue = parseInt($quantite.value);
                    if ($quantiteValue > 1) {
                        $quantiteValue -= 1;
                    } else {
                        $quantiteValue = 1;
                    }
                    $quantite.value = $quantiteValue;

                    $.post({
                        url: '/pages/paiements/Panier/ajax/Panier-modifier-quantite-action-ajax.php',
                        type: 'POST',
                        data: {
                            idaction: $(this).attr("data-id"),
                            quantite: $quantiteValue,
                        },
                        dataType: "json",
                        success: function(res) {
                            if (res.retour_validation == "ok") {
                                //popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                                no_recap = "oui";
                                RecapitulatifPanier(no_recap);
                            } else {
                                popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                            }
                        }
                    });
                });

                $(document).on("click", ".input-number__add", function() {

                    let $quantite = document.querySelector(".quantite" + $(this).attr("data-id"));
                    let $quantiteValue = parseInt($quantite.value);

                    $quantiteValue += 1;
                    $quantite.value = $quantiteValue;
                    $.post({
                        url: '/pages/paiements/Panier/ajax/Panier-modifier-quantite-action-ajax.php',
                        type: 'POST',
                        data: {
                            idaction: $(this).attr("data-id"),
                            quantite: $quantiteValue,
                        },
                        dataType: "json",
                        success: function(res) {
                            if (res.retour_validation == "ok") {
                                //popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                                no_recap = "oui";
                                RecapitulatifPanier(no_recap);
                            } else {
                                popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                            }
                        }
                    });
                    //$quantite.innerHTML = $quantiteValue;


                });

                $(document).on("change", "#payer_ala_livraison", function() {
                    // Décochez la case avant d'envoyer la requête
                    $('#payer_ala_livraison').prop('disabled', true);


                    payer_livraison();
                });

                function payer_livraison() {
                    // Vérifiez si la case est cochée
                    var datad = $('#payer_ala_livraison').is(':checked') ? 'oui' : 'non';

                    $.post({
                        url: '/pages/paiements/Panier/ajax/Panier-frais-ajax.php',
                        type: 'POST',
                        data: {
                            idaction: datad,
                        },
                        dataType: "json",
                        success: function(res) {
                            if (res.retour_validation == "ok") {
                                no_recap = "oui";
                                RecapitulatifPanier(no_recap);
                                listeCart();
                            } else {
                                popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                            }
                        },
                        error: function() {
                            popup_alert("Erreur de connexion avec le serveur.", "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                        },
                        complete: function() {
                            // Activez à nouveau la case à cocher après la réponse du serveur
                            $('#payer_ala_livraison').prop('disabled', false);
                        }
                    });
                }



                $(document).on("click", "#delete-panier", function() {
                    let text = "Voulez-vous vraiment supprimer?";
                    if (confirm(text) == true) {
                        $.post({
                            url: '/pages/paiements/Panier/ajax/Panier-supprimer2-action-ajax.php',
                            type: 'POST',
                            data: {
                                idaction: $(this).attr("data-id"),
                            },
                            dataType: "json",
                            success: function(res) {
                                if (res.retour_validation == "ok") {
                                    popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                                    if (res.retour_lien == 0) {
                                        location.href = '/Passage-de-commande';
                                    } else {
                                        no_recap = "oui";
                                        RecapitulatifPanier(no_recap);
                                    }
                                    listeCart();
                                } else {
                                    popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                                }
                            }
                        });
                    }
                });

                //AJAX SOUMISSION QUANTITE
                $(document).on("click", ".uk-icon-plus-circle", function() {
                    var calcul_plus = parseInt($("input[name=quantite]").val());
                    var calcul_plus_result = Number(calcul_plus + 1);
                    if (calcul_plus_result < 0) {
                        $("input[name=quantite]").val("0");
                    } else {
                        $("input[name=quantite]").val(calcul_plus_result);
                    }
                    onchange_quantite($("input[name=quantite]").val(), $(this).attr("data-id"), $(this).attr("data-typeaction"), $(this).attr("data-idpagepanier"));
                });

                $(document).on("click", ".uk-icon-minus-square", function() {
                    var calcul_moins = parseInt($("input[name=quantite]").val());
                    var calcul_moins_result = Number(calcul_moins - 1);
                    if (calcul_moins_result < 0) {
                        $("input[name=quantite]").val("0");
                    } else {
                        $("input[name=quantite]").val(calcul_moins_result);
                    }
                    onchange_quantite($("input[name=quantite]").val(), $(this).attr("data-id"), $(this).attr("data-typeaction"), $(this).attr("data-idpagepanier"));
                });

                function onchange_quantite(valeur_type, id_panier_detail, type_action, id_page_panier) {
                    $.post({
                        url: '/pages/paiements/Panier/ajax/Panier-quantite-ajax.php',
                        type: 'POST',
                        data: {
                            type_action: type_action,
                            id_page_panier: id_page_panier,
                            id_panier_detail: id_panier_detail,
                            type_valeur: valeur_type,
                        },
                        dataType: "json",
                        success: function(res) {
                            if (res.retour_validation == "ok") {
                                RecapitulatifPanier();
                            } else {
                                RecapitulatifPanier();
                                popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                            }
                        }
                    });
                }

                $(document).on('input', '#quantit', function() {
                    //onchange_quantite($("input[name=quantite]").val());
                    $.post({
                        url: '/pages/paiements/Panier/ajax/Panier-modifier-quantite-action-ajax.php',
                        type: 'POST',
                        data: {
                            idaction: $(this).attr("data-id"),
                            quantite: $(this).val(),
                        },
                        dataType: "json",
                        success: function(res) {
                            if (res.retour_validation == "ok") {
                                //popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                                no_recap = "oui";
                                RecapitulatifPanier(no_recap);
                            } else {
                                popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                            }
                        }
                    });
                });

                $(document).on('change', '.inputQuantite', function() {
                    onchange_quantite($("input[name=quantite]").val());
                });

                //AJAX SOUMISSION DU FORMULAIRE - VIDER
                $(document).on("click", ".supprimer", function() {
                    $.post({
                        url: '/pages/paiements/Panier/Panier-supprimer.php',
                        type: 'POST',
                        data: {
                            id_detail_panier: $(this).attr("data-id")
                        },
                        dataType: "json",
                        success: function(res) {
                            if (res.retour_validation == "ok") {
                                RecapitulatifPanier();
                                popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                            } else {
                                popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                            }
                        }
                    });
                });

                //AJAX SOUMISSION DU FORMULAIRE - PAIEMENT VALIDATION
                $(document).on("click", ".supprimer", function() {
                    $.post({
                        url: '/pages/paiements/Panier/Panier-payer.php',
                        type: 'POST',
                        data: {
                            id_detail_panier: $(this).attr("data-id")
                        },
                        dataType: "json",
                        success: function(res) {
                            if (res.retour_validation == "ok") {
                                RecapitulatifPanier();
                                popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                            } else {
                                popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                            }
                        }
                    });
                });
            });
        </script>

        <?php

        $req_select = $bdd->prepare("SELECT statut_compte FROM membres WHERE pseudo=?");
        $req_select->execute(array($user));
        $ligne_select = $req_select->fetch();
        $req_select->closeCursor();
        ?>

        <?php
        $req_select = $bdd->prepare("SELECT * FROM membres_panier WHERE pseudo=?");
        $req_select->execute(array($user));
        $ligne_select = $req_select->fetch();
        $req_select->closeCursor();
        $id_panier = $ligne_select['id'];

        $req_select = $bdd->prepare("SELECT * FROM membres_panier_details WHERE numero_panier=? AND (action_module_service_produit like 'Forfait' OR action_module_service_produit like 'Code promotion')");
        $req_select->execute(array($ligne_select['numero_panier']));
        $panier_details = $req_select->fetchAll(PDO::FETCH_ASSOC);
        $req_select->closeCursor();


        if ($panier_details) {
            foreach ($panier_details as $panier) {
                // var_dump ($panier);
                // $req_del = $bdd->prepare("DELETE FROM membres_panier_details WHERE id = ?");
                // $req_del->execute(array($panier['id']));
            }
            $upd_del = $bdd->prepare("UPDATE membres_panier SET code_promotion = null WHERE numero_panier = ?");
            $upd_del->execute(array($ligne_select['numero_panier']));
            unset($_SESSION['remise_panier_facture']);
            unset($_SESSION['code_promotion']);
        }
        //if(!empty($user) && !empty($id_panier) ){
        ?>
        <?php
        //}
        ?>
        <div style="clear: both;  margin-bottom: 20px;"></div>

        <!--
<div>
	<a class="btn btn-success p-fef" href="<?php echo $_SERVER['HTTP_REFERER']; ?>" >Page précédente</a>
	<div id="vider_panier" class="btn btn-danger" href="#" onclick="return false;" >Vider le panier</div>
</div>
-->

        <!-- BLOC RECAPITULATIF ET INFORMATIONS -->
        <div id='recapitulatif-panier'></div>

        <div id='boutonsValidation2'></div>

<?php

        //include("pages/paiements/paypal.php");
    } else {
        header('location: /Passage-de-commande');
    }
} else {
    header('location: /index.html');
}
?>