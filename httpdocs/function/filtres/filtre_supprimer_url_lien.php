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

///////////////////////////////////////FONCTION POUR SUPPRIMER LIEN
function supplien($string){
$content_array = explode(" ", $string);
$output1 = '';
foreach($content_array as $content1){
if(
substr($content1, 0, 7) == "http://" || substr($content1, 0, 8) == "https://" || substr($content, 0, 4) == "www." || 
substr($content1, -3) == ".fr" || substr($content1, -3) == ".FR" ||
substr($content1, -4) == ".com" || substr($content1, -4) == ".COM" ||
substr($content1, -4) == ".net" || substr($content1, -4) == ".NET" ||
substr($content1, -4) == ".org" || substr($content1, -3) == ".ORG" ||
substr($content1, -3) == ".eu" || substr($content1, -3) == ".EU" ||
substr($content1, -5) == ".info" || substr($content1, -5) == ".INFO" ||
substr($content1, -4) == ".biz" || substr($content1, -4) == ".BYZ" ||
substr($content1, -9) == ".graphics" || substr($content1, -9) == ".GRAPHYCS" ||
substr($content1, -8) == ".gallery" || substr($content1, -38) == ".GALLERY" ||
substr($content1, -5) == ".jobs" || substr($content1, -5) == ".JOBS" ||
substr($content1, -4) == ".int" || substr($content1, -4) == ".INT" ||
substr($content1, -5) == ".mobi" || substr($content1, -5) == ".MOBI" ||
substr($content1, -6) == ".photo" || substr($content1, -6) == ".PHOTO" ||
substr($content1, -12) == ".photography" || substr($content1, -12) == ".PHOTOGRAPHY" ||
substr($content1, -7) == ".photos" || substr($content1, -7) == ".PHOTOS" ||
substr($content1, -4) == ".pro" || substr($content1, -4) == ".PRO" ||
substr($content1, -8) == ".support" || substr($content1, -8) == ".SUPPORT" ||
substr($content1, -8) == ".systems" || substr($content1, -8) == ".SYSTEMS" ||
substr($content1, -11) == ".technology" || substr($content1, -11) == ".TECHNOLOGY" ||
substr($content1, -7) == ".tattoo" || substr($content1, -7) == ".TATTOO" ||
substr($content1, -4) == ".tel" || substr($content1, -4) == ".TEL" ||
substr($content1, -8) == ".voyage" || substr($content1, -8) == ".VOYAGE" ||
substr($content1, -4) == ".xxx" || substr($content1, -4) == ".XXX" ||
substr($content1, -4) == ".bzh" || substr($content1, -4) == ".BZH" ||
substr($content1, -3) == ".ca" || substr($content1, -3) == ".CA" ||
substr($content1, -3) == ".cf" || substr($content1, -3) == ".CF" ||
substr($content1, -3) == ".cg" || substr($content1, -3) == ".CG" ||
substr($content1, -3) == ".ch" || substr($content1, -3) == ".CH" ||
substr($content1, -3) == ".ci" || substr($content1, -3) == ".CI" ||
substr($content1, -3) == ".cm" || substr($content1, -3) == ".CM" ||
substr($content1, -3) == ".cn" || substr($content1, -3) == ".CN" ||
substr($content1, -3) == ".de" || substr($content1, -3) == ".DE" ||
substr($content1, -3) == ".dd" || substr($content1, -3) == ".DD" ||
substr($content1, -3) == ".dk" || substr($content1, -3) == ".DK" ||
substr($content1, -3) == ".dz" || substr($content1, -3) == ".DZ" ||
substr($content1, -3) == ".ec" || substr($content1, -3) == ".EC" ||
substr($content1, -3) == ".fi" || substr($content1, -3) == ".FI" ||
substr($content1, -3) == ".gb" || substr($content1, -3) == ".GB" ||
substr($content1, -3) == ".gp" || substr($content1, -3) == ".GP" ||
substr($content1, -3) == ".gn" || substr($content1, -3) == ".GN" ||
substr($content1, -3) == ".gq" || substr($content1, -3) == ".GQ" ||
substr($content1, -3) == ".gr" || substr($content1, -3) == ".GR" ||
substr($content1, -3) == ".mu" || substr($content1, -3) == ".MU" ||
substr($content1, -3) == ".gw" || substr($content1, -3) == ".GW" ||
substr($content1, -3) == ".gy" || substr($content1, -3) == ".GY" ||
substr($content1, -3) == ".is" || substr($content1, -3) == ".IS" ||
substr($content1, -3) == ".it" || substr($content1, -3) == ".IT" ||
substr($content1, -3) == ".lu" || substr($content1, -3) == ".LU" ||
substr($content1, -3) == ".ma" || substr($content1, -3) == ".MA" ||
substr($content1, -3) == ".mc" || substr($content1, -3) == ".MC" ||
substr($content1, -3) == ".mg" || substr($content1, -3) == ".MG" ||
substr($content1, -3) == ".me" || substr($content1, -3) == ".ME" ||
substr($content1, -3) == ".mq" || substr($content1, -3) == ".MQ" ||
substr($content1, -3) == ".mr" || substr($content1, -3) == ".MR" ||
substr($content1, -3) == ".mt" || substr($content1, -3) == ".MT" ||
substr($content1, -3) == ".mv" || substr($content1, -3) == ".MV" ||
substr($content1, -3) == ".mw" || substr($content1, -3) == ".MW" ||
substr($content1, -3) == ".mz" || substr($content1, -3) == ".MZ" ||
substr($content1, -3) == ".nc" || substr($content1, -3) == ".NC" ||
substr($content1, -3) == ".ne" || substr($content1, -3) == ".NE" ||
substr($content1, -3) == ".ng" || substr($content1, -3) == ".NG" ||
substr($content1, -3) == ".nz" || substr($content1, -3) == ".NZ" ||
substr($content1, -3) == ".ph" || substr($content1, -3) == ".PH" ||
substr($content1, -3) == ".pt" || substr($content1, -3) == ".PT" ||
substr($content1, -3) == ".qa" || substr($content1, -3) == ".QA" ||
substr($content1, -3) == ".re" || substr($content1, -3) == ".RE" ||
substr($content1, -3) == ".ro" || substr($content1, -3) == ".RO" ||
substr($content1, -3) == ".ru" || substr($content1, -3) == ".RU" ||
substr($content1, -3) == ".rw" || substr($content1, -3) == ".RW" ||
substr($content1, -3) == ".sa" || substr($content1, -3) == ".SA" ||
substr($content1, -3) == ".sc" || substr($content1, -3) == ".SC" ||
substr($content1, -3) == ".sd" || substr($content1, -3) == ".SD" ||
substr($content1, -3) == ".se" || substr($content1, -3) == ".SE" ||
substr($content1, -3) == ".sm" || substr($content1, -3) == ".SM" ||
substr($content1, -3) == ".sn" || substr($content1, -3) == ".SN" ||
substr($content1, -3) == ".sv" || substr($content1, -3) == ".SV" ||
substr($content1, -3) == ".sx" || substr($content1, -3) == ".SX" ||
substr($content1, -3) == ".th" || substr($content1, -3) == ".TH" ||
substr($content1, -3) == ".tn" || substr($content1, -3) == ".TN" ||
substr($content1, -3) == ".tr" || substr($content1, -3) == ".TR" ||
substr($content1, -3) == ".tw" || substr($content1, -3) == ".TW" ||
substr($content1, -3) == ".ua" || substr($content1, -3) == ".UA" ||
substr($content1, -3) == ".ve" || substr($content1, -3) == ".VE" ||
substr($content1, -3) == ".yt" || substr($content1, -3) == ".YT" ||
substr($content1, -3) == ".za" || substr($content1, -3) == ".ZA" ||
substr($content1, -3) == ".ovh" || substr($content1, -3) == ".OVH" ||
substr($content1, -3) == ".shop" || substr($content1, -3) == ".SHOP" ||
substr($content1, -3) == ".fun" || substr($content1, -3) == ".FUN" ||
substr($content1, -3) == ".me" || substr($content1, -3) == ".ME" ||
substr($content1, -3) == ".tv" || substr($content1, -3) == ".TV" ||
substr($content1, -3) == ".doctor" || substr($content1, -3) == ".DOCTOR" ||
substr($content1, -3) == ".games" || substr($content1, -3) == ".GAMES" ||
substr($content1, -3) == ".blog" || substr($content1, -3) == ".BLOG" ||
substr($content1, -3) == ".online" || substr($content1, -3) == ".ONLINE" ||
substr($content1, -3) == ".adult" || substr($content1, -3) == ".ADULT" ||
substr($content1, -3) == ".agency" || substr($content1, -3) == ".AGENCY" ||
substr($content1, -3) == ".alsace" || substr($content1, -3) == ".ALSACE" ||
substr($content1, -3) == ".art" || substr($content1, -3) == ".ART" ||
substr($content1, -3) == ".bar" || substr($content1, -3) == ".BAR" ||
substr($content1, -3) == ".auto" || substr($content1, -3) == ".AUTO" ||
substr($content1, -3) == ".audio" || substr($content1, -3) == ".AUDIO" ||
substr($content1, -3) == ".boutique" || substr($content1, -3) == ".BOUTIQUE" ||
substr($content1, -3) == ".busness" || substr($content1, -3) == ".BUSNESS" ||
substr($content1, -3) == ".cafe" || substr($content1, -3) == ".CAFE" ||
substr($content1, -3) == ".cam" || substr($content1, -3) == ".CAM" ||
substr($content1, -3) == ".camera" || substr($content1, -3) == ".CAMERA" ||
substr($content1, -3) == ".club" || substr($content1, -3) == ".CLUB" ||
substr($content1, -3) == ".paris" || substr($content1, -3) == ".PARIS"
){
$content1 = '';
}
$output1 .= " " . $content1;
}
$output1 = trim($output1);

return $output1;
}
///////////////////////////////////////FONCTION POUR SUPPRIMER LIEN
//echo "".supplien($string)."";

?>