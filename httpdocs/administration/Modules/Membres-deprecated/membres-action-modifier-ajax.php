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

$idaction = $_POST['idaction'];
$action = $_POST['action'];

$now = time();
$req_select = $bdd->prepare("SELECT * FROM membres WHERE id=?");
$req_select->execute(array($idaction));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$loginm = $ligne_select['pseudo'];

if(isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 1 ||
isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 2 ||
isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 3 ){

	$loginm = $_POST['login'];
	$emailm = $_POST['email'];
	$adminm = $_POST['admin'];
	$nomm = $_POST['nom'];
	$prenomm = $_POST['prenom'];
	$adressem = $_POST['adresse'];
	$cpm = $_POST['cp'];
	$villem = $_POST['ville'];
	$paypost = $_POST['payspost'];
	$ActiverActiver=$_POST['activer'];
	$passwordpost = $_POST['passwordpost'];
	$telephonepost = $_POST['telephonepost'];
	$telephoneposportable = $_POST['Telephone_portable'];
	$Nom_societe = $_POST['Nom_societe'];
	$Numero_identification = $_POST['Numero_identification'];
	$type_compte = $_POST['statut_compte'];

        $Code_securite = $_POST['Code_securite'];

	$CSP = $_POST['CSP'];
	$Votre_quartier = $_POST['Votre_quartier'];
	$Decrivez_un_peut_plus_chez_vous = $_POST['Decrivez_un_peut_plus_chez_vous'];
	$Complement_d_adresse = $_POST['Complement_d_adresse'];

	$message_administrateur = $_POST['message_administrateur'];
	$message_livraison = $_POST['message_livraison'];
	$message_commande = $_POST['message_commande'];
	$message_liste_souhait = $_POST['message_liste_souhait'];

	$zone = $_POST['zone'];

	////////////////////////////////////////////////////AJOUTER
	if($action == "Ajouter-action"){

		$passwordpost = hash("sha256",$passwordpost);
		$loginm = "EA".time()."";

		$req_check_mail = $bdd->prepare("SELECT * FROM membres WHERE mail=?");
		$req_check_mail->execute(array($_POST['email']));
		$checker_line = $req_check_mail->fetch();
		$req_check_mail->closeCursor();
		
		if($checker_line)
		{
			$result = array("Texte_rapport"=>"Adresse email déjà utilisée !","retour_validation"=>"non","retour_lien"=>"");
		}else{

			// if (!file_exists("" . $_SERVER['DOCUMENT_ROOT'] . "/images/membres/$loginm"))
			// {
			// 	mkdir("" . $_SERVER['DOCUMENT_ROOT'] . "/images/membres/$loginm");
			// }
			
			$sql_update = $bdd->prepare("INSERT INTO membres
				(pseudo,
				pass,
				mail,
				nom,
				prenom,
				Pays,
				Telephone,
				Telephone_portable,
				`admin`, 
				reglement_accepte, 
				newslettre,
				nbractivation,
				Activer,
				date_enregistrement,
				Code_securite,
				CSP,
				Votre_quartier,
				Decrivez_un_peut_plus_chez_vous,
				Complement_d_adresse,
				message_administrateur,
				message_livraison,
				message_commande,
				message_liste_souhait,
				zone
				)
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
			$sql_update->execute(array(
				$loginm, 
				$passwordpost,
				$emailm, 
				$nomm, 
				$prenomm,
				$_POST['Pays'], 
				$telephonepost,
				$_POST['Telephone_portable'],
				$adminm, 
				'oui',
				'0', 
				NULL,
				$ActiverActiver,
				$now,
				$Code_securite,
				$CSP,
				$Votre_quartier,
				$Decrivez_un_peut_plus_chez_vous,
				$Complement_d_adresse,
				$message_administrateur,
				$message_livraison,
				$message_commande,
				$message_liste_souhait,
				$zone));                     
			$sql_update->closeCursor();
			$lastInsertId = $bdd->lastInsertId();

    			$id_membre_insert = $lastInsertId;

    			if(strlen($id_membre_insert) == 1){
    				$numero_client  = "000".$ligne_select['id']."";
    			}elseif(strlen($id_membre_insert) == 2){
    				$numero_client  = "00".$ligne_select['id']."";
    			}elseif(strlen($id_membre_insert) == 3){
    				$numero_client  = "0".$ligne_select['id']."";
    			}elseif(strlen($id_membre_insert) > 3){
    				$numero_client  = "".$ligne_select['id']."";
   	 		}

			$sql_update = $bdd->prepare("UPDATE membres SET numero_client=? WHERE id=?");
			$sql_update->execute(array($numero_client,$id_membre_insert));                     
			$sql_update->closeCursor();

			// //////////////////////////////////////POST ACTION UPLOAD
			// $photo = $_FILES["photo"]["name"];
			// if(!empty($photo)){
			// 	if(!empty($photo) && substr($photo, -4) == "jpeg" || !empty($photo) &&  substr($photo, -3) == "jpg" || !empty($photo) && substr($photo, -3) == "JPG" || !empty($photo) && substr($photo, -3) == "png" || !empty($photo) && substr($photo, -3) == "PNG" || !empty($photo) && substr($photo, -3) == "gif" || !empty($photo) && substr($photo, -3) == "GIF" || !empty($photo) && substr($photo, -3) == "pdf" || !empty($photo) &&  substr($photo, -3) == "PDF" ){
			// 		$icon1 = $_FILES['photo']['name'];
			// 		$tmp = $_FILES['photo']['tmp_name'];
			// 		$now = time();
			// 		$namebrut = explode('.', $icon1);
			// 		$namebruto = $namebrut[0];
			// 		$namebruto_extansion = $namebrut[1];
			// 		$nouveau_nom_fichier = "".$namebruto."-".$now.".$namebruto_extansion";
			// 		include('membres-action-modifier-ajax-upload.php');
			// 	///////////////////////////////UPDATE
			// 	$sql_update = $bdd->prepare("UPDATE membres SET 
			// 		photo=?
			// 		WHERE id=?");
			// 	$sql_update->execute(array(
			// 		$namebruto,
			// 		$idoneinfos));                     
			// 	$sql_update->closeCursor();
			// }else{
			// 	$err = "oui";
			// 	$result = array("Texte_rapport"=>"La photo n'a pas l'extension requise !","retour_validation"=>"","retour_lien"=>"");
			// 	}
			// }
			//////////////////////////////////////POST ACTION UPLOAD

			$result = array("Texte_rapport"=> "Membre créé avec succès !","retour_validation"=>"ok","retour_lien"=>"");
		}
	}


	////////////////////////////////////////////////////MODIFIER
	if($action == "Modifier-action"){

		if(!empty($passwordpost)){
			$passwordpost = hash("sha256",$passwordpost);
			$sql_update = $bdd->prepare("UPDATE membres SET pass=? WHERE id=?");
			$sql_update->execute(array($passwordpost,$_POST['idaction']));                     
			$sql_update->closeCursor();
		}

		$sql_update = $bdd->prepare("UPDATE membres SET 
			mail=?, 
			admin=?, 
			nom=?, 
			prenom=?, 
			adresse=?, 
			Telephone=?,
			statut_compte=?,
			Activer=?,
			Code_securite=?,
			CSP=?,
			Votre_quartier=?,
			Decrivez_un_peut_plus_chez_vous=?,
			Complement_d_adresse=?,
			message_administrateur=?,
			message_livraison=?,
			message_commande=?,
			message_liste_souhait=?,
			zone=?
			WHERE id=?");
		$sql_update->execute(array(
			$emailm, 
			$adminm, 
			$nomm, 
			$prenomm, 
			$adressem,
			$telephonepost, 
			$type_compte,
			$ActiverActiver, 
			$Code_securite,
			$CSP,
			$Votre_quartier,
			$Decrivez_un_peut_plus_chez_vous,
			$Complement_d_adresse,
			$message_administrateur,
			$message_livraison,
			$message_commande,
			$message_liste_souhait,
			$zone,
			$_POST['idaction']));                     
		$sql_update->closeCursor();

		$sql_update = $bdd->prepare("UPDATE membres_professionnel SET
			Nom_societe=?,
			Numero_identification=?
			WHERE id_membre=?");
		$sql_update->execute(array(
			$Nom_societe, 
			$Numero_identification,
			$_POST['idaction']));                     
		$sql_update->closeCursor();


		$req_pseudo = $bdd->prepare("SELECT * FROM membres WHERE id=?");
		$req_pseudo->execute(array($idaction));
		$pseudo = $req_pseudo->fetch();
		$req_pseudo->closeCursor();


		if (!file_exists("" . $_SERVER['DOCUMENT_ROOT'] . "/images/membres/".$pseudo['pseudo'].""))
		{
			mkdir("" . $_SERVER['DOCUMENT_ROOT'] . "/images/membres/".$pseudo['pseudo']."");
		}

		////////////////////SI ON ENREGISTRE LE LOG
		if($compte_log_mail == "oui" ){
			$mail_compte_concerne = $emailm;
			$module_log = "ESPACE MEMBRE";
			$action_sujet_log = "$sujet_log_mail_utilisateur";
			$action_libelle_log = "$commentaire_log_mail_utilisateur";
			$action_log = "MODIFICATIONS";
			$niveau_log = "3";
			$compte_bloque = "";
			log_h($mail_compte_concerne,$module_log,$action_sujet_log,$action_libelle_log,$action_log,$niveau_log,$compte_bloque);
		}
		////////////////////SI ON ENREGISTRE LE LOG

		//////////////////////////////////////POST ACTION UPLOAD
		$photo = $_FILES["photo"]["name"];
		if(!empty($photo)){
			if(!empty($photo) && substr($photo, -4) == "jpeg" || !empty($photo) &&  substr($photo, -3) == "jpg" || !empty($photo) && substr($photo, -3) == "JPG" || !empty($photo) && substr($photo, -3) == "png" || !empty($photo) && substr($photo, -3) == "PNG" || !empty($photo) && substr($photo, -3) == "gif" || !empty($photo) && substr($photo, -3) == "GIF" || !empty($photo) && substr($photo, -3) == "pdf" || !empty($photo) &&  substr($photo, -3) == "PDF" ){
				$icon1 = $_FILES['photo']['name'];
				$tmp = $_FILES['photo']['tmp_name'];
				$now = time();
				$namebrut = explode('.', $icon1);
				$namebruto = $namebrut[0];
				$namebruto_extansion = $namebrut[1];
				$nouveau_nom_fichier = "".$namebruto."-".$now.".$namebruto_extansion";
				include('membres-action-modifier-ajax-upload.php');
			///////////////////////////////UPDATE
			$sql_update = $bdd->prepare("UPDATE membres SET 
				photo=?
				WHERE id=?");
			$sql_update->execute(array(
				$namebruto,
				$idaction));                     
			$sql_update->closeCursor();
			}else{
				$err = "oui";
				$result = array("Texte_rapport"=>"La photo n'a pas l'extension requise !","retour_validation"=>"","retour_lien"=>"");
			}
		}
		//////////////////////////////////////POST ACTION UPLOAD

		$result = array("Texte_rapport"=>"Membre modifié avec succès !","retour_validation"=>"ok","retour_lien"=>"");
	}

	echo json_encode($result);

}else{
	header('location: /index.html');
}

ob_end_flush();
?>