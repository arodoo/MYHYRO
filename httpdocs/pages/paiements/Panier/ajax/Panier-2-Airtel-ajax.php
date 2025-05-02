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

$prix = $_POST['prix'];
$id_page_panier = $_POST['id_page_panier'];
$type_action = $_POST['type_action'];
$telephone_airtel = $_POST['telephone_airtel'];


// <REPONSE><INTERFACEID>BAKOAI</INTERFACEID><REF>RF00</REF> <REFERENCE_MARCHAND>RF00</REFERENCE_MARCHAND><TYPE>1</TYPE><STATUT>200</STATUT><OPERATEUR>AM</OPERATEUR><TEL_CLIENT>074505372</TEL_CLIENT> <NUMERO_CLIENT>074505372</NUMERO_CLIENT><TOKEN></TOKEN><MESSAGE>Success. 24/10/01 19:36:59</MESSAGE></REPONSE>
$req_select = $bdd->prepare("SELECT * FROM membres_panier WHERE id_membre=? limit 1");
$req_select->execute(array($id_oo));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();

$data_random = generateRandomCode();

$reference = 'RF' . $id_oo . 'C' . $ligne_select['id'] . "$data_random";

$sql_update = $bdd->prepare("UPDATE membres_panier SET
        telephone_airtel=?,
        ref_airtel=?
        WHERE id=?");
$sql_update->execute(
  array(
    $telephone_airtel,
    $reference,
    $ligne_select['id']
  )
);
$sql_update->closeCursor();



// Vérifier si le numéro existe déjà pour ce membre
$req_select_tel = $bdd->prepare("SELECT * FROM membres_telephone_artiel WHERE id_membre = ? AND telephone = ?");
$req_select_tel->execute(array($id_oo, $telephone_airtel));
$existe = $req_select_tel->fetch();
$req_select_tel->closeCursor();

// Si le numéro n'existe pas, on l'insère
if (!$existe) {
  $req_insertion = $bdd->prepare("INSERT INTO membres_telephone_artiel (id_membre, telephone, created_at) VALUES (?, ?, NOW())");
  $req_insertion->execute(array($id_oo, $telephone_airtel));
  $req_insertion->closeCursor();
}

//https://api.mypvit.pro/ERS3O2QYDHC9CHH3/rest
//ACC_6785A0AFEA191
$url = 'https://api.mypvit.pro/XXCKLHUOZVJBM3UB/rest';
$data = array(
  'agent' => 'myhyro',
  'amount' => $prix,
  'product' => "PRODUIT-$id_page_panier",
  'reference' => $reference,
  'service' => 'RESTFUL',
  'callback_url_code' => 'WFGTC',
  'customer_account_number' => $telephone_airtel,
  'merchant_operation_account_code' => 'ACC_680F6406D78AD',
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
  // Successfully decoded JSON
  $statut = $responseData['status'];
  $transactionId = $responseData['transactionId'];
  $status_code = $responseData['status_code'];
  $Message = $responseData['message'];

  if ($Message == "Le N de tlphone du client:   Oprateur: AM est incorrect") {
    $Message = "Veuillez saisir le numéro au format 077XXXXXX ou 074XXXXXX sans mettre d'espace";
  }

  $retour = $status_code == "200" ? 'ok' : "";

  if($status_code == "200"){

    $req_select = $bdd->prepare("SELECT * FROM membres_panier WHERE id_membre=?");
    $req_select->execute(array($id_oo));
    $ligne_select = $req_select->fetch();
    $req_select->closeCursor();
    $_SESSION['id_liv'] = $ligne_select['id_livraison'];
    $id_paiement = $ligne_select['id_paiement'];
    $id_paiement_pf = $ligne_select['id_paiement_pf'];

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

    


    $result = array("Texte_rapport" => "$Message", "retour_validation" => "$retour", "retour_lien" => "$status_code", "reference" => "$reference");
  }else{
    $result = array("Texte_rapport" => "$Message", "retour_validation" => "$retour", "retour_lien" => "$status_code");
  }

} else {
  // JSON decoding failed
  $result = array("Texte_rapport" => "Error", "retour_validation" => "");
}

$result = json_encode($result);
echo $result;

ob_end_flush();
