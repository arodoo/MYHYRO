<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../Configurations_bdd.php');
require_once('../../Configurations.php');
require_once('../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction= "../../";
require_once('../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

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

$loginOK = false; 

	$login = $_POST['login'];
	$pass = $_POST['password'];

if(!empty($login) && !empty($pass) ){

	$pass = hash("sha256",$_POST['password']);

	extract($_POST);  // je vous renvoie à la doc de cette fonction

	$_SESSION['nbr_login_test'] = (1+$_SESSION['nbr_login_test']);
	if(4 > $_SESSION['nbr_login_test_reste']){
		$_SESSION['nbr_login_test_reste'] = (3-$_SESSION['nbr_login_test']);
	}
	unset($_SESSION['nbr_login_test']);
	unset($_SESSION['nbr_login_test_reste']);

// On va chercher si le compte est bloqué
if(empty($_POST['admin'])){
///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM membres WHERE mail=? and admin!=? ");
$req_select->execute(array(htmlspecialchars($login),1));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();

}elseif(!empty($_POST['admin'])){
///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM membres WHERE mail=? and admin>? ");
$req_select->execute(array(htmlspecialchars($login),0));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
}

$req_select2 = $bdd->prepare("SELECT * FROM membres WHERE mail=? and (nbractivation!='' OR nbractivation IS NULL ) AND statut_compte=1");
$req_select2->execute(array(htmlspecialchars($login)));
$ligne_select2 = $req_select2->fetch();
$req_select2->closeCursor();

if(empty($ligne_select2['id']) && !empty($ligne_select['id']) && $ligne_select['compte_bloque'] != "oui") {

		// On va chercher le mot de passe afférent à ce login
		if(empty($_POST['admin'])){
		///////////////////////////////SELECT
		$req_select = $bdd->prepare("SELECT * FROM membres 
			WHERE mail=? 
			and pass=?
			and (nbractivation=? OR nbractivation IS NULL)
			and Activer=?");
		$req_select->execute(array(
			htmlspecialchars($login),
			htmlspecialchars($pass), 
			'',
			'oui'));
		$ligne_select = $req_select->fetch();
		$req_select->closeCursor();

		}elseif(!empty($_POST['admin'])){
		///////////////////////////////SELECT
		$req_select = $bdd->prepare("SELECT * FROM membres 
			WHERE mail=? 
			and pass=?
			and (nbractivation=? OR nbractivation IS NULL)
			and Activer=?");
		$req_select->execute(array(
			htmlspecialchars($login),
			htmlspecialchars($pass), 
			'',
			'oui'));
		$ligne_select = $req_select->fetch();
		$req_select->closeCursor();
		}
		if(!empty($ligne_select['id'])) {
   			if ($pass == $ligne_select['pass']) {
      				$loginOK = true;
   			}else{
				$result = array("Texte_rapport"=>"<div class='rapport_red' ><span class='uk-icon-warning' ></span> Le mot de passe ou le mail n'est pas correct !</div>","Texte_rapport_panier"=>"Le mot de passe ou le mail n'est pas correct !","retour_validation"=>"","retour_lien"=>"");
			}

		}else{
			$result = array("Texte_rapport"=>"<div class='rapport_red' ><span class='uk-icon-warning' ></span> Le mot de passe ou le mail n'est pas correct ! </div>","Texte_rapport_panier"=>"Le mot de passe ou le mail n'est pas correct !","retour_validation"=>"","retour_lien"=>"");

	/*
		$result = array("Texte_rapport"=>"<div class='rapport_red' ><span class='uk-icon-warning' ></span> Le compte vient d'être bloqué, contactez un administrateur ! </div>","Texte_rapport_panier"=>"Le compte vient d'être bloqué, contactez un administrateur !","retour_validation"=>"","retour_lien"=>"");
		$mail_compte_concerne = $login;
		$module_log = "IDENTIFICATION";
		$action_sujet_log = "Compte bloqué - Notification de tentative de connexion";
		$action_libelle_log = "Une personne ou vous même avez tenté de vous connecté au compte <b></b> sur $nomsiteweb. 3 tentatives de connexion ont échoués, en conséquence le
		compte est bloqué. Pour débloquer le compte, veuillez prendre contact avec un administrateur. Si vous n'êtes pas à l'origine de cette action, veuillez sans attendre contacter un administrateur sur la page
		<a href='".$http."".$nomsiteweb."/Contact' target='blank_' style='text-decoration: underline;' >Contact</a>";
		$action_log = "CONNEXION";
		$niveau_log = "1";
		$compte_bloque = "oui";
		log_h($mail_compte_concerne,$module_log,$action_sujet_log,$action_libelle_log,$action_log,$niveau_log,$compte_bloque);
	*/

		}

}elseif(!empty($ligne_select2['id'])){
	$result = array("Texte_rapport"=>"<div class='rapport_red' ><span class='uk-icon-warning' ></span> Le compte n'est pas validé ! </div>","Texte_rapport_panier"=>"Le compte n'est pas validé !","retour_validation"=>"","retour_lien"=>"");

}elseif(empty($ligne_select['id'])){
	$result = array("Texte_rapport"=>"<div class='rapport_red' ><span class='uk-icon-warning' ></span> Le compte n'existe pas ! </div>","Texte_rapport_panier"=>"Le compte n'existe pas ! Il reste ".$_SESSION['nbr_login_test_reste']." tentative(s). ","retour_validation"=>"","retour_lien"=>"");

}elseif(!empty($ligne_select['id'])  && $data['compte_bloque'] == "oui" ){
	$result = array("Texte_rapport"=>"<div class='rapport_red' ><span class='uk-icon-warning' ></span> Le compte est bloqué, contactez un administrateur ! </div>","Texte_rapport_panier"=>"Le compte est bloqué, contactez un administrateur ! ","retour_validation"=>"","retour_lien"=>"");
}

}elseif(!empty($_POST['login_post'])) {
	$result = array("Texte_rapport"=>"<div class='rapport_red' ><span class='uk-icon-warning' ></span> Indiquez un mot de passe et un mail ! </div>","Texte_rapport_panier"=>"Indiquez un mot de passe et un mail !","retour_validation"=>"","retour_lien"=>"");
}


// Si le login a été validé on met les données en session
if ($loginOK){

	unset($_SESSION['nbr_login_test']);
  	unset($_SESSION['nbr_login_test_reste']);

  	$_SESSION['pseudo'] = $ligne_select['id'];
  	$ipproprietaire = $_SERVER['REMOTE_ADDR'];

  	unset($_POST['Login_submit']);

			///////////////////////////////SELECT
			$req_select = $bdd->prepare("SELECT * FROM membres WHERE mail=? and admin >?");
			$req_select->execute(array(htmlspecialchars($login),"0"));
			$ligne_select = $req_select->fetch();
			$req_select->closeCursor();
  			$AddMMiinn = $ligne_select['admin'];

			if(isset($loginOK) && $AddMMiinn > 0 && $loginOK = true){
				$_SESSION['7A5d8M9i4N9'] = "GY1x79VmPH5yXwbT18hGdg";
			}
		//////////////////////////////CONNEXION ADMINISTRATEUR ET SESSIONS ASSOCIEES


	if(isset($loginOK) && $loginOK = true){
		$_SESSION['4M8e7M5b1R2e8s'] = "A9lKJF0HJ12YtG7WxCl12";
		$now = time();

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM membres WHERE mail=?");
$req_select->execute(array(htmlspecialchars($login)));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$last_ip = $ligne_select['last_ip'];

		///////////////////////////////UPDATE
		$sql_update = $bdd->prepare("UPDATE membres SET 
			last_ip=?,
			last_login=? 
			WHERE mail=?");
		$sql_update->execute(array(
			$_SERVER['REMOTE_ADDR'],
			time(),
			htmlspecialchars($login)
		));                     
		$sql_update->closeCursor();

	/* 	if($last_ip != $_SERVER['REMOTE_ADDR']){
			$mail_compte_concerne = $login;
			$module_log = "IDENTIFICATION";
			$action_sujet_log = "Notification de connexion réussie";
			$action_libelle_log = "Notification à votre compte <b>$mail_compte_concerne</b> sur $nomsiteweb. Si vous n'êtes pas à l'origine de cette connexion, veuillez sans attendre contacter un administrateur sur la page
			<a href='".$http."".$nomsiteweb."/Contact' target='blank_' style='text-decoration: underline;' >Contact</a>";
			$action_log = "CONNEXION";
			$niveau_log = "2";
			$compte_bloque = "";
			log_h($mail_compte_concerne,$module_log,$action_sujet_log,$action_libelle_log,$action_log,$niveau_log,$compte_bloque);
		} */

		$result = array("Texte_rapport"=>"","retour_validation"=>"Ok","retour_lien"=>$lasturl);

		///////////////////////////////SELECT
		$req_select = $bdd->prepare("SELECT * FROM membres WHERE mail=?");
		$req_select->execute(array(htmlspecialchars($login)));
		$ligne_select = $req_select->fetch();
		$req_select->closeCursor();

		///////ON MET A JOUR PSEUDO PANIER
		if(!empty($id_oo)){

		///////////////////////////////DELETE
		$sql_delete = $bdd->prepare("DELETE FROM membres_commandes WHERE user_id=? AND statut='3'");
		$sql_delete->execute(array(htmlspecialchars($ligne_select['id'])));                     
		$sql_delete->closeCursor();

				///////////////////////////////DELETE
				$sql_delete = $bdd->prepare("DELETE FROM membres_colis WHERE user_id=? AND statut='1'");
				$sql_delete->execute(array(htmlspecialchars($ligne_select['id'])));                     
				$sql_delete->closeCursor();

		///////////////////////////////DELETE
		$sql_delete = $bdd->prepare("DELETE FROM membres_panier WHERE id_membre=?");
		$sql_delete->execute(array(htmlspecialchars($ligne_select['id'])));                     
		$sql_delete->closeCursor();

		///////////////////////////////DELETE
		$sql_delete = $bdd->prepare("DELETE FROM membres_panier_details WHERE id_membre=?");
		$sql_delete->execute(array(htmlspecialchars($ligne_select['id'])));                     
		$sql_delete->closeCursor();

			///////////////////////////////UPDATE
			$sql_update = $bdd->prepare("UPDATE membres_commandes SET
				user_id=? 
				WHERE id=?");
			$sql_update->execute(array(
				$ligne_select['id'],
				htmlspecialchars($_SESSION['id_commande'])));                    
			$sql_update->closeCursor();

			///////////////////////////////UPDATE
			$sql_update = $bdd->prepare("UPDATE membres_commandes_details SET
				id_membre=? 
				WHERE commande_id=?");
			$sql_update->execute(array(
				$ligne_select['id'],
				htmlspecialchars($_SESSION['id_commande'])));                    
			$sql_update->closeCursor();

			///////////////////////////////UPDATE
			$sql_update = $bdd->prepare("UPDATE membres_colis SET
				user_id=? 
				WHERE id=?");
			$sql_update->execute(array(
				$ligne_select['id'],
				htmlspecialchars($_SESSION['id_colis'])));                    
			$sql_update->closeCursor();
			///////////////////////////////UPDATE
			$sql_update = $bdd->prepare("UPDATE membres_panier_details SET
				id_membre=? 
				WHERE id_membre=?");
			$sql_update->execute(array(
				$ligne_select['id'],
				htmlspecialchars($id_oo)));                    
			$sql_update->closeCursor();

			///////////////////////////////UPDATE
			$sql_update = $bdd->prepare("UPDATE membres_panier SET
				id_membre=? 
				WHERE id_membre=?");
			$sql_update->execute(array(
				$ligne_select['id'],
				htmlspecialchars($id_oo)));                    
			$sql_update->closeCursor();
	
			// var_dump($id_oo, $ligne_select['id'], $_SESSION['id_colis']);
			// //unset($_SESSION['pseudo_panier']);

		}

	}

}elseif(empty($login)){
	$result = array("Texte_rapport"=>"<div class='rapport_red' ><span class='uk-icon-warning' ></span> Indiquez un identifiant ! </div>","Texte_rapport_panier"=>"Indiquez un identifiant !","retour_validation"=>"","retour_lien"=>"");


}elseif(empty($pass)){
	$result = array("Texte_rapport"=>"<div class='rapport_red' ><span class='uk-icon-warning' ></span> Indiquez un mot de passe ! </div>","Texte_rapport_panier"=>"Indiquez un mot de passe !","retour_validation"=>"","retour_lien"=>"");

}


$result = json_encode($result);
echo $result;

ob_end_flush();
?>