<?php

class DatosJSON {
	private $datos;
	private $resultado;
	private $archivo;
	 //constructor se le pasa la base de datos
    function __construct($bd) {
        $this->archivo = $bd;
    }
	function getJson(){
		$this->resultado = file_get_contents($this->archivo);
		return $this->resultado;
	}
    function getArray(){
		$this->resultado = file_get_contents($this->archivo);
		$this->datos = json_decode($this->resultado, true);
		return $this->datos;
	}
}

?>