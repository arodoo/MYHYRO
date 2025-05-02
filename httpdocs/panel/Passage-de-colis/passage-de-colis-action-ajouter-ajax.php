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

$names = $_POST['names'] ;
$descriptions = $_POST['descriptions'] ;
$categories = $_POST['categories'] ;
$prices = $_POST['prices'] ;
$quantities = $_POST['quantities'] ;
$totalTTC = $_POST['totalTTC'] ;
$comment = $_POST['comment'];


if (isset($user)) {
    $ok_categories = true;
    for ($i = 0; $i < count($categories); $i++) {
        if($categories[$i] == ""){
            $ok_categories = false;
        }
    }
    if($ok_categories){
        //ALL CATEGORIES ARE OK
        $ok_names = true;
        for($i = 0; $i < count($names); $i++){
            if($names[$i] == ""){
                $ok_names = false;
            }
        }
        if($ok_names){
            $ok_quantity = true;
            for ($i = 0; $i < count($quantities); $i++){
                if($quantities[$i] < 1){
                    $ok_quantity = false;
                }
            }
            if($ok_quantity){
                $ok_price = true;
                for ($i = 0; $i < count($prices); $i++){
                    if($prices[$i] < 1){
                        $ok_price = false;
                    }
                }
    
                if($ok_price){
                    // ICI ON A :
                    /*
                        - LE COMMENTAIRE DU COLIS

                        Pour chaque article on a :
                        - LA CATEGORIE DE CHAQUE ARTICLE
                        - LA VALEUR DE L'ARTICLE
                        - LA QUANTITE DE L'ARTICLE
                        - LE NOM DE L'ARTICLE
                        - LE TYPE DE VALEUR DE L'ARTICLE
                        - LA DESCRIPTION DE L'ARTICLE

                        Pour le colis on doit :
                        - CALCULER LE PRIX TOTAL
                        - COMPARER AVEC LE PRIX DONNE VIA FRONT
                    */

                    $totalEu = 0;
                    $totalFcfa = 0;
                    for($i=0; $i < count($prices); $i++){
                        //var_dump($categories[$i]);
                        //categorie
                        $req_select = $bdd->prepare("SELECT * FROM categories WHERE nom_categorie=?");
                        $req_select->execute(array(
                            $categories[$i]
                        ));
                        $categorie = $req_select->fetch();
                        $req_select->closeCursor();

                        $total_i = $prices[$i]*$quantities[$i]; //Valeur totale de l'article
                        
                        if($categorie['type'] == "1"){
                            //Prix au kg
                            $totalEu += floatval($total_i*$categorie['value']);
                        }else if($categorie['type'] == "2"){
                            //Prix en pourcentage
                            $totalEu += floatval($total_i*($categorie['value']/100));
                        }
                    }
                    $totalEu = round($totalEu,2);
                    $totalFcfa = round($totalEu/0.00152449);
                    
                    if($totalFcfa == $totalTTC){
                        //Le contrôle des prix est bon
                        $now = time();
                        // Ajout en BDD dans membres_colis
                        $sql_insert = $bdd->prepare("INSERT INTO membres_colis
                        (comment,
                        user_id,
                        statut,
                        prix_total,
                        created_at,
                        updated_at)
                        VALUES (?,?,?,?,?,?)");
                        $sql_insert->execute(array(
                            $comment,
                            $id_oo,
                            htmlspecialchars("1"),
                            htmlspecialchars(strval($totalFcfa)),
                            $now,
                            $now
                        ));
                        $sql_insert->closeCursor();

                        $sql_select = $bdd->prepare("SELECT * FROM membres_colis WHERE user_id=? AND created_at=? AND updated_at=?");
                        $sql_select->execute(array(
                            $id_oo,
                            $now,
                            $now
                        ));
                        $colis = $sql_select->fetch();
                        $sql_select->closeCursor();

                        // Ajout en BDD des articles
                        for($i=0; $i < count($prices); $i++){
                            $req_select = $bdd->prepare("SELECT * FROM categories WHERE nom_categorie=?");
                            $req_select->execute(array(
                                $categories[$i]
                            ));
                            $categorie = $req_select->fetch();
                            $req_select->closeCursor();

                            $sql_insert = $bdd->prepare("INSERT INTO membres_colis_details
                            (colis_id,
                            nom,
                            description,
                            categorie,
                            quantite,
                            type_value,
                            value)
                            VALUES (?,?,?,?,?,?,?)");

                            $sql_insert->execute(array(
                                htmlspecialchars($colis['id']),
                                htmlspecialchars($names[$i]),
                                htmlspecialchars($descriptions[$i]),
                                htmlspecialchars($categories[$i]),
                                htmlspecialchars($quantities[$i]),
                                htmlspecialchars($categorie['type']),
                                htmlspecialchars($prices[$i])
                            ));
                            $sql_insert->closeCursor();
                        }

                        $result = array("Texte_rapport" => "Colis ajouté", "retour_validation" => "ok", "retour_lien" => "/Mes-colis");
                    }else{
                        $result = array("Texte_rapport" => "Erreur !", "retour_validation" => "non", "retour_lien" => "");
                    }
                }else{
                    $result = array("Texte_rapport" => "Prix supérieur ou égale à 1 obligatoire", "retour_validation" => "non", "retour_lien" => "");
                }
            }else{
                $result = array("Texte_rapport" => "Quantité supérieur ou égale à 1 obligatoire", "retour_validation" => "non", "retour_lien" => "");
            } 
        }else{
            $result = array("Texte_rapport" => "Nom obligatoire", "retour_validation" => "non", "retour_lien" => "");
        }
    }else{
        //PAS OK
        $result = array("Texte_rapport" => "Catégorie obligatoire", "retour_validation" => "non", "retour_lien" => "");
    }
    $result = json_encode($result);
    echo $result;
} else {
    $result = json_encode(array("Texte_rapport" => "Accès interdit", "retour_validation" => "non", "retour_lien" => "/"));
    echo $result;
}

ob_end_flush();
?>