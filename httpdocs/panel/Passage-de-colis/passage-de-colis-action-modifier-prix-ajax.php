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
$prix = floatval($_POST['prix']);


    $sql_select = $bdd->prepare('SELECT * FROM membres_colis WHERE user_id=? AND statut=1');
    $sql_select->execute(array($id_oo));
    $colis = $sql_select->fetch();
    $sql_select->closeCursor();

    $select_bql = $bdd->prepare("SELECT * FROM membres_panier_details WHERE id_membre=? AND id_colis_detail=?");
                    $select_bql->execute(array($id_oo, $colis['id']));
                    $select_pan_d = $select_bql->fetch();
                    $select_bql->closeCursor();

        $sql_update = $bdd->prepare("UPDATE membres_colis SET
        prix_total=?
        WHERE id=?");

            $sql_update->execute(array(
                $prix,
                $colis['id']
            ));
            $sql_update->closeCursor();

            $sql_update = $bdd->prepare("UPDATE membres_panier_details SET
            TTC_colis=?
            WHERE id=?");

            $sql_update->execute(array(
                $prix,
                $id_panier_d
            ));
            $sql_update->closeCursor();

    

ob_end_flush();
?>