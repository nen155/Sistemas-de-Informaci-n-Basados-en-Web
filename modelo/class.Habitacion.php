<?php

class Habitacion {

    private $numero;

    //define el constructor
    function __construct($numero=null) {
        $this->numero = $numero;
    }
	
	function setNumero($numero){
		$this->numero=$numero;
	}
	
	function getNumero(){
		return $this->numero;
	}
}
?>