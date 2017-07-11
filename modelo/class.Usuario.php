<?php
class Usuario{
	private $nombre;
	private $password;
	
	function __construct($nombre=null, $password=null){
		$this->nombre=$nombre;
		$this->password=$password;
	}
	
	function setNombre($nombre){
		$this->nombre=$nombre;
	}
	
	function getNombre(){
		return $this->nombre;
	}
	
	function setPassword($password){
		$this->password=$password;
	}
	
	function getPassword(){
		return $this->password;
	}
}
?>