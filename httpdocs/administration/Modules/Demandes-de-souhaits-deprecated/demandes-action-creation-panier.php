<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../../Configurations_bdd.php');
require_once('../../../Configurations.php');
require_once('../../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction = "../../../";
require_once('../../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

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
$userId = $_POST['userId'];
$pseudo = $_POST['pseudo'];
$tarif_TTC_article = $_POST['price'];
$libelle = $_POST['libelle'];

if (isset($user)) {
    if(isset($id) || isset($userId) || isset($pseudo) || isset($price) || isset($libelle)){
        if($tarif_TTC_article > 0){
            $time = strval(time());

            $req_select = $bdd->prepare("SELECT * FROM membres WHERE id=?");
            $req_select->execute(array(
                $userId
            ));
            $membre = $req_select->fetch();
            $req_select->closeCursor();

            $req_select = $bdd->prepare("SELECT * FROM configurations_abonnements WHERE id=?");
            $req_select->execute(array(
                $membre['Abonnement_id']
            ));
            $abonnement = $req_select->fetch();
            $req_select->closeCursor();
            
            $tarif_TTC = $tarif_TTC_article;
            if($abonnement['Liste_de_souhaits'] != "Gratuit"){
                $tarif_TTC += intval($abonnement['Liste_de_souhaits']);
            }
            if($abonnement['Frais_de_passage_d_une_commande'] != "Gratuit"){
                $tarif_TTC += intval($abonnement['Frais_de_passage_d_une_commande']);
            }

            $tarif_TTC += intval($abonnement['Frais_de_gestion_d_une_commande']);

            $base_TVA = 20;
            $tarif_HT = (100*intval($tarif_TTC))/(100+$base_TVA);
            $tarif_HT_net = (100*intval($tarif_TTC))/(100+$base_TVA);
            $Total_TVA = $tarif_TTC - $tarif_HT;

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
                    htmlspecialchars(strval($userId)),
                    htmlspecialchars(strval($pseudo)),
                    htmlspecialchars("Commande provenant d'une liste de souhait"),
                    htmlspecialchars("Commande provenant d'une liste de souhait"),
                    htmlspecialchars("non traite"),
                    htmlspecialchars($time),
                    htmlspecialchars(strval(round($tarif_HT, 2))),
                    htmlspecialchars(strval(round($tarif_HT_net, 2))),
                    htmlspecialchars(strval(round($tarif_TTC,2))),
                    htmlspecialchars(strval(round($Total_TVA,2))),
                    htmlspecialchars("1.20")
                )
            );
            $sql_insert->closeCursor();

            $sql_select = $bdd->prepare("SELECT * FROM membres_panier WHERE id_membre=? AND pseudo=? AND Tarif_TTC=? AND date_edition=?");
            $sql_select->execute(array(
                htmlspecialchars(strval($userId)),
                htmlspecialchars(strval($pseudo)),
                htmlspecialchars(strval(round($tarif_TTC,2))),
                htmlspecialchars($time)
            ));
            $ligne_select = $sql_select->fetch();
            $sql_select->closeCursor();

            $sql_update = $bdd->prepare("UPDATE membres_commandes SET
            statut=?,
            type=?,
            panier_id=?,
            prix=?
            WHERE id=?");
        
            $sql_update->execute(
                array(
                    intval(3),
                    intval(2),
                    htmlspecialchars(strval($ligne_select['id'])),
                    htmlspecialchars($tarif_TTC),
                    intval($id)
                )
            );
            $sql_update->closeCursor();

            
            //AJOUTER UNE LIGNE DANS MEMBRES_PANIER_DETAIL


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
            action_module_service_produit,
            date)
            VALUES (?,?,?,?,?,?,?,?,?,?)");
        
            $sql_insert->execute(
                array(
                    htmlspecialchars(strval($userId)),
                    htmlspecialchars(strval($pseudo)),
                    htmlspecialchars(strval($ligne_select['id'])),
                    htmlspecialchars($libelle),
                    htmlspecialchars(strval(round($tarif_HT, 2))),
                    htmlspecialchars(strval(round($Total_TVA,2))),
                    htmlspecialchars("1.20"),
                    htmlspecialchars("1"),
                    htmlspecialchars("Commande"),
                    htmlspecialchars($time)
                )
            );
            $sql_insert->closeCursor();
            

            $result = array("Texte_rapport" => "Panier créé !", "retour_validation" => "ok", "retour_lien" => "");
        }else{
            $result = array("Texte_rapport" => "Le prix doit être supérieur à 0€", "retour_validation" => "non", "retour_lien" => "");
        }
        
    }else{
        $result = array("Texte_rapport" => "Erreur", "retour_validation" => "non", "retour_lien" => "");
    }
    
    $result = json_encode($result);
    echo $result;
} else {
    header('location: /index.html');
}

ob_end_flush();
?>