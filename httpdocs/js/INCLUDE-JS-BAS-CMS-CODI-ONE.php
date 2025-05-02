
<script src="/js/jspanel/jquery.jspanel.js"></script>
<script src="/js/jspanel/jquery.jspanel-compiled.js"></script>
<script src="/js/jspanel/jquery.jspanel.function-save.js"></script>

<script src="/js/bootstrap/bootstrap-modal.js"></script>

<script src="/js/datatables/jquery.dataTables.min.js" ></script>
<script src='https://cdn.datatables.net/buttons/1.2.2/js/buttons.colVis.min.js'></script>
<script src='/js/datatables/dataTables.responsive.min.js'></script>
<script src='/js/datatables/dataTables.rowReorder.min.js'></script>

<script type="text/javascript" src="<?php echo "$http"; ?><?php echo "$nomsiteweb"; ?>/js/tinymce/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript" src="<?php echo "$http"; ?><?php echo "$nomsiteweb"; ?>/js/tinymce/script.js"></script>
<script type="text/javascript" src="<?php echo "$http"; ?><?php echo "$nomsiteweb"; ?>/js/jquery.Jcrop.js"></script>
<?php if(!empty($user)){ ?>

<input id="my-file" type="file" name="my-file" style="display: none;" onchange="" />
<?php } ?>

<script>

jQuery(document).ready(function(){

$(document).on("click",".close", function(){
  	$(".modall").removeClass("in");
  	$(".modal-backdrop").remove();
  	$(".modal").hide();
});

//INSCRIPTION
$(document).on("click",".pxp-header-inscription", function(){
  	$(".modall").removeClass("in");
  	$(".modal-backdrop").remove();
  	$(".modal").hide();
	$('#pxp-signin-modal-inscription').modal('show');
});

//LOGIN
$(document).on("click",".pxp-header-user", function(){
  	$(".modall").removeClass("in");
  	$(".modal-backdrop").remove();
  	$(".modal").hide();
	$('#pxp-signin-modal').modal('show');
});

//PASSWORD
$(document).on("click",".pxp-header-passperdu", function(){
  	$(".modall").removeClass("in");
  	$(".modal-backdrop").remove();
  	$(".modal").hide();
	$('#pxp-password-modal').modal('show');
});

<?php
//JQUERY PASSWORD - RETOUR MAIL
if($_GET['action_password']){
?>
//PASSWORD
  	$(".modall").removeClass("in");
  	$(".modal-backdrop").remove();
  	$(".modal").hide();
	$('#pxp-password-modal').modal('show');
<?php
}
?>

//PASSWORD CONFIRMATION
$(document).on("click",".pxp-header-passperd-confirmation", function(){
  	$(".modall").removeClass("in");
  	$(".modal-backdrop").remove();
  	$(".modal").hide();
	$('#pxp-password-confirmation-modal').modal('show');
});
// AJOUT PARTENAIRE

//NEWSLETTER
$(document).on("click","#souscription_newsletter", function(){
	function newsletter(){
	    $.post({
	        url : '/js/ajax/newsletter.php',
	        type : 'POST',
		dataType: "json",
	        data : {mail: $('#mail_souscription').val()},
	        success: function (res) {                   
	            if(res == 0) {
	                popup_alert("Veuillez rentrer un email valide","#CC0000 filledlight","#CC0000","uk-icon-times");
	            } else {
	                popup_alert(res,"#C1AC81", "#C1AC81", "uk-icon-check");
			$('#mail_souscription').val("");
	            }                      
	        }
	    });
	}
	newsletter();
});

<?php 
////////////////////////////////////////////////////DECONNEXION
if(!empty($user)){
?>
//DECONNEXION
$(document).on("click","#Deconnexion", function(){
$("#deconection_popup").css("display","");
setTimeout(function(){timer_deconection()},2000);
function timer_deconection(){
$.post({
url : '/pop-up/deconnexion/deconnexion_popup_ajax.php',
type : 'POST',
data : {},
dataType: "html",
success: function (res) {
$(location).attr("href", "/");
}
});
}
});
<?php
}
////////////////////////////////////////////////////DECONNEXION

////////////////////////////////////////////////////ON VOUS RAPPEL
?>
$(document).on("click","#bloc_rappel_pop_up_formulaire", function(){
popup_panel("password_jspanel","/pop-up/rapelle_popup.php","On vous rappelle","300 auto","300 auto","modal","");
});
<?php
////////////////////////////////////////////////////ON VOUS RAPPEL

////////////////////////////////////////////////////Pop-up LOGIN
if($_GET['a'] == "login" || $_GET['a'] == "admin" ){
if($_GET['a'] == "login" ){
$titre_popup_login = "Identification";
}elseif($_GET['a'] == "admin" ){
$titre_popup_login = "Identification administrateur";
}
?>
  	$(".modall").removeClass("in");
  	$(".modal-backdrop").remove();
  	$(".modal").hide();
	$('#pxp-signin-modal').modal('show');

<?php
}
////////////////////////////////////////////////////Pop-up LOGIN

////////////////////////////////////////////////////Pop-up INSCRIPTION
if($_GET['a'] == "inscription" ){
?>
if($("#password_jspanel").length > 0){
jsPanel.activePanels.getPanel("password_jspanel").close();
}
if($("#login_jspanel").length > 0){
jsPanel.activePanels.getPanel("login_jspanel").close();
}
popup_panel("inscription_jspanel","/pop-up/inscription/inscription_popup.php","Inscription","300 auto","300 auto","modal","");
<?php
}
////////////////////////////////////////////////////Pop-up INSCRIPTION

////////////////////////////////////////////////////POP-UP PASSWORD
//JQUERY PASSWORD - RETOUR MAIL
if($_GET['a'] == "Mot-de-passe"){
?>
popup_panel("password_jspanel","/pop-up/mot-de-passe-perdu/password_popup.php","Nouveau mot de passe","300 auto","300 auto","modal","");
<?php
}
////////////////////////////////////////////////////POP-UP PASSWORD

////////////////////////////////////////////////////POP-UP PASSWORD CONFIRMATION
if(!empty($user)){
?>
//PASSWORD CONFIRMATION
$(document).on("click","#supprimer_mon_compte", function(){
	$.post({
		url : '/panel/Supprimer-compte/supprimer-compte.php',
		type : 'POST',
		data : {},
		dataType: "html",
		success: function (res) {
			popup_alert("Votre demande va être prise en compte !","green filledlight","#009900","uk-icon-check");
			setTimeout(function(){$(location).attr("href", "/");},2000);
		}
	});
});
<?php
}
////////////////////////////////////////////////////POP-UP PASSWORD CONFIRMATION
?>


});

</script>

<!-- <script src="/js/cms/cms.js?v=1" ></script> -->

<!-- CORRECTION POUR MINIMIZE LORS DE LA RESTURATION(IMPORT) DU DERNIER JSPANEL -->
<div id="jsPanel-replacement-container"></div>
<div id="jsPanelparking"></div>


