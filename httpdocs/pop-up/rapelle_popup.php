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

<script>
  $(document).ready(function (){

    //AJAX SOUMISSION DU FORMULAIRE
    $(".onvousrappellebtn").click(function (){
      $.post({
        url : "<?php echo "/pop-up/rapelle_popup-ajax.php"; ?>",
        type : 'POST',
        data : {
          nom_rappel:$('#nom_rappel').val(),
          prenom_rappel:$('#prenom_rappel').val(),
          mail_rappel:$('#mail_rappel').val(),
          tel_rappel:$('#tel_rappel').val(),
        },
        dataType: "json",
        success: function (res) {
          if(res.retour_validation == "ok"){
		popup_alert(res.Texte_rapport,"green filledlight","#009900","uk-icon-check");
            	$(location).attr("href", "/");
          }else{
		popup_alert(res.Texte_rapport,"#CC0000 filledlight","#CC0000","uk-icon-times");
          }
        }
      });

    });

});
</script>

	<form id="form_mail_on_vous_rappelle" method='post' action='#'>
		<input id="nom_rappel" class='form-control' type="text" name="nom_rappel" title="<?php echo "Votre nom"; ?>" placeholder="<?php echo "Votre nom"; ?>" style='width: 100%; margin-bottom: 5px;' />
		<input id="prenom_rappel" class='form-control' type="text" name="prenom_rappel" title="<?php echo "Votre prénom"; ?>" placeholder="<?php echo "Votre prénom"; ?>" style='width: 100%; margin-bottom: 5px;' />
		<input id="mail_rappel" class='form-control' type="text" name="mail_rappel" title="<?php echo "Votre mail"; ?>" placeholder="<?php echo "Votre mail"; ?>" style='width: 100%; margin-bottom: 5px;' />
		<input id="tel_rappel" class='form-control' type="text" name="tel_rappel" title="<?php echo "N° de téléphone : 06.00.00.00.00"; ?>" placeholder="<?php echo "N° de téléphone : 06.00.00.00.00"; ?>" style='width: 100%; margin-bottom: 5px;' />
		<a id="onvousrappellebtn" class="btn btn-primary onvousrappellebtn" href="#" onclick="return false;" style="width: 100%; margin-top: 20px;" >Effectuer la demande</a>
	</form>

