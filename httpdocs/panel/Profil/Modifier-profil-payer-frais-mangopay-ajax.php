<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once ('../../Configurations_bdd.php');
require_once ('../../Configurations.php');
require_once ('../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction = "../../";
require_once ('../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');
require_once $_SERVER['DOCUMENT_ROOT'] . '/mangopay/mangopayClass.php';

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
 
if (!empty($_SESSION['4M8e7M5b1R2e8s']) && !empty($user))
{
    // Vérifier qu'il a tous les documents bien rempli a payer
    // Que ce qui est dans la base
    // Et qui n'est pas en validation_asked
    $sql_get = $bdd->prepare("SELECT * FROM 
        membres_profil_paiement
        WHERE pseudo=?");
    $sql_get->execute(array(
        $user
    ));
    $infosKYC = $sql_get->fetch(PDO::FETCH_ASSOC);
    $sql_get->closeCursor();

    // Vérification

    if($infosKYC)
    {
        if(!empty($infosKYC['type_KYC']))
        {
            //Pour le type de société
            switch ($infosKYC['type_KYC'])
            {
                case 'EI':
                    $LegalPersonType = "SOLETRADER";
                break;
                case 'Auto entrepreneur':
                    $LegalPersonType = "SOLETRADER";
                break;
                case 'SA':
                case 'SASU':
                case 'SAS':
                    $LegalPersonType = "BUSINESS";
                break;
                default:
                    $LegalPersonType = "BUSINESS";
                break;
            }
            if($LegalPersonType == 'SOLETRADER')
            {
                if(!empty($infosKYC['registration_id']) && !empty($infosKYC['kyc_id']))
                {
                    // On récupère les documents sur MangoPay et on vérifie qu'ils sont bien en CREATED
                    $registration = json_decode(mangopay_viewKycDocument($api, [
                        'UserId' => $infosKYC['bank_id'],
                        'KycDocumentId' => $infosKYC['registration_id']
                    ]));

                    if($registration->Status != "CREATED")
                    {
                        $result2 = array(
                            "Texte_rapport" => "Vous devez envoyé un document de preuve d'identification de votre société.",
                            "retour_validation" => "",
                            "retour_lien" => ""
                        );

                        $result2 = json_encode($result2);
                        echo $result2;
                        return;
                    }

                    $identity = json_decode(mangopay_viewKycDocument($api, [
                        'UserId' => $infosKYC['bank_id'],
                        'KycDocumentId' => $infosKYC['kyc_id']
                    ]));

                    if($identity->Status != "CREATED")
                    {
                        $result2 = array(
                            "Texte_rapport" => "Vous devez envoyé un document de peuve d'idendité",
                            "retour_validation" => "",
                            "retour_lien" => ""
                        );

                        $result2 = json_encode($result2);
                        echo $result2;
                        return;
                    }
                }
                else
                {
                    $result2 = array(
                        "Texte_rapport" => "Vous devez au moins envoyé un document de preuve d'identité et un document de preuve d'identification de votre société",
                        "retour_validation" => "",
                        "retour_lien" => ""
                    );

                    $result2 = json_encode($result2);
                    echo $result2;
                    return;
                }
            }
            else
            {
                if(!empty($infosKYC['registration_id']) && !empty($infosKYC['kyc_id']) && !empty($infosKYC['ubo_id']) && !empty($infosKYC['articleofasso_id']))
                {
                    // On récupère les documents sur MangoPay et on vérifie qu'ils sont bien en CREATED
                    $registration = json_decode(mangopay_viewKycDocument($api, [
                        'UserId' => $infosKYC['bank_id'],
                        'KycDocumentId' => $infosKYC['registration_id']
                    ]));

                    if($registration->Status != "CREATED")
                    {
                        $result2 = array(
                            "Texte_rapport" => "Vous devez envoyé un document de preuve d'identification de votre société.",
                            "retour_validation" => "",
                            "retour_lien" => ""
                        );

                        $result2 = json_encode($result2);
                        echo $result2;
                        return;
                    }

                    $identity = json_decode(mangopay_viewKycDocument($api, [
                        'UserId' => $infosKYC['bank_id'],
                        'KycDocumentId' => $infosKYC['kyc_id']
                    ]));

                    if($identity->Status != "CREATED")
                    {
                        $result2 = array(
                            "Texte_rapport" => "Vous devez envoyé un document de peuve d'idendité",
                            "retour_validation" => "",
                            "retour_lien" => ""
                        );

                        $result2 = json_encode($result2);
                        echo $result2;
                        return;
                    }

                    $asso = json_decode(mangopay_viewKycDocument($api, [
                        'UserId' => $infosKYC['bank_id'],
                        'KycDocumentId' => $infosKYC['articleofasso_id']
                    ]));

                    if($asso->Status != "CREATED")
                    {
                        $result2 = array(
                            "Texte_rapport" => "Vous n\'avez transmis aucune preuve d\'identification de votre société",
                            "retour_validation" => "",
                            "retour_lien" => ""
                        );

                        $result2 = json_encode($result2);
                        echo $result2;
                        return;
                    }

                    $ubo = mangoPay_getUboFromUser($api, [
                        'UserId' => $infosKYC['bank_id'],
                        'UboDeclarationId' => $infosKYC['ubo_id']
                    ]);

                    if($ubo->Status != "CREATED")
                    {
                        $result2 = array(
                            "Texte_rapport" => "Vous devez transmettre un UBO",
                            "retour_validation" => "",
                            "retour_lien" => ""
                        );

                        $result2 = json_encode($result2);
                        echo $result2;
                        return;
                    }
                    else
                    {
                        if(count((array)$ubo->Ubos)==0)
                        {
                            $result2 = array(
                                "Texte_rapport" => "Vous devez transmettre un UBO",
                                "retour_validation" => "",
                                "retour_lien" => ""
                            );

                            $result2 = json_encode($result2);
                            echo $result2;
                            return;
                        }
                    }
                }
                else
                {
                    $result2 = array(
                        "Texte_rapport" => "Vous devez remplir tous les documents",
                        "retour_validation" => "",
                        "retour_lien" => ""
                    );

                    $result2 = json_encode($result2);
                    echo $result2;
                    return;
                }
            }
        }
        else
        {
            $result2 = array(
                "Texte_rapport" => "Vos informations ne sont pas correctes",
                "retour_validation" => "",
                "retour_lien" => ""
            );

            $result2 = json_encode($result2);
            echo $result2;
            return;
        }
    }
    // Si le user n'a pas de profil de paiements
    else
    {
        $result2 = array(
            "Texte_rapport" => "Vous n'avez pas rempli vos informations de paiements",
            "retour_validation" => "",
            "retour_lien" => ""
        );

        $result2 = json_encode($result2);
        echo $result2;
        return;
    }

    $sql = $bdd->query("SELECT promo_for_all FROM configurations_preferences_generales");
    $general_preference = $sql->fetch(PDO::FETCH_ASSOC);
    $sql->closeCursor();

    // Si on ne leur fait pas payer les frais
    if(!$general_preference['promo_for_all'])
    {

        $req_select = $bdd->prepare("SELECT * FROM membres_profil_paiement WHERE pseudo=? ");
        $req_select->execute(array(
            $user
        ));
        $kyc = $req_select->fetch(PDO::FETCH_ASSOC);
        $req_select->closeCursor();

        // On submit les KYC
        if($kyc)
        {
            if(!empty($kyc['type_KYC']))
            {
                //Pour le type de société
                switch ($kyc['type_KYC'])
                {
                    case 'EI':
                        $LegalPersonType = "SOLETRADER";
                    break;
                    case 'Auto entrepreneur':
                        $LegalPersonType = "SOLETRADER";
                    break;
                    case 'SA':
                    case 'SASU':
                    case 'SAS':
                        $LegalPersonType = "BUSINESS";
                    break;
                    default:
                        $LegalPersonType = "BUSINESS";
                    break;
                }
                if($LegalPersonType == 'SOLETRADER')
                {
                    mangoPay_submitKycDocument($api, [
                        'KycUserId' => $kyc['bank_id'], 
                        'KycDocumentId' => $kyc['kyc_id'], 
                        'Tag' => '', 
                        'Status' => "VALIDATION_ASKED"
                    ]);
                    mangoPay_submitKycDocument($api, [
                        'KycUserId' => $kyc['bank_id'], 
                        'KycDocumentId' => $kyc['registration_id'], 
                        'Tag' => '', 
                        'Status' => "VALIDATION_ASKED"
                    ]);
                    
                        // SUBMIT
                }
                else
                {
                    mangoPay_submitKycDocument($api, [
                        'KycUserId' => $kyc['bank_id'], 
                        'KycDocumentId' => $kyc['registration_id'], 
                        'Tag' => '', 
                        'Status' => "VALIDATION_ASKED"
                    ]);
                    mangoPay_submitKycDocument($api, [
                        'KycUserId' => $kyc['bank_id'], 
                        'KycDocumentId' => $kyc['kyc_id'], 
                        'Tag' => '', 
                        'Status' => "VALIDATION_ASKED"
                    ]);
                    mangoPay_submitUbo($api, [
                        'UserId' => $kyc['bank_id'],
                        'UboDeclarationId' => $kyc['ubo_id']
                    ]);
                    mangoPay_submitKycDocument($api, [
                        'KycUserId' => $kyc['bank_id'], 
                        'KycDocumentId' => $kyc['articleofasso_id'], 
                        'Tag' => '', 
                        'Status' => "VALIDATION_ASKED"
                    ]);
                    
                        
                }
            }
            else
            {
                $result2 = array(
                    "Texte_rapport" => "Vos informations ne sont pas correctes",
                    "retour_validation" => "",
                    "retour_lien" => ""
                );

                $result2 = json_encode($result2);
                echo $result2;
                return;
            }
        }


        $result2 = array(
            "Texte_rapport" => "La validation a été demandé à MangoPay",
            "retour_validation" => "ok",
            "retour_lien" => "https://123vitrine.fr/Modifier-profil.html"
        );

        $result2 = json_encode($result2);
        echo $result2;
        return;
    }

    // On vérifie s'il n'a pas plusieurs KYC dans son panier (ou quoi que se soit d'autre, il n'est pas censer avoir de panier de base)
    $sql_get = $bdd->prepare("SELECT count(*) as 'Total' FROM 
        membres_panier_details
        WHERE pseudo=?");
    $sql_get->execute(array(
        $user
    ));
    $total = $sql_get->fetch(PDO::FETCH_ASSOC);
    $sql_get->closeCursor();

    if($total['Total'] != 0)
    {
        $result2 = array(
            "Texte_rapport" => "Vous avez déjà des frais KYC à valider ",
            "retour_validation" => "ok",
            "retour_lien" => "https://123vitrine.fr/Paiement"
        );

        $result2 = json_encode($result2);
        echo $result2;
        return;
    }

    $libelle_details_article = "Païement des frais de validation des documents KYC MangoPay.";
    $libelle_prix_article = 3;
    $action_parametres_valeurs_explode = "";
	$pseudo_membres_profil = "123vitrine";
	$libelle_id_article = "";
    $pseudo_panier = "$user";
    $libelle_quantite_article = "1";
    $action_module_apres_paiement = "KYC";
    $type_panier = '';
    ajout_panier($libelle_details_article, $libelle_quantite_article, $libelle_prix_article, $action_module_apres_paiement, $action_parametres_valeurs_explode, $libelle_id_article, $pseudo_panier, $type_panier, '', $pseudo_membres_profil);

	$result2 = array(
        "Texte_rapport" => "Vous allez être rediriger vers le panier ",
        "retour_validation" => "ok",
        "retour_lien" => "https://123vitrine.fr/Paiement"
    );

	$result2 = json_encode($result2);
    echo $result2;
}
else
{
    header('location: /index.html');
}

ob_end_flush();