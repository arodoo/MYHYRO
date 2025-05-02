<style>
    @media (max-width: 768px) {
    .page-header__title h1 {
        display: none;
    }
}
</style>
<script>
    function handleRedirect(id){
        $.post({
            url: '/function/function_manager_command.php',
            type: 'POST',
            data: {
                action: "Modifier",
                id: id
            },
            success: function(res) {
                res = JSON.parse(res);

                if (res.retour_validation == "ok") {
                    document.location.replace('/Passage-de-commande');
                }else{
                    popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                }
            }
        })
    }
</script>
<?php
if($_GET['page'] != "Panier2"){
    unset($_SESSION['frais_gestion_pf']);
    unset($_SESSION['paiement_pf']);
    unset($_SESSION['id_paiement']);
    unset($_SESSION['id_livraison']);
    unset($_SESSION['frais_livraison']);
}

if($_GET['page'] != "Recapitulatif-Panier" && $_GET['page'] != "Panier2"){
    unset($_SESSION['prix_expedition_colis_total']);
    unset($_SESSION['prix_expedition_total']);
}



if($_GET['page'] == "Avatar"){
	?>

	<div class="page-header">
                <div class="page-header__container container">
                    <div class="page-header__breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/"><?= $nom_proprietaire; ?></a>
                                    <svg class="breadcrumb-arrow" width="6px" height="9px">
                                        <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                    </svg>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Avatar</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="page-header__title">
                        <h1>Avatar</h1>
                    </div>
                </div>
            </div>

	<?php
}elseif($_GET['page'] == "Boutique"){

    
    $action = $_GET['action'];
   
	?>

	<div class="page-header">
                <div class="page-header__container container">
                    <div class="page-header__breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/"><?= $nom_proprietaire; ?></a>
                                    <svg class="breadcrumb-arrow" width="6px" height="9px">
                                        <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                    </svg>
                                </li>
                                <?php 
                                    if($action)
                                    {
                                        ?>
                                     <li class="breadcrumb-item">
                                        <a href="/Boutique">Boutique</a>
                                        <svg class="breadcrumb-arrow" width="6px" height="9px">
                                            <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                        </svg>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page"><?= $action ?></li>

                                    <?php } else{ ?>
                                <li class="breadcrumb-item <?= $active ?>" aria-current="page">Boutique</li>
                                <?php }?>
                            </ol>
                        </nav>
                    </div>
                    <div class="page-header__title">
                        <h1>Boutique</h1>
                    </div>
                </div>
            </div>

	<?php
}elseif($_GET['page'] == "Boutique-fiche"){

	?>

	<div class="page-header">
                <div class="page-header__container container">
                    <div class="page-header__breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/"><?= $nom_proprietaire; ?></a>
                                    <svg class="breadcrumb-arrow" width="6px" height="9px">
                                        <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                    </svg>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="/Boutique">Boutique</a>
                                    <svg class="breadcrumb-arrow" width="6px" height="9px">
                                        <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                    </svg>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Boutique fiche</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="page-header__title">
                        <h1>Mes commandes</h1>
                    </div>
                </div>
            </div>

	<?php
}elseif($_GET['page'] == "Passage-de-commande"){
	?>

	<div class="page-header">
                <div class="page-header__container container">
                    <div class="page-header__breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/"><?= $nom_proprietaire; ?></a>
                                    <svg class="breadcrumb-arrow" width="6px" height="9px">
                                        <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                    </svg>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Passage de commande</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="page-header__title">
                            <h1 style="font-size: 28px;">Constitution du panier</h1>
                    </div>
                </div>
            </div>

	<?php
}elseif($_GET['page'] == "Passage-de-colis"){
	?>

	<div class="page-header">
                <div class="page-header__container container">
                    <div class="page-header__breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/"><?= $nom_proprietaire; ?></a>
                                    <svg class="breadcrumb-arrow" width="6px" height="9px">
                                        <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                    </svg>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Passage de colis</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="page-header__title">
                            <h1>Constitution du colis</h1>
                    </div>
                </div>
            </div>

	<?php
}elseif($_GET['page'] == "Recapitulatif"){
	?>

	<div class="page-header">
                <div class="page-header__container container">
                    <div class="page-header__breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/"><?= $nom_proprietaire; ?></a>
                                    <svg class="breadcrumb-arrow" width="6px" height="9px">
                                        <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                    </svg>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Passage de commande</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="page-header__title">
                        <h1>Récapitulatif du panier</h1>
                        <button onclick="handleRedirect(<?= $_SESSION['id_commande']; ?>)" class="btn btn-primary mt-2">Retourner à l'étape précédente</button>
                    </div>
                </div>
            </div>

	<?php
}elseif($_GET['page'] == "Mes-commandes"){
	?>

	<div class="page-header">
                <div class="page-header__container container">
                    <div class="page-header__breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/"><?= $nom_proprietaire; ?></a>
                                    <svg class="breadcrumb-arrow" width="6px" height="9px">
                                        <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                    </svg>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Mes commandes</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="page-header__title">
                        <h1>Mes commandes</h1>
                    </div>
                </div>
            </div>

	<?php
}elseif($_GET['page'] == "Sites-d-achats-recommandes"){
	?>

	<div class="page-header">
                <div class="page-header__container container">
                    <div class="page-header__breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/"><?= $nom_proprietaire; ?></a>
                                    <svg class="breadcrumb-arrow" width="6px" height="9px">
                                        <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                    </svg>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Sites recommandés</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="page-header__title">
                        <h1>Sites recommandés</h1>
                    </div>
                </div>
            </div>

	<?php
}elseif($_GET['page'] == "Mon-abonnement"){
	?>

	<div class="page-header">
                <div class="page-header__container container">
                    <div class="page-header__breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/"><?= $nom_proprietaire; ?></a>
                                    <svg class="breadcrumb-arrow" width="6px" height="9px">
                                        <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                    </svg>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Mon abonnement</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="page-header__title">
                        <h1>Mon abonnement</h1>
                    </div>
                </div>
            </div>

	<?php
}elseif($_GET['page'] == "Mes-listes-de-souhaits"){
	?>

	<div class="page-header">
                <div class="page-header__container container">
                    <div class="page-header__breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/"><?= $nom_proprietaire; ?></a>
                                    <svg class="breadcrumb-arrow" width="6px" height="9px">
                                        <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                    </svg>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Mes listes de souhaits</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="page-header__title">
                        <h1>Mes listes de souhaits</h1>
                    </div>
                </div>
            </div>

	<?php
}elseif($_GET['page'] == "Mes-colis"){
	?>

	<div class="page-header">
                <div class="page-header__container container">
                    <div class="page-header__breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/"><?= $nom_proprietaire; ?></a>
                                    <svg class="breadcrumb-arrow" width="6px" height="9px">
                                        <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                    </svg>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Mes colis</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="page-header__title">
                        <h1>Mes colis</h1>
                    </div>
                </div>
            </div>

	<?php
}elseif($_GET['page'] == "modifier-profil-photo"){
	?>

	<div class="page-header">
                <div class="page-header__container container">
                    <div class="page-header__breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/"><?= $nom_proprietaire; ?></a>
                                    <svg class="breadcrumb-arrow" width="6px" height="9px">
                                        <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                    </svg>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Avatar</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="page-header__title">
                        <h1>Avatar</h1>
                    </div>
                </div>
            </div>

	<?php
}elseif($_GET['page'] == "Compte-modifications"){
	?>

	<div class="page-header">
                <div class="page-header__container container">
                    <div class="page-header__breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/"><?= $nom_proprietaire; ?></a>
                                    <svg class="breadcrumb-arrow" width="6px" height="9px">
                                        <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                    </svg>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Modifications de votre compte</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="page-header__title">
                        <h1>Modifications de votre compte</h1>
                    </div>
                </div>
            </div>

	<?php

}elseif($_GET['page'] == "Traitements-informations"){
	?>

	<div class="page-header">
                <div class="page-header__container container">
                    <div class="page-header__breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/"><?= $nom_proprietaire; ?></a>
                                    <svg class="breadcrumb-arrow" width="6px" height="9px">
                                        <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                    </svg>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Paiement validé</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="page-header__title">
                        <h1>Paiement validé</h1>
                    </div>
                </div>
            </div>

	<?php

////////////////////////////////////////////////////////////////////////////////////////////FICHE BLOG
}elseif($_GET['page'] == "blog" && !empty($_GET['fiche']) && !empty($_GET['idaction'])){

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM codi_one_blog WHERE id=?");
$req_select->execute(array($_GET['idaction']));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM codi_one_blog_categories WHERE id=?");
$req_select->execute(array($ligne_select['id_categorie']));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$nom_categorie = $ligne_select['nom_categorie'];
$nom_url_categorie = $ligne_select['nom_url_categorie'];
$Title = $ligne_select['Title'];
$Metas_description = $ligne_select['Metas_description'];
$Metas_mots_cles = $ligne_select['Metas_mots_cles'];

	?>

	<div class="page-header">
                <div class="page-header__container container">
                    <div class="page-header__breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/"><?= $nom_proprietaire; ?></a>
                                    <svg class="breadcrumb-arrow" width="6px" height="9px">
                                        <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                    </svg>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="/Blog">Blog</a>
                                    <svg class="breadcrumb-arrow" width="6px" height="9px">
                                        <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                    </svg>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?php echo "/$nom_url_categorie"; ?>"><?= $nom_categorie; ?></a>
                                    <svg class="breadcrumb-arrow" width="6px" height="9px">
                                        <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                    </svg>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo "$titre_blog_1_artciles_blog"; ?></li>
                            </ol>
                        </nav>
                    </div>
                    <div class="page-header__title">
                        <h1><?php echo "$titre_blog_1_artciles_blog"; ?></h1>
                    </div>
                </div>
            </div>

	<?php
////////////////////////////////////////////////////////////////////////////////////////////FICHE BLOG

////////////////////////////////////////////////////////////////////////////////////////////CATEGORIE BLOG
}elseif($_GET['page'] == "blog" && empty($_GET['fiche']) && !empty($_GET['idaction'])){

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM codi_one_blog_categories WHERE id=?");
$req_select->execute(array($_GET['idaction']));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$nom_categorie = $ligne_select['nom_categorie'];
$Title = $ligne_select['Title'];
$Metas_description = $ligne_select['Metas_description'];
$Metas_mots_cles = $ligne_select['Metas_mots_cles'];

	?>

	<div class="page-header">
                <div class="page-header__container container">
                    <div class="page-header__breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/"><?= $nom_proprietaire; ?></a>
                                    <svg class="breadcrumb-arrow" width="6px" height="9px">
                                        <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                    </svg>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="/Blog">Blog</a>
                                    <svg class="breadcrumb-arrow" width="6px" height="9px">
                                        <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                    </svg>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo "$nom_categorie"; ?></li>
                            </ol>
                        </nav>
                    </div>
                    <div class="page-header__title">
                        <h1><?php echo "$nom_categorie"; ?></h1>
                    </div>
                </div>
            </div>

	<?php
////////////////////////////////////////////////////////////////////////////////////////////FICHE BLOG

////////////////////////////////////////////////////////////////////////////////////////////BLOG
}elseif($_GET['page'] == "blog"){
	?>

	<div class="page-header">
                <div class="page-header__container container">
                    <div class="page-header__breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/"><?= $nom_proprietaire; ?></a>
                                    <svg class="breadcrumb-arrow" width="6px" height="9px">
                                        <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                    </svg>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo "$Ancre_fil_ariane_page"; ?></li>
                            </ol>
                        </nav>
                    </div>
                    <div class="page-header__title">
                        <h1><?php echo "$Titre_h1_page"; ?></h1>
                    </div>
                </div>
            </div>

	<?php

////////////////////////////////////////////////////////////////////////////////////////////Paiement
}elseif($_GET['page'] == "Panier"){
	?>

	<div class="page-header">
                <div class="page-header__container container">
                    <div class="page-header__breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/"><?= $nom_proprietaire; ?></a>
                                    <svg class="breadcrumb-arrow" width="6px" height="9px">
                                        <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                    </svg>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Recapitulatif panier</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="page-header__title">
                        <h1>Recapitulatif panier</h1>
                    </div>
                </div>
            </div>

	<?php

////////////////////////////////////////////////////////////////////////////////////////////Paiement 2
}elseif($_GET['page'] == "Panier2"){
	?>

	<div class="page-header">
                <div class="page-header__container container">
                    <div class="page-header__breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/"><?= $nom_proprietaire; ?></a>
                                    <svg class="breadcrumb-arrow" width="6px" height="9px">
                                        <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                    </svg>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Paiement</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="page-header__title">
                        <h1>Paiement</h1>
                    </div>
                </div>
            </div>

<?php

////////////////////////////////////////////////////////////////////////////////////////////Messagerie
}elseif($_GET['page'] == "Messagerie"){
	?>

	<div class="page-header">
                <div class="page-header__container container">
                    <div class="page-header__breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/"><?= $nom_proprietaire; ?></a>
                                    <svg class="breadcrumb-arrow" width="6px" height="9px">
                                        <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                    </svg>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Messagerie</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="page-header__title">
                        <h1>Messagerie</h1>
                    </div>
                </div>
            </div>

<?php

////////////////////////////////////////////////////////////////////////////////////////////Messagerie
}elseif($_GET['page'] == "Message"){
	?>

	<div class="page-header">
                <div class="page-header__container container">
                    <div class="page-header__breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/"><?= $nom_proprietaire; ?></a>
                                    <svg class="breadcrumb-arrow" width="6px" height="9px">
                                        <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                    </svg>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Message</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="page-header__title">
                        <h1>Message</h1>
                    </div>
                </div>
            </div>

<?php

////////////////////////////////////////////////////////////////////////////////////////////Messagerie
}elseif($_GET['page'] == "factures"){
	?>

	<div class="page-header">
                <div class="page-header__container container">
                    <div class="page-header__breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/"><?= $nom_proprietaire; ?></a>
                                    <svg class="breadcrumb-arrow" width="6px" height="9px">
                                        <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                    </svg>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Factures</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="page-header__title">
                        <h1>Factures</h1>
                    </div>
                </div>
            </div>

<?php

////////////////////////////////////////////////////////////////////////////////////////////NOTIFICATIONS
}elseif($_GET['page'] == "Notifications"){
	?>

	<div class="page-header">
                <div class="page-header__container container">
                    <div class="page-header__breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/"><?= $nom_proprietaire; ?></a>
                                    <svg class="breadcrumb-arrow" width="6px" height="9px">
                                        <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                    </svg>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Notifications</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="page-header__title">
                        <h1>Notifications</h1>
                    </div>
                </div>
            </div>

<?php

////////////////////////////////////////////////////////////////////////////////////////////PAGE FRONT
}elseif(!empty($_GET['page'])){
	?>

	<div class="page-header">
                <div class="page-header__container container">
                    <div class="page-header__breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/"><?= $nom_proprietaire; ?></a>
                                    <svg class="breadcrumb-arrow" width="6px" height="9px">
                                        <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                    </svg>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo "$Ancre_fil_ariane_page"; ?></li>
                            </ol>
                        </nav>
                    </div>
                    <div class="page-header__title">
                        <h1><?php echo "$Titre_h1_page"; ?></h1>
                    </div>
                </div>
            </div>

	<?php
}
////////////////////////////////////////////////////////////////////////////////////////////PAGE FRONT

?>
