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


?>


<script>
  $(document).ready(function() {
   
    $('#pxp-signin-modal').on('shown.bs.modal', function() {
      console.log("Login popup opened on: " + window.location.href);
    });

    // Detectar cuando se presiona "Enter" para iniciar sesión
    document.addEventListener('keydown', function(event) {
      if (event.keyCode == 13) {
        /* console.log("Login attempted on: " + window.location.href); */
        $.post({
          url: "<?php echo "/pop-up/login/login_popup-ajax.php"; ?>",
          type: 'POST',
          data: {
            <?php if ($_GET['a'] == "admin") { ?>
              admin: "admin",
            <?php } ?>
            login: $('#login').val(),
            password: $('#password_login').val(),
            login_post: $('#login_post').val()
          },
          dataType: "json",
          success: function(res) {
            if (res.retour_validation == "Ok") {
              /*       console.log("Login successful on: " + window.location.href); */

              if (window.location.pathname === "/Passage-de-commande") {
                location.href = "/Paiement";
              } else {
                 location.href = res.retour_lien;
                location.href = "/acccueli";

              }
            } else {
              /*  console.log("Login failed on: " + window.location.href); */
              $('#retour_login').html("<div class='alert alert-danger' role='alert' style='text-align: left;'>" + res.Texte_rapport + "</div>");
            }
          }
        });
      }
    });


    $(document).on("click", "#login_post", function() {
      /*   console.log("Login button clicked on: " + window.location.href); */
      $.post({
        url: "<?php echo "/pop-up/login/login_popup-ajax.php"; ?>",
        type: 'POST',
        data: {
          <?php if ($_GET['a'] == "admin") { ?>
            admin: "admin",
          <?php } ?>
          login: $('#login').val(),
          password: $('#password_login').val(),
          login_post: $('#login_post').val()
        },
        dataType: "json",
        success: function(res) {
          if (res.retour_validation == "Ok") {
            /*  console.log("Login successful on: " + window.location.href); */

            if (window.location.pathname === "/Passage-de-commande") {
              location.href = "/Paiement";
            } else {
               location.href = res.retour_lien;
              location.href = "/accueli";
            }
          } else {
            /*  console.log("Login failed on: " + window.location.href); */
            $('#retour_login').html("<div class='alert alert-danger' role='alert' style='text-align: left;'>" + res.Texte_rapport + "</div>");
          }
        }
      });
    });


    $('#pxp-signin-modal').on('hidden.bs.modal', function() {
      $('#login').val('');
      $('#password_login').val('');
    });


    $('.modal-header .close').on('click', function() {
      $('#login').val('');
      $('#password_login').val('');
    });
  });
</script>

<div class="modal fade" id="pxp-signin-modal" tabindex="-1" role="dialog" aria-labelledby="pxpSigninModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header" style="text-align: left;">
        <h2 class="modal-title style_color" id="pxpSigninModal" style="float: left;">Identification</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <div style="clear: both;"></div>
      </div>
      <div class="modal-body modal-body-img" style="text-align: left;">
        <div id='retour_login'></div>
        <!-- <div class="text-center pxp-modal-small" style="display: inline-block;">
                                <a href="#" class="pxp-header-inscription pxp-modal-link pxp-signup-trigger btn btn-info" onclick="return false;">Création d'un compte</a>
                            </div>
                            <div class="text-center pxp-modal-small" style="display: inline-block;">
				<a href="#" class="pxp-modal-link pxp-header-passperdu btn btn-info" style="" >Mot de passe perdu ?</a>
                            </div> -->
        <form class="mt-4" method='post' action='#' onclick="return false;">
          <div class="form-group">
            <label for="pxp-signin-email">Email</label>
            <input type="email" class="form-control" id="login" name="login" placeholder="Entrer l'adresse mail">
          </div>
          <div class="form-group">
            <label for="pxp-signin-pass">Mot de passe</label>
            <input type="password" class="form-control" id="password_login" name="password" placeholder="Entrer le mot de passe" onlick="return false;">
          </div>
          <div class="form-group" style="display: inline-block;">
            <a href="#" id='login_post' class="pxp-agent-contact-modal-btn btn btn-primary" onclick="return false;">S'identifier</a>
          </div>
          <div class="form-group" style="display: inline-block;">
            <a href="#" id='register_post' class="pxp-header-inscription btn btn-info" onclick="return false;">Inscription</a>
          </div>
          <div class="form-group" style="display: block;">
            <a href="#" class="pxp-modal-link pxp-header-passperdu">Mot de passe perdu ?</a>
          </div>

          <div style="clear: both;"></div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php
ob_end_flush();
?>