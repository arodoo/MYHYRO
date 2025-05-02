<style>
    .site-footer {
        margin-top: 0 !important;
    }

    .site-footer__bottom {
        justify-content: end; 
}

</style>
<!-- site__footer -->
<footer class="site__footer">
    <div class="site-footer">
        <div class="container">
            <div class="site-footer__widgets">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="site-footer__widget footer-contacts">
                            <h5 class="footer-contacts__title">Contact</h5>
                            <div class="footer-contacts__text">
                                Notre plateforme vous permet de commande, acheter et livrer des colis en France et chez vous avec des options d'achat.
                            </div>
                            <ul class="footer-contacts__contacts">
                                <li><i class="footer-contacts__icon fas fa-globe-americas"></i> <?php echo "$adresse_ii $ville_ii $cp_dpt_ii $pays_ii"; ?></li>
                                <li><i class="footer-contacts__icon far fa-envelope"></i> <?php echo "$emaildefault"; ?></li>
                                <li><i class="footer-contacts__icon fas fa-mobile-alt"></i> <?php echo "$telephone_fixe_ii $telephone_portable_ii"; ?></li>
                                <li><i class="footer-contacts__icon far fa-clock"></i> <?php echo "Lundi à Samedi 9:00 à 17:00"; ?></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 col-lg-2">
                        <div class="site-footer__widget footer-links">
                            <h5 class="footer-links__title">Informations</h5>
                            <ul class="footer-links__list">
                                <li class="footer-links__item"><a href="/Contact" class="footer-links__link">Contact</a></li>
                                <li class="footer-links__item"><a href="/Livraisons" class="footer-links__link">Livraisons</a></li>
                                <li class="footer-links__item"><a href="/Mode-de-paiements" class="footer-links__link">Mode de paiements</a></li>
                                <li class="footer-links__item"><a href="/Vos-donnees" class="footer-links__link">Vos données</a></li>
                                <li class="footer-links__item"><a href="/Blog" class="footer-links__link">Blog</a></li>
                                <li class="footer-links__item"><a href="/Abonnements" class="footer-links__link">Devenir membre</a></li>
                                <li class="footer-links__item"><a href="/Recrutement" class="footer-links__link">Recrutement</a></li>
                                <li class="footer-links__item"><a href="/Comment-ca-marche" class="footer-links__link">Comment ça marche</a></li>
                                <li class="footer-links__item"><a href="/A-propos" class="footer-links__link">Mentions légales</a></li>
                                <li class="footer-links__item"><a href="/Traitements-de-mes-donnees" class="footer-links__link">Vos données</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 col-lg-2">
                        <div class="site-footer__widget footer-links">
                            <h5 class="footer-links__title">Mon compte</h5>
                            <ul class="footer-links__list">
                                <li class="footer-links__item"><a href="<?php if (!empty($user)) { ?>/Gestion-de-votre-compte.html<?php } else {
                                                                                                                                    echo "#";
                                                                                                                                } ?>" <?php if (empty($user)) { ?>onclick="return false;" <?php } ?> class="footer-links__link <?php if (empty($user)) { ?>pxp-header-user<?php } ?>">Mes informations</a></li>
                                <li class="footer-links__item"><a href="<?php if (!empty($user)) { ?>/Mes-commandes<?php } else {
                                                                                                                    echo "#";
                                                                                                                } ?>" <?php if (empty($user)) { ?>onclick="return false;" <?php } ?> class="footer-links__link <?php if (empty($user)) { ?>pxp-header-user<?php } ?>">Mes commandes</a></li>
                                <li class="footer-links__item"><a href="<?php if (!empty($user)) { ?>/Mon-abonnement<?php } else {
                                                                                                                    echo "#";
                                                                                                                } ?>" <?php if (empty($user)) { ?>onclick="return false;" <?php } ?> class="footer-links__link <?php if (empty($user)) { ?>pxp-header-user<?php } ?>">Mon abonnement</a></li>
                                <li class="footer-links__item"><a href="<?php if (!empty($user)) { ?>/Ma-liste-de-souhaits<?php } else {
                                                                                                                            echo "#";
                                                                                                                        } ?>" <?php if (empty($user)) { ?>onclick="return false;" <?php } ?> class="footer-links__link <?php if (empty($user)) { ?>pxp-header-user<?php } ?>">Ma liste de souhaits</a></li>
                                <li class="footer-links__item"><a href="<?php if (!empty($user)) { ?>/Envoyer-un-colis<?php } else {
                                                                                                                        echo "#";
                                                                                                                    } ?>" <?php if (empty($user)) { ?>onclick="return false;" <?php } ?> class="footer-links__link <?php if (empty($user)) { ?>pxp-header-user<?php } ?>">Envoyer un colis</a></li>
                                <li class="footer-links__item"><a href="<?php if (!empty($user)) { ?>/Factures<?php } else {
                                                                                                                echo "#";
                                                                                                            } ?>" <?php if (empty($user)) { ?>onclick="return false;" <?php } ?> class="footer-links__link <?php if (empty($user)) { ?>pxp-header-user<?php } ?>">Mes factures</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-4">
                        <div class="site-footer__widget footer-newsletter">
                            <h5 class="footer-newsletter__title">Newsletter</h5>
                            <div class="footer-newsletter__text">
                                Inscrivez-vous à notre newsletter et recever des bons plans et des offres.
                            </div>
                            <form action="" class="footer-newsletter__form">
                                <label class="sr-only" for="footer-newsletter-address">Adresse Email</label>
                                <input type="text" class="footer-newsletter__form-input form-control" id="mail_souscription" name="email" placeholder="Email ...">
                                <button id="souscription_newsletter" class="footer-newsletter__form-button btn btn-primary" onclick="return false;">S'inscrire</button>
                            </form>
                            <div class="footer-newsletter__text footer-newsletter__text--social">
                                Suivez-nous sur les réseaux sociaux
                            </div>
                            <!-- social-links -->
                            <div class="social-links footer-newsletter__social-links social-links--shape--circle">
                                <ul class="social-links__list">
                                    <li class="social-links__item">
                                        <a class="social-links__link social-links__link--type--facebookk" href="https://www.facebook.com" target="_blank">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                    </li>
                                    <li class="social-links__item">
                                        <a class="social-links__link social-links__link--type--twitterr" href="https://twitter.com/home?lang=fr" target="_blank">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                    </li>
                                    <li class="social-links__item">
                                        <a class="social-links__link social-links__link--type--linkedin" href="https://www.linkedin.com" target="_blank">
                                            <i class="fab fa-linkedin"></i>
                                        </a>
                                    </li>
                                    <li class="social-links__item">
                                        <a class="social-links__link social-links__link--type--tiktok" href="https://www.tiktok.com/fr/" target="_blank">
                                            <i class="fab fa-tiktok"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <!-- social-links / end -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="site-footer__bottom">

                <div class="site-footer__payments">
                    <img src="/images/logo airtel money.png" alt="Paiement">
                    <img src="/template2/black/images/paiement.jpg" alt="Paiement">
                </div>
            </div>
        </div>
        <div class="totop">
            <div class="totop__body">
                <div class="totop__start"></div>
                <div class="totop__container container"></div>
                <div class="totop__end">
                    <button type="button" class="totop__button">
                        <svg width="13px" height="8px">
                            <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-up-13x8"></use>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- site__footer / end -->


<div class="site__footer2" style="padding: 0;">
    <div class="container">
        <div class="site-footer__widgets" style="padding: 0;">
            <div class="row">

                <div class="">
                    <div class="site-footer__widget footer-contacts">
                        <div class="footer-contacts__text">
                            <img src="/images/logo footer.png" alt="my-hyro" style="width: 100%;">
                        </div>


                    </div>

                </div>

                <div class="" style="padding: 15px;">
                    <div class="site-footer__copyright">
                        <?php echo "$text_informations_footer"; ?>
                        <div>
                            <a href="/CGV">CGV</a> | <a href="/Partenariats">Partenariats</a> | <a href="/FAQ">FAQ</a> | <a href="/Nos-engagements">Nos engagements</a>
                        </div>
                    </div>
                </div>


                <!-- <div class="col-12 col-md-3 col-lg-3">
                                <div class="site-footer__widget footer-links" style="margin-bottom: 10px;" >
                                    <h5 class="footer-links__title" style="margin-bottom: 10px;" >Assistance Gabon</h5>
                                    <ul class="footer-links__list" style="margin-bottom: 10px;">
                                        <li class="footer-links__item"><?php echo $telephone_fixe_ii; ?></li>
                                    </ul>
                                    <h5 class="footer-links__title" style="margin-bottom: 10px;" >Assistance France</h5>
                                    <ul class="footer-links__list">
                                        <li class="footer-links__item"><?php echo $telephone_portable_ii; ?></li>
                                    </ul>
                                </div>
                            </div> -->
                <!-- 
                            <div class="col-12 col-md-3 col-lg-3">
                                <div class="site-footer__widget footer-links">
                                    <h5 class="footer-links__title">Nos réseaux sociaux </h5>
                                    <ul class="footer-links__list">
                                        <li class="footer-links__item"><a href="https://www.facebook.com" class="footer-links__link"><i class="fab fa-facebook-f"></i> Facebook</a></li>
                                        <li class="footer-links__item"><a href="https://twitter.com/home?lang=fr" class="footer-links__link"><i class="fab fa-twitter"></i> Twitter</a></li>
                                        <li class="footer-links__item"><a href="https://www.tiktok.com/fr/" class="footer-links__link"><i class="fab fa-tiktok"></i> Tiktok</a></li>
                                        <li class="footer-links__item"><a href="https://www.linkedin.com" class="footer-links__link"><i class="fab fa-linkedin"></i> Linkedin</a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-12 col-md-3 col-lg-3">
                                <div class="site-footer__widget footer-links">
                                    <h5 class="footer-links__title">Les dernières news</h5>
<?php
$req_test_blog = $bdd->prepare("SELECT * FROM codi_one_blog WHERE activer=? AND type_blog_artciles=? ORDER BY date_blog DESC LIMIT 0,3");
$req_test_blog->execute(array("oui", "standard"));
if ($req_test_blog->fetch()) {
?>
                                    <ul class="footer-links__list">
		<?php
        ///////////////////////////////SELECT BOUCLE
        $req_boucle = $bdd->prepare("SELECT * FROM codi_one_blog WHERE activer=? AND type_blog_artciles=? ORDER BY date_blog DESC LIMIT 0,4");
        $req_boucle->execute(array("oui", "standard"));
        while ($ligne_boucle = $req_boucle->fetch()) {
            ///////////////////////////////SELECT
            $req_select = $bdd->prepare("SELECT * FROM codi_one_blog_a_b_image WHERE id_page=?");
            $req_select->execute(array($ligne_boucle['id']));
            $ligne_select = $req_select->fetch();
            $req_select->closeCursor();
            $img_lienii = $ligne_select['img_lien2'];
            //affichage date
            $date_fiche = $ligne_boucle['date_blog'];
            $jour = date('d', $date_fiche);
            $mois = date('m', $date_fiche);
            $annee = date('y', $date_fiche);
            $b++;
            $texte_article_blog_source = strip_tags($ligne_boucle['texte_article']);
            $texte_article_blog_len = strlen($texte_article_blog_source);
            $texte_article_blog = substr($texte_article_blog_source, "0", "100");
            $texte_article_blog_texte = mb_substr($texte_article_blog_source, "0", 100 * 2);
            if ($texte_article_blog_len > $limitation_texte_liste_blog_cfg && $type_blog_artciles_blog != "texte") {
                $texte_article_blog = "$texte_article_blog ...";
            } elseif ($texte_article_blog_len > ($limitation_texte_liste_blog_cfg * 2) && $type_blog_artciles_blog == "texte") {
                $texte_article_blog = "$texte_article_blog_texte ...";
            }
        ?>
                              <li class="footer-links__item"><a href="/<?php echo $ligne_boucle['url_fiche_blog']; ?>" class="footer-links__link"><?php echo $ligne_boucle['titre_blog_1']; ?></a></li>
		<?php
        }
        $req_boucle->closeCursor();
        ?>  
                    </ul>
	<?php } ?>

                                </div>
                            </div> -->

            </div>
        </div>
    </div>
</div>