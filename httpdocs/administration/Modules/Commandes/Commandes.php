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

if (
    isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 1 ||
    isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 2 ||
    isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 3
) {

    $action = isset($_GET['action']) ? $_GET['action'] : '';
    $idaction = isset($_GET['idaction']) ? $_GET['idaction'] : '';
    ?>

    <div class="sa-app__body">
        <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
            <div class="container">
                <div class="py-5">
                    <div class="row g-4 align-items-center">
                        <div class="col">
                            <nav class="mb-2" aria-label="breadcrumb">
                                <ol class="breadcrumb breadcrumb-sa-simple">
                                    <li class="breadcrumb-item"><a href="<?php echo $http; ?><?php echo $nomsiteweb; ?>">Accueil</a></li>
                                    <li class="breadcrumb-item"><a href="<?php echo $mode_back_lien_interne; ?>">Administration</a></li>
                                    <?php if (empty($action)) { ?>
                                            <li class="breadcrumb-item active" aria-current="page">Commandes</li>
                                    <?php } else { ?>
                                            <li class="breadcrumb-item"><a href="?page=Commandes">Commandes</a></li>
                                    <?php } ?>
                                    <?php if ($action == "Details") { ?>
                                            <li class="breadcrumb-item active" aria-current="page">Détails de la commande</li>
                                    <?php } ?>
                                </ol>
                            </nav>
                            <h1 class="h3 m-0">Commandes</h1>
                        </div>
                        <div class="col-auto d-flex">
                            <a href="<?php echo $mode_back_lien_interne; ?>" class="btn btn-secondary me-3">
                                <i class="fas fa-cog me-2"></i>Administration
                            </a>
                            <?php if (isset($action)) { ?>
                                    <a href="?page=Commandes" class="btn btn-primary">
                                        <i class="fas fa-list me-2"></i>Liste des commandes
                                    </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <?php if ($action == "Details") { ?>
                        <div class="card">
                            <div class="card-body" id="details-commande">
                                <!-- Le contenu sera chargé via AJAX -->
                            </div>
                        </div>
                <?php } else { ?>
                        <!-- Liste des commandes -->
                        <div class="card">
                            <div class="p-4">
                                <div id="liste-commandes">
                                    <!-- Le contenu sera chargé via AJAX -->
                                </div>
                            </div>
                        </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        // Fonction pour charger la liste des commandes
        function listeCommandes() {
            $.post({
                url: '/administration/Modules/Commandes/Commandes-action-liste-ajax.php',
                type: 'POST',
                data: {
                    idmembre: "<?php echo isset($_GET['idmembre']) ? $_GET['idmembre'] : ''; ?>"
                },
                dataType: "html",
                success: function(res) {
                    $("#liste-commandes").html(res);
                }
            });
        }

        // Charger la liste des commandes au chargement
        listeCommandes();

        // Si on est en mode détails, charger les détails de la commande
        <?php if ($action == "Details") { ?>
                $.post({
                    url: '/administration/Modules/Commandes/Commandes-action-details-ajax.php',
                    type: 'POST',
                    data: {
                        idaction: "<?php echo $idaction; ?>"
                    },
                    dataType: "html",
                    success: function(res) {
                        $("#details-commande").html(res);
                    }
                });
        <?php } ?>

        // Événement pour la mise à jour d'une commande
        $(document).on("click", ".update", function() {
            let idCommande = $("#idWish").val();
            let statut_2 = $("#statut_2").val();
            let message = $("#message").val();
            let statut_expedition = $("#statut_expedition").val();

            let datas = {
                id: idCommande,
                annuler_commande: $(this).data('annuler'),
                statut_2: statut_2,
                message: message,
                statut_expedition: statut_expedition,
                poids: $('#poids').val(),
                notes: $('#notes').val(),
                restant_payer: $('#restant_payer').val(),
                restant_rembourser: $('#restant_rembourser').val(),
                montant_rembourser: $('#montant_rembourser').val(),
                statut_paiement: $('#statut_paiement').val(),
                date_de_reception: $('#date_de_reception').val(),
                montant_recu: $('#montant_recu').val(),
                montant_paye_client: $('#montant_paye_client').val(),
                dette_payee_pf: $('#dette_payee_pf').val(),
                dette_payee_pf2: $('#dette_payee_pf2').val(),
                dette_payee_pf3: $('#dette_payee_pf3').val(),
                regulariser: $('#regulariser').val(),
                moyen_de_remboursement: $('#moyen_de_remboursement').val(),
                date_rem: $('#date_rem').val(),
                total_rembourse: $('#total_rembourse').val(),
                moyen_d_encaissement: $('#moyen_d_encaissement').val(),
                commentaire_livraison: $('#commentaire_livraison').val(),
                echeance_du: $('#echeance_du').val(),
                adresse_liv: $('#adresse_liv').val(),
                adresse_fac: $('#adresse_fac').val(),
                lot_expedition: $('#lot_expedition').val(),
                date_envoi: $('#date_envoi').val(),
                motif_encaissement: $('#motif_encaissement').val(),
                motif_remboursement: $('#motif_remboursement').val(),
                mode_encaissement: $('#type_d_encaissement').val(),
                douane_a_la_livraison: $('input[name="douane_a_la_livraison"]:checked').val(),
            }
        
            $.post({
                url: '/administration/Modules/Commandes/Commandes-action-modifier-ajax.php',
                type: 'POST',
                data: datas,
                success: function(res) {
                    res = JSON.parse(res);
                    if (res.retour_validation == "ok") {
                        showToast("success", "Succès", res.Texte_rapport);
                        setTimeout(() => {
                            document.location.reload();
                        }, 1500);
                    } else {
                        showToast("error", "Erreur", res.Texte_rapport);
                    }
                }
            });
        });

        // Fonction pour afficher un toast (notification)
        function showToast(type, title, message) {
            let toastContainer = $(".sa-app__toasts");
            let toastHTML = `
            <div class="toast align-items-center border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body ${type === 'error' ? 'text-danger' : 'text-success'}">
                        <strong>${title}:</strong> ${message}
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        `;
            toastContainer.append(toastHTML);
            setTimeout(function() {
                toastContainer.find('.toast').first().remove();
            }, 3000);
        }

        // Gestion des modifications de produits
        $(document).on("click", "#new_prix", function() {
            let idCommande = $("#idWish").val();
        
            $.post({
                url: '/administration/Modules/Commandes/Commandes-action-produits-ajax.php',
                type: 'POST',
                data: $("#form-produits").serialize(),
                success: function(res) {
                    res = JSON.parse(res);
                    if (res.retour_validation == "ok") {
                        showToast("success", "Succès", res.Texte_rapport);
                        setTimeout(() => {
                            document.location.reload();
                        }, 1500);
                    } else {
                        showToast("error", "Erreur", res.Texte_rapport);
                    }
                }
            });
        });

        // Gestion de la régulation
        $(document).on("click", "#sendRegul", function() {
            let regul = $("#regul").val();
            let idCommande = $("#idWish").val();
            let idMembre = $("#idMembre").val();
        
            let datas = {
                nb: regul,
                id: idCommande,
                action: "add",
                idMembre: idMembre
            };

            $.post({
                url: '/administration/Modules/Commandes/Commandes-action-regulation-ajax.php',
                type: 'POST',
                data: datas,
                success: function(res) {
                    res = JSON.parse(res);
                    if (res.retour_validation == "ok") {
                        showToast("success", "Succès", res.Texte_rapport);
                        setTimeout(() => {
                            document.location.reload();
                        }, 1500);
                    } else {
                        showToast("error", "Erreur", res.Texte_rapport);
                    }
                }
            });
        });

        // Gestion de la mise à jour de la régulation
        $(document).on("click", "#updateRegul", function() {
            let regul = $("#regul").val();
            let idCommande = $("#idWish").val();
            let idRegul = $("#idRegul").val();
        
            let datas = {
                nb: regul,
                id: idRegul,
                action: "update"
            };

            $.post({
                url: '/administration/Modules/Commandes/Commandes-action-regulation-ajax.php',
                type: 'POST',
                data: datas,
                success: function(res) {
                    res = JSON.parse(res);
                    if (res.retour_validation == "ok") {
                        showToast("success", "Succès", res.Texte_rapport);
                    } else {
                        showToast("error", "Erreur", res.Texte_rapport);
                    }
                }
            });
        });

        // Gestion des champs modifiables
        $(document).on("click", ".modif-liv", function() {
            $("#adresse_liv").css('display', '');
            $("#text-liv").css('display', 'none');
            $(this).css('display', 'none');
        });

        $(document).on("click", ".modif-fac", function() {
            $("#adresse_fac").css('display', '');
            $("#text-fac").css('display', 'none');
            $(this).css('display', 'none');
        });

        // Fonction pour calculer la douane et le transport
        function douanetrans() {
            var poids = $('#poids').val();
            var prixkilo = $('#prix_du_kg').val();

            var douane_reel = poids * prixkilo;
            $('#douane_et_transport_reel').val(Math.round(douane_reel));
            ecart();
        }

        // Fonction pour calculer l'écart
        function ecart() {
            var prix_expedition = $('#prix_expedition').val();
            var douane_et_transport_reel = $('#douane_et_transport_reel').val();
            var ecart = prix_expedition - douane_et_transport_reel;

            $('#ecart').val(Math.round(ecart));

            if (ecart > 0) {
                $('#ecart').css('border-color', 'green');
                $('#ecart').css('color', 'green');
            } else {
                $('#ecart').css('border-color', 'red');
                $('#ecart').css('color', 'red');
            }
        }

        // Fonction pour copier dans le presse-papiers
        function copyToClipboard(text) {
            const textarea = document.createElement('textarea');
            textarea.value = text;
            document.body.appendChild(textarea);
            textarea.select();
        
            try {
                document.execCommand('copy');
                return true;
            } catch (ex) {
                console.warn("Copy to clipboard failed.", ex);
                return false;
            } finally {
                document.body.removeChild(textarea);
            }
        }

        // Fonction pour copier les prix
        window.copyPrice = function(idPrixU, idPrixR) {
            var prix_u = document.getElementById(idPrixU).value;
            document.getElementById(idPrixR).value = prix_u;
        };

        // Événement pour l'annulation d'une commande
        $(document).on("click", ".annuler", function() {
            let id = $(this).data('id');
            let annule = ($(this).hasClass('green')) ? 'non' : 'oui';
        
            $(`#annule_champ${id}`).val(annule);
        
            if (annule === 'oui') {
                $(this).removeClass('uk-icon-times red').addClass('uk-icon-check green');
                $(`.line${id}`).addClass('annule');
            } else {
                $(this).removeClass('uk-icon-check green').addClass('uk-icon-times red');
                $(`.line${id}`).removeClass('annule');
            }
        });

        // Événement pour l'ajout d'un produit à un panier
        $(document).on("click", "#addCartFromWish", function() {
            let idCommande = $("#idWish").val();
            let idMembre = $("#idMembre").val();
        
            $.post({
                url: '/panel/Passage-de-commande/passage-de-commande-action-ajouter-ajax.php',
                type: 'POST',
                data: {
                    idcommande: idCommande,
                    idmembre: idMembre
                },
                success: function(res) {
                    res = JSON.parse(res);
                    if (res.retour_validation == "ok") {
                        showToast("success", "Succès", res.Texte_rapport);
                    } else {
                        showToast("error", "Erreur", res.Texte_rapport);
                    }
                }
            });
        });

        // Événement pour ouvrir tous les liens produits
        $(document).on("click", "#openAllProductLinks", function() {
            $(".product-link").each(function() {
                window.open($(this).attr('href'), '_blank');
            });
        });

        // Modification des produits
        $(document).on("change", ".modif_produit", function() {
            let id = $(this).data('id');
            let champ = $(this).data('champ');
            let value = $(this).val();
        
            $.post({
                url: '/administration/Modules/Commandes/Commandes-action-produits-ajax.php',
                type: 'POST',
                data: {
                    id: id,
                    champ: champ,
                    value: value
                },
                success: function(res) {
                    // Feedback visuel sans recharger la page
                    $(this).css('border-color', '#5cb85c');
                    setTimeout(() => {
                        $(this).css('border-color', '');
                    }, 1000);
                }
            });
        });

        // Événement pour calculer la douane et le transport
        $(document).on("input", "#poids", function() {
            douanetrans();
        });
    });
    </script>

    <?php
} else {
    header('location: /index.html');
}
?>