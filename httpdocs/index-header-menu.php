<script>
    function listeCart() {
        $.post({
            url: '/panel/Passage-de-commande/passage-de-commande-action-liste-cart-ajax.php',
            type: 'POST',
            dataType: "html",
            success: function(res) {
                $("#cardNav").html(res);
               
            }
        });
    }
    listeCart();

    function RecapitulatifPanier(i) {
        $.post({
            url: '/pages/paiements/Panier/Panier2-recapitulatif-ajax.php',
            type: 'POST',
            data: {},
            dataType: "html",
            success: function(res) {
                $("#panier_recap_prix").html(res);
                if (i == true) {
                    show();
                } else {
                    $('#show2').attr('class', 'show-less');
                    $('#show2').text('[-]');
                }
            }
        });

    }

    /* function listePanier() {
        $.post({
            url: '/panel/Passage-de-commande/passage-de-commande-action-liste-ajax.php',
            type: 'POST',
            dataType: "html",
            success: function(res) {
                $("#listePanier").html(res);
            }
        });
    } */

    function listePanier() {
        $.post({
            url: '/panel/Passage-de-commande/passage-de-commande-action-liste-ajax.php',
            type: 'POST',
            dataType: "html",
            success: function(res) {

                $("#listePanier").html(res);





                /*     onChangePrice(); */
            },
            error: function(xhr, status, error) {

            }
        });

    }



    listePanier();


    function handlePaiement(e) {
        $.ajax({
            url: '/pages/paiements/Panier/Panier-action.php',
            dataType: "json",
            data: {
                id: e
            },
            success: function(res) {
                if (res.retour_validation == "ok") {
                    document.location.replace('/Paiement');
                } else if (res.retour_validation == "non") {
                    document.location.reload();
                }
            }
        })
    }

    $(document).ready(function() {

        let profil = document.getElementById('profilButtonNav');
        let dropdown = document.querySelector('.indicator__dropdown');
        let hideTimeout;


        profil.addEventListener("mouseenter", function() {
            clearTimeout(hideTimeout);
            profil.classList.add('indicator--open');
            profil.classList.add('indicator--display');
        });

        profil.addEventListener("mouseleave", function() {

            hideTimeout = setTimeout(function() {
                if (!dropdown.matches(':hover')) {
                    profil.classList.remove('indicator--open');
                    profil.classList.remove('indicator--display');
                }
            }, 300);
        });

        
        dropdown.addEventListener("mouseenter", function() {
            clearTimeout(hideTimeout);
            profil.classList.add('indicator--open');
            profil.classList.add('indicator--display');
        });


        dropdown.addEventListener("mouseleave", function() {
            hideTimeout = setTimeout(function() {
                profil.classList.remove('indicator--open');
                profil.classList.remove('indicator--display');
            }, 300);
        });


        $(document).on('click', '#profilButton', function() {
            window.location.assign('/Gestion-de-votre-compte.html');
        });

        $(document).on('click', "#addList", function() {
            $('#demande_souhait').modal('show');
        })

        $(document).on('click', "#supp_pan", function() {
            $.post({
                url: '/panel/Passage-de-commande/passage-de-commande-action-supprimer-article-panier-ajax.php',
                type: 'POST',
                data: {
                    idaction: $(this).attr("data-id"),
                },
                dataType: "json",
                success: function(res) {
                    if (res.retour_validation == "ok") {
                        if (res.retour_lien == 0) {
                            location.href = '/Passage-de-commande';
                        }
                        listeCart();
                        RecapitulatifPanier();

                        listePanier();
                    } else {
                        popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                    }
                }
            });
        })
    });
</script>

<div class="nav-panel__departments">
    <!-- .departments -->
    <div class="departments" data-departments-fixed-by="">
        <div class="departments__body">
            <div class="departments__links-wrapper">
                <div class="departments__submenus-container"></div>
                <ul class="departments__links">
                    <li class="departments__item"><a href="/Sites-d-achats-recommandes" class="departments__item-link">Tous</a></li>
                    <li class="departments__item">
                        <a class="departments__item-link" href="/Sites-d-achats-recommandes/">
                            Sites généralistes
                            <svg class="departments__item-arrow" width="6px" height="9px">
                                <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-right-6x9"></use>
                            </svg>
                        </a>
                        <div class="departments__submenu departments__submenu--type--megamenu departments__submenu--size--sm" style="max-height: 617px;">
                            <!-- .megamenu -->
                            <div class="megamenu  megamenu--departments ">
                                <div class="megamenu__body">
                                    <div class="row">
                                        <div class="col-12">
                                            <ul class="megamenu__links megamenu__links--level--0 row" style="justify-content: space-between;">
                                                <li class="megamenu__item  megamenu__item--with-submenu ">
                                                    <a href="/Sites-d-achats-recommandes" target="blank_"><span>Tous</span></a>
                                                    <ul class="megamenu__links megamenu__links--level--1">
                                                        <li class="megamenu__item"><a href="https://www.amazon.fr/" target="blank_">Amazon</a></li>
                                                        <li class="megamenu__item"><a href="https://www.cdiscount.com/" target="blank_">Cdiscount</a></li>
                                                        <li class="megamenu__item"><a href="https://fr.shopping.rakuten.com/" target="blank_">Priceminister</a></li>
                                                        <li class="megamenu__item"><a href="https://www.rueducommerce.fr/" target="blank_">Rueducommerce</a></li>
                                                        <li class="megamenu__item"><a href="https://www.asdiscount.com/" target="blank_">Asdiscount</a></li>
                                                        <li class="megamenu__item"><a href="https://www.pixmania.com/fr/fr/" target="blank_">Pixmania</a></li>
                                                        <li class="megamenu__item"><a href="https://www.mistergooddeal.com/" target="blank_">Mister good deal</a></li>
                                                    </ul>
                                                </li>
                                                <li><img src="/images/sites-generalistes.jpg" style="width: 300px" alt="sac de shopping"></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="departments__item">
                        <a class="departments__item-link" href="#">
                            Femmes
                            <svg class="departments__item-arrow" width="6px" height="9px">
                                <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-right-6x9"></use>
                            </svg>
                        </a>
                        <div class="departments__submenu departments__submenu--type--megamenu departments__submenu--size--sm">
                            <!-- .megamenu -->
                            <div class="megamenu  megamenu--departments ">
                                <div class="megamenu__body" style="background-image: url(/images/femme.jpg); background-position: 68% 45%; background-size: 300px;">
                                    <div class="row">
                                        <div class="col-12">
                                            <ul class="megamenu__links megamenu__links--level--0 row" style="justify-content: space-between;">
                                                <li class=" megamenu__item  megamenu__item--with-submenu ">
                                                    <a href="/Sites-d-achats-recommandes/" target="blank_"><span>Mode et accessoires</span></a>
                                                    <ul class="megamenu__links megamenu__links--level--1">
                                                        <li class="megamenu__item"><a href="https://www.asos.com/fr/" target="blank_">Asos</a></li>
                                                        <li class="megamenu__item"><a href="https://galerieslafayette.com/" target="blank_">Galerieslafayette</a></li>
                                                        <li class="megamenu__item"><a href="https://www.prettylittlething.fr/" target="blank_">Prettylittlething</a></li>
                                                        <li class="megamenu__item"><a href="https://www2.hm.com/fr_be/femme.html" target="blank_">H&M</a></li>
                                                        <li class="megamenu__item"><a href="https://www.kiabi.com/" target="blank_">Kiabi</a></li>
                                                        <li class="megamenu__item"><a href="https://www.lahalle.com/" target="blank_">Lahalle</a></li>
                                                        <li class="megamenu__item"><a href="https://www.pimkie.fr/" target="blank_">Pimkie</a></li>
                                                        <li class="megamenu__item"><a href="https://www.promod.fr/fr-fr/" target="blank_">Promod</a></li>
                                                        <li class="megamenu__item"><a href="https://www.spartoo.com/" target="blank_">Spartoo</a></li>
                                                        <li class="megamenu__item"><a href="https://www.zalando.fr/" target="blank_">Zalando</a></li>
                                                        <li class="megamenu__item"><a href="https://www.zara.com/fr/" target="blank_">Zara</a></li>
                                                        <li class="megamenu__item"><a href="https://m.shein.com/fr/" target="blank_">Shein</a></li>
                                                        <li class="megamenu__item"><a href="https://www.brandalley.fr/" target="blank_">Brandalley</a></li>
                                                        <li class="megamenu__item"><a href="https://www.placedestendances.com/fr/fr" target="blank_">Place des tendances</a></li>
                                                        <li class="megamenu__item"><a href="https://www.newlook.com/fr/" target="blank_">New look</a></li>
                                                        <li class="megamenu__item"><a href="https://www.laboutiqueofficielle.com/" target="blank_">laboutiqueofficielle</a></li>
                                                        <li class="megamenu__item"><a href="https://www.laredoute.fr/" target="blank_">Laredoute</a></li>
                                                        <li class="megamenu__item"><a href="https://www.c-and-a.com/fr/fr/shop" target="blank_">C&A</a></li>
                                                        <li class="megamenu__item"><a href="https://fr.boohoo.com/" target="blank_">Boohoo</a></li>
                                                        <li class="megamenu__item"><a href="https://shop.mango.com/fr" target="blank_">Mango</a></li>
                                                    </ul>
                                                </li>
                                                <li class=" megamenu__item  megamenu__item--with-submenu ">
                                                    <a href="/Sites-d-achats-recommandes/" target="blank_"><span>Chaussures</span></a>
                                                    <ul class="megamenu__links megamenu__links--level--1">
                                                        <li class="megamenu__item"><a href="https://www.chaussea.com/fr/" target="blank_">Chaussea</a></li>
                                                        <li class="megamenu__item"><a href="https://www.justfab.fr/" target="blank_">Justfab</a></li>
                                                        <li class="megamenu__item"><a href="https://www.eram.fr/" target="blank_">Eram</a></li>
                                                        <li class="megamenu__item"><a href="https://www.andre.fr/" target="blank_">Andre</a></li>
                                                        <li class="megamenu__item"><a href="https://www.minelli.fr/" target="blank_">Minelli</a></li>
                                                        <li class="megamenu__item"><a href="https://www.bocage.fr/" target="blank_">Bocage</a></li>
                                                        <li class="megamenu__item"><a href="https://www.sarenza.com/" target="blank_">Sarenza</a></li>
                                                        <li class="megamenu__item"><a href="https://www.zalando.fr/" target="blank_">Zalando</a></li>
                                                    </ul>
                                                </li>
                                                <li class="megamenu__item  megamenu__item--with-submenu ">
                                                    <a href="/Sites-d-achats-recommandes/" target="blank_"><span>Montres et Bijoux</span></a>
                                                    <ul class="megamenu__links megamenu__links--level--1">
                                                        <li class="megamenu__item"><a href="https://www.bijourama.com/" target="blank_">Bijourama</a></li>
                                                        <li class="megamenu__item"><a href="https://www.histoiredor.com/fr_FR" target="blank_">Histoire d'Or</a></li>
                                                        <li class="megamenu__item"><a href="https://www.lemanegeabijoux.com/" target="blank_">Le manège à bijoux</a></li>
                                                        <li class="megamenu__item"><a href="https://www.maty.com/" target="blank_">Maty</a></li>
                                                        <li class="megamenu__item"><a href="https://fr.pandora.net/fr/" target="blank_">Pandora</a></li>
                                                        <li class="megamenu__item"><a href="https://www.agatha.fr/fr_FR" target="blank_">Agatha</a></li>
                                                        <li class="megamenu__item"><a href="https://www.swarovski.com/fr-FR/" target="blank_">Swarovski</a></li>
                                                        <li class="megamenu__item"><a href="https://www.cleor.com/" target="blank_">Cleor</a></li>
                                                        <li class="megamenu__item"><a href="https://www.juliendorcel.com/" target="blank_">Julien d'Orcel</a></li>
                                                        <li class="megamenu__item"><a href="https://www.marc-orian.com/fr_FR" target="blank_">Marc Orian</a></li>
                                                        <li class="megamenu__item"><a href="https://www.aparanjanparis.com/" target="blank_">Aparanjan Paris</a></li>
                                                    </ul>
                                                </li>
                                                <li class="megamenu__item  megamenu__item--with-submenu ">
                                                    <a href="/Sites-d-achats-recommandes/" target="blank_"><span>Hygiène, parfumerie et beauté</span></a>
                                                    <ul class="megamenu__links megamenu__links--level--1">
                                                        <li class="megamenu__item"><a href="https://www.marionnaud.fr/" target="blank_">Marionnaud</a></li>
                                                        <li class="megamenu__item"><a href="https://www.nocibe.fr/" target="blank_">Nocibé</a></li>
                                                        <li class="megamenu__item"><a href="https://www.sephora.fr/" target="blank_">Sephora</a></li>
                                                        <li class="megamenu__item"><a href="https://www.yves-rocher.fr/" target="blank_">Yves rocher</a></li>
                                                        <li class="megamenu__item"><a href="https://www.lookfantastic.fr/" target="blank_">Lookfantastic</a></li>
                                                        <li class="megamenu__item"><a href="https://www.beautybay.com/fr/" target="blank_">Beauty Bay</a></li>
                                                        <li class="megamenu__item"><a href="https://www.printemps.com/fr/fr" target="blank_">Printemps </a></li>
                                                        <li class="megamenu__item"><a href="https://www.parashop.com/" target="blank_">Parashop</a></li>
                                                        <li class="megamenu__item"><a href="https://www.activpharma.com/fr/" target="blank_">Actvipharma</a></li>

                                                    </ul>
                                                </li>
                                                <li class="megamenu__item  megamenu__item--with-submenu ">
                                                    <a href="/Sites-d-achats-recommandes/" target="blank_"><span>Luxe</span></a>
                                                    <ul class="megamenu__links megamenu__links--level--1">
                                                        <li class="megamenu__item"><a href="https://fr.burberry.com/" target="blank_">Burberry</a></li>
                                                        <li class="megamenu__item"><a href="https://www.dolcegabbana.com/fr/" target="blank_">Dolce Gabbana</a></li>
                                                        <li class="megamenu__item"><a href="https://www.galerieslafayette.com/" target="blank_">Galerieslafayette</a></li>
                                                        <li class="megamenu__item"><a href="https://www.printemps.com/fr/fr" target="blank_">Printemps</a></li>
                                                        <li class="megamenu__item"><a href="https://www.guess.eu/fr-fr/home" target="blank_">Guess</a></li>
                                                        <li class="megamenu__item"><a href="https://fr.louisvuitton.com/fra-fr/homepage" target="blank_">Louis Vuitton</a></li>
                                                        <li class="megamenu__item"><a href="https://www.ralphlauren.fr/" target="blank_">Ralph Lauren</a></li>
                                                        <li class="megamenu__item"><a href="https://www.dior.com/fr_fr" target="blank_">Dior</a></li>
                                                        <li class="megamenu__item"><a href="https://fr.tommy.com/" target="blank_">Tommy hilfiger</a></li>
                                                        <li class="megamenu__item"><a href="https://fr.claudiepierlot.com/" target="blank_">claudie pierlot</a></li>
                                                        <li class="megamenu__item"><a href="https://fr.maje.com/" target="blank_">Maje</a></li>
                                                        <li class="megamenu__item"><a href="https://www.balenciaga.com/fr-fr" target="blank_">Balanciaga</a></li>
                                                        <li class="megamenu__item"><a href="https://www.calvinklein.fr/" target="blank_">Calvin Klein</a></li>
                                                    </ul>
                                                </li>
                                                <li class="megamenu__item  megamenu__item--with-submenu ">
                                                    <a href="/Sites-d-achats-recommandes/" target="blank_"><span>Les ventes Privées</span></a>
                                                    <ul class="megamenu__links megamenu__links--level--1">
                                                        <li class="megamenu__item"><a href="https://www.veepee.fr/gr/home/default" target="blank_">Vente-privee</a></li>
                                                        <li class="megamenu__item"><a href="https://www.showroomprive.com/" target="blank_">Showroomprive</a></li>
                                                        <li class="megamenu__item"><a href="https://www.beauteprivee.fr/" target="blank_">Beauté privée</a></li>
                                                        <li class="megamenu__item"><a href="https://fr.bazarchic.com/" target="blank_">Bazarchic</a></li>
                                                        <li class="megamenu__item"><a href="https://www.zalando-prive.fr/ventes-privees/vetements-femme/#/" target="blank_">Zalando privé</a></li>
                                                    </ul>
                                                </li>
                                                <li class="megamenu__item  megamenu__item--with-submenu ">
                                                    <a href="/Sites-d-achats-recommandes/" target="blank_"><span>Mariage</span></a>
                                                    <ul class="megamenu__links megamenu__links--level--1">
                                                        <li class="megamenu__item"><a href="https://pronuptia.fr/" target="blank_">Pronuptia*</a></li>
                                                        <li class="megamenu__item"><a href="https://www.jjshouse.fr/" target="blank_">JJ's House</a></li>
                                                        <li class="megamenu__item"><a href="https://www.milanoo.com/fr/jian/Mariage" target="blank_">milanoo</a></li>
                                                        <li class="megamenu__item"><a href="https://www.lamodeuse.com/" target="blank_">lamodeuse</a></li>
                                                        <li class="megamenu__item"><a href="https://www.lesitedumariage.com/" target="blank_">lesitedumariage</a></li>
                                                        <li class="megamenu__item"><a href="https://www.marieeparisienne.com/" target="blank_">mariéeparisienne</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="departments__item">
                        <a class="departments__item-link" href="#">
                            Hommes
                            <svg class="departments__item-arrow" width="6px" height="9px">
                                <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-right-6x9"></use>
                            </svg>
                        </a>
                        <div class="departments__submenu departments__submenu--type--megamenu departments__submenu--size--sm">
                            <!-- .megamenu -->
                            <div class="megamenu  megamenu--departments ">
                                <div class="megamenu__body" style="background-image: url(/images/homme.jpg); background-position: 90% 32%; background-size: 200px;">
                                    <div class="row">
                                        <div class="col-12">
                                            <ul class="megamenu__links megamenu__links--level--0 row" style="justify-content: space-between;">
                                                <li class=" megamenu__item  megamenu__item--with-submenu ">
                                                    <a href="/Sites-d-achats-recommandes/" target="blank_"><span>Mode et accessoires</span></a>
                                                    <ul class="megamenu__links megamenu__links--level--1">
                                                        <li class="megamenu__item"><a href="https://www.asos.com/fr/" target="blank_">Asos</a></li>
                                                        <li class="megamenu__item"><a href="https://galerieslafayette.com/" target="blank_">Galerieslafayette</a></li>
                                                        <li class="megamenu__item"><a href="https://www.celio.com/fr-fr" target="blank_">Celio</a></li>
                                                        <li class="megamenu__item"><a href="https://www2.hm.com/fr_be/femme.html" target="blank_">H&M</a></li>
                                                        <li class="megamenu__item"><a href="https://www.jules.com/" target="blank_"></a>Jules</li>
                                                        <li class="megamenu__item"><a href="https://www.lahalle.com/" target="blank_">Lahalle</a></li>
                                                        <li class="megamenu__item"><a href="https://www.pimkie.fr/" target="blank_">Pimkie</a></li>
                                                        <li class="megamenu__item"><a href="https://www.promod.fr/fr-fr/" target="blank_">Promod</a></li>
                                                        <li class="megamenu__item"><a href="https://www.spartoo.com/" target="blank_">Spartoo</a></li>
                                                        <li class="megamenu__item"><a href="https://www.zalando.fr/" target="blank_">Zalando</a></li>
                                                        <li class="megamenu__item"><a href="https://www.zara.com/fr/" target="blank_">Zara</a></li>
                                                        <li class="megamenu__item"><a href="https://www.jules.com/fr-fr/l/jules-x-brice/" target="blank_">Brice By Jules</a></li>
                                                        <li class="megamenu__item"><a href="https://www.brandalley.fr/" target="blank_">Brandalley</a></li>
                                                        <li class="megamenu__item"><a href="https://www.placedestendances.com/fr/fr" target="blank_">Place des tendances</a></li>
                                                        <li class="megamenu__item"><a href="https://www.ruedeshommes.com/" target="blank_">Rue des hommes</a></li>
                                                        <li class="megamenu__item"><a href="https://www.laboutiqueofficielle.com/" target="blank_">laboutiqueofficielle</a></li>
                                                        <li class="megamenu__item"><a href="https://www.laredoute.fr/" target="blank_">Laredoute</a></li>
                                                        <li class="megamenu__item"><a href="https://izac.fr/" target="blank_">Izac</a></li>
                                                        <li class="megamenu__item"><a href="https://www.boohooman.com/fr/" target="blank_">BoohooMan</a></li>
                                                        <li class="megamenu__item"><a href="https://www.easylunettes.fr/" target="blank_">easy lunettes</a></li>
                                                        <li class="megamenu__item"><a href="https://www.mencorner.com/" target="blank_">Men corner</a></li>
                                                    </ul>
                                                </li>
                                                <li class=" megamenu__item  megamenu__item--with-submenu ">
                                                    <a href="/Sites-d-achats-recommandes/" target="blank_"><span>Chaussures</span></a>
                                                    <ul class="megamenu__links megamenu__links--level--1">
                                                        <li class="megamenu__item"><a href="https://www.chaussea.com/fr/" target="blank_">Chaussea</a></li>
                                                        <li class="megamenu__item"><a href="https://www.bexley.fr/" target="blank_">Bexley</a></li>
                                                        <li class="megamenu__item"><a href="https://www.eram.fr/" target="blank_">Eram</a></li>
                                                        <li class="megamenu__item"><a href="https://www.andre.fr/" target="blank_">Andre</a></li>
                                                        <li class="megamenu__item"><a href="https://www.kickz.com/fr" target="blank_">kickz</a></li>
                                                        <li class="megamenu__item"><a href="https://www.bocage.fr/" target="blank_">Bocage</a></li>
                                                        <li class="megamenu__item"><a href="https://www.sarenza.com/" target="blank_">Sarenza</a></li>
                                                        <li class="megamenu__item"><a href="https://eu.jmweston.com/" target="blank_">jmweston</a></li>
                                                        <li class="megamenu__item"><a href="https://www.finsbury-shoes.com/" target="blank_">Finsbury </a></li>
                                                        <li class="megamenu__item"><a href="https://www.zalando.fr/" target="blank_">Zalando</a></li>
                                                    </ul>
                                                </li>
                                                <li class="megamenu__item  megamenu__item--with-submenu ">
                                                    <a href="/Sites-d-achats-recommandes/" target="blank_"><span>Montres et Bijoux</span></a>
                                                    <ul class="megamenu__links megamenu__links--level--1">
                                                        <li class="megamenu__item"><a href="https://www.bijourama.com/" target="blank_">Bijourama</a></li>
                                                        <li class="megamenu__item"><a href="https://www.histoiredor.com/fr_FR" target="blank_">Histoire d'Or</a></li>
                                                        <li class="megamenu__item"><a href="https://www.lemanegeabijoux.com/" target="blank_">Le manège à bijoux</a></li>
                                                        <li class="megamenu__item"><a href="https://www.maty.com/" target="blank_">Maty</a></li>
                                                        <li class="megamenu__item"><a href="https://fr.pandora.net/fr/" target="blank_">Pandora</a></li>
                                                        <li class="megamenu__item"><a href="https://www.tissotwatches.com/fr-fr/" target="blank_">Tissot</a></li>
                                                    </ul>
                                                </li>
                                                <li class="megamenu__item  megamenu__item--with-submenu ">
                                                    <a href="/Sites-d-achats-recommandes/" target="blank_"><span>Hygiène, parfumerie et beauté</span></a>
                                                    <ul class="megamenu__links megamenu__links--level--1">
                                                        <li class="megamenu__item"><a href="https://www.marionnaud.fr/" target="blank_">Marionnaud</a></li>
                                                        <li class="megamenu__item"><a href="https://www.nocibe.fr/" target="blank_">Nocibé</a></li>
                                                        <li class="megamenu__item"><a href="https://www.sephora.fr/" target="blank_">Sephora</a></li>
                                                        <li class="megamenu__item"><a href="https://www.yves-rocher.fr/" target="blank_">Yves rocher</a></li>

                                                    </ul>
                                                </li>
                                                <li class="megamenu__item  megamenu__item--with-submenu ">
                                                    <a href="/Sites-d-achats-recommandes/" target="blank_"><span>Luxe</span></a>
                                                    <ul class="megamenu__links megamenu__links--level--1">
                                                        <li class="megamenu__item"><a href="https://fr.burberry.com/" target="blank_">Burberry</a></li>
                                                        <li class="megamenu__item"><a href="https://www.dolcegabbana.com/fr/" target="blank_">Dolce Gabbana</a></li>
                                                        <li class="megamenu__item"><a href="https://www.galerieslafayette.com/" target="blank_">Galerieslafayette</a></li>
                                                        <li class="megamenu__item"><a href="https://www.printemps.com/fr/fr" target="blank_">Printemps</a></li>
                                                        <li class="megamenu__item"><a href="https://www.guess.eu/fr-fr/home" target="blank_">Guess</a></li>
                                                        <li class="megamenu__item"><a href="https://fr.louisvuitton.com/fra-fr/homepage" target="blank_">Louis Vuitton</a></li>
                                                        <li class="megamenu__item"><a href="https://www.ralphlauren.fr/" target="blank_">Ralph Lauren</a></li>
                                                        <li class="megamenu__item"><a href="https://www.dior.com/fr_fr" target="blank_">Dior</a></li>
                                                        <li class="megamenu__item"><a href="https://fr.tommy.com/" target="blank_">Tommy hilfiger</a></li>
                                                        <li class="megamenu__item"><a href="https://www.balenciaga.com/fr-fr" target="blank_">Balanciaga</a></li>
                                                        <li class="megamenu__item"><a href="https://www.calvinklein.fr/" target="blank_">Calvin Klein</a></li>
                                                    </ul>
                                                </li>
                                                <li class="megamenu__item  megamenu__item--with-submenu ">
                                                    <a href="/Sites-d-achats-recommandes/" target="blank_"><span>Les ventes Privées</span></a>
                                                    <ul class="megamenu__links megamenu__links--level--1">
                                                        <li class="megamenu__item"><a href="https://www.veepee.fr/gr/home/default" target="blank_">Vente-privee</a></li>
                                                        <li class="megamenu__item"><a href="https://www.showroomprive.com/" target="blank_">Showroomprive</a></li>
                                                        <li class="megamenu__item"><a href="https://www.beauteprivee.fr/" target="blank_">Beauté privée</a></li>
                                                        <li class="megamenu__item"><a href="https://fr.bazarchic.com/" target="blank_">Bazarchic</a></li>
                                                        <li class="megamenu__item"><a href="https://www.zalando-prive.fr/ventes-privees/vetements-femme/#/" target="blank_">Zalando privé</a></li>
                                                    </ul>
                                                </li>
                                                <li class="megamenu__item  megamenu__item--with-submenu ">
                                                    <a href="/Sites-d-achats-recommandes/" target="blank_"><span>Mariage</span></a>
                                                    <ul class="megamenu__links megamenu__links--level--1">
                                                        <li class="megamenu__item"><a href="https://izac.fr/" target="blank_">Izac</a></li>
                                                        <li class="megamenu__item"><a href="https://www.johann.fr/" target="blank_">Johann</a></li>
                                                        <li class="megamenu__item"><a href="https://www.fatherandsons.fr/" target="blank_">fatherandsons</a></li>
                                                        <li class="megamenu__item"><a href="https://www.lesitedumariage.com/" target="blank_">lesitedumariage</a></li>
                                                        <li class="megamenu__item"><a href="https://www.hockerty.fr/fr/" target="blank_">Hockerty</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="departments__item">
                        <a class="departments__item-link" href="#">
                            Enfants
                            <svg class="departments__item-arrow" width="6px" height="9px">
                                <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-right-6x9"></use>
                            </svg>
                        </a>
                        <div class="departments__submenu departments__submenu--type--megamenu departments__submenu--size--sm">
                            <!-- .megamenu -->
                            <div class="megamenu  megamenu--departments ">
                                <div class="megamenu__body" style="background-image: url(/images/enfants.jpg); background-position: 100% 100%; background-size: 150px;">
                                    <div class="row">
                                        <div class="col-12">
                                            <ul class="megamenu__links megamenu__links--level--0 row" style="justify-content: space-between;">
                                                <li class=" megamenu__item  megamenu__item--with-submenu ">
                                                    <a href="/Sites-d-achats-recommandes/" target="blank_"><span>Vêtements et chaussures</span></a>
                                                    <ul class="megamenu__links megamenu__links--level--1">
                                                        <li class="megamenu__item"><a href="https://www.dpam.com/" target="blank_">du pareil au même</a></li>
                                                        <li class="megamenu__item"><a href="https://www.gemo.fr/" target="blank_">Gémo</a></li>
                                                        <li class="megamenu__item"><a href="https://www.kiabi.com/" target="blank_">Kiabi</a></li>
                                                        <li class="megamenu__item"><a href="https://www.lahalle.com/" target="blank_">Lahalle</a></li>
                                                        <li class="megamenu__item"><a href="https://www.promod.fr/fr-fr/" target="blank_">Okaidi</a></li>
                                                        <li class="megamenu__item"><a href="https://www.petit-bateau.fr/" target="blank_">Petit-bateau</a></li>
                                                        <li class="megamenu__item"><a href="https://www.sergent-major.com/" target="blank_">Sergent-major</a></li>
                                                        <li class="megamenu__item"><a href="https://www.zara.com/fr/fr/enfants-mkt1.html" target="blank_">Zara</a></li>
                                                        <li class="megamenu__item"><a href="https://shop.mango.com/fr/enfants" target="blank_">Mango</a></li>
                                                        <li class="megamenu__item"><a href="https://m.shein.com/fr/kids" target="blank_">Shein</a></li>
                                                        <li class="megamenu__item"><a href="https://www.t-a-o.com/" target="blank_">Tape à l'œil</a></li>
                                                        <li class="megamenu__item"><a href="https://www.vertbaudet.fr/" target="blank_">Verbaudet</a></li>
                                                    </ul>
                                                </li>
                                                <li class=" megamenu__item  megamenu__item--with-submenu ">
                                                    <a href="/Sites-d-achats-recommandes/" target="blank_"><span>Bébé</span></a>
                                                    <ul class="megamenu__links megamenu__links--level--1">
                                                        <li class="megamenu__item"><a href="https://www.allobebe.fr/" target="blank_">Allobebe</a></li>
                                                        <li class="megamenu__item"><a href="https://www.aubert.com/" target="blank_">Aubert</a></li>
                                                        <li class="megamenu__item"><a href="https://www.chicco.fr/" target="blank_">chicco</a></li>
                                                        <li class="megamenu__item"><a href="https://www.t-a-o.com/" target="blank_">Tape à l'œil</a></li>
                                                        <li class="megamenu__item"><a href="https://www.vertbaudet.fr/" target="blank_">vertbaudet</a></li>
                                                        <li class="megamenu__item"><a href="https://littlefrimousse.com/" target="blank_">petite-frimousse</a></li>
                                                        <li class="megamenu__item"><a href="https://www.berceaumagique.com/" target="blank_">berceau magique</a></li>
                                                        <li class="megamenu__item"><a href="https://www.madeinbebe.com/" target="blank_">made in bebe</a></li>
                                                        <li class="megamenu__item"><a href="https://www.bebe-au-naturel.com/" target="blank_">Bébé au naturel</a></li>
                                                    </ul>
                                                </li>
                                                <li class="megamenu__item  megamenu__item--with-submenu ">
                                                    <a href="/Sites-d-achats-recommandes/" target="blank_"><span>Jeux et Jouets</span></a>
                                                    <ul class="megamenu__links megamenu__links--level--1">
                                                        <li class="megamenu__item"><a href="https://www.avenuedesjeux.com/" target="blank_">Avenuedesjeux</a></li>
                                                        <li class="megamenu__item"><a href="https://www.joueclub.fr/" target="blank_">Joue Club</a></li>
                                                        <li class="megamenu__item"><a href="https://www.lagranderecre.fr/" target="blank_">La Grande Récré</a></li>
                                                        <li class="megamenu__item"><a href="https://www.maxitoys.fr/" target="blank_">Maxi Toys</a></li>
                                                        <li class="megamenu__item"><a href="https://www.cultura.com/univers-enfant/jeux-jouets.html" target="blank_">Cultura</a></li>
                                                        <li class="megamenu__item"><a href="https://www.idkids.fr/" target="blank_">IDKIDS</a></li>
                                                        <li class="megamenu__item"><a href="https://www.fnac.com/enfants.asp" target="blank_">Fnac</a></li>
                                                        <li class="megamenu__item"><a href="https://www.cdiscount.com/" target="blank_">Cdiscount</a></li>
                                                        <li class="megamenu__item"><a href="https://www.natureetdecouvertes.com/" target="blank_">Nature & découvertes</a></li>
                                                        <li class="megamenu__item"><a href="https://www.furet.com/" target="blank_">Furet du Nord</a></li>
                                                    </ul>
                                                </li>
                                                <li class="megamenu__item  megamenu__item--with-submenu ">
                                                    <a href="/Sites-d-achats-recommandes/" target="blank_"><span>Les ventes Privées</span></a>
                                                    <ul class="megamenu__links megamenu__links--level--1">
                                                        <li class="megamenu__item"><a href="https://www.veepee.fr/gr/home/default" target="blank_">Vente-privee</a></li>
                                                        <li class="megamenu__item"><a href="https://www.showroomprive.com/" target="blank_">Showroomprive</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="departments__item">
                        <a class="departments__item-link" href="/Sites-d-achats-recommandes/">
                            Sports et Loisirs
                            <svg class="departments__item-arrow" width="6px" height="9px">
                                <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-right-6x9"></use>
                            </svg>
                        </a>
                        <div class="departments__submenu departments__submenu--type--megamenu departments__submenu--size--sm">
                            <!-- .megamenu -->
                            <div class="megamenu  megamenu--departments ">
                                <div class="megamenu__body">
                                    <div class="row">
                                        <div class="col-12">
                                            <ul class="megamenu__links megamenu__links--level--0 row" style="justify-content: space-between;">
                                                <li class="megamenu__item  megamenu__item--with-submenu ">
                                                    <a href="/Sites-d-achats-recommandes/" target="blank_"><span>Tous</span></a>
                                                    <ul class="megamenu__links megamenu__links--level--1">
                                                        <li class="megamenu__item"><a href="https://www.decathlon.fr/" target="blank_">Décathlon</a></li>
                                                        <li class="megamenu__item"><a href="https://www.footlocker.fr/" target="blank_">Footlocker</a></li>
                                                        <li class="megamenu__item"><a href="https://www.go-sport.com/" target="blank_">Go Sport</a></li>
                                                        <li class="megamenu__item"><a href="https://www.intersport.fr/" target="blank_">Intersport</a></li>
                                                        <li class="megamenu__item"><a href="https://www.jdsports.fr/" target="blank_">Jdsports</a></li>
                                                        <li class="megamenu__item"><a href="https://www.kickz.com/fr" target="blank_">Kickz</a></li>
                                                    </ul>
                                                </li>
                                                <li><img src="/images/sports-loisirs.jpeg" alt="sport" style="max-width: 300px"></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="departments__item">
                        <a class="departments__item-link" href="/Sites-d-achats-recommandes/">
                            Maison
                            <svg class="departments__item-arrow" width="6px" height="9px">
                                <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-right-6x9"></use>
                            </svg>
                        </a>
                        <div class="departments__submenu departments__submenu--type--megamenu departments__submenu--size--sm">
                            <!-- .megamenu -->
                            <div class="megamenu  megamenu--departments ">
                                <div class="megamenu__body" style="background-image: url(/images/maison.jpeg); background-position: 100% 100%; background-size: 300px;">
                                    <div class="row">
                                        <div class="col-12">
                                            <ul class="megamenu__links megamenu__links--level--0 row" style="justify-content: space-between;">
                                                <li class="megamenu__item  megamenu__item--with-submenu ">
                                                    <a href="/Sites-d-achats-recommandes/" target="blank_"><span>Electroménager</span></a>
                                                    <ul class="megamenu__links megamenu__links--level--1">
                                                        <li class="megamenu__item"><a href="https://www.amazon.fr/" target="blank_">Amazon</a></li>
                                                        <li class="megamenu__item"><a href="https://www.cdiscount.com/" target="blank_"> Cdiscount</a></li>
                                                        <li class="megamenu__item"><a href="https://fr.shopping.rakuten.com/" target="blank_">Rakuten</a></li>
                                                        <li class="megamenu__item"><a href="https://www.rueducommerce.fr/" target="blank_">Rueducommerce</a></li>
                                                        <li class="megamenu__item"><a href="https://www.asdiscount.com/" target="blank_">asdiscount</a></li>
                                                        <li class="megamenu__item"><a href="https://www.darty.com/" target="blank_">Darty</a></li>
                                                        <li class="megamenu__item"><a href="https://www.pixmania.com/fr/fr/" target="blank_">Pixmania</a></li>
                                                        <li class="megamenu__item"><a href="https://www.mistergooddeal.com/" target="blank_">Mister good deal</a></li>
                                                        <li class="megamenu__item"><a href="https://www.conforama.fr/" target="blank_">Conforama</a></li>
                                                        <li class="megamenu__item"><a href="https://www.boulanger.com/" target="blank_">Boulanger</a></li>
                                                    </ul>
                                                </li>
                                                <li class="megamenu__item  megamenu__item--with-submenu ">
                                                    <a href="/Sites-d-achats-recommandes/" target="blank_"><span>Meuble, décoration et équipement</span></a>
                                                    <ul class="megamenu__links megamenu__links--level--1">
                                                        <li class="megamenu__item"><a href="https://www.bricodepot.fr/" target="blank_">Brico dépôt</a></li>
                                                        <li class="megamenu__item"><a href="https://www.leroymerlin.fr/" target="blank_">Leroy Merlin</a></li>
                                                        <li class="megamenu__item"><a href="https://www.castorama.fr/" target="blank_">Castorama</a></li>
                                                        <li class="megamenu__item"><a href="https://www.ikea.com/fr/fr/" target="blank_">Ikea</a></li>
                                                        <li class="megamenu__item"><a href="https://www.but.fr/" target="blank_">But</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="departments__item">
                        <a class="departments__item-link" href="/Sites-d-achats-recommandes/">
                            High-tech et informatique
                            <svg class="departments__item-arrow" width="6px" height="9px">
                                <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-right-6x9"></use>
                            </svg>
                        </a>
                        <div class="departments__submenu departments__submenu--type--megamenu departments__submenu--size--sm">
                            <!-- .megamenu -->
                            <div class="megamenu  megamenu--departments ">
                                <div class="megamenu__body" style="background-image: url(/images/high-tech.jpg); background-position: 100% 100%; background-size: 300px;">
                                    <div class="row">
                                        <div class="col-12">
                                            <ul class="megamenu__links megamenu__links--level--0 row" style="justify-content: space-between;">
                                                <li class="megamenu__item  megamenu__item--with-submenu ">
                                                    <a href="/Sites-d-achats-recommandes/" target="blank_"><span>Tous</span></a>
                                                    <ul class="megamenu__links megamenu__links--level--1">
                                                        <li class="megamenu__item"><a href="https://www.amazon.fr/" target="blank_">Amazon</a></li>
                                                        <li class="megamenu__item"><a href="https://www.cdiscount.com/" target="blank_"> Cdiscount</a></li>
                                                        <li class="megamenu__item"><a href="https://fr.shopping.rakuten.com/" target="blank_">Rakuten</a></li>
                                                        <li class="megamenu__item"><a href="https://www.rueducommerce.fr/" target="blank_">Rueducommerce</a></li>
                                                        <li class="megamenu__item"><a href="https://www.asdiscount.com/" target="blank_">asdiscount</a></li>
                                                        <li class="megamenu__item"><a href="https://www.darty.com/" target="blank_">Darty</a></li>
                                                        <li class="megamenu__item"><a href="https://www.laredoute.fr/" target="blank_">Laredoute</a></li>
                                                        <li class="megamenu__item"><a href="https://www.pixmania.com/fr/fr/" target="blank_">Pixmania</a></li>
                                                        <li class="megamenu__item"><a href="https://www.mistergooddeal.com/" target="blank_">Mister good deal</a></li>
                                                        <li class="megamenu__item"><a href="https://www.fnac.com/" target="blank_">Fnac</a></li>
                                                        <li class="megamenu__item"><a href="https://www.boulanger.com/" target="blank_">Boulanger</a></li>
                                                        <li class="megamenu__item"><a href="https://www.grosbill.com/" target="blank_">Grosbill</a></li>
                                                        <li class="megamenu__item"><a href="https://www.ldlc.com/" target="blank_">LDLC</a></li>
                                                        <li class="megamenu__item"><a href="https://www.materiel.net/" target="blank_">Materiel.net</a></li>
                                                        <li class="megamenu__item"><a href="https://www.3suisses.fr/" target="blank_">3 Suisses</a></li>
                                                    </ul>
                                                </li>
                                                <li class="megamenu__item  megamenu__item--with-submenu ">
                                                    <a href="/Sites-d-achats-recommandes/" target="blank_"><span>Instruments de musique et sono</span></a>
                                                    <ul class="megamenu__links megamenu__links--level--1">
                                                        <li class="megamenu__item"><a href="https://www.projethomestudio.fr/" target="blank_">homestudio</a></li>
                                                        <li class="megamenu__item"><a href="https://www.sonovente.com/" target="blank_">sonovente</a></li>
                                                        <li class="megamenu__item"><a href="https://www.cultura.com/" target="blank_">Cultura</a></li>
                                                        <li class="megamenu__item"><a href="https://www.stars-music.fr/" target="blank_">star's music</a></li>
                                                        <li class="megamenu__item"><a href="https://www.thomann.de/fr/index.html" target="blank_">thomann</a></li>
                                                        <li class="megamenu__item"><a href="https://www.woodbrass.com/" target="blank_">Woodbrass</a></li>
                                                        <li class="megamenu__item"><a href="https://www.projethomestudio.fr/" target="blank_">projet home studio</a></li>
                                                        <li class="megamenu__item"><a href="https://www.terredeson.com/" target="blank_">terre de son</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="departments__item">
                        <a class="departments__item-link" href="/Sites-d-achats-recommandes/">
                            Automobile et Moto
                            <svg class="departments__item-arrow" width="6px" height="9px">
                                <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-right-6x9"></use>
                            </svg>
                        </a>
                        <div class="departments__submenu departments__submenu--type--megamenu departments__submenu--size--sm">
                            <!-- .megamenu -->
                            <div class="megamenu  megamenu--departments ">
                                <div class="megamenu__body">
                                    <div class="row">
                                        <div class="col-12">
                                            <ul class="megamenu__links megamenu__links--level--0 row" style="justify-content: space-between;">
                                                <li class="megamenu__item  megamenu__item--with-submenu ">
                                                    <a href="/Sites-d-achats-recommandes/" target="blank_"><span>Tous</span></a>
                                                    <ul class="megamenu__links megamenu__links--level--1">
                                                        <li class="megamenu__item"><a href="https://www.mister-auto.com/" target="blank_">Mister-auto</a></li>
                                                        <li class="megamenu__item"><a href="https://www.norauto.fr/" target="blank_">norauto</a></li>
                                                        <li class="megamenu__item"><a href="https://www.oscaro.com/" target="blank_">oscaro</a></li>
                                                        <li class="megamenu__item"><a href="https://www.piecesauto.com/" target="blank_">piecesauto</a></li>
                                                        <li class="megamenu__item"><a href="https://www.carter-cash.com/" target="blank_">Carter Cash</a></li>
                                                    </ul>
                                                </li>
                                                <li><img src="/images/auto-moto.jpg" alt="pieces détachées" style="max-width: 300px"></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="departments__item">
                        <a class="departments__item-link" href="/Sites-d-achats-recommandes/">
                            Jeux vidéo et consoles
                            <svg class="departments__item-arrow" width="6px" height="9px">
                                <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-right-6x9"></use>
                            </svg>
                        </a>
                        <div class="departments__submenu departments__submenu--type--megamenu departments__submenu--size--sm">
                            <!-- .megamenu -->
                            <div class="megamenu  megamenu--departments ">
                                <div class="megamenu__body">
                                    <div class="row">
                                        <div class="col-12">
                                            <ul class="megamenu__links megamenu__links--level--0 row" style="justify-content: space-between;">
                                                <li class="megamenu__item  megamenu__item--with-submenu ">
                                                    <a href="/Sites-d-achats-recommandes/" target="blank_"><span>Tous</span></a>
                                                    <ul class="megamenu__links megamenu__links--level--1">
                                                        <li class="megamenu__item"><a href="https://www.fnac.com/enfants.asp" target="blank_">Fnac</a></li>
                                                        <li class="megamenu__item"><a href="https://www.cultura.com/" target="blank_">Cultura</a></li>
                                                        <li class="megamenu__item"><a href="https://www.micromania.fr/" target="blank_">Micromania</a></li>
                                                    </ul>
                                                </li>
                                                <li><img src="/images/jeux-video-consoles.jpeg" alt="pieces détachées" style="max-width: 300px"></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                </ul>
            </div>
        </div>
        <button class="departments__button text-uppercase">
            <svg class="departments__button-icon" width="18px" height="14px">
                <use xlink:href="/template2/black/images/sprite.svg#menu-18x14"></use>
            </svg>
            Sites recommandés
            <svg class="departments__button-arrow" width="9px" height="6px">
                <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-down-9x6"></use>
            </svg>
        </button>
    </div>
    <!-- .departments / end -->
</div>

<!-- .nav-links -->
<div class="nav-panel__nav-links nav-links">
    <ul class="nav-links__list">

        <li class="nav-links__item  nav-links__item--has-submenu ">
            <a class="nav-links__item-link">
                <div class="nav-links__item-body text-uppercase">
                    Services & tarifs
                    <svg class="nav-links__item-arrow" width="9px" height="6px">
                        <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-down-9x6"></use>
                    </svg>
                </div>
            </a>
            <div class="nav-links__submenu nav-links__submenu--type--menu">
                <!-- .menu -->
                <div class="menu menu--layout--classic ">
                    <div class="menu__submenus-container"></div>
                    <ul class="menu__list">
                        <li class="menu__item">
                            <!-- This is a synthetic element that allows to adjust the vertical offset of the submenu using CSS. -->
                            <div class="menu__item-submenu-offset"></div>
                            <a class="menu__item-link" href="/Liste-de-souhaits">
                                Liste de souhaits
                            </a>
                        </li>
                        <li class="menu__item">
                            <!-- This is a synthetic element that allows to adjust the vertical offset of the submenu using CSS. -->
                            <div class="menu__item-submenu-offset"></div>
                            <a class="menu__item-link" href="/Envoyer-un-colis">
                                Envoyer un colis
                            </a>
                        </li>
                        <li class="menu__item">
                            <!-- This is a synthetic element that allows to adjust the vertical offset of the submenu using CSS. -->
                            <div class="menu__item-submenu-offset"></div>
                            <a class="menu__item-link" href="/Suivi-personnalise">
                                Suivi personnalisé
                            </a>
                        </li>

                        <li class="menu__item">
                            <!-- This is a synthetic element that allows to adjust the vertical offset of the submenu using CSS. -->
                            <div class="menu__item-submenu-offset"></div>
                            <a class="menu__item-link" href="/Abonnements">
                                Abonnements
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- .menu / end -->
            </div>
        </li>

        <li class="nav-links__item  nav-links__item--has-submenu ">
            <a class="nav-links__item-link">
                <div class="nav-links__item-body text-uppercase">
                    Assistance
                    <svg class="nav-links__item-arrow" width="9px" height="6px">
                        <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-down-9x6"></use>
                    </svg>
                </div>
            </a>
            <div class="nav-links__submenu nav-links__submenu--type--menu">
                <!-- .menu -->
                <div class="menu menu--layout--classic ">
                    <div class="menu__submenus-container"></div>
                    <ul class="menu__list">
                        <li class="menu__item">
                            <!-- This is a synthetic element that allows to adjust the vertical offset of the submenu using CSS. -->
                            <div class="menu__item-submenu-offset"></div>
                            <a class="menu__item-link" href="/Comment-ca-marche">
                                Comment ça marche
                            </a>
                        </li>
                        <li class="menu__item">
                            <!-- This is a synthetic element that allows to adjust the vertical offset of the submenu using CSS. -->
                            <div class="menu__item-submenu-offset"></div>
                            <a class="menu__item-link" href="/Assistances-France">
                                Assistances France
                            </a>
                        </li>
                        <li class="menu__item">
                            <!-- This is a synthetic element that allows to adjust the vertical offset of the submenu using CSS. -->
                            <div class="menu__item-submenu-offset"></div>
                            <a class="menu__item-link" href="/Assistances-Gabon">
                                Assistances Gabon
                            </a>
                        </li>
                        <li class="menu__item">
                            <!-- This is a synthetic element that allows to adjust the vertical offset of the submenu using CSS. -->
                            <div class="menu__item-submenu-offset"></div>
                            <a class="menu__item-link" href="/Notre-entreprise">
                                L'entreprise
                            </a>
                        </li>
                        <!-- <li class="menu__item">
                            <div class="menu__item-submenu-offset"></div>
                            <a class="menu__item-link" href="/Contact">
                                Contact
                            </a>
                        </li> -->
                    </ul>
                </div>
                <!-- .menu / end -->
            </div>
        </li>

        <li class="nav-links__item  nav-links__item--has-submenu ">

            <div class="nav-links__submenu nav-links__submenu--type--menu">
                <!-- .menu -->
                <div class="menu menu--layout--classic ">
                    <div class="menu__submenus-container"></div>
                    <ul class="menu__list">

                        <?php
                        ///////////////////////////////SELECT BOUCLE
                        $req_boucle = $bdd->prepare("SELECT * FROM codi_one_blog_categories WHERE activer=? ORDER by Position_categorie ASC");
                        $req_boucle->execute(array("oui"));
                        while ($ligne_boucle = $req_boucle->fetch()) {
                            $idoneinfos = $ligne_boucle['id'];
                            $nom_categorie = $ligne_boucle['nom_categorie'];
                            $nom_url_categorie = $ligne_boucle['nom_url_categorie'];
                            $nbr_consultation_blog = $ligne_boucle['nbr_consultation_blog'];
                            $Title = $ligne_boucle['Title'];
                            $Metas_description = $ligne_boucle['Metas_description'];
                            $Metas_mots_cles = $ligne_boucle['Metas_mots_cles'];
                            $activer_categorie_blog = $ligne_boucle['activer'];
                            $date_categorie_blog = $ligne_boucle['date'];
                            $Position_categorie = $ligne_boucle['Position_categorie'];
                            $Ancre_menu = $ligne_boucle['Ancre_menu'];
                        ?>

                            <li class="menu__item">
                                <!-- This is a synthetic element that allows to adjust the vertical offset of the submenu using CSS. -->
                                <div class="menu__item-submenu-offset"></div>
                                <a class="menu__item-link" href="/<?php echo "$nom_url_categorie"; ?>">
                                    <?php echo "$Ancre_menu"; ?>
                                </a>
                            </li>

                        <?php
                        }
                        $req_boucle->closeCursor();
                        ?>

                    </ul>
                </div>
                <!-- .menu / end -->
            </div>
        </li>

        <li class="nav-links__item ">
            <a class="nav-links__item-link" href="/Boutique">
                <div class="nav-links__item-body text-uppercase">
                    Bon Plan
                </div>
            </a>
        </li>

        <li class="nav-links__item  nav-links__item--has-submenu ">
            <a class="nav-links__item-link">
                <div class="nav-links__item-body text-uppercase">
                    Hyro premium
                    <svg class="nav-links__item-arrow" width="9px" height="6px">
                        <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-down-9x6"></use>
                    </svg>
                </div>
            </a>
            <div class="nav-links__submenu nav-links__submenu--type--menu">
                <div class="menu menu--layout--classic " style="width: 250px">
                    <div class="menu__submenus-container"></div>

                    <div style="text-align: left; padding: 12px;">
                        <p style="font-size: 17px;">Avantages Membre Premium </p>
                        <div class="menu-premium mt-3 color-orange">Livraison à domicile gratuit</div>
                        <div class="menu-premium my-2 color-orange">Faciliter le paiement</div>
                        <span>Paiement en 2 ou 3 fois ou avancer 60%</span>
                        <div class="menu-premium mt-2 color-orange">-50% sur les frais de gestions</div>

                        <a href="/Hyro-premium"><img src="/images/premium-menu.png" alt="Premium best choice" style="width: 100%"></a>
                    </div>

                </div>
                <!-- .menu / end -->
            </div>
        </li>

    </ul>
</div>
<!-- .nav-links / end -->

<div class="nav-panel__indicators" style="align-items: center;">
<a href="#" style="font-size: 12px; height: 28px; background-color: #FFC107; color: #1C2833; padding: 5px 10px; font-weight: bold; display: inline-block; text-decoration: none; border-radius: 5px">
            <span style="margin-right: 5px;"></span> <strong style="color: white;">Livraison gratuite</strong> Hyro premium <strong style="color: white;">!</strong>
        </a>

    

    <?php
    /*if (empty($user)) {
    ?>

        <div class="indicator">
            <a href="<?php if (!empty($user)) {
                            echo "/Gestion-de-votre-compte.html";
                        } else {
                            echo "#";
                        } ?>" class="indicator__button <?php if (empty($user)) {
                                                                                                                                        echo "pxp-header-user";
                                                                                                                                    } ?>" <?php if (empty($user)) {
                                                                                                                                                                                                echo "onclick='return false;'";
                                                                                                                                                                                            } ?>>
                <span class="indicator__area">
                    <svg width="20px" height="20px">
                        <use xlink:href="/template2/black/images/sprite.svg#person-20"></use>
                    </svg>
                </span>
            </a>
        </div>
    <?php
    }*/
    ?>

    <?php
    if (true) {
    ?>

        

        <div id="profilButtonNav" class="indicator">
            <a id="<?php if (!empty($user)) {
                        echo "profilButton";
                    } ?>" class="indicator__button <?php if (empty($user)) {
                                                        echo "pxp-header-user";
                                                    } ?>" <?php if (empty($user)) {
                                                                echo "onclick='return false;'";
                                                            } ?>>
                <span class="indicator__area">
                    <svg width="20px" height="20px">
                        <use xlink:href="/template2/black/images/sprite.svg#person-20"></use>
                    </svg>
                </span>
            </a>
            <div class="indicator__dropdown" style="max-height: 538px;">
                <div class="account-menu">
                    <div class="account-menu__divider"></div>

                    <?php if (!empty($user)) { ?>
                        <a href="/Gestion-de-votre-compte.html" class="account-menu__user">
                            <!-- <div class="account-menu__user-avatar">
                                                        <img src="/images/membres/<?php echo "$user"; ?>/<?php echo "$image_oo"; ?>" alt="<?php echo "$nom_oo $prenom_oo"; ?>">
                                                    </div> -->
                            <div class="account-menu__user-info">
                                <div class="account-menu__user-name"><?php echo "$nom_oo $prenom_oo"; ?></div>
                                <div class="account-menu__user-email"><?php echo "$mail_oo"; ?></div>
                            </div>
                        </a>
                    <?php } ?>
                    <div class="account-menu__divider"></div>
                    <ul class="account-menu__links">
                        <?php if (!empty($user)) { ?>
                            <?php
                            //////////////////////////////////SI ADMIN
                            if ($admin_oo > 0) {
                            ?>
                                <li><a href="/administration/index-admin.php">Administration</a></li>
                            <?php
                            }
                            ?>

                            <li><a href="/Gestion-de-votre-compte.html">Mes informations</a></li>
                            <li><a href="/Mon-abonnement">Mon abonnement</a></li>
                            <li><a href="/Mes-commandes">Mes commandes</a></li>
                        <?php } ?>
                        <li><a style="margin-left:1rem" href="/Passage-de-commande">Nouvelle commande</a></li>
                        <?php if (!empty($user)) { ?>
                            <li><a href="/Mes-listes-de-souhaits">Mes listes de souhaits</a></li>
                            <li><a style="margin-left:1rem" href="/Mes-listes-de-souhaits">Mes souhaits en cours</a></li>
                         <!--    <li><a style="margin-left:1rem" href="/Mes-produits">Mes produits retrouvés</a></li> -->
                        <?php } ?>
                        <li><a style="margin-left:1rem" href="#" id="addList">Créer une liste de souhaits</a></li>
                        <?php if (!empty($user)) { ?>
                            <li><a href="/Mes-colis">Mes colis</a></li>
                        <?php } ?>
                        <li><a style="margin-left:1rem" href="/Passage-de-colis">Nouveau colis</a></li>
                        <?php if (!empty($user)) { ?>
                            <li><a href="/Notifications">Notifications</a></li>
                            <li><a href="/Factures">Factures</a></li>
                        <?php } ?>
                    </ul>
                    <?php if (!empty($user)) { ?>
                        <div class="account-menu__divider"></div>
                        <ul class="account-menu__links">
                            <li><a id="Deconnexion" href="#" onclick="return false;">Déconnexion</a></li>
                        </ul>
                    <?php } ?>
                </div>
            </div>
        </div>


</div>

<?php
    }
?>
<div id="cardNav" class="indicator"></div>