<?php
class Reserva{
	private $checkIn;
	private $checkOut;
	private $observaciones;
	private $cancelada;
	private $numPersonas;
	private $cliente;
	private $lineasReserva;
	private $numNinos;
	
	function __construct($checkIn=null, $checkOut=null, $observaciones=null, $cancelada=null, $numPersonas=null, $cliente=null, $lineasReserva=null,$numNinos=null){
		$this->checkIn = $checkIn;
		$this->checkOut = $checkOut;
		$this->observaciones = $observaciones;
		$this->cancelada = $cancelada;
		$this->numPersonas = $numPersonas;
		$this->cliente = $cliente;
		$this->lineasReserva = $lineasReserva;
		$this->numNinos = $numNinos;
	}
	function setNumNinos($numNinos){
		$this->numNinos = $numNinos;
	}
	function getNumNinos(){
		return $this->numNinos;
	}
	function setCheckIn($checkIn){
		$this->checkIn = $checkIn;
	}
	
	function getCheckIn(){
		return $this->checkIn;
	}
	
	function setCheckOut($checkOut){
		$this->checkOut = $checkOut;
	}
	
	function getCheckOut(){
		return $this->checkOut;
	}
	
	function setObservaciones($observaciones){
		$this->observaciones = $observaciones;
	}
	
	function getObservaciones(){
		return $this->observaciones;
	}
	
	function setCancelada($cancelada){
		$this->cancelada = $cancelada;
	}
	
	function getCancelada(){
		return $this->cancelada;
	}

	function setNumPersonas($numPersonas){
		$this->numPersonas = $numPersonas;
	}
	
	function getNumPersonas(){
		return $this->numPersonas;
	}
	
	function setCliente($cliente){
		$this->cliente = $cliente;
	}
	
	function getCliente(){
		return $this->cliente;
	}
	
	function setLineasReserva($lineasReserva){
		$this->lineasReserva = $lineasReserva;
	}
	
	function getLineasReserva(){
		return $this->lineasReserva;
	}
}
?>