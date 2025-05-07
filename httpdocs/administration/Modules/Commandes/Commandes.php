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

if (
    isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 1 ||
    isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 2 ||
    isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 3
) {

?>

    <script>
        $(document).ready(function() {

            //AJAX SOUMISSION DU FORMULAIRE - MODIFIER 
            $(document).on("click", "#modifier-compte-membre", function() {
                $.post({
                    url: '/administration/Modules/Membres-logs/membres-logs-action-modifier-ajax.php',
                    type: 'POST',
                    data: new FormData($("#formulaire-modifier-compte-membre")[0]),
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    success: function(res) {
                        if (res.retour_validation == "ok") {
                            popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                        } else {
                            popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                        }
                    }
                });
                listeCommandes();
            });

            //FUNCTION AJAX - LISTE NEWSLETTER
            function listeCommandes() {
                $.post({
                    url: '/administration/Modules/Commandes/Commandes-action-liste-ajax.php',
                    type: 'POST',
                    data: {
                        idmembre: "<?php echo $_GET['idmembre']; ?>"
                    },
                    dataType: "html",
                    success: function(res) {
                        $("#liste-commandes").html(res);
                    }
                });
            }

            listeCommandes();

        });
    </script>

    <?php

    $action = $_GET['action'];
    $idaction = $_GET['idaction'];
    ?>

    <ol class="breadcrumb">
        <li><a href="<?php echo $http; ?><?php echo $nomsiteweb; ?>">Accueil</a></li>
        <li><a href="<?php echo $mode_back_lien_interne; ?>">Administration</a></li>
        <?php if (empty($_GET['action'])) { ?> <li class="active">Commandes</li> <?php } else { ?> <li><a href="?page=Commandes">Commandes</a></li> <?php } ?>
        <?php if ($_GET['action'] == "modifier") { ?> <li class="active">Consultation</li> <?php } ?>
        <?php if ($_GET['action'] == "addm") { ?> <li class="active">Ajouter</li> <?php } ?>
    </ol>

    <?php
    echo "<div id='bloctitre' style='text-align: left;'><h1>Commandes</h1></div><br />
<div style='clear: both;'></div>";

    ////////////////////Boutton administration
    echo "<a href='" . $mode_back_lien_interne . "'><button type='button' class='btn btn-default' style='margin-right: 5px;' ><span class='uk-icon-cogs'></span> Administration</button></a>";
    if (isset($_GET['action'])) {
        echo "<a href='?page=Commandes'><button type='button' class='btn btn-success' style='margin-right: 5px;' ><span class='uk-icon-history'></span> Liste des commandes</button></a>";
    }
    echo "<div style='clear: both;'></div>";
    ////////////////////Boutton administration
    ?>

    <div style='text-align: center;'>

        <?php
        ////////////////////////////////////////////////////////////////////////////////////////////FORMULAIRE AJOUTER - MODIFIER
     
        ///////////////////////////////////////////////////////////////////////////////////////////ACTION - DETAILS
        if($action == "Details"){?>
            <script>
                $.post({
                    url: '/administration/Modules/Commandes/Commandes-action-details-ajax.php',
                    type: 'POST',
                    data: {
                        idaction: "<?php echo $_GET['idaction']; ?>"
                    },
                    dataType: "html",
                    success: function(res) {
                        $("#details-commande").html(res);
                    }
                });
            </script>
            <div id="details-commande" style="clear:both;"></div>
        <?php }


        ////////////////////////////////////////////////////////////////////////////////////////////PAS D'ACTION
        if (!isset($action)) {
        ?>

            <div style='clear: both; margin-bottom: 20px;'></div>

            <div id='liste-commandes' style='clear: both;'></div>

    <?php
            ////////////////////////////////////////////////////////////////////////////////////////////PAS D'ACTION
        }

        echo "</div>";
    } else {
        header('location: /index.html');
    }
    ?>