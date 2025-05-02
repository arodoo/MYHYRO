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

  $code_promo = $_POST['code_promo'];


if (!isset($code_promo) || empty($code_promo)) {
      echo "Code promo invalide. Veuillez réessayer.";
  } else {
      $sql = "SELECT * FROM codes_promotion WHERE Titre_promo = ?";
      $stmt = mysqli_prepare($connexion, $sql);
      if (!$stmt) {
          die("Erreur lors de la préparation de la requête : " . mysqli_error($connexion));
      }
      mysqli_stmt_bind_param($stmt, "s", $code_promo);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);

      if (mysqli_num_rows($result) > 0) {
          echo "Code promo valide. Appliquez la remise.";
      } else {
          echo "Code promo invalide. Veuillez réessayer.";
      }


      mysqli_stmt_close($stmt);
  }
  ?>