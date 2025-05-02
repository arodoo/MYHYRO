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

  $color = $_POST['color'] ;
  $size = $_POST['size'] ;
  $option = $_POST['option'] ;
  $url = $_POST['url'] ;
  $categorie = $_POST['categorie'] ;
  $price = $_POST['price'] ;
  $quantitie = $_POST['quantitie'] ;
  $totalTTC = $_POST['totalTTC'] ;
  $comment = $_POST['comment'];
  $nbr = $_POST['nbr'];
  $id_commande = $_SESSION['id_commande'];

if(filter_var($url, FILTER_VALIDATE_URL)){
    if($quantitie > 0){
        if($categorie != ""){
            if($price > 0){

                if(empty($id_commande)){

                    
                    $sql_select = $bdd->prepare("SELECT * FROM membres_panier WHERE id_membre=?");
                    $sql_select->execute(array(
                        $id_oo
                    ));
                    $ligne_pann = $sql_select->fetch();
                    $sql_select->closeCursor();
    if(empty($ligne_pann['id'])){
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
            }else{
                $panier_id = $ligne_pann['id'];
                if($ligne_pann['Titre_panier'] == 'Abonnement'){
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
                    $panier_id));                    
                $sql_update->closeCursor();

                $sql_delete = $bdd->prepare("DELETE FROM membres_panier_details WHERE id_membre=?");
                $sql_delete->execute(array($id_oo));
                $sql_delete->closeCursor();
                }
            }  
                   
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

                if(empty($user) && empty($id_oo)){
                    $_SESSION['id_ext'] = $_SESSION['id_commande'];
                    $id_oo = $_SESSION['id_ext'].'ext';
                    ///////////////////////////////UPDATE
			$sql_update = $bdd->prepare("UPDATE membres_panier SET
            id_membre=? 
            WHERE id=?");
        $sql_update->execute(array(
            $id_oo,
            $numero_panier));                    
        $sql_update->closeCursor();
                }
                
                }else{
                    $commande_id = $_SESSION['id_commande'];
                    $sql_select = $bdd->prepare("SELECT * FROM membres_commandes WHERE id=? AND user_id=?");
                $sql_select->execute(array($commande_id,$id_oo));
                $ligne_select = $sql_select->fetch();
                $sql_select->closeCursor();
                    $numero_panier = $ligne_select['panier_id'];

                    /*$sql_delete = $bdd->prepare("DELETE FROM membres_panier_details WHERE numero_panier=?");
            $sql_delete->execute(array($numero_panier));
            $sql_delete->closeCursor();

            $sql_delete = $bdd->prepare("DELETE FROM membres_commandes_details WHERE commande_id=?");
            $sql_delete->execute(array($commande_id));
            $sql_delete->closeCursor();*/
                }

                //ajout article
                $sql_insert = $bdd->prepare("INSERT INTO membres_commandes_details
                (url,
                categorie,
                quantite,
                couleur,
                taille,
                prix,
                commande_id)
                VALUES (?,?,?,?,?,?,?)");
                $sql_insert->execute(array(
                    htmlspecialchars($url),
                    htmlspecialchars($categorie),
                    htmlspecialchars($quantitie),
                    htmlspecialchars($color),
                    htmlspecialchars($size),
                    htmlspecialchars($price),
                    htmlspecialchars($commande_id)
                ));
                $sql_insert->closeCursor();

                $commande_detail = $bdd->lastInsertId();
                    
		    	$libelle = "Article $nbr";

                    //$base_TVA = 20;
                    
                    //$TVA = $prices[$i] - $PU_HT;
                    //creation du détail
                    $PU_HT = round($price);
                    $TVA = 0;

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
                            htmlspecialchars(strval($numero_panier)),
                            htmlspecialchars($libelle),
                            htmlspecialchars(strval(round($PU_HT))),
                            htmlspecialchars(strval(round($TVA))),
                            htmlspecialchars("1.18"),
                            htmlspecialchars($quantitie),
                            htmlspecialchars($categorie),
                            htmlspecialchars("Commande"),
                            htmlspecialchars($time),
                            $commande_detail
                        )
                    );
                    $sql_insert->closeCursor();

            
                $update = update_commande($commande_id);
                
                if($update){
                    $result = json_encode(array("Texte_rapport" => "Article ajouté !", "retour_validation" => "ok", "retour_lien" => "", "id_detail" => $commande_detail, "id_com" => $commande_id));
                    echo $result;
                }else{
                    $result = json_encode(array("Texte_rapport" => "Erreur !", "retour_validation" => "non", "retour_lien" => ""));
                    echo $result;
                }
                
            }else{
                $result = json_encode(array("Texte_rapport" => "Prix supérieur ou égale à 1 obligatoire", "retour_validation" => "non", "retour_lien" => ""));
                echo $result;
            }
        }else{
            $result = json_encode(array("Texte_rapport" => "Catégorie obligatoire !", "retour_validation" => "non", "retour_lien" => ""));
            echo $result;   
        }
    }else{
        $result = json_encode(array("Texte_rapport" => "Quantité supérieur ou égale à 1 obligatoire !", "retour_validation" => "non", "retour_lien" => ""));
        echo $result;   
    }
}else{
    $result = json_encode(array("Texte_rapport" => "Url obligatoire !", "retour_validation" => "non", "retour_lien" => ""));
    echo $result;
}
