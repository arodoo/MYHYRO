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
        $(document).on("click", ".update", function () {
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
                success: function (res) {
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

        $(document).on("click", "#new_prix", function () {
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
                    success: function (res) {
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

        $(document).on("click", ".annuler", function () {

            var idd = $(this).data('id')

            $('#annule_champ' + idd).val("oui")

            $('.line' + $(this).data('id')).attr('class', 'annule line' + $(this).data('id'));
            $(this).attr('class', 'uk-icon-check annuler green');

        });



        $(document).on("click", ".uk-icon-check", function () {
            var idd = $(this).data('id')
            $('#annule_champ' + idd).val("non")
            $('.line' + $(this).data('id')).attr('class', 'line' + $(this).data('id'));
            $(this).attr('class', 'uk-icon-times annuler red');

        });


        $(document).on("click", "#sendRegul", function () {
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
                success: function (res) {
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

        $(document).on("click", "#updateRegul", function () {
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
                success: function (res) {
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

        $(document).on("input", "#poids", function () {

            douanetrans();
        });

        function douanetrans() {
            var poids = $('#poids').val();
            var prixkilo = $('#prix_du_kg').val();

            var douane_reel = poids * prixkilo;
            $('#douane_et_transport_reel').val(Math.round(douane_reel));
            ecart()
        }

        $(document).on("click", ".modif-liv", function () {
            $("#adresse_liv").css('display', '')
            $("#text-liv").css('display', 'none')
            $(this).css('display', 'none')
        });

        $(document).on("click", ".modif-fac", function () {
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
        /* ...existing CSS styles... */
    </style>
    
    <input id="idWish" type="hidden" value="<?= $commande['id']; ?>" />
    <input id="idMembre" type="hidden" value="<?= $commande['user_id']; ?>" />

    <!-- Details view -->
    <div class="card mb-5">
        <div class="card-header">
            <h5 class="card-title">Commande #<?= $commande['id'] ?></h5>
        </div>
        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="mb-4">
                        <h6>Informations client</h6>
                        <p>Client: <a href="?page=Membres&action=Modifier&idaction=<?= $id_membre ?>" class="text-decoration-none"><?= $prenom_membre ?> <?= strtoupper($nom_membre) ?></a></p>
                        <p>Type d'abonnement: <?= $abonnement_membre ?></p>
                        
                        <div class="mt-4">
                            <p>Historique des modifications</p>
                            <div class="ps-3 pe-3 py-2" style="max-height: 15vh; overflow-y: auto;">
                                <?php
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
                        
                        <div class="mt-4">
                            <button class="btn btn-primary" onclick="openAllProductLinks()" title="Ouvrir tous les produits">
                                COMMANDER
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-4">
                        <div class="card">
                            <div class="card-body border-top">
                                <div class="row">
                                    <div class="col-lg-7">
                                        <p class="mb-4">Commande #<?= $commande['id'] ?></p>
                                        <p>Date : <?= date('d/m/Y à H \h i \m\i\n', $commande['created_at']) ?></p>
                                        <p>Utilisateur : <a href="?page=Membres&action=Modifier&idaction=<?= $id_membre ?>" class="text-primary"><?= $pseudo_membre ?></a></p>
                                        <p>Nom : <?= strtoupper($nom_membre) ?> <?= $prenom_membre ?></p>
                                        <p>Type d'abonnement : <?= $abonnement_membre ?></p>
                                    </div>
                                    <div class="col-lg-5 align-self-end">
                                        <p>Numéro de paiement : <?= !empty($client['Telephone']) ? $client['Telephone'] : $client['Telephone_portable'] ?></p>
                                        <p>Attente paiement: 
                                        <?php
                                        $hasNonPaye = false;

                                        if (isset($commande['dette_payee_pf']) && $commande['dette_payee_pf'] === 'Non payé') {
                                            echo "<br>Dette Montant : " . $commande['dette_montant_pf'];
                                            $hasNonPaye = true;
                                        }

                                        if (isset($commande['dette_payee_pf2']) && $commande['dette_payee_pf2'] === 'Non payé') {
                                            echo "<br>Dette Montant : " . $commande['dette_montant_pf2'];
                                            $hasNonPaye = true;
                                        }

                                        if (isset($commande['dette_payee_pf3']) && $commande['dette_payee_pf3'] === 'Non payé') {
                                            echo "<br>Dette Montant : " . $commande['dette_montant_pf3'];
                                            $hasNonPaye = true;
                                        }

                                        if (!$hasNonPaye) {
                                            echo "Il n'y a pas de dates à venir";
                                        }
                                        ?>
                                        </p>
                                        <p>Code transaction: xxxxxx</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <?php if (!empty($colis_lie["id"])) { ?>
                            <a href='?page=Envoyer-colis&action=Details&idaction=<?= $colis_lie["id"] ?>' class="btn btn-link">Cette commande est rattachée à un colis, cliquez ici pour le traiter</a>
                        <?php } ?>
                        
                        <div class="mt-4 d-flex">
                            <button id="annuler_commande" class="btn <?= $commande['statut_2'] == 3 ? "btn-danger" : "btn-primary" ?> update me-2" 
                                data-annuler="oui" <?= $commande['statut_2'] == 2 || $commande['statut_2'] == 3 ? "disabled" : "" ?>>
                                <?= $commande['statut_2'] == 3 ? "Commande annulée" : "Annuler commande" ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<!-- Products section -->
<div class="card mb-5">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title">Produits</h5>
        <button id="new_prix" class="btn btn-primary">Valider</button>
    </div>
    <div class="card-body">
        <!-- Product table -->
        <form id="form-produits" method="post" action="#" enctype="multipart/form-data">
            <div class="table-responsive">
                <table id="Tableau_a2" class="sa-datatables-init table table-bordered table-striped table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th>Lien du produit</th>
                            <th>Couleur</th>
                            <th>Taille</th>
                            <th>Categorie</th>
                            <th>Quantité</th>
                            <th>Prix Unitaire TTC €</th>
                            <th>Prix Unitaire XAF</th>
                            <th>Total XAF</th>
                            <th>Disponibilité</th>
                            <th>Nom du produit</th>
                            <th>N° de commande site</th>
                            <th>Réf produit site d'achat</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php
                            // ...existing product rows loop code...
                            $even_odd_class = '';
                            $req_boucle = $bdd->prepare("SELECT * FROM membres_commandes_details WHERE commande_id=? ORDER BY id DESC");
                            $req_boucle->execute(array($_POST['idaction']));
                            while ($ligne_boucle = $req_boucle->fetch()) {
                                // ...existing row generation code...
                                $even_odd_class = ($even_odd_class == 'even') ? 'odd' : 'even';
                                if ($ligne_boucle['annule'] == 'oui') {
                                    $alert = "oui";
                                }
                            ?>
                                <tr class="line<?= $ligne_boucle['id'] ?> <?= $ligne_boucle['annule'] == 'oui' ? "text-decoration-line-through" : "" ?>">
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <i class="<?= $ligne_boucle['annule'] == 'oui' ? "fas fa-check text-success" : "fas fa-times text-danger" ?> annuler" 
                                               data-id="<?= $ligne_boucle['id'] ?>" data-champ="annule"></i>
                                            <input type="hidden" id="annule_champ<?= $ligne_boucle['id'] ?>" 
                                                   name="annule<?= $ligne_boucle['id'] ?>" value="<?= $ligne_boucle['annule'] ?>">
                                            <a href="<?= $ligne_boucle['url'] ?>" target="_blank" class="product-link btn btn-primary btn-sm ms-2">Lien</a>
                                            <button type="button" onclick="copyToClipboard('<?= $ligne_boucle['url'] ?>')" 
                                                    class="btn btn-outline-secondary btn-sm ms-2" title="Copier le lien">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="couleur<?= $ligne_boucle['id'] ?>" 
                                               value="<?= $ligne_boucle['couleur'] ? $ligne_boucle['couleur'] : '-' ?>">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="taille<?= $ligne_boucle['id'] ?>" 
                                               value="<?= $ligne_boucle['taille'] ? $ligne_boucle['taille'] : '-' ?>">
                                    </td>
                                    <td>
                                        <select class="form-select modif_produit" data-id="<?= $ligne_boucle['id'] ?>" 
                                                data-champ="categorie" name="categorie<?= $ligne_boucle['id'] ?>">
                                            <?php
                                            $req_boucle2 = $bdd->prepare("SELECT * FROM categories ORDER BY nom_categorie ASC");
                                            $req_boucle2->execute();
                                            while ($ligne_boucle2 = $req_boucle2->fetch()) {
                                            ?>
                                                <option value="<?= $ligne_boucle2['nom_categorie'] ?>" 
                                                        <?= $ligne_boucle2['nom_categorie'] == $ligne_boucle['categorie'] ? 'selected' : '' ?>>
                                                    <?= $ligne_boucle2['nom_categorie'] ?>
                                                </option>
                                            <?php
                                            }
                                            $req_boucle2->closeCursor();
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input class="form-control line<?= $ligne_boucle['id'] ?> <?= $ligne_boucle['annule'] == 'oui' ? "text-decoration-line-through" : "" ?>" 
                                               type="text" id="quantite" data-id="<?= $ligne_boucle['id'] ?>" 
                                               data-champ="quantite" name="quantite<?= $ligne_boucle['id'] ?>" value="<?= $ligne_boucle['quantite'] ?>">
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <input type="text" id="<?= $ligne_boucle['id'] ?>-prix_u" 
                                                   class="form-control line<?= $ligne_boucle['id'] ?> <?= $ligne_boucle['annule'] == 'oui' ? "text-decoration-line-through" : "" ?>" 
                                                   name="prix_u" value="<?= round($ligne_boucle['prix'] * 0.00152449, 2); ?>" disabled>
                                            <button type="button" onclick="copyPrice('<?= $ligne_boucle['id'] ?>-prix_u', '<?= $ligne_boucle['id'] ?>-prix_r')" 
                                                    class="btn btn-primary">
                                                <i class="fas fa-euro-sign"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" id="<?= $ligne_boucle['id'] ?>-prix_u_xaf" 
                                               class="form-control line<?= $ligne_boucle['id'] ?> <?= $ligne_boucle['annule'] == 'oui' ? "text-decoration-line-through" : "" ?>" 
                                               name="prix_u_xaf" value="<?= number_format($ligne_boucle['prix'], 0, '.', ' '); ?>" disabled>
                                    </td>
                                    <td>
                                        <input type="text" id="total_xaf" 
                                               class="form-control line<?= $ligne_boucle['id'] ?> <?= $ligne_boucle['annule'] == 'oui' ? "text-decoration-line-through" : "" ?>" 
                                               name="total_xaf" value="<?= number_format($ligne_boucle['prix'] * $ligne_boucle['quantite'], 0, '.', ' ') ?>" disabled>
                                    </td>
                                    <td>
                                        <select class="form-select modif_produit <?= $ligne_boucle['annule'] == 'oui' ? "text-decoration-line-through" : "remplir" ?>" 
                                                name="disponibilite<?= $ligne_boucle['id'] ?>" data-champ="disponibilite" data-id="<?= $ligne_boucle['id'] ?>">
                                            <option></option>
                                            <option value="Disponible" <?= $ligne_boucle['disponibilite'] == 'Disponible' ? "selected" : "" ?>>Disponible</option>
                                            <option value="Non disponible" <?= $ligne_boucle['disponibilite'] == 'Non disponible' ? "selected" : "" ?>>Non disponible</option>
                                            <option value="Annulé" <?= $ligne_boucle['disponibilite'] == 'Annulé' ? "selected" : "" ?>>Annulé</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input class="form-control modif_produit <?= $ligne_boucle['annule'] == 'oui' ? "text-decoration-line-through" : "remplir" ?>" 
                                               type="text" id="nom_produit" data-id="<?= $ligne_boucle['id'] ?>" 
                                               data-champ="nom" name="nom<?= $ligne_boucle['id'] ?>" value="<?= $ligne_boucle['nom'] ?>">
                                    </td>
                                    <td>
                                        <input class="form-control modif_produit" type="text" id="num_commande_site" 
                                               data-id="<?= $ligne_boucle['id'] ?>" data-champ="num_commande_site" 
                                               name="num_commande_site<?= $ligne_boucle['id'] ?>" value="<?= $ligne_boucle['num_commande_site'] ?>">
                                    </td>
                                    <td>
                                        <input class="form-control modif_produit" type="text" id="ref_produit_site_achat" 
                                               data-id="<?= $ligne_boucle['id'] ?>" data-champ="ref_produit_site" 
                                               name="ref_produit_site<?= $ligne_boucle['id'] ?>" value="<?= $ligne_boucle['ref_produit_site'] ?>">
                                    </td>
                                </tr>
                                <tr class="line<?= $ligne_boucle['id'] ?> <?= $ligne_boucle['annule'] == 'oui' ? "text-decoration-line-through" : "" ?>">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <b>Prix Réel</b>
                                    </td>
                                    <td>
                                        <input class="form-control modif_produit <?= $ligne_boucle['annule'] == 'oui' ? "text-decoration-line-through" : "remplir" ?>" 
                                               type="text" id="<?= $ligne_boucle['id'] ?>-prix_r" data-id="<?= $ligne_boucle['id'] ?>" 
                                               data-champ="prix_reel" name="prix_reel<?= $ligne_boucle['id'] ?>" value="<?= round($ligne_boucle['prix_reel'] * 0.00152449, 2); ?>">
                                    </td>
                                    <td>
                                        <input class="form-control line<?= $ligne_boucle['id'] ?> <?= $ligne_boucle['annule'] == 'oui' ? "text-decoration-line-through" : "" ?>" 
                                               type="text" id="prix_r_xaf" name="prix_r_xaf" value="<?= number_format($ligne_boucle['prix_reel'], 0, '.', ' '); ?>" disabled>
                                    </td>
                                    <td>
                                        <input class="form-control line<?= $ligne_boucle['id'] ?> <?= $ligne_boucle['annule'] == 'oui' ? "text-decoration-line-through" : "" ?>" 
                                               type="text" id="prix_r_fcfa" name="prix_r_fcfa" 
                                               value="<?= number_format(round(($ligne_boucle['prix_reel']) * $ligne_boucle['quantite']), 0, '.', ' '); ?>" disabled>
                                    </td>
                                    <td colspan="4"></td>
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
                </div>
            </form>
            
            <?php if ($commande['comment']) { ?>
                <div class="mt-3 alert alert-info">
                    Commentaire : <?= $commande['comment'] ?>
                </div>
            <?php } ?>

            <div class="mt-4">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Total des produits :</strong> <?= number_format($sous_total, 0, '.', ' '); ?> F CFA
                            (<?= round($sous_total * 0.00152449, 2); ?>€)</p>
                        <p><strong>Frais de livraison :</strong>
                            <?= number_format($commande['frais_livraison'], 0, '.', ' '); ?> F CFA 
                            (<?= round($commande['frais_livraison'] * 0.00152449, 2); ?>€)</p>
                        <p><strong>Frais de gestion :</strong>
                            <?= number_format($commande['frais_gestion'], 0, '.', ' '); ?> F CFA
                            (<?= round($commande['frais_gestion'] * 0.00152449, 2); ?>€)</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>TVA :</strong> <?= number_format($commande['tva'], 0, '.', ' '); ?> F CFA
                            (<?= round($commande['tva'] * 0.00152449, 2); ?>€)</p>
                        <p><strong>Douane et transport :</strong> <?= number_format($prix_expedition, 0, '.', ' '); ?> F CFA
                            (<?= round($prix_expedition * 0.00152449, 2); ?>€)</p>
                        <p><strong>Total de la commande :</strong> <?= number_format($prix_total, 0, '.', ' '); ?> F CFA
                            (<?= round($prix_total * 0.00152449, 2); ?>€)</p>
                        <?php if (!is_null($commande['frais_gestion_pf_total'])): ?>
                            <p><strong>Frais de gestion PF total :</strong>
                                <?= number_format($commande['frais_gestion_pf_total'], 0, '.', ' '); ?> F CFA
                                (<?= round($commande['frais_gestion_pf_total'] * 0.00152449, 2); ?>€)</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Order tracking section -->
    <div class="card mb-5">
        <div class="card-header">
            <h5 class="card-title">Suivi de la commande</h5>
        </div>
        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="mb-4">
                        <h6>Etape 1 : Suivi achat</h6>
                        <select id="statut_2" name="statut_2" class="form-select">
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
                </div>
                <div class="col-md-4">
                    <div class="mb-4">
                        <h6>Etape 2 : Suivi expédition</h6>
                        <select id="statut_expedition" name="statut_expedition" class="form-select">
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
                <div class="col-md-4">
                    <div class="mb-4">
                        <h6>Messages prédéfinis</h6>
                        <select id="message" name="message" class="form-select">
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
            </div>
            
            <div class="row g-4 mt-2">
                <div class="col-md-6">
                    <div class="mb-4">
                        <h6>Commentaire livraison</h6>
                        <textarea class="form-control" style="height: 120px" name="commentaire_livraison" id="commentaire_livraison"><?= $commande['commentaire_livraison']; ?></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Réduction</label>
                        <input class="form-control" type="text" name="reduction" value="<?= $commande['prix_reduction'] ?>" id="reduction" disabled>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Code de réduction</label>
                        <input class="form-control" type="text" value="<?= $commande['code_promo'] ?>" name="code_de_reduction" id="code_de_reduction" disabled>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Douane à la livraison</label>
                        <div class="d-flex">
                            <div class="form-check me-3">
                                <input class="form-check-input" type="radio" id="oui" name="douane_a_la_livraison" value="oui" <?php echo $commande['douane_a_la_liv'] == 'oui' ? 'checked' : ''; ?> disabled>
                                <label class="form-check-label" for="oui">Oui</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="non" name="douane_a_la_livraison" value="non" <?php echo $commande['douane_a_la_liv'] != 'oui' ? 'checked' : ''; ?> disabled>
                                <label class="form-check-label" for="non">Non</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Montant de la douane et transport</label>
                                <input class="form-control" type="text" name="prix_expedition" id="prix_expedition" value="<?php echo $commande['douane_a_la_liv'] == 'oui' ? $commande['dette_montant'] : $commande['prix_expedition']; ?>" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Montant à payer</label>
                                <input class="form-control" type="text" name="montant_a_payer" id="montant_a_payer" value="<?= number_format($prix_total, 0, '.', ' ') ?>" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row g-4 mt-2">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Nombre de Kg</label>
                        <input class="form-control" type="text" value="<?= $commande['poids'] ?>" name="poids" id="poids">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Prix du Kg</label>
                        <input class="form-control" type="text" value="<?= round($prix_kilo_colis / 0.00152449) ?>" name="prix_du_kg" id="prix_du_kg" disabled>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Douane et transport réel</label>
                        <input class="form-control" type="text" name="douane_et_transport_reel" value="" id="douane_et_transport_reel" disabled>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Ecart</label>
                        <input class="form-control" type="text" name="ecart" id="ecart" value="" disabled>
                    </div>
                </div>
            </div>
            
            <div class="row g-4 mt-3">
                <div class="col-md-6">
                    <?php
                    $req_facture = $bdd->prepare("SELECT * FROM membres_prestataire_facture WHERE id_commande=?");
                    $req_facture->execute(array($commande['id']));
                    $facture = $req_facture->fetch();
                    $req_facture->closeCursor();

                    if ($facture && $facture['statut'] == "Activée") {
                        $reference_numero = $facture['REFERENCE_NUMERO'];
                        echo '
                        <a class="btn btn-primary" href="/facture/' . $reference_numero . '/' . $nomsiteweb . '">
                            Voir la facture
                        </a>
                    ';
                    }
                    ?>
                </div>
                <div class="col-md-6">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Lot d'expédition</label>
                                <input class="form-control" type="text" value="<?= $commande['lot_expedition'] ?>" name="lot_expedition" id="lot_expedition">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Date d'envoi</label>
                                <?php
                                if ($commande['date_envoi'] != null) {
                                    $date_envoi = date('Y-m-d', $commande['date_envoi']);
                                }
                                ?>
                                <input class="form-control" type="date" value="<?= isset($date_envoi) ? $date_envoi : '' ?>" name="date_envoi" id="date_envoi">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Payments and Refunds section -->
    <div class="card mb-5">
        <div class="card-header">
            <h5 class="card-title">Suivi des encaissements et des remboursements</h5>
        </div>
        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="card-title">Encaissement</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">Montant à payer</label>
                                    <input class="form-control" type="text" name="montant_a_payer" id="montant_a_payer" value="<?= number_format($prix_total, 0, '.', ' ') ?>" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Montant payé par le client</label>
                                    <input class="form-control" type="text" name="montant_paye_client" id="montant_paye_client" value="<?= number_format($commande['montant_paye_client'] ? $commande['montant_paye_client'] : 0, 0, '.', ' ') ?>" disabled>
                                </div>
                            </div>
                            
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">Total à régulariser</label>
                                    <input class="form-control" disabled type="text" name="total_a_regulariser" value="<?= number_format(!empty($commande['prix_total_reel']) ? $commande['prix_total_reel'] - $commande['montant_paye_client'] : $prix_total - $commande['montant_paye_client'], 0, '.', ' ') ?>" id="total_a_regulariser">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Restant à payer</label>
                                    <input class="form-control" type="text" name="restant_payer" id="restant_payer" value="<?= number_format($commande['restant_payer'], 0, '.', ' ') ?>">
                                </div>
                            </div>
                            
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">Montant reçu</label>
                                    <input class="form-control" type="text" name="montant_recu" id="montant_recu">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Date de réception</label>
                                    <input class="form-control" type="date" name="date_de_reception" id="date_de_reception">
                                </div>
                            </div>
                            
                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <label class="form-label">Moyen d'encaissement</label>
                                    <select name="moyen_d_encaissement" id="moyen_d_encaissement" class="form-select">
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
                                <div class="col-md-4">
                                    <label class="form-label">Type d'encaissement</label>
                                    <select name="type_d_encaissement" id="type_d_encaissement" class="form-select">
                                        <option value=""></option>
                                        <option value="Comptant">Comptant</option>
                                        <option value="60 %">60 %</option>
                                        <option value="2 fois">2 fois</option>
                                        <option value="3 fois">3 fois</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Statut de paiement</label>
                                    <select name="statut_paiement" id="statut_paiement" class="form-select">
                                        <option value=""></option>
                                        <option value="Paiement en attente" <?= $commande['statut_paiement'] == "Paiement en attente" ? 'selected' : '' ?>>Paiement en attente</option>
                                        <option value="Commande totalement payée" <?= $commande['statut_paiement'] == "Commande totalement payée" ? 'selected' : '' ?>>Commande totalement payée</option>
                                        <option value="Commande partiellement payée" <?= $commande['statut_paiement'] == "Commande partiellement payée" ? 'selected' : '' ?>>Commande partiellement payée</option>
                                        <option value="Défaut de paiement" <?= $commande['statut_paiement'] == "Défaut de paiement" ? 'selected' : '' ?>>Défaut de paiement</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">A échéance du</label>
                                    <input class="form-control" type="date" name="echeance_du" id="echeance_du">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Motif</label>
                                    <input class="form-control" type="text" name="motif_encaissement" id="motif_encaissement" value="<?= $commande['motif_encaissement'] ?>">
                                </div>
                            </div>
                            
                            <?php if (!empty($commande['id_paiement_pf'])) { ?>
                                <h6 class="mt-4">Echéancier</h6>
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label">1er <?= $commande['dette_montant_pf'] ?></label>
                                        <select id='dette_payee_pf' name='dette_payee_pf' class='form-select'>
                                            <option value='Payé' <?php if ($commande['dette_payee_pf'] == 'Payé') { echo 'selected'; } ?>>Payé</option>
                                            <option value='Non payé' <?php if ($commande['dette_payee_pf'] == 'Non payé') { echo 'selected'; } ?>>Non payé</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">2e <?= $commande['dette_montant_pf2'] ?></label>
                                        <select id='dette_payee_pf2' name='dette_payee_pf2' class='form-select'>
                                            <option value='Payé' <?php if ($commande['dette_payee_pf2'] == 'Payé') { echo 'selected'; } ?>>Payé</option>
                                            <option value='Non payé' <?php if ($commande['dette_payee_pf2'] == 'Non payé') { echo 'selected'; } ?>>Non payé</option>
                                        </select>
                                    </div>
                                </div>
                                <?php if (!empty($commande['dette_montant_pf3'])) { ?>
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label">3e <?= $commande['dette_montant_pf3'] ?></label>
                                            <select id='dette_payee_pf3' name='dette_payee_pf3' class='form-select'>
                                                <option value='Payé' <?php if ($commande['dette_payee_pf3'] == 'Payé') { echo 'selected'; } ?>>Payé</option>
                                                <option value='Non payé' <?php if ($commande['dette_payee_pf3'] == 'Non payé') { echo 'selected'; } ?>>Non payé</option>
                                            </select>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                            
                            <h6 class="mt-4">Transactions</h6>
                            <div class="ps-3" style="max-height: 20vh; overflow-y: auto;">
                                <?php
                                $req_boucle = $bdd->prepare("SELECT * FROM membres_transactions_commande WHERE id_commande=? AND type=? ORDER BY id DESC");
                                $req_boucle->execute(array($_POST['idaction'], "Paiement"));
                                while ($ligne_boucle = $req_boucle->fetch()) {
                                ?>
                                    <p>- Paiement <?= $ligne_boucle['moyen'] ?> <?= $ligne_boucle['mode_encaissement'] ?> <?= $ligne_boucle['telephone_airtel'] ?> de <?= $ligne_boucle['montant'] ?> f cfa réalisé le <?= $ligne_boucle['date'] ?>
                                        <?php if (!empty($ligne_boucle['motif'])) { ?>
                                            : <?= $ligne_boucle['motif'] ?>
                                        <?php } ?>
                                        <?= $ligne_boucle['echeance_du'] ? ", <span class='text-danger fw-bold'> prochaine échéance le " . $ligne_boucle['echeance_du'] . "</span>" : '' ?>
                                    </p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title">Remboursement</h6>
                        </div>
                        <div class="card-body">
                            <?php if ($alert == "oui") { ?>
                                <div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> Attention! des articles ont été annulés, veuillez procéder au remboursement si besoin</div>
                            <?php } ?>
                            
                            <div class="mb-3">
                                <label class="form-label">Montant à rembourser</label>
                                <input class="form-control" type="text" name="montant_rembourser" id="montant_rembourser" value="<?= number_format($commande['montant_rembourser'], 0, '.', ' ') ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Restant à rembourser</label>
                                <input class="form-control" type="text" name="restant_rembourser" id="restant_rembourser" value="<?= number_format($commande['restant_rembourser'], 0, '.', ' ') ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Total remboursé</label>
                                <input class="form-control" type="text" name="total_rembourse" id="total_rembourse" value="<?= number_format($commande['total_rembourse'], 0, '.', ' ') ?>" disabled>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Montant remboursé</label>
                                <input class="form-control" type="text" name="regulariser" id="regulariser" value="<?= isset($commande['regulariser']) ? number_format($commande['regulariser'], 0, '.', ' ') : '' ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Date de remboursement</label>
                                <input class="form-control" type="date" name="date_rem" id="date_rem">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Moyen de remboursement</label>
                                <select name="moyen_de_remboursement" id="moyen_de_remboursement" class="form-select">
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
                            
                            <div class="mb-3">
                                <label class="form-label">Motif</label>
                                <input class="form-control" type="text" name="motif_remboursement" id="motif_remboursement" value="<?= $commande['motif_remboursement'] ?>">
                            </div>
                            
                            <h6 class="mt-4">Transactions</h6>
                            <div class="ps-3" style="max-height: 20vh; overflow-y: auto;">
                                <?php
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Notes section -->
    <div class="card mb-5">
        <div class="card-header">
            <h5 class="card-title">Notes</h5>
        </div>
        <div class="card-body">
            <div class="mb-4">
                <textarea id="notes" name="notes" class="form-control" rows="4"><?= $commande['notes'] ?></textarea>
            </div>
            
            <div class="mt-5">
                <button class="btn btn-primary update">Modifier</button>
            </div>
        </div>
    </div>

<?php } else {
    header('location: /index.html');
}

ob_end_flush();
?>

<script>
    // ...existing JavaScript code...
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