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
$names = $_POST['names'];
$descriptions = $_POST['descriptions'];
$categories = $_POST['categories'];
$prices = $_POST['prices'];
$quantities = $_POST['quantities'];
$totalTTC = $_POST['totalTTC'];
$comment = $_POST['comment'];
$ids_detail = $_POST['ids_detail'];
$poids = floatval($_POST['poids']);

if (isset($user)) {
    $ok_categories = true;
    for ($i = 0; $i < count($categories); $i++) {
        if ($categories[$i] == "") {
            $ok_categories = false;
        }
    }
    if ($ok_categories) {
        //ALL CATEGORIES ARE OK
        $ok_names = true;
        for ($i = 0; $i < count($names); $i++) {
            if ($names[$i] == "") {
                $ok_names = false;
            }
        }
        if ($ok_names) {
            $ok_quantity = true;
            for ($i = 0; $i < count($quantities); $i++) {
                if ($quantities[$i] < 1) {
                    $ok_quantity = false;
                }
            }
            if ($ok_quantity) {
                $ok_price = true;
                /*for ($i = 0; $i < count($prices); $i++){
                    if($prices[$i] < 1){
                        $ok_price = false;
                    }
                }*/

                if ($ok_price) {
                    $totalEu = 0;
                    $totalFcfa = $totalTTC;
                    /*for($i=0; $i < count($prices); $i++){

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
                    }*/
                    if (!empty($poids) && $poids != 0) {
                        //if($totalFcfa == $totalTTC){

                        $now = time();

                        if (empty($id)) {
                            $sql_insert = $bdd->prepare("INSERT INTO membres_colis
                                (comment,
                                user_id,
                                statut,
                                prix_total,
                                created_at,
                                updated_at,
                                poids)
                                VALUES (?,?,?,?,?,?,?)");
                            $sql_insert->execute(array(
                                $comment,
                                $id_oo,
                                htmlspecialchars("1"),
                                htmlspecialchars(strval($totalFcfa)),
                                $now,
                                $now,
                                $poids
                            ));
                            $sql_insert->closeCursor();

                            $idColis = $bdd->lastInsertId();
                        } else {
                            $idColis = $id;
                        }

                        // Ajout en BDD des articles
                        for ($i = 0; $i < count($prices); $i++) {

                            $req_select = $bdd->prepare("SELECT * FROM categories WHERE nom_categorie=?");
                            $req_select->execute(array(
                                $categories[$i]
                            ));
                            $categorie = $req_select->fetch();
                            $req_select->closeCursor();

                            if (empty($ids_detail[$i])) {
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
                                    htmlspecialchars($idColis),
                                    htmlspecialchars($names[$i]),
                                    htmlspecialchars($descriptions[$i]),
                                    htmlspecialchars($categories[$i]),
                                    htmlspecialchars($quantities[$i]),
                                    htmlspecialchars($categorie['type']),
                                    htmlspecialchars($prices[$i])
                                ));
                                $sql_insert->closeCursor();
                            } else {

                                $sql_update = $bdd->prepare("UPDATE membres_colis SET
                    created_at=? 
                    WHERE id=?");
                                $sql_update->execute(array(
                                    time(),
                                    $idColis
                                ));
                                $sql_update->closeCursor();

                                $sql_update = $bdd->prepare("UPDATE membres_colis_details SET
                                    nom=?,
                                    description=?,
                                    categorie=?,
                                    quantite=?,
                                    type_value=?,
                                    value=?
                                        WHERE id=?");

                                $sql_update->execute(array(
                                    htmlspecialchars($names[$i]),
                                    htmlspecialchars($descriptions[$i]),
                                    htmlspecialchars($categories[$i]),
                                    htmlspecialchars($quantities[$i]),
                                    htmlspecialchars($categorie["type"]),
                                    htmlspecialchars($prices[$i]),
                                    $ids_detail[$i]
                                ));
                                $sql_update->closeCursor();
                            }
                        }

                        $select_bql = $bdd->prepare("SELECT * FROM membres_panier WHERE id_membre=?");
                        $select_bql->execute(array($id_oo));
                        $select_pan = $select_bql->fetch();
                        $select_bql->closeCursor();

                        if (!empty($select_pan['id'])) {
                            $id_panier = $select_pan['id'];
                        } else {
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

                        $select_bql = $bdd->prepare("SELECT * FROM membres_panier_details WHERE id_membre=? AND id_colis_detail=? AND numero_panier=?");
                        $select_bql->execute(array($id_oo, $idColis, $id_panier));
                        $select_pan_d = $select_bql->fetch();
                        $select_bql->closeCursor();

                        if (empty($select_pan_d['id'])) {
                            $libelle = "Colis 1";
                            $sql_insert = $bdd->prepare("INSERT INTO membres_panier_details
                            (id_membre,
                            pseudo,
                            numero_panier,
                            libelle,
                            PU_HT,
                            TVA,
                            TVA_TAUX,
                            action_module_service_produit,
                            date,
                            id_colis_detail)
                            VALUES (?,?,?,?,?,?,?,?,?,?)");
                            $sql_insert->execute(
                                array(
                                    htmlspecialchars(strval($id_oo)),
                                    htmlspecialchars(strval($user)),
                                    htmlspecialchars(strval($id_panier)),
                                    htmlspecialchars($libelle),
                                    htmlspecialchars(strval(round($PU_HT))),
                                    htmlspecialchars(strval(round($TVA))),
                                    htmlspecialchars("1.18"),
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
                        } else {
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
                            comment=?,
                            prix_total=?,
                            updated_at=?,
                            panier_id=?
                            WHERE id=?");
                        $sql_update->execute(array(
                            $comment,
                            htmlspecialchars(strval($totalFcfa)),
                            $now,
                            htmlspecialchars($id_panier),
                            $idColis
                        ));
                        $sql_update->closeCursor();

                        $result = array("Texte_rapport" => "Colis ajouté", "retour_validation" => "ok", "retour_lien" => "/Paiement");

                        $_SESSION['id_colis'] = $idColis;
                    } else {
                        $result = array("Texte_rapport" => "Veuillez indiquer un poids !", "retour_validation" => "non", "retour_lien" => "");
                    }
                } else {
                    $result = array("Texte_rapport" => "Prix supérieur ou égale à 1 obligatoire", "retour_validation" => "non", "retour_lien" => "");
                }
            } else {
                $result = array("Texte_rapport" => "Quantité supérieur ou égale à 1 obligatoire", "retour_validation" => "non", "retour_lien" => "");
            }
        } else {
            $result = array("Texte_rapport" => "Nom obligatoire", "retour_validation" => "non", "retour_lien" => "");
        }
    } else {
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
