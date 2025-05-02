<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
$variable_pdf_page = "oui";
require_once('../../Configurations_bdd.php');
require_once('../../Configurations.php');
require_once('../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction= "../../";
//require_once('../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

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

$action = $_GET['action'];
$idaction = $_GET['idaction'];

///////////////////////////////Configurations Devis - Factures
///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM configurations_pdf_devis_factures WHERE id=?");
$req_select->execute(array("1"));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$id_cfg_df = $ligne_select['id'];
$logo_pdf = $ligne_select['logo_pdf'];
$LAST_REFERENCE_DEVIS = $ligne_select['LAST_REFERENCE_DEVIS'];
$LAST_REFERENCE_FACTURE = $ligne_select['LAST_REFERENCE_FACTURE'];
$MODE_REFERENCE_1_2_3 = $ligne_select['MODE_REFERENCE_1_2_3'];
$LISTE_MAIL_CC = $ligne_select['LISTE_MAIL_CC'];
$En_Tete_Pdf = nl2br($ligne_select['En_Tete_Pdf']);
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
///////////////////////////////Configurations Devis - Factures

	///////////////////////////////SELECT
	if(isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo > 0 ){
		$req_select = $bdd->prepare("SELECT * FROM membres_prestataire_facture WHERE numero_facture=?");
		$req_select->execute(array($idaction));
	}elseif(!empty($user)){
		$req_select = $bdd->prepare("SELECT * FROM membres_prestataire_facture WHERE numero_facture=? AND pseudo=?");
		$req_select->execute(array($idaction,$user));
	}
	$ligne_select = $req_select->fetch();
	$req_select->closeCursor();
	$id_facture = $ligne_select['id'];

	///////////SI AUTORISE ON AFFICHE
	if(!empty($id_facture)){

	$id_membre = $ligne_select['id_membre'];
	$id_membrepseudo = $ligne_select['pseudo'];
	$numero_facture = $ligne_select['numero_facture'];
	$REFERENCE_NUMERO = $ligne_select['REFERENCE_NUMERO'];
	$id_commercial = $ligne_select['id_commercial'];
	$pseudo_commercial = $ligne_select['pseudo_commercial'];
	$Titre_facture = $ligne_select['Titre_facture'];
	$Contenu = $ligne_select['Contenu'];
	$Suivi = $ligne_select['Suivi'];
	$date_edition = $ligne_select['date_edition'];
	$date_edition = date('d-m-Y', $date_edition);
	$mod_paiement = $ligne_select['mod_paiement'];
	$Tarif_HT = $ligne_select['Tarif_HT'];
	$Remise = $ligne_select['Remise'];
	$Tarif_HT_net = round($ligne_select['Tarif_HT_net']);
	$Tarif_TTC = $ligne_select['Tarif_TTC'];
	$Total_Tva = $ligne_select['Total_Tva'];
	$taux_tva = $ligne_select['taux_tva'];
	$frais_livraison = $ligne_select['frais_livraison'] ? $ligne_select['frais_livraison'] : '0';
	$prix_expedition_total = $ligne_select['prix_expedition_total'] + $ligne_select['prix_expedition_colis_total']; 
	$condition_reglement = $ligne_select['condition_reglement'];
	$delai_livraison = $ligne_select['delai_livraison'];
	$prix_total_frais_expedition_TTC = round(($ligne_select['prix_frais_de_gestion_total']+$ligne_select['prix_prospection_total']+$ligne_select['prix_expedition_total']+$ligne_select['prix_expedition_colis_total'])*1.18, 0);
	$fraisgestion = $ligne_select['prix_frais_de_gestion_total'];
	$id_devis = $ligne_select['id_devis'];

	$Commentaire_information = $ligne_select['Commentaire_information'];

	if($Suivi == "payer"){
		$Suivi_informations = "Facture soldée";
	}else{
		$Suivi_informations = "Facture non soldée";
	}

	if(empty($dateedition1) || $dateedition1 == "" || $dateedition1 == 0 ){
		$dateedition = "0";
	}else{
		$dateedition = date('d/m/Y', $dateedition1);
	}

	//Commercial
	///////////////////////////////SELECT
	$req_select = $bdd->prepare("SELECT * FROM membres WHERE id=?");
	$req_select->execute(array($id_commercial));
	$ligne_select = $req_select->fetch();
	$req_select->closeCursor();
	$idd_com = $ligne_select['id']; 
	$email_com = $ligne_select['mail'];
	$nomm_com = $ligne_select['nom'];
	$prenomm_com = $ligne_select['prenom'];
	$telephoneposportable_com = $ligne_select['Telephone_portable'];
	$pseudo_skype_com = $ligne_select['pseudo_skype'];

	//Client
	///////////////////////////////SELECT
	$req_select = $bdd->prepare("SELECT * FROM membres WHERE pseudo=?");
	$req_select->execute(array($id_membrepseudo));
	$ligne_select = $req_select->fetch();
	$req_select->closeCursor();
	$idd_oo = $ligne_select['id']; 
	$pseudo2_oo = $ligne_select['pseudo'];
	$mail_oo = $ligne_select['mail'];
	$nom_oo = $ligne_select['nom'];
	$prenom_oo = $ligne_select['prenom'];
	$Pays_oo = $ligne_select['Pays'];
        $adresse_oo = $ligne_select['adresse'];
	$cp_oo = $ligne_select['cp'];
	$ville_oo = $ligne_select['ville'];
	$telephonepost_oo = $ligne_select['Telephone'];
	$cbb_oo = $ligne_select['reglement_accepte'];
	$nbgainsnbgains_oo = $ligne_select['nbgains'];
	$date_enregistrement_oo = $ligne_select['date_enregistrement'];
	$date_enregistrement_oo = date("d-m-Y", $date_enregistrement_oo);
	$post_skype_oo = $ligne_select['pseudo_skype'];
	$post_site_web_oo = $ligne_select['site_web'];
	$statut_compte_oo = $ligne_select['statut_compte'];

	///////////////////////////////SELECT
	$req_select = $bdd->prepare("SELECT * FROM membres_professionnel WHERE pseudo=?");
	$req_select->execute(array($id_membrepseudo));
	$ligne_select = $req_select->fetch();
	$req_select->closeCursor();
	$Nom_societe = $ligne_select['Nom_societe']; 
	$Numero_identification = $ligne_select['Numero_identification']; 

	$infos_client = "$Nom_societe $Numero_identification <br /> $prenom_oo $nom_oo <br /> $adresse_oo <br /> $ville_oo $cp_oo <br /> $mail_oo <br /> $telephonepost_oo";
?>

<style type="text/css">

td{
padding: 5px;
}
th{
padding: 5px;
}

table{
width: 100%;
}

.entete_informations{
font-size: 14px;
}

.info_banque td{
text-align: left; 
border: 1px solid #232E3F; 
}

.info_recap th{
background-color: #232E3F;
color: white;
padding: 10px;
}
.info_recap td{
border: 1px solid #232E3F;;
}

.info_reglement th{
// background-color: #983823;
background-color: #232E3F;
color: white;
padding: 10px;
}
.info_reglement td{
border: 1px solid #232E3F;;
}

.info_details th{
background-color: #232E3F;
color: white;
padding: 10px;
}
.info_details td{
border: 1px solid #232E3F;
}

.page_footer{
text-align: center;
width: 100%;
}

</style>
<page style="font-size: 12px">

<h1 style="display: none;" ></h1>

<table class="entete" >
	<tr>
		<td style="width: 60%; vertical-align: top;">
			<?php if(!empty($logo_pdf)AND file_exists("../../images/$logo_pdf")){ ?>
			<img src="../../images/<?php echo "$logo_pdf"; ?>" alt="<?php echo "$logo_pdf"; ?>" width="100"><br />
			<?php }else{ ?>
			
			<img src="../../images/Logo/My-hyro-logo.png" alt="<?php echo "$logo_pdf"; ?>" width="100"><br />
			<?php } ?>
		</td>
		<td style="width: 40%; vertical-align: middle;" >
			<strong style="font-size: 22px;" >Facture N°<?php echo "$numero_facture"; ?></strong>
		</td>
	</tr>
</table>

<table class="entete_informations" >
	<tr>
		<td style="width: 60%; vertical-align: top;">
			<?php echo "$En_Tete_Pdf"; ?>
		</td>
		<td style="width: 40%; vertical-align: top;" >
			<b>CLIENT (<?php echo "$pseudo2_oo"; ?>)</b><br />
			<?php echo "$infos_client"; ?>
		</td>
	</tr>
</table>

<table class="entete_intitule" style="margin-top: 70px;" >
	<tr>
		<td style="width: 60%;" >
			Objet: Facture <br />
			Intitulé : <?php echo "$Titre_facture"; ?> <br />
			Date d'émission : Edité le, <?php echo "$date_edition"; ?><br />
			<?php
			////////////////////////SI MODULE FACTURE COMMERCIAL ACTIVE
			if($Module_facture_commercial_active = "oui" && !empty($nomm_com)){
				echo "Conseillier : $nomm_com $prenomm_com ".$pseudo_skype_com_texte."- $email_com - $telephoneposportable_com";
			}
			?>
		</td>
		<td style="width: 40%;">
		</td>
	</tr>
</table>

<table class="info_details" style="margin-top: 40px;">
	<tr>
		<th style="width: 10%; ">Réf.</th>
		<th style="width: 50%;">Désignation</th>
		<th style="width: 10%;">Quantité</th>
		<th style="width: 15%;">PU HT</th>
		<th style="width: 15%;">Total HT</th>
	</tr>
<?php
///////////////////////////////SELECT BOUCLE
$req_boucle = $bdd->prepare("SELECT * FROM membres_prestataire_facture_details WHERE pseudo=? AND numero_facture=? ORDER BY id ASC");
$req_boucle->execute(array($id_membrepseudo,$numero_facture));
while($ligne_boucle = $req_boucle->fetch()){
$idd2dddf_compte_pro_oodd = $ligne_boucle['id']; 
$libellelibelle = $ligne_boucle['libelle'];
$PU_HTPU_HT = $ligne_boucle['PU_HT'];
$quantite = $ligne_boucle['quantite'];
$REFERENCE_DETAIL = $ligne_boucle['REFERENCE_DETAIL'];

if(empty($REFERENCE_DETAIL)){
	$i++;
	$REFERENCE_DETAIL = "$i";
}

if($PU_HTPU_HT == 0){
$eurosaa = "";
}else{
$eurosaa = utf8_decode("Euros");
}

if($quantite == 0){
$quantite = "";
}else{
$quantite = "$quantite";
}

?>
	<tr>
		<td style="width: 10%; "><?php echo $REFERENCE_DETAIL; ?></td>
		<td style="width: 50%;"><?php echo $libellelibelle; ?></td>
		<td style="width: 10%;"><?php echo $quantite; ?></td>
		<td style="width: 15%;"><?php echo round($PU_HTPU_HT); ?> Cfa</td>
		<td style="width: 15%;"><?php echo round(($PU_HTPU_HT*$quantite)); ?> Cfa</td>
	</tr>
<?php

$Tarif_HT = ($PU_HTPU_HT*$quantite);
$Tarif_HT_TOTAL = ($Tarif_HT+$Tarif_HT_TOTAL);
}
$req_boucle->closeCursor();
$Tarif_HT_net = $Tarif_HT_TOTAL;
//$Total_Tva = round(($Tarif_HT_net/100*20),2);
//$Tarif_TTC = ($Total_Tva+$Tarif_HT_net);
?>

</table>

<table class="info_recap" style="margin-top: 40px;">
<?php
if($Titre_facture == 'Abonnement'){
	$Tarif_HT_net = round($Tarif_HT_net);
	$Tarif_TTC = round($Tarif_HT_net+$Total_Tva);
	?>
		<tr>
		<th style="width: 33.33%; ">Total HT net</th>
		<th style="width: 33.33%;">TVA</th>
		<th style="width: 33.33%;">Net TTC</th>
	</tr>
	<tr>
		<td style="width: 33.33%; "><?php echo "$Tarif_HT_net"; ?> Cfa</td>
		<td style="width: 33.33%;"><?php echo "$Total_Tva"; ?> Cfa</td>
		<td style="width: 33.33%;"><?php echo "$Tarif_TTC"; ?> Cfa</td>
	</tr>
	<?php
}else{
	?>
		<tr>
		<th style="width: 20%; ">Frais de gestion</th>
		<th style="width: 20%; ">Total frais et expedition</th>
		<th style="width: 20%; ">Frais de livraison</th>
		<th style="width: 20%;">TVA</th>
		<th style="width: 20%;">Net TTC</th>
	</tr>
	<tr>
		<td style="width: 20%; "><?php echo "$fraisgestion"; ?> Cfa</td>
		<td style="width: 20%;"><?php echo "$prix_expedition_total"; ?> Cfa</td>
		<td style="width: 20%;"><?php echo "$frais_livraison"; ?> Cfa</td>
		<td style="width: 20%;"><?php echo "$Total_Tva"; ?> Cfa</td>
		<td style="width: 20%;"><?php echo "$Tarif_TTC"; ?> Cfa</td>
	</tr>
	<?php
}
?>


</table>

<table class="info_reglement" style="margin-top: 40px;" >
	<tr>
		<th style="width: 25%; ">Mode de paiement</th>
		<th style="width: 25%;">Délai de livraison</th>
		<th style="width: 25%;">Condition de paiement</th>
		<th style="width: 25%;">Statut</th>

	</tr>
	<tr>
		<td style="width: 25%; "><?php echo "$mod_paiement"; ?></td>
		<td style="width: 25%;"><?php echo "$delai_livraison"; ?></td>
		<td style="width: 25%;"><?php echo "$condition_reglement"; ?></td>
		<td style="width: 25%;"><?php echo "$Suivi_informations"; ?></td>

	</tr>

</table>

<?php
if(!empty($Banque_nom)){
?>
<table class="info_banque" style="margin-top: 40px;" >
	<tr>
		<td style="width: 20%; ">Banque : <br /><?php echo "$Banque_nom"; ?></td>
		<td style="width: 15%; ">Code : <br /><?php echo "$Banque_code"; ?></td>
		<td style="width: 30%;">N°compte : <br /><?php echo "$Banque_numero_compte"; ?></td>
		<td style="width: 20%;">Clé RIB : <br /><?php echo "$Banque_cle_rib"; ?></td>
		<td style="width: 15%;">BIC : <br /><?php echo "$Banque_bic"; ?></td>

	</tr>
</table>
<?php
}
?>

<table class="informations_legales" style="margin-top: 40px;" >
	<tr>
		<td style="text-align: left;">Taux des pénalités de retard : 40 Euros Pour frais de recouvrement, plus le taux d'intérêt légal en vigueur.</td>
	</tr>
</table>

<?php
/////////////////SI IL Y A UN COMMENTAIRE
if(!empty($Commentaire_information)){
?>
<table class="commantaires" style="margin-top: 40px;" >
	<tr>
		<td style="text-align: center;"><?php echo "$Commentaire_information"; ?></td>
	</tr>
</table>
<?php
}
/////////////////SI IL Y A UN COMMENTAIRE
?>

<page_footer class="page_footer" >
	<?php echo "$Pied_de_page_Pdf" ?>
	<br />
	[[page_cu]]/[[page_nb]]
</page_footer>

</page>

<?php
	}else{
		header('location: /index.html');
	}
	///////////SI AUTORISE ON AFFICHE

ob_end_flush();
?>