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

if (
    isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 1 ||
    isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 4
) {

    $action = $_GET['action'];
    $actionn = $_GET['actionn'];
    $idaction = $_GET['idaction'];
    $actionone = $_GET['actionone'];

?>

    <script>
        $(document).ready(function() {

            //AJAX SOUMISSION DU FORMULAIRE - MODIFIER - AJOUTER
            $(document).on("click", "#bouton_formulaire_article_categorie", function() {
                //ON SOUMET LE TEXTAREA TINYMCE
                tinyMCE.triggerSave();
                $.post({
                    url: '/administration/Modules/Blog/Articles/gestions-du-blog-action-ajouter-modifier-ajax.php',
                    type: 'POST',
                    <?php if ($_GET['action'] == "modifier") { ?>
                        data: new FormData($("#formulaire_article_blog_modifier")[0]),
                    <?php } else { ?>
                        data: new FormData($("#formulaire_article_blog_ajouter")[0]),
                    <?php } ?>
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    success: function(res) {
                        if (res.retour_validation == "ok") {
                            popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                            <?php if ($_GET['action'] != "modifier") { ?>
                                $("#formulaire_article_blog_ajouter")[0].reset();
                            <?php } ?>
                        } else {
                            popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                        }
                    }
                });
                listeArticleBlog();
            });

            //AJAX - SUPPRIMER
            $(document).on("click", ".lien-supprimer-article-blog", function() {
                $.post({
                    url: '/administration/Modules/Blog/Articles/gestions-du-blog-action-supprimer-ajax.php',
                    type: 'POST',
                    data: {
                        idaction: $(this).attr("data-id")
                    },
                    dataType: "json",
                    success: function(res) {
                        if (res.retour_validation == "ok") {
                            popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                        } else {
                            popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                        }
                        listeArticleBlog();
                        $("#modalSuppr").modal('hide')
                    }
                });
            });

            //FUNCTION AJAX - LISTE 
            function listeArticleBlog() {
                $.post({
                    url: '/administration/Modules/Blog/Articles/gestions-du-blog-liste-article-ajax.php',
                    type: 'POST',
                    dataType: "html",
                    success: function(res) {
                        $("#liste-article-blog").html(res);
                    }
                });
            }

            listeArticleBlog();


            //TYPE D'ARTICLE
            $(document).on("click", "#type_blog_artciles", function() {
                type_blog_artciles();
            });

            function type_blog_artciles() {
                if ($("#type_blog_artciles").val() == "standard") {
                    $(".type_blog_artciles_standard").css("display", "");
                    $(".type_blog_artciles_video").css("display", "");
                }
                if ($("#type_blog_artciles").val() == "image") {
                    $(".type_blog_artciles_standard").css("display", "");
                    $(".type_blog_artciles_video").css("display", "");
                }
                if ($("#type_blog_artciles").val() == "texte") {
                    $(".type_blog_artciles_standard").css("display", "none");
                    $(".type_blog_artciles_video").css("display", "");
                }
                if ($("#type_blog_artciles").val() == "vidéo") {
                    $(".type_blog_artciles_video").css("display", "none");
                    $(".type_blog_artciles_standard").css("display", "none");
                }
            }
            type_blog_artciles();

            $(document).on('click', '#btnSupprModal', function() {
                $.post({
                    url: '/administration/Modules/Blog/Articles/modal-supprimer-ajax.php',
                    type: 'POST',
                    data: {
                        idaction: $(this).attr("data-id")
                    },
                    dataType: "html",
                    success: function(res) {
                        $("body").append(res)
                        $("#modalSuppr").modal('show')
                    }
                })
            });

            $(document).on("click", "#btnSuppr", function() {
                $("#modalSuppr").modal('hide')
            });

            $(document).on("click", "#btnSuppr", function() {
                $.post({
                    url: '/administration/Modules/Blog/Articles/gestions-du-blog-action-supprimer-ajax.php',
                    type: 'POST',
                    data: {
                        idaction: $(this).attr("data-id")
                    },
                    dataType: "json",
                    success: function(res) {
                        if (res.retour_validation == "ok") {
                            popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
                        } else {
                            popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
                        }
                        listeGestionPays();
                    }
                });
            });

            $(document).on("click", "#btnNon", function() {
                $("#modalSuppr").modal('hide')
            });

            $(document).on('hidden.bs.modal', "#modalSuppr", function() {
                $(this).remove()
            })
        });
    </script>

    <ol class="breadcrumb">
        <li><a href="<?php echo $http; ?><?php echo $nomsiteweb; ?>">Accueil</a></li>
        <li><a href="<?php echo $mode_back_lien_interne; ?>">Administration</a></li>
        <?php if (empty($_GET['action'])) { ?> <li class="active">Gestion du blog</li> <?php } else { ?> <li><a href="?page=Gestions-du-blog">Gestion du blog</a></li> <?php } ?>
        <?php if ($_GET['action'] == "modifier") { ?> <li class="active">Modifications</li> <?php } ?>
        <?php if ($_GET['action'] == "ajouter") { ?> <li class="active">Ajouter</li> <?php } ?>
    </ol>

    <div id='bloctitre' style='text-align: left;'>
        <h1>Gestion du blog</h1>
    </div><br />
    <div style='clear: both;'></div>

    <?php
    ////////////////////Boutton administration
    echo "<a href='" . $mode_back_lien_interne . "'><button type='button' class='btn btn-default' style='margin-right: 5px;' ><span class='uk-icon-cogs'></span> Administration</button></a>";
    echo "<a href='?page=Pages&amp;action=modification&amp;idaction=4'><button type='button' class='btn btn-primary' style='margin-right: 5px;' ><span class='uk-icon-cog'></span> Gestion de la page</button></a>";
    echo "<a href='/Blog' target='_top'><button type='button' class='btn btn-primary' style='margin-right: 5px;' ><span class='uk-icon-search'></span> Consulter le blog</button></a>";
    echo "<a href='?page=Configurations-du-blog'><button type='button' class='btn btn-primary' style='margin-right: 5px;' ><span class='uk-icon-file'></span> Configurations du blog</button></a>";
    echo "<a href='?page=Categories-du-blog'><button type='button' class='btn btn-primary' style='margin-right: 5px;' ><span class='uk-icon-file-text'></span> Catégories du blog</button></a>";
    if ($action != "ajouter") {
        echo "<a href='?page=Gestions-du-blog&amp;action=ajouter'><button type='button' class='btn btn-success' style='margin-right: 5px;' ><span class='uk-icon-plus-circle'></span> Ajouter un article</button></a>";
    }
    if (!empty($action)) {
        echo "<a href='?page=Gestions-du-blog'><button type='button' class='btn btn-success' style='margin-right: 5px;' ><span class='uk-icon-file-text-o'></span> Liste des articles</button></a>";
    }
    echo "<div style='clear: both;'></div>";
    ////////////////////Boutton administration
    ?>

    <div style='padding: 5px;' align="center">

        <?php

        ////////////////////////////////////////AJOUTER / MODIFIER
        if ($action == "ajouter" || $action == "modifier") {

            $_SESSION['page_precedente_article_blog'] = $_SERVER['REQUEST_URI'];

            ////////////////////On nome l'id de la page ou numéro temporaire pour les photos
            if ($action == "ajouter") {
                $_SESSION['id_page_photo_2'] = time();
            } else {
                $_SESSION['id_page_photo_2'] = $idaction;
            }
            ////////////////////On nome l'id de la page ou numéro temporaire pour les photos

            if ($action == "modifier") {

                $_SESSION['idsessionp_2'] = $idaction;

                ///////////////////////////////SELECT
                $req_select = $bdd->prepare("SELECT * FROM codi_one_blog WHERE id=?");
                $req_select->execute(array($idaction));
                $ligne_select = $req_select->fetch();
                $req_select->closeCursor();
                $idoneinfos_artciles_blog = $ligne_select['id'];
                $id_categorie_artciles_blog = $ligne_select['id_categorie'];
                $titre_blog_1_artciles_blog = $ligne_select['titre_blog_1'];
                $titre_blog_2_artciles_blog = $ligne_select['titre_blog_2'];
                $texte_article_blog = $ligne_select['texte_article'];
                $video_artciles_blog = $ligne_select['video'];
                $url_fiche_blog_artciles_blog = $ligne_select['url_fiche_blog'];
                $mot_cle_blog_1_artciles_blog = $ligne_select['mot_cle_blog_1'];
                $mot_cle_blog_1_lien_artciles_blog = $ligne_select['mot_cle_blog_1_lien'];
                $mot_cle_blog_2_artciles_blog = $ligne_select['mot_cle_blog_2'];
                $mot_cle_blog_2_lien_artciles_blog = $ligne_select['mot_cle_blog_2_lien'];
                $mot_cle_blog_3_artciles_blog = $ligne_select['mot_cle_blog_3'];
                $mot_cle_blog_3_lien_artciles_blog = $ligne_select['mot_cle_blog_3_lien'];
                $mot_cle_blog_4_artciles_blog = $ligne_select['mot_cle_blog_4'];
                $mot_cle_blog_4_lien_artciles_blog = $ligne_select['mot_cle_blog_4_lien'];
                $ID_IMAGE_BLOG_artciles_blog = $ligne_select['ID_IMAGE_BLOG'];
                $nbr_consultation_blog_artciles_blog = $ligne_select['nbr_consultation_blog'];
                $Title_artciles_blog = $ligne_select['Title'];
                $Metas_description_artciles_blog = $ligne_select['Metas_description'];
                $Metas_mots_cles_artciles_blog = $ligne_select['Metas_mots_cles'];
                $activer_commentaire_artciles_blog = $ligne_select['activer_commentaire'];
                $activer_artciles_blog = $ligne_select['activer'];
                $date_blog_artciles_blog = $ligne_select['date_blog'];
                $type_blog_artciles_blog = $ligne_select['type_blog_artciles'];

                if ($type_blog_artciles_blog == "standard") {
                    $selectedtypeacrticle1 = "selected='selected'";
                } elseif ($type_blog_artciles_blog == "image") {
                    $selectedtypeacrticle2 = "selected='selected'";
                } elseif ($type_blog_artciles_blog == "texte") {
                    $selectedtypeacrticle3 = "selected='selected'";
                } elseif ($type_blog_artciles_blog == "vidéo") {
                    $selectedtypeacrticle4 = "selected='selected'";
                }

                if ($activer_artciles_blog == "oui") {
                    $selectedstatut1 = "selected='selected'";
                } elseif ($activer_artciles_blog == "non") {
                    $selectedstatut2 = "selected='selected'";
                } elseif ($activer_artciles_blog == "brouillon") {
                    $selectedstatut3 = "selected='selected'";
                }

                if ($activer_commentaire_artciles_blog == "oui") {
                    $selectedstatut11 = "selected='selected'";
                } elseif ($Declaree_dans_site_map_xml == "non") {
                    $selectedstatut22 = "selected='selected'";
                }

                ///////////////////////////////INSERT
                $sql_insert = $bdd->prepare("INSERT INTO configurations_publicites
	(type_publicite)
	VALUES (?)");
                $sql_insert->execute(array(
                    "ok"
                ));
                $sql_insert->closeCursor();

                ///////////////////////////////SELECT
                $req_select = $bdd->prepare("SELECT COUNT(*) AS nbr_commentaire FROM codi_one_blog_commentaires WHERE id_article=?");
                $req_select->execute(array($id_categorie_artciles_blog));
                $ligne_select = $req_select->fetch();
                $req_select->closeCursor();
                $nbr_commentaire = $ligne_select['nbr_commentaire'];

        ?>

                <div align='left'>
                    <h2>Modifier l'article <?php echo "$titre_blog_1_artciles_blog"; ?></h2>
                </div><br />
                <div style='clear: both;'></div>

                <form id="formulaire_article_blog_modifier" method="post" action="?page=Gestions-du-blog&amp;action=modifier-action&amp;idaction=<?php echo "$idaction"; ?>">
                    <input id="action" type="hidden" name="action" value="modifier-action">
                    <input id="idaction" type="hidden" name="idaction" value="<?php echo "$idaction"; ?>">

                <?php
            } else {
                ?>

                    <div align='left'>
                        <h2>Ajouter un article</h2>
                    </div><br />
                    <div style='clear: both;'></div>

                    <form id="formulaire_article_blog_ajouter" method="post" action="?page=Gestions-du-blog&amp;action=ajouter-action&amp;idaction=<?php echo "$idaction"; ?>">
                        <input id="action" type="hidden" name="action" value="ajouter-action">

                    <?php
                }
                    ?>

                    <table style="text-align: left; width: 100%; text-align: center;" cellpadding="2" cellspacing="2">
                        <tbody>

                            <tr>
                                <td style="text-align: left; width: 190px;">Type d'article</td>
                                <td style="text-align: left;">
                                    <select id='type_blog_artciles' name='type_blog_artciles' class='form-control'>
                                        <option value='standard' <?php echo "$selectedtypeacrticle1"; ?>> Type standard (Texte et image/vidéo) </option>
                                        <option value='image' <?php echo "$selectedtypeacrticle2"; ?>> Type image </option>
                                        <option value='texte' <?php echo "$selectedtypeacrticle3"; ?>> Type texte (Seul ou avec une vidéo) </option>
                                        <option value='vidéo' <?php echo "$selectedtypeacrticle4"; ?>> Type vidéo </option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>

                            <tr class='type_blog_artciles_standard' style='display: none;'>
                                <td style="text-align: left; width: 190px;">Gestion des photos</td>
                                <td style="text-align: left;">
                                    <a href='/administration/index-admin.php?page=Photos-blog&amp;action=<?php echo "$action"; ?>' target='top_'>
                                        <button type='button' class='btn btn-success'>Gestion photos</button>
                                    </a>
                                </td>
                            </tr>
                            <tr class='type_blog_artciles_standard' style='display: none;'>
                                <td colspan="2">&nbsp;</td>
                            </tr>

                            <?php
                            if ($action != "ajouter") {
                            ?>

                                <tr>
                                    <td style="text-align: left; width: 190px;">Lien de l'article</td>
                                    <td style="text-align: left;">
                                        <a href='/<?php echo "$url_fiche_blog_artciles_blog"; ?>' target='_top'>
                                            <button type='button' class='btn btn-success'>Consulter l'article</button>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                </tr>

                                <tr>
                                    <td style="text-align: left; width: 190px;">Consultations </td>
                                    <td style="text-align: left;">
                                        <?php echo "$nbr_consultation_blog_artciles_blog Consultation(s)"; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                </tr>

                            <?php
                            }
                            ?>

                            <tr>
                                <td style="text-align: left; width: 190px;">Catégorie </td>
                                <td style="text-align: left;">
                                    <select name='id_categorie_article_post' class='form-control'>
                                        <option value=""> <?php echo "Sans catégorie"; ?> &nbsp; &nbsp; </option>

                                        <?php
                                        ///////////////////////////////SELECT BOUCLE
                                        $req_boucle = $bdd->prepare("SELECT * FROM codi_one_blog_categories ORDER BY nom_categorie ASC");
                                        $req_boucle->execute(array());
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

                                            if ($idoneinfos == $id_categorie_artciles_blog) {
                                        ?>
                                                <option selected='selected' value="<?php echo "$idoneinfos"; ?>"> <?php echo "$nom_categorie"; ?> &nbsp; &nbsp; </option>
                                            <?php
                                            } else {
                                            ?>
                                                <option value="<?php echo "$idoneinfos"; ?>"> <?php echo "$nom_categorie"; ?> &nbsp; &nbsp; </option>
                                        <?php
                                            }
                                        }
                                        $req_boucle->closeCursor();
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>

                            <tr>
                                <td style="text-align: left; width: 190px;">Nom / Titre 1 </td>
                                <td style="text-align: left;">
                                    <input type='text' name="nom_article_titre1_post" class="form-control" placeholder="Grand titre / Associé au nom de la page" value="<?php echo "$titre_blog_1_artciles_blog"; ?>" style='width: 100%;' />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>

                            <tr>
                                <td style="text-align: left; width: 190px;">Titre 2 </td>
                                <td style="text-align: left;">
                                    <input type='text' name="nom_titre2_post" class="form-control" placeholder="Petit titre de l'article" value="<?php echo "$titre_blog_2_artciles_blog"; ?>" style='width: 100%;' />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>

                            <tr class='type_blog_artciles_video' style='display: none;'>
                                <td style="text-align: left; vertical-align: top; width: 190px;">Description</td>
                                <td style="text-align: left;"><textarea class='mceEditor' id='description_articles_post' name='description_articles_post' style='width: 100%; height: 60px;'><?php echo "$texte_article_blog"; ?></textarea></td>
                            </tr>
                            <tr class='type_blog_artciles_video' style='display: none;'>
                                <td colspan="2">&nbsp;</td>
                            </tr>

                            <tr>
                                <td style="text-align: left; vertical-align: top; width: 190px;">Vidéo</td>
                                <td style="text-align: left;"><textarea name='video_article_post' class='form-control' placeholder="Script d'une vidéo sur Youtube" style='width: 100%; height: 70px;'><?php echo "$video_artciles_blog"; ?></textarea></td>
                            </tr>
                            <tr>
                                <td style="text-align: left; vertical-align: top; width: 190px;"></td>
                                <td style="text-align: left;">Youtube : Cliquez sur partager, puis intégrer et copier coller le code ci-dessus.</td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>

                            <tr>
                                <td style="text-align: left; width: 190px;">Title </td>
                                <td style="text-align: left;">
                                    <input type='text' name="title_article_post" class="form-control" placeholder="Titre dans la fenêtre du navigateur" value="<?php echo "$Title_artciles_blog"; ?>" style='width: 100%;' />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>

                            <tr>
                                <td style="text-align: left; vertical-align: top; width: 190px;">Méta déscription</td>
                                <td style="text-align: left;"><textarea name='meta_description_post' class='form-control' placeholder="Description en 2 ligne maximum" style='width: 100%; height: 50px;'><?php echo "$Metas_description_artciles_blog"; ?></textarea></td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>

                            <tr>
                                <td style="text-align: left; vertical-align: top; width: 190px;">Méta keywords</td>
                                <td style="text-align: left;"><textarea name='meta_keyword_post' class='form-control' placeholder="Mot clé 1, Mot clé 2, Mot clé 3, Mot clé 4, Mot clé 5, Mot clé 6," style='width: 100%; height: 50px;'><?php echo "$Metas_mots_cles_artciles_blog"; ?></textarea></td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>

                            <tr>
                                <td style="text-align: left; width: 190px;">Statut de l'article </td>
                                <td style="text-align: left;">
                                    <select name='statut_activer_post' class='form-control'>
                                        <option <?php echo "$selectedstatut3"; ?> value='brouillon'> Brouillon &nbsp; &nbsp;</option>
                                        <option <?php echo "$selectedstatut2"; ?> value='non'> Désactivée &nbsp; &nbsp;</option>
                                        <option <?php echo "$selectedstatut1"; ?> value='oui'> Activée &nbsp; &nbsp;</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>

                    </table>

                    <table class="ajoutArticle" style="text-align: left; width: 100%; border-collapse : separate; border-spacing : 0px 15px;" cellpadding="2" cellspacing="2">
                        <tbody>
                        </tbody>
                    </table>

                    <table style="text-align: left; width: 100%; text-align: center;" cellpadding="2" cellspacing="2">
                        <tbody>
                            <tr>
                                <td style="text-align: left; width: 190px;">Ajouter un lien</td>
                                <td style="text-align : left;"><button id="ajouter-lien" title="Ajouter un lien" type="button" class="btn btn-success" style="width : 50px; height : auto; margin-bottom : 0 !important;"><span class="uk-icon-plus"></span></button></td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                        </tbody>
                    </table>


                    <script>
                        $("#ajouter-lien").click(function() {
                            lien_ajoutter();
                        });

                        function lien_ajoutter(lien_page, ancre_page, statut, position) {
                            var incrementation = 1;
                            incrementation = (incrementation + $('.count_lien').length);
                            $(".ajoutArticle > tbody").append(`<tr class="article"><td style="text-align: left; width: 190px;"> Lien </td>
                                        <td><input type="text" name="blog_liens[` + incrementation + `][ancre]" class="form-control count_lien" placeholder="Ancre" style="display : flex; text-align : left; width : 96%;"></td>
                                        <td><input type="text" name="blog_liens[` + incrementation + `][lien]" class="form-control" placeholder="Lien" style="display : flex; text-align : left; width : 96%;"></td>
                                        <td>
                                            <select name="blog_liens[` + incrementation + `][statut]" class="form-control" value="` + statut + `" style="display : flex; text-align : left; width : 96%;">
                                                <option hidden selected <?php echo "$selectedstatut3"; ?> value='statut'> Statut &nbsp; &nbsp;</option>
                                                <option <?php echo "$selectedstatut2"; ?> value='non'> Désactivée &nbsp; &nbsp;</option>
                                                <option <?php echo "$selectedstatut1"; ?> value='oui'> Activée &nbsp; &nbsp;</option>
                                            </select>
                                        </td>
                                        <td><input type="number" name="blog_liens[` + incrementation + `][position]" class="form-control" placeholder="Position" value="` + position + `" style="display : flex; text-align : left; width : 96%;"></td>
                                        <td><button type="button" class="btn btn-danger supprimer" style="width : 50px; height : auto; margin-bottom : 0 !important;"><span class="uk-icon-trash-o"></span></button></td>
                                    </tr>`);

                            $('.supprimer').click(function() {
                                $(this).parent().parent().remove()
                            })

                        }

                        <?php
                        ///////////////////////////////SELECT BOUCLE
                        $req_boucle = $bdd->prepare("SELECT * FROM codi_one_blog_liens WHERE id_article_blog=?");
                        $req_boucle->execute(array($idaction));
                        while ($ligne_boucle = $req_boucle->fetch()) {
                        ?>
                            lien_ajoutter("<?php echo $ligne_boucle['lien_page']; ?>", "<?php echo $ligne_boucle['ancre_page']; ?>", "<?php echo $ligne_boucle['statut']; ?>", "<?php echo $ligne_boucle['position']; ?>", );
                        <?php
                        }
                        $req_boucle->closeCursor();
                        ?>
                    </script>

                    <td>
                        <button id='bouton_formulaire_article_categorie' type='button' class='btn btn-success' style='width: 150px;' onclick='return false;'>ENVOYER</button>
                    </td>
                    </form>

                <?php

            }
            ////////////////////////////////////////AJOUTER / MODIFIER

            ////////////////////////////SI APS D'ACTION 
            if (empty($_GET['action'])) {
                ?>

                    <!-- LISTE DES ARTICLES DU BLOG -->
                    <div id='liste-article-blog'></div>


                <?php
            }
            ////////////////////////////SI APS D'ACTION 
                ?>

    </div>

<?php
} else {
    header("location: index.html");
}

?>