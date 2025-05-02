<?php

////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('Configurations_bdd.php');
require_once('Configurations_modules.php');
require_once('Configurations.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
include('function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

require __DIR__ . '/vendor/autoload.php';

use \Ovh\Api;

 function envoi_sms($telephone, $message)
{

    $telephone = $telephone;
    $endpoint = 'ovh-eu';
    $applicationKey = "mkktbeGujVVy75O6";
    $applicationSecret = "YDheYFf0UWuAZ7xN2PoFo5Ib2TaiD0ZA";
    $consumer_key = "7mcQ7Jru9J07XUzUss9lmsll6x0YHarV";

    $conn = new Api($applicationKey,$applicationSecret,$endpoint,$consumer_key);

    $smsServices = $conn->get('/sms/');

    $content = (object) array(
        "charset"=> "UTF-8",
        "class"=> "phoneDisplay",
        "coding"=> "7bit",
        "message"=> $message,
        "noStopClause"=> false,
        "priority"=> "high",
        "receivers"=> [$telephone],
        "senderForResponse"=> true,
        "validityPeriod"=> 2880
    );
    $resultPostJob = $conn->post('/sms/'.$smsServices[0].'/jobs', $content);
    $smsJobs = $conn->get('/sms/'.$smsServices[0].'/jobs');

    return true;
}

envoi_sms("+33673340172", "Hey whats up");

//////////////////////////////////////////////////////BOUCLE SUR LES PRESTATAIRES POUR ENVOYER LE MAIL ASSOCIE A LA NOUVELLE DEMANDE
?>

