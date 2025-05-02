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

?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
	</head>
	<body> 
		<?php

		$now = time();

		$idactionnn = $_GET['idactionnn'];
		$onajoute11 = $_GET['onajoute11'];
		$unParametre = $_GET['unParametre'];
		$a = $_GET['a'];

	$parametre1 = $_GET['parametre1'];
	$parametre2 = $_GET['parametre2'];
	$parametre3 = $_GET['parametre3'];
	$parametre4 = $_GET['parametre4'];

	///////////////////////////////SELECT
	$req_select = $bdd->prepare("SELECT * FROM membres_prestataire_facture WHERE id=?");
	$req_select->execute(array($idactionnn));
	$ligne_select = $req_select->fetch();
	$req_select->closeCursor();
	$id_facture = $ligne_select['id'];
	$id_membre = $ligne_select['id_membre'];
	$id_membrepseudo = $ligne_select['pseudo'];
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

//////////////////////////////////////////////ACTION - AJOUTER DETAILS
if($onajoute11 == "Ajouter"){

$parametre2 = str_replace(",", ".", $parametre2);

///////////////////////////////INSERT
$sql_insert = $bdd->prepare("INSERT INTO membres_prestataire_facture_details
	(id_membre,
	pseudo,
	numero_facture,
	libelle,
	PU_HT,
	quantite,
	REFERENCE_DETAIL)
	VALUES (?,?,?,?,?,?,?)");
$sql_insert->execute(array(
	$id_membre,
	$id_membrepseudo,
	$numero_facture,
	$parametre1,
	$parametre2,
	$parametre3,
	$parametre4));                     
$sql_insert->closeCursor();

}
//////////////////////////////////////////////ACTION - AJOUTER DETAILS


//////////////////////////////////////////////SUPPRIMER DETAILS
if($onajoute11 == "Supprimer"){

///////////////////////////////DELETE
$sql_delete = $bdd->prepare("DELETE FROM  membres_prestataire_facture_details WHERE id=?");
$sql_delete->execute(array($parametre1));                     
$sql_delete->closeCursor();

}
//////////////////////////////////////////////SUPPRIMER DETAILS

		?>

<div style='text-align: left;'>

<h3>D&eacute;tails de la facture</h3>

<table style='width: 100%;'>
<tr>
<td style='padding: 10px; text-align: center; width: 10%; border-top-left-radius: 10px; background-color: <?php echo "$couleurbordure"; ?>; color: <?php echo "$couleurFOND"; ?>;' >REFERENCE</td>
<td style='padding: 10px; text-align: center; width: 50%; background-color: <?php echo "$couleurbordure"; ?>; color: <?php echo "$couleurFOND"; ?>;' >LIBELLE</td>
<td style='padding: 10px; text-align: center; width: 14%; background-color: <?php echo "$couleurbordure"; ?>; color: <?php echo "$couleurFOND"; ?>;' >P.U H.T</td>
<td style='padding: 10px; text-align: center; width: 10%; background-color: <?php echo "$couleurbordure"; ?>; color: <?php echo "$couleurFOND"; ?>;' >QTS</td>
<td style='padding: 10px; text-align: center; width: 14%; background-color: <?php echo "$couleurbordure"; ?>; color: <?php echo "$couleurFOND"; ?>;' >TOTAL H.T</td>
<td style='padding: 10px; text-align: center; width: 2%; border-top-right-radius: 10px; background-color: <?php echo "$couleurbordure"; ?>; color: <?php echo "$couleurFOND"; ?>;' ></td>
</tr>
<?php
///////////////////////////////SELECT BOUCLE
$req_boucle = $bdd->prepare("SELECT * FROM membres_prestataire_facture_details WHERE numero_facture=?");
$req_boucle->execute(array($numero_facture));
while($ligne_boucle = $req_boucle->fetch()){
$id_details = $ligne_boucle['id'];
$numero_facture_details = $ligne_boucle['numero_facture'];
$libelle_details = $ligne_boucle['libelle'];
$PU_HT_details = $ligne_boucle['PU_HT'];
$quantite_details = $ligne_boucle['quantite'];
$REFERENCE_DETAIL = $ligne_boucle['REFERENCE_DETAIL'];

$montant_total_ht = ($montant_total_ht+($PU_HT_details*$quantite_details));
$montant_total_ht = round($montant_total_ht,2);
if(empty($montant_total_ht)){
$montant_total_ht = "0";
}

?>
<tr>
<td style='padding: 10px; text-align: center; width: 10%; border-bottom: 1px solid <?php echo "$couleurbordure"; ?>;'><?php echo "$REFERENCE_DETAIL"; ?></td>
<td style='padding: 10px; text-align: center; width: 49%; border-bottom: 1px solid <?php echo "$couleurbordure"; ?>;'><?php echo "$libelle_details"; ?></td>
<td style='padding: 10px; text-align: center; width: 14%; border-bottom: 1px solid <?php echo "$couleurbordure"; ?>;'><?php echo "$PU_HT_details"; ?>&euro;</td>
<td style='padding: 10px; text-align: center; width: 10%; border-bottom: 1px solid <?php echo "$couleurbordure"; ?>;'><?php echo "$quantite_details"; ?></td>
<td style='padding: 10px; text-align: center; width: 14%; border-bottom: 1px solid <?php echo "$couleurbordure"; ?>;'><?php echo ($PU_HT_details*$quantite_details); ?>&euro;</td>
<td style='padding: 10px; text-align: center; width: 2%; border-bottom: 1px solid <?php echo "$couleurbordure"; ?>;'><a href='javascript:maFonctionAjaxa2("Supprimer","<?php echo "$id_details"; ?>");'><span class='uk-icon-times' style='color: red;'></span></a></td>
</tr>
<?php
}
$req_boucle->closeCursor();

if(empty($id_details)){
?>
<tr><td style='padding: 10px;  text-align: center; width: 100%; border-bottom: 1px solid <?php echo "$couleurbordure"; ?>;' colspan='6'><?php echo "Auncune d&eacute;signation pour le moment !"; ?></td></tr>
<?php
}
?>

</table>

<?php

if(empty($montant_total_ht)){
$montant_total_ht = "0";
}

//////////////////////////////////////////////REMISE 
if($onajoute11 == "Remise"){

	$Remise = "$parametre1";

	if(!empty($Remise)){
		$coef_remiserr = ($Remise/100);
		$coef_remiserr = ($coef_remiserr);
		$montant_total_ht_netremise = ($montant_total_ht*$coef_remiserr);

		// $montant_total_ht_netremise = ($montant_total_ht-$montant_total_ht_netremise);
		$Remise = round($montant_total_ht_netremise, 2);
	}

///////////////////////////////UPDATE
$sql_update = $bdd->prepare("UPDATE membres_prestataire_facture SET Remise=? WHERE id=?");
$sql_update->execute(array($Remise,$id_facture));                     
$sql_update->closeCursor();

}
//////////////////////////////////////////////REMISE 


//////////////////////////////////////////////REMISE 
if($onajoute11 == "SupprimerRemise"){

///////////////////////////////UPDATE
$sql_update = $bdd->prepare("UPDATE membres_prestataire_facture SET Remise=? WHERE id=?");
$sql_update->execute(array('',$id_facture));                     
$sql_update->closeCursor();
unset($Remise);
}
//////////////////////////////////////////////REMISE 

if(empty($Remise)){
$Remise = "0";
}

$montant_total_ht_net = round($montant_total_ht-$Remise, 2);

$Tva_coeff = (1+$Tva_coef);
$montant_total_ttc = ($montant_total_ht_net*$Tva_coeff);
$montant_total_ttc = round($montant_total_ttc, 2);

$mont_total_tva = ($montant_total_ttc-$montant_total_ht_net);

///////////////////////////////////////////////////////////UPDATE FACTURE
///////////////////////////////UPDATE
$sql_update = $bdd->prepare("UPDATE membres_prestataire_facture SET 
	Tarif_HT=?,
	Tarif_HT_net=?,
	Tarif_TTC=?,
	Total_Tva=?,
	taux_tva=?
	WHERE id=?");
$sql_update->execute(array(
	$montant_total_ht,
	$montant_total_ht_net,
	$montant_total_ttc,
	$mont_total_tva,
	$Tva_coef,
	$id_facture));                     
$sql_update->closeCursor();

///////////////////////////////////////////////////////////UPDATE FACTURE

?>

<div style='float: right; width: 215px; margin-top: 5px;'>
<div style='text-align: center; display: inline-block; width: 100px; background-color: <?php echo "$couleurbordure"; ?>; color: <?php echo "$couleurFOND"; ?>; padding: 2px;'> Montant H.T</div>
<div style='text-align: center;  display: inline-block; width: 100px; background-color: <?php echo "$couleurbordure"; ?>; color: <?php echo "$couleurFOND"; ?>; padding: 2px;'> <?php echo "$montant_total_ht"; ?>&euro; </div>
</div>
<div style='clear: both; margin-bottom: 3px;'></div>

<?php
///////////////////////////SI REMISE
if(!empty($Remise)){
?>
<div style='float: right; width: 215px;'>
<div style='text-align: center; display: inline-block; width: 100px; background-color: <?php echo "$couleurbordure"; ?>; color: <?php echo "$couleurFOND"; ?>; padding: 2px;'> Remise</div>
<div style='text-align: center;  display: inline-block; width: 100px; background-color: <?php echo "$couleurbordure"; ?>; color: <?php echo "$couleurFOND"; ?>; padding: 2px;'> <?php echo "-$Remise"; ?>&euro; 
<a href='javascript:maFonctionAjaxa2("SupprimerRemise","");'><span class='uk-icon-times' style='float:right; margin-top:4px; color: <?php echo "$couleurFOND"; ?>;'></span></a>
</div>
</div>
<div style='clear: both; margin-bottom: 3px;'></div>

<div style='float: right; width: 215px;'>
<div style='text-align: center; display: inline-block; width: 100px; background-color: <?php echo "$couleurbordure"; ?>; color: <?php echo "$couleurFOND"; ?>; padding: 2px;'> Total H.T net </div>
<div style='text-align: center;  display: inline-block; width: 100px; background-color: <?php echo "$couleurbordure"; ?>; color: <?php echo "$couleurFOND"; ?>; padding: 2px;'> <?php echo "$montant_total_ht_net"; ?>&euro; </div>
</div>
<div style='clear: both; margin-bottom: 3px;'></div>
<?php
}
///////////////////////////SI REMISE
?>
<div style='float: right; width: 215px;'>
<div style='text-align: center;  display: inline-block; width: 100px; background-color: <?php echo "$couleurbordure"; ?>; color: <?php echo "$couleurFOND"; ?>; padding: 2px;'> Montant TVA</div>
<div style='text-align: center; display: inline-block; width: 100px; background-color: <?php echo "$couleurbordure"; ?>; color: <?php echo "$couleurFOND"; ?>; padding: 2px;'> <?php echo "$mont_total_tva"; ?>&euro; </div>
</div>
<div style='clear: both; margin-bottom: 3px;'></div>

<div style='float: right; width: 215px;'>
<div style='text-align: center;  display: inline-block; width: 100px; background-color: <?php echo "$couleurbordure"; ?>; color: <?php echo "$couleurFOND"; ?>; padding: 2px;'> Montant TTC</div>
<div style='text-align: center; display: inline-block; width: 100px; background-color: <?php echo "$couleurbordure"; ?>; color: <?php echo "$couleurFOND"; ?>; padding: 2px;'> <?php echo "$montant_total_ttc"; ?>&euro; </div>
</div>
<div style='clear: both; margin-bottom: 3px;'></div>


</div>

	</body>
</html>

<?php
ob_end_flush();
?>
