<?php


class Inicio extends Class_controles {
private $sesion;


public function __construct(){
parent::__construct();
$this->seguridad_app(get_class($this));
}


public function inicio(){
$this->vistas->obtener_vista($this, "inicio", $this->db);
}



public function saveWork($parametros){
$nombre_funcion = __FUNCTION__;
$utilidad = new utilidad();
$arrPARAM = explode(",", $parametros);


if (
isset($_POST["nombres"]) &&
isset($_POST["apellidos"]) &&
isset($_POST["correo"]) &&
isset($_POST["tel"]) &&
isset($_POST["org-emp"]) &&
isset($_POST["desc"]) &&
isset($_POST["lat"]) &&
isset($_POST["long"])) {


//---------- INCLUIR API GEOCODER -----------
include('Librerias/geocoder/AbstractGeocoder.php');
include('Librerias/geocoder/Geocoder.php');
//-----------------------------------------



if ($_POST["lat"] && $_POST["long"]){
$query = $_POST["lat"].",".$_POST["long"];
$key = getenv('OPENCAGE_API_KEY');
$geocoder = new OpenCage\Geocoder\Geocoder($key);
$result = $geocoder->geocode($query);
$json_resp = $result["results"][0]["components"];

$json_coord = str_replace('"}', '", "lat":"'.$_POST["lat"].'", "long":"'.$_POST["long"].'"}' , codificar_json($json_resp));


}else{
$json_coord = codificar_json(array("lat" => 0, "long"=> 0, "road"=>"N/A", "continent"=>"N/A", "country"=>"N/A", "state"=>"N/A", "town"=>"N/A"));
}



//-----------------------------------------
$array = array(
$_POST["nombres"],
$_POST["apellidos"],
$_POST["correo"],
$_POST["tel"],
$_POST["org-emp"],
$_POST["desc"], $json_coord);

if($this->db["sitio"]["estado_trab"] == 1){
//-----------------------------------------
if ($this->sitioModel->guardar_solicitud($array) == 1) {



//------------------------------------------
//------------- ENVIO DE CORREO ------------
//------------------------------------------
if ($this->conf_email == 1) {
//----------------------------------------
$Funcorreo = $this->confSet_Email;
$bodyHTML = $Funcorreo->plantilla(array(
"nombre_app" =>  $this->db["sitio"]["nombre_app"],
"plant_email"=>4,
"nombre_cliente"=>$_POST["nombres"]." ".$_POST["apellidos"]));
//----------------------------------------
$Funcorreo->enviarCorreo("Estado de Solicitud", "Test J|Doxx", $_POST["correo"], "Creacion del Software.", $bodyHTML);
}
//----------------------------------------



echo 1;
}else if ($this->sitioModel->guardar_solicitud($array) == 2) {
echo 2;
}else{
echo $this->sitioModel->guardar_solicitud($array);
}
//----------------------------------------
}else{
echo 3;
}
}
}





public function test(){



//------------------------------------------
//------------- ENVIO DE CORREO ------------
//------------------------------------------
$Funcorreo = $this->confSet_Email;
$bodyHTML = $Funcorreo->plantilla(array(
"nombre_app" =>  $this->db["sitio"]["nombre_app"],
"plant_email"=>5,
"nombre_cliente"=>"Elizabeth Olsen"));
//----------------------------------------
$Funcorreo->enviarCorreo("#XRM534534 caso Cerrado", "Test J|Doxx", "josealfonzod@gmail.com", "Sesion Terminada.", $bodyHTML);



}





}
?>