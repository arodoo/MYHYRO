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
    $sql_select = $bdd->prepare('SELECT * from membres_colis WHERE id=?');
    $sql_select->execute(array(
        intval($_POST['idaction'])
    ));
    $colis = $sql_select->fetch();
    $sql_select->closeCursor();

    $sql_select = $bdd->prepare('SELECT * from membres_commandes WHERE panier_id=?');
    $sql_select->execute(array(
        $colis['panier_id']
    ));
    $commande_lie = $sql_select->fetch();
    $sql_select->closeCursor();

    $sql_select = $bdd->prepare('SELECT * from membres WHERE id=?');
    $sql_select->execute(array(
        intval($colis['user_id'])
    ));
    $client = $sql_select->fetch();
    $sql_select->closeCursor();

    $sql_select = $bdd->prepare('SELECT * from configurations_livraisons_gabon WHERE id=?');
    $sql_select->execute(array(
        intval($colis['id_livraison'])
    ));
    $livraison = $sql_select->fetch();
    $sql_select->closeCursor();

    $sql_select = $bdd->prepare('SELECT * from configurations_modes_paiement WHERE id=?');
    $sql_select->execute(array(
        intval($colis['id_paiement'])
    ));
    $paiement = $sql_select->fetch();
    $sql_select->closeCursor();

    $mode_paiement = $paiement['nom_mode'];

    if (empty($paiement['nom_mode'])) {
        $sql_select = $bdd->prepare('SELECT * from configurations_modes_paiement_plusieurs_fois WHERE id=?');
        $sql_select->execute(array(
            intval($colis['id_paiement_pf'])
        ));
        $paiement = $sql_select->fetch();
        $sql_select->closeCursor();

        $mode_paiement = $paiement['nom'];
    }

    $req_select = $bdd->prepare("SELECT * FROM membres WHERE id=?");
    $req_select->execute(array($colis['user_id']));
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

    if ($colis['id_paiement'] == '6') {

        $req_select = $bdd->prepare("SELECT * FROM membres_adresse_liv_france WHERE id_membre=?");
        $req_select->execute(array($colis['user_id']));
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
        FROM membres_colis
        JOIN membres ON membres_colis.user_id = membres.id
        LEFT JOIN configurations_abonnements ON membres.Abonnement_id = configurations_abonnements.id
        WHERE membres_colis.id =?");
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
        $(document).ready(function() {

            $(document).on("click", ".update", function() {
                let idColis = document.getElementById('idWish').value;
                //let statut = document.getElementById('statut').value;
                let statut_2 = document.getElementById('statut').value;
                let message = document.getElementById('message').value;
                let statut_expedition = document.getElementById('statut_expedition').value;
                //let commentaire_livraison = document.getElementById('commentaire_livraison').value;




                let datas = {
                    id: idColis,
                    annuler_colis: $(this).data('annuler'),
                    //statut: statut,
                    statut_2: statut_2,
                    message: message,
                    statut_expedition: statut_expedition,
                    //commentaire_livraison: commentaire_livraison,
                    poids: $('#poids').val(),
                    poids_reel: $('#poids_reel').val(),
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
                    url: '/administration/Modules/Envoyer-colis/Envoyer-colis-action-modifier-ajax.php',
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

            $(document).on("change", ".categorie-prod", function() {
                let type = $(this).find('option:selected').attr('data-type')
                let line = $(this).attr('data-id')
                if (type == 1) {
                    //console.log('.line'+(line-1));
                    $('.line' + (line)).css('display', 'none');
                } else {
                    $('.line' + (line)).css('display', '');
                }
            });

            $(document).on("click", "#new_prix", function() {
                let idColis = document.getElementById('idWish').value;

                const product = document.getElementsByClassName('remplir');
                var valid = true;

                for (let i = 0; i < product.length; i++) {
                    if (!product[i].value) {
                        var valid = false;
                        break;
                    }
                }

                let datas = {
                    id: idColis,
                }

                if (valid) {

                    $.post({
                        url: '/administration/Modules/Envoyer-colis/Envoyer-colis-action-produits-ajax.php',
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
                idColis = document.getElementById('idWish').value;
                idMembre = document.getElementById('idMembre').value;

                datas = {
                    nb: regul,
                    id: idColis,
                    action: "add",
                    idMembre: idMembre
                }

                $.post({
                    url: '/administration/Modules/Envoyer-colis/Envoyer-colis-action-regulation-ajax.php',
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
                idColis = document.getElementById('idWish').value;
                idRegul = document.getElementById('idRegul').value;
                idMembre = document.getElementById('idMembre').value;

                datas = {
                    nb: regul,
                    id: idColis,
                    action: "update",
                    idRegul: idRegul,
                    idMembre: idMembre
                }

                $.post({
                    url: '/administration/Modules/Envoyer-colis/Envoyer-colis-action-regulation-ajax.php',
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

            $(document).on('change', 'select[name^="categorie"]', function() {



                let selectedType = $(this).find('option:selected').attr('type');



                let row = $(this).closest('tr');
                let nextRow = row.next();

                let valeurTTC = row.find('input[id$="-prix_u"]');
                let valeurXAF = row.find('input[id$="-prix_u_xaf"]');
                let totalXAF = row.find('input[name="total_xaf"]');


                let valeurTTCNext = nextRow.find('input[id$="-prix_r"]');
                let valeurXAFNext = nextRow.find('input[name="prix_r_xaf"]');
                let totalXAFNext = nextRow.find('input[name="prix_r_fcfa"]');




                if (selectedType === '1') {
                    valeurTTC.closest('td').css('visibility', 'hidden');
                    valeurXAF.closest('td').css('visibility', 'hidden');
                    totalXAF.closest('td').css('visibility', 'hidden');

                    valeurTTCNext.closest('td').css('visibility', 'hidden');
                    valeurXAFNext.closest('td').css('visibility', 'hidden');
                    totalXAFNext.closest('td').css('visibility', 'hidden');
                } else {
                    valeurTTC.closest('td').css('visibility', 'visible');
                    valeurXAF.closest('td').css('visibility', 'visible');
                    totalXAF.closest('td').css('visibility', 'visible');

                    valeurTTCNext.closest('td').css('visibility', 'visible');
                    valeurXAFNext.closest('td').css('visibility', 'visible');
                    totalXAFNext.closest('td').css('visibility', 'visible');
                }
            });

        });
    </script>

    <style>
        #table-wrapper {
            position: relative;
        }

        #table-scroll {
            /*             height: 150px; */
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
            text-align: center;
        }

        #table-wrapper table thead th .textthead {
            /*position:absolute;*/
            /*top: -2rem;*/
            /*z-index:2;*/
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

        .poids {
            margin-left: 15rem;
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

            .poids {
                margin-left: 0;
            }

            .button-modifier {
                justify-content: center;
            }

        }

        #Tableau_a2 {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 11px;
            text-align: left;

        }

        #Tableau_a2 thead th {
            background-color: #f4f4f4;
            font-weight: bold;
            text-transform: uppercase;
            padding: 10px;
            border-bottom: 2px solid #ddd;
            text-align: left;

        }


        #Tableau_a2 tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }


        #Tableau_a2 tbody tr:nth-child(even) {
            background-color: #fff;
        }


        #Tableau_a2 td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;

        }


        #Tableau_a2 input,
        #Tableau_a2 select {
            padding: 5px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 11px;
            width: 100%;
        }

        #Tableau_a2 button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 4px;
            font-size: 11px;
        }

        #Tableau_a2 button:hover {
            background-color: #0056b3;
        }


        #Tableau_a2 i {
            cursor: pointer;
            margin-right: 5px;
        }

        .uk-icon-check {
            color: green;
        }

        .uk-icon-times {
            color: red;
        }

        /*                 @media only screen and (max-width: 768px) {
                    #Tableau_a2 {
                        font-size: 9px;
                        width: 100%;
                        overflow-x: auto;
                    }

                    #Tableau_a2 thead {
                        display: none;
                      
                    }

                    #Tableau_a2 tr {
                        display: block;
                        margin-bottom: 10px;
                        border-bottom: 2px solid #ddd;
                    }

                    #Tableau_a2 td {
                        display: block;
                        text-align: left;
                        padding: 8px;
                        border-bottom: 1px solid #ddd;
                        white-space: normal;
                    }

                    #Tableau_a2 td:before {
                        content: attr(data-label);
                        font-weight: bold;
                        display: block;
                        margin-bottom: 5px;
                        color: #333;
                    }
                } */
    </style>
    <div class="well well-sm" style="margin-top: 2rem; text-align: left; width: 96vw; position: absolute; top: 40vh; left: 2vw; right: 2vw; ">

        <div class="remboursement" style=" justify-content: space-between; margin-bottom: 2rem">
            <div style="display: flex; flex-direction: column; height: 100%">
                <div>
                    <h2>Colis #<?= $colis['id'] ?></h2>
                    <p>Historique des modifications</p>

                    <div style="max-height: 15vh; overflow-y: auto; scrollbar-color: #ff9900 #dee2e6 ; padding: 1rem 2rem;">
                        <?php
                        ///////////////////////////////SELECT BOUCLE

                        $req_boucle = $bdd->prepare("SELECT * FROM admin_colis_historique WHERE id_colis=? ORDER BY id DESC");
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
            </div>
            <div>

                <div style="background-color: white; max-width: 60rem; border-radius: 1rem; margin-bottom: 10px;">
                    <p style="margin-top: 1rem; margin-left: 1rem"><b>Colis</b></p>
                    <div class="remboursement" style=" align-content: space-between; border-top: 1px solid #dfdfdf; padding: 1rem; margin-top: 1rem">
                        <div style="margin-right: 10rem">
                            <p style="margin-bottom: 3rem">Colis #<?= $colis['id'] ?></p>

                            <p>Date : <?= date('d/m/Y à H \h i \m\i\n', $colis['created_at']) ?></p>
                            <p>Utilisateur : <a href="?page=Membres&action=Modifier&idaction=<?= $id_membre ?>" style="color: #0174aa"><?= $pseudo_membre ?></a> </p>
                            <p>Nom : <?= strtoupper($nom_membre) ?> <?= $prenom_membre ?></p>
                            <p>Type d'abonnement : <?= $abonnement_membre ?></p>
                        </div>
                        <div style="display: inline-block;  align-self: flex-end; ">
                            <p>Numéro de paiement : </p>
                            <p>Attente paiement: </p>
                            <p>Code transaction: xxxxxx</p>
                        </div>
                    </div>


                </div>


                <?php
                if (!empty($commande_lie["id"])) {
                ?>
                    <a href='?page=Commandes&action=Details&idaction=<?= $commande_lie["id"] ?>'>Ce coli est rattaché à une commande, cliquez ici pour la traiter</a>
                <?php
                }
                ?>

            </div>
        </div>

        <input id="idWish" type="hidden" disabled value="<?= $colis['id']; ?>" />

        <div style="padding: 2rem">

            <button id="annuler_colis" class="btn <?= $colis['statut'] == 13 ? "btn-danger" : "btn-primary" ?> update" data-annuler="oui" style="margin-right: 1rem" <?= $colis['statut'] == 2 || $colis['statut'] == 13 ? "disabled" : "" ?>>
                <?= $colis['statut'] == 13 ? "colis annulée" : "Annuler colis" ?>
            </button>

            <h4 style="color: #ff9900; font-weight: bold;">PRODUITS</h4>
            <button id="new_prix" class="btn btn-primary" style="margin-right: 1rem">
                valider
            </button>
            <div class="poids" style=" display: flex;">
                <div>
                    <label for="nombre_de_kg" style="font-weight: normal;">Poids du colis</label>
                    <input class="form-control" type="text" value="<?= $colis['poids'] ?>" name="poids" id="poids" style="width: 10rem;" disabled>
                </div>
                <div style="margin-left: 5rem;">
                    <label for="poids_reel" style="font-weight: normal;">Poids réel</label>
                    <input class="form-control" type="text" value="<?= $colis['poids_reel'] ?>" name="poids_reel" id="poids_reel" style="width: 10rem;">
                </div>

            </div>

            <!--            max-height: 20vh; overflow-y: auto; scrollbar-color: #ff9900 #dee2e6 ;-->




            <div id="table-wrapper">
                <div id="table-scroll">
                    <form id="form-produits" method='post' action='#' enctype='multipart/form-data'>
                        <input id="id" name="idColis" type="hidden" value="<?= $colis['id']; ?>" />
                        <table id='Tableau_a2' class="display nowrap table-responsive"
                            style="text-align: center; width: 100%; margin-top: 15px; font-size: 11px" cellpadding="2" cellspacing="2">
                            <thead>
                                <tr>
                                    <th><span class="textthead" style="text-align: center">Action</span></th>
                                    <th><span class="textthead" style="text-align: center">Categorie</span></th>
                                    <th><span class="textthead" style="text-align: center">Quantité</span></th>
                                    <th><span class="textthead" style="text-align: center">Valeur Unitaire TTC €</span></th>
                                    <th><span class="textthead" style="text-align: center">Valeur Unitaire XAF</span></th>
                                    <th><span class="textthead" style="text-align: center">Total XAF</span></th>
                                    <th><span class="textthead" style="text-align: center">Disponibilité</span></th>
                                    <th><span class="textthead" style="text-align: center">Nom du produit</span></th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                ///////////////////////////////SELECT BOUCLE
                                $even_odd_class = '';
                                $req_boucle = $bdd->prepare("SELECT * FROM membres_colis_details WHERE colis_id=? ORDER BY id DESC");
                                $req_boucle->execute(array($_POST['idaction']));
                                while ($ligne_boucle = $req_boucle->fetch()) {
                                    $even_odd_class = ($even_odd_class == 'even') ? 'odd' : 'even';
                                    if ($ligne_boucle['annule'] == 'oui') {
                                        $alert = "oui";
                                    }
                                    $prix = floatval($ligne_boucle['prix']);
                                    $quantite = intval($ligne_boucle['quantite']);
                                    $prix_reel = floatval($ligne_boucle['prix_reel']);
                                ?>
                                    <tr class="line<?= $ligne_boucle['id'] ?> <?= $even_odd_class ?> <?= $ligne_boucle['annule'] == 'oui' ? "annule" : "" ?>">
                                        <td style="text-align: center;">
                                            <div style="display: flex; text-align: center; width: 100%; align-content: center; justify-content: center">
                                                <i class="<?= $ligne_boucle['annule'] == 'oui' ? "uk-icon-check green" : "uk-icon-times red" ?> annuler" style="cursor: pointer; margin-right: 2px" data-id="<?= $ligne_boucle['id'] ?>" data-champ="annule"></i>
                                                <input type="hidden" id="annule_champ<?= $ligne_boucle['id'] ?>" name="annule<?= $ligne_boucle['id'] ?>" value="<?= $ligne_boucle['annule'] ?>" style="width: 2.5rem; height: 2.125rem;">
                                            </div>
                                        </td>
                                        <td style="text-align: center;">
                                            <label for="categorie">
                                                <select class="modif_produit categorie-prod" data-id="<?= $ligne_boucle['id'] ?>" data-champ="categorie" style="width: 20rem; padding: 0 height: 2.125rem;" name="categorie<?= $ligne_boucle['id'] ?>">
                                                    <?php
                                                    $req_boucle2 = $bdd->prepare("SELECT * FROM categories ORDER BY nom_categorie ASC");
                                                    $req_boucle2->execute();
                                                    while ($ligne_boucle2 = $req_boucle2->fetch()) {
                                                    ?>
                                                        <option value="<?= $ligne_boucle2['nom_categorie'] ?>" type="<?= $ligne_boucle2['type'] ?>" <?= $ligne_boucle2['nom_categorie'] == $ligne_boucle['categorie'] ? 'selected' : '' ?>>
                                                            <?= $ligne_boucle2['nom_categorie'] ?>
                                                        </option>
                                                    <?php
                                                    }
                                                    $req_boucle2->closeCursor();
                                                    ?>
                                                </select>
                                            </label>
                                        </td>
                                        <td style="text-align: center; ">
                                            <input class="line<?= $ligne_boucle['id'] ?> <?= $ligne_boucle['annule'] == 'oui' ? "annule" : "" ?>" type="text" id="quantite" data-id="<?= $ligne_boucle['id'] ?>" data-champ="quantite" name="quantite<?= $ligne_boucle['id'] ?>" value="<?= $quantite ?>" style="width: 2.5rem; height: 2.125rem;">
                                        </td>
                                        <td style="text-align: center; min-width: 144px; ">
                                            <input type="text" id="<?= $ligne_boucle['id'] ?>-prix_u" class="line<?= $ligne_boucle['id'] ?> <?= $ligne_boucle['annule'] == 'oui' ? "annule" : "" ?>" name="prix_u" value="<?= round($prix * 0.00152449, 2); ?>" style="height: 2.125rem; width: 10rem;" disabled>
                                            <button type="button" onclick="copyPrice('<?= $ligne_boucle['id'] ?>-prix_u', '<?= $ligne_boucle['id'] ?>-prix_r')" style="width:2rem;" class="btn-primary">
                                                <i class="uk-icon-eur"></i>
                                            </button>
                                        </td>
                                        <td style="text-align: center; ">
                                            <input type="text" id="<?= $ligne_boucle['id'] ?>-prix_u_xaf" class="line<?= $ligne_boucle['id'] ?> <?= $ligne_boucle['annule'] == 'oui' ? "annule" : "" ?>" name="prix_u_xaf" value="<?= number_format($prix, 0, '.', ' '); ?>" disabled style="height: 2.125rem; width: 10rem;">
                                        </td>
                                        <td style="text-align: center; ">
                                            <input type="text" id="total_xaf" class="line<?= $ligne_boucle['id'] ?> <?= $ligne_boucle['annule'] == 'oui' ? "annule" : "" ?>" name="total_xaf" value="<?= number_format($prix * $quantite, 0, '.', ' ') ?>" disabled style="height: 2.125rem; width: 10rem;">
                                        </td>
                                        <td style="text-align: center; ">
                                            <label for="disponibilite">
                                                <select style="padding: 0; height: 2.125rem;" class="modif_produit <?= $ligne_boucle['annule'] == 'oui' ? "annule" : "remplir" ?>" name="disponibilite<?= $ligne_boucle['id'] ?>" data-champ="disponibilite" data-id="<?= $ligne_boucle['id'] ?>">
                                                    <option></option>
                                                    <option value="Disponible" <?= $ligne_boucle['disponibilite'] == 'Disponible' ? "selected" : "" ?>>Disponible</option>
                                                    <option value="Non disponible" <?= $ligne_boucle['disponibilite'] == 'Non disponible' ? "selected" : "" ?>>Non disponible</option>
                                                </select>
                                            </label>
                                        </td>
                                        <td style="text-align: center; padding-bottom: 3rem; min-width: 123px;">
                                            <label for="nom_produit"> </label>
                                            <input class="modif_produit <?= $ligne_boucle['annule'] == 'oui' ? "annule" : "remplir" ?>" type="text" id="nom_produit" data-id="<?= $ligne_boucle['id'] ?>" data-champ="nom" name="nom<?= $ligne_boucle['id'] ?>" value="<?= $ligne_boucle['nom'] ?>" style="height: 2.125rem;">
                                        </td>
                                    </tr>
                                    <tr class="line<?= $ligne_boucle['id'] ?> <?= $even_odd_class ?> <?= $ligne_boucle['annule'] == 'oui' ? "annule" : "" ?>" style="border-bottom: 1px solid black;">
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <b>Valeur Réel</b>
                                        </td>
                                        <td style="text-align: center;">
                                            <input class="modif_produit <?= $ligne_boucle['annule'] == 'oui' ? "annule" : "remplir" ?>" type="text" id="<?= $ligne_boucle['id'] ?>-prix_r" data-id="<?= $ligne_boucle['id'] ?>" data-champ="prix_reel" name="prix_reel<?= $ligne_boucle['id'] ?>" value="<?= round($prix_reel * 0.00152449, 2); ?>" style="width: 10rem;">
                                        </td>
                                        <td style="text-align: center;">
                                            <input class="line<?= $ligne_boucle['id'] ?> <?= $ligne_boucle['annule'] == 'oui' ? "annule" : "" ?>" type="text" id="prix_r_xaf" name="prix_r_xaf" value="<?= number_format($prix_reel, 0, '.', ' '); ?>" disabled style="width: 10rem;">
                                        </td>
                                        <td style="text-align: center; ">
                                            <input class="line<?= $ligne_boucle['id'] ?> <?= $ligne_boucle['annule'] == 'oui' ? "annule" : "" ?>" type="text" id="prix_r_fcfa" name="prix_r_fcfa" value="<?= number_format(round($prix_reel * $quantite), 0, '.', ' '); ?>" disabled style="width: 10rem;">
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <!-- <td></td>
                                        <td></td> -->
                                    </tr>
                                <?php
                                }
                                $req_boucle->closeCursor();

                                $sous_total = floatval($colis['sous_total']);
                                $prix_total = floatval($colis['prix_total']);

                                if ($colis['douane_a_la_liv'] == 'oui') {
                                    $prix_expedition = floatval($colis['dette_montant']);
                                    $prix_total += floatval($colis['dette_montant']);
                                } else {
                                    $prix_expedition = floatval($colis['prix_expedition']);
                                }
                                ?>
                            </tbody>
                        </table>
                    </form>

                </div>

                <div>
                    <?= $colis['comment'] ? 'Commantaire : ' . $colis['comment'] : ''; ?>
                </div>

            </div>
            <br>
            <div style="display: flex;">

                <div>
                    <b>
                        <!-- <div>
                            Total des produits : <?= number_format($sous_total, 0, '.', ' '); ?> F CFA
                            (<?= round($sous_total * 0.00152449, 2); ?>€)
                        </div>

                        <div>
                            Frais de livraison : <?= number_format($colis['frais_livraison'], 0, '.', ' '); ?> F CFA
                            (<?= round($colis['frais_livraison'] * 0.00152449, 2); ?>€)
                        </div>

                        <div>
                            Frais de gestion : <?= number_format($colis['frais_gestion'], 0, '.', ' '); ?> F CFA
                            (<?= round($colis['frais_gestion'] * 0.00152449, 2); ?>€)
                        </div>


                        <div>
                            TVA : <?= number_format($colis['tva'], 0, '.', ' '); ?> F CFA
                            (<?= round($colis['tva'] * 0.00152449, 2); ?>€)
                        </div>

                        <div>
                            Douane et transport : <?= number_format($prix_expedition, 0, '.', ' '); ?> F CFA
                            (<?= round($prix_expedition * 0.00152449, 2); ?>€)
                        </div> -->

                        <div>
                            Total du colis : <?= number_format($prix_total, 0, '.', ' '); ?> F CFA
                            (<?= round($prix_total * 0.00152449, 2); ?>€)
                        </div>
                    </b>
                </div>

            </div>
            <br>
        </div>


        <div style="border-top: 1px solid #dddddd; padding: 2rem">
            <h4 style="color: #ff9900; font-weight: bold;">SUIVI DU COLIS</h4>

            <div class="suivi-commande" style="display: flex;">
                <div class="commande-etape1" style=" padding-left: 1rem; padding-right: 2rem;">
                    <div style="padding-right: 2rem; border-right: 1px solid #dfdfdf;">
                        <div style="display: flex; ">
                            <div>
                                <label for="statut" style="font-weight: normal;">Etape1 : Suivi achat</label>
                                <select id="statut" name="statut" class="form-control">
                                    <option value=""></option>
                                    <?php
                                    $req_boucle = $bdd->prepare("SELECT * FROM configurations_suivi_achat where type=3");
                                    $req_boucle->execute();
                                    while ($ligne_boucle = $req_boucle->fetch()) {
                                    ?>
                                        <option value="<?= $ligne_boucle['id'] ?>" <?php if ($colis['statut'] == $ligne_boucle['id']) { ?> selected <?php } ?>><?= $ligne_boucle['nom_suivi'] ?></option>
                                    <?php
                                    }
                                    $req_boucle->closeCursor();
                                    ?>
                                </select>
                            </div>

                            <div style="margin-left: 1rem">
                                <label for="statut_expedition" style="font-weight: normal;">Etape 2 : Suivi expédition</label> <select
                                    id="statut_expedition" name="statut_expedition" class="form-control" style="">
                                    <option value=""></option>
                                    <?php
                                    $req_boucle = $bdd->prepare("SELECT * FROM configurations_suivi_expedition where type = 3");
                                    $req_boucle->execute();
                                    while ($ligne_boucle = $req_boucle->fetch()) {
                                    ?>
                                        <option value="<?= $ligne_boucle['id'] ?>" <?php if ($colis['statut_expedition'] == $ligne_boucle['id']) { ?> selected <?php } ?>><?= $ligne_boucle['nom_suivi'] ?></option>
                                    <?php
                                    }
                                    $req_boucle->closeCursor();
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div style="margin-top: 6rem">
                            <label for="message" style="font-weight: normal;">Messages prédéfinis</label>

                            <select id="message" name="message" class="form-control" style="">
                                <option value=""></option>
                                <?php
                                $req_boucle = $bdd->prepare("SELECT * FROM configurations_messages_predefini where type is null");
                                $req_boucle->execute();
                                while ($ligne_boucle = $req_boucle->fetch()) {
                                ?>
                                    <option value="<?= $ligne_boucle['id'] ?>" <?php if ($colis['message'] == $ligne_boucle['id']) { ?> selected <?php } ?>><?= $ligne_boucle['message'] ?></option>
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
                            <input class="form-control" type="text" name="reduction" value="<?= $colis['prix_reduction'] ?>" id="reduction" style="width: 10rem;" disabled>
                        </div>

                        <div style="display: flex; justify-content: flex-end; align-items: flex-start; margin-top: 1rem;">
                            <p style="margin-right: 1rem; font-weight: normal;">Douane à la livraison</p>
                            <input type="radio" id="oui" name="douane_a_la_livraison" value="oui" style="margin-left: 1rem" <?php echo $colis['douane_a_la_liv'] == 'oui' ? 'checked' : ''; ?> disabled>
                            <label for="oui" style="margin-left:0.5rem; font-weight: normal;">Oui</label>
                            <input type="radio" id="non" name="douane_a_la_livraison" value="non" style="margin-left: 1rem" <?php echo $colis['douane_a_la_liv'] != 'oui' ? 'checked' : ''; ?> disabled>
                            <label for="non" style="margin-left:0.5rem; font-weight: normal;">Non</label><br>
                        </div>


                        <div style="display: flex; justify-content: flex-end; margin-top: 1rem;">
                            <label for="prix_expedition" style="margin-right: 1rem; font-weight: normal;">Montant de la douane et transport</label>
                            <input class="form-control" type="text" name="prix_expedition" id="prix_expedition" style="width: 10rem;" value=" <?php echo $colis['douane_a_la_liv'] == 'oui' ? $colis['dette_montant'] : $colis['prix_expedition']; ?>" disabled>
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
                        <textarea class="form-control" style="width: 100%; height: 15rem; resize: none" name="commentaire_livraison" id="commentaire_livraison"><?= $colis['commentaire_livraison']; ?></textarea>
                    </div>


                    <div style="margin-top: 5rem;">

                        <div style="display: flex; align-items: center">
                            <label for="code_de_reduction" style="margin-right: 1rem; font-weight: normal;">Code de réduction</label>
                            <input class="form-control" type="text" value="<?= $colis['code_promo'] ?>" name="code_de_reduction" id="code_de_reduction" style="width: 10rem;" disabled>
                        </div>

                        <div class="suivi-kg" style="display: flex;flex-wrap: wrap; margin-top: 11rem; align-content: center; ">

                            <div class="margin-kg" style="margin-right: 1rem">
                                <label for="nombre_de_kg" style="font-weight: normal;">Nombre de Kg</label>
                                <input class="form-control" type="text" value="<?= $colis['poids'] ?>" name="poids" id="poids" style="width: 10rem;" disabled>
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

                    <button class="btn btn-primary button-feacture" style="height: 4rem;">
                        Voir la facture
                    </button>

                    <div class="dates input-expedition" style="align-content: center; justify-content: space-around;">
                        <div style="margin-right: 1rem">
                            <label for="lot_expedition" style="font-weight: normal;">Lot d'expédition</label>
                            <input class="form-control" type="text" value="<?= $colis['lot_expedition'] ?>" name="lot_expedition" id="lot_expedition" style="width: 10rem;">
                        </div>
                        <div>
                            <?php
                            if ($colis['date_envoi'] != null) {
                                $date_envoi = date('Y-m-d', $colis['date_envoi']);
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
                    $sql_select->execute(array(intval($colis['id_livraison'])));
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
                    $sql_select->execute(array(intval($colis['id_paiement'])));
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
                        intval($colis['id_paiement_pf'])
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
                                <?= nl2br($colis['adresse_fac'])  ?>

                            </div>
                            <textarea style="display: none; border: #80808070 1px solid;  padding: 1rem; width: 25rem; min-height: 120px; max-height: 150px;" name="" id="adresse_fac"><?= str_replace("<br>", "\n", $colis['adresse_fac']) ?></textarea>
                            <div style="display: flex; align-content: center; justify-content: flex-end; margin-top: 1rem;">
                                <button class="btn btn-primary modif-fac">
                                    Modifier
                                </button>
                            </div>
                        </div>
                        <div style='text-align: left; margin-left: 2rem; '>
                            <h5 style="margin-bottom: 1rem; font-weight:bold;">Adresse de livraison</h5>
                            <div id="text-liv" style="border: #80808070 1px solid;  padding: 1rem; width: 25rem; min-height: 120px; max-height: 150px;">
                                <?= nl2br($colis['adresse_liv'])   ?>
                            </div>
                            <textarea style="display: none; border: #80808070 1px solid;  padding: 1rem; width: 25rem; min-height: 120px; max-height: 150px;" name="" id="adresse_liv"><?= str_replace("<br>", "\n", $colis['adresse_liv']) ?></textarea>
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
                                <input class="form-control" type="text" name="montant_paye_client" id="montant_paye_client"
                                    value="<?= number_format($colis['montant_paye_client'] ? $colis['montant_paye_client'] : 0, 0, '.', ' ') ?>"
                                    style="width: 10rem; margin-right: 1rem;" disabled>
                            </div>

                        </div>

                        <div style="margin-left: 10rem">


                            <div style='display: flex; align-items: center; justify-content: flex-end; margin-bottom: 1rem;'>
                                <label for="total_a_regulariser" style="margin-right: 1rem; font-weight: normal;">Total à régulariser</label>
                                <input class="form-control" disabled type="text" name="total_a_regulariser"
                                    value="<?= number_format(!empty($colis['prix_total_reel']) ? $colis['prix_total_reel'] - $colis['montant_paye_client'] : $colis['prix_total'] - $colis['montant_paye_client'], 0, '.', ' ') ?>"
                                    id="total_a_regulariser" style="width: 10rem; margin-right: 1rem;">
                            </div>


                            <div style='display: flex; align-items: center; justify-content: flex-end;'>
                                <label for="restant_payer" style="margin-right: 1rem; font-weight: normal;">Restant à payer</label>
                                <input class="form-control" type="text" name="restant_payer" id="restant_payer"
                                    value="<?= number_format($colis['restant_payer'], 0, '.', ' ') ?>"
                                    style="width: 10rem; margin-right: 1rem;">
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
                                    <option value="Paiement en attente" <?= $colis['statut_paiement'] == "Paiement en attente" ? 'selected' : '' ?>>Paiement en attente</option>
                                    <option value="colis totalement payée" <?= $colis['statut_paiement'] == "Colis totalement payée" ? 'selected' : '' ?>>Colis totalement payée</option>
                                    <option value="colis partiellement payée" <?= $colis['statut_paiement'] == "Colis partiellement payée" ? 'selected' : '' ?>>Colis partiellement payée</option>
                                    <option value="Défaut de paiement" <?= $colis['statut_paiement'] == "Défaut de paiement" ? 'selected' : '' ?>>Défaut de paiement</option>
                                </select>
                            </div>

                            <div style='display: flex; align-items: center; justify-content: flex-end; margin-top: 1rem;'>
                                <label for="echeance_du" style="font-weight: normal; margin-right: 1rem;">A échéance du : </label>
                                <input class="form-control" type="date" name="echeance_du" id="echeance_du" style="width: 14rem; margin-right: 1rem;">
                            </div>
                        </div>

                        <div style="margin-left: 5rem">
                            <?php if (!empty($colis['id_paiement_pf'])) {
                            ?>
                                <h5 style="font-weight: bold">Echéancier</h5>
                                <div style='display: flex; align-items: center; justify-content: flex-end; margin-top: 1rem;'>
                                    <label for="echeancier1" style="font-weight: normal; margin-right: 1rem;">1er <?= $colis['dette_montant_pf'] ?> </label>
                                    <select id='dette_payee_pf' name='dette_payee_pf' class='form-control' style='width:50%'>
                                        <option value='Payé' <?php if ($colis['dette_payee_pf'] == 'Payé') {
                                                                    echo 'selected';
                                                                } ?>>Payé</option>
                                        <option value='Non payé' <?php if ($colis['dette_payee_pf'] == 'Non payé') {
                                                                        echo 'selected';
                                                                    } ?>>Non payé</option>
                                    </select>
                                    <!--input class="form-control" type="text" name="echeancier1" id="echeancier1" style="width: 10rem; margin-right: 1rem;" disabled-->
                                </div>
                                <div style='display: flex; align-items: center; justify-content: flex-end; margin-top: 1rem;'>
                                    <label for="echeancier2" style="font-weight: normal; margin-right: 1rem;">2e <?= $colis['dette_montant_pf2'] ?> </label>
                                    <select id='dette_payee_pf2' name='dette_payee_pf2' class='form-control' style='width:50%'>
                                        <option value='Payé' <?php if ($colis['dette_payee_pf2'] == 'Payé') {
                                                                    echo 'selected';
                                                                } ?>>Payé</option>
                                        <option value='Non payé' <?php if ($colis['dette_payee_pf2'] == 'Non payé') {
                                                                        echo 'selected';
                                                                    } ?>>Non payé</option>
                                    </select>
                                    <!--input class="form-control" type="text" name="echeancier2" id="echeancier2" style="width: 10rem; margin-right: 1rem;" disabled-->
                                </div>
                                <?php if (!empty($colis['dette_montant_pf3'])) { ?>
                                    <div style='display: flex; align-items: center; justify-content: flex-end; margin-top: 1rem;'>
                                        <label for="echeancier3" style="font-weight: normal; margin-right: 1rem;">3e <?= $colis['dette_montant_pf3'] ?> </label>
                                        <select id='dette_payee_pf3' name='dette_payee_pf3' class='form-control' style='width:50%'>
                                            <option value='Payé' <?php if ($colis['dette_payee_pf3'] == 'Payé') {
                                                                        echo 'selected';
                                                                    } ?>>Payé</option>
                                            <option value='Non payé' <?php if ($colis['dette_payee_pf3'] == 'Non payé') {
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
                        <input class="form-control" type="text" name="motif_encaissement" id="motif_encaissement" value="<?= $colis['motif_encaissement'] ?>" style="width: 20rem; margin-right: 1rem;">
                    </div>

                    <div style="margin-top: 3rem">
                        <p style="font-weight: bold">Transactions</p>
                        <?php
                        ///////////////////////////////SELECT BOUCLE

                        $req_boucle = $bdd->prepare("SELECT * FROM membres_transactions_colis WHERE id_colis=? AND type=? ORDER BY id DESC");
                        $req_boucle->execute(array($_POST['idaction'], "Paiement"));
                        while ($ligne_boucle = $req_boucle->fetch()) {
                        ?>
                            <p>- Paiement <?= $ligne_boucle['moyen'] ?> <?= $ligne_boucle['mode_encaissement'] ?> de <?= $ligne_boucle['montant'] ?> f cfa réalisé le <?= $ligne_boucle['date'] ?>
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
                            <input class="form-control" type="text" name="montant_rembourser" id="montant_rembourser"
                                value="<?= number_format($colis['montant_rembourser'], 0, '.', ' ') ?>"
                                style="width: 14rem; margin-right: 1rem;">
                        </div>


                        <div style="display: flex; align-items: center; justify-content: flex-end; margin-bottom: 1rem;">
                            <label for="restant_rembourser" style="margin-right: 1rem; font-weight: normal;">Restant à rembourser</label>
                            <input class="form-control" type="text" name="restant_rembourser" id="restant_rembourser"
                                value="<?= number_format($colis['restant_rembourser'], 0, '.', ' ') ?>"
                                style="width: 14rem; margin-right: 1rem;">
                        </div>


                        <div style="display: flex; align-items: center; justify-content: flex-end; margin-bottom: 1rem;">
                            <label for="total_rembourse" style="margin-right: 1rem; font-weight: normal;">Total remboursé</label>
                            <input class="form-control" type="text" name="total_rembourse" id="total_rembourse"
                                value="<?= number_format($colis['total_rembourse'], 0, '.', ' ') ?>"
                                style="width: 14rem; margin-right: 1rem;" disabled>
                        </div>

                    </div>

                    <div style="margin-top: 3rem">
                        <div style="display: flex; align-items: center; justify-content: flex-end; margin-bottom: 1rem;">
                            <label for="regulariser" style="margin-right: 1rem; font-weight: normal;">Montant remboursé</label>
                            <input class="form-control" type="text" name="regulariser" id="regulariser"
                                value="<?= number_format($colis['regulariser'], 0, '.', ' ') ?>"
                                style="width: 14rem; margin-right: 1rem;">
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
                            <input class="form-control" type="text" name="motif_remboursement" id="motif_remboursement" value="<?= $colis['motif_remboursement'] ?>" style="width: 20rem; margin-right: 1rem;">
                        </div>

                    </div>


                    <div style="margin-top: 3rem">
                        <p style="font-weight: bold">Transactions</p>
                        <?php
                        ///////////////////////////////SELECT BOUCLE

                        $req_boucle = $bdd->prepare("SELECT * FROM membres_transactions_colis WHERE id_colis=? AND type=? ORDER BY id DESC");
                        $req_boucle->execute(array($_POST['idaction'], "Remboursement"));
                        while ($ligne_boucle = $req_boucle->fetch()) {
                        ?>
                            <p>- Remboursement <?= $ligne_boucle['moyen'] ?> de <?= $ligne_boucle['montant'] ?> f cfa réalisé le <?= $ligne_boucle['date'] ?>
                                <?php if (!empty($colis['motif_remboursement'])) { ?>
                                    : <?= $colis['motif_remboursement'] ?>
                                <?php } ?>
                            </p>
                        <?php } ?>
                    </div>
                    <div style="display:flex;margin-top:1rem">
                        <div>

        </div>

        <div style="border-top: 1px solid #dddddd; padding: 2rem;">
            <h4 style="color: #ff9900; font-weight: bold;">NOTES</h4>
            <div style="display: flex; flex-direction: column">
                <label for="notes">Notes</label>
                <textarea id="notes" name="notes"><?= $colis['notes'] ?></textarea>
            </div>

        </div>

        <div class="button-modifier" style="display:flex;margin-top:1rem">
            <div>
                <button id="update" class="btn btn-success update" style="width: 100px; text-align:center">Modifier</button>
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