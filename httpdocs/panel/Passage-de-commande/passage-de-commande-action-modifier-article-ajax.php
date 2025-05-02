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
$color = $_POST['color'];
$size = $_POST['size'];
$url = $_POST['url'];
$categorie = $_POST['categorie'];
$price = $_POST['price'];
$quantitie = $_POST['quantitie'];
$idArticle = $_POST['id'];
$id = $_SESSION['id_commande'];

if(filter_var($url, FILTER_VALIDATE_URL)){
    if($quantitie > 0){
        if($categorie != ""){
            if($price > 0){
                //update article

                $sql_select = $bdd->prepare("SELECT * FROM membres_commandes_details WHERE id=?");
                $sql_select->execute(array(intval($idArticle)));
                $article = $sql_select->fetch();
                $sql_select->closeCursor();

                $sql_select = $bdd->prepare("SELECT * FROM membres_panier_details WHERE id_commande_detail=?");
                $sql_select->execute(array(intval($idArticle)));
                $article_pan = $sql_select->fetch();
                $sql_select->closeCursor();
                

                if($article['valide'] == "true"){
                    $sql_update = $bdd->prepare("UPDATE membres_commandes_details SET couleur=?,taille=?,quantite=? WHERE id=?");
                    $sql_update->execute(array(
                        htmlspecialchars($color),
                        htmlspecialchars($size),
                        htmlspecialchars($quantitie),
                        intval($idArticle)
                    ));
                    $sql_update->closeCursor();
                }else{
                    $sql_update = $bdd->prepare("UPDATE membres_commandes_details SET url=?,categorie=?,quantite=?,couleur=?,taille=?,prix=? WHERE id=?");
                    $sql_update->execute(array(
                        htmlspecialchars($url),
                        htmlspecialchars($categorie),
                        htmlspecialchars($quantitie),
                        htmlspecialchars($color),
                        htmlspecialchars($size),
                        htmlspecialchars($price),
                        intval($idArticle)
                    ));
                    $sql_update->closeCursor();
                }

            //$nart=$i+1;
		    	//$libelle = "Article $nart";

                /*$base_TVA = 20;
                $PU_HT = (100*intval($price))/(100+$base_TVA);
                $TVA = $price - $PU_HT;*/
                $PU_HT = round($price);
                if($article_pan['action_module_service_produit'] == "Commande boutique"){
                $sql_update = $bdd->prepare("UPDATE membres_panier_details SET quantite=? WHERE id_commande_detail=?");
                $sql_update->execute(array(
                    htmlspecialchars($quantitie),
                    intval($idArticle)
                ));
                $sql_update->closeCursor();
                }else{
                    $sql_update = $bdd->prepare("UPDATE membres_panier_details SET PU_HT=?, TVA=?, categorie=?,quantite=? WHERE id_commande_detail=?");
                    $sql_update->execute(array(
                        htmlspecialchars(strval(round($PU_HT,2))),
                        htmlspecialchars(strval(round($TVA,2))),
                        htmlspecialchars($categorie),
                        htmlspecialchars($quantitie),
                        intval($idArticle)
                    ));
                    $sql_update->closeCursor();
                }

                $update = update_commande($id);
                
                if($update){
                    $result = json_encode(array("Texte_rapport" => "Article modifié !", "retour_validation" => "ok", "retour_lien" => ""));
                    echo $result;
                }else{
                    $result = json_encode(array("Texte_rapport" => "Erreur !", "retour_validation" => "non", "retour_lien" => ""));
                    echo $result;
                }
                
            }else{
                $result = json_encode(array("Texte_rapport" => "Prix supérieur ou égale à 1 obligatoire", "retour_validation" => "non", "retour_lien" => ""));
                echo $result;
            }
        }else{
            $result = json_encode(array("Texte_rapport" => "Catégorie obligatoire !", "retour_validation" => "non", "retour_lien" => ""));
            echo $result;   
        }
    }else{
        $result = json_encode(array("Texte_rapport" => "Quantité supérieur ou égale à 1 obligatoire !", "retour_validation" => "non", "retour_lien" => ""));
        echo $result;   
    }
}else{
$result = json_encode(array("Texte_rapport" => "Url obligatoire !", "retour_validation" => "non", "retour_lien" => ""));
echo $result;
}