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

if(!empty($_SESSION['4M8e7M5b1R2e8s']) && !empty($user)){

    ?>
    <style>
        #colisTable_length{
            display:none;
        }
        #colisTable_paginate{
            display:none;
        }
    </style>

    <script>

        function onChangePrice(){
            let quantities = document.getElementsByName('article-quantity');
            let prices = document.getElementsByName('article-price');
            let categories = document.querySelectorAll("#article-category");

            var totalFcfa = document.getElementById('total-fcfa');
            var totalEuro = document.getElementById('total-euro');
            var valEuro = parseFloat(0);

            for(let i=0; i<quantities.length;i++){
                const quantity = parseFloat(quantities[i].value);
                const price = parseFloat(prices[i].value);
                const totalEu = parseFloat(quantity*price);

                let type = categories[i].options[categories[i].selectedIndex].getAttribute('type');
                let value = categories[i].options[categories[i].selectedIndex].getAttribute('price');
                let number = categories[i].options[categories[i].selectedIndex].getAttribute('number');
                let label = document.getElementById('article-'+number);
                let indication = document.getElementById('indication-'+number);
                if(type == "1"){
                    //Prix au kg
                    // Calcul : Prix au kg * valeur en kg
                    valEuro += parseFloat(value*totalEu);
                    label.innerHTML = "Kg";
                    indication.innerHTML = "Indiquez un poids";
                }else if(type == "2"){
                    //Prix en pourcentage
                    //Calcul: Valeur * pourcentage/100
                    valEuro += parseFloat(totalEu*value/100);
                    label.innerHTML = "€";
                    indication.innerHTML = "Indiquez un prix";
                }
            }

            totalFcfa.value = parseFloat(valEuro/0.00152449).toFixed(2);
            totalEuro.value = parseFloat(valEuro).toFixed(2);
        };

        
    </script>
    <?php if(!empty($user)){?>
    <script>
        $(document).ready(function (){
            <?php if($action == "Modifier"){?>
                var article = document.getElementById('nbArticle').value;
            <?php }else{?>
                var article = 1;
            <?php }?>

            function listeColis(){
                $.post({
                url : '/panel/Mes-colis/mes-colis-action-liste-ajax.php',
                type : 'POST',
                dataType: "html",
                success: function (res) {
                    $("#liste").html(res);
                }
                });
            }
            listeColis();

            function onChangeId(){
                let articles = document.getElementsByClassName('label-custom');
                for(let i=0; i < article; i++){
                    articles[i].id = "article-"+i;
                }
                let options = document.getElementsByClassName('option-custom');
                var number = 1;
                for(let i=0; i < options.length; i++){
                    if(i%15 == 0 && i !=0){
                        number += 1;
                    }
                    options[i].setAttribute('number', number);
                }
                let handleAddButton = document.getElementsByClassName('handleAdd');
                for(let i=0; i < handleAddButton.length; i++){
                    handleAddButton[i].id = "article-"+i;
                }
                
                let handleRefreshButton = document.getElementsByClassName('handleRefresh');
                for(let i=0; i < handleRefreshButton.length; i++){
                    handleRefreshButton[i].id = "article-"+i;
                }
            }

            $(document).on("click", ".handleAdd", function(e) {
                let id = e.currentTarget.id.split('-')[1];
                console.log(id);
            });

            $(document).on("click", ".handleRefresh", function(e){
                let id = e.currentTarget.id.split('-')[1];
                let names = document.getElementsByName('article-name');
                let descriptions = document.getElementsByName('article-desc');
                let categories = document.getElementsByName('article-category')
                let prices = document.getElementsByName('article-price')
                let quantities = document.getElementsByName('article-quantity')
                
                for(let i=0; i <names.length; i++){
                    if(parseInt(id) === i){
                        names[i].value = "";
                        descriptions[i].value = "";
                        prices[i].value = 0;
                        categories[i].value = "";
                        quantities[i].value = 1;
                    }
                }
            });

            $(document).on("click", "#ajouterColis", function() {
        
                var names = [];
                if(document.getElementsByName('article-name').length > 0){
                    for(let i=0; i<document.getElementsByName('article-name').length; i++){
                        names.push(document.getElementsByName('article-name')[i].value);
                    }
                }

                var descriptions = [];
                if(document.getElementsByName('article-desc').length > 0){
                    for(let i=0; i<document.getElementsByName('article-desc').length; i++){
                        descriptions.push(document.getElementsByName('article-desc')[i].value);
                    }
                }

                var categories = [];
                if(document.getElementsByName('article-category').length > 0){
                    for(let i=0; i<document.getElementsByName('article-category').length; i++){
                        categories.push(document.getElementsByName('article-category')[i].value);
                    }
                }

                var prices = [];
                if(document.getElementsByName('article-price').length > 0){
                    for(let i=0; i<document.getElementsByName('article-price').length; i++){
                        var price = parseFloat(document.getElementsByName('article-price')[i].value);
                        prices.push(price);
                    }
                }

                var quantities = [];
                if(document.getElementsByName('article-quantity').length > 0){
                    for(let i=0; i<document.getElementsByName('article-quantity').length; i++){
                        quantities.push(document.getElementsByName('article-quantity')[i].value);
                    }
                }

                const totalTTC = document.getElementById('total-fcfa').value;
                const comment = document.getElementById('item-comment').value;

                datas = {
                    names: names,
                    descriptions: descriptions,
                    categories: categories,
                    prices: prices,
                    quantities: quantities,
                    totalTTC: totalTTC,
                    comment: comment
                }

                $.post({
                    url: '/panel/Mes-colis/mes-colis-action-ajouter-ajax.php',
                    type: 'POST',
                    data: datas,
                    success: function(res) {
                        res = JSON.parse(res);

                        if (res.retour_validation == "ok") {
                            popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                            document.location.href=res.retour_lien;
                        }else{
                            popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                        }
                    }
                });
            });

            $(document).on("click", "#modifierColis", function() {
                var id = document.getElementById('idColis').value;

                var names = [];
                if(document.getElementsByName('article-name').length > 0){
                    for(let i=0; i<document.getElementsByName('article-name').length; i++){
                        names.push(document.getElementsByName('article-name')[i].value);
                    }
                }

                var descriptions = [];
                if(document.getElementsByName('article-desc').length > 0){
                    for(let i=0; i<document.getElementsByName('article-desc').length; i++){
                        descriptions.push(document.getElementsByName('article-desc')[i].value);
                    }
                }

                var categories = [];
                if(document.getElementsByName('article-category').length > 0){
                    for(let i=0; i<document.getElementsByName('article-category').length; i++){
                        categories.push(document.getElementsByName('article-category')[i].value);
                    }
                }

                var prices = [];
                if(document.getElementsByName('article-price').length > 0){
                    for(let i=0; i<document.getElementsByName('article-price').length; i++){
                        var price = parseFloat(document.getElementsByName('article-price')[i].value);
                        prices.push(price);
                    }
                }

                var quantities = [];
                if(document.getElementsByName('article-quantity').length > 0){
                    for(let i=0; i<document.getElementsByName('article-quantity').length; i++){
                        quantities.push(document.getElementsByName('article-quantity')[i].value);
                    }
                }

                const totalTTC = document.getElementById('total-fcfa').value;
                const comment = document.getElementById('item-comment').value;

                datas = {
                    id: id,
                    names: names,
                    descriptions: descriptions,
                    categories: categories,
                    prices: prices,
                    quantities: quantities,
                    totalTTC: totalTTC,
                    comment: comment
                }

                $.post({
                    url: '/panel/Mes-colis/mes-colis-action-modifier-ajax.php',
                    type: 'POST',
                    data: datas,
                    success: function(res) {
                        res = JSON.parse(res);

                        if (res.retour_validation == "ok") {
                            popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                            document.location.href=res.retour_lien;
                        }else{
                            popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                        }
                    }
                });
            });

            var colis_table = $('#colisTable').DataTable(
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
                colis_table.row.add( [
                    '<input type="text" class="form-control" name="article-name">',
                    '<input type="text" class="form-control" name="article-desc">',
                    "<select id='article-category' name='article-category' onchange='onChangePrice()' class='form-control'><option></option><?php $req_boucle = $bdd->prepare("SELECT * FROM categories ORDER BY nom_categorie ASC");$req_boucle->execute(); while($ligne_boucle = $req_boucle->fetch()){?> <option class='option-custom' number='"+article+"' type=<?= $ligne_boucle['type'];?> price=<?= $ligne_boucle['value']; ?> value=<?=$ligne_boucle['nom_categorie']?>><?= $ligne_boucle['nom_categorie']?></option> <?php } $req_boucle->closeCursor() ?> </select>",
                    "<div class='input-group'><small id='indication-"+article+"' class='form-text text-muted'>Indiquez un poids</small><div style='display:flex'><input aria-describedby='test' style='border-top-right-radius: 0px; border-bottom-right-radius:0px' class='form-control' onchange='onChangePrice()' id='article-price' type='number' value='0' min='1' name='article-price'/><label style='border-top-left-radius: 0px; border-bottom-left-radius:0px;width:50px;justify-content:center' class='input-group-text label-custom' id='article-"+article+"0'>€</label></div></div>",
                    '<div class="row align-items-center" style="padding: 8px 10px"><input style="width:60%; margin-right: 0.5rem" class="form-control" onchange="onChangePrice()" type="number" value="1" min="1" name="article-quantity"/><a href="#" id="article-'+article+'" class="btn-details lineRef handleAdd" style="position:relative;font-size: 20px;color: green;margin-right:0.5rem"><span class="uk-icon-shopping-cart"></span><span class="uk-icon-plus" style="position:absolute;top:0;font-size:10px"></span></a><a href="#" onclick="return false;" class="deleteRow" style="color: #FF9900; margin-left:0.5rem"><span class="uk-icon-trash-o"></span></a></div>',
                ] ).draw();
                article += 1;
                onChangeId();
                onChangePrice();
            });
            $('#colisTable').on('click', '.deleteRow', function () {
                if(article > 1){
                    var row = $(this).parents('tr');
                    if($(row).hasClass('child')){
                        colis_table.row($(row).prev('tr')).remove().draw();
                    } else {
                        colis_table
                        .row($(this).parents('tr'))
                        .remove()
                        .draw();
                    }
                    article -= 1;
                    onChangeId();
                    onChangePrice();
                }
            });
        });
    </script>
    <?php }?>

        <!-- AJOUTER COMMANDE -->
        <?php if(!empty($user) && $action == "Ajouter"){?>
            <div class="container" style="padding:0; margin-bottom:1rem">
                <div class="row" style="margin-top:1rem">
                    <div class="col">
                        <h5>Indiquez-nous les articles que vous souhaitez expédier</h5>
                        <table id="colisTable">
                            <thead>
                                                               <tr scope="col">
                                    <th style="text-align: center;width:15%">Nom d'article</th>
                                    <th style="text-align: center;width:10%">Description</th>
                                    <th style="text-align: center;width:10%">Catégorie</th>
                                    <th style="text-align: center;width:10%">Poids ou prix</th>
                                    <th style="text-align: center;width:5%">Quantité</th>
                                </tr>
                            </thead>
                            <tfoot> 
                                     <tr class="odd">
                                    <th style="text-align: center;width:15%">Nom d'article</th>
                                    <th style="text-align: center;width:10%">Description</th>
                                    <th style="text-align: center;width:10%">Catégorie</th>
                                    <th style="text-align: center;width:10%">Poids ou prix</th>
                                    <th style="text-align: center;width:5%">Quantité</th>
                                </tr>
                            </tfoot>
                                <td>
                                    <input class="form-control" type="text" name="article-name"/>
                                </td>
                                <td>
                                    <input class="form-control" type="text" name="article-desc"/>
                                </td>
                                <td>
                                    <select id="article-category" onchange="onChangePrice()" name="article-category" class="form-control">
                                        <option></option>
                                        <?php
                                            $req_boucle = $bdd->prepare("SELECT * FROM categories ORDER BY nom_categorie ASC");
                                            $req_boucle->execute();
                                        
                                            while($ligne_boucle = $req_boucle->fetch()){?>
                                                <option number="0" type="<?= $ligne_boucle['type']; ?>" price="<?= $ligne_boucle['value']; ?>" value=<?=$ligne_boucle['nom_categorie']?>><?= $ligne_boucle['nom_categorie']?></option>
                                            <?php 
                                                }
                                                $req_boucle->closeCursor() 
                                            ?>
                                    </select>
                                    
                                </td>
                                <td>
                                    <div class="input-group">
                                        <small id="indication-0" class="form-text text-muted">Indiquez un poids</small>
                                        <div style="display:flex">
                                            <input aria-describedby="test" style="border-top-right-radius: 0px; border-bottom-right-radius:0px" class="form-control" onchange="onChangePrice()" id="article-price" type="number" value="0" min="1" name="article-price"/>
                                            <label style="border-top-left-radius: 0px; border-bottom-left-radius:0px;width:50px;justify-content:center" class="input-group-text label-custom" id="article-0">€</label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="row align-items-center" style="padding: 8px 10px">
                                        <input style="width:60%;margin-right: 10px" onchange="onChangePrice()" class="form-control" type="number" min="1" value="1" name="article-quantity"/>
                                        <a href="#" id="article-0" class="btn-details lineRef handleAdd" style="position:relative;font-size: 20px;color: green;margin-right:0.5rem"><span class="uk-icon-shopping-cart"></span><span class="uk-icon-plus" style="position:absolute;top:0;font-size:10px"></span></a>
                                        <a href="#" id="article-0" class="btn-details handleRefresh" style="margin-left:0.5rem;color: #FF9900"><span class="uk-icon-times"></span></a>
                                    </div>
                                </td>
                            </tbody>
                        </table>
                        <button class="btn btn-primary mt-2" id="addItems">Ajouter un article</button>
                    </div>
                </div>
                
                <div class="row" style="margin:0; margin-top: 1.5rem;align-items:end">
                    <div class="col col-5" style="padding:0px;">
                        <label for="item-comment">Commentaire ou précision sur votre commande ?</label>
                        <textarea style="height:100px;resize:none" class="form-control" id="item-comment" placeholder="Écrivez votre commentaire sur la commande"></textarea>
                    </div>
                    <div class="col col-1"></div>
                    <div class="col col-6">
                        <div class="row">
                            <div class="col col-6"></div>
                            <div class="col col-3 form-control text-center border-left border-top border-right" style="border:0">En euro</div>
                            <div class="col col-3 form-control text-center border-top border-right" style="border:0">En fcfa</div>
                        </div>
                        <div class="row">
                            <div class="col col-6 text-center border p-0"><span class="form-control" style="border:none;border-radius:0">Total de vos articles</span></div>
                            <div class="col col-3 border-top border-bottom border-right p-0">
                                <input id="total-euro" value="1" class="form-control" style="border: none;border-radius: 0" disabled/>
                            </div>
                            <div class="col col-3 border-top border-bottom border-right p-0">
                                <input id="total-fcfa" value="1" class="form-control" style="border: none;border-radius: 0" disabled/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row " style="margin:0; margin-top: 1.5rem; flex-direction:row-reverse">
                    <div class="col col-8" style="text-align:end;padding:0">
                        <button type="button" id="<?php if(!empty($user)){echo "ajouterColis";}?>" class="btn btn-primary <?php if (empty($user)) { echo 'pxp-header-user'; }?>">Soumettre</button>
                    </div>
                </div>
            </div>
                                            
        <?php 


        // MODIFIER UN COLIS
        }else if(!empty($user) && $action == "Modifier"){?>
            <?php 
                $sql_select = $bdd->prepare("SELECT * FROM membres_colis WHERE id=? AND user_id=?");
                $sql_select->execute(array($_SESSION['id_colis'], $id_oo));
                $colis = $sql_select->fetch();
                $sql_select->closeCursor();

                $sql_boucle = $bdd->prepare("SELECT * FROM membres_colis_details WHERE colis_id=? ORDER BY id ASC");
                $sql_boucle->execute(array($_SESSION['id_colis']));
                $articles = $sql_boucle->fetchAll();
                $sql_boucle->closeCursor();
            ?>
            <input class="form-control" id="nbArticle" style="display:none;" type="text" value="<?= count($articles); ?>"/>
            <input class="form-control" id="idColis" style="display:none;" type="text" value="<?= $colis['id']; ?>"/>
            <div class="container" style="padding:0; margin-bottom:1rem">
                <div class="row" style="margin-top:1rem">
                    <div class="col">
                        <h5>Indiquez-nous les articles que vous souhaitez expédier</h5>
                        <table id="colisTable">
                            <thead>
                                <tr>
                                    <th style="text-align: center;width:15%">Nom d'article</th>
                                    <th style="text-align: center;width:10%">Description</th>
                                    <th style="text-align: center;width:10%">Catégorie</th>
                                    <th style="text-align: center;width:10%">Poids ou prix</th>
                                    <th style="text-align: center;width:5%">Quantité</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    
                                    $number = 0;
                                    for($i=0; $i < count($articles); $i++){
                                ?>
                                    <tr>
                                        <td>
                                            <input class="form-control" value="<?= $articles[$i]['nom']?>" type="text" name="article-name"/>
                                        </td>
                                        <td>
                                            <input class="form-control" value="<?= $articles[$i]['description']?>" type="text" name="article-desc"/>
                                        </td>
                                        <td>
                                            <select id="article-category" onchange="onChangePrice()" name="article-category" class="form-control">
                                                <?php
                                                    $req_boucle = $bdd->prepare("SELECT * FROM categories ORDER BY nom_categorie ASC");
                                                    $req_boucle->execute();
                                                    while($ligne_boucle = $req_boucle->fetch()){?>
                                                        <option number="<?= $number; ?>" type="<?= $ligne_boucle['type']; ?>" price="<?= $ligne_boucle['value']; ?>" value=<?=$ligne_boucle['nom_categorie']?> <?php if($articles[$i]['categorie'] == $ligne_boucle['nom_categorie']){ echo "selected";}?>><?= $ligne_boucle['nom_categorie']?></option>
                                                    <?php 
                                                        }
                                                        $req_boucle->closeCursor() 
                                                    ?>
                                            </select> 
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input style="border-top-right-radius: 0px; border-bottom-right-radius:0px" class="form-control" onchange="onChangePrice()" id="article-price" type="number" value="<?= $articles[$i]['value']; ?>" min="1" name="article-price"/>
                                                <label style="border-top-left-radius: 0px; border-bottom-left-radius:0px;width:50px;justify-content:center" class="input-group-text label-custom" id="article-<?= $i; ?>">
                                                    <?php if($articles[$i]['type_value'] == "1"){
                                                        echo "Kg";
                                                    }else{
                                                        echo "€";
                                                    }?>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="row align-items-center" style="padding: 8px 10px">
                                            <?php if($number == 0){?>
                                                <input style="margin-right: 10px" onchange="onChangePrice()" class="form-control" type="number" min="1" value="<?= $articles[$i]['quantite']; ?>" name="article-quantity"/>
                                            <?php }else{?>
                                                <input style="width:75%;margin-right: 10px" onchange="onChangePrice()" class="form-control" type="number" min="1" value="<?= $articles[$i]['quantite']; ?>" name="article-quantity"/>
                                                <a href="#" onclick="return false;" class="deleteRow" style="color: #FF9900"><span class="uk-icon-trash-o"></span></a>
                                            <?php }?>
                                            </div> 
                                        </td>
                                    </tr>
                                <?php 
                                    $number++;
                                }?>
                            </tbody>
                        </table>
                        <button class="btn btn-primary mt-2" id="addItems">Ajouter un article</button>
                    </div>
                </div>
                
                <div class="row" style="margin:0; margin-top: 1.5rem;align-items:end">
                    <div class="col col-5" style="padding:0px;">
                        <label for="item-comment">Commentaire ou précision sur votre commande ?</label>
                        <textarea class="form-control" id="item-comment" placeholder="Écrivez votre commentaire sur la commande"><?= $colis['comment']; ?></textarea>
                    </div>
                    <div class="col col-1"></div>
                    <div class="col col-6">
                        <div class="row">
                            <div class="col col-6"></div>
                            <div class="col col-3 form-control text-center border-left border-top border-right" style="border:0">En euro</div>
                            <div class="col col-3 form-control text-center border-top border-right" style="border:0">En fcfa</div>
                        </div>
                        <div class="row">
                            <div class="col col-6 text-center border p-0"><span class="form-control" style="border:none;border-radius:0">Total de vos articles</span></div>
                            <div class="col col-3 border-top border-bottom border-right p-0">
                                <input id="total-euro" value="<?= round($colis['prix_total']*0.00152449,2) ;?>" class="form-control" style="border: none;border-radius: 0" disabled/>
                            </div>
                            <div class="col col-3 border-top border-bottom border-right p-0">
                                <input id="total-fcfa" value="<?= $colis['prix_total']; ?>" class="form-control" style="border: none;border-radius: 0" disabled/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row " style="margin:0; margin-top: 1.5rem; flex-direction:row-reverse">
                    <div class="col col-8" style="text-align:end;padding:0">
                        <button type="button" id="<?php if(!empty($user)){echo "modifierColis";}?>" class="btn btn-primary <?php if (empty($user)) { echo 'pxp-header-user'; }?>">Modifier</button>
                    </div>
                </div>
            </div>
        <?php }


        // AFFICHER TOUS LES COLIS
        if($action != "Ajouter" && $action != "Modifier"){?>
        <div class="row">
            <?php
                include('panel/menu.php');
            ?>
            <div class="col-12 col-lg-9 mt-4 mt-lg-0">
                <div id="liste" style="clear: both;"></div>
            </div>
        </div>
           
            
        <?php }?>
<?php
}else{
    header('location: /index.html');
}
?>