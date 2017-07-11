<?php
	function __autoload($class){
		if(file_exists('../modelo/class.'.$class.'.php'))
			include_once '../modelo/class.'.$class.'.php';
		if(file_exists('../dao/class.'.$class.'.php'))
			include_once '../dao/class.'.$class.'.php';
	}
	$bd = new BaseDatos();
	$bd->setConexion(Constantes::$servidor, Constantes::$usuario, Constantes::$clave,Constantes::$basedatos);
	$ninos = $_POST["ninos"];
	$adultos = $_POST["adultos"];
	$checkin = $_POST["checkin"];
	$checkout = $_POST["checkout"];
	$reserva = new Reserva();
	$reserva->setCheckin($checkin);
	$reserva->setCheckout($checkout);
	$reserva->setNumPersonas($adultos);
	$reserva->setNumNinos($ninos);
	$reservas = new Reservas($bd);
	$resultado=	$reservas->comprobarReserva($reserva);
	echo $resultado;
	$bd->closeConexion();
?>