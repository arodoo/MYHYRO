<?php

function avis($idannonce){

global $bdd;

$req_boucle = $bdd->prepare("SELECT * FROM membres_biens_avis WHERE id_annonce=? ");
$req_boucle->execute(array($idannonce));
while($ligne_boucle = $req_boucle->fetch()){
	$avis = $ligne_boucle['avis'];
	$total_avis = ($total_avis+$avis);
	$nbr++;

}
$req_boucle->closeCursor();

if(!empty($total_avis)){
	$total_avis = ($total_avis/$nbr);
	$total_avis = round($total_avis,0);
}

return $total_avis;

}

?>