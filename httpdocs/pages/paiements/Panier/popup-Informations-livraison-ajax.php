<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../../Configurations_bdd.php');
require_once('../../../Configurations.php');
require_once('../../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction = "../../../";
require_once('../../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

// Recogida de datos con el prefijo "modal_"
$modal_pays        = trim($_POST['modal_pays'] ?? '');
$modal_nom         = trim($_POST['modal_nom'] ?? '');
$modal_prenom      = trim($_POST['modal_prenom'] ?? '');
$modal_mail        = trim($_POST['modal_mail'] ?? '');
$modal_portable    = trim($_POST['modal_portable'] ?? '');
$modal_fixe        = trim($_POST['modal_fixe'] ?? '');
$modal_adresse     = trim($_POST['modal_adresse'] ?? '');
$modal_code_postal = trim($_POST['modal_code_postal'] ?? '');
$modal_ville       = trim($_POST['modal_ville'] ?? '');
$modal_complement  = trim($_POST['modal_complement'] ?? '');



$result = array();

if (!empty($id_oo) && !empty($user)) {
    try {

        $stmt = $bdd->prepare("SELECT COUNT(*) as count FROM membres_informations_livraison WHERE id_membre = ?");
        $stmt->execute(array($id_oo));
        $row = $stmt->fetch();
        $stmt->closeCursor();

        if ($row['count'] >= 4) {
            $result = array(
                "Texte_rapport"     => "Vous ne pouvez pas ajouter plus de 4 adresses.",
                "retour_validation" => "error",
                "retour_lien"       => ""
            );
        } else {
            $sql_insert = $bdd->prepare("
                INSERT INTO membres_informations_livraison 
                (id_membre, pseudo, pays, nom, prenom, mail, portable, fixe, adresse, code_postal, ville, Complement)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $sql_insert->execute(array(
                $id_oo,
                $user,
                $modal_pays,
                $modal_nom,
                $modal_prenom,
                $modal_mail,
                $modal_portable,
                $modal_fixe,
                $modal_adresse,
                $modal_code_postal,
                $modal_ville,
                $modal_complement
            ));

            $sql_insert->closeCursor();

            $result = array(
                "Texte_rapport"     => "Les informations de livraison ont été enregistrées avec succès.",
                "retour_validation" => "ok",
                "retour_lien"       => ""
            );
        }
    } catch (Exception $e) {
        $result = array(
            "Texte_rapport"     => "Erreur lors de l'enregistrement" ,
            "retour_validation" => "error",
            "retour_lien"       => ""
        );
    }
} else {
    $result = array(
        "Texte_rapport"     => "Impossible d'enregistrer.",
        "retour_validation" => "error",
        "retour_lien"       => ""
    );
}


echo json_encode($result);
ob_end_flush();
?>
