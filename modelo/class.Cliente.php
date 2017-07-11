<?php
class Cliente{
	private $nombre;
	private $apellidos;
	private $email;
	private $telefono;
	private $direccion;
	private $ciudad;
	private $pais;
	private $dniPasaporte;
	private $codigoPostal;
	
	function __construct($nombre=null, $apellidos=null,$email=null, $telefono=null, $direccion=null, $ciudad=null, $pais=null, $dniPasaporte=null, $codigoPostal=null){
		$this->nombre=$nombre;
		$this->apellidos=$apellidos;
		$this->email=$email;
		$this->telefono=$telefono;
		$this->direccion=$direccion;
		$this->ciudad=$ciudad;
		$this->pais=$pais;
		$this->dniPasaporte=$dniPasaporte;
		$this->codigoPostal=$codigoPostal;
	}
	
	function setNombre($nombre){
		$this->nombre=$nombre;
	}
	
	function getNombre(){
		return $this->nombre;
	}
	
	function setApellidos($apellidos){
		$this->apellidos=$apellidos;
	}
	
	function getApellidos(){
		return $this->apellidos;
	}
	
	function setEmail($email){
		$this->email=$email;
	}
	
	function getEmail(){
		return $this->email;
	}
	
	function setTelefono($telefono){
		$this->telefono=$telefono;
	}
	
	function getTelefono(){
		return $this->telefono;
	}
	
	function setDireccion($direccion){
		$this->direccion=$direccion;
	}
	
	function getDireccion(){
		return $this->direccion;
	}
	
	function setCiudad($ciudad){
		$this->ciudad=$ciudad;
	}
	
	function getCiudad(){
		return $this->ciudad;
	}
	
	function setPais($pais){
		$this->pais=$pais;
	}
	
	function getPais(){
		return $this->pais;
	}
	
	function setDniPasaporte($dniPasaporte){
		$this->dniPasaporte=$dniPasaporte;
	}
	
	function getDniPasaporte(){
		return $this->dniPasaporte;
	}
	
	function setCodigoPostal($codigoPostal){
		$this->codigoPostal=$codigoPostal;
	}
	
	function getCodigoPostal(){
		return $this->codigoPostal;
	}
}
?>