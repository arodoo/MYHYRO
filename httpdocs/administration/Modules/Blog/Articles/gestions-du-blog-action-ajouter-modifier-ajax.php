<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once ('../../../../Configurations_bdd.php');
require_once ('../../../../Configurations.php');
require_once ('../../../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction = "../../../../";
require_once ('../../../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

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

if (isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 1 || isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 4)
{
    $action = $_POST['action'];
    $idaction = $_POST['idaction'];

    $id_categorie_article_post = $_POST['id_categorie_article_post'];
    $nom_article_titre1_post = $_POST['nom_article_titre1_post'];
    $nom_titre2_post = $_POST['nom_titre2_post'];

    $description_articles_post = $_POST['description_articles_post'];
    $video_article_post = $_POST['video_article_post'];

    $ancre_mot_cle_1_post = $_POST['ancre_mot_cle_1_post'];
    $ancre_mot_cle_1_lien_post = $_POST['ancre_mot_cle_1_lien_post'];

    $ancre_mot_cle_2_post = $_POST['ancre_mot_cle_2_post'];
    $ancre_mot_cle_2_lien_post = $_POST['ancre_mot_cle_2_lien_post'];

    $ancre_mot_cle_3_post = $_POST['ancre_mot_cle_3_post'];
    $ancre_mot_cle_3_lien_post = $_POST['ancre_mot_cle_3_lien_post'];

    $ancre_mot_cle_4_post = $_POST['ancre_mot_cle_4_post'];
    $ancre_mot_cle_4_lien_post = $_POST['ancre_mot_cle_4_lien_post'];

    $title_article_post = $_POST['title_article_post'];
    $meta_description_post = $_POST['meta_description_post'];
    $meta_keyword_post = $_POST['meta_keyword_post'];
    $statut_activer_post = $_POST['statut_activer_post'];
    $statut_activer_post_commentaire = $_POST['statut_activer_post_commentaire'];

    $type_blog_artciles = $_POST['type_blog_artciles'];

    $id_article_blog = $_POST['id_article_blog'];
    $lien_page = $_POST['lien_page'];
    $ancre_page = $_POST['ancre_page'];
    $statut = $_POST['statut'];
    $Position = $_POST['Position'];

    $envoyer_mail = $_POST['envoyer_mail'];

    $now = time();

    ////////////////////////////AJOUTER
    if ($action == "ajouter-action")
    {

///////////////////////////////INSERT
$sql_insert = $bdd->prepare("INSERT INTO codi_one_blog
	(id_categorie,
	titre_blog_1,
	titre_blog_2,
	texte_article,
	video,
	url_fiche_blog,
	mot_cle_blog_1,
	mot_cle_blog_1_lien,
	mot_cle_blog_2,
	mot_cle_blog_2_lien,
	mot_cle_blog_3,
	mot_cle_blog_3_lien,
	mot_cle_blog_4,
	mot_cle_blog_4_lien,
	ID_IMAGE_BLOG,
	nbr_consultation_blog,
	Title,
	Metas_description,
	Metas_mots_cles,
	activer_commentaire,
	activer,
	date_blog,
	type_blog_artciles,
	plus,
	plus1)
	VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
$sql_insert->execute(array(
	$id_categorie_article_post,
	$nom_article_titre1_post,
	$nom_titre2_post,
	$description_articles_post,
	$video_article_post,
	'',
	$ancre_mot_cle_1_post,
	$ancre_mot_cle_1_lien_post,
	$ancre_mot_cle_2_post,
	$ancre_mot_cle_2_lien_post,
	$ancre_mot_cle_3_post,
	$ancre_mot_cle_3_lien_post,
	$ancre_mot_cle_4_post,
	$ancre_mot_cle_4_lien_post,
	'',
	'0',
	$title_article_post,
	$meta_description_post,
	$meta_keyword_post,
	$statut_activer_post_commentaire,
	$statut_activer_post,
	$now,
	$type_blog_artciles,
	$_SESSION['id_page_photo_2'],
	''));                     
$sql_insert->closeCursor();
///////////////////////////////On nome l'url de la page si ce n'est pas un module

        ///////////////////////////////On nomme l'url de la page si ce n'est pas un module
        ///////////////////////////////SELECT
        $req_select = $bdd->prepare("SELECT * FROM codi_one_blog WHERE date_blog=?");
        $req_select->execute(array($now));
        $ligne_select = $req_select->fetch();
        $req_select->closeCursor();
        $id_image = $ligne_select['id'];

        $_SESSION['idsessionp'] = $id_image;

        //////////////////////////////////////On nomme l'url de la page
        $nouveaucontenu = "$nom_article_titre1_post";
        include ("../../../../function/cara_replace.php");
        $nom_article_titre1_post_url = "$nouveaucontenu";
        $nom_article_titre1_post_url = "Blog/" . $nom_article_titre1_post_url . "/" . $id_image . "";
        //////////////////////////////////////On nomme l'url de la page
        /////////////////////////////////////On met à jour l'url
        ///////////////////////////////UPDATE
        $sql_update = $bdd->prepare("UPDATE codi_one_blog SET url_fiche_blog=? WHERE id=?");
        $sql_update->execute(array(
            $nom_article_titre1_post_url,
            $id_image
        ));
        $sql_update->closeCursor();
        /////////////////////////////////////On met à jour l'url
        /////////////////////////MISE A JOUR DE L'ID POUR LES IMAGES DE L'ARTICLE
        ///////////////////////////////SELECT BOUCLE
        $req_boucle = $bdd->prepare("SELECT * FROM codi_one_blog_a_b_image WHERE id_page=?");
        $req_boucle->execute(array(
            $_SESSION['id_page_photo_2']
        ));
        while ($ligne_boucle = $req_boucle->fetch())
        {
            $id_image_update = $ligne_boucle['id'];

            ///////////////////////////////UPDATE
            $sql_update = $bdd->prepare("UPDATE codi_one_blog_a_b_image SET id_page=? WHERE id=?");
            $sql_update->execute(array(
                $id_image,
                $id_image_update
            ));
            $sql_update->closeCursor();

        }
        $req_boucle->closeCursor();
        /////////////////////////MISE A JOUR DE L'ID POUR LES IMAGES DE L'ARTICLE
        /////////////////////////////////////////////////////////////MAILS NEWSLETTER
        //////////////////////////////////////////////SI MODULE NEWSLETTER ACTIVE
        if ($newsletter == "oui" && $statut_activer_post == "oui" && $envoyer_mail == "oui")
        {

            ///////////////////////////////SELECT BOUCLE
            $req_boucle = $bdd->prepare("SELECT * FROM Newsletter_listing");
            $req_boucle->execute();
            while ($ligne_boucle = $req_boucle->fetch())
            {
                $idrsdNumero_id = $ligne_boucle['Numero_id'];
                $mail = $ligne_boucle['Mail'];

                $lien_desabonnement = "<a href='" . $http . "" . $nomsiteweb . "/Desabonnement-lettre-information-" . $idrsdNumero_id . ".html' target='_blank'>Si vous ne souhaitez plus recevoir la lettre d'information, cliquer ici</a>";

                //////////////////////////////////////////////////////////////////////A inclure sur la page FONCTION MAIL
                $de_nom = "$nomsiteweb"; //Nom de l'envoyeur
                $de_mail = "$emaildefault"; //Email de l'envoyeur
                $vers_nom = "$mail"; //Nom du receveur
                $vers_mail = "$mail"; //Email du receveur
                $sujet = mail_bi($type_scan = "sujet", $id_mail_requete = 9);

                $message_principalone = mail_bi($type_scan = "", $id_mail_requete = 9);

                mailsend($vers_mail, $vers_nom, $de_mail, $de_nom, $sujet, $message_principalone);
                //////////////////////////////////////////////////////////////////////A inclure sur la page FONCTION MAIL
                
            }
            $req_boucle->closeCursor();

        }
        //////////////////////////////////////////////SI MODULE NEWSLETTER ACTIVE
        /////////////////////////////////////////////////////////////MAILS NEWSLETTER


///////////////////////////////DELETE
$sql_delete = $bdd->prepare("DELETE FROM codi_one_blog_liens WHERE id_article_blog=?");
$sql_delete->execute(array($id_image));                     
$sql_delete->closeCursor();

if(!empty($blog_liens['lien'])){
    foreach($_POST['blog_liens'] as $blog_liens ){
        $i++;

        $sql_insert = $bdd->prepare("INSERT INTO codi_one_blog_liens
        (id_article_blog,
        lien_page,
        ancre_page,
        statut,
        Position)
        VALUES (?,?,?,?,?)");
            $sql_insert->execute(array(
                $id_image,
                $blog_liens['lien'],
                $blog_liens['ancre'],
                'oui',
                $blog_liens['position']
            ));
            $sql_insert->closeCursor();
    //echo print_r($blog_liens['lien']);
    //echo "<br />";
    }

}
///////////////////AJOUT LIEN


        $result = array(
            "Texte_rapport" => "Article ajouté avec succès !",
            "retour_validation" => "ok",
            "retour_lien" => ""
        );

    }
    ////////////////////////////AJOUTER





    ////////////////////////////MODIFIER
    if ($action == "modifier-action")
    {

        $_SESSION['idsessionp'] = $idaction;

        //////////////////////////////////////On nomme l'url de la page
        $nouveaucontenu = "$nom_article_titre1_post";
        include ("../../../../function/cara_replace.php");
        $nom_article_titre1_post_url = "$nouveaucontenu";
        $nom_article_titre1_post_url = "Blog/" . $nom_article_titre1_post_url . "/" . $idaction . "";
        //////////////////////////////////////On nomme l'url de la page
        ///////////////////////////////UPDATE
        $sql_update = $bdd->prepare("UPDATE codi_one_blog SET 
	id_categorie=?, 
	titre_blog_1=?,
	titre_blog_2=?,
	texte_article=?,
	video=?,
	url_fiche_blog=?, 
	mot_cle_blog_1=?,
	mot_cle_blog_1_lien=?,
	mot_cle_blog_2=?, 
	mot_cle_blog_2_lien=?,
	mot_cle_blog_3=?,
	mot_cle_blog_3_lien=?, 
	mot_cle_blog_4=?,
	mot_cle_blog_4_lien=?,
	ID_IMAGE_BLOG=?, 
	Title=?, 
	Metas_description=?,
	Metas_mots_cles=?,
	activer_commentaire=?, 
	activer=?,
	date_blog=?,
	type_blog_artciles=?
	WHERE id=?");
        $sql_update->execute(array(
            $id_categorie_article_post,
            $nom_article_titre1_post,
            $nom_titre2_post,
            $description_articles_post,
            $video_article_post,
            $nom_article_titre1_post_url,
            $ancre_mot_cle_1_post,
            $ancre_mot_cle_1_lien_post,
            $ancre_mot_cle_2_post,
            $ancre_mot_cle_2_lien_post,
            $ancre_mot_cle_3_post,
            $ancre_mot_cle_3_lien_post,
            $ancre_mot_cle_4_post,
            $ancre_mot_cle_4_lien_post,
            '',
            $title_article_post,
            $meta_description_post,
            $meta_keyword_post,
            $statut_activer_post_commentaire,
            $statut_activer_post,
            $now,
            $type_blog_artciles,
            $idaction
        ));
        $sql_update->closeCursor();

///////////////////AJOUT LIEN

///////////////////////////////DELETE
$sql_delete = $bdd->prepare("DELETE FROM codi_one_blog_liens WHERE id_article_blog=?");
$sql_delete->execute(array($idaction));                     
$sql_delete->closeCursor();

if(!empty($blog_liens['lien'])){
    foreach($_POST['blog_liens'] as $blog_liens ){
    $i++;

    $sql_insert = $bdd->prepare("INSERT INTO codi_one_blog_liens
	(id_article_blog,
	lien_page,
	ancre_page,
	statut,
	Position)
     VALUES (?,?,?,?,?)");
         $sql_insert->execute(array(
             $idaction,
             $blog_liens['lien'],
             $blog_liens['ancre'],
             'oui',
             $blog_liens['position']
        ));
         $sql_insert->closeCursor();
//echo print_r($blog_liens['lien']);
//echo "<br />";
}

}
///////////////////AJOUT LIEN

        $result = array(
            "Texte_rapport" => "Modifications effectuées !",
            "retour_validation" => "ok",
            "retour_lien" => ""
        );

    }
    ////////////////////////////MODIFIER
    $result = json_encode($result);
    echo $result;



}
else
{
    header('location: /index.html');
}

ob_end_flush();
