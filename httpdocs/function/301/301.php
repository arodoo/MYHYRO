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

$pageencoursm301 = $_SERVER['REQUEST_URI'];
$pageencoursuuuuooi = $pageencoursm301; 

$pageencoursuuuuooi = explode("".$http."$nomsiteweb", $pageencoursuuuuooi);
$pageencoursuuuuooi = $pageencoursuuuuooi['0'];

/////////Si page avec number page
///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM pages_redirections_301 WHERE ancienne_page=?");
$req_select->execute(array($pageencoursuuuuooi));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$id301 = $ligne_select['id'];	
$nouvelle_page301 = $ligne_select['nouvelle_page'];

if(!empty($id301)){
header("HTTP/1.0 301 Moved Permanently");     
header("Location: /$nouvelle_page301");      
exit();
}

?>