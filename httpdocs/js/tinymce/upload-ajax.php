<?php

$imageFolder = "../../images/uploads/";

reset ($_FILES);
$temp = current($_FILES);
if(is_uploaded_file($temp['tmp_name'])){

// Sanitize input
if(preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
header("HTTP/1.0 500 Invalid file name.");
return;
}

// Verify extension
if(!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png"))) {
header("HTTP/1.0 500 Invalid extension.");
return;
}

// Accept upload if there was no origin, or if it is an accepted origin
$filetowrite = "$imageFolder".time()."".$temp['name']."";
move_uploaded_file($temp['tmp_name'], $filetowrite);
echo json_encode(array('location' => $filetowrite));

}else{
header("HTTP/1.0 500 Server Error");
}

?>