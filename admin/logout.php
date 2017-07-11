<?php
function __autoload($class){
		if(file_exists('../modelo/class.'.$class.'.php'))
			include_once '../modelo/class.'.$class.'.php';
		if(file_exists('../dao/class.'.$class.'.php'))
			include_once '../dao/class.'.$class.'.php';
	}
		$sesion = new Sesion();
header("Location:index.php");
		$sesion->cerrar();
?>