<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../../Configurations_bdd.php');
require_once('../../../Configurations.php');
require_once('../../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction= "../../../";
require_once('../../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

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

if(isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 1){

$entetemail = $_POST["entetemail"];
$pieddepage = $_POST["pieddepage"];
$nomsitewebp = $_POST["nomsitewebp"];
$emaildefault = $_POST["emaildefault"];
$LISTE_MAIL_CC = $_POST["LISTE_MAIL_CC"];

$login_smtp_site = $_POST["login_smtp_site"];
$password_smtp_site = $_POST["password_smtp_site"];

$Validation_openDKIM = $_POST["Validation_openDKIM"];
$Activation_du_TLS = $_POST["Activation_du_TLS"];

$SMTPDebug = $_POST["SMTPDebug"];

$nowtime = time ();

$resdomaine = "$nomsitewebp";
$restt = substr($resdomaine,0,7);
$resttt = substr($resdomaine,0,4);
$restttt = substr($resdomaine,0,11);

if($restt != "http://" && $resttt != "www." && $resttt != "https://" && !empty($emaildefault) ){

///////////////////////////////UPDATE
$sql_update = $bdd->prepare("UPDATE configuration_email SET 
	LISTE_MAIL_CC=?, 
	SMTPDebug=?, 
	Activation_du_TLS=?, 
	Validation_openDKIM=?, 
	login_smtp_site=?, 
	password_smtp_site=?, 
	entete=?, 
	nom_siteweb=?, 
	pieddepage=?, 
	auteur_miseajour=?, 
	date_miseajour=?, 
	email_default=?
	WHERE id=?");
$sql_update->execute(array(
	$LISTE_MAIL_CC, 
	$SMTPDebug, 
	$Activation_du_TLS, 
	$Validation_openDKIM, 
	$login_smtp_site, 
	$password_smtp_site, 
	$entetemail, 
	$nomsitewebp, 
	$pieddepage, 
	$user, 
	$nowtime, 
	$emaildefault,
	'1'));                     
$sql_update->closeCursor();

///////////////////////////////UPDATE
$sql_update = $bdd->prepare("UPDATE configurations_preferences_generales SET nom_siteweb=? WHERE id=?");
$sql_update->execute(array($nomsitewebp,1));                     
$sql_update->closeCursor();

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM membres WHERE pseudo=?");
$req_select->execute(array($user));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$mailauteur = $ligne_select['mail'];

//////////////////////////////////////////////////////////////////////A inclure sur la page FONCTION MAIL
$de_nom = "$nomsiteweb"; //Nom de l'envoyeur
$de_mail = "$emaildefault"; //Email de l'envoyeur
$vers_nom = "$user"; //Nom du receveur
$vers_mail = "$mailauteur"; //Email du receveur
$sujet = "E-mail (configuration)"; //Sujet du mail

$message_principalone = "<b>Objet:</b> $sujet<br /><br />
<b>Bonjour,</b><br /><br />
Ceci est un e-mail de test, afin de visualiser les changements appliqués!<br /><br />
Cordialement, l'équipe
";

mailsend($vers_mail, $vers_nom, $de_mail, $de_nom, $sujet, $message_principalone);
//////////////////////////////////////////////////////////////////////A inclure sur la page FONCTION MAIL

$result = array("Texte_rapport"=>"Action éffectuée avec succès !","retour_validation"=>"ok","retour_lien"=>"");

}elseif($restttt == "http://www." || $restt == "https://" || $restt == "http://" || $resttt == "www." ){
$result = array("Texte_rapport"=>"Seul votre nom de domaine brut doit être indiqué.","retour_validation"=>"","retour_lien"=>"");

}elseif(empty($emaildefault) ){
$result = array("Texte_rapport"=>"Vous devez indiquer une adresse mail !","retour_validation"=>"","retour_lien"=>"");
}


$result = json_encode($result);
echo $result;

}else{
header('location: /index.html');
}

ob_end_flush();
?>