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

if(isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 1 ||
isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 3 ){

?>

<script>
$(document).ready(function (){

//AJAX - SUPPRIMER NEWSLETTER
$(document).on("click", ".mail-supprimer-newsletter", function (){
$(".modal").show();
$.post({
url : '/administration/Modules/Newsletters/configurations-action-supprimer.php',
type : 'POST',
data: {idaction:$(this).attr("data-id")},
dataType: "json",
success: function (res) {
if(res.retour_validation == "ok"){
popup_alert(res.Texte_rapport,"green filledlight","#009900","uk-icon-check");
}else{
popup_alert(res.Texte_rapport,"#CC0000 filledlight","#CC0000","uk-icon-times");
}
}
});
// listeNewsletter();
});

//FUNCTION AJAX - LISTE NEWSLETTER
function listeNewsletter(){
$.post({
url : '/administration/Modules/Newsletters/configurations-liste-ajax.php',
type : 'POST',
dataType: "html",
success: function (res) {
$("#liste-newsletter").html(res);
}
});
}

listeNewsletter();

$(document).on('click', '#btnSupprModal', function(){
        $.post({
          url: '/administration/Modules/Newsletters/modal-supprimer-ajax.php',
          type: 'POST',
          data: {
            idaction: $(this).attr("data-id")
          },
          dataType: "html",
          success: function(res) {
            $("body").append(res)
            $("#modalSuppr").modal('show')
          }
        })
      });

      $(document).on("click", "#btnSuppr", function() {
        // $(".modal").show();
        $.post({
          url: '/administration/Modules/Newsletters/configurations-action-supprimer.php',
          type: 'POST',
          data: {
            idaction: $(this).attr("data-id")
          },
          dataType: "json",
          success: function(res) {
            if (res.retour_validation == "ok") {
              popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
            } else {
              popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
            }
            listeNewsletter();
            $("#modalSuppr").modal('hide')
            // $("#modalSuppr").hide(1000);
            // $(this).hide(1000);
          }
        });
      });
      
      $(document).on("click", "#btnNon", function() {
        $("#modalSuppr").modal('hide')
      });

      $(document).on('hidden.bs.modal', "#modalSuppr", function(){
        $(this).remove()
      })

});

</script>

<div id='idnewsletter'>

<?php
$action = $_GET['action'];
?>

<ol class="breadcrumb">
  <li><a href="<?php echo $http; ?><?php echo $nomsiteweb; ?>">Accueil</a></li>
  <li><a href="<?php echo $mode_back_lien_interne; ?>">Administration</a></li>
  <li class="active">Inscrits à la newsletter</li>
</ol>

<?php

echo "<div id='bloctitre' style='text-align: left;' ><h1>Inscrits à la newsletter</h1></div><br />
<div style='clear: both;'></div>";

////////////////////Boutton administration
echo "<a href='".$mode_back_lien_interne."'><button type='button' class='btn btn-default' style='margin-right: 5px;' ><span class='uk-icon-cogs'></span> Administration</button></a>";
echo "<div style='clear: both;'></div>";
////////////////////Boutton administration
?>

<!-- LISTE DES NEWSLETTER -->
<h2>Liste des personnes abonnées à la newsletter</h2>

<div id='liste-newsletter'></div>

</div>

<?php

}else{
header('location: /index.html');
}
?>