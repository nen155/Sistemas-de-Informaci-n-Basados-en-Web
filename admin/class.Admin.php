<?php
	class Admin {
		private $logeado;
		private $tipos;
		private $precios;
		private $bd;
		private $sesion;
		private $regimenes;
		private $reservas;
		private $tipos;
		private $regimenes;
		private $habitaciones;
		private $precios;
		private $vistaAddHabitaciones;
		private $vistaAddPrecios;
		private $vistaAddRegimenes;
		private $vistaAddTipos;
		private $vistaAddHabitaciones;
		private $vistaGestionReservas;
		
		function __construct($bd){
			$this->bd=$bd;
			$this->logeado=false;
		}
		
		function login($user, $pass){
			if($this->logeado==false){
				$this->bd->setConsulta("select u.nombre from usuario where u.nombre=$user");
				$filas = $this->bd->getFilas();
				$nombre = $filas[0];
				if($nombre!=null){
					$this->bd->setConsulta("select u.pass from usuario where nombre=$user");
					$filas = $this->bd->getFilas();
					$passbd = $filas[0];
					if($pass==$passbd){
						$usuario = new Usuario($user,$pass);
						$sesion->set("usuario",$usuario);
					}
				}
				$this->logeado=true;
			}
		}
		
		function modificarCheckInReserva($id_reserva,$checkIn){
			$this->bd->setConsulta("update reserva set checkin=$checkIn where id_reserva=$id_reserva");
		}
		
		function modificarCheckOutReserva($id_reserva,$checkOut){
			$this->bd->setConsulta("update reserva set checkout=$checkOut where id_reserva=$id_reserva");
		}
		
		function modificarNumPersonas($id_reserva,$numPersonas){
			$this->bd->setConsulta("update reserva set numPersonas=$numPersonas where id_reserva=$id_reserva");
		}
		
		function modificarRegimenReserva($id_reserva,$id_linea,$id_regimen){
			$this->bd->setConsulta("update lineareserva set id_regimen=$id_regimen where id_reserva=$id_reserva and id=$id_linea");
		}
		
		function modificarTipoHabitacionReserva($id_reserva,$id_linea,$id_tipoHab){
			$this->bd->setConsulta("update lineareserva set id_tipo=$id_tipoHab where id_reserva=$id_reserva and id=$id_linea");
		}
		
		function verReservas(){
			$this->vistaGestionReservas->verReservas($this->reservas->getReservasBD());
		}
		
		function CancelarReserva($id_reserva){
			$this->reservas->setCancelada($id_reserva, true);
		}
		
		function addNumReserva($id_reserva, $numHab){
			$this->bd->setConsulta("update habitacion set numero=$numHab where (select h.numero from habitacion h inner join lineareserva l inner join tipo t inner join habitacion h where id_reserva=$id_reserva)");
		}
		
		function addTipo($nombre,$desc,$numPers,$numHab,$precio){
			
			$this->bd->setConsulta("insert into tipo values($nombre,$desc,$numPers,$numHab,$precio)");
		}
		
		function verTipos(){
			$this->$vistaAddTipos->verTipos($this->tipos->getTipos());
		}
		
		function removeTipo($id_tipo){
			$this->bd->setConsulta("delete from tipo where id_tipo=$id_tipo");
		}
		
		function addRegimen($nombre,$precio){
			$this->bd->setConsulta("insert into regimen values($nombre,$precio)");
		}
		
		function verRegimenes(){
			$this->$vistaAddRegimen->verRegimenes($this->regimenes->getRegimenes());
		}
		
		function removeRegimen($id_regimen){
			$this->bd->setConsulta("delete from regimen where id_regimen=$id_regimen");
		}
		
		function addHabitacion($numhabitacion){
			$this->bd->setConsulta("insert into habitacion values($numhabitacion)");
		}
		
		function verHabitaciones(){
			$this->$vistaAddHabitaciones->verHabitaciones($this->habitaciones->getHabitaciones());
		}
		
		function removeHabitacion($id_habitacion){
			$this->bd->setConsulta("delete from habitacion where id_habitacion=$id_habitacion");
		}
		
		function addPrecio($fechaIni,$fechaFin,$porcentaje){
			$this->bd->setConsulta("insert into precio values($fechaIni,$fechaFin,$porcentaje)");
		}
		
		function verPrecios(){
			$this->$vistaAddPrecios->verPrecios($this->precios->getPrecios());
		}
		
		function removePrecio($id_precio){
			$this->bd->setConsulta("delete from precio where id_precio=$id_precio");
		}
	}
?>