<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../../Configurations_bdd.php');
require_once('../../../Configurations.php');
require_once('../../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction = "../../";
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

$id = $_POST['id'];

if (isset($user)) {
    if(isset($id)){
        $sql_update = $bdd->prepare("UPDATE membres_souhait SET
        statut=?
        WHERE id=?");
    
        $sql_update->execute(
            array(
                intval(4),
                intval($id)
            )
        );
        $sql_update->closeCursor();
        $result = array("Texte_rapport" => "Demande refusé !", "retour_validation" => "ok", "retour_lien" => "");
    }else{
        $result = array("Texte_rapport" => "Erreur", "retour_validation" => "non", "retour_lien" => "");
    }
    
    $result = json_encode($result);
    echo $result;
} else {
    header('location: /index.html');
}

ob_end_flush();
?>