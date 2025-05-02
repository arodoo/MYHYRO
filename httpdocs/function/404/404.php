<?php
ob_start();

require_once('Configurations.php');

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

$pageencours = $_SERVER['REQUEST_URI'];
$pageencours = utf8_decode(urldecode($pageencours)); 

$pageencoursnew = explode("".$http."$nomsiteweb", $pageencours);
$pageencoursnew = $pageencoursnew['0'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta name="keywords" content="La page <?php echo "$pageencoursnew"; ?> n'existe pas"/>
<meta http-equiv="Content-Language" content="fr"/>
<meta name="reply-to" content="<?php echo "$emaildefault"; ?>"/>
<meta name="Author" lang="fr" content="Auteur: <?php echo "$nom_proprietaire"; ?> "/>
<meta name="copyright" content="<?php echo "$nom_proprietaire"; ?>"/>
<meta name="identifier-url" content="<?php echo "$http"; ?><?php echo "$nomsiteweb"; ?>"/>
<meta name="publisher" content="<?php echo "$nom_proprietaire"; ?>"/>
<meta name="category" content="Erreur 404, la page indiqué n'existe pas"/>
<meta http-equiv="Pragma" content="no-cache"/>
<meta name="Classification" content= "Erreur 404, la page indiqué n'existe pas"/> 
<meta name="organization" content="<?php echo "$nom_proprietaire"; ?>"/>
<meta name="owner" content="<?php echo "$nom_proprietaire"; ?>"/>

<title>La page <?php echo "$pageencoursnew"; ?> n'existe pas</title>

<meta name="description" content="La page <?php echo "$pageencoursnew"; ?> n'existe pas"/>
</head>
<body style='background-color: <?php echo "$couleurFOND"; ?>; color: <?php echo "$couleurbordure"; ?>'>

<div style='margin-left: auto; margin-right: auto; width: 600px; margin-top: 70px;' align='center'>
<h1 style='font-size: 48px;'>Page inexistante</h1>
<p style='text-align: center; font-size: 24px;'>
Vous êtes sur le site internet de <?php echo "$nom_proprietaire"; ?>.<br /><br />
Veuillez nous excuser la page <b><?php echo "$pageencoursnew"; ?></b>
n'existe pas ou l'adresse de l'url n'existe plus, 2 raisons : soit elle a été déplacée ou supprimée par nos services, soit il y a une erreur dans l'url via votre navigateur.</p>

<a href='<?php echo "$http"; ?><?php echo "$nomsiteweb"; ?>' style='text-decoration: none; font-size: 18px; color: <?php echo "$couleurbordure"; ?>'>Retourner sur le site ici</a>

</div>

</body>
</html>
<?php
ob_end_flush();
?>
