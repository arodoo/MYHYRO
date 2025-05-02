<?php

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

// Affichage des erreurs
$type_gestion = 1; // 1=>mode debug, 2=>mode production (erreur dans log/error.log), 0=>Aucun traitement
switch ($type_gestion) {
    case '1':
        if (PHP_VERSION_ID < 50400) error_reporting (E_ALL | E_STRICT);
        else error_reporting (E_ERROR | E_WARNING | E_PARSE);
        //else error_reporting (E_ALL);
	ini_set('display_errors', true);
	ini_set('html_errors', false);
	ini_set('display_startup_errors',true);		  
        ini_set('log_errors', false);
	ini_set('error_prepend_string','<span style="color: red;">');
	ini_set('error_append_string','<br /></span>');
	ini_set('ignore_repeated_errors', true);
    break;
    case '2': 
        error_reporting (E_ALL);
	ini_set('display_errors', false);
	ini_set('html_errors', false);
	ini_set('display_startup_errors',false);
	ini_set('log_errors', true);
	ini_set('error_log', CHG_ROOT_PATH.'log/error.log');
	ini_set('error_prepend_string','<span style="color: red;">');
	ini_set('error_append_string','</span>');
	ini_set('ignore_repeated_errors', true);
    break;
    default:
	error_reporting (E_ALL);
	ini_set('display_errors', false);
	ini_set('html_errors', false);
	ini_set('display_startup_errors',false);
	ini_set('log_errors', false);
}
?>