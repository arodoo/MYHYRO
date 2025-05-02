
<script>

$(document).ready(function (){

//AJAX SOUMISSION DU FORMULAIRE - ACTIVER
$(document).on("click", "#DECLARER_LE_MODULE", function (){
nom_module_jquery_h1 = $("h1").text();
$.post({
url : '/administration/Modules/Membres-moderateurs/Moderateurs-modules-include-declarations-ajax.php',
type : 'POST',
data:{
nom_module_moderateur:nom_module_jquery_h1,
url_page_module_moderateur:"<?php echo $_GET['page']; ?>",
},
dataType: "json",
success: function (res) {
if(res.retour_validation == "ok"){
popup_alert(res.Texte_rapport,"green filledlight","#009900","uk-icon-check");
}
}
});
listeModuleDeclarationModule();
});

//AJAX SOUMISSION DU FORMULAIRE - ACTIVER
$(document).on("click", "#NE_PLUS_DECLARER_LE_MODULE", function (){
nom_module_jquery_h1 = $("h1").text();
$.post({
url : '/administration/Modules/Membres-moderateurs/Moderateurs-modules-include-declarations-ajax.php',
type : 'POST',
data:{
nom_module_moderateur:nom_module_jquery_h1,
url_page_module_moderateur:"<?php echo $_GET['page']; ?>",
},
dataType: "json",
success: function (res) {
if(res.retour_validation == "ok"){
popup_alert(res.Texte_rapport,"green filledlight","#009900","uk-icon-check");
}
}
});
listeModuleDeclarationModule();
});

//FUNCTION AJAX - RAPPORTS
function listeModuleDeclarationModule(){
nom_module_jquery_h1 = $("h1").text();
$.post({
url : '/administration/Modules/Membres-moderateurs/Moderateurs-modules-include-declarations.php',
type : 'POST',
data:{
nom_module_moderateur:nom_module_jquery_h1,
url_page_module_moderateur:"<?php echo $_GET['page']; ?>",
},
dataType: "html",
success: function (res) {
$("#Module-rapport-declarations-module").html(res);
}
});
}
listeModuleDeclarationModule();

});

</script>

<!-- RAPPORT DECLARATIONS MODULE -->
<div id='Module-rapport-declarations-module' ></div>
