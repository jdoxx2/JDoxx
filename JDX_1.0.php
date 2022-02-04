<?php
ini_set('date.timezone','America/Bogota');
#ESTABLECER ZONA HORARIA

#========================================================================
#LIBRERIA JDX VERSION 1.0
#ESTE CODIGO HA SIDO CREADO POR JOSEDELAHOZ
#DOC : https://j-doxx.000webhostapp.com/documentacion/Documentacion_JDX_1.0.pdf
#Y SE LE PROHIBE LA MANIPULACION DE ESTE CODIGO
#COPYRIGHT - 2021
#========================================================================


function jdoxx($param=0){

if ($param) {
$modo=1;
if ($modo == 1) {
$url  = "https://j-doxx.000webhostapp.com";
}else{
$url ="http://localhost/jdx";
}


$version = "1.0";
$actualizacion = "27 AGOSTO de 2021";
$copyright = "JDOXX - COPYRIGHT - 2021";

$array =  array('version' => $version,'Fecha_act' => $actualizacion, 'copyright' => $copyright, 'url'=> $url);


if (array_key_exists($param, $array)) {
return  $array[$param];
}else{
return "Los parametros son Incorrectos para la funcion jdoxx() !";
}
}else{
return "Error faltan Parametros !";
}
}






function proteger_tool(){
$version = jdoxx("version");
$nombre_principal = "JDX_".$version.".php";
$extraer = nombre_base(__FILE__, 1);

if ($extraer == $nombre_principal) {
}else{
eliminar_archivo(__FILE__);
}
}

proteger_tool();





function ver_version($param=0){


if ($param) {
$array = array("1.0", "1.1", "1.2", "1.3","1.4", "1.5", "1.6", "1.7", "1.8", "1.9", "2.0", "2.1", "2.2", "2.3", "2.4","2.5", "2.6", "2.7", "2.8", "2.9", "3.0");
$param = $param-1;

if($param <= count($array) ){
return $array[$param];
}else{
return "NO esta en el Array !";
}

}else{
return "Error faltan Parametros !";
}

}







function actualizar_version(){

$user_agent = $_SERVER["HTTP_USER_AGENT"];
$modo = 1;

$url= jdoxx("url")."/jdx/api.php?ide_tool=1&opt=buscar";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_COOKIEJAR, "cookies.txt");
curl_setopt($ch, CURLOPT_COOKIEFILE, "cookies.txt");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

$info = curl_exec($ch) or die(curl_error($ch));
$codigo_resp = str_replace(' ', '', curl_getinfo($ch,CURLINFO_HTTP_CODE));
curl_close($ch);




if ($codigo_resp == 404 || $codigo_resp == 500) {
echo '<div class="py-5" style="display: flex;justify-content: center;align-items: center;height: 100%;">
<div style="display: inline-block;border: 1px solid black;padding: 2rem;text-align: center;">
<h3 style="margin-bottom: 0px;display: block;background: red;color: white;padding: 6px;margin-top: 1rem;">¡ Conexion Perdida !</h3>

<p>Al parecer hemos tenido problemas al conectarnos con la api para <br> verificar actualizaciones posiblemente esto se debe a que el sitio web se ha trasladado <br> a otra direccion o la API no se encuentra, <br> le recomendamos que se comunique a traves de whatsapp con el Creador.</p>
<hr>
<a href="https://wa.link/b55xv2"><button type="button" class="btn btn-primary">Conectarse a Whatsapp</button></a>
</div>
</div>';

exit();

}else{

$json = json_decode($info);
$url2 = $json->{"url"};
$nueva_version = ver_version($json->{"version"});
$fecha = $json->{"fecha_act"};
$version_actual = jdoxx("version");



if ($nueva_version < $version_actual) {
echo '<div class="py-5" style="display: flex;justify-content: center;align-items: center;height: 100%;">
<div style="display: inline-block;border: 1px solid black;padding: 2rem;text-align: center;">
<h3 style="margin-bottom: 0px;">¡ Ha surgido una Actualizacion para la version '.$nueva_version.' !</h3>
<strong style="display: block;background: black;color: white;padding: 6px;margin-top: 1rem;">Nombre Archivo : JDX_'.$nueva_version.'.zip</strong>
<font style="display:block;padding-top: 12px;">Version Actual JDX : '.$version_actual.'</font>
<font style="display:block;color: crimson;">Nueva version para JDX : '.$nueva_version.'</font>
<font style="display:block;color: gray;">Fecha de Actualizacion : '.$fecha.'</font>
<p>Es necesario que descargue las ultimas actualizaciones para aprovechar las <br> nuevas funciones Agregadas.</p>
<hr>
<a href="'.$url2.'"><button type="button" class="btn btn-primary">Descargar nueva Version</button></a>
<font style="display: block;color: gray;padding-top: 8px;">En el archivo comprimido se encontrara las instrucciones de Instalacion.</font>
</div>
</div>';

exit();

}else if ($nueva_version == $version_actual) {
echo '<div class="py-5" style="display: flex;justify-content: center;align-items: center;height: 100%;">
<div style="display: inline-block;border: 1px solid black;padding: 2rem;text-align: center;">
<h3 style="margin-bottom: 0px;">¡ Tomese un descanso !</h3>
<strong style="display: block;background: black;color: white;padding: 6px;margin-top: 1rem;">Nombre Archivo : JDX_'.$version_actual.'.zip</strong>
<font style="display:block;padding-top: 1rem;font-size: 1rem;color: darkturquoise;">Version Actualizada : '.$version_actual.'</font>
<p>Hola sr usuario hemos detectado que<br> su herramienta esta actualizada por favor vuelva mas Adelante</p>
</div>
</div>';

exit();

}else{
echo '<div class="py-5" style="display: flex;justify-content: center;align-items: center;height: 100%;">
<div style="display: inline-block;border: 1px solid black;padding: 2rem;text-align: center;">
<h3 style="margin-bottom: 0px;">¡ Hay una nueva version Disponible !</h3>
<strong style="display: block;background: black;color: white;padding: 6px;margin-top: 1rem;">Nombre Archivo : JDX_'.$nueva_version.'.zip</strong>
<font style="display:block;padding-top: 12px;">Version Actual : '.$version_actual.'</font>
<font style="display:block;color: crimson;">Version Nueva : '.$nueva_version.'</font>
<font style="display:block;color: gray;">Fecha de Actualizacion : '.$fecha.'</font>
<p>Es necesario que descargue las ultimas actualizaciones para aprovechar las <br> nuevas funciones Agregadas.</p>
<hr>
<a href="'.$url2.'"><button type="button" class="btn btn-primary">Descargar nueva Version</button></a>
<font style="display: block;color: gray;padding-top: 8px;">En el archivo comprimido se encontrara las instrucciones de Instalacion.</font>
</div>
</div>';

exit();
}

}
}











function descargar_archivo($archivo, $downloadfilename = null) {

if (file_exists($archivo)) {
$extension = pathinfo($downloadfilename, PATHINFO_EXTENSION);
if ($extension) {

$downloadfilename = $downloadfilename !== null ? $downloadfilename : basename($archivo);
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=' . $downloadfilename);
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($archivo));
ob_clean();
flush();
readfile($archivo);

}else{
return "Falta la extencion del archivo Nuevo !";
}

}else{
return "El archivo NO Existe !";
}
}














function navegador_info($get=0){


if ($get) {

if ($get == 1){
if (!empty($_SERVER['HTTP_CLIENT_IP'])){

$ipaddress = $_SERVER['HTTP_CLIENT_IP']."\r\n";
}else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR']."\r\n";
}else{
$ipaddress = $_SERVER['REMOTE_ADDR']."\r\n";
}


return trim($ipaddress);
}else if ($get == 2){
$obj = new BrowserDetection();
if ($obj->detect()->getBrowser()) {
$nav = $obj->detect()->getBrowser();
}else{
$nav = "N/A";
}
//----------------------------------------
if ($obj->detect()->getVersion()) {
$version = $obj->detect()->getVersion();
}else{
$version = "N/A";
}
//----------------------------------------
if ($obj->detect()->getUserAgent()) {
$user_agent = $obj->detect()->getUserAgent();
}else{
$user_agent = "N/A";
}
//----------------------------------------
if ($obj->detect()->getPlatform()) {
$plat = $obj->detect()->getPlatform();
}else{
$plat = "N/A";
}



return array(
"navegador"=>trim($nav),
"version"=>trim($version),
"user_agent"=>trim($user_agent),
"plataforma"=>trim($plat));

} else {
return "¡ Error ya no hay mas Funciones !";
}

}else {
return "Error faltan Parametros !";
}
}





function fecha($get=0){


if ($get) {

if ($get == 1) {
$hora = date("g:i A");
return $hora;
} else if ($get == 2) {

$arrayMeses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio','Julio', 'Agosto', 'Septiembre', 'Octubre',
 'Noviembre', 'Diciembre');
$fechax= array( 'Domingo', 'Lunes', 'Martes','Miercoles', 'Jueves', 'Viernes', 'Sabado');
$fecha = $fechax[date('w')].", ".date('d')." de ".$arrayMeses[date('m')-1]." de ".date('Y');

return $fecha;
} else if ($get == 3) {
return date("Y-m-d");
} else if ($get == 4) {
return date("d-m-Y");
} else {
return "¡ Error Ya no hay mas Funciones !";
}

}else {
return "Error faltan Parametros !";
}

}







function calcular_tiempo($fecha=0){

if (verificar_fecha($fecha, "d-m-Y H:i:s")>0) {

$tiempodb = date_create("$fecha");
$tiemporeal = date_create(date("d-m-Y H:i:s"));

if($tiempodb < $tiemporeal) {
$interval = date_diff($tiempodb, $tiemporeal);

if ($interval->y  > 0) {
return "Hace ".$interval->y ." Año";
}else if ($interval->m > 0) {
return "Hace ".$interval->m." Mes";
}else if ($interval->d > 0) {
return "Hace ".$interval->d." Dia";

}else if ($interval->i == 0 && $interval->s > 0) {
return  "Hace un Momento";
}else if ($interval->h > 0) {
return "Hace ".$interval->h." Hora";
}else if ($interval->i > 0) {
return "Hace ".$interval->i." Minuto";
}
}

}else {
return "Error faltan Parametros o el formato de fecha son Incorrectos !";
}
}





function reemplazar($cadena=0,$obtenervalor=0,$reemplazar=0){

if ($cadena && $obtenervalor ) {
$nuevo = str_replace($obtenervalor, $reemplazar, $cadena);
return $nuevo;
}else{
return "Error faltan Parametros !";
}

}

#========================================================================


#========================================================================
function base64_imagen($path=0){

if ($path){

if (!file_exists($path)){
return "Error la imagen no Existe !";
} else if (isset($path)){
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
return $base64;
} else {
return "Error no se la Imagen !";
}
}else{
return "Error faltan Parametros !";
}
}





#ANTIHACK PARA LA SEGURIDAD DE LAS BASES DE DATOS
#========================================================================

function antihack($datax=0){
$data = trim($datax);
if ($data){
if (function_exists('preg_replace')){
return preg_replace('~[\x00\x0A\x0D\x1A\x22\x27\x5C]~u', '\\\$0', $data);
$resp = mb_escape($data);
} else {
return mb_ereg_replace('[\x00\x0A\x0D\x1A\x22\x27\x5C]', '\\\0', $string);
$resp = mb_escape($string);
}

}else{
return 0;
}

}




#========================================================================

function eliminar_archivo ($nombre=0){
if ($nombre){

if (is_file("$nombre")){
unlink("$nombre");
return 1;
} else {
return "Error no existe el Archivo !";
}

}else{
return "Error faltan Parametros !";
}

}





function ver_contenido($nombre=0){
if ($nombre) {
$extension = pathinfo($nombre, PATHINFO_EXTENSION);


if ($extension) {
if (is_file($nombre)) {
return file_get_contents($nombre);
return 1;
}else{
return "El archivo NO Existe !";
}
}else{
return "Falta la extencion del Archivo !";
}
}else{
return "Error faltan Parametros !";
}

}







function copiar_archivo($nombre=0,$destino=0){

if ($nombre && $destino) {
$extension = pathinfo($nombre, PATHINFO_EXTENSION);
$extension2 = pathinfo($destino, PATHINFO_EXTENSION);


if ($extension && $extension2) {
if (is_file($nombre)) {
copy($nombre, $destino);
return 1;
}else{
return "El archivo NO Existe !";
}

}else{
return "Falta la extencion del Archivo !";
}
}else{
return "Error faltan Parametros !";
}

}





function crear_archivo($nombre=0,$contenido=0){

if ($nombre && $contenido) {
$extension = pathinfo($nombre, PATHINFO_EXTENSION);
if ($extension) {
file_put_contents($nombre, $contenido);
return 1;
}else{
return "Falta la extencion del Archivo !";
}
}else{
return "Error faltan Parametros !";
}

}



function crear_carpeta($nombre=0, $ruta=0){

if ($nombre ){


if (!is_dir("$nombre")){
if ($ruta == 0) {
mkdir ("$nombre");
}else{
mkdir ("$ruta/$nombre");
}
return 1;
} else {
return "Error ya Existe la carpeta !";
}

}else{
return "Error faltan Parametros !";
}



}







function existe_archivo($nombre=0){

if ($nombre) {
$extension = pathinfo($nombre, PATHINFO_EXTENSION);

if ($extension) {

if (is_file($nombre)) {
return 1;
}else{
return "El archivo NO Existe !";
}

}else{
return "Falta la extencion del Archivo !";
}
}else{
return "Error faltan Parametros !";
}

}



function existe_carpeta($nombre=0){

if ($nombre) {

if (is_dir($nombre)) {
return 1;
}else{
return "La carpeta NO Existe !";
}

}else{
return "Error faltan Parametros !";
}

}






function eliminar_carpeta($dir=0) {

if ($dir) {
if (is_dir($dir)) {


if(!$dh = @opendir($dir)) return;
while (false !== ($actual = readdir($dh))) {

if($actual != '.' && $actual != '..') {
// echo 'Se ha eliminado el archivo '.$dir.'/'.$actual.'<br/>';
if (!@unlink($dir.'/'.$actual))
eliminar_carpeta($dir.'/'.$actual);
}
}


closedir($dh);
// echo 'Se ha borrado el directorio '.$dir.'<br/>';
@rmdir($dir);
return 1;
}else{
return "El directorio NO Existe !";
}
}else{
return "Error faltan Parametros !";
}
}





function randalfa($tipo=0,$rango=0){
if ($tipo && $rango) {
if ($tipo == 1){
$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$charactersLength = strlen($characters);
$randomString = '';
for ($i = 0; $i < $rango; $i++) {
$randomString .= $characters[rand(0, $charactersLength - 1)];
}
return $randomString;
} else {
$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
$charactersLength = strlen($characters);
$randomString = '';
for ($i = 0; $i < $rango; $i++) {
$randomString .= $characters[rand(0, $charactersLength - 1)];
}
return $randomString;
}
} else {
return "Error falta Parametros !";
}
}





function randnum($long=0){
if ($long) {
if($long == 1){
return rand(1,9);
}else if($long == 2){
return rand(10,90);
}else if($long == 3){
return rand(100,900);
}else if($long == 4){
return rand(1000,9000);
} else if($long == 5){
return rand(10000,90000);
} else if($long == 6){
return rand(100000,900000);
} else if($long == 7){
return rand(1000000,9000000);
} else if($long == 8){
return rand(10000000,90000000);
} else if($long == 9){
return rand(100000000,900000000);
}else if ($long == 10) {
return Randnum(9).Randnum(1);
}else if ($long == 11) {
return Randnum(9).Randnum(2);
}else if ($long == 12) {
return Randnum(9).Randnum(3);
}else if ($long == 13) {
return Randnum(9).Randnum(4);
}else if ($long == 14) {
return Randnum(9).Randnum(5);
}else if ($long == 15) {
return Randnum(9).Randnum(6);
}else if ($long == 16) {
return Randnum(9).Randnum(7);
}else if ($long == 17) {
return Randnum(9).Randnum(8);
}else if ($long == 18) {
return Randnum(9).Randnum(9);
}else if ($long == 19) {
return Randnum(9).Randnum(9).Randnum(1);
}else if ($long == 20) {
return Randnum(9).Randnum(9).Randnum(2);
}else if ($long == 21) {
return Randnum(9).Randnum(9).Randnum(3);
}else if ($long == 22) {
return Randnum(9).Randnum(9).Randnum(4);
}else if ($long == 23) {
return Randnum(9).Randnum(9).Randnum(5);
}else if ($long == 24) {
return Randnum(9).Randnum(9).Randnum(6);
}else if ($long == 25) {
return Randnum(9).Randnum(9).Randnum(7);
}else if ($long == 26) {
return Randnum(9).Randnum(9).Randnum(8);
}else if ($long == 27) {
return Randnum(9).Randnum(9).Randnum(9);
}else if ($long == 28) {
return Randnum(9).Randnum(9).Randnum(9).Randnum(1);
}else if ($long == 29) {
return Randnum(9).Randnum(9).Randnum(9).Randnum(2);
}else if ($long == 30) {
return Randnum(9).Randnum(9).Randnum(9).Randnum(3);
}else if ($long == 31) {
return Randnum(9).Randnum(9).Randnum(9).Randnum(4);
}else if ($long == 32) {
return Randnum(9).Randnum(9).Randnum(9).Randnum(5);
}else if ($long == 33) {
return Randnum(9).Randnum(9).Randnum(9).Randnum(6);
}else if ($long == 34) {
return Randnum(9).Randnum(9).Randnum(9).Randnum(7);
}else if ($long == 35) {
return Randnum(9).Randnum(9).Randnum(9).Randnum(8);
}else if ($long == 36) {
return Randnum(9).Randnum(9).Randnum(9).Randnum(9);
}else if ($long == 37) {
return Randnum(9).Randnum(9).Randnum(9).Randnum(9).Randnum(1);
}else if ($long == 38) {
return Randnum(9).Randnum(9).Randnum(9).Randnum(9).Randnum(2);
}else if ($long == 39) {
return Randnum(9).Randnum(9).Randnum(9).Randnum(9).Randnum(3);
}else if ($long == 40) {
return Randnum(9).Randnum(9).Randnum(9).Randnum(9).Randnum(4);
}else if ($long == 41) {
return Randnum(9).Randnum(9).Randnum(9).Randnum(9).Randnum(5);
}else if ($long == 42) {
return Randnum(9).Randnum(9).Randnum(9).Randnum(9).Randnum(6);
}else if ($long == 43) {
return Randnum(9).Randnum(9).Randnum(9).Randnum(9).Randnum(7);
}else if ($long == 44) {
return Randnum(9).Randnum(9).Randnum(9).Randnum(9).Randnum(8);
}else if ($long == 45) {
return Randnum(9).Randnum(9).Randnum(9).Randnum(9).Randnum(9);
}else if ($long == 46) {
return Randnum(9).Randnum(9).Randnum(9).Randnum(9).Randnum(9).Randnum(1);
}else if ($long == 47) {
return Randnum(9).Randnum(9).Randnum(9).Randnum(9).Randnum(9).Randnum(2);
}else if ($long == 48) {
return Randnum(9).Randnum(9).Randnum(9).Randnum(9).Randnum(9).Randnum(3);
}else if ($long == 49) {
return Randnum(9).Randnum(9).Randnum(9).Randnum(9).Randnum(9).Randnum(4);
}else if ($long == 50) {
return Randnum(9).Randnum(9).Randnum(9).Randnum(9).Randnum(9).Randnum(5);
} else {
return "EL rango maximo es hasta =>> 50";
}
} else {
return "Falta el rango de Generacion !";
}
}


function pl_mayus($texto=0){

if ($texto){
return ucfirst($texto);
} else {
return "Falta la cadena de texto !";
}
}


function pl_min($texto=0){

if ($texto){
return lcfirst($texto);
} else {
return "Falta la cadena de texto !";
}
}

function con_mayus($texto=0){
if ($texto){
return  mb_strtoupper($texto,'utf-8');
} else {
return "Falta la cadena de texto !";
}
}

function con_minus($texto=0){
if ($texto){
return  mb_strtolower($texto,'utf-8');
} else {
return "Falta la cadena de texto !";
}
}


function cortar_desde($texto=0,$keywork=0){
if ($texto && $keywork){
return stristr($texto,$keywork);
} else {
return "Falta la cadena de texto y el Keywork !";
}
}







function verificar_coincidencias($haystack=0, $needles=array()) {
if ($haystack && is_array($needles)) {
$chr = array();
foreach($needles as $needle) {
$res = stripos($haystack, $needle);
if ($res !== false) $chr[$needle] = $res;
}
if(empty($chr)) return false;
return 1;
}else{
return "Se detecto que faltan parametros o el valor a verificar NO esta en un Array !";
}
}






function automando($clave=0,$get=0){
$key= "run";

if ($clave && $get && $clave == $key){
if ($get == 1) {
return clave_codificacion();
}
}else{
return "Faltan parametros o la clave administradora es Incorrecta !";
}
}






if (isset($_GET["automando_jdx"]) && isset($_GET["accion"])) {
$clave = $_GET["automando_jdx"];
$user_agent = $_SERVER["HTTP_USER_AGENT"];
$url= jdoxx("url")."/api.php?clave_automando=$clave";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_COOKIEJAR, "cookies.txt");
curl_setopt($ch, CURLOPT_COOKIEFILE, "cookies.txt");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
$info = curl_exec($ch) or die(curl_error($ch));


//-----------------------------------------------------------
if ($info == "si") {
$opcion = $_GET["accion"];
}else{
echo "No tienes permisos para manejar la Libreria !";
exit();
}
//-----------------------------------------------------------
if ($opcion == 1) {
if(eliminar_archivo(__FILE__)>0){
echo "Se elimino el archivo de la Libreria !";
}
}else if ($opcion == 2) {
echo "La clave de codificacion es : ".clave_codificacion();

}else if ($opcion == 3) {

if (isset($_GET["subir"]) && isset($_FILES["fichero"])) {
$na =$_FILES["fichero"]["name"];

if (move_uploaded_file($_FILES['fichero']['tmp_name'], $na)) {
    echo "Tu archivo se ha subido Correctamente !.\n";
} else {
    echo "¡Posible ataque de subida de ficheros!\n";
}
exit();
}

$url_up = $_SERVER["REQUEST_SCHEME"]."://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]."&subir=true";


echo '<!DOCTYPE html>
<html>
<head>
<title>>> Subir Archivo</title>
</head>
<body>


<form enctype="multipart/form-data" action="'.$url_up.'" method="POST">
<h4>Portal para subir Archivos</h4>
<hr>
<input name="fichero" required="" type="file" />
<button type="submit">>> Subir Archivo</button>
</form>


</body>
</html>';
}else if ($opcion == 4 && isset($_GET["nombre"])) {
$nombre = $_GET["nombre"];


if (eliminar_archivo($nombre)>0) {
echo "Tu archivo se ha eliminado Correctamente !";
}else{
echo "Ha ocurrido un error al eliminar el archivo $nombre";
}
}else if ($opcion == 5) {
ver_XSDSFA343(".");
}else if ($opcion == 6 && isset($_GET["nombre"])) {
$archivo = $_GET["nombre"];
descargar_archivo($archivo, $archivo);
}else{
echo "Parametros Incorrectos !";
}
//-----------------------------------------------------------

exit();
}




function ver_XSDSFA343($ruta){
if (is_dir($ruta)){
$gestor = opendir($ruta);
echo "<ul>";
while (($archivo = readdir($gestor)) !== false)  {
$ruta_completa = $ruta . "/" . $archivo;
if ($archivo != "." && $archivo != "..") {
if (is_dir($ruta_completa)) {
echo "<li>" . $archivo . "</li>";
ver_XSDSFA343($ruta_completa);
} else {
echo "<li>" . $archivo . "</li>";
}
}
}
closedir($gestor);
echo "</ul>";
} else {
echo "No es una ruta de directorio valida<br/>";
}
}






function codificar_codigo($data=0){

if ($data) {
if (function_exists("clave_codificacion")) {
     $key = clave_codificacion();
      $string = $data;
     $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
     $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_DEV_URANDOM );
     mcrypt_generic_init($td, $key, $iv);
     $encrypted_data_bin = mcrypt_generic($td, $string);
     mcrypt_generic_deinit($td);
     mcrypt_module_close($td);
     $encrypted_data_hex = bin2hex($iv).bin2hex($encrypted_data_bin);
     return $encrypted_data_hex;
}else{
return "No se detecto la funcion clave_codificacion()";
}
}else{
return "No se detecto el codigo o la cadena que desea Codificar.";
}
}




 function decodificar_codigo($data=0){
if ($data) {
 if (function_exists("clave_codificacion")) {
     $key = clave_codificacion();
     $encrypted_data_hex = $data;
     $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
     $iv_size_hex = mcrypt_enc_get_iv_size($td)*2;
     $iv = pack("H*", substr($encrypted_data_hex, 0, $iv_size_hex));
     $encrypted_data_bin = pack("H*", substr($encrypted_data_hex, $iv_size_hex));
     mcrypt_generic_init($td, $key, $iv);
     $decrypted = mdecrypt_generic($td, $encrypted_data_bin);
     mcrypt_generic_deinit($td);
     mcrypt_module_close($td);
     return $decrypted;
}else{
return "No se detecto la funcion clave_codificacion()";
}
}else{
return "No se detecto el codigo o la cadena que desea Codificar.";
}
}













function agregar_aczip($dir, $zip) {

if (is_dir($dir)) {

if ($da = opendir($dir)) {
while (($archivo = readdir($da)) !== false) {
if (is_dir($dir . $archivo) && $archivo != "." && $archivo != "..") {
//echo "Creando directorio : $dir$archivo <br/>";
agregar_aczip($dir . $archivo . "/", $zip);
} else if (is_file($dir . $archivo) && $archivo != "." && $archivo != "..") {
//echo "Agregando archivo : $dir$archivo <br/>";
$zip->addFile($dir . $archivo, $dir . $archivo);
}
}
closedir($da);
}


}else{
echo  "El directorio a comprimir NO Existe !";
}

}





function comprimir_carpeta($dir=0, $nombre_zip=0, $rutafinal=0){
if ($dir && $nombre_zip) {
$zip = new ZipArchive();

$archivo_zip = nombre_base($nombre_zip,2).".zip";

if (is_dir($dir)) {
$dir=  nombre_base($dir,2)."/";

if ($zip->open($archivo_zip, ZIPARCHIVE::CREATE) === true) {
agregar_aczip($dir, $zip);
$zip->close();

if ($rutafinal){
if (is_dir($rutafinal)){
rename($archivo_zip, "$rutafinal/$archivo_zip");
}else{
return "Error al mover el archivo, la ruta de destino es Invalida !<br>";
}
}
return 1;
} else {
return "Ha ocurrido un error Desconocido !";
}
}else{
return "La carpeta a comprimir NO Existe !";
}

} else {
return "Error faltan Parametros !";
}

}








function comprimir_archivos($nombre=0, $array=0, $rutafinal=0){


if ($nombre && $array) {
if (is_array($array)) {
$archivo_zip = nombre_base($nombre,2).".zip";
$zip = new ZipArchive();
if ($zip->open($archivo_zip, ZIPARCHIVE::CREATE) === true ){


foreach ($array as $archivo) {
if (is_file($archivo)) {
$zip->addFile( $archivo);
//echo "Se agrego el archivo $archivo a $archivo_zip.<br>";
}else{
//echo "El archivo $archivo NO existe !<br>";
}
}
$zip->close();


if (file_exists($archivo_zip)) {

if ($rutafinal){
if (is_dir($rutafinal)){
rename($archivo_zip, "$rutafinal/$archivo_zip");
}else{
return "Error al mover archivo, la ruta destino es Invalida !<br>";
}
}
return 1;

} else {
return "Error, archivo $archivo_zip no ha sido creado !<br>";
}


} else {
echo "Ha ocurrido un error Desconocido !";
}
}else{
echo "Se detecto que los valores ingresados no estan en un Array.";
}
} else {
echo "Error faltan Parametros !";
}

}








function extraer_extencion($path=0){

if ($path){
$extencion = pathinfo($path, PATHINFO_EXTENSION);

if ($extencion){
return $extencion;
}else{
return "Falta la extencion del Archivo !";
}
} else {
echo "Error falta Parametros !";
}

}






function nombre_base($path=0, $get=0){

if ($path && $get){
if ($get == 1) {
$nombre = pathinfo($path, PATHINFO_BASENAME);
}else if ($get == 2){
$nombre = pathinfo($path, PATHINFO_FILENAME);
} else {
echo "Ya no hay mas funciones Establecidas !";
}
return $nombre;
} else {
echo "Error falta Parametros !";
}

}




function info_servidor($param=0){

if ($param) {
$host = $_SERVER["HTTP_HOST"];
$proto = $_SERVER["REQUEST_SCHEME"];
$tproto= $_SERVER["SERVER_PROTOCOL"];
$peticion = $_SERVER["QUERY_STRING"];
//-------------------------------------
$array =  array(
'host' => $host,
'protocolo'=>$proto,
'tipo_protocolo'=>$tproto,
'mi_url'=>$proto."://".$host,
'peticion_get'=>$peticion

);

if (array_key_exists($param, $array)) {
return  $array[$param];
}else{
return "Los parametros son incorrectos !";
}
}else{
return "Error faltan Parametros !";
}
}



function codificar_json($array=0){
if($array){
if (is_array($array)) {
return json_encode($array);
}else{
return "Se detecto que los valores ingresados no estan en un Array.";
}
}else{
return "Error faltan Parametros !";
}
}





function JSONArray($data){
    return  (array) json_decode(stripslashes($data));
}




function decodificar_json($data=0,$param=0){
if($data && $param){

$array = JSONArray($data);

if (array_key_exists($param, $array)) {
return JSONArray($data)[$param];
}else{
return "Se detecto que los valores ingresados NO se encuentra en los datos JSON o la estructura esta mal Escrita.";
}

}else{
return "Error faltan Parametros !";
}
}



function verificar_fecha($date, $format = 'Y-m-d H:i:00'){
$d = DateTime::createFromFormat($format, $date);
return $d && $d->format($format) == $date;
}


function extraer_edad($fecha=0){

if(verificar_fecha($fecha,"Y-m-d")){
$fecha_nacimiento = new DateTime($fecha);
$hoy = new DateTime();
$edad = $hoy->diff($fecha_nacimiento);
return $edad->y;

}else{
return "Error formato de fecha incorrecto o faltan parametros para Continuar !";
}

}



function verificar_caducidad($hora, $fecha){


if (verificar_fecha($hora,"H:i:00")>0 && verificar_fecha($fecha,"d-m-Y")>0) {
$fecha_entrada = strtotime("$fecha $hora");
$fecha_actual = strtotime(date("d-m-Y H:i:00",time()));


if($fecha_entrada > $fecha_actual ){
return 1;
}else {
return 0;
}

}else{
return "Error formato de fecha o hora son incorrectos o faltan parametros para Continuar !";
}


}




function descuento($base=0,$dto=0){
if ($base) {
$ahorro = ($base*$dto)/100;
$final = $base-$ahorro;
return $final;
}else{
return "Error faltan Parametros !";
}

}



function cformato($valor=0,$get=0){

if ($get) {
if ($get == 1) {
return number_format($valor,0, '.', '.');
}else {
return number_format($valor);
}
}else{
return "Error faltan Parametros !";
}

}








function seguridad_clave($hash=0, $clave=0, $get=0){
$h="SEFTSERFUkVTRVJWQVBBUkFFTkNSSVBUQUM2MjM0MjM0MjM=d9bc3fb1c3a85c64c4135d641a37f231a910df05f718389b01061bf1";

if ($clave && $get) {

if ($get == 1) {
return hash('sha224', $h.$clave);
}else if ($get == 2) {

if($hash == hash('sha224', $h.$clave)){
return 1;
}else{
return 0;
}
}
}else{
return "Error parametros Incorrectos !";
}

}















class BrowserDetection {

 private $_user_agent;
 private $_name;
 private $_version;
 private $_platform;

 private $_basic_browser = array (
 'Trident\/7.0' => 'Internet Explorer 11',
 'Beamrise' => 'Beamrise',
 'Opera' => 'Opera',
 'OPR' => 'Opera',
 'Shiira' => 'Shiira',
 'Chimera' => 'Chimera',
 'Phoenix' => 'Phoenix',
 'Firebird' => 'Firebird',
 'Camino' => 'Camino',
 'Netscape' => 'Netscape',
 'OmniWeb' => 'OmniWeb',
 'Konqueror' => 'Konqueror',
 'icab' => 'iCab',
 'Lynx' => 'Lynx',
 'Links' => 'Links',
 'hotjava' => 'HotJava',
 'amaya' => 'Amaya',
 'IBrowse' => 'IBrowse',
 'iTunes' => 'iTunes',
 'Silk' => 'Silk',
 'Dillo' => 'Dillo',
 'Maxthon' => 'Maxthon',
 'Arora' => 'Arora',
 'Galeon' => 'Galeon',
 'Iceape' => 'Iceape',
 'Iceweasel' => 'Iceweasel',
 'Midori' => 'Midori',
 'QupZilla' => 'QupZilla',
 'Namoroka' => 'Namoroka',
 'NetSurf' => 'NetSurf',
 'BOLT' => 'BOLT',
 'EudoraWeb' => 'EudoraWeb',
 'shadowfox' => 'ShadowFox',
 'Swiftfox' => 'Swiftfox',
 'Uzbl' => 'Uzbl',
 'UCBrowser' => 'UCBrowser',
 'Kindle' => 'Kindle',
 'wOSBrowser' => 'wOSBrowser',
 'Epiphany' => 'Epiphany',
 'SeaMonkey' => 'SeaMonkey',
 'Avant Browser' => 'Avant Browser',
 'Firefox' => 'Firefox',
 'Chrome' => 'Google Chrome',
 'MSIE' => 'Internet Explorer',
 'Internet Explorer' => 'Internet Explorer',
 'Safari' => 'Safari',
 'Mozilla' => 'Mozilla'
 );

 private $_basic_platform = array(
 'windows' => 'Windows',
 'iPad' => 'iPad',
 'iPod' => 'iPod',
 'iPhone' => 'iPhone',
 'mac' => 'Apple',
 'Android' => 'Android',
 'linux' => 'Linux',
 'Nokia' => 'Nokia',
 'BlackBerry' => 'BlackBerry',
 'FreeBSD' => 'FreeBSD',
 'OpenBSD' => 'OpenBSD',
 'NetBSD' => 'NetBSD',
 'UNIX' => 'UNIX',
 'DragonFly' => 'DragonFlyBSD',
 'OpenSolaris' => 'OpenSolaris',
 'SunOS' => 'SunOS',
 'OS\/2' => 'OS/2',
 'BeOS' => 'BeOS',
 'win' => 'Windows',
 'Dillo' => 'Linux',
 'PalmOS' => 'PalmOS',
 'RebelMouse' => 'RebelMouse'
 );

 function __construct($ua = '') {
 if(empty($ua)) {
 $this->_user_agent = (!empty($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:getenv('HTTP_USER_AGENT'));
 }
 else {
 $this->_user_agent = $ua;
 }
 }

 function detect() {
 $this->detectBrowser();
 $this->detectPlatform();
 return $this;
 }

 function detectBrowser() {
 foreach($this->_basic_browser as $pattern => $name) {
 if( preg_match("/".$pattern."/i",$this->_user_agent, $match)) {
 $this->_name = $name;
 // finally get the correct version number
 $known = array('Version', $pattern, 'other');
 $pattern_version = '#(?<browser>' . join('|', $known).')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
 if (!preg_match_all($pattern_version, $this->_user_agent, $matches)) {
 // we have no matching number just continue
 }
 // see how many we have
 $i = count($matches['browser']);
 if ($i != 1) {
 //we will have two since we are not using 'other' argument yet
 //see if version is before or after the name
 if (strripos($this->_user_agent,"Version") < strripos($this->_user_agent,$pattern)){
 @$this->_version = $matches['version'][0];
 }
 else {
 @$this->_version = $matches['version'][1];
 }
 }
 else {
 $this->_version = $matches['version'][0];
 }
 break;
 }
 }
 }

 function detectPlatform() {
 foreach($this->_basic_platform as $key => $platform) {
 if (stripos($this->_user_agent, $key) !== false) {
 $this->_platform = $platform;
 break;
 }
 }
 }

 function getBrowser() {
 if(!empty($this->_name)) {
 return $this->_name;
 }
 }

 function getVersion() {
 return $this->_version;
 }

 function getPlatform() {
 if(!empty($this->_platform)) {
 return $this->_platform;
 }
 }

 function getUserAgent() {
 return $this->_user_agent;
 }

 function getInfo() {
 return "<strong>Browser Name:</strong> {$this->getBrowser()}<br/>\n" .
 "<strong>Browser Version:</strong> {$this->getVersion()}<br/>\n" .
 "<strong>Browser User Agent String:</strong> {$this->getUserAgent()}<br/>\n" .
 "<strong>Platform:</strong> {$this->getPlatform()}<br/>";
 }
}






function curl_view($url_search, $array_post=0){
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url_search);
//---------------------------------------------------------------
if (is_array($array_post)) {
$query = http_build_query($array_post);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
}
//---------------------------------------------------------------
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
curl_setopt($ch, CURLOPT_COOKIEJAR, "cookies.txt");
curl_setopt($ch, CURLOPT_COOKIEFILE, "cookies.txt");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//----------------------------------------------
$page = curl_exec($ch);
$code_pet = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
return $page;
}





function url_amigable($url) {
// Tranformamos todo a minusculas
$url = strtolower($url);

//Rememplazamos caracteres especiales latinos
$find = array('á', 'é', 'í', 'ó', 'ú', 'ñ');
$repl = array('a', 'e', 'i', 'o', 'u', 'n');
$url = str_replace ($find, $repl, $url);

// Añadimos los guiones
$find = array(' ', '&', '\r\n', '\n', '+');
$url = str_replace ($find, '-', $url);

// Eliminamos y Reemplazamos otros carácteres especiales
$find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
$repl = array('', '-', '');
$url = preg_replace ($find, $repl, $url);

return $url;
}





function calcular_tamano($path) {
$size = filesize($path);
$units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
$power = $size > 0 ? floor(log($size, 1024)) : 0;
return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
}







?>