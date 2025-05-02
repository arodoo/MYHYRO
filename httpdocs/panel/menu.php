<script>
    function handleRedirect() {
        $.post({
            url: '/function/function_manager_command.php',
            type: 'POST',
            data: {
                action: "Ajouter"
            },
            success: function(res) {
                res = JSON.parse(res);

                if (res.retour_validation == "ok") {
                    document.location.replace('/Passage-de-commande');
                } else {
                    popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                }
            }
        })
    }
    $(document).on('click', "#addList", function() {
        $('#demande_souhait').modal('show');
    })
</script>
<div class="col-md-12">
    <div style="padding: 15px;">Bonjour <?php echo $prenom_oo; ?>,</div>
</div>
<div class="col-md-12 col-lg-3 d-flex">
    <div class="account-nav flex-grow-1">
        <h4 class="account-nav__title">Mon compte</h4>
        <ul>
            <li class="account-nav__item">
                <a href="/">
                    Accueil
                </a>
            </li>

            <li class="account-nav__item  <?php if ($_GET['page'] == "Compte-modifications") {
                                                echo "account-nav__item--active";
                                            } ?> ">
                <a href="/Gestion-de-votre-compte.html">
                    Mes informations
                </a>
            </li>

            <li class="account-nav__item <?php if ($_GET['page'] == "Mon-abonnement") {
                                                echo "account-nav__item--active";
                                            } ?> ">
                <a href="/Mon-abonnement">
                    Mon abonnement
                </a>
            </li>

            <li class="account-nav__item <?php if ($_GET['page'] == "Mes-commandes" && empty($_GET['action'])) {
                                                echo "account-nav__item--active";
                                            } ?>">
                <a href="/Mes-commandes">
                    Mes commandes
                </a>
            </li>

            <li class="account-nav__item <?php if ($_GET['page'] == "Mes-commandes" && $_GET['action'] == "Ajouter") {
                                                echo "account-nav__item--active";
                                            } ?> " style="margin-left: 40px;">
                <a href="/Passage-de-commande">Nouvelle commande</a>
            </li>

            <li class="account-nav__item <?php if ($_GET['page'] == "Ma-liste-de-souhaits" && empty($_GET['action'])) {
                                                echo "account-nav__item--active";
                                            } ?>">
                <a href="/Mes-listes-de-souhaits">
                    Mes listes de souhaits
                </a>
            </li>
            <li class="account-nav__item <?php if ($_GET['page'] == "Ma-liste-de-souhaits" && $_GET['action'] == "Ajouter") {
                                                echo "account-nav__item--active";
                                            } ?> " style="margin-left: 40px;">
                <a href="/Mes-listes-de-souhaits">
                    Mes souhaits en cours
                </a>
            </li>
          <!--   <li class="account-nav__item <?php if ($_GET['page'] == "Ma-liste-de-souhaits" && $_GET['action'] == "Ajouter") {
                                                echo "account-nav__item--active";
                                            } ?> " style="margin-left: 40px;">
                <a href="/Mes-produits">
                    Mes produits retrouvés
                </a>
            </li> -->
            <li class="account-nav__item <?php if ($_GET['page'] == "Ma-liste-de-souhaits" && $_GET['action'] == "Ajouter") {
                                                echo "account-nav__item--active";
                                            } ?> " style="margin-left: 40px;">
                <a href="#" id="addList">
                    Créer une liste
                </a>
            </li>
            <li class="account-nav__item <?php if ($_GET['page'] == "Mes-colis" && empty($_GET['action'])) {
                                                echo "account-nav__item--active";
                                            } ?>">
                <a href="/Mes-colis">
                    Mes colis
                </a>
            </li>
            <li class="account-nav__item <?php if ($_GET['page'] == "Mes-colis" && $_GET['action'] == "Ajouter") {
                                                echo "account-nav__item--active";
                                            } ?>" style="margin-left: 40px;">
                <a href="/Passage-de-colis">
                    Nouveau colis
                </a>
            </li>
            <li class="account-nav__item <?php if ($_GET['page'] == "Notifications") {
                                                echo "account-nav__item--active";
                                            } ?>">
                <a href="/Notifications">
                    Notifications
                </a>
            </li>
            <li class="account-nav__item <?php if ($_GET['page'] == "factures") {
                                                echo "account-nav__item--active";
                                            } ?>">
                <a href="/Factures">
                    Factures
                </a>
            </li>


            <li class="account-nav__item  mobile-only">
                <a href="/Contact">Assistance</a>
            </li>

            <li class="account-nav__item  mobile-only">
                <a href="/FAQ"> Faq </a>
            </li>

            <li class="account-nav__item  mobile-only">
                <a href="/Blog"> Blog</a>
            </li>


        </ul>

        <div class="card-divider"></div>
        <h4 class="account-nav__title">Navigation</h4>
        <ul class="navigation-hide">
            <li class="account-nav__item ">
                <a href="/Contact">Assistance</a>
            </li>

            <li class="account-nav__item ">
                <a href="/FAQ"> Faq </a>
            </li>

            <li class="account-nav__item ">
                <a href="/Blog"> Blog</a>
            </li>
        </ul>

        <h4 class="account-nav__title" style="width: 100%;">Besoin d'un conseil ?</h4>
        <ul style="padding: 0; margin: 0;">

            <li class="account-nav__item " style="padding-left: 15px; padding-right: 15px;">
                Un spécialiste répond à toutes vos questions et vous aide à bien choisir. <br /><br />
            </li>
        </ul>

        <!-- <div class="account-nav__item " style="width: 100%; padding: 15px; margin-bottom: 5px; padding-top: 5px; padding-bottom: 5px; font-weight: bold; font-size: 18px;">France
            <?php echo "$telephone_fixe_ii"; ?>
        </div> -->
        <div class="card-divider"></div>
        <!-- <div class="account-nav__item " style="width: 100%; padding: 15px; margin-top: 5px; font-weight: bold; font-size: 18px; padding-bottom: 5px;">Gabon
            <?php echo "$telephone_portable_ii"; ?>
        </div> -->
        <div class="card-divider"></div>

    </div>
</div>



    <!-- </div> -->


    <style>
        .mobile-only {
            display: none;
        }


        @media (max-width: 992px) {
            .mobile-only {
                display: list-item;
            }

            .navigation-hide {
            display: none!important;
        }

        }
    </style>