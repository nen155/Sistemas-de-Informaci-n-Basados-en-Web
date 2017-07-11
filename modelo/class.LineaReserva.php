<?php
class LineaReserva{
	private $tipo;
	private $regimen;
	
	function __construct($tipo=null, $regimen=null){
		$this->tipo=$tipo;
		$this->regimen=$regimen;
	}
	
	function setTipo($tipo){
		$this->tipo=$tipo;
	}
	
	function getTipo(){
		return $this->tipo;
	}
	
	function setRegimen($regimen){
		$this->regimen=$regimen;
	}
	
	function getRegimen(){
		return $this->regimen;
	}
}
?>