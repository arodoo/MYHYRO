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

$title = $_POST['title'];
$desc = $_POST['description'];
$file = $_FILES['files'];

$time = time();
$sql_select = $bdd->prepare("SELECT * FROM membres_panier WHERE id_membre=?");
$sql_select->execute(array(
    $id_oo
));
$ligne_pann = $sql_select->fetch();
$sql_select->closeCursor();

if (isset($user)) {
    $ok_title = true;
    if (strlen($title) == 0) {
        $ok_title = false;
        $code_title = 1;
    } else if (strlen($title) >= 100) {
        $ok_title = false;
        $code_title = 2;
    }
    if ($ok_title) {
        if (strlen($desc) > 0) {
            //Vérification du fichier

            if ($prix_liste_de_souhaits == "Gratuit") {
                if ($file == null) {
                    $sql_insert = $bdd->prepare("INSERT INTO membres_souhait
                    (titre,
                    description,
                    user_id,
                    statut,
                    created_at,
                    updated_at)
                    VALUES (?,?,?,?,?,?)");

                    $sql_insert->execute(
                        array(
                            htmlspecialchars($title),
                            htmlspecialchars($desc),
                            intval($id_oo),
                            intval(1),
                            time(),
                            time()
                        )
                    );
                    $sql_insert->closeCursor();

                    $result = array("Texte_rapport" => "Demande envoyée !", "retour_validation" => "ok", "retour_lien" => "");
                } else {
                    if ($file['type'] == "image/jpeg" || $file['type'] == "image/png" || $file['type'] == "application/pdf") {
                        if ($file['size'] <= 20971520) {
                            $filename = $dir_fonction . "images/uploads/users/" . $id_oo;
                            $filepath = "/var/www/vhosts/aw28.fr/httpdocs/images/uploads/users/" . $id_oo . "/" . $file['name'];
                            if (file_exists($filename)) {
                                move_uploaded_file($file['tmp_name'], $filepath);
                            } else {
                                mkdir($filename);
                                move_uploaded_file($file['tmp_name'], $filepath);
                            }

                            $sql_insert = $bdd->prepare("INSERT INTO membres_souhait
                            (titre,
                            description,
                            filename,
                            user_id,
                            statut,
                            created_at,
                            updated_at)
                            VALUES (?,?,?,?,?,?,?)");

                            $sql_insert->execute(
                                array(
                                    htmlspecialchars($title),
                                    htmlspecialchars($desc),
                                    htmlspecialchars($file['name']),
                                    intval($id_oo),
                                    intval(1),
                                    time(),
                                    time()
                                )
                            );
                            $sql_insert->closeCursor();

                            $result = array("Texte_rapport" => "Demande envoyée !", "retour_validation" => "ok", "retour_lien" => "");
                        } else {
                            $result = array("Texte_rapport" => "Fichier trop volumineux (20 Mo max.)", "retour_validation" => "non", "retour_lien" => "");
                        }
                    } else {
                        $result = array("Texte_rapport" => "Fichier non autorisé (.jpg/.png/.pdf)", "retour_validation" => "non", "retour_lien" => "");
                    }
                }
            } else {

                if ($file == null) {
                } else {
                    if ($file['type'] == "image/jpeg" || $file['type'] == "image/png" || $file['type'] == "application/pdf") {
                        if ($file['size'] <= 20971520) {
                            $filename = $dir_fonction . "images/uploads/users/" . $id_oo;
                            $filepath = "/var/www/vhosts/aw28.fr/httpdocs/images/uploads/users/" . $id_oo . "/" . $file['name'];
                            if (file_exists($filename)) {
                                move_uploaded_file($file['tmp_name'], $filepath);
                            } else {
                                mkdir($filename);
                                move_uploaded_file($file['tmp_name'], $filepath);
                            }
                        } else {
                            $error = "oui";
                            $result = array("Texte_rapport" => "Fichier trop volumineux (20 Mo max.)", "retour_validation" => "non", "retour_lien" => "");
                        }
                    } else {
                        $error = "oui";
                        $result = array("Texte_rapport" => "Fichier non autorisé (.jpg/.png/.pdf)", "retour_validation" => "non", "retour_lien" => "");
                    }
                }

                if ($error != "oui") {

                    $req_bouclere = $bdd->prepare("SELECT * FROM membres_commandes WHERE user_id=? AND statut=3");
                    $req_bouclere->execute(array(
                        array($id_oo)
                    ));
                    $ligne_bouclere = $req_bouclere->fetch();
                    $req_bouclere->closeCursor();

                    $sql_delete = $bdd->prepare("DELETE FROM membres_commandes WHERE user_id=? AND statut=3");
                    $sql_delete->execute(array($id_oo));
                    $sql_delete->closeCursor();

                    $sql_delete = $bdd->prepare("DELETE FROM membres_commandes_details WHERE commande_id=?");
                    $sql_delete->execute(array($ligne_bouclere['id']));
                    $sql_delete->closeCursor();

                    unset($_SESSION['id_commande']);

                    $req_bouclere = $bdd->prepare("SELECT * FROM membres_colis WHERE user_id=? AND statut = 1");
                    $req_bouclere->execute(array(
                        array($id_oo)
                    ));
                    $ligne_bouclere = $req_bouclere->fetch();
                    $req_bouclere->closeCursor();


                        $sql_delete = $bdd->prepare("DELETE FROM membres_colis WHERE user_id=? AND statut = 1");
                        $sql_delete->execute(array($id_oo));
                        $sql_delete->closeCursor();

                        $sql_delete = $bdd->prepare("DELETE FROM membres_colis_details WHERE colis_id=?");
                        $sql_delete->execute(array($ligne_bouclere['id']));
                        $sql_delete->closeCursor();

                        unset($_SESSION['id_colis']);
   

                    $sql_delete = $bdd->prepare("DELETE FROM membres_panier WHERE id_membre=?");
                    $sql_delete->execute(array($id_oo));
                    $sql_delete->closeCursor();

                    $sql_delete = $bdd->prepare("DELETE FROM membres_panier_details WHERE id_membre=?");
                    $sql_delete->execute(array($id_oo));
                    $sql_delete->closeCursor();
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
                   Total_Tva)
                   VALUES (?,?,?,?,?,?,?,?,?,?)");

                    $sql_insert->execute(
                        array(
                            htmlspecialchars(strval($id_oo)),
                            $user,
                            htmlspecialchars("Liste"),
                            htmlspecialchars("Liste"),
                            htmlspecialchars("non traite"),
                            htmlspecialchars($time),
                            htmlspecialchars(strval(round($tarif_HT))),
                            htmlspecialchars(strval(round($tarif_HT_net))),
                            htmlspecialchars(strval(round($tarif_TTC))),
                            htmlspecialchars(strval(round($Total_TVA)))
                        )
                    );
                    $sql_insert->closeCursor();

                    $panier_id = $bdd->lastInsertId();


                    $numero_panier = $panier_id;

                    $libelle = "Liste de souhait | $title";
                    $TVA = $prix_liste_de_souhaits * .18;
                    $PU_HT = $prix_liste_de_souhaits;
                    $quantities = 1;

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
                    titre_liste,
                            description_liste,
                            fichier_liste,
                    id_commande_detail)
                    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                    $sql_insert->execute(
                        array(
                            htmlspecialchars(strval($id_oo)),
                            htmlspecialchars(strval($user)),
                            htmlspecialchars(strval($numero_panier)),
                            htmlspecialchars($libelle),
                            htmlspecialchars(strval(round($PU_HT))),
                            htmlspecialchars(strval(round($TVA))),
                            htmlspecialchars("1.18"),
                            htmlspecialchars($quantities),
                            htmlspecialchars($categories),
                            htmlspecialchars("Achat liste souhait"),
                            htmlspecialchars($time),
                            htmlspecialchars($title),
                            htmlspecialchars($desc),
                            htmlspecialchars($file['name']),
                            $commande_detail
                        )
                    );
                    $sql_insert->closeCursor();

                    $req_boucle = $bdd->prepare("SELECT * FROM membres_panier_details
	WHERE pseudo=? 
	AND numero_panier=?");
                    $req_boucle->execute(array(
                        htmlspecialchars($user),
                        htmlspecialchars($numero_panier)
                    ));
                    while ($ligne_boucle = $req_boucle->fetch()) {
                        $idoneinfos_artciles_fiche_panier = $ligne_boucle['id'];
                        $PU_HT_artciles_fiche_panier = $ligne_boucle['PU_HT'];
                        $TVA = $ligne_boucle['TVA'];
                        $TVA_TAUX = $ligne_boucle['TVA_TAUX'];
                        $quantite_artciles_fiche_panier = $ligne_boucle['quantite'];

                        $PU_HT_TOTAUX = ($PU_HT_TOTAUX + ($PU_HT_artciles_fiche_panier * $quantite_artciles_fiche_panier));

                        if ($ligne_boucle['TVA_TAUX'] == "1.18") {
                            $PU_TVA_TOTAUX = ($PU_TVA_TOTAUX + ($TVA * $quantite_artciles_fiche_panier));
                            $Taux_tva = "1.18";
                        }
                    }
                    $PU_TTC_TOTAUX = ($PU_HT_TOTAUX + $PU_TVA_TOTAUX + $PU_TVA2_TOTAUX);

                    //UPDATE SQL
                    ///////////////////////////////UPDATE
                    $sql_update = $bdd->prepare("UPDATE membres_panier SET 
	Tarif_HT=?, 
	Tarif_HT_net=?, 
	Tarif_TTC=?, 
	Total_Tva=?,
	taux_tva=?,
	Total_Tva2=?,
	taux_tva2=?
	WHERE numero_panier=? 
	AND pseudo=?");
                    $sql_update->execute(array(
                        htmlspecialchars($PU_HT_TOTAUX),
                        htmlspecialchars($PU_HT_TOTAUX),
                        htmlspecialchars($PU_TTC_TOTAUX),
                        htmlspecialchars($PU_TVA_TOTAUX),
                        htmlspecialchars($Taux_tva),
                        htmlspecialchars($PU_TVA2_TOTAUX),
                        htmlspecialchars($Taux2_tva),
                        htmlspecialchars($numero_panier),
                        htmlspecialchars($user)
                    ));
                    $sql_update->closeCursor();

                    $result = array("Texte_rapport" => "Ajouté au panier !", "retour_validation" => "ok", "retour_lien" => "");
                }
            }
        } else {
            $result = array("Texte_rapport" => "La description est obligatoire", "retour_validation" => "non", "retour_lien" => "");
        }
    } else {
        //PAS OK
        if ($code_title == 1) {
            $result = array("Texte_rapport" => "Le titre est obligatoire", "retour_validation" => "non", "retour_lien" => "");
        } else {
            $result = array("Texte_rapport" => "Le titre possède 100 caractères maximum", "retour_validation" => "non", "retour_lien" => "");
        }
    }

    $result = json_encode($result);
    echo $result;
} else {
    header('location: /index.html');
}

ob_end_flush();
