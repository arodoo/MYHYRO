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

?>

<script>

function attentenojs(){
var div = document.getElementById('attente');
div.style.display = "none";
}

function attentejs(){
var div = document.getElementById('attente');
div.style.display = "";
}

function Timer(){
document.location.replace("<?php echo "$http"; ?><?php echo "$nomsiteweb"; ?>");
}
</script>

<!-- Page d'affichage de la déconnection -->
<div id='attente' style='top: 0; right: 0; bottom: 0; left: 0; display: none; position: fixed; width: 100%; height: 100%; background-color: black; filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70; z-index: 99999999; text-align: center;'>
<div style='font-size: 24px; color: white; width: 300px; margin-top: 200px; margin-left: auto; margin-right: auto;'>
Veuillez patienter pendant le chargement ...
</div>
</div>
<!-- Page d'affichage de la déconnection -->