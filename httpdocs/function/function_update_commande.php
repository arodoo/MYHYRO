<?php

/******************************************************\
* Adresse e-mail => direction@codi-one.fr              *
* La conception est assujettie à une autorisation      *
* spéciale de codi-one.com. Si vous ne disposez pas de *
* cette autorisation, vous êtes dans l'illégalité.     *
* L'auteur de la conception est et restera             *
* codi-one.fr                                          *
* Codage, script & images (all contenu) sont réalisés  * 
* par codi-one.fr                                      *
* La conception est à usage unique et privé.           *
* La tierce personne qui utilise le script se porte    *
* garante de disposer des autorisations nécessaires    *
*                                                      *
* Copyright ... Tous droits réservés auteur (Fabien B) *
\******************************************************/

function update_commande($idCommande){
	global $bdd;
	global $id_oo;
    global $user;

    $time = time();
    

    if(!empty($user)){
        $sql_select = $bdd->prepare("SELECT * FROM membres WHERE id=?");
        $sql_select->execute(array($id_oo));
        $membre = $sql_select->fetch();
        $sql_select->closeCursor();

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
    

    if($idCommande != ""){
        $sql_select = $bdd->prepare("SELECT * FROM membres_commandes WHERE id=?");
        $sql_select->execute(array($idCommande));
        $commande = $sql_select->fetch();
        $sql_select->closeCursor();

        if($commande){
            /*$sql_delete = $bdd->prepare("DELETE FROM membres_panier_details WHERE numero_panier=?");
            $sql_delete->execute(array($commande['panier_id']));
            $sql_delete->closeCursor();*/

            $sql_select = $bdd->prepare("SELECT * FROM membres_commandes_details WHERE commande_id=?");
            $sql_select->execute(array($idCommande));
            $articles = $sql_select->fetchAll();
            $sql_select->closeCursor();

            if(count($articles) > 0){
                $TTC = 0;
                $sous_total = 0;
                for($i = 0; $i < count($articles); $i++){
                    $PU_TTC = $articles[$i]['prix'];
                    $req_select = $bdd->prepare("SELECT * FROM categories WHERE nom_categorie=?");
                    $req_select->execute(array(
                        $articles[$i]['categorie']
                    ));
                    $categorie = $req_select->fetch();
                    $req_select->closeCursor();
                    $pourcentage = 1 + $categorie['value_commande']/100;

                    $sous_total += round($PU_TTC*$articles[$i]['quantite']);
                    $TTC += $PU_TTC*$pourcentage*$articles[$i]['quantite'];
                    $TTC = round($TTC,2);
                    $base_TVA = 20;
                    $PU_HT = (100*intval($PU_TTC))/(100+$base_TVA);
                    $PU_HT = round($PU_HT,2);

                    $TVA = $PU_TTC - $PU_HT;

                    //Recreation membres_panier_details
                    /*$sql_insert = $bdd->prepare("INSERT INTO membres_panier_details
                    (id_membre,
                    pseudo,
                    numero_panier,
                    PU_HT,
                    TVA,
                    TVA_TAUX,
                    quantite,
                    categorie,
                    action_module_service_produit
                    )
                    VALUES (?,?,?,?,?,?,?,?,?)");
                    $sql_insert->execute(array(
                        htmlspecialchars($id_oo),
                        htmlspecialchars($user),
                        htmlspecialchars($commande['panier_id']),
                        htmlspecialchars($PU_HT),
                        htmlspecialchars($TVA),
                        htmlspecialchars(1.20),
                        htmlspecialchars($articles[$i]['quantite']),
                        htmlspecialchars($articles[$i]['categorie']),
                        htmlspecialchars("Commande")
                    ));
                    $sql_insert->closeCursor();*/
                }

                $TTC += intval($abonnement['Frais_de_gestion_d_une_commande']);
                
                $TTC = round($TTC);

                $base_TVA = 20;
                $HT = (100*intval($TTC))/(100+$base_TVA);
                $HT = round($HT,2);
                $HT_NET = (100*intval($TTC))/(100+$base_TVA);
                $HT_NET = round($HT_NET,2);

                $time = strval(time());

                $HT = round($HT);
                $HT_NET = round($HT_NET);
                $Total_TVA = $TTC - $HT;

                //Update membres_commandes
                $sql_update = $bdd->prepare("UPDATE membres_commandes SET user_id=?,sous_total=?,prix_total=?,updated_at=? WHERE id=?");
                $sql_update->execute(array(
                    htmlspecialchars($id_oo),
                    htmlspecialchars($sous_total),
                    htmlspecialchars($TTC),
                    $time,
                    $commande['id']
                ));
                $sql_update->closeCursor();

                //Update membres_panier
                $sql_update = $bdd->prepare("UPDATE membres_panier SET Tarif_HT=?,Tarif_HT_net=?,Tarif_TTC=?,Total_TVA=? WHERE id=?");
                $sql_update->execute(array(
                    htmlspecialchars($HT),
                    htmlspecialchars($HT_NET),
                    htmlspecialchars($TTC),
                    htmlspecialchars($Total_TVA),
                    htmlspecialchars($commande['panier_id'])
                ));
                $sql_update->closeCursor();
                
            }else{
                //Update membres_commandes
                $sql_update = $bdd->prepare("UPDATE membres_commandes SET user_id=?,sous_total=?,prix_total=?,updated_at=? WHERE id=?");
                $sql_update->execute(array(
                    htmlspecialchars($id_oo),
                    htmlspecialchars('0'),
                    htmlspecialchars('0'),
                    $time,
                    $commande['id']
                ));
                $sql_update->closeCursor();

                //Update membres_panier
                $sql_update = $bdd->prepare("UPDATE membres_panier SET Tarif_HT=?,Tarif_HT_net=?,Tarif_TTC=?,Total_TVA=? WHERE id=?");
                $sql_update->execute(array(
                    htmlspecialchars('0'),
                    htmlspecialchars('0'),
                    htmlspecialchars('0'),
                    htmlspecialchars('0'),
                    htmlspecialchars($commande['panier_id'])
                ));
                $sql_update->closeCursor();
            }
        }else{
            return false;
        }
        return true;
    }else{
        return false;
    }
}

function update_colis($idColis){
	global $bdd;
	global $id_oo;
    global $user;

    
    

    if(!empty($user)){
        $sql_select = $bdd->prepare("SELECT * FROM membres WHERE id=?");
        $sql_select->execute(array($id_oo));
        $membre = $sql_select->fetch();
        $sql_select->closeCursor();

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
    

    if($idColis != ""){
        $sql_select = $bdd->prepare("SELECT * FROM membres_colis WHERE id=?");
        $sql_select->execute(array($idColis));
        $commande = $sql_select->fetch();
        $sql_select->closeCursor();

        if($commande){
            /*$sql_delete = $bdd->prepare("DELETE FROM membres_panier_details WHERE numero_panier=?");
            $sql_delete->execute(array($commande['panier_id']));
            $sql_delete->closeCursor();*/

            $sql_select = $bdd->prepare("SELECT * FROM membres_colis_details WHERE colis_id=?");
            $sql_select->execute(array($idColis));
            $articles = $sql_select->fetchAll();
            $sql_select->closeCursor();

            if(count($articles) > 0){
                $TTC = 0;
                $sous_total = 0;
                for($i = 0; $i < count($articles); $i++){
                    $PU_TTC = $articles[$i]['prix'];
                    $req_select = $bdd->prepare("SELECT * FROM categories WHERE nom_categorie=?");
                    $req_select->execute(array(
                        $articles[$i]['categorie']
                    ));
                    $categorie = $req_select->fetch();
                    $req_select->closeCursor();
                    $pourcentage = 1 + $categorie['value_commande']/100;

                    $sous_total += round($PU_TTC*$articles[$i]['quantite']);
                    $TTC += $PU_TTC*$pourcentage*$articles[$i]['quantite'];
                    $TTC = round($TTC,2);
                    $base_TVA = 20;
                    $PU_HT = (100*intval($PU_TTC))/(100+$base_TVA);
                    $PU_HT = round($PU_HT,2);

                    $TVA = $PU_TTC - $PU_HT;

                    //Recreation membres_panier_details
                    /*$sql_insert = $bdd->prepare("INSERT INTO membres_panier_details
                    (id_membre,
                    pseudo,
                    numero_panier,
                    PU_HT,
                    TVA,
                    TVA_TAUX,
                    quantite,
                    categorie,
                    action_module_service_produit
                    )
                    VALUES (?,?,?,?,?,?,?,?,?)");
                    $sql_insert->execute(array(
                        htmlspecialchars($id_oo),
                        htmlspecialchars($user),
                        htmlspecialchars($commande['panier_id']),
                        htmlspecialchars($PU_HT),
                        htmlspecialchars($TVA),
                        htmlspecialchars(1.20),
                        htmlspecialchars($articles[$i]['quantite']),
                        htmlspecialchars($articles[$i]['categorie']),
                        htmlspecialchars("Commande")
                    ));
                    $sql_insert->closeCursor();*/
                }

                $TTC += intval($abonnement['Frais_de_gestion_d_une_commande']);
                
                $TTC = round($TTC);

                $base_TVA = 20;
                $HT = (100*intval($TTC))/(100+$base_TVA);
                $HT = round($HT,2);
                $HT_NET = (100*intval($TTC))/(100+$base_TVA);
                $HT_NET = round($HT_NET,2);

                $time = strval(time());

                $HT = round($HT);
                $HT_NET = round($HT_NET);
                $Total_TVA = $TTC - $HT;

                //Update membres_commandes
                $sql_update = $bdd->prepare("UPDATE membres_colis SET user_id=?,sous_total=?,prix_total=?,updated_at=? WHERE id=?");
                $sql_update->execute(array(
                    htmlspecialchars($id_oo),
                    htmlspecialchars($sous_total),
                    htmlspecialchars($TTC),
                    $time,
                    $commande['id']
                ));
                $sql_update->closeCursor();

                //Update membres_panier
                /*$sql_update = $bdd->prepare("UPDATE membres_panier SET Tarif_HT=?,Tarif_HT_net=?,Tarif_TTC=?,Total_TVA=? WHERE id=?");
                $sql_update->execute(array(
                    htmlspecialchars($HT),
                    htmlspecialchars($HT_NET),
                    htmlspecialchars($TTC),
                    htmlspecialchars($Total_TVA),
                    htmlspecialchars($commande['panier_id'])
                ));
                $sql_update->closeCursor();*/
                
            }else{
                return false;
            }
        }else{
            return false;
        }
        return true;
    }else{
        return false;
    }
}