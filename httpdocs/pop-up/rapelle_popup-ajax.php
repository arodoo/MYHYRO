<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../Configurations_bdd.php');
require_once('../Configurations.php');
require_once('../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction= "../";
require_once('../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

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

$mail_rappel = $_POST['mail_rappel'];
$nom_rappel = $_POST['nom_rappel'];
$prenom_rappel = $_POST['prenom_rappel'];
$tel_rappel = $_POST['tel_rappel'];

if(!empty($mail_rappel) && !empty($nom_rappel) && !empty($prenom_rappel) && !empty($tel_rappel) ){

//////////////////////////////////////////////////////////////////////MAIL ADMINISTRATEUR DU SITE INTERNET
//Envoi de l'email test
$de_nom = "$nom_rappel $prenom_rappel"; //Nom de l'envoyeur
$de_mail = "$mail_rappel"; //Email de l'envoyeur
$vers_nom = "$nomsiteweb"; //Nom du receveur
$vers_mail = "$emaildefault"; //Email du receveur
$sujet = "Demande à contacter sur $nomsiteweb";

$message_principalone = "
Bonjour,<br /><br />
Une personne demande à être rappelé au ".$tel_rappel.".<br /><br />
<u>Informations :</u> <br />
Nom : $nom_rappel <br />
Prénom : $prenom_rappel <br />
Mail : $mail_rappel<br /><br />
Cordialement,<br /><br />
";

mailsend($vers_mail, $vers_nom, $de_mail, $de_nom, $sujet, $message_principalone);
//////////////////////////////////////////////////////////////////////MAIL ADMINISTRATEUR DU SITE INTERNET

	$result = array("Texte_rapport"=>"Demande envoyée !","retour_validation"=>"ok","retour_lien"=>$lasturl);

}else{
	$result = array("Texte_rapport"=>"<span class='uk-icon-warning' ></span> Renseignez tous les champs !","retour_validation"=>"","retour_lien"=>"");

}


$result = json_encode($result);
echo $result;

ob_end_flush();
?>