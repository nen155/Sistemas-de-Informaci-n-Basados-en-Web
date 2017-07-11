<html>
<?php
	function __autoload($class){
		if(file_exists('modelo/class.'.$class.'.php'))
			include_once 'modelo/class.'.$class.'.php';
		if(file_exists('dao/class.'.$class.'.php'))
			include_once 'dao/class.'.$class.'.php';
		if(file_exists('vista/class.'.$class.'.php'))
			include_once 'vista/class.'.$class.'.php';
	}

	$ad=0;
	foreach( $_POST as $k => $v ) {
		///VARIABLES DEL PASO 1
		if($k=="ninos" || $k=="adultos" || $k=="checkin" ||$k=="checkout" || $k=="observaciones" || preg_match("/adultos_[^']*/",$k) ){
			if(preg_match("/adultos_[^']*/",$k)){
				$ad+=$v;
			}else
				$variablesReserva[$k]=$v;
		
		}///VARIABLES DE NUMERO DE HABITACIONES ESCOGIDAS
		else if ( preg_match("/hab_disp_[^']*/", $k) ) { 
		  $variablesHabDisp[$k] = $v."_".$k;
	    }///VARIABLES DE LINEA RESERVA
		else if(preg_match("/tipo_[^']*/", $k)){
			$tipo = new Tipo();
			$nombreTipo=split("_",$k);
			$tipo->setNombre($nombreTipo[1]);
			$tipo->setId($v);
			$variablesLineaReserva[$k] =$tipo;
		}
		else if( preg_match("/regimen_[^']*/", $k)){
			$regimen = new Regimen();
			$nombreReg=split("_",$v);
			$regimen->setId($nombreReg[0]);
			$regimen->setNombre($nombreReg[2]);
			$regimen->setPrecio($nombreReg[1]);
			$variablesLineaReserva[$k] =$regimen;
		}
		else if( preg_match("/precio_base_[^']*/", $k)){
			$variablesPrecio[$k]=$v;
		}
		///VARIABLES DEL PASO 2
		else
		{
			$variablesCliente[$k]=$v;
		}
	}
	if($ad!=0)
	$variablesReserva["adultos"] =$ad;
	
	$sesion = new Sesion();
	//CREO LAS LINEAS DE RESERVA PARA AÑADIRSELAS A LA RESERVA 
	if(isset($variablesHabDisp))//MIRO EL NUMERO DE HABITACIONES QUE HA ESCOGIDO
	{
		foreach($variablesHabDisp as $numHabReservadas){
			$nombre = split("_",$numHabReservadas);//COJO EL VALOR NOMBRE[0] PARA SABER CUANTAS HABITACIONES DE UN TIPO HA ESCOGIDO
			for($i=0;$i<$nombre[0];$i++){
				///EN EL NOMBRE[3] TENGO EL TIPO DE HABITACION SI ES DOBLE, INDIVIDUAL ETC..
				$variablesLineaReserva["tipo_".$nombre[3]]->setPrecio($variablesPrecio["precio_base_".$nombre[3]."_".$i]);
				$lineasReserva[] = new LineaReserva($variablesLineaReserva["tipo_".$nombre[3]],$variablesLineaReserva["regimen_".$nombre[3]."_".$i]);
			}
		}
	}
	
	///SESION PARA EL CLIENTE
	if($sesion->get("cliente")!=null)///SI HA VUELTO A CLIENTE LE PONGO SU SESION
	{	
		
		$cliente = unserialize($sesion->get("cliente"));
		if(isset($variablesCliente["nombre"]))///SI HA CAMBIADO DATOS EN EL FORMULARIO SE LOS AÑADO A LA SESION
		{
			$cliente = new Cliente($variablesCliente["nombre"],$variablesCliente["apellidos"],$variablesCliente["email"],$variablesCliente["telefono"],$variablesCliente["direccion"],$variablesCliente["ciudad"],$variablesCliente["pais"],$variablesCliente["pasaporte"],$variablesCliente["codigopostal"]);
			$sesion->set("cliente",$cliente);
		}
	}else///SI ES LA PRIMERA VEZ COJO LO DEL POST
	{
		if(isset($_POST["nombre"])){
			$cliente = new Cliente($variablesCliente["nombre"],$variablesCliente["apellidos"],$variablesCliente["email"],$variablesCliente["telefono"],$variablesCliente["direccion"],$variablesCliente["ciudad"],$variablesCliente["pais"],$variablesCliente["pasaporte"],$variablesCliente["codigopostal"]);
			$sesion->set("cliente",$cliente);
		}
	}
	
	///SESION PARA LA RESERVA
	if($sesion->get("reserva")!=null)///SI HA RESERVA LE PONGO SU SESION
	{	
		$reserva = unserialize($sesion->get("reserva"));
		if(isset($variablesReserva["adultos"]))///SI HA CAMBIADO DATOS EN EL FORMULARIO SE LOS AÑADO A LA SESION
		{
			if($reserva->getNumPersonas()!=$variablesReserva["adultos"])
				$reserva->setNumPersonas($variablesReserva["adultos"]);
			if($reserva->getNumNinos()!=$variablesReserva["ninos"])
				$reserva->setNumNinos($variablesReserva["ninos"]);
			if($reserva->getCheckIn()!=$variablesReserva["checkin"])
				$reserva->setCheckin($variablesReserva["checkin"]);
			if($reserva->getCheckOut()!=$variablesReserva["checkout"])
				$reserva->setCheckout($variablesReserva["checkout"]);
			if(isset($variablesReserva["observaciones"]))
				if($reserva->getObservaciones()!=$variablesReserva["observaciones"])
					$reserva->setObservaciones($variablesReserva["observaciones"]);
			if(isset($lineasReserva)){
				$reserva->setLineasReserva($lineasReserva);
			}
			$sesion->set("reserva",$reserva);
		}
	}else
	{
		if(isset($_POST["ninos"]))///SI ES LA PRIMERA VEZ COJO LO DEL POST
		{
			$reserva = new Reserva();
			$reserva->setCheckin($variablesReserva["checkin"]);
			$reserva->setCheckout($variablesReserva["checkout"]);
			$reserva->setNumPersonas($variablesReserva["adultos"]);
			$reserva->setNumNinos($variablesReserva["ninos"]);
			if(isset($lineasReserva))
				$reserva->addLineasReserva($lineasReserva);
			$reserva->setCancelada(0);
			$sesion->set("reserva",$reserva);
		}
	}
	$jsonHead = new DatosJSON("json/header.json");
	$jsonMFC = new DatosJSON("json/menuFooterContacto.json");
	
	$datosHead=$jsonHead->getArray();
	$datosMFC=$jsonMFC->getArray();
	
	if(isset($_POST["lang"]))
		$nacionalizacion=$_POST["lang"];
	if(!isset($nacionalizacion))
		$nacionalizacion="ES";
	if(isset($_POST["paso"]))
		$paso=$_POST["paso"];
	else
		$paso=1;
	
	$datosJsonMFC = $datosMFC[$nacionalizacion];
	
	$menuF = new MenuFooterContacto($datosJsonMFC["menu"],$datosJsonMFC["titulos"],null);
	$menu = new MenuFooterContacto($datosJsonMFC["menu"]);
		
		//Mostrar desde Head hasta Form Reserva
	if(!isset($seccion)){
		$bdHead = $datosHead[$nacionalizacion]["index"];
	}else
	{
		$bdHead = $datosHead[$nacionalizacion][$seccion];
	}
	$cabecera = new Header($bdHead['title'], $bdHead['descripcion'], $bdHead['keywords'], $bdHead['index_title'], $bdHead['mis_reservas'],$bdHead["variablesFormReserva"]);
	$vistaHead = new VistaHeader($cabecera,$nacionalizacion);
		
	$vistaHead->muestraCabecera();
	$vistaHead->muestraHeader();
	
	$vistaMenu = new VistaMenu($menu,$nacionalizacion);
	$vistaMenu->muestraMenu();
	
	if(isset($cliente)){
		$vistaPasosReserva = new VistaPasosReserva($reserva,$cliente);
	}
	else
		$vistaPasosReserva = new VistaPasosReserva($reserva);
	echo'<!-- CONTENIDO -->
            <section id="contenido">
				<div id="container">
				<div id="container-reserva">';
		if($paso!=4)
			$vistaPasosReserva->muestraPasos($paso);
		switch($paso){
			case 1:
				$vistaPasosReserva->muestraPaso1();
			break;
			case 2:
				$vistaPasosReserva->muestraPaso2();
			break;
			case 3:
				$vistaPasosReserva->muestraPaso3();
			break;
			case 4:
				$bd = new BaseDatos();
				$bd->setConexion(Constantes::$servidor, Constantes::$usuario, Constantes::$clave,Constantes::$basedatos);
				$clientes = new Clientes($bd);
				$clientes->addCliente($cliente);
				$idCliente = $bd->getLastId();
				$reservas = new Reservas($bd);
				$reserva->setCliente($idCliente);
				$reservas->addReserva($reserva);
				$bd->closeConexion();
				$envioEmail = new EnvioEmail($reserva,$cliente);
				$envioEmail->enviaEmail();
				$vistaPasosReserva->muestraPaso4();
			break;
		}
	echo'</div>';		
	echo'</div>';
	echo'</section>';
	$vistaFooter = new VistaFooter($menuF);
	$vistaFooter->muestraFooter();
?>
</html>