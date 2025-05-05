<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../../Configurations_bdd.php');
require_once('../../../Configurations.php');
require_once('../../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction = "../../";
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

$idCommande = $_POST['idCommande'];

//var_dump($champ,$value, $id);
if (isset($user)) {



        //var_dump($idCommande);

        $req_boucle = $bdd->prepare("SELECT * FROM membres_commandes_details WHERE commande_id=? ORDER BY id DESC");
        $req_boucle->execute(array($idCommande));
        while ($ligne_boucle = $req_boucle->fetch()) {

            $sql_update = $bdd->prepare("UPDATE membres_commandes_details SET
        couleur=?,
        taille=?,
        categorie=?,
        quantite=?,
        disponibilite=?,
        nom=?,
        num_commande_site=?,
        ref_produit_site=?,
        prix_reel=?,
        annule=?
        WHERE id=?");

        $sql_update->execute(
            array(
                $_POST['couleur'.$ligne_boucle['id']],
                $_POST['taille'.$ligne_boucle['id']],
                $_POST['categorie'.$ligne_boucle['id']],
                $_POST['quantite'.$ligne_boucle['id']],
                $_POST['disponibilite'.$ligne_boucle['id']],
                $_POST['nom'.$ligne_boucle['id']],
                $_POST['num_commande_site'.$ligne_boucle['id']],
                $_POST['ref_produit_site'.$ligne_boucle['id']],
                round($_POST['prix_reel'.$ligne_boucle['id']] / 0.00152449),
                $_POST['annule'.$ligne_boucle['id']],
                intval($ligne_boucle['id'])
            )
        );
        $sql_update->closeCursor();

        }
        $req_boucle->closeCursor();



        /*/$sql_update = $bdd->prepare("UPDATE membres_commandes_details SET
        $champ = ?
        WHERE id=?");

        $sql_update->execute(
            array(
                $value,
                intval($id)
            )
        );
        $sql_update->closeCursor();*/

        $in = false;
        $req_boucle = $bdd->prepare("SELECT * FROM membres_commandes_details WHERE commande_id=? AND (annule != 'oui' OR annule is null) AND (disponibilite != 'Non disponible' OR disponibilite is null) ORDER BY id DESC");
        $req_boucle->execute(array($idCommande));
        while ($ligne_boucle = $req_boucle->fetch()) {
$in = true;
            if(!empty($ligne_boucle['prix_reel'])){
                $prix_reel = $ligne_boucle['prix_reel'] * $ligne_boucle['quantite'];
            }else{
                $prix_reel = $ligne_boucle['prix'] * $ligne_boucle['quantite'];
            }

            $sous_total_reel = $sous_total_reel + $prix_reel;
            //var_dump($sous_total_reel);

            ///////////////////////////////Douane et transport commande normale
		$req_select = $bdd->prepare("SELECT * FROM categories WHERE nom_categorie=?");
		$req_select->execute(array($ligne_boucle['categorie']));
		$categorie = $req_select->fetch();
		$req_select->closeCursor();
		$prix_expedition = (($ligne_boucle['quantite']*$ligne_boucle['prix_reel'])*($categorie['value_commande']/100)); //$ligne_boucle['quantite']*
		$prix_expedition = round($prix_expedition,0);
		$prix_expedition_total = ($prix_expedition_total+$prix_expedition);

		
        }
        $req_boucle->closeCursor();

        

        

        //$sous_total_reel = round($sous_total_reel / 0.00152449);

        $req_select = $bdd->prepare("SELECT * FROM membres_commandes WHERE id=?");
        $req_select->execute(array($idCommande));
        $ligne_select2 = $req_select->fetch();
        $req_select->closeCursor();


            $prix_total = $ligne_select2['prix_total'];
    
            $sous_total = $ligne_select2['sous_total'];

        /*if($ligne_select2['douane_a_la_liv'] == 'oui'){
            $prix_expedition = $ligne_select2['prix_expedition_reel'] ? $ligne_select2['prix_expedition_reel'] : $ligne_select2['dette_montant'];
            
        }else{
            $prix_expedition = $ligne_select2['prix_expedition_reel'] ? $ligne_select2['prix_expedition_reel'] : $ligne_select2['prix_expedition'];
        }*/

        $prix_total_reel = $sous_total_reel + $ligne_select2['frais_livraison'] + $ligne_select2['frais_gestion'] + $ligne_select2['tva'] + $prix_expedition_total;


        
        if(!$in){
            $sous_total_reel = '0';
            $prix_total_reel = '0';
            $prix_expedition_total = '0';
        }

        $sql_update = $bdd->prepare("UPDATE membres_commandes SET
        sous_total = ?,
        prix_total = ?,
        prix_expedition = ?
        WHERE id=?");

        $sql_update->execute(
            array(
                $sous_total_reel,
                $prix_total_reel,
                $prix_expedition_total,
                intval($idCommande)
            )
        );
        $sql_update->closeCursor();

        $result = array("Texte_rapport" => "Modifié!", "retour_validation" => "ok", "retour_lien" => "");
    
    $result = json_encode($result);
    echo $result;
} else {
    header('location: /index.html');
}

ob_end_flush();
?>