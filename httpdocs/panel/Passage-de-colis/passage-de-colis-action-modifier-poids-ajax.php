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
$poids = floatval($_POST['poids']);

if(empty($user) && empty($id_oo) && !empty($_SESSION['id_ext'])){
    $id_oo = $_SESSION['id_ext'].'ext';
}

    $sql_select = $bdd->prepare('SELECT * FROM membres_colis WHERE user_id=? AND statut=1');
    $sql_select->execute(array($id_oo));
    $colis = $sql_select->fetch();
    $sql_select->closeCursor();

    if(!empty($colis['id'])){

        $sql_update = $bdd->prepare("UPDATE membres_colis SET
        poids=?
        WHERE id=?");

            $sql_update->execute(array(
                $poids,
                $colis['id']
            ));
            $sql_update->closeCursor();

    }else{

        $sql_insert = $bdd->prepare("INSERT INTO membres_colis
                    (comment,
                    user_id,
                    statut,
                    prix_total,
                    created_at,
                    updated_at,
                    poids)
                    VALUES (?,?,?,?,?,?,?)");
                    $sql_insert->execute(array(
                        $comment,
                        $id_oo,
                        htmlspecialchars("1"),
                        htmlspecialchars(strval($totalFcfa)),
                        $now,
                        $now,
                        $poids
                    ));
        $sql_insert->closeCursor();
        $id_colis = $bdd->lastInsertId();
        $_SESSION['id_colis'] = $id_colis;

        if(empty($user) && empty($id_oo)){
            $_SESSION['id_ext'] = $_SESSION['id_colis'];
            $id_oo = $_SESSION['id_ext'].'ext';
            ///////////////////////////////UPDATE
    $sql_update = $bdd->prepare("UPDATE membres_colis SET
    user_id=? 
    WHERE id=?");
$sql_update->execute(array(
    $id_oo,
    $idColis));                    
$sql_update->closeCursor();
        }

    }

ob_end_flush();
?>