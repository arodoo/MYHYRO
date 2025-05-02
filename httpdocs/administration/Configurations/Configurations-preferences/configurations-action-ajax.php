<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once ('../../../Configurations_bdd.php');
require_once ('../../../Configurations.php');
require_once ('../../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction = "../../../";
require_once ('../../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

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

if (isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user))
{


    $promo_for_all = $_POST['promo_for_all'];
    $code_promo = $_POST['code_promo'];
	$cgl_default = $_POST["cgl_default"];

    $type_template = $_POST["type_template"];

    $nomproprietaire = $_POST["nom_proprietaire"];
    $urlsite = $_POST["urlsite"];

    $nomsitewebp = $_POST["nomsitewebp"];

    $emaildefault = $_POST["emaildefault"];

    $resdomaine = "$urlsite";
    $restt = substr($resdomaine, 0, 7);
    $resttt = substr($resdomaine, 0, 4);
    $restttt = substr($resdomaine, 0, 11);

    $text_informations_footer_post = $_POST["text_informations_footer_post"];
    $Google_analytic = $_POST["Google_analytic"];
    $http_post = $_POST["http_post"];

    $Page_Facebook = $_POST["Page_Facebook"];
    $Page_twitter = $_POST["Page_twitter"];
    $Page_Google = $_POST["Page_Google"];
    $Page_Linkedin = $_POST["Page_Linkedin"];
    $Chaine_Youtube = $_POST["Chaine_Youtube"];

    $cookies_validation_module = $_POST['cookies_validation_module'];
    $texte_cookies = $_POST['texte_cookies'];
    $type_cookies_alerte = $_POST['type_cookies_alerte'];
    $cookies_bouton_accepter = $_POST['cookies_bouton_accepter'];
    $Type_bouton_cookies_alerte = $_POST['Type_bouton_cookies_alerte'];

    $commission = $_POST['commission'];
    $activer_mangopay = $_POST['activer_mangopay'];
    $action_sms = $_POST['action_sms'];

    $now = time();
    $nowtime = date('Y-m-d');

    //////////////////////////////////////////////////////////////////////////////////ACTIONS
    if ($restt != "http://" && $resttt != "www." && $resttt != "https://")
    {

        $icon1 = $_FILES['bandeau_image_page_secondaire_default']['name'];
        //////////////////////////////////////POST ACTION UPLOAD 1
        if (!empty($icon1))
        {
            if (!empty($icon1) && substr($icon1, -4) == "jpeg" || !empty($icon1) && substr($icon1, -3) == "jpg" || !empty($icon1) && substr($icon1, -3) == "JPEG" || !empty($icon1) && substr($icon1, -3) == "JPG" || !empty($icon1) && substr($icon1, -3) == "png" || !empty($icon1) && substr($icon1, -3) == "PNG" || !empty($icon1) && substr($icon1, -3) == "gif" || !empty($icon1) && substr($icon1, -3) == "GIF")
            {
                $image_a_uploader = $_FILES['bandeau_image_page_secondaire_default']['name'];
                $icon = $_FILES['bandeau_image_page_secondaire_default']['name'];
                $taille = $_FILES['bandeau_image_page_secondaire_default']['size'];
                $tmp = $_FILES['bandeau_image_page_secondaire_default']['tmp_name'];
                $type = $_FILES['bandeau_image_page_secondaire_default']['type'];
                $erreur = $_FILES['bandeau_image_page_secondaire_default']['error'];
                $source_file = $_FILES['bandeau_image_page_secondaire_default']['tmp_name'];
                $destination_file = "../../../images/" . $icon . "";

                ////////////Upload des images
                if (move_uploaded_file($tmp, $destination_file))
                {
                    $namebrut = explode('.', $image_a_uploader);
                    $namebruto = $namebrut[0];
                    $namebruto_extansion = $namebrut[1];
                    $nouveaucontenu = "$namebruto";
                    include ('../../../function/cara_replace.php');
                    $namebruto = "$nouveaucontenu";
                    $nouveau_nom_fichier = "" . $namebruto . "-" . $now . ".$namebruto_extansion";
                    rename("../../../images/$icon", "../../../images/$nouveau_nom_fichier");

                    ///////////////////////////////UPDATE
                    $sql_update = $bdd->prepare("UPDATE configuration_email SET 
						bandeau_image_page_secondaire_default=?
						WHERE id=?");
                    $sql_update->execute(array(
                        $nouveau_nom_fichier,
                        '1'
                    ));
                    $sql_update->closeCursor();

                }
                ////////////Upload des images
                
            }
            elseif (!empty($icon1))
            {
                $tous_les_fichiers_non_pas_l_extension = "oui";
            }
        }
        //////////////////////////////////////POST ACTION UPLOAD 1
        $icon2 = $_FILES['logo']['name'];
        //////////////////////////////////////POST ACTION UPLOAD LOGO
        if (!empty($icon2))
        {
            if (!empty($icon2) && substr($icon2, -4) == "jpeg" || !empty($icon2) && substr($icon2, -3) == "jpg" || !empty($icon2) && substr($icon2, -3) == "JPEG" || !empty($icon2) && substr($icon2, -3) == "JPG" || !empty($icon2) && substr($icon2, -3) == "png" || !empty($icon2) && substr($icon2, -3) == "PNG" || !empty($icon2) && substr($icon2, -3) == "gif" || !empty($icon2) && substr($icon2, -3) == "GIF")
            {
                $image_a_uploader = $_FILES['logo']['name'];
                $icon = $_FILES['logo']['name'];
                $taille = $_FILES['logo']['size'];
                $tmp = $_FILES['logo']['tmp_name'];
                $type = $_FILES['logo']['type'];
                $erreur = $_FILES['logo']['error'];
                $source_file = $_FILES['logo']['tmp_name'];
                $destination_file = "../../../images/" . $icon . "";

                ////////////Upload des images
                if (move_uploaded_file($tmp, $destination_file))
                {
                    $namebrut = explode('.', $image_a_uploader);
                    $namebruto = $namebrut[0];
                    $namebruto_extansion = $namebrut[1];
                    $nouveaucontenu = "$namebruto";
                    include ('../../../function/cara_replace.php');
                    $namebruto = "$nouveaucontenu";
                    $nouveau_nom_fichier = "" . $namebruto . "-" . $now . ".$namebruto_extansion";
                    rename("../../../images/$icon", "../../../images/$nouveau_nom_fichier");

                    ///////////////////////////////UPDATE
                    $sql_update = $bdd->prepare("UPDATE configurations_preferences_generales SET 
						logo=?
						WHERE id=?");
                    $sql_update->execute(array(
                        $nouveau_nom_fichier,
                        '1'
                    ));
                    $sql_update->closeCursor();

                }
                ////////////Upload des images
                
            }
            elseif (!empty($icon2))
            {
                $tous_les_fichiers_non_pas_l_extension = "oui";
            }
        }
        //////////////////////////////////////POST ACTION UPLOAD LOGO
        $icon3 = $_FILES['favicon']['name'];
        //////////////////////////////////////POST ACTION UPLOAD FAVICON
        if (!empty($icon3))
        {
            if (!empty($icon3) && substr($icon3, -3) == "ico" || !empty($icon3) && substr($icon3, -3) == "ICO")
            {
                $image_a_uploader = $_FILES['favicon']['name'];
                $icon = $_FILES['favicon']['name'];
                $taille = $_FILES['favicon']['size'];
                $tmp = $_FILES['favicon']['tmp_name'];
                $type = $_FILES['favicon']['type'];
                $erreur = $_FILES['favicon']['error'];
                $source_file = $_FILES['logo']['tmp_name'];
                $destination_file = "../../../images/" . $icon . "";

                ////////////Upload des images
                if (move_uploaded_file($tmp, $destination_file))
                {
                    $namebrut = explode('.', $image_a_uploader);
                    $namebruto = $namebrut[0];
                    $namebruto_extansion = $namebrut[1];
                    $nouveaucontenu = "$namebruto";
                    include ('../../../function/cara_replace.php');
                    $namebruto = "$nouveaucontenu";
                    $nouveau_nom_fichier = "" . $namebruto . "-" . $now . ".$namebruto_extansion";
                    rename("../../../images/$icon", "../../../images/$nouveau_nom_fichier");

                    ///////////////////////////////UPDATE
                    $sql_update = $bdd->prepare("UPDATE configurations_preferences_generales SET 
						favicon=?
						WHERE id=?");
                    $sql_update->execute(array(
                        $nouveau_nom_fichier,
                        '1'
                    ));
                    $sql_update->closeCursor();

                }
                ////////////Upload des images
                
            }
            elseif (!empty($icon3))
            {
                $tous_les_fichiers_non_pas_l_extension = "oui";
            }
        }
        //////////////////////////////////////POST ACTION UPLOAD FAVICON
        ///////////////////////////////UPDATE
        $sql_update = $bdd->prepare("UPDATE configurations_preferences_generales SET 	
		cookies_bouton_accepter=?, 
		Type_bouton_cookies_alerte=?,
		texte_cookies=?,
		type_cookies_alerte=?,
		cookies_validation_module=?,
		http=?,
		text_informations_footer=?,
		date_update=?, 
		Google_analytic=?,
		Page_Facebook=?,
		Page_twitter=?,
		Page_Google=?,
		Page_Linkedin=?,
		Chaine_Youtube=?,
		nom_siteweb=?,
		nom_proprietaire=?, 
		bloc_couleur_fond=?,
		bloc_couleur_bordure=?,
		bloc_couleur_complementaire=?,
		auteur_delamiseajour=?,
		commission=?,
		activer_mangopay=?
		WHERE id=?");
        $sql_update->execute(array(
            	$cookies_bouton_accepter,
            	$Type_bouton_cookies_alerte,
           	$texte_cookies,
           	$type_cookies_alerte,
            	$cookies_validation_module,
            	$http_post,
            	$text_informations_footer_post,
            	time(),
            	$Google_analytic,
           	$Page_Facebook,
            	$Page_twitter,
            	$Page_Google,
            	$Page_Linkedin,
            	$Chaine_Youtube,
            	$urlsite,
            	$nomproprietaire,
            	$bloc_couleur_fond,
            	$bloc_couleur_bordure,
            	$bloc_couleur_bordure,
           	$user,
		$commission,
		$activer_mangopay,
            	'1'));
        	$sql_update->closeCursor();

        ///////////////////////////////UPDATE
        $sql_update = $bdd->prepare("UPDATE configuration_email SET 
		nom_siteweb=?, 
		email_default=? 
		WHERE id=?");
        $sql_update->execute(array(
            	$urlsite,
            	$emaildefault,
            	'1'));
        $sql_update->closeCursor();

        $result = array(
            "Texte_rapport" => "Action effectuée avec succès !",
            "retour_validation" => "ok",
            "retour_lien" => ""
        );

    }
    elseif ($resttt == "www." || $restt == "https://" || $restt == "http://" || "http://www.")
    {
        $result = array(
            "Texte_rapport" => "Seul votre nom de domaine brut doit être indiqué. !",
            "retour_validation" => "",
            "retour_lien" => ""
        );

        //////////////////////////////////////////////////////////////////////////////////ACTIONS
        
    }

    $result = json_encode($result);
    echo $result;

}
else
{
    header('location: /index.html');
}

ob_end_flush();
?>
