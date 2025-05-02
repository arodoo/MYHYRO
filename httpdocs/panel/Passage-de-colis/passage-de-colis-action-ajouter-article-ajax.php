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
$idColis = $_SESSION['id_colis'];
if(empty($user) && empty($id_oo) && !empty($_SESSION['id_ext'])){
    $id_oo = $_SESSION['id_ext'].'ext';
}
$names = $_POST['names'] ;
$descriptions = $_POST['descriptions'] ;
$categories = $_POST['categories'] ;
$prices = $_POST['prices'] ;
$pricesF = $_POST['pricesF'] ;
$quantities = $_POST['quantities'] ;
$totalTTC = $_POST['totalTTC'] ;
$comment = $_POST['comment'];
$id_colis_detail = $_POST['id_colis_detail'];
$poids = $_POST['poids'];

//$id_colis = $_SESSION['id_colis'];
$now = time();

    $ok_categories = true;
    if($categories == ""){
        $ok_categories = false;
    }
    if($ok_categories){
        //ALL CATEGORIES ARE OK
        $ok_names = true;
        if($names == ""){
            $ok_names = false;
        }
        if($ok_names){
            $ok_quantity = true;
            if($quantities < 1){
                $ok_quantity = false;
            }
            if($ok_quantity){
                $ok_price = true;
                $req_select = $bdd->prepare("SELECT * FROM categories WHERE nom_categorie=?");
                $req_select->execute(array(
                    $categories
                ));
                $categorie = $req_select->fetch();
                $req_select->closeCursor();

                if($categorie["type"] == "2"){
                if($prices[$i] < 1){
                    $ok_price = false;
                }
                }
                if($ok_price){
                    if(!empty($poids) && $poids != 0){
                    $req_select = $bdd->prepare("SELECT * FROM categories WHERE nom_categorie=?");
                    $req_select->execute(array(
                        $categories
                    ));
                    $categorie = $req_select->fetch();
                    $req_select->closeCursor();

                    if(empty($idColis)){
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

                        $idColis = $bdd->lastInsertId();
                        $_SESSION['id_colis'] = $idColis;

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

                    if(empty($id_colis_detail)){

                        $sql_update = $bdd->prepare("UPDATE membres_colis SET
                    created_at=? 
                    WHERE id=?");
                $sql_update->execute(array(
                    time(),
                    $idColis));                    
                $sql_update->closeCursor();

                        //Ajouter l'article
                    $req_insert = $bdd->prepare("INSERT INTO membres_colis_details
                    (colis_id,
                    nom,
                    description,
                    categorie,
                    quantite,
                    type_value,
                    value,
                    prix)
                    VALUES (?,?,?,?,?,?,?,?)");
                    
                    $req_insert->execute(array(
                        htmlspecialchars($idColis),
                        htmlspecialchars($names),
                        htmlspecialchars($descriptions),
                        htmlspecialchars($categories),
                        htmlspecialchars($quantities),
                        htmlspecialchars($categorie["type"]),
                        htmlspecialchars($prices),
                        htmlspecialchars($pricesF)
                    ));
                    $req_insert->closeCursor();



                    $result = array("Texte_rapport" => "Article ajouté !", "retour_validation" => "ok", "retour_lien" => "/Recapitulatif");
                    }else{
                        $sql_update = $bdd->prepare("UPDATE membres_colis_details SET
                    nom=?,
                    description=?,
                    categorie=?,
                    quantite=?,
                    type_value=?,
                    value=?,
                    prix=?
                        WHERE id=?");

                        $sql_update->execute(array(
                            htmlspecialchars($names),
                            htmlspecialchars($descriptions),
                            htmlspecialchars($categories),
                            htmlspecialchars($quantities),
                            htmlspecialchars($categorie["type"]),
                            htmlspecialchars($prices),
                            round($pricesF, 0),
                            $id_colis_detail
                        ));
                        $sql_update->closeCursor();
                        $result = array("Texte_rapport" => "Article modifié !", "retour_validation" => "ok", "retour_lien" => "/Recapitulatif");
                    }
                    

                    /*//Mettre à jour le prix du colis
                    $select_bql = $bdd->prepare("SELECT * FROM membres_colis_details WHERE colis_id=?");
                    $select_bql->execute(array($idColis));
                    $articles = $select_bql->fetch();
                    $select_bql->closeCursor();*/

                    $totalEu = 0;
                    $totalFcfa = $totalTTC;
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

                    $totalEu = round($totalEu,2);
                    $totalFcfa = round($totalEu/0.00152449);*/

                    //if($totalFcfa == $totalTTC){

                    //Mettre à jour le prix du colis
                    $select_bql = $bdd->prepare("SELECT * FROM membres_panier WHERE id_membre=?");
                    $select_bql->execute(array($id_oo));
                    $select_pan = $select_bql->fetch();
                    $select_bql->closeCursor();

                    if(!empty($select_pan['id'])){
                        $id_panier = $select_pan['id'];
                    }else{
                        $sql_insert = $bdd->prepare("INSERT INTO membres_panier
                        (id_membre,
                        pseudo,
                        Contenu,
                        Titre_panier,
                        Suivi,
                        date_edition,
                        Tarif_HT,
                        Tarif_HT_net,
                        Tarif_TTC,
                        Total_Tva,
                        taux_tva)
                        VALUES (?,?,?,?,?,?,?,?,?,?,?)");
                    
                        $sql_insert->execute(
                            array(
                                htmlspecialchars(strval($id_oo)),
                                $user,
                                htmlspecialchars("Commande"),
                                htmlspecialchars("Commande"),
                                htmlspecialchars("non traite"),
                                htmlspecialchars($time),
                                htmlspecialchars(strval(round($tarif_HT))),
                                htmlspecialchars(strval(round($tarif_HT_net))),
                                htmlspecialchars(strval(round($tarif_TTC))),
                                htmlspecialchars(strval(round($Total_TVA))),
                                htmlspecialchars("1.18")
                            )
                        );
                        $sql_insert->closeCursor();

                        $id_panier = $bdd->lastInsertId();
                    }

                    $select_bql = $bdd->prepare("SELECT * FROM membres_panier_details WHERE id_membre=? AND id_colis_detail=?");
                    $select_bql->execute(array($id_oo, $idColis));
                    $select_pan_d = $select_bql->fetch();
                    $select_bql->closeCursor();

                    $PU_HT = 0;

                    if(empty($select_pan_d['id'])){
                        $libelle = "Colis 1";
                        $sql_insert = $bdd->prepare("INSERT INTO membres_panier_details
                        (id_membre,
                        pseudo,
                        numero_panier,
                        libelle,
                        PU_HT,
                        TVA,
                        TVA_TAUX,
                        quantite,
                        action_module_service_produit,
                        date,
                        id_colis_detail)
                        VALUES (?,?,?,?,?,?,?,?,?,?,?)");
                        $sql_insert->execute(
                            array(
                                htmlspecialchars(strval($id_oo)),
                                htmlspecialchars(strval($user)),
                                htmlspecialchars(strval($id_panier)),
                                htmlspecialchars($libelle),
                                htmlspecialchars(strval(round($PU_HT))),
                                htmlspecialchars(strval(round($TVA))),
                                htmlspecialchars("1.18"),
                                htmlspecialchars($quantities),
                                htmlspecialchars("Commande colis"),
                                htmlspecialchars($time),
                                $idColis
                            )
                        );
                        $sql_insert->closeCursor();

                        $id_panier_d = $bdd->lastInsertId();

                        $select_bql = $bdd->prepare("SELECT * FROM membres_colis_details WHERE colis_id=?");
                        $select_bql->execute(array($idColis));
                        
                        while ($ligne_boucle = $select_bql->fetch()) {
                            $quanti += $ligne_boucle['quantite'];
                        }
                        $select_bql->closeCursor();

                        $sql_update = $bdd->prepare("UPDATE membres_panier_details SET
                        quantite=?,
                        TTC_colis=?
                        WHERE id=?");

                        $sql_update->execute(array(
                            $quanti,
                            $totalFcfa,
                            $id_panier_d
                        ));
                        $sql_update->closeCursor();
                    }else{
                        $select_bql = $bdd->prepare("SELECT * FROM membres_colis_details WHERE colis_id=?");
                        $select_bql->execute(array($idColis));

                        while ($ligne_boucle = $select_bql->fetch()) {
                            $quanti += $ligne_boucle['quantite'];
                        }
                        $select_bql->closeCursor();

                            $sql_update = $bdd->prepare("UPDATE membres_panier_details SET
                            quantite=?,
                            TTC_colis=?
                            WHERE id=?");
    
                            $sql_update->execute(array(
                                $quanti,
                                $totalFcfa,
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

                        $_SESSION['id_colis'] = $idColis;

                        

                        //$result = array("Texte_rapport" => "Article modifié !", "retour_validation" => "ok", "retour_lien" => "/Recapitulatif");
                    //}else{
                        //$result = array("Texte_rapport" => "Erreur !", "retour_validation" => "non", "retour_lien" => "");
                    //}
                    }else{
                        $result = array("Texte_rapport" => "Veuillez saisir un poids", "retour_validation" => "non", "retour_lien" => "");
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

ob_end_flush();
?>