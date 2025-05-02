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

///////////////////////////////////////FONCTION POUR SUPPRIMER TELEPHONE
function suppmail($string){
$motif = "`\w(?:[-_.]?\w)*@\w(?:[-_.]?\w)*\.(?:[a-z]{2,4})`";
$remplace = "**********";
$string = preg_replace ($motif, $remplace, $string);

//ON RETIRE @ - AROBASE
$content_array = explode(" ", $string);
foreach($content_array as $content1){
if(substr($content1, 0, 1) == "@" || substr($content1, 0, 7) ==  "AROBASE" || substr($content1, 0, 7) ==  "arobase"){
$content1 = '*******';
}
$output1 .= " ".$content1;
}
//ON RETIRE @ - AROBASE

$output1 = trim($output1);

return $output1;
}
///////////////////////////////////////FONCTION POUR SUPPRIMER TELEPHONE
//echo "<br /><br />".suppmail($string)."";

?>