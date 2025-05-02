<?php
////////////////////////////////////////////////////FONCTION POUR OUVRIR UNE POP-UP - JSPANEL admin

if(isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo > 0){

?>

//jspanel.close();

//CONFIGURATION GENERIQUE JSPANEL
var conf_save_session_statut;
var id_jspanel_fonction = "panel_admin";

//FOOTER JSPANEL ADMIN
var arr = [
    {
        item:     "<button style='margin-left:5px;' type='button'><span class='...'></span></button>",
        event:    "click",
        btnclass: "btn btn-default",
        btntext:  "Panel admin classique",
        callback: function( event ){
        event.data.close();
	$(location).attr("href", "<?php echo "".$http."".$nomsiteweb."".$page_bak_office_static.""; ?>");
        }
    }
];

//CONFIGURATION DU JSPANEL
var predefinedConfigs = {
default: {
<?php 
//SI STATUT DU JS PANEL EXISTE
if(!empty($_SESSION['statutjspanel'])){ ?>
setstatus:"<?php echo "".$_SESSION['statutjspanel'].""; ?>",
<?php 
}
//SI SESSION ASSOCIEE AUX POSITIONS DU JS PANEL EXISTE
if($_SESSION['statutjspanel'] != "minimize" && !empty($_SESSION['position_top']) && !empty($_SESSION['position_top']) ){ ?>
position: {left: <?php echo "".$_SESSION['position_left'].""; ?>, top: <?php echo "".$_SESSION['position_top'].""; ?> },
<?php 
} 
?>
footerToolbar: arr,
contentIframe: { id:'iframe_js_panel', src: '<?php echo "$mode_back_lien"; ?>', style:  {border: '0px'} },
theme:"<?php echo "$mode_back_office_jspanel_background_color"; ?>",
contentSize: {width: <?php echo "$mode_back_office_jspanel_width"; ?>, height: <?php echo "$mode_back_office_jspanel_height"; ?> },
headerTitle: "<span class='uk-icon-cog'></span> Panel d'administration",
resizable: {start: function(event, ui) { jsPanel.exportPanels(); save_statut_jspanel("normalize"); }, stop: function(event, ui) { jsPanel.exportPanels(); save_statut_jspanel("normalize"); }},
onclosed:function(){ jsPanel.exportPanels(); },
}
};

//ON BASULE LA SESSION PHP SUR LE STATUT MAXIMIZE
$(document).on("click",".jsglyph-maximize", function(){
conf_save_session_statut = "maximize";
save_statut_jspanel(conf_save_session_statut);
//alert('maximize'); 
});

//ON BASULE LA SESSION PHP SUR LE STATUT NORMALIZE
$(document).on("click",".jsglyph-normalize", function(){
conf_save_session_statut = "normalize";
save_statut_jspanel(conf_save_session_statut);
jsPanel.exportPanels(); 
//alert('normalize');
});

//ON BASULE LA SESSION PHP SUR LE STATUT MINIMISE
$(document).on("click",".jsglyph-minimize", function(){
conf_save_session_statut = "minimize";
save_statut_jspanel(conf_save_session_statut);
//alert('minimize');
});

//ON BASULE LA SESSION PHP SUR LE STATUT SMALLIFY
$(document).on("click",".jsglyph-chevron-up", function(){
conf_save_session_statut = "smallify";
save_statut_jspanel(conf_save_session_statut);
jsPanel.exportPanels(); 
//alert('smallify');
});

//ON BASULE LA SESSION PHP SUR LE STATUT NORMALIZE
$(document).on("click",".jsglyph-chevron-down", function(){
conf_save_session_statut = "normalize";
save_statut_jspanel(conf_save_session_statut);
jsPanel.exportPanels(); 
//alert('normalize');
});

//OUVERTURE DU JSPANEL
$(document).on("click","#ouverturejspanel", function(){

//SI JSPANEL POUR CETTE ID DEJA OUVERT, ON LE FERME AVANT DE L'OUVRIR
if($("#"+id_jspanel_fonction).length > 0){
jsPanel.activePanels.getPanel(id_jspanel_fonction).close();
}
panela = $.jsPanel({
id: id_jspanel_fonction,
position: {left:<?php echo "$mode_back_office_jspanel_position_left"; ?>, top: <?php echo "$mode_back_office_jspanel_position_top"; ?>},
callback: function(th) {
},
config:predefinedConfigs.default
});
save_statut_jspanel();
jsPanel.exportPanels();
});

//ON CREER UN EVENT SI LA POSITION DU JSPANEL CHANGE
$(document).on("mouseup","#"+id_jspanel_fonction, function(){
save_statut_jspanel();
});

//ON CREER UN EVENT SI LA POSITION DU JSPANEL CHANGE AVEC OFFSET
$(document).on("mouseup","#iframe_js_panel", function(){
//save_statut_jspanel();
alert($('#iframe_js_panel').get(0).contentWindow.location.href);
});

//FUNCTION AJAX POUR CREER UNE SESSION PHP, AFIN DE STOCKER LE STATUT ET LA POSITION DU PANEL DU JSPANEL
function save_statut_jspanel(conf_save_session_statut){

$.post({
url : '/administration/admin-jspanel-save-ajax.php',
type : 'POST',
data : {
page_courante_iframe: $('#iframe_js_panel').get(0).contentWindow.location.href,
statutjspanel:conf_save_session_statut,
position_left: $("#"+id_jspanel_fonction).position().left,
position_top: $("#"+id_jspanel_fonction).position().top,
},
dataType: "json",
success: function (res) {
}
});
}

<?php 
//////////SI SESSION ASSOCIEE A L'URL DE L'IFRAME EXISTE, ON RESTORE L'ANCIENNE PAGE EN SESSION
if(empty($JSPANEL_URL_IFRAME_INDEX)){
?>
jsPanel.importPanels(predefinedConfigs);
<?php 
} 
?>

<?php 
//////////SI SESSION ASSOCIEE A L'URL DE L'IFRAME EXISTE, ON RESTORE L'ANCIENNE PAGE EN SESSION
if(!empty($_SESSION['JSPANEL_URL_IFRAME'])){
?>
$('#iframe_js_panel').attr("src","<?php echo $_SESSION['JSPANEL_URL_IFRAME']; ?>");
<?php 
} 
?>

<?php
}
////////////////////////////////////////////////////FONCTION POUR OUVRIR UNE POP-UP - JSPANEL admin
?>