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

function create_password($length=8,$use_upper=1,$use_lower=1,$use_number=1,$use_custom=""){
    $upper = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $lower = "abcdefghijklmnopqrstuvwxyz";
    $number = "0123456789";
    if($use_upper){
        $seed_length += 26;
        $seed .= $upper;
    }
    if($use_lower){
        $seed_length += 26;
        $seed .= $lower;
    }
    if($use_number){
        $seed_length += 10;
        $seed .= $number;
    }
    if($use_custom){
        $seed_length +=strlen($use_custom);
        $seed .= $use_custom;
    }
    for($x=1;$x<=$length;$x++){
        $password .= $seed{rand(0,$seed_length-1)};
    }
    return($password);
}
?>