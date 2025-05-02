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

if(isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo > 0 ){

$action = $_POST['action'];
$idaction = $_POST['idaction'];

?>

<div class="btn-group" style="margin-top: 7px; margin-left: 4px; display : table-caption !important;">
  <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Modules en favoris  <span class="caret"></span>
  </button>
  <ul class="dropdown-menu moduleFavoris" style="width: 150%;">
<?php
///////////////////////////////SELECT BOUCLE
$req_boucle = $bdd->prepare("SELECT * FROM membres_modules_favoris_administrateur WHERE pseudo=?");
$req_boucle->execute(array($user));
while($ligne_boucle = $req_boucle->fetch()){
$id_module = $ligne_boucle['id'];
$nom_module = $ligne_boucle['nom_module'];
$url_page_module = $ligne_boucle['url_page_module'];
?>
    <li style='padding-left: 5px; display: inline-block;'><span class='uk-icon-times lien-supprimer-module-favoris' data-id='<?php echo "$id_module"; ?>' style='margin-right: 5px;'></span> <a href="?page=<?php echo $url_page_module; ?>" style='display: inline-block; padding-left: 0px;'> <?php echo $nom_module; ?></a></li>
<?php
}
$req_boucle->closeCursor();
?>
  </ul>
</div>

<?php
}else{
header('location: /index.html');
}

ob_end_flush();
?>