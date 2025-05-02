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
  $idaction = $_GET['idaction'];
?>


<script>
$(document).ready(function (){

	//AJAX SOUMISSION DU FORMULAIRE - MODIFIER 
	$(document).on("click", "#modifier-categorie", function (){
		//ON SOUMET LE TEXTAREA TINYMCE
		tinyMCE.triggerSave();
		$.post({
			url : '/administration/Modules/Categories/Categories-action-modifier-ajax.php',
			type : 'POST',
			<?php if($_GET['action'] == "Modifier" ){ ?> 
				data: new FormData($("#formulaire-modifier-categorie")[0]),
			<?php }else{ ?> 
				data: new FormData($("#formulaire-modifier-categorie-ajouter")[0]),
			<?php } ?> 
			processData: false,
			contentType: false,
			dataType: "json",
			success: function (res) {
				if(res.retour_validation == "ok"){
					popup_alert(res.Texte_rapport,"green filledlight","#009900","uk-icon-check");
					<?php if($_GET['action'] != "Modifier" ){ ?> 
					$("#formulaire-gestion-des-pages-ajouter")[0].reset();
					<?php } ?> 
				}else{
					popup_alert(res.Texte_rapport,"#CC0000 filledlight","#CC0000","uk-icon-times");
				}
			}
		});
		$("html, body").animate({ scrollTop: 0 }, "slow");
		listeCategorie();
	});


	//AJAX - SUPPRIMER MEMBRE
	$(document).on("click", "#supprimer-compte-membre-submit", function (){
		//ON SOUMET LE TEXTAREA TINYMCE
		tinyMCE.triggerSave();
		$.post({
			url : '/administration/Modules/Membres/membres-action-supprime-ajax.php',
			type : 'POST',
			data: new FormData($("#formulaire-supprimer-compte-membre")[0]),
			processData: false,
			contentType: false,
			dataType: "json",
			success: function (res) {
				if(res.retour_validation == "ok"){
					popup_alert(res.Texte_rapport,"green filledlight","#009900","uk-icon-check");
					//setTimeout("Timerone()",2000);
					//document.location.href = "?page=Membres";
				}else{
					popup_alert(res.Texte_rapport,"#CC0000 filledlight","#CC0000","uk-icon-times");
				}
			}
		});
		listeCategorie();
		$("html, body").animate({ scrollTop: 0 }, "slow");
	});

	//FUNCTION AJAX - LISTE CATEGORIES
	function listeCategorie(){
		$.post({
			url : '/administration/Modules/Categories/Categories-action-liste-ajax.php',
			type : 'POST',
			dataType: "html",
			success: function (res) {
				$("#liste-compte-membre").html(res);
			}
		});
	}

	listeCategorie();

	// AJAX - SUPPRIMER CATEGORIE
	$(document).on("click", "#btnSuppr", function() {
		$("#modalSuppr").modal('hide')
	});

	$(document).on("click", "#btnSuppr", function() {
		$.post({
			url: '/administration/Modules/Categories/Categories-action-supprimer-ajax.php',
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
			listeCategorie();
			}
		});
	});

	$(document).on('click', '#btnSupprModal', function(){
		$.post({
			url: '/administration/Modules/Categories/modal-supprimer-ajax.php',
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

	$(document).on("click", "#btnNon", function() {
		$("#modalSuppr").modal('hide')
	});

	$(document).on('hidden.bs.modal', "#modalSuppr", function(){
		$(this).remove()
	})


});
</script>

<?php
$action = $_GET['action'];
$idaction = $_GET['idaction'];
?>


<ol class="breadcrumb">
  <li><a href="<?php echo $http; ?><?php echo $nomsiteweb; ?>">Accueil</a></li>
  <li><a href="<?php echo $mode_back_lien_interne; ?>">Administration</a></li>
  <?php if(empty($_GET['action'])){ ?> <li class="active">Gestion des catégories</li> <?php }else{ ?> <li><a href="?page=Categroies">Gestion des catégories</a></li> <?php } ?>
  <?php if($_GET['action'] == "modifier" ){ ?> <li class="active">Modifications</li> <?php } ?>
  <?php if($_GET['action'] == "addm" ){ ?> <li class="active">Ajouter</li> <?php } ?>
  <?php if($_GET['action'] == "Graphique" ){ ?> <li class="active">Graphique</li> <?php } ?>
</ol>


<?php
echo "<div id='bloctitre' style='text-align: left;'><h1>Gestion des catégories</h1></div><br />
<div style='clear: both;'></div>";

////////////////////Boutton administration
echo "<a href='".$mode_back_lien_interne."'><button type='button' class='btn btn-default' style='margin-right: 5px;' ><span class='uk-icon-cogs'></span> Administration</button></a>";
if($_GET['action'] != "Ajouter" ){
echo "<a href='?page=Categories&amp;action=Ajouter'><button type='button' class='btn btn-success' style='margin-right: 5px;' ><span class='uk-icon-plus-circle'></span> Ajouter une catégorie</button></a>";
}
if(isset($_GET['action'])){
echo "<a href='?page=Categories'><button type='button' class='btn btn-success' style='margin-right: 5px;' ><span class='uk-icon-list'></span> Liste des categories</button></a>";
}
echo "<div style='clear: both;'></div><br />";
////////////////////Boutton administration
?>


<div style='padding: 5px; text-align: center;'>

<?php
////////////////////////////////////////////////////////////////////////////////////////////FORMULAIRE AJOUTER - MODIFIER
if($action == "Ajouter" || $action == "Modifier"){

	if($action == "Modifier"){

		///////////////////////////////SELECT
		$req_select = $bdd->prepare("SELECT * FROM categories WHERE id=?");
		$req_select->execute(array($idaction));
		$ligne_select = $req_select->fetch();
		$req_select->closeCursor();
		$idd2dddf = $ligne_select['id']; 
		$nom_categorie = $ligne_select['nom_categorie'];
		$url_categorie = $ligne_select['url_categorie'];
		$title_categorie = $ligne_select['title_categorie'];
		$meta_description_categorie = $ligne_select['meta_description_categorie'];
		$meta_keyword_categorie = $ligne_select['meta_keyword_categorie'];
		$title_categorie_demandes = $ligne_select['title_categorie_demandes'];
		$meta_description_categorie_demandes = $ligne_select['meta_description_categorie_demandes'];
		$meta_keyword_categorie_demandes = $ligne_select['meta_keyword_categorie_demandes'];
		$nom_categorie_image = $ligne_select['nom_categorie_image'];

		$command = $ligne_select['value_commande'];
		$type = $ligne_select['type'];
		$value = $ligne_select['value'];
		$activer = $ligne_select['activer'];
		
		echo "<form id='formulaire-modifier-categorie' method='post' action='#' enctype='multipart/form-data' >
		<div style='text-align: center; margin-right: auto; margin-left: auto;'>
		<div style='text-align: left;'>
		<h2>Modifier la catégorie : $nom_categorie</h2><br /><br />
		</div>";
	?>
	<input name="idaction" class="form-control" type="hidden" value="<?php echo "$idaction"; ?>" style='width: 100%;'/>
	<input name="action" class="form-control" type="hidden" value="<?php echo "Modifier-action"; ?>" style='width: 100%;'/>
	<?php


}elseif($action == "Ajouter"){
	echo "<form id='formulaire-modifier-categorie-ajouter' method='post' action='#' enctype='multipart/form-data' >
			<div style='text-align: center; margin-right: auto; margin-left: auto;'>
				<div style='text-align: left;'>
				<h2>Ajouter une catégorie</h2><br /><br />
				</div>
		";
	?>
	<input name="idaction" class="form-control" type="hidden" value="<?php echo "$idaction"; ?>" style='width: 100%;'/>
	<input name="action" class="form-control" type="hidden" value="<?php echo "Ajouter-action"; ?>" style='width: 100%;'/>
<?php
}
?>

<div class="well well-sm" style="width: 100%; text-align: left;">

	<div class="row" style="">
		<div class="form-group">
			<label for="" class="col-md-2"><strong> Activer Catégorie </strong></label>
			<div class="col-md-4">
				<select name="activer" id="activer" class="form-control">
					<option <?php if($activer == "oui"){ echo "selected"; } ?> value="oui"><?php echo "Oui"; ?></option>
					<option <?php if($activer == "Non"){ echo "selected"; } ?> value="Non"><?php echo "Non"; ?></option>
				</select>
			</div>
		</div>
	</div>

	<div class="row" style="margin-top:2%;">
		<div class="form-group">
			<label for="" class="col-md-2">Nom de la catégorie</label>
			<div class="col-md-4">
				<input name="nom_categorie" class="form-control" type="text" value="<?php echo "$nom_categorie"; ?>" style='width: 100%;'/>
			</div>
		</div>
	</div>

	<div class="row" style="margin-top:2%">
		<div class="form-group">
			<label for="" class="col-md-2">Pourcentage au passage de commande</label>
			<div class="col-md-4">
				<input name="command" class="form-control" type="number" value="<?= $command ?>"/>
			</div>
		</div>
	</div>
	
	<div class="row" style="margin-top:2%">
		<div class="form-group">
			<label for="" class="col-md-2">Type de valeur (Module colis)</label>
			<div class="col-md-4">
				<select name="type" id="type" class="form-control">
					<option <?php if($type == 1){ echo "selected"; } ?> value="1"><?php echo "Prix du kilo"; ?></option>
					<option <?php if($type == 2){ echo "selected"; } ?> value="2"><?php echo "Pourcentage"; ?></option>
				</select>
			</div>
		</div>
	</div>
	<div class="row" style="margin-top:2%">
		<div class="form-group">
			<label for="" class="col-md-2">Valeur (Module colis)</label>
			<div class="col-md-4">
				<input name="value" class="form-control" type="number" value="<?= $value ?>"/>
			</div>
		</div>
	</div>
	<div class="row" style="margin-top:2%">
		<div class="form-group">
			<label for="" class="col-md-2">Image</label>
			<div class="col-md-4">
				<input type='file' name='image' class='form-control'/>
			</div>
			<?php
if(!empty($nom_categorie_image)){
?>
<img src="/images/categories/<?php echo $nom_categorie_image; ?>" style="width: 100px;" alt="<?php echo $nom_categorie_image; ?>" >
<?php
}
?>
		</div>
	</div>

</div>

<br />
<button id='modifier-categorie' type='button' class='btn btn-success' onclick="return false;" style='width: 150px;' >ENREGISTRER</button>

</form>

<?php
}
////////////////////////////////////////////////////////////////////////////////////////////FORMULAIRE AJOUTER - MODIFIER

////////////////////////////////////////////////////////////////////////////////////////////PAS D'ACTION
if(!isset($action)){
?>

<div id='liste-compte-membre' style='clear: both;'></div>

<?php

  } 
  echo "</div>";

}else {
    header('location: /');
  }
?>

