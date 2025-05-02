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
			url : '/administration/Modules/Abonnements/Abonnements-action-modifier-ajax.php',
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

	//FUNCTION AJAX - LISTE CATEGORIES
	function listeCategorie(){
		$.post({
			url : '/administration/Modules/Abonnements/Abonnements-action-liste-ajax.php',
			type : 'POST',
			dataType: "html",
			success: function (res) {
				$("#liste-compte-membre").html(res);
			}
		});
	}

	listeCategorie();

});
</script>

<?php
$action = $_GET['action'];
$idaction = $_GET['idaction'];
?>


<ol class="breadcrumb">
  <li><a href="<?php echo $http; ?><?php echo $nomsiteweb; ?>">Accueil</a></li>
  <li><a href="<?php echo $mode_back_lien_interne; ?>">Administration</a></li>
  <?php if(empty($_GET['action'])){ ?> <li class="active">Gestion des abonnements</li> <?php }else{ ?> <li><a href="?page=Abonnements">Gestion des abonnements</a></li> <?php } ?>
  <?php if($_GET['action'] == "modifier" ){ ?> <li class="active">Modifications</li> <?php } ?>
  <?php if($_GET['action'] == "addm" ){ ?> <li class="active">Ajouter</li> <?php } ?>
  <?php if($_GET['action'] == "Graphique" ){ ?> <li class="active">Graphique</li> <?php } ?>
</ol>


<?php
echo "<div id='bloctitre' style='text-align: left;'><h1>Gestion des abonnements</h1></div><br />
<div style='clear: both;'></div>";

////////////////////Boutton administration
echo "<a href='".$mode_back_lien_interne."'><button type='button' class='btn btn-default' style='margin-right: 5px;' ><span class='uk-icon-cogs'></span> Administration</button></a>";
if(isset($_GET['action'])){
echo "<a href='?page=Abonnements'><button type='button' class='btn btn-success' style='margin-right: 5px;' ><span class='uk-icon-list'></span> Liste des abonnements</button></a>";
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
		$req_select = $bdd->prepare("SELECT * FROM configurations_abonnements WHERE id=?");
		$req_select->execute(array($idaction));
		$ligne_select = $req_select->fetch();
		$req_select->closeCursor();
		$idd2dddf = $ligne_select['id']; 
		
		echo "<form id='formulaire-modifier-categorie' method='post' action='#' enctype='multipart/form-data' >
		<div style='text-align: center; margin-right: auto; margin-left: auto;'>
		<div style='text-align: left;'>
		<h2>Modifier</h2><br /><br />
		</div>";
	?>
	<input name="idaction" class="form-control" type="hidden" value="<?php echo "$idaction"; ?>" style='width: 100%;'/>
	<input name="action" class="form-control" type="hidden" value="<?php echo "Modifier-action"; ?>" style='width: 100%;'/>
	<?php


}elseif($action == "Ajouter"){
	echo "<form id='formulaire-modifier-categorie-ajouter' method='post' action='#' enctype='multipart/form-data' >
			<div style='text-align: center; margin-right: auto; margin-left: auto;'>
				<div style='text-align: left;'>
				<h2>Ajouter</h2><br /><br />
				</div>
		";
	?>
	<input name="idaction" class="form-control" type="hidden" value="<?php echo "$idaction"; ?>" style='width: 100%;'/>
	<input name="action" class="form-control" type="hidden" value="<?php echo "Ajouter-action"; ?>" style='width: 100%;'/>
<?php
}
?>

<div class="well well-sm" style="width: 100%; text-align: left;">

	<div class="row" style="margin-top:2%;">
		<div class="col-md-12">
			<div class="form-group">
				<label for="" class="col-md-2">Nom abonnement</label>
				<div class="col-md-10">
					<input name="nom_abonnement" class="form-control" type="text" value="<?php echo $ligne_select['nom_abonnement']; ?>" style='width: 100%;'/>
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-top:2%;">
		<div class="col-md-12">
			<div class="form-group">
				<label for="" class="col-md-2">Prix<br /> En fcfa</label>
				<div class="col-md-10">
					<input name="Prix" class="form-control" type="number" value="<?php echo $ligne_select['Prix']; ?>" style='width: 100%;'/>
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-top:2%;">
		<div class="col-md-12">
			<div class="form-group">
				<label for="" class="col-md-2">Douane et transport<br /> En %</label>
				<div class="col-md-10">
					<input name="Douane_et_transport" class="form-control" type="number" value="<?php echo $ligne_select['Douane_et_transport']; ?>" style='width: 100%;'/>
				</div>
			</div>
		</div>
	</div>

<!-- 
	<div class="row" style="margin-top:2%;">
		<div class="col-md-12">
			<div class="form-group">
				<label for="" class="col-md-2">Frais de passage d'une commande<br /> En fcfa ou Gratuit</label>
				<div class="col-md-10">
					<input name="Frais_de_passage_d_une_commande" class="form-control" type="text" value="<?php echo $ligne_select['Frais_de_passage_d_une_commande']; ?>" style='width: 100%;'/>
				</div>
			</div>
		</div>
	</div> -->

	<div class="row" style="margin-top:2%;">
		<div class="col-md-12">
			<div class="form-group">
				<label for="" class="col-md-2">Liste de souhaits<br /> En fcfa ou Gratuit</label>
				<div class="col-md-10">
					<input name="Liste_de_souhaits" class="form-control" type="text" value="<?php echo $ligne_select['Liste_de_souhaits']; ?>" style='width: 100%;'/>
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-top:2%;">
		<div class="col-md-12">
			<div class="form-group">
				<label for="" class="col-md-2">Frais de gestion d'une commande<br /> En fcfa</label>
				<div class="col-md-10">
					<input name="Frais_de_gestion_d_une_commande" class="form-control" type="number" value="<?php echo $ligne_select['Frais_de_gestion_d_une_commande']; ?>" style='width: 100%;'/>
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-top:2%;">
		<div class="col-md-12">
			<div class="form-group">
				<label for="" class="col-md-2">Montant minimum pour passage de commande<br /> En fcfa</label>
				<div class="col-md-10">
					<input name="Montant_minimum" class="form-control" type="number" value="<?php echo $ligne_select['Montant_minimum']; ?>" style='width: 100%;'/>
				</div>
			</div>
		</div>
	</div>

</div>

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

