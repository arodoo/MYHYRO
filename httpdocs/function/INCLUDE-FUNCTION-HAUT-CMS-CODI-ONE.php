<?php

////FUNCTIONS
include(''.$dir_fonction.'function/title-metas/page-title-metas.php');
include(''.$dir_fonction.'function/erreurs-php/affichage_erreurs_php.php');
include(''.$dir_fonction.'function/404/404r_generateur.php');
include(''.$dir_fonction.'function/301/301.php');

include(''.$dir_fonction.'function/logs/function-logs-historiques.php');

include(''.$dir_fonction.'function/php_pass.php');
include(''.$dir_fonction.'function/mails/mail-send.php');
include(''.$dir_fonction.'function/mails/mail-bibliotheques.php');
include(''.$dir_fonction.'function/pagination/pagination.php');
include(''.$dir_fonction.'function/inscription/creation_compte.php');
include(''.$dir_fonction.'function/algo_caracteres.php');
include(''.$dir_fonction.'function/function_rapport_bloc.php');
include(''.$dir_fonction.'function/mails/PHPMailerAutoload.php');
include(''.$dir_fonction.'function/page/page-bandeaux/bandeaux.php');

include(''.$dir_fonction.'function/inscription/compte-debloque.php');

include(''.$dir_fonction.'function/cara_replace_function.php');

//include('pages/Newsletter/Abonnement-lettre-information.php');
include(''.$dir_fonction.'function/function_ajout_panier.php');
include(''.$dir_fonction.'function/function_ajout_produit_panier.php');
include(''.$dir_fonction.'function/function_update_panier.php');
include(''.$dir_fonction.'function/function_update_commande.php');
//include(''.$dir_fonction.'function/avis.php');

?>