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

if(isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 1 ||
isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 2 ||
isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 3 ){

$idaction = $_GET['idaction'];
$action = $_GET['action'];

?>

<script>
$(document).ready(function (){

  //AJAX SOUMISSION DU FORMULAIRE - MODIFIER - AJOUTER
  $(document).on("click", "#btn_configurations_livraisons_gabon", function (){
        $.post({
          url : '/administration/Modules/configurations_livraisons_gabon/configurations_livraisons_gabon_modifier ajax.php',
          type : 'POST',
          <?php if($_GET['action'] == "Modifier" ){ ?> 
          data: new FormData($("#formulaire_modifier_configurations_livraisons_gabon")[0]),
          <?php }else{ ?> 
          data: new FormData($("#formulaire_modifier_configurations_livraisons_gabon")[0]),
          <?php } ?> 
          processData: false,
          contentType: false,
          dataType: "json",
          success: function (res) {
            if(res.retour_validation == "ok"){
              console.log(res.Texte_rapport);
              popup_alert(res.Texte_rapport,"green filledlight","#009900","uk-icon-check");
              <?php if($_GET['action'] != "Modifier" ){ ?> 
              $("#configurations_livraisons_gabon")[0].reset();
              <?php } ?> 
            }else{
              popup_alert(res.Texte_rapport,"#CC0000 filledlight","#CC0000","uk-icon-times");
            }
          },
          error: function (xhtml, error, code) {
            console.log(xhtml.responseText);
          }
        });
       listelivraisons();
  });

 //FUNCTION AJAX 
  function listelivraisons(){
    $.post({
      url : '/administration/Modules/configurations_livraisons_gabon/configurations_livraisons_gabon_liste_ajax.php',
      type : 'POST',
      dataType: "html",
      success: function (res) {
        $("#listelivraisons").html(res);
      }
    });
  }
  listelivraisons();

 });
</script>

<?php 

$action = $_GET['action'];
$idaction = $_GET['idaction'];
?>

<ol class="breadcrumb">
  <li><a href="<?php echo $http; ?><?php echo $nomsiteweb; ?>">Accueil</a></li>
  <li><a href="<?php echo $mode_back_lien_interne; ?>">Administration</a></li>
   <li><a href="<?php echo $addm; ?>">Ajouter une livraison</a></li>
  <?php if(empty($_GET['action'])){ ?> <li class="active">Configuration des livraisons</li> <?php }else{ ?> <li><a href="?page=configurations_livraisons_gabon">Références des livraisons</a></li> <?php } ?>
  <?php if($_GET['action'] == "modifier" ){ ?> <li class="active">Modifications</li> <?php } ?>
  <?php if($_GET['action'] == "addm" ){ ?> <li class="active">Ajouter</li> <?php } ?>
  <?php if($_GET['action'] == "Graphique" ){ ?> <li class="active">Graphique</li> <?php } ?>
</ol>

<?php
echo "<div id='bloctitre' style='text-align: left;'><h1>Configuration des livraisons</h1></div><br />
<div style='clear: both;'></div>";

////////////////////Boutton administration
echo "<a href='".$mode_back_lien_interne."'><button type='button' class='btn btn-default' style='margin-right: 5px;' ><span class='uk-icon-file-text'></span> Administration</button></a>";
if(isset($_GET['action'])){
echo "<a href='?page=configurations_livraisons_gabon'><button type='button' class='btn btn-success' style='margin-right: 5px;' ><span class='uk-icon-file-text'></span> Liste des livraisons</button></a>";
}
if($action != "ajouter"){
echo "<a href='?page=configurations_livraisons_gabon&action=Ajouter'><button type='button' class='btn btn-success' style='margin-right: 5px;' ><span class='uk-icon-plus-circle'></span> Ajouter une livraison</button></a>";
}
if(!empty($action)){
echo "<a href='?page=configurations_livraisons_gabon'><button type='button' class='btn btn-success' style='margin-right: 5px;' ><span class='uk-icon-file-text'></span> Configuration des livraisons</button></a>";
}
echo "<div style='clear: both;'></div><br />";
////////////////////Boutton administration
?>

<div style='padding: 5px; text-align: center;'>


<?php
////////////////////////////////////////////////////////////////////////////////////////////FORMULAIRE AJOUTER - MODIFIER
if($action == "Ajouter" || $action == "Modifier"){

if($action == "Modifier"){
  $req_select = $bdd->prepare("SELECT * FROM configurations_livraisons_gabon WHERE id=?");
  $req_select->execute(array($idaction));
  $ligne_select = $req_select->fetch();
  $req_select->closeCursor();
  $idd = $ligne_select['id']; 
  $nom_livraison = $ligne_select['nom_livraison'];
  $ville_livraison = $ligne_select['ville_livraison'];
  $commentaire_livraison = $ligne_select['commentaire_livraison'];
  $activer = $ligne_select['activer'];

?>

<form id='formulaire_modifier_configurations_livraisons_gabon' method='post' action='#'>
  <input name="idaction" class="form-control" type="hidden" value="<?php echo "$idaction"; ?>" style='width: 100%;'/>
  <input name="action" class="form-control" type="hidden" value="<?php echo "Modifier-action"; ?>" style='width: 100%;'/>
 
  <div style='text-align: center; max-width: 700px; margin-right: auto; margin-left: auto;'>
  <div style='text-align: left;'>
    <h2>Configurer la livraison</h2><br /><br />
  </div>
<?php
 $icon1 = $_FILES['image']['name'];
        //////////////////////////////////////POST ACTION UPLOAD 1
        if (!empty($icon1))
        {
            if (!empty($icon1) && substr($icon1, -4) == "jpeg" || !empty($icon1) && substr($icon1, -3) == "jpg" || !empty($icon1) && substr($icon1, -3) == "JPEG" || !empty($icon1) && substr($icon1, -3) == "JPG" || !empty($icon1) && substr($icon1, -3) == "png" || !empty($icon1) && substr($icon1, -3) == "PNG" || !empty($icon1) && substr($icon1, -3) == "gif" || !empty($icon1) && substr($icon1, -3) == "GIF")
            {
                $image_a_uploader = $_FILES['image']['name'];
                $icon = $_FILES['image']['name'];
                $taille = $_FILES['image']['size'];
                $tmp = $_FILES['image']['tmp_name'];
                $type = $_FILES['image']['type'];
                $erreur = $_FILES['image']['error'];
                $source_file = $_FILES['image']['tmp_name'];
                $destination_file = "../../../images/categories/" . $icon . "";

                ////////////Upload des images
                if (move_uploaded_file($tmp, $destination_file))
                {
                    $namebrut = explode('.', $image_a_uploader);
                    $namebruto = $namebrut[0];
                    $namebruto_extansion = $namebrut[1];
                    $nouveaucontenu = "$namebruto";
                    include ('../../../function/cara_replace.php');
                    $namebruto = "$nouveaucontenu";
                    $nouveau_nom_fichier = "" . $namebruto . "-" . $now . ".$namebruto_extansion";
                    rename("../../../images/categories/$icon", "../../../images/categories/$nouveau_nom_fichier");
			$image_ok = "ok";
                }
                ////////////Upload des images
                
            }
            elseif (!empty($icon1))
            {
                $tous_les_fichiers_non_pas_l_extension = "oui";
            }
        }
?>

<?php
}elseif($action == "Ajouter"){ ?>
<form id='formulaire_modifier_configuration_reference_produit' method='post' action='#'>
  <input name="idaction" class="form-control" type="hidden" value="<?php echo "$idaction"; ?>" style='width: 100%;'/>
  <input name="action" class="form-control" type="hidden" value="Ajouter-action" style='width: 100%;'/>

  <div style='text-align: center; max-width: 700px; margin-right: auto; margin-left: auto;'>
  <div style='text-align: left;'>
    <h2>Ajouter une livraison</h2><br /><br />
  </div>
<?php } ?>

<div class="well well-sm" style="width: 100%; text-align: left;">
<table style='text-align: center; width: 100%;' cellpadding='2' cellspacing='2' >

    <tr><td style='text-align: left; min-width: 120px;'>Nom</td>
    <td style='text-align: left;'>
     <input type='text' name="nom_livraison" class="form-control" value="<?php echo "$nom_livraison"; ?>" style='width: 100%;' />
    </td></tr>
  <tr><td>&nbsp;</td></tr>

    <tr><td style='text-align: left; min-width: 120px;'>Ville</td>
    <td style='text-align: left;'>
    <input name="ville_livraison" class="form-control" type="text" id="ville_livraison" value="<?php echo "$Ville"; ?>" style='width: 100%; min-width: 200px;' required />
    </td></tr>
  <tr><td>&nbsp;</td></tr>

    <tr><td style='text-align: left; min-width: 120px;'>Commentaire</td>
    <td style='text-align: left;'>
    <textarea name="commentaire_livraison" class="form-control" id="commentaire_livraison" style='width: 100%; min-width: 200px;' required /><?php echo "$commentaire_livraison"; ?></textarea>
    </td></tr>
  <tr><td>&nbsp;</td></tr>

<tr>
  <td style='text-align: left; width: 150px; font-weight: bold;'>Activer</td>
  <td style='text-align: left;'>
					<select name="activer" id="activer" class="form-control">
						<option <?php if($activer == "oui"){ echo "selected"; } ?> value="oui"> <?php echo "Oui"; ?></option>
						<option <?php if($activer == "Non"){ echo "selected"; } ?> value="Non"> <?php echo "Non"; ?></option>
					</select>
  </td></tr>
  <tr><td>&nbsp;</td></tr>

  </table>
  </div>

  <br />
  <button id='btn_configurations_livraisons_gabon' type='button' class='btn btn-success' onclick="return false;" style='width: 150px;' >ENREGISTRER</button>

</form>

<?php
} 
if(!isset($action)){
?>

<div id='listelivraisons' style='clear: both;'></div>

<?php
} 
echo "</div>";
}else{
header('location: /index.html');
}
?>
