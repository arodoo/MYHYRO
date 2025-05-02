<!-- JS GENERIQUE -->

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- CSS ADMINISTRATION -->

<script type="text/javascript" src="<?php echo "$http"; ?><?php echo "$nomsiteweb"; ?>/administration/Assets/js/tinymce/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript" src="<?php echo "$http"; ?><?php echo "$nomsiteweb"; ?>/administration/Assets/js/tinymce/script.js"></script>



<script>
    jQuery(document).ready(function() {

        //DECONNEXION
        $(document).on("click", "#Deconnexion", function() {
            $("#deconection_popup").css("display", "");
            setTimeout(function() {
                timer_deconection()
            }, 2000);

            function timer_deconection() {
                $.post({
                    url: '/pop-up/deconnexion/deconnexion_popup_ajax.php',
                    type: 'POST',
                    data: {},
                    dataType: "html",
                    success: function(res) {
                        $(location).attr("href", "/");
                    }
                });
            }
        });
        <?php

        ////////////////////////////////////////////////////FONCTION POUR OUVRIR UNE POP-UP - JSPANEL admin
        if (isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo > 0) {
            include('../administration/Assets/js/jspanel/jquery.jspanel.modal-admin.php');
        }
        ////////////////////////////////////////////////////FONCTION POUR OUVRIR UNE POP-UP - JSPANEL admin
        ?>

    });
</script>

<!-- CORRECTION POUR MINIMIZE LORS DE LA RESTURATION(IMPORT) DU DERNIER JSPANEL -->
<div id="jsPanel-replacement-container"></div>
<div id="jsPanelparking"></div>