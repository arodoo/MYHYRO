<?php
require_once('../../Configurations_bdd.php');
include('../../Configurations.php');

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

function mailsend($vers_mail, $vers_nom, $de_mail, $de_nom, $sujet, $message_principalone){

global $bdd;

//Informations de la configuration e-mail
///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM configuration_email WHERE id=?");
$req_select->execute(array("1"));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$entete = $ligne_select['entete'];
$pieddepage = $ligne_select['pieddepage'];
$login_smtp_site = $ligne_select['login_smtp_site'];
$password_smtp_site = $ligne_select['password_smtp_site'];
$nomsiteweb = $ligne_select['nom_siteweb'];
$SMTPDebug = $ligne_select['SMTPDebug'];
$LISTE_MAIL_CC = $ligne_select['LISTE_MAIL_CC'];

if(!empty($logo_mail)){
$message_principalone_ .= "<a href='https://".$nomsiteweb."' target='blank_'><img src='https://".$nomsiteweb."/images/mail/".$logo_mail."' alt='".$logo_mail."'/></a><br /><br />";
}

//EN-TÃŠTE ET PIED DE PAGE 
//$message_principalone_formate .= "$entete <br />";
$message_principalone_formate .= "$message_principalone <br />";
$message_principalone_formate .= "$pieddepformateage";

global $site_web,$login_smtp,$password_smtp;

date_default_timezone_set('Etc/UTC');
require '../../function/mails/PHPMailerAutoload.php';
 
//CREATION DE l'INSTANCE
$mail = new PHPMailer;
//Tell PHPMailer to use SMTP
$mail->isSMTP();
$mail->SMTPDebug = 2;
//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';

//SMTP
$mail->Host = "123webmaster.fr";
$mail->Port = 587; // Port 25, 465 or 587
//Whether to use SMTP authentication
$mail->SMTPAuth = true;
$mail->Username = 'support@123webmaster.fr';//$login_smtp_site;
$mail->Password = 'nWjEQpknHSXxF';//$password_smtp_site;
$mail->SMTPSecure = 'tls';     

//CHARSET
$mail->CharSet = 'utf-8';

//VARIABLES
//Set who the message is to be sent from
$mail->setFrom("$de_mail", "$de_nom");
//Set an alternative reply-to address
$mail->addReplyTo("$de_mail", "$de_nom");
//Set who the message is to be sent to
$mail->addAddress("$vers_mail", "$vers_nom");
//Set the subject line
$mail->Subject = "$sujet";

//MESSAGE
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML("$message_principalone_formate");
//Replace the plain text body with one created manually
$mail->AltBody = "$message_principalone_formate";
//Attach an image file

///////////unsubscribe
//$mail->AddCustomHeader("List-Unsubscribe: <mailto:web-qhK1ih@mail-tester.com?subject=Unsubscribe>, <http://mydomain.com/unsubscribe.php?mailid=1234>");
//DKIM
 //This should be the same as the domain of your From address
$mail->DKIM_domain = "$nomsiteweb";
//Path to your private key file
$mail->DKIM_private = '../../../dkim.private';
//Set this to your own selector
$mail->DKIM_selector = 'dkim';
//If your private key has a passphrase, set it here
$mail->DKIM_passphrase = '';
//The identity you're signing as - usually your From address
$mail->DKIM_identity = $mail->From;

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}

}

 $vers_mail = "berthelet.fabien@orange.fr";
 $vers_nom = "Codeur";
 $de_mail = "contact@123demenagement.fr";
 $de_nom = "123demenagement.fr";
 $sujet = "L'entreprise peut venir au diner que vous organiser avec toute l'équipe!";
 $message_principalone = "Il faut vous apporter quoi à manger ???????
 Bonne soirée à toi, Fabien";

 mailsend($vers_mail, $vers_nom, $de_mail, $de_nom, $sujet, $message_principalone); 

?>

