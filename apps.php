<?php
class apps extends Class_controles {
private $sesion;


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

public function apps(){
echo "Error de peticion, verifique sus datos e intente de nuevo.";
}





public function view($parametros){
$nombre_funcion = __FUNCTION__;
$arrPARAM = explode(",", $parametros)[0];
$ext_info_app = $this->db["sitio"];


if ($this->soporteModel->extraer_info_app($arrPARAM,2, 1)>0) {
$ext_info = $this->soporteModel->extraer_info_app($arrPARAM, 2, 2);

if ($ext_info["estado"] == 2) {
echo "Esta APP No esta disponible, vuelva mas Tarde.";
}else{

$array = array (
"datos-app"=>$ext_info,
"cuenta"=>$this->db);


$this->vistas->obtener_vista($this, "view_info",  $array );
}
}else{
require_once("Vistas/errors/error.php");
}
}





}
