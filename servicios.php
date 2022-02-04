<?php
class servicios extends Class_controles {
private $sesion;


public function __construct(){
parent::__construct();
$this->seguridad_app(get_class($this));
}


public function servicios(){
#$this->vistas->obtener_vista($this, "inicio", $this->db);

echo 4324234;
}


public function soporteTecnico($parametros){
$nombre_funcion = __FUNCTION__;
$arrPARAM = explode(",", $parametros)[0];

if ($arrPARAM == "st-info-remoto"){
$extraer_sitio = $this->db["sitio"];
$host = $extraer_sitio["host_socket"];
$token = $extraer_sitio["token_socket"];
$estado = $extraer_sitio["estado_trab"];
#--------------------------------------------------------
$array = array("estado" => $estado, "host"=>$host, "token"=> $token);
$json_data = base64_encode(json_encode($array));

echo $json_data;

}else if ($arrPARAM == "st-remoto" &&
@$_POST["ide_caso"] &&
@$_POST["nombres"] &&
@$_POST["apellidos"] &&
@$_POST["correo"] &&
@$_POST["tel"] &&
@$_POST["ide-con"] &&
@$_POST["clave-con"] &&
@$_POST["desc"] &&
@$_POST["ide_caso"] &&
@$_POST["hash_secure"]
) {


$array = array(
$_POST["nombres"],
$_POST["apellidos"],
$_POST["correo"],
$_POST["tel"],
$_POST["ide-con"],
$_POST["clave-con"],
$_POST["desc"],
$_POST["ide_caso"],
$_POST["hash_secure"]
);


if($this->db["sitio"]["estado_trab"] == 1){
if($this->soporteModel->agregar_info_sremoto($array) == 1){
//$_SESSION["ide-soporte-cliente"] = $_POST["ide_caso"];
//$_SESSION["nombre-soporte-cliente"] = $_POST["nombres"];
echo 1;
}else{
echo $this->soporteModel->agregar_info_sremoto($array);
}
}else{
echo 2;
}


//--------------------------------------------------------
}else if ($arrPARAM == "st-remoto-wsocket" &&
@$_POST["hash_cliente"] &&
@$_POST["acc"] &&
$_POST["acc"] == "eliminar"){


if($this->soporteModel->verificar_cliente($_POST["hash_cliente"], 1)){
$ext_info = $this->soporteModel->verificar_cliente($_POST["hash_cliente"],2);


//----------------------------------------
$ext_info_client = $ext_info;

if ($ext_info_client["estado"] == "rechazada" || $ext_info_client["estado"] == "call" || $ext_info_client["estado"] == "aceptada") {
echo "Error al eliminar trabajo, se detecto que este trabajo fue respondido por el administrador.";

}else{


if ($this->soporteModel->eliminar_cliente($_POST["hash_cliente"])) {
echo "\n--------------------------------------------------------------\n";
echo "Sesion destruida para [{$ext_info["nombres"]} {$ext_info["apellidos"]}] | IDE : {$ext_info["ide_caso"]}\n";
unset($_SESSION["ide-soporte-cliente"]);
unset($_SESSION["nombre-soporte-cliente"]);
exit;
}else{
echo "\n--------------------------------------------------------------\n";
echo "Error al eliminar la sesion !\n";
}


}
}else{
echo "\n--------------------------------------------------------------\n";
echo "Error al destruir sesion, el cliente NO envio ninguna solicitud !\n";
}



//--------------------------------------------------------
}else if ($arrPARAM == "st-wss-actualizar" && @$_POST["hash_secure"]  && @$_POST["url-wss"]  && @$_POST["est_trab"]) {

if ($this->db["sitio"]["hash"] == $_POST["hash_secure"]) {
if($this->soporteModel->actualizar_info_socket(array($_POST["url-wss"],0, $_POST["est_trab"], 2))>0){
echo 1;
}else{
echo 2;
}


}else{
echo 3;
}




}else{
$this->vistas->obtener_vista($this, "mis_servicios", $this->db);
}
}






}
?>