<?php
ob_start();

////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../Configurations_bdd.php');
require_once('../../Configurations.php');
require_once('../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction = "../../";
require_once('../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

function getNumbers($input)
{
    // Use a regular expression to capture the numbers between "RF" and "C"
    preg_match('/RF(\d+)C/', $input, $matches);

    // If there is a match, return the captured numbers
    return isset($matches[1]) ? $matches[1] : null;
}




$data_received = file_get_contents("php://input");
$data_received_xml = new SimpleXMLElement($data_received);

$ligne_response = $data_received_xml[0];
$interface = $ligne_response->INTERFACEID;
$client = $ligne_response->NUMERO_CLIENT;
$reference = $ligne_response->REFERENCE_MARCHAND;
$Message = $ligne_response->MESSAGE;
$statut = $ligne_response->STATUT;
$token_r = $ligne_response->TOKEN;

$id_oo = getNumbers($reference);

if ($statut == "200") {
    $modepaiements = "Airtel money";
    include('Traitements-actions.php');
}

ob_end_flush();
