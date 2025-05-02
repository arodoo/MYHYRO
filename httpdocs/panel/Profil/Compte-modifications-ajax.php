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

$modif = "oui";

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

if(!empty($_SESSION['4M8e7M5b1R2e8s']) && !empty($user)){

$modif = "oui";
include("".$dir_fonction."function/inscription/controle_inscriptions.php"); 

///////////////////////////////////////////////////////////////////////////////SI ERREUR
if($err != 1){

// if(!empty($_POST['password']) && !empty($_POST['passwordclient2'])){

// $passwordupdate = hash("sha256",$_POST['password']);

///////////////////////////////UPDATE
// $sql_update = $bdd->prepare("UPDATE membres SET 
// 	pass=?
// 	WHERE pseudo=?");
// $sql_update->execute(array(
// 	htmlspecialchars($passwordupdate),
// 	$user));                     
// $sql_update->closeCursor();
// }

if(!empty($Code_postal)){
$departement = substr($Code_postal,0,2);
}
$same_adresse="false";
if($_POST["same_adresse"] == "on"){
	$same_adresse="oui";
}
///////////////////////////////UPDATE
$sql_update = $bdd->prepare("UPDATE membres SET 
	date_update=?, 
	date_update_ip=?, 
	nom=?, 
	prenom=?,
	mail=?, 
	Pays=?, 
	Telephone=?, 
	Telephone_portable=?, 
	adresse=?, 
	cp=?, 
	departement=?, 
	ville=?,
	CSP=?,
	Votre_quartier=?,
	Decrivez_un_peut_plus_chez_vous=?,
	Complement_d_adresse=?,

	same_adresse=?,
	Adresse_facturation=?,
	Votre_quartier_facturation=?,
	Code_postal_facturation=?,
	Ville_facturation=?,
	Pays_facturation=?,
	Decrivez_un_peut_plus_chez_vous_facturation=?,
	Complement_d_adresse_facturation=?,

	datenaissance=?,
	Code_securite=?
WHERE pseudo=?");
$sql_update->execute(array(
	time(), 
	$_SERVER['REMOTE_ADDR'], 
	htmlspecialchars($Nom), 
	htmlspecialchars($Prenom),
	htmlspecialchars($Mail), 
	htmlspecialchars($Pays), 
	htmlspecialchars($Telephone), 
	htmlspecialchars($Telephone_portable), 
	htmlspecialchars($Adresse), 
	htmlspecialchars($Code_postal), 
	htmlspecialchars($departement), 
	htmlspecialchars($Ville),
	htmlspecialchars($CSP),
	htmlspecialchars($Votre_quartier),
	htmlspecialchars($Decrivez_un_peut_plus_chez_vous),
	htmlspecialchars($Complement_d_adresse),
	htmlspecialchars($same_adresse),
	htmlspecialchars($_POST['Adresse_facturation']),
	htmlspecialchars($_POST['Votre_quartier_facturation']),
	htmlspecialchars($_POST['Code_postal_facturation']),
	htmlspecialchars($_POST['Ville_facturation']),
	htmlspecialchars($_POST['Pays_facturation']),
	htmlspecialchars($_POST['Decrivez_un_peut_chez_vous_facturation']),
	htmlspecialchars($_POST['Complement_d_adresse_facturation']),
	htmlspecialchars($datenaissance),
	htmlspecialchars($Code_securite),
	$user));                     
$sql_update->closeCursor();

if($statut_compte_oo == 2){
$sql_update = $bdd->prepare("UPDATE membres_professionnel SET
	Nom_societe=?,
	Numero_identification=?
	WHERE pseudo=?");
$sql_update->execute(array(
	htmlspecialchars($Nom_societe), 
	htmlspecialchars($Numero_identification),
	$user));                     
$sql_update->closeCursor();
}

	$mail_compte_concerne = $Mail;
	$module_log = "PROFIL";
	$action_sujet_log = "Notification de modification de vos données personnelles";
	$action_libelle_log = "Notification de votre compte <b>$mail_compte_concerne</b> sur $nomsiteweb. Vos données personnelles ont été modifiées sur votre espace utilisateur.
        Si vous n'êtes pas à l'origine des modifications de vos informations personnelles, veuillez sans attendre contacter un administrateur sur la page
	<a href='".$http."".$nomsiteweb."/Contact' target='blank_' style='text-decoration: underline;' >Contact</a>";
	$action_log = "MODIFICATION";
	$niveau_log = "2";
	$compte_bloque = "";
	log_h($mail_compte_concerne,$module_log,$action_sujet_log,$action_libelle_log,$action_log,$niveau_log,$compte_bloque);

	$result2 = array("Texte_rapport"=>"Modifications effectuées ! ","retour_validation"=>"ok","retour_lien"=>"");

}else{
	$result2 = $result2;

}

///////////////////////////////////////////////////////////////////////////////ACTION OK

$result2 = json_encode($result2);
echo $result2;

}else{
header('location:index.html');
}

ob_end_flush();
?>