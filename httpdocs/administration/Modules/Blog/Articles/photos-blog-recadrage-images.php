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


///////////////////////////////////////////////////////////////////////////////////////////VARIABLES / CONFIGURATIONS
$page_fonction = "?page=Photos-blog"; //Page d'ou est appélé le script
$recadrage_active = "oui"; //activation du recadrage
$activer_title = "oui"; //activation titre avec l'image
$retour_page = "non"; //activation du bouton de retour vers une page
$retour_page_text = ""; //text du bouton
$page_retour_url = ""; //url page retour

////////TYPE D'IMAGE VOULU : 
// large => plus large que haute
// haute => plus haute que large
// egale => longueur = largeur
$type_image_voulu = "large";

////////TAILLES
$large_min_img = "800";// largeur minimal image de départ (ENVIRON 200px DE PLUS QUE LA TAILLE SOUHAITEE)
$haute_min_img = "497"; // hauteur minimal image de départ (ENVIRON 200px DE PLUS QUE LA TAILLE SOUHAITEE)
$large_img_finale = "800"; //largeur de l'image finale crée
$haute_img_finale = "497"; //hauteur de l'image finale crée

$repertoire = "public_html/images/blog"; // répertoire d'upload
$repertoire_chmod = "../images/blog"; //répertoire du chmod

$insert_sql = "oui"; //insertion en sql ou non
//Requette d'insertion ou update SQL
//variable image : $_SESSION['namebruto_extension']
//variable image recadrée : "2-".$_SESSION['namebruto_extension']
//variable titre image : $_SESSION['attributs_title_alt_image']

///////////////////////////////INSERT
$sql_insert = $bdd->prepare("INSERT INTO codi_one_blog_a_b_image
	(img_lien,
	img_lien2,
	img_title,
	img_alt,
	id_page,
	defaut)
	VALUES (?,?,?,?,?,?)");

$caractere_replace_repertoire = "../function/cara_replace.php"; //chemin fonction cara_replace.php
///////////////////////////////////////////////////////////////////////////////////////////VARIABLES / CONFIGURATIONS

?>

<script type="text/javascript">
$(function(){
$('#box').Jcrop({
onSelect: updateCoords,
bgFade: true,
bgOpacity: .2,        
boxWidth: <?php echo $large_img_finale; ?>, 
boxHeight: <?php echo $haute_img_finale; ?>,
aspectRatio : <?php echo "$large_img_finale/$haute_img_finale"; ?>,
minSize : [200,200],
maxSize : [<?php echo $large_img_finale; ?>,<?php echo $haute_img_finale; ?>],
setSelect: [ 0, 0, 200, 200 ]
},function(){
jcrop_api = this;
});
});

function updateCoords(c){
$('#x').val(c.x);
/*console.log(c.x);*/
$('#y').val(c.y);
/*console.log(c.y);*/
$('#w').val(c.w);
/*console.log(c.w);*/
$('#h').val(c.h);
/*console.log(c.h);*/
};

function checkCoords(){
if (parseInt($('#w').val())) return true;
alert('Il vous faut recadrer votre image, puis sauvegarder.');
return false;
};
</script>

<?php

///////////////////////////////////////////////////////////////////////////DEBUT PAGE

$actionn = $_GET['actionn'];
$submit_recadrage = $_POST['submit_recadrage'];
$nomphotopost = $_POST['nomphotopost'];

///////////////////////////////////////////////////////////////////////////IF RECADRAGE
if ($actionn == "recadrage"){

	if($recadrage_active == "oui"){

		$targ_w = "$large_img_finale";
		$targ_h = "$haute_img_finale";
		$jpeg_quality = 100;
		$src = "".$repertoire_chmod."/".$_SESSION['namebruto_extension'].""; 
		$src2 = "".$repertoire_chmod."/2-".$_SESSION['namebruto_extension']."";

	    if(substr($_SESSION['namebruto_extension'], -4) == "jpeg" || substr($_SESSION['namebruto_extension'], -4) == "JPEG" || substr($_SESSION['namebruto_extension'], -3) == "jpg" || substr($_SESSION['namebruto_extension'], -3) == "JPG" ){			
		$img_r = imagecreatefromjpeg($src);
		$dst_r = ImageCreateTrueColor($targ_w,$targ_h);
		imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],$targ_w,$targ_h,$_POST['w'],$_POST['h']);
		imagejpeg($dst_r, "$src2", 100); 
		}

	    if(substr($_SESSION['namebruto_extension'], -3) == "png" || substr($_SESSION['namebruto_extension'], -3) == "PNG"){
		$img_r = imagecreatefrompng($src);
		$dst_r = imagecreatetruecolor($targ_w,$targ_h);
		imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],$targ_w,$targ_h,$_POST['w'],$_POST['h']);
		imagepng($dst_r, "$src2");
		}

	}

	if($insert_sql == "oui"){
	$sql_insert->execute(array(
		$_SESSION['namebruto_extension'],
		"2-".$_SESSION['namebruto_extension']."",
		$_SESSION['attributs_title_alt_image'],
		$_SESSION['attributs_title_alt_image'],
		$_SESSION['id_page_photo_2'],
		''));                     
	$sql_insert->closeCursor();
	}

	$image_upload_affiche = $_SESSION['namebruto_extension'];
	$_SESSION['image_upload_affiche'] = "$image_upload_affiche";

	////////////RAPPORT JS
	?>
	<script language="javascript" type="text/javascript">
	document.location.replace("<?php echo $page_fonction; ?>&amp;action=informations&amp;actionn=oui&amp;upload_et_recadrage_ok=recadrage");
	</script>
	<?php
	////////////RAPPORT JS
}
///////////////////////////////////////////////////////////////////////////IF RECADRAGE



////////////Upload des images
if($actionn == "upload"){

       $icon = $_FILES['images']['name'];

        if(substr($icon, -4) == "jpeg" || substr($icon, -4) == "JPEG" || substr($icon, -3) == "jpg" || substr($icon, -3) == "JPG" || substr($icon, -3) == "png" || substr($icon, -3) == "PNG"){

		if (!empty($icon)){

			$icon = $_FILES['images']['name'];
			$taille = $_FILES['images']['size'];
			$tmp = $_FILES['images']['tmp_name'];
			$type = $_FILES['images']['type'];
			$erreur = $_FILES['images']['error'];
			$source_file = $_FILES['images']['tmp_name'];
			$destination_file = "$repertoire/$icon";
			unset($_SESSION['namebruto_extension']);
			unset($_SESSION['attributs_title_alt_image']);

			$namebrut = explode('.', $icon);
			$namebruto = $namebrut[0];
			$now = time();
			$namebruto = "$namebruto-$now";

			$nouveaucontenu = "$namebruto";
			include("$caractere_replace_repertoire");
			$namebruto = "$nouveaucontenu";

			$repertoire_move = "$repertoire_chmod/$icon";
			move_uploaded_file($tmp, $repertoire_move);

			chmod("$repertoire_chmod/$icon", 0777);

			$size_origine_controle = getimagesize("$repertoire_chmod/$icon") ;

			///////////Produit en croix
			$gettsizee = getimagesize("$repertoire_chmod/$icon");
			$largeur =  $gettsizee[0];
			$hauteur = $gettsizee[1];
			///////////Produit en croix

			//////////////////////////////////////////////VERIFICATION SIZE IMAGE

			unset($hauteur_ok);
			unset($largeur_ok);

			if($type_image_voulu == "large"){

				if($largeur > $hauteur){

					if($largeur >= $large_min_img){
						if($hauteur >= $haute_min_img){
							$hauteur_ok = "oui";
							$largeur_ok = "oui";
							$newhauteur = round($hauteur*$large_min_img/$largeur);
							$newlargeur = $large_min_img;
							$_SESSION['newhauteur'] = $newhauteur;
							$_SESSION['newlargeur'] = $newlargeur;
						}else{
							$erreur_upload = "L'image n'est pas assez haute, minimum ".$haute_min_img."px !";
						}
					}else{
						$erreur_upload = "L'image n'est pas assez large, minimum ".$large_min_img."px !";
					}

				}else{
					$erreur_upload = "L'image doit être plus large que haute !";
				}			

			}elseif($type_image_voulu == "haute"){
				if($hauteur > $largeur){
					if($largeur >= $large_min_img){
						if($hauteur >= $haute_min_img){
							$hauteur_ok = "oui";
							$largeur_ok = "oui";
							$newhauteur = $haute_min_img;
							$newlargeur = round($largeur*$haute_min_img/$hauteur);							
							$_SESSION['newhauteur'] = $newhauteur;
							$_SESSION['newlargeur'] = $newlargeur;
						}else{
							$erreur_upload = "L'image n'est pas assez haute, minimum ".$haute_min_img."px !";
						}
					}else{
						$erreur_upload = "L'image n'est pas assez large, minimum ".$large_min_img."px !";
					}

				}else{
					$erreur_upload = "L'image doit être plus haute que large !";
				}
			}elseif($type_image_voulu == "egale"){
				if($largeur >= $large_min_img){
					if($hauteur >= $haute_min_img){
						$hauteur_ok = "oui";
						$largeur_ok = "oui";
						$newhauteur = $haute_min_img;
						$newlargeur = round($largeur*$haute_min_img/$hauteur);
						$_SESSION['newhauteur'] = $newhauteur;
						$_SESSION['newlargeur'] = $newlargeur;
					}else{
						$erreur_upload = "L'image n'est pas assez haute, minimum ".$haute_min_img."px !";
					}
				}else{
					$erreur_upload = "L'image n'est pas assez large, minimum ".$large_min_img."px !";
				}
			}

			//////////////////////////////////////////////VERIFICATION SIZE IMAGE

			if($hauteur_ok == "oui" && $largeur_ok == "oui"){				

					//////////////Redimensionner en jpeg
					if(substr($icon, -4) == "jpeg" || substr($icon, -4) == "JPEG" || substr($icon, -3) == "jpg" || substr($icon, -3) == "JPG"){
						$img_bigee = imagecreatefromjpeg("$repertoire_chmod/$icon");
						$img_miniee = imagecreatetruecolor($newlargeur, $newhauteur);
						imagecopyresampled($img_miniee,$img_bigee,0,0,0,0,$newlargeur,$newhauteur,$largeur,$hauteur);
						imagejpeg($img_miniee, "$repertoire_chmod/$namebruto.jpg", 100); 
						$_SESSION['namebruto_extension'] = "".$namebruto.".jpg";
					}//////////////Redimensionner en jpeg

					//////////////Redimensionner en png
					if(substr($icon, -3) == "png" || substr($icon, -3) == "PNG"){
						$img_bigee = imagecreatefrompng("$repertoire_chmod/$icon");
						$img_miniee = imagecreatetruecolor($newlargeur, $newhauteur);
						imagecopyresampled($img_miniee,$img_bigee,0,0,0,0,$newlargeur,$newhauteur,$largeur,$hauteur);
						imagepng($img_miniee,"$repertoire_chmod/$namebruto.png");
						$_SESSION['namebruto_extension'] = "$namebruto.png";
					}//////////////Redimensionner en png

					$_SESSION['attributs_title_alt_image'] = "$nomphotopost";
					unlink("$repertoire_chmod/$icon");

					///////////////////////////////ACTIONS
					$now = time();
					$uploadok = "oui";
					///////////////////////////////ACTIONS

			}

		}//if !empty($icon)

		////////////Si n'est pas une image ou si aucune image choisie
		}elseif(!empty($icon)){
		$erreur_upload = "Seulement les images sont autorisées";
		}else{
		$erreur_upload = "Une erreur est survenue, merci de tenter à nouveau le téléchargement !";
		}
		////////////Si n'est pas une image ou si aucune image choisie


////////////Erreur champ nom de l'image vide
}elseif($actionn == "upload"){
$erreur_upload = "Une erreur est survenue, merci de tenter à nouveau le téléchargement !";
}
////////////Erreur autre

////////////Upload des images




////////////////////////////////////////RECADRAGE FORMULAIRE
if($uploadok == "oui" && $recadrage_active == "oui" && empty($erreur_upload)){
?>

	<div style='width: <?php echo $large_img_finale; ?>px; height: <?php echo $haute_img_finale; ?>px;'>
		<img src="/<?php echo "".$repertoire_chmod."/".$_SESSION['namebruto_extension'].""; ?>" id="box" alt="Image" width="<?php echo $_SESSION['newlargeur']; ?>"/>
	</div>

	<div style='clear: both;'></div>

	<br />

	<form id='recadrage' action="<?php echo "$page_fonction"; ?>&amp;action=informations&amp;actionn=recadrage" method="post" onsubmit="return checkCoords();" >
		<input type="hidden" id="x" name="x" />
		<input type="hidden" id="y" name="y" />
		<input type="hidden" id="w" name="w" />
		<input type="hidden" id="h" name="h" />
		<input type="submit" name='submit_recadrage' value="Sauvegarder le recadrage" />
	</form>

<?php
////////////////////////////////////////RECADRAGE FORMULAIRE

////////////////////////////////////////UPLOAD FORMULAIRE
}else{

	
	if($_GET['upload_et_recadrage_ok'] == "oui"){
		if($retour_page == "non"){
		?>
			<span class='rapport' style='color: green;'>Votre image a été téléchargée avec succès, vous pouvez fermer cet onglet ou ajouter une nouvelle image!</span><br /><br />
		<?php

		}else{
	?>
			<span class='rapport' style='color: green;'>Votre image à été téléchargée avec succès !</span><br /><br />
			<input type="button" name='retour-page' value="<?php echo $retour_page_text; ?>" onclick='window.location.href="<?php echo $page_retour_url; ?>";'/>
	<?php
		}
	}else{
		if(!empty($erreur_upload)){
			echo "<span class='rapport' style='color: red;'>$erreur_upload</span> <br /><br />";
		}

?>

	<form id='upload' action="<?php echo "$page_fonction"; ?>&amp;action=recadrage&amp;actionn=upload" method="post" enctype="multipart/form-data">

		<table style="text-align: left; width: 100%;" cellpadding="2" cellspacing="2" ><tbody>

			<tr>
			<td style="text-align: left;">
<img src="/images/pas-de-photo.png" alt="<?php echo "Image"; ?>" width="150" onclick="clickinputfile('images');" style='cursor: pointer;' />
<input type='file' name='images' id="images" style='width: 100%;' hidden onchange="document.getElementById('upload').submit();" /><br />
<div style='display: inline-block; font-weight: bold; cursor: pointer;' onclick="clickinputfile('images');">Télécharger une image</div>
			</td>
			</tr>

		</table>
	</form>

<?php
	}
}
////////////////////////////////////////UPLOAD FORMULAIRE
?>

