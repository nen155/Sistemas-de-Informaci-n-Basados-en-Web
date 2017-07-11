<?php
class Precios{
	private $bd;
	
	function __construct($bd){
		$this->bd=$bd;
	}
	
	function getPrecios(){
		$this->bd->setConsulta("select * from precio");
		$precios = array();
		$i=0;
		while ($fila = $this->bd->getFila()){
			$precios[$i] = new Precio($fila[0], $fila[1], $fila[2]);
			$i++;
		}
		return $precios;
	}
	
	function addPrecio($precio){
		$this->bd->setConsulta("insert into precio values ($precio->getFechaInicio(), $precio->getFechaFin(), $precio->getPorcentaje(), $precio->getIdTipo()) ");
	}
}
?>