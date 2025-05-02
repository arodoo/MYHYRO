<?php
ob_start();

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

unset($_SESSION['creation_compte_ok']);
?>

<script>
    $(document).ready(function() {

        //AJAX SOUMISSION DU FORMULAIRE

        $("#inscription_submit").click(function(event) {
            event.preventDefault(); // Empêcher le rechargement de la page
            $.post({
                url: '/pop-up/inscription/inscription_popup_ajax.php',
                type: 'POST',
                data: new FormData($("#inscription_formulaire")[0]),
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(res) {
                    console.log(res);

                    <?php
                    //Si mode inscription - Connexion automatique après inscription
                    if ($mod_inscription == 2) {
                    ?>
                        if (res.retour_validation == "") {
                            $('#retour_inscription').html("<div class='alert alert-danger' role='alert' style='text-align: left;' >" + res.Texte_rapport + "</div>");
                        }

                        if (res.retour_validation == "ok") {
                            $('#retour_inscription').html("<div class='alert alert-success' role='alert' style='text-align: left;' >" + res.Texte_rapport + "</div>");
                            $('#inscription_formulaire')[0].reset(); // Réinitialiser les champs du formulaire
                            $(location).attr("href", res.retour_lien);
                        }
                    <?php
                        //Si mode inscription autre
                    } else {
                    ?>
                        if (res.retour_validation == "") {
                            $('#retour_inscription').html("<div class='alert alert-danger' role='alert' style='text-align: left;' >" + res.Texte_rapport + "</div>");
                        }

                        if (res.retour_validation == "ok") {
                            $('#retour_inscription').html("<div class='alert alert-success' role='alert' style='text-align: left;' >" + res.Texte_rapport + "</div>");
                            $('#inscription_formulaire')[0].reset(); // Réinitialiser les champs du formulaire
                            $(location).attr("href", res.retour_lien);
                        }
                    <?php
                    }
                    ?>
                },
                error: function(xhr, status, error) {
                    console.log("Erreur AJAX : " + error);
                }
            });
        });

        //AFFICHE INFORMATIONS MOT DE PASSE
        $(document).on("click", "#password", function() {
            $('#rappot_mot_de_passe').css("display", "");
        });

    });
</script>

<style>
    .inscription-md {
        max-width: 60%;
        max-height: 60% !important;
        margin-top: 80px;
    }

    .abo-price {
        padding-top: 1rem;
        padding-bottom: 1rem;
    }



    @media screen and (max-width: 768px) {
        .inscription-md {
            max-width: 90%;
            max-height: 90% !important;
            margin-top: 80px;
        }

        #pxp-signin-modal-inscription .modal-title,
        #pxp-signin-modal-inscription .modal-body,
        #pxp-signin-modal-inscription .modal-body p,
        #pxp-signin-modal-inscription .modal-body h5 {
            font-size: 14px;
        }

        .modal-content {
            max-height: 80vh;
            overflow-y: auto;
        }

        .card {
            max-width: 100%;
            margin: 10px auto;
            padding: 10px;
        }

        .card-title-abo h5 {
            font-size: 12px;
            padding-top: 5px !important;
            padding-bottom: 5px !important;
        }

        .abo-price {
            font-size: 12px;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        input[type="radio"] {
            width: 18px !important;
            height: 18px !important;
        }

        
    }
</style>

<div class="modal fade" id="pxp-signin-modal-inscription" tabindex="-1" role="dialog"
    aria-labelledby="pxpSigninModalInscription" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered inscription-md" role="document">
        <div class="modal-content" style="margin-top:1%;">
            <div class="modal-header" style="text-align: left;">
                <h2 class="modal-title style_color" id="pxpSigninModal" style="float: left;">Inscription</h2>
                <a href="#" class="pxp-header-user btn btn-info" onclick="return false;"
                    style="color : #fff !important; margin-left: 20px; margin-top: 5px;">S'identifier</a>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div style="clear: both;"></div>
            </div>
            <div class="modal-body" style="text-align: left;">
                <div id='retour_inscription'></div>
                <form id='inscription_formulaire' method='post' action='#'>



                    <div class='MarginBottom20' style='clear: both;'></div>

                    <div class="input-group mb-2 col-lg-6" style="padding-left: 0">
                        <input class="form-control mr-3" id="Nom" type="text" name="Nom"
                            placeholder="*<?php echo "Nom"; ?>" value="<?php echo "$Nom"; ?>"
                            style='<?php echo "$coloorm"; ?>' />
                        <input class="form-control" id="Prenom" type="text" name="Prenom"
                            placeholder="*<?php echo "Prenom"; ?>" value="<?php echo "$Prenom"; ?>"
                            style='<?php echo "$coloorm"; ?>' />
                    </div>


                    <div class="input-group mb-2 col-lg-6" style="padding-left: 0">
                        <input class="form-control" id="Mail" type="email" name="Mail" placeholder="*Mail"
                            value="<?php echo "$Mail"; ?>" style='<?php echo "$coloorm"; ?>' />
                    </div>

                    <div id="rappot_mot_de_passe" class="alert alert-warning col-lg-6" role="alert"
                        style="margin-bottom: 10px; display: none;"><span
                            class="uk-icon-exclamation-circle"></span> <b>Mot de passe</b> : Alphanumérique, 8
                        caractères minimum
                    </div>

                    <div class="input-group mb-2 col-lg-6" style="padding-left: 0">
                        <input class="form-control" id="password" type="password" name="password"
                            placeholder="*Mot de passe" value="<?php echo "$password"; ?>" autocomplete="off"
                            style='<?php echo "$coloorm"; ?>' />
                    </div>

                    <div class="row justify-content-center mt-4">
                        <div class="col-lg-4 col-md-4">
                            <div class="card flex-grow-1 mb-0">
                                <div class="card-abonnement ">
                                    <div class="card-title-abo bg-electric1 text-center"
                                        style="height: 30px !important;">
                                        <h5 class="text-white">One shot</h5>
                                    </div>
                                    <p class="pt-2" style="text-align: center; padding: 0px 10px;">
                                        Des tarifs proposés au prix du marché <br><br>
                                        <input type="radio" id="opcion1" name="Abonnement" value="1"
                                            style="height:25px; width:25px;" class="order-first" checked>
                                    </p>
                                    <div class="bg-electric1 abo-price">0 FCFA <span
                                            style="font-size: 16px; color: #0a6f70;"> / An</span></div>

                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4">
                            <div class="card flex-grow-1 mb-0">
                                <div class="card-abonnement ">

                                    <div class="card-title-abo bg-electric2 text-center"
                                        style="height: 30px !important;">
                                        <h5 class="text-white">Hyro Standard</h5>
                                    </div>
                                    <p class="pt-2" style="text-align: center; padding: 0px 0px;">
                                        <span style="font-weight: bold">Accès illimité sans frais supplémentaires</span>
                                        à des prix adaptés pour tous<br>
                                        <input type="radio" id="opcion2" name="Abonnement"
                                            style="height:25px; width:25px;" class="order-first" value="2">
                                    </p>
                                    <div class="bg-electric2 abo-price ">19 900 FCFA <span
                                            style="font-size: 16px; color: #007267;"> / An</span>
                                    </div>

                                </div>
                            </div>

                        </div>


                        <div class="col-lg-4 col-md-4">

                            <div class="card flex-grow-1 mb-0">
                                <div class="card-abonnement">
                                    <div class="card-title-abo bg-electric3 text-center"
                                        style="height: 30px !important;">
                                        <h5 class="text-white">Hyro Prémium</h5>
                                    </div>
                                    <p class="pt-2" style="text-align: center; padding: 0px 0px;">
                                        <strong style="font-weight: bold;">Accès illimité</strong> avec services et
                                        <strong style="font-weight: bold;">suivis personnalisés</strong> pour répondre
                                        à tous vos besoins
                                        <br>
                                        <input type="radio" id="opcion3" name="Abonnement" class="order-first" value="3" style="height:25px; width:25px;">
                                    </p>

                                    <div class="bg-electric3 abo-price ">49 900 FCFA <span
                                            style="font-size: 16px; color: #ab0812;"> / An</span></div>

                                </div>
                            </div>

                        </div>


                    </div>

                    <?php
                    //////////////////////////////////////SI LES CONDITIONS GENERALES EXISTES
                    if (!empty($lien_conditions_generales)) {
                    ?>
                        <br>
                        <div class="input-group MarginBottom10" style="">
                            <input id='cbaonepost' name='cbaonepost' type="checkbox"
                                value='1' <?php echo "$checkedok $checkediiinfos"; ?>
                                style='margin-top:0.5%; margin-right:1%; display: inline-block;' />
                            Je reconnais avoir pris connaissance des <a href='/CGV' target='blank_'
                                class="style_color"
                                style="margin-left: 3px;">CGV</a> et les
                            accepte, ainsi que le traitement de mes données <a href="/Traitements-de-mes-donnees"
                                target="_blank" class="style_color">Politique
                                de confidentialité</a>
                        </div>
                        <br />
                    <?php
                    }
                    ?>

                    <div class="input-group MarginBottom10 justify-content-center" style="text-align: center; margin-bottom: 25px" ;>
                        <button type='button' id='inscription_submit' class='btn btn-primary'
                            style='color : #fff !important; margin-bottom: "35px " !important;' onclick='return false;'>VALIDER
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<?php
ob_end_flush();
?>