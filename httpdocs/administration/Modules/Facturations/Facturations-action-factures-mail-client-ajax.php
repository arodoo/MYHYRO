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
isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 4 ){

$idaction = $_POST['idaction'];

	///////////////////////////////SELECT
	$req_select = $bdd->prepare("SELECT * FROM membres_prestataire_facture WHERE id=?");
	$req_select->execute(array($idaction));
	$ligne_select = $req_select->fetch();
	$req_select->closeCursor();
	$id_facture = $ligne_select['id'];
	$id_membre = $ligne_select['id_membre'];
	$REFERENCE_NUMERO_SQL = $ligne_select['REFERENCE_NUMERO'];
	$id_membrepseudo = $ligne_select['pseudo'];
	$id_commercial = $ligne_select['id_commercial'];
	$pseudo_commercial = $ligne_select['pseudo_commercial'];
	$numero_facture = $ligne_select['numero_facture'];
	$Titre_facture = $ligne_select['Titre_facture'];
	$Contenu = $ligne_select['Contenu'];
	$Suivi = $ligne_select['Suivi'];
	$date_edition = $ligne_select['date_edition'];
	$date_edition = date('d-m-Y', $date_edition);
	$mod_paiement = $ligne_select['mod_paiement'];
	$Tarif_HT = $ligne_select['Tarif_HT'];
	$Remise = $ligne_select['Remise'];
	$Tarif_HT_net = $ligne_select['Tarif_HT_net'];
	$Tarif_TTC = $ligne_select['Tarif_TTC'];
	$Total_Tva = $ligne_select['Total_Tva'];
	$taux_tva = $ligne_select['taux_tva'];
	$condition_reglement = $ligne_select['condition_reglement'];
	$delai_livraison = $ligne_select['delai_livraison'];
	$Commentaire_information = $ligne_select['Commentaire_information'];

	///////////////////////////////SELECT
	$req_select = $bdd->prepare("SELECT * FROM membres WHERE pseudo=?");
	$req_select->execute(array($id_membrepseudo));
	$ligne_select = $req_select->fetch();
	$req_select->closeCursor();
	$idd2dddf = $ligne_select['id']; 
	$loginm = $ligne_select['pseudo'];
	$emailm = $ligne_select['mail'];
	$adminm = $ligne_select['admin'];
	$nomm = $ligne_select['nom'];
	$prenomm = $ligne_select['prenom'];
        $adressem = $ligne_select['adresse'];
	$cpm = $ligne_select['cp'];
	$villem = $ligne_select['ville'];
	$IM = $ligne_select['IM'];
	$IM_REGLEMENT = $ligne_select['IM_REGLEMENT'];
	$telephonepost = $ligne_select['Telephone'];
	$telephoneposportable = $ligne_select['Telephone_portable'];
	$cba = $ligne_select['newslettre'];
	$cbb = $ligne_select['reglement_accepte'];
	$FH = $ligne_select['femme_homme'];
	$datenaissance = $ligne_select['datenaissance'];
	$passwd = $ligne_select['pass'];
	$passwdd = $ligne_select['pass'];
	$pdate_etatdate_etat = $ligne_select['date_etat'];
	$date_enregistrement = $ligne_select['date_enregistrement'];
	$ip_inscription = $ligne_select['ip_inscription'];
	$statut_compte = $ligne_select['statut_compte'];

	///////////////////////////////SELECT
	$req_select = $bdd->prepare("SELECT * FROM membres_professionnel WHERE pseudo=?");
	$req_select->execute(array($loginm));
	$ligne_select = $req_select->fetch();
	$req_select->closeCursor();
	$id_pro_a = $ligne_select['id'];
	$Nom_societe_pro_a = $ligne_select['Nom_societe'];
	$Votre_role_a = $ligne_select['Votre_role'];
	$Type_societe_pro_a = $ligne_select['Type_societe'];
	$Effectif_pro_a = $ligne_select['Effectif'];
	$Numero_identification_pro_a = $ligne_select['Numero_identification'];
	$Non_assujetti_pro_a = $ligne_select['Non_assujetti'];
	$Numero_tva_pro_a = $ligne_select['Numero_tva'];

if($_POST['demande_paiement'] == "oui"){
$lien_de_paiement = "<br />Paiement : Vous pouvez cliquer sur cette page pour effectuer un paiement sécurisé : <br />
<a href='".$http."".$nomsiteweb."/Paiement/Facture/".$id_facture."'> Payer la facture maintenant </a> <br /><br />";
}

$lien_facture = "<a href='".$http."".$nomsiteweb."/facture-".$numero_facture."-".$nomsiteweb.".html' target='blank_'>".$http."".$nomsiteweb."/facture-".$numero_facture."-".$nomsiteweb.".html</a>";

///////////////////////Mail client
$de_nom = "$nomsiteweb"; //Nom de l'envoyeur
$de_mail = "$emaildefault"; //Email de l'envoyeur
$vers_nom = "$nomm $prenomm"; //Nom du receveur
$vers_mail = "$emailm"; //Email du receveur
$sujet = "Votre facture sur $nomsiteweb";

$message_principalone = "Bonjour,<br /><br />
Votre facture est disponible sur votre espace client ".$http."".$nomsiteweb.".<br /><br />
Vous pouvez également télécharger votre facture en format pro PDF en cliquant sur le lien suivant :<br />
".$lien_facture."<br />
$lien_de_paiement
Notre équipe reste à votre disposition.<br />
Bien cordialement, ";

mailsend($vers_mail, $vers_nom, $de_mail, $de_nom, $sujet, $message_principalone);
///////////////////////Mail client

$result = array("Texte_rapport"=>"Mail envoyé avec succès !","retour_validation"=>"ok","retour_lien"=>"");

$result = json_encode($result);
echo $result;

}else{
header('location: /index.html');
}

ob_end_flush();
?>