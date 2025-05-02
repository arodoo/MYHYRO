               <!-- .topbar -->
                <div class="site-header__topbar topbar">
                    <div class="topbar__container container">
                        <div class="topbar__row">
                            <div class="topbar__item topbar__item--link">
                                <a class="topbar-link" href="/">Accueil</a>
                            </div>
                            <div class="topbar__item topbar__item--link">
                                <a class="topbar-link" href="/Contact">Contact</a>
                            </div>
                            <div class="topbar__item topbar__item--link">
                                <a class="topbar-link" href="/Abonnements">Abonnements</a>
                            </div>
                            <div class="topbar__item topbar__item--link">
                                <a class="topbar-link" href="/Suivi-personnalise">Suivi personnalisé</a>
                            </div>
                            <div class="topbar__spring"></div>
                            <div class="topbar__item topbar__item--link" style="margin-right: 70px;">
                                <a class="topbar-link" href="/Passage-de-commande">
                                <img src="/images/clignotant.gif" alt="Créer un panier"></a>
                            </div>

				<?php
				if(!empty($user)){
				?>

                            <div class="topbar__item">
                                <div class="topbar-dropdown">
                                    <button class="topbar-dropdown__btn" type="button">
                                        Mon compte
                                        <svg width="7px" height="5px">
                                            <use xlink:href="/template2/black/images/sprite.svg#arrow-rounded-down-7x5"></use>
                                        </svg>
                                    </button>
                                    <div class="topbar-dropdown__body">
                                        <!-- .menu -->
                                        <div class="menu menu--layout--topbar ">
                                            <div class="menu__submenus-container"></div>
                                            <ul class="menu__list">

						<?php
						//////////////////////////////////SI ADMIN
						if($admin_oo > 0 ){
						?>
                                                <li class="menu__item">
                                                    <!-- This is a synthetic element that allows to adjust the vertical offset of the submenu using CSS. -->
                                                    <div class="menu__item-submenu-offset"></div>
                                                    <a class="menu__item-link" href="/administration/index-admin.php">
                                                        Administration
                                                    </a>
                                                </li>
						<?php
						}
						?>

                                                <li class="menu__item">
                                                    <!-- This is a synthetic element that allows to adjust the vertical offset of the submenu using CSS. -->
                                                    <div class="menu__item-submenu-offset"></div>
                                                    <a class="menu__item-link" href="/Gestion-de-votre-compte.html">
                                                        Mes informations
                                                    </a>
                                                </li>

                                               <!--  <li class="menu__item">
                                                    <div class="menu__item-submenu-offset"></div>
                                                    <a class="menu__item-link" href="/Avatar">
                                                        Avatar
                                                    </a>
                                                </li> -->

                                                <li class="menu__item">
                                                    <!-- This is a synthetic element that allows to adjust the vertical offset of the submenu using CSS. -->
                                                    <div class="menu__item-submenu-offset"></div>
                                                    <a class="menu__item-link" href="/Mes-commandes">
                                                       Mes commandes
                                                    </a>
                                                </li>

                                                <li class="menu__item">
                                                    <!-- This is a synthetic element that allows to adjust the vertical offset of the submenu using CSS. -->
                                                    <div class="menu__item-submenu-offset"></div>
                                                    <a class="menu__item-link" href="/Mon-abonnement">
                                                       Mon abonnement
                                                    </a>
                                                </li>

                                                <li class="menu__item">
                                                    <!-- This is a synthetic element that allows to adjust the vertical offset of the submenu using CSS. -->
                                                    <div class="menu__item-submenu-offset"></div>
                                                    <a class="menu__item-link" href="/Mes-listes-de-souhaits">
                                                      Ma liste de souhaits
                                                    </a>
                                                </li>

                                                <li class="menu__item">
                                                    <!-- This is a synthetic element that allows to adjust the vertical offset of the submenu using CSS. -->
                                                    <div class="menu__item-submenu-offset"></div>
                                                    <a class="menu__item-link" href="/Passage-de-colis">
                                                       Envoyer un colis
                                                    </a>
                                                </li>

                                                <li class="menu__item">
                                                    <!-- This is a synthetic element that allows to adjust the vertical offset of the submenu using CSS. -->
                                                    <div class="menu__item-submenu-offset"></div>
                                                    <a class="menu__item-link" href="/Notifications">
                                                       Notifications
                                                    </a>
                                                </li>
                                                <li class="menu__item">
                                                    <!-- This is a synthetic element that allows to adjust the vertical offset of the submenu using CSS. -->
                                                    <div class="menu__item-submenu-offset"></div>
                                                    <a class="menu__item-link" href="/Factures">
                                                        Factures
                                                    </a>
                                                </li>
                                                <li class="menu__item">
                                                    <!-- This is a synthetic element that allows to adjust the vertical offset of the submenu using CSS. -->
                                                    <div class="menu__item-submenu-offset"></div>
                                                    <a id="supprimer_mon_compte" class="menu__item-link" href="#" onclick='return false;'>
                                                        Supprimer mon compte
                                                    </a>
                                                </li>
                                                <li class="menu__item">
                                                    <!-- This is a synthetic element that allows to adjust the vertical offset of the submenu using CSS. -->
                                                    <div class="menu__item-submenu-offset"></div>
                                                    <a id='Deconnexion' class="menu__item-link" href="#" onclick='return false;' >
                                                        Déconnexion
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- .menu / end -->
                                    </div>
                                </div>
                            </div>

				<?php
				}else{
				?>

                           	 <div class="topbar__item">
                                    	<button onclick="return false;" class="pxp-header-user btn btn-info" type="button" style="padding: 3px; font-size: 12px; height: 30px; margin-top: 1px; margin-right: 5px;" > Connexion </button>
                            	</div>
                           	 <div class="topbar__item">
                                    	<button onclick="return false;" class="pxp-header-inscription btn btn-primary" type="button" style="padding: 3px; font-size: 12px; height: 30px; margin-top: 1px;" > Inscription </button>
                            	</div>

				<?php
				}
				?>

                        </div>
                    </div>
                </div>
                <!-- .topbar / end -->