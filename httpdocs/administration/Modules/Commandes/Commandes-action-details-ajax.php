<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../../Configurations_bdd.php');
require_once('../../../Configurations.php');
require_once('../../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction = "../../../";
require_once('../../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

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

if (
    isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 1 ||
    isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 2 ||
    isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 3
) {

    //GET FUNCTION
    $sql_select = $bdd->prepare('SELECT * from membres_commandes WHERE id=?');
    $sql_select->execute(array(
        intval($_POST['idaction'])
    ));
    $commande = $sql_select->fetch();
    $sql_select->closeCursor();

    $sql_select = $bdd->prepare('SELECT * from membres_colis WHERE panier_id=?');
    $sql_select->execute(array(
        intval($commande['panier_id'])
    ));
    $colis_lie = $sql_select->fetch();
    $sql_select->closeCursor();

    $sql_select = $bdd->prepare('SELECT * from membres WHERE id=?');
    $sql_select->execute(array(
        intval($commande['user_id'])
    ));
    $client = $sql_select->fetch();
    $sql_select->closeCursor();

    $sql_select = $bdd->prepare('SELECT * from configurations_livraisons_gabon WHERE id=?');
    $sql_select->execute(array(
        intval($commande['id_livraison'])
    ));
    $livraison = $sql_select->fetch();
    $sql_select->closeCursor();

    $sql_select = $bdd->prepare('SELECT * from configurations_modes_paiement WHERE id=?');
    $sql_select->execute(array(
        intval($commande['id_paiement'])
    ));
    $paiement = $sql_select->fetch();
    $sql_select->closeCursor();

    $mode_paiement = $paiement['nom_mode'];

    if (empty($paiement['nom_mode'])) {
        $sql_select = $bdd->prepare('SELECT * from configurations_modes_paiement_plusieurs_fois WHERE id=?');
        $sql_select->execute(array(
            intval($commande['id_paiement_pf'])
        ));
        $paiement = $sql_select->fetch();
        $sql_select->closeCursor();

        $mode_paiement = $paiement['nom'];
    }

    $req_select = $bdd->prepare("SELECT * FROM membres WHERE id=?");
    $req_select->execute(array($commande['user_id']));
    $ligne_membre = $req_select->fetch();
    $req_select->closeCursor();

    if ($ligne_membre['same_adresse'] == "oui") {
        $nomfac = $ligne_membre['nom'];
        $prenomfac = $ligne_membre['prenom'];
        $adressefac = $ligne_membre['Adresse_facturation'];
        $telephonefac = $ligne_membre['Telephone_portable'];
        $villefac = $ligne_membre['Ville_facturation'];
        $cpfac = $ligne_membre['Code_postal_facturation'];
        $paysfac = $ligne_membre['Pays_facturation'];
        $complementfac = $ligne_membre['Complement_d_adresse_facturation'];

        $nomliv = $ligne_membre['nom'];
        $prenomliv = $ligne_membre['prenom'];
        $adresseliv = $ligne_membre['adresse'];
        $villeliv = $ligne_membre['ville'];
        $telephoneliv = $ligne_membre['Telephone_portable'];
        $cpliv = $ligne_membre['cp'];
        $paysliv = $ligne_membre['Pays'];
        $complementliv = $ligne_membre['Complement_d_adresse'];
    } else {
        $nomfac = $ligne_membre['nom'];
        $prenomfac = $ligne_membre['prenom'];
        $adressefac = $ligne_membre['adresse'];
        $villefac = $ligne_membre['ville'];
        $telephonefac = $ligne_membre['Telephone_portable'];
        $cpfac = $ligne_membre['cp'];
        $paysfac = $ligne_membre['Pays'];
        $complementfac = $ligne_membre['Complement_d_adresse'];

        $nomliv = $ligne_membre['nom'];
        $prenomliv = $ligne_membre['prenom'];
        $adresseliv = $ligne_membre['adresse'];
        $villeliv = $ligne_membre['ville'];
        $telephoneliv = $ligne_membre['Telephone_portable'];
        $cpliv = $ligne_membre['cp'];
        $paysliv = $ligne_membre['Pays'];
        $complementliv = $ligne_membre['Complement_d_adresse'];
    }

    if ($commande['id_paiement'] == '6') {

        $req_select = $bdd->prepare("SELECT * FROM membres_adresse_liv_france WHERE id_membre=?");
        $req_select->execute(array($commande['user_id']));
        $ligne_select2 = $req_select->fetch();
        $req_select->closeCursor();

        $nomliv = $ligne_select2['nom_liv_france'];
        $prenomliv = $ligne_select2['prenom_liv_france'];
        $adresseliv = $ligne_select2['adresse_liv_france'];
        $villeliv = $ligne_select2['ville_liv_france'];
        $telephoneliv = $ligne_select2['telephone_liv_france'];
        $cpliv = $ligne_select2['cp_liv_france'];
        $paysliv = "France";
        $complementliv = $ligne_select2['complement_adresse_liv_france'];
    }

    $req_select_info_membre = $bdd->prepare("SELECT membres.id, membres.pseudo, membres.nom, membres.prenom, configurations_abonnements.nom_abonnement AS nom_abonnement
        FROM membres_commandes
        JOIN membres ON membres_commandes.user_id = membres.id
        LEFT JOIN configurations_abonnements ON membres.Abonnement_id = configurations_abonnements.id
        WHERE membres_commandes.id =?");
    $req_select_info_membre->execute(array($_POST['idaction']));
    $ligne_info_membre = $req_select_info_membre->fetch();
    $req_select_info_membre->closeCursor();
    $id_membre = $ligne_info_membre['id'];
    $pseudo_membre = $ligne_info_membre['pseudo'];
    $nom_membre = $ligne_info_membre['nom'];
    $prenom_membre = $ligne_info_membre['prenom'];
    $abonnement_membre = $ligne_info_membre['nom_abonnement'];

?>
    <script>
        $(document).on("click", ".update", function() {
            let idCommande = document.getElementById('idWish').value;
            //let statut = document.getElementById('statut').value;
            let statut_2 = document.getElementById('statut_2').value;
            let message = document.getElementById('message').value;
            let statut_expedition = document.getElementById('statut_expedition').value;
            //let commentaire_livraison = document.getElementById('commentaire_livraison').value;




            let datas = {
                id: idCommande,
                annuler_commande: $(this).data('annuler'),
                //statut: statut,
                statut_2: statut_2,
                message: message,
                statut_expedition: statut_expedition,
                //commentaire_livraison: commentaire_livraison,
                poids: $('#poids').val(),
                notes: $('#notes').val(),
                restant_payer: $('#restant_payer').val(),
                restant_rembourser: $('#restant_rembourser').val(),
                montant_rembourser: $('#montant_rembourser').val(),
                statut_paiement: $('#statut_paiement').val(),
                date_de_reception: $('#date_de_reception').val(),
                montant_recu: $('#montant_recu').val(),
                montant_paye_client: $('#montant_paye_client').val(),
                //douane_et_transport_reel: $('#douane_et_transport_reel').val(),
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
                        popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                        document.location.reload();
                    } else {
                        popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                    }
                }
            });
        });

        $(document).on("click", "#new_prix", function() {
            let idCommande = document.getElementById('idWish').value;

            const product = document.getElementsByClassName('remplir');
            var valid = true;

            for (let i = 0; i < product.length; i++) {
                if (!product[i].value) {
                    var valid = false;
                    break;
                }
            }

            let datas = {
                id: idCommande,
            }

            if (valid) {

                $.post({
                    url: '/administration/Modules/Commandes/Commandes-action-produits-ajax.php',
                    type: 'POST',
                    data: new FormData($("#form-produits")[0]),
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        res = JSON.parse(res);

                        if (res.retour_validation == "ok") {
                            document.location.reload();
                        } else {
                            popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                        }
                    }
                });

            } else {
                popup_alert("Remplir le prix réel, disponibilité et nom", "#CC0000 filledlight", "#CC0000", "uk-icon-times");
            }
        });

        /*$(document).on("change", ".modif_produit", function () {

            let datas = {
                id: $(this).data('id'),
                champ:  $(this).data('champ'),
                value: $(this).val(),
            }
            $.post({
                url: '/administration/Modules/Commandes/Commandes-action-produits-ajax.php',
                type: 'POST',
                data: datas,
                success: function (res) {
                    res = JSON.parse(res);

                    if (res.retour_validation == "ok") {
                        //popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                        //document.location.reload();

                    } else {
                        popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                    }
                }
            });
        });*/

        $(document).on("click", ".annuler", function() {

            var idd = $(this).data('id')

            $('#annule_champ' + idd).val("oui")

            $('.line' + $(this).data('id')).attr('class', 'annule line' + $(this).data('id'));
            $(this).attr('class', 'uk-icon-check annuler green');

        });



        $(document).on("click", ".uk-icon-check", function() {
            var idd = $(this).data('id')
            $('#annule_champ' + idd).val("non")
            $('.line' + $(this).data('id')).attr('class', 'line' + $(this).data('id'));
            $(this).attr('class', 'uk-icon-times annuler red');

        });

        /*$('#Tableau_a2').DataTable(
            {
                responsive: true,
                stateSave: true,
                dom: 'Btir',
                "order": [],
                buttons: [],
                columnDefs: [{
                    visible: false
                }],
                "language": {
                    "sProcessing": "Traitement en cours...",
                    "sSearch": "Rechercher&nbsp;:",
                    "sLengthMenu": "Afficher _MENU_ &eacute;l&eacute;ments",
                    "sInfo": "",
                    "sInfoEmpty": "",
                    "sInfoFiltered": "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                    "sInfoPostFix": "",
                    "sLoadingRecords": "Chargement en cours...",
                    "sZeroRecords": "Aucun &eacute;l&eacute;ment &agrave; afficher",
                    "sEmptyTable": "Aucune donn&eacute;e disponible dans le tableau",
                    "oPaginate": {
                        "sFirst": "Premier",
                        "sPrevious": "Pr&eacute;c&eacute;dent",
                        "sNext": "Suivant",
                        "sLast": "Dernier"
                    },
                    "oAria": {
                        "sSortAscending": ": activer pour trier la colonne par ordre croissant",
                        "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
                    }
                }
            }
        );*/


        $(document).on("click", "#sendRegul", function() {
            regul = document.getElementById('regul').value;
            idCommande = document.getElementById('idWish').value;
            idMembre = document.getElementById('idMembre').value;

            datas = {
                nb: regul,
                id: idCommande,
                action: "add",
                idMembre: idMembre
            }

            $.post({
                url: '/administration/Modules/Commandes/Commandes-action-regulation-ajax.php',
                type: 'POST',
                data: datas,
                success: function(res) {
                    res = JSON.parse(res);

                    if (res.retour_validation == "ok") {
                        popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                        setTimeout(() => {
                            document.location.reload();
                        }, 1500)
                    } else {
                        popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                    }
                }
            });
        });

        $(document).on("click", "#updateRegul", function() {
            regul = document.getElementById('regul').value;
            idCommande = document.getElementById('idWish').value;
            idRegul = document.getElementById('idRegul').value;
            idMembre = document.getElementById('idMembre').value;

            datas = {
                nb: regul,
                id: idCommande,
                action: "update",
                idRegul: idRegul,
                idMembre: idMembre
            }

            $.post({
                url: '/administration/Modules/Commandes/Commandes-action-regulation-ajax.php',
                type: 'POST',
                data: datas,
                success: function(res) {
                    res = JSON.parse(res);

                    if (res.retour_validation == "ok") {
                        popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                        setTimeout(() => {
                            document.location.reload();
                        }, 1500)
                    } else {
                        popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                    }
                }
            });
        });

        $(document).on("input", "#poids", function() {

            douanetrans();
        });

        function douanetrans() {
            var poids = $('#poids').val();
            var prixkilo = $('#prix_du_kg').val();

            var douane_reel = poids * prixkilo;
            $('#douane_et_transport_reel').val(Math.round(douane_reel));
            ecart()
        }

        $(document).on("click", ".modif-liv", function() {
            $("#adresse_liv").css('display', '')
            $("#text-liv").css('display', 'none')
            $(this).css('display', 'none')
        });

        $(document).on("click", ".modif-fac", function() {
            $("#adresse_fac").css('display', '')
            $("#text-fac").css('display', 'none')
            $(this).css('display', 'none')
        });

        function ecart() {
            var prix_expedition = $('#prix_expedition').val();
            var douane_et_transport_reel = $('#douane_et_transport_reel').val();
            var ecart = prix_expedition - douane_et_transport_reel

            $('#ecart').val(Math.round(ecart));

            if (ecart > 0) {
                $('#ecart').css('border-color', 'green');
                $('#ecart').css('color', 'green');
            } else {
                $('#ecart').css('border-color', 'red');
                $('#ecart').css('color', 'red');
            }
        }
        douanetrans();
    </script>



    <style>
        #table-wrapper {
            position: relative;
        }

        #table-scroll {
            height: 150px;
            overflow: auto;
            margin-top: 20px;
        }

        #table-wrapper table {
            width: 100%;

        }

        /*#table-wrapper table thead {
            position:absolute;
            !*top: -2rem;*!
            z-index:2;
        }
*/
        #table-wrapper table thead th {
            text-align: left;
        }

        #table-wrapper table thead th .textthead {
            /*position:absolute;
            top: -2rem;
            z-index:2;*/
            /*left: 0;*/
            /*height:20px;*/
            /*width:35%;*/
            /*border-bottom:1px solid black;*/
        }

        .even {
            background-color: #ffffff;
        }

        .odd {
            background-color: #f0f0f0;
        }

        .annule {
            text-decoration: line-through;
            text-decoration-color: red;
        }

        .green {
            color: green;
        }

        .red {
            color: red;
        }

        /* Responsive */
        .dates {
            display: flex;

        }

        .remboursement {
            display: flex;
        }

        .paiement {
            display: flex;

        }

        .paiement-element {
            width: 25%;
        }

        .paiement-element2 {
            width: 20%;
        }

        .adresse {
            display: flex;
        }

        .voir-facture {
            width: 20%;
        }

        .encaissement {
            width: 70%;
        }

        .commentaire-livraison {
            width: 45%;
        }

        .suivi-kg {
            justify-content: space-around;
        }

        .button-feacture {
            margin-top: 20rem;
        }

        .input-expedition {
            margin-top: 13rem;
        }



        @media (max-width: 976px) {
            .suivi-commande {
                flex-direction: column;
            }

            .remboursement,
            .dates {
                display: block;
            }

            .paiement {
                flex-wrap: wrap;
            }

            .paiement-element,
            .paiement-element2 {
                width: 33%;
            }

            .adresse {
                display: block;
            }

            .voir-facture,
            .commentaire-livraison {
                width: 100%;
            }

            .encaissement {
                width: max-content;
            }

            .suivi-kg {
                justify-content: space-between;
            }

            .margin-kg {
                margin-right: 0 !important;
            }

            .button-feacture {
                margin-top: 5rem;
            }

            .input-expedition {
                margin-top: 5rem;
                display: flex;
            }

            .button-modifier {
                justify-content: center;
            }

        }
    </style>

    <div class="well well-sm" style="margin-top: 2rem; text-align: left; width: 96vw; position: absolute; top: 40vh; left: 2vw; right: 2vw; ">

        <div class="remboursement" style=" justify-content: space-between; margin-bottom: 2rem">
            <div style="display: flex; flex-direction: column; height: 100%">
                <div>
                    <h2>Commande #<?= $commande['id'] ?></h2>
                    <p>Historique des modifications</p>

                    <div style="max-height: 15vh; overflow-y: auto; scrollbar-color: #ff9900 #dee2e6 ; padding: 1rem 2rem;">
                        <?php
                        ///////////////////////////////SELECT BOUCLE

                        $req_boucle = $bdd->prepare("SELECT * FROM admin_commandes_historique WHERE id_commande=? ORDER BY id DESC");
                        $req_boucle->execute(array($_POST['idaction']));
                        while ($ligne_boucle = $req_boucle->fetch()) {

                            $req_select = $bdd->prepare("SELECT * FROM membres WHERE id=?");
                            $req_select->execute(array($ligne_boucle['id_membre']));
                            $ligne_admin = $req_select->fetch();
                            $req_select->closeCursor();

                        ?>
                            <p> - <?= $ligne_admin['prenom'] ?> a effectué une modification le <?= date('d-m-Y à H:i', $ligne_boucle['date']) ?></p>
                        <?php } ?>
                    </div>

                </div>
                <button class="btn btn-primary" style="height: 4rem; width: fit-content; " onclick="openAllProductLinks()" title="Ouvrir tous les produits">
                    COMMANDER
                </button>
            </div>
            <div>


                <div style="background-color: white; max-width: 60rem; border-radius: 1rem">
                    <p style="margin-top: 1rem; margin-left: 1rem"><b>Commande</b></p>
                    <div class="remboursement" style="align-content: space-between; border-top: 1px solid #dfdfdf; padding: 1rem; margin-top: 1rem">
                        <div style="margin-right: 10rem">
                            <p style="margin-bottom: 3rem">Commande #<?= $commande['id'] ?></p>

                            <p>Date : <?= date('d/m/Y à H \h i \m\i\n', $commande['created_at']) ?></p>
                            <p>Utilisateur : <a href="?page=Membres&action=Modifier&idaction=<?= $id_membre ?>" target="_blank" style="color: #0174aa"><?= $pseudo_membre ?></a></p>

                            <p>Nom : <?= strtoupper($nom_membre) ?> <?= $prenom_membre ?></p>
                            <p>Type d'abonnement : <?= $abonnement_membre ?></p>
                        </div>
                        <div style="display: inline-block;  align-self: flex-end; ">
                            <p>Numéro de paiement : <?= !empty($client['Telephone']) ? $client['Telephone'] : $client['Telephone_portable'] ?></p>

                            <p>Attente paiement: </p>
                            <?php
                            $hasNonPaye = false;

                            if (isset($commande['dette_payee_pf']) && $commande['dette_payee_pf'] === 'Non payé') {
                                echo "<p>Dette Montant : " . $commande['dette_montant_pf'] . "</p>";
                                $hasNonPaye = true;
                            }

                            if (isset($commande['dette_payee_pf2']) && $commande['dette_payee_pf2'] === 'Non payé') {
                                echo "<p>Dette Montant : " . $commande['dette_montant_pf2'] . "</p>";
                                $hasNonPaye = true;
                            }

                            if (isset($commande['dette_payee_pf3']) && $commande['dette_payee_pf3'] === 'Non payé') {
                                echo "<p>Dette Montant : " . $commande['dette_montant_pf3'] . "</p>";
                                $hasNonPaye = true;
                            }

                            if (!$hasNonPaye) {
                                echo "<p>Il n'y a pas de dates à venir</p>";
                            }
                            ?>


                            <p>Code transaction: xxxxxx</p>
                        </div>
                    </div>

                </div>
                <?php
                if (!empty($colis_lie["id"])) {
                ?>

                    <a href='?page=Envoyer-colis&action=Details&idaction=<?= $colis_lie["id"] ?>'>Cette commande est rattachée à un colis, cliquez ici pour le traiter</a>
                <?php
                }
                ?>
            </div>
        </div>

        <input id="idWish" type="hidden" disabled value="<?= $commande['id']; ?>" />

        <div style="padding: 2rem">

            <button id="annuler_commande" class="btn <?= $commande['statut_2'] == 3 ? "btn-danger" : "btn-primary" ?> update" data-annuler="oui" style="margin-right: 1rem" <?= $commande['statut_2'] == 2 || $commande['statut_2'] == 3 ? "disabled" : "" ?>>
                <?= $commande['statut_2'] == 3 ? "Commande annulée" : "Annuler commande" ?>
            </button>

            <h4 style="color: #ff9900; font-weight: bold;">PRODUITS</h4>
            <button id="new_prix" class="btn btn-primary" style="margin-right: 1rem">
                valider
            </button>

            <!--            max-height: 20vh; overflow-y: auto; scrollbar-color: #ff9900 #dee2e6 ;-->


            <div id="table-wrapper">
                <div id="table-scroll">
                    <form id="form-produits" method='post' action='#' enctype='multipart/form-data'>
                        <input id="id" name="idCommande" type="hidden" value="<?= $commande['id']; ?>" />
                        <table id='Tableau_a2' class="display nowrap table-responsive"
                            style="text-align: center; width: 100%; margin-top: 15px; font-size: 11px" cellpadding="2" cellspacing="2">
                            <thead>
                                <tr>
                                    <th><span class="textthead" style="left: -3px;">Lien du produit
                                            <!--<i class="uk-icon-info-circle" style="color: blue;" title="Hypertexte"></i>-->
                                        </span>
                                    </th>
                                    <th><span class="textthead">Couleur</span></th>
                                    <th><span class="textthead">Taille</span></th>
                                    <th><span class="textthead">Categorie</span></th>
                                    <th><span class="textthead">Quantité</span></th>
                                    <th><span class="textthead">Prix Unitaire TTC €</span></th>
                                    <th><span class="textthead">Prix Unitaire XAF</span></th>
                                    <th><span class="textthead">Total XAF</span></th>
                                    <th><span class="textthead">Disponibilité</span></th>
                                    <th><span class="textthead">Nom du produit</span></th>
                                    <th><span class="textthead">N° de commande site</span></th>
                                    <th><span class="textthead">Réf produit site d'achat</span></th>

                                </tr>
                            </thead>



                            <tbody>

                                <?php
                                ///////////////////////////////SELECT BOUCLE
                                $even_odd_class = '';
                                $req_boucle = $bdd->prepare("SELECT * FROM membres_commandes_details WHERE commande_id=? ORDER BY id DESC");
                                $req_boucle->execute(array($_POST['idaction']));
                                while ($ligne_boucle = $req_boucle->fetch()) {
                                    $even_odd_class = ($even_odd_class == 'even') ? 'odd' : 'even';
                                    if ($ligne_boucle['annule'] == 'oui') {
                                        $alert = "oui";
                                    }
                                ?>



                                    <tr class="line<?= $ligne_boucle['id'] ?> <?= $even_odd_class ?> <?= $ligne_boucle['annule'] == 'oui' ? "annule" : "" ?>">

                                        <td style="text-align: center;">

                                            <div style="display: flex; text-align: center; width: 100%; align-content: center; justify-content: center">
                                                <i class="<?= $ligne_boucle['annule'] == 'oui' ? "uk-icon-check green" : "uk-icon-times red" ?> annuler" style="cursor: pointer; margin-right: 2px" data-id="<?= $ligne_boucle['id'] ?>" data-champ="annule"></i>
                                                <input type="hidden" id="annule_champ<?= $ligne_boucle['id'] ?>" name="annule<?= $ligne_boucle['id'] ?>" value="<?= $ligne_boucle['annule'] ?>" style="width: 2.5rem; height: 2.125rem;">
                                                <a href="<?= $ligne_boucle['url'] ?>" target="_blank" class='product-link'>
                                                    <div class="btn-primary" style="height: 2.125rem; width:4rem; display: inline-block; text-align: center; align-content: center ;white-space: nowrap; vertical-align: middle; border-radius: 4px;">Lien</div>
                                                </a>
                                                <button onclick="copyToClipboard('<?= $ligne_boucle['url'] ?>')"
                                                    title="Copier le lien" style="margin-left: 1rem; height: 2.125rem;">
                                                    <i class="uk-icon-copy"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td style="text-align: center; width: 50px;">

                                            <input type="text" id="couleur" name="couleur<?= $ligne_boucle['id'] ?>" value="<?= $ligne_boucle['couleur'] ?  $ligne_boucle['couleur'] : '-' ?>" style="width: 6rem; height: 2.125rem;">
                                        </td>
                                        <td style="text-align: center; width: 45px; ">

                                            <input type="text" id="taille" name="taille<?= $ligne_boucle['id'] ?>" value="<?= $ligne_boucle['taille'] ? $ligne_boucle['taille'] : '-' ?>" style="width: 6rem; height: 2.125rem; margin-left: .5rem;">
                                        </td>
                                        <td style="text-align: center; ">
                                            <label for="categorie">
                                                <select class="modif_produit" data-id="<?= $ligne_boucle['id'] ?>" data-champ="categorie" style="width: 20rem; padding: 0.5rem; height: 2.125rem;" name="categorie<?= $ligne_boucle['id'] ?>">
                                                    <?php
                                                    $req_boucle2 = $bdd->prepare("SELECT * FROM categories ORDER BY nom_categorie ASC");
                                                    $req_boucle2->execute();
                                                    while ($ligne_boucle2 = $req_boucle2->fetch()) {
                                                    ?>
                                                        <option value="<?= $ligne_boucle2['nom_categorie'] ?>" <?= $ligne_boucle2['nom_categorie'] == $ligne_boucle['categorie'] ? 'selected' : '' ?>>
                                                            <?= $ligne_boucle2['nom_categorie'] ?></option>
                                                    <?php
                                                    }
                                                    $req_boucle2->closeCursor();
                                                    ?>
                                                </select>
                                            </label>
                                        </td>
                                        <td style="text-align: center;">
                                            <input class="line<?= $ligne_boucle['id'] ?> <?= $ligne_boucle['annule'] == 'oui' ? "annule" : "" ?>" type="text" id="quantite" data-id="<?= $ligne_boucle['id'] ?>" data-champ="quantite" name="quantite<?= $ligne_boucle['id'] ?>" value="<?= $ligne_boucle['quantite'] ?>" style="width: 2.5rem; height: 2.125rem;">
                                        </td>
                                        <td style="text-align: center;">
                                            <input type="text" id="<?= $ligne_boucle['id'] ?>-prix_u" class="line<?= $ligne_boucle['id'] ?> <?= $ligne_boucle['annule'] == 'oui' ? "annule" : "" ?>" name="prix_u" value="<?= round($ligne_boucle['prix'] * 0.00152449, 2); ?>" style="height: 2.125rem; width: 6rem;" disabled>
                                            <button type="button" onclick="copyPrice('<?= $ligne_boucle['id'] ?>-prix_u', '<?= $ligne_boucle['id'] ?>-prix_r')" style="width:2rem;" class="btn-primary">
                                                <i class="uk-icon-eur"></i>
                                            </button>
                                        </td>
                                        <td style="text-align: center;">
                                            <input type="text" id="<?= $ligne_boucle['id'] ?>-prix_u_xaf" class="line<?= $ligne_boucle['id'] ?> <?= $ligne_boucle['annule'] == 'oui' ? "annule" : "" ?>" name="prix_u_xaf" value="<?= number_format($ligne_boucle['prix'], 0, '.', ' '); ?>" disabled style="height: 2.125rem; width: 6rem;">
                                        </td>
                                        <td style="text-align: center;">
                                            <input type="text" id="total_xaf" class="line<?= $ligne_boucle['id'] ?> <?= $ligne_boucle['annule'] == 'oui' ? "annule" : "" ?>" name="total_xaf" value="<?= number_format($ligne_boucle['prix'] * $ligne_boucle['quantite'], 0, '.', ' ') ?>" disabled style="height: 2.125rem; width: 6rem;">
                                        </td>

                                        <td style="text-align: center;">
                                            <label for="disponibilite">
                                                <select style="padding: 0.5rem; height: 2.125rem;" class="modif_produit <?= $ligne_boucle['annule'] == 'oui' ? "annule" : "remplir" ?>" name="disponibilite<?= $ligne_boucle['id'] ?>" data-champ="disponibilite" data-id="<?= $ligne_boucle['id'] ?>">
                                                    <option></option>
                                                    <option value="Disponible" <?= $ligne_boucle['disponibilite'] == 'Disponible' ? "selected" : "" ?>>Disponible</option>
                                                    <option value="Non disponible" <?= $ligne_boucle['disponibilite'] == 'Non disponible' ? "selected" : "" ?>>Non disponible</option>
                                                    <option value="Annulé" <?= $ligne_boucle['disponibilite'] == 'Annulé' ? "selected" : "" ?>>Annulé</option>

                                                </select>
                                            </label>
                                        </td>
                                        <td style="text-align: center;">
                                            <label for="nom_produit"> </label>
                                            <input class="modif_produit <?= $ligne_boucle['annule'] == 'oui' ? "annule" : "remplir" ?>" type="text" id="nom_produit" data-id="<?= $ligne_boucle['id'] ?>" data-champ="nom" name="nom<?= $ligne_boucle['id'] ?>" value="<?= $ligne_boucle['nom'] ?>" style="height: 2.125rem;">

                                        </td>
                                        <td style="text-align: center;">
                                            <label for="num_commande_site"> </label>
                                            <input class="modif_produit" type="text" id="num_commande_site" data-id="<?= $ligne_boucle['id'] ?>" data-champ="num_commande_site" name="num_commande_site<?= $ligne_boucle['id'] ?>" value="<?= $ligne_boucle['num_commande_site'] ?>" style="height: 2.125rem; width: 12rem;">

                                        </td>
                                        <td style="text-align: center;">
                                            <label for="ref_produit_site_achat"></label>
                                            <input class="modif_produit" type="text" id="ref_produit_site_achat" data-id="<?= $ligne_boucle['id'] ?>" data-champ="ref_produit_site" name="ref_produit_site<?= $ligne_boucle['id'] ?>" value="<?= $ligne_boucle['ref_produit_site'] ?>" style="height: 2.125rem; width: 12rem;">

                                        </td>

                                    </tr>

                                    <tr class="line<?= $ligne_boucle['id'] ?> <?= $even_odd_class ?> <?= $ligne_boucle['annule'] == 'oui' ? "annule" : "" ?>" style="border-bottom: 1px solid black;">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <b>Prix Réel</b>
                                        </td>
                                        <td style="text-align: center;">
                                            <input class="modif_produit <?= $ligne_boucle['annule'] == 'oui' ? "annule" : "remplir" ?>" type="text" id="<?= $ligne_boucle['id'] ?>-prix_r" data-id="<?= $ligne_boucle['id'] ?>" data-champ="prix_reel" name="prix_reel<?= $ligne_boucle['id'] ?>" value="<?= round($ligne_boucle['prix_reel'] * 0.00152449, 2); ?>" style="width: 6rem;">
                                        </td>
                                        <td style="text-align: center;">
                                            <input class="line<?= $ligne_boucle['id'] ?> <?= $ligne_boucle['annule'] == 'oui' ? "annule" : "" ?>" type="text" id="prix_r_xaf" name="prix_r_xaf" value="<?= number_format($ligne_boucle['prix_reel'], 0, '.', ' '); ?>" disabled style="width: 6rem;">
                                        </td>
                                        <td style="text-align: center;">
                                            <input class="line<?= $ligne_boucle['id'] ?> <?= $ligne_boucle['annule'] == 'oui' ? "annule" : "" ?>" type="text" id="prix_r_fcfa" name="prix_r_fcfa" value="<?= number_format(round(($ligne_boucle['prix_reel']) * $ligne_boucle['quantite']), 0, '.', ' '); ?>" disabled style="width: 6rem">
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>

                                    </tr>

                                <?php
                                }
                                $req_boucle->closeCursor();

                                $sous_total = $commande['sous_total'];

                                $prix_total = $commande['prix_total'];



                                if ($commande['douane_a_la_liv'] == 'oui') {
                                    $prix_expedition = $commande['dette_montant'];
                                    $prix_total = $prix_total + $commande['dette_montant'];
                                } else {
                                    $prix_expedition = $commande['prix_expedition'];
                                }


                                ?>
                            </tbody>

                        </table>
                    </form>
                </div>

                <div>
                    <?= $commande['comment'] ? 'Commantaire : ' . $commande['comment'] : ''; ?>
                </div>
            </div>
            <br>
            <b>
                <div>
                    Total des produits : <?= number_format($sous_total, 0, '.', ' '); ?> F CFA
                    (<?= round($sous_total * 0.00152449, 2); ?>€)
                </div>

                <div>
                    Frais de livraison : <?= number_format($commande['frais_livraison'], 0, '.', ' '); ?> F CFA
                    (<?= round($commande['frais_livraison'] * 0.00152449, 2); ?>€)
                </div>

                <div>
                    Frais de gestion : <?= number_format($commande['frais_gestion'], 0, '.', ' '); ?> F CFA
                    (<?= round($commande['frais_gestion'] * 0.00152449, 2); ?>€)
                </div>


                <div>
                    TVA : <?= number_format($commande['tva'], 0, '.', ' '); ?> F CFA
                    (<?= round($commande['tva'] * 0.00152449, 2); ?>€)
                </div>

                <div>
                    Douane et transport : <?= number_format($prix_expedition, 0, '.', ' '); ?> F CFA
                    (<?= round($prix_expedition * 0.00152449, 2); ?>€)
                </div>

                <div>
                    Total de la commande : <?= number_format($prix_total, 0, '.', ' '); ?> F CFA
                    (<?= round($prix_total * 0.00152449, 2); ?>€)
                </div>


                <?php if (!is_null($commande['frais_gestion_pf_total'])): ?>
                    <div>
                        Frais de gestion PF total : <?= number_format($commande['frais_gestion_pf_total'], 0, '.', ' '); ?> F CFA
                        (<?= round($commande['frais_gestion_pf_total'] * 0.00152449, 2); ?>€)
                    </div>
                <?php endif; ?>

            </b>
            <br>
        </div>




        <div style="border-top: 1px solid #dddddd; padding: 2rem">
            <h4 style="color: #ff9900; font-weight: bold;">SUIVI DE LA COMMANDE</h4>

            <div class="suivi-commande" style="display: flex;">
                <div class="commande-etape1" style=" padding-left: 1rem; padding-right: 2rem;">
                    <div style="padding-right: 2rem; border-right: 1px solid #dfdfdf;">
                        <div style="display: flex; ">
                            <div>
                                <label for="statut_2" style="font-weight: normal;">Etape1 : Suivi achat</label>
                                <select id="statut_2" name="statut_2" class="form-control">
                                    <option value=""></option>
                                    <?php
                                    $req_boucle = $bdd->prepare("SELECT * FROM configurations_suivi_achat where type=1");
                                    $req_boucle->execute();
                                    while ($ligne_boucle = $req_boucle->fetch()) {
                                    ?>
                                        <option value="<?= $ligne_boucle['id'] ?>" <?php if ($commande['statut_2'] == $ligne_boucle['id']) { ?> selected <?php } ?>><?= $ligne_boucle['nom_suivi'] ?></option>
                                    <?php
                                    }
                                    $req_boucle->closeCursor();
                                    ?>
                                </select>
                            </div>

                            <div style="margin-left: 1rem">
                                <label for="statut_expedition" style="font-weight: normal;">Etape 2 : Suivi expédition</label> <select
                                    id="statut_expedition" name="statut_expedition" class="form-control">
                                    <option value=""></option>
                                    <?php
                                    $req_boucle = $bdd->prepare("SELECT * FROM configurations_suivi_expedition");
                                    $req_boucle->execute();
                                    while ($ligne_boucle = $req_boucle->fetch()) {
                                    ?>
                                        <option value="<?= $ligne_boucle['id'] ?>" <?php if ($commande['statut_expedition'] == $ligne_boucle['id']) { ?> selected <?php } ?>><?= $ligne_boucle['nom_suivi'] ?></option>
                                    <?php
                                    }
                                    $req_boucle->closeCursor();
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div style="margin-top: 6rem">
                            <label for="message" style="font-weight: normal;">Messages prédéfinis</label>
                            <select id="message" name="message" class="form-control">
                                <option value=""></option>
                                <?php
                                $req_boucle = $bdd->prepare("SELECT * FROM configurations_messages_predefini where type is null");
                                $req_boucle->execute();
                                while ($ligne_boucle = $req_boucle->fetch()) {
                                ?>
                                    <option value="<?= $ligne_boucle['id'] ?>" <?php if ($commande['message'] == $ligne_boucle['id']) { ?> selected <?php } ?>><?= $ligne_boucle['message'] ?></option>
                                <?php
                                }
                                $req_boucle->closeCursor();
                                ?>
                            </select>
                        </div>
                    </div>

                    <div style="margin-top: 5rem; display: flex; flex-direction: column; justify-content: flex-end; padding-right: 2rem;">
                        <div style="display: flex; align-items: center; justify-content: flex-end">
                            <label for="reduction" style="margin-right: 1rem; font-weight: normal;">Réduction</label>
                            <input class="form-control" type="text" name="reduction" value="<?= $commande['prix_reduction'] ?>" id="reduction" style="width: 10rem;" disabled>
                        </div>

                        <div style="display: flex; justify-content: flex-end; align-items: flex-start; margin-top: 1rem;">
                            <p style="margin-right: 1rem; font-weight: normal;">Douane à la livraison</p>
                            <input type="radio" id="oui" name="douane_a_la_livraison" value="oui" style="margin-left: 1rem" <?php echo $commande['douane_a_la_liv'] == 'oui' ? 'checked' : ''; ?> disabled>
                            <label for="oui" style="margin-left:0.5rem; font-weight: normal;">Oui</label>
                            <input type="radio" id="non" name="douane_a_la_livraison" value="non" style="margin-left: 1rem" <?php echo $commande['douane_a_la_liv'] != 'oui' ? 'checked' : ''; ?> disabled>
                            <label for="non" style="margin-left:0.5rem; font-weight: normal;">Non</label><br>
                        </div>

                        <div style="display: flex; justify-content: flex-end; margin-top: 1rem;">
                            <label for="prix_expedition" style="margin-right: 1rem; font-weight: normal;">Montant de la douane et transport</label>
                            <input class="form-control" type="text" name="prix_expedition" id="prix_expedition" style="width: 10rem;" value=" <?php echo $commande['douane_a_la_liv'] == 'oui' ? $commande['dette_montant'] : $commande['prix_expedition']; ?>" disabled>
                        </div>

                        <div style="display: flex; align-items: center; justify-content: flex-end; margin-top: 5rem;">
                            <label for="montant_a_payer" style="margin-right: 1rem; font-weight: normal;">Montant à payer</label>
                            <input class="form-control" type="text" name="montant_a_payer" id="montant_a_payer" style="width: 10rem;" value="<?= number_format($prix_total, 0, '.', ' ') ?>" disabled>
                        </div>
                    </div>




                </div>
                <div class="commentaire-livraison" style=" padding-left: 5rem; padding-right: 2rem;">
                    <div>
                        <label for="commentaire_livraison" style="font-weight: normal;">Commentaire livraison</label>
                        <br>
                        <textarea class="form-control" style="width: 100%; height: 15rem; resize: none" name="commentaire_livraison" id="commentaire_livraison"><?= $commande['commentaire_livraison']; ?></textarea>
                    </div>


                    <div style="margin-top: 5rem;">

                        <div style="display: flex; align-items: center">
                            <label for="code_de_reduction" style="margin-right: 1rem; font-weight: normal;">Code de réduction</label>
                            <input class="form-control" type="text" value="<?= $commande['code_promo'] ?>" name="code_de_reduction" id="code_de_reduction" style="width: 10rem;" disabled>
                        </div>

                        <div class="suivi-kg" style="display: flex;flex-wrap: wrap; margin-top: 11rem; align-content: center; ">

                            <div class="margin-kg" style="margin-right: 1rem">
                                <label for="nombre_de_kg" style="font-weight: normal;">Nombre de Kg</label>
                                <input class="form-control" type="text" value="<?= $commande['poids'] ?>" name="poids" id="poids" style="width: 10rem;">
                            </div>
                            <div class="margin-kg" style="margin-right: 5rem">
                                <label for="prix_du_kg" style="font-weight: normal;">Prix du Kg</label>
                                <input class="form-control" type="text" value="<?= round($prix_kilo_colis / 0.00152449) ?>" name="prix_du_kg" id="prix_du_kg" style="width: 10rem;" disabled>
                            </div>
                            <div class="margin-kg" style="margin-right: 1rem">
                                <label for="douane_et_transport_reel" style="font-weight: normal;">Douane et transport réel</label>
                                <input class="form-control" type="text" name="douane_et_transport_reel" value="" id="douane_et_transport_reel" style="width: 10rem;" disabled>
                            </div>
                            <div>
                                <label for="ecart" style="font-weight: normal;">Ecart</label>
                                <input class="form-control" type="text" name="ecart" id="ecart" value="" style="width: 10rem;" disabled>
                            </div>
                        </div>


                    </div>


                </div>



                <div class="voir-facture" style=" display: flex; flex-direction: column; justify-content: center; align-content: center; align-items: center">
                    <?php
                    $req_facture = $bdd->prepare("SELECT * FROM membres_prestataire_facture WHERE id_commande=?");
                    $req_facture->execute(array($commande['id']));
                    $facture = $req_facture->fetch();
                    $req_facture->closeCursor();

                    if ($facture && $facture['statut'] == "Activée") {
                        $reference_numero = $facture['REFERENCE_NUMERO'];
                        echo '
                                    <a class="btn btn-primary button-feacture" style="height: 4rem;" href="/facture/' . $reference_numero . '/' . $nomsiteweb . '">
                                        Voir la facture
                                    </a>
                                 ';
                    }
                    ?>

                    <div class="dates input-expedition" style="align-content: center; justify-content: space-around;">
                        <div style="margin-right: 1rem">
                            <label for="lot_expedition" style="font-weight: normal;">Lot d'expédition</label>
                            <input class="form-control" type="text" value="<?= $commande['lot_expedition'] ?>" name="lot_expedition" id="lot_expedition" style="width: 10rem;">
                        </div>
                        <div>
                            <?php
                            if ($commande['date_envoi'] != null) {
                                $date_envoi = date('Y-m-d', $commande['date_envoi']);
                            }
                            ?>
                            <label for="date_envoi" style="font-weight: normal;">Date d'envoi</label>
                            <input class="form-control" type="date" value="<?= $date_envoi ?>" name="date_envoi" id="date_envoi" style="width: 14rem;">
                        </div>

                    </div>
                </div>
            </div>


        </div>

        <div style="border-top: 1px solid #dddddd; padding: 2rem;">
            <h4 style="color: #ff9900; font-weight: bold;">MODE DE LIVRAISON ET PAIEMENT</h4>

            <div class="paiement">
                <div class="paiement-element" style="border-right: 1px solid #dfdfdf; padding-left: 1rem; padding-right: 2rem;">
                    <h5 style="font-weight: bold;">Mode de livraison</h5>


                    <?php

                    $sql_select = $bdd->prepare('SELECT * from configurations_livraisons_gabon WHERE id=?');
                    $sql_select->execute(array(intval($commande['id_livraison'])));
                    $livraison = $sql_select->fetch();
                    $sql_select->closeCursor();

                    $sql_all = $bdd->prepare("SELECT * FROM `configurations_livraisons_gabon` WHERE `activer` = ?");
                    $sql_all->execute(array('oui'));

                    while ($row = $sql_all->fetch()) {
                        $checked = ($row['id'] == $livraison['id']) ? 'checked' : '';
                        echo '<input type="radio" id="' . $row['id'] . '" name="mode_de_livraison" value="' . $row['nom_livraison'] . '" ' . $checked . ' disabled>';
                        echo '<label for="' . $row['id'] . '" style="font-weight:normal; margin-left:0.5rem;">' . $row['nom_livraison'] . '</label><br>';
                    }
                    $sql_all->closeCursor();
                    ?>
                </div>


                <div class="paiement-element2" style="padding-left: 2rem; padding-right: 2rem; border-right: 1px solid #dfdfdf;">
                    <h5 style="font-weight: bold">Mode de paiement</h5>


                    <?php

                    $sql_select = $bdd->prepare('SELECT * from configurations_modes_paiement WHERE id=?');
                    $sql_select->execute(array(intval($commande['id_paiement'])));
                    $paiement = $sql_select->fetch();
                    $sql_select->closeCursor();

                    $sql_all = $bdd->prepare("SELECT * FROM `configurations_modes_paiement` WHERE `statut_mode` = ?");
                    $sql_all->execute(array('oui'));

                    while ($row = $sql_all->fetch()) {
                        $checked = ($row['id'] == $paiement['id']) ? 'checked' : '';
                        echo '<input type="radio" id="' . $row['id'] . '" name="mode_de_paiement" value="' . $row['nom_mode'] . '" ' . $checked . ' disabled>';
                        echo '<label for="' . $row['id'] . '" style="font-weight:normal; margin-left:0.5rem;">' . $row['nom_mode'] . '</label><br>';
                    }
                    $sql_all->closeCursor();
                    ?>

                </div>


                <div class="paiement-element2" style="padding-left: 2rem; padding: auto; border-right: 1px solid #dfdfdf;">
                    <h5 style="font-weight: bold;">En plusieurs fois</h5>


                    <?php

                    $sql_select = $bdd->prepare('SELECT * from configurations_modes_paiement_plusieurs_fois WHERE id=?');
                    $sql_select->execute(array(
                        intval($commande['id_paiement_pf'])
                    ));
                    $paiement = $sql_select->fetch();
                    $sql_select->closeCursor();

                    $sql_all = $bdd->prepare("SELECT * FROM `configurations_modes_paiement_plusieurs_fois`");
                    $sql_all->execute();

                    while ($row = $sql_all->fetch()) {
                        $checked = ($row['id'] == $paiement['id']) ? 'checked' : '';
                        echo '<input type="radio" id="' . $row['id'] . '" name="plusieurs_fois" value="' . $row['nom'] . '" ' . $checked . ' disabled>';
                        echo '<label for="' . $row['id'] . '" style="font-weight:normal; margin-left:0.5rem;">' . $row['nom'] . '</label><br>';
                    }
                    $sql_all->closeCursor();
                    ?>

                </div>
                <div style="padding-left: 2rem; padding-right: 1rem;">
                    <div class="adresse">
                        <div style='text-align: left;'>
                            <h5 style="margin-bottom: 1rem; font-weight: bold;">Adresse de facturation</h5>
                            <div id="text-fac" style="border: #80808070 1px solid;  padding: 1rem; width: 25rem; min-height: 120px; max-height: 150px;">
                                <?= nl2br($commande['adresse_fac'])  ?>

                            </div>
                            <textarea style="display: none; border: #80808070 1px solid;  padding: 1rem; width: 25rem; min-height: 120px; max-height: 150px;" name="" id="adresse_fac"><?= str_replace("<br>", "\n", $commande['adresse_fac']) ?></textarea>
                            <div style="display: flex; align-content: center; justify-content: flex-end; margin-top: 1rem;">
                                <button class="btn btn-primary modif-fac">
                                    Modifier
                                </button>
                            </div>
                        </div>
                        <div style='text-align: left; margin-left: 2rem; '>
                            <h5 style="margin-bottom: 1rem; font-weight:bold;">Adresse de livraison</h5>
                            <div id="text-liv" style="border: #80808070 1px solid;  padding: 1rem; width: 25rem; min-height: 120px; max-height: 150px;">
                                <?= nl2br($commande['adresse_liv'])   ?>
                            </div>
                            <textarea style="display: none; border: #80808070 1px solid;  padding: 1rem; width: 25rem; min-height: 120px; max-height: 150px;" name="" id="adresse_liv"><?= str_replace("<br>", "\n", $commande['adresse_liv']) ?></textarea>
                            <div style="display: flex; align-content: center; justify-content: flex-end; margin-top: 1rem;">
                                <button class="btn btn-primary modif-liv">
                                    Modifier
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <br>

        </div>
        <div style="border-top: 1px solid #dddddd; padding: 2rem;">
            <h4 style="color: #ff9900; font-weight: bold;">SUIVI DES ENCAISSEMENTS ET DES REMBOURSEMENTS</h4>

            <div class="remboursement">

                <div class="encaissement">
                    <h5 style="font-weight: bold">Encaissement</h5>
                    <div class="remboursement">

                        <div>
                            <div style="display: flex; align-items: center; justify-content: flex-end; margin-bottom: 1rem;">
                                <label for="montant_a_payer" style="margin-right: 1rem; font-weight: normal;">Montant à payer</label>
                                <input class="form-control" type="text" name="montant_a_payer" id="montant_a_payer" style="width: 10rem; margin-right: 1rem;" value=" <?= number_format($prix_total, 0, '.', ' ') ?> " disabled>
                            </div>

                            <div style="display: flex; align-items: center; justify-content: flex-end;">
                                <label for="montant_paye_client" style="margin-right: 1rem; font-weight: normal;">Montant payé par le client :</label>
                                <input class="form-control" type="text" name="montant_paye_client" id="montant_paye_client" value="<?= number_format($commande['montant_paye_client'] ? $commande['montant_paye_client'] : 0, 0, '.', ' ') ?>" style="width: 10rem; margin-right: 1rem;" disabled>
                            </div>

                        </div>

                        <div style="margin-left: 10rem">
                            <div style='display: flex; align-items: center; justify-content: flex-end; margin-bottom: 1rem;'>
                                <label for="total_a_regulariser" style="margin-right: 1rem; font-weight: normal;">Total à régulariser</label>
                                <input class="form-control" disabled type="text" name="total_a_regulariser" value="<?= number_format(!empty($commande['prix_total_reel']) ? $commande['prix_total_reel'] - $commande['montant_paye_client'] : $prix_total - $commande['montant_paye_client'], 0, '.', ' ') ?>" id="total_a_regulariser" style="width: 10rem; margin-right: 1rem;">
                            </div>


                            <div style='display: flex; align-items: center; justify-content: flex-end;'>
                                <label for="restant_payer" style="margin-right: 1rem; font-weight: normal;">Restant à payer</label>
                                <input class="form-control" type="text" name="restant_payer" id="restant_payer" value="<?= number_format($commande['restant_payer'], 0, '.', ' ') ?>" style="width: 10rem; margin-right: 1rem;">
                            </div>

                        </div>
                    </div>
                    <div class="remboursement" style=" margin-top: 3rem;">
                        <div>
                            <div style='display: flex; align-items: center; justify-content: flex-end; margin-top: 1rem;'>
                                <label for="montant_recu" style="font-weight: normal; margin-right: 1rem;">Montant reçu</label>
                                <input class="form-control" type="text" name="montant_recu" id="montant_recu" style="width: 10rem; margin-right: 1rem;">
                            </div>

                            <div style="display: flex; align-items: center; justify-content: flex-end; margin-top: 1rem;">
                                <label for="moyen_d_encaissement" style="font-weight: normal; margin-right: 1rem;">Moyen d'encaissement : </label>
                                <select name="moyen_d_encaissement" id="moyen_d_encaissement" style="width: 10rem; margin-right: 1rem;" class="form-control">
                                    <option value=""></option>
                                    <option value="Espèces">Espèces</option>
                                    <option value="Chèque">Chèque</option>
                                    <option value="Airtel money">Airtel money</option>
                                    <option value="Flooz">Flooz</option>
                                    <option value="MobiCash">MobiCash</option>
                                    <option value="PayPal">PayPal</option>
                                    <option value="CB">CB</option>
                                </select>
                            </div>

                            <div style="display: flex; align-items: center; justify-content: flex-end; margin-top: 1rem;">
                                <label for="type_d_encaissement" style="font-weight: normal; margin-right: 1rem;">Type d'encaissement : </label>
                                <select name="type_d_encaissement" id="type_d_encaissement" style="width: 10rem; margin-right: 1rem;" class="form-control">
                                    <option value=""></option>
                                    <option value="Comptant">Comptant</option>
                                    <option value="60 %">60 %</option>

                                    <option value="2 fois">2 fois</option>
                                    <option value="3 fois">3 fois</option>
                                </select>
                            </div>
                        </div>
                        <div style="margin-left: 5rem">
                            <div style='display: flex; align-items: center; justify-content: flex-end; margin-top: 1rem;'>
                                <label for="date_de_reception" style="font-weight: normal; margin-right: 1rem;">Date de réception</label>
                                <input class="form-control" type="date" name="date_de_reception" id="date_de_reception" style="width: 14rem; margin-right: 1rem;">
                            </div>

                            <div style="display: flex; align-items: center; justify-content: flex-end; margin-top: 1rem;">
                                <label for="statut_paiement" style="font-weight: normal; margin-right: 1rem;">Statut de paiement : </label>
                                <select name="statut_paiement" id="statut_paiement" style="width: 14rem; margin-right: 1rem;" class="form-control">
                                    <option value=""></option>
                                    <option value="Paiement en attente" <?= $commande['statut_paiement'] == "Paiement en attente" ? 'selected' : '' ?>>Paiement en attente</option>
                                    <option value="Commande totalement payée" <?= $commande['statut_paiement'] == "Commande totalement payée" ? 'selected' : '' ?>>Commande totalement payée</option>
                                    <option value="Commande partiellement payée" <?= $commande['statut_paiement'] == "Commande partiellement payée" ? 'selected' : '' ?>>Commande partiellement payée</option>
                                    <option value="Défaut de paiement" <?= $commande['statut_paiement'] == "Défaut de paiement" ? 'selected' : '' ?>>Défaut de paiement</option>
                                </select>
                            </div>

                            <div style='display: flex; align-items: center; justify-content: flex-end; margin-top: 1rem;'>
                                <label for="echeance_du" style="font-weight: normal; margin-right: 1rem;">A échéance du : </label>
                                <input class="form-control" type="date" name="echeance_du" id="echeance_du" style="width: 14rem; margin-right: 1rem;">
                            </div>
                        </div>

                        <div style="margin-left: 5rem">
                            <?php if (!empty($commande['id_paiement_pf'])) {
                            ?>
                                <h5 style="font-weight: bold">Echéancier</h5>
                                <div style='display: flex; align-items: center; justify-content: flex-end; margin-top: 1rem;'>
                                    <label for="echeancier1" style="font-weight: normal; margin-right: 1rem;">1er <?= $commande['dette_montant_pf'] ?> </label>
                                    <select id='dette_payee_pf' name='dette_payee_pf' class='form-control' style='width:50%'>
                                        <option value='Payé' <?php if ($commande['dette_payee_pf'] == 'Payé') {
                                                                    echo 'selected';
                                                                } ?>>Payé</option>
                                        <option value='Non payé' <?php if ($commande['dette_payee_pf'] == 'Non payé') {
                                                                        echo 'selected';
                                                                    } ?>>Non payé</option>
                                    </select>
                                    <!--input class="form-control" type="text" name="echeancier1" id="echeancier1" style="width: 10rem; margin-right: 1rem;" disabled-->
                                </div>
                                <div style='display: flex; align-items: center; justify-content: flex-end; margin-top: 1rem;'>
                                    <label for="echeancier2" style="font-weight: normal; margin-right: 1rem;">2e <?= $commande['dette_montant_pf2'] ?> </label>
                                    <select id='dette_payee_pf2' name='dette_payee_pf2' class='form-control' style='width:50%'>
                                        <option value='Payé' <?php if ($commande['dette_payee_pf2'] == 'Payé') {
                                                                    echo 'selected';
                                                                } ?>>Payé</option>
                                        <option value='Non payé' <?php if ($commande['dette_payee_pf2'] == 'Non payé') {
                                                                        echo 'selected';
                                                                    } ?>>Non payé</option>
                                    </select>
                                    <!--input class="form-control" type="text" name="echeancier2" id="echeancier2" style="width: 10rem; margin-right: 1rem;" disabled-->
                                </div>
                                <?php if (!empty($commande['dette_montant_pf3'])) { ?>
                                    <div style='display: flex; align-items: center; justify-content: flex-end; margin-top: 1rem;'>
                                        <label for="echeancier3" style="font-weight: normal; margin-right: 1rem;">3e <?= $commande['dette_montant_pf3'] ?> </label>
                                        <select id='dette_payee_pf3' name='dette_payee_pf3' class='form-control' style='width:50%'>
                                            <option value='Payé' <?php if ($commande['dette_payee_pf3'] == 'Payé') {
                                                                        echo 'selected';
                                                                    } ?>>Payé</option>
                                            <option value='Non payé' <?php if ($commande['dette_payee_pf3'] == 'Non payé') {
                                                                            echo 'selected';
                                                                        } ?>>Non payé</option>
                                        </select>
                                        <!--input class="form-control" type="text" name="echeancier3" id="echeancier3" style="width: 10rem; margin-right: 1rem;" disabled-->
                                    </div>
                            <?php
                                }
                            } ?>

                        </div>
                    </div>
                    <div style='display: flex; align-items: center; margin-top: 5rem;'>
                        <label for="motif_encaissement" style="font-weight: normal; margin-right: 1rem;">Motif : </label>
                        <input class="form-control" type="text" name="motif_encaissement" id="motif_encaissement" value="<?= $commande['motif_encaissement'] ?>" style="width: 20rem; margin-right: 1rem;">
                    </div>

                    <div style="margin-top: 3rem;max-height: 15vh; overflow-y: auto;">
                        <p style="font-weight: bold">Transactions</p>
                        <?php
                        ///////////////////////////////SELECT BOUCLE

                        $req_boucle = $bdd->prepare("SELECT * FROM membres_transactions_commande WHERE id_commande=? AND type=? ORDER BY id DESC");
                        $req_boucle->execute(array($_POST['idaction'], "Paiement"));
                        while ($ligne_boucle = $req_boucle->fetch()) {
                        ?>
                            <p>- Paiement <?= $ligne_boucle['moyen'] ?> <?= $ligne_boucle['mode_encaissement'] ?> <?= $ligne_boucle['telephone_airtel'] ?> de <?= $ligne_boucle['montant'] ?> f cfa réalisé le <?= $ligne_boucle['date'] ?>
                                <?php if (!empty($ligne_boucle['motif'])) { ?>
                                    : <?= $ligne_boucle['motif'] ?>
                                <?php } ?>
                                <?= $ligne_boucle['echeance_du'] ? ", <label style='color: red;'><b> prochaine échéance le " . $ligne_boucle['echeance_du'] . "</b></label>" : '' ?>
                            </p>
                        <?php } ?>
                    </div>
                    <div style="display:flex;margin-top:1rem">
                        <div>
                            <!--button id="paiement_save" class="btn btn-success" style="width: 100px; text-align:center">Enregistrer</button-->
                        </div>
                    </div>
                </div>
                <div style="border-left: 1px solid #dfdfdf; padding-left: 2rem; padding-right: 1rem; display: flex; flex-direction: column; align-items: center;">

                    <h5 style="font-weight: bold">Remboursement</h5>
                    <?php if ($alert == "oui") { ?>
                        <div class="alert alert-danger"><i class="uk-icon-warning"></i> Attention! des articles ont été annulés, veuillez procéder au remboursement si besoin</div>
                    <?php } ?>
                    <div>
                        <div style="display: flex; align-items: center; justify-content: flex-end; margin-bottom: 1rem;">
                            <label for="montant_rembourser" style="margin-right: 1rem; font-weight: normal;">Montant à rembourser</label>
                            <input class="form-control" type="text" name="montant_rembourser" id="montant_rembourser" value="<?= number_format($commande['montant_rembourser'], 0, '.', ' ') ?>" style="width: 14rem; margin-right: 1rem;">
                        </div>

                        <div style="display: flex; align-items: center; justify-content: flex-end; margin-bottom: 1rem;">
                            <label for="restant_rembourser" style="margin-right: 1rem; font-weight: normal;">Restant à rembourser</label>
                            <input class="form-control" type="text" name="restant_rembourser" id="restant_rembourser" value="<?= number_format($commande['restant_rembourser'], 0, '.', ' ') ?>" style="width: 14rem; margin-right: 1rem;">
                        </div>

                        <div style="display: flex; align-items: center; justify-content: flex-end; margin-bottom: 1rem;">
                            <label for="total_rembourse" style="margin-right: 1rem; font-weight: normal;">Total remboursé</label>
                            <input class="form-control" type="text" name="total_rembourse" id="total_rembourse" value="<?= number_format($commande['total_rembourse'], 0, '.', ' ') ?>" style="width: 14rem; margin-right: 1rem;" disabled>
                        </div>
                    </div>

                    <div style="margin-top: 3rem">
                        <div style="display: flex; align-items: center; justify-content: flex-end; margin-bottom: 1rem;">
                            <label for="regulariser" style="margin-right: 1rem; font-weight: normal;">Montant remboursé</label>
                            <input class="form-control" type="text" name="regulariser" id="regulariser" value="<?= isset($commande['regulariser']) ? number_format($commande['regulariser'], 0, '.', ' ') : '' ?>" style="width: 14rem; margin-right: 1rem;">
                        </div>

                        <div style="display: flex; align-items: center; justify-content: flex-end; margin-bottom: 1rem;">
                            <label for="date_rem" style="margin-right: 1rem; font-weight: normal;">Date de remboursement</label>
                            <input class="form-control" type="date" name="date_rem" id="date_rem" style="width: 14rem; margin-right: 1rem;">
                        </div>
                        <div style="display: flex; align-items: center; justify-content: flex-end; margin-bottom: 1rem;">
                            <label for="moyen_de_remboursement" style="font-weight: normal; margin-right: 1rem;">Moyen de remboursement </label>
                            <select name="moyen_de_remboursement" id="moyen_de_remboursement" style="width: 14rem; margin-right: 1rem;" class="form-control">
                                <option value=""></option>
                                <option value="Espèces">Espèces</option>
                                <option value="Chèque">Chèque</option>
                                <option value="Airtel money">Airtel money</option>
                                <option value="Flooz">Flooz</option>
                                <option value="MobiCash">MobiCash</option>
                                <option value="PayPal">PayPal</option>
                                <option value="CB">CB</option>
                            </select>
                        </div>
                        <div style='display: flex; align-items: center; justify-content: flex-end; margin-top: 5rem;'>
                            <label for="motif_remboursement" style="font-weight: normal; margin-right: 1rem;">Motif : </label>
                            <input class="form-control" type="text" name="motif_remboursement" id="motif_remboursement" value="<?= $commande['motif_remboursement'] ?>" style="width: 20rem; margin-right: 1rem;">
                        </div>

                    </div>


                    <div style="margin-top: 3rem">
                        <p style="font-weight: bold">Transactions</p>
                        <?php
                        ///////////////////////////////SELECT BOUCLE

                        $req_boucle = $bdd->prepare("SELECT * FROM membres_transactions_commande WHERE id_commande=? AND type=? ORDER BY id DESC");
                        $req_boucle->execute(array($_POST['idaction'], "Remboursement"));
                        while ($ligne_boucle = $req_boucle->fetch()) {
                        ?>
                            <p>- Remboursement <?= $ligne_boucle['moyen'] ?> de <?= $ligne_boucle['montant'] ?> f cfa réalisé le <?= $ligne_boucle['date'] ?>
                                <?php if (!empty($commande['motif_remboursement'])) { ?>
                                    : <?= $commande['motif_remboursement'] ?>
                                <?php } ?>
                            </p>
                        <?php } ?>
                    </div>
                    <div style="display:flex;margin-top:1rem">
                        <div>
                            <!--button id="remboursement_save" class="btn btn-success" style="width: 100px; text-align:center">Enregistrer</button-->
                        </div>
                    </div>
                </div>
            </div>

            <!--table style='text-align: center; width: 100%;' cellpadding='2' cellspacing='2'>

                <input id="idWish" style="display:none" disabled value="<?= $commande['id']; ?>"/>
                <input id="idMembre" style="display:none" disabled value="<?= $commande['user_id']; ?>"/>

                <tr>

                    <td style='text-align: left; font-weight:bold'>
                        <?php
                        if (!empty($commande['id_paiement_pf'])) {
                            if ($commande['id_paiement_pf'] == '2' || $commande['id_paiement_pf'] == '1' || $commande['id_paiement_pf'] == '4' || $commande['id_paiement_pf'] == '3') {

                                echo $commande['dette_montant_pf'] ?> <select id='dette_payee_pf' name='dette_payee_pf'
                                                                              class='form-control' style='width:50%'>
                                    <option value='Payé' <?php if ($commande['dette_payee_pf'] == 'Payé') {
                                                                echo 'selected';
                                                            } ?>>Payé
                                    </option>
                                    <option value='Non payé' <?php if ($commande['dette_payee_pf'] == 'Non payé') {
                                                                    echo 'selected';
                                                                } ?>>Non payé
                                    </option>
                                </select>
                                <br>
                                <?php echo $commande['dette_montant_pf2'] ?>
                                <select id='dette_payee_pf2' name='dette_payee_pf2' class='form-control' style='width:50%'>
                                    <option value='Payé' <?php if ($commande['dette_payee_pf2'] == 'Payé') {
                                                                echo 'selected';
                                                            } ?>>Payé</option>
                                    <option value='Non payé' <?php if ($commande['dette_payee_pf2'] == 'Non payé') {
                                                                    echo 'selected';
                                                                } ?>>Non payé</option>
                                </select>
                                <br>
                                <?php

                            } elseif ($commande['id_paiement_pf'] == '6' || $commande['id_paiement_pf'] == '5') {

                                echo $commande['dette_montant_pf'] ?>

                                <br>
                                <?php echo $commande['dette_montant_pf2'] ?>
                                <select id='dette_payee_pf2' name='dette_payee_pf2' class='form-control' style='width:50%'>
                                    <option value='Payé' <?php if ($commande['dette_payee_pf2'] == 'Payé') {
                                                                echo 'selected';
                                                            } ?>>Payé</option>
                                    <option value='Non payé' <?php if ($commande['dette_payee_pf2'] == 'Non payé') {
                                                                    echo 'selected';
                                                                } ?>>Non payé</option>
                                </select>
                                <br>
                                <?php echo $commande['dette_montant_pf3'] ?>
                                <select id='dette_payee_pf3' name='dette_payee_pf3' class='form-control' style='width:50%'>
                                    <option value='Payé' <?php if ($commande['dette_payee_pf3'] == 'Payé') {
                                                                echo 'selected';
                                                            } ?>>Payé</option>
                                    <option value='Non payé' <?php if ($commande['dette_payee_pf3'] == 'Non payé') {
                                                                    echo 'selected';
                                                                } ?>>Non payé</option>
                                </select>
                                <br>
                                <?php
                            }
                        }
                                ?>
                    </td>

                </tr>
            </table-->


        </div>

        <div style="border-top: 1px solid #dddddd; padding: 2rem;">
            <h4 style="color: #ff9900; font-weight: bold;">NOTES</h4>
            <div style="display: flex; flex-direction: column">
                <label for="notes">Notes</label>
                <textarea id="notes" name="notes"><?= $commande['notes'] ?></textarea>
            </div>

        </div>


        <!--<div style="border-top: 1px solid #dddddd; padding: 2rem;">
            <h4 style="color: #ff9900; font-weight: bold;">A MODIFIER</h4>

            <table style='text-align: center; width: 100%;' cellpadding='2' cellspacing='2'>



                <tr>
                    <td style='text-align: left; min-width: 120px;'><strong>Statut :</strong></td>
                    <td style='text-align: left;'>
                        <select id="statut" class="form-control" style="width:200px">
                            <option value="4" <?php /*if ($commande['statut'] == "4") { */ ?> selected <?php /*} */ ?>>Payé</option>
                            <option value="5" <?php /*if ($commande['statut'] == "5") { */ ?> selected <?php /*} */ ?>>En attente de paiement</option>
                            <option value="6" <?php /*if ($commande['statut'] == "6") { */ ?> selected <?php /*} */ ?>>Terminé</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style='text-align: left; min-width: 120px;'><strong>N°client :</strong></td>
                    <td style='text-align: left;'><?php /*= $client['id']; */ ?></td>
                </tr>
                <tr>
                    <td style='text-align: left; min-width: 120px;'><strong>Client :</strong></td>
                    <td style='text-align: left;'><?php /*= $client['prenom']; */ ?> <?php /*= $client['nom']; */ ?></td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                </tr>
                <?php /*if (!empty($commande['dette_montant'])) { */ ?>
                    <tr>
                        <td style='text-align: left; font-weight:bold'>Dette Frais douane et expédition commande :</td>
                        <td style='text-align: left;'>
                            <?php /*= $commande['dette_montant'] */ ?> CFA
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>

                    <tr>
                        <td style='text-align: left; font-weight:bold'>Dette payée :</td>
                        <td style='text-align: left;'>
                            <select id="dette_payee" class="form-control" style="width:200px">
                                <option value="oui" <?php /*if ($commande['dette_payee'] == "oui") { */ ?> selected <?php /*} */ ?>>
                                    Oui
                                </option>
                                <option value="non" <?php /*if ($commande['dette_payee'] == "non") { */ ?> selected <?php /*} */ ?>>
                                    Non
                                </option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                <?php /*} */ ?>

                <?php /*if ($commande['statut'] == 4) { */ ?>
                    <tr>
                        <td style='text-align: left; font-weight:bold'>Régulation :</td>
                        <td style='text-align: left;'>
                            <div class="form-group" style="display:flex">
                                <div class="input-group" style="width:200px">
                                    <input id="regul" type="number" value="<?php /*= $regulation['prix'] */ ?>" class="form-control"
                                           style="width:175px,border-top-right-radius:0px;border-bottom-right-radius:0px"/>
                                    <label for="regul" class="input-group-addon"
                                           style="border-top-left-radius:0px;border-bottom-left-radius:0px">€</label>
                                </div>
                                <button id="sendRegul" class="btn btn-warning" style="margin-left:1rem">Envoyer la
                                    régulation
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php /*} else if ($commande['statut'] == 5) {
                    $sql_select = $bdd->prepare("SELECT * FROM membres_regulation WHERE id_membre=? AND id_commande=?");
                    $sql_select->execute(array(htmlspecialchars($commande['user_id']), htmlspecialchars($commande['id'])));
                    $regulation = $sql_select->fetch();
                    $sql_select->closeCursor();
                    */ ?>
                    <input id="idRegul" style="display:none" disabled value="<?php /*= $commande['id_regulation']; */ ?>"/>

                    <tr>
                        <td style='text-align: left; font-weight:bold'>Régulation :</td>
                        <td style='text-align: left;'>
                            <div class="form-group" style="display:flex">
                                <div class="input-group" style="width:200px">
                                    <input id="regul" type="number" value="<?php /*= $regulation['prix'] */ ?>" class="form-control"
                                           style="width:175px,border-top-right-radius:0px;border-bottom-right-radius:0px"/>
                                    <label for="regul" class="input-group-addon"
                                           style="border-top-left-radius:0px;border-bottom-left-radius:0px">€</label>
                                </div>
                                <button id="updateRegul" class="btn btn-warning" style="margin-left:1rem">Modifier la
                                    régulation
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php /*} */ ?>
            </table>
        </div>-->



        <div class="button-modifier" style="display:flex;margin-top:1rem ">
            <div>
                <button id="update" class="btn btn-success update " style="width: 100px; text-align:center">Modifier</button>
            </div>
        </div>




    </div>

<?php } else {
    header('location: /index.html');
}

ob_end_flush();
?>

<script>
    function openAllProductLinks() {
        const productLinks = document.getElementsByClassName('product-link');

        for (let i = 0; i < productLinks.length; i++) {
            window.open(productLinks[i].href);
        }
    }

    function copyToClipboard(text) {
        var textarea = document.createElement("textarea");
        textarea.textContent = text;
        textarea.style.position = "fixed";
        document.body.appendChild(textarea);
        textarea.select();
        try {
            var successful = document.execCommand("copy");
            if (successful) alert('Le lien a été copié dans le presse-papiers');
            else throw new Error('La copie du lien a échoué');
        } catch (ex) {
            console.warn("Copy to clipboard failed.", ex);
            return false;
        } finally {
            document.body.removeChild(textarea);
        }
    }

    function copyPrice(idPrixU, idPrixR) {
        var prix_u = document.getElementById(idPrixU).value;
        document.getElementById(idPrixR).value = prix_u;
    }

    function douane() {
        if ($('#ecart').val() > 0) {
            $('#ecart').css('border-color', 'green');
            $('#ecart').css('color', 'green');
        } else {
            $('#ecart').css('border-color', 'red');
            $('#ecart').css('color', 'red');
        }
    }

    douane()
</script>