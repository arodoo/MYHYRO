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
  \*****************************************************/

$id = $_POST['id'];
$statut = $_POST['statut'];
$statut_2 = $_POST['statut_2'];
$message = $_POST['message'];
$poids = $_POST['poids'];
$notes = $_POST['notes'];
$restant_payer = $_POST['restant_payer'];
$restant_rembourser = $_POST['restant_rembourser'];
$montant_rembourser = $_POST['montant_rembourser'];
$montant_recu = $_POST['montant_recu'];
$montant_paye_client = $_POST['montant_paye_client'];
$statut_paiement = $_POST['statut_paiement'];
//$douane_et_transport_reel = $_POST['douane_et_transport_reel'];
$statut_expedition = $_POST['statut_expedition'];
$dette_payee_pf = $_POST['dette_payee_pf'];
$dette_payee_pf2 = $_POST['dette_payee_pf2'];
$dette_payee_pf3 = $_POST['dette_payee_pf3'];
$date_de_reception = $_POST['date_de_reception'];
$moyen_d_encaissement = $_POST['moyen_d_encaissement'];
$regulariser = $_POST['regulariser'];
$moyen_de_remboursement = $_POST['moyen_de_remboursement'];
$total_rembourse = $_POST['total_rembourse'];
$date_rem = $_POST['date_rem'];
$commentaire_livraison = $_POST['commentaire_livraison'];
$echeance_du = $_POST['echeance_du'];
$adresse_liv = $_POST['adresse_liv'];
$adresse_fac = $_POST['adresse_fac'];
$annuler_commande = $_POST['annuler_commande'];
$lot_expedition = $_POST['lot_expedition'];
$douane_a_la_liv = $_POST['douane_a_la_livraison'];
if (isset($_POST['date_envoi'])) {
    $date_envoi = strtotime($_POST['date_envoi']);
} else {
    $date_envoi = null;
}
$motif_encaissement = $_POST['motif_encaissement'];
$motif_remboursement = $_POST['motif_remboursement'];
$now = time();
$mode_encaissement = $_POST['mode_encaissement'];


if (isset($user)) {
    if(isset($id)){


        $sql_update = $bdd->prepare("UPDATE membres_commandes SET
        statut_2=?,
        message=?,
        statut_expedition=?,
        dette_payee_pf=?,
        dette_payee_pf2=?,
        dette_payee_pf3=?,
        poids=?,
        notes=?,
        restant_payer=?,
        restant_rembourser = ?,
        montant_rembourser=?,
        statut_paiement=?,
        adresse_liv = ?,
        adresse_fac = ?,
        commentaire_livraison=?,
        lot_expedition=?,
        date_envoi=?,
        douane_a_la_liv=?
        WHERE id=?");

        $sql_update->execute(
            array(
                $statut_2,
                $message,
                $statut_expedition,
                $dette_payee_pf,
                $dette_payee_pf2,
                $dette_payee_pf3,
                $poids,
                $notes,
                $restant_payer,
                $restant_rembourser,
                $montant_rembourser,
                $statut_paiement,
                $adresse_liv,
                $adresse_fac,
                $commentaire_livraison,
                $lot_expedition,
                $date_envoi,
                $douane_a_la_liv,
                intval($id)
            )
        );
        $sql_update->closeCursor();

        if($statut_2 == "10"){
            //Facture
            $sql_update = $bdd->prepare("UPDATE membres_prestataire_facture SET statut = ? WHERE id_commande = ?");
            $sql_update->execute(array("Activée", intval($id)));
            $sql_update->closeCursor();
        }

        if(!empty($annuler_commande) && $annuler_commande == "oui"){
            $sql_update = $bdd->prepare("UPDATE membres_commandes SET
        statut_2=?,
        /* sous_total = ?, */
        prix_total = ?
      /*   prix_expedition = ? */
        WHERE id=?");

        $sql_update->execute(
            array(
                "3",
                /* 0, */
                0,
                /* 0, */
                intval($id)
            )
        );
        $sql_update->closeCursor();
        }

        $sql_update = $bdd->prepare("INSERT INTO admin_commandes_historique
        (
            id_commande, 
            id_membre,
            pseudo,
            date
        )
        VALUES (?,?,?,?)");
    $sql_update->execute(
        array(
            $id,
            $id_oo,
            $user, 
            $now
        )
    );
    $sql_update->closeCursor();

    if(!empty($montant_recu)){

        $montant_paye_client = $montant_paye_client + $montant_recu ;

        $sql_update = $bdd->prepare("UPDATE membres_commandes SET
        montant_paye_client=?
        WHERE id=?");

        $sql_update->execute(
            array(
                $montant_paye_client,
                intval($id)
            )
        );
        $sql_update->closeCursor();

        $sql_update = $bdd->prepare("INSERT INTO membres_transactions_commande
        ( 
            id_membre,
            id_commande,
            date,
            type,
            moyen,
            montant,
            echeance_du,
            motif,
            mode_encaissement
        )
        VALUES (?,?,?,?,?,?,?,?,?)");
    $sql_update->execute(
        array(
            $id_oo,
            $id,
            $date_de_reception,
            "Paiement",
            $moyen_d_encaissement,
            $montant_recu,
            $echeance_du,
            $motif_encaissement,
            $mode_encaissement
        )
    );
    $sql_update->closeCursor();
    }

    if(!empty($regulariser)){

        $total_rembourse = floatval($total_rembourse) + floatval($regulariser);

        $sql_update = $bdd->prepare("UPDATE membres_commandes SET
        total_rembourse=?
        WHERE id=?");

        $sql_update->execute(
            array(
                $total_rembourse,
                intval($id)
            )
        );
        $sql_update->closeCursor();

        $sql_update = $bdd->prepare("INSERT INTO membres_transactions_commande
        ( 
            id_membre,
            id_commande,
            date,
            type,
            moyen,
            montant,
            motif
        )
        VALUES (?,?,?,?,?,?,?)");
    $sql_update->execute(
        array(
            $id_oo,
            $id,
            $date_rem,
            "Remboursement",
            $moyen_de_remboursement,
            $regulariser,
            $motif_remboursement
        )
    );
    $sql_update->closeCursor();
    }

        $result = array("Texte_rapport" => "Modifié!", "retour_validation" => "ok", "retour_lien" => "");
    }else{
        $result = array("Texte_rapport" => "Erreur", "retour_validation" => "non", "retour_lien" => "");
    }
    
    $result = json_encode($result);
    echo $result;
} else {
    header('location: /index.html');
}



ob_end_flush();
?>