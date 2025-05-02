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

if(!empty($_SESSION['4M8e7M5b1R2e8s']) && !empty($user)){
?>

    <div class="form-popup" style="margin-bottom: 20px;" >
        <div class="form-popup-content" >
            <h2>Télécharger une image pour votre avatar</h2>
            <hr />

            <form method='post' id='formulaire_image' action='/Photos/recadrage/upload' enctype='multipart/form-data' >
                <table style='width: 100%;' >

                    <tr>
                        <td style='text-align: left;'>
                            <?php
                            if (!empty($image_profil_oo))
                            {
                            ?>
                                <img src="/images/membres/<?php echo "$user"; ?>/<?php echo "$image_profil_oo"; ?>" alt="<?php echo "$image_profil_oo"; ?>" style='cursor: pointer; border-radius: 50%; margin-bottom: 20px;' />
                                <input type='file' name='images' id="images" style='width: 100%;'onchange="document.getElementById('formulaire_image').submit();" /><br />
                            <?php
                            }
                            else
                            {
                            ?>
                                <input type='file' name='images' id="images" style='width: 100%;' onchange="document.getElementById('formulaire_image').submit();" /><br />
                            <?php
                            }
                            ?>
                        </td>
                    </tr>

                </table>
                <p style="text-align: left;">Formats autorisés .jpg ou .png</p>
                <div class="alert alert-info" style="text-align: left;" >L'image sera récadreé en 100x100, on recommande de télécharger une image avec une dimension de 100px de largeur.<br /> Et de 100px de hauteur pour conserver une bonne définition.</div>

            </form>
        </div>
    </div>

<?php
}else{
header('location: /');

}
?>
