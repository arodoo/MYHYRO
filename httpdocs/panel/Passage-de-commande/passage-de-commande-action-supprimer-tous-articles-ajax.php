<?php
ob_start();
require_once('../../Configurations_bdd.php');
require_once('../../Configurations.php');
require_once('../../Configurations_modules.php');
require_once('../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

$idCommande = $_POST['idCommande'];
$articleIds = $_POST['articleIds'];

if (isset($idCommande) && !empty($articleIds)) {
    foreach ($articleIds as $idArticle) {
        $sql_delete = $bdd->prepare("DELETE FROM membres_commandes_details WHERE id=?");
        $sql_delete->execute(array($idArticle));
        $sql_delete->closeCursor();

        $sql_delete = $bdd->prepare("DELETE FROM membres_panier_details WHERE id_commande_detail=?");
        $sql_delete->execute(array($idArticle));
        $sql_delete->closeCursor();
    }

    $sql_select = $bdd->prepare("SELECT * FROM membres_commandes_details WHERE commande_id=?");
    $sql_select->execute(array($idCommande));
    $articles = $sql_select->fetch();
    $sql_select->closeCursor();

    if ($articles) {
        $update = update_commande($idCommande);

        if ($update) {
            $result = json_encode(array("Texte_rapport" => "Articles supprim�s !", "retour_validation" => "ok", "retour_lien" => ""));
            echo $result;
        } else {
            $result = json_encode(array("Texte_rapport" => "Erreur !", "retour_validation" => "non", "retour_lien" => ""));
            echo $result;
        }
    } else {
        $sql_select = $bdd->prepare("SELECT * FROM membres_commandes WHERE id=?");
        $sql_select->execute(array($idCommande));
        $commande = $sql_select->fetch();
        $sql_select->closeCursor();

        $sql_delete = $bdd->prepare("DELETE FROM membres_panier_details WHERE numero_panier=?");
        $sql_delete->execute(array($commande['panier_id']));
        $sql_delete->closeCursor();

        $sql_delete = $bdd->prepare("DELETE FROM membres_panier WHERE id=?");
        $sql_delete->execute(array($commande['panier_id']));
        $sql_delete->closeCursor();

        $sql_delete = $bdd->prepare("DELETE FROM membres_commandes WHERE id=?");
        $sql_delete->execute(array($idCommande));
        $sql_delete->closeCursor();

        unset($_SESSION['id_commande']);
        unset($_SESSION['saved']);
        unset($_SESSION['action']);
        $result = json_encode(array("Texte_rapport" => "Panier supprim� !", "retour_validation" => "ok", "retour_lien" => "/"));
        echo $result;
    }
} else {
    $result = json_encode(array("Texte_rapport" => "Erreur !", "retour_validation" => "non", "retour_lien" => ""));
    echo $result;
}
?>