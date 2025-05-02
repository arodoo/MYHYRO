<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../Configurations_bdd.php');
require_once('../../Configurations.php');
require_once('../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction= "../../";
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

$email = $_POST['mail'];

if(!empty($email)){

	$array = explode('@', $email);
	$ap = $array[1];
	$domain = checkdnsrr($ap);

	if(!preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,4}$/", $email) && $domain == false
		|| !preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,4}$/", $email) && $domain != false
		|| preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,4}$/", $email) && $domain == false){
		$response = "Email invalide";

	} else {

		///////////////////////////////SELECT
		$req_select = $bdd->prepare("SELECT * FROM Newsletter_listing WHERE Mail=?");
		$req_select->execute(array($email));
		$ligne_select = $req_select->fetch();
		$req_select->closeCursor();

		$date=time();

		if(empty($ligne_select['id'])){

			///////////////////////////////INSERT
			$sql_insert = $bdd->prepare("INSERT INTO Newsletter_listing
				(Mail,
				Numero_id, 
				date)
				VALUES (?,?,?)");
			$sql_insert->execute(array(
				$email,
				sha1(uniqid()),
				$date));                     
			$sql_insert->closeCursor();

			$response = "Vous êtes inscrit à la newsletter !";

		}else{

			$response = "Déjà abonné à la newsletter !";

		}

	}

}else{

	$response = 0;

}

$result = json_encode($response);
echo $result;

ob_end_flush();
?>
