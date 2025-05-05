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

if(isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 1 ||
isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 2 ||
isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 3 ){

$idaction = $_GET['idaction'];
$action = $_GET['action'];

?>
<style>
    .accordion-button{
        border-top-left-radius:0.5rem;
        border-top-right-radius:0.5rem;
        border:1px solid #dddddd;
        padding:1rem;
        text-align:left;
        width:100%;
        height:100%;
        font-size: 24px;
        background-color: #fafafa;
    }
    .accordion-body{
        padding: 1rem;
        border:1px solid #dddddd;
        border-bottom-left-radius:0.5rem;
        border-bottom-right-radius:0.5rem;
    }
    
</style>
<script>

    $(document).ready(function (){
        //AFFICHER TOUTES LES DEMANDES
        function listeDemandes(){
            $.post({
            url : '/administration/Modules/Demandes-de-souhaits/demandes-action-liste-ajax.php',
            type : 'POST',
            data: { idmembre: "<?= $_GET['idmembre'] ? $_GET['idmembre'] : "" ?>" },
            dataType: "html",
            success: function (res) {
                $("#liste-demandes").html(res);
            }
            });

        }
        listeDemandes();
        
        
        $(document).on("click", "#generate", function() {
            let id = document.getElementById('idWish').value;
            let prices = document.getElementsByName('article-price');

            datas = {
                id: id,
                prices: prices,
            }

            $.post({
                url: '/administration/Modules/Demandes-de-souhaits/demandes-action-creation-panier.php',
                type: 'POST',
                data: datas,
                success: function(res) {
                    res = JSON.parse(res);

                    if (res.retour_validation == "ok") {
                        popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                        setTimeout(() => {
                            document.location.reload();
                        }, 1500)
                    }else{
                        popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                    }
                }
            });
        });
        $(document).on("click", "#delete", function() {
            let id = document.getElementById('idWish').value;
            datas = {
                id: id
            }
            
            $.post({
                url: '/administration/Modules/Demandes-de-souhaits/demandes-action-supprimer-ajax.php',
                type: 'POST',
                data: datas,
                success: function(res) {
                    res = JSON.parse(res);

                    if (res.retour_validation == "ok") {
                        popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                        setTimeout(() => {
                            document.location.reload();
                        }, 1500)
                    }else{
                        popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                    }
                }
            });
        });
        $(document).on('click', "#addArticleButton", function() {
            let id = document.getElementById('idWish').value;
            let name = document.getElementById('article-name').value;
            let desc = document.getElementById('article-desc').value;
            let url = document.getElementById('article-url').value;
            let category = document.getElementById('article-category').value;
            let quantity = document.getElementById('article-quantity').value;
            let color = document.getElementById('article-color').value;
            let size = document.getElementById('article-size').value;
            let price = document.getElementById('article-price').value;
            let type = document.getElementById('article-type').value;

            let datas = {
                action: "ajouter",
                id: id,
                name: name,
                desc: desc,
                url: url,
                category: category,
                quantity: quantity,
                color: color,
                size: size,
                price: price,
                type: type
            }

            $.post({
                url: '/administration/Modules/Demandes-de-souhaits/demandes-action-ajouter-modifier-article-ajax.php',
                type: 'POST',
                data: datas,
                success: function(res) {
                    res = JSON.parse(res);

                    if (res.retour_validation == "ok") {
                        popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                        setTimeout(() => {
                            document.location.reload();
                        }, 1500)
                    }else{
                        popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                    }
                }
            });
        })
        $(document).on("click", "#updateListe", function(){
            let id = document.getElementById('idWish').value;
            let status = document.getElementById('statut').value;
            datas = {
                id: id,
                status: status
            }
            $.post({
                url: '/administration/Modules/Demandes-de-souhaits/demandes-action-modifier-ajax.php',
                type: 'POST',
                data: datas,
                success: function(res) {
                    res = JSON.parse(res);

                    if (res.retour_validation == "ok") {
                        popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                        setTimeout(() => {
                            document.location.reload();
                        }, 1500)
                    }else{
                        popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                    }
                }
            })
        });

        $(document).on("click", "#modifierArticle", function(e){
            let id = e.target.getAttribute('ida');
            let type = document.getElementById(`type-${id}`).value;
            let name = document.getElementById(`name-${id}`).value;
            let desc = document.getElementById(`desc-${id}`).value;
            let url = document.getElementById(`url-${id}`).value;
            let category = document.getElementById(`category-${id}`).value;
            let quantity = document.getElementById(`quantity-${id}`).value;
            let color = document.getElementById(`color-${id}`).value;
            let size = document.getElementById(`size-${id}`).value;
            let price = document.getElementById(`price-${id}`).value;

            let datas = {
                action: "modifier",
                id: id,
                name: name,
                desc: desc,
                url: url,
                category: category,
                quantity: quantity,
                color: color,
                size: size,
                price: price,
                type: type
            }

            $.post({
                url: '/administration/Modules/Demandes-de-souhaits/demandes-action-ajouter-modifier-article-ajax.php',
                type: 'POST',
                data: datas,
                success: function(res) {
                    res = JSON.parse(res);

                    if (res.retour_validation == "ok") {
                        popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                        setTimeout(() => {
                            document.location.reload();
                        }, 1500)
                    }else{
                        popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                    }
                }
            });
        })
    });
    
</script>


<?php
echo "<div id='bloctitre' style='text-align: left;'><h1>Gestion des demandes de souhaits</h1></div><br />
<div style='clear: both;'></div>";

////////////////////Boutton administration
echo "<a href='".$mode_back_lien_interne."'><button type='button' class='btn btn-default' style='margin-right: 5px;' ><span class='uk-icon-cogs'></span> Administration</button></a>";
if(isset($_GET['action'])){
echo "<a href='?page=Demandes-de-souhaits'><button type='button' class='btn btn-success' style='margin-right: 5px;' ><span class='uk-icon-history'></span> Liste des demandes</button></a>";
echo "<button  type='button' class='btn btn-success' style='margin-right: 5px;' data-toggle='modal' data-target='#addArticle'><span class='uk-icon-history'></span> Ajouter un article</button>";
}
echo "<div style='clear: both;'></div><br />";
////////////////////Boutton administration
?>

<div style='padding: 5px; text-align: center;'>
    <?php
        //AFFICHAGE DES DEMANDES
        if(!isset($action)){
    ?>
        <div id="liste-demandes" style="clear: both;">
            
        </div>

    <?php
        //AFFICHAGE DES DETAILS
        }else if($action == "Details"){
            $sql_select = $bdd->prepare("SELECT * FROM membres_souhait WHERE id=?");
            $sql_select->execute(array($idaction));
            $ligne_select = $sql_select->fetch();
            $sql_select->closeCursor();

            $sql_select = $bdd->prepare("SELECT * FROM membres WHERE id=?");
            $sql_select->execute(array($ligne_select['user_id']));
            $client = $sql_select->fetch();
            $sql_select->closeCursor();

    ?>
            <div class="modal fade" id="addArticle" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title">Ajouter un article</h3>
                    </div>
                    <div class="modal-body">
                        <table>
                            <tr>
                                <td style='padding-bottom:10px;text-align: left; font-weight:bold; width:200px'>Type d'article : </td>
                                <td style='padding-bottom:10px;text-align: left;'>
                                    <select id="article-type" class="form-control">
                                        <option value="1">Identique</option>                                            
                                        <option value="2">Similaire</option>                                            
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style='padding-bottom:10px;text-align: left; font-weight:bold; width:200px'>Nom : </td>
                                <td style='padding-bottom:10px;text-align: left;'>
                                    <input id="article-name" class="form-control" type="text"/>
                                </td>
                            </tr>
                            <tr>
                                <td style='padding-bottom:10px;text-align: left; font-weight:bold; width:200px'>Description : </td>
                                <td style='padding-bottom:10px;text-align: left;'>
                                    <textarea id="article-desc" class="form-control" style="resize:vertical"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td style='padding-bottom:10px;text-align: left; font-weight:bold; width:200px'>Lien de l'article : </td>
                                <td style='padding-bottom:10px;text-align: left;'>
                                    <input id="article-url" class="form-control" type="text"/>
                                </td>
                            </tr>
                            <tr>
                                <td style='padding-bottom:10px;text-align: left; font-weight:bold; width:200px'>Catégorie : </td>
                                <td style='padding-bottom:10px;text-align: left;'>
                                    <select id="article-category" name="article-category" class="form-control">
                                        <?php
                                            $req_boucle = $bdd->prepare("SELECT * FROM categories ORDER BY nom_categorie ASC");
                                            $req_boucle->execute();
                                            while($ligne_boucle = $req_boucle->fetch()){?>
                                                <option value="<?=$ligne_boucle['nom_categorie']?>"><?= $ligne_boucle['nom_categorie']?></option>
                                            <?php 
                                                }
                                                $req_boucle->closeCursor() 
                                            ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style='padding-bottom:10px;text-align: left; font-weight:bold; width:200px'>Quantité : </td>
                                <td style='padding-bottom:10px;text-align: left;'>
                                    <input id="article-quantity" class="form-control" min="1" value="1" type="number"/>
                                </td>
                            </tr>
                            <tr>
                                <td style='padding-bottom:10px;text-align: left; font-weight:bold; width:200px'>Couleur : </td>
                                <td style='padding-bottom:10px;text-align: left;'>
                                    <input id="article-color" class="form-control" type="text"/>
                                </td>
                            </tr>
                            <tr>
                                <td style='padding-bottom:10px;text-align: left; font-weight:bold; width:200px'>Taille : </td>
                                <td style='padding-bottom:10px;text-align: left;'>
                                    <input id="article-size" class="form-control" type="text"/>
                                </td>
                            </tr>
                            <tr>
                                <td style='text-align: left; font-weight:bold; width:200px'>Prix (en F CFA) : </td>
                                <td style='text-align: left;'>
                                    <input id="article-price" type="number" min="1" class="form-control"/>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                        <button type="button" id="addArticleButton" class="btn btn-success">Ajouter</button>
                    </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <div class="well well-sm" style="width: 100%; text-align: left;">
                <h3>Plus de détails sur la liste de souhait n°<?= $ligne_select['id'] ?></h3>
                <table style='text-align: center; width: 100%;' cellpadding='2' cellspacing='2' >

                    <input id="idWish" style="display:none" disabled value=<?= $ligne_select['id']; ?>></input>
                    
                    <tr>
                        <td style='text-align: left; width: 200px;'><strong>Statut :</strong></td>
                        <td style='text-align: left;'>
                            <select id="statut" class="form-control" style="width:200px">
                                <option value="1" <?php if($ligne_select['statut'] == 1){?> selected <?php }?>>En attente d'être traitée</option>
                                <option value="2" <?php if($ligne_select['statut'] == 2){?> selected <?php }?>>En attente d'être payé</option>
                                <option value="3" <?php if($ligne_select['statut'] == 3){?> selected <?php }?>>Refusée</option>
                                <option value="4" <?php if($ligne_select['statut'] == 4){?> selected <?php }?>>Terminée</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td style='text-align: left; min-width: 120px;'><strong>N°client :</strong></td>
                        <td style='text-align: left;'><?php echo $ligne_select['user_id']; ?></td>
                    </tr>
                    <tr>
                        <td style='text-align: left; min-width: 120px;'><strong>Prénom Nom :</strong></td>
                        <td style='text-align: left;'><?php echo $client['prenom']; ?> <?php echo $client['nom']; ?></td>
                    </tr>
                    <tr>
                        <td style='text-align: left; font-weight:bold'>Adresse de livraison : </td>
                        <td style='text-align: left;'>
                            <?php if(($client['adresse'] == null || $client['adresse'] == "") && ($client['ville'] == "" || $client['ville'] == null) && ($client['cp'] == "" || $client['cp'] == null)){
                                echo "Pas d'adresse de livraison renseignée";
                            }else{?>
                                <?= $client['adresse']; ?> <?= $client['ville']; ?> <?= $client['cp']; ?>
                            <?php }?>
                        </td>
                    </tr>
                    <tr>
                        <td style='text-align: left; font-weight:bold'>Adresse de facturation : </td>
                        <td style='text-align: left;'>
                            <?php if(($client['adresse'] == null || $client['adresse'] == "") && ($client['ville'] == "" || $client['ville'] == null) && ($client['cp'] == "" || $client['cp'] == null)){
                                echo "Pas d'adresse de livraison renseignée";
                            }else{?>
                                <?= $client['adresse']; ?> <?= $client['ville']; ?> <?= $client['cp']; ?>
                            <?php }?>
                        </td>
                    </tr>
                    <tr>
                        <td style='text-align: left; font-weight:bold'>Créee le : </td>
                        <td style='text-align: left;'>
                            <?= date("d/m/Y H:i:s", $ligne_select['created_at']); ?>
                        </td>
                    </tr>
                    <tr>
                        <td style='text-align: left; font-weight:bold'>Dernière mise à jour : </td>
                        <td style='text-align: left;'>
                            <?= date("d/m/Y H:i:s", $ligne_select['updated_at']); ?>
                        </td>
                    </tr>
                    <tr>
                        <td style='text-align: left; font-weight:bold'>Titre de la liste de souhait : </td>
                        <td style='text-align: left;'>
                            <?= $ligne_select['titre']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style='text-align: left; font-weight:bold'>Description : </td>
                        <td style='text-align: left;'>
                            <textarea class="form-control" style="resize:vertical; width:50%; min-height: 10rem"><?= $ligne_select['description']; ?></textarea>
                        </td>
                    </tr>
                </table>

                <div style="margin-top:2rem" class="accordion" id="accordionExample">
                    <?php 
                    $sql_boucle = $bdd->prepare("SELECT * FROM membres_souhait_details WHERE liste_id=?");
                    $sql_boucle->execute(array($ligne_select['id']));
                    $compteur = 1;
                    while($ligne_boucle = $sql_boucle->fetch()){?>
                        <div class="accordion-item" style="border-radius:0.5rem;border:1px solid #eeeeee;background-color:#fff">
                            <h2 class="accordion-header" style="margin-top:0px;margin-bottom:0px">
                                <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapse<?= $compteur; ?>" aria-expanded="false">
                                    Article n°<?= $compteur?>
                                </button>
                            </h2>
                            <div id="collapse<?= $compteur; ?>" class="accordion-collapse collapse" data-parent="#accordionExample">
                                <div class="accordion-body">
                                    <table>
                                        <tr>
                                            <td style='padding-bottom:10px;text-align: left; font-weight:bold; width:200px'>Type d'article : </td>
                                            <td style='padding-bottom:10px;text-align: left;'>
                                                <select id="type-<?= $compteur; ?>" class="form-control">
                                                    <option value="1" <?php ($ligne_boucle['type'] == "1") ? "selected" : "" ?>>Identique</option>                                            
                                                    <option value="2" <?php ($ligne_boucle['type'] == "2") ? "selected" : "" ?>>Similaire</option>                                            
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style='padding-bottom:10px;text-align: left; font-weight:bold; width:200px'>Nom : </td>
                                            <td style='padding-bottom:10px;text-align: left;'>
                                                <input id="name-<?= $compteur; ?>" class="form-control" type="text" value="<?= $ligne_boucle['nom'];?>"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style='padding-bottom:10px;text-align: left; font-weight:bold; width:200px'>Description : </td>
                                            <td style='padding-bottom:10px;text-align: left;'>
                                                <textarea id="desc-<?= $compteur; ?>" class="form-control" style="resize:vertical"><?= $ligne_boucle['description']; ?></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style='padding-bottom:10px;text-align: left; font-weight:bold; width:200px'>Lien de l'article : </td>
                                            <td style='padding-bottom:10px;text-align: left;'>
                                                <input id="url-<?= $compteur; ?>" class="form-control" value="<?= $ligne_boucle['url']; ?>" type="text"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style='padding-bottom:10px;text-align: left; font-weight:bold; width:200px'>Catégorie : </td>
                                            <td style='padding-bottom:10px;text-align: left;'>
                                                <select id="category-<?= $compteur; ?>" name="article-category" class="form-control">
                                                    <?php
                                                        $req_boucle = $bdd->prepare("SELECT * FROM categories ORDER BY nom_categorie ASC");
                                                        $req_boucle->execute();
                                                        while($ligne_req = $req_boucle->fetch()){?>
                                                            <option value="<?=$ligne_req['nom_categorie']?>" <?php if($ligne_boucle['categorie'] == $ligne_req['nom_categorie']){echo "selected";} ?>><?= $ligne_req['nom_categorie']?></option>
                                                        <?php 
                                                            }
                                                            $req_boucle->closeCursor() 
                                                        ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style='padding-bottom:10px;text-align: left; font-weight:bold; width:200px'>Quantité : </td>
                                            <td style='padding-bottom:10px;text-align: left;'>
                                                <input id="quantity-<?= $compteur; ?>" class="form-control" min="1" value="<?= $ligne_boucle['quantite']; ?>" type="number"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style='padding-bottom:10px;text-align: left; font-weight:bold; width:200px'>Couleur : </td>
                                            <td style='padding-bottom:10px;text-align: left;'>
                                                <input id="color-<?= $compteur; ?>" class="form-control" value="<?= $ligne_boucle['couleur']; ?>" type="text"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style='padding-bottom:10px;text-align: left; font-weight:bold; width:200px'>Taille : </td>
                                            <td style='padding-bottom:10px;text-align: left;'>
                                                <input id="size-<?= $compteur; ?>" class="form-control" value="<?= $ligne_boucle['taille']; ?>" type="text"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style='padding-bottom:10px;text-align: left; font-weight:bold; width:200px'>Prix (en F CFA) : </td>
                                            <td style='padding-bottom:10px;text-align: left;'>
                                                <input id="price-<?= $compteur; ?>" type="number" min="1" value="<?= $ligne_boucle['prix']; ?>" class="form-control"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style='text-align: left; font-weight:bold; width:200px'><button id="modifierArticle" ida="<?= $ligne_boucle['id']; ?>" class="btn btn-success">Enregistrer</button></td>
                                            <td style='text-align: left;'>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php
                    $compteur += 1;
                    }
                        $req_boucle->closeCursor() ;
                    ?>
                </div>
                <div style="display:flex;margin-top:1rem">
                    <div>
                        <button id="delete" class="btn btn-danger" style="width: 175px; text-align:center">Supprimer la demande</button>
                        <button  type='button' class='btn btn-success' style='margin-right: 5px;' id='updateListe'><span class='uk-icon-history'></span> Modifier la demande</button>
                    </div>
                </div>
            </div>
    <?php }?>
</div>

<?php
}else{
header('location: /index.html');
}
?>