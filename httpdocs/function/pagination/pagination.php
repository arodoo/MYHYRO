<?php

  /*****************************************************\
  * Adresse e-mail => staff@codi-one.com                *
  * La conception est assujettie à une autorisation     *
  * spéciale de codi-one.com. Si vous ne disposez pas de*
  * cette autorisation, vous êtes dans l'illégalité.    *
  * L'auteur de la conception est et restera            *
  * codi-one.com                                        *
  * Codage, script & images (all contenu) sont réalisés *
  * par codi-one.com                                    *
  * La conception est à usage unique et privé.          *
  * La tierce personne qui utilise le script se porte   *
  * garant de disposer des autorisations nécessaires    *
  *                                                     *
  * Copyright ... Tous droits réservés auteur (Fabien B)*
  \*****************************************************/

/////CALL FONCTION PAGINATION
//pagination("codi_one_blog","1","$nomsiteweb/Blog","Blog");

/////FONCTION PAGINATION
function pagination($table_sql_pagination,$nbrpage,$url_page_accueil,$url_secondaire){

global $bdd,$nomsiteweb,$http,$couleurFOND,$couleurbordure;

$n = $_GET['n'];

/////////////////////CONFIGURATIONS
$calcul_avant = ($n-4);
$calcul_apres = ($n+4);

/////ON VA CHERCHER LE NOMBRE D'ID
///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT COUNT(*) AS nb_mc FROM $table_sql_pagination");
$req_select->execute();
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$NbTOTAUXligne = $ligne_select['nb_mc'];

/////////////////////SI LE NOMBRE D'ID EST SUPERIEUR AU TOTAL DU NOMBRE D'ID PAR PAGE PRE-CONFIGURE
if($NbTOTAUXligne > $nbrpage ){

/////////////////////CONFIGURATIONS
$NBRdivisek  = ($NbTOTAUXligne/$nbrpage);
$NBRdivisekk = round($NBRdivisek,0);
if($NBRdivisekk < $NBRdivisek ){
$NBRdivise = ($NBRdivisekk+1);
}else{
$NBRdivise = "$NBRdivisekk";
}

////////////Si inférieure à une page on affiche et si 'affichage n'est pas égal à la première page
if(empty($n)){
$n = "1";
}

if($n == 2){
$type_url = "rel='canonical'";
}

/////////////////////CONFIGURATIONS

//echo "NOMBRE D'ID EN BDD : $NbTOTAUXligne <br />";
//echo "NOMBRE DE PAGE : $NBRdivise <br />";

echo "<div style='clear: both; margin-right: auto; margin-left: auto; padding: 5px; height: 25px; margin-bottom: 20px;'>";

////////////On calcule pour la flèche "précédent"
$resNmoins = ($n-1);
if($resNmoins == $NBRdivise || $resNmoins < $NBRdivise){
}else{
$resNmoins = "$NBRdivise";
}
//echo "FLECHE PRECEDENTE : $resNmoins <br />";

/////////SI IL Y A PLUSIEURS PAGE ON AFFICHE LA PAGINATION
if($NBRdivise > 1 ){

if($n == 2){
$urllreslastURLn = "$url_page_accueil";
}else{
$urllreslastURLn = "".$http."".$nomsiteweb."/".$url_secondaire."/".$resNmoins."";
}

for ($i = 1 ; $i <= $NBRdivise ; $i++){

if($i == 1 && $n != 1){
echo "<a href='".$urllreslastURLn."' rel='prev' ><span style='margin-left: 3px; float: left; border: 1px solid ".$couleurbordure."; color: ".$couleurbordure."; padding: 4px; padding-left: 10px; padding-right: 10px; border-top-left-radius: 4px; border-bottom-left-radius: 4px;'><span class='uk-icon-caret-left' ></span></span></a>";
}

if($i > $calcul_avant && $i < ($n+4)){
/////////Si page actuelle 1
if($i == "1" && $n == 1){
echo "<a href='".$http."".$url_page_accueil."' rel='canonical'><span style='float: left; background-color: ".$couleurbordure."; border: 1px solid ".$couleurbordure."; color: ".$couleurFOND."; padding: 4px; width: auto; border-top-left-radius: 4px; border-bottom-left-radius: 4px;'>1</span></a>";

/////////Si page actuelle autres et différent de la dernière page
}elseif($n == $i && $NBRdivise != 1 && $NBRdivise != $i){
echo "<a href='".$http."".$nomsiteweb."/".$url_secondaire."/".$i."'><span style='margin-left: 3px; float: left; background-color: ".$couleurbordure."; border: 1px solid ".$couleurbordure."; color: ".$couleurFOND."; padding: 4px; width: auto;'>$i</span></a>";

/////////Si page actuelle autres et dernière page
}elseif($n == $i && $NBRdivise != 1 && $NBRdivise == $i){
$lastpage = "ok";
echo "<a href='".$http."".$nomsiteweb."/".$url_secondaire."/".$i."'><span style='margin-left: 3px; float: left; background-color: ".$couleurbordure."; border: 1px solid ".$couleurbordure."; color: ".$couleurFOND."; padding: 4px; width: auto; border-top-right-radius: 4px; border-bottom-right-radius: 4px;'>$i</span></a>";

/////////Si on a passer la page 1
}elseif($i == 1 ){
echo "<a href='".$http."".$url_page_accueil."' rel='canonical'><span style='margin-left: 3px; float: left; border: 1px solid ".$couleurbordure."; color: ".$couleurbordure."; padding: 4px; width: auto;'>1</span></a>";

///////////////////////Si dernière page
}elseif($NBRdivise != 1 && $NBRdivise == $i && $NBRdivise > $nbrpage){
$lastpage = "ok";
echo "<a href='".$http."".$nomsiteweb."/".$url_secondaire."/".$i."'><span style='margin-left: 3px; float: left; border: 1px solid ".$couleurbordure."; color: ".$couleurbordure."; padding: 4px; width: auto;'>$i</span></a>";

/////////Si page non actuelle
}elseif($NBRdivise == $nbrpage || $NBRdivise < $nbrpage){
echo "<a href='".$http."".$nomsiteweb."/".$url_secondaire."/".$i."' ><span style='margin-left: 3px; float: left; border: 1px solid ".$couleurbordure."; color: ".$couleurbordure."; padding: 4px; width: auto;'>$i</span></a>";

}else{
echo "<a href='".$http."".$nomsiteweb."/".$url_secondaire."/".$i."'><span style='margin-left: 3px; float: left; border: 1px solid ".$couleurbordure."; color: ".$couleurbordure."; padding: 4px; width: auto;'>$i</span></a>";
}
}
/////Boucle for finish
}

if($lastpage != "ok" && $NBRdivise > $nbrpage){
echo "<div style='margin-left: 3px; float: left; border: 1px solid ".$couleurbordure."; color: ".$couleurbordure."; padding: 4px; width: auto;'>...</div>";
}

////////////On calcule pour la flèche "suivant"
$resNoneplus = ($n+1);
if($resNoneplus == $NBRdivise || $resNoneplus < $NBRdivise){
}else{
$resNoneplus = "$NBRdivise";
}

//echo "<br />FLECHE SUIVANTE : $resNoneplus <br />";

/////////Si page actuelle autres et si pas la dernière page
if($NBRdivise > 1 && $NBRdivise != $n){
echo "<a href='".$http."".$nomsiteweb."/".$url_secondaire."/".$resNoneplus."' rel='next' ><span style='margin-left: 3px; float: left; border: 1px solid ".$couleurbordure."; color: ".$couleurbordure."; padding: 4px; padding-left: 10px; padding-right: 10px; border-top-right-radius: 4px; border-bottom-right-radius: 4px;'> <span class='uk-icon-caret-right' ></span> </span></a>";
}

echo "</div>";

echo "<div style='clear: both;'></div>";
}

}

}

?>