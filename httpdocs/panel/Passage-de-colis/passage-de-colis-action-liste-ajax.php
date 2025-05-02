<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../Configurations_bdd.php');
require_once('../../Configurations.php');
require_once('../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction = "../../";
require_once('../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

$lasturl = $_SERVER['HTTP_REFERER'];
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


if (isset($_SESSION['id_colis'])) {
    $sql_select = $bdd->prepare('SELECT * FROM membres_colis WHERE id=?');
    $sql_select->execute(array($_SESSION['id_colis']));
    $colis = $sql_select->fetch();
    $sql_select->closeCursor();
    $action = "Modifier";
    $empty = false;
    $id_colis = $colis['id'];
} else {
    $sql_select = $bdd->prepare('SELECT * FROM membres_colis WHERE user_id=? AND statut=1');
    $sql_select->execute(array($id_oo));
    $colis = $sql_select->fetch();
    $sql_select->closeCursor();
    if (!empty($colis['id'])) {

        $id_colis = $colis['id'];
        $_SESSION['id_colis'] = $colis['id'];
        $empty = false;
        $action = "Modifier";
    } else {

        $sql_insert = $bdd->prepare("INSERT INTO membres_colis
                        (comment,
                        user_id,
                        statut,
                        prix_total,
                        created_at,
                        updated_at)
                        VALUES (?,?,?,?,?,?)");
        $sql_insert->execute(array(
            $comment,
            $id_oo,
            htmlspecialchars("1"),
            htmlspecialchars(strval($totalFcfa)),
            $now,
            $now
        ));
        $sql_insert->closeCursor();
        $id_colis = $bdd->lastInsertId();
        $_SESSION['id_colis'] = $id_colis;
        if (empty($user) && empty($id_oo)) {
            $_SESSION['id_ext'] = $_SESSION['id_colis'];
            $id_oo = $_SESSION['id_ext'] . 'ext';
            ///////////////////////////////UPDATE
            $sql_update = $bdd->prepare("UPDATE membres_colis SET
     user_id=? 
     WHERE id=?");
            $sql_update->execute(array(
                $id_oo,
                $id_colis
            ));
            $sql_update->closeCursor();
        }
        $action = "Ajouter";
    }
}

?>
<style>
    /* #articleTable_length {
        display: none;
    }

    #articleTable_paginate {
        display: none;
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }


    #articleTable {
        width: 100%;
        border-collapse: separate;
        margin: 20px 0;
        border: 1px solid #ccc;
    }

    #articleTable th,
    #articleTable td {
        padding: 5px;
        text-align: left;
        vertical-align: middle;
        border: none;
    }

    #articleTable th {
        background-color: #ffffff;
        color: #333;
        font-weight: 10;
        text-align: center;
    }

    #articleTable tr:nth-child(even) {
        background-color: #fff;
    }

    #articleTable tr:nth-child(odd) {
        background-color: #f2f2f2;
    } */

    .add-button {
        background-color: #FF9900;
        border: none;
        padding: 10px;
        cursor: pointer;
        margin: 10px 0;
        border-radius: 5px;
        color: #fff;
        font-size: 14px;
    }

    input[type="text"],
    select,
    input[type="number"] {
        padding: 10px;
        width: 100%;
        box-sizing: border-box;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    .cart-btn,
    .delete-btn {
        cursor: pointer;
        padding: 5px 10px;
        border: none;
        background: none;
    }

    .cart-btn {
        color: green;
        font-size: 20px;
    }

    .delete-btn {
        color: #FF9900;
        font-size: 20px;
    }

    .row.align-items-center {
        display: flex;
        align-items: center;
    }

    #addItems {
        background-color: transparent;
        color: #FF9900;
        border: 2px solid #FF9900;
        border-radius: 20px;
        font-size: 16px;
        font-weight: normal;
        text-align: center;
        transition: background-color 0.3s, color 0.3s;
    }

    #addItems:hover {
        background-color: #FF9900;
        color: white;
    }


    .input-group-text {
        padding: 0 !important;
    }

    .mobile-text {
        display: none;
    }

    @media (max-width: 768px) {

        .mobile-text {
            display: block;
        }

        .uk-icon-trash-o.mobile {
            display: none !important;
        }

        /* #articleTable,
        #articleTable thead,
        #articleTable tbody,
        #articleTable th,
        #articleTable td,
        #articleTable tr {
            display: block;
        }

        #articleTable thead tr {
            display: none;
        }

        #articleTable tr {
            margin-bottom: 10px;
        }

        #articleTable td {
            display: block;
            justify-content: space-between;
            padding: 10px;
            position: relative;
            border: none;
            border-bottom: 1px solid #ddd;
            width: 100%;
            box-sizing: border-box;
        }

        #articleTable td::before {
            content: attr(data-label);
            font-weight: bold;
            font-size: 12px;
            color: #666;
            text-align: left;
            display: block;
            margin-bottom: 5px;
        } */

        #poids {
            width: 220px;
        }

        input[type="text"],
        select,
        input[type="number"] {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
        }

        .row.align-items-center {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
        }

        .btn-details {
            font-size: 24px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #ff9900;
            color: white;
        }

        .btn-details.lineRef {
            color: green;
            background-color: transparent;
            margin-right: 10px;
            text-align: center;
        }

        .btn-details.deleteRow {
            color: #ff9900;
            background-color: transparent;
        }

        .col-md-6,
        .col-md-12,
        .col-sm-6,
        .col-sm-12 {
            width: 100%;
            padding: 0 10px;
        }



        .col-lg-3 .row {
            margin-right: 0 !important;
        }
    }

    .btn-circle {
        background-color: #31b131;
        color: white;
        border: none;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        cursor: pointer;
        padding: 0;
        text-align: center;
    }

    .btn-circle:hover {
        background-color: #31b131;
    }

    .btn-delete-mobile {
        display: none;
    }

    @media (max-width: 768px) {

        .btn-delete-mobile {
            display: block;
        }

        /* .delete-btn {
            display: none;
        } */


        .text-center-adapt {
            display: flex;

        }

        .btn-details.lineRef.handleAdd.button1.btn-add-to-cart,
        .deleteRow {
            margin: 0 auto !important;
        }


        .add-article {
            display: flex;

        }

        .add-article .btn-circle {
            margin-right: 5px;
        }

        .article-color {
            width: 40% !important;
        }

        .article-size {
            width: 35% !important;
        }

        .article-price {
            width: 35% !important;
        }

        .article-quantity {
            width: 30% !important;
        }

        .btn-add-to-cart {
            background-color: #07c546 !important;
            color: white !important;
            padding: 10px 15px;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            width: 70%;
            font-size: 16px !important;
            text-align: center;
            /* Añadir esta línea para centrar el texto */
            margin: 0 auto;
            /* Añadir esta línea para centrar el botón */
        }

        .btn-delete {
            color: #FF9900;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 16px !important;
            text-decoration: none;
            text-decoration: underline;
        }


    }
</style>

<script>
   



    $(document).ready(function() {
        var article = parseInt(document.getElementById('nbArticle').value);




        function toggleIconsToText() {

            /*  if (window.matchMedia("(max-width: 768px)").matches) {
                 $('input[name="article-name"]').each(function(index) {
                     let $thisInput = $(this);

                     if (!$thisInput.next('.deleteRow').length) {
                         $thisInput.after(`
                     <a lined="${index}" class="deleteRow" style="color: #FF9900; margin-left:0.5rem">
                         <span class="uk-icon-trash-o"></span>
                     </a>
                 `);
                     }
                 });
             } */

            if (window.matchMedia("(max-width: 768px)").matches) {
                $('a.lineRef').html("AJOUTER AU PANIER").addClass('btn-add-to-cart');

                // $("tr td div.text-center-adapt a.deleteRow").html("SUPPRIMER").addClass('btn-delete');
            } else {
                $('a.lineRef').html('<span class="uk-icon-shopping-cart"></span><span class="uk-icon-plus" style="position:absolute;top:0;font-size:10px"></span>').removeClass('btn-add-to-cart');

                $("tr td div.text-center-adapt a.deleteRow").html('<span class="uk-icon-trash-o"></span>').removeClass('btn-delete');
            }
        }





        toggleIconsToText();
        $(window).resize(toggleIconsToText);


        let isMobile = $(window).width() <= 768;

        function toggleColumnsOnButtonClick() {
            if (isMobile) {
                $('#articleTable tbody tr').each(function() {
                    let firstCell = $(this).find('td:first-child .add-article');

                    if (!firstCell.find('.toggle-row').length) {
                        firstCell.prepend('<button class="toggle-row btn-circle">+</button>');
                    }

                    const button = firstCell.find('.toggle-row');
                    button.off('click').on('click', function() {
                        const siblings = $(this).closest('tr').find('td:not(:first-child)');

                        siblings.css({
                            'width': '100%',
                            'padding': '10px',
                            'padding-left': '35px'
                        }).slideToggle(300, function() {
                            if (siblings.is(':visible')) {
                                button.text('-').addClass('open');
                                button.css('background-color', 'rgb(211, 51, 51)');
                            } else {
                                button.text('+').removeClass('open');
                                button.css('background-color', '');
                            }
                        });
                    });


                    const $inputArticleUrl = $(this).find('input[name="article-name"]');
                    $inputArticleUrl.off('click').on('click', function() {
                        const siblings = $(this).closest('tr').find('td:not(:first-child)');


                        if (!siblings.is(':visible')) {

                            siblings.css({
                                'width': '100%',
                                'padding': '10px',
                                'padding-left': '35px'
                            }).slideDown(300, function() {

                                button.text('-').addClass('open');
                                button.css('background-color', 'rgb(211, 51, 51)');
                            });
                        }

                    });

                    if ($(this).hasClass('new-row')) {
                        $(this).find('td:not(:first-child)')
                            .css({
                                'padding': '10px',
                                'padding-left': '35px'
                            })
                            .show();
                        $(this).removeClass('new-row');
                    } else {
                        $(this).find('td:not(:first-child)').hide();
                    }
                });
            } else {
                $('#articleTable tbody tr').each(function() {
                    $(this).find('.toggle-row').remove();
                    $(this).find('td').css({
                        'display': 'table-cell',
                        'width': '',
                        'padding': ''
                    });
                });
            }
        }

        toggleColumnsOnButtonClick();




        $(document).on("click", ".handleRefresh", function(e) {
            let id = e.currentTarget.id.split('-')[1];
            let names = document.getElementsByName('article-name');
            //let descriptions = document.getElementsByName('article-desc');
            let categories = document.getElementsByName('article-category')
            let prices = document.getElementsByName('article-price')
            let quantities = document.getElementsByName('article-quantity')

            for (let i = 0; i < names.length; i++) {
                if (parseInt(id) === i) {
                    names[i].value = "";
                    //descriptions[i].value = "";
                    prices[i].value = 0;
                    categories[i].value = "";
                    quantities[i].value = 1;
                }
            }
        });

        $(document).on("change", "#article-category", function() {
            let type = $(this).find('option:selected').attr('type')
            let line = $(this).find('option:selected').attr('number')
            if (type == 1) {
                //console.log('.line'+(line-1));
                $('.line' + (line)).css('display', 'none');
            } else {
                $('.line' + (line)).css('display', '');
            }
            ///onChangePrice()
        });

        function onChangeId() {
            let articles = document.getElementsByClassName('label-custom');
            for (let i = 0; i < articles.length; i++) {
                articles[i].id = "article-" + i;
            }
            let options = document.getElementsByClassName('option-custom');
            /*var number = 0;
            for(let i=0; i < options.length; i++){
                if(i%15 == 0 && i !=0){
                    number += 1;
                }
                options[i].setAttribute('number', number);
            }*/
            let handleAddButton = document.getElementsByClassName('button1');
            for (let i = 0; i < handleAddButton.length; i++) {
                handleAddButton[i].id = "article-" + i;
            }

            let handleRefreshButton = document.getElementsByClassName('handleRefresh');
            for (let i = 0; i < handleRefreshButton.length; i++) {
                handleRefreshButton[i].id = "article-" + i;
            }

        }



        function onChangePrice() {

            let quantities = document.getElementsByName('article-quantity');
            let prices = document.getElementsByName('article-price');
            let categories = document.querySelectorAll("#article-category");

            var totalFcfa = document.getElementById('total-fcfa');
            var totalEuro = document.getElementById('total-euro');
            var valEuro = parseFloat(0);


            if (quantities.length == 0) {
                totalFcfa.value = '0';
                totalEuro.value = '0';

            } else {
                for (let i = 0; i < quantities.length; i++) {
                    const quantity = parseFloat(quantities[i].value);
                    const price = parseFloat(prices[i].value);
                    const totalEu = parseFloat(quantity * price);

                    let type = categories[i].options[categories[i].selectedIndex].getAttribute('type');
                    let value = categories[i].options[categories[i].selectedIndex].getAttribute('price');
                    let number = categories[i].options[categories[i].selectedIndex].getAttribute('number');
                    let label = document.getElementById('article-' + i);

                    if (type == "2") {
                        //Prix en pourcentage
                        //Calcul: Valeur * pourcentage/100
                        valEuro += parseFloat(totalEu * value / 100);
                        label.innerHTML = "€";

                    }
                }

                //console.log(valEuro);

                totalFcfa.value = parseFloat(valEuro / 0.00152449).toFixed(0).toString();
                totalEuro.value = parseFloat(valEuro).toFixed(2);
            }

        };



        $(document).ready(function() {

            var article = parseInt(document.getElementById('nbArticle').value);

            //console.log(article);
            var colis_table = $('#articleTable');

            /*     console.log("Registrando evento #addItems");
                alert("Registrando evento #addItems"); */
            $('#addItems').on('click', function() {
                /* 
                                if (e.type === 'click') {
                                    alert("Se hizo CLICK");
                                } else if (e.type === 'touchstart') {
                                    alert("Se hizo TOUCH");
                                } */


                let table = document.getElementById("articleTable").getElementsByTagName('tbody')[0];
                let newRow = table.insertRow();

                newRow.classList.add('new-row');

                newRow.innerHTML = `
                        <td data-label="NOM D'ARTICLE ${article +1}">
                            <div class="add-article">
                                <input type="text" class="form-control" name="article-name">
                                <a class="deleteRow btn-delete-mobile" id="article-<?= $number; ?>" data-idart="<?= $articles[$number]['id'] ?>" style="margin-left:0.5rem;color: #FF9900"><span class="uk-icon-trash-o deleteRow "></span></a>
                            </div>
                        </td>
                        <td data-label="CATÉGORIE">
                            <select id='article-category' name='article-category' class='form-control'><option></option><?php $req_boucle = $bdd->prepare("SELECT * FROM categories ORDER BY nom_categorie ASC");
                                                                                                                        $req_boucle->execute();
                                                                                                                        while ($ligne_boucle = $req_boucle->fetch()) { ?> <option class='option-custom' number='` + article + `' type='<?= $ligne_boucle['type']; ?>' price='<?= $ligne_boucle['value']; ?>' value='<?= $ligne_boucle['nom_categorie'] ?>'><?= $ligne_boucle['nom_categorie'] ?></option> <?php }
                                                                                                                                                                                                                                                                                                                                                                                                        $req_boucle->closeCursor() ?> </select>
                        </td>
                        <td data-label="PRIX UNITAIRE (€)">
                            <div class='input-group line` + article + `' style='display:none;'><div style='display:flex'><input aria-describedby='test' style='border-top-right-radius: 0px; border-bottom-right-radius:0px' class='form-control' id='article-price' type='number' value='0' min='1' name='article-price'/><label style='border-top-left-radius: 0px; border-bottom-left-radius:0px;width:50px;justify-content:center' class='input-group-text label-custom' id='article-` + article + `0'>€</label></div></div>
                        </td>
                         <td data-label="QUANTITÉ">
                                   <div>
                                        <select style="width:100%; margin-right: 10px" class="form-control article-quantity" name="article-quantity">
                                            <?php for ($j = 1; $j <= 100; $j++): ?>
                                                <option value="<?= $j; ?>" <?= ($articles[$i]['quantite'] == $j) ? 'selected' : ''; ?>>
                                                    <?= $j; ?>
                                                </option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>

                                </td>
                                <td data-label="">
                                    <div class="text-center-adapt" >
                                       <a  id="article-` + article + `" class="btn-details lineRef handleAdd button1" line="` + article + `" style="position:relative;font-size: 20px;color: green;margin-right:0.5rem"><span class="uk-icon-shopping-cart"></span><span class="uk-icon-plus" style="position:absolute;top:0;font-size:10px"></span></a>
                                      
                                    </div> 
                                </td>
                                <td data-label="">
                                    <div class="text-center-adapt delete-btn" >
                                      
                                       <a lined="` + article + `"  onclick="return false;" class="deleteRow" style="color: #FF9900; /* margin-left:0.5rem */">
                                       <span class=""uk-icon-trash-o mobile></span>
                                          <span class="mobile-text" style="text-decoration: underline;">SUPPRIMER</span>
                                       </a>
                                  
                                       </div> 
                                </td>
                    `;

                //var article = parseInt(document.getElementById('nbArticle').value);
                //console.log(article);
                article += 1;
                //onChangeId();
                //onChangePrice();
                toggleIconsToText();
                toggleColumnsOnButtonClick()
            });

            if (article == 0) {
                let table = document.getElementById("articleTable").getElementsByTagName('tbody')[0];
                let newRow = table.insertRow();

                newRow.innerHTML = `
                        <td data-label="NOM D'ARTICLE ${article +1}">
                        <div class="add-article">
                            <input type="text" class="form-control" name="article-name">
                            <a class="deleteRow btn-delete-mobile" id="article-<?= $number; ?>" data-idart="<?= $articles[$number]['id'] ?>" style="margin-left:0.5rem;color: #FF9900"><span class="uk-icon-trash-o deleteRow "></span></a>
                        </div> 
                        </td>
                        <td data-label="CATÉGORIE">
                            <select id='article-category' name='article-category' class='form-control'><option></option><?php $req_boucle = $bdd->prepare("SELECT * FROM categories ORDER BY nom_categorie ASC");
                                                                                                                        $req_boucle->execute();
                                                                                                                        while ($ligne_boucle = $req_boucle->fetch()) { ?> <option class='option-custom' number='` + article + `' type='<?= $ligne_boucle['type']; ?>' price='<?= $ligne_boucle['value']; ?>' value='<?= $ligne_boucle['nom_categorie'] ?>'><?= $ligne_boucle['nom_categorie'] ?></option> <?php }
                                                                                                                                                                                                                                                                                                                                                                                                        $req_boucle->closeCursor() ?> </select>
                        </td>
                        <td data-label="PRIX UNITAIRE (€)">
                            <div class='input-group line` + article + `' style='display:none;'><div style='display:flex'><input aria-describedby='test' style='border-top-right-radius: 0px; border-bottom-right-radius:0px' class='form-control' id='article-price' type='number' value='0' min='1' name='article-price'/><label style='border-top-left-radius: 0px; border-bottom-left-radius:0px;width:50px;justify-content:center' class='input-group-text label-custom' id='article-` + article + `0'>€</label></div></div>
                        </td>
                         <td data-label="QUANTITÉ">
                                   <div >
                                        <select style="width:100%; margin-right: 10px" class="form-control article-quantity" name="article-quantity">
                                            <?php for ($j = 1; $j <= 100; $j++): ?>
                                                <option value="<?= $j; ?>" <?= ($articles[$i]['quantite'] == $j) ? 'selected' : ''; ?>>
                                                    <?= $j; ?>
                                                </option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>

                                </td>
                                <td data-label="">
                                    <div class="text-center-adapt" >
                                       <a id="article-` + article + `" class="btn-details lineRef handleAdd button1" line="` + article + `" style="position:relative;font-size: 20px;color: green;margin-right:0.5rem"><span class="uk-icon-shopping-cart"></span><span class="uk-icon-plus" style="position:absolute;top:0;font-size:10px"></span></a>
                                       
                                    </div> 
                                </td>
                                <td data-label="">
                                    <div class="text-center-adapt delete-btn" >
                                       
                                       <a lined="` + article + `"  onclick="return false;" class="deleteRow" style="color: #FF9900; /* margin-left:0.5rem */">
                                       <span class="uk-icon-trash-o mobile"></span>
                                        <span class="mobile-text" style="text-decoration: underline;">SUPPRIMER</span>
                                       </a>
                                    
                                       </div> 
                                </td>
                    `;
                article += 1;
                //onChangeId();
                //onChangePrice(); 
                toggleIconsToText();
                toggleColumnsOnButtonClick()
            }

            $(document).ready(function() {
                $('#articleTable').on('click', '.deleteRow', function(e) {
                    e.preventDefault();

                    if (article > 1) {
                        deleteRow($(this));
                    }
                });
            });

            function deleteRow(btn) {
                let row = btn.closest('tr');

                row.remove();

                article -= 1;

                onChangeId();
                onChangePrice();
            }

            function hcsdc() {
                var quant = 0;
                if (document.getElementsByName('article-quantity').length > 0) {
                    for (let i = 0; i < document.getElementsByName('article-quantity').length; i++) {
                        quant = quant + parseInt(document.getElementsByName('article-quantity')[i].value);
                    }
                }
                /*  console.log(quant); */
                //$('#quant_art').text(quant+ " article(s) dans votre colis");
            }

            hcsdc();


            function afficherprix() {

                if (document.getElementsByName('article-category').length > 0) {
                    for (let i = 0; i < document.getElementsByName('article-category').length; i++) {
                        //document.getElementsByName('article-category')[i].value;
                        let type = $('.artcle-cat' + i).find('option:selected').attr('type')
                        //console.log(type)
                        let line = $('.artcle-cat' + i).find('option:selected').attr('number')
                        if (type == 1) {
                            //console.log('.line'+(line-1));
                            $('.line' + (line)).css('display', 'none');
                        } else {
                            $('.line' + (line)).css('display', '');
                        }
                    }
                }
            }

            afficherprix()


        });

        function prix() {
            var totalFcfaLabel = document.getElementById('total-fcfa-label');
            var totalEuroLabel = document.getElementById('total-euro-label');
            var totalFcfa = document.getElementById('total-fcfa');
            var totalEuro = document.getElementById('total-euro');
            var prixkilo = <?= $prix_kilo_colis ?>;

            valEuro = ($('#poids').val()) * prixkilo;

            let quantities = document.getElementsByName('article-quantity');
            let prices = document.getElementsByName('article-price');
            let categories = document.querySelectorAll("#article-category");

            for (let i = 0; i < quantities.length; i++) {
                const quantity = parseFloat(quantities[i].value);
                const price = parseFloat(prices[i].value);
                const totalEu = parseFloat(quantity * price);

                let type = categories[i].options[categories[i].selectedIndex].getAttribute('type');
                let value = categories[i].options[categories[i].selectedIndex].getAttribute('price');
                let number = categories[i].options[categories[i].selectedIndex].getAttribute('number');
                let label = document.getElementById('article-' + i);


                if (type == "2") {
                    valEuro += parseFloat(totalEu * (value / 100));
                }
            }

            totalFcfaLabel.innerHTML = parseFloat(parseFloat(valEuro / 0.00152449).toFixed(0)).toLocaleString() + " F CFA";
            totalEuroLabel.innerHTML = parseFloat(parseFloat(valEuro).toFixed(2)).toLocaleString() + " €";

            totalFcfa.value = parseFloat(valEuro / 0.00152449).toFixed(0);
            totalEuro.value = parseFloat(valEuro).toFixed(2);

        }

        prix();

        function updatePrix() {
            $.post({
                url: '/panel/Passage-de-colis/passage-de-colis-action-modifier-prix-ajax.php',
                type: 'POST',
                data: {
                    prix: $('#total-fcfa').val(),
                },
                dataType: "json",
                success: function(res) {
                    if (res.retour_validation == "ok") {
                        //popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                    } else {
                        //popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                    }
                }
            });
        }
        updatePrix();



    });
</script>

<!-- AJOUTER COLIS -->
<?php
/*if(!empty($user) && $action == "Ajouter"){?>

// MODIFIER UN COLIS
}else */ if ($action == "Modifier") {
    /*    echo $id_oo */
?>
    <?php


    $sql_select = $bdd->prepare('SELECT * FROM membres_colis WHERE user_id=? AND statut=1');
    $sql_select->execute(array($id_oo));
    $colis = $sql_select->fetch();
    $sql_select->closeCursor();

    $_SESSION['id_colis'] = $colis['id'];

    $sql_boucle = $bdd->prepare("SELECT * FROM membres_colis_details WHERE colis_id=? ORDER BY id ASC");
    $sql_boucle->execute(array($_SESSION['id_colis']));
    $articles = $sql_boucle->fetchAll();
    $sql_boucle->closeCursor();
    ?>
    <input class="form-control" id="nbArticle" style="display:none;" type="text" value="<?= count($articles); ?>" />
    <input class="form-control" id="idColis" style="display:none;" type="text" value="<?= $colis['id']; ?>" />
    <div class="container" style="padding:0; margin-bottom:1rem">
        <div class="row" style="margin-top:1rem">
            <div class="col">


                <div class="container" style="background-color: #efe4b0; display: flex; flex-direction: column; align-items: center; font-size: 14px; padding-top: 10px; border-radius: 10px;">

                    <span style="font-weight: bold; align-self: flex-start;">Important: Mes produits sont command&eacutes rapidement!!?</span>

                    <div style="display: flex; flex-direction: row; align-items: center; ">
                        <ul>
                            <li>&#8226; Renseignez les prix exacts de vos articles tels qu'ils sont indiqu&eacute;s sur vos sites d'achats. Le prix constitue le premier &eacute;l&eacute;ment de v&eacute;rification.</li>
                            <li>&#8226; Copiez et collez vos liens correctement. Vous pouvez les v&eacute;rifier en cliquant dessus une fois ajout&eacute; au panier ou &agrave; l'&eacute;tape suivante.</li>
                            <li>&#8226; Renseignez la couleur, la taille ou la pointure telle qu'indiqu&eacute;e sur votre site d'achat. Pensez &agrave; v&eacute;rifier la disponibilit&eacute; de vos articles.</li>
                            <li>&#8226; Les &eacute;l&eacute;ments "couleurs, taille de pointure telle qu'indiqu&eacute;e sur votre site d'achat. Pensez &agrave; v&eacute;rifier la disponibilit&eacute; de vos articles.</li>
                        </ul>

                        <img src="/images/box-cart.png" alt="Description de l'image" style="margin-left: 20px; width: 100px;">
                    </div>
                </div>

                <div class="container" style="width: 20%; margin: 0; padding: 0;">
                    <div class="row" style="margin-top: 1rem;">
                        <div class="col">
                            <div class="input-container" style="position: relative; margin-bottom: 20px;margin-top: 20px;">
                                <div class="label" style="display: block; text-align: left; width: 150px;"><strong>Poids du colis</strong></div>
                                <div class="input-group">
                                    <div style="display:flex">
                                        <input style="border-top-right-radius: 0px; border-bottom-right-radius:0px;min-width: 36px ;max-width:50% !important" class="form-control" placeholder="Entrez le poids" id="poids" type="number" value="<?= $colis['poids'] ?>" min="1" name="poids" />
                                        <label style="border-top-left-radius: 0px; border-bottom-left-radius:0px;width:50px;justify-content:center" class="input-group-text label-custom">Kg
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-9 col-md-12">
                        <table id="articleTable" class="display" style="text-align: center; width: 100%; border-radius: 7px;" cellpadding="2" cellspacing="2">
                            <thead>
                                <tr scope="col">
                                    <th style="text-align: center;width:20%">NOM D'ARTICLE</th>
                                    <!--th style="text-align: center;width:30%">Description</th-->
                                    <th style="text-align: center;width:25%">CATÉGORIE</th>
                                    <th style="text-align: center;width:15%">PRIX UNITAIRE (€)</th>
                                    <th style="text-align: center;width:5%">QUANTITÉ</th>
                                    <th style="text-align: center; width:5%">AJOUTER</th>
                                    <th style="text-align: center; width:5%"><i class="uk-icon-trash-o trash-black " onclick="handleDeleteAllArticlesColis()"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $number = 0;
                                for ($i = 0; $i < count($articles); $i++) {
                                ?>
                                    <tr class="odd">

                                        <td class="dtr-control" data-label="NOM D'ARTICLE <?= $i + 1; ?>">
                                            <div class="add-article">
                                                <button class="toggle-row btn-circle">+</button>
                                                <!--   <button class="toggle-row btn btn-primary" style="margin-right: 8px;">voir plus</button> -->
                                                <input class="form-control" value="<?= $articles[$i]['nom'] ?>" type="text" name="article-name" />
                                                <a class="deleteRow btn-delete-mobile" id="article-<?= $number; ?>" data-idart="<?= $articles[$number]['id'] ?>" style="margin-left:0.5rem;color: #FF9900"><span class="uk-icon-trash-o deleteRow "></span></a>
                                            </div>
                                        </td>
                                        <!--td>
                                    <input class="form-control" value="<?= $articles[$i]['description'] ?>" type="text" name="article-desc"/>
                                </td-->
                                        <td data-label="CATÉGORIE">
                                            <select id="article-category" name="article-category" class="form-control artcle-cat<?= $i ?>">
                                                <?php
                                                $req_boucle = $bdd->prepare("SELECT * FROM categories ORDER BY nom_categorie ASC");
                                                $req_boucle->execute();
                                                while ($ligne_boucle = $req_boucle->fetch()) { ?>
                                                    <option number="<?= $number; ?>" type="<?= $ligne_boucle['type']; ?>" price="<?= $ligne_boucle['value']; ?>" value="<?= $ligne_boucle['nom_categorie'] ?>" <?php if ($articles[$i]['categorie'] == $ligne_boucle['nom_categorie']) {
                                                                                                                                                                                                                    echo "selected";
                                                                                                                                                                                                                } ?>><?= $ligne_boucle['nom_categorie'] ?></option>
                                                <?php
                                                }
                                                $req_boucle->closeCursor()
                                                ?>
                                            </select>
                                        </td>
                                        <td data-label="PRIX UNITAIRE (€)">
                                            <div class="input-group line<?= $i ?>">
                                                <div style="display:flex">
                                                    <input style="border-top-right-radius: 0px; border-bottom-right-radius:0px" class="form-control" id="article-price" type="number" value="<?= $articles[$i]['value']; ?>" min="1" name="article-price" />
                                                    <label style="border-top-left-radius: 0px; border-bottom-left-radius:0px;width:50px;justify-content:center" class="input-group-text label-custom" id="article-<?= $i; ?>">
                                                        <?php /*if($articles[$i]['type_value'] == "1"){
                                                    echo "Kg";
                                                }else{*/
                                                        echo "€";
                                                        //}
                                                        ?>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-label="QUANTITÉ">
                                            <div>
                                                <select style="width:100%; margin-right: 10px" class="form-control article-quantity" name="article-quantity">
                                                    <?php for ($j = 1; $j <= 100; $j++): ?>
                                                        <option value="<?= $j; ?>" <?= ($articles[$i]['quantite'] == $j) ? 'selected' : ''; ?>>
                                                            <?= $j; ?>
                                                        </option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>

                                        </td>
                                        <td data-label="">
                                            <div class="text-center-adapt">
                                                <a id="article-<?= $number; ?>-<?= $articles[$number]['id'] ?>" line="<?= $i ?>" data-idart="<?= $articles[$number]['id'] ?>" class="btn-details lineRef handleAdd button1" style="position:relative;font-size: 20px;color: green;margin-right:0.5rem"><span class="uk-icon-shopping-cart"></span><span class="uk-icon-plus" style="position:absolute;top:0;font-size:10px"></span></a>


                                            </div>
                                        </td>
                                        <td data-label="">
                                            <div class="text-center-adapt delete-btn">

                                                <a class="deleteRow" id="article-<?= $number; ?>" data-idart="<?= $articles[$number]['id'] ?>" style="/* margin-left:0.5rem; */color: #FF9900">
                                                    <span class="uk-icon-trash-o deleteRow mobile"></span>
                                                    <span class="mobile-text" style="text-decoration: underline;">SUPPRIMER</span>
                                                </a>

                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                    $number++;

                                    $quant += $articles[$i]['quantite'];
                                } ?>
                            </tbody>
                        </table><br>
                        <div id="quant_art"><?= $quant ?> article(s) dans votre colis</div>
                        <button class="btn btn-primary mt-2" id="addItems">Ajouter un article</button>
                    </div>
                    <div class="col-lg-3 col-md-12" style="align-self: flex-start; position: sticky; top: 0;">
                        <div class="row" style="margin-right: 20px; ">
                            <div class="col-md-12" style="background-color: #E6F7E6; padding: 20px; border-radius: 10px; text-align: center; margin: 20px;">
                                <h4 style="font-weight: normal;">Total articles</h4>
                                <h1 style="font-size: 2rem; font-weight: bold; color: #003C71;" id="total-fcfa-label">
                                    <?php if ($colis['prix_total']) {
                                        number_format($colis['prix_total'], 0, '.', ' ');
                                    } ?> FCFA
                                </h1>
                                <p style="color: #666;" id="total-euro-label">En euro : <?php if ($colis['prix_total']) {
                                                                                            echo round($colis['prix_total'] * 0.00152449);
                                                                                        } ?>€</p>
                                <input id="total-euro" type="hidden" value="<?php if ($colis['prix_total']) {
                                                                                echo round($colis['prix_total'] * 0.00152449);
                                                                            } ?>">
                                <input id="total-fcfa" type="hidden" value="<?php if ($colis['prix_total']) {
                                                                                echo $colis['prix_total'];
                                                                            } ?>">
                                <button type="button" id="<?php if (!empty($user)) {
                                                                echo "modifierColis";
                                                            } ?>" class="btn btn-primary <?php if (empty($user)) {
                                                                                                echo 'pxp-header-user';
                                                                                            } ?>">VALIDER COLIS</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label for="item-comment" style="font-size: 14px;">Commentaire ou précision sur votre commande ?</label>
                                <textarea style="height: 100px; resize: none; padding: 10px;" class="form-control" id="item-comment" placeholder="Écrivez votre commentaire sur la commande"><?= $colis['comment']; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>


        <div class="row " style="margin:0; margin-top: 1.5rem; flex-direction:row-reverse">
            <div class="col col-8" style="text-align:end;padding:0">

            </div>
        </div>
    </div>
<?php } ?>