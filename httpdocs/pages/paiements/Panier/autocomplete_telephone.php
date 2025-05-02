<?php
ob_start();
session_start();
header('Content-Type: application/json');
require_once('../../../Configurations_bdd.php');
require_once('../../../Configurations.php');
require_once('../../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction = "../../../";
require_once('../../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

$lasturl = $_SERVER['HTTP_REFERER'];

// Utiliser l'id_membre envoyé en GET ou, en cas d'absence, celui de la session
if (isset($_GET['id_membre']) && !empty($_GET['id_membre'])) {
    $id_membre = $_GET['id_membre'];
} else {
    echo json_encode([]);
    exit;
}

$req = $bdd->prepare("SELECT telephone FROM membres_telephone_artiel WHERE id_membre = ? ORDER BY created_at DESC");
$req->execute(array($id_membre));
$telephones = $req->fetchAll(PDO::FETCH_COLUMN);
$req->closeCursor();

ob_clean();
echo json_encode($telephones);
ob_end_flush();
