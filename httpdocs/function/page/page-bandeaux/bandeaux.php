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

function page_bandeaux(){

global $bdd;

$pageencours = urlencode($_SERVER['REQUEST_URI']);
$pageencours = urldecode($pageencours); 
$pageencours = utf8_decode($pageencours);

$pageencoursnew_len = strlen($pageencours);
$pageencoursnew = substr($pageencours,1);

///////////////////////////////SELECT BOUCLE
$req_boucle = $bdd->prepare("SELECT * FROM pages_bandeaux WHERE page_bandeau=?");
$req_boucle->execute(array($pageencoursnew));
while($ligne_boucle = $req_boucle->fetch()){
$id = $ligne_boucle['id'];
$page_bandeau = $ligne_boucle['page_bandeau'];
$activer_bandeau_page = $ligne_boucle['activer_bandeau_page'];
$type_bandeau_page = $ligne_boucle['type_bandeau_page'];
$type_cible_page = $ligne_boucle['type_cible_page'];
$type_icone_page = $ligne_boucle['type_icone_page'];
$contenu_bandeau_page = $ligne_boucle['contenu_bandeau_page'];

if(
$activer_bandeau_page == "oui" && $type_cible_page == "Utilisateurs identifiés" && !empty($user) ||
$activer_bandeau_page == "oui" && $type_cible_page == "Tout le monde" ||
$activer_bandeau_page == "oui" && $type_cible_page == $id_statut_compte_membre && !empty($user)
){
?>

<div class="container">
<div class="alert <?php echo "$type_bandeau_page"; ?>  alert-dismissible" role="alert" style="position: relative;">
<div class="container" style="width: 90%; position: relative;">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <span class="<?php echo "$type_icone_page"; ?> "></span> <?php echo "$contenu_bandeau_page"; ?> 
</div>
</div>
</div>

<?php
}

}
$req_boucle->closeCursor();

}

?>