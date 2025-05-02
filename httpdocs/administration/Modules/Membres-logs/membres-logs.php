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

    ?>

    <script>
        $(document).ready(function () {

            //AJAX SOUMISSION DU FORMULAIRE - MODIFIER 
            $(document).on("click", "#modifier-compte-membre", function () {
                $.post({
                    url: '/administration/Modules/Membres-logs/membres-logs-action-modifier-ajax.php',
                    type: 'POST',
                    data: new FormData($("#formulaire-modifier-compte-membre")[0]),
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    success: function (res) {
                        if (res.retour_validation == "ok") {
                            popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                        } else {
                            popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                        }
                    }
                });
                listeCompteMembre();
            });

            //FUNCTION AJAX - LISTE NEWSLETTER
            function listeCompteMembre() {
                $.post({
                    url: '/administration/Modules/Membres-logs/membres-logs-action-liste-ajax.php',
                    type: 'POST',
                    data: { idaction: "<?php echo $_GET['idaction']; ?>" },
                    dataType: "html",
                    success: function (res) {
                        $("#liste-compte-membre").html(res);
                        // Initialize DataTable properly after AJAX content loads
                        initializeLogsDataTable();
                    }
                });
            }

            // Separate function to initialize DataTable - follows the pattern from Membres module
            function initializeLogsDataTable() {
                // Prevent duplicate initialization
                if ($.fn.DataTable.isDataTable('.sa-datatables-init')) {
                    $('.sa-datatables-init').DataTable().destroy();
                }
                
                // Define clean template structure for consistent layout
                const template = 
                    '<"sa-datatables"' +
                    '<"sa-datatables__table"t>' +
                    '<"sa-datatables__footer"' +
                        '<"sa-datatables__pagination"p>' +
                        '<"sa-datatables__controls"' +
                        '<"sa-datatables__legend"i>' +
                        '<"sa-datatables__divider">' +
                        '<"sa-datatables__page-size"l>' +
                        '>' +
                    '>' +
                    '>';
                
                // Initialize with clean options
                $('.sa-datatables-init').each(function() {
                    const table = $(this).DataTable({
                        dom: template,
                        paging: true,
                        ordering: true,
                        info: true,
                        language: {
                            search: "",
                            searchPlaceholder: "Rechercher...",
                            lengthMenu: "Afficher _MENU_ éléments",
                            info: "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
                            infoEmpty: "Affichage de l'élément 0 à 0 sur 0 élément",
                            infoFiltered: "(filtré de _MAX_ éléments au total)",
                            paginate: {
                                first: "Premier",
                                previous: "Précédent",
                                next: "Suivant",
                                last: "Dernier"
                            }
                        },
                        // Apply proper styles to pagination for consistency
                        drawCallback: function() {
                            $(this.api().table().container()).find('.pagination').addClass('pagination-sm');
                        }
                    });
                    
                    // Connect search input using data attribute for clean, declarative approach
                    const searchSelector = $(this).data('sa-search-input');
                    if (searchSelector) {
                        $(searchSelector).off('input').on('input', function() {
                            table.search(this.value).draw();
                        });
                        
                        // Prevent form submission on enter in search field
                        $(searchSelector).off('keypress.prevent-form-submit').on('keypress.prevent-form-submit', function(e) {
                            return e.which !== 13;
                        });
                    }
                });
            }

            listeCompteMembre();
        });
    </script>

    <?php

    $action = $_GET['action'];
    $idaction = $_GET['idaction'];
    ?>

    <div id="top" class="sa-app__body">
        <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
            <div class="container">
                <div class="py-5">
                    <div class="row g-4 align-items-center">
                        <div class="col">
                            <nav class="mb-2" aria-label="breadcrumb">
                                <ol class="breadcrumb breadcrumb-sa-simple">
                                    <li class="breadcrumb-item"><a href="index-admin.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Membres</li>
                                </ol>
                            </nav>
                            <h1 class="h3 m-0">Membres</h1>
                        </div>
                        <div class="col-auto d-flex">
                            <?php if (isset($_GET['action'])) { ?>
                                <a href="?page=Membres-logs" class="btn btn-primary me-3">
                                    <i class="fas fa-history me-2"></i>Liste des logs
                                </a>
                            <?php } ?>
                            <a href="?page=Membres" class="btn btn-primary">
                                <i class="fas fa-user me-2"></i>Liste des membres
                            </a>
                        </div>
                    </div>
                </div>

                <?php
                ////////////////////////////////////////////////////////////////////////////////////////////FORMULAIRE AJOUTER - MODIFIER
                if ($action == "consulter") {

                    ///////////////////////////////SELECT
                    $req_select = $bdd->prepare("SELECT * FROM membres_logs WHERE id=?");
                    $req_select->execute(array($idaction));
                    $ligne_select = $req_select->fetch();
                    $req_select->closeCursor();
                    $idd = $ligne_select['id'];
                    $id_membre = $ligne_select['id_membre'];
                    $pseudo = $ligne_select['pseudo'];
                    $mail_compte_concerne = $ligne_select['mail_compte_concerne'];
                    $module = $ligne_select['module'];
                    $action_sujet = $ligne_select['action_sujet'];
                    $action_libelle = $ligne_select['action_libelle'];
                    $action = $ligne_select['action'];
                    $date = $ligne_select['date'];
                    $date_seconde = $ligne_select['date_seconde'];
                    $heure = $ligne_select['heure'];
                    $ip = $ligne_select['ip'];
                    $navigateur = $ligne_select['navigateur'];
                    $navigateur_version = $ligne_select['navigateur_version'];
                    $referrer = $ligne_select['referrer'];
                    $uri = $ligne_select['uri'];
                    $cookies_autorisees = $ligne_select['cookies_autorisees'];
                    $os = $ligne_select['os'];
                    $langue = $ligne_select['langue'];
                    $niveau = $ligne_select['niveau'];
                    $lieu = $ligne_select['lieu'];
                    //$compte_bloque = $ligne_select['compte_bloque'];
            
                    ///////////////////////////////SELECT
                    $req_select = $bdd->prepare("SELECT * FROM membres WHERE mail=?");
                    $req_select->execute(array($mail_compte_concerne));
                    $ligne_select = $req_select->fetch();
                    $req_select->closeCursor();
                    $idd2dddf = $ligne_select['id'];
                    $loginm = $ligne_select['pseudo'];
                    $emailm = $ligne_select['mail'];
                    $adminm = $ligne_select['admin'];
                    $nomm = $ligne_select['nom'];
                    $prenomm = $ligne_select['prenom'];
                    $adressem = $ligne_select['adresse'];
                    $cpm = $ligne_select['cp'];
                    $villem = $ligne_select['ville'];
                    $IM = $ligne_select['IM'];
                    $IM_REGLEMENT = $ligne_select['IM_REGLEMENT'];
                    $telephonepost = $ligne_select['Telephone'];
                    $telephoneposportable = $ligne_select['Telephone_portable'];
                    $cba = $ligne_select['newslettre'];
                    $cbb = $ligne_select['reglement_accepte'];
                    $FH = $ligne_select['femme_homme'];
                    $datenaissance = $ligne_select['datenaissance'];
                    $passwd = $ligne_select['pass'];
                    $passwdd = $ligne_select['pass'];
                    $pdate_etatdate_etat = $ligne_select['date_etat'];
                    $date_enregistrement = $ligne_select['date_enregistrement'];
                    $ip_inscription = $ligne_select['ip_inscription'];
                    $compte_bloque = $ligne_select['compte_bloque'];
                    $compte_bloque_date = $ligne_select['compte_bloque_date'];
                    if ($compte_bloque == "oui" && !empty($compte_bloque_date)) {
                        $compte_bloque_date = ", bloqué le " . date('d-m-Y', $compte_bloque_date) . "";
                    } else {
                        $compte_bloque_date = "";
                    }

                    $paypost = $ligne_select['Pays'];
                    $Client = $ligne_select['Client'];
                    $nbractivation = $ligne_select['nbractivation'];
                    $site_web = $ligne_select['site_web'];
                    $pseudo_skype = $ligne_select['pseudo_skype'];
                    $last_login = $ligne_select['last_login'];
                    $last_ip = $ligne_select['last_ip'];
                    $FH = $ligne_select['civilites'];
                    $faxpost = $ligne_select['Fax'];
                    $statut_compte = $ligne_select['statut_compte'];
                    ?>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                Consultation du log de <?php echo $mail_compte_concerne; ?>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info" role="alert">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Log du <?php echo "$date à $heure"; ?></strong>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="mb-0">Informations utilisateur</h6>
                                        </div>
                                        <div class="card-body">
                                            <dl class="row mb-0">
                                                <dt class="col-sm-5"><i class="fas fa-user me-2"></i>Pseudo du compte :</dt>
                                                <dd class="col-sm-7"><?php echo $pseudo; ?></dd>

                                                <dt class="col-sm-5"><i class="fas fa-envelope me-2"></i>Mail du compte :</dt>
                                                <dd class="col-sm-7"><?php echo $mail_compte_concerne; ?></dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="mb-0">Détails de connexion</h6>
                                        </div>
                                        <div class="card-body">
                                            <dl class="row mb-0">
                                                <dt class="col-sm-5"><i class="fas fa-clock me-2"></i>Dernière connexion :</dt>
                                                <dd class="col-sm-7">
                                                    <?php if (!empty($last_login) && $last_login != "time") {
                                                        echo date('d-m-Y à H:i', $last_login);
                                                    } else {
                                                        echo "--";
                                                    } ?>
                                                </dd>

                                                <dt class="col-sm-5"><i class="fas fa-globe me-2"></i>IP connexion :</dt>
                                                <dd class="col-sm-7"><?php echo "$last_ip"; ?></dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="fas fa-file-alt me-2"></i>Module et action</h6>
                                </div>
                                <div class="card-body">
                                    <dl class="row mb-0">
                                        <dt class="col-sm-3"><i class="fas fa-cog me-2"></i>MODULE :</dt>
                                        <dd class="col-sm-9"><?php echo "$module"; ?></dd>

                                        <dt class="col-sm-3"><i class="fas fa-cogs me-2"></i>ACTION :</dt>
                                        <dd class="col-sm-9"><?php echo "$action"; ?></dd>
                                    </dl>
                                </div>
                            </div>

                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="fas fa-laptop me-2"></i>Informations du système</h6>
                                </div>
                                <div class="card-body">
                                    <dl class="row mb-0">
                                        <dt class="col-sm-3"><i class="fas fa-globe me-2"></i>Navigateur :</dt>
                                        <dd class="col-sm-9"><?php echo "$navigateur"; ?></dd>

                                        <dt class="col-sm-3"><i class="fas fa-desktop me-2"></i>OS :</dt>
                                        <dd class="col-sm-9"><?php echo "$os"; ?></dd>

                                        <dt class="col-sm-3"><i class="fas fa-language me-2"></i>Langue :</dt>
                                        <dd class="col-sm-9"><?php echo "$langue"; ?></dd>
                                    </dl>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="fas fa-file-alt me-2"></i>Détails de la notification</h6>
                                </div>
                                <div class="card-body">
                                    <dl class="row mb-0">
                                        <dt class="col-sm-3"><i class="fas fa-file-alt me-2"></i>Détails :</dt>
                                        <dd class="col-sm-9"><?php echo "$action_libelle"; ?></dd>

                                        <dt class="col-sm-3"><i class="fas fa-heading me-2"></i>Sujet :</dt>
                                        <dd class="col-sm-9"><?php echo "$action_sujet"; ?></dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                }
                ////////////////////////////////////////////////////////////////////////////////////////////FORMULAIRE AJOUTER - MODIFIER
            
                ////////////////////////////////////////////////////////////////////////////////////////////PAS D'ACTION
                if (!isset($action)) {
                    ?>
                    <div id="liste-compte-membre" class="card-table"></div>
                    <?php
                }
                ////////////////////////////////////////////////////////////////////////////////////////////PAS D'ACTION
                ?>
            </div>
        </div>
    </div>

    <?php
} else {
    header('location: /index.html');
}
?>