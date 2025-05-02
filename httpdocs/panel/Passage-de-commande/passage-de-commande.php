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

///////////////////////CREATION PANIER SI EXISTE PAS

$sql_select = $bdd->prepare("SELECT * FROM membres_panier WHERE id_membre=?");
$sql_select->execute(array(htmlspecialchars(strval($id_oo))));
$ligne_select = $sql_select->fetch();
$sql_select->closeCursor();

if ($ligne_selectpa['Titre_panier'] == "Abonnement") {

    $sql_delete = $bdd->prepare("DELETE FROM membres_panier WHERE id_membre=?");
    $sql_delete->execute(array($id_oo));
    $sql_delete->closeCursor();

    $sql_delete = $bdd->prepare("DELETE FROM membres_panier_details WHERE id_membre=?");
    $sql_delete->execute(array($id_oo));
    $sql_delete->closeCursor();
}

if (empty($ligne_select['id'])) {

    /*///////////////////////////////INSERT
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
			"Commande sur $nomsiteweb",
			"Commande sur $nomsiteweb",
			'non traite',
			$now,
			'',
			htmlspecialchars($Tarif_HT),
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
		$sql_insert->closeCursor();*/
}

?>

<style>
    #commandsTable_length {
        display: none;
    }

    #commandsTable_paginate {
        display: none;
    }
</style>

<script>
    function toggleColumnsOnButtonClick() {
        if ($(window).width() <= 768) {
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

                // Abrir la fila si no está visible
                const siblings = $(this).find('td:not(:first-child)');
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

    function listePanier() {
        $.post({
            url: '/panel/Passage-de-commande/passage-de-commande-action-liste-ajax.php',
            type: 'POST',
            dataType: "html",
            success: function(res) {
                $("#listePanier").html(res);
            }
        });
    }
    listePanier();

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





    function handleDeleteAllArticles() {


        let commandeId = document.getElementById('idCommande').value;

        document.querySelectorAll('.deleteRow').forEach(function(element) {
            let articleId = element.getAttribute('data-article-id');
            console.log("Deleting article:", articleId);
            console.log("Deletin article comande:", commandeId);
            if (articleId) {
                /*    console.log("Deleting article:", articleId);
                   console.log("Deletin article comande:", commandeId); */
                handleDeleteArticle(commandeId, articleId);

            }
        });
    }
    

    function handleDeleteArticle(idCommande, idArticle) {
        window.eventoActivado = true;
        /* console.log("handleDeleteArticle called with idCommande:", idCommande, "idArticle:", idArticle); */
        $.post({
            url: '/panel/Passage-de-commande/passage-de-commande-action-supprimer-article-ajax.php',
            type: 'POST',
            data: {
                idCommande: idCommande,
                idArticle: idArticle
            },
            success: function(res) {
                /*   console.log("Response from server:", res); */
                res = JSON.parse(res);

                $("#cardNav").html(res);
                $("#mobileCartNav").html(res);

                if (res.retour_validation == "ok") {
                    popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                    if (document.location.pathname == "/Passage-de-commande") {
                        listePanier();
                    }
                    listeCart();
                } else {
                    popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                }
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
            }
        });
    }

    $(document).ready(function() {
        $(document).on("click", "#ajouterAllArticles", function() {

            var ids = [];
            if (document.getElementsByName('article-id').length > 0) {
                for (let i = 0; i < document.getElementsByName('article-id').length; i++) {
                    ids.push(document.getElementsByName('article-id')[i].value);
                }
            }


            var colors = [];
            if (document.getElementsByName('article-color').length > 0) {
                for (let i = 0; i < document.getElementsByName('article-color').length; i++) {
                    colors.push(document.getElementsByName('article-color')[i].value);
                }
            }

            var sizes = [];
            if (document.getElementsByName('article-size').length > 0) {
                for (let i = 0; i < document.getElementsByName('article-size').length; i++) {
                    sizes.push(document.getElementsByName('article-size')[i].value);
                }
            }

            var urls = [];
            if (document.getElementsByName('article-url').length > 0) {
                for (let i = 0; i < document.getElementsByName('article-url').length; i++) {
                    urls.push(document.getElementsByName('article-url')[i].value);
                }
            }

            var categories = [];
            if (document.getElementsByName('article-category').length > 0) {
                for (let i = 0; i < document.getElementsByName('article-category').length; i++) {
                    categories.push(document.getElementsByName('article-category')[i].value);
                }
            }

            var prices = [];
            if (document.getElementsByName('article-price').length > 0) {
                for (let i = 0; i < document.getElementsByName('article-price').length; i++) {
                    var price = parseFloat(document.getElementsByName('article-price')[i].value / 0.00152449);
                    prices.push(price.toFixed(0));
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
                ids: ids,
                sizes: sizes,
                urls: urls,
                categories: categories,
                prices: prices,
                quantities: quantities,
                totalTTC: totalTTC,
                comment: comment
            };

            $.post({
                url: '/panel/Passage-de-commande/passage-de-commande-action-ajouter-ajax.php',
                type: 'POST',
                data: datas,
                success: function(res) {
                    res = JSON.parse(res);

                    if (res.retour_validation == "ok") {
                        popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                        setTimeout(() => {
                            window.location.assign('/Paiement');
                        }, 1000);
                    } else {
                        popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");

                        /*    console.log("Error recibido del servidor:", res);
                           console.log("Datos enviados al servidor:", datas); */


                        $("#articleTable tbody tr").each(function(index) {
                            const row = $(this);


                            const articleUrl = row.find('input[name="article-url"]').val() || "";
                            const articleCategory = row.find('select[name="article-category"]').val() || "";
                            const articlePrice = parseFloat(row.find('input[name="article-price"]').val()) || 0;


                            if (datas.urls[index] === "" || datas.categories[index] === "" || datas.prices[index] === "" || articlePrice === 0) {
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

        $(document).on("click", "#ajouterCommande", function() {
            var line = this.getAttribute('line');
            var color, nline;

            if (document.getElementsByName('article-color').length > 0) {
                for (let i = 0; i < document.getElementsByName('article-color').length; i++) {
                    if (i == line) {
                        color = document.getElementsByName('article-color')[i].value;
                        nline = i;
                    }
                }
            }

            var saveArticles = [];

            var saveColors = [];
            if (document.getElementsByName('article-color').length > 0) {
                for (let i = 0; i < document.getElementsByName('article-color').length; i++) {

                    if (i == line) {
                        color = document.getElementsByName('article-color')[i].value;
                        nline = i;
                    }
                }
            }


            var sizes = [];
            var saveSizes = [];
            if (document.getElementsByName('article-size').length > 0) {
                for (let i = 0; i < document.getElementsByName('article-size').length; i++) {
                    if (i == line) {
                        size = document.getElementsByName('article-size')[i].value;
                    }
                }
            }

            var urls = [];
            var saveUrls = [];
            if (document.getElementsByName('article-url').length > 0) {
                for (let i = 0; i < document.getElementsByName('article-url').length; i++) {
                    if (i == line) {
                        url = document.getElementsByName('article-url')[i].value;
                    }
                }
            }

            var categories = [];
            var saveCategories = [];
            if (document.getElementsByName('article-category').length > 0) {
                for (let i = 0; i < document.getElementsByName('article-category').length; i++) {
                    if (i == line) {
                        categorie = document.getElementsByName('article-category')[i].value;
                    }
                }
            }

            var prices = [];
            var savePrices = [];
            if (document.getElementsByName('article-price').length > 0) {
                for (let i = 0; i < document.getElementsByName('article-price').length; i++) {

                    if (i == line) {
                        var price = parseFloat(document.getElementsByName('article-price')[i].value / 0.00152449);
                        price = price.toFixed(0);
                    }
                }
            }

            var quantities = [];
            var saveQuantities = [];
            if (document.getElementsByName('article-quantity').length > 0) {
                for (let i = 0; i < document.getElementsByName('article-quantity').length; i++) {
                    if (i == line) {
                        quantitie = document.getElementsByName('article-quantity')[i].value;
                    }
                }
            }

            for (let i = 0; i < saveQuantities.length; i++) {
                if (saveUrls[i] != "" || saveSizes[i] != "" || saveColors[i] != "" || saveCategories[i] != "" || savePrices[i] != "0" || saveQuantities[i] != "1") {
                    saveArticles.push({
                        url: saveUrls[i],
                        size: saveSizes[i],
                        color: saveColors[i],
                        categorie: saveCategories[i],
                        price: savePrices[i],
                        quantitie: saveQuantities[i]
                    });
                }
            }

            const totalTTC = document.getElementById('total-fcfa').value;
            const comment = document.getElementById('item-comment').value;

            datas = {
                color: color,
                size: size,
                url: url,
                categorie: categorie,
                price: price,
                quantitie: quantitie,
                totalTTC: totalTTC,
                comment: comment,
                nbr: nline + 1
            };
            $.post({
                url: '/panel/Passage-de-commande/passage-de-commande-action-ajouter-article-ajax.php',
                type: 'POST',
                data: datas,
                success: function(res) {
                    res = JSON.parse(res);

                    if (res.retour_validation == "ok") {
                        popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                        listeCart();
                        listePanier();
                        $("a[line='" + line + "']").attr('data', res.id_detail);
                        $("a[line='" + line + "']").attr('id', 'modifierArticle');
                        $("a[lined='" + line + "']").attr('onclick', 'handleDeleteArticle(' + res.id_com + ', ' + res.id_detail + ')');

                    } else {
                        popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                    }
                }
            });
        });

        $(document).on("click", "#modifierArticle", function() {
            var line = this.getAttribute('line');
            var numArticle = this.getAttribute('data');

            var color = [];
            if (document.getElementsByName('article-color').length > 0) {
                for (let i = 0; i < document.getElementsByName('article-color').length; i++) {
                    if (i == line) {
                        color.push(document.getElementsByName('article-color')[i].value);
                    }
                }
            }

            var size = [];
            if (document.getElementsByName('article-size').length > 0) {
                for (let i = 0; i < document.getElementsByName('article-size').length; i++) {
                    if (i == line) {
                        size.push(document.getElementsByName('article-size')[i].value);
                    }
                }
            }

            var url = [];
            if (document.getElementsByName('article-url').length > 0) {
                for (let i = 0; i < document.getElementsByName('article-url').length; i++) {
                    if (i == line) {
                        url.push(document.getElementsByName('article-url')[i].value);
                    }
                }
            }

            var categorie = [];
            if (document.getElementsByName('article-category').length > 0) {
                for (let i = 0; i < document.getElementsByName('article-category').length; i++) {
                    if (i == line) {
                        categorie.push(document.getElementsByName('article-category')[i].value);
                    }
                }
            }

            var price = [];
            if (document.getElementsByName('article-price').length > 0) {
                for (let i = 0; i < document.getElementsByName('article-price').length; i++) {
                    var num = parseFloat(document.getElementsByName('article-price')[i].value / 0.00152449);
                    if (i == line) {
                        price.push(num.toFixed(2));
                    }
                }
            }

            var quantitie = [];
            if (document.getElementsByName('article-quantity').length > 0) {
                for (let i = 0; i < document.getElementsByName('article-quantity').length; i++) {
                    if (i == line) {
                        quantitie.push(document.getElementsByName('article-quantity')[i].value);
                    }
                }
            }




            var datas = {
                id: numArticle,
                type: 2,
                color: color[0],
                size: size[0],
                url: url[0],
                categorie: categorie[0],
                price: price[0],
                quantitie: quantitie[0]
            };


            $.post({
                url: '/panel/Passage-de-commande/passage-de-commande-action-modifier-article-ajax.php',
                type: 'POST',
                data: datas,
                success: function(res) {
                    res = JSON.parse(res);

                    if (res.retour_validation == "ok") {
                        popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                        listeCart();
                    } else {
                        popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                    }
                }
            });
        });


        $(document).on("click", "#ajouterArticle", function() {
            var line = this.getAttribute('line');
            var numCommande = this.getAttribute('data');

            var saveArticles = [];

            var color = [];
            var saveColors = [];
            if (document.getElementsByName('article-color').length > 0) {
                for (let i = 0; i < document.getElementsByName('article-color').length; i++) {
                    if (i == line) {
                        color.push(document.getElementsByName('article-color')[i].value);
                    } else if (i > line) {
                        saveColors.push(document.getElementsByName('article-color')[i].value);
                    }
                }
            }

            var size = [];
            var saveSizes = [];
            if (document.getElementsByName('article-size').length > 0) {
                for (let i = 0; i < document.getElementsByName('article-size').length; i++) {
                    if (i == line) {
                        size.push(document.getElementsByName('article-size')[i].value);
                    } else if (i > line) {
                        saveSizes.push(document.getElementsByName('article-size')[i].value);
                    }
                }
            }

            var url = [];
            var saveUrls = [];
            if (document.getElementsByName('article-url').length > 0) {
                for (let i = 0; i < document.getElementsByName('article-url').length; i++) {
                    if (i == line) {
                        url.push(document.getElementsByName('article-url')[i].value);
                    } else if (i > line) {
                        saveUrls.push(document.getElementsByName('article-url')[i].value);
                    }
                }
            }

            var categorie = [];
            var saveCategories = [];
            if (document.getElementsByName('article-category').length > 0) {
                for (let i = 0; i < document.getElementsByName('article-category').length; i++) {
                    if (i == line) {
                        categorie.push(document.getElementsByName('article-category')[i].value);
                    } else if (i > line) {
                        saveCategories.push(document.getElementsByName('article-category')[i].value);
                    }
                }
            }

            var price = [];
            var savePrices = [];
            if (document.getElementsByName('article-price').length > 0) {
                for (let i = 0; i < document.getElementsByName('article-price').length; i++) {
                    var num = parseFloat(document.getElementsByName('article-price')[i].value / 0.00152449);
                    if (i == line) {
                        price.push(num.toFixed(2));
                    } else if (i > line) {
                        savePrices.push(num.toFixed(2));
                    }
                }
            }

            var quantitie = [];
            var saveQuantities = [];
            if (document.getElementsByName('article-quantity').length > 0) {
                for (let i = 0; i < document.getElementsByName('article-quantity').length; i++) {
                    if (i == line) {
                        quantitie.push(document.getElementsByName('article-quantity')[i].value);
                    } else if (i > line) {
                        saveQuantities.push(document.getElementsByName('article-quantity')[i].value);
                    }
                }
            }

            for (let i = 0; i < saveQuantities.length; i++) {
                if (saveUrls[i] != "" || saveSizes[i] != "" || saveColors[i] != "" || saveCategories[i] != "" || savePrices[i] != "0" || saveQuantities[i] != "1") {
                    saveArticles.push({
                        url: saveUrls[i],
                        size: saveSizes[i],
                        color: saveColors[i],
                        categorie: saveCategories[i],
                        price: savePrices[i],
                        quantitie: saveQuantities[i]
                    });
                }
            }

            var datas = {
                id: numCommande,
                type: 2,
                color: color[0],
                size: size[0],
                url: url[0],
                categorie: categorie[0],
                price: price[0],
                quantitie: quantitie[0],
                saved: saveArticles
            };

            $.post({
                url: '/panel/Passage-de-commande/passage-de-commande-action-ajouter-article-ajax.php',
                type: 'POST',
                data: datas,
                success: function(res) {
                    res = JSON.parse(res);

                    if (res.retour_validation == "ok") {
                        popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                        listeCart();
                    } else {
                        popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                    }
                }
            });
        });

        $(document).on("click", "#modifierCommande", function() {
            var id = document.getElementById('idCommande').value;


            var colors = [];
            if (document.getElementsByName('article-color').length > 0) {
                for (let i = 0; i < document.getElementsByName('article-color').length; i++) {
                    colors.push(document.getElementsByName('article-color')[i].value);
                }
            }

            var sizes = [];
            if (document.getElementsByName('article-size').length > 0) {
                for (let i = 0; i < document.getElementsByName('article-size').length; i++) {
                    sizes.push(document.getElementsByName('article-size')[i].value);
                }
            }

            var urls = [];
            if (document.getElementsByName('article-url').length > 0) {
                for (let i = 0; i < document.getElementsByName('article-url').length; i++) {
                    urls.push(document.getElementsByName('article-url')[i].value);
                }
            }

            var categories = [];
            if (document.getElementsByName('article-category').length > 0) {
                for (let i = 0; i < document.getElementsByName('article-category').length; i++) {
                    categories.push(document.getElementsByName('article-category')[i].value);
                }
            }

            var prices = [];
            if (document.getElementsByName('article-price').length > 0) {
                for (let i = 0; i < document.getElementsByName('article-price').length; i++) {
                    var price = parseFloat(document.getElementsByName('article-price')[i].value / 0.00152449);
                    prices.push(price.toFixed(2));
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
                    ids.push($('[line=' + i + ']').attr("data"));
                }
            }

            const totalTTC = document.getElementById('total-fcfa').value;
            const comment = document.getElementById('item-comment').value;

            datas = {
                id: id,
                type: 1,
                colors: colors,
                sizes: sizes,
                urls: urls,
                categories: categories,
                prices: prices,
                quantities: quantities,
                totalTTC: totalTTC,
                ids: ids,
                comment: comment
            };

            $.post({
                url: '/panel/Passage-de-commande/passage-de-commande-action-modifier-ajax.php',
                type: 'POST',
                data: datas,
                success: function(res) {
                    res = JSON.parse(res);

                    if (res.retour_validation == "ok") {
                        popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                        listeCart();
                    } else {
                        popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                    }
                }
            });
        });

        $(document).on("click", "#continueCommande", function() {
            var id = document.getElementById('idCommande').value;


            var colors = [];
            if (document.getElementsByName('article-color').length > 0) {
                for (let i = 0; i < document.getElementsByName('article-color').length; i++) {
                    colors.push(document.getElementsByName('article-color')[i].value);
                }
            }

            var sizes = [];
            if (document.getElementsByName('article-size').length > 0) {
                for (let i = 0; i < document.getElementsByName('article-size').length; i++) {
                    sizes.push(document.getElementsByName('article-size')[i].value);
                }
            }

            var urls = [];
            if (document.getElementsByName('article-url').length > 0) {
                for (let i = 0; i < document.getElementsByName('article-url').length; i++) {
                    urls.push(document.getElementsByName('article-url')[i].value);
                }
            }

            var categories = [];
            if (document.getElementsByName('article-category').length > 0) {
                for (let i = 0; i < document.getElementsByName('article-category').length; i++) {
                    categories.push(document.getElementsByName('article-category')[i].value);
                }
            }

            var prices = [];
            if (document.getElementsByName('article-price').length > 0) {
                for (let i = 0; i < document.getElementsByName('article-price').length; i++) {
                    var price = parseFloat(document.getElementsByName('article-price')[i].value / 0.00152449);
                    prices.push(price.toFixed(2));
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
                    ids.push($('[line=' + i + ']').attr("data"));
                }
            }

            const totalTTC = document.getElementById('total-fcfa').value;
            const comment = document.getElementById('item-comment').value;

            datas = {
                id: id,
                type: 2,
                colors: colors,
                sizes: sizes,
                urls: urls,
                categories: categories,
                prices: prices,
                quantities: quantities,
                totalTTC: totalTTC,
                ids: ids,
                comment: comment
            };

            $.post({
                url: '/panel/Passage-de-commande/passage-de-commande-action-modifier-ajax.php',
                type: 'POST',
                data: datas,
                success: function(res) {
                    res = JSON.parse(res);

                    if (res.retour_validation == "ok") {
                        popup_alert("Continuer la commande !", "green filledlight", "#009900", "uk-icon-check");
                        setTimeout(() => {
                            window.location.assign(res.retour_lien);
                        }, 1000);
                    } else {
                        popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                    }
                }
            });
        });
    });
</script>

<div id="listePanier">

</div>