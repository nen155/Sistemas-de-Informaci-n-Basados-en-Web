<?php
function __autoload($class){
		if(file_exists('../../modelo/class.'.$class.'.php'))
			include_once '../../modelo/class.'.$class.'.php';
		if(file_exists('../../dao/class.'.$class.'.php'))
			include_once '../../dao/class.'.$class.'.php';
	}
	$bd = new BaseDatos();
	$bd->setConexion(Constantes::$servidor, Constantes::$usuario, Constantes::$clave,Constantes::$basedatos);

	$bd->setConsulta("select h.id, h.numero, t.nombre as tipo from habitacion h inner join tipo t on h.id_tipoHabitacion=t.id");
	$habitaciones=array();
	while($fila = $bd->getFila()){
		$habitaciones[]= $fila;
	}
	echo json_encode($habitaciones);
	$bd->closeConexion();	
?>