<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../../../Configurations_bdd.php');
require_once('../../../../Configurations.php');
require_once('../../../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction= "../../../../";
require_once('../../../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

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

if(isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 1 ||
isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 4 ){

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM configuration_membres_moderateurs_modules_liste");
$req_select->execute();
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$idoneinfos = $ligne_select['id'];
$nom_module_moderateur = $ligne_select['nom_module_moderateur'];
$url_page_module_moderateur = $ligne_select['url_page_module_moderateur'];

if(empty($idoneinfos)){
?>
<div class="alert alert-danger" role="alert" style="text-align: left;" >
<span class='uk-icon-warning'></span> <b>Vous devez déclarer des modules</b>. Puis il sera possible de les associer aux groupes sur le module concerné.
</div>
<?php
}

if(empty($_SESSION['MODULE_MODERATEUR_MODE_ACTIVE']) && $_POST['page'] == "Moderateurs-modules"){
?>
<div class="alert alert-warning" role="alert" style="text-align: left;" >
<b>Pour déclarer un module :</b><br />
1-Cliquez sur le bouton ci-ontre pour <b>activer le mode</b> <br />
2-<b>Allez sur le module concerné</b>, un bandeau sera présent en haut de page <br />
3-Puis <b>cliquez sur le bouton</b> présent dans le bandeau <br />
<button id="ACTIVER_LE_MODE_POUR_DECLARER_MODULE" type="button" class="btn btn-warning" onclick="return false;" >ACTIVER LE MODE</button>
</div>
<?php
}

if(empty($_SESSION['MODULE_MODERATEUR_MODE_ACTIVE']) && $_POST['page'] != "Moderateurs-modules" ){
?>
<div class="alert alert-warning" role="alert" style="text-align: left;" >
<span class='uk-icon-times'></span> <b>DECLARATIONS DE MODULE - MODE DESACTIVE :</b><br />
Afin d'activer le mode de déclarations des modules pour les modérateurs, cliquez sur le bouton ci-dessous. Pour rappel afin de rajouter un module à la liste, vous pourrez sur la page du module concerné l'ajouter à la liste.<br />
<button id="ACTIVER_LE_MODE_POUR_DECLARER_MODULE" type="button" class="btn btn-warning" onclick="return false;" >ACTIVER LE MODE</button>
</div>
<?php
}

if(!empty($_SESSION['MODULE_MODERATEUR_MODE_ACTIVE'])){
?>
<div class="alert alert-success" role="alert" style="text-align: left;" >
<span class='uk-icon-check'></span> <b>DECLARATIONS DE MODULE - MODE ACTIVE :</b><br />
Afin de désactiver le mode de déclaration des modules pour les modérateurs, cliquez sur le bouton ci-dessous.<br />
<button id="DESACTIVER_LE_MODE_POUR_DECLARER_MODULE" type="button" class="btn btn-success" onclick="return false;" >DESACTIVER LE MODE</button>
</div>
<?php
}

}else{
header('location: /index.html');
}

ob_end_flush();
?>