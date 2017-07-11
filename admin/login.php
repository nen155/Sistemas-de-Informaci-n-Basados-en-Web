<?php
function __autoload($class){
		if(file_exists('../modelo/class.'.$class.'.php'))
			include_once '../modelo/class.'.$class.'.php';
		if(file_exists('../dao/class.'.$class.'.php'))
			include_once '../dao/class.'.$class.'.php';
	}
	$bd = new BaseDatos();
	$bd->setConexion(Constantes::$servidor, Constantes::$usuario, Constantes::$clave,Constantes::$basedatos);
	$sesion = new Sesion();
	$user = $_POST["email"];
	$pass = sha1($_POST["password"]);
	$bd->setConsulta("select password from `usuario` where email='$user'");
	$fila = $bd->getFila();
	echo $fila[0];
	
	$passbd = $fila[0];
	if($pass==$passbd){
		$usuario = new Usuario($user,$pass);
		$sesion->set("usuario",$usuario);
		header("Location:inicio.php");
	}
	else
	{
		header("Location:index.php");
		$sesion->cerrar();
	}
	$bd->closeConexion();	
?>