<?php

ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../../Configurations_bdd.php');
require_once('../../../Configurations.php');
require_once('../../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction= "../../../";
require_once('../../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

$lasturl = $_SERVER['HTTP_REFERER'];

function upload_images($idaction, $bdd)
{
	// die('cidsds');2 097 152       1 384 820
	
	
		
	if($idaction != 1)
	{
		if(!empty( $_FILES['image']))
		{
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp' , 'pdf' , 'doc' , 'ppt'); // valid extensions
			$path = '../../../images/pages/'; // upload directorydirectory
			$path2 = '/images/pages/'; // upload directorydirectory
				
			// $db->query("DELETE FROM pages_a_b_image WHERE id_page=?;");
			// $insert_image->execute(array($idaction)); 
			// $insert_image->closeCursor();
			
			$img = $_FILES['image']['name'];
			$tmp = $_FILES['image']['tmp_name'];
			// get uploaded file's extension
			$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
			// can upload same image using rand function
			$final_image = rand(1000,1000000). '_'.rand(1000,1000000).$img;
			// check's valid format
			$img_title = "Image de bandeau de ".$postpagetitle;
			
			if(in_array($ext, $valid_extensions)) 
			{ 
				// $path = $path.strtolower($final_image); 
				$path = $path.basename($final_image);
				$path2 = $path2.basename($final_image);
				// move_uploaded_file($tmp_name, "$uploads_dir/$name");
				if(move_uploaded_file($tmp,$path)) 
				{
					
					
					$req_select_page = $bdd->prepare("SELECT * FROM pages WHERE id=?  ORDER BY id DESC LIMIT 1");
					$req_select_page->execute(array(intval($idaction)));
					$page = $req_select_page->fetch();
					$id_page = $page['id'];
					$req_select_page->closeCursor();
					
					$req_select_image = $bdd->prepare("SELECT * FROM pages_a_b_image WHERE id_page=?  LIMIT 1");
					$req_select_image->execute(array(intval($idaction)));
					$image = $req_select_image->fetch();
					$req_select_image->closeCursor();
					
					if($image)
					{
						
						$sql_update_image = $bdd->prepare("UPDATE pages_a_b_image SET img_lien=?, img_lien2=?,img_title=?,img_alt=?,defaut=?  WHERE id_page=?");
						$sql_update_image->execute(array($path2,$path2,$img_title,$img_title,"images/banner.jpg",$idaction));                     
						$sql_update_image->closeCursor();
						
						
					}else{
						
						$req_select_image = $bdd->prepare("SELECT * FROM pages_a_b_image ORDER BY id DESC  LIMIT 1");
						$req_select_image->execute(array(intval($idaction)));
						$image = $req_select_image->fetch();
						$last_id = $image['id'] + 1;
						$req_select_image->closeCursor();
						
						$sql_insert_image = $bdd->prepare("INSERT INTO pages_a_b_image (id,img_lien,img_lien2,img_title,img_alt,id_page,defaut) VALUES (?,?,?,?,?,?,?)");
						
						$sql_insert_image->execute(array($last_id,$path2,$path2,$img_title,$img_title,$idaction,"images/banner.jpg")); 
						$sql_insert_image->closeCursor();
						
					}
					
					
					// $insert_image->execute(array("images/banner.jpg","images/banner.jpg",$img_title,$img_title,$id_image,"images/banner.jpg")); 
					// $insert_image->closeCursor();
					//echo $insert?'ok':'err';
					$message_image = "avec ajout de l'image de bandeau";
					
				}
			} 
			else 
			{
				$message_image = "sans ajout de l'image de bandeau";
			}
		}
	}else{
		if($_FILES['images'])
		{
			
			
			$countfiles = count($_FILES['images']['name']);
			
			for($i=1;$i<=$countfiles;$i++){
				if($_FILES['images']['size'][$i] < 2097152){	
					// $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp' , 'pdf' , 'doc' , 'ppt'); // valid extensions
					$valid_extensions = array('jpeg', 'jpg', 'png'); // valid extensions
					$path = '../../../images/pages/'; // upload directorydirectory
					$path2 = '/images/pages/'; // upload directorydirectory
						
					$img = $_FILES['images']['name'][$i];
					$tmp = $_FILES['images']['tmp_name'][$i];
					
					$final_image =null;
					$title = null;
					$text = null;
					$active = null;
					
					$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
					// can upload same image using rand function
					$final_image = rand(1,1000000). '_'.rand(1,1000000). '_'.rand(1,1000000).".".$ext;
					$title = $_POST['title'][$i];
					$text = $_POST['text'][$i];
					$active = $_POST['activer'][$i];
					
					// check's valid format
					$img_title = "Image de slider de l'accueil";
					if(in_array($ext, $valid_extensions)) 
					{ 
						// $path = $path.strtolower($final_image); 
						$path = $path.basename($final_image);
						$path2 = $path2.basename($final_image);
						// move_uploaded_file($tmp_name, "$uploads_dir/$name");
						if(move_uploaded_file($tmp,$path)) 
						{
							$sql_insert_image = $bdd->prepare("INSERT INTO page_accueil_sliders (img_link,title_slider,text_silder,activer) VALUES (?,?,?,?)");						
							$sql_insert_image->execute(array($path2,$title,$text,$active)); 
							$sql_insert_image->closeCursor();
						}
					}
				}
			}
		}
	}
	
}

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

	$action = $_POST['action'];
$idaction = $_POST['idaction'];

$now = time();

$postpagecategorie = $_POST['postpagecategorie'];
$postpagetitle = $_POST['postpagetitle'];
$contenupagepost = $_POST['contenupagepost'];
$menu_pagepost = $_POST['menu_pagepost'];
$positiondansmenupostpage = $_POST['positiondansmenupostpage'];

$presence_footer = $_POST['presence_footer'];
$positiondansfooterpostpage = $_POST['positiondansfooterpostpage'];
$ancrelienfooterpostpage = $_POST['ancrelienfooterpostpage'];

$titreh1postpage = $_POST['titreh1postpage'];
$ancrelienmenupostpage = $_POST['ancrelienmenupostpage'];
$ancrefildarianepostpage = $_POST['ancrefildarianepostpage'];
$activer = $_POST['activer'];
$declaree_dans_site_map_xml_pagepost = $_POST['declaree_dans_site_map_xml_pagepost'];

$metamotsclespagepost = $_POST['metamotsclespagepost'];
$metadescriptionpagepost = $_POST['metadescriptionpagepost'];
$titlepagepost = $_POST['titlepagepost'];

$levelpagepost = $_POST['levelpagepost'];
$datemodifpagepost = $_POST['datemodifpagepost'];
$frequencepagepost = $_POST['frequencepagepost'];

$Page_fixepost = $_POST['Page_fixepost'];
$Page_type_module_ou_page = $_POST['Page_type_module_ou_page'];

$Page_admin_associeepost = $_POST['Page_admin_associeepost'];

if($Page_type_module_ou_page == "Page web"){
	$Page_web_categorie  = $_POST['Page_web_categorie'];
}elseif($Page_type_module_ou_page == "Page boutique"){
	$Page_web_categorie  = $_POST['Page_web_categorie_boutique'];
}else{
	$Page_web_categorie  = $_POST['Page_web_categorie'];
}


$afficher_reseaux_sociaux_page = $_POST['afficher_reseaux_sociaux_page'];

$contenu_video = $_POST['contenu_video'];

$id_categorie  = $_POST['id_categorie'];

$mise_en_avant  = $_POST['mise_en_avant'];

/////////////////////////////////////////Ajouter action
if($action == "add2"){

	if($Page_type_module_ou_page == "Module"){
		unset($image_post_banniere_parallaxe);
	}

	$nowdatesitemap = date('Y-m-d');

///////////////////////////////INSERT
	$sql_insert = $bdd->prepare("INSERT INTO pages
		(id_categorie,
		Page,
		Page_nom,
		contenu_de_la_page,
		categorie_menu,
		position_menu,
		Ancre_lien_menu,
		presence_footer,
		position_footer,
		Ancre_lien_footer,
		Titre_h1,
		Ancre_fil_ariane,
		Title,
		Metas_description,
		Metas_mots_cles,
		Site_map_xml_date_mise_a_jour,
		Site_map_xml_propriete,
		Site_map_xml_frequence_mise_a_jour,
		Declaree_dans_site_map_xml,
		Statut_page,
		Page_fixe,
		Page_type_module_ou_page,
		Page_admin_associee,
		date,
		afficher_reseaux_sociaux_page,
		contenu_video,
		plus,
		mise_en_avant)
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
	$sql_insert->execute(array(
		$id_categorie,
		$postpagetitle,
		$postpagetitle,
		$contenupagepost,
		$menu_pagepost,
		$positiondansmenupostpage,
		$ancrelienmenupostpage,
		$presence_footer,
		$positiondansfooterpostpage,
		$ancrelienfooterpostpage,
		$titreh1postpage,
		$ancrefildarianepostpage,
		$titlepagepost,
		$metadescriptionpagepost,
		$metamotsclespagepost,
		$nowdatesitemap,
		$levelpagepost,
		$frequencepagepost,
		$declaree_dans_site_map_xml_pagepost,
		$activer,
		$Page_fixepost,
		$Page_type_module_ou_page,
		$Page_admin_associeepost,
		$now,
		$afficher_reseaux_sociaux_page,
		$contenu_video,
		$_SESSION['idsessionp'],
		$mise_en_avant));                     
	$sql_insert->closeCursor();

///////////////////////////////SELECT
	$req_select = $bdd->prepare("SELECT * FROM pages WHERE Plus=?");
	$req_select->execute(array($_SESSION['idsessionp']));
	$ligne_select = $req_select->fetch();
	$req_select->closeCursor();
	$id_image = $ligne_select['id'];

	$_SESSION['idsessionp'] = $id_image;

//////////////////////////////////////On nome l'url de la page si ce n'est pas un module
	if($Page_type_module_ou_page != "Module"){
		$nouveaucontenu = "$postpagetitle";
		include("../../../function/cara_replace.php");
		$postpagetitle = "$nouveaucontenu";
		$postpagetitle = "".$postpagetitle."";
	}
//////////////////////////////////////On nome l'url de la page si ce n'est pas un module

///////////////////////////////UPDATE
	$sql_update = $bdd->prepare("UPDATE pages SET Page=?, Page_nom=? WHERE id=?");
	$sql_update->execute(array($postpagetitle,$postpagetitle,$id_image));                     
	$sql_update->closeCursor();

/////////////////////////MISE A JOUR DE L'ID POUR LES IMAGES DE L'ARTICLE
///////////////////////////////SELECT BOUCLE
	$req_boucle = $bdd->prepare("SELECT * FROM pages_a_b_image WHERE id_page=? ");
	$req_boucle->execute(array($_SESSION['id_page_photo']));
	while($ligne_boucle = $req_boucle->fetch()){
		$id_image_update = $ligne_boucle['id'];

///////////////////////////////UPDATE
		$sql_update = $bdd->prepare("UPDATE pages_a_b_image SET id_page=? WHERE id=?");
		$sql_update->execute(array($id_image,$id_image_update));                     
		$sql_update->closeCursor();

	}
	$req_boucle->closeCursor();
	
	$message_image = "";
	
	if($_FILES['images'])
		{
			
			$message = '';
			$countfiles = count($_FILES['images']['name']);
			
			for($i=1;$i<=$countfiles;$i++){
				if($_FILES['images']['size'][$i] < 2097152){	
					// $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp' , 'pdf' , 'doc' , 'ppt'); // valid extensions
					$valid_extensions = array('jpeg', 'jpg', 'png'); // valid extensions
					$path = '../../../images/pages/'; // upload directorydirectory
					$path2 = '/images/pages/'; // upload directorydirectory
						
					$img = $_FILES['images']['name'][$i];
					$tmp = $_FILES['images']['tmp_name'][$i];
					
					$final_image =null;
					$title = null;
					$text = null;
					$active = null;
					
					$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
					// can upload same image using rand function
					$final_image = rand(1,1000000). '_'.rand(1,1000000). '_'.rand(1,1000000).".".$ext;
					$title = $_POST['title'][$i];
					$text = $_POST['text'][$i];
					$active = $_POST['activer'][$i];
					
					// check's valid format
					$img_title = "Image de slider de l'accueil";
					if(in_array($ext, $valid_extensions)) 
					{ 
						// $path = $path.strtolower($final_image); 
						$path = $path.basename($final_image);
						$path2 = $path2.basename($final_image);
						// move_uploaded_file($tmp_name, "$uploads_dir/$name");
						if(move_uploaded_file($tmp,$path)) 
						{
							$sql_insert_image = $bdd->prepare("INSERT INTO page_accueil_sliders (img_link,title_slider,text_silder,activer) VALUES (?,?,?,?)");						
							$sql_insert_image->execute(array($path2,$title,$text,$active)); 
							$sql_insert_image->closeCursor();
						}
					}
				}else{
					$message .= " ". $_FILES['images']['name'][$i]." depasse 2 Mega <br>";
				}
			}
		}
	
/////////////////////////MISE A JOUR DE L'ID POUR LES IMAGES DE L'ARTICLE


	$result = array("Texte_rapport"=>"Ajout effectué avec succès $message !","retour_validation"=>"ok","retour_lien"=>"");

}
/////////////////////////////////////////Ajouter action


/////////////////////////////////////////Modification action
if($action == "modifier2"){
	
///////////////////////////////SELECT
	$req_select = $bdd->prepare("SELECT * FROM pages WHERE id=?");
	$req_select->execute(array($idaction));
	$ligne_select = $req_select->fetch();
	$req_select->closeCursor();
	$id = $ligne_select['id'];
	$id_categorie_bdd = $ligne_select['id_categorie'];
	$id_image_parallaxe_banniere = $ligne_select['id_image_parallaxe_banniere'];
	$pagesa = $ligne_select['Page'];
	$pagesa_nom = $ligne_select['Page_nom'];
	$contenu = $ligne_select['contenu_de_la_page'];
	$categorie_menu = $ligne_select['categorie_menu'];
	$Ancre_lien_menu = $ligne_select['Ancre_lien_menu'];
	$Titre_h1 = $ligne_select['Titre_h1'];
	$Ancre_fil_ariane = $ligne_select['Ancre_fil_ariane'];
	$TitreTitrea = $ligne_select['Title'];
	$Metas_description = $ligne_select['Metas_description'];
	$Metas_mots_cles = $ligne_select['Metas_mots_cles'];
	$Site_map_xml_date_mise_a_jour = $ligne_select['Site_map_xml_date_mise_a_jour'];
	$Site_map_xml_propriete = $ligne_select['Site_map_xml_propriete'];
	$Site_map_xml_frequence_mise_a_jour = $ligne_select['Site_map_xml_frequence_mise_a_jour'];
	$Declaree_dans_site_map_xml = $ligne_select['Declaree_dans_site_map_xml'];
	$Statut_page = $ligne_select['Statut_page'];
	$Page_index = $ligne_select['Page_index'];
	$Page_admin = $ligne_select['Page_admin'];
	$Page_fixe = $ligne_select['Page_fixe'];
	$date_upadte_p = $ligne_select['date'];

	if($datemodifpagepost == "oui"){
		$nowdatesitemap = date('Y-m-d');
	}else{
		$nowdatesitemap = "$Site_map_xml_date_mise_a_jour";
	}

	if($Page_fixe != "oui"){
		///////////////////////////////UPDATE
		$sql_update = $bdd->prepare("UPDATE pages SET 
			Page_nom=?
			WHERE id=?");
		$sql_update->execute(array(
			$postpagetitle,
			$idaction
		));                     
		$sql_update->closeCursor();


		//////////////////////////////////////On nome l'url de la page si ce n'est pas un module
		if($Page_type_module_ou_page != "Module"){
			$nouveaucontenu = "$postpagetitle";
			include("../../../function/cara_replace.php");
			$postpagetitle = "$nouveaucontenu";
			$postpagetitle = "".$postpagetitle."";

			///////////////////////////////UPDATE
			$sql_update = $bdd->prepare("UPDATE pages SET 
				Page=?
				WHERE id=?");
			$sql_update->execute(array(
				$postpagetitle,
				$idaction
			));                     
			$sql_update->closeCursor();

		}
		//////////////////////////////////////On nome l'url de la page si ce n'est pas un module
	}

	if($Page_type_module_ou_page != "Module"){

///////////////////////////////UPDATE
		$sql_update = $bdd->prepare("UPDATE pages SET 
			Page_type_module_ou_page=?
			WHERE id=?");
		$sql_update->execute(array(
			$Page_type_module_ou_page,
			$idaction));                     
		$sql_update->closeCursor();

	}

	// var_dump($id_categorie);

///////////////////////////////UPDATE
	$sql_update = $bdd->prepare("UPDATE pages SET 
		id_categorie=?, 
		id_image_parallaxe_banniere=?, 
		contenu_de_la_page=?, 
		Ancre_lien_menu=?, 
		categorie_menu=?, 
		position_menu=?, 
		presence_footer=?, 
		position_footer=?, 
		Ancre_lien_footer=?, 
		Titre_h1=?, 
		Ancre_fil_ariane=?, 
		Title=?, 
		Metas_description=?, 
		Metas_mots_cles=?, 
		Site_map_xml_date_mise_a_jour=?, 
		Site_map_xml_propriete=?,  
		Site_map_xml_frequence_mise_a_jour=?,  
		Declaree_dans_site_map_xml=?, 
		Statut_page=?, 
		date=?,
		afficher_reseaux_sociaux_page=?, 
		contenu_video=?,
		mise_en_avant=?
		WHERE id=?");
	$sql_update->execute(array(
		$id_categorie, 
		$image_post_banniere_parallaxe, 
		$contenupagepost, 
		$ancrelienmenupostpage, 
		$menu_pagepost, 
		$positiondansmenupostpage, 
		$presence_footer,
		$positiondansfooterpostpage,
		$ancrelienfooterpostpage,
		$titreh1postpage, 
		$ancrefildarianepostpage, 
		$titlepagepost, 
		$metadescriptionpagepost, 
		$metamotsclespagepost, 
		$nowdatesitemap, 
		$levelpagepost, 
		$frequencepagepost, 
		$declaree_dans_site_map_xml_pagepost, 
		$activer,
		$now,
		$afficher_reseaux_sociaux_page,
		$contenu_video,
		$mise_en_avant,
		$idaction
	));                     
	$sql_update->closeCursor();
	
	// $message_image = "";
	
	$message_image = "Modifications effectuées ";
	// upload_images($idaction,$bdd);
	if($_FILES['images'])
		{
			
			$pas_charge = "oui";
			$countfiles = count($_FILES['images']['name']);
			

			for($i=1;$i<=$countfiles;$i++){
				
				if($_FILES['images']['size'][$i] < 2097152 ){
					$pas_charge = "non";
					// $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp' , 'pdf' , 'doc' , 'ppt'); // valid extensions
					$valid_extensions = array('jpeg', 'jpg', 'png'); // valid extensions
					$path = '../../../images/pages/'; // upload directorydirectory
					$path2 = '/images/pages/'; // upload directorydirectory
						
					$img = $_FILES['images']['name'][$i];
					$tmp = $_FILES['images']['tmp_name'][$i];
					
					$final_image =null;
					$title = null;
					$text = null;
					$active = null;
					
					$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
					// can upload same image using rand function
					$final_image = rand(1,1000000). '_'.rand(1,1000000). '_'.rand(1,1000000).".".$ext;
					$title = $_POST['title'][$i];
					$text = $_POST['text'][$i];
					$active = $_POST['activer'][$i];
					
					// check's valid format
					$img_title = "Image de slider de l'accueil";
					if(in_array($ext, $valid_extensions)) 
					{ 
						// $path = $path.strtolower($final_image); 
						$path = $path.basename($final_image);
						$path2 = $path2.basename($final_image);
						// move_uploaded_file($tmp_name, "$uploads_dir/$name");
						if(move_uploaded_file($tmp,$path)) 
						{
							$sql_insert_image = $bdd->prepare("INSERT INTO page_accueil_sliders (img_link,title_slider,text_silder,activer) VALUES (?,?,?,?)");						
							$sql_insert_image->execute(array($path2,$title,$text,$active)); 
							$sql_insert_image->closeCursor();
						}
					}else{
						$message_image .= " type image non autorisé";
					}
				}else{
					$pas_charge = "oui";
				}
			}
		}
		if($pas_charge == "oui")
		{
			$message_image = " Modification efectuée. Des images dépassent 2 Méga ";
		}
		
	
	$result = array("Texte_rapport"=>"$message_image !","retour_validation"=>"ok","retour_lien"=>"");

}
/////////////////////////////////////////Modification action

$result = json_encode($result);
echo $result;

}else{
	header('location: /index.html');
}

ob_end_flush();
?>