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

$colors = $_POST['colors'];
$sizes = $_POST['sizes'];
$options = $_POST['options'];
$urls = $_POST['urls'];
$categories = $_POST['categories'];
$prices = $_POST['prices'];
$quantities = $_POST['quantities'];
$totalTTC = $_POST['totalTTC'];
$comment = $_POST['comment'];
$ids = $_POST['ids'];
$id_commande = $_SESSION['id_commande'];
$time = time();

if (empty($user) && empty($id_oo)) {
    $_SESSION['id_ext'] = $_SESSION['id_commande'];
    $id_oo = $_SESSION['id_ext'] . 'ext';
}

$ok_urls = true;
for ($i = 0; $i < count($urls); $i++) {
    if ($urls[$i] == "") {
        $ok_urls = false;
    } else if (filter_var($urls[$i], FILTER_VALIDATE_URL) == false) {
        $ok_urls = false;
    }
}
if ($ok_urls) {
    //ALL URL ARE OK
    $ok_quantity = true;
    for ($i = 0; $i < count($quantities); $i++) {
        if ($quantities[$i] < 1) {
            $ok_quantity = false;
        }
    }
    if ($ok_quantity) {
        $ok_category = true;
        for ($i = 0; $i < count($categories); $i++) {
            if ($categories[$i] == "") {
                $ok_category = false;
            }
        }
        if ($ok_category) {
            $ok_price = true;
            for ($i = 0; $i < count($prices); $i++) {
                if ($prices[$i] < 1) {
                    $ok_price = false;
                }
            }

            if ($ok_price) {
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
                for ($i = 0; $i < count($prices); $i++) {
                    $PU_TTC = $prices[$i]; // FCFA
                    $req_select = $bdd->prepare("SELECT * FROM categories WHERE nom_categorie=?");
                    $req_select->execute(array(
                        $categories[$i]
                    ));
                    $categorie = $req_select->fetch();
                    $req_select->closeCursor();
                    $pourcentage = 1 + $categorie['value_commande'] / 100;

                    $tarif_ss_total += round($PU_TTC * $quantities[$i]);
                    $tarif_TTC += $PU_TTC * $quantities[$i]; // FCFA
                }

                $tarif_TTC += intval($abonnement['Frais_de_gestion_d_une_commande']);

                $tarif_TTC = round($tarif_TTC);

                /*$base_TVA = 20;
                $tarif_HT = (100*intval($tarif_TTC))/(100+$base_TVA); // FCFA
                $tarif_HT_net = (100*intval($tarif_TTC))/(100+$base_TVA); // FCFA
                $Total_TVA = $tarif_TTC - $tarif_HT; // FCFA
                $time = strval(time());*/

                if (empty($id_commande)) {

                    //AJOUTER UNE LIGNE DANS MEMBRES_PANIER_DETAIL

                    $sql_select = $bdd->prepare("SELECT * FROM membres_panier WHERE id_membre=?");
                    $sql_select->execute(array(
                        $id_oo
                    ));
                    $ligne_pann = $sql_select->fetch();
                    $sql_select->closeCursor();
                    if (empty($ligne_pann['id'])) {
                        //creation du panier
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
                                htmlspecialchars("1.20")
                            )
                        );
                        $sql_insert->closeCursor();

                        $panier_id = $bdd->lastInsertId();
                    } else {
                        $panier_id = $ligne_pann['id'];

                        if ($ligne_pann['Titre_panier'] == 'Abonnement' || $ligne_pann['Titre_panier'] == 'Liste') {
                            $sql_update = $bdd->prepare("UPDATE membres_panier SET
                        Contenu=?,
                        Titre_panier=?,
                        Suivi=?,
                        date_edition=?,
                        Tarif_HT=?,
                        Tarif_HT_net=?,
                        Tarif_TTC=?,
                        Total_Tva=?
                        WHERE id=?");
                            $sql_update->execute(array(
                                htmlspecialchars("Commande"),
                                htmlspecialchars("Commande"),
                                htmlspecialchars("non traite"),
                                htmlspecialchars($time),
                                0,
                                0,
                                0,
                                0,
                                $panier_id
                            ));
                            $sql_update->closeCursor();

                            $sql_delete = $bdd->prepare("DELETE FROM membres_panier_details WHERE id_membre=?");
                            $sql_delete->execute(array($id_oo));
                            $sql_delete->closeCursor();
                        }
                    }


                    //Ajout en BDD de la commande dans membres_commande
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
                        htmlspecialchars(round($tarif_TTC)),
                        htmlspecialchars($panier_id),
                        time(),
                        time()
                    ));
                    $sql_insert->closeCursor();

                    $sql_select = $bdd->prepare('SELECT * FROM membres_commandes WHERE panier_id=?');
                    $sql_select->execute(array(
                        htmlspecialchars($panier_id)
                    ));
                    $commande = $sql_select->fetch();
                    $sql_select->closeCursor();
                    //Ajout en BDD du panier dans membres_panier et membres_panier_details
                    $_SESSION['id_commande'] = $commande['id'];
                    $commande_id = $_SESSION['id_commande'];
                    $numero_panier = $panier_id;

                    if (empty($user) && empty($id_oo)) {
                        $_SESSION['id_ext'] = $_SESSION['id_commande'];
                        $id_oo = $_SESSION['id_ext'] . 'ext';
                        ///////////////////////////////UPDATE
                        $sql_update = $bdd->prepare("UPDATE membres_panier SET
            id_membre=? 
            WHERE id=?");
                        $sql_update->execute(array(
                            $id_oo,
                            $numero_panier
                        ));
                        $sql_update->closeCursor();
                    }
                } else {
                    $commande_id = $_SESSION['id_commande'];
                    $sql_select = $bdd->prepare("SELECT * FROM membres_commandes WHERE id=? AND user_id=?");
                    $sql_select->execute(array($commande_id, $id_oo));
                    $ligne_select = $sql_select->fetch();
                    $sql_select->closeCursor();
                    $numero_panier = $ligne_select['panier_id'];

                    //         $sql_delete = $bdd->prepare("DELETE FROM membres_panier_details WHERE numero_panier=?");
                    // $sql_delete->execute(array($numero_panier));
                    // $sql_delete->closeCursor();

                    // $sql_delete = $bdd->prepare("DELETE FROM membres_commandes_details WHERE commande_id=?");
                    // $sql_delete->execute(array($commande_id));
                    // $sql_delete->closeCursor();
                }


                //Ajout en BDD de tous les articles liés à la commande
                for ($i = 0; $i < count($prices); $i++) {
                    $nart = $i + 1;
                    $libelle = "Article $nart";
                    $boutique_v = "";

                    $PU_HT = round($prices[$i]);

                    if (!empty($ids[$i])) {

                        $sql_select = $bdd->prepare("SELECT * FROM membres_panier_details WHERE id_commande_detail=?");
                        $sql_select->execute(array($ids[$i]));
                        $ligne_select_vvv = $sql_select->fetch();
                        $sql_select->closeCursor();

                        $boutique_v = $ligne_select_vvv["action_module_service_produit"];

                        if($boutique_v == "Commande boutique"){
                            $sql_update = $bdd->prepare("UPDATE membres_commandes_details SET
                            commande_id=?,
                            quantite=?,
                            couleur=?,
                            taille=?
                            WHERE id=?");
                            $sql_update->execute(array(
                               htmlspecialchars($commande_id),
                            htmlspecialchars($quantities[$i]),
                            htmlspecialchars($colors[$i]),
                            htmlspecialchars($sizes[$i]),
                            htmlspecialchars($ids[$i])
                            ));
                            $sql_update->closeCursor();

                            $sql_update = $bdd->prepare("UPDATE membres_panier_details SET
                            numero_panier=?,
                            PU_HT=?,
                            TVA=?,
                            TVA_TAUX=?,
                            quantite=?,
                            date=?
                            WHERE id_commande_detail=?");
                            $sql_update->execute(array(
                                htmlspecialchars(strval($numero_panier)),
                                htmlspecialchars(strval(round($PU_HT))),
                                htmlspecialchars(strval(round($TVA))),
                                htmlspecialchars("1.18"),
                                htmlspecialchars($quantities[$i]),
                                htmlspecialchars($time),
                            htmlspecialchars($ids[$i])
                            ));
                            $sql_update->closeCursor();

                        }else{
                            $sql_update = $bdd->prepare("UPDATE membres_commandes_details SET
                            commande_id=?,
                            nom=?,
                            description=?,
                            url=?,
                            categorie=?,
                            quantite=?,
                            couleur=?,
                            taille=?,
                            options=?,
                            prix=?
                            WHERE id=?");
                            $sql_update->execute(array(
                               htmlspecialchars($commande_id),
                            htmlspecialchars($names[$i]),
                            htmlspecialchars(''),
                            htmlspecialchars($urls[$i]),
                            htmlspecialchars($categories[$i]),
                            htmlspecialchars($quantities[$i]),
                            htmlspecialchars($colors[$i]),
                            htmlspecialchars($sizes[$i]),
                            htmlspecialchars($options[$i]),
                            htmlspecialchars($prices[$i]),
                            htmlspecialchars($ids[$i])
                            ));
                            $sql_update->closeCursor();

                            $sql_update = $bdd->prepare("UPDATE membres_panier_details SET
                            numero_panier=?,
                            libelle=?,
                            PU_HT=?,
                            TVA=?,
                            TVA_TAUX=?,
                            quantite=?,
                            categorie=?,
                            date=?
                            WHERE id_commande_detail=?");
                            $sql_update->execute(array(
                                htmlspecialchars(strval($numero_panier)),
                                htmlspecialchars($libelle),
                                htmlspecialchars(strval(round($PU_HT))),
                                htmlspecialchars(strval(round($TVA))),
                                htmlspecialchars("1.18"),
                                htmlspecialchars($quantities[$i]),
                                htmlspecialchars($categories[$i]),
                                htmlspecialchars($time),
                            htmlspecialchars($ids[$i])
                            ));
                            $sql_update->closeCursor();
    
                        }

                    } else {
                        $sql_insert = $bdd->prepare('INSERT INTO membres_commandes_details
                    (commande_id,
                    nom,
                    description,
                    url,
                    categorie,
                    quantite,
                    couleur,
                    taille,
                    options,
                    prix)
                    VALUES (?,?,?,?,?,?,?,?,?,?)');
                        $sql_insert->execute(array(
                            htmlspecialchars($commande_id),
                            htmlspecialchars($names[$i]),
                            htmlspecialchars(''),
                            htmlspecialchars($urls[$i]),
                            htmlspecialchars($categories[$i]),
                            htmlspecialchars($quantities[$i]),
                            htmlspecialchars($colors[$i]),
                            htmlspecialchars($sizes[$i]),
                            htmlspecialchars($options[$i]),
                            htmlspecialchars($prices[$i])
                        ));

                        $sql_insert->closeCursor();
                        $commande_detail = $bdd->lastInsertId();

                        //$base_TVA = 20;

                        //$TVA = $prices[$i] - $PU_HT;
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
                                htmlspecialchars(strval($membre['pseudo'])),
                                htmlspecialchars(strval($numero_panier)),
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
                    }


                    $update = update_commande($commande_id);
                }
                $_SESSION['action'] = "Modifier";

                $result = array("Texte_rapport" => "Article ajouté", "retour_validation" => "ok", "retour_lien" => "");
            } else {
                $result = array("Texte_rapport" => "Prix supérieur ou égale à 1 obligatoire", "retour_validation" => "non", "retour_lien" => "");
            }
        } else {
            $result = array("Texte_rapport" => "Catégorie incorrecte !", "retour_validation" => "non", "retour_lien" => "");
        }
    } else {
        $result = array("Texte_rapport" => "Quantité supérieur ou égale à 1 obligatoire", "retour_validation" => "non", "retour_lien" => "");
    }
} else {
    //PAS OK
    $result = array("Texte_rapport" => "Url obligatoire", "retour_validation" => "non", "retour_lien" => "");
}
$result = json_encode($result);
echo $result;


ob_end_flush();
