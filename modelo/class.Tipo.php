<?php
class Tipo{
	private $id;
	private $nombre;
	private $descripcion;
	private $numPersonas;
	private $numTotalHab;
	private $precio;
	private $habitaciones;
	private $precios;
	
	function __construct($nombre=null, $descripcion=null, $numPersonas=null, $numTotalHab=null, $precio=null, $habitaciones=null, $precios=null,$id=null){
		$this->id=$id;
		$this->nombre=$nombre;
		$this->descripcion=$descripcion;
		$this->numPersonas=$numPersonas;
		$this->numTotalHab=$numTotalHab;
		$this->precio=$precio;
		$this->habitaciones=$habitaciones;
		$this->precios=$precios;
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
	
	function setDescripcion($descripcion){
		$this->descripcion=$descripcion;
	}
	
	function getDescripcion(){
		return $this->descripcion;
	}
	
	function setNumPersonas($numPersonas){
		$this->numPersonas=$numPersonas;
	}
	
	function getNumPersonas(){
		return $this->numPersonas;
	}
	
	function setNumTotalHab($numTotalHab){
		$this->numTotalHab=$numTotalHab;
	}
	
	function getNumTotalHab(){
		return $this->numTotalHab;
	}
	
	function setPrecio($precio){
		$this->precio=$precio;
	}
	
	function getPrecio(){
		return $this->precio;
	}
	
	function setHabitaciones($habitaciones){
		$this->habitaciones=$habitaciones;
	}
	
	function getHabitaciones(){
		return $this->habitaciones;
	}
	
		function setPrecios($precios){
		$this->precios=$precios;
	}
	
	function getPrecios(){
		return $this->precios;
	}
}
?>