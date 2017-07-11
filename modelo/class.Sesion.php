<?php
class Sesion{
		function __construct(){
			session_start();
		}
		function get($variable){
			if(isset($_SESSION["$variable"]))
				return $_SESSION["$variable"];
			else
				return null;
		}
		function set($variable,$valor){
			$_SESSION["$variable"] = serialize($valor);
		}
		function cerrar(){
			session_destroy();
		}
		function getTipo(){
			$v=$this->get("usuario");
			if($v != null)
				return unserialize($v)->getTipoUsu();
			else
				return "invitado";
		}
		function administrador($destino="localhost/index.php"){
			$v=$this->get("usuario");
			if($v != null){
				$usuario = unserialize($v);
				if($usuario->getTipoUsu()=="admin")
				{
				}else{
					if($_SERVER['ORIG_PATH_INFO']!=null)
					$destino =$_SERVER['ORIG_PATH_INFO'];
					header("location:".$destino);
							exit;
				}
			}else{
				header("location:".$destino);
				exit;
			}
		}
	}
?>