<?php

class profile extends Class_controles {

public function __construct(){
parent::__construct();

//------ VERIFICAR SESION ----------
$this->seguridad_app();

if ($this->accountModel->verificar_user_sesion(1)) {
}else {
$this->accountModel->destruir_sesion();
echo '<script>location.href="'.BASE_URL.'"; </script>';
}
//----------------------------------
}



public function profile(){
header("Location:".BASE_URL."profile/informacion");
}




public function alfredbot($param){
$nombre_funcion = __FUNCTION__;
$array = array (
"item-bar"=>$nombre_funcion,
"datos"=>$this->db["datos"],
"sitio"=>$this->db["sitio"]);
$this->vistas->obtener_vista($this, "inicio", $array);
}








public function informacion($parametros){
$nombre_funcion = __FUNCTION__;
$arrPARAM = explode(",", $parametros)[0];

//------------------------------------------------------
if($arrPARAM == "subirfoto" && isset($_POST["foto"])){
echo $this->fotoModel->actualizar_fotoperfil($_POST["foto"]);
}else if($arrPARAM == "eliminarFoto"){
$this->fotoModel->quitar_fotoperfil();
echo '<script>location.href="'.BASE_URL.'profile/informacion"; </script>';

//------------------------------------------------------
}else if($arrPARAM == "eliminarCuenta" &&
isset($_POST["punt-app"]) &&
isset($_POST["respuesta"])){

$pnt = $_POST["punt-app"];
$resp = $_POST["respuesta"];

if($this->accountModel->guardar_opinion($pnt, $resp) && $this->accountModel->eliminar_cuenta()){
echo 1;
}else{
echo 2;
}


//------------------------------------------------------
}else if($arrPARAM == "actualizarCuenta" &&
isset($_POST["nombres"]) &&
isset($_POST["apellidos"]) &&
isset($_POST["correo"]) &&
isset($_POST["fnac"]) &&
isset($_POST["tel"]) &&
isset($_POST["genero"])
){


if(isset($_POST["mi_desc"]) && trim($_POST["mi_desc"]) == ""){
$mi_desc = "N/A";
}else{
$mi_desc = $_POST["mi_desc"];
}


$array = array(
$_POST["nombres"],
$_POST["apellidos"],
$_POST["correo"],
$_POST["fnac"],
$_POST["genero"],
$mi_desc,
$_POST["tel"]
);


if($this->accountModel->actualizar_infocuenta($array)){
echo 1;
}else{
echo 2;
}

//------------------------------------------------------
}else if($arrPARAM == "actualizar-seguridadProfile" &&
isset($_POST["actividad-cuenta"]) &&
isset($_POST["estado-cuenta"])
){
$act_cuenta =$_POST["actividad-cuenta"];
$estado = $_POST["estado-cuenta"];

$arr_secure = array("1","2","3");
if(verificar_coincidencias($act_cuenta,$arr_secure)>0 || verificar_coincidencias($estado, $arr_secure)>0){
}else{
echo 0;
exit;
}

if ($estado == 1) {
$estado = "dblock";
}else if ($estado == 2) {
$estado = "block";
}else if ($estado == 3) {
$estado = "susp";
}else{
echo 0;
exit;
}

$array = array($_POST["actividad-cuenta"], $estado);

if($this->accountModel->actualizar_segcuenta($array)){
echo 1;
}else{
echo 2;
}
//------------------------------------------------------
}else if($arrPARAM == "cambiarClave" &&
isset($_POST["clave-old"]) &&
isset($_POST["clave-new"])
){
$array = array($_POST["clave-old"], $_POST["clave-new"]);


if($this->accountModel->cambiarClave($array) == 1){
echo 1;
}else if($this->accountModel->cambiarClave($array) == 3){
echo 3;
}else{
echo 2;
}
//------------------------------------------------------

}else{
$array = array (
"item-bar"=>$nombre_funcion,
"datos"=>$this->db["datos"],
"sitio"=>$this->db["sitio"]);
$this->vistas->obtener_vista($this, "inicio", $array);
}
}













public function seguridad($parametros){
$nombre_funcion = __FUNCTION__;
$arrPARAM = explode(",", $parametros)[0];


if($arrPARAM == "actualizar-seguridadSitio" &&
isset($_POST["nombre-app"]) &&
isset($_POST["clave-app"]) &&
isset($_POST["hash-app"]) &&
isset($_POST["sniff-app"]) &&
isset($_POST["estado-app"]) &&
isset($_POST["envios-correo"]) &&
isset($_POST["desc-app"]) &&
isset($_POST["terminos-app"])
){
$vsniff =$_POST["sniff-app"];
$vestado = $_POST["estado-app"];
$ecorreo = $_POST["envios-correo"];

$arr_secure = array("1","2","3");
if(verificar_coincidencias($vsniff, $arr_secure)>0 || verificar_coincidencias($vestado, $arr_secure)>0 || verificar_coincidencias($ecorreo, $arr_secure)>0){
}else{
echo 0;
exit;
}



if ($vestado == 1) {
$estado = "dblock";
}else if ($vestado ==2) {
$estado = "mant";
}else if ($vestado ==3) {
$estado = "secure";
}



$array = array($_POST["nombre-app"], $_POST["clave-app"], $_POST["hash-app"], $vsniff, $estado, $_POST["desc-app"], $_POST["terminos-app"], $ecorreo);

if($this->sitioModel->actualizar_segapp($array)){
echo 1;
}else{
echo 2;
}

//------------------------------------------------------
}else  if($arrPARAM == "extraer-sesiones" &&
isset($_POST["buscarSesion"])){


if ($this->accountModel-> extraer_sesiones($_POST["buscarSesion"], 1)>0) {

$contar_sesiones = $this->accountModel->extraer_sesiones($_POST["buscarSesion"], 1);
$sql = $this->accountModel->extraer_sesiones($_POST["buscarSesion"], 2);


while($ext = $sql->fetch()){

$estado_sesion = $ext["estado_sesion"];
$ran_class = randalfa(1,8);
$ran_class2 = randalfa(1,8);


if ($estado_sesion == "activo") {
$titulo_estado_sesion= '<h4 class="text-uppercase"><strong>Estado Activo </strong> <i class="fas fa-circle" style="color: #13b500;"></i></h4>';
$style_estado='border-top: 10px solid #13b500;';
$opt_sesion=1;
//--------------------------------------------------
}else if ($estado_sesion == "nactivo") {
$titulo_estado_sesion= '<h4 class="text-uppercase"><strong>Estado Inactivo </strong> <i class="fas fa-circle" style="color: #b3b3b3;"></i></h4>';
$style_estado='border-top: 10px solid  #b3b3b3;';
$opt_sesion=2;
//--------------------------------------------------
}else if ($estado_sesion == "anti-block") {
$titulo_estado_sesion= '<h4 class="text-uppercase"><strong>Estado Antiblock </strong> <i class="fas fa-circle" style="color:#5445b6;"></i></h4>';
$style_estado='border-top: 10px solid #5445b6;';
$opt_sesion=3;

}else{
$titulo_estado_sesion = "Desconocido X";
$style_estado='border-top: 11px solid red;';
$opt_sesion=1;
}



echo '
<div class="col-md-4 pt-3">
<div class="div-sesiones '.$ran_class.'" style="'.$style_estado.'">'.$titulo_estado_sesion;

if(navegador_info(2)["user_agent"] == $ext["user_agent"] && navegador_info(1) == $ext["ip"]){
echo '<h5 style="background: #4838a1;color: white;padding: 4px 18px;border-radius: 3px;">IP Actual : '.$ext["ip"].'</h5>';
}else{
echo '<h5 style="background:#6e6e6e;color: white;padding: 4px 18px;border-radius: 3px;">IP Iniciada : '.$ext["ip"].'</h5>';
}

echo '<font class="item-text"><strong>Navegador : </strong>'.$ext["nav"].'</font>
<font class="item-text"><strong>Plataforma : </strong>'.$ext["plat"].'</font>
<font class="item-text"><strong>Fecha : </strong>'.$ext["fecha"].'</font>
<font class="item-text"><strong>User Agent : </strong>'.$ext["user_agent"].'</font>

<div class="d-flex flex-column flex-md-row pt-2 accion-btn-sesion " est_sesion="'.$opt_sesion.'" class_sesion='.$ran_class.' ide_sesion='.$ext["Id"].'>
<button type="button" btn="1" class="btn btn-sm style-btn-6 "><i class="fa fa-trash"></i> Eliminar</button>';

if($estado_sesion == "activo" || $estado_sesion == "nactivo"){
echo '<button  btn="2" type="button" class="btn btn-sm style-btn-8 "><i class="fa fa-unlock"></i> Antiblock</button>';
}else if($estado_sesion == "anti-block"){
echo '<button  btn="2" type="button" class="btn btn-sm style-btn-1 "><i class="fa fa-lock"></i> Antiblock</button>';

}



echo '</div>
</div>
</div>
';
}

}else{
echo '<div class="col-12">
<h4 class="text-muted text-center text-md-left"><i class="fal fa-search"></i> NO tienes sesiones  Abiertas.</h4>
</div>
</div>';
}
//------------------------------------------------------
}else if($arrPARAM == "antiblock-sesion" &&
isset($_POST["ide_sesion"]) &&
isset($_POST["est_sesion"]) &&
isset($_POST["antiblock"]) ){

$est_se = $_POST["est_sesion"];
if ($est_se == 1 || $est_se == 2) {
$est = "anti-block";
}else{
$est = "nactivo";
}




if($this->accountModel->antiblock_sesion($est, $_POST["ide_sesion"])>0){
echo 1;
}else{
echo 2;
}

//------------------------------------------------------
}else if($arrPARAM == "eliminar-sesion" &&
isset($_POST["ide_sesion"]) &&
isset($_POST["eliminar"]) ){

if($this->accountModel->eliminar_sesiones($_POST["ide_sesion"])>0){
echo 1;
}else{
echo 2;
}
//------------------------------------------------------
}else if($arrPARAM == "eliminar-sesiones" &&
isset($_POST["eliminar"]) && $_POST["eliminar"] == true){

if($this->accountModel->eliminar_sesiones()>0){
echo 1;
}else{
echo 2;
}


}else{
$array = array (
"item-bar"=>$nombre_funcion,
"datos"=>$this->db["datos"],
"sitio"=>$this->db["sitio"]);
$this->vistas->obtener_vista($this, "inicio", $array);
}
}


















public function sniff($parametros){
$nombre_funcion = __FUNCTION__;
$arrPARAM = explode(",", $parametros)[0];

//------------------------------------------------------
if($arrPARAM == "ver-sniffers" &&
isset($_POST["buscarSniffer"])){

if ($this->sitioModel->extraer_sniffer($_POST["buscarSniffer"], 1)>0) {
$contar_sniff = $this->sitioModel->extraer_sniffer($_POST["buscarSniffer"], 1);

echo "<div class='count-sniff'><label class='mb-0'><i class='far fa-search'></i> ".$contar_sniff." - Sniffers</label></div>";

echo '<div class="row m-0" >';
$sql = $this->sitioModel->extraer_sniffer($_POST["buscarSniffer"], 2);
while($ext = $sql->fetch()){
$ran_class = randalfa(1,8);
$ran_class2 = randalfa(1,8);

echo '
<div class="col-md-6 '.$ran_class.'">
<div class="pt-4 " style="border-top: 2px solid green;">';

if($ext["estado"] == "block" || $ext["estado"] == "urlblock"){
echo '<strong style="color: #785fa0;" class="ip text-center text-md-left"><i class="fa fa-location"></i>  IP : '.$ext["ip"].'</strong>';
}else{
echo '<strong  class="ip text-center text-md-left"><i class="fa fa-location"></i>  IP : '.$ext["ip"].'</strong>';
}

echo '<!--------------------------------------------->
<font class="item-dato"><strong>Clase Control :</strong> '.$ext["class_control"].'</font>
<font class="item-dato"><strong>Plataforma :</strong> '.$ext["plataforma"].'</font>
<font class="item-dato"><strong>Navegador :</strong> '.$ext["nav"].'</font>
<font class="item-dato"><strong>URL Peticion : </strong>'.$ext["url_peticion"].'</font>
<font class="item-dato"><strong>Metodo de envio :</strong> '.$ext["tipo_pet"].'</font>
<font class="item-dato"><strong>Fecha : </strong> '.$ext["fecha_pet"].'</font>

<hr>';

//---------------------------
echo '<div class="div-desc-pet '.$ran_class2.'">
<font class="item-dato"><strong>Version :</strong> '.$ext["nav_vers"].'</font>
<font class="item-dato"><strong>User Agent :</strong> '.$ext["user_agent"].'</font>

<font class="item-dato-json"><strong>Datos Peticion :</strong> '.htmlspecialchars($ext["json_peticion"]).'</font>
</div>';
//---------------------------

if ($ext["estado"] == "block") {
$tblock = 1;
}else if ($ext["estado"] == "urlblock") {
$tblock = 2;
}else if ($ext["estado"] == "dblock") {
$tblock = 3;
}


//---------------------------
echo '<div class="d-flex flex-column flex-md-row py-3 accion-btn-sniff " class_desc="'.$ran_class2.'" class_sniff="'.$ran_class.'" est_sniff="'.$tblock.'" ide_sniff="'.$ext["Id"].'">

<button type="button" btn="1" class="btn style-btn-1 btn-sm "><i class="far fa-eye"></i> Ver</button>';
//---------------------------
if ($ext["estado"] == "block") {
echo '<button type="button" btn="2" class="btn style-btn-4 btn-sm  ml-md-2"><i class="far fa-lock"></i> IP Bloqueada</button>';
//---------------------------
}else if ($ext["estado"] == "urlblock") {
echo '<button type="button" btn="2" class="btn style-btn-4 btn-sm  ml-md-2"><i class="far fa-lock"></i> Sniffer Bloqueado</button>';
//---------------------------
}else if ($ext["estado"] == "dblock") {
echo '<button type="button" btn="2" class="btn style-btn-6 btn-sm  ml-md-2"><i class="far fa-unlock"></i> Bloquear</button>';
}
//---------------------------
echo '<button type="button" btn="3" class="btn style-btn-7 btn-sm ml-md-2"><i class="far fa-trash"></i> Eliminar</button>
</div>';
//---------------------------


echo '
</div>
</div>
';
}


}else{
echo '<div class="col-12">
<h4 class=""><i class="fal fa-search text-center text-md-left"></i> No hay Sniffers.</h4>
</div>';
}

echo "</div>";

//------------------------------------------------------
}else if($arrPARAM == "block-sniff" && isset($_POST["ide_sniff"]) && isset($_POST["tblock"]) && isset($_POST["block"])){


if ($_POST["tblock"] == 1) {
$tblock = "block";
}else if ($_POST["tblock"] == 2) {
$tblock = "urlblock";
}else if ($_POST["tblock"] == 3) {
$tblock = "dblock";
}else{
echo 0;
exit;
}

$array = array ($_POST["ide_sniff"], $tblock);
if($this->sitioModel->block_sniff($array)>0){
echo 1;
}else{
echo 2;
}


//------------------------------------------------------
}else if($arrPARAM == "eliminar-sniff" &&
isset($_POST["ide_sniff"]) &&
isset($_POST["eliminar"]) ){

if($this->sitioModel->eliminar_sniffers($_POST["ide_sniff"])>0){
echo 1;
}else{
echo 2;
}
//------------------------------------------------------
}else if($arrPARAM == "eliminar-sniffers" &&
isset($_POST["eliminar"]) && $_POST["eliminar"] == true){

if($this->sitioModel->eliminar_sniffers()>0){
echo 1;
}else{
echo 2;
}

//------------------------------------------------------
}else{
$array = array (
"item-bar"=>$nombre_funcion,
"datos"=>$this->db["datos"],
"sitio"=>$this->db["sitio"]);
$this->vistas->obtener_vista($this, "inicio", $array);
}
}

















public function infoPortafolio($param){
$nombre_funcion = __FUNCTION__;
$arrPARAM = explode(",", $param)[0];

//------------------------------------------------------
if($arrPARAM == "agregar-sess" &&
isset($_POST["tit-sesion"]) &&
isset($_POST["ver-sesion"]) &&
isset($_POST["desc-sesion"])
){

if (!verificar_coincidencias(array(1,2), $_POST["ver-sesion"])) {
exit;
}


$array = array ($_POST["tit-sesion"], $_POST["ver-sesion"], $_POST["desc-sesion"]);
echo $this->sitioModel->agregarsitio_sess($array);
//------------------------------------------------------
}else if($arrPARAM == "actualizar-sess" &&
isset($_POST["ide-sesion"]) &&
isset($_POST["tit-sesion"]) &&
isset($_POST["ver-sesion"]) &&
isset($_POST["desc-sesion"])
){

if (!verificar_coincidencias(array(1,2), $_POST["ver-sesion"])) {
exit;
}


$array = array ($_POST["ide-sesion"], $_POST["tit-sesion"], $_POST["ver-sesion"], $_POST["desc-sesion"]);
if($this->sitioModel->actualizarsitio_sess($array)>0){
echo 1;
}else{
echo 2;
}

//------------------------------------------------------
}else if($arrPARAM == "eliminar-sess" &&
isset($_POST["eliminar"]) &&
isset($_POST["ide_sesion"]) &&
$_POST["eliminar"] == true){

if($this->sitioModel->eliminar_sess($_POST["ide_sesion"])>0){
echo 1;
}else{
echo 2;
}
//------------------------------------------------------

}else if($arrPARAM == "actualizar-agr-cont" &&
isset($_POST["idec1"]) &&
isset($_POST["idec2"]) &&
isset($_POST["idea1"]) &&
isset($_POST["idea2"]) &&
isset($_POST["actualizar"]) &&
$_POST["actualizar"] == true){

if($this->sitioModel->actualizar_ag_cont(array(
$_POST["idec1"],
$_POST["idec2"],
$_POST["idea1"],
$_POST["idea2"]))>0){
echo 1;
}else{
echo 2;
}

//------------------------------------------------------
}else if($arrPARAM == "agregar-doc" &&
isset($_POST["nombre-doc"]) &&
isset($_POST["vis-doc"]) &&
isset($_FILES["file-doc"]) &&
isset($_POST["subirdoc"]) &&
$_POST["subirdoc"] == true){

//----- VERIFICACION EXTENCION ----------
$array = array("xlsx", "xls", "doc", "docx", "ppt", "pptx", "pdf");

if (!verificar_coincidencias($_FILES["file-doc"]["type"], $array)==1){
echo "El archivo a subir NO es un documento.";
exit;
}
//--------------------------------------



$carpeta = "doc/";
$nombre_doc = $_POST["nombre-doc"];
$vis_doc = $_POST["vis-doc"];
//--------------------------------
$arch =  $_FILES["file-doc"];
$org_name = $arch["name"];
$new_name = randalfa(1,20).".".extraer_extencion($arch["name"]);


$array = array($nombre_doc, $org_name, $vis_doc, $new_name);
if($this->sitioModel->agregar_doc($array)== 1){
if(move_uploaded_file($arch['tmp_name'], $carpeta.$new_name)) {
echo 1;
}else{
echo 3;
}
}else{
echo 2;
}
//------------------------------------------------------
}else if($arrPARAM == "actualizar-doc" &&
isset($_POST["ide-doc"]) &&
isset($_POST["nombre-doc"]) &&
isset($_POST["vis-doc"]) &&
isset($_POST["subirdoc"]) &&
$_POST["subirdoc"] == true){


if($this->sitioModel->extraer_info_doc($_POST["ide-doc"], 1)>0){
//----------------------------------------
$ext_infodoc = $this->sitioModel->extraer_info_doc($_POST["ide-doc"], 2);

if(isset($_FILES["file-doc"])){
//----- VERIFICACION EXTENCION ----------
$array = array("xlsx", "xls", "doc", "docx", "ppt", "pptx", "pdf");

if (!verificar_coincidencias($_FILES["file-doc"]["type"], $array)==1){
echo "El archivo a subir NO es un documento.";
exit;
}
//--------------------------------------
$carpeta = "doc/";
$nombre_doc = $_POST["nombre-doc"];
$vis_doc = $_POST["vis-doc"];
//--------------------------------
$arch =  $_FILES["file-doc"];
$org_name = $arch["name"];
$new_name = randalfa(1,20).".".extraer_extencion($arch["name"]);
$url_doc = $this->sitioModel->extraer_info_doc($_POST["ide-doc"], 2)["url_doc"];
//---------------------------------------
eliminar_archivo($carpeta.$url_doc);
$array = array($_POST["ide-doc"], $nombre_doc, $org_name, $vis_doc, $new_name);

if($this->sitioModel->actualizar_doc($array)>0 && move_uploaded_file($arch['tmp_name'], $carpeta.$new_name)) {
echo 1;
}else{
echo 4;
}
}else{

$array = array($_POST["ide-doc"], $_POST["nombre-doc"], $ext_infodoc["nombre_original"],  $_POST["vis-doc"], $ext_infodoc["url_doc"]);

if($this->sitioModel->actualizar_doc($array)>0){
echo 1;
}else{
echo 2;
}



}
//-------------------------------------------
}else{
echo 3;
}








//------------------------------------------------------
}else if($arrPARAM == "extraerall-doc" &&
isset($_POST["extraer"]) &&
$_POST["extraer"] == true){


if ($this->sitioModel->extraer_alldocs(1)>0) {
$sentencia = $this->sitioModel->extraer_alldocs(2);

while ($ext_info = $sentencia->fetch()) {
echo '
<tr>
<td class="text-center">'.$ext_info["Id"].'</td>
<td>'.$ext_info["nombre"].'</td>
<td>'.$ext_info["nombre_original"].'</td>';

if($ext_info["view"] == 1){
echo '<td>Activo</td>';
}else{
echo '<td>NO Activo</td>';
}

echo '<td>'.$ext_info["fecha"].'</td>

<td class="td-actions text-center btn-accion-doc" ide="'.$ext_info["Id"].'">
<a target="_blank" href="https://docs.google.com/gview?url='.BASE_URL.'doc/'.$ext_info["url_doc"].'" ">
<button type="button"  rel="tooltip" class="btn btn-info btn-round btn-icon btn-sm">
<i class="fal fa-eye"></i>
</button></a>
<button type="button" btn="1" rel="tooltip" class="btn btn-success btn-round btn-icon btn-sm">
<i class="tim-icons icon-pencil"></i>
</button>
<button type="button" btn="2" rel="tooltip" class="btn btn-danger btn-round btn-icon btn-sm">
<i class="tim-icons icon-simple-remove"></i>
</button>
</td>
</tr>';

}


}else{
echo '<tr>
<td class="pl-5" colspan="5"><i class="far fa-search"></i> No se encontraron Documentos.</td></tr>';
}


//------------------------------------------------------
}else if($arrPARAM == "eliminar-doc" &&
isset($_POST["ide_doc"]) &&
isset($_POST["eliminar"]) &&
$_POST["eliminar"] == true){


if($this->sitioModel->extraer_info_doc($_POST["ide_doc"], 1)>0){
$url_doc = $this->sitioModel->extraer_info_doc($_POST["ide_doc"], 2)["url_doc"];

if(eliminar_archivo("doc/".$url_doc)>0 &&
$this->sitioModel->eliminar_doc($_POST["ide_doc"])>0){
echo 1;
}else{
echo 3;
}

}else{
echo 2;
}
//------------------------------------------------------
}else if($arrPARAM == "extraer-infodoc" &&
isset($_POST["ide_doc"]) &&
isset($_POST["extraer"]) &&
$_POST["extraer"] == true){


if($this->sitioModel->extraer_info_doc($_POST["ide_doc"], 1)>0){
$ext_infodoc = $this->sitioModel->extraer_info_doc($_POST["ide_doc"], 2);

echo codificar_json(array(
"code"=>1,
"nombre" => $ext_infodoc["nombre"],
"vista" => $ext_infodoc["view"]
));

}else{
echo codificar_json(array("code", 2));
}


//------------------------------------------------------
}else{
$array = array (
"item-bar"=>$nombre_funcion,
"datos"=>$this->db["datos"],
"sitio"=>$this->db["sitio"]);
$this->vistas->obtener_vista($this, "inicio", $array);
}
}


















public function trabajos($parametros){
$nombre_funcion = __FUNCTION__;
$arrPARAM = explode(",", $parametros)[0];
//------------------------------------------------------



if ($arrPARAM == "act-estrabajo" && isset($_POST["statework"])) {
if($this->sitioModel->actualizar_estrabajo($_POST["statework"], 1)>0){
echo 1;
}else{
echo 2;
}

//-------------------------------------------------------
}else if ($arrPARAM == "ext-trabajos" && isset($_POST["searchwork"])) {


if($this->sitioModel->extraer_trabajos($_POST["searchwork"], 1)>0){


$sentencia = $this->sitioModel->extraer_trabajos($_POST["searchwork"], 2);
while ($ext_info = $sentencia->fetch()) {

$estado = $ext_info["estado"];
//------------------------------------
if ($estado == "destacado") {
$bg_color = "estado-dest";
}else if ($estado == "rechazada") {
$bg_color = "estado-rech";
}else if ($estado == "aceptada") {
$bg_color = "estado-acept";
}else{
$bg_color = "";
}



echo '<tr class="'.$bg_color.'">
<td>'.$ext_info["Id"].'</td>
<td>'.$ext_info["nombres"].'</td>
<td>'.$ext_info["apellidos"].'</td>
<td>'.$ext_info["org_emp"].'</td>
<td>'.$ext_info["tel"].'</td>
<td>'.$ext_info["hora"].'</td>
<td>'.$ext_info["fecha"].'</td>



<td class="td-actions text-center btn-accion-trab" ide="'.$ext_info["Id"].'">

<button type="button" btn="1"  rel="tooltip" class="btn style-btn-4 btn-sm btn-round btn-icon">
<i class="fal fa-info"></i>
</button> ';



if($estado == "aceptada" || $estado == "rechazada"){
echo '<button  type="button" rel="tooltip" class="btn style-btn-3 btn-sm btn-round btn-icon" disabled>
<i class="far fa-star"></i>
</button> ';
}else{
echo '<button  type="button" bool-dest="'.($estado == "destacado"?"1":"2").'" btn="2" rel="tooltip" class="btn style-btn-8 btn-sm btn-round btn-icon">
<i class="far fa-tags"></i>
</button> ';
}

//----------------------------------------------


if($estado == "aceptada" || $estado == "rechazada"){
echo '<button type="button"  rel="tooltip" class="btn style-btn-3 btn-sm btn-round btn-icon" disabled>
<i class="far fa-save"></i>
</button> ';
}else{
echo '<button type="button"  btn="3" rel="tooltip" class="btn style-btn-3 btn-sm btn-round btn-icon">
<i class="far fa-rocket"></i>
</button> ';
}








echo '<button type="button" btn="4" rel="tooltip" class="btn style-btn-9 btn-sm btn-round btn-icon">
<i class="tim-icons icon-simple-remove"></i>
</button>





</td>


</tr>';

}
}else{
echo '<tr><td class="pl-3" colspan="7"><i class="fa fa-search"></i> No se encontraron resultados</td></tr>';
}

//-------------------------------------------------------
}else if($arrPARAM == "eliminar-trabajos" &&
isset($_POST["eliminar"]) && $_POST["eliminar"] == true){

if($this->sitioModel->eliminar_trabajos()>0){
echo 1;
}else{
echo 2;
}


//------------------------------------------------------
}else if($arrPARAM == "rechazar-trabajo" &&
isset($_POST["ide_trab"]) &&
isset($_POST["mensaje"]) &&
isset($_POST["actualizar"]) &&
$_POST["actualizar"] == true){
$ext_info_client = $this->sitioModel->extraer_info_trabajo($_POST["ide_trab"], 2);


//------------------------------------------
//------------- ENVIO DE CORREO ------------
//------------------------------------------
if ($this->conf_email == 1) {
$Funcorreo = $this->confSet_Email;
$ext_info_dev = $this->db["datos"];

//----------------------------------------
$bodyHTML = $Funcorreo->plantilla(array(
"nombre_app" => $this->db["sitio"]["nombre_app"],
"plant_email"=>3,
"nombre_cliente"=> $ext_info_client["nombres"]." ".$ext_info_client["apellidos"],
"nombre_developer"=>$ext_info_dev["nombres"]." ".$ext_info_dev["apellidos"],
"mensaje"=>$_POST["mensaje"]
));
//----------------------------------------
$resp_correo = $Funcorreo->enviarCorreo("Estado de Solicitud", "Test J|Doxx", $ext_info_client["correo"], "Creacion del Software.", $bodyHTML);
}else{
$resp_correo = 1;
}
//----------------------------------------



if($resp_correo){

if($this->sitioModel->extraer_info_trabajo($_POST["ide_trab"], 1)>0){

if($this->sitioModel->actualizar_estrabajos($_POST["ide_trab"], "rechazada")>0){
echo 1;
}else{
echo 3;
}
}else{
echo 2;
}

}else{
echo 4;
}

//------------------------------------------------------
}else if($arrPARAM == "destacar-trabajo" &&
isset($_POST["ide_trab"]) &&
isset($_POST["est_trab"]) &&
isset($_POST["actualizar"]) &&
$_POST["actualizar"] == true){

$estado = $_POST["est_trab"];
if ($estado == 1) {
$est = "espera";
}else if ($estado == 2) {
$est = "destacado";
}else{
exit;
}





if($this->sitioModel->extraer_info_trabajo($_POST["ide_trab"], 1)>0){
if($this->sitioModel->actualizar_estrabajos($_POST["ide_trab"], $est)>0){
echo 1;
}else{
echo 3;
}
}else{
echo 2;
}



//------------------------------------------------------
}else if($arrPARAM == "eliminar-trabajo" &&
isset($_POST["ide_trab"]) &&
isset($_POST["eliminar"]) &&
$_POST["eliminar"] == true){






if($this->sitioModel->extraer_info_trabajo($_POST["ide_trab"], 1)>0){
if($this->sitioModel->eliminar_trabajo($_POST["ide_trab"])>0){
echo 1;
}else{
echo 3;
}
}else{
echo 2;
}




//------------------------------------------------------
}else if($arrPARAM == "cont-trabajos" &&
isset($_POST["extraer"]) &&
$_POST["extraer"] == true){


$aceptada= $this->sitioModel->extraer_cont_trabajos("aceptada");
$revisar = $this->sitioModel->extraer_cont_trabajos("espera");
$destacado = $this->sitioModel->extraer_cont_trabajos("destacado");
$rechazada = $this->sitioModel->extraer_cont_trabajos("rechazada");

echo codificar_json(array(
"aceptada"=>$aceptada,
"espera"=>$revisar,
"destacado"=>$destacado,
"rechazada"=>$rechazada,
));

//------------------------------------------------------
}else if($arrPARAM == "extraer-infotrabajo" &&
isset($_POST["ide_trab"]) &&
isset($_POST["extraer"]) &&
$_POST["extraer"] == true){

if($this->sitioModel->extraer_info_trabajo($_POST["ide_trab"], 1)>0){
$ext_info = $this->sitioModel->extraer_info_trabajo($_POST["ide_trab"], 2);
$lat = decodificar_json( $ext_info["json_coord"], "lat");
$long = decodificar_json( $ext_info["json_coord"], "long");



echo codificar_json(array(
"ide_trab"=>$ext_info["Id"],
"lat"=>$lat,
"long"=>$long,
"nombres"=>$ext_info["nombres"],
"apellidos"=>$ext_info["apellidos"],
"correo"=>$ext_info["correo"],
"tel"=>$ext_info["tel"],
"org"=>$ext_info["org_emp"],
"desc"=>$ext_info["work_resp"],
"hora"=>$ext_info["hora"],
"fecha"=>$ext_info["fecha"],
"estado"=>$ext_info["estado"],
$ext_info["json_coord"]

));


}else{
echo 2;
}

//------------------------------------------------------
}else if($arrPARAM == "aceptar-trabajo" &&
isset($_POST["ide-trab"]) &&
isset($_POST["tipo-trab"]) &&
isset($_POST["valor-trab"]) &&
isset($_POST["actualizar"]) &&
$_POST["actualizar"] == true){

$ext_info_client = $this->sitioModel->extraer_info_trabajo($_POST["ide-trab"], 2);

$desc_trab  = isset($_POST["desc-trab"]) ? $_POST["desc-trab"]:0;



//------------------------------------------
//------------- ENVIO DE CORREO ------------
//------------------------------------------
if ($this->conf_email == 1) {
$Funcorreo = $this->confSet_Email;
$ext_info_dev = $this->db["datos"];
//----------------------------------------
$bodyHTML = $Funcorreo->plantilla(array(
"nombre_app" => $this->db["sitio"]["nombre_app"],
"plant_email"=>2,
"nombre_cliente"=> $ext_info_client["nombres"]." ".$ext_info_client["apellidos"],
"nombre_developer"=>$ext_info_dev["nombres"]." ".$ext_info_dev["apellidos"],
"desc_producto"=>$_POST["tipo-trab"],
"whatsapp_developer"=>$ext_info_dev["codigo_pais"].$ext_info_dev["tel"],
"correo_developer"=>$ext_info_dev["correo"],
"valor_producto"=>$_POST["valor-trab"],
"mensaje"=>$desc_trab
));
//----------------------------------------
$resp_correo = $Funcorreo->enviarCorreo("Estado de Solicitud", "Test J|Doxx", $ext_info_client["correo"], "Creacion del Software.", $bodyHTML);
}else{
$resp_correo = 1;
}
//----------------------------------------



if($resp_correo){
if($this->sitioModel->extraer_info_trabajo($_POST["ide-trab"], 1)>0){

if($this->sitioModel->actualizar_estrabajos($_POST["ide-trab"], "aceptada")>0){
echo 1;
}else{
echo 3;
}
}else{
echo 2;
}
}else{
echo 4;
}

}else if($arrPARAM == "socket-info-actualizar" &&
@$_POST["url-websocket"] &&
@$_POST["token-websocket"] &&
@$_POST["actualizar"] &&
$_POST["actualizar"] == true){


if($this->soporteModel->actualizar_info_socket(array($_POST["url-websocket"], $_POST["token-websocket"],0, 1))>0){
echo 1;
}else{
echo 2;
}

}else if ($arrPARAM == "socket-ext-trabajos" && isset($_POST["searchwork"])) {


if($this->soporteModel->extraer_trabajos($_POST["searchwork"], 1)>0){


$sentencia = $this->soporteModel->extraer_trabajos($_POST["searchwork"], 2);
while ($ext_info = $sentencia->fetch()) {

$estado = $ext_info["estado"];
//------------------------------------
if ($estado == "pago") {
$bg_color = "estado-dest";
}else if ($estado == "rechazada") {
$bg_color = "estado-rech";
}else if ($estado == "aceptada") {
$bg_color = "estado-acept";
}else if ($estado == "call") {
$bg_color = "estado-call";
}else{
$bg_color = "";
}



echo '<tr class="'.$bg_color.'">
<td>'.$ext_info["ide_caso"].'</td>
<td>'.$ext_info["ide_con"].'</td>
<td>'.$ext_info["clave_con"].'</td>
<td>'.$ext_info["nombres"].'</td>
<td>'.$ext_info["apellidos"].'</td>
<td>'.$ext_info["correo"].'</td>
<td>'.$ext_info["tel"].'</td>
<td>'.$ext_info["hora"].'</td>
<td>'.$ext_info["fecha"].'</td>



<td class="td-actions text-center btn-accion-trab-remoto" ide="'.$ext_info["Id"].'" correo_client="'.$ext_info["correo"].'"   ide_client="'.$ext_info["ide_caso"].'" hash_secure="'.$ext_info["hash_secure"].'">

<button type="button" btn="1"  rel="tooltip" class="btn style-btn-4 btn-sm btn-round btn-icon">
<i class="fal fa-info"></i>
</button> ';



if ($estado == "rechazada") {
echo '<button  type="button" bool-dest="'.($estado == "destacado"?"1":"2").'" disabled rel="tooltip" class="btn style-btn-2 btn-sm btn-round btn-icon">
<i class="far fa-phone-plus"></i>
</button> ';

}else{
echo '<button  type="button" bool-dest="'.($estado == "destacado"?"1":"2").'" btn="2" rel="tooltip" class="btn style-btn-2 btn-sm btn-round btn-icon">
<i class="far fa-phone-plus"></i>
</button> ';
}






if ($estado == "rechazada") {
echo '<button  type="button" bool-dest="'.($estado == "destacado"?"1":"2").'" disabled="" rel="tooltip" class="btn style-btn-3 btn-sm btn-round btn-icon"><i class="fad fa-usd-circle"></i></button> ';
}else{
echo '<button  type="button" bool-dest="'.($estado == "destacado"?"1":"2").'" btn="3" rel="tooltip" class="btn style-btn-3 btn-sm btn-round btn-icon"><i class="fad fa-usd-circle"></i></button> ';
}




if ($estado == "rechazada") {
echo '<button  type="button" bool-dest="'.($estado == "destacado"?"1":"2").'" disabled rel="tooltip" class="btn style-btn-8 btn-sm btn-round btn-icon"><i class="far fa-check"></i></button> ';
}else{
echo '<button  type="button" bool-dest="'.($estado == "destacado"?"1":"2").'" btn="4" rel="tooltip" class="btn style-btn-8 btn-sm btn-round btn-icon"><i class="far fa-check"></i></button> ';
}




if ($estado == "rechazada" ) {
echo '<button type="button"  disabled rel="tooltip" class="btn style-btn-5 btn-sm btn-round btn-icon">
<i class="far fa-rocket"></i>
</button> ';

}else{
echo '<button type="button"  btn="5" rel="tooltip" class="btn style-btn-5 btn-sm btn-round btn-icon">
<i class="far fa-rocket"></i>
</button> ';
}


echo '<button type="button"  btn="6" rel="tooltip" class="btn style-btn-9 btn-sm btn-round btn-icon">
<i class="far fa-trash"></i>
</button> ';





echo '</td>


</tr>';

}
}else{
echo '<tr><td class="pl-3" colspan="10"><i class="fa fa-search"></i> No se encontraron resultados</td></tr>';
}


//------------------------------------------------------
}else if($arrPARAM == "socket-ext-infotrabajo" &&
isset($_POST["ide_trab"]) &&
isset($_POST["extraer"]) &&
$_POST["extraer"] == true){

if($this->soporteModel->extraer_info_trabajo($_POST["ide_trab"], 1)>0){
$ext_info = $this->soporteModel->extraer_info_trabajo($_POST["ide_trab"], 2);

echo codificar_json(array(
"code"=>1,
"ide_cliente"=>$ext_info["ide_caso"],
"hash_cliente"=>$ext_info["hash_secure"],
"desc"=>$ext_info["descripcion"],
));


}else{
echo codificar_json(array(
"code"=>2,
"ide_cliente"=>"",
"hash_cliente"=>"",
"desc"=>"",
));
}


//------------------------------------------------------
}else if($arrPARAM == "trab-remoto-eliminar" &&
isset($_POST["hash_cliente"]) &&
isset($_POST["eliminar"]) &&
$_POST["eliminar"] == true){

if($this->soporteModel->verificar_cliente($_POST["hash_cliente"], 1)){
$ext_info = $this->soporteModel->verificar_cliente($_POST["hash_cliente"],2);


//----------------------------------------
$ext_info_client = $ext_info;

if (!$ext_info_client["estado"] == "rechazada") {
//----------------------------------------
if ($this->conf_email == 1) {
$Funcorreo = $this->confSet_Email;
$ext_info_dev = $this->db["datos"];

//----------------------------------------
$bodyHTML = $Funcorreo->plantilla(array(
"nombre_app" => $this->db["sitio"]["nombre_app"],
"plant_email"=>5,
"nombre_cliente"=> $ext_info_client["nombres"]." ".$ext_info_client["apellidos"],
"nombre_developer"=>$ext_info_dev["nombres"]." ".$ext_info_dev["apellidos"],
"mensaje"=>$_POST["mensaje"]
));
//----------------------------------------
$Funcorreo->enviarCorreo("#".$ext_info_client["ide_caso"]." caso Cerrado", "Test J|Doxx", $ext_info_client["correo"], "Sesion Terminada.", $bodyHTML);
}
//----------------------------------------
}


if ($this->soporteModel->eliminar_cliente($_POST["hash_cliente"])) {

echo 1;
exit;
}else{
echo 3;
}

}else{
echo 2;
}

//------------------------------------------------------
}else if($arrPARAM == "trab-remoto-actualizar" &&
isset($_POST["hash_cliente"]) &&
isset($_POST["opt_acc"]) &&
isset($_POST["actualizar"]) &&
$_POST["actualizar"] == true){

$opcion = $_POST["opt_acc"];

if ($opcion == 2) {
$est_trab = "call";
}else if ($opcion == 3) {
$est_trab = "pago";
}else if ($opcion == 4) {
$est_trab = "aceptada";
}else if ($opcion == 5) {
$est_trab = "rechazada";
}else{
echo 4;
exit;
}





if($this->soporteModel->verificar_cliente($_POST["hash_cliente"], 1)){

if ($this->soporteModel->actualizar_info_trab(array($_POST["hash_cliente"], $est_trab))) {
echo 1;
exit;
}else{
echo 3;
}

}else{
echo 2;
}







//------------------------------------------------------
}else{

$array = array (
"item-bar"=>$nombre_funcion,
"datos"=>$this->db["datos"],
"sitio"=>$this->db["sitio"]);
$this->vistas->obtener_vista($this, "inicio", $array);
}
}












public function apps($parametros){
$nombre_funcion = __FUNCTION__;
$arrPARAM = explode(",", $parametros)[0];
//------------------------------------------------------



if ($arrPARAM == "add-apps" &&
@$_POST["nombre-app"] &&
@$_POST["tprod"] &&
@$_POST["url-app"] &&
@$_POST["version"] &&
@$_POST["securecode"] &&
@$_POST["view-video"] &&
@$_POST["cat-product"] &&
@$_POST["lang-product"] &&
@$_FILES["fotos-product"] &&
@$_POST["desc-min"] &&
@$_POST["desc-max"] &&
@$_POST["vista"]

) {

$hash_app = randalfa(1,50);

$array = array("png", "jfif", "jpeg", "pjp", "pjpeg", "jpg", "webp");


//---------- PROTECCION DE ARCHIVO -------------------
for($i=0; $i<count($_FILES['fotos-product']['name']); $i++){
$tipo_file = $_FILES['fotos-product']['type'][$i];
if (verificar_coincidencias($tipo_file, $array)==1){
}else{
echo 3;
exit;
}
}
//------------------------------------------





// ------- OBTENER CHECK DE CATEGORIAS ---------------------
$array = array();
foreach ($_POST['cat-product'] as $valor) {
$array["categoria"][] = $valor;
}
$json_categorias = json_encode($array);
//------------------------------------------


// ------- OBTENER CHECK DE LENGUAJES ---------------------
$array = array();
foreach ($_POST['lang-product'] as $valor) {
$array["lenguajes"][] = $valor;
}
$json_lenguajes = json_encode($array);
//------------------------------------------




// ------- VERIFICAR SI HAY VIDEO ---------------------
if ($_POST["view-video"]  == 1) {
$url_video = $_POST["url-video"];
}else{
$url_video = "N/A";
}
//------------------------------------------

$array = array($hash_app, $_POST['nombre-app'],  url_amigable($_POST['nombre-app']), $_POST["version"], $_POST['url-app'], $_POST['tprod'],  $_POST['securecode'],$_POST['view-video'], $url_video, $json_categorias, $json_lenguajes, $_POST['desc-min'], $_POST['desc-max'], $_POST["vista"]);
if($this->soporteModel->agregar_info_apps($array) == 1){
$ide_app = $this->soporteModel->extraer_info_app($hash_app,1, 2)["Id"];




if ($_POST["tprod"]  == 1) {
if(!$this->soporteModel->agregar_url_epayco(array($ide_app, $_POST["url-epayco"], $_POST["precio"]))==1){
echo "Error al agregar url EPAYCO !";
}
}





//------------ CARGAR FOTOS ----------------

if (count($_FILES['fotos-product']['name'])>0) {
for($i=0; $i<count($_FILES['fotos-product']['name']); $i++){

$carpeta = "apps_files";
$extencion = extraer_extencion($_FILES['fotos-product']['name'][$i]);
$hash_secure = randalfa(1,100).".".$extencion;
$ruta = $carpeta."/".$hash_secure;

if(move_uploaded_file($_FILES['fotos-product']['tmp_name'][$i], $ruta)) {
if(!$this->soporteModel->agregar_fotos_apps(array($ide_app, $ruta))==1){
echo "Error al agregar las fotos !";
}
} else{
echo 2;
}
}
}
echo 1;
//------------------------------------------
}else{
echo $this->soporteModel->agregar_info_apps($array);
}




}else if ($arrPARAM == "extraer-allapps" &&
$_POST["extraer"] &&
$_POST["extraer"] == true
){


if ($this->soporteModel->extraer_infoall_app($_POST["searchwork"], 1)>0) {
$sentencia = $this->soporteModel->extraer_infoall_app($_POST["searchwork"], 2);

while ($ext_info = $sentencia->fetch()) {
echo '
<tr>
<td class="text-center">'.$ext_info["Id"].'</td>
<td>'.$ext_info["nombre_app"].'</td>
<td>'.$ext_info["version_app"].'</td>';



//---------------------------------------------------------

if($ext_info["tipo_product"] == 1){
echo '<td><span class="badge badge-pill venta mr-1" style="background-color:#515eff;color:white"><i class="far fa-badge-dollar"></i> Pago</span></td>';
}else{
echo '<td><span class="badge badge-pill gratis mr-1" style="background-color:#1c8847;color:white"><i class="far fa-users"></i> Gratis</span></td>';
}

//---------------------------------------------------------

if($ext_info["secure_code"] == 1){
echo '<td><span class="badge badge-pill" style="background: #353535;color: white;"><i class="far fa-shield"></i> Codigo Protegido</span></td>';
}else{
echo '<td><span class="badge badge-pill" style="background:#b24100;color: white;"><i class="far fa-shield"></i> Codigo Libre</span></td>';
}

//---------------------------------------------------------
if($ext_info["view_video"] == 1){
echo '<td><a rel="noopener noreferrer"  href="'.$ext_info["url_video"].'" target="_blank">Ver Ahora</a>';
}else{
echo '<td class="text-muted">No Video <i class="fa fa-camera-movie"></i></td>';
}

//---------------------------------------------------------




echo '
<td>'.$ext_info["hora"].'</td>
<td>'.$ext_info["fecha"].'</td>

<td class="td-actions text-center btn-accion-app" ide="'.$ext_info["Id"].'">
<button type="button" btn="1" rel="tooltip" class="btn btn-success btn-round btn-icon btn-sm">
<i class="tim-icons icon-pencil"></i>
</button>
<button type="button" btn="2" rel="tooltip" class="btn btn-danger btn-round btn-icon btn-sm">
<i class="tim-icons icon-simple-remove"></i>
</button>
</td>
</tr>';

}


}else{
echo '<tr>
<td class="pl-3" colspan="9"><i class="far fa-search"></i> No se encontraron APPS.</td></tr>';
}

//------------------------------------------------------

}else if($arrPARAM == "eliminar-app" &&
isset($_POST["ide_app"]) &&
isset($_POST["eliminar"]) &&
$_POST["eliminar"] == true){



//---------- ELIMINAR FOTO ----------------
if($this->soporteModel->extraer_info_app($_POST["ide_app"], 1, 1)>0){
$sql_fotos = $this->soporteModel->extraer_fotos_apps($_POST["ide_app"], 2);
while($ext_url = $sql_fotos->fetch()){
eliminar_archivo($ext_url["url_foto"]);
}
//--------------------------------------------


echo $this->soporteModel->eliminar_app($_POST["ide_app"]);

}else{
echo 2;
}


}else{
$array = array (
"item-bar"=>$nombre_funcion,
"datos"=>$this->db["datos"],
"sitio"=>$this->db["sitio"]);
$this->vistas->obtener_vista($this, "inicio", $array);
}
}










public function cerrarsesion(){
if($this->accountModel->destruir_sesion()["bool"]){
header("Location:../inicio");
}else{
echo "UPS, error critico NO se ha podido cerrar tu cuenta.";
}

}



}
?>
