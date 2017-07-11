<?php
function __autoload($class){
		if(file_exists('../../modelo/class.'.$class.'.php'))
			include_once '../../modelo/class.'.$class.'.php';
		if(file_exists('../../dao/class.'.$class.'.php'))
			include_once '../../dao/class.'.$class.'.php';
	}
	$dato=0;
	if(isset($_GET["dato"]))
		$dato=$_GET["dato"];
	$dato= strtoupper ($dato);
	$bd = new BaseDatos();
	$bd->setConexion(Constantes::$servidor, Constantes::$usuario, Constantes::$clave,Constantes::$basedatos);
	if($dato!=0){
		$bd->setConsulta("SELECT c.nombre,c.apellidos,c.dniPasaporte as dni,r.checkin,r.checkout,r.observaciones,r.cancelada,r.numPersonas FROM reserva as r INNER JOIN cliente as c ON r.id_cliente = c.id WHERE UPPER(c.apellidos) LIKE UPPER(CONCAT('%','".$dato."' , '%')) OR c.dniPasaporte LIKE CONCAT('%','".$dato."', '%') ");
	}
	else{
		$bd->setConsulta("SELECT c.nombre,c.apellidos,c.dniPasaporte as dni,r.checkin,r.checkout,r.observaciones,r.cancelada,r.numPersonas FROM reserva as r INNER JOIN cliente as c ON r.id_cliente = c.id");
	}
	$reservas=array();
	while($fila = $bd->getFila()){
		$reservas[]= $fila;
	}
	echo json_encode($reservas);
	$bd->closeConexion();	
?>