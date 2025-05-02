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

if($Pays == "France"){
$selected_France = "selected='selected'";
}elseif($Pays == "Grande-Bretagne"){
$selected_GrandeBretagne = "selected='selected'";
}elseif($Pays == "Irlande"){
$selected_Irlande = "selected='selected'";
}elseif($Pays == "Espagne"){
$selected_Espagne = "selected='selected'";
}elseif($Pays == "Portugal"){
$selected_Portugal = "selected='selected'";
}elseif($Pays == "Italie"){
$selected_Italie = "selected='selected'";
}elseif($Pays == "Suisse"){
$selected_Suisse = "selected='selected'";
}elseif($Pays == "Luxembourg"){
$selected_Luxembourg = "selected='selected'";
}elseif($Pays == "Belgique"){
$selected_Belgique = "selected='selected'";
}elseif($Pays == "Pays-bas"){
$selected_Paysbas = "selected='selected'";
}elseif($Pays == "Allemagne"){
$selected_Allemagne = "selected='selected'";
}elseif($Pays == "Autriche"){
$selected_Autriche = "selected='selected'";
}elseif($Pays == "Danemark"){
$selected_Danemark = "selected='selected'";
}elseif($Pays == "Finlande"){
$selected_Finlande = "selected='selected'";
}elseif($Pays == "Grece"){
$selected_Grece = "selected='selected'";
}elseif($Pays == "Hongrie"){
$selected_Hongrie = "selected='selected'";
}elseif($Pays == "Islande"){
$selected_Islande = "selected='selected'";
}elseif($Pays == "Norvege"){
$selected_Norvege = "selected='selected'";
}elseif($Pays == "Pologne"){
$selected_Pologne = "selected='selected'";
}elseif($Pays == "Suede"){
$selected_Suede = "selected='selected'";
}elseif($Pays == "Croatie"){
$selected_Croatie = "selected='selected'";
}
?>

<select class="form-control" id='Pays' name='Pays' >
<option <?php echo "$selected_France"; ?> value="France"><?php echo "France"; ?></option>
<?php
if($Inscription_residentfrancais == "non"){
?>
<option <?php echo "$selected_Allemagne"; ?> value="Allemagne"> <?php echo "Allemagne"; ?></option>
<option <?php echo "$selected_Autriche"; ?> value="Autriche"><?php echo "Autriche"; ?></option>
<option <?php echo "$selected_Belgique"; ?> value="Belgique"><?php echo "Belgique"; ?></option>
<option <?php echo "$selected_Croatie"; ?> value="Croatie"><?php echo "Croatie"; ?></option>
<option <?php echo "$selected_Danemark"; ?> value="Danemark"><?php echo "Danemark"; ?></option>
<option <?php echo "$selected_Espagne"; ?> value="Espagne"><?php echo "Espagne"; ?></option>
<option <?php echo "$selected_Finlande"; ?> value="Finlande"><?php echo "Finlande"; ?></option>
<option <?php echo "$selected_GrandeBretagne"; ?> value="Grande-Bretagne"><?php echo "GrandeBretagne"; ?></option>
<option <?php echo "$selected_Grece"; ?> value="Grece"><?php echo "Grece"; ?></option>
<option <?php echo "$selected_Hongrie"; ?> value="Hongrie"><?php echo "Hongrie"; ?></option>
<option <?php echo "$selected_Irlande"; ?> value="Irlande"><?php echo "Irlande"; ?></option>
<option <?php echo "$selected_Islande"; ?> value="Islande"><?php echo "Islande"; ?></option>
<option <?php echo "$selected_Italie"; ?> value="Italie"><?php echo "Italie"; ?></option>
<option <?php echo "$selected_Luxembourg"; ?> value="Luxembourg"><?php echo "Luxembourg"; ?></option>
<option <?php echo "$selected_Norvege"; ?> value="Norvege"><?php echo "Norvege"; ?></option>
<option <?php echo "$selected_Paysbas"; ?> value="Pays-bas"><?php echo "Paysbas"; ?></option>
<option <?php echo "$selected_Pologne"; ?> value="Pologne"><?php echo "Pologne"; ?></option>
<option <?php echo "$selected_Portugal"; ?> value="Portugal"><?php echo "Portugal"; ?></option>
<option <?php echo "$selected_Suede"; ?> value="Suede"><?php echo "Suede"; ?></option>
<option <?php echo "$selected_Suisse"; ?> value="Suisse"><?php echo "Suisse"; ?></option>
<?php
}
?>
</select>