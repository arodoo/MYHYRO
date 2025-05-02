<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../../../Configurations_bdd.php');
require_once('../../../../Configurations.php');
require_once('../../../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction= "../../../../";
require_once('../../../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

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

// if(isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) ){

$idaction = $_POST['idaction'];

/*$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$mail = $_POST['mail'];
$Telephone_portable = $_POST['Telephone_portable'];
$Telephone = $_POST['Telephone'];*/
$nom = $_POST['nom_liv_france'];
$prenom = $_POST['prenom_liv_france'];
$adresse = $_POST['adresse_liv_france'];
$ville = $_POST['ville_liv_france'];
$telephone = $_POST['telephone_liv_france'];
$cp = $_POST['cp_liv_france'];
$complement_adresse = $_POST['complement_adresse_liv_france'];


/*if(!empty($mail) && preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,4}$/", $mail)){
  $array = explode('@', $mail);
  $ap = $array[1];
  $domain = checkdnsrr($ap);
}*/

/////CONTRÔLE SI MAIL EXISTE PAS
///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM membres WHERE pseudo!=? AND mail=?");
$req_select->execute(array($user,$mail));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$id_mail_existe = $ligne_select['id'];

// if(empty($id_mail_existe) && preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,4}$/", $mail) && $domain == true && !empty($nom) && !empty($prenom) && !empty($mail) && !empty($adresse) && !empty($ville) && !empty($cp) && 
// ($configurations_informations_champs_professionnels == "" || $configurations_informations_champs_professionnels == "non" ) ||
// ($configurations_informations_champs_professionnels == "oui" && $configurations_informations_champs_professionnels_obligatoire == ""  || $configurations_informations_champs_professionnels_obligatoire == "non" ) || 
// (!empty($Nom_societe) && !empty($Numero_identification) && $configurations_informations_champs_professionnels == "oui" && $configurations_informations_champs_professionnels_obligatoire == "oui") ){

/*if(empty($id_mail_existe) && preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,4}$/", $mail) && $domain == true && !empty($nom) && !empty($prenom) && !empty($mail) && !empty($adresse) && !empty($ville) && !empty($cp)) {

if(!empty($cp)){
$departement = substr($cp,0,2);
}*/
if(empty($adresse) || empty($ville) || empty($cp) || empty($telephone)|| empty($nom)|| empty($prenom)){
$result = array("Texte_rapport"=>"Les champs précédés d'une étoile doivent êtres remplis !","retour_validation"=>"","retour_lien"=>"");
}else{
//////////////////////REQUETE UPDATE TABLE MEMBRES
///////////////////////////////UPDATE

$req_select = $bdd->prepare("SELECT * FROM membres_adresse_liv_france WHERE id_membre=?");
$req_select->execute(array($id_oo));
$ligne_select2 = $req_select->fetch();
$req_select->closeCursor();

if($ligne_select2){
  $sql_update = $bdd->prepare("UPDATE membres_adresse_liv_france SET
  nom_liv_france=?,
  prenom_liv_france=?,
	adresse_liv_france=?,
	telephone_liv_france=?,
  ville_liv_france=?,
  cp_liv_france=?,
  complement_adresse_liv_france=?
	WHERE pseudo=?");
$sql_update->execute(array(
  $nom,
  $prenom,
	$adresse,
	$telephone,
  $ville,
  $cp,
  $complement_adresse,
	$user));
$sql_update->closeCursor();
}else{
          //Ajout en BDD de la commande dans membres_commande
          $sql_insert = $bdd->prepare("INSERT INTO membres_adresse_liv_france
          (
          id_membre,
          pseudo,
          nom_liv_france,
          prenom_liv_france,
          adresse_liv_france,
          telephone_liv_france,
          ville_liv_france,
          cp_liv_france,
          complement_adresse_liv_france)
          VALUES (?,?,?,?,?,?,?,?,?)");

      $sql_insert->execute(array(
          $id_oo,
          htmlspecialchars($user),
          $nom,
          $prenom,
          htmlspecialchars($adresse),
          htmlspecialchars($telephone),
          htmlspecialchars($ville),
          htmlspecialchars($cp),
          htmlspecialchars($complement_adresse)
      ));
      $sql_insert->closeCursor();
}



$result = array("Texte_rapport"=>"Modifié avec succès !","retour_validation"=>"ok","retour_lien"=>"");
}
///////MAIL EXISTE


$result = json_encode($result);
echo $result;

// }

ob_end_flush();
?>