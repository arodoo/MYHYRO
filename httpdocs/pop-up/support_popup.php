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

/////////////////////////////////AFFICHE POUR QUELLE PAGE ?
if( !isset($_GET['page']) ){

if( !isset($_GET['page'])){
$top_support = "12";
}else{
$top_support = "10";
}

?>

<div id="bloc_pop_up_support_container" class="triggerAnimation animated" data-animate="fadeInLeft" style="position:fixed; z-index:4; right:0px; top:<?php echo "$top_support"; ?>em; ">
	<div id="bloc_pop_up_support" style="height: 120px; width: 220px;" >
		<div class='bloc_retrait'></div>
		<div class="bloc_retrait_text triggerAnimation animated" data-animate="fadeInLeft">Besoin de conseil ou d'aide ?</div>
		<div class='bloc_telephone triggerAnimation animated' data-animate="fadeInRight"><i class="uk-icon-phone" style="font-size: 16px;" ></i> <?php echo "$telephone_fixe_ii"; ?></div>

		<div id="bloc_rappel_pop_up_formulaire" class="bloc_rappel_pop_up" style='margin-top: 5px;' ><span class='uk-icon-sign-in' ></span> On vous rappelle !</div>

		<div style="clear: both; margin-bottom: 10px;"></div>
	</div>
</div>

<?php
}
/////////////////////////////////AFFICHE POUR QUELLE PAGE ?
?>