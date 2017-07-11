<?php
class Regimenes{
	private $bd;
	
	function __construct($bd){
		$this->bd=$bd;
	}
	
	function getRegimenes(){
		$this->bd->setConsulta("select id,nombre,precio from regimen");
		$regimenes = array();
		$i=0;
		while ($fila = $this->bd->getFila()){
			$regimenes[$i] = new Regimen($fila[0], $fila[1],$fila[2]);
			$i++;
		}
		return $regimenes;
	}
	
	function addRegimen($regimen){
		$this->bd->setConsulta("insert into regimen values ($regimen->getNombre(), $regimen->getPrecio()) ");
	}
}
?>