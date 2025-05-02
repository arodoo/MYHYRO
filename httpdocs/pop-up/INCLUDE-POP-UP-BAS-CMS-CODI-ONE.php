<?php

////SI MODULE COOKIES VALIDATION ACTIVE
if($cookies_validation_module == "oui" && !isset($user) ){
include(''.$dir_fonction.'pop-up/cookies/cookies_popup.php');
}

if(!empty($user)){
////DECONNEXION
include(''.$dir_fonction.'pop-up/deconnexion/deconnexion_popup.php');
}

include(''.$dir_fonction.'pop-up/demande-souhait/demande-souhait.php');
include(''.$dir_fonction.'pop-up/login/login_popup.php');
include(''.$dir_fonction.'pop-up/mot-de-passe-perdu/password_popup.php');
include(''.$dir_fonction.'pop-up/mot-de-passe-confirmation/password_confirmation_popup.php');
include(''.$dir_fonction.'pop-up/inscription/inscription_popup.php');

if($_GET['page'] == 'annuaire-fiche'){ 
    include(''.$dir_fonction.'pop-up/avis-annonce/avis-popup.php'); 
}


// if($_GET['page'] == 'Mes-biens'){ 
//     include(''.$dir_fonction.'panel/Mes-biens/suppression-popup.php'); 
// }
?>