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

$names = $_POST['names'];
$id = $_POST['id'];
$descs = $_POST['descriptions'];
$options = $_POST['options'];
$categories = $_POST['categories'];
$quantities = $_POST['quantities'];
$comment = $_POST['comment'];

if (isset($user)) {
    $ok_names_descs = true;
    for($i=0; $i < count($names); $i++){
        if($names[$i] == ""){
            $ok_names_descs = false;
        }
        if($descs[$i] == ""){
            $ok_names_descs = false;
        }
    }


    if($ok_names_descs){
        //OK
        $ok_quantities = true;
        for($i=0; $i < count($quantities); $i++){
            if($quantities[$i] < 1){
                $ok_quantities = false;
            }
        }

        if($ok_quantities){
            
            $now = time();
            $sql_update = $bdd->prepare("UPDATE membres_commandes SET
            comment=?,
            statut=?,
            updated_at=?,
		liste_souhait=?
            WHERE id=?");

            $sql_update->execute(
                array(
                        htmlspecialchars($comment),
                        htmlspecialchars(1),
                        $now,
                        $id,
			"oui"
                )
            );
            $sql_update->closeCursor();

            $sql_delete = $bdd->prepare("DELETE FROM membres_commandes_details WHERE commande_id=?");
            $sql_delete->execute(array(htmlspecialchars($id)));
            $sql_delete->closeCursor();
            for($i=0; $i < count($names); $i++){
                $sql_insert = $bdd->prepare("INSERT INTO membres_commandes_details
                (commande_id,
                nom,
                description,
                categorie,
                quantite,
                options,
		liste_souhait)
                VALUES (?,?,?,?,?,?,?)");
                
                $sql_insert->execute(array(
                    htmlspecialchars($id),
                    htmlspecialchars($names[$i]),
                    htmlspecialchars($descs[$i]),
                    htmlspecialchars($categories[$i]),
                    htmlspecialchars($quantities[$i]),
                    htmlspecialchars($options[$i]),
			"oui"
                ));
                $sql_insert->closeCursor();
            }

            $result = array("Texte_rapport" => "Liste de souhait modifée ", "retour_validation" => "ok", "retour_lien" => "");
        }else{
            $result = array("Texte_rapport" => "Quantité supérieur ou égale à 1 obligatoire", "retour_validation" => "non", "retour_lien" => "");
        }
    }else{
        //PAS OK
        if(count($names) == 1){
            $result = array("Texte_rapport" => "Nom et description obligatoire", "retour_validation" => "non", "retour_lien" => "");
        }else{
            $result = array("Texte_rapport" => "Noms et descriptions obligatoire", "retour_validation" => "non", "retour_lien" => "");
        }
    }
    
    $result = json_encode($result);
    echo $result;
} else {
    header('location: /index.html');
}

ob_end_flush();
?>