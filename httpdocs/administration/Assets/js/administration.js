
$(document).ready(function(){

//AJAX SOUMISSION DU FORMULAIRE - MODULES FAVORIS

$(document).on("click", "#Mettre_le_module_en_favoris", function (){
nom_module_jquery_h1 = $("h1").text();
$.post({
url : '/administration/Assets/ajax/mettre-le-module-en-favoris.php',
type : 'POST',
data: {
nom_module:nom_module_jquery_h1,
url_page_module:$("#Mettre_le_module_en_favoris").attr("data-url"),
},
dataType: "json",
success: function (res) {
if(res.retour_validation == "ok"){
$("#Mettre_le_module_en_favoris").css("color","#FFCC66");
popup_alert(res.Texte_rapport,"green filledlight","#009900","uk-icon-check");
}else{
$("#Mettre_le_module_en_favoris").css("color","");
popup_alert(res.Texte_rapport,"#CC0000 filledlight","#CC0000","uk-icon-times");
}
}
});
listeModuleFavoris();
});

//AJAX - SUPPRIMER
$(document).on("click", ".lien-supprimer-module-favoris", function (){
$.post({
url : '/administration/Assets/ajax/mettre-le-module-en-favoris-supprimer.php',
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
listeModuleFavoris();
});

//FUNCTION AJAX - LISTE 
function listeModuleFavoris(){
$.post({
url : '/administration/Assets/ajax/menu-module-en-favoris-liste.php',
type : 'POST',
dataType: "html",
success: function (res) {
$("#listeModuleFavoris").html(res);
}
});
}
listeModuleFavoris();

});