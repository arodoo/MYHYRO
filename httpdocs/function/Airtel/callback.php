<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../Configurations_bdd.php');
require_once('../../Configurations.php');
require_once('../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction = "../../";
require_once('../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

$lasturl = $_SERVER['HTTP_REFERER'];

// Receives JSON data from another server
$jsonData = file_get_contents('php://input');

// Decode the JSON data into a PHP array
$data = json_decode($jsonData, true);

// Check if the required keys are present
if (isset($data['transactionId'], $data['merchantReferenceId'], $data['status'], $data['amount'], $data['customerID'], $data['fees'], $data['totalAmount'], $data['chargeOwner'], $data['freeInfo'], $data['transactionOperation'], $data['code'], $data['operator'])) {
    $transactionId = $data['transactionId'];
    $merchantReferenceId = $data['merchantReferenceId'];
    $status = $data['status'];
    $amount = $data['amount'];
    $customerID = $data['customerID'];
    $fees = $data['fees'];
    $totalAmount = $data['totalAmount'];
    $chargeOwner = $data['chargeOwner'];
    $freeInfo = $data['freeInfo'];
    $transactionOperation = $data['transactionOperation'];
    $code = $data['code'];
    $operator = $data['operator'];

    if ($status == 'SUCCESS') {

        $response = [
            'responseCode' => $code,
            'transactionId' => $transactionId
        ];

        $id_oo = intval($freeInfo);

        ///////////////////////////////SELECT ABONNEMENT
        $req_selectap = $bdd->prepare("SELECT * FROM membres WHERE id=?");
        $req_selectap->execute(array($id_oo));
        $ligne_selectap = $req_selectap->fetch();
        $req_selectap->closeCursor();

        $user = $ligne_selectap["pseudo"];

        $_SESSION['total_TTC'] = round($totalAmount) . " F CFA";

         $ajax = "oui";
         $modepaiements = "Airtel money";
         include('../../pages/paiements/Traitements-actions.php');
    } else if ($status == 'PENDING') {
        $statut = 0;
        $response = [
            'responseCode' => $code,
            'transactionId' => $transactionId
        ];
    } else if ($status == 'FAILED') {
        $statut = 0;

        $response = [
            'responseCode' => $code,
            'transactionId' => $transactionId
        ];
    }

    // Process the data as needed
    // For example, you can save it to a database or use it in your application

    // Send a response back to the client

} else {
    // Send an error response if required keys are missing
    $response = [
        'status' => 'error',
        'message' => 'Invalid data received'
    ];
}

// Set the content type to application/json
header('Content-Type: application/json');

// Send the JSON response
echo json_encode($response);

ob_end_flush();
