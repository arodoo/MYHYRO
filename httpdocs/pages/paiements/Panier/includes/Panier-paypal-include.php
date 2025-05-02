<?php
$_SESSION['port'] = 0.0;
$paypal = "#";
$paypal = new Paypal();
/////////////////////////////POUR PLUS DE DETAILS https://developer.paypal.com/docs/classic/api/merchant/GetExpressCheckoutDetails_API_Operation_NVP/
$params = array(
	'SOLUTIONTYPE' => "Sole",
	'LANDINGPAGE' => "Billing",
	'LOGOIMG' => "" . $http . "$nomsiteweb/images/Logo/logo-dark.png",
	'INVNUM' => "$numero_panier" . time() . "",
	'BRANDNAME' => "$nom_proprietaire",
	'PHONENUM' => "" . $Telephone_portable_oo . "",
	'FIRSTNAME' => "" . $prenom_oo . "",
	'MIDDLENAME' => "" . $prenom_oo . "",
	'LASTNAME' => "" . $nom_oo . "",
	'PAYER_EMAIL' => "" . $mail_oo . "",
	'H_PHONENUMBER' => "" . $Telephone_portable_oo . "",
	'EMAIL' => "" . $mail_oo . "",
	'PAYMENTREQUEST_0_PAYMENTACTION' => "Sale",
	'PAYMENTREQUEST_0_SHIPTOSTREET' => "" . $adresse_oo . "",
	'PAYMENTREQUEST_0_SHIPTOCITY' => "" . $ville_oo . "",
	'PAYMENTREQUEST_0_SHIPTOZIP' => "" . $cp_oo . "",
	'PAYMENTREQUEST_0_SHIPTOPHONENUMP' => "" . $Telephone_portable_oo . "",
	'RETURNURL' => "" . $http . "$nomsiteweb/index.php?page=Traitements",
	'CANCELURL' => "" . $http . "$nomsiteweb",
	'PAYMENTREQUEST_0_CURRENCYCODE' => 'EUR',
	'PAYMENTREQUEST_0_SHIPPINGAMT' => $_SESSION['port'],
	//PAYMENTREQUEST_n_ITEMAMT
);

$k = 0;
$PU_TTC_totald_panierd = 0;
//////////////////////////////////////////////////////PRODUITS SERVICES
///////////////////////////////SELECT BOUCLE
$req_boucle = $bdd->prepare("SELECT * FROM membres_panier_details WHERE id_membre=? ORDER BY id ASC");
$req_boucle->execute(array($id_oo));
while ($ligne_boucle = $req_boucle->fetch()) {
	$id_facture_panier_dd = $ligne_boucle['id'];
	$id_panier_facture_details_idd = $ligne_boucle['id'];
	$libelled = utf8_encode($ligne_boucle['libelle']);
	//SI TABLE PANIER
	$id_panier_SERVICE_PRODUIT_idd = $ligne_boucle['id_panier_SERVICE_PRODUIT'];
	$PU_HTd = $ligne_boucle['PU_HT'];
	$quantited = $ligne_boucle['quantite'];
	$PU_HT_totald = (($PU_HTd) + $PU_HT_total);
	$Tva_coef = $ligne_boucle['TVA_TAUX'];
	$PU_TTC_totald = sprintf('%.2f', ($PU_HT_totald * $Tva_coef));

	$PU_TTC_totald_panierd = ($PU_TTC_totald_panierd + $PU_TTC_totald);
	$PU_TTC_totald_panierd = sprintf('%.2f', ($PU_TTC_totald_panierd));

	$k++;
}
$req_boucle->closeCursor();
//////////////////////////////////////////////////////PRODUITS SERVICES
$req_select = $bdd->prepare('SELECT * FROM configurations_abonnements WHERE id=?');
$req_select->execute(array($Abonnement_id));
$abonnement = $req_select->fetch();
$req_select->closeCursor();
$params["L_PAYMENTREQUEST_0_NAME$k"] = "test";
$params["L_PAYMENTREQUEST_0_DESC$k"] = "test";
$params["L_PAYMENTREQUEST_0_AMT$k"] = 1;
$params["L_PAYMENTREQUEST_0_QTY$k"] = 1;

// var_dump($params, $PU_TTC_totald_panierd);

$params['PAYMENTREQUEST_0_AMT'] = 1;

// if($abonnement['Frais_de_gestion_d_une_commande'] != "Gratuit"){
// 	$params["L_PAYMENTREQUEST_0_NAME$k"] = "Frais de gestion";
// 	$params["L_PAYMENTREQUEST_0_DESC$k"] = "Frais de gestion";
// 	$params["L_PAYMENTREQUEST_0_AMT$k"] = $abonnement["Frais_de_gestion_d_une_commande"];
// 	$params["L_PAYMENTREQUEST_0_QTY$k"] = 1;
// 	$k++;
// }

// if($abonnement['Frais_de_passage_d_une_commande'] != "Gratuit"){
// 	$params["L_PAYMENTREQUEST_0_NAME$k"] = "Frais de passage";
// 	$params["L_PAYMENTREQUEST_0_DESC$k"] = "Frais de passage";
// 	$params["L_PAYMENTREQUEST_0_AMT$k"] = $abonnement["Frais_de_passage_d_une_commande"];
// 	$params["L_PAYMENTREQUEST_0_QTY$k"] = 1;
// 	$k++;
// }

// $params["L_PAYMENTREQUEST_0_NAME$k"] = "Frais d'expédition";
// $params["L_PAYMENTREQUEST_0_DESC$k"] = "Frais d'expédition";
// $params["L_PAYMENTREQUEST_0_AMT$k"] = $_SESSION['total_expedition'];
// $params["L_PAYMENTREQUEST_0_QTY$k"] = 1;
// $k++;

$response = $paypal->request('SetExpressCheckout', $params);


if ($response) {
	//$paypal = 'https://www.paypal.com/webscr?cmd=_express-checkout&useraction=commit&token=' . $response['TOKEN'];
	$paypal = 'https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&useraction=commit&token=' . $response['TOKEN'];
} else {
	var_dump($paypal);
	$erreur_paypal = "oui";
}

if (empty($erreur_paypal)) {
?>

	<div style='text-align: center; margin-top: 20px;'>
		<a href='<?php echo "$paypal"; ?>' class="btn btn-default" style=' margin-top: 15px; text-decoration: none;'>
			Payer ma commande
		</a>
	</div>

<?php
}
?>