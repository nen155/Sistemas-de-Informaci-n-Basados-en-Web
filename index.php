<!DOCTYPE html>
<html>
	<?php
	include_once 'controlador/class.ControladorSidebar.php';
	//include_once 'modelo/class.DatosJSON.php';
	function __autoload($class){
		if(file_exists('modelo/class.'.$class.'.php'))
		include_once 'modelo/class.'.$class.'.php';
		if(file_exists('vista/class.'.$class.'.php'))
		include_once 'vista/class.'.$class.'.php';
	}
	
		$jsonHead = new DatosJSON("json/header.json");
		$jsonMFC = new DatosJSON("json/menuFooterContacto.json");
		$jsonContenido = new DatosJSON("json/contenido.json");
		$jsonSidebar = new DatosJSON("json/sidebar.json");

		$datosHead=$jsonHead->getArray();
		$datosMFC=$jsonMFC->getArray();
		$datosContenido = $jsonContenido->getArray();
		$datosSidebar=$jsonSidebar->getArray();
		

		
		if(isset($_GET["seccion"]))
			$seccion=$_GET["seccion"];
		if(isset($_GET["lang"]))
			$nacionalizacion=$_GET["lang"];
		if(!isset($nacionalizacion))
			$nacionalizacion="ES";
				
		$datosJsonMFC = $datosMFC[$nacionalizacion];
		$bdContenido = $datosContenido[$nacionalizacion];
		
		$contacto = new MenuFooterContacto(null,$datosJsonMFC["titulos"],$datosJsonMFC["titulosContact"]);
		$contenido = new Contenido($bdContenido["descripcion"], $bdContenido["servicios"], $bdContenido["galeria"],$bdContenido["habitacion"], $bdContenido["promo"], $bdContenido["opinion"], $bdContenido["localizacion"]);
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
		$vistaHead->muestraSlider();
		$vistaHead->muestraFormReserva();
		//Mostrar Menu
		$vistaMenu = new VistaMenu($menu,$nacionalizacion);
		$vistaMenu->muestraMenu();
		//Mostrar Contenido
		$vistaContenido = new VistaContenido( $contenido);
		$vistaContacto = new VistaContacto( $contacto);
		echo'<!-- CONTENIDO -->
            <section id="contenido">
				<div id="container1">';
				
		if(!isset($seccion)){
				$vistaContenido->muestraDescripcion();
				$vistaContenido->muestraServicios();
				$vistaContenido->muestraSlider();
		}else{
			switch($seccion)
			{
				case "":
					$vistaContenido->muestraDescripcion();
					$vistaContenido->muestraServicios();
					$vistaContenido->muestraSlider();
					break;
				case "habitaciones":
					$vistaContenido->muestraHabitaciones();
					$vistaContenido->muestraServicios();
					break;
				case "galeria":
					$vistaContenido->muestraGaleria();
					break;
				case "promociones":
					$vistaContenido->muestraPromociones();
					break;
				case "opiniones":
					$vistaContenido->muestraOpiniones();
					break;
				case "localizacion":
					$vistaContenido->muestraLocalizacion();
					break;
				case "contacto":
					$vistaContacto->muestraContacto();
					$vistaContacto->muestraFormulario();
					break;
				case "promo_sierra":
					$vistaContenido->muestraPromocion(0);
					break;
				case "promo_alhambra":
					$vistaContenido->muestraPromocion(1);
					break;
				case "promo_noches":
					$vistaContenido->muestraPromocion(2);
					break;
				case "hab_doble":
					$vistaContenido->muestraHabitacion(0);
					break;
				case "hab_doble_sup":
					$vistaContenido->muestraHabitacion(1);
					break;
				case "hab_triple":
					$vistaContenido->muestraHabitacion(2);
					break;
			}
		}
		echo'</div>';
		//Mostrar Sidebar
		if(isset($seccion))
			$sidebar = new ControladorSidebar($datosSidebar[$nacionalizacion],$nacionalizacion,$seccion);
		else
			$sidebar = new ControladorSidebar($datosSidebar[$nacionalizacion],$nacionalizacion,null);
		$sidebar->mostrarSidebar();
		echo'</section>';
		//Mostrar Pie
		$vistaFooter = new VistaFooter($menuF);
		$vistaFooter->muestraFooter();
	?>
</html>