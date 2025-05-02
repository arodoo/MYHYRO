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

/////Function d'appel pour créer un compte
//$information_creation_compte = creation_compte("1",$information_variable,"non",$pseudo_creation,$Nom_post,$Prenom_post,$Adresse_post,$Ville_post,$Code_postal_post,$pays,$Telephone_post,$Telephone_portable,$Societe_post,$Siret_post,$post_societe,$type_societe,$nbr_effectif,$N_TVA_post,$Mail_post,$type_compte,"0",$siteweb,$pseudoskype,$password,"fr",$Id_commercial);
//$id_oo_ss = $information_creation_compte[0];
//$pseudo_compte = $information_creation_compte[1];


//////////////////////FONCTION INSCRIPTION AUTOMATIQUE
function creation_compte($Client, $information_variable, $Nom, $Prenom, $Adresse, $Ville, $Code_postal, $Pays, $Telephone, $Telephone_portable, $Nom_societe, $Siret, $post_societe, $type_societe, $nbr_effectif, $tva_societe, $Mail, $type_de_compte, $admin_compte, $siteweb, $pseudoskype, $choix_langue, $Id_commercial)
{
    $information_creation_compte = inscription();

    return $information_creation_compte;

}
//////////////////////FONCTION INSCRIPTION AUTOMATIQUE
//////////////////////FONCTION INSCRIPTION MANUEL EN FRONT
function creation_compte2($post_array, $mode_manuel)
{

    $pseudo_creation = $post_array['pseudo_creation'];
    $Client = $post_array['Client'];
    //$information_variable
    $Nom = $post_array['Nom'];
    $Prenom = $post_array['Prenom'];
    $Adresse = $post_array['Adresse'];
    $Ville = $post_array['Ville'];
    $Code_postal = $post_array['Code_postal'];
    $Birthday = (new Datetime($post_array['Birthday']))->getTimestamp();
    $Pays_naissance = $post_array["Pays"];
    $Pays = $post_array['Pays'];
    $Telephone = $post_array['Telephone'];
    $Telephone_portable = $post_array['Telephone_portable'];
    $Nom_societe = $post_array['Nom_societe'];
    $Siret = $post_array['Siret'];
    $post_societe = $post_array['post_societe'];
    $type_societe = $post_array['type_societe'];
    $nbr_effectif = $post_array['nbr_effectif'];
    $tva_societe = $post_array['tva_societe'];
    $Mail = $post_array['Mail'];
    $type_de_compte = $post_array['type_de_compte'];
    //$admin_compte = $post_array['admin_compte'];
    $siteweb = $post_array['siteweb'];
    $pseudoskype = $post_array['pseudoskype'];
    $password = $post_array['password'];
    $choix_langue = $post_array['choix_langue'];
	$Id_commercial = $post_array['Id_commercial'];
    $Abonnement = $post_array['Abonnement'];

    $information_creation_compte = inscription();

    return $information_creation_compte;

}
//////////////////////FONCTION INSCRIPTION MANUEL EN FRONT
//////////////////////FONCTION INSCRIPTION DEVIS
function creation_compte3($Client, $information_variable, $Nom, $Prenom, $Adresse, $Ville, $Code_postal, $Pays, $Telephone, $Telephone_portable, $Nom_societe, $Siret, $post_societe, $type_societe, $nbr_effectif, $tva_societe, $Mail, $type_de_compte, $admin_compte, $siteweb, $pseudoskype, $choix_langue, $Id_commercial, $mode_manuel)
{

    $information_creation_compte = inscription();

    return $information_creation_compte;

}
//////////////////////FONCTION INSCRIPTION DEVIS


//////////////////////FUNCTION INSCRIPTION GENERIQUE
function inscription()
{

    global $LAST_NUMERO_PARRAIN, $bdd, $mode_inscription_nbractivation_texte, $sujet, $pseudo_mail, $pseudo_compte_creation4, $mode_manuel, $Client, $information_variable, $pseudo_creation, $Nom, $Prenom, $Adresse, $Ville, $Code_postal, $Pays, $Pays_naissance, $Birthday, $Telephone, $Telephone_portable, $Nom_societe, $Siret, $post_societe, $type_societe, $nbr_effectif, $tva_societe, $Mail, $type_de_compte, $admin_compte, $siteweb, $pseudoskype, $password, $choix_langue,$Abonnement, $Id_commercial, $numero_parrain, $id_oo;

    if ($mode_manuel == "oui")
    {
        $dir_fonction_compte = "../../";
    }
    else
    {
        $dir_fonction_compte = "";
    }

	$req_check_mail = $bdd->prepare("SELECT * FROM membres WHERE mail=?");
    $req_check_mail->execute(array($Mail));
    $checker_line = $req_check_mail->fetch();
    $req_check_mail->closeCursor();
	
	if($checker_line)
	{
		return 'Email est déjà utilisé';
	}
	
    //Configurations
    ///////////////////////////////SELECT
    $req_select = $bdd->prepare("SELECT * FROM configurations_pdf_devis_factures WHERE id=?");
    $req_select->execute(array(
        "1"
    ));
    $ligne_select = $req_select->fetch();
    $req_select->closeCursor();
    $id_cfg_df = $ligne_select['id'];
    $logo_pdf = $ligne_select['logo_pdf'];
    $LAST_REFERENCE_DEVIS = $ligne_select['LAST_REFERENCE_DEVIS'];
    $LAST_REFERENCE_FACTURE = $ligne_select['LAST_REFERENCE_FACTURE'];
    $MODE_REFERENCE_1_2_3 = $ligne_select['MODE_REFERENCE_1_2_3'];
    $LISTE_MAIL_CC = $ligne_select['LISTE_MAIL_CC'];
    $En_Tete_Pdf = $ligne_select['En_Tete_Pdf'];
    $Pied_de_page_Pdf = $ligne_select['Pied_de_page_Pdf'];
    $Tva_coef = $ligne_select['Tva_coef'];
    $Taux_tva = $ligne_select['Taux_tva'];
    $Description_defaut_devis = $ligne_select['Description_defaut_devis'];
    $Description_defaut_facture = $ligne_select['Description_defaut_facture'];

    $Banque_nom = $ligne_select['Banque_nom'];
    $Banque_code = $ligne_select['Banque_code'];
    $Banque_numero_compte = $ligne_select['Banque_numero_compte'];
    $Banque_cle_rib = $ligne_select['Banque_cle_rib'];
    $Banque_iban = $ligne_select['Banque_iban'];
    $Banque_bic = $ligne_select['Banque_bic'];

    $Mode_couleur_SITE_DEFAUT = $ligne_select['Mode_couleur_SITE_DEFAUT'];
    $RIB = $ligne_select['RIB'];
    $date_mise_a_jour = $ligne_select['date_mise_a_jour'];

    $text_demande_de_devis = $ligne_select['text_demande_de_devis'];

    $informations_mail_supplemantaire = $ligne_select['informations_mail_supplemantaire'];

    ///////////////////////////////Informations mise en page mail
    ///////////////////////////////SELECT
    $req_select = $bdd->prepare("SELECT * FROM configuration_email WHERE id=?");
    $req_select->execute(array(
        "1"
    ));
    $ligne_select = $req_select->fetch();
    $req_select->closeCursor();
    $idcfgmail = $ligne_select['id'];
    $entete = $ligne_select['entete'];
    $pieddepage = $ligne_select['pieddepage'];
    $auteurmiseajour = $ligne_select['auteur_miseajour'];
    $nomsiteweb = $ligne_select['nom_siteweb'];
    $emaildefault = $ligne_select['email_default'];
    $logo_mail = $ligne_select['logo_mail'];
    ///////////////////////////////Informations mise en page mail
    //////////////////////////////CONFIGURATIONS GENERALES
    ///////////////////////////////SELECT
    $req_select = $bdd->prepare("SELECT * FROM configurations_preferences_generales");
    $req_select->execute();
    $ligne_select = $req_select->fetch();
    $req_select->closeCursor();
    $nom_proprietaire = $ligne_select['nom_proprietaire'];
    $text_informations_footer = $ligne_select['text_informations_footer'];
    $nomsiteweb = $ligne_select['nom_siteweb'];
    $http = $ligne_select['http'];
    $valeurtva = $ligne_select['tva'];
    $jeton_google = $ligne_select['jeton_google'];
    $Page_Facebook = $ligne_select['Page_Facebook'];
    $Page_twitter = $ligne_select['Page_twitter'];
    $Page_Google = $ligne_select['Page_Google'];
    $Page_Linkedin = $ligne_select['Page_Linkedin'];
    $Chaine_Youtube = $ligne_select['Chaine_Youtube'];
    $couleurFOND = $ligne_select['bloc_couleur_fond'];
    $couleurbordure = $ligne_select['bloc_couleur_bordure'];
    $bloc_couleur_complementaire = $ligne_select['bloc_couleur_complementaire'];
    $nbrpage = $ligne_select['nbr_ligne_page'];
    $Google_analytic = $ligne_select['Google_analytic'];
    $contact_libelle_messagerie = $ligne_select['contact_libelle_messagerie'];
    $pseudo_contact_messagerie = $ligne_select['pseudo_contact_messagerie'];
    $lien_conditions_generales = $ligne_select['lien_conditions_generales'];
    $mod_inscription = $ligne_select['mod_inscription'];
    $Mod_antirobot = $ligne_select['Mod_antirobot'];
    $inscriptionplusde18 = $ligne_select['inscriptionplusde18'];
    $Mode_Passwordmodif = $ligne_select['Mode_Password'];
    $pseudo_manuel = $ligne_select['pseudo_manuel'];
    //////////////////////////////CONFIGURATIONS GENERALES
    $now = time();

    if (!empty($password))
    {
        $passct = hash("sha256", $password);

    }
    else
    {
        $password = create_password();
        $passct = hash("sha256", $password);

    }

    ///////////////////////////////SELECT
    $req_select = $bdd->prepare("SELECT * FROM configurations_preferences_generales");
    $req_select->execute();
    $ligne_select = $req_select->fetch();
    $req_select->closeCursor();
    $LAST_NUMERO_PARRAIN = $ligne_select['LAST_NUMERO_PARRAIN'];
    $LAST_NUMERO_PARRAIN = ($LAST_NUMERO_PARRAIN + 1);

    //////////////////////////////////////////////////////////////////CRETAION DU COMPTE
    ////////////////////LE DERNIER ID MEMBRE ENREGISTRE
    ///////////////////////////////SELECT
    $req_select = $bdd->prepare("SELECT * FROM membres ORDER BY id DESC");
    $req_select->execute();
    $ligne_select = $req_select->fetch();
    $req_select->closeCursor();
    $id_oo_creation = $ligne_select['id'];


    //$pseudo_compte_creation1_domaine = substr("$nomsiteweb",0,2);
    //$pseudo_compte_creation1_domaine = strtoupper($pseudo_compte_creation1_domaine);
    //SI VARIABLE DU PSEUDO EST VIDE
    if (empty($pseudo_creation))
    {

        $pseudo_compte_creation1 = substr("$Nom", 0, 2);
        $pseudo_compte_creation2 = substr("$Prenom", 0, 2);
        $pseudo_compte_creation3 = ($id_oo_creation + 1);
        $pseudo_compte_creation4 = "$information_variable" . $pseudo_compte_creation1 . "" . $pseudo_compte_creation2 . "0" . $pseudo_compte_creation3 . "";
        $pseudo_compte_creation4 = strtoupper($pseudo_compte_creation4);
        $pseudo_compte_creation4 = cara_replace($pseudo_compte_creation4);
    }
    else
    {
        $pseudo_compte_creation4 = $pseudo_creation;
    }

    //}
    if (!empty($Code_postal))
    {
        $Code_departement = substr($Code_postal, 0, 2);
    }

    if (empty($admin_compte))
    {
        $admin_compte = 0;
    }
    if (empty($Client))
    {
        $Client = 0;
    }
    if (empty($mode_inscription_nbractivation))
    {
        $mode_inscription_nbractivation = "";
    }
    if (empty($type_de_compte))
    {
        $type_de_compte = "";
    }
    if (empty($Id_commercial))
    {
        $Id_commercial = "";
    }

    ///////////////////////////////INSERT
    $sql_insert = $bdd->prepare("INSERT INTO membres
	(pseudo,
	pass,
	mail,
	nom,
	prenom,
	adresse,
	ville,
	cp,
	departement,
	newslettre,
	reglement_accepte,
	admin,
	ip_inscription,
	Telephone,
	Telephone_portable,
    Pays,
    pays_naissance,
    datenaissance,
	nbractivation,
	statut_compte,
	last_ip,
	supprimer,
	Activer,
	Abonnement_id,
	Abonnement_date,
	Abonnement_date_expiration)
	VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $sql_insert->execute(array(
        htmlspecialchars($pseudo_compte_creation4),
        htmlspecialchars($passct),
        htmlspecialchars($Mail),
        htmlspecialchars($Nom),
        htmlspecialchars($Prenom),
        htmlspecialchars($Adresse),
        htmlspecialchars($Ville),
        htmlspecialchars($Code_postal),
        htmlspecialchars($Code_departement),
        '1',
        'oui',
        htmlspecialchars($admin_compte),
        '',
        htmlspecialchars($Telephone),
        htmlspecialchars($Telephone),
        htmlspecialchars($Pays),
        htmlspecialchars($Pays),
        htmlspecialchars($Birthday),
        htmlspecialchars($mode_inscription_nbractivation),
        1,
        '',
        'non',
        'oui',
	1,
	time(),
	(time()+(86400*365)),
    ));
	$sql_insert->closeCursor();
    
    $lastInsertId = $bdd->lastInsertId();

    //SI MODE INSCRIPTION - CONFIRMATION MAIL
    if($mode_manuel == "oui" ){
    $passvalidation = $passct . "" . bin2hex(random_bytes(5)) . $lastInsertId;
    $mode_inscription_nbractivation = "$passvalidation";
    $mode_inscription_nbractivation_texte = "Pour confirmer et activer votre compte, merci de cliquer sur le lien suivant ou<br/> 
    de le copier coller dans la barre de recherche de votre navigateur : <br/> <br/> 
    <a href='" . $http . "" . $nomsiteweb . "/Inscription-confirmation-" . $mode_inscription_nbractivation . ".html' target='blank_'>" . $http . "" . $nomsiteweb . "/Inscription-confirmation-" . $mode_inscription_nbractivation . ".html</a><br/><br/>";

    $sql_update = $bdd->prepare("UPDATE membres SET nbractivation=? WHERE id=?");
    $sql_update->execute(array(
        htmlspecialchars($mode_inscription_nbractivation),
        $lastInsertId
    ));
    $sql_update->closeCursor();
    }
    //////INSERT ID membre
    ///////////////////////////////SELECT
    $req_select = $bdd->prepare("SELECT * FROM membres WHERE pseudo=?");
    $req_select->execute(array(
        htmlspecialchars($pseudo_compte_creation4)
    ));
    $ligne_select = $req_select->fetch();
    $req_select->closeCursor();
    $id_membre_insert = $ligne_select['id'];

    if(strlen($id_membre_insert) == 1){
    	$numero_client  = "000".$ligne_select['id']."";
    }elseif(strlen($id_membre_insert) == 2){
    	$numero_client  = "00".$ligne_select['id']."";
    }elseif(strlen($id_membre_insert) == 3){
    	$numero_client  = "0".$ligne_select['id']."";
    }elseif(strlen($id_membre_insert) > 3){
    	$numero_client  = "".$ligne_select['id']."";
    }

    ///////////////////////////////UPDATE
    $sql_update = $bdd->prepare("UPDATE membres SET numero_client=? WHERE id=?");
    $sql_update->execute(array($numero_client,$id_membre_insert));                     
    $sql_update->closeCursor();

    if($Abonnement == '2' || $Abonnement == '3'){


        $sql_delete = $bdd->prepare("DELETE FROM membres_commandes WHERE user_id=? AND statut='3'");
		$sql_delete->execute(array(htmlspecialchars($id_membre_insert)));                     
		$sql_delete->closeCursor();

				///////////////////////////////DELETE
				$sql_delete = $bdd->prepare("DELETE FROM membres_colis WHERE user_id=? AND statut='1'");
				$sql_delete->execute(array(htmlspecialchars($id_membre_insert)));                     
				$sql_delete->closeCursor();

		///////////////////////////////DELETE
		$sql_delete = $bdd->prepare("DELETE FROM membres_panier WHERE id_membre=?");
		$sql_delete->execute(array(htmlspecialchars($id_membre_insert)));                     
		$sql_delete->closeCursor();

		///////////////////////////////DELETE
		$sql_delete = $bdd->prepare("DELETE FROM membres_panier_details WHERE id_membre=?");
		$sql_delete->execute(array(htmlspecialchars($id_membre_insert)));                     
		$sql_delete->closeCursor();

    $req_select3 = $bdd->prepare("SELECT * FROM configurations_abonnements WHERE id=?");
	$req_select3->execute(array($Abonnement));
	$ligne_select3 = $req_select3->fetch();
	$req_select3->closeCursor();

		$now = time();
		$now_expiration = date('d-m-Y', $now);
    
	$libelle_details_article = "Abonnement : ".$ligne_select3['nom_abonnement']." - Date expiration $now_expiration";
	//var_dump($Tva_coef);
	$libelle_prix_articleht = ($ligne_select3['Prix']/(1+$Tva_coef));
	$libelle_prix_articleht = round($libelle_prix_articleht,2);
	$libelle_tva_article = ($ligne_select3['Prix']-$libelle_prix_articleht);
	$libelle_taux_tva_article = "$Taux_tva";
	$libelle_id_article = "$Abonnement";

	ajout_panier($libelle_details_article,"1",$libelle_prix_articleht,$libelle_tva_article,(1+$Tva_coef),"Abonnement",null,$libelle_id_article,$pseudo_compte_creation4,"Abonnement","$Abonnement",time());
    }else{
        	///////////////////////////////UPDATE
			$sql_update = $bdd->prepare("UPDATE membres_commandes SET
            user_id=? 
            WHERE id=?");
        $sql_update->execute(array(
            $id_membre_insert,
            htmlspecialchars($_SESSION['id_commande'])));                    
        $sql_update->closeCursor();

        ///////////////////////////////UPDATE
        $sql_update = $bdd->prepare("UPDATE membres_colis SET
            user_id=? 
            WHERE id=?");
        $sql_update->execute(array(
            $id_membre_insert,
            htmlspecialchars($_SESSION['id_colis'])));                    
        $sql_update->closeCursor();

        ///////////////////////////////UPDATE
        $sql_update = $bdd->prepare("UPDATE membres_panier_details SET
            id_membre=? 
            WHERE id_membre=?");
        $sql_update->execute(array(
            $id_membre_insert,
            htmlspecialchars($id_oo)));                    
        $sql_update->closeCursor();

        ///////////////////////////////UPDATE
        $sql_update = $bdd->prepare("UPDATE membres_panier SET
            id_membre=? 
            WHERE id_membre=?");
        $sql_update->execute(array(
            $id_membre_insert,
            htmlspecialchars($id_oo)));                    
        $sql_update->closeCursor();
    }
    //////INSERT ID membre
    //On créer le dossier du membre
    if (!file_exists("" . $_SERVER['DOCUMENT_ROOT'] . "/images/membres/$pseudo_compte_creation4"))
    {
        mkdir("" . $_SERVER['DOCUMENT_ROOT'] . "/images/membres/$pseudo_compte_creation4");
    }

    if (!empty($Nom_societe) || !empty($Siret))
    {
        ///////////////////////////////INSERT
        $sql_insert = $bdd->prepare("INSERT INTO membres_professionnel
	(id_membre,
	pseudo,
	Nom_societe,
	Votre_role,
	Type_societe,
	Effectif,
	Numero_identification,
	Numero_tva)
	VALUES (?,?,?,?,?,?,?,?)");
        $sql_insert->execute(array(
            $id_membre_insert,
            htmlspecialchars($pseudo_compte_creation4),
            htmlspecialchars($Nom_societe),
            htmlspecialchars($post_societe),
            htmlspecialchars($type_societe),
            htmlspecialchars($nbr_effectif),
            htmlspecialchars($Siret),
            htmlspecialchars($tva_societe)
        ));
        $sql_insert->closeCursor();

    }

    //////////Newsletter
    ///////////////////////////////INSERT
    $sql_insert = $bdd->prepare("INSERT INTO Newsletter_listing
	(Mail,
	Numero_id,
	date,
	plus,
	plus1)
	VALUES (?,?,?,?,?)");
    $sql_insert->execute(array(
        htmlspecialchars($Mail),
        htmlspecialchars($passcone),
        htmlspecialchars($now),
        '',
        ''
    ));
    $sql_insert->closeCursor();

    ///////////////////////////////////////////////////////////////CONNECTION AUTO
    if ($mode_manuel == "")
    {
        $_SESSION['pseudo'] = $id_membre_insert;
        $_SESSION['4M8e7M5b1R2e8s'] = "A9lKJF0HJ12YtG7WxCl12";
    }

    ///////////////////////Mail client
    $de_nom = "$nomsiteweb"; //Nom de l'envoyeur
    $de_mail = "$emaildefault"; //Email de l'envoyeur
    $vers_nom = "$Nom $Prenom"; //Nom du receveur
    $vers_mail = "$Mail"; //Email du receveur
    $sujet = "Votre inscription sur $nomsiteweb";

    $message_principalone = "<b>Objet :</b> $sujet<br /><br />
    <b>Bonjour, </b><br /><br /> 
    Bonjour ".$Prenom.", 
    $infos_demande
    $mode_inscription_nbractivation_texte
    Bienvenue dans la communauté hyro ! <br /><br />
    Vous avez demandé à ouvrir un compte sur <a href='".$http."".$nomsiteweb."' target='blank_' >my-hyro.com</a> et nous vous remercions pour votre confiance. Votre numéro client est le ".$numero_client.". <br /><br />
    Nous vous confirmons les éléments vous permettant d'accéder à votre compte : <br /><br />
    E-mail : $Mail <br /><br />
    Utilisez ces mêmes identifiants pour toutes vos commandes, cela vous évitera d'avoir à ressaisir à chaque fois vos coordonnées. 
    Nous sommes ravis de vous compter parmi nos privilégiés et restons à votre service pour vous faciliter vos achats en ligne sur vos sites préférés !<br /><br />
     <u>Quelques liens utiles : </u><br />
     <a href='".$http."".$nomsiteweb."/Gestion-de-votre-compte.html' target='blank_' >1) Pour accéder à votre compte client, modifier vos coordonnées, vos adresses de livraison et/ou facturation, cliquez ici</a><br />
     <a href='".$http."".$nomsiteweb."/Mes-commandes' target='blank_' >2) Pour accéder directement au passage d’une commandes, cliquez ici</a><br /><br />
     Pour tous les accès précités, vous devrez renseigner au préalable les identifiants inclus au début de ce mail. <br /><br />
     Le service client se tient à votre disposition <br /><br />
     Nos conseillers répondront à toutes vos questions au +241 05 19 36 94 et +336 50 68 01 67, du lundi au vendredi de 8h30 à 20h00, le samedi de 9h00 à 18h00
     et les dimanches et jours fériés au +241 05 19 36 94 et +336 50 68 01 67, de 10h00 à 18h00 (sauf le 25 décembre et le 1er janvier) <br /><br />
     Très cordialement, <br />
     L'équipe HYRO »<br />
    <br />";
    mailsend($vers_mail, $vers_nom, $de_mail, $de_nom, $sujet, $message_principalone);
    ///////////////////////Mail client

    ///////////////////////Mail support
    $de_nom = "$Nom $Prenom"; //Nom de l'envoyeur
    $de_mail = "$Mail"; //Email de l'envoyeur
    $vers_nom = "$nomsiteweb"; //Nom du receveur
    $vers_mail = "$emaildefault"; //Email du receveur
    $sujet = "Nouvelle inscription sur $nomsiteweb";

    $message_principalone = "<b>Objet :</b> $sujet<br /><br />
  <b>Bonjour, </b><br /><br />  
  $infos_demande
  <b><u>Récapitulatif:</u></b><br /><br />
  <b>Pseudo du compte :</b><span style='color: green;'> $pseudo_compte_creation4 </span><br />
  <b>L'email associé :</b> $Mail <br /><br />
  <b>Nom d'usage :</b> $Nom <br />
  <b>Prénom :</b> $Prenom <br />
  <br />
  Cordialement, l'équipe
  <br />";
    mailsend($vers_mail, $vers_nom, $de_mail, $de_nom, $sujet, $message_principalone);
    ///////////////////////Mail support
    $information_creation_compte = array(
        $id_membre_insert,
        $pseudo_compte_creation4,
        $password
    );

    return $information_creation_compte;

}
//////////////////////FUNCTION INSCRIPTION GENERIQUE

?>
