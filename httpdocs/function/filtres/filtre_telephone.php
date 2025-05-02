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
function supptel($string){
$motif = "#[0-9][1-9]([-.,_/!?;'~:\`&=*+%^|{}à@azertyuiopqsdfghjklmwxcvbnéèçàù$£<>§ ]?[0-9]){7,8}#";
$remplace = "**********";
$string = preg_replace ($motif, $remplace, $string);
$output1 = trim($string);
return $output1;
}
///////////////////////////////////////FONCTION POUR SUPPRIMER TELEPHONE
//echo "<br /><br />".supptel($string)."";

?>