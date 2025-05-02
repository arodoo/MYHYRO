<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('httpdocs/Configurations_bdd.php');
require_once('httpdocs/Configurations.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction = "httpdocs/";
require_once('httpdocs/function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

function generateRandomCode($length = 5)
{
    // Available characters (numbers, lowercase and uppercase letters)
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    // Generate random code by shuffling the characters
    $randomCode = '';
    for ($i = 0; $i < $length; $i++) {
        $randomIndex = random_int(0, strlen($characters) - 1);
        $randomCode .= $characters[$randomIndex];
    }

    return $randomCode;
}



$req_boucle = $bdd->prepare("SELECT * FROM membres_commandes WHERE (id_paiement_pf = ? OR id_paiement_pf = ?) AND (dette_payee_pf2 = ?) ");
$req_boucle->execute(array("3", "5", "Non payé"));
while ($ligne_boucle = $req_boucle->fetch()) {
    $idoneinfos = $ligne_boucle['id'];
    $dette_montant_pf2 = $ligne_boucle['dette_montant_pf2'];

    // Extract the amount and date from $dette_montant_pf2
    preg_match('/(\d+)\sF\sCFA\sle\s(\d{2}-\d{2}-\d{4})/', $dette_montant_pf2, $matches);

    if (!empty($matches)) {
        $montant = $matches[1]; // Extracted amount
        $date = $matches[2];    // Extracted date
    } else {
        $montant = null;
        $date = null;
    }

    if ($date == date("d-m-Y", time())) {
        $prix = $montant;
        $id_page_panier = $ligne_boucle['panier_id'];


        $req_select_tel = $bdd->prepare("SELECT * FROM membres_transactions_commande WHERE id_commande = ?");
        $req_select_tel->execute(array($idoneinfos));
        $existe = $req_select_tel->fetch();
        $req_select_tel->closeCursor();

        $telephone_airtel = $existe['telephone_airtel'];

        $data_random = generateRandomCode();

        $reference = 'RF' . $id_oo . 'C' . $ligne_select['id'] . "$data_random";

        $url = 'https://api.mypvit.pro/ERS3O2QYDHC9CHH3/rest';
        $data = array(
            'agent' => 'myhyro',
            'amount' => $prix,
            'product' => "PRODUIT-$id_page_panier",
            'reference' => $reference,
            'service' => 'RESTFUL',
            'callback_url_code' => 'WFGTC',
            'customer_account_number' => $telephone_airtel,
            'merchant_operation_account_code' => 'ACC_6785A0AFEA191',
            'transaction_type' => 'PAYMENT',
            'owner_charge' => 'MERCHANT',
            'free_info' => $id_oo,
            'success_redirection_url_code' => '/success',
            'failed_redirection_url_code' => '/failed',
        );

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "X-Secret: $cle_secret_airtel",
            'X-Callback-MediaType: application/json',
            'Content-Type: application/json'
        ));

        $response = curl_exec($ch);

        curl_close($ch);

        $responseData = json_decode($response, true);

        if (json_last_error() === JSON_ERROR_NONE) {

            $sql_update = $bdd->prepare("UPDATE membres_commandes SET
        ref_airtel2=?
        WHERE id=?");
            $sql_update->execute(
                array(
                    $reference,
                    $idoneinfos
                )
            );
            $sql_update->closeCursor();

            $status_code = $responseData['status_code'];
            $retour = $status_code == "200" ? 'ok' : "";

            if ($status_code == "200") {
                $result = array("Texte_rapport" => "$Message", "retour_validation" => "$retour", "retour_lien" => "$status_code", "reference" => "$reference");
            } else {
                $result = array("Texte_rapport" => "$Message", "retour_validation" => "$retour", "retour_lien" => "$status_code");
            }
        } else {
            // JSON decoding failed
            $result = array("Texte_rapport" => "Error", "retour_validation" => "");
        }
    }
}
$req_boucle->closeCursor();

$req_boucle = $bdd->prepare("SELECT * FROM membres_commandes WHERE (id_paiement_pf = ?) AND (dette_payee_pf3=?) ");
$req_boucle->execute(array("5", "Non payé"));
while ($ligne_boucle = $req_boucle->fetch()) {

    $idoneinfos = $ligne_boucle['id'];
    $dette_montant_pf2 = $ligne_boucle['dette_montant_pf3'];

    // Extract the amount and date from $dette_montant_pf2
    preg_match('/(\d+)\sF\sCFA\sle\s(\d{2}-\d{2}-\d{4})/', $dette_montant_pf2, $matches);

    if (!empty($matches)) {
        $montant = $matches[1]; // Extracted amount
        $date = $matches[2];    // Extracted date
    } else {
        $montant = null;
        $date = null;
    }

    if ($date == date("d-m-Y", time())) {
        $prix = $montant;
        $id_page_panier = $ligne_boucle['panier_id'];


        $req_select_tel = $bdd->prepare("SELECT * FROM membres_transactions_commande WHERE id_commande = ?");
        $req_select_tel->execute(array($idoneinfos));
        $existe = $req_select_tel->fetch();
        $req_select_tel->closeCursor();

        $telephone_airtel = $existe['telephone_airtel'];

        $data_random = generateRandomCode();

        $reference = 'RF' . $id_oo . 'C' . $ligne_select['id'] . "$data_random";

        $url = 'https://api.mypvit.pro/ERS3O2QYDHC9CHH3/rest';
        $data = array(
            'agent' => 'myhyro',
            'amount' => $prix,
            'product' => "PRODUIT-$id_page_panier",
            'reference' => $reference,
            'service' => 'RESTFUL',
            'callback_url_code' => 'WFGTC',
            'customer_account_number' => $telephone_airtel,
            'merchant_operation_account_code' => 'ACC_6785A0AFEA191',
            'transaction_type' => 'PAYMENT',
            'owner_charge' => 'MERCHANT',
            'free_info' => $id_oo,
            'success_redirection_url_code' => '/success',
            'failed_redirection_url_code' => '/failed',
        );

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "X-Secret: $cle_secret_airtel",
            'X-Callback-MediaType: application/json',
            'Content-Type: application/json'
        ));

        $response = curl_exec($ch);

        curl_close($ch);

        $responseData = json_decode($response, true);

        if (json_last_error() === JSON_ERROR_NONE) {

            $sql_update = $bdd->prepare("UPDATE membres_commandes SET
        ref_airtel3=?
        WHERE id=?");
            $sql_update->execute(
                array(
                    $reference,
                    $idoneinfos
                )
            );
            $sql_update->closeCursor();

            $status_code = $responseData['status_code'];
            $retour = $status_code == "200" ? 'ok' : "";

            if ($status_code == "200") {
                $result = array("Texte_rapport" => "$Message", "retour_validation" => "$retour", "retour_lien" => "$status_code", "reference" => "$reference");
            } else {
                $result = array("Texte_rapport" => "$Message", "retour_validation" => "$retour", "retour_lien" => "$status_code");
            }
        } else {
            // JSON decoding failed
            $result = array("Texte_rapport" => "Error", "retour_validation" => "");
        }
    }
}
$req_boucle->closeCursor();

$result = json_encode($result);
echo $result;


ob_end_flush();
