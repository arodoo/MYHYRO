<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once ('../../Configurations_bdd.php');
require_once ('../../Configurations.php');
require_once ('../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction = "../../";

require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/cmpayments/iban/src/lib/IBAN.php';
require_once ('../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

//API MAngoPay
require_once $_SERVER['DOCUMENT_ROOT'] . '/mangopay/mangopayClass.php';
// require_once $_SERVER['DOCUMENT_ROOT'] . '/function/verif_upload_file.php';

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
	
    $type_KYC = $_POST['type_KYC'];

    $iban = $_POST['iban'];

    // $iban_strlen = strlen($iban);
    // $iban_fr = substr($iban, 0, 2);
    // $iban_alphanum = ctype_alnum($iban);
    // $iban_last_chaine = substr($iban, 2, $iban_strlen);
    // $iban_last_chaine_numeric = is_numeric($iban_last_chaine);

    // //VERIFICATION TYPOLOGIE IBAN
    // if ($iban_strlen == 27 && ($iban_fr == "fr" || $iban_fr == "FR" || $iban_fr == "Fr" || $iban_fr == "fR") && $iban_alphanum == 1 && $iban_last_chaine_numeric == 1)
    // {
    //     $iban_ok = "ok";

    // }

    $liban = new CMPayments\IBAN($iban);

    if ( $liban->validate($error) ) {
        $iban_ok = "ok";
    }

    if (!empty($type_KYC))
    {
        if (!empty($iban) && $iban_ok == "ok")
        {

            /**** Version Maxime ***/
            /* Aucune vérification n'est mise en place */

            //Il faut récupérer les infos du membre pour les infos mangopay
            $sql = $bdd->prepare("SELECT * FROM membres 
        		LEFT JOIN membres_professionnel ON (membres_professionnel.id_membre = membres.id) 
        		LEFT JOIN membres_profil_paiement ON (membres_profil_paiement.id_membre = membres.id) 
        		WHERE membres.id = ?");
            $sql->execute(array(
                $id_user
            ));
            $leMembre = $sql->fetch(PDO::FETCH_ASSOC);
            $sql->closeCursor();

            if(!empty($leMembre['kyc_id']))
            {
                $datas_for_mangopay = ['UserId' => $leMembre['bank_id'], 'KycDocumentId' => $leMembre['kyc_id']];
                //var_dump($datas_for_mangopay);
                $infosKyc = json_decode(mangopay_viewKycDocument($api, $datas_for_mangopay));

                if($infosKyc->Status == 'VALIDATION_ASKED')
                {
                    $result2 = array(
                        "Texte_rapport" => "Il y a déjà une demande de validation à MangoPay",
                        "retour_validation" => "",
                        "retour_lien" => ""
                    );
                    echo json_encode($result2);
                }
            }

            if(!empty($leMembre['registration_id']))
            {
                $datas_for_mangopay = ['UserId' => $leMembre['bank_id'], 'KycDocumentId' => $leMembre['registration_id']];
                //var_dump($datas_for_mangopay);
                $infosKyc = json_decode(mangopay_viewKycDocument($api, $datas_for_mangopay));

                if($infosKyc->Status == 'VALIDATION_ASKED')
                {
                    $result2 = array(
                        "Texte_rapport" => "Il y a déjà une demande de validation à MangoPay",
                        "retour_validation" => "",
                        "retour_lien" => ""
                    );
                    echo json_encode ($result2);
                }
            }

            if(!empty($leMembre['articleofasso_id']))
            {
                $datas_for_mangopay = ['UserId' => $leMembre['bank_id'], 'KycDocumentId' => $leMembre['articleofasso_id']];
                //var_dump($datas_for_mangopay);
                $infosKyc = json_decode(mangopay_viewKycDocument($api, $datas_for_mangopay));

                if($infosKyc->Status == 'VALIDATION_ASKED')
                {
                    $result2 = array(
                        "Texte_rapport" => "Il y a déjà une demande de validation à MangoPay",
                        "retour_validation" => "",
                        "retour_lien" => ""
                    );
                    echo json_encode($result2);
                }
            }

            if(!empty($leMembre['ubo_id']))
            {
                //var_dump($datas_for_mangopay);
                $infosKyc = mangoPay_getUboFromUser($api, [
                    'UserId' => $leMembre['bank_id'],
                    'UboDeclarationId' => $leMembre['ubo_id']
                ]);

                if($infosKyc->Status == 'VALIDATION_ASKED')
                {
                    $result2 = array(
                        "Texte_rapport" => "Il y a déjà une demande de validation à MangoPay",
                        "retour_validation" => "",
                        "retour_lien" => ""
                    );
                    echo $result2 = json_encode($result2);
                    return;
                }
            }
            
            /////////////////////////////////////////////////////////////////////////////////////
            //1ere étape, on créé une ligne dans la table, si celle-ci n'existe pas
            $sql = $bdd->prepare("SELECT * FROM membres_profil_paiement WHERE id_membre=?");
            $sql->execute(array(
                $id_user
            ));
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            if (!$row)
            {
                //On créé la ligne
                $sql = $bdd->prepare("INSERT INTO membres_profil_paiement (id_membre, pseudo, type_KYC) VALUES (:id_membre, :pseudo, :type_KYC)");
                $sql->bindParam(':id_membre', $id_user);
                $sql->bindParam(':pseudo', $user);
                $sql->bindParam(':type_KYC', $_POST['type_KYC']);
                $sql->execute();
                $mpp_id = $bdd->lastInsertId();
            }
            else
            {
                $mpp_id = $row['id'];
                //Pour le type de société
                if($_POST['type_KYC'] != $leMembre['type_KYC'])
                {
                    switch ($_POST['type_KYC'])
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

                    $datas_for_mangopay = [
                        'HeadquartersAddress_AddressLine1'          => $leMembre['adresse'], 
                        'HeadquartersAddress_AddressLine2'          => "", 
                        'HeadquartersAddress_City'                  => $leMembre['ville'], 
                        'HeadquartersAddress_Region'                => "", 
                        'HeadquartersAddress_PostalCode'            => $leMembre['cp'], 
                        'HeadquartersAddress_Country'               => "FR", //Aucune info dans la base, donc en dur
                        'LegalPersonType'                           => $LegalPersonType, 
                        'Name'                                      => $leMembre['Nom_societe'], 
                        'LegalRepresentativeAddress_AddressLine1'   => $leMembre['adresse'], 
                        'LegalRepresentativeAddress_AddressLine2'   => "", 
                        'LegalRepresentativeAddress_City'           => $leMembre['ville'], 
                        'LegalRepresentativeAddress_Region'         => "", 
                        'LegalRepresentativeAddress_PostalCode'     => $leMembre['cp'], 
                        'LegalRepresentativeAddress_Country'        => "FR", //Aucune info dans la base, donc en dur
                        'LegalRepresentativeBirthday'               => 259259059, //Pour les tests => Il faudra récupérer la valeur de la table $leMembre['datenaissance']
                        'LegalRepresentativeCountryOfResidence'     => "FR", //Aucune info dans la base, donc en dur
                        'LegalRepresentativeNationality'            => "FR", //Aucune info dans la base, donc en dur
                        'LegalRepresentativeEmail'                  => $leMembre['mail'], 
                        'LegalRepresentativeFirstName'              => $leMembre['prenom'], 
                        'LegalRepresentativeLastName'               => $leMembre['nom'], 
                        'Email'                                     => $leMembre['mail'], 
                        'CompanyNumber'                             => $leMembre['Numero_identification'],
                        'UserId'                                    => $leMembre['bank_id']
                    ];
                    
                    $updateMangopay = json_decode(mangoPay_updateLegalUser($api, $datas_for_mangopay));
                    
                    if(isset($updateMangopay->Errors))
                    {
                        $result2 = array(
                            "Texte_rapport" => $updateMangopay->Message,
                            "retour_validation" => "",
                            "retour_lien" => ""
                        );
                        echo $result2 = json_encode($result2);
                        return;
                    }
                    //On la met à jour si elle existe
                    $sql = $bdd->prepare("UPDATE membres_profil_paiement SET type_KYC=? WHERE id=?");
                    $sql->execute([$_POST['type_KYC'], $mpp_id]);
                    $sql->closeCursor();
                }
            }
            $sql->closeCursor();

            //Pour le type de société
            switch ($_POST['type_KYC'])
            {
                case 'EI':
                case 'Auto entrepreneur':
                    $LegalPersonType = "SOLETRADER";
                    break;
                case 'SNC':
                case 'EURL':
                case 'SA':
                case 'SASU':
                case 'SAS':
                case 'SARL':
                    $LegalPersonType = "BUSINESS";
                    break;
                default:
                    $LegalPersonType = "BUSINESS";
                    break;
            }

            /////////////////////////////////////////////////////////////////////////////////////
            //1 - Création du User dans MangoPay
            $datas_for_mangopay_user = [
                'HeadquartersAddress_AddressLine1'          => $leMembre['adresse'], 
                'HeadquartersAddress_AddressLine2'          => "", 
                'HeadquartersAddress_City'                  => $leMembre['ville'], 
                'HeadquartersAddress_Region'                => "", 
                'HeadquartersAddress_PostalCode'            => $leMembre['cp'], 
                'HeadquartersAddress_Country'               => "FR", //Aucune info dans la base, donc en dur
                'LegalPersonType'                           => $LegalPersonType, 
                'Name'                                      => $leMembre['Nom_societe'], 
                'LegalRepresentativeAddress_AddressLine1'   => $leMembre['adresse'], 
                'LegalRepresentativeAddress_AddressLine2'   => "", 
                'LegalRepresentativeAddress_City'           => $leMembre['ville'], 
                'LegalRepresentativeAddress_Region'         => "", 
                'LegalRepresentativeAddress_PostalCode'     => $leMembre['cp'], 
                'LegalRepresentativeAddress_Country'        => "FR", //Aucune info dans la base, donc en dur
                'LegalRepresentativeBirthday'               => 259259059, //Pour les tests => Il faudra récupérer la valeur de la table $leMembre['datenaissance']
                'LegalRepresentativeCountryOfResidence'     => "FR", //Aucune info dans la base, donc en dur
                'LegalRepresentativeNationality'            => "FR", //Aucune info dans la base, donc en dur
                'LegalRepresentativeEmail'                  => $leMembre['mail'], 
                'LegalRepresentativeFirstName'              => $leMembre['prenom'], 
                'LegalRepresentativeLastName'               => $leMembre['nom'], 
                'Email'                                     => $leMembre['mail'], 
                'CompanyNumber'                             => $leMembre['Numero_identification'] 
            ];

            $monRes['bank_id'] = $leMembre['bank_id'];

            if (empty($leMembre['bank_id']) || $leMembre['bank_id'] === null)
            {
                var_dump($datas_for_mangopay_user);
                die();
                $creaUser = json_decode(mangoPay_createLegalUser($api, $datas_for_mangopay_user));
                if (isset($creaUser->Id) && !empty($creaUser->Id))
                {
                    //on update la ligne
                    $sql = $bdd->prepare("UPDATE membres_profil_paiement SET bank_id=? WHERE id=?");
                    $sql->execute([$creaUser->Id, $mpp_id]);
                    $sql->closeCursor();
                    $monRes['bank_id'] = $creaUser->Id;
                }
                else
                {
                    $result2 = array(
                        "Texte_rapport" => "La création du compte chez MangoPay a echouée ! ",
                        "retour_validation" => "",
                        "retour_lien" => ""
                    );
                    echo $result2 = json_encode($result2);
                    return;
                }
            }

            /////////////////////////////////////////////////////////////////////////////////////
            //2 - Création du WALLET dans MangoPay
            if (empty($leMembre['wallet_id']) || $leMembre['wallet_id'] === null)
            {
                $datas_for_mangopay_wallet = ['Owners' => array(
                    $monRes['bank_id']
                ) , 'Description' => "Wallet " . $leMembre['Nom_societe'], 'Currency' => "EUR", 'Tag' => "Wallet", ];
                $creaWallet = json_decode(mangoPay_createWallet($api, $datas_for_mangopay_wallet));
                if (isset($creaWallet->Id) && !empty($creaWallet->Id))
                {
                    //on update la ligne
                    $sql = $bdd->prepare("UPDATE membres_profil_paiement SET wallet_id=? WHERE id=?");
                    $sql->execute([$creaWallet->Id, $mpp_id]);
                    $sql->closeCursor();
                }
                else
                {
                    $result2 = array(
                        "Texte_rapport" => "La création du wallet chez MangoPay a echouée ! ",
                        "retour_validation" => "",
                        "retour_lien" => ""
                    );
                    echo $result2 = json_encode($result2);
                    return;
                }
            }

            /////////////////////////////////////////////////////////////////////////////////////
            /// IDENTITY_PROOF
            //3 - Envoi de la CNI
            if (isset($_FILES['cni']) && !empty($_FILES['cni']['name'][0]))
            {
                // echo '<pre>';
                // print_r($_FILES['cni']);
                // echo '</pre>';
                //On vérifie si chaque fichier n'est pas vide
                foreach ($_FILES['cni']['name'] as $fichier):
                    if (empty($fichier))
                    {
                        $result2 = array(
                            "Texte_rapport" => "Veuillez vérifier vos fichiers pour la preuve d'identité ",
                            "retour_validation" => "",
                            "retour_lien" => ""
                        );
                        echo $result2 = json_encode($result2);
                        return;
                    }
                endforeach;

                //Si tous les fichiers semblent cohérents, on les teste avant l'envoi à MangoPay pour validation
                //On doit donc reconstruire chaque tableau
                $mesFiles = [];
                foreach ($_FILES['cni']['tmp_name'] as $key => $tmp_name):
                    $monFile['name'] = $key . $_FILES['cni']['name'][$key];
                    $monFile['size'] = $_FILES['cni']['size'][$key];
                    $monFile['tmp_name'] = $_FILES['cni']['tmp_name'][$key];
                    $monFile['type'] = $_FILES['cni']['type'][$key];

                    array_push($mesFiles, $monFile);
                endforeach;

                //On envoi chaque fichier à la vérification
                //Si une erreur apparait le script est arrêté
                foreach ($mesFiles as $mf):
                    verifFile($mf);
                endforeach;

                //Si on est passé ici, c'est qu'on peut envoyer les fichiers à validation MANGOPAY
                //1 createKycDoc
                $datas_for_mangopay = ['UserId' => $monRes['bank_id'], 'Tag' => 'Identité ' . $leMembre['prenom'] . ' ' . $leMembre['nom'], 'Type' => 'IDENTITY_PROOF'];
                $creaKycDoc = json_decode(mangoPay_createKycDocument($api, $datas_for_mangopay));
                if (isset($creaKycDoc->Id) && !empty($creaKycDoc->Id))
                {
                    //on update la ligne
                    $sql = $bdd->prepare("UPDATE membres_profil_paiement SET kyc_id=? WHERE id=?");
                    $sql->execute([$creaKycDoc->Id, $mpp_id]);
                    $sql->closeCursor();

                    //2 createKycPage
                    //On doit convertir les fichiers en base64
                    foreach ($mesFiles as $monFichier):

                        $temp_file = file_get_contents($monFichier['tmp_name']);
                        $data = base64_encode($temp_file);

                        //$data = $temp_file; //Pas besoin d'encoder avec le SDK
                        $datas_for_mangopay = ['UserId' => $monRes['bank_id'], 'KycDocumentId' => $creaKycDoc->Id, 'File' => urlencode($data) ];
                        $creaPage = json_decode(mangoPay_createKycPage($api, $datas_for_mangopay));

                        if ($creaPage != true)
                        {
                            $result2 = array(
                                "Texte_rapport" => "Une erreur est intervenue pendant le transfert de vos documents à la banque, veuillez essayer ulterieurement",
                                "retour_validation" => "",
                                "retour_lien" => ""
                            );
                            echo $result2 = json_encode($result2);
                            return;
                        }
                    endforeach;

                    //3 submitKycDocument
                    $datas_for_mangopay = ['KycUserId' => $monRes['bank_id'], 'KycDocumentId' => $creaKycDoc->Id, 'Tag' => 'Identité ' . $leMembre['prenom'] . ' ' . $leMembre['nom'], 'Status' => "CREATED"];
                    $submitKycDoc = json_decode(mangoPay_submitKycDocument($api, $datas_for_mangopay));

                }
                else
                {
                    $result2 = array(
                        "Texte_rapport" => "Une erreur est intervenue pendant le transfert de vos documents à la banque, veuillez essayer ulterieurement",
                        "retour_validation" => "",
                        "retour_lien" => ""
                    );
                    echo $result2 = json_encode($result2);
                    return;

                }

            }
            ///// FIN CNI
            /////////////////////////////////////////////////////////////////////////////////////

            /// REGISTRATION_PROOF
            //3 - Envoi du KBIS
            if (isset($_FILES['kbis']) && $_FILES['kbis']['name'][0])
            {
                // echo '<pre>';
                // print_r($_FILES['kbis']);
                // echo '</pre>';
                //On vérifie si chaque fichier n'est pas vide
                foreach ($_FILES['kbis']['name'] as $fichier):
                    if (empty($fichier))
                    {
                        $result2 = array(
                            "Texte_rapport" => "Veuillez vérifier vos fichiers pour le KBis ",
                            "retour_validation" => "",
                            "retour_lien" => ""
                        );
                        echo $result2 = json_encode($result2);
                        return;
                    }
                endforeach;

                //Si tous les fichiers semblent cohérents, on les teste avant l'envoi à MangoPay pour validation
                //On doit donc reconstruire chaque tableau
                $mesFiles = [];
                foreach ($_FILES['kbis']['tmp_name'] as $key => $tmp_name):
                    $monFile['name'] = $key . $_FILES['kbis']['name'][$key];
                    $monFile['size'] = $_FILES['kbis']['size'][$key];
                    $monFile['tmp_name'] = $_FILES['kbis']['tmp_name'][$key];
                    $monFile['type'] = $_FILES['kbis']['type'][$key];

                    array_push($mesFiles, $monFile);
                endforeach;

                //On envoi chaque fichier à la vérification
                //Si une erreur apparait le script est arrêté
                foreach ($mesFiles as $mf):
                    verifFile($mf);
                endforeach;

                //Si on est passé ici, c'est qu'on peut envoyer les fichiers à validation MANGOPAY
                //1 createKycDoc
                $datas_for_mangopay = ['UserId' => $monRes['bank_id'], 'Tag' => 'Preuve société ' . $leMembre['prenom'] . ' ' . $leMembre['nom'], 'Type' => 'REGISTRATION_PROOF'];
                $creaKycDoc = json_decode(mangoPay_createKycDocument($api, $datas_for_mangopay));
                if (isset($creaKycDoc->Id) && !empty($creaKycDoc->Id))
                {
                    //on update la ligne
                    $sql = $bdd->prepare("UPDATE membres_profil_paiement SET registration_id=? WHERE id=?");
                    $sql->execute([$creaKycDoc->Id, $mpp_id]);
                    $sql->closeCursor();

                    //2 createKycPage
                    //On doit convertir les fichiers en base64
                    foreach ($mesFiles as $monFichier):

                        $temp_file = file_get_contents($monFichier['tmp_name']);
                        $data = base64_encode($temp_file);

                        //$data = $temp_file; //Pas besoin d'encoder avec le SDK
                        $datas_for_mangopay = ['UserId' => $monRes['bank_id'], 'KycDocumentId' => $creaKycDoc->Id, 'File' => urlencode($data) ];
                        $creaPage = json_decode(mangoPay_createKycPage($api, $datas_for_mangopay));

                        if ($creaPage != true)
                        {
                            $result2 = array(
                                "Texte_rapport" => "Une erreur est intervenue pendant le transfert de vos documents à la banque, veuillez essayer ulterieurement",
                                "retour_validation" => "",
                                "retour_lien" => ""
                            );
                            echo $result2 = json_encode($result2);
                            return;
                        }
                    endforeach;

                   /* //3 submitKycDocument
                    $datas_for_mangopay = ['KycUserId' => $monRes['bank_id'], 'KycDocumentId' => $creaKycDoc->Id, 'Tag' => 'Preuve société ' . $leMembre['prenom'] . ' ' . $leMembre['nom'], 'Status' => "VALIDATION_ASKED"];
                    $submitKycDoc = json_decode(mangoPay_submitKycDocument($api, $datas_for_mangopay));*/

                }
                else
                {
                    $result2 = array(
                        "Texte_rapport" => "Une erreur est intervenue pendant le transfert de vos documents à la banque, veuillez essayer ulterieurement",
                        "retour_validation" => "",
                        "retour_lien" => ""
                    );
                    echo $result2 = json_encode($result2);
                    return;

                }

            }
            ///// FIN KBIS
            /////////////////////////////////////////////////////////////////////////////////////

            // ARTICLE_OF_ASSOCIATION
            //3 - Envoi des STATUS SOCIETE
            if (isset($_FILES['Statut_a_jour_signe']) && $_FILES['Statut_a_jour_signe']['name'][0])
            {
                // echo '<pre>';
                // print_r($_FILES['Statut_a_jour_signe[]']);
                // echo '</pre>';
                //On vérifie si chaque fichier n'est pas vide
                foreach ($_FILES['Statut_a_jour_signe']['name'] as $fichier):
                    if (empty($fichier))
                    {
                        $result2 = array(
                            "Texte_rapport" => "Veuillez vérifier vos fichiers pour les statuts ",
                            "retour_validation" => "",
                            "retour_lien" => ""
                        );
                        echo $result2 = json_encode($result2);
                        return;
                    }
                endforeach;

                //Si tous les fichiers semblent cohérents, on les teste avant l'envoi à MangoPay pour validation
                //On doit donc reconstruire chaque tableau
                $mesFiles = [];
                foreach ($_FILES['Statut_a_jour_signe']['tmp_name'] as $key => $tmp_name):
                    $monFile['name'] = $key . $_FILES['Statut_a_jour_signe']['name'][$key];
                    $monFile['size'] = $_FILES['Statut_a_jour_signe']['size'][$key];
                    $monFile['tmp_name'] = $_FILES['Statut_a_jour_signe']['tmp_name'][$key];
                    $monFile['type'] = $_FILES['Statut_a_jour_signe']['type'][$key];

                    array_push($mesFiles, $monFile);
                endforeach;

                //On envoi chaque fichier à la vérification
                //Si une erreur apparait le script est arrêté
                foreach ($mesFiles as $mf):
                    verifFile($mf);
                endforeach;

                //Si on est passé ici, c'est qu'on peut envoyer les fichiers à validation MANGOPAY
                //1 createKycDoc
                $datas_for_mangopay = ['UserId' => $monRes['bank_id'], 'Tag' => 'Status association ' . $leMembre['prenom'] . ' ' . $leMembre['nom'], 'Type' => 'ARTICLES_OF_ASSOCIATION'];
                $creaKycDoc = json_decode(mangoPay_createKycDocument($api, $datas_for_mangopay));
                if (isset($creaKycDoc->Id) && !empty($creaKycDoc->Id))
                {
                    //on update la ligne
                    $sql = $bdd->prepare("UPDATE membres_profil_paiement SET articleofasso_id=? WHERE id=?");
                    $sql->execute([$creaKycDoc->Id, $mpp_id]);
                    $sql->closeCursor();

                    //2 createKycPage
                    //On doit convertir les fichiers en base64
                    foreach ($mesFiles as $monFichier):

                        $temp_file = file_get_contents($monFichier['tmp_name']);
                        $data = base64_encode($temp_file);

                        //$data = $temp_file; //Pas besoin d'encoder avec le SDK
                        $datas_for_mangopay = ['UserId' => $monRes['bank_id'], 'KycDocumentId' => $creaKycDoc->Id, 'File' => urlencode($data) ];
                        $creaPage = json_decode(mangoPay_createKycPage($api, $datas_for_mangopay));

                        if ($creaPage != true)
                        {
                            $result2 = array(
                                "Texte_rapport" => "Une erreur est intervenue pendant le transfert de vos documents à la banque, veuillez essayer ulterieurement",
                                "retour_validation" => "",
                                "retour_lien" => ""
                            );
                            echo $result2 = json_encode($result2);
                            return;
                        }
                    endforeach;

                    /*//3 submitKycDocument
                    $datas_for_mangopay = ['KycUserId' => $monRes['bank_id'], 'KycDocumentId' => $creaKycDoc->Id, 'Tag' => 'Statuts association ' . $leMembre['prenom'] . ' ' . $leMembre['nom'], 'Status' => "VALIDATION_ASKED"];
                    $submitKycDoc = json_decode(mangoPay_submitKycDocument($api, $datas_for_mangopay));*/

                }
                else
                {
                    $result2 = array(
                        "Texte_rapport" => "Une erreur est intervenue pendant le transfert de vos documents à la banque, veuillez essayer ulterieurement",
                        "retour_validation" => "",
                        "retour_lien" => ""
                    );
                    echo $result2 = json_encode($result2);
                    return;

                }

            }

            // Envoie du UBO
            if($LegalPersonType == "BUSINESS")
            {
                $sql = $bdd->prepare("SELECT * FROM membres 
                    LEFT JOIN membres_professionnel ON (membres_professionnel.id_membre = membres.id) 
                    LEFT JOIN membres_profil_paiement ON (membres_profil_paiement.id_membre = membres.id) 
                    WHERE membres.id = ?");
                $sql->execute(array(
                    $id_user
                ));
                $uboMembre = $sql->fetch(PDO::FETCH_ASSOC);
                $sql->closeCursor();
                // Vérifier que le post UBO existe
                if(!isset($_POST['ubo']) || empty($_POST['ubo']))
                {
                    $result2 = array(
                        "Texte_rapport" => '',
                        "retour_validation" => "",
                        "retour_lien" => ""
                    );
                    echo $result2 = json_encode($result2);
                    return;
                }

                // Si l'utilisateur n'a pas déjà un UBO existant
                if(empty($uboMembre['ubo_id']))
                {
                    // create UBODeclarations
                    $createUbo = mangoPay_createUBODeclarations($api, ['UserId' => $uboMembre['bank_id']]);

                    $sql = $bdd->prepare("UPDATE membres_profil_paiement SET ubo_id=? WHERE id=?");
                    $sql->execute([$createUbo->Id, $uboMembre['id']]);
                    $sql->closeCursor();
                    
                    $uboMembre['ubo_id'] = $createUbo->Id;

                }

                // S'il en a déjà un de validé, on lui donne la possibilité d'en créer un autre
                $uboFromMangopay = mangoPay_getUboFromUser($api, [
                    'UserId' => $uboMembre['bank_id'],
                    'UboDeclarationId' => $uboMembre['ubo_id']
                ]);

                if($uboFromMangopay->Status == 'VALIDATED')
                {
                    // create UBODeclarations
                    $createUbo = mangoPay_createUBODeclarations($api, ['UserId' => $uboMembre['bank_id']]);

                    $sql = $bdd->prepare("UPDATE membres_profil_paiement SET ubo_id=? WHERE id=?");
                    $sql->execute([$createUbo->Id, $uboMembre['id']]);
                    $sql->closeCursor();
                    
                    $uboMembre['ubo_id'] = $createUbo->Id;

                    $ubo = $_POST['ubo'];

                    // Maintenant on parcours tous les UBO envoyé
                    for($i=0;$i<4;$i++)
                    {
                        if(array_key_exists($i, $ubo))
                        {
                            $uboItem = $ubo[$i];
                            // On change la date en format TIMESTAMP
                            $birthday = date_create_from_format('Y-m-d', $uboItem['Birthday']['Year'].'-'.$uboItem['Birthday']['Month'].'-'.$uboItem['Birthday']['Day']);
                            $birthday->setTimezone(new \DateTimeZone('UTC'));
                            $uboItem['Birthday'] = date_timestamp_get($birthday);

                            $uboItem['UserId'] = $uboMembre['bank_id'];
                            $uboItem['UboDeclarationId'] = $uboMembre['ubo_id'];
                            $uboItem['UboId'] = $uboItem['token'];
                            // Si le token existe on le met à jour
                            if(isset($uboItem['token']) && !empty($uboItem['token']))
                            {
                                $updateUbo = mangoPay_uboUpdateUbo($api, $uboItem);
                            }
                            // Sinon on créer un nouveau document
                            else
                            {
                                $createUbo = mangoPay_createUBO($api, $uboItem);
                            }
                        }
                    }
                }
                else if($uboFromMangopay->Status == 'CREATED')
                {
                    $ubo = $_POST['ubo'];
                    $errors['valid'] = false;
                    // Maintenant on parcours tous les UBO envoyé
                    for($i=0;$i<4;$i++)
                    {
                        if(array_key_exists($i, $ubo))
                        {
                            $uboItem = $ubo[$i];
                            // On change la date en format TIMESTAMP
                            $birthday = date_create_from_format('Y-m-d', $uboItem['Birthday']['Year'].'-'.$uboItem['Birthday']['Month'].'-'.$uboItem['Birthday']['Day']);
                            $birthday->setTimezone(new \DateTimeZone('UTC'));
                            $uboItem['Birthday'] = date_timestamp_get($birthday);

                            $uboItem['UserId'] = $uboMembre['bank_id'];
                            $uboItem['UboDeclarationId'] = $uboMembre['ubo_id'];
                            $uboItem['UboId'] = $uboItem['token'];
                            // Si le token existe on le met à jour

                            // Possibilité de customisé les erreurs
                            if(isset($uboItem['token']) && !empty($uboItem['token']))
                            {
                                $updateUbo = mangoPay_uboUpdateUbo($api, $uboItem);
                                if(isset($updateUbo->Errors))
                                {
                                    $errors['valid'] = true;
                                    $errors['message'] .= $updateUbo->Message;
                                }
                            }
                            // Sinon on créer un nouveau document
                            else
                            {
                                $createUbo = mangoPay_createUBO($api, $uboItem);
                                if(isset($createUbo->Errors))
                                {
                                    $errors['valid'] = true;
                                    $errors['message'] .= $createUbo->Message;
                                }
                            }
                        }
                    }
                    if($errors['valid'])
                    {
                        $result2 = array(
                            "Texte_rapport" => $errors['message'],
                            "retour_validation" => "",
                            "retour_lien" => ""
                        );
                        echo $result2 = json_encode($result2);
                        return;
                    }
                }
                else if($uboFromMangopay->Status == 'VALIDATION_ASKED')
                {
                    $result2 = array(
                        "Texte_rapport" => "Vous avez déjà un document en cour de validation.",
                        "retour_validation" => "",
                        "retour_lien" => ""
                    );
                    echo $result2 = json_encode($result2);
                    return;
                }
            }

            ///// FIN KBIS
            /////////////////////////////////////////////////////////////////////////////////////
            //3 - Envoi IBAN
            if (isset($_POST['iban']) && !empty($_POST['iban']))
            {
            	
                //On vérifie si l'IBAN n'est pas déjà existant dans MangoPay pour ce compte
                $datas_for_mangopay = ['UserId' => $monRes['bank_id'], ];
                $liste_de_ribs_enregistres = mangoPay_listBankAccounts($api, $datas_for_mangopay);
                foreach ($liste_de_ribs_enregistres as $leRib):
                    if ($leRib
                        ->Details->IBAN == $_POST['iban'])
                    {
                        $deja_existant = 1;
                    }
                endforeach;

                if (!isset($deja_existant))
                {
                    if ($leRib->Details->IBAN == $_POST['iban']){

                    }
                    else {
                        $datas_for_mangopay = ['UserId' => $monRes['bank_id'], 'Tag' => 'Mise à jour IBAN', 'OwnerAddress' => ['AddressLine1' => $leMembre['adresse'], 'AddressLine2' => '', 'City' => $leMembre['ville'], 'PostalCode' => $leMembre['cp'], 'Country' => 'FR'], 'OwnerName' => $leMembre['prenom'] . ' ' . $leMembre['nom'], 'IBAN' => trim($_POST['iban']) ];

                        //mail('maxime.codione@gmail.com', 'iban', json_encode($datas_for_mangopay));
                        $bankAccount = json_decode(mangoPay_createIbanBankAccount($api, $datas_for_mangopay));
                        if (isset($bankAccount->Id) && !empty($bankAccount->Id))
                        {
                            //on update la ligne
                            $sql = $bdd->prepare("UPDATE membres_profil_paiement SET iban=?, external_account_id=? WHERE id=?");
                            $sql->execute([$_POST['iban'], $bankAccount->Id, $mpp_id]);
                            $sql->closeCursor();
                        }
                    }
                }
            }
        }
        else
        {
            $result2 = array(
                "Texte_rapport" => "L'IBAN n'est pas correct ! : ". $_POST['iban'],
                "retour_validation" => "",
                "retour_lien" => ""
            );
            $result2 = json_encode($result2);
            echo $result2;
            return ;
        }

    }
    elseif (empty($type_KYC))
    {
        $result2 = array(
            "Texte_rapport" => "Choisissez un type de société !",
            "retour_validation" => "",
            "retour_lien" => ""
        );
        $result2 = json_encode($result2);
        echo $result2;
        return ;
    }

    /*
    
    ////////////////////////////////////////////////////////////////////////Update du profil
    
    $type_KYC = $_POST['type_KYC'];
    
    $cni_recto = $_FILES['cni_recto']['name'];
    $cni_verso = $_FILES['cni_verso']['name'];
    $kbis = $_FILES['kbis']['name'];
    $justificatif_domicile = $_FILES['justificatif_domicile']['name'];
    
    $iban = $_POST['iban'];
    $iban_strlen = strlen($iban);
    $iban_fr = substr($iban,0,2);
    $iban_alphanum = ctype_alnum($iban);
    $iban_last_chaine = substr($iban,2,$iban_strlen);
    $iban_last_chaine_numeric = is_numeric($iban_last_chaine);
    
    $Statut_a_jour_signe = $_FILES['Statut_a_jour_signe']['name'];
    
    //VERIFICATION TYPOLOGIE IBAN
    if($iban_strlen == 27 && ($iban_fr == "fr" || $iban_fr == "FR" || $iban_fr == "Fr" || $iban_fr == "fR" ) && $iban_alphanum == 1 && $iban_last_chaine_numeric == 1){
    $iban_ok = "ok";
    }
    
    if((($type_KYC == "EI" || $type_KYC == "Auto entrepreneur") && !empty($justificatif_domicile) && !empty($type_KYC) && !empty($cni_recto) && !empty($cni_verso) && !empty($kbis) && !empty($iban) ) && $iban_ok == "ok" ||
    (($type_KYC == "SA" || $type_KYC == "SASU" || $type_KYC == "SAS" ) & !empty($justificatif_domicile) && !empty($type_KYC) && !empty($cni_recto) && !empty($cni_verso) && !empty($kbis) && !empty($iban) && !empty($Statut_a_jour_signe) ) && $iban_ok == "ok" ){
    
    if( (substr($cni_recto, -4) == "jpeg" || substr($cni_recto, -4) == "JPEG" || substr($cni_recto, -3) == "jpg" || substr($cni_recto, -3) == "JPG" || substr($cni_recto, -3) == "png" || substr($cni_recto, -3) == "PNG" || substr($cni_recto, -3) == "PDF" || substr($cni_recto, -3) == "pdf" ) &&
    (substr($cni_verso, -4) == "jpeg" || substr($cni_verso, -4) == "JPEG" || substr($cni_verso, -3) == "jpg" || substr($cni_verso, -3) == "JPG" || substr($cni_verso, -3) == "png" || substr($cni_verso, -3) == "PNG" || substr($cni_verso, -3) == "PDF" || substr($cni_verso, -3) == "pdf" ) &&
    (substr($kbis, -4) == "jpeg" || substr($kbis, -4) == "JPEG" || substr($kbis, -3) == "jpg" || substr($kbis, -3) == "JPG" || substr($kbis, -3) == "png" || substr($kbis, -3) == "PNG" || substr($kbis, -3) == "PDF" || substr($kbis, -3) == "pdf" ) &&
    (substr($justificatif_domicile, -4) == "jpeg" || substr($justificatif_domicile, -4) == "JPEG" || substr($justificatif_domicile, -3) == "jpg" || substr($justificatif_domicile, -3) == "JPG" || substr($justificatif_domicile, -3) == "png" || substr($justificatif_domicile, -3) == "PNG" || substr($justificatif_domicile, -3) == "PDF" || substr($justificatif_domicile, -3) == "pdf" ) &&
    ((substr($Statut_a_jour_signe, -4) == "jpeg" || substr($Statut_a_jour_signe, -4) == "JPEG" || substr($Statut_a_jour_signe, -3) == "jpg" || substr($Statut_a_jour_signe, -3) == "JPG" || substr($Statut_a_jour_signe, -3) == "png" || substr($Statut_a_jour_signe, -3) == "PNG" || substr($Statut_a_jour_signe, -3) == "PDF" || substr($Statut_a_jour_signe, -3) == "pdf" ) || ($type_KYC == "EI" || $type_KYC == "Auto entrepreneur")) ){
    
    ///////////////////////////////UPDATE / INSERT PROFIL PAIEMENT
    
    ////////RECTO CNI - TELECHARGEMENT
    $document = "cni_recto";
    include('documents-upload.php');
    $cni_recto = $nouveau_nom_fichier;
    
    ////////VERSO CNI - TELECHARGEMENT
    $document = "cni_verso";
    include('documents-upload.php');
    $cni_verso = $nouveau_nom_fichier;
    
    ////////KBIS - TELECHARGEMENT
    $document = "kbis";
    include('documents-upload.php');
    $kbis = $nouveau_nom_fichier;
    
    ////////STATUT - TELECHARGEMENT
    if($type_KYC == "SA" || $type_KYC == "SASU" || $type_KYC == "SAS" ){
    $document = "Statut_a_jour_signe";
    include('documents-upload.php');
    $Statut_a_jour_signe = $nouveau_nom_fichier;
    }
    
    ////////JUSTIFICATIF DE DOMICILE - TELECHARGEMENT
    $document = "justificatif_domicile";
    include('documents-upload.php');
    $kbis = $nouveau_nom_fichier;
    
    ////////COMPTE VALIDE oui OU non
    $compte_valide = "oui";
    
    ///////////////UPDATE OU INSERT ?
    if(!empty($id_paiement)){
    
    ///////////////////////////////UPDATE PROFIL PAIEMENT
    $sql_update = $bdd->prepare("UPDATE membres_profil_paiement SET 
    	bank_id=?,
    	wallet_id=?, 
    	kyc_id=?,
    	registration_id=?,
    	articleofasso_id=?,
    	shareholder_id=?,
    	external_account_id=?,
    	cni_recto=?,
    	cni_verso=?,
    	kbis=?,
    	iban=?,
    	fichier_statuts=?,
    	type_KYC=?,
    	justificatif_domicile=?,
    	compte_valide=?
    	WHERE pseudo=?");
    $sql_update->execute(array(
    	'',
    	'',
    	'',
    	'',
    	'',
    	'',
    	'',
    	$cni_recto,
    	$cni_verso,
    	$kbis,
    	$iban,
    	$Statut_a_jour_signe,
    	$type_KYC,
    	$justificatif_domicile,
    	$compte_valide,
    	$user));                     
    $sql_update->closeCursor();
    }else{
    
    ///////////////////////////////UPDATE PROFIL PAIEMENT
    $sql_update = $bdd->prepare("INSERT INTO membres_profil_paiement
    	(id_membre,
    	pseudo,
    	bank_id,
    	wallet_id, 
    	kyc_id,
    	registration_id,
    		articleofasso_id,
    	shareholder_id,
    	external_account_id,
    	cni_recto,
    	cni_verso,
    	kbis,
    	iban,
    	fichier_statuts,
    	type_KYC,
    	justificatif_domicile,
    	compte_valide)
    	VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $sql_update->execute(array(
    	$id_oo,
    	$user,
    	'',
    	'',
    	'',
    	'',
    	'',
    	'',
    	'',
    	$cni_recto,
    	$cni_verso,
    	$kbis,
    	$iban,
    	$Statut_a_jour_signe,
    	$type_KYC,
    	$justificatif_domicile,
    	$compte_valide));                     
    $sql_update->closeCursor();
    
    }
    
    $result2 = array("Texte_rapport"=>"Modification apportées avec succès !","retour_validation"=>"ok","retour_lien"=>"");
    
    
    }else{
    $result2 = array("Texte_rapport"=>"Un fichier n'a pas l'extansion requise !","retour_validation"=>"","retour_lien"=>"");
    }
    
    }elseif($iban_fr != "fr" && $iban_fr != "FR" && $iban_fr != "Fr" && $iban_fr != "fR" ){
    $result2 = array("Texte_rapport"=>"L'IBAN doit commencer par FR !","retour_validation"=>"","retour_lien"=>"");
    
    }elseif($iban_last_chaine_numeric != 1){
    $result2 = array("Texte_rapport"=>"L'IBAN doit être numérique !","retour_validation"=>"","retour_lien"=>"");
    
    }elseif($iban_strlen != 27){
    $result2 = array("Texte_rapport"=>"L'IBAN doit être composé de 27 caractères !","retour_validation"=>"","retour_lien"=>"");
    
    }elseif($iban_alphanum != 1){
    $result2 = array("Texte_rapport"=>"L'IBAN doit être aplhanumérique !","retour_validation"=>"","retour_lien"=>"");
    
    }elseif(empty($type_KYC)){
    $result2 = array("Texte_rapport"=>"Choisissez un type de société !","retour_validation"=>"","retour_lien"=>"");
    
    }elseif(empty($iban)){
    $result2 = array("Texte_rapport"=>"Vous devez indiquer un IBAN !","retour_validation"=>"","retour_lien"=>"");
    
    }elseif(empty($cni_recto)){
    $result2 = array("Texte_rapport"=>"Vous devez télécharger le recto de la CNI !","retour_validation"=>"","retour_lien"=>"");
    
    }elseif(empty($cni_verso)){
    $result2 = array("Texte_rapport"=>"Vous devez télécharger le vero de la CNI !","retour_validation"=>"","retour_lien"=>"");
    
    }elseif(empty($kbis)){
    $result2 = array("Texte_rapport"=>"Vous devez télécharger votre kbis !","retour_validation"=>"","retour_lien"=>"");
    
    }elseif(empty($justificatif_domicile)){
    $result2 = array("Texte_rapport"=>"Vous devez télécharger un justificatif !","retour_validation"=>"","retour_lien"=>"");
    
    }elseif(($type_KYC == "SA" || $type_KYC == "SASU" || $type_KYC == "SAS" ) && empty($Statut_a_jour_signe) ){
    $result2 = array("Texte_rapport"=>"Vous devez télécharger vos statuts","retour_validation"=>"","retour_lien"=>"");
    
    }
    $sql = $bdd->prepare("SELECT mail FROM membres WHERE pseudo = ?");
    $sql->execute(array($user));
    $mail = $sql->fetch();
    $sql->closeCursor();
    
    $mail_compte_concerne = $mail['mail'];
    $module_log = "PROFIL DE PAIEMENT";
    $action_sujet_log = "Notification de modification de vos données de paiement";
    $action_libelle_log = "Notification de votre compte <b>$mail_compte_concerne</b> sur $nomsiteweb. Vos données de paiement ont été modifiées sur votres espace utilisateur.
       Si vous n'êtes pas à l'origine des modifications de vos informations personnelles, veuillez sans attendre contacter un administrateur sur la page
    <a href='".$http."".$nomsiteweb."/Contact' target='blank_' style='text-decoration: underline;' >Contact</a>";
    $action_log = "PROFIL DE PAIEMENT";
    $niveau_log = "2";
    $compte_bloque = "";
    log_h($mail_compte_concerne,$module_log,$action_sujet_log,$action_libelle_log,$action_log,$niveau_log,$compte_bloque);
    */
    $result2 = array(
        "Texte_rapport" => "Modifications effectuées ! ",
        "retour_validation" => "ok",
        "retour_lien" => ""
    );

    ////////////////////////////////////////////////////////////////////////Update du profil
    $result2 = json_encode($result2);
    echo $result2;

}
else
{
    header('location: /index.html');
}

ob_end_flush();
?>
