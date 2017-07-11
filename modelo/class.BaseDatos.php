<?php
class BaseDatos {
    private $conexion ;
    private $resultado ;
	private $resultado2;
    function setConexion($servidor, $usuario, $pass,$baseDatos) {
		$this -> conexion = mysqli_connect($servidor, $usuario, $pass,$baseDatos);
        if(!mysqli_connect_errno()){
            mysqli_set_charset($this -> conexion, "utf8");
            return true;
        }
        else 
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
			//you need to exit the script, if there is an error
			exit();
		}
    }
    function closeConexion() {
        mysqli_close($this -> conexion);
    }
    function setConsulta($consulta) {
		$this -> resultado = mysqli_query($this -> conexion,$consulta);
		if($this -> resultado)
                return true;
        return false;
    }
	function setSubConsulta($consulta) {
		$this -> resultado2 = mysqli_query($this -> conexion,$consulta);
		if($this -> resultado2)
                return true;
        return false;
    }
    function getNumFilas() {
		$res = mysqli_num_rows($this -> resultado);
		if($res)
                return $res;
        return false;
    }
    function getFila() {
		$res =mysqli_fetch_array($this -> resultado);
		if($res)
			return $res;
        return false;
    }
	function getSubNumFilas() {
		$res = mysqli_num_rows($this -> resultado2);
		if($res)
                return $res;
        return false;
    }
	function getSubFila() {
		$res =mysqli_fetch_array($this -> resultado2);
		if($res)
			return $res;
        return false;
    }
	function getLastId(){
		return mysqli_insert_id($this->conexion);
	}
}
?>