<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../../../Configurations_bdd.php');
require_once('../../../../Configurations.php');
require_once('../../../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction= "../../../../";
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

$id_panier_detail = $_POST['id_panier_detail'];
$id_page_panier = $_POST['id_page_panier'];
$type_action = $_POST['type_action'];



$_SESSION['paiement_pf'] = $_POST['paiement_pf'];

if(empty($_POST['paiement_pf'])){
  unset($_SESSION['paiement_pf']);
}

$req_select = $bdd->prepare("SELECT * FROM membres_panier WHERE id_membre=?");
$req_select->execute(array($id_oo));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();


$req_select = $bdd->prepare("SELECT count(*) as valid FROM membres_commandes WHERE user_id=? AND (statut='4' or statut='6') ");
$req_select->execute(array($id_oo));
$ligne_valid = $req_select->fetch();
$req_select->closeCursor();

$total_panier_frais_ttc = $ligne_select['Tarif_TTC'];

//var_dump($total_panier_frais_ttc);

if($ligne_valid['valid'] > 1){
  $max = $montant_maximum_en_plusieurs_fois_apres_1er_commande;
}else{
  $max = $montant_maximum_en_plusieurs_fois;
}

//var_dump($montant_minimum_en_plusieurs_fois, $max);
$total_panier_frais_ttc = $total_panier_frais_ttc-$_SESSION['frais_gestion_pf'];
if($total_panier_frais_ttc >= $montant_minimum_en_plusieurs_fois || $admin_oo == "1" || $_POST['paiement_pf'] == '2' || $_POST['paiement_pf'] == '1'){

  if($total_panier_frais_ttc <= $max || $admin_oo == "1" || $_POST['paiement_pf'] == '2' || $_POST['paiement_pf'] == '1'){
     //var_dump($ligne_select['id_paiement'], $total_panier_frais_ttc);
if(($_POST['paiement_pf'] == '2' || $_POST['paiement_pf'] == '4' || $_POST['paiement_pf'] == '6')){

  if($_POST['paiement_pf'] == '2'){
   
    $_SESSION['frais_gestion_pf'] = ($total_panier_frais_ttc)*($avancement_60_pourcent_frais_gestion/100);
      $apayer = round(($total_panier_frais_ttc+$_SESSION['frais_gestion_pf'])*($avancement_60_pourcent_taux_avance/100));
      $lereste = round(($total_panier_frais_ttc+$_SESSION['frais_gestion_pf']) - $apayer);

      $apayer = number_format($apayer, 0, '.', ' ');
      $lereste = number_format($lereste, 0, '.', ' ');
      $fechaActual = new DateTime();
      $date1 = $fechaActual->format('d-m-Y');
      $text = "$apayer F CFA le $date1 <br> $lereste F CFA à la livraison";
      $dette_pf = "$apayer F CFA le $date1";
      $dette_pf2 = "$lereste F CFA à la livraison";
      
  }elseif($_POST['paiement_pf'] == '4'){
    $_SESSION['frais_gestion_pf'] = ($total_panier_frais_ttc)*($paiement_2_fois_frais_gestion/100);

    $apayer =  round(($total_panier_frais_ttc+$_SESSION['frais_gestion_pf'])*($paiement_2_fois_taux_avance/100));
    $lereste = round(($total_panier_frais_ttc+$_SESSION['frais_gestion_pf']) - $apayer);

    $fechaActual = new DateTime();
    $date1 = $fechaActual->format('d-m-Y');
    $fechaActual->modify('+1 month');
    $date2 = $fechaActual->format('d-m-Y');
    $apayer = number_format($apayer, 0, '.', ' ');
    $lereste = number_format($lereste, 0, '.', ' ');
    $text = "$apayer F CFA le $date1 <br> $lereste F CFA le $date2";
    $dette_pf = "$apayer F CFA le $date1";
    $dette_pf2 = "$lereste F CFA le $date2";
    
  }elseif($_POST['paiement_pf'] == '6'){
    
    $_SESSION['frais_gestion_pf'] = ($total_panier_frais_ttc)*($paiement_3_fois_frais_gestion/100);
    $apayer =  round(($total_panier_frais_ttc+$_SESSION['frais_gestion_pf'])*($paiement_3_fois_taux_avance/100));
    $lereste = round((($total_panier_frais_ttc+$_SESSION['frais_gestion_pf']) - $apayer)/2);
    $lereste2 = round((($total_panier_frais_ttc+$_SESSION['frais_gestion_pf']) - $apayer)/2);
    $fechaActual = new DateTime();
    $date1 = $fechaActual->format('d-m-Y');
    $fechaActual->modify('+1 month');
    $date2 = $fechaActual->format('d-m-Y');
    $fechaActual->modify('+1 month');
    $date3 = $fechaActual->format('d-m-Y');
    $apayer = number_format($apayer, 0, '.', ' ');
    $lereste = number_format($lereste, 0, '.', ' ');
    $text = "$apayer F CFA le $date1 <br> $lereste F CFA le $date2 <br> $lereste F CFA le $date3";
    $dette_pf = "$apayer F CFA le $date1";
    $dette_pf2 = "$lereste F CFA le $date2";
    $dette_pf3 = "$lereste F CFA le $date3";
    
  }

  $result = array("Texte_rapport"=>"Mode de paiement plusieurs fois mise à jour.","retour_validation"=>"ok","retour_lien"=>"","text" => $text);

}elseif(($_POST['paiement_pf'] == '1' || $_POST['paiement_pf'] == '3' || $_POST['paiement_pf'] == '5')){

  if($_POST['paiement_pf'] == '1'){
    $_SESSION['frais_gestion_pf'] = ($total_panier_frais_ttc)*($avancement_60_pourcent_frais_gestion/100);
    $apayer =  round(($total_panier_frais_ttc+$_SESSION['frais_gestion_pf'])*($avancement_60_pourcent_taux_avance/100));
    $lereste = round(($total_panier_frais_ttc+$_SESSION['frais_gestion_pf']) - $apayer);
    $apayer = number_format($apayer, 0, '.', ' ');
      $lereste = number_format($lereste, 0, '.', ' ');
    $text = "$apayer F CFA maintenant <br> $lereste F CFA à la livraison";
   
    $dette_pf = "$apayer F CFA le $date1";
    $dette_pf2 = "$lereste F CFA à la livraison";
}elseif($_POST['paiement_pf'] == '3'){
  $_SESSION['frais_gestion_pf'] =($total_panier_frais_ttc)*($paiement_2_fois_frais_gestion/100);
  $apayer =  round(($total_panier_frais_ttc+$_SESSION['frais_gestion_pf'])*($paiement_2_fois_taux_avance/100));
  $lereste = round(($total_panier_frais_ttc+$_SESSION['frais_gestion_pf']) - $apayer);
  
  $fechaActual = new DateTime();
  $date1 = $fechaActual->format('d-m-Y');
  $fechaActual->modify('+1 month');
  $date2 = $fechaActual->format('d-m-Y');
  $apayer = number_format($apayer, 0, '.', ' ');
  $lereste = number_format($lereste, 0, '.', ' ');
  $text = "$apayer F CFA le $date1 <br> $lereste F CFA le $date2";
  $dette_pf = "$apayer F CFA le $date1";
  $dette_pf2 = "$lereste F CFA le $date2";
}elseif($_POST['paiement_pf'] == '5'){
  
  $_SESSION['frais_gestion_pf'] = ($total_panier_frais_ttc)*($paiement_3_fois_frais_gestion/100);
    $apayer =  round(($total_panier_frais_ttc+$_SESSION['frais_gestion_pf'])*($paiement_3_fois_taux_avance/100));
    $lereste = round((($total_panier_frais_ttc+$_SESSION['frais_gestion_pf']) - $apayer)/2);
    $lereste2 = round((($total_panier_frais_ttc+$_SESSION['frais_gestion_pf']) - $apayer)/2);

    
    $fechaActual = new DateTime();
    $date1 = $fechaActual->format('d-m-Y');
    $fechaActual->modify('+1 month');
    $date2 = $fechaActual->format('d-m-Y');
    $fechaActual->modify('+1 month');
    $date3 = $fechaActual->format('d-m-Y');
    $apayer = number_format($apayer, 0, '.', ' ');
    $lereste = number_format($lereste, 0, '.', ' ');
    $text = "$apayer F CFA le $date1 <br> $lereste F CFA le $date2 <br> $lereste F CFA le $date3";
    $dette_pf = "<b>$apayer</b> F CFA le $date1";
    $dette_pf2 = "$lereste F CFA le $date2";
    $dette_pf3 = "$lereste F CFA le $date3";
}

  $result = array("Texte_rapport"=>"Mode de paiement plusieurs fois mise à jour.","retour_validation"=>"ok","retour_lien"=>"", "text" => $text);

}else{
  $result = array("Texte_rapport"=>"Le mode paiement plusieurs fois ne correspond pas","retour_validation"=>"","retour_lien"=>"");
}
  }else{
    $result = array("Texte_rapport"=>"Maximum du paiement en plusieurs fois ".$max,"retour_validation"=>"","retour_lien"=>"");
  }
 
}else{
  $result = array("Texte_rapport"=>"Minimum du paiement en plusieurs fois ".$montant_minimum_en_plusieurs_fois,"retour_validation"=>"","retour_lien"=>"");
}

if(!empty($_SESSION['id_commande'])){

  ///////////////////////////////UPDATE
  $sql_update = $bdd->prepare("UPDATE membres_commandes SET 
  dette_montant_pf=?,
  dette_payee_pf=?,
  dette_montant_pf2=?,
  dette_payee_pf2=?,
  dette_montant_pf3=?,
  dette_payee_pf3=?
  WHERE id=?");
  $sql_update->execute(array(
  $dette_pf,
  'Non payé',
  $dette_pf2,
  'Non payé',
  $dette_pf3,
  'Non payé',
  $_SESSION['id_commande']));                     
  $sql_update->closeCursor();

}

$result = json_encode($result);
echo $result;

ob_end_flush();
?>