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

$idColis = $_POST['idColis'];
$idArticle = $_POST['idArticle'];
$totalTTC = $_POST['totalTTC'];


if(!empty($user)){
    $req_select = $bdd->prepare("SELECT * FROM membres WHERE id=?");
    $req_select->execute(array(
        $id_oo
    ));
    $membre = $req_select->fetch();
    $req_select->closeCursor();
    
    $req_select = $bdd->prepare("SELECT * FROM configurations_abonnements WHERE id=?");
    $req_select->execute(array(
        $membre['Abonnement_id']
    ));
    $abonnement = $req_select->fetch();
    $req_select->closeCursor();
}else{
    $req_select = $bdd->prepare("SELECT * FROM configurations_abonnements WHERE id=?");
    $req_select->execute(array(
        1
    ));
    $abonnement = $req_select->fetch();
    $req_select->closeCursor();
}


if(isset($idColis) && isset($idArticle)){
    $sql_delete = $bdd->prepare("DELETE FROM membres_colis_details WHERE id=?");
    $sql_delete->execute(array(
        $idArticle
    ));
    $sql_delete->closeCursor();

   $select_bql = $bdd->prepare("SELECT * FROM membres_colis_details WHERE colis_id=?");
                    $select_bql->execute(array($idColis));
                    $articles = $select_bql->fetchAll();
                    $select_bql->closeCursor();

                    $totalEu = 0;
                    $totalFcfa = 0;


                    if(!empty($articles)){
                        /*for($i=0; $i < count($articles); $i++){
                            //categorie
                            $req_select = $bdd->prepare("SELECT * FROM categories WHERE nom_categorie=?");
                            $req_select->execute(array(
                                $articles[$i]['categorie']
                            ));
                            $categorie = $req_select->fetch();
                            $req_select->closeCursor();
    
                            $total_i = $articles[$i]['value']*$articles[$i]['quantite']; //Valeur totale de l'article
                            
                            if($categorie['type'] == "1"){
                                //Prix au kg
                                $totalEu += floatval($total_i*$categorie['value']);
                            }else if($categorie['type'] == "2"){
                                //Prix en pourcentage
                                $totalEu += floatval($total_i*($categorie['value']/100));
                            }
                        }
    
                        //$totalEu = round($totalEu,2);
                        //$totalFcfa = round($totalEu/0.00152449);*/


                    }
                    $select_bql = $bdd->prepare("SELECT * FROM membres_panier_details WHERE id_membre=? AND id_colis_detail=?");
                    $select_bql->execute(array($id_oo, $idColis));
                    $select_pan_d = $select_bql->fetch();
                    $select_bql->closeCursor();

                    $select_bql = $bdd->prepare("SELECT * FROM membres_colis_details WHERE colis_id=?");
                        $select_bql->execute(array($idColis));
                        while ($ligne_boucle = $select_bql->fetch()) {
                            $quanti += $ligne_boucle['quantite'];
                        }
                        $select_bql->closeCursor();

                        if($quanti == 0){
                            $sql_delete = $bdd->prepare("DELETE FROM membres_panier_details WHERE id=?");
                            $sql_delete->execute(array(
                                $select_pan_d['id']
                            ));
                            $sql_delete->closeCursor();

                        }else{
                            $sql_update = $bdd->prepare("UPDATE membres_panier_details SET
                            quantite=?
                            WHERE id=?");
    
                            $sql_update->execute(array(
                                $quanti,
                                $select_pan_d['id']
                            ));
                            $sql_update->closeCursor();
                        }



                        $sql_update = $bdd->prepare("UPDATE membres_colis SET
                        prix_total=?,
                        updated_at=?
                        WHERE id=?");

                        $sql_update->execute(array(
                            htmlspecialchars(strval($totalFcfa)),
                            $now,
                            $idColis
                        ));
                        $sql_update->closeCursor();



                        $result = json_encode(array("Texte_rapport" => "Article supprimé !", "retour_validation" => "ok", "retour_lien" => ""));
                        //echo $result;
                    echo $result;
    
}else{
    $result = json_encode(array("Texte_rapport" => "Erreur !", "retour_validation" => "non", "retour_lien" => ""));
    echo $result;
}