<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../../Configurations_bdd.php');
require_once('../../../Configurations.php');
require_once('../../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction = "../../../";
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
$action = $_POST['action'];
$name = $_POST['name'];
$desc = $_POST['desc'];
$url = $_POST['url'];
$category = $_POST['category'];
$quantity = $_POST['quantity'];
$color = $_POST['color'];
$size = $_POST['size'];
$price = $_POST['price'];
$type = $_POST['type'];

if (isset($user)) {
    if(isset($id)){
        if(isset($name)){
            if(isset($url)){
                if(isset($price)){
                    if($price >= 1){
                        if(isset($type)){
                            if($action == "ajouter"){
                                $sql_insert = $bdd->prepare("INSERT INTO membres_souhait_details
                                (liste_id,
                                nom,
                                description,
                                url,
                                categorie,
                                quantite,
                                couleur,
                                taille,
                                prix,
                                type)
                                VALUES (?,?,?,?,?,?,?,?,?,?)");
    
                                $sql_insert->execute(
                                    array(
                                        intval($id),
                                        htmlspecialchars($name),
                                        htmlspecialchars($desc),
                                        htmlspecialchars($url),
                                        htmlspecialchars($category),
                                        htmlspecialchars($quantity),
                                        htmlspecialchars($color),
                                        htmlspecialchars($size),
                                        htmlspecialchars($price),
                                        htmlspecialchars($type)
                                    )
                                );
                                $sql_insert->closeCursor();
                            }else if($action == "modifier"){
                                $sql_update = $bdd->prepare("UPDATE membres_souhait_details SET
                                nom=?,
                                description=?,
                                url=?,
                                categorie=?,
                                quantite=?,
                                couleur=?,
                                taille=?,
                                prix=?,
                                type=?
                                WHERE id=?");

                                $sql_update->execute(
                                    array(
                                        htmlspecialchars($name),
                                        htmlspecialchars($desc),
                                        htmlspecialchars($url),
                                        htmlspecialchars($category),
                                        htmlspecialchars($quantity),
                                        htmlspecialchars($color),
                                        htmlspecialchars($size),
                                        htmlspecialchars($price),
                                        htmlspecialchars($type),
                                        intval($id)
                                    )
                                );
                                $sql_update->closeCursor();
                            }

                            $result = array("Texte_rapport" => "Article ajouté !", "retour_validation" => "ok", "retour_lien" => "");
                        }else{
                            $result = array("Texte_rapport" => "Type obligatoire", "retour_validation" => "non", "retour_lien" => "");
                        }
                    }else{
                        $result = array("Texte_rapport" => "Le prix doit être supérieur à 1€", "retour_validation" => "non", "retour_lien" => "");
                    }
                }else{
                    $result = array("Texte_rapport" => "Prix obligatoire", "retour_validation" => "non", "retour_lien" => "");
                }
            }else{
                $result = array("Texte_rapport" => "Url obligatoire", "retour_validation" => "non", "retour_lien" => "");
            }
        }else{
            $result = array("Texte_rapport" => "Nom obligatoire", "retour_validation" => "non", "retour_lien" => "");
        }
    }else{
        $result = array("Texte_rapport" => "Erreur interne", "retour_validation" => "non", "retour_lien" => "");
    }
    
    $result = json_encode($result);
    echo $result;
} else {
    header('location: /index.html');
}

ob_end_flush();
?>