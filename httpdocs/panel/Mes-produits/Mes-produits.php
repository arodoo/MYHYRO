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
  $action = $_GET['action']; 

if(!empty($_SESSION['4M8e7M5b1R2e8s']) && !empty($user)){?>
    <style>
        #listeTable_length{
            display:none;
        }
        #listeTable_paginate{
            display:none;
        }
    </style>
        
    <?php
}else{
    header('location: /index.html');
}
?>

<script>
    //AFFICHER TOUTES LES DEMANDES
    function listeDemandes(){
        $.post({
        url : '/panel/Mes-produits/Mes-produits-action-liste-ajax.php',
        type : 'POST',
        dataType: "html",
        success: function (res) {
            $("#liste").html(res);
        }
        });
    }
    listeDemandes();
</script>

<div class="row">
    <?php
        include('panel/menu.php');
    ?>
    <div class="col-12 col-lg-9 mt-4 mt-lg-0">
        <div id="liste" style="clear: both;"></div>
    </div>
</div>