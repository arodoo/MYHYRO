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
if (isset($user)) {

    if (isset($_SESSION['id_commande'])) {

        $sql_select = $bdd->prepare('SELECT * FROM membres_commandes WHERE id=? AND statut=3');
        $sql_select->execute(array($_SESSION['id_commande']));
        $commande = $sql_select->fetch();
        $sql_select->closeCursor();
        $action = "Modifier";
        $empty = false;
        $id_commande = $commande['id'];

        $sql_boucle = $bdd->prepare("SELECT COUNT(*) as con FROM membres_commandes_details WHERE commande_id=?");
        $sql_boucle->execute(array($id_commande));
        $articl = $sql_boucle->fetch();
        $sql_boucle->closeCursor();

        if ($articl['con'] == '0') {
            $action = "Ajouter";
        }
    } else {

        $sql_select = $bdd->prepare('SELECT * FROM membres_commandes WHERE user_id=? AND statut=3');
        $sql_select->execute(array($id_oo));
        $commande = $sql_select->fetch();
        $sql_select->closeCursor();
        if ($commande) {
            $id_commande = $commande['id'];
            $_SESSION['id_commande'] = $commande['id'];
            $empty = false;
            $action = "Modifier";
            $sql_boucle = $bdd->prepare("SELECT COUNT(*) as con FROM membres_commandes_details WHERE commande_id=?");
            $sql_boucle->execute(array($id_commande));
            $articl = $sql_boucle->fetch();
            $sql_boucle->closeCursor();

            if ($articl['con'] == '0') {
                $action = "Ajouter";
            }
        } else {
            $empty = true;
            $action = "Ajouter";
        }
    }
} else {

    if (isset($_SESSION['id_commande'])) {

        $action = "Modifier";
        $sql_select = $bdd->prepare('SELECT * FROM membres_commandes WHERE id=?'); //AND statut=3
        $sql_select->execute(array($_SESSION['id_commande']));
        $commande = $sql_select->fetch();
        $sql_select->closeCursor();
        $id_commande = $commande['id'];
        $empty = false;
    } else {

        $empty = false;
        $action = "Ajouter";
    }
}


?>
<style>
    .btn-delete-mobile {
        display: none;
    }


    .mobile-text {
        display: none;
    }

    @media (max-width: 768px) {

        .article-price {
            width: 35% !important;
        }

        .btn-delete-mobile {
            display: block;
        }

        .mobile-text {
            display: block;
        }

        .uk-icon-trash-o.mobile {
            display: none !important;
        }

        .text-center-adapt {
            display: flex;

        }


        .btn-details.lineRef.btn-add-to-cart,
        .deleteRow {
            margin: 0 auto !important;
        }

        /*  .delete-btn {
            display: none;
        } */

    }
</style>
<div style='clear: both;'></div>



<!-- AJOUTER COMMANDE -->
<?php

if ($action == "Ajouter") { ?>
    <div class="container" style="padding:0; margin-bottom:100px">
        <input id="idCommande" type="text" value="<?= $id_commande; ?>" disabled style="display:none" />
        <div class="container">
            <div class="row" style="margin-top: 1rem;">
                <div class="col-lg-9 col-md-6" style="padding-left: 0px;">
                    <div style="max-width: 100%;">
                        <div id="panier_vide" class="row" style="justify-content:center;flex-direction:column;align-content:center">
                            <img src="../../images/empty.jpeg" style="max-width:125px; align-self:center" />
                            <div class="text-center">
                                <span style=" font-size: 20px; text-align: center; margin-right:10px">VOTRE PANIER EST VIDE !</span> <?php if (!$user) { ?>
                                    <button onclick="return false;" class="pxp-header-user btn btn-primary" style="align-self:center;margin-top:1rem;margin-bottom:1rem"> Connexion </button>
                                <?php } ?> <br>
                                <span style="color: #2C7091; font-size: 17px;" class="container">Créer votre panier en indiquant les liens de vos articles ou visitez notre boutique</span>

                            </div>

                        </div>
                        <table id='articleTable' class="table commandsTable display" style="text-align: center; width: 100% !important; border-radius: 7px" cellpadding="2" cellspacing="2">
                            <thead>
                                <tr scope="col">
                                    <th style="text-align: center; width:25%">LIEN DE L'ARTICLE</th>
                                    <th style="text-align: center; width:10%">COULEUR</th>
                                    <th style="text-align: center; width:5%">TAILLE/POINTURE</th>
                                    <th style="text-align: center; width:20%">CATÉGORIE</th>
                                    <th style="text-align: center; width:9%">PRIX (€)</th>
                                    <th style="text-align: center; width:5%">QUANTITÉ</th>
                                    <th style="text-align: center; width:5%">AJOUTER</th>
                                    <th style="text-align: center; width:5%"><i class="uk-icon-trash-o trash-black" style="cursor: pointer;" onclick="handleDeleteAllArticles()"></i></th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr class="odd">
                                    <td class="dtr-control" data-label="LIEN DE L'ARTICLE">
                                        <div class="add-article">

                                            <button class="toggle-row btn-circle">+</button>
                                            <input class="form-control article-url" title="Collez ici le lien de votre article" value="<?= $_SESSION['url'] ?>" type="text" name="article-url" placeholder="Collez ici le lien de votre article" />
                                            <a class="deleteRow btn-delete-mobile" onclick="handleDeleteArticle(<?= $id_commande; ?>, <?= $id_article; ?>)" style="color: #FF9900;margin-left:0.5rem">
                                                <span class="uk-icon-trash-o"></span>

                                            </a>
                                        </div>
                                    </td>
                                    <td data-label="COULEUR">
                                        <input class="form-control article-color" title="Indiquez la couleur si nécessaire" type="text" name="article-color" placeholder="Couleur" />
                                    </td>
                                    <td data-label="Taille">
                                        <input class="form-control article-size" title="Indiquez la taille ou la pointure si nécessaire" type="text" name="article-size" placeholder="Taille" />
                                    </td>
                                    <td data-label="CATÉGORIE">
                                        <select id="article-category" name="article-category" class="form-control cp article-category">
                                            <option></option>
                                            <?php
                                            $req_boucle = $bdd->prepare("SELECT * FROM categories ORDER BY nom_categorie ASC");
                                            $req_boucle->execute();
                                            while ($ligne_boucle = $req_boucle->fetch()) {
                                                echo "<option class='option-custom' number='" . $article . "' type='" . $ligne_boucle['type'] . "' price='" . $ligne_boucle['value'] . "' value='" . $ligne_boucle['nom_categorie'] . "'>" . $ligne_boucle['nom_categorie'] . "</option>";
                                            }
                                            $req_boucle->closeCursor();
                                            ?>
                                        </select>
                                    </td>

                                    <td data-label="Prix">
                                        <div class="input-group article-size">
                                            <input placeholder="prix article" id="article-0" title="Indiquez le prix exact tel qu'il apparaît sur votre site d'achat" class="form-control cp article-price" type="text" value="" name="article-price" />
                                        </div>
                                    </td>
                                    <td>
                                        <select style="width:100%; margin-right: 10px" class="form-control cp article-quantity" name="article-quantity">
                                            <?php for ($j = 1; $j <= 100; $j++): ?>
                                                <option value="<?= $j; ?>" <?= ($articles[$i]['quantite'] == $j) ? 'selected' : ''; ?>>
                                                    <?= $j; ?>
                                                </option>
                                            <?php endfor; ?>
                                        </select>
                                    </td>
                                    <td>
                                        <div class="text-center-adapt">
                                            <a line="0" id="ajouterCommande" class="btn-details lineRef" style="position:relative;font-size: 20px;color: green;margin-right:0.5rem">
                                                <span class="uk-icon-shopping-cart"></span>
                                                <span class="uk-icon-plus" style="position:absolute;top:0;font-size:10px"></span>
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center-adapt delete-btn">
                                            <a onclick="handleRefresh(0)" class="btn-details deleteRow" style="color: #FF9900;margin-left:0.5rem">
                                                <span class="uk-icon-trash-o mobile"></span>
                                                <span class="mobile-text" style="text-decoration: underline;">SUPPRIMER</span>
                                            </a>

                                        </div>
                                    </td>
                                </tr>
                            </tbody>

                        </table>

                        <div class="row" style="margin:0; margin-top: 1rem;align-items:end">
                            <button id="addRow" class="btn btn-primary" onclick="addRow()">Ajouter un article</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" style="align-self: flex-start; position: sticky; top: 0;">
                    <div class="row" style="margin-right: 15px; ">
                        <div class="col-md-12" style="background-color: #E6F7E6; padding: 20px; border-radius: 10px; text-align: center; margin: 15px;">
                            <h4 style="font-weight: normal;">Total articles</h4>
                            <h1 style="font-size: 26px !important; font-weight: bold; color: #003C71;" id="total-fcfa-label">
                                <?= round($totalFCFA); ?> FCFA
                            </h1>
                            <p style="color: #666;">En euro : <span id="total-euro-label"><?= round($totalFCFA * 0.00152449, 2); ?>€</span></p>
                            <input id="total-euro" type="hidden" value="<?= round($totalFCFA * 0.00152449, 2); ?>">
                            <input id="total-fcfa" type="hidden" value="<?= round($totalFCFA); ?>">
                            <button type="button"
                                id="<?php if (!empty($user)) {
                                        echo 'ajouterAllArticles';
                                    } ?>"
                                class="btn cart__checkout-button <?php if (empty($user)) {
                                                                        echo 'pxp-header-user';
                                                                    } ?>"
                                <?php if (empty($user)) {
                                    echo 'onclick="return false;"';
                                } ?>>
                                PASSER COMMANDE
                            </button>


                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label for="item-comment" style="font-size: 14px;">Commentaire ou précision sur votre commande ?</label>
                            <textarea style="height: 100px; resize: none; padding: 10px;" class="form-control" id="item-comment" placeholder="Écrivez votre commentaire sur la commande"><?= $commande['comment']; ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">

        </div>
    </div>

<?php

    // MODIFIER COMMANDE
} else if (($action == "Modifier" || $action == "Recap") && isset($id_commande)) { ?>
    <?php
    $totalFCFA = 0;
    $sql_select = $bdd->prepare("SELECT * FROM membres_commandes WHERE id=? AND user_id=?");
    $sql_select->execute(array($id_commande, $id_oo));
    $commande = $sql_select->fetch();
    $sql_select->closeCursor();

    $sql_boucle = $bdd->prepare("SELECT COUNT(*) as con FROM membres_commandes_details WHERE commande_id=?");
    $sql_boucle->execute(array($id_commande));
    $articl = $sql_boucle->fetch();
    $sql_boucle->closeCursor();

    ?>
    <input id="idCommande" type="text" value="<?= $id_commande; ?>" disabled style="display:none" />
    <div class="container" style="padding:0; margin-bottom:1rem">



        <div class="row" style="margin-top:1rem">
            <?php if ($articl['con'] != '0') {
            ?> <div class="container" style="color: #2C7091; font-size: 17px;">Indiquez-nous les articles que vous souhaitez commander</div>
            <?php
            } ?>

            <div class="col-lg-9 col-md-12">
                <?php if ($articl['con'] == '0') {
                ?>
                    <div id="panier_vide" class="row" style="justify-content:center;flex-direction:column;align-content:center">
                        <img src="../../images/empty.jpeg" style="max-width:125px; align-self:center" />
                        <div class="text-center">
                            <span style=" font-size: 20px; text-align: center; margin-right:10px">VOTRE PANIER EST VIDE !</span> <?php if (!$user) { ?>
                                <button onclick="return false;" class="pxp-header-user btn btn-primary" style="align-self:center;margin-top:1rem;margin-bottom:1rem"> Connexion </button>
                            <?php } ?> <br>
                            <span style="color: #2C7091; font-size: 17px;" class="container">Créer votre panier en indiquant les liens de vos articles ou visitez notre boutique</span>

                        </div>

                    </div>
                <?php
                } ?>
                <table id="articleTable" class="commandsTable table display" style="border-radius: 7px">
                    <thead>
                        <tr scope="col">
                            <th style="text-align: center;width:25%">LIEN DE L'ARTICLE</th>
                            <th style="text-align: center;width:10%">COULEUR</th>
                            <th style="text-align: center;width:5%">TAILLE/POINTURE</th>
                            <th style="text-align: center;width:20%">CATÉGORIE</th>
                            <th style="text-align: center;width:9%">PRIX (€)</th>
                            <th style="text-align: center; width:5%">QUANTITÉ</th>
                            <th style="text-align: center; width:5%">AJOUTER</th>
                            <th style="text-align: center; width:5%"><i class="uk-icon-trash-o trash-black" onclick="handleDeleteAllArticles()"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql_boucle = $bdd->prepare("SELECT * FROM membres_commandes_details WHERE commande_id=? ORDER BY id ASC");
                        $sql_boucle->execute(array($id_commande));
                        $articles = $sql_boucle->fetchAll();
                        $sql_boucle->closeCursor();

                        for ($i = 0; $i < count($articles); $i++) {
                            $totalFCFA += floatval($articles[$i]['prix'] * $articles[$i]['quantite']);
                        ?>
                            <tr class="odd">

                                <td class="dtr-control" data-label="LIEN DE L'ARTICLE <?= $i + 1; ?>">
                                    <div class="add-article">

                                        <button class="toggle-row btn-circle">+</button>
                                        <input title="Collez ici le lien de votre article" <?php if ($articles[$i]['valide'] === "true") {
                                                                                                echo ("disabled");
                                                                                            } ?> class="form-control article-url" value="<?= $articles[$i]['url'] ?>" type="text" name="article-url" placeholder="Collez ici le lien de votre article" />
                                        <a class="deleteRow btn-delete-mobile" onclick="handleDeleteArticle(<?= $articles[$i]['commande_id']; ?>, <?= $articles[$i]['id']; ?>)" style="color: #FF9900;margin-left:0.5rem">
                                            <span class="uk-icon-trash-o"></span>

                                        </a>

                                        <input class="article-id" value="<?= $articles[$i]['id'] ?>" type="hidden" name="article-id" />
                                    </div>


                                </td>
                                <td data-label="COULEUR">
                                    <input title="Indiquez la couleur si nécessaire" class="form-control article-color" value="<?= $articles[$i]['couleur'] ?>" type="text" name="article-color" placeholder="Couleur" />
                                </td>
                                <td data-label="Taille/Pointure">
                                    <input title="Indiquez la taille ou la pointure si nécessaire" class="form-control article-size" value="<?= $articles[$i]['taille'] ?>" type="text" name="article-size" placeholder="Taille" />
                                </td>
                                <td data-label="CATÉGORIE">
                                    <select id="article-category" <?php if ($articles[$i]['valide'] === "true") {
                                                                        echo ("disabled");
                                                                    } ?> name="article-category" class="form-control cp article-category">
                                        <option></option>
                                        <?php
                                        $req_boucle = $bdd->prepare("SELECT * FROM categories ORDER BY nom_categorie ASC");
                                        $req_boucle->execute();
                                        while ($ligne_boucle = $req_boucle->fetch()) { ?>
                                            <option type="<?= $ligne_boucle['type']; ?>" price="<?= $ligne_boucle['value']; ?>" value="<?= $ligne_boucle['nom_categorie']; ?>" <?php if ($articles[$i]['categorie'] == $ligne_boucle['nom_categorie']) {
                                                                                                                                                                                    echo "selected";
                                                                                                                                                                                } ?>><?= $ligne_boucle['nom_categorie'] ?></option>
                                        <?php }
                                        $req_boucle->closeCursor();
                                        ?>
                                    </select>
                                </td>
                                <td data-label="PRIX (€)">
                                    <div class="input-group article-price article-size">
                                        <input <?php if ($articles[$i]['valide'] === "true") {
                                                    echo ("disabled");
                                                } ?> placeholder="prix article" title="Indiquez le prix exact tel qu'il apparaît sur votre site d'achat" style="border-top-right-radius: 0px; border-bottom-right-radius:0px" class="form-control cp article-size" type="text" value="<?= round($articles[$i]['prix'] * 0.00152449, 2); ?>" min="1" name="article-price" />
                                    </div>
                                </td>
                                <td data-label="QUANTITÉ">
                                    <select style="width:100%; margin-right: 10px; " class="form-control cp article-quantity" name="article-quantity">
                                        <?php for ($j = 1; $j <= 100; $j++): ?>
                                            <option value="<?= $j; ?>" <?= ($articles[$i]['quantite'] == $j) ? 'selected' : ''; ?>>
                                                <?= $j; ?>
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                </td>
                                <td>
                                    <div class="text-center-adapt">
                                        <a line="<?= $i ?>" data="<?= $articles[$i]['id']; ?>" id="modifierArticle" class="btn-details lineRef" style="position:relative;font-size: 20px;color: green;margin-right:0.5rem">
                                            <span class="uk-icon-shopping-cart"></span><span class="uk-icon-plus" style="position:absolute;top:0;font-size:10px"></span>
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-center-adapt delete-btn">
                                        <a class="deleteRow" data-article-id="<?= $articles[$i]['id']; ?>"
                                            data-commande-id="<?= $articles[$i]['commande_id']; ?>"
                                            onclick="handleDeleteArticle(<?= $articles[$i]['commande_id']; ?>, <?= $articles[$i]['id']; ?>)" style="color: #FF9900;margin-left:0.5rem">
                                            <span class="uk-icon-trash-o mobile"></span>
                                            <span class="mobile-text" style="text-decoration: underline;">SUPPRIMER</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>

                </table>

                <div class="row" style="margin:0; margin-top: 1rem;align-items:end">
                    <button id="addRow" class="btn btn-primary" onclick="addRow()">Ajouter un article</button>
                </div>
            </div>

            <div class="col-lg-3 col-md-12" style="align-self: flex-start; position: sticky; top: 0;">
                <div class="row" style="margin-right: 15px; ">
                    <div class="col-md-12" style="background-color: #E6F7E6; padding: 20px; border-radius: 10px; text-align: center; margin: 15px;">
                        <h4 style="font-weight: normal;">Total articles</h4>
                        <h1 style="font-size: 26px !important; font-weight: bold; color: #003C71;" id="total-fcfa-label">
                            <?= round($totalFCFA); ?> FCFA
                        </h1>
                        <p style="color: #666;">En euro : <span id="total-euro-label"><?= round($totalFCFA * 0.00152449, 2); ?>€</span></p>
                        <input id="total-euro" type="hidden" value="<?= round($totalFCFA * 0.00152449, 2); ?>">
                        <input id="total-fcfa" type="hidden" value="<?= round($totalFCFA); ?>">
                        <button type="button"
                            id="<?php if (!empty($user)) {
                                    echo 'ajouterAllArticles';
                                } ?>"
                            class="btn cart__checkout-button <?php if (empty($user)) {
                                                                    echo 'pxp-header-user';
                                                                } ?>"
                            <?php if (empty($user)) {
                                echo 'onclick="return false;"';
                            } ?>>
                            PASSER COMMANDE
                        </button>


                    </div>
                </div>

                <!-- Sección de Comentarios -->
                <div class="row">
                    <div class="col-md-12">
                        <label for="item-comment" style="font-size: 14px;">Commentaire ou précision sur votre commande ?</label>
                        <textarea style="height: 100px; resize: none; padding: 10px;" class="form-control" id="item-comment" placeholder="Écrivez votre commentaire sur la commande"><?= $commande['comment']; ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <input id="nbArticle" type="hidden" value="<?= count($articles) ?>" />





        <!-- <div class="row" style="margin:0; margin-top: 1.5rem;">
            <div class="col-12 col-md-5" style="padding:0px;">
                <label for="item-comment">Commentaire ou précision sur votre commande ?</label>
                <textarea style="height:100px;resize:none" class="form-control" id="item-comment" placeholder="Écrivez votre commentaire sur la commande"><?= $commande['comment']; ?></textarea>
            </div>
            <div class="col-12 col-md-1"></div>
            <div class="col-12 col-md-6">
                <div class="row">
                    <div class="col-4"></div>
                    <div class="col-4 col-md-4 form-control text-center border-left border-top border-right" style="border:0">En euro</div>
                    <div class="col-4 col-md-4 form-control text-center border-top border-right" style="border:0">En F CFA</div>
                </div>
                <div class="row">
                    <div class="col-1"></div>
                    <div class="col-3 col-md-3 text-center border p-0"><span class="form-control" style="border:none;border-radius:0">Sous-total</span></div>
                    <div class="col-4 col-md-4 border-top border-bottom border-right p-0">
                        <input id="total-euro" value="<?= round($totalFCFA * 0.00152449, 2); ?>" class="form-control" style="text-align: center;border: none;border-radius: 0" disabled />
                    </div>
                    <div class="col-4 col-md-4 border-top border-bottom border-right p-0">
                        <input id="total-fcfa" value="<?= round($totalFCFA); ?>" class="form-control" style="text-align:center;border: none;border-radius: 0" disabled />
                    </div>
                </div>
            </div>
        </div> -->
    </div>



<?php
}
?>
<script>
    //Fonction permettant d'effacer les données si handleDelete n'est pas activé
    /* $(document).ready(function(){
      $(".btn-delete-mobile").on("click", function(){
        window.eventoActivado = false;
        setTimeout(function(){
          if (!window.eventoActivado) {
            console.log("El handle no se activó, se procede a limpiar los campos.");
            clearArticleFields();
          }
        }, 200); 
      });
    }); */
    $(document).ready(function() {
        // Comprueba si el ancho de la ventana es de dispositivo móvil
        if ($(window).width() <= 768) {
            $(".btn-delete-mobile").on("click", function() {
                window.eventoActivado = false;
                setTimeout(function() {
                    if (!window.eventoActivado) {
                        clearArticleFields();
                    }
                }, 200);
            });
        }
    });

    function clearArticleFields() {
        $("#articleTable").find("input").val("");
        $("#articleTable").find("select").prop("selectedIndex", 0);
    }



    var article;

    function addRow() {
        let table = document.getElementById("articleTable").getElementsByTagName('tbody')[0];
        let newRow = table.insertRow();

        newRow.setAttribute('data-commande-id', '');
        newRow.setAttribute('data-article-id', '');
        newRow.classList.add('new-row');

        newRow.innerHTML = `
        <td data-label="LIEN DE L'ARTICLE ${article + 1}">
            <div class="add-article">
                <input title="Collez ici le lien de votre article" class="form-control article-url" type="text" name="article-url" placeholder="Collez ici le lien de votre article" />
                <a class="deleteRow btn-delete-mobile" onclick="handleDeleteArticle('', '')" style="color: #FF9900;margin-left:0.5rem">
                    <span class="uk-icon-trash-o"></span>
                </a>
            </div>
        </td>
        <td data-label="COULEUR">
            <input title="Indiquez la couleur si nécessaire" class="form-control article-color" type="text" name="article-color" placeholder="Couleur" />
        </td>
        <td data-label="TAILLE/POINTURE">
            <input title="Indiquez la taille ou la pointure si nécessaire" class="form-control article-size" type="text" name="article-size" placeholder="Taille" />
        </td>
        <td data-label="CATÉGORIE">
            <select id="article-category" name="article-category" class="form-control cp article-category">
                <option></option>
                <?php
                $req_boucle = $bdd->prepare("SELECT * FROM categories ORDER BY nom_categorie ASC");
                $req_boucle->execute();
                while ($ligne_boucle = $req_boucle->fetch()) { ?> 
                    <option class="option-custom" number="` + article + `" type="<?= $ligne_boucle['type']; ?>" price="<?= $ligne_boucle['value']; ?>" value="<?= $ligne_boucle['nom_categorie']; ?>">
                        <?= $ligne_boucle['nom_categorie']; ?>
                    </option> 
                <?php }
                $req_boucle->closeCursor(); ?>
            </select>
        </td>
        <td data-label="PRIX (€)">
            <input placeholder="prix article" title="Indiquez le prix exact tel qu'il apparaît sur votre site d'achat" class="form-control cp article-price" id="article-price" type="text" name="article-price" />
        </td>
        <td data-label="QUANTITÉ">
            <select style="width:100%; margin-right: 10px" class="form-control cp article-quantity" name="article-quantity">
                <?php for ($j = 1; $j <= 100; $j++): ?>
                    <option value="<?= $j; ?>"><?= $j; ?></option>
                <?php endfor; ?>
            </select>
        </td>
        <td data-label="">
            <div class="text-center-adapt">
                <a line="` + article + `" id="ajouterCommande" class="btn-details lineRef" style="position: relative; font-size: 20px; color: green; margin-right: 0.5rem">
                    <span class="uk-icon-shopping-cart"></span>
                    <span class="uk-icon-plus" style="position: absolute; top: 0;"></span>
                </a>
            </div>
        </td>
        <td data-label="">
            <div class="text-center-adapt delete-btn">
                <a lined="` + article + `" class="btn-details deleteRow" onclick="handleDeleteArticle('', '')" style="margin-left: 0.5rem; color: #FF9900">
                    <span class="uk-icon-trash-o mobile"></span>
                    <span class="mobile-text" style="text-decoration: underline;">SUPPRIMER</span>
                </a>
            </div>
        </td>
    `;

        article += 1;
        toggleIconsToText();
        onChangeId();
        onChangePrice();
        toggleColumnsOnButtonClick();
    }

    function onChangePrice() {
        let quantities = document.getElementsByName('article-quantity');
        let prices = document.getElementsByName('article-price');

        var totalFcfa = document.getElementById('total-fcfa');
        var totalEuro = document.getElementById('total-euro');
        var totalFcfaLabel = document.getElementById('total-fcfa-label');
        var totalEuroLabel = document.getElementById('total-euro-label');
        var valFcfa = parseFloat(0);
        var valEuro = parseFloat(0);

        for (let i = 0; i < quantities.length; i++) {
            const quantity = parseFloat(quantities[i].value);
            const price = parseFloat(prices[i].value);
            valFcfa += parseFloat(quantity * price / 0.00152449);
            valEuro += parseFloat(quantity * price);
        }

        if (isNaN(valFcfa)) {
            totalFcfa.value = "";
        } else {
            totalFcfa.value = parseInt(valFcfa.toFixed(0)).toLocaleString() + " F CFA";
            totalFcfaLabel.innerHTML = parseInt(valFcfa.toFixed(0)).toLocaleString() + " F CFA";
        }

        if (isNaN(valEuro)) {
            totalEuro.value = "";
        } else {
            totalEuro.value = parseFloat(valEuro.toFixed(2)).toLocaleString() + " €";
            totalEuroLabel.innerHTML = parseFloat(valEuro.toFixed(2)).toLocaleString() + " €";
        }
    }


    function onChangeId() {
        let lines = document.getElementsByClassName('lineRef');
        for (var i = 0; i < lines.length; i++) {
            lines[i].setAttribute('line', i);
        }
    }


    function toggleIconsToText() {


        /*  if (window.matchMedia("(max-width: 768px)").matches) {
             $('.add-article').each(function() {

                 if (!$(this).find('.btn-details.deleteRow').length) {

                     $(this).append(


                         '<a lined="` + article + `" class="btn-details deleteRow" style="margin-left: 0.5rem; color: #FF9900">' +
                         '  <span class="uk-icon-trash-o"></span>' +
                         '   </a>'
                     );
                 }
             });
             $('.delete-btn').hide();
         } */


        if (window.matchMedia("(max-width: 768px)").matches) {


            $('a.lineRef').html("AJOUTER AU PANIER").addClass('btn-add-to-cart');
            // $("tr td.text-center-adapt a").html("SUPPRIMER").addClass('btn-delete');

        } else if (window.matchMedia("(min-width: 768px)").matches) {

            $('a.lineRef').html('<span class="uk-icon-shopping-cart"></span><span class="uk-icon-plus" style="position:absolute;top:0;font-size:10px"></span>').removeClass('btn-add-to-cart');
            $('tr td.text-center-adapt a').html('<span class="uk-icon-trash-o"></span>').removeClass('btn-delete');
        }
    }

    $('#articleTable tbody').on('click', 'input[name="article-url"]', function() {
        const $row = $(this).closest('tr');
        const siblings = $row.find('td:not(:first-child)');
        const button = $row.find('.toggle-row');
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



                $('#articleTable tbody').on('click', 'input[name="article-url"]', function() {
                    const $row = $(this).closest('tr');
                    const siblings = $row.find('td:not(:first-child)');
                    const button = $row.find('.toggle-row');
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


                // Si la ligne est nouvelle, nous verrons toutes les cellules
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

    // Fonction pour afficher ou masquer les colonnes sur mobile
    $(document).ready(function() {


        function toggleIconsToText() {
            if (window.matchMedia("(max-width: 768px)").matches) {

                $('a.lineRef').html("AJOUTER AU PANIER").addClass('btn-add-to-cart');
                // $("tr td div.text-center-adapt a.deleteRow").html("SUPPRIMER").addClass('btn-delete');

            } else if (window.matchMedia("(min-width: 768px)").matches) {

                $('a.lineRef').html('<span class="uk-icon-shopping-cart"></span><span class="uk-icon-plus" style="position:absolute;top:0;font-size:10px"></span>').removeClass('btn-add-to-cart');
                $('tr td div.text-center-adapt a.deleteRow').html('<span class="uk-icon-trash-o"></span>').removeClass('btn-delete');
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

                    // Si la ligne est nouvelle, nous verrons toutes les cellules
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

        // $(window).resize(function() {
        //     isMobile = $(window).width() <= 768;
        //     toggleColumnsOnButtonClick();
        // }).resize();


        function onChangePrice() {
            let quantities = document.getElementsByName('article-quantity');
            let prices = document.getElementsByName('article-price');

            var totalFcfa = document.getElementById('total-fcfa');
            var totalEuro = document.getElementById('total-euro');
            var totalFcfaLabel = document.getElementById('total-fcfa-label');
            var totalEuroLabel = document.getElementById('total-euro-label');
            var valFcfa = parseFloat(0);
            var valEuro = parseFloat(0);

            for (let i = 0; i < quantities.length; i++) {
                const quantity = parseFloat(quantities[i].value);
                const price = parseFloat(prices[i].value);
                valFcfa += parseFloat(quantity * price / 0.00152449);
                valEuro += parseFloat(quantity * price);
            }

            if (isNaN(valFcfa)) {
                totalFcfa.value = "";
            } else {
                totalFcfa.value = parseInt(valFcfa.toFixed(0)).toLocaleString() + " F CFA";
                totalFcfaLabel.innerHTML = parseInt(valFcfa.toFixed(0)).toLocaleString() + " F CFA";
            }

            if (isNaN(valEuro)) {
                totalEuro.value = "";
            } else {
                totalEuro.value = parseFloat(valEuro.toFixed(2)).toLocaleString() + " €";
                totalEuroLabel.innerHTML = parseFloat(valEuro.toFixed(2)).toLocaleString() + " €";
            }
        }




        onChangePrice();


        function onChangeId() {
            let lines = document.getElementsByClassName('lineRef');
            for (var i = 0; i < lines.length; i++) {
                lines[i].setAttribute('line', i);
            }
        }

        $(document).on("change", ".cp", function() {
            onChangePrice();
        });


        onChangeId();
        onChangePrice();
        ///////////////CHAMPS DE RECHERCHE SUR COLONNE

        <?php if ($action == "Modifier" || $action == "Recap") { ?>
            article = parseInt(document.getElementById('nbArticle').value);
        <?php } else { ?>
            article = 1;
        <?php } ?>
        <?php /* if (isset($_SESSION['url'])) { ?>
            article += 1;
        <?php } */ ?>

        var commands_table = $('.commandsTable');


        $('.commandsTable').on('click', '.deleteRow', function(e) {
            e.preventDefault();

            if (article > 1) {
                deleteRow($(this));
            }
        });


        function deleteRow(btn) {
            let row = btn.closest('tr');

            row.remove();

            article -= 1;

            onChangeId();
            onChangePrice();
        }


        if (article == 0) {
            let table = document.getElementById("articleTable").getElementsByTagName('tbody')[0];
            let newRow = table.insertRow();
            article += 1;
            newRow.innerHTML = `
                <td data-label="LIEN DE L'ARTICLE ${article}">
                    <div class="add-article">
                        <input title="Collez ici le lien de votre article" class="form-control article-url" type="text" value="<?= $_SESSION['url'] ?>" name="article-url" placeholder="Collez ici le lien de votre article"/>
                         <a class="deleteRow btn-delete-mobile" onclick="handleDeleteArticle(<?= $id_commande; ?>, <?= $id_article; ?>)" style="color: #FF9900;margin-left:0.5rem">
                                            <span class="uk-icon-trash-o"></span>
                                        </a>

                                        </div>
                        </td>
                    
                <td data-label="COULEUR"><input title="Indiquez la couleur si nécessaire" class="form-control article-color" type="text" name="article-color" placeholder="Couleur"/></td>
                <td data-label="TAILLE/POINTURE"><input title="Indiquez la taille ou la pointure si nécessaire" class="form-control article-size" type="text" name="article-size" placeholder="Taille"/></td>
                <td data-label="CATÉGORIE">
                    <select id='article-category' name='article-category'  class='form-control cp article-category'><option></option><?php $req_boucle = $bdd->prepare("SELECT * FROM categories ORDER BY nom_categorie ASC");
                                                                                                                                        $req_boucle->execute();
                                                                                                                                        while ($ligne_boucle = $req_boucle->fetch()) { ?> <option class='option-custom' number='` + article + `' type='<?= $ligne_boucle['type']; ?>' price='<?= $ligne_boucle['value']; ?>' value='<?= $ligne_boucle['nom_categorie'] ?>'><?= $ligne_boucle['nom_categorie'] ?></option> <?php }
                                                                                                                                                                                                                                                                                                                                                                                                                        $req_boucle->closeCursor() ?> </select>
                </td>
                <td data-label="PRIX (€)"><input placeholder="prix article" title="Indiquez le prix exact tel qu'il apparaît sur votre site d'achat" id="article-0" class="form-control cp article-price article-size"  id="article-price" type="text"  name="article-price"/></td>
                <td data-label="QUANTITÉ">
                   <select style="width:100%; margin-right: 10px" class="form-control cp article-quantity" name="article-quantity">
                                        <?php for ($j = 1; $j <= 100; $j++): ?>
                                            <option value="<?= $j; ?>" <?= ($articles[$i]['quantite'] == $j) ? 'selected' : ''; ?>>
                                                <?= $j; ?>
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                </td>
                <td data-label="">
                            <div class="text-center-adapt" >
                                <a line="` + article + `" id="ajouterCommande" class="btn-details lineRef" style="position: relative; font-size: 20px; color: green; margin-right: 0.5rem">
                                    <span class="uk-icon-shopping-cart"></span>
                                    <span class="uk-icon-plus" style="position: absolute; top: 0; font-size: 10px"></span>
                                </a>
                            </div>
                        </td>
                         <td data-label="">
                            <div class="text-center-adapt delete-btn" >
                                <a lined="` + article + `" class="btn-details deleteRow"   data-article-id="<?= $articles[$i]['id']; ?>"
                                            data-commande-id="<?= $articles[$i]['commande_id']; ?>" style="margin-left: 0.5rem; color: #FF9900">
                                    <span class="uk-icon-trash-o mobile"></span>
                                     <span class="mobile-text" style="text-decoration: underline;">SUPPRIMER</span>
                                </a>
                            </div>
                        </td>
            `;
            article += 1;
            toggleIconsToText();
            toggleColumnsOnButtonClick()

        }



    });

    // Fonction pour le scraping
    $(document).on('change', '.form-control.article-url', function() {
        // 1) Save the input that triggered the change
        const $input = $(this);
        const url = $input.val().trim();
        if (!url) return;

        // 2) Locate the row where this input is
        const $row = $input.closest('tr');

        // 3) Mark as "loading..."
        $row.find('input.article-price').val('…');
        $row.find('input.article-color').val('…');
        $row.find('input.article-size').val('…');

        // 4) Send the POST request
        $.post({
            url: '/panel/Passage-de-commande/scrapping-amazon.php',
            type: 'POST',
            data: {
                scrape_url: url
            },
            success: function(res) {
                /* console.log('Scraper response:', res);
                 */

                if (res.retour_validation === "ok" && res.data) {
                    const data = res.data;
                    // 1) Clean the € symbol
                    let priceClean = (data.price || '').replace('€', '').trim();
                    // 2) Fill in the fields
                    $row.find('input.article-price').val(priceClean);
                    $row.find('input.article-color').val(data.color || '');
                    $row.find('input.article-size').val(data.size || '');

                }
            },
            /*   error: function(xhr, status, error) {
                  console.error('Error in the request:', error);
              } */
        });
    });
</script>
<?php

?>