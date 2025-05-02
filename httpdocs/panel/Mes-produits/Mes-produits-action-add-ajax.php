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

$id = $_POST['id'];
$id_commande = $_SESSION['id_commande'];

$time = time();

if (isset($user)) {
    $sql_select = $bdd->prepare("SELECT * FROM membres_souhait_details WHERE id=?");
    $sql_select->execute(array($id));
    $article = $sql_select->fetch();
    $sql_select->closeCursor();

    $sql_select = $bdd->prepare("SELECT * FROM membres_souhait WHERE id=?");
    $sql_select->execute(array($article['liste_id']));
    $lds = $sql_select->fetch();
    $sql_select->closeCursor();

    if($lds['user_id'] == $id_oo){
        $sql_select = $bdd->prepare("SELECT * FROM membres_commandes WHERE user_id=? AND statut=3");
        $sql_select->execute(array($id_oo));
        $commande = $sql_select->fetch();
        $sql_select->closeCursor();
        
        if(empty($id_commande)){
            //Calcul du sous total et du total
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

            $PU_TTC = $article['prix']; //FCFA
            $req_select = $bdd->prepare("SELECT * FROM categories WHERE nom_categorie=?");
            $req_select->execute(array(
                $article[$i]['categorie']
            ));
            $categorie = $req_select->fetch();
            $req_select->closeCursor();
            $pourcentage = 1 + $categorie['value_commande']/100;

            $tarif_ss_total += round($PU_TTC*$quantities[$i]);
            $tarif_TTC += $PU_TTC*$pourcentage*$quantities[$i]; // FCFA

            $tarif_TTC += intval($abonnement['Frais_de_gestion_d_une_commande']);
            $tarif_TTC += intval($abonnement['Liste_de_souhaits']);    

            $tarif_TTC = round($tarif_TTC);

            $base_TVA = 20;
            $tarif_HT = (100*intval($tarif_TTC))/(100+$base_TVA); // FCFA
            $tarif_HT_net = (100*intval($tarif_TTC))/(100+$base_TVA); // FCFA
            $Total_TVA = $tarif_TTC - $tarif_HT; // FCFA
            $time = strval(time());

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
                    htmlspecialchars(strval($membre['pseudo'])),
                    htmlspecialchars("Commande"),
                    htmlspecialchars("Commande"),
                    htmlspecialchars("non traite"),
                    htmlspecialchars($time),
                    htmlspecialchars(strval(round($tarif_HT))),
                    htmlspecialchars(strval(round($tarif_HT_net))),
                    htmlspecialchars(strval(round($tarif_TTC))),
                    htmlspecialchars(strval(round($Total_TVA))),
                    htmlspecialchars("1.20")
                )
            );
            $sql_insert->closeCursor();

            $now = time();
            $sql_insert = $bdd->prepare("INSERT INTO membres_commandes
            (type,
            user_id,
            statut,
            sous_total,
            prix_total,
            created_at,
            updated_at)
            VALUES (?,?,?,?,?,?,?)");
        
            $sql_insert->execute(
                array(
                    htmlspecialchars(2),
                    intval($id_oo),
                    htmlspecialchars(3),
                    htmlspecialchars(0),
                    htmlspecialchars(0),
                    $now,
                    $now
                )
            );
            $sql_insert->closeCursor();

            $sql_select = $bdd->prepare("SELECT * FROM membres_commandes WHERE user_id=?");
            $sql_select->execute(array($id_oo));
            $commande = $sql_select->fetch();
            $sql_select->closeCursor();

            $sql_select = $bdd->prepare("SELECT * FROM membres_panier WHERE id_membre=? AND pseudo=? AND Tarif_TTC=? AND date_edition=?");
            $sql_select->execute(array(
                htmlspecialchars(strval($id_oo)),
                htmlspecialchars(strval($membre['pseudo'])),
                htmlspecialchars(strval(round($tarif_TTC))),
                htmlspecialchars($time)
            ));
            $ligne_select = $sql_select->fetch();
            $sql_select->closeCursor();
        }


        $sql_insert = $bdd->prepare("INSERT INTO membres_commandes_details
            (commande_id,
            nom,
            description,
            url,
            categorie,
            quantite,
            couleur,
            taille,
            prix,
            valide,
            liste_souhait)
            VALUES (?,?,?,?,?,?,?,?,?,?,?)"
        );

        $sql_insert->execute(array(
            htmlspecialchars($commande['id']),
            htmlspecialchars($article['nom']),
            htmlspecialchars($article['description']),
            htmlspecialchars($article['url']),
            htmlspecialchars($article['categorie']),
            htmlspecialchars($article['quantite']),
            htmlspecialchars($article['couleur']),
            htmlspecialchars($article['taille']),
            htmlspecialchars($article['prix']),
            htmlspecialchars('true'),
            'oui'
        ));

        $sql_insert->closeCursor();

        $commande_detail = $bdd->lastInsertId();

		    	$libelle = $article['nom'];

                    $base_TVA = 20;
                    $PU_HT = (100*intval($article['prix']))/(100+$base_TVA);
                    $TVA = $article['prix'] - $PU_HT;
                    //creation du détail
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
                            htmlspecialchars(strval($commande['panier_id'])),
                            htmlspecialchars($libelle),
                            htmlspecialchars(strval(round($PU_HT,2))),
                            htmlspecialchars(strval(round($TVA,2))),
                            htmlspecialchars("1.20"),
                            htmlspecialchars($article['quantite']),
                            htmlspecialchars($article['categorie']),
                            htmlspecialchars("Commande"),
                            htmlspecialchars($time),
                            $commande_detail
                        )
                    );
                    $sql_insert->closeCursor();

        $update = update_commande($commande['id']);

        $result = array("Texte_rapport" => "Article ajouté", "retour_validation" => "ok", "retour_lien" => "");
    }else{
        $result = array("Texte_rapport" => "Accès interdit", "retour_validation" => "non", "retour_lien" => "");
    }

            
        //     $now = time();
        //     $sql_insert = $bdd->prepare("INSERT INTO membres_commandes
        //     (type,
        //     comment,
        //     user_id,
        //     statut,
        //     created_at,
        //     updated_at)
        //     VALUES (?,?,?,?,?,?)");
        
        //     $sql_insert->execute(
        //         array(
        //                 htmlspecialchars(1),
        //                 htmlspecialchars($comment),
        //                 intval($id_oo),
        //                 htmlspecialchars(1),
        //                 $now,
        //                 $now
        //         )
        //     );
        //     $sql_insert->closeCursor();

        //     $sql_select = $bdd->prepare("SELECT * FROM membres_commandes WHERE user_id=? AND created_at=? AND updated_at=?");
        //     $sql_select->execute(array(
        //         $id_oo,
        //         $now,
        //         $now
        //     ));
        //     $liste = $sql_select->fetch();
        //     $sql_select->closeCursor();

        //     for($i=0; $i < count($names); $i++){
        //         $sql_insert = $bdd->prepare("INSERT INTO membres_commandes_details
        //         (commande_id,
        //         nom,
        //         description,
        //         categorie,
        //         quantite,
        //         options)
        //         VALUES (?,?,?,?,?,?)");
                
        //         $sql_insert->execute(array(
        //             htmlspecialchars($liste['id']),
        //             htmlspecialchars($names[$i]),
        //             htmlspecialchars($descs[$i]),
        //             htmlspecialchars($categories[$i]),
        //             htmlspecialchars($quantities[$i]),
        //             htmlspecialchars($options[$i])
        //         ));
        //         $sql_insert->closeCursor();
        //     }

        //     $result = array("Texte_rapport" => "Liste de souhait envoyé ", "retour_validation" => "ok", "retour_lien" => "");
        // }else{
        //     $result = array("Texte_rapport" => "Quantité supérieur ou égale à 1 obligatoire", "retour_validation" => "non", "retour_lien" => "");
        // }
    
    $result = json_encode($result);
    echo $result;
} else {
    header('location: /index.html');
}

ob_end_flush();
?>