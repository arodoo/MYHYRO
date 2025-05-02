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

$idaction = $_POST['idaction'];
$action = $_POST['action'];
$quantite = $_POST['quantite'];
$idCommande = $_POST['idCommande'];
$id_commande = $_SESSION['id_commande'];


if (empty($user) && !empty($_SESSION['id_commande'])) {
  $_SESSION['id_ext'] = $_SESSION['id_commande'];
  $id_oo = $_SESSION['id_commande'] . 'ext';
}

$now = time();
$now_expiration = date('d-m-Y', $now);

$product_query = $bdd->prepare("SELECT * FROM configurations_references_produits WHERE id=?");
$product_query->execute(array($idaction));
$product = $product_query->fetch();

$category_query = $bdd->prepare("SELECT * FROM categories WHERE id=?");
$category_query->execute(array($product['id_categorie']));
$categorie = $category_query->fetch();

if ($product) {

  if (!empty($id_oo)) {
    $sql_select = $bdd->prepare("SELECT * FROM membres_panier WHERE id_membre=?");
    $sql_select->execute(array(
      $id_oo,
    ));
    $ligne_pann = $sql_select->fetch();
    $sql_select->closeCursor();

    $panier_id = $ligne_pann['id'];

    $sql_select = $bdd->prepare("SELECT * FROM membres_commandes WHERE user_id=?");
    $sql_select->execute(array(
      $id_oo
    ));
    $ligne_commande = $sql_select->fetch();
    $sql_select->closeCursor();

    if (empty($ligne_commande['id'])) {

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

$id = $bdd->lastInsertId();


//Ajout en BDD du panier dans membres_panier et membres_panier_details
$_SESSION['id_commande'] = $id;
$commande_id = $_SESSION['id_commande'];
    } 
  } else {
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

    $id = $bdd->lastInsertId();

    $sql_select = $bdd->prepare('SELECT * FROM membres_commandes WHERE id=?');
    $sql_select->execute(array(
      htmlspecialchars($id)
    ));
    $commande = $sql_select->fetch();
    $sql_select->closeCursor();
    //Ajout en BDD du panier dans membres_panier et membres_panier_details
    $_SESSION['id_commande'] = $commande['id'];
    $commande_id = $_SESSION['id_commande'];
    $id_oo = $_SESSION['id_commande'] . 'ext';
    $_SESSION['id_ext'] = $_SESSION['id_commande'];
  }

  if (empty($panier_id)) {

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
        htmlspecialchars(strval($user)),
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

    //AJOUTER UNE LIGNE DANS MEMBRES_PANIER_DETAIL

    $sql_select = $bdd->prepare("SELECT * FROM membres_panier WHERE id_membre=? AND pseudo=? AND Tarif_TTC=? AND date_edition=?");
    $sql_select->execute(array(
      htmlspecialchars(strval($id_oo)),
      htmlspecialchars(strval($user)),
      htmlspecialchars(strval(round($tarif_TTC))),
      htmlspecialchars($time)
    ));
    $ligne_select = $sql_select->fetch();
    $sql_select->closeCursor();

    // Mise à jour de la commande dans membres_commande
    $sql_update = $bdd->prepare("UPDATE membres_commandes SET
        type = ?,
        comment = ?,
        user_id = ?,
        statut = ?,
        sous_total = ?,
        prix_total = ?,
        panier_id = ?,
        updated_at = ?
        WHERE id = ?");

    $sql_update->execute(array(
      htmlspecialchars(2),
      htmlspecialchars($comment),
      htmlspecialchars($id_oo),
      htmlspecialchars(3),
      htmlspecialchars($tarif_ss_total),
      htmlspecialchars(round($tarif_TTC)),
      htmlspecialchars($panier_id),
      time(),
      $_SESSION['id_commande']
    ));
    $sql_update->closeCursor();

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

    if (empty($user)) {
      $id_oo = $_SESSION['id_commande'] . 'ext';
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

    if ($ligne_pann['Titre_panier'] == 'Abonnement') {
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

  $url = 'https://' . $nomsiteweb . '/Boutique-fiche/' . $product['url_produit'];

  $sql_select = $bdd->prepare("SELECT * FROM membres_commandes_details WHERE url=? AND id_membre=? AND commande_id=?");
  $sql_select->execute(array($url, $id_oo, $commande_id));
  $ligne_select2 = $sql_select->fetch();
  $sql_select->closeCursor();

  if (empty($ligne_select2['id'])) {
    $sql_insert = $bdd->prepare('INSERT INTO membres_commandes_details
                    (id_membre,
                    commande_id,
                    nom,
                    description,
                    url,
                    categorie,
                    quantite,
                    couleur,
                    taille,
                    options,
                    prix,
                    valide)
                    VALUES (?,?,?,?,?,?,?,?,?,?,?,?)');
    $sql_insert->execute(array(
      $id_oo,
      htmlspecialchars($commande_id),
      htmlspecialchars($product['nom_produit']),
      htmlspecialchars($product['description']),
      $url,
      htmlspecialchars($categorie['nom_categorie']),
      htmlspecialchars($quantite),
      htmlspecialchars($product['couleur2']),
      htmlspecialchars(''),
      htmlspecialchars(''),
      htmlspecialchars($product['prix']),
      "true"
    ));

    $sql_insert->closeCursor();
    $commande_detail = $bdd->lastInsertId();

    $libelle_details_article = $product['nom_produit'];
    $libelle_prix_articleht = ($product['prix']);
    $libelle_prix_articleht = round($libelle_prix_articleht);
    $libelle_tva_article = ($product['prix'] - $libelle_prix_articleht);
    $libelle_taux_tva_article = "$Taux_tva";
    $libelle_id_article = "$idaction";

    $sql_insert = $bdd->prepare("INSERT INTO membres_panier_details
                    (id_membre,
                    pseudo,
                    id_produit,
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
                    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $sql_insert->execute(
      array(
        htmlspecialchars(strval($id_oo)),
        htmlspecialchars(strval($user)),
        $product['id'],
        htmlspecialchars(strval($numero_panier)),
        htmlspecialchars($libelle_details_article),
        htmlspecialchars(strval(round($libelle_prix_articleht))),
        htmlspecialchars(strval(round($libelle_tva_article))),
        htmlspecialchars($libelle_taux_tva_article),
        htmlspecialchars($quantite),
        htmlspecialchars($categorie['nom_categorie']),
        htmlspecialchars("Commande boutique"),
        htmlspecialchars($time),
        $commande_detail
      )
    );
    $sql_insert->closeCursor();
  } else {
    $newquantite = $ligne_select2['quantite'] + $quantite;

    $sql_update = $bdd->prepare("UPDATE membres_commandes_details SET quantite=? WHERE id=?");
    $sql_update->execute(array(
      htmlspecialchars($newquantite),
      intval($ligne_select2['id'])
    ));
    $sql_update->closeCursor();

    $sql_update = $bdd->prepare("UPDATE membres_panier_details SET quantite=? WHERE id_commande_detail=? AND id_membre=?");
    $sql_update->execute(array(
      htmlspecialchars($newquantite),
      intval($ligne_select2['id']),
      $id_oo
    ));
    $sql_update->closeCursor();
  }


  $update = update_commande($commande_id);

  //ajout_produit_panier($libelle_details_article, $libelle_categorie, $categorie['value_commande'], $quantite, $libelle_prix_articleht, $libelle_tva_article, (1 + $Tva_coef), "Commande", $action_parametres_valeurs_explode, $libelle_id_article, $user,$idaction);
  $result = array("Texte_rapport" => "Produit ajouté au panier avec succès ", "retour_validation" => "ok", "retour_lien" => '');
} else {

  $result = array("Texte_rapport" => "Produit introuvable", "retour_validation" => "non", "retour_lien" => "");
}


$result = json_encode($result);
echo $result;

ob_end_flush();
