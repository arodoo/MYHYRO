<fieldset class="col-md-6 ubos">
    <legend>UBO <?= $key+1 ?></legend>
    <input type="hidden" name="ubo[<?= $key ?>][token]" value="<?= $userUbo->Id ?>"/>
    <hr size="30">
    <!-- firstname - lastname -->
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="formUboFirstName">Prénom</label>
            <input required type="text" class="form-control" id="formUboFirstName" name="ubo[<?= $key ?>][FirstName]" value="<?= $userUbo->FirstName ?>" placeholder="John" style="border: 1px solid #ccc;">
        </div>
        <div class="form-group col-md-6">
            <label for="formUboLastName">Nom</label>
            <input required type="text" class="form-control" id="formUboLastName" name="ubo[<?= $key ?>][LastName]" value="<?= $userUbo->LastName ?>" placeholder="Snow" style="border: 1px solid #ccc;">
        </div>
    </div>

    <!-- Adresse -->
    <div class="form-row">
        <hr size="30">
        <!-- Adresse line 1 -->
        <div class="form-group col-md-6">
            <label for="formUboAddressLine1">Addresse ligne 1</label>
            <input required type="text" class="form-control" id="formUboAddressLine1" name="ubo[<?= $key ?>][Address][AddressLine1]" value="<?= $userUbo->Address->AddressLine1 ?>" placeholder="exemple : 1 Mangopay Street" style="border: 1px solid #ccc;">
        </div>

        <!-- Adresse line 2 -->
        <div class="form-group col-md-6">
            <label for="formUboAddressLine2">Addresse ligne 2</label>
            <input required type="text" class="form-control" id="formUboAddressLine2" name="ubo[<?= $key ?>][Address][AddressLine2]" value="<?= $userUbo->Address->AddressLine2 ?>" placeholder="exemple : The loop" style="border: 1px solid #ccc;">
        </div>

        <!-- city -->
        <div class="form-group col-md-6">
            <label for="formUboVille">Ville</label>
            <input required type="text" class="form-control" id="formUboVille" name="ubo[<?= $key ?>][Address][City]" value="<?= $userUbo->Address->City ?>" placeholder="exemple : Paris" style="border: 1px solid #ccc;">
        </div>

        <!-- region -->
        <div class="form-group col-md-6">
            <label for="formUboRegion">Région</label>
            <input required type="text" class="form-control" id="formUboRegion" name="ubo[<?= $key ?>][Address][Region]" value="<?= $userUbo->Address->Region ?>" placeholder="exemple : Ile de France" style="border: 1px solid #ccc;">
        </div>

        <!-- postalcode -->
        <div class="form-group col-md-6">
            <label for="formUboVille">Code postal</label>
            <input required type="text" class="form-control" id="formUboVille" name="ubo[<?= $key ?>][Address][PostalCode]" value="<?= $userUbo->Address->PostalCode ?>" placeholder="exemple : 750101" style="border: 1px solid #ccc;">
        </div>

        <!-- country code -->
        <div class="form-group col-md-3">
            <label for="formUboCountryCode">Pays</label>
            <select required id="formUboCountryCode" class="form-control" name="ubo[<?= $key ?>][Address][CountryCode]">
                <?php 
                foreach($countryCodeAPIJson as $code)
                {
                    ?>
                    <option <?php if($code->alpha2Code == $userUbo->Address->Country){ echo 'selected'; } ?> value="<?= $code->alpha2Code ?>"><?= $code->name ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
    </div>

    <!-- nationality -->
    <div class="form-group col-md-3">
        <label for="formUboNationality">Nationalité</label>
        <select required id="formUboNationality" class="form-control" name="ubo[<?= $key ?>][Nationality]">
            <?php
            foreach($countryCodeAPIJson as $code)
            {
                ?>
                <option <?php if($code->alpha2Code == $userUbo->Nationality){ echo 'selected'; } ?> value="<?= $code->alpha2Code ?>"><?= $code->name ?></option>
                <?php
            }
            ?>
        </select>
    </div>

    <hr size="30">
    <!-- birthplace -->
    <div class="form-row">
        
        <!-- birthplacecity -->
        <div class="form-group">
            <div class="form-group col-md-6">
                <label for="formUboBirthplaceCity">Lieu de naissance</label>
                <input required type="text" class="form-control" id="formUboBirthplaceCity" value="<?= $userUbo->Birthplace->City ?>" name="ubo[<?= $key ?>][Birthplace][City]" style="border: 1px solid #ccc;">
            </div>
        </div>

        <?php 
        $now        = new DateTime('NOW');
        $birthdate  = new DateTime();
        $birthdate->setTimestamp($userUbo->Birthday);
        ?>

        <!-- birthday -->
        <div class="form-group"> <!-- (timestamp 00h - 23h) -->
            <div class="form-group col-md-3">
                <label for="formUboBirthday">Date de naissance</label>
                <div class="form-row">
                    <!-- Jour -->
                    <div class="form-group">
                        <select required id="BirthdayDay<?= $key ?>" name="ubo[<?= $key ?>][Birthday][Day]" class="col-md-4 form-control">
                            <?php 
                            for($i=1;$i<=31;$i++)
                            {
                                ?>
                                <option
                                    <?php
                                    if($i==$birthdate->format('d'))
                                    {
                                        echo 'selected ';
                                    }
                                    ?>
                                    value="<?= $i ?>"
                                >
                                    <?= $i ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <!-- Mois -->
                    <div class="form-group">
                        <select required id="BirthdayMonth<?= $key ?>" name="ubo[<?= $key ?>][Birthday][Month]" class="col-md-4 form-control">
                            <?php 
                            $months = [
                                'Janvier', 
                                'Février',
                                'Mars',
                                'Avril',
                                'Mai',
                                'Juin',
                                'Juillet',
                                'Août',
                                'Septembre',
                                'Octobre',
                                'Novembre',
                                'Décembre'];
                            foreach($months as $keyMonth => $month)
                            {
                                $keyMonth++;
                                ?>
                                <option 
                                    <?php 
                                    if($keyMonth == $birthdate->format('m'))
                                    {
                                        echo 'selected ';
                                    }
                                    ?> 
                                    value="<?= $keyMonth ?>">
                                    <?= $month ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <!-- Année -->
                    <div class="form-group">
                        <select required id="BirthdayYear<?= $key ?>" name="ubo[<?= $key ?>][Birthday][Year]"  class="col-md-4 form-control">
                            <?php 
                            for($i=0;$i<100;$i++)
                            {
                                ?>
                                <option 
                                    <?php 
                                    if($birthdate->format('Y') == $now->format('Y'))
                                    { 
                                        echo 'selected '; 
                                    } 
                                    ?> 
                                    value="<?= $now->format('Y') ?>">
                                        <?= $now->format('Y') ?>
                                </option>
                                <?php
                                $now->modify('-1 year');
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <script>
                    $(document).ready(function() {
                        let day<?= $key ?>     = $('#BirthdayDay<?= $key ?>')
                        let month<?= $key ?>   = $('#BirthdayMonth<?= $key ?>')
                        let year<?= $key ?>    = $('#BirthdayYear<?= $key ?>')

                        day<?= $key ?>.change(function() {
                        	verifDate(day<?= $key ?>, month<?= $key ?>, year<?= $key ?>)
                        })
                        month<?= $key ?>.change(function() {
                        	verifDate(day<?= $key ?>, month<?= $key ?>, year<?= $key ?>)
                        })
                        year<?= $key ?>.change(function() {
                        	verifDate(day<?= $key ?>, month<?= $key ?>, year<?= $key ?>)
                        })

                        verifDate(day<?= $key ?>, month<?= $key ?>, year<?= $key ?>)
                    })

                </script>
            </div>
        </div>

        <!-- birthplacecountry -->
        <div class="form-group">
            <div class="form-group col-md-3">
                <label for="formUboBirthplaceCountry">Pays de naissance</label>
                <select id="formUboBirthplaceCountry" class="form-control" name="ubo[<?= $key ?>][Birthplace][Country]">
                    <?php
                    foreach($countryCodeAPIJson as $code)
                    {
                        ?>
                        <option <?php if($code->alpha2Code == $userUbo->Birthplace->Country){ echo 'selected'; } ?> value="<?= $code->alpha2Code ?>"><?= $code->name ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>

    </div>
</fieldset>