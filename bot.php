<?php

class bot extends Class_controles {

public function __construct(){
parent::__construct();

}



public function bot($parametros){
echo "Estructura de la peticion NO es Valida.";
}


public function conectarBot($parametros){
$nombre_funcion = __FUNCTION__;
$utilidad = new utilidad();
$arrPARAM = explode(",", $parametros);

if ($arrPARAM && isset($_POST["mensaje"])) {

$obtener_msj = trim($_POST["mensaje"]);

//------------ MODO ADMIN-----------------
if(isset($_SESSION["sesion-adm"]) || $obtener_msj == "admin"){

$getARR = $this->botModel->menu_adm( $obtener_msj );
$java = $getARR["java"];
$mensaje = $utilidad->bot_msj(1,$getARR["mensaje"]);
}else{
//---------------------------------------------------
$java=0;
$mensaje = $utilidad->bot_msj();
}

$array = array(
    "mensaje"=>$mensaje,
    "java" =>$java);
    echo codificar_json($array);

//----------- REDIRECCION A INICIO ------------------
}else{
$array = array(
"mensaje"=>$utilidad->bot_msj(0,"bebe"),
"java" =>0);
echo codificar_json($array);
}
}

















}

