<?php
/**
 *
 */
class Errors extends Class_controles {

public function __construct(){
parent::__construct();
}



public function MostrarError(){
$this->vistas->obtener_vista($this, "error");
}
}


$notFound = new Errors();
$notFound->MostrarError();



?>