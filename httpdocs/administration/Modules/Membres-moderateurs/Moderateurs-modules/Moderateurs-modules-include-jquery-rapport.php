
//AJAX SOUMISSION DU FORMULAIRE - ACTIVER
$(document).on("click", "#ACTIVER_LE_MODE_POUR_DECLARER_MODULE", function (){
$.post({
url : '/administration/Modules/Membres-moderateurs/Moderateurs-modules/Moderateurs-modules-action-activer-mode-ajax.php',
type : 'POST',
data:{
page:"<?php echo $_GET['page']; ?>",
},
dataType: "json",
success: function (res) {
if(res.retour_validation == "ok"){
popup_alert(res.Texte_rapport,"green filledlight","#009900","uk-icon-check");
}
}
});
listeModuleModerateurRapport();
});

//AJAX SOUMISSION DU FORMULAIRE - DESACTIVER
$(document).on("click", "#DESACTIVER_LE_MODE_POUR_DECLARER_MODULE", function (){
$.post({
url : '/administration/Modules/Membres-moderateurs/Moderateurs-modules/Moderateurs-modules-action-desactiver-mode-ajax.php',
type : 'POST',
data:{
page:"<?php echo $_GET['page']; ?>",
},
dataType: "json",
success: function (res) {
if(res.retour_validation == "ok"){
popup_alert(res.Texte_rapport,"#CC0000 filledlight","#CC0000","uk-icon-times");
}
}
});
listeModuleModerateurRapport();
});

//FUNCTION AJAX - RAPPORTS
function listeModuleModerateurRapport(){
$.post({
url : '/administration/Modules/Membres-moderateurs/Moderateurs-modules/Moderateurs-modules-rapport-ajax.php',
type : 'POST',
data:{
page:"<?php echo $_GET['page']; ?>",
},
dataType: "html",
success: function (res) {
$("#Module-Moderateur-rapport").html(res);
}
});
}
listeModuleModerateurRapport();