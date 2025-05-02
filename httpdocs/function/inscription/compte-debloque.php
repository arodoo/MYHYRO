<?php
ob_start();

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

if($_GET['a'] == "Compte-debloque" && !empty($_GET['idaction'])){

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM membres WHERE compte_debloque_par_url=?");
$req_select->execute(array($_GET['idaction']));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$id_oo_debloque = $ligne_select['id'];
$mail_oo_debloque = $ligne_select['mail'];

	if(!empty($id_oo_debloque)){

///////////////////////////////UPDATE
$sql_update = $bdd->prepare("UPDATE membres SET 
	compte_debloque_par_url=? 
	WHERE compte_debloque_par_url=?");
$sql_update->execute(array(
	"",
	$_GET['idaction']));                     
$sql_update->closeCursor();
		session_destroy();
		header('location: /Mot-de-passe');

		////////////////////SI ON ENREGISTRE LE LOG
		$mail_compte_concerne = $mail_oo_debloque;
		$module_log = "DEBLOQUER LE COMPTE";
		$action_sujet_log = "Notification de définition d'un nouveau mot passe sur votre compte ".$mail_oo_debloque." ";
		$action_libelle_log = "Vous venez d'accéder au lien pour débloquer votre compte et definir un nouveau mot de passe. Si vous n'êstes pas à l'origine de cette
		action, merci de contacter sans attendre un administrateur sur la page
		<a href='".$http."".$nomsiteweb."/Contact' target='blank_' style='text-decoration: underline;' >Contact</a>.";
		$action_log = "SUPPRESION DE COMPTE";
		$niveau_log = "1";
		$compte_bloque = "";
		log_h($mail_compte_concerne,$module_log,$action_sujet_log,$action_libelle_log,$action_log,$niveau_log,$compte_bloque);
		////////////////////SI ON ENREGISTRE LE LOG

	}else{
		header('location: /');
	}
}

ob_end_flush();
?>