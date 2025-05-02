<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('httpdocs/Configurations_bdd.php');
require_once('httpdocs/Configurations.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction = "httpdocs/";
require_once('httpdocs/function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');


$req_boucle = $bdd->prepare("SELECT * FROM membres WHERE Activer = ? AND Abonnement_date_expiration < ? ");
$req_boucle->execute(array("oui", time()));
while ($ligne_boucle = $req_boucle->fetch()) {

	$idoneinfos = $ligne_boucle['id'];


	if (!empty($idoneinfos)) {

		$mail = $ligne_boucle['mail'];
		$prenom = $ligne_boucle['prenom'];
		$nom = $ligne_boucle['nom'];

		///////////////////////////////////////UPDATE
		$sql_update = $bdd->prepare("UPDATE membres SET 
    		Abonnement_date_expiration=?,
   	 		Abonnement_id=?
       	 	WHERE id=?");
		$sql_update->execute(array(
			time() + (365 * 24 * 60 * 60),
			"1",
			$idoneinfos
		));
		$sql_update->closeCursor();

		///////////////////////Mail client
		$de_nom = "$nomsiteweb"; //Nom de l'envoyeur
		$de_mail = "$emaildefault"; //Email de l'envoyeur
		$vers_nom = "$prenom $nom"; //Nom du receveur
		$vers_mail = "$mail"; //Email du receveur
		$sujet = "Votre abonnement a expiré sur $nomsiteweb";

		$message_principalone = "
    		<b>Bonjour, </b><br /><br />
		Votre abonnement a expiré.<br />

        Vous avez maintenant l'abonnement One Shot
		<br />
    		<br />
   	 	Cordialement, l'équipe
    		<br />";
		mailsend($vers_mail, $vers_nom, $de_mail, $de_nom, $sujet, $message_principalone);
		///////////////////////Mail support

	}
}
$req_boucle->closeCursor();

ob_end_flush();
