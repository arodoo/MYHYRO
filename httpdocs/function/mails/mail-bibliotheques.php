<?php

function mail_bi($type_scan,$id_mail_requete){

global $bdd,$suivi_commentaire,$suivi,$objet_du_litige,$commentaire_auteur_du_litige,$commentaire_destinataire_du_litige,$statut,$commentaire_administrateur,$lien_litige,$forfait_date_expiration_mail,$nom_option_mail,$duree_prix_mail,$Nom_du_forfait,$nowtime,$total_TTC,$modepaiements,$information_mail,$lien_devis,$lien_facture,$lien_de_paiement,$objetpost,$Namepost,$messagepost,$mailpost,$id_cc_fichier_i_w_demande,$pseudo_mail,$now,$idaction,$lien_desabonnement,$nom_article_titre1_post,$nom_article_titre1_post_url,$description_articles_post,$loginm,$nomm,$prenomm,$adressem,$villem,$cpm,$paypost,$telephonepost,$telephoneposportable,$newpass,$lien_recuperation,$pseudo_compte_creation4,$password,$Mail,$Nom,$Prenom,$mode_inscription_nbractivation_texte,$http,$nomsiteweb,$emaildefault,$nom_oo,$prenom_oo,$mail_oo,$user,$sujet;

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM configuration_email_bibliotheques WHERE id=?");
$req_select->execute(array($id_mail_requete));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$idmail_requete= $ligne_select['id'];
$id_groupe_mail= $ligne_select['id_groupe_mail'];
$contenu_sujet_mail= $ligne_select['contenu_sujet_mail'];
$contenu_corp_mail= $ligne_select['contenu_corp_mail'];

///////////////////////////////SELECT BOUCLE
$req_boucle = $bdd->prepare("SELECT * FROM configuration_email_bibliotheques_cles WHERE id_mail=?");
$req_boucle->execute(array($idmail_requete));
while($ligne_boucle = $req_boucle->fetch()){
$cle_variable_mail_cle= $ligne_boucle['cle_variable_mail'];
$variable_mail_cle= $ligne_boucle['variable_mail'];

$variable_initiale = ${$ligne_boucle['variable_mail']};

if($type_scan == "sujet"){
	$contenu_sujet_mail = str_replace($cle_variable_mail_cle,$variable_initiale,$contenu_sujet_mail);
}else{
	$contenu_corp_mail = str_replace($cle_variable_mail_cle,$variable_initiale,$contenu_corp_mail);
}

}
$req_boucle->closeCursor();

if($type_scan == "sujet"){
	return $contenu_sujet_mail;
}else{
	return $contenu_corp_mail;
}

}
//////////////////////////ON RENOME VARIABLE PSEUDO POUR PAS AVOIR DE CHIFFRE 

?>