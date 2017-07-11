<?php
class Precio{
	private $fechaInicio;
	private $fechaFin;
	private $porcentaje;
	private $id_tipo;
	
	function __construct($tfechaInicioipo=null, $fechaFin=null, $porcentaje=null, $id_tipo=null){
		$this->fechaInicio=$fechaInicio;
		$this->fechaFin=$fechaFin;
		$this->porcentaje=$porcentaje;
	}
	
	function setFechaInicio($fechaInicio){
		$this->fechaInicio=$fechaInicio;
	}
	
	function getFechaInicio(){
		return $this->fechaInicio;
	}
	
	function setFechaFin($fechaFin){
		$this->fechaFin=$fechaFin;
	}
	
	function getFechaFin(){
		return $this->fechaFin;
	}
	
	function setPorcentaje($porcentaje){
		$this->porcentaje=$porcentaje;
	}
	
	function getPorcentaje(){
		return $this->porcentaje;
	}
	
	function setIdTipo($id_tipo){
		$this->id_tipo=$id_tipo;
	}
	
	function getIdTipo(){
		return $this->id_tipo;
	}
}
?>