<?php
 include_once "modelo/class.Habitaciones.php";
class VistaHabitacion	 {

    // solo una variable de tipo de la clase BaseDatos
    private $bd = null;
	private $habitaciones = null;
    //constructor se le pasa la base de datos
    function __construct($bd) {
        $this->bd = $bd;
		$this->habitaciones = new Habitaciones($this->bd->getArray());
    }

   
  				///PARA DIFERENCIAR LA VISTA DE UNA HABITACION CUANDO SE MUESTRA SOLA EN LUGAR DE UTILIZAR UNA FOTO PODEMOS METER UN ARRAY DE FOTOS Y HACERLE UN SLIDER PERO PARA ESO HAY QUE HACER EL SLIDER COMO EL DE EL HOTEL ABBADES CON <UL><LI> Y PARAMETROS DE VISIBILIDAD 
				//ASI QUE SINO QUIERES HACER ESO PORQUE ES LARGO PRUEBA A HACER ALGUN CAMBIO PARA QUE CUANDO SE MUESTRE SOLA UNA HABITACION SE VEA DISTINTA CUANDO SE MUESTRAN UNA DEBAJO DE OTRA, ES DECIR, LA SECCION HABITACIONES DEL MENU Y LA SECCION HABITACION TIENEN QUE MOSTRAR LA HABITACION DE DISTINTO MODO POR ELLO HAY UN METODO SINGLE y otro normal
				
    //Muestra por pantalla la habitación del tipo
    function muestraHabitacionSingle($tipo) {
       $hab = $this->habitaciones->getHabitacionPorTipo($tipo);
	   echo '<div class="two_columns">
					<div class="column1_two">
						<div class="texto_descripcion_promociones">
							<h2 class="titulos_columns">'.$hab->getNombre().'</h2>
							<p>'.$hab->getDescripcion().'</p>
						</div>
						<div class="boton color1">
							<a href="#" class="boton_link">
								RESERVAR
							</a>
						</div>
					</div>
					<div class="column2_two">
						<img id="img_descripcion_hotel" src="'.$hab->getFoto().'" alt="imagen habitación doble"/>
					</div>
				</div>';
				
    }
	//Muestra por pantalla la habitación del tipo
    function muestraHabitacion($tipo) {
       $hab = $this->habitaciones->getHabitacionPorTipo($tipo);
	   echo '<div class="two_columns">
					<div class="column1_two">
						<div class="texto_descripcion_promociones">
							<h2 class="titulos_columns">'.$hab->getNombre().'</h2>
							<p>'.$hab->getDescripcion().'</p>
						</div>
						<div class="boton color1">
							<a href="#" class="boton_link">
								RESERVAR
							</a>
						</div>
					</div>
					<div class="column2_two">
						<img id="img_descripcion_hotel" src="'.$hab->getFoto().'" alt="imagen habitación doble"/>
					</div>
				</div>';
				
    }
	//Muestra por pantalla la habitación del tipo
    function muestraHabitaciones() {
       $habs = $this->habitaciones->getHabitaciones();
	   $i=0;
	   foreach($habs as $hab){
		   if($i%2==0)
		   		$class="item_par";
			else
				$class="item_impar";
		   echo '<div class="two_columns '. $class.'">
						<div class="column1_two">
							<div class="texto_descripcion_promociones">
								<h2 class="titulos_columns">'.$hab->getNombre().'</h2>
								<p>'.$hab->getDescripcion().'</p>
							</div>
							<div class="boton color1">
								<a href="#" class="boton_link">
									RESERVAR
								</a>
							</div>
						</div>
						<div class="column2_two">
							<img id="img_descripcion_hotel" src="'.$hab->getFoto().'" alt="imagen habitación doble"/>
						</div>
					</div>';
	   }
				
    }
}

?>
