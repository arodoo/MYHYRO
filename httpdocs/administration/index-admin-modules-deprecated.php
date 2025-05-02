<?php
ob_start();

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

if (isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 1) {

?>

  <div class='container' style='margin-bottom: 20px;'>

    <ol class="breadcrumb">
      <li><a href="<?php echo $http; ?><?php echo $nomsiteweb; ?>">Accueil</a></li>
      <li class="active">Administration</li>
    </ol>

    <div class="well well-sm">
      <div style='text-align: center;'>
        <h1>Panel d'administration</h1>
      </div>
    </div>

  </div>

  <div class='container' style='margin-bottom: 20px; text-align: center;'>

    <div id="accordion">

      <?php if (count(AdminMembresEtModules()) > 1) {  ?>
        <h3><?php echo AdminMembresEtModules()[1][1]; ?></h3>
        <div class='section_module_accueil_administrateur'>
          <p>
            <?php foreach (AdminMembresEtModules() as $key => $item) {
              if ($key != 1) { ?>
          <div class='col-md-4 col-sm-4 col-xs-4 col-admin-accueil'><a href='<?php echo $item[2]; ?>'><span class='uk-icon-<?php echo $item[1]; ?>' style='font-size:  30px;'></span><br /><?php echo $item[0]; ?></a></div>
      <?php }
            } ?>
      </p>
        </div>
      <?php } ?>

      <?php if (count(AdminBlogActualite()) > 1) {  ?>
        <h3><?php echo AdminBlogActualite()[1][1]; ?></h3>
        <div class='section_module_accueil_administrateur'>
          <p>
            <?php foreach (AdminBlogActualite() as $key => $item) {
              if ($key != 1) { ?>
          <div class='col-md-4 col-sm-4 col-xs-4 col-admin-accueil'><a href='<?php echo $item[2]; ?>'><span class='uk-icon-<?php echo $item[1]; ?>' style='font-size:  30px;'></span><br /><?php echo $item[0]; ?></a></div>
      <?php }
            } ?>
      </p>
        </div>
      <?php } ?>

      <?php if (count(AdminPreferencesEtConfigurations()) > 1) {  ?>
        <h3><?php echo AdminPreferencesEtConfigurations()[1][0]; ?></h3>
        <div class='section_module_accueil_administrateur'>
          <p>
            <?php foreach (AdminPreferencesEtConfigurations() as $key => $item) {
              if ($key != 1) { ?>
          <div class='col-md-4 col-sm-4 col-xs-4 col-admin-accueil'><a href='<?php echo $item[2]; ?>'><span class='uk-icon-<?php echo $item[1]; ?>' style='font-size:  30px;'></span><br /><?php echo $item[0]; ?></a></div>
      <?php }
            } ?>
      </p>
        </div>
      <?php } ?>

      <?php if (count(AdminDocumentsCommerciaux()) > 1) {  ?>
        <h3><?php echo AdminDocumentsCommerciaux()[1][1]; ?></h3>
        <div class='section_module_accueil_administrateur'>
          <p>
            <?php foreach (AdminDocumentsCommerciaux() as $key => $item) {
              if ($key != 1) { ?>
          <div class='col-md-4 col-sm-4 col-xs-4 col-admin-accueil'><a href='<?php echo $item[2]; ?>'><span class='uk-icon-<?php echo $item[1]; ?>' style='font-size:  30px;'></span><br /><?php echo $item[0]; ?></a></div>
      <?php }
            } ?>
      </p>
        </div>
      <?php } ?>

      <?php if (count(AdminDeveloppementsWeb()) > 1) {  ?>
        <h3><?php echo AdminDeveloppementsWeb()[1][1]; ?></h3>
        <div class='section_module_accueil_administrateur'>
          <p>
            <?php foreach (AdminDeveloppementsWeb() as $key => $item) {
              if ($key != 1) { ?>
          <div class='col-md-4 col-sm-4 col-xs-4 col-admin-accueil'><a href='<?php echo $item[2]; ?>'><span class='uk-icon-<?php echo $item[1]; ?>' style='font-size:  30px;'></span><br /><?php echo $item[0]; ?></a></div>
      <?php }
            } ?>
      </p>
        </div>
      <?php } ?>

    <?php
  }
    ?>

    </div>

  </div>

  <?php
  ob_end_flush();
  ?>