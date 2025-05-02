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

if(isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 1 ||
isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 2 ||
isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 3 ){


$action = $_POST['action'];
$idaction = $_POST['idaction'];

$MODULES_MEMBRES_SUPPRIMER = $_POST['MODULES_MEMBRES_SUPPRIMER'];
$MODULE_PROFIL_SUPPRIMER = $_POST['MODULE_PROFIL_SUPPRIMER'];
$MODULE_APPEL_D_OFFRE_SUPPRIMER = $_POST['MODULE_APPEL_D_OFFRE_SUPPRIMER'];
$MODULE_DOCUMENTS_COMMERCIAUX_SUPPRIMER = $_POST['MODULE_DOCUMENTS_COMMERCIAUX_SUPPRIMER'];
$MODULE_MESSAGERIE_SUPPRIMER = $_POST['MODULE_MESSAGERIE_SUPPRIMER'];
$MODULE_LITIGE_SUPPRIMER = $_POST['MODULE_LITIGE_SUPPRIMER'];
$MODULE_ENVOYER_MAIL = $_POST['MODULE_ENVOYER_MAIL'];
$sujet_log_mail_utilisateur = $_POST['sujet_log_mail_utilisateur'];
$commentaire_log_mail_utilisateur = $_POST['commentaire_log_mail_utilisateur'];

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM membres WHERE id=?");
$req_select->execute(array($_POST['idaction']));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$idsiretdelete = $ligne_select['pseudo'];
$maildeletedelete = $ligne_select['mail'];
$Telephone_portabledeletedelete = $ligne_select['Telephone_portable'];
$image_profil = $ligne_select['image_profil'];
$photo = $ligne_select['photo'];

////////////////////SI ENVOYER MAIL
if($MODULE_ENVOYER_MAIL == "oui"){

//Envoi de l'email test
$de_nom = "$nomsiteweb"; //Nom de l'envoyeur
$de_mail = "$emaildefault"; //Email de l'envoyeur
$vers_nom = "$idsiretdelete"; //Nom du receveur
$vers_mail = "$maildeletedelete"; //Email du receveur
$sujet = "$sujet_log_mail_utilisateur"; //Sujet du mail
$message_principalone = "
Bonjour,<br /><br />
$commentaire_log_mail_utilisateur
<br />
L'équipe de $nomsiteweb
";

mailsend($vers_mail, $vers_nom, $de_mail, $de_nom, $sujet, $message_principalone);
}
////////////////////SI ENVOYER MAIL


////////////////////SI ON ENREGISTRE LE LOG
	$mail_compte_concerne = $maildeletedelete;
	$module_log = "ESPACE MEMBRE";
	$action_sujet_log = "$sujet_log_mail_utilisateur";
	$action_libelle_log = "$commentaire_log_mail_utilisateur";
	$action_log = "SUPPRESION DE COMPTE";
	$niveau_log = "1";
	$compte_bloque = "";
	log_h($mail_compte_concerne,$module_log,$action_sujet_log,$action_libelle_log,$action_log,$niveau_log,$compte_bloque);
////////////////////SI ON ENREGISTRE LE LOG

/////////////TABLES ASSOCIEES DIRECTEMENT AUX MEMBRES
if($MODULES_MEMBRES_SUPPRIMER== "oui"){

///////////////////////////////UPDATE
$sql_update = $bdd->prepare("UPDATE membres SET 
	mail=?, 
	datenaissance=?,
	pays_naissance=?, 
	ville_naissance=?, 
	type_voie=?, 
	adresse=?, 
	ville=?, 
	cp=?, 
	region=?, 
	departement=?, 
	ip_inscription=?, 
	ip_login=?, 
	Telephone=?, 
	Telephone_portable=?, 
	Pays=?, 
	last_login=?, 
	last_ip=?, 
	image_profil=?, 
	nom=?, 
	prenom=?, 
	pass=?,
	Activer=?, 
	supprimer=?,
	supprimer_date=?
	WHERE id=?");
$sql_update->execute(array(
	$emaildefault,
	"",
	"",
	"",
	"",
	"***********",
	"*******",
	"****",
	"",
	"",
	"",
	"",
	"",
	"",
	"",
	"",
	"",
	"",
	"*******",
	"*******",
	hash("sha256",time()),
	"non",
	"oui",
	time(),
	$_POST['idaction']));                     
$sql_update->closeCursor();

///////////////////////////////DELETE
$sql_delete = $bdd->prepare("DELETE FROM Newsletter_listing WHERE Mail=?");
$sql_delete->execute(array($maildeletedelete));                     
$sql_delete->closeCursor();

///////////////////////////////DELETE
$sql_delete = $bdd->prepare("DELETE FROM membres_password_perdu WHERE pseudo_id=?");
$sql_delete->execute(array($_POST['idaction']));                     
$sql_delete->closeCursor();

///////////////////////////////DELETE
//$sql_delete = $bdd->prepare("DELETE FROM membres_professionnel WHERE id_membre=?");
//$sql_delete->execute(array($_POST['idaction']));                     
//$sql_delete->closeCursor();

/////////////ON SUPPRIME LES FICHIERS ET DOSSIER DE L'UTILISATEUR
$dir = "/images/membres";
if(!empty($photo) && isset($photo)){
  unlink($dir."/".$photo); 
}

}

/////////////TABLES ASSOCIEES DIRECTEMENT AUX MEMBRES

/////////////TABLES ASSOCIEES AUX DOCUMENTS COMMERCIAUX
if($MODULE_DOCUMENTS_COMMERCIAUX_SUPPRIMER== "oui"){

///////////////////////////////DELETE
$sql_delete = $bdd->prepare("DELETE FROM membres_prestataire_facture WHERE id_membre=?");
$sql_delete->execute(array($_POST['idaction']));                     
$sql_delete->closeCursor();

///////////////////////////////DELETE
$sql_delete = $bdd->prepare("DELETE FROM membres_prestataire_facture_details WHERE id_membre=?");
$sql_delete->execute(array($_POST['idaction']));                     
$sql_delete->closeCursor();

///////////////////////////////DELETE
$sql_delete = $bdd->prepare("DELETE FROM membres_panier WHERE id_membre=?");
$sql_delete->execute(array($_POST['idaction']));                     
$sql_delete->closeCursor();

///////////////////////////////DELETE
$sql_delete = $bdd->prepare("DELETE FROM membres_panier_details WHERE id_membre=?");
$sql_delete->execute(array($_POST['idaction']));                     
$sql_delete->closeCursor();

///////////////////////////////DELETE
$sql_delete = $bdd->prepare("DELETE FROM membres_biens_paiements WHERE id_membre_client=? || id_membre_annonce=?");
$sql_delete->execute(array($_POST['idaction'],$_POST['idaction']));                     
$sql_delete->closeCursor();

}
/////////////TABLES ASSOCIEES DIRECTEMENT AUX DOCUMENTS COMMERCIAUX

/////////////TABLES ASSOCIEES AUX PROFILS
if($MODULE_PROFIL_SUPPRIMER== "oui"){

///////////////////////////////DELETE
$req_boucle = $bdd->prepare("SELECT * FROM membres_biens WHERE id_membre=?");
$req_boucle->execute(array($_POST['idaction']));
while($ligne_boucle = $req_boucle->fetch()){
$idannonce = $ligne_boucle['id']; 

	///////////////////////////////DELETE
	$req_bouclei = $bdd->prepare("SELECT * FROM membres_biens_medias WHERE bien_id=?");
	$req_bouclei->execute(array($idannonce));
	while($ligne_bouclei = $req_bouclei->fetch()){
	$id = $ligne_bouclei['id']; 

		///////////////////////////////DELETE
		$sql_delete = $bdd->prepare("DELETE FROM membres_biens_medias WHERE id=?");
		$sql_delete->execute(array($id));                     
		$sql_delete->closeCursor();

		if(!file_exists("../../..".$ligne_bouclei['lien_media_source']."")){
        		unlink("../../..".$ligne_bouclei['lien_media_source']."");
		}
		if(!file_exists("../../..".$ligne_bouclei['lien_media']."")){
        		unlink("../../..".$ligne_bouclei['lien_media']."");
		}
		if(!file_exists("../../..".$ligne_bouclei['lien_media2']."")){
        		unlink("../../..".$ligne_bouclei['lien_media2']."");
		}

	}
	$req_bouclei->closeCursor();

	///////////////////////////////DELETE
	$sql_delete = $bdd->prepare("DELETE FROM membres_biens_avis WHERE id_annonce=?");
	$sql_delete->execute(array($idannonce));                     
	$sql_delete->closeCursor();

	///////////////////////////////DELETE
	$sql_delete = $bdd->prepare("DELETE FROM membres_biens_favoris WHERE bien_id=?");
	$sql_delete->execute(array($idannonce));                     
	$sql_delete->closeCursor();

}
$req_boucle->closeCursor();

///////////////////////////////DELETE
$sql_delete = $bdd->prepare("DELETE FROM membres_biens WHERE id_membre=?");
$sql_delete->execute(array($_POST['idaction']));                     
$sql_delete->closeCursor();

///////////////////////////////DELETE
$sql_delete = $bdd->prepare("DELETE FROM membres_biens_demandes WHERE id_membre=?");
$sql_delete->execute(array($_POST['idaction']));                     
$sql_delete->closeCursor();

///////////////////////////////DELETE
$sql_delete = $bdd->prepare("DELETE FROM membres_messages WHERE id_membre=?");
$sql_delete->execute(array($_POST['idaction']));                     
$sql_delete->closeCursor();

///////////////////////////////DELETE
$sql_delete = $bdd->prepare("DELETE FROM membres_biens_reservations WHERE membre_id=? || membre_annonceur_id=?");
$sql_delete->execute(array($_POST['idaction'],$_POST['idaction']));                     
$sql_delete->closeCursor();

///////////////////////////////DELETE
$sql_delete = $bdd->prepare("DELETE FROM membres_messages WHERE id_membre_destinataire=?");
$sql_delete->execute(array($_POST['idaction']));                     
$sql_delete->closeCursor();

///////////////////////////////DELETE
$sql_delete = $bdd->prepare("DELETE FROM membres_messages_reponse WHERE id_membre=?");
$sql_delete->execute(array($_POST['idaction']));                     
$sql_delete->closeCursor();

}
/////////////TABLES ASSOCIEES AUX PROFILS

$result = array("Texte_rapport"=>"Compte supprimé avec succès !","retour_validation"=>"ok","retour_lien"=>"");

$result = json_encode($result);
echo $result;

}else{
header('location: /index.html');
}

ob_end_flush();
?>