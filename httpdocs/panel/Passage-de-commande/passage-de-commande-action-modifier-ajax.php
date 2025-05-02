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

$colors = $_POST['colors'] ;
$sizes = $_POST['sizes'] ;
$urls = $_POST['urls'] ;
$categories = $_POST['categories'] ;
$prices = $_POST['prices'] ;
$quantities = $_POST['quantities'] ;
$totalTTC = $_POST['totalTTC'] ;
$ids = $_POST['ids'];
$comment = $_POST['comment'];
$id = $_SESSION['id_commande'];
$type = $_POST['type'];

//var_dump($ids);

$ok_urls = true;
for ($i = 0; $i < count($urls); $i++) {
    if($urls[$i] == ""){
        $ok_urls = false;
    }else if(filter_var($urls[$i], FILTER_VALIDATE_URL) == false){
        $ok_urls = false;
    }
}
if($ok_urls){
    //ALL URL ARE OK
    $ok_quantity = true;
    for ($i = 0; $i < count($quantities); $i++){
        if($quantities[$i] < 1){
            $ok_quantity = false;
        }
    }
    if($ok_quantity){
        $ok_category = true;
        for ($i = 0; $i < count($categories); $i++){
            if($categories[$i] == ""){
                $ok_category = false;
            }
        }
        if($ok_category){
            $ok_price = true;
            for ($i = 0; $i < count($prices); $i++){
                if($prices[$i] < 1){
                    $ok_price = false;
                }
            }

            if($ok_price){
                if(isset($id)){
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
        
                    $tarif_TTC = 0;
                    $tarif_ss_total = 0;
    
                    //Ajout du prix de chaque article avec le pourcentage de la catégorie
                    for($i=0; $i < count($prices); $i++){

                        $PU_TTC = $prices[$i];

			/*
                        $req_select = $bdd->prepare("SELECT * FROM categories WHERE nom_categorie=?");
                        $req_select->execute(array(
                            $categories[$i]
                        ));
                        $categorie = $req_select->fetch();
                        $req_select->closeCursor();
                        $pourcentage = 1 + $categorie['value_commande']/100;
			*/

                        $tarif_ss_total += round($PU_TTC*$quantities[$i]);
                        $tarif_TTC += $PU_TTC*$quantities[$i]; //*$pourcentage

                    }

                    //$tarif_TTC += intval($abonnement['Frais_de_gestion_d_une_commande']);
                    
                    $tarif_TTC = round($tarif_TTC);
    
                    /*$base_TVA = 20;
                    $tarif_HT = (100*intval($tarif_TTC))/(100+$base_TVA);
                    $tarif_HT = round($tarif_HT,2);
                    $tarif_HT_net = (100*intval($tarif_TTC))/(100+$base_TVA);
                    $tarif_HT_net = round($tarif_HT_net,2);
                    $Total_TVA = $tarif_TTC - $tarif_HT;*/
                    $time = strval(time());
    
                    //Suppression des infos en BDD
                    $sql_select = $bdd->prepare("SELECT * FROM membres_commandes WHERE id=?");
                    $sql_select->execute(array($id));
                    $commande = $sql_select->fetch();
                    $sql_select->closeCursor();

                    /*$sql_delete = $bdd->prepare("DELETE FROM membres_commandes_details WHERE commande_id=?");
                    $sql_delete->execute(array($commande['id']));
                    $sql_delete->closeCursor();

                    $sql_delete = $bdd->prepare("DELETE FROM membres_panier WHERE id=?");
                    $sql_delete->execute(array($commande['panier_id']));
                    $sql_delete->closeCursor();

                    $sql_delete = $bdd->prepare("DELETE FROM membres_panier_details WHERE numero_panier=?");
                    $sql_delete->execute(array($commande['panier_id']));
                    $sql_delete->closeCursor();

                    $sql_delete = $bdd->prepare("DELETE FROM membres_commandes WHERE id=?");
                    $sql_delete->execute(array($commande['id']));
                    $sql_delete->closeCursor();*/
                        
                    //AJOUTER UNE LIGNE DANS MEMBRES_PANIER_DETAIL

                    $sql_select = $bdd->prepare("SELECT * FROM membres_panier WHERE id_membre=?");
                    $sql_select->execute(array(
                        htmlspecialchars(strval($id_oo))
                    ));
                    $ligne_select = $sql_select->fetch();
                    $sql_select->closeCursor();
                    
                    /*//Ajout en BDD de la commande dans membres_commande
                    $sql_insert = $bdd->prepare("INSERT INTO membres_commandes
                        (type,
                        comment,
                        user_id,
                        statut,
                        sous_total,
                        prix_total,
                        panier_id,
                        created_at,
                        updated_at)
                        VALUES (?,?,?,?,?,?,?,?,?)");

                    $sql_insert->execute(array(
                        htmlspecialchars(2),
                        htmlspecialchars($comment),
                        htmlspecialchars($id_oo),
                        htmlspecialchars(3),
                        htmlspecialchars($tarif_ss_total),
                        htmlspecialchars($tarif_TTC),
                        htmlspecialchars($ligne_select['id']),
                        time(),
                        time()
                    ));
                    $sql_insert->closeCursor();*/

                    /*$sql_select = $bdd->prepare('SELECT * FROM membres_commandes WHERE panier_id=?');
                    $sql_select->execute(array(
                        htmlspecialchars($ligne_select['id'])
                    ));
                    $commande = $sql_select->fetch();
                    $sql_select->closeCursor();*/
   
                    //Ajout en BDD de tous les articles liés à la commande
                    for($i = 0; $i < count($prices); $i++){

                        //Suppression des infos en BDD
                    $sql_select = $bdd->prepare("SELECT * FROM membres_commandes_details WHERE id=? and commande_id=?");
                    $sql_select->execute(array($ids[$i], $commande['id']));
                    $commanded = $sql_select->fetch();
                    $sql_select->closeCursor();

                    if(empty($commanded['id'])){
                        $sql_insert = $bdd->prepare('INSERT INTO membres_commandes_details
                        (commande_id,
                        nom,
                        description,
                        url,
                        categorie,
                        quantite,
                        couleur,
                        taille,
                        prix)
                        VALUES (?,?,?,?,?,?,?,?,?)');
                        $sql_insert->execute(array(
                            htmlspecialchars($commande['id']),
                            htmlspecialchars($names[$i]),
                            htmlspecialchars(''),
                            htmlspecialchars($urls[$i]),
                            htmlspecialchars($categories[$i]),
                            htmlspecialchars($quantities[$i]),
                            htmlspecialchars($colors[$i]),
                            htmlspecialchars($sizes[$i]),
                            htmlspecialchars($prices[$i])
                        ));
                        $sql_insert->closeCursor();

                        $commande_detail = $bdd->lastInsertId();

            $nbart = $i + 1;
		    	$libelle = "Article $nbart";

                    /*$base_TVA = 20;
                    $PU_HT = (100*intval($prices[$i]))/(100+$base_TVA);
                    $PU_HT = round($PU_HT,2);
                    $TVA = $prices[$i] - $PU_HT;*/
                    $TVA = 0;
                    $PU_HT = round($prices[$i]);

                    $sql_insert = $bdd->prepare("INSERT INTO membres_panier_details
                    (id_membre,
                    pseudo,
                    numero_panier,
                    libelle,
                    PU_HT,
                    TVA,
                    TVA_TAUX,
                    quantite,
                    categorie,
                    action_module_service_produit,
                    date,
                    id_commande_detail)
                    VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
                    $sql_insert->execute(
                        array(
                            htmlspecialchars(strval($id_oo)),
                            htmlspecialchars(strval($user)),
                            htmlspecialchars(strval($ligne_select['id'])),
                            htmlspecialchars($libelle),
                            htmlspecialchars(strval(round($PU_HT))),
                            htmlspecialchars(strval(round($TVA))),
                            htmlspecialchars("1.18"),
                            htmlspecialchars($quantities[$i]),
                            htmlspecialchars($categories[$i]),
                            htmlspecialchars("Commande"),
                            htmlspecialchars($time),
                            $commande_detail
                        )
                    );
                    $sql_insert->closeCursor();

                    }else{
                        $TVA = 0;
                    $PU_HT = round($prices[$i]);
                        $sql_update = $bdd->prepare("UPDATE membres_commandes_details SET url=?,categorie=?,quantite=?,couleur=?,taille=?,prix=? WHERE id=?");
                        $sql_update->execute(array(
                            htmlspecialchars($urls[$i]),
                            htmlspecialchars($categories[$i]),
                            htmlspecialchars($quantities[$i]),
                            htmlspecialchars($colors[$i]),
                            htmlspecialchars($sizes[$i]),
                            htmlspecialchars($prices[$i]),
                            intval($commanded['id'])
                        ));
                        $sql_update->closeCursor();


                        $sql_update = $bdd->prepare("UPDATE membres_panier_details SET PU_HT=?, TVA=?, categorie=?,quantite=? WHERE id_commande_detail=?");
                    $sql_update->execute(array(
                        htmlspecialchars(strval(round($PU_HT))),
                        htmlspecialchars(strval(round($TVA))),
                        htmlspecialchars($categories[$i]),
                        htmlspecialchars($quantities[$i]),
                        intval($commanded['id'])
                    ));
                    $sql_update->closeCursor();
                    }
                   

                    $update = update_commande($id);
			//ajout_panier($libelle, $quantities[$i], $PU_HT, $TVA, "1.18", "Commande", "", $libelle_id_article, $user,$categories[$i],$lastInsertId,$time);		

                    }

                    $_SESSION['id_commande'] = $commande['id'];
                    if($type == 1){
                        $_SESSION['action'] = "Modifier";
                        $result = array("Texte_rapport" => "", "retour_validation" => "ok", "retour_lien" => "/Passage-de-commande");

                    }else if($type == 2){
                        $_SESSION['action'] = "Recap";
                        $result = array("Texte_rapport" => "", "retour_validation" => "ok", "retour_lien" => "/Recapitulatif-Panier");
                    }
                }else{
                    $result = array("Texte_rapport" => "Erreur !", "retour_validation" => "non", "retour_lien" => "");
                }
            }else{
                $result = array("Texte_rapport" => "Prix supérieur ou égale à 1 obligatoire", "retour_validation" => "non", "retour_lien" => "");
            }
        }else{
            $result = array("Texte_rapport" => "Catégorie incorrecte !", "retour_validation" => "non", "retour_lien" => "");
        }
    }else{
        $result = array("Texte_rapport" => "Quantité supérieur ou égale à 1 obligatoire", "retour_validation" => "non", "retour_lien" => "");
    }
}else{
    $result = array("Texte_rapport" => "Url obligatoire", "retour_validation" => "non", "retour_lien" => "");
}
$result = json_encode($result);
echo $result;

ob_end_flush();
?>