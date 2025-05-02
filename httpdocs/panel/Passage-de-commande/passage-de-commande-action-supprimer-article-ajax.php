<?php
ob_start();


////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../Configurations_bdd.php');
require_once('../../Configurations.php');
require_once('../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction = "../../";
require_once('../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

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

$idCommande = $_POST['idCommande'];
$idArticle = $_POST['idArticle'];

if(!empty($user)){
    $req_select = $bdd->prepare("SELECT * FROM membres WHERE id=?");
    $req_select->execute(array(
        $id_oo
    ));
    $membre = $req_select->fetch();
    $req_select->closeCursor();
    
    $req_select = $bdd->prepare("SELECT * FROM configurations_abonnements WHERE id=?");
    $req_select->execute(array(
        $membre['Abonnement_id']
    ));
    $abonnement = $req_select->fetch();
    $req_select->closeCursor();
}else{
    $req_select = $bdd->prepare("SELECT * FROM configurations_abonnements WHERE id=?");
    $req_select->execute(array(
        1
    ));
    $abonnement = $req_select->fetch();
    $req_select->closeCursor();
}


if(isset($idCommande) && isset($idArticle)){
    $sql_delete = $bdd->prepare("DELETE FROM membres_commandes_details WHERE id=?");
    $sql_delete->execute(array(
        $idArticle
    ));
    $sql_delete->closeCursor();

    $sql_delete = $bdd->prepare("DELETE FROM membres_panier_details WHERE id_commande_detail=?");
    $sql_delete->execute(array($idArticle));
    $sql_delete->closeCursor();
    
    $sql_select = $bdd->prepare("SELECT * FROM membres_commandes_details WHERE commande_id=?");
    $sql_select->execute(array($idCommande));
    $articles = $sql_select->fetch();
    $sql_select->closeCursor();
    
    if($articles){
        $update = update_commande($idCommande);
        
        if($update){
            $result = json_encode(array("Texte_rapport" => "Article supprimé !", "retour_validation" => "ok", "retour_lien" => ""));
            echo $result;
        }else{
            $result = json_encode(array("Texte_rapport" => "Erreur !", "retour_validation" => "non", "retour_lien" => ""));
            echo $result;
        }
    }else{
        $sql_select = $bdd->prepare("SELECT * FROM membres_commandes WHERE id=?");
        $sql_select->execute(array($idCommande));
        $commande = $sql_select->fetch();
        $sql_select->closeCursor();

        $sql_delete = $bdd->prepare("DELETE FROM membres_panier_details WHERE numero_panier=?");
        $sql_delete->execute(array($commande['panier_id']));
        $sql_delete->closeCursor();

        $sql_delete = $bdd->prepare("DELETE FROM membres_panier WHERE id=?");
        $sql_delete->execute(array($commande['panier_id']));
        $sql_delete->closeCursor();

        $sql_delete = $bdd->prepare("DELETE FROM membres_commandes WHERE id=?");
        $sql_delete->execute(array($idCommande));
        $sql_delete->closeCursor();

        unset($_SESSION['id_commande']);
        unset($_SESSION['saved']);
        unset($_SESSION['action']);
        $result = json_encode(array("Texte_rapport" => "Panier supprimé !", "retour_validation" => "ok", "retour_lien" => "/"));
        echo $result;
    }
                
    
}else{
    $result = json_encode(array("Texte_rapport" => "Erreur !", "retour_validation" => "non", "retour_lien" => ""));
    echo $result;
}