<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../../Configurations_bdd.php');
require_once('../../../Configurations.php');
require_once('../../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction= "../../../";
require_once('../../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

$lasturl = $_SERVER['HTTP_REFERER'];

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

if(isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) ){

$nom_module_moderateur = $_POST['nom_module_moderateur'];
$url_page_module_moderateur = $_POST['url_page_module_moderateur'];

if(!empty($_SESSION['MODULE_MODERATEUR_MODE_ACTIVE'])){

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM configuration_membres_moderateurs_modules_liste WHERE url_page_module_moderateur=?");
$req_select->execute(array($url_page_module_moderateur));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$id = $ligne_select['id'];
$nom_module_moderateur = $ligne_select['nom_module_moderateur'];
$url_page_module_moderateur = $ligne_select['url_page_module_moderateur'];

if(empty($ligne_select['id'])){
?>
<div class="alert alert-danger" role="alert" style="text-align: left;" >
<span class='uk-icon-warning'></span> <b>le module n'est pas déclaré</b> dans la liste des modules pour modérateurs.
</div>

<div class="alert alert-warning" role="alert" style="text-align: left;" >
<span class='uk-icon-times'></span> <b>DECLARATIONS DE MODULE - MODE DESACTIVE :</b><br />
Pour <b>déclarer le module</b> à la liste des modules pour modérateur, cliquez sur le bouton ci-dessous.<br />
<button id="DECLARER_LE_MODULE" type="button" class="btn btn-warning" onclick="return false;" >DECLARER LE MODULE</button>
</div>
<?php
}else{
?>
<div class="alert alert-success" role="alert" style="text-align: left;" >
<span class='uk-icon-check'></span> <b>DECLARATIONS DU MODULE - MODULE ACTIVE :</b><br />
Pour </b>ne plus déclarer le module</b> à la liste des modules pour modérateur, cliquez sur le bouton ci-dessous.<br />
<button id="NE_PLUS_DECLARER_LE_MODULE" type="button" class="btn btn-success" onclick="return false;" >NE PLUS DECLARER LE MODULE</button>
</div>
<?php
}

}

}else{
header('location: /index.html');
}

ob_end_flush();
?>