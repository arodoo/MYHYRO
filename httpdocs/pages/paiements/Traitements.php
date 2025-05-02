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

if(isset($user)){

    $nowtime = date('d-m-Y');
    require 'Api-Paypal/paypal.php';
    $paypal = new Paypal();

    $response = $paypal->request('GetExpressCheckoutDetails', array('TOKEN' => $_GET['token']));

    if ($response){
        ///////////////////////////////////////////PAIEMENT DEJA VALIDE
        if ($response['CHECKOUTSTATUS'] == 'PaymentActionCompleted'){
            ?>
		<div class="alert alert-danger" style="text-align: left; margin-top: 20px; margin-bottom: 20px;" >
			<span class="uk-icon-warning" ></span> 
			Ce montant est déjà validé ! Si vous avez rencontré un problème, contactez nous : <a href="/Contact">Contacter le service client</a>
		</div>

            <?php            
        }
    }else{
        //var_dump($paypal->errors);        
        ?>
		<div class="alert alert-danger" style="text-align: left; margin-top: 20px; margin-bottom: 20px;" >
			<span class="uk-icon-warning" ></span> 
			Il y a eu un problème, contactez nous : <a href="/Contact">Contacter le service client</a>
		</div>

        <?php      
    }

    $params = array(
        'TOKEN' => $_GET['token'],
        'PAYERID' => $_GET['PayerID'],
        'PAYMENTACTION' => 'Sale',
        'PAYMENTREQUEST_0_AMT' => $_SESSION['total_TTC_paypal'] + $_SESSION['port'],
        'PAYMENTREQUEST_0_CURRENCYCODE' => 'EUR',
        'PAYMENTREQUEST_0_SHIPPINGAMT' => $_SESSION['port'],
        'PAYMENTREQUEST_0_ITEMAMT' => $_SESSION['total_TTC_paypal'],
    );

    $response = $paypal->request('DoExpressCheckoutPayment', $params);

    /////////////////////////////////PAIEMENT EFFECTUE AVEC SUCCES
    if ($response){

        $response['PAYMENTINFO_0_TRANSACTIONID'];
        //////////////ATTRIBUTION SERVICE OU ACTIONS METIER
        if ($_SESSION['total_TTC_paypal'] == $response["PAYMENTINFO_0_AMT"]){
            $modepaiements = "Paypal";
            include('Traitements-actions.php');
        /////////////////////////////////Montant correspond pas
        }else{                    
            ?>
		<div class="alert alert-danger" style="text-align: left; margin-top: 20px; margin-bottom: 20px;" >
			<span class="uk-icon-warning" ></span> 
			Le montant correspond pas : <a href="/Contact">Contacter le service client</a>
		</div>
             <?php 
        }

    /////////////////////////////////PAIEMENT Refusé
    }else{
        mail('contact@codi-one.fr', 'Test paypal errors', 'paypal : '.json_encode($paypal->errors).'<br/> response : '.json_encode($response));               
       ?>
		<div class="alert alert-danger" style="text-align: left; margin-top: 20px; margin-bottom: 20px;" >
			<span class="uk-icon-warning" ></span> 
			Il y a eu un problème : <a href="/Contact">Contacter le service client</a>
		</div>
       <?php               
    }

}else{
    header("location: /");
}

?>