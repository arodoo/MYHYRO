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
            $req_select = $bdd->prepare("SELECT * FROM membres_panier WHERE id_membre=? AND id=?");
            $req_select->execute(array(
                $id_oo,
                $_SESSION['idpanier']
            ));
            $ligne_select = $req_select->fetch();
            $req_select->closeCursor();
        } else {
            ///////////////////////////////SELECT
            $table_update = "membres_panier";
            $req_select = $bdd->prepare("SELECT * FROM membres_panier WHERE id_membre=?");
            $req_select->execute(array($id_oo));
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
        //var_dump($Tarif_HT);
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

        ///////////////////////////////SELECT
        $req_selectpa = $bdd->prepare("SELECT * FROM membres_panier WHERE id_membre=?");
        $req_selectpa->execute(array($id_oo));
        $ligne_selectpa = $req_selectpa->fetch();
        $req_selectpa->closeCursor();






        ////////////////////////////////////////////////////////////////////////////////REQUÊTE PANIER OU FACTURE
?>

        <script>
            $(document).ready(function() {
                var $airtelInput = $('#airtelNumber');
                if ($airtelInput.length === 0) return;

                // Créer un conteneur pour les suggestions
                var $suggestionContainer = $('<div id="airtelSuggestions"></div>').css({
                    position: 'absolute',
                    border: '1px solid #ccc',
                    backgroundColor: '#fff',
                    display: 'none',
                    zIndex: 1000
                }).appendTo('body');

                var numbers = [];

                var idMembre = "<?php echo isset($id_oo) ? $id_oo : ''; ?>";


                $.ajax({
                    url: '/pages/paiements/Panier/autocomplete_telephone.php',
                    type: 'GET',
                    data: {
                        id_membre: idMembre
                    },
                    dataType: 'json',
                    success: function(data) {
                        numbers = data;
                        /* console.log("Números extraídos del backend:", numbers); */
                    },
                    /* error: function(xhr, status, error) {
                        console.error("Erreur lors du chargement des numéros:", error);
                    } */
                });

                // Événement d'entrée pour la saisie semi-automatique
                $airtelInput.on('input', function() {
                    var query = $(this).val().trim();
                    $suggestionContainer.empty();

                    var filtered = [];
                    if (query.length === 0) {
                        // Si vide, afficher toutes les options
                        filtered = numbers;
                    } else {
                        // Filtrer les nombres qui commencent par la requête
                        filtered = numbers.filter(function(num) {
                            return num.indexOf(query) === 0;
                        });
                    }

                    if (filtered.length === 0) {
                        $suggestionContainer.hide();
                        return;
                    }

                    // Créer un élément pour chaque suggestion
                    $.each(filtered, function(index, item) {
                        var $div = $('<div></div>').text(item).css({
                            padding: '5px',
                            cursor: 'pointer'
                        });
                        $div.on('click', function() {
                            $airtelInput.val(item);
                            $suggestionContainer.hide();
                        });
                        $suggestionContainer.append($div);
                    });

                    // Positionnez le conteneur juste en dessous de l'entrée
                    var rect = $airtelInput[0].getBoundingClientRect();
                    $suggestionContainer.css({
                        top: rect.bottom + window.scrollY + "px",
                        left: rect.left + window.scrollX + "px",
                        width: rect.width + "px",
                        display: "block"
                    });
                });

                // Masquer le conteneur si cliqué à l'extérieur
                $(document).on('click', function(e) {
                    if (!$(e.target).is($airtelInput) && !$suggestionContainer.is(e.target) && $suggestionContainer.has(e.target).length === 0) {
                        $suggestionContainer.hide();
                    }
                });
            });
        </script>

        <script>
            $(document).ready(function() {
                $('#btnModifier').click(function(e) {
                    e.preventDefault();

                    $('#modalContainer').load('/pages/paiements/Panier/popup-Informations-livraison.php', function() {

                        $('#envoyerMessageModal').modal('show');
                    });
                });
            });

            function closeModal() {
                $('#envoyerMessageModal').modal('hide');
            }



            $(document).ready(function() {

                // Variables
                let timeLeft = 60 + 20; // 5 minutes in seconds
                let timerInterval;
                let ajaxInterval;

                // Function to format time as MM:SS
                function formatTime(seconds) {
                    const minutes = Math.floor(seconds / 60);
                    const secs = seconds % 60;
                    return `${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
                }

                // Countdown Timer
                function startTimer() {
                    $('#temps-message').hide();
                    timerInterval = setInterval(function() {
                        timeLeft--;
                        $('#timer').text(formatTime(timeLeft));

                        // Show cancel button when timeLeft is 40 seconds
                        if (timeLeft === 50) {
                            $('#cancelButton').show();
                        }


                        if (timeLeft <= 0) {
                            clearInterval(timerInterval);
                            clearInterval(ajaxInterval);
                            $('#error-message').show(); // Show error message
                            $('#error-message2').show();
                            $('#loader').hide();
                            $("#modal-loading").modal("hide");
                            $('#temps-message').show();
                            clearInterval(ajaxInterval);
                            clearInterval(timerInterval);
                            timeLeft = 60 + 20;
                        }
                    }, 1000);
                }

                // Send AJAX request every 10 seconds
                function startAjaxRequests(reference) {
                    ajaxInterval = setInterval(function() {
                        $.post({
                            url: '/pages/paiements/Panier/ajax/verif-paiement.php',
                            type: 'POST',
                            data: {
                                reference: reference
                            },
                            dataType: "json",
                            success: function(res) {
                                if (res.retour_validation == "ok") {
                                    popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                                    clearInterval(ajaxInterval);
                                    clearInterval(timerInterval);
                                    location.href = res.retour_lien;
                                } else {
                                    popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                                    $("#modal-loading").modal("hide");
                                    $('#annuler-message').show();
                                    clearInterval(ajaxInterval);
                                    clearInterval(timerInterval);
                                    timeLeft = 60 + 20;
                                }
                            }
                        });
                    }, 4000); // Every 10 seconds
                }

                // // Start the modal and the countdown when the modal is shown
                // $('#modal-loading').on('shown.bs.modal', function() {
                // startTimer(); // Start countdown
                // startAjaxRequests(); // Start sending AJAX requests
                // });


                //AJAX SOUMISSION DU FORMULAIRE - MODIFIER
                $(document).on("click", "#button-informations_livraison_france", function() {
                    var airtelNumber = $("#airtelNumber").val();
                    var airtelNumberRegex = /^(077|074)\d{6}$/;

                    /* if (!airtelNumberRegex.test(airtelNumber)) {
                    popup_alert("Veuillez saisir le numéro au format 077XXXXXX ou 074XXXXXX sans mettre d'espace", "#CC0000 filledlight" , "#CC0000" , "uk-icon-times" );
                    return;
                    } */
                    $.post({
                        url: '/pages/paiements/Panier/ajax/Panier-livraison-action-ajax.php',
                        type: 'POST',
                        data: new FormData($("#form-livrason_france")[0]),
                        processData: false,
                        contentType: false,
                        dataType: "json",
                        success: function(res) {
                            if (res.retour_validation == "ok") {
                                popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                                location.href = '';
                            } else {
                                popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                            }
                        }
                    });
                });

                //AJAX SOUMISSION DU FORMULAIRE - MODIFIER
                $(document).on("click", "#button-informations_mise_a_jour_panier", function() {
                    var airtelNumber = $("#airtelNumber").val();
                    var airtelNumberRegex = /^(077|074)\d{6}$/;

                    /* if (!airtelNumberRegex.test(airtelNumber)) {
                    popup_alert("Veuillez saisir le numéro au format 077XXXXXX ou 074XXXXXX sans mettre d'espace", "#CC0000 filledlight" , "#CC0000" , "uk-icon-times" );
                    return;
                    } */
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
                                location.href = '';
                            } else {
                                popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                            }
                        }
                    });
                });

                //AJAX SOUMISSION DU FORMULAIRE - LIVRAISON
                $(document).on("click", ".radio_livraison", function() {
                    $(".custom-pf").prop("checked", false);
                    $('.act').attr('class', 'act payment-methods__item')
                    $('.des').empty()

                    $.post({
                        url: '/pages/paiements/Panier/ajax/Panier-2-mode_paiement-pf-ajax.php',
                        type: 'POST',
                        data: new FormData($("#modepaiementpf")[0]),
                        processData: false,
                        contentType: false,
                        dataType: "json",
                        success: function(res) {
                            if (res.retour_validation == "ok") {


                            } else {

                            }

                        }
                    });
                    $.post({
                        url: '/pages/paiements/Panier/ajax/Panier-2-livraison-ajax.php',
                        type: 'POST',
                        data: new FormData($("#modelivraison")[0]),
                        processData: false,
                        contentType: false,
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
                    if ($("input[name='checkout_payment_method2' ]:checked").val() == '3') {

                    }
                });

                //AJAX SOUMISSION DU FORMULAIRE - LIVRAISON
                $(document).on("click", "#payer", function() {


                    if ($(this).data("donnes") == "oui") {



                        <?php

                        if ($ligne_val2['v2'] > 0) {
                            $montant_minimum_ht = $prix_kilo_colis;
                            //var_dump($Tarif_TTC);
                            $Tarif_TTC = $ligne_val2['TTC_colis'];
                        }
                        if ($ligne_selectpa['Titre_panier'] == "Abonnement" || $ligne_selectpa['Titre_panier'] == "Liste") {
                            $montant_minimum_ht = 0;
                        }
                        if ($admin_oo == "1") {
                            $montant_minimum_ht = 0;
                        }
                        //var_dump($montant_minimum_ht, $Tarif_TTC);

                        ?>
                        var min_ht = <?php echo floatval($montant_minimum_ht); ?>;
                        var ttc = $("#totalttc").val();

                        if (parseFloat(ttc) > parseFloat(min_ht)) {
                            var mode_paiement = $("input[name='checkout_payment_method2' ]:checked").val();
                            var mode_pf = $("input[name='paiement_pf' ]:checked").val();
                            <?php if ($ligne_selectpa['Titre_panier'] != "Abonnement" && $ligne_selectpa['Titre_panier'] != "Liste") { ?>
                                if ($("#checkout-terms").is(":checked") && $("input[name='checkout_payment_method' ]:checked").val() && ($("input[name='checkout_payment_method2' ]:checked").val() || $("input[name='paiement_pf' ]:checked").val())) {

                                    if (mode_paiement == '1') {

                                        $.post({
                                            url: '/pages/paiements/Panier/includes/Panier-paypal-include-ajax.php',
                                            type: 'POST',
                                            data: {
                                                prix: $("#totalttc").val(),

                                            },
                                            dataType: "json",
                                            success: function(res) {
                                                if (res.retour_validation == "ok") {
                                                    popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                                                    location.href = res.retour_lien;
                                                } else {
                                                    popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                                                }
                                                //RecapitulatifPanier();
                                            }
                                        });

                                    } else if (mode_paiement == '2') {
                                        location.href = '/Traitements-cheque';
                                    } else if (mode_paiement == '3' || mode_pf == '2' || mode_pf == '4' || mode_pf == '6') {
                                        location.href = '/Traitements-especes';
                                    } else if (mode_paiement == '4' || mode_pf == '1' || mode_pf == '3' || mode_pf == '5') {

                                        if (mode_pf == '1') {
                                            var prix = Math.floor(parseFloat($("#totalttc").val()) * .60);
                                            var tel = $("#airtelNumber_" + mode_pf).val()
                                        } else if (mode_pf == '3') {
                                            var prix = Math.floor(parseFloat($("#totalttc").val()) * .50);
                                            var tel = $("#airtelNumber_" + mode_pf).val()
                                        } else if (mode_pf == '5') {
                                            var prix = Math.floor(parseFloat($("#totalttc").val()) * .33);
                                            var tel = $("#airtelNumber_" + mode_pf).val()
                                        } else if (mode_paiement == '4') {
                                            var prix = $("#totalttc").val();
                                            var tel = $("#airtelNumber").val();
                                        }
                                        $("#tel-popup").html(tel);
                                        $("#prix-popup").html(prix);
                                        clearInterval(timerInterval);
                                        timeLeft = 60 + 20;
                                        if (/^(074|077|066)\d{6}$/.test(tel)) {
                                            $.post({
                                                url: '/pages/paiements/Panier/ajax/Panier-2-Airtel-ajax.php',
                                                type: 'POST',
                                                data: {
                                                    prix: prix,
                                                    telephone_airtel: tel,
                                                },
                                                dataType: "json",
                                                success: function(res) {
                                                    if (res.retour_validation == "ok") {
                                                        popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                                                        $("#modal-loading").modal("show");
                                                        startTimer(); // Start countdown
                                                        startAjaxRequests(res.reference);
                                                    } else {
                                                        popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                                                    }
                                                    //RecapitulatifPanier();
                                                }
                                            });
                                        } else {
                                            document.getElementById('invalidPhoneNumberAlert').style.display = 'block';
                                            popup_alert("Veuillez saisir le numéro au format 077XXXXXX ou 074XXXXXX sans mettre d'espace", "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                                        }
                                    }

                                } else {
                                    if (!$("#checkout-terms").is(":checked"))
                                        popup_alert("Veuillez accepter nos CGV", "#CC0000 filledlight", "#CC0000", "uk-icon-times");

                                    if (!$("input[name='checkout_payment_method' ]:checked").val())
                                        popup_alert("Veuillez choisir un mode de livraison", "#CC0000 filledlight", "#CC0000", "uk-icon-times");

                                    if (!$("input[name='checkout_payment_method2' ]:checked").val() && !$("input[name='paiement_pf' ]:checked").val())
                                        popup_alert("Veuillez choisir un mode de paiement", "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                                }
                            <?php } else {
                            ?>
                                if (mode_paiement == '1') {

                                    $.post({
                                        url: '/pages/paiements/Panier/includes/Panier-paypal-include-ajax.php',
                                        type: 'POST',
                                        data: {
                                            prix: $("#totalttc").val(),

                                        },
                                        dataType: "json",
                                        success: function(res) {
                                            if (res.retour_validation == "ok") {
                                                popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                                                location.href = res.retour_lien;
                                            } else {
                                                popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                                            }
                                            //RecapitulatifPanier();
                                        }
                                    });

                                } else if (mode_paiement == '2') {
                                    location.href = '/Traitements-cheque';
                                } else if (mode_paiement == '3') {
                                    location.href = '/Traitements-especes';
                                } else if (mode_paiement == '4') {
                                    var prix = $("#totalttc").val();
                                    var tel = $("#airtelNumber").val();
                                    $("#tel-popup").html(tel);
                                    $("#prix-popup").html(prix);
                                    clearInterval(timerInterval);
                                    timeLeft = 60 + 20;
                                    $.post({
                                        url: '/pages/paiements/Panier/ajax/Panier-2-Airtel-ajax.php',
                                        type: 'POST',
                                        data: {
                                            prix: prix,
                                            telephone_airtel: tel,
                                        },
                                        dataType: "json",
                                        success: function(res) {
                                            if (res.retour_validation == "ok") {
                                                popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                                                $("#modal-loading").modal("show");
                                                startTimer(); // Start countdown
                                                startAjaxRequests(res.reference);
                                            } else {
                                                popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                                            }
                                            //RecapitulatifPanier();
                                        }
                                    });
                                }
                            <?php
                            } ?>
                        } else {
                            popup_alert("Votre commande doit etre superieur à <?= $montant_minimum_ht ?> F CFA", "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                        }
                    } else {
                        popup_alert("Vous devez remplir les coordonées de facturation", "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                    }

                });
                $(document).on("change", "#payer_ala_livraison", function() {
                    $('#payer_ala_livraison').prop('disabled', true);

                    payer_livraison();

                    $(".custom-pf").prop("checked", false);
                    $('.act').attr('class', 'act payment-methods__item');
                    $('.des').empty();

                    $.post({
                        url: '/pages/paiements/Panier/ajax/Panier-2-mode_paiement-pf-ajax.php',
                        type: 'POST',
                        data: new FormData($("#modepaiementpf")[0]),
                        processData: false,
                        contentType: false,
                        dataType: "json",
                        success: function(res) {
                            if (res.retour_validation == "ok") {

                            }
                        },
                        error: function() {
                            popup_alert("Erreur de connexion avec le serveur dans la deuxième requête.", "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                        },
                        complete: function() {
                            checkCompletion();
                        }
                    });
                });

                function payer_livraison() {
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
                                listeCart();
                                RecapitulatifPanier();
                            } else {
                                popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                            }
                        },
                        error: function() {
                            popup_alert("Erreur de connexion avec le serveur dans la première requête.", "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                        },
                        complete: function() {
                            checkCompletion();
                        }
                    });
                }

                var requestsPending = 2;

                function checkCompletion() {
                    requestsPending--;

                    if (requestsPending === 0) {
                        $('#payer_ala_livraison').prop('disabled', false);
                        requestsPending = 2;
                    }
                }


                //AJAX SOUMISSION DU FORMULAIRE - COMMENTAIRE LIVRAISON
                $(document).on("click", "#btn-commentaire_livraison", function() {
                    $.post({
                        url: '/pages/paiements/Panier/ajax/Panier-2-livraison-commentaire-ajax.php',
                        type: 'POST',
                        data: new FormData($("#modelivraison_commentaire")[0]),
                        processData: false,
                        contentType: false,
                        dataType: "json",
                        success: function(res) {
                            if (res.retour_validation == "ok") {
                                popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                                location.href = '';
                            } else {
                                popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                            }
                            RecapitulatifPanier();
                        }
                    });
                });

                $(document).on("click", "#modif_adfac", function() {
                    $('#form-informations').css('display', '');
                    $('#info_fac').css('display', 'none');
                });

                $(document).on("click", "#modif-15", function() {
                    $('#btn-commentaire_livraison').css('display', '');
                    $('#ad_liv_modif').css('display', '');

                    $(this).css('display', 'none');
                    $('#ad_liv').css('display', 'none');
                });

                $(document).on("click", "#modif-1", function() {
                    $("#form-livraison-france").css('display', '');
                });

                $(document).on("click", ".custom-radio", function() {
                    $(".custom-pf").prop("checked", false);
                    $(".act").attr("class", "act payment-methods__item");

                    $.post({
                        url: '/pages/paiements/Panier/ajax/Panier-2-mode_paiement-ajax.php',
                        type: 'POST',
                        data: new FormData($("#modepaiement")[0]),
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
                    RecapitulatifPanier();
                });

                $(document).on("click", ".custom-pf", function() {
                    $(".custom-radio").prop("checked", false);
                    // Masque tous les messages de notification
                    document.querySelectorAll(".payment-methods__message").forEach(function(message) {
                        message.style.display = 'none';
                    });
                    $.post({
                        url: '/pages/paiements/Panier/ajax/Panier-2-mode_paiement-ajax.php',
                        type: 'POST',
                        data: new FormData($("#modepaiement")[0]),
                        processData: false,
                        contentType: false,
                        dataType: "json",
                        success: function(res) {
                            if (res.retour_validation == "ok") {

                            } else {

                            }
                        }
                    });

                    var val = $(this).val();

                    $.post({
                        url: '/pages/paiements/Panier/ajax/Panier-2-mode_paiement-pf-ajax.php',
                        type: 'POST',
                        data: new FormData($("#modepaiementpf")[0]),
                        processData: false,
                        contentType: false,
                        dataType: "json",
                        success: function(res) {
                            if (res.retour_validation == "ok") {
                                $('.des').empty()
                                $('.description' + val).append(res.text)
                                popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");

                            } else {
                                popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                                $(".custom-pf").prop("checked", false);
                            }
                            RecapitulatifPanier();
                        }
                    });
                    $('.act').attr('class', 'act payment-methods__item')
                    $('#active_pf' + val).attr('class', 'act payment-methods__item--active')
                });



                $(document).on("change", "input[name='checkout_payment_method']", function() {
                    livraison_france();

                });

                //FUNCTION AJAX - RECAPITULATIF PAIEMENT
                function RecapitulatifPanier(i) {
                    $.post({
                        url: '/pages/paiements/Panier/Panier2-recapitulatif-ajax.php',
                        type: 'POST',
                        data: {
                            datashow: $('#show2').attr('class')
                        },
                        dataType: "html",
                        success: function(res) {
                            $("#panier_recap_prix").html(res);

                        }
                    });

                }
                RecapitulatifPanier(true);


                function livraison_france() {
                    if ($("input[name='checkout_payment_method' ]:checked").val() == '6') {
                        $("#form-livraison-france").css('display', '');
                        $("#liv_france").css('display', '');
                        $("#liv_reste").css('display', 'none');
                        $("#modif-15").css('display', 'none');
                        $("#modif-1").css('display', '');
                    } else {
                        $("#form-livraison-france").css('display', 'none');
                        $("#liv_france").css('display', 'none');
                        $("#liv_reste").css('display', '');
                        $("#modif-15").css('display', '');
                        $("#modif-1").css('display', 'none');
                    }
                }
                livraison_france();

                function show() {
                    element = $('#show2').attr('class');
                    if (element == "show-more") {
                        var $showElements = $('.show');
                        $showElements.css('display', 'none');
                        //$('.show-less').text('[-]');
                        //$(this).attr('class','show-more');
                    } else {

                    }
                }

                show()

                function noshow() {
                    $("#form-livraison-france").css('display', 'none');
                    $("#modif-1").css('display', '');
                }

                <?php if ($_SESSION['id_livraison'] == 6) {
                ?>
                    noshow();
                <?php
                } ?>

                $(document).on("click", ".show-more", function() {
                    var $showElements = $('.show');
                    $showElements.css('display', '');
                    $(this).text('[-]');
                    $(this).attr('class', 'show-less');
                });

                $(document).on("click", ".show-less", function() {
                    var $showElements = $('.show');
                    $showElements.css('display', 'none');
                    $(this).text('[+]');
                    $(this).attr('class', 'show-more');
                });

            });

            /* $(document).ready(function() {
            $(".payment-methods__item").click(function() {

            $(this).find("input[type='radio' ]").prop("checked", true);
            });
            }); */
        </script>
        <style>
            .annuler-message {
                color: red;
                font-weight: bold;
                margin-top: 20px;
                text-align: center;
                display: none;
            }

            .cart__totals-footer tr {
                background-color: transparent !important;
                color: #FF9900;
            }

            /*  @media (max-width: 768px) {
                .payment-methods__item-title {
                    font-size: 12px;
                }

                .payment-methods__item-price>span {
                    font-size: 12px;
                }

                .span-payment {
                    font-size: 12px;
                }
            } */
        </style>
        <?php
        $req_select = $bdd->prepare("SELECT * FROM membres_adresse_liv_france WHERE id_membre=?");
        $req_select->execute(array($id_oo));
        $ligne_select2 = $req_select->fetch();
        $req_select->closeCursor();

        $req_select = $bdd->prepare("SELECT * FROM membres WHERE pseudo=?");
        $req_select->execute(array($user));
        $ligne_membre = $req_select->fetch();
        $req_select->closeCursor();

        $req_select = $bdd->prepare("SELECT * FROM membres_panier WHERE pseudo=?");
        $req_select->execute(array($user));
        $ligne_select = $req_select->fetch();
        $req_select->closeCursor();
        $id_panier = $ligne_select['id'];
        $id_livraison = $ligne_select['id_livraison'];
        $commentaire_livraison_sql = $ligne_select['commentaire_livraison'];


        if ($ligne_membre['same_adresse'] == "oui") {
            $adressefac = $ligne_membre['Adresse_facturation'];
            $telephonefac = $ligne_membre['Telephone_portable'];
            $villefac = $ligne_membre['Ville_facturation'];
            $cpfac = $ligne_membre['Code_postal_facturation'];
            $paysfac = $ligne_membre['Pays_facturation'];
            $complementfac = $ligne_membre['Complement_d_adresse_facturation'];
            $Votre_quartier_fac = $ligne_membre['Votre_quartier_facturation'];
            $Decrivez_un_peut_plus_chez_vous_fac = $ligne_membre['Decrivez_un_peut_plus_chez_vous_facturation'];

            $adresseliv = $ligne_membre['adresse'];
            $villeliv = $ligne_membre['ville'];
            $telephoneliv = $ligne_membre['Telephone_portable'];
            $cpliv = $ligne_membre['cp'];
            $paysliv = $ligne_membre['Pays'];
            $complementliv = $ligne_membre['Complement_d_adresse'];
            $Votre_quartier_liv = $ligne_membre['Votre_quartier'];
            $Decrivez_un_peut_plus_chez_vous_liv = $ligne_membre['Decrivez_un_peut_plus_chez_vous'];
        } else {
            $adressefac = $ligne_membre['adresse'];
            $villefac = $ligne_membre['ville'];
            $telephonefac = $ligne_membre['Telephone_portable'];
            $cpfac = $ligne_membre['cp'];
            $paysfac = $ligne_membre['Pays'];
            $complementfac = $ligne_membre['Complement_d_adresse'];
            $Votre_quartier_fac = $ligne_membre['Votre_quartier'];
            $Decrivez_un_peut_plus_chez_vous_fac = $ligne_membre['Decrivez_un_peut_plus_chez_vous'];

            $adresseliv = $ligne_membre['adresse'];
            $villeliv = $ligne_membre['ville'];
            $telephoneliv = $ligne_membre['Telephone_portable'];
            $cpliv = $ligne_membre['cp'];
            $paysliv = $ligne_membre['Pays'];
            $complementliv = $ligne_membre['Complement_d_adresse'];
            $Votre_quartier_liv = $ligne_membre['Votre_quartier'];
            $Decrivez_un_peut_plus_chez_vous_liv = $ligne_membre['Decrivez_un_peut_plus_chez_vous'];
        }


        if (!empty($villefac) && !empty($paysfac)) {
            $donneescomplet = true;
        } else {
            $donneescomplet = false;
        }


        $id_paiement_sql = $ligne_select['id_paiement'];

        $req_select = $bdd->prepare("SELECT * FROM membres_panier_details WHERE numero_panier=? AND (action_module_service_produit like 'Forfait' OR action_module_service_produit like 'Code promotion')");
        $req_select->execute(array($ligne_select['numero_panier']));
        $panier_details = $req_select->fetchAll(PDO::FETCH_ASSOC);
        $req_select->closeCursor();

        ?>

        <?php
        ///////////////////////////////SELECT
        $req_selectpa = $bdd->prepare("SELECT * FROM membres_panier WHERE id_membre=?");
        $req_selectpa->execute(array($id_oo));
        $ligne_selectpa = $req_selectpa->fetch();
        $req_selectpa->closeCursor();

        if ($ligne_selectpa['Titre_panier'] != "Abonnement") {
        ?>


            <div>
                <a href="/Recapitulatif-Panier" class="footer-newsletter__form-button btn btn-outline-dark mb-3"
                    style="border-radius: 7px;">Etape précédente</a>

            </div>
            <!--a class="footer-newsletter__form-button btn btn-light" href="/Passage-de-commande" style="margin-bottom: 20px;">Constitution du panier</a>
	    <a class="footer-newsletter__form-button btn btn-light" href="/Passage-de-colis" style="margin-bottom: 20px;" >Constitution colis</a-->


        <?php
        }
        ?>

        <style>
            .loader {
                border: 8px solid #f3f3f3;
                border-top: 8px solid #3498db;
                border-radius: 50%;
                width: 50px;
                height: 50px;
                animation: spin 1s linear infinite;
            }

            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }

            .loading-text {
                margin-top: 15px;
                font-family: Arial, sans-serif;
                font-size: 18px;
                color: #555;
            }

            .timer-text {
                margin-top: 10px;
                font-size: 16px;
                color: #333;
                text-align: center;
            }

            .error-message {
                color: red;
                font-weight: bold;
                margin-top: 20px;
                text-align: center;
                display: none;
            }

            /* .error-message2 {
                margin-top: 20px;
                text-align: center;
                display: none;
            } */

            @media (max-width: 768px) {
                #modal-loading .modal-content {
                    font-size: 14px;
                }

                #modal-loading .modal-title {
                    font-size: 18px;
                }

                #modal-loading h5,
                #modal-loading h6 {
                    font-size: 16px;
                }

                #modal-loading p,
                #modal-loading li {
                    font-size: 14px;
                }

            }

            /* body {
        overflow: hidden;
    } */

            .payment-methods__item-header {
                display: flex;

                align-items: center;
            }

            .payment-methods__item-price {
                margin-left: auto;
                text-align: right;
            }

            .payment-methods__item-details {
                text-align: right;

            }
        </style>
        <div class="checkout block">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3" style="padding-left: 0px; background: #fff3cd; padding-left: 15px;">

                        <h2 style="font-size: 20px; color: #284170;" class="title-borderb">La commande <span id="show2" class="show-more" style="color: #4f7baf; cursor:pointer; font-weight: 1 !important; font-size: 12px;">voir le détails[+]</span></h2>
                        <div id="panier_recap_prix" class=" table cart__totals"></div>
                        <div>

                            <div>



                                <?php
                                ///////////////////////////////SELECT
                                $req_selectpa = $bdd->prepare("SELECT * FROM membres_panier WHERE id_membre=?");
                                $req_selectpa->execute(array($id_oo));
                                $ligne_selectpa = $req_selectpa->fetch();
                                $req_selectpa->closeCursor();

                                if ($ligne_selectpa['Titre_panier'] != "Abonnement" && $ligne_selectpa['Titre_panier'] != "Liste") {
                                ?>



                                    <div class="payment-methods">
                                        <h2 style="font-size: 20px; color: #284170;" class="title-borderb">Informations de livraison</h2>
                                        <form method="POST" action="#" class="pt-3">
                                            <?php

                                            $req_selectLivraison = $bdd->prepare("SELECT COUNT(*) AS total FROM membres_informations_livraison WHERE id_membre = ?");
                                            $req_selectLivraison->execute(array($id_oo));
                                            $result = $req_selectLivraison->fetch(PDO::FETCH_ASSOC);
                                            $hasAddress = ($result['total'] > 0);
                                            $req_selectLivraison->closeCursor();

                                            if (!$hasAddress):
                                            ?>

                                                <div id="ad_liv" style="width: 100%; border: #ffe79c 1px solid">
                                                    <div id="liv_reste" style="padding-left: 5px;">
                                                        <?php
                                                        if ($paysliv == "Gabon") {
                                                            echo $ligne_membre['nom'] . " " . $ligne_membre['prenom']; ?><br>
                                                            <?= $telephoneliv ?><br>
                                                            <?= $Votre_quartier_liv ?><br>
                                                            <?= $villeliv ?><br>
                                                            <?= $paysliv ?><br>
                                                            <?= $Decrivez_un_peut_plus_chez_vous_liv ?>
                                                        <?php
                                                            $_SESSION['address_liv'] = $ligne_membre['nom'] . " " . $ligne_membre['prenom'] . " <br> "
                                                                . $telephoneliv . " <br> " . $Votre_quartier_liv . " <br> "
                                                                . $villeliv . " <br> " . $paysliv . " <br> "
                                                                . $Decrivez_un_peut_plus_chez_vous_liv;
                                                        } else {
                                                            echo $ligne_membre['nom'] . " " . $ligne_membre['prenom']; ?><br>
                                                            <?= $telephoneliv ?><br>
                                                            <?= $adresseliv ?><br>
                                                            <?= $cpliv ?> <?= $villeliv ?><br>
                                                            <?= $paysliv ?>
                                                            <?php
                                                            $_SESSION['address_liv'] = $ligne_membre['nom'] . " " . $ligne_membre['prenom'] . " <br> "
                                                                . $telephoneliv . " <br> " . $adresseliv . " <br> "
                                                                . $cpliv . " " . $villeliv . " <br> " . $paysliv;
                                                            if (!empty($complementliv)) {
                                                                $_SESSION['address_liv'] .= " <br> " . $complementliv;
                                                            ?>
                                                                <br>
                                                                <?= $complementliv ?>
                                                        <?php }
                                                        }
                                                        ?>
                                                        <br>
                                                    </div>
                                                    <div id="liv_france" style="padding-left: 5px; display:none">
                                                        <?php
                                                        echo $ligne_select2['nom_liv_france'] . " " . $ligne_select2['prenom_liv_france']; ?><br>
                                                        <?= $ligne_select2['telephone_liv_france']; ?><br>
                                                        <?= $ligne_select2['adresse_liv_france']; ?><br>
                                                        <?= $ligne_select2['cp_liv_france']; ?> <?= $ligne_select2['ville_liv_france']; ?><br>
                                                        France
                                                        <?php if (!empty($ligne_select2['complement_adresse_liv_france'])) { ?>
                                                            <br>
                                                            <?= $ligne_select2['complement_adresse_liv_france']; ?>
                                                        <?php } ?>
                                                        <br>
                                                    </div>
                                                </div>
                                            <?php else:

                                                $req_selectPref = $bdd->prepare("SELECT * FROM membres_informations_livraison WHERE id_membre = ? AND prefere = 'oui' LIMIT 1");
                                                $req_selectPref->execute(array($id_oo));
                                                $ligne_pref = $req_selectPref->fetch(PDO::FETCH_ASSOC);
                                                $req_selectPref->closeCursor();


                                                if (!$ligne_pref) {
                                                    $req_selectPref = $bdd->prepare("SELECT * FROM membres_informations_livraison WHERE id_membre = ? ORDER BY id DESC LIMIT 1");
                                                    $req_selectPref->execute(array($id_oo));
                                                    $ligne_pref = $req_selectPref->fetch(PDO::FETCH_ASSOC);
                                                    $req_selectPref->closeCursor();
                                                }
                                            ?>

                                                <div id="ad_liv" style="width: 100%; border: #ffe79c 1px solid">
                                                    <div id="liv_reste" style="padding-left: 5px;">
                                                        <?php
                                                        echo $ligne_pref['nom'] . " " . $ligne_pref['prenom']; ?><br>
                                                        <?= $ligne_pref['portable']; ?><br>
                                                        <?= $ligne_pref['adresse']; ?><br>
                                                        <?= $ligne_pref['ville']; ?><br>
                                                        <?= $ligne_pref['pays']; ?><br>
                                                        <?php
                                                        if (!empty($ligne_pref['Complement'])) {
                                                            echo $ligne_pref['Complement'] . "<br>";
                                                        }
                                                        ?>
                                                        <br>
                                                    </div>
                                                </div>
                                            <?php endif; ?>


                                            <textarea id="ad_liv_modif" name="commentaire_livraison" class="form-control" style="width: 100%; height: 80px; display:none" placeholder="Adresse, compléments d'informations"><?php echo "$commentaire_livraison_sql"; ?></textarea>
                                            <!--  <a href="/Gestion-de-votre-compte.html" style='margin-left: 0px; background-color: transparent; border: none; color: #4f7baf; padding: 5px 0; text-decoration: underline; font-size: 12px; cursor: pointer;'>Modifier</a> -->
                                            <a href="#" id="btnModifier" style="margin-left: 0px; background-color: transparent; border: none; color: #4f7baf; padding: 5px 0; text-decoration: underline; font-size: 12px; cursor: pointer;">Modifier</a>
                                            <a id='modif-1' style='margin-left: 0px; background-color: transparent; border: none; color: #4f7baf; padding: 5px 0; text-decoration: underline; font-size: 12px; cursor: pointer; display:none'>Modifier adresse en France</a>
                                            <a id='btn-commentaire_livraison' style='margin-left: 0px; background-color: transparent; border: none; color: #4f7baf; padding: 5px 10px; text-decoration: underline; font-size: 12px; cursor: pointer; display:none'>Ok</a>
                                        </form>
                                    </div>

                                    <div id="modalContainer"></div>
                                <?php
                                }
                                if ($donneescomplet) {
                                ?>

                                    <div id="info_fac" class="payment-methods">
                                        <h2 style="font-size: 20px; color: #284170 !important;" class="title-borderb">Informations de facturation</h2>
                                        <div style="width: 100%; border: #ffe79c 1px solid">
                                            <div style="padding-left: 5px;"><?php
                                                                            if ($paysfac == "Gabon") {
                                                                                echo $ligne_membre['nom'] . " " . $ligne_membre['prenom'] ?><br>
                                                    <?= $telephonefac ?><br>
                                                    <?= $Votre_quartier_fac ?><br>
                                                    <?= $villefac ?><br>
                                                    <?= $paysfac ?><br>
                                                    <?= $Decrivez_un_peut_plus_chez_vous_fac ?>
                                                <?php
                                                                                $_SESSION['address_fac'] = $ligne_membre['nom'] . " " . $ligne_membre['prenom'] . " <br> " . $telephonefac . " <br> " . $Votre_quartier_fac . " <br> " . $villefac . " <br> " . $paysfac . " <br> " . $Decrivez_un_peut_plus_chez_vous_fac;
                                                                            } else {
                                                                                echo $ligne_membre['nom'] . " " . $ligne_membre['prenom'] ?><br>
                                                    <?= $telephonefac ?><br>
                                                    <?= $adressefac ?><br>
                                                    <?= $cpfac ?> <?= $villefac ?><br>
                                                    <?= $paysfac ?>
                                                    <?php
                                                                                $_SESSION['address_fac'] = $ligne_membre['nom'] . " " . $ligne_membre['prenom'] . " <br> " . $telephonefac . " <br> " . $adressefac . " <br> " . $cpfac . " " . $villefac . " <br> " . $paysfac;
                                                                                if (!empty($complementfac)) {
                                                                                    $_SESSION['address_fac'] .= " <br>" . $complementfac;
                                                    ?>
                                                        <br>
                                                        <?= $complementfac ?>
                                                <?php }
                                                                            }

                                                ?>
                                            </div>
                                        </div>
                                        <a id='modif_adfac' style='margin-left: 0px; background-color: transparent; border: none; color: #4f7baf; padding: 5px 0; text-decoration: underline; font-size: 12px; cursor: pointer;'>Modifier l'adresse de facturation</a>

                                    </div>





                                <?php
                                }
                                ?>
                                <div id="form-informations" <?php if ($donneescomplet) {
                                                                echo "style='display: none'";
                                                            } ?>>
                                    <h3 class="card-title title-borderb" style="font-size: 18px">Modifications de vos informations</h3>
                                    <form id='form-informations_mise_a_jour_panier' method='post' action='#'>
                                        <!--                                <div class="form-group">-->
                                        <!--                                    <label for="checkout-address">*Pays</label>-->
                                        <!--                                    <input class="form-control" type="text" id="pays" name="pays" placeholder="--><?php //echo "Pays de facturation"; 
                                                                                                                                                                ?><!--" value='--><?php //echo "$paysfac"; 
                                                                                                                                                                                    ?><!--' autocomplete="off" style='--><?php //echo "$coloorppasse"; 
                                                                                                                                                                                                                            ?><!--' />-->
                                        <!--                                </div>-->

                                        <div class="form-group">
                                            <label class="control-label" for="Pays"><?php echo "Pays"; ?>*</label>
                                            <select class="form-control" id="Pays" name="pays" placeholder="*Pays"
                                                style='<?php echo "$coloorc"; ?>'>
                                                <?php
                                                $req_pays = $bdd->query("SELECT * FROM pays ORDER BY pays ASC");
                                                while ($pays = $req_pays->fetch()) { ?>

                                                    <option value="<?= $pays["pays"] ?>" <?= $paysfac == $pays["pays"] ? 'selected' : '' ?>> <?= $pays["pays"] ?> </option>

                                                <?php }
                                                $req_pays->closeCursor(); ?>
                                            </select>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="checkout-first-name">*Nom</label>
                                                <input type='text' class='form-control' id='nom' name='nom' value='<?php echo "$nom_oo"; ?>' placeholder='Nom' required autocomplete="off" style='width: 100%;'>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="checkout-last-name">*Prénom</label>
                                                <input type='text' class='form-control' id='prenom' name='prenom' value='<?php echo "$prenom_oo"; ?>' placeholder='Prénom' autocomplete="off" required style='width: 100%;'>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="checkout-mail">*Mail</label>
                                            <input type='text' class='form-control' id='mail' name='mail' value='<?php echo "$mail_oo"; ?>' placeholder='Mail' autocomplete="off" style='width: 100%;' disabled>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="checkout-company-name">*Portable</label>
                                                <input type='text' class='form-control' id='Telephone_portable' name='Telephone_portable' value='<?php echo "$Telephone_portable_oo"; ?>' placeholder='Téléphone' autocomplete="off" style='width: 100%;'>
                                            </div>
                                            <div class="form-group col-md-6 france" id="tel_fixe_france">
                                                <label for="checkout-fixe">Fixe</label>
                                                <input class="form-control" type="text" id="Telephone" name="Telephone" value='<?php echo "$Telephone_oo"; ?>' placeholder="<?php echo "Téléphone fixe"; ?>" autocomplete="off" style='<?php echo "$coloorppasse"; ?>' />
                                            </div>
                                            <div class="form-group col-md-6 gabon" id="tel_mobile_gabon">
                                                <label for="checkout-phone-gabon">Portable</label>
                                                <input class="form-control" type="text" id="Telephone" name="Telephone" value='<?php echo "$Telephone_oo"; ?>' placeholder="<?php echo "Téléphone portable"; ?>" autocomplete="off" style='<?php echo "$coloorppasse"; ?>' />
                                            </div>
                                        </div>
                                        <div class="form-group france">
                                            <label for="checkout-address">*Adresse</label>
                                            <input class="form-control" type="text" id="checkout-address" name="adresse" placeholder="<?php echo "Adresse de facturation (Et n°rue)"; ?>" value='<?php echo "$adressefac"; ?>' autocomplete="off" style='<?php echo "$coloorppasse"; ?>' />
                                        </div>


                                        <div class="form-row">
                                            <div class="form-group col-md-6 france">
                                                <label for="checkout-cp">*Code postal</label>
                                                <input type='text' class='form-control' id='cp' name='cp' value='<?php echo "$cpfac"; ?>' placeholder='Code postale' required maxlength="5" pattern="[0-9]{1,5}" style='width: 100%;'>
                                            </div>

                                            <div class="form-group col-md-6 gabon">
                                                <label for="Votre_quartier">*Votre quartier</label>
                                                <input type='text' class='form-control' id='Votre_quartier' name='Votre_quartier' value='<?php echo "$Votre_quartier_fac"; ?>' placeholder='Nom du quartier' required style='width: 100%;'>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="checkout-city">*Ville</label>
                                                <input type='text' class='form-control' id='ville' name='ville' value='<?php echo "$villefac"; ?>' placeholder='Ville' required style='width: 100%;'>
                                            </div>

                                        </div>
                                        <div class="form-group france">
                                            <label for="checkout-address">Complément d'adresse</label>
                                            <input class="form-control" type="text" id="complement_adresse" name="complement_adresse" placeholder="<?php echo "Complément d'adresse"; ?>" value='<?php echo "$complementfac"; ?>' autocomplete="off" style='<?php echo "$coloorppasse"; ?>' />
                                        </div>

                                        <div class="form-group gabon">
                                            <label for="checkout-address">Décrivez un peut plus chez vous</label>
                                            <input class="form-control" type="text" id="Decrivez_un_peut_plus_chez_vous" name="Decrivez_un_peut_plus_chez_vous" placeholder="<?php echo ""; ?>" value='<?php echo "$Decrivez_un_peut_plus_chez_vous_fac"; ?>' autocomplete="off" style='<?php echo "$coloorppasse"; ?>' />
                                        </div>

                                        <div class="col-sm-12 col-xs-12 text-center" style='margin-bottom: 15px; text-align: left;'>
                                            <button id='button-informations_mise_a_jour_panier' class='footer-newsletter__form-button btn btn-primary' style='text-transform : uppercase;' onclick="return false;"> ENREGISTRER </button>
                                        </div>

                                    </form>
                                </div>

                                <div id="form-livraison-france" style='display: none;'>
                                    <h2 class="title-borderb" style="font-size: 20px;">Adresse livraison en France</h2>
                                    <form id='form-livrason_france' method='post' action='#'>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="checkout-first-name">*Nom</label>
                                                <input type='text' class='form-control' id='nom_liv_france' name='nom_liv_france' value='<?php echo $ligne_select2['nom_liv_france']; ?>' placeholder='Nom' required autocomplete="off" style='width: 100%;'>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="checkout-last-name">*Prénom</label>
                                                <input type='text' class='form-control' id='prenom_liv_france' name='prenom_liv_france' value='<?php echo $ligne_select2['prenom_liv_france']; ?>' placeholder='Prénom' autocomplete="off" required style='width: 100%;'>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="checkout-company-name">*Portable</label>
                                                <input type='text' class='form-control' id='Telephone_portable' name='telephone_liv_france' value='<?php echo $ligne_select2['telephone_liv_france']; ?>' placeholder='Téléphone' autocomplete="off" style='width: 100%;'>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="checkout-address">*Adresse</label>
                                            <input class="form-control" type="text" id="adresse" name="adresse_liv_france" placeholder="<?php echo "Adresse"; ?>" value='<?php echo $ligne_select2['adresse_liv_france']; ?>' autocomplete="off" style='<?php echo "$coloorppasse"; ?>' />
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="checkout-city">*Ville</label>
                                                <input type='text' class='form-control' id='ville' name='ville_liv_france' value='<?php echo $ligne_select2['ville_liv_france']; ?>' placeholder='Ville' required style='width: 100%;'>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="checkout-state">*Code postal</label>
                                                <input type='text' class='form-control' id='cp' name='cp_liv_france' value='<?php echo $ligne_select2['cp_liv_france']; ?>' placeholder='Code postale' required maxlength="5" pattern="[0-9]{1,5}" style='width: 100%;'>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="checkout-address">Complément d'adresse</label>
                                            <input class="form-control" type="text" id="complement_adresse" name="complement_adresse_liv_france" placeholder="<?php echo "Complément d'adresse"; ?>" value='<?php echo  $ligne_select2['complement_adresse_liv_france']; ?>' autocomplete="off" style='<?php echo "$coloorppasse"; ?>' />
                                        </div>

                                        <div class="col-sm-12 col-xs-12 text-center" style='margin-bottom: 15px; text-align: left;'>
                                            <button id='button-informations_livraison_france' class='footer-newsletter__form-button btn btn-primary' style='text-transform : uppercase;' onclick="return false;"> ENREGISTRER </button>
                                        </div>

                                    </form>
                                </div>
                            </div>

                            <div style="margin: 0 auto;">
                                <img src="images/Fotolia-Women.png" alt="Description de l'image" width="250" height="auto">
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-9 mt-4 mt-lg-0">
                        <?php if ($ligne_selectpa['Titre_panier'] != "Abonnement" && $ligne_selectpa['Titre_panier'] != "Liste") { ?>
                            <div class="payment-methods">
                                <h2 style="font-size: 20px; color: #284170; " class="title-borderb">Mode de livraison</h2>
                                <form method="POST" id="modelivraison" class="pt-3" action="#">
                                    <ul class="payment-methods__list">
                                        <div class='row'>
                                            <?php
                                            try {
                                                $sql = "SELECT * FROM configurations_livraisons_gabon";
                                                $stmt = $bdd->prepare($sql);
                                                $stmt->execute();

                                                $rowCount = 0;

                                                $librevillePrinted = false;
                                                $portGentilPrinted = false;
                                                $resteGabonPrinted = false;
                                                $francePrinted = false;

                                                while ($row = $stmt->fetch()) {
                                                    $idlivraison = $row['id'];
                                                    $nom_livraison = $row['nom_livraison'];
                                                    $ville_livraison = $row['ville_livraison'];
                                                    $commentaire_livraison = $row['commentaire_livraison'];

                                                    if ($Abonnement_id == 1) {
                                                        $prix_livraison = $row['prix_1'] == "Gratuit" ? "<span style='color: #4f7baf;'>Gratuit</span>" : "<span style='color: #4f7baf;'>" . number_format($row['prix_1'], 0, '.', ' ') . " FCFA</span>";
                                                    } elseif ($Abonnement_id == 2) {
                                                        $prix_livraison = $row['prix_2'] == "Gratuit" ? "<span style='color: #4f7baf;'>Gratuit</span>" : "<span style='color: #4f7baf;'>" . number_format($row['prix_2'], 0, '.', ' ') . " FCFA</span>";
                                                    } elseif ($Abonnement_id == 3) {
                                                        $prix_livraison = $row['prix_3'] == "Gratuit" ? "<span style='color: #4f7baf;'>Gratuit</span>" : "<span style='color: #4f7baf;'>" . number_format($row['prix_3'], 0, '.', ' ') . " FCFA</span>";
                                                    }

                                                    if (!$librevillePrinted && ($nom_livraison == "Point de retrait LBV" || $nom_livraison == "Livraison à dom LBV")) {
                                                        echo "<div class='col-md-12'><h3 style='font-size: 18px; color: #FF9900; margin-top: 20px;'>Libreville</h3></div>";
                                                        $librevillePrinted = true;
                                                    }
                                                    if (!$portGentilPrinted && ($nom_livraison == "Livraison relais POG FCV MDA" || $nom_livraison == "Livraison Dom POG FCV MDA")) {
                                                        echo "<div class='col-md-12'><h3 style='font-size: 18px; color: #FF9900; margin-top: 20px;'>Port-Gentil/Franceville/Moanda</h3></div>";
                                                        $portGentilPrinted = true;
                                                    }
                                                    if (!$resteGabonPrinted && $nom_livraison == "Livraison reste du Gabon") {
                                                        echo "<div class='col-md-12'><h3 style='font-size: 18px; color: #FF9900; margin-top: 20px;'>Reste du Gabon</h3></div>";
                                                        $resteGabonPrinted = true;
                                                    }
                                                    if (!$francePrinted && $nom_livraison == "Livraison en France") {
                                                        echo "<div class='col-md-12'><h3 style='font-size: 18px; color: #FF9900; margin-top: 20px;'>En France</h3></div>";
                                                        $francePrinted = true;
                                                    }

                                                    $colClass = "col-md-6";

                                                    echo "<div class='$colClass'>";
                                                    echo "<li class='payment-methods__item $active'>";

                                                    echo "<label class='payment-methods__item-header radio_livraison' data-id='" . $idlivraison . "' style='display: block;text-align: right;'>";
                                                    echo "<span class='payment-methods__item-radio input-radio' style='display: flex;'>";
                                                    echo "<span class='input-radio__body'>";
                                                    if ($_SESSION['id_livraison'] == $idlivraison) {
                                                        echo "<input checked class='input-radio__input radio_livraison' data-id='" . $idlivraison . "' name='checkout_payment_method' type='radio' value='" . $idlivraison . "'>";
                                                    } else {
                                                        echo "<input class='input-radio__input radio_livraison' data-id='" . $idlivraison . "' name='checkout_payment_method' type='radio' value='" . $idlivraison . "'>";
                                                    }
                                                    echo "<span class='input-radio__circle'></span>";
                                                    echo "</span>";

                                                    echo "<div class='payment-methods__item-title' style='margin-left: 10px;'>" . $nom_livraison . "</div>";
                                                    echo "</span>";
                                                    echo "" . $prix_livraison . "";
                                                    echo "</label>";

                                                    echo "<div class='payment-methods__item-container'>";
                                                    echo "<div class='payment-methods__item-description'>";
                                                    if (!empty($ville_livraison)) {
                                                        echo "Ville : $ville_livraison <br />";
                                                    }
                                                    echo "$commentaire_livraison";
                                                    echo "</div>";
                                                    echo "</div>";
                                                    echo "</li>";
                                                    echo "</div>";

                                                    $rowCount++;
                                                }
                                            } catch (PDOException $e) {
                                                echo 'Erreur de base de données : ';
                                            }
                                            ?>
                                        </div>
                                    </ul>
                                </form>



                            </div>
                        <?php } ?>



                        <!-- <a class="footer-newsletter__form-button btn btn-primary" href="/Paiement" style="margin-bottom: 20px;">Récapitulatif de la commande</a> -->

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                // Élément d'entrée pour Airtel
                                var airtelInput = document.getElementById('inputAirtel');
                                // Sélectionne tous les éléments <li> dans la liste des méthodes de paiement
                                var liElements = document.querySelectorAll(".payment-methods__item");

                                liElements.forEach(function(li) {
                                    li.addEventListener('click', function() {
                                        // Trouve le bouton radio à l'intérieur du <li> et l'active
                                        var radioButton = li.querySelector("input[name='checkout_payment_method2']");
                                        if (radioButton) {
                                            radioButton.checked = true;
                                            // Déclenche l'événement 'change' manuellement sur le bouton radio
                                            radioButton.dispatchEvent(new Event('change'));
                                        }
                                    });
                                });

                                // Événement 'change' pour afficher/masquer inputAirtel et les messages
                                document.querySelectorAll("input[name='checkout_payment_method2']").forEach(function(radio) {
                                    radio.addEventListener('change', function() {


                                        // Masque tous les messages de notification
                                        document.querySelectorAll(".payment-methods__message").forEach(function(message) {
                                            message.style.display = 'none';
                                        });

                                        // Contrôle l'affichage de 'inputAirtel' en fonction de la valeur sélectionnée
                                        if (this.value == 4) {
                                            airtelInput.style.display = 'block';
                                        } else {
                                            airtelInput.style.display = 'none';
                                        }

                                        // Affiche le message correspondant au bouton radio sélectionné
                                        const messageId = this.getAttribute("data-id");
                                        const message = document.getElementById("message_" + messageId);
                                        if (message) {
                                            message.style.display = "block";
                                        }
                                    });
                                });

                                document.querySelectorAll("input[name='checkout_payment_method']").forEach(function(radio) {
                                    radio.addEventListener('change', function() {


                                        // Masque tous les messages de notification
                                        document.querySelectorAll(".payment-methods__message_liv").forEach(function(message) {
                                            message.style.display = 'none';
                                        });

                                        // Affiche le message correspondant au bouton radio sélectionné
                                        const messageId = this.getAttribute("data-id");
                                        const message = document.getElementById("message_liv_" + messageId);
                                        if (message) {
                                            message.style.display = "block";
                                        }
                                    });
                                });


                                // Affiche 'inputAirtel' si le bouton radio avec la valeur 4 est déjà sélectionné au chargement de la page
                                if (document.querySelector("input[name='checkout_payment_method2'][value='4']").checked) {
                                    airtelInput.style.display = 'block';
                                }

                                // Affiche le message correspondant au bouton radio déjà sélectionné au chargement de la page
                                const selectedRadio = document.querySelector("input[name='checkout_payment_method2']:checked");
                                if (selectedRadio) {
                                    const messageId = selectedRadio.getAttribute("data-id");
                                    const message = document.getElementById("message_" + messageId);
                                    if (message) {
                                        message.style.display = "block";
                                    }
                                }
                            });
                        </script>

                        <!--  -->





                        <div class="payment-methods">

                            <h2 style="font-size: 20px; color: #284170;" class="title-borderb">Mode de paiement comptant</h2>

                            <form method="POST" id="modepaiement" action="#">
                                <ul class="payment-methods__list">
                                    <div class='row'>

                                        <?php

                                        ///////////////////////////////SELECT ABONNEMENT
                                        $req_selecta = $bdd->prepare("SELECT * FROM configurations_modes_paiement_conditions WHERE id=?");
                                        $req_selecta->execute(array("1"));
                                        $ligne_selecta = $req_selecta->fetch();
                                        $req_selecta->closeCursor();

                                        $sql = "SELECT * FROM configurations_modes_paiement";
                                        $stmt = $bdd->prepare($sql);
                                        $stmt->execute();
                                        while ($row = $stmt->fetch()) {
                                            $idModePaiement = $row['id'];
                                            $nomModePaiement = $row['nom_mode'];
                                            $informations_mode = $row['informations_mode'];

                                            /*  var_dump($row); */

                                            echo "<div class='col-md-6'>";
                                            echo "<li class='payment-methods__item $active'>";
                                            echo "<label class='payment-methods__item-header' style='display: block;'>";

                                            echo "<span class='payment-methods__item-radio input-radio'>";
                                            echo "<span class='input-radio__body'>";


                                            echo "<input class='input-radio__input custom-radio' name='checkout_payment_method2' type='radio' value='" . $idModePaiement . "' id='method_$idModePaiement'  data-id='$idModePaiement' ";

                                            if ($_SESSION['id_paiement'] == $idModePaiement) {
                                                echo "checked";
                                            }

                                            echo ">";

                                            echo "<span class='input-radio__circle'></span>";
                                            echo "</span>";
                                            echo "</span>";


                                            echo "<span class='payment-methods__item-title'>" . $nomModePaiement . "</span>";

                                            if ($idModePaiement != 4) {
                                                echo "<div class='payment-methods__message' id='message_$idModePaiement' style='margin-top: 10px; color: #555; display: none; font-weight: 100;'>";
                                                echo "$informations_mode";
                                                echo "</div>";
                                            }
                                            // Récupérer le dernier numéro enregistré pour ce membre
                                            $req_tel = $bdd->prepare("SELECT telephone FROM membres_telephone_artiel WHERE id_membre = ? ORDER BY created_at DESC LIMIT 1");
                                            $req_tel->execute(array($id_oo));
                                            $lastTel = $req_tel->fetch();
                                            $req_tel->closeCursor();

                                            // Si un numéro existe déjà, on l'utilise, sinon on utilise le numéro par défaut
                                            if ($lastTel && !empty($lastTel['telephone'])) {
                                                $Airtel_number = $lastTel['telephone'];
                                            } else {
                                                if (strpos($Telephone_portable_oo, '077') === 0 || strpos($Telephone_portable_oo, '074') === 0) {
                                                    $Airtel_number = $Telephone_portable_oo;
                                                } else {
                                                    $Airtel_number = "";
                                                }
                                            }
                                            if ($idModePaiement == 4) {
                                                echo "<div id='inputAirtel' class='payment-methods__message' style='display: none; margin-top: 10px;' type>";
                                                echo "<label for='airtelNumber' style='display: block; margin-top: 10px; font-weight: 100;'>Payer avec ce numéro de téléphone:</label>";
                                                echo "<input type='text' maxlength='9' minlength='9' pattern='[0-9]{9}' value='$Airtel_number' id='airtelNumber' name='airtelNumber' class='form-control' placeholder='numéro de téléphone portable' style='display: block; width: 100%; margin-top: 5px;'>";
                                                echo "<div id='invalidPhoneNumberAlert' style='display: none; color: red; margin-top: 10px;'>Veuillez saisir le numéro au format 077XXXXXX ou 074XXXXXX sans mettre d'espace</div>";
                                                if ($_SESSION['total_TTC'] > 500000) {
                                                    echo "<label style='color: red; font-weight: bold; margin-top: 10px;'>le montant par commande ne peut dépasser 500 000 Fcfa</label>";
                                                }
                                                echo "</div>";
                                            }



                                            echo "</label>";
                                            echo "<div class='payment-methods__item-container'>";
                                            echo "<div class='payment-methods__item-description text-muted'>";
                                            echo "$informations_mode";
                                            echo "</div>";
                                            echo "</div>";
                                            echo "</li>";
                                            echo "</div>";
                                        }

                                        ?>
                                        </li>
                                    </div>
                                </ul>
                            </form>
                        </div>
                        <?php if ($ligne_selectpa['Titre_panier'] != "Abonnement" && $ligne_selectpa['Titre_panier'] != "Liste") {

                            $sql = "SELECT * FROM membres WHERE pseudo=?";
                            $stmt = $bdd->prepare($sql);
                            $stmt->execute(array($user));
                            $ligne_select = $stmt->fetch();
                            $stmt->closeCursor();
                            $abonnement_id = $ligne_select['Abonnement_id'];

                        ?>
                            <div class="payment-methods">

                                <?php if ($abonnement_id == 3) { ?>
                                    <h2 style="font-size: 20px; color: #284170;" class="title-borderb">Paiement en plusieurs fois</h2>
                                <?php } else { ?>
                                    <h2 style="font-size: 20px; color: #284170;" class="title-borderb">Paiement en plusieurs fois <span style="color: #4f7baf;">(Membres PREMIUM)</span></h2>
                                <?php } ?>

                                <form method="POST" id="modepaiementpf" action="#">
                                    <ul class="payment-methods__list">
                                        <div class="row">
                                            <?php
                                            $sql = "SELECT * FROM configurations_modes_paiement_plusieurs_fois";
                                            $stmt2 = $bdd->prepare($sql);
                                            $stmt2->execute();

                                            while ($row = $stmt2->fetch()) {
                                                $idModePaiement2 = $row['id'];
                                                $nomModePaiement2 = $row['nom'];

                                                $active = ($_SESSION['paiement_pf'] == $idModePaiement2) ? "payment-methods__item--active" : "";

                                                echo "<div class='col-md-6'>";
                                                echo "<li id='active_pf$idModePaiement2' class='act payment-methods__item $active'>";


                                                echo "<label class='payment-methods__item-header' style='display: flex; flex-direction: column; align-items: flex-start;'>";


                                                echo "<div style='display: flex; align-items: center; width: 100%;'>";
                                                echo "<span class='payment-methods__item-radio input-radio' style='margin-right: 10px;'>";
                                                echo "<span class='input-radio__body'>";
                                                echo "<input id='radio_$idModePaiement2' class='input-radio__input custom-pf' name='paiement_pf' type='radio' value='$idModePaiement2' ";


                                                if ($_SESSION['paiement_pf'] == $idModePaiement2) {
                                                    echo "checked ";
                                                }
                                                if (($idModePaiement2 == "1" || $idModePaiement2 == "2") && $avancement_60_pourcent == 'non') {
                                                    echo "disabled";
                                                } elseif (($idModePaiement2 == "3" || $idModePaiement2 == "4") && $paiement_2_fois == 'non') {
                                                    echo "disabled";
                                                } elseif (($idModePaiement2 == "5" || $idModePaiement2 == "6") && $paiement_3_fois == 'non') {
                                                    echo "disabled";
                                                }

                                                echo ">";
                                                echo "<span class='input-radio__circle'></span>";
                                                echo "</span>";
                                                echo "</span>";
                                                echo "<div style='flex: 1;'>" . htmlspecialchars($nomModePaiement2) . "</div>";
                                                echo "</div>";


                                                echo "<div style='text-align: right; width: 100%; color: #4f7baf; margin-top: 5px;'>";
                                                if ($idModePaiement2 == 1 || $idModePaiement2 == 2) {
                                                    echo "Le reste à la livraison";
                                                } elseif ($idModePaiement2 == 3 || $idModePaiement2 == 4) {
                                                    echo "2 mensualités";
                                                } elseif ($idModePaiement2 == 5 || $idModePaiement2 == 6) {
                                                    echo "3 mensualités";
                                                }
                                                echo "</div>";

                                                echo "</label>";


                                                echo "<div class='payment-methods__item-container'>";
                                                echo "<div class='payment-methods__item-description'>";

                                                if ($idModePaiement2 == 1 || $idModePaiement2 == 3 || $idModePaiement2 == 5) {
                                                    echo "<div id='inputAirtel_$idModePaiement2' class='' style='margin-top: 10px;'>";
                                                    echo "<label for='airtelNumber_$idModePaiement2' style='display: block; margin-top: 10px; font-weight: 100;'>Payer avec ce numéro de téléphone:</label>";
                                                    echo "<input type='text' maxlength='9' minlength='9' pattern='[0-9]{9}' value='$Airtel_number' id='airtelNumber_$idModePaiement2' name='airtelNumber_$idModePaiement2' class='form-control' placeholder='numéro de téléphone portable' style='display: block; width: 100%; margin-top: 5px;'>";

                                                    if ($_SESSION['total_TTC'] > 500000) {
                                                        echo "<label style='color: red; font-weight: bold; margin-top: 10px;'>le montant par commande ne peut dépasser 500 000 Fcfa</label>";
                                                    }

                                                    echo "</div>";
                                                }

                                                echo "<div class='des description$idModePaiement2'></div>";
                                                echo "</div>";
                                                echo "</div>";

                                                echo "</li>";
                                                echo "</div>";
                                            }
                                            ?>
                                        </div>

                                    </ul>
                                </form>



                                <script>
                                    // document.querySelectorAll("input[name='paiement_pf']").forEach(radio => {
                                    //     radio.addEventListener('change', function() {
                                    //         document.querySelectorAll('.phone-input-container').forEach(input => {
                                    //             input.style.display = 'none';
                                    //         });


                                    //         const selectedValue = parseInt(this.value);
                                    //         if (selectedValue === 1 || selectedValue === 5 || selectedValue === 3) {
                                    //             document.getElementById('phoneInput_' + selectedValue).style.display = 'block';
                                    //         }
                                    //     });
                                    // });
                                </script>




                            </div>
                        <?php } ?>

                        <div class="checkout__agree form-group" style="text-align:center">
                            <div class="form-check">
                                <input type="checkbox" name="checkout-terms" class="form-check-input" id="checkout-terms" value="oui" style="text-align: center;">
                                <label class="form-check-label" for="checkout-terms">
                                    <div class="lien" style="text-align: right; font-size: 14px;">
                                        <label for="checkout-terms" style="text-align: center;">
                                            En passant commande vous acceptez nos <a href="/CGV" target="_blank">CGV</a>, ainsi que le <a href="/Traitements-de-mes-donnees" target="_blank">traitements de vos donn&eacute;es.</a>
                                            <?php if ($ligne_selectpa['Titre_panier'] != "Abonnement" && $ligne_selectpa['Titre_panier'] != "Liste") {
                                                echo "<br> Vous avez v&eacute;rifi&eacute; les liens en cliquant dessus et les prix renseign&eacute;s sont exacts.";
                                            } ?>
                                        </label>

                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="annuler-message" id="annuler-message">Vous avez annulé la transaction.</div>
                        <div class="annuler-message" id="temps-message">Le temps est écoulé. Si vous avez effectué le paiement, veuillez recharger la page et votre commande sera traitée.</div>
                        <div style="display: flex; justify-content: center;">
                            <button id="payer" data-donnes="<?= $donneescomplet ? 'oui' : "non" ?>" type='submit' style=' padding: 6px; color: black;' class='btn btn-primary'>PAYER MA COMMANDE</button>
                        </div>


                        <?php
                        // include('includes/Panier-paypal-include.php');
                        /////////////////////////////////////PAYPAL
                        // 	if($idModePaiement == 1){
                        //         echo "<button type='submit' class='btn btn-primary btn-block'>Payer</button>";
                        //        //
                        //    }
                        if (isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $_SESSION['total_HT'] > 0) { ?>
                            <div style="text-align: center; margin-top: 20px; width: 100%;">
                                <a href="/Traitements-admin" id='valider-admin' class='btn btn-primary' style='color: black !important; text-decoration: none; padding-left: 1em; padding-right: 1em;'> PAYER EN ADMIN </a>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>


        <div id="modal-loading" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="margin-top: 50px; max-width: 1200px;">
                <div class="modal-content" style="max-height: 90vh; overflow-y: auto;">
                    <div class="modal-header" style=" color: white; display: flex; align-items: center;">
                        <img src="images/logo header.png" alt="Icono" style="width: 90px; height: auto; margin-right: 10px;">
                        <h5 class="modal-title" style="text-align: center; width: 100%; color: black; font-weight: 100;">Validez votre paiement depuis votre mobile</h5>
                    </div>

                    <div class="modal-body" style="padding: 0;">
                        <div style="background-color: #31b0d5; color: white; text-align: center; padding: 15px;">
                            <span style="font-size: 24px; margin: 0;">Paiement initié</span>
                            <p>Veuillez suivre les instructions depuis votre mobile de paiement en saisissant les données de validation.</p>
                            <div class="loader" style="margin: 0 auto;"></div>
                            <div style="font-size: 24px; margin-top: 10px;">
                                <strong>Temps restant : <span id="timer">1:20</span></strong>
                            </div>
                        </div>
                        <div style="background-color: #E8F4FA; padding: 20px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                                <div style="flex: 0.3; padding-right: 15px; min-width: 250px; margin-bottom: 15px;">
                                    <h6>Résumé de la transaction</h6>
                                    <p><strong>Marchand :</strong> MY-HYRO</p>
                                    <p><strong>Montant :</strong> <span id="prix-popup"></span> FCFA</p>
                                    <p><strong>Date :</strong> <?= date('d-m-Y H:i', time()); ?></p>
                                    <p><strong>N° de mobile payeur :</strong> <span id="tel-popup"></span></p>
                                </div>

                                <div style="flex: 1; padding-left: 15px; border-left: 2px solid #ccc; min-width: 250px;">

                                    <p>Vous avez reçu une demande de paiement sur le mobile indiqué. Vous disposez de 30 secondes pour la valider.</p>
                                    <p>Si vous ne recevez pas la demande de paiement sur votre mobile, cela peut être dû à des problèmes de réseau ou une erreur de numéro. Vous pouvez soit :</p>

                                    <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                                        <div style="text-align: center;">
                                            <img src="images/Télephone pop up.png" alt="Exemple d'écran" style="width: 100%; max-width: 150px; margin-top: 10px;">
                                        </div>
                                        <div style="flex: 1; min-width: 150px;">
                                            <ul style="margin-top: 10px; list-style-type: none; padding: 0;">
                                                <li>🔸 Réessayer maintenant ou plus tard avec le même numéro</li>
                                                <li>🔸 Réessayer en payant avec un autre numéro</li>
                                                <li>🔸 Choisir un autre moyen de paiement, espèces par exemple afin de payer par dépôt AM ou en espèces</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <br>
                                    <p>Si vous n'avez pas reçu la demande de paiement sur votre mobile dans les 10 secondes <a id="notif-pasrecu" href="/Paiement-2"> Cliquez ici </a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="background-color: #284170; text-align: center; justify-content: center;">
                        <button style="background-color: white;" class="btn btn-light" data-dismiss="modal">Aide</button>
                        <button id="cancelButton" style="display: none; background-color: white;" class="btn btn-danger"><a id="notif-pasrecu" href="/Paiement-2" style="color: black;"> Annuler </a></button>
                    </div>
                </div>
            </div>
        </div>


        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>





        <script>
            function preventNavigation() {
                // Ajout d'une entrée factice à l'historique
                history.pushState(null, null, location.href);
            }


            $('#modal-loading').on('shown.bs.modal', function() {

                $(document).on('keydown.disableReload', function(e) {
                    if ((e.which || e.keyCode) === 116 || // F5
                        (e.ctrlKey && e.which === 82) || // Ctrl+R
                        (e.metaKey && e.which === 82)) { // Cmd+R para Mac
                        e.preventDefault();
                    }
                });

                // Ajout d'une entrée factice pour éviter la navigation vers l'arrière
                preventNavigation();
                window.addEventListener('popstate', preventNavigation);
            });


            $('#modal-loading').on('hidden.bs.modal', function() {
                //Activer à nouveau le rechargement de la page
                $(document).off('keydown.disableReload');

                // On quitte l'entrée factice et l'événement
                window.removeEventListener('popstate', preventNavigation);
            });

            $('#modal-loading').on('shown.bs.modal', function() {
                $('checkout block').css('overflow', 'hidden');
            });


            $('#notif-pasrecu').on('click', function() {
                $('checkout block').css('overflow', 'auto');
            });


            $(document).on("change", "#Pays", function() {
                pays();
            });

            function pays() {
                if ($('#Pays option:selected').val() != "Gabon") {
                    $('.france').css("display", "");
                    $('.gabon').css("display", "none");
                }
                if ($('#Pays option:selected').val() == "Gabon") {
                    $('.france').css("display", "none");
                    $('.gabon').css("display", "");
                }
            }
            pays();
        </script>



<?php
    } else {
        header('location: /Passage-de-commande');
    }
    //include("pages/paiements/Api-Paypal/paypal.php");

} else {
    header('location: /index.html');
}
?>