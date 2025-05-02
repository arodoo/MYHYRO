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

//ICON EXEMPLE : info-circle warning plus-circle times exclamation-circle exclamation-triangle
//METHODE echo rapport_bloc("info-circle",0,"red","10","Mon contenu"); // RETURN => $rapport_bloc;

function rapport_bloc($type_icon,$border_radius,$background_color,$padding_bloc,$rapport_contenu){

$rapport_bloc = "
<script>
function supprimer_bloc(){
document.getElementById('rapport_bloc_informations').style.display='none';
}
</script>
<div id='rapport_bloc_informations' style='width: 100%; background-color: ".$background_color."; color: white; border-radius: ".$border_radius."px; margin-bottom: 20px; text-align: left;'>
<div style='padding: ".$padding_bloc."px;'>
<span class='uk-icon-".$type_icon."' ></span> 
".$rapport_contenu."
<a href='javascript:supprimer_bloc();'><span class='uk-icon-times' style='float: right; color: white;'></span></a>
</div>
</div>
";

return $rapport_bloc;

}

?>