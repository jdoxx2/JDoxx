<?php


class Login extends Class_controles {

public function __construct(){
parent::__construct();

//------ VERIFICAR SESION ----------
$this->seguridad_app(get_class($this));
if ($this->db["bool"]) {
echo '<script>location.href="'.BASE_URL.'"; </script>';
}
//----------------------------------
}



public function login(){
$nombre_funcion = __FUNCTION__;
$this->vistas->obtener_vista($this, "login",$this->db);
}















public function checkpoint(){
if (
isset($_POST["usuario"]) &&
isset($_POST["clave"])
) {
$usuario = $_POST["usuario"];
$clave = $_POST["clave"];

if ($this->loginModel->verificar_cuenta($usuario, $clave, 1)>0) {
$_SESSION["sav-user"]=$usuario;
$_SESSION["sav-pass"]=$clave;
$this->accountModel->manejar_activo(true);
echo 1;
}else{
echo 2;
}
}else{
require_once("Controles/Error.php");
}
}













public function registrarCuenta(){
if (
isset($_POST["nombres"]) &&
isset($_POST["apellidos"]) &&
isset($_POST["correo"]) &&
isset($_POST["fnac"]) &&
isset($_POST["genero"]) &&
isset($_POST["usuario"]) &&
isset($_POST["clave"])

) {
$array =
array(
$_POST["nombres"],
$_POST["apellidos"],
$_POST["correo"],
$_POST["fnac"],
$_POST["genero"],
$_POST["usuario"],
$_POST["clave"]);

$mod = $this->accountModel;


if ($mod->verificar_info_cuentas($array[2],"correo",1)>0) {
echo 1;
}else if ($mod->verificar_info_cuentas($array[5],"usuario",1)>0) {
echo 2;
}else {

echo $this->loginModel->guardarCuenta($array)==1 ?  4 : "Error al crear Cuenta !";
}
}else{
require_once("Controles/Error.php");
}
}



















public function resetCuenta(){
if(!isset($_POST["accion"])){
exit;
}


//-----------------------------------------------------------------------------------
if (isset($_POST["correo"]) && $_POST["accion"] == 1 ) {
$acc = $this->accountModel;
$correo = $_POST["correo"];




if ($acc->verificar_info_cuentas($correo, "correo", 1)>0) {

$this->loginModel->eliminar_resetpass($correo);
$this->loginModel->resetCuenta($correo);
//---------------------------------
$extraer = $this->loginModel->verificar_resetpass($correo, 2, 1);
$codigo = $extraer["codigo"];
$token = $extraer["token"];


$nombre_cliente = $this->accountModel->verificar_info_cuentas($correo, "correo",2);
//------------------------------------------
//------------- ENVIO DE CORREO ------------
//------------------------------------------
if ($this->conf_email == 1) {
$Funcorreo = $this->confSet_Email;
//----------------------------------------
$bodyHTML = $Funcorreo->plantilla(array("plant_email"=>1,"codigo_reset"=>$codigo, "nombre_cliente"=> $nombre_cliente["nombres"]." ".$nombre_cliente["apellidos"]));
//----------------------------------------
$Funcorreo->enviarCorreo(utf8_decode("Restablecimiento de Contraseña"), "Test J|Doxx", $correo, "Codigo de Seguridad", $bodyHTML);
}
//----------------------------------------





echo json_encode(array("opcion"=>1, "token"=>$token));
}else{
echo json_encode(array("opcion"=>3));
}


//-----------------------------------------------------------------------------------

}else if (isset($_POST["token"]) && isset($_POST["correo"]) && isset($_POST["code"]) && $_POST["accion"] == 2) {
$token = $_POST["token"];
$correo = $_POST["correo"];
$codigo = $_POST["code"];

$array = array($token, $correo, $codigo);

if($this->loginModel->verificar_resetpass($array, 1, 2)>0){
echo json_encode(array("opcion"=>4, "token"=>$token));
}else{
echo json_encode(array("opcion"=>5));
}

//-----------------------------------------------------------------------------------

}else if (isset($_POST["token"]) && isset($_POST["correo"]) && isset($_POST["code"]) && isset($_POST["clave"]) && $_POST["accion"] == 3) {
$clave = $_POST["clave"];
$token = $_POST["token"];
$correo = $_POST["correo"];
$codigo = $_POST["code"];

$array = array($token, $correo, $codigo);

if($this->loginModel->verificar_resetpass($array, 1, 2)>0){
echo json_encode(array("opcion"=>$this->loginModel->cambiar_clavecuenta($correo, $clave)));
}else{
$this->loginModel->eliminar_resetpass($correo);
echo json_encode(array("opcion"=>2));
}


//-----------------------------------------------------------------------------------
}else if (isset($_POST["token"]) && isset($_POST["correo"]) && $_POST["accion"] == 4) {
$token = $_POST["token"];
$correo = $_POST["correo"];
$array = array($token, $correo);

if($this->loginModel->verificar_resetpass($array, 1, 3)>0){
$fecha_entrada = $this->loginModel->verificar_resetpass($correo, 2, 1)["vencimiento"];

$fechaInicial = date("Y-m-d H:i:s");
$fechaFinal =$fecha_entrada;
$str_inicial = strtotime($fechaInicial);
$str_final = strtotime($fechaFinal);

if($str_inicial > $str_final){
$this->loginModel->eliminar_resetpass($correo);
echo codificar_json(array("opcion"=>2));
}else{
$seg = $str_final - $str_inicial;
$d = floor($seg / 86400);
$h = floor(($seg - ($d * 86400)) / 3600);
$m = floor(($seg - ($d * 86400) - ($h * 3600)) / 60);
$s = $seg % 60;

if($d < 10){
$dias = "0".$d;
}else{
$dias = $d;
}
//----------------------------
if($h < 10){
$horas = "0".$h;
}else{
$horas = $h;
}
//----------------------------
if($m < 10){
$minutos = "0".$m;
}else{
$minutos = $m;
}
//----------------------------
if($s < 10){
$segundos = "0".$s;
}else{
$segundos = $s;
}
echo codificar_json(array("opcion"=>1, "time"=>$minutos.":".$segundos));
}

//-----------------------------------------------------------------------------------

}else{
$this->loginModel->eliminar_resetpass($correo);
echo codificar_json(array("opcion"=>3));
}
}

}













}
?>
