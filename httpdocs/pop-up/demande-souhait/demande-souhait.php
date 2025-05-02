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
    function addList(){
        // $("#addForm").submit(function(e) {
        //     e.preventDefault();
        //     $.ajax({
        //         url : '/panel/Ma-liste-de-souhaits/ma-liste-de-souhaits-action-ajouter-ajax.php',
        //         type: "POST",
        //         data: new FormData(this),
        //         processData: false,
        //         contentType: false
        //     });
        // })
        let formData = new FormData();
        formData.append('title', document.getElementById('title').value);
        formData.append('description', document.getElementById('description').value);
        formData.append('files', $('#file')[0].files[0]);

        $.ajax({
            url : '/panel/Ma-liste-de-souhaits/ma-liste-de-souhaits-action-ajouter-ajax.php',
            type : 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                res = JSON.parse(res);
                if(res.retour_validation == "ok"){
                    popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                    $("#demande_souhait").modal('hide');
                    document.location.replace('');
                }else if(res.retour_validation == "non"){
                    popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                }
            }
        });
    }
</script>

<div class="modal fade" id="demande_souhait" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header" style="text-align: left;" >
                <h2 class="modal-title style_color" id="pxpSigninModal" style="float: left;" >Créer votre liste de souhait</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <div class="modal-body" style="text-align: left;">
            <div class="col" style="display:flex; flex-direction:column">
                <form id="addForm" enctype="multipart/form-data" action="/panel/Ma-liste-de-souhaits/ma-liste-de-souhaits-action-ajouter-ajax.php" method="post">
                    <div>
                        <label for="title">Titre <span class="text-danger">*</span></label>
                        <input class="form-control" id="title" name="title" placeholder="Insérez un titre..."/>
                    </div>
                    <div class="my-3">
                        <label for="description">Description <span class="text-danger">*</span></label>
                        <textarea style="min-height: 100px" name="description" class="form-control" id="description" placeholder="Écrivez une description précise des articles avec par exemple le nom de l'article, la couleur, la pointure, etc."></textarea>
                    </div>
                    
                    
                    <div class="form-group">
                        <label for="item-file">Joindre une image</label>
                        <input type="file" class="form-control-file" id="file" name="files">
                    </div>
                    <button type="button" onclick="addList()" id="ajouterListe" class="btn btn-primary <?php if(empty($user)){ echo "pxp-header-user"; } ?>" style="align-self:end">Soumettre</button>
                </form>
                
            </div>
        </div>
    </div>
</div>
        
<?php
ob_end_flush();
?>