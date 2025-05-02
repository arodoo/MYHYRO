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

if(isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 1){

?>

<script>
$(document).ready(function (){

  //AJAX SOUMISSION DU FORMULAIRE
  $(document).on("click", "#bouton_formulaire_informations", function (){
    $.post({
      url : '/administration/Configurations/Configurations-informations/informations-ajax.php',
      type : 'POST',
      data: new FormData($("#formulaire_informations")[0]),
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (res) {
        if(res.retour_validation == "ok"){
          popup_alert(res.Texte_rapport,"green filledlight","#009900","uk-icon-check");
        }else{
          popup_alert(res.Texte_rapport,"#CC0000 filledlight","#CC0000","uk-icon-times");
        }
      },
      error: function(xhtml, error, code){
        console.log(error + " | " + code + " | ")
      }
    });
  });

});

</script>

<?php

?>

<ol class="breadcrumb">
  <li><a href="<?php echo $http; ?><?php echo $nomsiteweb; ?>">Accueil</a></li>
  <li><a href="<?php echo $mode_back_lien_interne; ?>">Administration</a></li>
  <?php if(empty($_GET['action'])){ ?> <li class="active">Gestion des informations</li> <?php }else{ ?> <li><a href="?page=Informations">Gestion des informations</a></li> <?php } ?>
</ol>

<?php

echo "<div id='bloctitre' style='text-align: left;'  ><h1>Gestion des informations | Page contact </h1></div><br />
<div style='clear: both;'></div>";

////////////////////Boutton administration
echo "<a href='".$mode_back_lien_interne."' style='float: left; text-decoration: none; margin-right: 5px;'><button type='button' class='btn btn-default' style='margin-right: 5px;' ><span class='uk-icon-cogs'></span> Administration</button></a>";
echo "<div style='clear: both;'></div><br />"; 
////////////////////Boutton administration

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM informations_structure WHERE id=1");
$req_select->execute(array($idaction));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$Nom_i = $ligne_select['Nom_i'];
$statut_entreprise_i = $ligne_select['statut_entreprise_i'];
$Siret_i = $ligne_select['Siret_i'];
$TVA_intra_i = $ligne_select['TVA_intra_i'];
$adresse_i = $ligne_select['adresse_i'];
$ville_i = $ligne_select['ville_i'];
$cp_dpt_i = $ligne_select['cp_dpt_i'];
$pays_i = $ligne_select['pays_i'];
$telephone_fixe_i = $ligne_select['telephone_fixe_i'];
$telephone_portable_i = $ligne_select['telephone_portable_i'];
$fax_i = $ligne_select['fax_i'];
$Skype_i = $ligne_select['Skype_i'];
$activer_carte_map_i = $ligne_select['activer_carte_map_i'];
$text_i = $ligne_select['text_i'];
$latitude_i = $ligne_select['latitude_i'];
$longitude_i = $ligne_select['longitude_i'];
$cle_api_google_i = $ligne_select['cle_api_google_map'];

if($activer_carte_map_i == "oui"){
  $selected1 = "selected='selected'";
}else{
  $selected2 = "selected='selected'";
}

?>

<form id="formulaire_informations" method="post" action="?page=Informations&amp;action=Modifier">

  <div style=' width: 100%; padding: 5px;' align='center'>

  <div align='left'>
  <h2>Modifier les informations | Coordonnées de contact </h2>
  </div><br />
  <div style='clear: both;'></div>

  <table style="text-align: left; width: 100%;" border="0" cellpadding="2" cellspacing="2"><tbody>

  <tr><td colspan="2" rowspan="1">&nbsp;</td></tr>

  <tr><td style="text-align: left; width: 190px;">Nom (structure ...)</td>
  <td style="text-align: left;"><input type='text' name='Nom_i_post' class='form-control' value="<?php echo "$Nom_i"; ?>" style='width: 50%;'/></td></tr>
  <tr><td colspan="2" rowspan="1">&nbsp;</td></tr>

  <tr><td style="text-align: left; width: 190px;">Statut </td>
  <td style="text-align: left;"><input type='text' name='statut_entreprise_i_post' class='form-control' value="<?php echo "$statut_entreprise_i"; ?>" style='width: 50%;'/></td></tr>
  <tr><td colspan="2" rowspan="1">&nbsp;</td></tr>

  <tr><td style="text-align: left; width: 190px;">Siret </td>
  <td style="text-align: left;"><input type='text' name='Siret_i_post' class='form-control' value="<?php echo "$Siret_i"; ?>" style='width: 50%;'/></td></tr>
  <tr><td colspan="2" rowspan="1">&nbsp;</td></tr>

  <tr><td style="text-align: left; width: 190px;">Numéro TVA </td>
  <td style="text-align: left;"><input type='text' name='TVA_intra_i_post' class='form-control' value="<?php echo "$TVA_intra_i"; ?>" style='width: 50%;'/></td></tr>
  <tr><td colspan="2" rowspan="1">&nbsp;</td></tr>
  <tr><td colspan="2" rowspan="1">&nbsp;</td></tr>

  <tr><td style="text-align: left; width: 190px;">Adresse</td>
  <td style="text-align: left;"><input type='text' name='adresse_i_post' class='form-control' value="<?php echo "$adresse_i"; ?>" style='width: 100%;'/></td></tr>
  <tr><td colspan="2" rowspan="1">&nbsp;</td></tr>

  <tr><td style="text-align: left; width: 190px;">Ville </td>
  <td style="text-align: left;"><input type='text' name='ville_i_post' class='form-control' value="<?php echo "$ville_i"; ?>" style='width: 100%;'/></td></tr>
  <tr><td colspan="2" rowspan="1">&nbsp;</td></tr>

  <tr><td style="text-align: left; width: 190px;">Code postal </td>
  <td style="text-align: left;"><input type='text' name='cp_dpt_i_post' class='form-control' value="<?php echo "$cp_dpt_i"; ?>" style='width: 100%;'/></td></tr>
  <tr><td colspan="2" rowspan="1">&nbsp;</td></tr>

  <tr><td style="text-align: left; width: 190px;">Pays </td>
  <td style="text-align: left;"><input type='text' name='pays_i_post' class='form-control' value="<?php echo "$pays_i"; ?>" style='width: 100%;'/></td></tr>
  <tr><td colspan="2" rowspan="1">&nbsp;</td></tr>
  <tr><td colspan="2" rowspan="1">&nbsp;</td></tr>

  <tr><td style="text-align: left; width: 190px;">Téléphone Gabon</td>
  <td style="text-align: left;"><input type='text' name='telephone_fixe_i_post' class='form-control' value="<?php echo "$telephone_fixe_i"; ?>" style='width: 100%;'/></td></tr>
  <tr><td colspan="2" rowspan="1">&nbsp;</td></tr>

  <tr><td style="text-align: left; width: 190px;">Téléphone France </td>
  <td style="text-align: left;"><input type='text' name='telephone_portable_i_post' class='form-control' value="<?php echo "$telephone_portable_i"; ?>" style='width: 100%;'/></td></tr>
  <tr><td colspan="2" rowspan="1">&nbsp;</td></tr>

  <tr><td style="text-align: left; width: 190px; vertical-align: top;">Texte complémentaire <br /> </td>
  <td style="text-align: left;"><textarea name='text_i_post' class='mceEditor' style='width: 100%; height: 190px;'><?php echo "$text_i"; ?></textarea>
  <br />Ce texte se placera sur votre page contact. Nous vous recommandons d'écrire une ligne ou deux maximum.
  </td></tr>
  <tr><td colspan="2" rowspan="1">&nbsp;</td></tr>

  <tr><td colspan="2" >&nbsp;</td></tr>
  <tr><td colspan="2"  style="text-align: center;">
  <button id='bouton_formulaire_informations' type='button' class='btn btn-success' onclick="return false;" >ENREGISTRER</button>
  </tr></td>

  </tbody></table>
  </div><br /><br />

</form>

<?php

}else{
  header('location: /index.html');
}
?>