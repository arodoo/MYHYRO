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


$sql_select = $bdd->prepare("SELECT * FROM membres_panier WHERE id_membre=?");
$sql_select->execute(array(htmlspecialchars(strval($id_oo))));
$ligne_select = $sql_select->fetch();
$sql_select->closeCursor();

if ($ligne_select['Titre_panier'] == "Abonnement") {

    $sql_delete = $bdd->prepare("DELETE FROM membres_panier WHERE id_membre=?");
    $sql_delete->execute(array($id_oo));
    $sql_delete->closeCursor();

    $sql_delete = $bdd->prepare("DELETE FROM membres_panier_details WHERE id_membre=?");
    $sql_delete->execute(array($id_oo));
    $sql_delete->closeCursor();

    unset($ligne_select);
}

if (empty($ligne_select['id']) && !empty($id_oo)) {

    $sql_delete = $bdd->prepare("DELETE FROM membres_panier WHERE id_membre=?");
    $sql_delete->execute(array($id_oo));
    $sql_delete->closeCursor();

    $sql_delete = $bdd->prepare("DELETE FROM membres_panier_details WHERE id_membre=?");
    $sql_delete->execute(array($id_oo));
    $sql_delete->closeCursor();

    ///////////////////////////////INSERT
    $sql_insert = $bdd->prepare("INSERT INTO membres_panier
	(id_membre,
	pseudo,
	numero_panier,
	id_facture,
	Titre_panier,
	Contenu,
	Suivi,
	date_edition,
	mod_paiement,
	Tarif_HT,
	Remise,
	Tarif_HT_net,
	Tarif_TTC,
	Total_Tva,
	taux_tva,
	Total_tva2,
	taux_tva2,
	Type_compte_F,
	type_panier
	)
	VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $sql_insert->execute(array(
        $id_oo,
        $user,
        '',
        '',
        "Commande",
        "Commande",
        'non traite',
        $now,
        '',
        '',
        '',
        '',
        '',
        '',
        '1.20',
        '',
        '',
        $statut_compte_oo,
        $type_panier
    ));
    $sql_insert->closeCursor();
}

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
        $action = "Modifier";
    }
}

?>
<style>
    #colisTable_info {
        display: none;
    }

    #colisTable_length {
        display: none;
    }

    #colisTable_paginate {
        display: none;
    }
</style>

<script>
    function handleRefresh(line) {
        if (document.getElementsByName('article-color').length > 0) {
            for (let i = 0; i < document.getElementsByName('article-color').length; i++) {
                if (i == line) {
                    document.getElementsByName('article-color')[i].value = "";
                }
            }
        }
        if (document.getElementsByName('article-size').length > 0) {
            for (let i = 0; i < document.getElementsByName('article-size').length; i++) {
                if (i == line) {
                    document.getElementsByName('article-size')[i].value = "";
                }
            }
        }
        if (document.getElementsByName('article-url').length > 0) {
            for (let i = 0; i < document.getElementsByName('article-url').length; i++) {
                if (i == line) {
                    document.getElementsByName('article-url')[i].value = "";
                }
            }
        }
        if (document.getElementsByName('article-category').length > 0) {
            for (let i = 0; i < document.getElementsByName('article-category').length; i++) {
                if (i == line) {
                    document.getElementsByName('article-category')[i].value = "";
                }
            }
        }
        if (document.getElementsByName('article-price').length > 0) {
            for (let i = 0; i < document.getElementsByName('article-price').length; i++) {
                if (i == line) {
                    document.getElementsByName('article-price')[i].value = "0";
                }
            }
        }
        if (document.getElementsByName('article-quantity').length > 0) {
            for (let i = 0; i < document.getElementsByName('article-quantity').length; i++) {
                if (i == line) {
                    document.getElementsByName('article-quantity')[i].value = "1";
                }
            }
        }
        onChangePrice();
    }
</script>

<script>
    function handleDeleteAllArticlesColis() {
        /*  console.log("handleDeleteAllArticlesColis called"); */

        document.querySelectorAll('.deleteRow').forEach(function(element) {

            let articleId = $(element).data("idart");
            let colisId = <?= $_SESSION['id_colis'] ?>;

            console.log("Deleting article:", articleId, "from colis:", colisId);

            if (articleId && colisId) {

                handleDeleteArticle(colisId, articleId);
            }
        });
    }

    function handleDeleteArticle(idColis, idArticle) {
        /*  console.log("Deleting article:", idArticle, "from colis:", idColis); */
        window.eventoActivado = true;
        $.post({
            url: '/panel/Passage-de-colis/passage-de-colis-action-supprimer-article-ajax.php',
            type: 'POST',
            data: {
                idColis: idColis,
                idArticle: idArticle
            },
            success: function(res) {
                res = JSON.parse(res);

                if (res.retour_validation == "ok") {
                    popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");

                    let rowToDelete = $(`[data-idart="${idArticle}"]`).closest("tr");
                    if (rowToDelete.length) {
                        rowToDelete.remove();
                    }

                    if (document.location.pathname == "/Passage-de-colis") {
                        listeColis();
                    }
                    listeCart();
                } else {
                    popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                }
            },
            error: function(xhr, status, error) {
                console.error("Error deleting article:", error);
            }
        });
    }

    function listeColis() {
        $.post({
            url: '/panel/Passage-de-colis/passage-de-colis-action-liste-ajax.php',
            type: 'POST',
            dataType: "html",
            success: function(res) {
                $("#listeColis").html(res);
            }
        });
    }
    listeColis();

    function listeCart() {
        $.post({
            url: '/panel/Passage-de-commande/passage-de-commande-action-liste-cart-ajax.php',
            type: 'POST',
            dataType: "html",
            success: function(res) {
                $("#cardNav").html(res);
                $("#mobileCartNav").html(res);
            }
        });
    }





    $(document).ready(function() {



        function listeColis() {
            $.post({
                url: '/panel/Passage-de-colis/passage-de-colis-action-liste-ajax.php',
                type: 'POST',
                dataType: "html",
                success: function(res) {
                    $("#listeColis").html(res);
                }
            });
        }
        listeColis();

        function listeCart() {
            $.post({
                url: '/panel/Passage-de-commande/passage-de-commande-action-liste-cart-ajax.php',
                type: 'POST',
                dataType: "html",
                success: function(res) {
                    $("#cardNav").html(res);
                    $("#mobileCartNav").html(res);
                }
            });
        }


   

        $(document).on("click", ".deleteRow", function(e) {
            if ($(this).data("idart")) {

        

                $.post({
                    url: '/panel/Passage-de-colis/passage-de-colis-action-supprimer-article-ajax.php',
                    type: 'POST',
                    data: {
                        idColis: <?= $_SESSION['id_colis'] ?>,
                        idArticle: $(this).data("idart")
                    },


                    success: function(res) {
                        res = JSON.parse(res);

                        if (res.retour_validation == "ok") {
                            popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                            if (document.location.pathname == "/Passage-de-colis") {
                                listeColis();
                            }
                            listeCart();
                        } else {
                            popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                        }
                    }
                })
            }

        })

        $(document).ready(function() {
            //OK
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

            $(document).on("input", "#poids", function() {
                //console.log($(this).val())
                $.post({
                    url: '/panel/Passage-de-colis/passage-de-colis-action-modifier-poids-ajax.php',
                    type: 'POST',
                    data: {
                        poids: $(this).val(),
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

                prix();

            });

            $(document).on("input", "[name='article-price']", function() {
                if ($(this).val() > 0) {
                    prix();
                }

            });

            $(document).on("input", "[name='article-quantity']", function() {
                if ($(this).val() > 0) {
                    prix();
                }

            });

            //OK
            $(document).on("click", ".handleUpdate", function(e) {
                var idColis = document.getElementById('idColis').value;

                let id = e.currentTarget.id.split('-')[1];
                let idArticle = e.currentTarget.id.split('-')[2];
                let names = document.getElementsByName('article-name')[id].value;
                //let descriptions = document.getElementsByName('article-desc')[id].value;
                let categories = document.getElementsByName('article-category')[id].value;
                let prices = document.getElementsByName('article-price')[id].value;
                let quantities = document.getElementsByName('article-quantity')[id].value;
                const totalTTC = document.getElementById('total-fcfa').value;


                datas = {
                    idColis: idColis,
                    id: idArticle,
                    names: names,
                    //descriptions: descriptions,
                    categories: categories,
                    prices: prices,
                    quantities: quantities,
                    totalTTC: totalTTC,
                }
                $.post({
                    url: '/panel/Passage-de-colis/passage-de-colis-action-modifier-article-ajax.php',
                    type: 'POST',
                    data: datas,
                    success: function(res) {
                        res = JSON.parse(res);

                        if (res.retour_validation == "ok") {
                            popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                            listeColis();
                            listeCart();
                        } else {
                            popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                        }
                    }
                });
            });

            //OK
            $(document).on("click", "#ajouterColis", function() {
                var names = [];
                if (document.getElementsByName('article-name').length > 0) {
                    for (let i = 0; i < document.getElementsByName('article-name').length; i++) {
                        names.push(document.getElementsByName('article-name')[i].value);
                    }
                }

                /*var descriptions = [];
                if(document.getElementsByName('article-desc').length > 0){
                    for(let i=0; i<document.getElementsByName('article-desc').length; i++){
                        descriptions.push(document.getElementsByName('article-desc')[i].value);
                    }
                }*/

                var categories = [];
                if (document.getElementsByName('article-category').length > 0) {
                    for (let i = 0; i < document.getElementsByName('article-category').length; i++) {
                        categories.push(document.getElementsByName('article-category')[i].value);
                    }
                }

                var prices = [];
                if (document.getElementsByName('article-price').length > 0) {
                    for (let i = 0; i < document.getElementsByName('article-price').length; i++) {
                        var price = parseFloat(document.getElementsByName('article-price')[i].value);
                        prices.push(price);
                    }
                }

                var quantities = [];
                if (document.getElementsByName('article-quantity').length > 0) {
                    for (let i = 0; i < document.getElementsByName('article-quantity').length; i++) {
                        quantities.push(document.getElementsByName('article-quantity')[i].value);
                    }
                }

                const totalTTC = document.getElementById('total-fcfa').value;
                const comment = document.getElementById('item-comment').value;

                datas = {
                    names: names,
                    //descriptions: descriptions,
                    categories: categories,
                    prices: prices,
                    quantities: quantities,
                    totalTTC: totalTTC,
                    comment: comment
                }

                $.post({
                    url: '/panel/Passage-de-colis/passage-de-colis-action-ajouter-ajax.php',
                    type: 'POST',
                    data: datas,
                    success: function(res) {
                        res = JSON.parse(res);

                        if (res.retour_validation == "ok") {
                            popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                            document.location.href = res.retour_lien;
                        } else {
                            popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                        }
                    }
                });
            });

            //OK
            $(document).on("click", ".handleAdd", function(e) {
                var idColis = document.getElementById('idColis').value;

                let id = e.currentTarget.id.split('-')[1];
                let names = document.getElementsByName('article-name')[id].value;
                //let descriptions = document.getElementsByName('article-desc')[id].value;
                let categories = document.getElementsByName('article-category')[id].value;
                let prices = document.getElementsByName('article-price')[id].value;
                var pricesF = parseFloat(document.getElementsByName('article-price')[id].value / 0.00152449).toString();

                let quantities = document.getElementsByName('article-quantity')[id].value;

                var id_colis_detail = $(this).attr('data-idart');
                var poids = $('#poids').val();


                const totalTTC = document.getElementById('total-fcfa').value;
                const comment = document.getElementById('item-comment').value;

                datas = {
                    names: names,
                    //descriptions: descriptions,
                    categories: categories,
                    prices: prices,
                    pricesF: pricesF,
                    quantities: quantities,
                    totalTTC: totalTTC,
                    id_colis_detail: id_colis_detail,
                    poids: poids
                }


                $.post({
                    url: '/panel/Passage-de-colis/passage-de-colis-action-ajouter-article-ajax.php',
                    type: 'POST',
                    data: datas,
                    success: function(res) {
                        res = JSON.parse(res);

                        if (res.retour_validation == "ok") {
                            popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                            listeColis();
                            listeCart();
                        } else {
                            popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                        }
                    }
                });
            });

            //OK
            $(document).on("click", "#modifierColis", function() {
                var id = document.getElementById('idColis').value;
                var poids = $('#poids').val();

                var names = [];
                if (document.getElementsByName('article-name').length > 0) {
                    for (let i = 0; i < document.getElementsByName('article-name').length; i++) {
                        names.push(document.getElementsByName('article-name')[i].value);
                    }
                }

                /*var descriptions = [];
                if(document.getElementsByName('article-desc').length > 0){
                    for(let i=0; i<document.getElementsByName('article-desc').length; i++){
                        descriptions.push(document.getElementsByName('article-desc')[i].value);
                    }
                }*/

                var categories = [];
                if (document.getElementsByName('article-category').length > 0) {
                    for (let i = 0; i < document.getElementsByName('article-category').length; i++) {
                        categories.push(document.getElementsByName('article-category')[i].value);
                    }
                }

                var prices = [];
                if (document.getElementsByName('article-price').length > 0) {
                    for (let i = 0; i < document.getElementsByName('article-price').length; i++) {
                        var price = parseFloat(document.getElementsByName('article-price')[i].value);
                        prices.push(price);
                    }
                }

                var quantities = [];
                if (document.getElementsByName('article-quantity').length > 0) {
                    for (let i = 0; i < document.getElementsByName('article-quantity').length; i++) {
                        quantities.push(document.getElementsByName('article-quantity')[i].value);
                    }
                }

                var ids = [];
                if (document.getElementsByName('article-quantity').length > 0) {
                    for (let i = 0; i < document.getElementsByName('article-quantity').length; i++) {
                        ids.push($('[line=' + i + ']').attr("data-idart"));
                    }
                }

                const totalTTC = document.getElementById('total-fcfa').value;
                const comment = document.getElementById('item-comment').value;

                datas = {
                    id: id,
                    names: names,
                    //descriptions: descriptions,
                    categories: categories,
                    prices: prices,
                    quantities: quantities,
                    totalTTC: totalTTC,
                    comment: comment,
                    ids_detail: ids,
                    poids: poids
                }

                $.post({
                    url: '/panel/Passage-de-colis/passage-de-colis-action-modifier-ajax.php',
                    type: 'POST',
                    data: datas,
                    success: function(res) {
                        res = JSON.parse(res);

                        if (res.retour_validation == "ok") {
                            popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                            document.location.href = res.retour_lien;
                        } else {
                            popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                            console.log("Error recibido del servidor:", res);
                            console.log("Datos enviados al servidor:", datas);

                    
                            $("#articleTable tbody tr").each(function(index) {
                                const row = $(this);
                                const articleName = row.find('input[name="article-name"]').val() || "";
                                const articleCategory = row.find('select[name="article-category"]').val() || "";
                         

                        
                                if (datas.names[index] === "" || datas.categories[index] === "" ) {
                                    const siblings = row.find('td:not(:first-child)');
                                    const button = row.find('.toggle-row');

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
                                }
                            });
                        }
                    }
                });
            });
        });

        function prix() {
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
                //let indication = document.getElementById('indication-'+i);

                if (type == "2") {
                    valEuro += parseFloat(totalEu * (value / 100));
                }
            }

            totalFcfa.value = parseInt(parseFloat(valEuro / 0.00152449).toFixed(0)).toString();
            totalEuro.value = parseInt(parseFloat(valEuro).toFixed(2)).toString();
        }

        // prix();



        // var article = parseInt(document.getElementById('nbArticle').value);

        /*  function listeColis(){
             $.post({
             url : '/panel/Passage-de-colis/passage-de-colis-action-liste-ajax.php',
             type : 'POST',
             dataType: "html",
             success: function (res) {
                 $("#listeColis").html(res);
             }
             });
         }
         listeColis(); */
    });
</script>

<div id="listeColis"></div>