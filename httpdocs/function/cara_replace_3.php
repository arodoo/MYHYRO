<?php 

function cara_replace($name)
{
    $array_replace = array("?" => "");
    $name = explode('.', $name);
    $name = iconv("UTF-8", 'ASCII//TRANSLIT',$name[0]);
    $name = strtr($name, $array_replace);
    return (strtolower(preg_replace("#[^a-zA-Z0-9]#", "_", $name)));
}

?>