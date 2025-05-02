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

<nav class="navbar navbar-default">
  <div class="container-fluid">

      <ul class="nav navbar-nav" style="width: 100%; margin: 0px; margin-top:5px;">
        <li class="active" style="width: 100%;"><a href="<?php echo "".$page_bak_office_static.""; ?>" style="font-weight: bold; text-decoration: none; width: 100%;"><span class="uk-icon-cogs"></span> PANEL D'ADMINISTRATION <span class="sr-only">(current)</span></a></li>
         </ul>

   <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
    <?php if(count(AdminMembresEtModules()) > 1){  ?>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo AdminMembresEtModules()[1][0];?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
        <?php foreach (AdminMembresEtModules() as $key => $item){ if($key != 1){ ?>
            <li><a href="<?php echo $item[2]; ?>"><span class='uk-icon-<?php echo $item[1]; ?>'></span> <?php echo $item[0]; ?></a></li>
        <?php } } ?>
          </ul>
        </li>
   <?php } ?>

    <?php if(count(AdminBlogActualite()) > 1){  ?>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo AdminBlogActualite()[1][0];?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
        <?php foreach (AdminBlogActualite() as $key => $item){ if($key != 1){ ?>
            <li><a href="<?php echo $item[2]; ?>"><span class='uk-icon-<?php echo $item[1]; ?>'></span> <?php echo $item[0]; ?></a></li>
        <?php } } ?>
          </ul>
        </li>
   <?php } ?>

    <?php if(count(AdminPreferencesEtConfigurations()) > 1){  ?>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo AdminPreferencesEtConfigurations()[1][0];?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
        <?php foreach (AdminPreferencesEtConfigurations() as $key => $item){ if($key != 1){ ?>
            <li><a href="<?php echo $item[2]; ?>"><span class='uk-icon-<?php echo $item[1]; ?>'></span> <?php echo $item[0]; ?></a></li>
        <?php } } ?>
          </ul>
        </li>
   <?php } ?>

    <?php if(count(AdminDocumentsCommerciaux()) > 1){  ?>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo AdminDocumentsCommerciaux()[1][0];?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
        <?php foreach (AdminDocumentsCommerciaux() as $key => $item){ if($key != 1){ ?>
            <li><a href="<?php echo $item[2]; ?>"><span class='uk-icon-<?php echo $item[1]; ?>'></span> <?php echo $item[0]; ?></a></li>
        <?php } } ?>
          </ul>
        </li>
   <?php } ?>

    <?php if(count(AdminDeveloppementsWeb()) > 1){  ?>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo AdminDeveloppementsWeb()[1][0];?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
        <?php foreach (AdminDeveloppementsWeb() as $key => $item){ if($key != 1){ ?>
            <li><a href="<?php echo $item[2]; ?>"><span class='uk-icon-<?php echo $item[1]; ?>'></span> <?php echo $item[0]; ?></a></li>
        <?php } } ?>
          </ul>
        </li>
   <?php } ?>

      </ul>

      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
		<div id='listeModuleFavoris'></div>
        </li>
<?php
///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM membres_modules_favoris_administrateur WHERE url_page_module=? AND pseudo=?");
$req_select->execute(array($_GET['page'],$user));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$id_module = $ligne_select['id'];
if(!empty($id_module)){
$style_module_favoris = "style='color: #0288D1;'";
}

if($_GET['page']){
?>
        <li><a id='Mettre_le_module_en_favoris' href="#" data-url="<?php echo $_GET['page']; ?>" style='font-size: 18px; margin-left : -8px;' title='Mettre le produit en favoris' onclick='return false;' ><span class="uk-icon-star" <?php echo $style_module_favoris; ?> ></span></a></li>
<?php
}
?>
      </ul>

    </div>
  </div>
</nav>
