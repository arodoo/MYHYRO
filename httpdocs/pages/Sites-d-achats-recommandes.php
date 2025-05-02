
    <?php
    ///////////////////////////////SELECT BOUCLE
    if (!empty($_GET['idaction'])) {
        $req_boucle = $bdd->prepare("SELECT * FROM categories WHERE id=? ORDER BY nom_categorie ASC");
        $req_boucle->execute(array($_GET['idaction']));
    } else {
        $req_boucle = $bdd->prepare("SELECT * FROM categories ORDER BY nom_categorie ASC");
        $req_boucle->execute();
    }

    ?>
<div class="row">
    <div class="col-lg-4">
        <div><h4>Sites généralistes</h4></div>
        <ul class="megamenu__links megamenu__links--level--1">
            <li class="megamenu__item"><a href="https://www.amazon.fr/" target="blank_">Amazon</a></li>
            <li class="megamenu__item"><a href="https://www.cdiscount.com/" target="blank_">Cdiscount</a></li>
            <li class="megamenu__item"><a href="https://fr.shopping.rakuten.com/" target="blank_">Priceminister</a></li>
            <li class="megamenu__item"><a href="https://www.rueducommerce.fr/" target="blank_">Rueducommerce</a></li>
            <li class="megamenu__item"><a href="https://www.asdiscount.com/" target="blank_">Asdiscount</a></li>
            <li class="megamenu__item"><a href="https://www.pixmania.com/fr/fr/" target="blank_">Pixmania</a></li>
            <li class="megamenu__item"><a href="https://www.mistergooddeal.com/" target="blank_">Mister good deal</a></li>
        </ul>
        <div class="mt-3"><h4>Maison</h4></div>
        <ul class="megamenu__links megamenu__links--level--1 row" style="justify-content: space-between;">
            <li class="megamenu__item  megamenu__item--with-submenu ">
                <span class="title-borderb">Electroménager</span>
                <ul class="megamenu__links megamenu__links--level--1 my-2">
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
                <span class="title-borderb">Meuble, décoration et équipement</span>
                <ul class="megamenu__links megamenu__links--level--1 my-2">
                    <li class="megamenu__item"><a href="https://www.bricodepot.fr/" target="blank_">Brico dépôt</a></li>
                    <li class="megamenu__item"><a href="https://www.leroymerlin.fr/" target="blank_">Leroy Merlin</a></li>
                    <li class="megamenu__item"><a href="https://www.castorama.fr/" target="blank_">Castorama</a></li>
                    <li class="megamenu__item"><a href="https://www.ikea.com/fr/fr/" target="blank_">Ikea</a></li>
                    <li class="megamenu__item"><a href="https://www.but.fr/" target="blank_">But</a></li>
                </ul>
            </li>
        </ul>

    </div>
    <div class="col-lg-6">
        <div><h4>Femmes</h4></div>
        <ul class="row" style="justify-content: space-between; padding-left: 19px;">
            <li>
                <span class="title-borderb">Mode et accessoires</span>
                <ul class="megamenu__links megamenu__links--level--1 my-2">
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

                    <span class="title-borderb mt-2" style="display: inline-block;">Hygiène, parfumerie et beauté</span>
                    <ul class="megamenu__links megamenu__links--level--1 my-2">
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
                </ul>
            </li>
            <li class=" megamenu__item  megamenu__item--with-submenu ">
                <span class="title-borderb ">Chaussures</span>
                <ul class="megamenu__links megamenu__links--level--1 mt-2 mb-5">
                    <li class="megamenu__item"><a href="https://www.chaussea.com/fr/" target="blank_">Chaussea</a></li>
                    <li class="megamenu__item"><a href="https://www.justfab.fr/" target="blank_">Justfab</a></li>
                    <li class="megamenu__item"><a href="https://www.eram.fr/" target="blank_">Eram</a></li>
                    <li class="megamenu__item"><a href="https://www.andre.fr/" target="blank_">Andre</a></li>
                    <li class="megamenu__item"><a href="https://www.minelli.fr/" target="blank_">Minelli</a></li>
                    <li class="megamenu__item"><a href="https://www.bocage.fr/" target="blank_">Bocage</a></li>
                    <li class="megamenu__item"><a href="https://www.sarenza.com/" target="blank_">Sarenza</a></li>
                    <li class="megamenu__item"><a href="https://www.zalando.fr/" target="blank_">Zalando</a></li>
                </ul>
                <span class="title-borderb mt-5" style="display: inline-block;">Les ventes Privées</span>
                <ul class="megamenu__links megamenu__links--level--1 my-2">
                    <li class="megamenu__item"><a href="https://www.veepee.fr/gr/home/default" target="blank_">Vente-privee</a></li>
                    <li class="megamenu__item"><a href="https://www.showroomprive.com/" target="blank_">Showroomprive</a></li>
                    <li class="megamenu__item"><a href="https://www.beauteprivee.fr/" target="blank_">Beauté privée</a></li>
                    <li class="megamenu__item"><a href="https://fr.bazarchic.com/" target="blank_">Bazarchic</a></li>
                    <li class="megamenu__item"><a href="https://www.zalando-prive.fr/ventes-privees/vetements-femme/#/" target="blank_">Zalando privé</a></li>
                </ul>
            </li>
            <li class="megamenu__item  megamenu__item--with-submenu ">
                <span class="title-borderb ">Montres et Bijoux</span>
                <ul class="megamenu__links megamenu__links--level--1 my-2">
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
                <span class="title-borderb mt-3" style="display: inline-block;">Mariage</span>
                <ul class="megamenu__links megamenu__links--level--1 my-2">
                    <li class="megamenu__item"><a href="https://pronuptia.fr/" target="blank_">Pronuptia*</a></li>
                    <li class="megamenu__item"><a href="https://www.jjshouse.fr/" target="blank_">JJ's House</a></li>
                    <li class="megamenu__item"><a href="https://www.milanoo.com/fr/jian/Mariage" target="blank_">milanoo</a></li>
                    <li class="megamenu__item"><a href="https://www.lamodeuse.com/" target="blank_">lamodeuse</a></li>
                    <li class="megamenu__item"><a href="https://www.lesitedumariage.com/" target="blank_">lesitedumariage</a></li>
                    <li class="megamenu__item"><a href="https://www.marieeparisienne.com/" target="blank_">mariéeparisienne</a></li>
                </ul>
                <span class="title-borderb mt-3" style="display: inline-block;">Luxe</span>
                <ul class="megamenu__links megamenu__links--level--1 my-2">
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
        </ul>
    </div>
    <div class="col-lg-6">
        <div><h4>Hommes</h4></div>
        <ul class="megamenu__links megamenu__links--level--0 row" style="justify-content: space-between;">
            <li class=" megamenu__item  megamenu__item--with-submenu ">
                <span class="title-borderb">Mode et accessoires</span>
                <ul class="megamenu__links megamenu__links--level--1 my-2">
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
                <span class="title-borderb mt-2" style="display: inline-block;">Hygiène, parfumerie et beauté</span>
                <ul class="megamenu__links megamenu__links--level--1 my-2">
                    <li class="megamenu__item"><a href="https://www.marionnaud.fr/" target="blank_">Marionnaud</a></li>
                    <li class="megamenu__item"><a href="https://www.nocibe.fr/" target="blank_">Nocibé</a></li>
                    <li class="megamenu__item"><a href="https://www.sephora.fr/" target="blank_">Sephora</a></li>
                    <li class="megamenu__item"><a href="https://www.yves-rocher.fr/" target="blank_">Yves rocher</a></li>
                </ul>
            </li>
            <li class=" megamenu__item  megamenu__item--with-submenu ">
                <span class="title-borderb">Chaussures</span>
                <ul class="megamenu__links megamenu__links--level--1 my-2">
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
                <span class="title-borderb mt-2" style="display: inline-block;">Les ventes Privées</span>
                <ul class="megamenu__links megamenu__links--level--1 my-2">
                    <li class="megamenu__item"><a href="https://www.veepee.fr/gr/home/default" target="blank_">Vente-privee</a></li>
                    <li class="megamenu__item"><a href="https://www.showroomprive.com/" target="blank_">Showroomprive</a></li>
                    <li class="megamenu__item"><a href="https://www.beauteprivee.fr/" target="blank_">Beauté privée</a></li>
                    <li class="megamenu__item"><a href="https://fr.bazarchic.com/" target="blank_">Bazarchic</a></li>
                    <li class="megamenu__item"><a href="https://www.zalando-prive.fr/ventes-privees/vetements-femme/#/" target="blank_">Zalando privé</a></li>
                </ul>
                
            </li>
            <li class="megamenu__item  megamenu__item--with-submenu ">
                <span class="title-borderb">Montres et Bijoux</span>
                <ul class="megamenu__links megamenu__links--level--1 my-2">
                    <li class="megamenu__item"><a href="https://www.bijourama.com/" target="blank_">Bijourama</a></li>
                    <li class="megamenu__item"><a href="https://www.histoiredor.com/fr_FR" target="blank_">Histoire d'Or</a></li>
                    <li class="megamenu__item"><a href="https://www.lemanegeabijoux.com/" target="blank_">Le manège à bijoux</a></li>
                    <li class="megamenu__item"><a href="https://www.maty.com/" target="blank_">Maty</a></li>
                    <li class="megamenu__item"><a href="https://fr.pandora.net/fr/" target="blank_">Pandora</a></li>
                    <li class="megamenu__item"><a href="https://www.tissotwatches.com/fr-fr/" target="blank_">Tissot</a></li>
                </ul>
                <span class="title-borderb mt-2" style="display: inline-block;">Luxe</span>
                <ul class="megamenu__links megamenu__links--level--1 my-2">
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
                <span class="title-borderb mt-2">Mariage</span>
                <ul class="megamenu__links megamenu__links--level--1 my-2">
                    <li class="megamenu__item"><a href="https://izac.fr/" target="blank_">Izac</a></li>
                    <li class="megamenu__item"><a href="https://www.johann.fr/" target="blank_">Johann</a></li>
                    <li class="megamenu__item"><a href="https://www.fatherandsons.fr/" target="blank_">fatherandsons</a></li>
                    <li class="megamenu__item"><a href="https://www.lesitedumariage.com/" target="blank_">lesitedumariage</a></li>
                    <li class="megamenu__item"><a href="https://www.hockerty.fr/fr/" target="blank_">Hockerty</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="col-lg-4">
        <div><h4>Enfants</h4></div>
        <ul class="megamenu__links megamenu__links--level--0 row" style="justify-content: space-between;">
            <li class=" megamenu__item  megamenu__item--with-submenu ">
                <span class="title-borderb">Vêtements et chaussures</span>
                <ul class="megamenu__links megamenu__links--level--1 my-2">
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
                <span class="title-borderb">Bébé</span>
                <ul class="megamenu__links megamenu__links--level--1 my-2">
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
                <span class="title-borderb">Jeux et Jouets</span>
                <ul class="megamenu__links megamenu__links--level--1 my-2">
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
                <span class="title-borderb">Les ventes Privées</span>
                <ul class="megamenu__links megamenu__links--level--1 my-2">
                    <li class="megamenu__item"><a href="https://www.veepee.fr/gr/home/default" target="blank_">Vente-privee</a></li>
                    <li class="megamenu__item"><a href="https://www.showroomprive.com/" target="blank_">Showroomprive</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="col-lg-4">
        <div><h4>Sports et Loisirs</h4></div>
        <ul class="megamenu__links megamenu__links--level--0 row" style="justify-content: space-between;">
            <li class="megamenu__item  megamenu__item--with-submenu ">
                <ul class="megamenu__links megamenu__links--level--1 my-2">
                    <li class="megamenu__item"><a href="https://www.decathlon.fr/" target="blank_">Décathlon</a></li>
                    <li class="megamenu__item"><a href="https://www.footlocker.fr/" target="blank_">Footlocker</a></li>
                    <li class="megamenu__item"><a href="https://www.go-sport.com/" target="blank_">Go Sport</a></li>
                    <li class="megamenu__item"><a href="https://www.intersport.fr/" target="blank_">Intersport</a></li>
                    <li class="megamenu__item"><a href="https://www.jdsports.fr/" target="blank_">Jdsports</a></li>
                    <li class="megamenu__item"><a href="https://www.kickz.com/fr" target="blank_">Kickz</a></li>
                </ul>
            </li>
        </ul>
        <div class="mt-2"><h4>Auto et Moto</h4></div>
        <ul class="megamenu__links megamenu__links--level--0 row" style="justify-content: space-between;">
            <li class="megamenu__item  megamenu__item--with-submenu ">
                <ul class="megamenu__links megamenu__links--level--1">
                    <li class="megamenu__item"><a href="https://www.mister-auto.com/" target="blank_">Mister-auto</a></li>
                    <li class="megamenu__item"><a href="https://www.norauto.fr/" target="blank_">norauto</a></li>
                    <li class="megamenu__item"><a href="https://www.oscaro.com/" target="blank_">oscaro</a></li>
                    <li class="megamenu__item"><a href="https://www.piecesauto.com/" target="blank_">piecesauto</a></li>
                    <li class="megamenu__item"><a href="https://www.carter-cash.com/" target="blank_">Carter Cash</a></li>
                </ul>
            </li>
        </ul>
        <div class="mt-2"><h4>Jeux vidéo et consoles</h4></div>
        <ul class="megamenu__links megamenu__links--level--0 row" style="justify-content: space-between;">
            <li class="megamenu__item  megamenu__item--with-submenu ">
                <ul class="megamenu__links megamenu__links--level--1">
                    <li class="megamenu__item"><a href="https://www.fnac.com/enfants.asp" target="blank_">Fnac</a></li>
                    <li class="megamenu__item"><a href="https://www.cultura.com/" target="blank_">Cultura</a></li>
                    <li class="megamenu__item"><a href="https://www.micromania.fr/" target="blank_">Micromania</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="col-lg-4">
        <div><h4>Electroménager</h4></div>
        <ul class="megamenu__links megamenu__links--level--0 row" style="justify-content: space-between;">
            <li class="megamenu__item  megamenu__item--with-submenu ">
                <span class="title-borderb">Electroménager</span>
                <ul class="megamenu__links megamenu__links--level--1 my-2">
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
                <span class="title-borderb">Meuble, décoration et équipement</span>
                <ul class="megamenu__links megamenu__links--level--1 my-2">
                    <li class="megamenu__item"><a href="https://www.bricodepot.fr/" target="blank_">Brico dépôt</a></li>
                    <li class="megamenu__item"><a href="https://www.leroymerlin.fr/" target="blank_">Leroy Merlin</a></li>
                    <li class="megamenu__item"><a href="https://www.castorama.fr/" target="blank_">Castorama</a></li>
                    <li class="megamenu__item"><a href="https://www.ikea.com/fr/fr/" target="blank_">Ikea</a></li>
                    <li class="megamenu__item"><a href="https://www.but.fr/" target="blank_">But</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="col-lg-4">
        <div><h4>High-tech et informatique</h4></div>
        <ul class="megamenu__links megamenu__links--level--0 row" style="justify-content: space-between;">
            <li class="megamenu__item  megamenu__item--with-submenu ">
                <span  class="title-borderb">Informatique</span>
                <ul class="megamenu__links megamenu__links--level--1 my-2">
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
            <li class="megamenu__item  megamenu__item--with-submenu">
                <span  class="title-borderb">Instruments de musique et sono</span>
                <ul class="megamenu__links megamenu__links--level--1 my-2">
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
    <div class="col-lg-4">
       
    </div>
    <div class="col-lg-4">
       
    
    </div>


                                                                 

    <!-- <?php
    $count = 0; // Compteur pour suivre le nombre d'éléments traités
    
    while ($ligne_boucle = $req_boucle->fetch()) {

        // Affichez la catégorie dans la colonne correspondante
        echo '<div class="col-lg-4' . $col_class . '">';
        echo '<div>';
        echo '<h4>' . $ligne_boucle['nom_categorie'] . '</h4>';
        echo '</div>';
        echo '</div>';

    }
    $req_boucle->closeCursor();
    ?> -->
</div>



<?php
///////////////////////////////SELECT BOUCLE
$req_boucle1 = $bdd->prepare("SELECT * FROM categories_liens WHERE id_categorie=? ORDER by nom ASC");
$req_boucle1->execute(array($ligne_boucle['id']));

//while($ligne_boucle1 = $req_boucle1->fetch()){
?>

<?php
// }
// $req_boucle1->closeCursor();
?>


                        
