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

///////////////////////////////////////FONCTION POUR CREATION LIEN AUTOMATIQUE
function autolien($string){
$content_array = explode(" ", $string);
$output1 = '';
foreach($content_array as $content1){
if(substr(trim($content1), 0, 7) == "http://"){
$content1 = '<a href="' . $content1 . '" target="blank_">' . $content1 . '</a>';
}
if(substr(trim($content1), 0, 8) == "https://"){
$content1 = '<a href="' . $content1 . '" target="blank_" >' . $content1 . '</a>';
}
if(substr(trim($content), 0, 4) == "www."){
$content1 = '<a href="' . $content1 . '" target="blank_">' . $content1 . '</a>';
}
$output1 .= " " . $content1;
}
$output1 = trim($output1);
return $output1;
}
///////////////////////////////////////FONCTION POUR CREATION LIEN AUTOMATIQUE
//echo "".autolien($string)."";

?>