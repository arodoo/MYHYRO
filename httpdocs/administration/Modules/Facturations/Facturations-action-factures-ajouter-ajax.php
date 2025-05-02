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

$now =  time();

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
isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 4 ){

$idaction = $_POST['idaction'];

///////////////ACTION

if(!empty($_POST['Type_client'])){

$now = time();
$Type_client = $_POST['Type_client'];

if($_POST['Type_client'] == "Client enregistré ?" && !empty($_POST['Pseudo_post']) ){

$Pseudo_post = $_POST['Pseudo_post'];

//////////////////////////////CREATION FACTURE

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM membres WHERE pseudo=?");
$req_select->execute(array($Pseudo_post));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$id_oo_ss = $ligne_select['id'];
$Code_postal_devis = $ligne_select['cp'];

if(!empty($Code_postal_devis)){
$Code_departement = substr($Code_postal_devis,0,2);
}

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM configurations_pdf_devis_factures WHERE id=1");
$req_select->execute();
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$LAST_REFERENCE_FACTURE_BROUILLON = $ligne_select['LAST_REFERENCE_FACTURE_BROUILLON'];
$LAST_REFERENCE_FACTURE_BROUILLON = ($LAST_REFERENCE_FACTURE_BROUILLON+1);

$sql_update = $bdd->prepare("UPDATE configurations_pdf_devis_factures SET 
	LAST_REFERENCE_FACTURE_BROUILLON=?
	WHERE id=?");
$sql_update->execute(array(
	$LAST_REFERENCE_FACTURE_BROUILLON,
	'1'));                     
$sql_update->closeCursor();

///////////////////////////////INSERT
$sql_insert = $bdd->prepare("INSERT INTO membres_prestataire_facture
	(id_membre,
	pseudo,
	REFERENCE_NUMERO,
	numero_facture,
	Suivi,
	departement,
	date_edition,
	jour_edition, 
	mois_edition, 
	annee_edition,
	statut)
	VALUES (?,?,?,?,?,?,?,?,?,?,?)");
$sql_insert->execute(array(
	$id_oo_ss,
	$Pseudo_post,
	"BO-".$LAST_REFERENCE_FACTURE_BROUILLON."",
	"BO-".$LAST_REFERENCE_FACTURE_BROUILLON."",
	'non payer',
	$Code_departement,
	$now,
	date('d',$now),
	date('m',$now),
	date('Y',$now),
	'Brouillon'));                     
$sql_insert->closeCursor();

//////////////////////////////CREATION FACTURE

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM membres_prestataire_facture WHERE date_edition=?");
$req_select->execute(array($now));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$id_url = $ligne_select['id'];

//////////////////////////////CREATION FACTURE

$result = array("Texte_rapport"=>"","retour_validation"=>"ok","retour_lien"=>"$id_url");

}elseif($_POST['Type_client'] == "Client enregistré ?" && empty($_POST['Pseudo_post'])){
$result = array("Texte_rapport"=>"Vous devez choisir un client !","retour_validation"=>"","retour_lien"=>"");

}elseif($_POST['Type_client'] == "Client non enregistré ?"){

$now = time();

$Societe = $_POST['Societe'];
$Siret = $_POST['Siret'];
$N_TVA = $_POST['N_TVA'];

$Nom = $_POST['Nom'];
$Prenom = $_POST['Prenom'];
$Adresse = $_POST['Adresse'];
$Ville = $_POST['Ville'];
$Code_postal = $_POST['Code_postal'];
$client_submit = $_POST['client'];
$pays = $_POST['payspost'];
$type_compte = $_POST['type_compte'];

$Telephone = $_POST['Telephone'];
$Portable = $_POST['Portable'];
$Mail = $_POST['Mail'];

/////Function d'appel pour créer un compte 
$information_creation_compte = creation_compte($Client,$information_variable,$Nom,$Prenom,$Adresse,$Ville,$Code_postal,$Pays,$Telephone,$Telephone_portable,$Nom_societe,$Siret,$post_societe,$type_societe,$nbr_effectif,$tva_societe,$Mail,$type_de_compte,$admin_compte,$siteweb,$pseudoskype,$choix_langue,$Id_commercial);

$id_oo_ss = $information_creation_compte[0];
$pseudo_compte = $information_creation_compte[1];

//////////////////////////////CREATION FACTURE

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM configurations_pdf_devis_factures WHERE id=1");
$req_select->execute();
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$LAST_REFERENCE_FACTURE_BROUILLON = $ligne_select['LAST_REFERENCE_FACTURE_BROUILLON'];
$LAST_REFERENCE_FACTURE_BROUILLON = ($LAST_REFERENCE_FACTURE_BROUILLON+1);

$sql_update = $bdd->prepare("UPDATE configurations_pdf_devis_factures SET 
	LAST_REFERENCE_FACTURE_BROUILLON=?
	WHERE id=?");
$sql_update->execute(array(
	$LAST_REFERENCE_FACTURE_BROUILLON,
	'1'));                     
$sql_update->closeCursor();

if(!empty($Code_postal_post)){
$Code_departement = substr($Code_postal_post,0,2);
}

///////////////////////////////INSERT
$sql_insert = $bdd->prepare("INSERT INTO membres_prestataire_facture
	(id_membre,
	pseudo,
	REFERENCE_NUMERO,
	numero_facture,
	Suivi,
	departement,
	date_edition,
	jour_edition, 
	mois_edition, 
	annee_edition,
	statut )
	VALUES (?,?,?,?,?,?,?,?,?,?,?)");
$sql_insert->execute(array(
	$id_oo_ss,
	$Pseudo_post,
	"BO-".$LAST_REFERENCE_FACTURE_BROUILLON."",
	"BO-".$LAST_REFERENCE_FACTURE_BROUILLON."",
	'non payer',
	$Code_departement,
	$now,
	date('d',$now),
	date('m',$now),
	date('Y',$now),
	'Brouillon'));                     
$sql_insert->closeCursor();

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM membres_prestataire_facture WHERE date_edition=?");
$req_select->execute(array($now));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$id_url = $ligne_select['id'];

//////////////////////////////CREATION FACTURE

$result = array("Texte_rapport"=>"","retour_validation"=>"ok","retour_lien"=>"$id_url");
}

}elseif(empty($_POST['Type_client'])){
$result = array("Texte_rapport"=>"Vous devez choisir un type de client !","retour_validation"=>"","retour_lien"=>"");


}
////////////////////////////AJOUTER

$result = json_encode($result);
echo $result;

}else{
header('location: /index.html');
}
ob_end_flush();
?>