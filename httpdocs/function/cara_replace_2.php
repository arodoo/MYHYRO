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

$nouveaucontenu = str_replace("’","-", $nouveaucontenu);
$nouveaucontenu = str_replace("»","-", $nouveaucontenu);
$nouveaucontenu = str_replace("«","-", $nouveaucontenu);
$nouveaucontenu = str_replace("…","-", $nouveaucontenu);

$nouveaucontenu = str_replace("@","-", $nouveaucontenu);
$nouveaucontenu = str_replace("&","-", $nouveaucontenu);
$nouveaucontenu = str_replace("¨","-", $nouveaucontenu);
$nouveaucontenu = str_replace("|","-", $nouveaucontenu);
$nouveaucontenu = str_replace("%","-", $nouveaucontenu);
$nouveaucontenu = str_replace("§","-", $nouveaucontenu);
$nouveaucontenu = str_replace("_","-", $nouveaucontenu);
$nouveaucontenu = str_replace("\\","-", $nouveaucontenu);
$nouveaucontenu = str_replace("//","-", $nouveaucontenu);

$nouveaucontenu = str_replace(")","-", $nouveaucontenu);
$nouveaucontenu = str_replace("(","-", $nouveaucontenu);
$nouveaucontenu = str_replace("{","-", $nouveaucontenu);
$nouveaucontenu = str_replace("}","-", $nouveaucontenu);
$nouveaucontenu = str_replace("+","-", $nouveaucontenu);
$nouveaucontenu = str_replace("*","-", $nouveaucontenu);
$nouveaucontenu = str_replace("#","-", $nouveaucontenu);
$nouveaucontenu = str_replace("~","-", $nouveaucontenu);
$nouveaucontenu = str_replace("^","-", $nouveaucontenu);
$nouveaucontenu = str_replace("=","-", $nouveaucontenu);
$nouveaucontenu = str_replace("}","-", $nouveaucontenu);
$nouveaucontenu = str_replace("]","-", $nouveaucontenu);
$nouveaucontenu = str_replace("[","-", $nouveaucontenu);
$nouveaucontenu = str_replace("|","-", $nouveaucontenu);
$nouveaucontenu = str_replace("`","-", $nouveaucontenu);

$nouveaucontenu = str_replace("!","-", $nouveaucontenu);
$nouveaucontenu = str_replace("?","-", $nouveaucontenu);
$nouveaucontenu = str_replace(',',"-", $nouveaucontenu);
$nouveaucontenu = str_replace(';',"-", $nouveaucontenu);
$nouveaucontenu = str_replace(':',"-", $nouveaucontenu);
$nouveaucontenu = str_replace('"',"-", $nouveaucontenu);
$nouveaucontenu = str_replace("'","-", $nouveaucontenu); 
$nouveaucontenu = str_replace(" ","-", $nouveaucontenu);

$nouveaucontenu = str_replace("$","dollar", $nouveaucontenu);
$nouveaucontenu = str_replace("€","euros", $nouveaucontenu);

$nouveaucontenu = str_replace("ç","c", $nouveaucontenu);

$nouveaucontenu = str_replace("ñ","n", $nouveaucontenu);

$nouveaucontenu = str_replace("Ä","a", $nouveaucontenu);
$nouveaucontenu = str_replace("Â","a", $nouveaucontenu);
$nouveaucontenu = str_replace("À","a", $nouveaucontenu);
$nouveaucontenu = str_replace("Á","a", $nouveaucontenu);
$nouveaucontenu = str_replace("ä","a", $nouveaucontenu);
$nouveaucontenu = str_replace("â","a", $nouveaucontenu);
$nouveaucontenu = str_replace("à","a", $nouveaucontenu);
$nouveaucontenu = str_replace("á","a", $nouveaucontenu);

$nouveaucontenu = str_replace("Ë","e", $nouveaucontenu);
$nouveaucontenu = str_replace("Ê","e", $nouveaucontenu);
$nouveaucontenu = str_replace("È","e", $nouveaucontenu);
$nouveaucontenu = str_replace("É","e", $nouveaucontenu);
$nouveaucontenu = str_replace("é","e", $nouveaucontenu);
$nouveaucontenu = str_replace("è","e", $nouveaucontenu);
$nouveaucontenu = str_replace("ë","e", $nouveaucontenu);
$nouveaucontenu = str_replace("ê","e", $nouveaucontenu);

$nouveaucontenu = str_replace("Ï","i", $nouveaucontenu);
$nouveaucontenu = str_replace("Î","i", $nouveaucontenu);
$nouveaucontenu = str_replace("Ì","i", $nouveaucontenu);
$nouveaucontenu = str_replace("Í","i", $nouveaucontenu);
$nouveaucontenu = str_replace("ï","i", $nouveaucontenu);
$nouveaucontenu = str_replace("î","i", $nouveaucontenu);
$nouveaucontenu = str_replace("ì","i", $nouveaucontenu);
$nouveaucontenu = str_replace("í","i", $nouveaucontenu);

$nouveaucontenu = str_replace("Ö","o", $nouveaucontenu);
$nouveaucontenu = str_replace("Ô","o", $nouveaucontenu);
$nouveaucontenu = str_replace("Ò","o", $nouveaucontenu);
$nouveaucontenu = str_replace("Ó","o", $nouveaucontenu);
$nouveaucontenu = str_replace("ö","o", $nouveaucontenu);
$nouveaucontenu = str_replace("ô","o", $nouveaucontenu);
$nouveaucontenu = str_replace("ò","o", $nouveaucontenu);
$nouveaucontenu = str_replace("ó","o", $nouveaucontenu);
$nouveaucontenu = str_replace("œ","oe", $nouveaucontenu);

$nouveaucontenu = str_replace("Ü","u", $nouveaucontenu);
$nouveaucontenu = str_replace("Û","u", $nouveaucontenu);
$nouveaucontenu = str_replace("Ù","u", $nouveaucontenu);
$nouveaucontenu = str_replace("Ú","u", $nouveaucontenu);
$nouveaucontenu = str_replace("ü","u", $nouveaucontenu);
$nouveaucontenu = str_replace("û","u", $nouveaucontenu);
$nouveaucontenu = str_replace("ù","u", $nouveaucontenu);
$nouveaucontenu = str_replace("ú","u", $nouveaucontenu);
$nouveaucontenu = str_replace("µ","u", $nouveaucontenu);

$nouveaucontenu = str_replace("<","-", $nouveaucontenu);
$nouveaucontenu = str_replace(">","-", $nouveaucontenu);

?>
