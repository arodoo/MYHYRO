<?php
if (!empty($user) && !empty($_SESSION['LAST_REFERENCE_FACTURE'])) {

    $req_select = $bdd->prepare("SELECT * FROM membres WHERE pseudo=?");
    $req_select->execute(array($user));
    $ligne_membre = $req_select->fetch();
    $req_select->closeCursor();

    if ($same_adress_oo == "oui") {
        $nomfac = $ligne_membre['nom'];
        $prenomfac = $ligne_membre['prenom'];
        $adressefac = $ligne_membre['Adresse_facturation'];
        $telephonefac = $ligne_membre['Telephone_portable'];
        $villefac = $ligne_membre['Ville_facturation'];
        $cpfac = $ligne_membre['Code_postal_facturation'];
        $paysfac = $ligne_membre['Pays_facturation'];
        $complementfac = $ligne_membre['Complement_d_adresse_facturation'];

        $nomliv = $ligne_membre['nom'];
        $prenomliv = $ligne_membre['prenom'];
        $adresseliv = $ligne_membre['adresse'];
        $villeliv = $ligne_membre['ville'];
        $telephoneliv = $ligne_membre['Telephone_portable'];
        $cpliv = $ligne_membre['cp'];
        $paysliv = $ligne_membre['Pays'];
        $complementliv = $ligne_membre['Complement_d_adresse'];
    } else {
        $nomfac = $ligne_membre['nom'];
        $prenomfac = $ligne_membre['prenom'];
        $adressefac = $ligne_membre['adresse'];
        $villefac = $ligne_membre['ville'];
        $telephonefac = $ligne_membre['Telephone_portable'];
        $cpfac = $ligne_membre['cp'];
        $paysfac = $ligne_membre['Pays'];
        $complementfac = $ligne_membre['Complement_d_adresse'];

        $nomliv = $ligne_membre['nom'];
        $prenomliv = $ligne_membre['prenom'];
        $adresseliv = $ligne_membre['adresse'];
        $villeliv = $ligne_membre['ville'];
        $telephoneliv = $ligne_membre['Telephone_portable'];
        $cpliv = $ligne_membre['cp'];
        $paysliv = $ligne_membre['Pays'];
        $complementliv = $ligne_membre['Complement_d_adresse'];
    }

    if ($_SESSION['id_liv'] == '6') {

        $req_select = $bdd->prepare("SELECT * FROM membres_adresse_liv_france WHERE id_membre=?");
        $req_select->execute(array($id_oo));
        $ligne_select2 = $req_select->fetch();
        $req_select->closeCursor();

        $nomliv = $ligne_select2['nom_liv_france'];
        $prenomliv = $ligne_select2['prenom_liv_france'];
        $adresseliv = $ligne_select2['adresse_liv_france'];
        $villeliv = $ligne_select2['ville_liv_france'];
        $telephoneliv = $ligne_select2['telephone_liv_france'];
        $cpliv =  $ligne_select2['cp_liv_france'];
        $paysliv = "France";
        $complementliv = $ligne_select2['complement_adresse_liv_france'];
    }
?>
    <div>
        <h2>Merci pour votre paiement !</h2><br>
        <h3 style=" text-align: left;">Votre facture N°<?php echo $_SESSION['LAST_REFERENCE_FACTURE']; ?> est disponible.</h3>
        A tout moment vous pouvez retrouver la facture dans votre compte.<br><br>
    </div>

    <?php if (true) {

        $req_select = $bdd->prepare("SELECT * FROM configurations_livraisons_gabon WHERE id=?");
        $req_select->execute(array($_SESSION['id_liv']));
        $ligne_livtext = $req_select->fetch();
        $req_select->closeCursor();
    ?>
        <div id="retour-paiement" class="row icon_box icon_box_style_5" style="border: #80808070 1px solid; max-width: 800px; width: 100%; margin: auto; padding: 10px; margin-bottom: 0px;">
            Votre commande n&#176; <?= $_SESSION['last_commande']; ?> a &#233;t&#233; bien enregistr&#233;e sur my-hyro.com, nous vous remercions de votre confiance. (Un mail de confirmation vous sera adress&#233; dans les minutes qui viennent.)<br>
            <?php if ($_SESSION['last_mode_paiement'] == "Paypal" || $_SESSION['last_mode_paiement'] == "Airtel Money") {
            ?>
                Paiement effectué.<br>
            <?php
            } else {
                ?>
                Dans l'encadr&#233; :

                Pour qu'elle soit prise en compte au plus vite, merci d'apporter votre r&#232;glement &#224; notre ag&#232;nce ou aupr&#232;s de nos repr&#233;sentants.<br>
                Ag&#232;nce de <?= $ligne_livtext['ville_livraison'] ?> : <?= $ligne_livtext['commentaire_livraison'] ?>
            <?php
            } ?>

        </div>
        <div class="d-flex justify-content-center">

            <?php

            /* $test = $_SESSION;
    echo '<pre>';
    print_r($test);
    echo '</pre>';

    $test2 = $_SESSION['isAbonnement'];
    echo 'ok    '.$test2; */

            if ($_SESSION['isAbonnement'] == true) {
                echo '<a  href="/Mon-abonnement" style="font-size: 14px;">Suivre mes abonnements</a>';
            } else if($_SESSION['isListe'] == true) {
                echo '<a  href="/Mes-listes-de-souhaits" style="font-size: 14px;">Suivre mes listes de souhaits</a>';
            } else if(!empty($_SESSION['last_commande'])) {
                echo '<a  href="/Mes-commandes" style="font-size: 14px;">Suivre mes commandes</a>';
            } else if(empty($_SESSION['last_commande'])) {
                echo '<a  href="/Mes-colis" style="font-size: 14px;">Suivre mes colis</a>';
            } 
            ?>


            <!-- <a  href="/Mes-commandes" style="font-size: 14px;">Suivre mes commandes</a> -->
        </div>

        <br>
    <?php
    } ?>

    Pour toutes questions, vous pouvez contacter le service client <a href="/Contact"><u>ici</u></a></p>

    <div class="row">
        <div class="col-md-4">
            <div style="border: #80808070 1px solid; padding: 1em; font-size: 16px; line-height: 10px;">
                <h4>Date de commande : <span style="font-size: 16px;"><?= date('d-m-Y', time()) ?></span></h4>
                <p>N&deg; client : <?= $user ?></p>
                <p>N&deg; Commande : <?= $_SESSION['last_commande']; ?></p>
                <p>Code transaction : xxxxxx</p>
                <p>Type de r&egrave;glement : <?= $_SESSION['type_paiement'] ?></p>
            </div>
        </div>
        <div class="col-md-4">
            <div style="border: #80808070 1px solid;  padding: 1em; font-size: 16px;">
                <h4>Facturation :</h4>
                <?= $_SESSION['address_fac'] ?>
            </div>
        </div>
        <div class="col-md-4">
            <div style="border: #80808070 1px solid; padding: 1em; font-size: 16px;">
                <h4>Livraison :</h4>
                <?= $_SESSION['address_liv'] ?>
            </div>
        </div>

    </div>
    <div style="margin-top: 30px;">

        <a href="/facture/<?php echo $_SESSION['LAST_REFERENCE_FACTURE']; ?>/<?php echo $nomsiteweb; ?>" class="btn btn-primary" target="blank_"><span class="uk-icon-file-pdf-o"></span> Télécharger votre facture</a>

    </div>

<?php

unset($_SESSION['last_commande']);
unset($_SESSION['isAbonnement']);
unset($_SESSION['isListe']);

} else {
    header('location: /index.html');
}
?>