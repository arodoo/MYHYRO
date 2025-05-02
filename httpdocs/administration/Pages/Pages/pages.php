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
    isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 4 ){

      ?>
	  
 <style>

	.imageupload {
		margin: 20px 0;
	}
</style>

<script>
$(document).ready(function (){

	//AJAX SOUMISSION DU FORMULAIRE - MODIFIER - AJOUTER
	$(document).on("click", "#bouton-gestion-des-pages", function (){
	//ON SOUMET LE TEXTAREA TINYMCE
	tinyMCE.triggerSave();
	$.post({
	  url : '/administration/Pages/Pages/pages-action-ajouter-modification-ajax.php',
	  type : 'POST',
	  <?php if ($_GET['action'] == "modification" ){ ?>
		data: new FormData($("#formulaire-gestion-des-pages-modifier")[0]),
	  <?php }else{ ?>
		data: new FormData($("#formulaire-gestion-des-pages-ajouter")[0]),
	  <?php } ?>
	  processData: false,
	  contentType: false,
	  dataType: "json",
	  success: function (res) {
		if(res.retour_validation == "ok"){
		  popup_alert(res.Texte_rapport,"green filledlight","#009900","uk-icon-check");
		  <?php if ($_GET['action'] != "modification" ){ ?>
			$("#formulaire-gestion-des-pages-ajouter")[0].reset();
		  <?php } ?>
      $("#retour_statut_html").html(res.alert);
		}else{
		  popup_alert(res.Texte_rapport,"#CC0000 filledlight","#CC0000","uk-icon-times");
      $("#retour_statut_html").html(res.alert);
		}
		mise_en_avant();
	  }
	});
	$("html, body").animate({ scrollTop: 0 }, "slow");
	listeGestionPage();
	});

	//AJAX - SUPPRIMER
	$(document).on("click", ".lien-supprimer-pages", function (){
	  $.post({
		url : '/administration/Pages/Pages/pages-action-supprimer-ajax.php',
		type : 'POST',
		data: {idaction:$(this).attr("data-id")},
		dataType: "json",
		success: function (res) {
		  if(res.retour_validation == "ok"){
			popup_alert(res.Texte_rapport,"green filledlight","#009900","uk-icon-check");
		  }else{
			popup_alert(res.Texte_rapport,"#CC0000 filledlight","#CC0000","uk-icon-times");
		  }
		}
	  });
	  listeGestionPage();
	});

	//AJAX - MISE A JOUR XML
	$(document).on("click", "#bouton-mise-a-jours-date-xml", function (){
	  $.post({
		url : '/administration/Pages/Pages/pages-action-mise-a-jours-date-xml-ajax.php',
		type : 'POST',
		data: {idaction:$(this).attr("data-id")},
		dataType: "json",
		success: function (res) {
		  if(res.retour_validation == "ok"){
			popup_alert(res.Texte_rapport,"green filledlight","#009900","uk-icon-check");
		  }else{
			popup_alert(res.Texte_rapport,"#CC0000 filledlight","#CC0000","uk-icon-times");
		  }
		}
	  });
	  listeGestionPage();
	});

	//FUNCTION AJAX - LISTE
	function listeGestionPage(){
	  $.post({
		url : '/administration/Pages/Pages/pages-action-liste-ajax.php',
		type : 'POST',
		dataType: "html",
		success: function (res) {
		  $("#liste-des-pages").html(res);
		}
	  });
	}
	listeGestionPage();

	//SELECTION CHAMP TYPE DE PAGE 
	$(document).on("change", "#id_categorie", function (){
	  mise_en_avant();
	});

	//FUNCTION TYPE CATEGORIE
	function mise_en_avant(){
	  if($("#id_categorie").val() == "1" || $("#id_categorie").val() == "2" ){
		$(".mise_en_avant").css("display","");
	  }
	  if($("#id_categorie").val() != "1" && $("#id_categorie").val() != "2" ){
		$(".mise_en_avant").css("display","none");
	  }

	}
	mise_en_avant();

	$(document).on('click', '#btnSupprModal', function(){
	  $.post({
		url: '/administration/Pages/Pages/modal-supprimer-ajax.php',
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
	  // $(".modal").show();
	  $.post({
		url: '/administration/Pages/Pages/pages-action-supprimer-ajax.php',
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
		  listeGestionPage();
		  $("#modalSuppr").modal('hide')
		  // $("#modalSuppr").hide(1000);
		  // $(this).hide(1000);
		}
	  });
	});
	
	
	$(document).on("click", "#btnSupprImg", function() {
	  // $(".modal").show();
	  $.post({
		url: '/administration/Pages/Pages/pages-action-supprimer-image-ajax.php',
		type: 'POST',
		data: {
		  idaction: $(this).attr("data-id")
		},
		dataType: "json",
		success: function(res) {
		  if (res.retour_validation == "ok") {
			popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
			setTimeout( location.reload(), 3000);
		  } else {
			popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
		  }
		 
		}
	  });
	});

	$(document).on("click", "#btnNon", function() {
	  $("#modalSuppr").modal('hide')
	});

	$(document).on('hidden.bs.modal', "#modalSuppr", function(){
	  $(this).remove()
	})
});


$(document).on("click", ".browse", function() {
  var file = $(this).parents().find(".file");
  file.trigger("click");
});
$('input[type="file"]').change(function(e) {
  var fileName = e.target.files[0].name;
  $("#file").val(fileName);

  var reader = new FileReader();
  reader.onload = function(e) {
    // get loaded data and render thumbnail.
    document.getElementById("preview").src = e.target.result;
  };
  // read the image file as a data URL.
  reader.readAsDataURL(this.files[0]);
});

</script>

<ol class="breadcrumb">
  <li><a href="<?php echo $http; ?><?php echo $nomsiteweb; ?>">Accueil</a></li>
  <li><a href="<?php echo $mode_back_lien_interne; ?>">Administration</a></li>
  <?php if(empty($_GET['action'])){ ?> <li class="active">Gestion des pages</li> <?php }else{ ?> <li><a href="?page=Pages">Gestion des pages</a></li> <?php } ?>
  <?php if($_GET['action'] == "modification" ){ ?> <li class="active">Modifications</li> <?php } ?>
  <?php if($_GET['action'] == "add" ){ ?> <li class="active">Ajouter</li> <?php } ?>
</ol>

<div class="row" style="margin-bottom:2%;">
  <div class="col-md-12 animation animated fadeInUp" data-animation="fadeInUp" data-animation-delay="0.4s" style="animation-delay: 0.4s; opacity: 1;">
    <div class="small_padding contact_box"> 
      <div class="col-md-12">
        <div class="form-group" id="retour_statut_html" >
          <?php if($statut_reservation == "succès"){ 
            echo "<div class='alert alert-success' style='text-align: left;'><span class='uk-icon-check'></span> Bien enregistré avec succès !</div>"; 
            
          } ?>
          
          <?php if($statut_reservation == "echec"){ echo "<div class='alert alert-danger' style='text-align: left;'><span class='uk-icon-warning'></span> Veuillez renseigner les champs obligatoires !</div>"; } ?>
          
        </div>
      </div>
    </div>
  </div>
</div>


<?php

echo "<div id='bloctitre' style='text-align: left;' ><h1>Gestion des pages</h1></div><br />
<div style='clear: both;'></div>";

////////////////////Boutton administration
echo "<a href='".$mode_back_lien_interne."' ><button type='button' class='btn btn-default' style='margin-right: 5px;' ><span class='uk-icon-cogs'></span> Administration</button></a>";
echo "<a href='?page=Pages-404'><button type='button' class='btn btn-primary' style='margin-right: 5px;' ><span class='uk-icon-trash-o'></span> Erreurs 404/410</button></a>";
echo "<a href='?page=Pages-301'><button type='button' class='btn btn-primary' style='margin-right: 5px;' ><span class='uk-icon-file-code-o'></span> Redirections 301</button></a>";
echo "<a id='bouton-mise-a-jours-date-xml' href='?page=Pages&amp;action=mise-a-jour' onclick='return false;' ><button type='button' class='btn btn-success' style='margin-right: 5px;' ><span class='uk-icon-sitemap'></span> Mise à jour sitemap</button></a>";
////////////////////////////////////////////////////////////SI MODULE AJOUTER PAGE ACTIVE
  echo "<a href='?page=Pages&amp;action=add'><button type='button' class='btn btn-success' style='margin-right: 5px;' ><span class='uk-icon-plus-circle'></span> Ajouter une page</button></a>";
////////////////////////////////////////////////////////////SI MODULE AJOUTER PAGE ACTIVE
if(!empty($_GET['action'])){
  echo "<a href='?page=Pages'><button type='button' class='btn btn-success' style='margin-right: 5px;' ><span class='uk-icon-file-powerpoint-o'></span> Liste des pages</button></a>";
}
echo "<div style='clear: both;'></div>";
////////////////////Boutton administration
?>

<div style='padding: 5px; text-align: center;'>

  <?php

  $action = $_GET['action'];
  $actionn = $_GET['actionn'];

  $idaction = $_GET['idaction'];
  $idactionn = $_GET['idactionn'];

  $actionone = $_GET['actionone'];

  $now = time();

  if(isset($_POST['recherchepage'])){
    $recherchepage = $_POST['recherchepage'];
    $_SESSION['page_recherche'] = "$recherchepage";
    unset($_SESSION['recherche_page_one']);

  }elseif(isset($_GET['recherchepage'])){
    $recherchepage = $_GET['recherchepage'];
    $_SESSION['page_recherche'] = "$recherchepage";
    unset($_SESSION['recherche_page_one']);

  }elseif(!isset($actionone) && $action != "modification"){
    unset($_SESSION['page_recherche']);
  }


/////////////////////////////////////////Modification et Ajouter
  if ($action == "modification" || $action == "add"){

    $_SESSION['idsessionp'] = time();

    if($action == "modification"){
      unset($_SESSION['lasturrl_image2']);

      $_SESSION['idsessionp'] = $idaction;

      if(isset($_SESSION['page_recherche'])){
        $pagerecherche = $_SESSION['page_recherche'];
        $newurl_listing2 = "actionone=recherchep&amp;recherchepage=$pagerecherche";
        $_SESSION['lasturrl'] = "?page=Pages&amp;$newurl_listing2";
      }else{
        $lasturl = $_SERVER['HTTP_REFERER'];
        $_SESSION['lasturrl'] = $lasturl;
      }

      $_SESSION['page_precedente_article_page'] = $_SERVER['REQUEST_URI'];

///////////////////////////////SELECT
      $req_select = $bdd->prepare("SELECT * FROM pages WHERE id=?");
      $req_select->execute(array($idaction));
      $ligne_select = $req_select->fetch();
      $req_select->closeCursor();
      $id = $ligne_select['id'];
      $id_categorie = $ligne_select['id_categorie'];
      $id_image_parallaxe_banniere = $ligne_select['id_image_parallaxe_banniere'];
      $pagesa = $ligne_select['Page'];
      $pagesa_nom = $ligne_select['Page_nom'];
      $contenu = $ligne_select['contenu_de_la_page'];
      $categorie_menu = $ligne_select['categorie_menu'];
      $position_menu = $ligne_select['position_menu'];
      $Ancre_lien_menu = $ligne_select['Ancre_lien_menu'];
      $presence_footer = $ligne_select['presence_footer'];
      $position_footer = $ligne_select['position_footer'];
      $Ancre_lien_footer = $ligne_select['Ancre_lien_footer'];
      $Titre_h1 = $ligne_select['Titre_h1'];
      $Ancre_fil_ariane = $ligne_select['Ancre_fil_ariane'];
      $TitreTitrea = $ligne_select['Title'];
      $Metas_description = $ligne_select['Metas_description'];
      $Metas_mots_cles = $ligne_select['Metas_mots_cles'];
      $Site_map_xml_date_mise_a_jour = $ligne_select['Site_map_xml_date_mise_a_jour'];
      $Site_map_xml_propriete = $ligne_select['Site_map_xml_propriete'];
      $Site_map_xml_frequence_mise_a_jour = $ligne_select['Site_map_xml_frequence_mise_a_jour'];
      $Declaree_dans_site_map_xml = $ligne_select['Declaree_dans_site_map_xml'];
      $activer = $ligne_select['Statut_page'];
      $Page_index = $ligne_select['Page_index'];
      $Page_admin = $ligne_select['Page_admin'];
      $Page_fixe = $ligne_select['Page_fixe'];
      $Page_type_module_ou_page = $ligne_select['Page_type_module_ou_page'];
      $Page_admin_associee = $ligne_select['Page_admin_associee'];
      $date_upadte_p = $ligne_select['date'];

      $afficher_reseaux_sociaux_page = $ligne_select['afficher_reseaux_sociaux_page'];

      $contenu_video_select = $ligne_select['contenu_video'];

      $mise_en_avant  = $ligne_select['mise_en_avant'];

      if($activer == "oui"){
        $selectedactiver1 = "selected='selected'";
      }elseif($activer == "non"){
        $selectedactiver2 = "selected='selected'";
      }

      if($categorie_menu == "oui"){
        $selectedmenu1 = "selected='selected'";
      }else{
        $selectedmenu2 = "selected='selected'";
      }

      if($presence_footer == "oui"){
        $selectedfooter1 = "selected='selected'";
      }else{
        $selectedfooter2 = "selected='selected'";
      }

      if($Site_map_xml_propriete == "1.00"){
        $selectedone1 = "selected='selected'";
      }elseif($Site_map_xml_propriete == "0.9"){
        $selectedone2 = "selected='selected'";
      }elseif($Site_map_xml_propriete == "0.8"){
        $selectedone3 = "selected='selected'";
      }elseif($Site_map_xml_propriete == "0.7"){
        $selectedone4 = "selected='selected'";
      }elseif($Site_map_xml_propriete == "0.6"){
        $selectedone5 = "selected='selected'";
      }elseif($Site_map_xml_propriete == "0.5"){
        $selectedone6 = "selected='selected'";
      }elseif($Site_map_xml_propriete == "0.4"){
        $selectedone7 = "selected='selected'";
      }elseif($Site_map_xml_propriete == "0.3"){
        $selectedone8 = "selected='selected'";
      }elseif($Site_map_xml_propriete == "0.2"){
        $selectedone9 = "selected='selected'";
      }

      if($Site_map_xml_frequence_mise_a_jour == "always"){
        $selectedone1f = "selected='selected'";
      }elseif($Site_map_xml_frequence_mise_a_jour == "hourly"){
        $selectedone2f = "selected='selected'";
      }elseif($Site_map_xml_frequence_mise_a_jour == "daily"){
        $selectedone3f = "selected='selected'";
      }elseif($Site_map_xml_frequence_mise_a_jour == "weekly"){
        $selectedone4f = "selected='selected'";
      }elseif($Site_map_xml_frequence_mise_a_jour == "monthly"){
        $selectedone5f = "selected='selected'";
      }elseif($Site_map_xml_frequence_mise_a_jour == "yearly"){
        $selectedone6f = "selected='selected'";
      }elseif($Site_map_xml_frequence_mise_a_jour == "never"){
        $selectedone7f = "selected='selected'";
      }

      if($Declaree_dans_site_map_xml == "oui"){
        $selectedstatut1 = "selected='selected'";
      }elseif($Declaree_dans_site_map_xml == "non"){
        $selectedstatut2 = "selected='selected'";
      }

      if($Page_fixe == "oui"){
        $selectedpagefixe1 = "selected='selected'";
      }elseif($Page_fixe == "non"){
        $selectedpagefixe12 = "selected='selected'";
      }

      if($Page_type_module_ou_page == "Module"){
        $selectedpagemoduleoupage2 = "selected='selected'";
      }elseif($Page_type_module_ou_page == "Page web"){
        $selectedpagemoduleoupage1 = "selected='selected'";
      }elseif($Page_type_module_ou_page == "Page boutique"){
        $selectedpagemoduleoupage3 = "selected='selected'";
      }

//////////////Si page accueil / Index
      if($action != "add" && $Page_index != "oui"){
        $titre_info_admin_page = "$Ancre_lien_menu";
      }elseif($action != "add" && $Page_index == "oui"){
        $titre_info_admin_page = "Accueil / Index";
      }
//////////////Si page accueil / Index

      echo '<div style="width: 100%; text-align: center;">
      <form id="formulaire-gestion-des-pages-modifier" method="post" action="?page=Pages&amp;action=modifier2&amp;idaction='.$idaction.'" enctype="multipart/form-data">';
      echo "<div align='left'><h2>Modifications de la Page $titre_info_admin_page </h2></div>
      <div style='clear: both;'></div><br />";
      echo '<input id="action" type="hidden" name="action" value="modifier2" >';
      echo '<input id="idaction" type="hidden" name="idaction" value="'. $idaction.'" >';

    }else{

      $_SESSION['lasturrl_image2'] = "add";

      echo '<div style="width: 100%; text-align: center;">
      <form id="formulaire-gestion-des-pages-ajouter" method="post" action="?page=Pages&amp;action=add2" enctype="multipart/form-data">';
      echo "<div align='left'><h2>Déclarer une page</h2></div>
      <div style='clear: both;'></div><br />";
      echo '<input id="action" type="hidden" name="action" value="add2" >';

    }

////////////////////On nome l'id de la page ou numéro temporaire pour les photos
    if($action == "add"){
      $_SESSION['id_page_photo'] = time();
    }else{
      $_SESSION['id_page_photo'] = $idaction;
    }
////////////////////On nome l'id de la page ou numéro temporaire pour les photos


    if($action != "add" && $Page_index != "oui"){
      ?>
      <table style="text-align: left; width: 100%;" border="0" cellpadding="2" cellspacing="2" align="center"><tbody>
        <tr><td style="text-align: left; " colspan='2'>
          <?php
          echo "<a href='/".$pagesa."' target='_top' style='text-decoration: none; margin-right: 5px;'>
          <button type='button' class='btn btn-success'  >Consulter la page ".$pagesa." &gt;</button>
          </a>";
          ?>
        </td></tr>
        <tr><td colspan="3" rowspan="1">&nbsp;</td></tr>
      </tbody></table><br />
      <?php
    }

///////////////////////////////////////////////////////////Si page différente de l'index
    if($Page_index != "oui"){
      ?>
      <div align='left'>
        <h3>Configurations de la page</h3>
      </div><br />
      <div style='clear: both;'></div>

      <table style="text-align: left; width: 100%;" border="0" cellpadding="2" cellspacing="2" >
		<tbody>

        <?php
        if($action == "modification" && !empty($Page_admin_associee)){
          ?>
			<tr>
				<td style="text-align: left; width: 190px; vertical-align: middle;">Page admin associée </td>
				<td style="text-align: left; vertical-align: middle;">

              <?php
              echo "<a href='".$Page_admin_associee."' style='text-decoration: none; margin-right: 5px;'>
              <button type='button' class='btn btn-success' >Page admin</button>
              </a>";
              ?>

				</td>
			</tr>
            <tr>
				<td colspan="2" >&nbsp;</td>
			</tr>
            <?php
          }
          ?>

          <?php
          if($Page_type_module_ou_page != "Modules"){
            ?>
			<tr>
				<td style="text-align: left; width: 190px; font-weight: bold;">Type</td>
				<td style="text-align: left;">
					<select id='Page_type_module_ou_page' name='Page_type_module_ou_page' class='form-control' >
						<option <?php echo "$selectedpagemoduleoupage1"; ?> value='Page web'> Page web &nbsp;</option>
						<option <?php echo "$selectedpagemoduleoupage2"; ?> value='Module'> Module (Réservé au webmaster) &nbsp;</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2" >&nbsp;</td>
			</tr>
              <?php
            }
            ?>

			<tr class="mise_en_avant" style="display: none;" >
				<td style="text-align: left; width: 190px; font-weight: bold;">Mise en avant </td>
				<td class="mise_en_avant" style="text-align: left;">
					<select id='mise_en_avant' name='mise_en_avant' class='form-control'>
						<option <?php if($mise_en_avant == "oui"){ echo "selected"; } ?> value='oui'> Oui &nbsp; &nbsp;</option>
						<option <?php if($mise_en_avant == "non"){ echo "selected"; } ?> value='non'> Non &nbsp; &nbsp;</option>
					</select>
				</td>
			</tr>
			<tr class="mise_en_avant" style="display: none;" >
				<td colspan="2" >&nbsp;</td>
			</tr>

            <tr>
				<td style="text-align: left; width: 190px;">Nom de la page </td>
                <td style="text-align: left;">
                  <?php
                  if($Page_fixe == "oui"){
                    ?>
                    URL FIXEE ...
                    <?php
                  }else{
                    if($Page_type_module_ou_page == "Module"){
                      echo "<a href='/".$pagesa."' >$pagesa</a>";
                    }else{
                      ?>
                      <input type="text" name="postpagetitle" class="form-control" placeholder="Non de la page qui servira pour l'url" value="<?php echo "$pagesa_nom"; ?>" style="width: 100%;"/>
                      <?php
                    }
                  }
                  ?>
                </td>
			</tr>
            <tr>
				<td colspan="2" >&nbsp;</td>
			</tr>

            <tr>
				<td style="text-align: left; width: 190px;">Titre H1 </td>
                <td style="text-align: left;">
					<input type='text' class='form-control' placeholder="Titre principal de la page" name='titreh1postpage' value="<?php echo "$Titre_h1"; ?>" style='width: 100%;'/>
				</td>
			</tr>
            <tr>
				<td colspan="2" >&nbsp;</td>
			</tr>

			<?php
			if($Page_index == "oui"){
			?>
            
			<tr>
				<td style="text-align: left; width: 190px;">Image du bandeau </td>
                <td style="text-align: left;">
					 <div class="imageupload ">
						
						<div class="file-tab">
							<label class="btn btn-primary btn-file">
								<span>Charger</span>
								<!-- The file is stored here. -->
								<input type="file" name="image" class="form-control">
							</label>
							<button type="button" class="btn btn-danger">Supprimer l'image</button>
						</div>
						
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="2" >&nbsp;</td>
			</tr>

			<?php
			}
			?>

			<tr>
				<td style="text-align: left; width: 190px;">Ancre / Fil d'ariane </td>
                <td style="text-align: left;">
					<input type='text' class='form-control' placeholder="Ancre du fil d'ariane au niveau de la page" name='ancrefildarianepostpage' value="<?php echo "$Ancre_fil_ariane"; ?>" style='width: 100%;'/>
				</td>
			</tr>
			<tr>
				<td colspan="2" >&nbsp;</td>
			</tr>

			<?php
			////////////////////////////////////////Page admin associée
				if($action == "add"){
			?>
		    
			<tr id='page_admin_associee' style='display: none;' >
				<td style="text-align: left; width: 190px; font-weight: bold;">Page admin associée</td>
				<td style="text-align: left;">
					<input type='text' class='form-control' name='Page_admin_associeepost' placeholder='réservé au webmaster' value='<?php echo "$Page_admin_associee"; ?>' style='width: 100%;'/>
				</td>
			</tr>
			<tr>
				<td colspan="2" >&nbsp;</td>
			</tr>
			<?php
			    }elseif(!empty($Page_admin_associeepost) && $Page_type_module_ou_page == "Module" ){
			?>
			<tr>
				<td style="text-align: left; width: 190px; font-weight: bold;">Page admin associée</td>
				<td style="text-align: left;">
					<a href='/<?php echo "$Page_admin_associeepost"; ?>' target='_top' >
						<?php echo "Configuration supplémentaire"; ?>
					</a>
				</td>
			</tr>
			<tr>
				<td colspan="2" >&nbsp;</td>
			</tr>
			<?php
				}
			////////////////////////////////////////Page admin associée
			?>

			<tr>
				<td style="text-align: left; width: 190px; font-weight: bold;">Statut page </td>
				<td style="text-align: left;">
					<select name='activer' class='form-control'>
						<option <?php echo "$selectedactiver1"; ?> value='oui'> Activée &nbsp; &nbsp;</option>
						<option <?php echo "$selectedactiver2"; ?> value='non'> Désactivée &nbsp; &nbsp;</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2" >&nbsp;</td>
			</tr>

			<tr>
				<td style="text-align: left; width: 190px;">Afficher partage des réseaux sociaux </td>
				<td style="text-align: left;">
					<select name='afficher_reseaux_sociaux_page' class='form-control'>
						<option <?php if($afficher_reseaux_sociaux_page == "non"){ echo "selected"; } ?>  value='non'> Non &nbsp; &nbsp;</option>
						<option <?php if($afficher_reseaux_sociaux_page == "oui"){ echo "selected"; } ?> value='oui'> Oui &nbsp; &nbsp;</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2" >&nbsp;</td>
			</tr>

			<?php
				if($action == "add"){
			?>
			<tr>
				<td style="text-align: left; width: 190px; font-weight: bold;">Page fixe</td>
				<td style="text-align: left;">
					<select name='Page_fixepost' class='form-control'>
						<option <?php echo "$selectedpagefixe2"; ?> value='non'> Non &nbsp; &nbsp;</option>
						<option <?php echo "$selectedpagefixe1"; ?> value='oui'> Oui &nbsp; &nbsp;</option>
					</select> L'url ne pourra plus être modifié
				</td>
			</tr>
			<tr>
				<td colspan="2" >&nbsp;</td>
			</tr>
			<?php
			   }
			?>

		</tbody>
	</table>
	
	<br />

	<?php 
		}

		if($Page_index != "oui"){
	?>

	<div style='text-align: left;'>
		<h3>Page web</h3>
	</div>
	
	<br />
	
	<div style='clear: both;'></div>

	<?php
///////////////////////////////////////////////SI GESTION DES PAGES DANS LE MENU ACTIVEE
		if($gestion_page_dans_menu == "oui"){
	?>

	<table style="text-align: left; width: 100%;" border="0" cellpadding="2" cellspacing="2" align="center">
		<tbody>
			<tr>
				<td style="text-align: left; width: 190px;">Intégrer dans le menu </td>
			    <td style="text-align: left;">
					<select name='menu_pagepost' class='form-control'>
						<option <?php echo "$selectedmenu2"; ?> value='non'> Non &nbsp; &nbsp;</option>
						<option <?php echo "$selectedmenu1"; ?> value='oui'> Oui &nbsp; &nbsp;</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2" >&nbsp;</td>
			</tr>

			<tr>
				<td style="text-align: left; width: 190px;">Position dans le menu </td>
				<td style="text-align: left;">
					<input type='number' class='form-control' name='positiondansmenupostpage' placeholder='0' value="<?php echo "$position_menu"; ?>" style='width: 80px; display: inline-block;'/> Ex: 1
				</td>
			</tr>
			<tr>
				<td colspan="2" >&nbsp;</td>
			</tr>

			<tr>
				<td style="text-align: left; width: 190px;">Ancre / Lien / Menu </td>
				<td style="text-align: left;">
					<input type='text' class='form-control' name='ancrelienmenupostpage' placeholder="Ancre dans le menu" value="<?php echo "$Ancre_lien_menu"; ?>" style='width: 100%;'/>
				</td>
			</tr>
			<tr>
				<td colspan="2" >&nbsp;</td>
			</tr>

		</tbody>
	</table>
	
	<br />
	<?php
		}
///////////////////////////////////////////////SI GESTION DES PAGES DANS LE MENU ACTIVEE

///////////////////////////////////////////////SI GESTION DES PAGES DANS LE FOOTER ACTIVEE
		if($gestion_page_dans_footer == "oui"){
	?>
	<div style='text-align: left;'>
		<h3>Page web dans le Footer / Pied de page </h3>
	</div>
	
	<br />
	<div style='clear: both;'></div>

	<table style="text-align: left; width: 100%;" border="0" cellpadding="2" cellspacing="2" align="center">
	
		<tbody>

			<tr>
				<td style="text-align: left; width: 190px;">Intégrer dans le footer </td>
				<td style="text-align: left;">
					<select name='presence_footer' class='form-control'>
						<option <?php echo "$selectedfooter2"; ?> value='non'> Non &nbsp; &nbsp;</option>
						<option <?php echo "$selectedfooter1"; ?> value='oui'> Oui &nbsp; &nbsp;</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2" >&nbsp;</td>
			</tr>

			<tr>
				<td style="text-align: left; width: 190px;">Position dans le footer </td>
				<td style="text-align: left;">
					<input type='number' class='form-control' name='positiondansfooterpostpage' placeholder='0' value="<?php echo "$position_footer"; ?>" style='width: 80px; display: inline-block;'/> Ex: 1
				</td>
			</tr>
			<tr>
				<td colspan="2" >&nbsp;</td>
			</tr>

			<tr>
				<td style="text-align: left; width: 190px;">Ancre / Lien / footer </td>
				<td style="text-align: left;">
					<input type='text' class='form-control' name='ancrelienfooterpostpage' placeholder="Ancre dans le footer" value="<?php echo "$Ancre_lien_footer"; ?>" style='width: 100%;'/>
				</td>
			</tr>
			<tr>
				<td colspan="2" >&nbsp;</td>
			</tr>

		</tbody>
	</table>
	<br />
	<?php
///////////////////////////////////////////////SI GESTION DES PAGES DANS LE FOOTER ACTIVEE
		}
	?>

	<div style="text-align: left;">
		<h3>Déclarée la page dans le sitemap.xml</h3>
	</div>
	<br />
	<div style='clear: both;'></div>

	<table style="text-align: left; width: 100%;" border="0" cellpadding="2" cellspacing="2" align="center">
		<tbody>

			<tr>
				<td style="text-align: left; width: 190px;">Level</td>
				<td style="text-align: left;">
					<select name='levelpagepost' class='form-control'>
						<option value='0.9' <?php echo "$selectedone2"; ?> >0.9 - autre</option>
						<option value='0.8' <?php echo "$selectedone3"; ?> >0.8 - autre</option>
						<option value='0.7' <?php echo "$selectedone4"; ?> >0.7 - autre</option>
						<option value='0.6' <?php echo "$selectedone5"; ?> >0.6 - autre</option>
						<option value='0.5' <?php echo "$selectedone6"; ?> >0.5 - autre</option>
						<option value='0.4' <?php echo "$selectedone7"; ?> >0.4 - autre</option>
						<option value='0.3' <?php echo "$selectedone8"; ?> >0.3 - autre</option>
						<option value='0.2' <?php echo "$selectedone9"; ?> >0.2 - autre</option>
					</select> Structure hiérachique pour les robots du sitemap.xml
				</td>
			</tr>

			<?php
				if($action != "add"){
			?>
			<tr>
				<td colspan="2" >&nbsp;</td>
			</tr>

			<tr>
				<td style="text-align: left; width: 190px;">Changer la date</td>
				<td style="text-align: left;">
					<select name='datemodifpagepost' class='form-control'>
						<option value='oui'>oui</option>
						<option value='non'>non</option>
					</select> Date de modification pour les robots du sitemap.xml
				</td>
			</tr>

			<?php
				}

				if(empty($Site_map_xml_frequence_mise_a_jour))
				{
					$selectedone4f = "selected='selected'";
				}
			?>

			<tr>
				<td colspan="2" >&nbsp;</td>
			</tr>
			<tr>
				<td style="text-align: left; width: 190px;">Fréquence</td>
				<td style="text-align: left;">
					<select name='frequencepagepost' class='form-control'>
						<option value='always' <?php echo "$selectedone1f"; ?> >always - minutes</option>
						<option value='hourly' <?php echo "$selectedone2f"; ?> >hourly - heure</option>
						<option value='daily' <?php echo "$selectedone3f"; ?> >daily - jour</option>
						<option value='weekly' <?php echo "$selectedone4f"; ?> >weekly - semaine</option>
						<option value='monthly' <?php echo "$selectedone5f"; ?> >monthly - mois</option>
						<option value='yearly' <?php echo "$selectedone6f"; ?> >yearly - année</option>
						<option value='never' <?php echo "$selectedone7f"; ?> >never - toujours</option>
					</select> Fréquence de modification de la page
				</td>
			</tr>
			<tr>
				<td colspan="2" >&nbsp;</td>
			</tr>

			<tr>
				<td style="text-align: left; width: 190px; font-weight: bold;">Déclarer la page </td>
				<td style="text-align: left;">
					<select name='declaree_dans_site_map_xml_pagepost' class='form-control'>
						<option <?php echo "$selectedstatut1"; ?> value='oui'> Page déclarée &nbsp; &nbsp;</option>
						<option <?php echo "$selectedstatut2"; ?> value='non'> Page non déclarée &nbsp; &nbsp;</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2" >&nbsp;</td>
			</tr>

		</tbody>
	</table>
	
	<br />

	<?php
		}
///////////////////////////////////////////////////////////Si page différente de l'index
	?>


	<?php
		if($Page_index != "oui" && $Page_type_module_ou_page != "Module" || $pagesa == "contact" )
		{

			$contenu= "$contenu";
	?>

	<div id='Contenu_de_la_page' >
		<table style="text-align: left; width: 100%;" cellpadding="2" cellspacing="2">
			<tbody>
				<tr>
					<td colspan="2" ><hr /></td>
				</tr>
				<tr>
					<td colspan="2" >
						<h3>Contenu éditorial</h3>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: right;">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: left;">
						<textarea class='mceEditor' id='contenupagepost' name='contenupagepost' style='width: 100%; height: 60px;'><?php echo "$contenu"; ?></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: left;"> 
						<span class='uk-icon-warning'></span>
						Pour insérer une image ou une photo, glissez la simplement de votre orindateur dans le bloc ci-dessus. 
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: right;">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: left; vertical-align: top; width: 190px;">Vidéo Iframe Youtube</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: right;">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: left;">
						<textarea id='contenu_video' name='contenu_video' style='width: 100%; height: 60px;'><?php echo "$contenu_video_select"; ?></textarea>
					</td>
				</tr>

			</tbody>
		</table>
		<br />
		<br />
	</div>
</div>
	
<?php
			
	}
///////////////////////////////////////////////////////////Si page différente de l'index
?>


<table style="text-align: left; width: 100%; text-align: center;" border="0" cellpadding="2" cellspacing="2">
	<tbody>

		<tr>
			<td colspan="2" ><hr /></td>
		</tr>
		<tr>
			<td colspan="2" style="text-align: left;">
				<h3>Référencement SEO de la page</h3>
			</td>
		</tr>
		<tr>
			<td colspan="2"><br /></td>
		</tr>

		<tr>
			<td style="text-align: left; vertical-align: top; width: 190px;">Title</td>
			<td style="text-align: left;">
				<input name='titlepagepost' class='form-control' placeholder="Une phrase maximum" style='width: 100%;' value="<?php echo "$TitreTitrea"; ?>" >
			</td>
		</tr>
		<tr>
			<td colspan="2"><br /></td>
		</tr>

		<tr>
			<td style="text-align: left; vertical-align: top; width: 190px;">Méta déscription</td>
			<td style="text-align: left;">
				<textarea name='metadescriptionpagepost' class='form-control' placeholder="Une phrase ou deux maximum" style='width: 100%; height: 90px;'><?php echo "$Metas_description"; ?></textarea>
			</td>
		</tr>
		<tr>
			<td colspan="2"><br /></td>
		</tr>

		<tr>
			<td style="text-align: left; vertical-align: top; width: 190px;">Méta mots clés</td>
			<td style="text-align: left;">
				<textarea name='metamotsclespagepost' class='form-control' placeholder="Mot 1, Mot 2, Mot 3, Mot 4 ..." style='width: 100%; height: 90px;'><?php echo "$Metas_mots_cles"; ?></textarea>
			</td>
		</tr>

		<tr>
			<td colspan="2" >&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2" >&nbsp;</td>
		</tr>

		<tr>
			<td colspan="2" style="text-align: center;">
				<button id='bouton-gestion-des-pages' type='button' class='btn btn-success' onclick="return false;" style='width: 150px;' >ENREGISTRER</button>
			</td>
		</tr>

	</tbody>
</table>
</form>
</div>
<br />
<br />

<?php
	}
/////////////////////////////////////////Modification et Ajouter

/////////////////////////////////////////Si aucune action
	if ($action != "modification" && $action != "add" && $action != "images" && $actionone != "liste_images")
	{
?>

<!-- LISTE DES PAGES -->
<div id='liste-des-pages'></div>

<?php
	}
/////////////////////////////////////////Si aucune action

	echo "</div>";

	}
	else
	{
		header('location: /index.html');
	}
?>