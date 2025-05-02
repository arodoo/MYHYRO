<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');
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

if (!empty($user)) {

    $now = time();

    $_SESSION['last_mode_paiement'] = $modepaiements;

    $req_select = $bdd->prepare("SELECT * FROM membres_panier WHERE id_membre=?");
    $req_select->execute(array($id_oo));
    $ligne_select = $req_select->fetch();
    $req_select->closeCursor();
    $id_facture_panier = $ligne_select['id'];
    $telephone_airtel = $ligne_select['telephone_airtel'];
    $ref_airtel = $ligne_select['ref_airtel'];
    $numero_panier = $id_facture_panier;
    $Titre_facture = $ligne_select['Titre_panier'];
    $type_panier = $ligne_select['type_panier'];
    $code_promotion = $ligne_select['code_promotion'];
    $prix_frais_de_gestion_total = $ligne_select['prix_frais_de_gestion_total'];
    $prix_prospection_total = $ligne_select['prix_prospection_total'];
    $prix_expedition_total = $ligne_select['prix_expedition_total'];
    $prix_expedition_colis_total = $ligne_select['prix_expedition_colis_total'];
    $PU_HT = ($ligne_select['Tarif_HT'] + $ligne_select['prix_frais_de_gestion_total'] + $ligne_select['prix_prospection_total'] + $ligne_select['frais_gestion_pf'] + $ligne_select['prix_expedition_total'] + $ligne_select['prix_expedition_colis_total']);
    $total_panier_frais_ttc = $ligne_select['Tarif_TTC'];
    $total_panier_frais_tva = $ligne_select['Total_Tva'];
    $frais_livraison = $ligne_select['frais_livraison'];
    $id_livraison = $ligne_select['id_livraison'];
    $_SESSION['id_liv'] = $ligne_select['id_livraison'];
    $commentaire_livraison = $ligne_select['commentaire_livraison'];
    $id_paiement = $ligne_select['id_paiement'];
    $frais_gestion_pf = $ligne_select['frais_gestion_pf'];
    $id_paiement_pf = $ligne_select['id_paiement_pf'];
    /*$req_select = $bdd->prepare("SELECT * FROM membres_panier_details WHERE pseudo=? AND numero_panier=?");
    $req_select->execute(array($user, $id_facture_panier));
    $ligne_select = $req_select->fetch();
    $req_select->closeCursor();
    $id_panier_detail = $ligne_select['id'];
    $numero_panier = $ligne_select['numero_panier'];
    $libelle = $ligne_select['libelle'];
    $quantite = $ligne_select['quantite'];
    $action_module_service_produit = $ligne_select['action_module_service_produit'];
    $Duree_service = $ligne_select['Duree_service'];
    $pseudo_vendeur = $ligne_select['pseudo_vendeur'];
    */
    $condition_livraison = "Immédiat";


    $req_select = $bdd->prepare("SELECT * FROM configurations_modes_paiement WHERE id=?");
    $req_select->execute(array($id_paiement));
    $ligne_select = $req_select->fetch();
    $req_select->closeCursor();

    $_SESSION['type_paiement'] = $ligne_select['nom_mode'];

    if (empty($_SESSION['type_paiement'])) {
        $req_select = $bdd->prepare("SELECT * FROM configurations_modes_paiement_plusieurs_fois WHERE id=?");
        $req_select->execute(array($id_paiement_pf));
        $ligne_select = $req_select->fetch();
        $req_select->closeCursor();

        $_SESSION['type_paiement'] = $ligne_select['nom'];
    }


    $req_select = $bdd->prepare("SELECT * FROM configurations_pdf_devis_factures WHERE id=1");
    $req_select->execute();
    $ligne_select = $req_select->fetch();
    $req_select->closeCursor();
    $LAST_REFERENCE_FACTURE = $ligne_select['LAST_REFERENCE_FACTURE'];
    $LAST_REFERENCE_FACTURE = ($LAST_REFERENCE_FACTURE + 1);

    // UPDATE REFERENCED FACTURES
    $sql_update = $bdd->prepare("UPDATE configurations_pdf_devis_factures SET LAST_REFERENCE_FACTURE=? WHERE id=?");
    $sql_update->execute(array($LAST_REFERENCE_FACTURE, '1'));
    $sql_update->closeCursor();
    $LAST_REFERENCE_FACTURE = "FA-" . $LAST_REFERENCE_FACTURE . "";

    $isAbonnement = false;

    // CREATION FACTURE - INSERT
    $sql_insert = $bdd->prepare("INSERT INTO membres_prestataire_facture 
			(id_membre,
			pseudo,
			REFERENCE_NUMERO,
			numero_facture,
			Titre_facture,
			Contenu,
			Suivi,
			date_edition,
			departement,
			jour_edition,
			mois_edition,
			annee_edition,
			mod_paiement,
			Tarif_HT,
			Remise,
			Tarif_HT_net,
			Tarif_TTC,
			Total_Tva,
			taux_tva,
            prix_frais_de_gestion_total,
            prix_prospection_total,
            prix_expedition_total,
            prix_expedition_colis_total,
            frais_livraison,
			condition_reglement,
			delai_livraison,
			code_promotion,
			Type_compte_F,
			id_devis,
			statut
			)
			VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $sql_insert->execute(array(
        $id_oo,
        $user,
        $LAST_REFERENCE_FACTURE,
        $LAST_REFERENCE_FACTURE,
        $Titre_facture,
        '',
        'payer',
        $now,
        '',
        '',
        '',
        '',
        $modepaiements,
        $PU_HT,
        "",
        $PU_HT,
        $total_panier_frais_ttc,
        $total_panier_frais_tva,
        $TVA_TAUX,
        $prix_frais_de_gestion_total,
        $prix_prospection_total,
        $prix_expedition_total,
        $prix_expedition_colis_total,
        $frais_livraison,
        'Immédiat',
        $condition_livraison,
        $code_promotion,
        '',
        '',
        'Brouillon'
    ));
    $sql_insert->closeCursor();

    $req_select = $bdd->prepare("SELECT * FROM membres_prestataire_facture WHERE date_edition=?");
    $req_select->execute(array($now));
    $ligne_select = $req_select->fetch();
    $req_select->closeCursor();
    $id_url = $ligne_select['id'];
    $_SESSION['LAST_REFERENCE_FACTURE'] = $LAST_REFERENCE_FACTURE;
    // CREATION FACTURE - DETAILS FACTURE
    $req_boucle = $bdd->prepare("SELECT * FROM membres_panier_details WHERE numero_panier=? ORDER BY id ASC");
    $req_boucle->execute(array($numero_panier));
    while ($ligne_boucle = $req_boucle->fetch()) {
        $id_facture_panier_dd = $ligne_boucle['id'];
        $id_panier_facture_details_idd = $ligne_boucle['id'];
        $id_panier_SERVICE_PRODUIT_idd = $ligne_boucle['id_panier_SERVICE_PRODUIT'];
        $libelled = $ligne_boucle['libelle'];
        $PU_HTd = sprintf('%.2f', $ligne_boucle['PU_HT']);
        $quantited = $ligne_boucle['quantite'];
        $PU_HTd_total = ($PU_HTd * $quantited);
        $action_module_service_produit = $ligne_boucle['action_module_service_produit'];
        $Duree_service = $ligne_boucle['Duree_service'];
        $titre_liste = $ligne_boucle['titre_liste'];
        $description_liste = $ligne_boucle['description_liste'];
        $fichier_liste = $ligne_boucle['fichier_liste'];



        //////////
        if (($action_module_service_produit == "Commande" || $action_module_service_produit == "Commande boutique")) {


            ///////////////////////////////SELECT ABONNEMENT
            $req_selectap = $bdd->prepare("SELECT * FROM membres_commandes_details WHERE id=?");
            $req_selectap->execute(array($ligne_boucle['id_commande_detail']));
            $ligne_selectap = $req_selectap->fetch();
            $req_selectap->closeCursor();

            $commande_id = $ligne_selectap["commande_id"];

            if (!empty($commande_id)) {



                $_SESSION['last_commande'] = $commande_id;

                if ($id_paiement == '2' || $id_paiement == '3' || ($id_paiement_pf == '2' || $id_paiement_pf == '4' || $id_paiement_pf == '6')) {
                    $statuttt = '1';
                    $messagee = '2';
                } else {

                    $statuttt = '2';
                    $messagee = '7';

                    $req_select = $bdd->prepare("SELECT * FROM membres_commandes WHERE id=?");
                    $req_select->execute(array($commande_id));
                    $ligne_commande = $req_select->fetch();
                    $req_select->closeCursor();


                    if (($id_paiement_pf == '1' || $id_paiement_pf == '3' || $id_paiement_pf == '5')) {
                        preg_match('/\d[\d\s]*/', $ligne_commande["dette_montant_pf"], $matches);
                        $total_paye_fois = str_replace(' ', '', $matches[0]);

                        if ($id_paiement_pf == '1') {
                            $mode_fois = "60 %";
                        } elseif ($id_paiement_pf == '3') {
                            $mode_fois = "2 fois";
                        } elseif ($id_paiement_pf == '5') {
                            $mode_fois = "3 fois";
                        }

                        $sql_update = $bdd->prepare("INSERT INTO membres_transactions_commande
                        ( 
                            id_membre,
                            id_commande,
                            date,
                            type,
                            moyen,
                            montant,
                            echeance_du,
                            mode_encaissement,
                            telephone_airtel
                        )
                        VALUES (?,?,?,?,?,?,?,?,?)");
                        $sql_update->execute(
                            array(
                                $id_oo,
                                $commande_id,
                                date("d-m-Y", time()),
                                "Paiement",
                                $modepaiements,
                                $total_paye_fois,
                                $echeance_du,
                                $mode_fois,
                                $telephone_airtel
                            )
                        );
                        $sql_update->closeCursor();

                        $sql_update = $bdd->prepare("UPDATE membres_commandes SET
                    montant_paye_client=?,
                    dette_payee_pf=?
                    WHERE id=?");

                        $sql_update->execute(
                            array(
                                $total_paye_fois,
                                "Payé",
                                $commande_id
                            )
                        );
                        $sql_update->closeCursor();


                    } else {
                        $sql_update = $bdd->prepare("INSERT INTO membres_transactions_commande
                        ( 
                            id_membre,
                            id_commande,
                            date,
                            type,
                            moyen,
                            montant,
                            echeance_du,
                            mode_encaissement,
                            telephone_airtel
                        )
                        VALUES (?,?,?,?,?,?,?,?,?)");
                        $sql_update->execute(
                            array(
                                $id_oo,
                                $commande_id,
                                date("d-m-Y", time()),
                                "Paiement",
                                $modepaiements,
                                $total_panier_frais_ttc,
                                $echeance_du,
                                "Comptant",
                                $telephone_airtel
                            )
                        );
                        $sql_update->closeCursor();

                        $sql_update = $bdd->prepare("UPDATE membres_commandes SET
                    montant_paye_client=?
                    WHERE id=?");

                        $sql_update->execute(
                            array(
                                $total_panier_frais_ttc,
                                $commande_id
                            )
                        );
                        $sql_update->closeCursor();
                    }
                }

                $sql_update = $bdd->prepare("UPDATE membres_prestataire_facture SET
                id_commande=?
                WHERE id=?");

                $sql_update->execute(
                    array(
                        $commande_id,
                        $id_url
                    )
                );
                $sql_update->closeCursor();


                ///////////////////////////////UPDATE
                $sql_update = $bdd->prepare("UPDATE membres_commandes SET 
            statut=?,
            statut_2=?,
            id_livraison=?,
            commentaire_livraison=?,
            id_paiement=?,
            id_paiement_pf=?,
            prix_expedition=?,
            adresse_liv=?,
            adresse_fac=?,
            frais_livraison =?,
            frais_gestion = ?,
            tva=?,
            ref_airtel=?,
            panier_id=?,
            frais_gestion_pf_total=?,
            message=?
            WHERE id=?");
                $sql_update->execute(array(
                    '4',
                    $statuttt,
                    $id_livraison,
                    $commentaire_livraison,
                    $id_paiement,
                    $id_paiement_pf,
                    $prix_expedition_total,
                    $_SESSION['address_liv'],
                    $_SESSION['address_fac'],
                    $frais_livraison,
                    $prix_frais_de_gestion_total,
                    $total_panier_frais_tva,
                    $ref_airtel,
                    $id_facture_panier,
                    $frais_gestion_pf,
                    $messagee,
                    $commande_id
                ));
                $sql_update->closeCursor();
            }
        }

        //////////
        if ($action_module_service_produit == "Commande colis") {

             ///////////////////////////////SELECT ABONNEMENT
             $req_selectap = $bdd->prepare("SELECT * FROM membres_colis_details WHERE id=?");
             $req_selectap->execute(array($ligne_boucle['id_colis_detail']));
             $ligne_selectap = $req_selectap->fetch();
             $req_selectap->closeCursor();
 
             $colis_id = $ligne_selectap["colis_id"];

            if ($id_paiement == '2' || $id_paiement == '3' || ($id_paiement_pf == '2' || $id_paiement_pf == '4' || $id_paiement_pf == '6')) {
                $statuttt = '17';
                $messagee = '21';
            } else {
                $statuttt = '11';
                $messagee = '22';
            }

            ///////////////////////////////UPDATE
            $sql_update = $bdd->prepare("UPDATE membres_colis SET   
        statut=?,
        ref_airtel=?,
        panier_id=?,
        id_livraison=?,
        commentaire_livraison=?,
        id_paiement=?,
        id_paiement_pf=?,
        adresse_liv=?,
        adresse_fac=?,
        frais_gestion = ?,
        tva=?,
        message=?
        WHERE id=?");
            $sql_update->execute(array(
                $statuttt,
                $ref_airtel,
                $id_facture_panier,
                $id_livraison,
                $commentaire_livraison,
                $id_paiement,
                $id_paiement_pf,
                $_SESSION['address_liv'],
                $_SESSION['address_fac'],
                $prix_frais_de_gestion_total,
                $total_panier_frais_tva,
                $messagee,
                $colis_id
            ));
            $sql_update->closeCursor();

            $sql_update = $bdd->prepare("UPDATE membres_prestataire_facture SET
            id_colis=?
            WHERE id=?");

            $sql_update->execute(
                array(
                    $colis_id,
                    $id_url
                )
            );
            $sql_update->closeCursor();
        }


        //////////
        if ($action_module_service_produit == "Achat liste souhait") {

            $_SESSION['isListe'] = true;

            $sql_insert = $bdd->prepare("INSERT INTO membres_souhait
                            (titre,
                            description,
                            filename,
                            user_id,
                            statut,
                            created_at,
                            updated_at)
                            VALUES (?,?,?,?,?,?,?)");

            $sql_insert->execute(
                array(
                    htmlspecialchars($titre_liste),
                    htmlspecialchars($description_liste),
                    htmlspecialchars($fichier_liste),
                    intval($id_oo),
                    intval(1),
                    time(),
                    time()
                )
            );
            $sql_insert->closeCursor();
        }

        //////////
        if ($action_module_service_produit == "Abonnement") {

            if (($id_paiement == '2' || $id_paiement == '3')) {
                $sql_update = $bdd->prepare("UPDATE membres SET 
                Abonnement_demande=?,
                Abonnement_paye_demande=?,
                Abonnement_dernier_demande_date=?,
                Abonnement_statut_demande=?,
                Abonnement_message_demande=?
                WHERE id=?");
                $sql_update->execute(array(
                    $ligne_boucle['id_service'],
                    $modepaiements,
                    time(),
                    '7',
                    '19',
                    $id_oo
                ));
                $sql_update->closeCursor();
            } elseif (($id_paiement == '1' || $id_paiement == '4')) {

                //Condition
                $fecha_actual = new DateTime();
                $date_new_expiration = (clone $fecha_actual)->modify('+1 year');
                $date_new_expiration = $date_new_expiration->format('d-m-Y');

                $sql_update = $bdd->prepare("UPDATE membres SET 
                Abonnement_id=?,
			Abonnement_paye=?,
			Abonnement_mode_paye=?,
            Abonnement_date=?,
				Abonnement_date_expiration=?,
                Abonnement_message_demande=?,
			Abonnement_statut_demande=?
                WHERE id=?");
                $sql_update->execute(array(
                    $ligne_boucle['id_service'],
                    "oui",
                    $modepaiements,
                    time(),
                    strtotime($date_new_expiration),
                    "6",
                    '18',
                    $id_oo
                ));
                $sql_update->closeCursor();
            }

            $isAbonnement = true;


            /*///////////////////////////////UPDATE
            $sql_update = $bdd->prepare("UPDATE membres SET
                Abonnement_paye=?,
                Abonnement_mode_paye=?,
                Abonnement_date_paye=?,
                Abonnement_date_expiration=?,
                Abonnement_last_facture_numero=?
                WHERE id=?");
            $sql_update->execute(array(
                'oui',
                $modepaiements,
                time(),
                (time()+86400*365),
                $id_url,
                $id_oo));
            $sql_update->closeCursor();*/
        }


        $sql_insert = $bdd->prepare("INSERT INTO membres_prestataire_facture_details
            (id_membre,
            pseudo,
            numero_facture,
            libelle,
            PU_HT,
            quantite,
            REFERENCE_DETAIL,
            Type_detail)
            VALUES (?,?,?,?,?,?,?,?)");
        $sql_insert->execute(array(
            $id_oo,
            $user,
            $LAST_REFERENCE_FACTURE,
            $libelled,
            $PU_HTd,
            $quantited,
            '',
            $type_detail
        ));
        $sql_insert->closeCursor();
    }
    $_SESSION['isAbonnement'] = $isAbonnement;

     ///////////////////////////////UPDATE
     $sql_update = $bdd->prepare("UPDATE membres SET isAbonnement=? WHERE id=?");
     $sql_update->execute(array(
        $isAbonnement,
        $id_oo
     ));
     $sql_update->closeCursor();

    if (!empty($code_promotion)) {
        ///////////////////////////////SELECT
        $req_select = $bdd->prepare("SELECT * FROM codes_promotion WHERE numero_code=?");
        $req_select->execute(array($code_promotion));
        $ligne_select_c = $req_select->fetch();
        $req_select->closeCursor();

        $new_quant = $ligne_select_c['nbr_utilisation_en_cours'] + 1;

        ///////////////////////////////UPDATE
        $sql_update = $bdd->prepare("UPDATE codes_promotion SET nbr_utilisation_en_cours=? WHERE numero_code=?");
        $sql_update->execute(array(
            $new_quant,
            $code_promotion
        ));
        $sql_update->closeCursor();

        ///////////////////////////////INSERT
        $sql_insert = $bdd->prepare("INSERT INTO membres_codes_promo
                (id_membre,
                pseudo,
                code_promo,
                date
                )
                VALUES (?,?,?,?)");
        $sql_insert->execute(array(
            $id_oo,
            $user,
            $code_promotion,
            time()
        ));
        $sql_insert->closeCursor();
    }

    $sql_delete = $bdd->prepare("DELETE FROM membres_panier WHERE id_membre=?");
    $sql_delete->execute(array($id_oo));
    $sql_delete->closeCursor();

    $sql_delete = $bdd->prepare("DELETE FROM membres_panier_details WHERE id_membre=?");
    $sql_delete->execute(array($id_oo));
    $sql_delete->closeCursor();

    ////////////////MAIL CLIENT
    $de_nom = "$nomsiteweb"; //Nom de l'envoyeur
    $de_mail = "$emaildefault"; //Email de l'envoyeur
    $vers_nom = "$prenom_oo $nom_oo"; //Nom du receveur
    $vers_mail = "$mail_oo"; //Email du receveur
    $sujet = "Paiement sur $nomsiteweb"; //Sujet du mail
    $message_principalone = "
            <b>Bonjour,</b><br /><br />
            Vous avez effectué un paiement sur $nomsiteweb. <br /><br />
            Nous vous en remercions. <br /><br />
            $message_reservation
            La somme du paiement : " . $_SESSION['total_TTC'] . " Cfa<br /><br />
            Mode de paiement : " . $modepaiements . " <br /><br />
            Pour accéder à votre facture : <a href='" . $http . "" . $nomsiteweb . "/facture/" . $LAST_REFERENCE_FACTURE . "/" . $nomsiteweb . "' target='blank_' >FACTURE PDF</a> <br /><br />
            Pour accéder à vos réservations : <a href='" . $http . "" . $nomsiteweb . "/Mes-reservations' target='blank_' >Consulter la réservation</a> <br /><br />
            Cordialement, l'équipe<br /><br />";
    mailsend($vers_mail, $vers_nom, $de_mail, $de_nom, $sujet, $message_principalone);

    ////////////////MAIL ADMINISTRATEUR
    $de_nom = "$prenom_oo $nom_oo"; //Nom de l'envoyeur
    $de_mail = "$mail_oo"; //Email de l'envoyeur
    $vers_nom = "$nomsiteweb"; //Nom du receveur
    $vers_mail = "$emaildefault"; //Email du receveur
    $sujet = "MAIL ADMINISTRATEUR : Vous avez reçut un paiement sur $nomsiteweb"; //Sujet du mail
    $message_principalone = "<b>Objet:</b> $sujet<br /><br />
            <b>Bonjour,</b><br /><br />
            Vous avez reçut une nouveau paiement.<br /><br />
            <b>Voici les informations du client concerné :</b><br /><br />
            Date d'édition : $nowtime<br /><br />
            Pseudo client : $user <br />
            Nom : " . $nom_oo . " <br />
            Prénom : " . $prenom_oo . " <br /><br />
            La somme du paiement : " . $_SESSION['total_TTC'] . " Cfa<br /><br />
            Mode de paiement : " . $modepaiements . " <br /><br />
            $information_mail
            Pour accéder à là facture en PDF : <a href='" . $http . "" . $nomsiteweb . "/facture/" . $LAST_REFERENCE_FACTURE . "/" . $nomsiteweb . "' target='blank_' >FACTURE PDF</a><br />
            Pour accéder à la modification de la facture : <a href='" . $http . "" . $nomsiteweb . "/administration/index-admin.php?page=Facturations&action=Facture&idaction=" . $id_url . "' target='blank_'>VISUALISER LA FACTURE</a><br />
            Pour accéder à la fiche du client : <a href='" . $http . "" . $nomsiteweb . "/administration/index-admin.php?page=Membres&action=modifier&amp;idaction=" . $id_oo . "' target='blank_'>FICHE DU MEMBRE</a><br /><br />

            Cordialement, l'équipe<br /><br />";
    mailsend($vers_mail, $vers_nom, $de_mail, $de_nom, $sujet, $message_principalone);

    ///////////////////////////////INCLUDE RETOUR AFFICHAGE

    if ($ajax != "oui") {
        header('location: /Traitements-informations');
    }
}


unset($_SESSION['id_commande']);
unset($_SESSION['code_promo']);
unset($_SESSION['remise_panier_facture']);
unset($_SESSION['total_TTC']);
unset($_SESSION['code_promotion_montant']);
unset($_SESSION['id_colis']);
unset($_SESSION['url']);
