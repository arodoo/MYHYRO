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

unset($_SESSION['pageencoursnew404']);

$pageencoursm4044 = $_SERVER['REQUEST_URI'];
$pageencoursm4044 = utf8_decode(urldecode($pageencoursm4044)); 

$pageencoursnewm4044 = explode("/", $pageencoursm4044);
$pageencoursnewm4044 = $pageencoursnewm4044['1'];

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM pages_404 WHERE ancienne_page=?");
$req_select->execute(array($pageencoursnewm4044));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$id404rapport = $ligne_select['id'];

if(isset($id404rapport) && !empty($id404rapport)){
unset($_SESSION['pageencoursnew404']);
$_SESSION['pageencoursnew404'] = "$pageencoursnewm4044";
$p404_existe = "oui";
}
?>