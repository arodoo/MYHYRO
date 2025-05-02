<?php
include('function/erreurs-php/affichage_erreurs_php.php');

  $cfgHote       = "localhost";
  $cfgUser       = "greenflore";
  $cfgPass       = "Be68RFbnI01nzHj5";
  $cfgBase       = "greenflore";

///////////////////////////////CONNEXION

if (!isset($connexion) && !isset($db)){
	$connexion = mysql_connect($cfgHote, $cfgUser, $cfgPass) or die("Connexion au serveur mysql impossible...");
	$db = mysql_select_db($cfgBase, $connexion) or die("Selection de la bdd impossible...");
	try{
	    $bdd = new PDO('mysql:host='.$cfgHote.';dbname='.$cfgBase.';charset=utf8', $cfgUser, $cfgPass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}
	catch (Exception $e){
	    die('Erreur : ' . $e->getMessage());
	}
}

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM configurations_publicites WHERE id=?");
$req_select->execute(array($idaction));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
echo $ligne_select['id'];

///////////////////////////////UPDATE
$sql_update = $bdd->prepare("UPDATE configurations_publicites SET 
	type_page=? 
	WHERE id=?");
$sql_update->execute(array(
	"ok",
	"1"));                     
$sql_update->closeCursor();

///////////////////////////////INSERT
$sql_insert = $bdd->prepare("INSERT INTO configurations_publicites
	(id,
	type_page)
	VALUES (?,?)");
$sql_insert->execute(array(
	"",
	"ok"));                     
$sql_insert->closeCursor();

///////////////////////////////SELECT BOUCLE
$req_boucle = $bdd->prepare("SELECT * FROM configurations_publicites 
	WHERE type_page=? 
	ORDER by id");
$req_boucle->execute(array(
	"ok"));
while($ligne_boucle = $req_boucle->fetch()){
	echo $ligne_boucle['id'];
	echo "<br />";
}
$req_boucle->closeCursor();

///////////////////////////////DELETE
$sql_delete = $bdd->prepare("DELETE FROM configurations_publicites WHERE id=?");
$sql_delete->execute(array($idaction));                     
$sql_delete->closeCursor();


?>