<?php
class Tipos{
	private $bd;
	
	function __construct($bd){
		$this->bd=$bd;
	}
	
	function getTipos(){
		$this->bd->setConsulta("select * from tipo");
		$tipos = array();
		$i=0;
		while ($fila = $this->bd->getFila()){
			$tipos[$i] = new Tipo($fila[0], $fila[1], $fila[2], $fila[3], $fila[4], $fila[5], $fila[6]);
			$i++;
		}
		return $tipos;
	}
	
	function addTipo($tipo){
		$this->bd->setConsulta("insert into tipo values ($tipo->getNombre(), $tipo->getDescripcion(), $tipo->getNumPersonas(), $tipo->getNumTotalHab(), $tipo->getPrecio()) ");
	}
}
?>