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

        $sous_total_reel = 0;
        $req_boucle = $bdd->prepare("SELECT * FROM membres_commandes_details WHERE commande_id=? AND (annule != 'oui' OR annule is null) AND (disponibilite != 'Non disponible' OR disponibilite is null) ORDER BY id DESC");
        $req_boucle->execute(array($id));
        while ($ligne_boucle = $req_boucle->fetch()) {

            if(!empty($ligne_boucle['prix_reel'])){
                $prix_reel = round($ligne_boucle['prix_reel'] * 0.00152449, 2) * $ligne_boucle['quantite'];
            }else{
                $prix_reel = round($ligne_boucle['prix'] * 0.00152449, 2) * $ligne_boucle['quantite'];
            }

            $sous_total_reel = $sous_total_reel + $prix_reel;
            //var_dump($sous_total_reel);
        }
        $req_boucle->closeCursor();

        $sous_total_reel = round($sous_total_reel / 0.00152449);

        $req_select = $bdd->prepare("SELECT * FROM membres_commandes WHERE id=?");
        $req_select->execute(array($id));
        $ligne_select2 = $req_select->fetch();
        $req_select->closeCursor();

        if(!empty($ligne_select2['prix_total_reel'])){
            $prix_total = $ligne_select2['prix_total_reel'];
        }else{
            $prix_total = $ligne_select2['prix_total'];
        }

        if(!empty($ligne_select2['sous_total_reel'])){
            $sous_total = $ligne_select2['sous_total_reel'];
        }else{
            $sous_total = $ligne_select2['sous_total'];
        }

        $prix_total_reel = ($prix_total - $sous_total) + $sous_total_reel;

        

        $sql_update = $bdd->prepare("UPDATE membres_commandes SET
        sous_total_reel = ?,
        prix_total_reel = ?
        WHERE id=?");

        $sql_update->execute(
            array(
                $sous_total_reel,
                $prix_total_reel,
                intval($id)
            )
        );
        $sql_update->closeCursor();

        $result = array("Texte_rapport" => "Modifié!", "retour_validation" => "ok", "retour_lien" => "");
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