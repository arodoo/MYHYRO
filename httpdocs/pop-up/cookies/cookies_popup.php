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

//////////////////////////////Si pas enregistré
if (!isset($user) && empty($_SESSION['cookies_historiques'])) {
?>

  <script>
    $(document).ready(function() {

      //AJAX SOUMISSION DU FORMULAIRE - MODIFIER 
      $(document).on("click", ".close_cookies", function() {
        $.post({
          url: '/pop-up/cookies/cookies_acceptes_popup.php',
          data: {
            accepter: "oui"
          },
          type: 'POST',
          dataType: "html",
          success: function(res) {
            $(".bloc_cookies").css("display", "none");
          }
        });
      });

    });
  </script>

  <div class="alert <?php echo "$type_cookies_alerte"; ?> bloc_cookies alert-dismissible" role="alert" style="background : #fff;">
    <div class="container containerCookie" style="position: relative;">
      <button type="button" class="close_cookies close_cookies_span" aria-label="Close"><span class="uk-icon-times" ></span></button>
      <div class="text-center"><?php echo "$texte_cookies"; ?></div>
      <?php
      if ($cookies_bouton_accepter == "oui") {
      ?> <br>
        <!-- <div class="text-center mt-3 mb-3"> -->
        <div class="text-center">
			<button type="button" 
					class="btn btn-default <?php echo "$Type_bouton_cookies_alerte"; ?> close_cookies" 
					style="width: 200px;" aria-label="Close" 
					onclick="return false;">ACCEPTER</button>
        </div>
      <?php
      }
      ?>
    </div>
  </div>

<?php
}
//////////////////////////////Si pas enregistré
?>