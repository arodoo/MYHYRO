<?php
header("HTTP/1.0 410 Gone");

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

<div style='margin-left: auto; margin-right: auto; width: 100%; margin-top: 40px;' align='center'>
<h1 style='font-size: 48px;'>Page inexistante</h1><br /><br /><br /><br />

<p style='text-align: center; font-size: 24px;'>
Veuillez nous excuser, la page <b><?php echo $_SESSION['pageencoursnew404']; ?></b> n'existe pas.<br /><br /><br />

<!-- Plusieurs solutions possible:<br /><br /><br /> -->
Plusieurs raisons possibles:<br /><br /><br />

- L'adresse de l'url n'existe plus,<br /><br />
- Il y a une erreur dans l'adresse de l'url,<br /><br />
<!-- - Soit elle a été déplacée par nos services.</p><br /><br /> -->
- Elle a été déplacée par nos services.</p><br /><br />

<a href='<?php echo "$http"; ?><?php echo "$nomsiteweb"; ?>' style='text-decoration: none; font-size: 18px; color: <?php echo "$couleurbordure"; ?>'>Retourner sur le site ici</a>
</div><br /><br />
