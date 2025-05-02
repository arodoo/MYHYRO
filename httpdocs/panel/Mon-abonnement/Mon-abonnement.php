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

<?php
if(!empty($_SESSION['4M8e7M5b1R2e8s']) && !empty($user)){
?>

<div class="row" >

	<?php
	include('panel/menu.php');
	?>

	<div class="col-12 col-lg-9 mt-4 mt-lg-0">
	
		<?php
		include('panel/include-abonnements-en-cours.php');
		?>

	</div>

</div>

<?php
}else{
header('location: /index.html');
}
?>