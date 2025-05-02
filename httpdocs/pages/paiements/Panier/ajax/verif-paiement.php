<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../../../Configurations_bdd.php');
require_once('../../../../Configurations.php');
require_once('../../../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction = "../../../../";
require_once('../../../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

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


// <REPONSE><INTERFACEID>BAKOAI</INTERFACEID><REF>RF00</REF> <REFERENCE_MARCHAND>RF00</REFERENCE_MARCHAND><TYPE>1</TYPE><STATUT>200</STATUT><OPERATEUR>AM</OPERATEUR><TEL_CLIENT>074505372</TEL_CLIENT> <NUMERO_CLIENT>074505372</NUMERO_CLIENT><TOKEN></TOKEN><MESSAGE>Success. 24/10/01 19:36:59</MESSAGE></REPONSE>

$reference = $_POST["reference"];

if (empty($_POST["reference"])) {

  $req_select = $bdd->prepare("SELECT * FROM membres_panier WHERE id_membre=?");
  $req_select->execute(array($id_oo));
  $ligne_select = $req_select->fetch();
  $req_select->closeCursor();

  $reference = $ligne_select["ref_airtel"];
}

//https://api.mypvit.pro/XYLT0GWR5DNAOIHO/status?transactionId=$reference&accountOperationCode=ACC_6785A0AFEA191&transactionOperation=PAYMENT

$url = "https://api.mypvit.pro/C9L1MHDTER8JAU4Q/status?transactionId=$reference&accountOperationCode=ACC_680F6406D78AD&transactionOperation=PAYMENT";

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "X-Secret: $cle_secret_airtel"
));

$response = curl_exec($ch);

curl_close($ch);

$responseData = json_decode($response, true);

if (json_last_error() === JSON_ERROR_NONE) {

  $status = $responseData['status'];

  if ($status == 'FAILED') {
    $result = array("Texte_rapport" => "Paiement refusé", "retour_validation" => "non", "retour_lien" => "/", "statut" => "$status");
  } elseif ($status == 'SUCCESS') {

    $_SESSION['last_mode_paiement'] = "Airtel money";
   

    
    // $ajax = "oui";
    // $modepaiements = "Airtel money";
    // include('../../Traitements-actions.php');

    if (!empty($_SESSION['id_commande'])) {
      $_SESSION['last_commande'] = $_SESSION['id_commande'];
      ///////////////////////////////UPDATE
      $sql_update = $bdd->prepare("UPDATE membres_commandes SET 
       adresse_liv=?,
       adresse_fac=?
       WHERE id=?");
      $sql_update->execute(array(
        $_SESSION['address_liv'],
        $_SESSION['address_fac'],
        intval($_SESSION['id_commande'])
      ));
      $sql_update->closeCursor();
    }

    if (!empty($_SESSION['id_colis'])) {
      ///////////////////////////////UPDATE
      $sql_update = $bdd->prepare("UPDATE membres_colis SET   
               adresse_liv=?,
               adresse_fac=?
               WHERE id=?");
      $sql_update->execute(array(
        $_SESSION['address_liv'],
        $_SESSION['address_fac'],
        intval($_SESSION['id_colis'])
      ));
      $sql_update->closeCursor();
    }

    $req_select = $bdd->prepare("SELECT * FROM membres WHERE id=?");
    $req_select->execute(array($id_oo));
    $ligne_select_c = $req_select->fetch();
    $req_select->closeCursor();

    $_SESSION['isAbonnement'] = $ligne_select_c['isAbonnement'];

    unset($_SESSION['id_commande']);
    unset($_SESSION['code_promo']);
    unset($_SESSION['remise_panier_facture']);
    unset($_SESSION['total_TTC']);
    unset($_SESSION['code_promotion_montant']);
    unset($_SESSION['id_colis']);
    unset($_SESSION['url']);

    $result = array("Texte_rapport" => "Paiement validé", "retour_validation" => "ok", "statut" => "$status", "retour_lien" => "/Traitements-informations");
  } else if ($status == 'PENDING') {
    $status = 0;
  }
} else {
  // JSON decoding failed
  $result = array("Texte_rapport" => "error JSON", "retour_validation" => "ok", "statut" => "", "retour_lien" => "");
}


$result = json_encode($result);
echo $result;

ob_end_flush();
