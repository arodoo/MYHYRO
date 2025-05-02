<?php
ob_start();

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

<script>
    $(document).ready(function() {

        //AJAX SOUMISSION DU FORMULAIRE
        $(document).on("click", "#avis", function() {
            $.post({
                url: "<?php echo "/pop-up/avis-annonce/avis-popup-ajax.php"; ?>",
                type: 'POST',
                data: {
                    avis_area: $('#avisArea').val(),
                    id_annonce: $('#idannoncepost').val(),
                    commentaire_area: $('#commentaire_area').val(),
                    note_post: $('#note_post').val(),
                },
                dataType: "json",
                success: function(res) {
                    if (res.retour_validation == "ok") {
                        popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                        window.location.reload()
                    } else {
                        popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                    }
                }
            });

        });

    });
</script>

<div class="modal fade" id="avisAnnonceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header" style="text-align: left;">
                <h2 class="modal-title style_color" style="float: left;">Avis</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div style="clear: both;"></div>
            </div>
            <div class="modal-body" style="text-align: left;">
                <form id="avis_form" class="mt-4" method='post' action='#' onclick="return false;">
                    <input type='hidden' id='idannoncepost' name='idannoncepost' value="<?php echo $_GET['idaction'] ?>" />
                    <div class="form-group">
						
						<div id='etoile1' class='etoile_evaluation' onclick="addnote1(this.id)"></div>
						<div id='etoile11' class='etoile_evaluation2' style='display: none;' onclick="deletenote1(this.id)"></div>

						<div id='etoile2' class='etoile_evaluation' onclick="addnote1(this.id)"></div>
						<div id='etoile22' class='etoile_evaluation2' style='display: none;' onclick="deletenote1(this.id)"></div>

						<div id='etoile3' class='etoile_evaluation' onclick="addnote1(this.id)"></div>
						<div id='etoile33' class='etoile_evaluation2' style='display: none;' onclick="deletenote1(this.id)"></div>

						<div id='etoile4' class='etoile_evaluation' onclick="addnote1(this.id)"></div>
						<div id='etoile44' class='etoile_evaluation2' style='display: none;' onclick="deletenote1(this.id)"></div>

						<div id='etoile5' class='etoile_evaluation' onclick="addnote1(this.id)"></div>
						<div id='etoile55' class='etoile_evaluation2' style='display: none;' onclick="deletenote1(this.id)"></div>
						<div style="display: none;"><input type="number" id="avisArea" /> </div>

				<div style="display: none;"><input type="text" id="note_post" name="note_post" /> </div>

                         <br>
                        <textarea id="commentaire_area" name="commentaire_area" class="form-control" rows="3" placeholder="Laisser votre avis ici"></textarea><br>
                        <button id="avis" type="button" class="btn btn-white w-space btn-default" style="color : white !important;" data-dismiss="modal">Publier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
ob_end_flush();
?>