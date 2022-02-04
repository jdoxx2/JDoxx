<?php
$url = !empty($_GET["url"]) ? $_GET["url"] : "inicio/inicio";
$arrURL = explode("/", $url);
$URL_control = $arrURL[0];
$URL_metodo = $arrURL[0];
$URL_param = "";



if (!empty($arrURL[1])) {
if ($arrURL[1] != "") {
$URL_metodo = $arrURL[1];
}
}



if (!empty($arrURL[2])) {
if ($arrURL[2] != "") {
for ($i=2; $i < count($arrURL); $i++) {
$URL_param .= $arrURL[$i].",";
}
$URL_param  = trim($URL_param,",");
}
}


require_once("Librerias/Autocargar.php");

?>