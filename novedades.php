<?php

class novedades extends Class_controles {

public function __construct(){
parent::__construct();

//------ VERIFICAR SESION ----------
$this->seguridad_app(get_class($this));
if (!$this->db["bool"]) {
echo '<script>location.href="'.BASE_URL.'"; </script>';
}
//----------------------------------

}



public function novedades(){
$nombre_funcion = __FUNCTION__;
$array = array ("ver-contenido"=>"",   $this->db["datos"]);
$this->vistas->obtener_vista($this, "inicio-novedades", $array);
}




public function contenido($parametros){
$arrPARAM = explode(",", $parametros)[0];
$nombre_funcion = __FUNCTION__;

$this->vistas->obtener_vista($this, "detalle-novedades", $array);

exit;
if ($arrPARAM) {
$array = array ("ver-contenido"=>$arrPARAM, $this->db["datos"]);
$this->vistas->obtener_vista($this, "inicio-novedades", $array);
}else{
require_once("Controles/Error.php");
}
}






public function webSocket($parametros){
$arrPARAM = explode(",", $parametros)[0];




$curl = curl_init();
$post_fields = [
  "key" => "5NBKjo6U1XxAnUcn2Euaygu99VE04bivxGZdJeh1",
  "secret" => "jQYbG7dgWfHAGn6RHLMrJvkjHxJTOvt4",
  "channelId" => $channel,
  "message" => $message
];
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://free3.piesocket.com/api/publish",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode($post_fields),
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json"
  ),
));

$response = curl_exec($curl);
return $response;
}






}