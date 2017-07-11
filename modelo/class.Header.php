<?php
class Header{
	private $titulo;
	private $descripcion;
	private $keywords;
	private $index_title;
	private $mis_reservas;
	private $variablesFormReserva;
	
	function __construct($titulo=null, $descripcion=null, $keywords=null, $index_title=null, $mis_reservas=null,$variablesFormReserva=null){
		$this->titulo = $titulo;
        $this->descripcion = $descripcion;
        $this->keywords = $keywords;
		$this->index_title = $index_title;
		$this->mis_reservas = $mis_reservas;
		$this->variablesFormReserva=$variablesFormReserva;
	}
	public function getTitulo(){
		return $this->titulo;
	}
	public function getDescripcion(){
		return $this->descripcion;
	}
	public function getKeywords(){
		return $this->keywords;
	}
	public function getIndexTitle(){
		return $this->index_title;
	}
	public function getMisReservas(){
		return $this->mis_reservas;
	}
	public function getVariablesFormReserva(){
		return $this->variablesFormReserva;
	}
}
?>