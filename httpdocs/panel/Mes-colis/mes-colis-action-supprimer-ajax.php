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

$id = $_POST['id'];

try {
    if (isset($user)) {
        if (isset($id)) {
            $sql_select = $bdd->prepare("SELECT * FROM membres_colis WHERE id=?");
            $sql_select->execute(array(intval($id)));
            $colis = $sql_select->fetch();
            $sql_select->closeCursor();

            if ($colis) {
                $sql_delete = $bdd->prepare("DELETE FROM membres_colis_details WHERE colis_id=?");
                $sql_delete->execute(array($colis['id']));
                $sql_delete->closeCursor();

                $sql_delete = $bdd->prepare("DELETE FROM membres_colis WHERE id=?");
                $sql_delete->execute(array($colis['id']));
                $sql_delete->closeCursor();

                $result = array("Texte_rapport" => "Colis supprimée !", "retour_validation" => "ok", "retour_lien" => "");
            } else {
                $result = array("Texte_rapport" => "Colis non trouvé", "retour_validation" => "non", "retour_lien" => "");
            }
        } else {
            $result = array("Texte_rapport" => "ID manquant", "retour_validation" => "non", "retour_lien" => "");
        }
    } else {
        header('location: /index.html');
        exit();
    }
} catch (Exception $e) {
    $result = array("Texte_rapport" => "Erreur: " , "retour_validation" => "non", "retour_lien" => "");
}

echo json_encode($result);
ob_end_flush();
