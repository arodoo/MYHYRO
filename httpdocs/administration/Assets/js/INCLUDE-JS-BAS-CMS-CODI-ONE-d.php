
<!-- JS GENERIQUE -->

<script type="text/javascript" src="<?php echo "$http"; ?><?php echo "$nomsiteweb"; ?>/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo "$http"; ?><?php echo "$nomsiteweb"; ?>/js/jscolor.min.js" ></script>
<script type="text/javascript" src="<?php echo "$http"; ?><?php echo "$nomsiteweb"; ?>/js/jquery.Jcrop.js"></script>

<!-- CSS ADMINISTRATION -->

<script type="text/javascript" src="<?php echo "$http"; ?><?php echo "$nomsiteweb"; ?>/administration/Assets/js/bootstrap/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo "$http"; ?><?php echo "$nomsiteweb"; ?>/administration/Assets/js/bootstrap/bootstrap-modal.js"></script>
<script type="text/javascript" src="<?php echo "$http"; ?><?php echo "$nomsiteweb"; ?>/administration/Assets/js/bootstrap/bootstrap-tokenfield.js"></script>
<script type="text/javascript" src="<?php echo "$http"; ?><?php echo "$nomsiteweb"; ?>/administration/Assets/js/bootstrap/bootstrap-tooltip.js"></script>
<script type="text/javascript" src="<?php echo "$http"; ?><?php echo "$nomsiteweb"; ?>/administration/Assets/js/bootstrap/bootstrap-select.min.js"></script>

<script type="text/javascript" src="<?php echo "$http"; ?><?php echo "$nomsiteweb"; ?>/administration/Assets/js/jspanel/jquery.jspanel.js"></script>
<script type="text/javascript" src="<?php echo "$http"; ?><?php echo "$nomsiteweb"; ?>/administration/Assets/js/jspanel/jquery.jspanel-compiled.js"></script>
<script type="text/javascript" src="<?php echo "$http"; ?><?php echo "$nomsiteweb"; ?>/administration/Assets/js/jspanel/jquery.jspanel.function.js"></script>

<script src="<?php echo "$http"; ?><?php echo "$nomsiteweb"; ?>/administration/Assets/js/datatables/jquery.dataTables.min.js" ></script>
<script src='https://cdn.datatables.net/buttons/1.2.2/js/buttons.colVis.min.js'></script>
<script src='<?php echo "$http"; ?><?php echo "$nomsiteweb"; ?>/administration/Assets/js/datatables/dataTables.responsive.min.js'></script>
<script src='<?php echo "$http"; ?><?php echo "$nomsiteweb"; ?>/administration/Assets/js/datatables/dataTables.rowReorder.min.js'></script>

<script type="text/javascript" src="<?php echo "$http"; ?><?php echo "$nomsiteweb"; ?>/administration/Assets/js/tinymce/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript" src="<?php echo "$http"; ?><?php echo "$nomsiteweb"; ?>/administration/Assets/js/tinymce/script.js"></script>

<input id="my-file" type="file" name="my-file" style="display: none;" onchange="" />

<script type="text/javascript" src="<?php echo "$http"; ?><?php echo "$nomsiteweb"; ?>/administration/Assets/js/cms/cms.js"></script>
<script type="text/javascript" src="<?php echo "$http"; ?><?php echo "$nomsiteweb"; ?>/administration/Assets/js/administration.js"></script>

<!-- AJOUT 02/06/2021 -->
<script type="text/javascript" src="/js/bootstrap/bootstrap-multiselect.js"></script>

<script>

jQuery(document).ready(function(){

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

////////////////////////////////////////////////////FONCTION POUR OUVRIR UNE POP-UP - JSPANEL admin
if(isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo > 0){
include('../administration/Assets/js/jspanel/jquery.jspanel.modal-admin.php');
}
////////////////////////////////////////////////////FONCTION POUR OUVRIR UNE POP-UP - JSPANEL admin
?>

});

</script>

<script type="text/javascript" src="<?php echo "$http"; ?><?php echo "$nomsiteweb"; ?>/js/cms/cms.js" ></script>

<!-- CORRECTION POUR MINIMIZE LORS DE LA RESTURATION(IMPORT) DU DERNIER JSPANEL -->
<div id="jsPanel-replacement-container"></div>
<div id="jsPanelparking"></div>
