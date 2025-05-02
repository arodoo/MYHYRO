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

function algo(){

$nbrcara = "4";

$majuscul[0]= "a";
$majuscul[1]= "b";
$majuscul[2]= "c";
$majuscul[3]= "d";
$majuscul[4]= "e";
$majuscul[5]= "f";
$majuscul[6]= "g";
$majuscul[7]= "h";
$majuscul[8]= "i";
$majuscul[9]= "j";
$majuscul[10]= "k";
$majuscul[11]= "l";
$majuscul[12]= "m";
$majuscul[13]= "n";
$majuscul[14]= "o";
$majuscul[15]= "p";
$majuscul[16]= "q";
$majuscul[17]= "r";
$majuscul[18]= "s";
$majuscul[19]= "t";
$majuscul[20]= "u";
$majuscul[21]= "v";
$majuscul[22]= "w";
$majuscul[23]= "x";
$majuscul[24]= "y";
$majuscul[25]= "z";

//$majuscul[26] = "A";
//$majuscul[27]= "B";
//$majuscul[28]= "C";
//$majuscul[29]= "D";
//$majuscul[30]= "E";
//$majuscul[31]= "F";
//$majuscul[32]= "G";
//$majuscul[33]= "H";
//$majuscul[34]= "I";
//$majuscul[35]= "J";
//$majuscul[36]= "K";
//$majuscul[37]= "L";
//$majuscul[38]= "M";
//$majuscul[39]= "N";
//$majuscul[40]= "O";
//$majuscul[41]= "P";
//$majuscul[42]= "Q";
//$majuscul[43]= "R";
//$majuscul[44]= "S";
//$majuscul[45]= "T";
//$majuscul[46]= "U";
//$majuscul[47]= "V";
//$majuscul[48]= "W";
//$majuscul[49]= "X";
//$majuscul[50]= "Y";
//$majuscul[51]= "Z";

$majuscul[26] = "0";
$majuscul[27]= "1";
$majuscul[28]= "2";
$majuscul[29]= "3";
$majuscul[30]= "4";
$majuscul[31]= "5";
$majuscul[32]= "6";
$majuscul[33]= "7";
$majuscul[34]= "8";
$majuscul[35]= "9"; 

for ($i=0; $i< $nbrcara; $i++) { 
$majusculok .= $majuscul[rand(0,35)];
}

$passalgo = $majusculok;

return $passalgo;
}

$algo = algo();

?>