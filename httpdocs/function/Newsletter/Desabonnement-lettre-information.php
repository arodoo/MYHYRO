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

$action = mysql_real_escape_string($_GET['action']);
$crypt = mysql_real_escape_string($_GET['crypt']);

if($action == "delete"){

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM Newsletter_listing WHERE Numero_id=?");
$req_select->execute(array($crypt));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$idmaiNumeroid = $ligne_select['Numero_id'];

///////////////////////////////DELETE
$sql_delete = $bdd->prepare("DELETE FROM Newsletter_listing WHERE Numero_id=?");
$sql_delete->execute(array($idmaiNumeroid));                     
$sql_delete->closeCursor();

if($req6 == true){
////////////RAPPORT JS
?>
<script language="javascript" type="text/javascript">
alert("Votre adresse mail à bein été ajoutée !");
document.location.replace("/");
</script>
<?php
////////////RAPPORT JS

}else{
////////////RAPPORT JS
?>
<script language="javascript" type="text/javascript">
alert("Une erreur est survenue !");
document.location.replace("");
</script>
<?php
////////////RAPPORT JS
}

}else{
////////////RAPPORT JS
?>
<script language="javascript" type="text/javascript">
document.location.replace("/");
</script>
<?php
////////////RAPPORT JS
}
?>