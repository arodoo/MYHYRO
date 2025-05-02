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
 * \*****************************************************/

?>
<script>
    $(document).ready(function () {
        var sw = document.getElementById('customSwitch1');
        let facturation = document.getElementById('facturation');
        if (!sw.checked) {
            facturation.classList.toggle('d-none');
        }
    });

    function handleChange() {
        let facturation = document.getElementById('facturation');
        facturation.classList.toggle('d-none');
    }
</script>

<?php
    $req_select = $bdd->prepare("SELECT configurations_abonnements.nom_abonnement FROM membres INNER JOIN configurations_abonnements ON membres.Abonnement_id = configurations_abonnements.id WHERE membres.id = ?");
    $req_select->execute(array($id_oo));
    $ligne_select = $req_select->fetch();
    $req_select->closeCursor();
    $abonnement_premium = false;
    if($ligne_select['nom_abonnement'] == "Hyro Premium") {
        $abonnement_premium = true;
    }

?>

<div class="row">

    <?php
    include('panel/menu.php');
    ?>

    <div class="col-12 col-lg-9 mt-4 mt-lg-0">

        <?php
        include('panel/include-messages.php');
        ?>

        <div class="card">

            <div class="card-header">
                <h5>Mon compte</h5>
            </div>
            <div class="card-divider"></div>
            <div class="card-body">

                <?php

                /////////Variable * => ok si inscription
                if ($modif != "oui") {
                    $inscription_ok = "*";
                } else {
                    $inscription_ok = "";
                }
                /////////Variable * => ok si inscription

                ?>

                <div style='clear: both; margin-bottom: 15px;'></div>

                <div style='clear: both;'></div>

                <div class="alert alert-warning"><span class="uk-icon-user"></span> <b>Dernière connexion</b>
                    le, <?php echo date('d/m/Y à H:i', $last_login); ?> </div>


                <div style='clear: both; margin-bottom: 15px;'></div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">


                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label"><?php echo "N°client $inscription_ok"; ?></label>
                                            <div class="col-sm-5 style_color">
                                                <?php
                                                if ($statut_compte_oo == 1) {
                                                    ?>
                                                    <b><?php echo "$numero_client"; ?></b>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <b><?php echo "$numero_client"; ?></b>
                                                    <?php
                                                }
                                                ?>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label"></label>
                                            <div class="col-sm-5 style_color">
                                            </div>

                                        </div>
                                    </div>


                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label"><?php echo "Adresse mail $inscription_ok"; ?>
                                                *</label>
                                            <input type="text" id='Mail' name='Mail' class="form-control" placeholder=""
                                                   autocomplete="off" value="<?php echo "$Mail"; ?>"
                                                   style='<?php echo "$coloorm"; ?> margin-bottom: 0px;'/>

                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label"><?php echo "Code sécurite paiement mobile $inscription_ok"; ?></label>
                                            <input type="text" id='Code_securite' name='Code_securite'
                                                   class="form-control" placeholder="Maximum 6 caractères" maxlength="6"
                                                   autocomplete="off" value="<?php echo "$Code_securite"; ?>"
                                                   style='<?php echo "$coloorm"; ?> margin-bottom: 0px;'/>

                                        </div>
                                    </div>

                                    <!-- <div class="col-md-6 col-sm-6">
						<div class="form-group">
							<label class="control-label"><?php echo "Mot de passe actuel $inscription_ok"; ?>*</label>
							<input type="password" id='password_actuel' name='password_actuel' class="form-control" id="password_actuel" placeholder="<?php echo "Mot de passe"; ?>" value="<?php echo "$passwordclient"; ?>" style='<?php echo "$coloorppasse"; ?> margin-bottom: 15px;'/>
							
						</div>
					</div>
					
				</div>
				<div class="row">
					<div class="col-md-6 col-sm-6">
						
						<div class="form-group">
							<label class="control-label"><?php echo "Nouveau mot de passe $inscription_ok"; ?></label>
							<input type="password" id='password' name='password' class="form-control" id="passwordclient" placeholder="<?php echo "Mot de passe"; ?>" value="<?php echo "$passwordclient"; ?>" style='<?php echo "$coloorppasse"; ?>'/>
							
						</div>
						<div id="rappot_mot_de_passe_nouveau" class="alert alert-warning" role="alert" style="margin-bottom: 10px; display: none;" >
							<span class="uk-icon-exclamation-circle"></span>
								<b>Mot de passe</b>
									: Alphanumérique, 8 caractères avec miniscules et majuscules. Ex : Ni7Co1As
						</div>
					</div>
					
					<div class="col-md-6 col-sm-6">
						<div class="form-group">
							<label class="control-label">&nbsp; </label>
							<input type="password" id='passwordclient2' name='passwordclient2' class="form-control" id="passwordclient2" placeholder="<?php echo "Confirmer mot de passe"; ?>" value="<?php echo "$passwordclient2"; ?>" style='<?php echo "$coloorppasse"; ?> '/>
							
						</div>
					</div> -->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div style='clear: both; margin-bottom: 15px;'></div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xm-12">
                        <div class="card">
                            <div class="card-header">
                                <div style='text-align: left;'>
                                    <h2 class="style_color">Mes coordonnées</h2>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label"><?php echo "Civilité"; ?> *</label>
                                            <select id="FH" name="FH" class="form-control"
                                                    style='margin-bottom: 15px; <?php echo "$coloorpr"; ?>'>
                                                <option <?php if ($civilites_oo == "Madame") {
                                                    echo "selected";
                                                } ?> value="Madame">Madame
                                                </option>
                                                <option <?php if ($civilites_oo == "Monsieur") {
                                                    echo "selected";
                                                } ?> value="Monsieur">Monsieur
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label"><?php echo "Date de naissance"; ?> <?php if ($abonnement_premium) { echo '*';} ?></label>
                                            <input type="date" id='datenaissance' name='datenaissance'
                                                   class="form-control"
                                                   placeholder="<?php echo "Date de naissance"; ?>"
                                                   value="<?php echo "$datenaissance"; ?>"
                                                   style='<?php echo "$coloorpaaa"; ?>'
                                                <?php if ($abonnement_premium) { echo 'required';} ?>
                                            />
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label"><?php echo "Nom"; ?> *</label>
                                            <input type="text" id='Nom' name='Nom' class="form-control" placeholder=""
                                                   value="<?php echo "$Nom"; ?>"
                                                   style='margin-bottom: 15px; <?php echo "$coloorn"; ?>'/>
                                        </div>
                                    </div>


                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label"><?php echo "Prénom"; ?> *</label>
                                            <input id='Prenom' name='Prenom' type="text" class="form-control"
                                                   placeholder="" value="<?php echo "$Prenom"; ?>"
                                                   style='margin-bottom: 15px; <?php echo "$coloorpr"; ?>'/>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label"><?php echo "CSP"; ?> <?php if ($abonnement_premium) { echo '*';} ?></label>
                                            <select id="CSP" name="CSP" class="form-control" style='margin-bottom: 15px; <?php echo "$coloorpr"; ?>' <?php if ($abonnement_premium) { echo 'required';} ?>>
                                                <option <?php if ($CSP == "") {
                                                    echo "selected";
                                                } ?> value=""></option>
                                                <option <?php if ($CSP == "Elève") {
                                                    echo "selected";
                                                } ?> value="Elève">Elève
                                                </option>
                                                <option <?php if ($CSP == "Etudiant") {
                                                    echo "selected";
                                                } ?> value="Etudiant">Etudiant
                                                </option>
                                                <option <?php if ($CSP == "Salarié") {
                                                    echo "selected";
                                                } ?> value="Salarié">Salarié
                                                </option>
                                                <option <?php if ($CSP == "Sans activité") {
                                                    echo "selected";
                                                } ?> value="Sans activité">Sans activité
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-12">
                                        <hr>
                                        <h6 style="color:#FF9900">Adresse de livraison & facturation</h6>
                                    </div>

                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label" for="Pays"><?php echo "Pays"; ?>*</label>
                                            <select class="form-control" id="Pays" name="Pays" placeholder="*Pays"
                                                     style='<?php echo "$coloorc"; ?>'>
                                                <?php
                                                $req_pays = $bdd->query("SELECT * FROM pays ORDER BY pays ASC");
                                                while ($pays = $req_pays->fetch()) { ?>

                                                        <option value="<?= $pays["pays"] ?>" <?= $Pays_oo == $pays["pays"] ? 'selected' : '' ?>> <?= $pays["pays"] ?> </option>

                                                <?php }
                                                $req_pays->closeCursor(); ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group france">
                                            <label class="control-label"
                                                   for="Adresse"><?php echo "Adresse <span class='france' >(Et n°rue)</span>"; ?>
                                                *</label>
                                            <input type="text" id='Adresse' name='Adresse' class="form-control"
                                                   placeholder="<?php echo "Adresse"; ?>"
                                                   value="<?php echo "$Adresse"; ?>"
                                                   style='<?php echo "$coloorpaaa"; ?>'/>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-6 gabon">
                                        <div class="form-group">
                                            <label class="control-label"
                                                   for="Votre_quartier"><?php echo "Votre quartier"; ?>*</label>
                                            <input type="text" id='Votre_quartier' name='Votre_quartier'
                                                   class="form-control" placeholder="<?php echo "Votre quartier"; ?>"
                                                   value="<?php echo "$Votre_quartier"; ?>"
                                                   style='<?php echo "$coloorpaaa"; ?>'/>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-6 france">
                                        <div class="form-group">
                                            <label class="control-label" for="Code_postal">Code postal*</label>
                                            <input id='Code_postal' name='Code_postal' type="text" class="form-control"
                                                   placeholder="<?php echo "Code postal"; ?>"
                                                   value="<?php echo "$Code_postal"; ?>"
                                                   style='margin-bottom: 15px; <?php echo "$coloorpccc"; ?>'/>
                                        </div>
                                        <p style="color: red; display: none; font-weight: bold; background-color: white;"
                                           id="codePostalError">Le code postal doit contenir 5 chiffres</p>
                                    </div>

                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label" for="Ville">Ville*</label>
                                            <input type="text" class="form-control" placeholder="<?php echo "Ville"; ?>"
                                                   id='Ville' name='Ville' value="<?php echo "$Ville"; ?>"
                                                   style='margin-bottom: 15px; <?php echo "$coloorpvvv"; ?>'/>
                                        </div>
                                    </div>


                                    <div class="col-md-12 col-sm-12 gabon">
                                        <div class="form-group">
                                            <label class="control-label"><?php echo "Décrivez un peut plus chez vous"; ?></label>
                                            <textarea id='Decrivez_un_peut_plus_chez_vous'
                                                      name='Decrivez_un_peut_plus_chez_vous' class="form-control"
                                                      placeholder="<?php echo "Décrivez un peut plus chez vous"; ?>"
                                                      style='<?php echo "$coloorpaaa"; ?> height: 100px; width: 100%;'><?php echo "$Decrivez_un_peut_plus_chez_vous"; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-12 france">
                                        <div class="form-group">
                                            <label class="control-label"
                                                   for="Complement_d_adresse"><?php echo "Complément d'adresse"; ?></label>
                                            <textarea id='Complement_d_adresse' name='Complement_d_adresse'
                                                      class="form-control"
                                                      placeholder="<?php echo "Complément d'adresse"; ?>"
                                                      style='<?php echo "$coloorpaaa"; ?> height: 100px; width: 100%;;'/><?php echo "$Complement_d_adresse"; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-12">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="customSwitch1"
                                                   name="same_adresse" <?php if ($same_adresse == "oui") {
                                                echo "checked";
                                            } ?> onchange="handleChange()">
                                            <label class="custom-control-label" for="customSwitch1">Adresse de
                                                facturation différente</label>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-12" id="facturation">
                                        <div class="col-md-12 col-sm-12 px-0">
                                            <div class="form-group">
                                                <label class="control-label"
                                                       for="Adresse_fact"><?php echo "Adresse de facturation <span class='france' >(Et n°rue)</span>"; ?>
                                                    *</label>
                                                <input type="text" id='Adresse_fact' name='Adresse_facturation'
                                                       class="form-control" placeholder="<?php echo "Adresse"; ?>"
                                                       value="<?php echo "$Adresse_facturation_oo"; ?>"
                                                       style='<?php echo "$coloorpaaa"; ?>'/>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-sm-6 px-0 gabon">
                                            <div class="form-group">
                                                <label class="control-label"
                                                       for="Votre_quartier_fact"><?php echo "Votre quartier"; ?>
                                                    *</label>
                                                <input type="text" id='Votre_quartier_fact'
                                                       name='Votre_quartier_facturation' class="form-control"
                                                       placeholder="<?php echo "Votre quartier"; ?>"
                                                       value="<?php echo "$Votre_quartier_facturation_oo"; ?>"
                                                       style='<?php echo "$coloorpaaa"; ?>'/>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-sm-6 px-0 france">
                                            <div class="form-group">
                                                <label class="control-label" for="Code_postal_fact">Code postal*</label>
                                                <input id='Code_postal_fact' name='Code_postal_facturation' type="text"
                                                       class="form-control" placeholder="<?php echo "Code postal"; ?>"
                                                       value="<?php echo "$Code_postal_facturation_oo"; ?>"
                                                       style='margin-bottom: 15px; <?php echo "$coloorpccc"; ?>'/>
                                            </div>
                                            <p style="color: red; display: none; font-weight: bold; background-color: white;"
                                               id="codePostalError">Le code postal doit contenir 5 chiffres</p>
                                        </div>

                                        <div class="col-md-6 col-sm-6 px-0">
                                            <div class="form-group">
                                                <label class="control-label" for="Ville_fact">Ville*</label>
                                                <input type="text" class="form-control"
                                                       placeholder="<?php echo "Ville"; ?>" id='Ville_fact'
                                                       name='Ville_facturation'
                                                       value="<?php echo "$Ville_facturation_oo"; ?>"
                                                       style='margin-bottom: 15px; <?php echo "$coloorpvvv"; ?>'/>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-sm-6 px-0">
                                            <div class="form-group">
                                                <label class="control-label" for="Pays_fact"><?php echo "Pays"; ?>
                                                    *</label>
                                                <select class="form-control" id="Pays_fact" name="Pays_facturation"
                                                        placeholder="*Pays" value="FR"
                                                        style='<?php echo "$coloorc"; ?>'>
                                                    <?php
                                                    $req_pays = $bdd->query("SELECT * FROM pays ORDER BY pays ASC");
                                                    while ($pays = $req_pays->fetch()) { ?>
                                                        <?php if ($pays["sigle"] == "FR") { ?>
                                                            <option value="<?= $pays["pays"] ?>"
                                                                    selected='selected'> <?= $pays["pays"] ?> </option>
                                                        <?php } else { ?>
                                                            <option value="<?= $pays["pays"] ?>"> <?= $pays["pays"] ?> </option>
                                                        <?php } ?>
                                                    <?php }
                                                    $req_pays->closeCursor(); ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 gabon px-0">
                                            <div class="form-group">
                                                <label class="control-label"
                                                       for="Decrivez_un_peut_plus_chez_vous_fact"><?php echo "Décrivez un peut plus chez vous"; ?></label>
                                                <textarea id='Decrivez_un_peut_plus_chez_vous_fact'
                                                          name='Decrivez_un_peut_plus_chez_vous_facturation'
                                                          class="form-control"
                                                          placeholder="<?php echo "Décrivez un peut plus chez vous"; ?>"
                                                          style='<?php echo "$coloorpaaa"; ?> height: 100px; width: 100%;;'/><?php echo "$Decrivez_un_peut_plus_chez_vous_facturation_oo"; ?></textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 france px-0">
                                            <div class="form-group">
                                                <label class="control-label"
                                                       for="Complement_d_adresse_fact"><?php echo "Complément d'adresse"; ?></label>
                                                <textarea id='Complement_d_adresse_fact'
                                                          name='Complement_d_adresse_facturation' class="form-control"
                                                          placeholder="<?php echo "Complément d'adresse"; ?>"
                                                          style='<?php echo "$coloorpaaa"; ?> height: 100px; width: 100%;;'/><?php echo "$Complement_d_adresse_facturation_oo"; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div style='clear: both; margin-bottom: 15px;'></div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xm-12">
                        <div class="card">
                            <div class="card-header">
                                <div style='text-align: left;'>
                                    <h2 class="style_color"><?php echo "Coordonnées de contact"; ?></h2>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 france" id="tel_fixe_france">
                                        <div class="form-group">
                                            <label>Téléphone fixe</label>
                                            <input type="text" id='Telephone' name='Telephone' class="form-control"
                                                   placeholder="<?php echo "Téléphone"; ?>"
                                                   value="<?php echo "$Telephone"; ?>"
                                                   style='<?php echo "$coloorpccc1telfixe"; ?>'/>
                                        </div>
                                    </div>



                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Téléphone portable</label>
                                            <input type="text" id='Telephone_portable' name='Telephone_portable'
                                                   class="form-control" placeholder="<?php echo "Portable"; ?> *"
                                                   value="<?php echo "$Telephone_portable"; ?>"
                                                   style='<?php echo "$coloorpccc1portable"; ?> height: 35px;'/>
                                        </div>
                                        <p style="color: red; display: none; font-weight: bold; background-color: white;"
                                           id="telPortError">Le telephone portable doit contenir 10 chiffres</p>
                                    </div>

                                    <div class="col-sm-12 gabon" id="tel_mobile_gabon">
                                        <div class="form-group">
                                            <label for="Telephone_portable_gab">Téléphone portable (facultatif)</label>
                                            <input type="text" id='Telephone_portable_gab' name='Telephone_portable_gab'
                                                   class="form-control" placeholder=""
                                                   value=""
                                                   style='<?php echo "$coloorpccc1portable"; ?> height: 35px;'/>
                                        </div>
                                        <p style="color: red; display: none; font-weight: bold; background-color: white;"
                                           id="telPortError">Le telephone portable doit contenir 10 chiffres</p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    /*
                    if ($statut_compte_oo == 2) {
                    ?>

                        <div class="col-md-6 col-sm-6 col-xm-6">
                            <div class="card" style="">
                                <div class="card-header">
                                    <div style='text-align: left;'>
                                        <h2 class="style_color"><?php echo "Informations"; ?></h2>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Nom société</label>
                                                <input type="text" id='Nom_societe' name='Nom_societe' class="form-control" placeholder="<?php echo "Nom société"; ?>*" value="<?php echo "$Nom_societe"; ?>" style='<?php echo "$coloorpccc1telfixe"; ?>' />
                                            </div>

                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Siret</label>
                                                <input type="text" id='Numero_identification' name='Numero_identification' class="form-control" placeholder="<?php echo "Siret"; ?> *" value="<?php echo "$Numero_identification"; ?>"  style='<?php echo "$coloorpccc1portable"; ?>yy'/>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php
                    }
                    */
                    ?>

                </div>

                <div style='clear: both; margin-bottom: 15px;'></div>


                <?php
                if ($modif != "oui") {
                    ?>
                    <div class="form-group style_color">
                        <label class="control-label col-sm-6"></label>
                        <div class="col-sm-10">
                            <div class="checkbox">
                                <label> <input id='cbb' name='cbb' type="checkbox" checked="checked"
                                               value='1'/><?php echo "Je m'inscris à la newsletter"; ?></label>
                            </div>
                        </div>
                    </div>
                    <?php
                }

                //////////////////////////////////////SI LES CONDITIONS GENERALES EXISTES
                if (!empty($lien_conditions_generales_compte)) {
                    ?>
                    <div style="clear: both;"></div>
                    <div class="form-group">
                        <div class="col-sm-12" style="margin-bottom: 15px;">
                            <?php echo "$lien_conditions_generales_compte"; ?></a>
                        </div>
                    </div>
                    <?php
                }
                ?>

                <div class="form-group">
                    <div class="col-sm-12">
                        <b style="font-weight : normal;">"Les données collectées par la plateforme sont nécessaires pour
                            compléter votre profil. Vous disposez d'un droit d'accès, de rectification, d'opposition, de
                            limitation du traitement, de suppression, de portabilité.
                            Pour plus d'informations consultez notre <a href="/Traitements-de-mes-donnees"
                                                                        target="_blank" style="color: orange;">politique
                                de confidentialité</a>
                            "</b>
                    </div>
                </div>


                <div class="form-group style_color">
                    <label class="control-label col-sm-6"></label>
                    <div class="col-sm-10">
                        <small><?php echo "P.S : Tous les champs précédés d'une étoile (*) doivent être obligatoirement remplis."; ?></small>
                    </div>
                </div>

                <div style="clear: both;"></div>

                <div class="form-group" style="margin-top: 15px;">
                    <div class="col-sm-12" style="text-align: center;">
                        <?php
                        if ($modif != "oui") {
                            ?>
                            <button type='button' id='creation_post' class='btn btn-primary'
                                    style='color : white !important; text-align: center; display: inline-block;'
                                    onclick="return false;">ENREGISTRER
                            </button>
                            <?php
                        } else {
                            ?>
                            <button type='button' id='modification_post' class='btn btn-primary'
                                    style='color : white !important; text-align: center; display: inline-block;'
                                    onclick="return false;">ENREGISTRER
                            </button>
                            <?php
                        }
                        ?>
                    </div>
                </div>

            </div>

        </div>

    </div>


</div>




<!--<script>
    function handleChange() {
        let selectedCountry = document.getElementById("Pays").value;
        const telFixeFranceField = document.getElementById("tel_fixe_france");
        const telMobileGabonField = document.getElementById("tel_mobile_gabon");

        if (selectedCountry === "Gabon") {
            telMobileGabonField.style.display = "block";
            telFixeFranceField.style.display = "none";

        } else {
            telMobileGabonField.style.display = "none";
            telFixeFranceField.style.display = "block";
        }
    }

    window.onload = handleChange;

    document.getElementById("Pays").addEventListener("change", handleChange);
</script>

-->