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

	$id_liaison = $_GET['id_liaison'];
	$action = $_GET['action'];
	$idaction = $_GET['idaction'];
	$now = time();
	
	///////////////////////////////SELECT
	$req_select = $bdd->prepare("SELECT * FROM pages WHERE id=?");
	$req_select->execute(array($_SESSION['id_page_photo']));
	$ligne_select = $req_select->fetch();
	$req_select->closeCursor();
	$idoneinfos_artciles_page = $ligne_select['id'];
	$id_categorie_artciles_page = $ligne_select['id_categorie'];
	$titre_page_1_artciles_page = $ligne_select['Titre_h1'];
	$url_fiche_page_artciles_page = $ligne_select['Page'];

	if(!empty($idoneinfos_artciles_page)){
		echo "<div align='left'><h1>Gestion des photos</h1></div><br /><br />
		<div style='clear: both;'></div>";
		echo "<div align='left'><h2>Page : \" $titre_page_1_artciles_page \"</h2></div><br /><br />
		<div style='clear: both;'></div>";
	}else{
		echo "<div align='left'><h1>Gestion des photos</h1></div><br /><br />
		<div style='clear: both;'></div>";
	}

	////////////////////Boutton administration
	echo "<a href='/administration/index-admin.php' ><button type='button' class='btn btn-default' style='margin-right: 5px;' ><span class='uk-icon-cogs'></span> Administration</button></a>";
	echo "<a href='/administration/index-admin.php?page=Pages'><button type='button' class='btn btn-default' style='margin-right: 5px;' ><span class='uk-icon-file'></span> Gestion des pages</button></a>";
	if(!empty($_SESSION['page_precedente_article_page'])){
		echo "<a href='".$_SESSION['page_precedente_article_page']."'><button type='button' class='btn btn-default' style='margin-right: 5px;' ><span class='uk-icon-file-text-o'></span> Gestion de la page</button></a>";
	}
	echo "<a href='javascript:close();'><button type='button' class='btn btn-default' style='margin-right: 5px;' ><span class='uk-icon-times'></span> Fermer cette page</button></a>";
	echo "<div style='clear: both;'></div><br />";
	////////////////////Boutton administration

	////////////////////////////////////////AJOUTER UNE PHOTO
	?>
	<div align='left'>
		<h2>Ajouter une image</h2>
	</div><br />
	<div style='clear: both;'></div>

	<div style='text-align: left;'>
	<?php
	include(''.$dir_fonction.'/administration/Pages/Pages/photos-page-recadrage-images.php');
	?>
	</div><br /><br />
	<?php
	////////////////////////////////////////AJOUTER UNE PHOTO

	///////////////////////////////////////////SUPPRIMER UNE IMAGE
	if($action == "delete"){

		///////////////////////////////SELECT
		$req_select = $bdd->prepare("SELECT * FROM pages_a_b_image WHERE id=?");
		$req_select->execute(array($idaction));
		$ligne_select = $req_select->fetch();
		$req_select->closeCursor();
		$idimmmagee_delete = $ligne_select['id'];
		$img_lien_delete = $ligne_select['img_lien'];
		$img_lien2_delete = $ligne_select['img_lien2'];
		$img_title_delete = $ligne_select['img_title'];

		///////////////////////////////DELETE
		$sql_delete = $bdd->prepare("DELETE FROM pages_a_b_image WHERE id=?");
		$sql_delete->execute(array($idaction));                     
		$sql_delete->closeCursor();

		if(file_exists("images/pages/$img_lien_delete") == true && !empty($img_lien_delete )){
			unlink("images/pages/$img_lien_delete");
		}
		if(file_exists("images/pages/$img_lien2_delete") == true &&  !empty($img_lien2_delete)){
			unlink("images/pages/$img_lien2_delete");
		}
		////////////RAPPORT JS
		?>
		<script language="javascript" type="text/javascript">
		alert("Image supprimée avec succès !");
		</script>
		<?php
		////////////RAPPORT JS
	}
	///////////////////////////////////////////SUPPRIMER UNE IMAGE


	///////////////////////////////////////////IMAGE PAR DEFAUT DU BLOG
	if($action == "image-defaut"){

		$image_defaut_post = $_POST['image_defaut_post'];

			///////////////////////////////SELECT BOUCLE
			$req_boucle = $bdd->prepare("SELECT * FROM pages_a_b_image WHERE id_page=?");
			$req_boucle->execute(array($_SESSION['id_page_photo']));
			while($ligne_boucle = $req_boucle->fetch()){
			$idimmmagee_image_d = $ligne_boucle['id'];

			///////////////////////////////UPDATE
			$sql_update = $bdd->prepare("UPDATE pages_a_b_image SET defaut='' WHERE id=?");
			$sql_update->execute(array('',$idimmmagee_image_d));                     
			$sql_update->closeCursor();

		}
		$req_boucle->closeCursor();

		///////////////////////////////UPDATE
		$sql_update = $bdd->prepare("UPDATE pages_a_b_image SET defaut=? WHERE id=?");
		$sql_update->execute(array('oui',$image_defaut_post));                     
		$sql_update->closeCursor();

	////////////RAPPORT JS
	?>
	<script language="javascript" type="text/javascript">
	alert("Image par défaut changée !");
	</script>
	<?php
	////////////RAPPORT JS
	}
	///////////////////////////////////////////IMAGE PAR DEFAUT DU BLOG

	?>

	<form action="?page=Photos-page&amp;action=image-defaut" method="post">

		<table style="text-align: left; width: 100%;" cellpadding="2" cellspacing="2" align="center"><tbody>

			<tr><td style="text-align: left; width: 190px;">Image par défaut </td>
				<td style="text-align: left;"> 
					<select class='form-control' name='image_defaut_post' style='margin-right: 5px; width: 280px; display: inline-block;'>
						<option value="" > <?php echo "Image par défaut"; ?> &nbsp; &nbsp; </option>

						<?php

							///////////////////////////////SELECT BOUCLE
							$req_boucle = $bdd->prepare("SELECT * FROM pages_a_b_image WHERE id_page=?");
							$req_boucle->execute(array($_SESSION['id_page_photo']));
							while($ligne_boucle = $req_boucle->fetch()){
							$idimmmagee_image_d = $ligne_boucle['id'];
							$img_lien_image_d = $ligne_boucle['img_lien'];
							$img_title_image_d = $ligne_boucle['img_title'];
							$img_title_image_d = $ligne_boucle['img_title'];
							$defaut_image_d = $ligne_boucle['defaut'];

							if($defaut_image_d == "oui"){
								?>
								<option selected='selected' value="<?php echo "$idimmmagee_image_d"; ?>" > <?php echo "$img_lien_image_d"; ?> &nbsp; &nbsp; </option>
								<?php
							}else{
								?>
								<option value="<?php echo "$idimmmagee_image_d"; ?>" > <?php echo "$img_lien_image_d"; ?> &nbsp; &nbsp; </option>
								<?php
							}

						}
						$req_boucle->closeCursor();
						?>
					</select>
					<input type="submit" class="btn btn-success" name='submit_image_defaut' value="ATTRIBUER" /> </td></tr>
			<tr><td colspan="2" >&nbsp;</td></tr>

		</tbody></table>
	</form>

	<div style='text-align: left;'>
		<h2>Images de la page <br />
			<small><?php echo "<a href='".$pagesa."' target='_blank'>$pagesa</a>"; ?></small></h2>
		</div>
		<div style='clear: both;'></div>


		<script>
			$(document).ready(function(){
				$('#Tableau_a').DataTable(
				{
					"columnDefs": [
					{ "orderable": false, "targets": 1, },
					],
					"language": {
						"sProcessing":     "Traitement en cours...",
						"sSearch":         "Rechercher&nbsp;:",
						"sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
						"sInfo":           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
						"sInfoEmpty":      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
						"sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
						"sInfoPostFix":    "",
						"sLoadingRecords": "Chargement en cours...",
						"sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
						"sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
						"oPaginate": {
							"sFirst":      "Premier",
							"sPrevious":   "Pr&eacute;c&eacute;dent",
							"sNext":       "Suivant",
							"sLast":       "Dernier"
						},
						"oAria": {
							"sSortAscending":  ": activer pour trier la colonne par ordre croissant",
							"sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
						}
					}
				}
				);

			});
		</script>

		<table id='Tableau_a' class="display" style="text-align: center; width: 100%; margin-top: 15px; " cellpadding="2" cellspacing="2">

			<thead>
				<tr>
					<th style="text-align: center;">IMAGES</th>
					<th style="text-align: center; width: 90px;">SUPPRIMER</th>
				</tr>
			</thead>
			<tbody>
				<?php
					///////////////////////////////SELECT BOUCLE
					$req_boucle = $bdd->prepare("SELECT * FROM pages_a_b_image WHERE id_page=?");
					$req_boucle->execute(array($_SESSION['id_page_photo']));
					while($ligne_boucle = $req_boucle->fetch()){
					$idimmmagee = $ligne_boucle['id'];
					$img_lien = $ligne_boucle['img_lien'];
					$img_title = $ligne_boucle['img_title'];

					?>
					<tr><td style="text-align: center;"><div id='ancre_p'><?php echo "<a href='/images/pages/".$img_lien."' target='_blank'>$img_lien</a>"; ?></div></td>
						<td style="text-align: center; width: 90px;"><?php echo "<a href='?page=Photos-page&amp;action=delete&amp;idaction=".$idimmmagee."'><span class='uk-icon-times'></span></a>"; ?></td></tr>
						<?php
					}
					$req_boucle->closeCursor();
					?>

					<tbody>
					</table>
					<br /><br />

<?php
}else{
header('location: /index.html');
}
?>