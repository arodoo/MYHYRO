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
<style>
    #commandsTable_length{
        display:none;
    }
    #commandsTable_paginate{
        display:none;
    }
</style>
<script>
    function listeCommandes(){
        $.post({
        url : '/panel/Mes-commandes/mes-commandes-action-liste-ajax.php',
        type : 'POST',
        dataType: "html",
        success: function (res) {
            $("#liste").html(res);
        }
        });
    }
    listeCommandes();
</script>
<?php if(!empty($user)){?>
<script>
    $(document).ready(function (){
        var article = 1;

        function onChangeId(){
            let articles = document.getElementsByClassName('label-custom');
            for(let i=0; i < article; i++){
                articles[i].id = "article-"+i;
            }
        }

        var commands_table = $('#commandsTable').DataTable(
            {
                stateSave: true,
                "order": [],
                "searching": false,
                "language": {
                    "sProcessing":     "Traitement en cours...",
                    "sSearch":         "Rechercher&nbsp;:",
                    "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
                    "sInfo":           "_TOTAL_ article(s)",
                    "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
                    "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                    "sInfoPostFix":    "",
                    "sLoadingRecords": "Chargement en cours...",
                    "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
                    "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
                    "oPaginate": {
                        "sFirst":      "Premier",
                        "sPrevious":   "Pr&eacute;c&eacute;dent",
                        "sNext":       "Suivant",
                        "sLast":       "Dernier"
                    },
                    "oAria": {
                        "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
                        "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
                    }
                }
            }
        );

        $('#addItems').on( 'click', function () {
            commands_table.row.add( [
                '<input type="text" class="form-control" name="article-name">',
                '<input type="text" class="form-control" name="article-color" placeholder="Couleur">',
                '<input type="text" class="form-control" name="article-size" placeholder="Taille">',
                '<input type="text" class="form-control" name="article-url">',
                "<select id='article-category' name='article-category' class='form-control'><?php $req_boucle = $bdd->prepare("SELECT * FROM categories ORDER BY nom_categorie ASC");$req_boucle->execute(); while($ligne_boucle = $req_boucle->fetch()){?> <option value=<?=$ligne_boucle['nom_categorie']?>><?= $ligne_boucle['nom_categorie']?></option> <?php } $req_boucle->closeCursor() ?> </select>",
                '<input type="number" min="1" value="1" class="form-control" onchange="onChangePrice()" name="article-price">',
                '<div class="row align-items-center" style="padding: 8px 10px"><input style="width:75%; margin-right: 10px" class="form-control" onchange="onChangePrice()" type="number" value="1" min="1" name="article-quantity"/><a href="#" onclick="return false;" class="deleteRow" style="color: #FF9900"><span class="uk-icon-trash-o"></span></button></div>',
            ] ).draw();
            article += 1;
            onChangePrice();
        });
        $('#commandsTable').on('click', '.deleteRow', function () {
            if(article > 1){
                var row = $(this).parents('tr');
                if($(row).hasClass('child')){
                    commands_table.row($(row).prev('tr')).remove().draw();
                } else {
                    commands_table
                    .row($(this).parents('tr'))
                    .remove()
                    .draw();
                }
                article -= 1;
                onChangePrice();
            }
        });
    });
</script>
<?php }?>

<div class="row">
    <?php
        include('panel/menu.php');
    ?>
    <div class="col-12 col-lg-9 mt-4 mt-lg-0">
    <div id="liste" style="clear: both;"></div>
    </div>

</div>