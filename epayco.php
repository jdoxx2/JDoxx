<?php
class epayco extends Class_controles {
private $sesion;


public function __construct(){
parent::__construct();
$this->seguridad_app(get_class($this));
}

public function epayco(){
echo "Error de peticion, verifique sus datos e intente de nuevo.";

}


public function api($parametros){
$nombre_funcion = __FUNCTION__;
$arrPARAM = explode(",", $parametros)[0];
$ext_info_app = $this->db["sitio"];


if ($arrPARAM == "token" && @$_POST["extraer"]) {


$url_api = "https://apify.epayco.co";
//-------- INFO AUTHORIZATION ----------
$username = "9536e72f4cce86a43984e92168ab7887";
$clave = "f3278b85b049b575935cea880410f699";
//--------------------------------------
$AUTH = base64_encode($username.":".$clave);

$curl = curl_init();
curl_setopt_array($curl, array(
CURLOPT_URL => $url_api.'/login',
CURLOPT_RETURNTRANSFER => true,
CURLOPT_ENCODING => '',
CURLOPT_MAXREDIRS => 10,
CURLOPT_TIMEOUT => 0,
CURLOPT_FOLLOWLOCATION => true,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_CUSTOMREQUEST => 'POST',
CURLOPT_HTTPHEADER => array(
'Content-Type: application/json',
'Authorization: Basic '.$AUTH
),
));
//--------------------------------------
$obtener_token = curl_exec($curl);
curl_close($curl);

if($this->soporteModel->actualizar_epayco(array(json_decode($obtener_token, true)["token"]))>0){
echo $obtener_token;
}else{
echo "Error en JSON -> ".$obtener_token;
}


//--------------------------------------
}else if ($arrPARAM == "confirmacion") {
$this->vistas->obtener_vista($this, "confirmacion", $this->db);

//--------------------------------------
}else if ($arrPARAM == "respuesta") {
$this->vistas->obtener_vista($this, "respuesta", $this->db);

//--------------------------------------
}else if ($arrPARAM == "pagar") {
$this->vistas->obtener_vista($this, "pagar", $this->db);
}else{
echo "Error de API por favor verifique los datos que envia.";
}
}

}


?>