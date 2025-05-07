<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../../Configurations_bdd.php');
require_once('../../../Configurations.php');
require_once('../../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction= "../../../";
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
$regul = $_POST['nb'];
$idMembre = $_POST['idMembre'];
$action = $_POST['action'];

if (isset($user)) {
    if(isset($id) && isset($regul) && isset($idMembre) && isset($action)){
        $now = time();

        if($action == "add"){
          $sql_insert = $bdd->prepare("INSERT INTO membres_regulation
          (id_membre,
          type_regulation,
          id_commande,
          prix,
          created_at,
          updated_at)
          VALUE (?,?,?,?,?,?)");
  
          $sql_insert->execute(
              array(
                  htmlspecialchars($idMembre),
                  htmlspecialchars("1"),
                  htmlspecialchars($id),
                  htmlspecialchars($regul),
                  $now,
                  $now
              )
          );
          $sql_insert->closeCursor();
  
          $sql_select = $bdd->prepare("SELECT * FROM membres_regulation WHERE id_membre=? AND id_commande=?");
          $sql_select->execute(array(htmlspecialchars($idMembre), htmlspecialchars($id)));
          $regulation = $sql_select->fetch();
          $sql_select->closeCursor();
  
          $sql_update = $bdd->prepare("UPDATE membres_commandes SET
          statut=?,
          id_regulation=?
          WHERE id=?");
  
          $sql_update->execute(
              array(
                  htmlspecialchars("5"),
                  htmlspecialchars($regulation['id']),
                  intval($id)
              )
          );
          $sql_update->closeCursor();
          
          $result = array("Texte_rapport" => "Régulation envoyé !", "retour_validation" => "ok", "retour_lien" => "");
        }else if($action == "update"){
          $sql_update = $bdd->prepare("UPDATE membres_regulation SET
          prix=?
          WHERE id=?");
  
          $sql_update->execute(
              array(
                  htmlspecialchars($regul),
                  htmlspecialchars($_POST['idRegul'])
              )
          );
          $sql_update->closeCursor();

          $result = array("Texte_rapport" => "Régulation modifiée !", "retour_validation" => "ok", "retour_lien" => "");
        }
        

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