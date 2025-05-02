<?php

function prix($prix){

global $commission;

$commission_coef = (1+($commission/100));
$prix = ($prix*$commission_coef);
$prix = round($prix, 2);
$prix = sprintf('%.2f',$prix);

return $prix;

}

?>