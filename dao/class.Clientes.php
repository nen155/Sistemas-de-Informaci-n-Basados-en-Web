<?php
class Clientes{
	private $bd;
	
	function __construct($bd){
		$this->bd=$bd;
	}
	
	function getClientes(){
		$this->bd->setConsulta("select * from cliente");
		$clientes = array();
		$i=0;
		while ($fila = $this->bd->getFila()){
			$clientes[$i] = new Tipo($fila[1], $fila[2],$fila[3], $fila[4], $fila[5], $fila[6], $fila[7], $fila[8], $fila[9]);
			$i++;
		}
		return $clientes;
	}
	
	function addCliente($cliente){
		$nombre=$cliente->getNombre();
		$apellidos=$cliente->getApellidos();
		$email=$cliente->getEmail();
		$pasaporte=$cliente->getDniPasaporte();
		$direccion=$cliente->getDireccion();
		$ciudad=$cliente->getCiudad();
		$codigoPostal=$cliente->getCodigoPostal();
		$pais=$cliente->getPais();
		$telefono=$cliente->getTelefono();
		
		$this->bd->setConsulta("insert into `cliente` (`id`, `nombre`, `apellidos`, `telefono`, `direccion`, `ciudad`, `pais`, `dniPasaporte`, `codigoPostal`) values (NULL,".$nombre.",
		".$apellidos.",".$email.",".$telefono.",".$direccion.",".$ciudad.",".$pais.",".$pasaporte.",".$codigoPostal.") ");
	}
}
?>