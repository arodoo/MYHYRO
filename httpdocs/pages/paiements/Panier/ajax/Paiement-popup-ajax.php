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

  if (!empty($user)) {
    if (isset($_POST['idaction'])) {
        $idAction = $_POST['idaction'];

        // Vous pouvez effectuer un traitement en fonction de la valeur de $idAction ici.

        // Par exemple, générez une réponse HTML en fonction de $idAction.
        $response = '<div class="popup-content">';
        $response .= '<h2>Page de paiement</h2>';
        $response .= '<p>Contenu de la page de paiement pour l\'action avec l\'ID : ' . $idAction . '</p>';
        $response .= '</div>';

        // Renvoyez la réponse au format HTML.
        echo $response;
    } else {
        // Si l'identifiant d'action n'a pas été transmis, renvoyez une réponse d'erreur.
        echo 'Erreur : Identifiant d\'action non spécifié.';
    }
} else {
    echo "Vous devez vous identifier";
}
?>
