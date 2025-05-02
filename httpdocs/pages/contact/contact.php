
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
	$(document).on("click", "#Envoyer", function (){
		$.post({
			url : '/pages/contact/contact-ajax.php',
			type : 'POST',
			data: new FormData($("#contact-form")[0]),
			processData: false,
			contentType: false,
			dataType: "json",
			success: function (res) {
				if(res.retour_validation == "ok"){
					popup_alert(res.Texte_rapport,"green filledlight","#009900","uk-icon-check");
					service_mail:$('#service_mail').val(),
					$('#objetpost').val("");
					$('#messagepost').val("");
				}else{
					popup_alert(res.Texte_rapport,"#CC0000 filledlight","#CC0000","uk-icon-times");
				}
			}
		});
	});

	//LISTE DEROULANTE
	$(document).on("change", "#service_mail", function (){
		val = $("select#service_mail option").filter(":selected").val();	
		if(val == "proprietaire@mk-gestion.com" ){
			$(".proprietaire").css("display","");
			$(".investisseur").css("display","none");
			$("#Budget").val("");
			$("#liste_service").val("");


		}
		if(val == "investisseur@mk-gestion.com" ){
			$(".investisseur").css("display","");
			$(".proprietaire").css("display","none");
			$("#Adresse_du_bien").val("");
			$("#Adresse_perso").val("");
		}

	});

});

</script>

<?php

if(!empty($telephone_fixe_ii)){
	$telephone_information = "$telephone_fixe_ii";
}elseif(!empty($telephone_portable_ii)){
	$telephone_information = "$telephone_portable_ii";
}
?>

<div class="card mb-0" >

<div class="row" >
	<div class='col-md-6' style='text-align: left; margin-bottom: 20px; padding: 30px;' >

                                    	     <p><strong>Informations de contact</strong><br><br />

					     <?php echo "$adresse_ii $ville_ii $cp_dpt_ii"; ?> </p>

                                  	     <p>Assistance Gabon <?php echo "$telephone_fixe_ii"; ?> <br />
                                             Assistance France <?php echo "$telephone_portable_ii"; ?><br />
                                             <a href='<?php echo "mailto:$emaildefault";?>' ><?php echo "$emaildefault";?></a></p>

					    <p>
                                                <strong>Horaire de la plateforme</strong><br>
                                                Lundi à Samedi: 9:00 à 17:00<br>
                                                Samedi: Fermé<br>
                                                Dimanche: Fermé
                                            </p>

					    <p>
                                                <strong>Informations</strong><br>
                                                <?php echo $text_i; ?>
                                            </p>

</div>

<div class='col-md-6' style='text-align: left; padding: 10px;' >

	<div class="form-popup" style="padding: 10px;" >

	<form id="contact-form" method='post' action='#' enctype="multipart/form-data">

		<div class="row" >
			<input type='hidden' id='pseudomail' name='pseudomail' value="exemple@domaine.com"/>
			<div style='display: none;'>
				* <?php echo "Mail"; ?> <input type='text' id='eeemail' name='eeemail' value=""/> Ne pas remplir ce champ, merci !
			</div>

			<div class="col-sm-12" style='margin-bottom: 15px;'>
				<label>*<?php echo "Contact"; ?> :</label>
				<select id='service_mail' name='service_mail' class="form-control" >
				<?php
				///////////////////////////////SELECT BOUCLE
				$req_boucle = $bdd->prepare("SELECT * FROM contact WHERE activer='oui' ORDER BY position ASC");
				$req_boucle->execute();
				while($ligne_boucle = $req_boucle->fetch()){
				$idgcontact = $ligne_boucle['id'];	
				$serviceone = $ligne_boucle['service'];
				$mailonemail = $ligne_boucle['mail'];
				$activeronemail = $ligne_boucle['activer'];

					if($service_mail == $mailonemail){
					?>
						<option selected='selected' value="<?php echo "$mailonemail"; ?>"> <?php echo "$serviceone"; ?> &nbsp;</option>
					<?php
					}else{
					?>
						<option value="<?php echo "$mailonemail"; ?>"> <?php echo "$serviceone"; ?> &nbsp;</option>
					<?php
					}
				}
				?>
				</select>
			</div>


			<div class="col-sm-12 proprietaire" style='margin-bottom: 10px; display: none;'>
				<label>Adresse du bien +ville +code postal :</label>
				<input type="text" id="Adresse_du_bien" name="Adresse_du_bien" class="form-control" value="" />
			</div>
			<div class="col-sm-12 proprietaire" style='margin-bottom: 10px; display: none;'>
				<label>Adresse personnel +ville +code postal :</label>
				<input type="text" id="Adresse_perso" name="Adresse_perso" class="form-control" value="" />
			</div>

			<div class="col-sm-12 investisseur" style='margin-bottom: 10px; display: none;'>
				<label>Budget :</label>
				<input type="text" id="Budget" name="Budget" class="form-control" value="" />
			</div>
			<div class="col-sm-12 investisseur" style='margin-bottom: 10px; display: none;'>
				<label>Liste de service :</label>
				<select name="liste_service"  class="form-control" >
				<option value="" > Sélection </option>
					<option value="Rénovation" > Rénovation </option>
					<option value="Recherche de biens" > Recherche de biens </option>
					<option value="Conseil" > Conseil </option>
					<option value="Création meublés de toursime" > Création meublés de toursime </option>
				</select>
			</div>

			<div class="col-sm-6" style='margin-bottom: 10px;'>
				<label>*Nom :</label>
				<input type="text" id="Namepost" name="Namepost" class="form-control" value="<?php if(!empty($_POST['Namepost'])){ echo $_POST['Namepost']; }elseif((!empty($nom_oo) || !empty($prenom_oo) ) && !empty($user)){ echo "$nom_oo $prenom_oo"; } ?>" />
			</div>

			<div class="col-sm-6" style='margin-bottom: 10px;'>
				<label>*Email :</label>
				<input type="email" id="mailpost" name="mailpost" class='form-control' value="<?php if(!empty($_POST['mailpost'])){ echo $_POST['mailpost']; }elseif(!empty($mail_oo) && !empty($user)){ echo $mail_oo; } ?>" />
			</div>

			<div class="col-sm-12" style='margin-bottom: 15px;'>
				<label>*Objet :</label>
				<input type="text" id="objetpost" name="objetpost" class='form-control' value="<?php echo $_POST['objetpost']; ?>" style='width: 100%;' />
			</div>

			<div class="col-sm-12" style='margin-bottom: 15px;'>
				<label>*Message :</label>
				<textarea rows="5" id="messagepost" name="messagepost" class='form-control' style="width: 100%;"><?php echo $_POST['messagepost']; ?></textarea>
			</div>

			<div class="col-sm-12" style='margin-bottom: 15px;'>
				"Les données collectées par le formulaire de contact sont nécessaires pour répondre à votre message. Vous disposez d'un droit d'accès, de rectification, d'opposition, de limitation du traitement, de suppression et de portabilité.
			</div>

			<div class="col-sm-12" style='margin-bottom: 15px; text-align: center;'>
				<button type='button' id='Envoyer' class='btn btn-primary' style='' onclick='return false;' >ENVOYER</button>
			</div>
		</div>

		</form>
		<div style="clear: both;" ></div>
		</div>
	</div>
</div>

</div>
