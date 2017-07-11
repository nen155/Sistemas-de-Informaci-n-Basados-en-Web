<?php
class Regimen{
	private $id;
	private $nombre;
	private $precio;
	
	function __construct($id=null,$nombre=null, $precio=null){
		$this->id=$id;
		$this->nombre=$nombre;
		$this->precio=$precio;
	}
	
	function setId($id){
		$this->id=$id;
	}
	
	function getId(){
		return $this->id;
	}
	function setNombre($nombre){
		$this->nombre=$nombre;
	}
	
	function getNombre(){
		return $this->nombre;
	}
	
	function setPrecio($precio){
		$this->precio=$precio;
	}
	
	function getPrecio(){
		return $this->precio;
	}
}
?>