<?php

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

///////////////////////////////Informations des préférences générales
///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM configurations_preferences_generales");
$req_select->execute();
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$nom_proprietaire = $ligne_select['nom_proprietaire'];
$text_informations_footer = $ligne_select['text_informations_footer'];
$nomsiteweb = $ligne_select['nom_siteweb'];
$http = $ligne_select['http'];
// $valeurtva = $ligne_select['tva'];
$jeton_google = $ligne_select['jeton_google'];
$Page_Facebook = $ligne_select['Page_Facebook'];
$Page_twitter = $ligne_select['Page_twitter'];
$Page_Google = $ligne_select['Page_Google'];
$Page_Linkedin = $ligne_select['Page_Linkedin'];
$Chaine_Youtube = $ligne_select['Chaine_Youtube'];
$couleurFOND = $ligne_select['bloc_couleur_fond'];
$couleurbordure = $ligne_select['bloc_couleur_bordure'];
$bloc_couleur_complementaire = $ligne_select['bloc_couleur_complementaire'];
// $nbrpage = $ligne_select['nbr_ligne_page'];
$Google_analytic = $ligne_select['Google_analytic'];
// $contact_libelle_messagerie = $ligne_select['contact_libelle_messagerie'];
// $pseudo_contact_messagerie = $ligne_select['pseudo_contact_messagerie'];
$lien_conditions_generales = $ligne_select['lien_conditions_generales'];
$mod_inscription = $ligne_select['mod_inscription'];
// $Mod_antirobot = $ligne_select['Mod_antirobot'];
$inscriptionplusde18 = $ligne_select['inscriptionplusde18'];
$pseudo_manuel = $ligne_select['pseudo_manuel'];
$Mode_Passwordmodif = $ligne_select['Mode_Password'];

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

//EN-TÊTE ET PIED DE PAGE 
$message_principalone_formate .= "$entete <br />";
$message_principalone_formate .= "$message_principalone <br /><br />";
$message_principalone_formate .= "<br />$pieddepage";

global $site_web,$login_smtp,$password_smtp;

date_default_timezone_set('Etc/UTC');
// require 'function/mails/PHPMailerAutoload.php';
 
//CREATION DE l'INSTANCE
$mail = new PHPMailer;
//Tell PHPMailer to use SMTP
//$mail->isSMTP();
$mail->SMTPDebug = $SMTPDebug;
//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';

$mail->SMTPOptions = array(
'ssl' => array(
'verify_peer' => false,
'verify_peer_name' => false,
'allow_self_signed' => true
)
);

$mail->Host = "ssl://ds495.haisoft.net"; //$nomsiteweb
$mail->Port = 465; // Port 25, 465 or 587
//Whether to use SMTP authentication
$mail->SMTPAuth = true;
$mail->Username = "$login_smtp_site";//$login_smtp_site;
$mail->Password = "$password_smtp_site";//$password_smtp_site;
$mail->SMTPSecure = 'true';     
if($Activation_du_TLS == "oui"){
$mail->SMTPSecure = 'tls';     
}

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

//Message CC invisble
//$mail->AddBCC("$LISTE_MAIL_CC");

//MESSAGE
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML("$message_principalone_formate");
//Replace the plain text body with one created manually
$mail->AltBody = "$message_principalone_formate";
//Attach an image file

//unsubscribe
//$mail->AddCustomHeader("List-Unsubscribe: <mailto:web-qhK1ih@mail-tester.com?subject=Unsubscribe>, <http://mydomain.com/unsubscribe.php?mailid=1234>");

if($Validation_openDKIM == "oui"){
//DKIM
 //This should be the same as the domain of your From address
$mail->DKIM_domain = "$nomsiteweb";
//Path to your private key file
$mail->DKIM_private = '../dkim.private';
//Set this to your own selector
$mail->DKIM_selector = 'dkim';
//If your private key has a passphrase, set it here
$mail->DKIM_passphrase = '';
//The identity you're signing as - usually your From address
$mail->DKIM_identity = $mail->From;
}

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo ""; //Message sent!
}

}

//$vers_mail = "chafreestyle@hotmail.com";
//$vers_nom = "Codeur";
//$de_mail = "support@123webmaster.fr";
//$de_nom = "123webmaster.fr";
//$sujet = "L'entreprise peut venir au diner que vous organiser avec toute l'équipe!";
//$message_principalone = "Il faut vous apporter quoi à manger ???????";

//mailsend($vers_mail, $vers_nom, $de_mail, $de_nom, $sujet, $message_principalone); 

?>
