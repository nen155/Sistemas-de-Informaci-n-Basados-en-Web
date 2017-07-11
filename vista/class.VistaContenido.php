<?php
 include_once "modelo/class.Contenido.php";
class VistaContenido{

	private $cabecera = null;
    //constructor se le pasa el contenido
    function __construct( $contenido) {
		$this->contenido = $contenido;
    }
    function muestraDescripcion() {
		echo '
			<!-- DESCRIPCION -->
			<section id="descripcion_hotel" class="secciones">
                    <h1 class="titulos_seccion">'.$this->contenido->getDescripcionT().'</h1>
                    <div class="two_columns">
                        <div class="column1_two">
                            <div id="texto_descripcion_hotel">
                            	'.$this->contenido->getDescripcionC().'
                            </div>
                        </div>
                        <div class="column2_two">
                            <img id="img_descripcion_hotel" class="img_columns" src="'.$this->contenido->getDescripcionI().'" />
                        </div>
                    </div>
                </section>
		';
    }
	function muestraServicios(){
		echo '
			<!-- SERVICIOS -->
                <section id="servicios" class="secciones">
                    <h1 class="titulos_seccion">
                        '.$this->contenido->getServiciosT().'
                    </h1>
                    <!-- ICONO SERVICIOS -->
                    <ul>';
		$i = 1;			
		foreach($this->contenido->getServicios() as $item){
			echo'
				<li class="iconos_servicios" id="iconos_servicios_'.$i.'">
                    <span class="descripcion_servicios">'.$item["descripcion"].'</span>
                </li>';
				$i = $i +1;
		}
		
                        
        echo'            </ul>
                </section>';
	}
	function muestraSlider(){
		echo'
			<!-- PROMOCIONES -->
                <section id="promociones" class="secciones">
    
                    <h1 class="titulos_seccion">
                        '.$this->contenido->getPromoT().'
                    </h1>
					<div class="slider_promo">
						<div class="items">
			';
				$promo = $this->contenido->getPromo();
				$indice = 0;
				$i=1;
				foreach($promo as $item){
					if($indice==0){
						echo'
							<div id="slide_item'.$i.'" class="two_columns item_par">
									<div class="column1_two">
										<div class="texto_descripcion_promociones">
											 <h2 class="titulos_columns">'.$item["titulo"].'</h2>
											'.$item["descripcion"].'
										</div>
										<div class="boton color1">
											<a href="'.$item["link"].'" class="boton_link">'.$this->contenido->getPromoB().'</a>
										</div>
									</div>
									<div class="column2_two">
										<div class="img_ofertas">		
											<img class="img_columns" src="'.$item["img"].'" />
											
											<a href="'.$item["link"].'" class="oferta_izquierda"></a>
											<div class="titulo_oferta of_izq">'.$item["num"].'</div><div class="of_sub_izq  subtitulo_oferta">'.$item["tiem"].'</div>
										</div>
									</div>
							</div>
							
							';
					}else{
						echo'
							<div id="slide_item'.$i.'" class="two_columns item_impar">
									<div class="column1_two">
										<div class="img_ofertas">
											<img class="img_columns" src="'.$item["img"].'" />
									   
											<a href="'.$item["link"].'" class="oferta_derecha"></a>
											<div class="titulo_oferta of_der">'.$item["num"].'</div><div class="of_sub_der subtitulo_oferta">'.$item["tiem"].'</div>
										</div>
									</div>
									<div class="column2_two">
										
										<div class="texto_descripcion_promociones">
											<h2 class="titulos_columns">'.$item["titulo"].'</h2>
											'.$item["descripcion"].'
										</div>
										<div class="boton color2">
											<a href="'.$item["link"].'" class="boton_link">'.$this->contenido->getPromoB().'</a>
										</div>
									</div>
							</div>
						';
					}
					$indice = 1 - $indice;
					$i = $i + 1;
				}
				echo'	</div>
					</div>
				</section>';
	}
	function muestraHabitaciones(){
		echo'
			<section id="descripcion_habitaciones" class="secciones">
				<h1 class="titulos_seccion">
					'.$this->contenido->getHabitacionT().'
				</h1>
			';
			$hab = $this->contenido->getHabitacion();
			$indice = 0;
			foreach($hab as $item){
				if($indice==0)
				{
					echo'<div class="two_columns item_par">
						<div class="column1_two">
							<div class="texto_descripcion_promociones">
								<h2 class="titulos_columns">'.$item["titulo"].'</h2>
								'.$item["descripcion"].'
							</div>
							<div class="boton color1">
								<a href="'.$item["link"].'" class="boton_link">
									'.$this->contenido->getHabitacionB().'
								</a>
							</div>
						</div>
						<div class="column2_two">
							<img id="img_descripcion_hotel" src="'.$item["img"].'"/>
						</div>
					</div>
					';
				}else{
					echo'
						<div class="two_columns item_impar">
							<div class="column1_two">
								<img id="img_descripcion_hotel" src="'.$item["img"].'" />
							</div>
							<div class="column2_two">
								<div class="texto_descripcion_habitaciones">
									<h2 class="titulos_columns">'.$item["titulo"].'</h2>
									'.$item["descripcion"].'
								</div>
								<div class="boton color2">
									<a href="'.$item["link"].'" class="boton_link">
										'.$this->contenido->getHabitacionB().'
									</a>
								</div>
							</div>
						</div>
					';
				}
				
				$indice = 1 - $indice;
			}
			echo'</section>';
	}
	function muestraHabitacion($indice){
		echo'
			<section id="descripcion_habitaciones" class="secciones">
				<h1 class="titulos_seccion">
					'.$this->contenido->getHabitacionT().'
				</h1>
			';
			$item = $this->contenido->getHabitacion()[$indice];

					echo'<div class="two_columns item_par">
						<div class="column1_two">
							<div class="texto_descripcion_promociones">
								<h2 class="titulos_columns">'.$item["titulo"].'</h2>
								'.$item["descripcion"].'
							</div>
							<div class="boton color1">
								<a href="'.$item["link"].'" class="boton_link">
									'.$this->contenido->getHabitacionB().'
								</a>
							</div>
						</div>
						<div class="column2_two">
							<img id="img_descripcion_hotel" src="'.$item["img"].'"/>
						</div>
					</div>
					';
			echo'</section>';
	}
	function muestraGaleria(){
		echo'
			<section id="seccion_galeria" class="secciones">
					<h1 class="titulos_seccion">'.$this->contenido->getGaleriaT().'</h1>
					<div id="gallery" style="display:none;">
						<img alt="Hotel Plaza Nueva" src="images/thumbs/1.jpg"
							data-image="images/big/1.jpg"
							data-description="Hotel Plaza Nueva">
						<img alt="Hotel Plaza Nueva" src="images/thumbs/2.jpg"
							data-image="images/big/2.jpg"
							data-description="Hotel Plaza Nueva">
						<img alt="Hotel Plaza Nueva" src="images/thumbs/3.jpg"
							data-image="images/big/3.jpg"
							data-description="Hotel Plaza Nueva">
						<img alt="Hotel Plaza Nueva" src="images/thumbs/4.jpg"
							data-image="images/big/4.jpg"
							data-description="Hotel Plaza Nueva">
						<img alt="Hotel Plaza Nueva" src="images/thumbs/5.jpg"
							data-image="images/big/5.jpg"
							data-description="Hotel Plaza Nueva">
					
					</div>
			</section>
		';
	}
	function muestraPromociones(){
		echo'
			<!-- PROMOCIONES -->
			<section id="promociones" class="secciones">

				<h1 class="titulos_seccion">
					'.$this->contenido->getPromoT().'
				</h1>
			';
			$promo = $this->contenido->getPromo();
			$indice = 0;
			foreach($promo as $item){
				if($indice==0){
					echo'
						<div class="two_columns item_par">
							<div class="column1_two">
								<div id="texto_descripcion_promociones">
									<h2 class="titulos_columns">'.$item["titulo"].'</h2>
									'.$item["descripcion"].'
								</div>
								<div class="boton color1">
									<a href="'.$item["link"].'" class="boton_link">
										'.$this->contenido->getPromoB().'
									</a>
								</div>
							</div>
							<div class="column2_two">
								<div class="img_ofertas">		
									<img class="img_columns" src="'.$item["img"].'"/>
									<a href="'.$item["link"].'" class="oferta_izquierda"></a>
									<div class="titulo_oferta of_izq">'.$item["num"].'</div><div class="of_sub_izq  subtitulo_oferta">'.$item["tiem"].'</div>
								</div>
							</div>
						</div>
					';
				}else{
					echo'
						<div class="two_columns item_impar">
							<div class="column1_two">
								<div class="img_ofertas">
									<img class="img_columns" src="'.$item["img"].'" />
									<a href="'.$item["link"].'" class="oferta_derecha"></a>
									<div class="titulo_oferta of_der">'.$item["num"].'</div><div class="of_sub_der subtitulo_oferta">'.$item["tiem"].'</div>
								</div>
							</div>
							<div class="column2_two">
								<div id="texto_descripcion_promociones">
									<h2 class="titulos_columns">'.$item["titulo"].'</h2>
									'.$item["descripcion"].'
								</div>
								<div class="boton color2">
									<a href="'.$item["link"].'" class="boton_link">
										'.$this->contenido->getPromoB().'
									</a>
								</div>
							</div>
						</div>
					';
				}
				$indice = 1 - $indice;	
			}	
			echo'</section>';
	}
	function muestraPromocion($indice){
		echo'
			<!-- PROMOCIONES -->
			<section id="promociones" class="secciones">

				<h1 class="titulos_seccion">
					'.$this->contenido->getPromoT().'
				</h1>
			';
			$item = $this->contenido->getPromo()[$indice];
					echo'
						<div class="two_columns item_par">
							<div class="column1_two">
								<div id="texto_descripcion_promociones">
									<h2 class="titulos_columns">'.$item["titulo"].'</h2>
									'.$item["descripcion"].'
								</div>
								<div class="boton color1">
									<a href="'.$item["link"].'" class="boton_link">
										'.$this->contenido->getPromoB().'
									</a>
								</div>
							</div>
							<div class="column2_two">
								<div class="img_ofertas">		
									<img class="img_columns" src="'.$item["img"].'"/>
									<a href="'.$item["link"].'" class="oferta_izquierda"></a>
									<div class="titulo_oferta of_izq">'.$item["num"].'</div><div class="of_sub_izq  subtitulo_oferta">'.$item["tiem"].'</div>
								</div>
							</div>
						</div>
					';
			echo'</section>';
	}
	function muestraOpiniones(){
		echo'
			<section class="secciones">
				<h1 class="titulos_seccion">
					'.$this->contenido->getOpinionT().'
				</h1>
				<!-- OPINIONES -->
				';
				$opinion = $this->contenido->getOpinion();
				$indice = 0;
				$arrayColor = array(0 => '1', 1 => '2');
				foreach($opinion as $item)
				{
					echo'<div class="opiniones">
						<div class="datos_opiniones">
							<h3>'.$item["nombre"].'</h3>
							<p>'.$item["pais"].'</p>
							<p>'.$item["fecha"].'</p>
						</div>
						<div class="texto_opiniones color'.$arrayColor[$indice].'">
							<div class="triangle'.$arrayColor[$indice].'"></div>
							<p>'.$item["comentario"].'</p>
						</div>
						<div class="puntuacion">
							<p>'.$item["limpieza"].'</p>
							<p>'.$item["atencion"].'</p>
							<p>'.$item["confort"].'</p>
							<p>'.$item["ubicacion"].'</p>
							<p>'.$item["instalaciones"].'</p>
							<p>'.$item["desayuno"].'</p>
							<h3>'.$item["total"].'</h3>
						</div>
					</div>';
					
					$indice = 1 - $indice;
				}
		echo'</section>';

	}
	function muestraLocalizacion(){
		$titulos = $this->contenido->getLocalizacion();
		echo'
			<section class="secciones">
				<h1 class="titulos_seccion">
					'.$this->contenido->getLocalizacionT().'
				</h1>
				
				<div id="texto_localizacion">
					<div itemscope="" itemtype="http://schema.org/Hotel"><span class="contact_name_l" itemprop="name">Hotel Plaza Nueva</span></div>
										<ul class="contacto_hotel" itemprop="address" itemscope="" itemtype="http://schema.org/PostalAddress">
											<li>
												<span itemprop="streetAddress">'.$titulos["calle"].'. </span>
												<span itemprop="postalCode">18010 </span>
											   
											</li>
											<li>
												 <span itemprop="addressLocality">'.$titulos["ciudad"].', </span>
												<span>'.$titulos["ciudad"].', </span>
												<span itemprop="addressCountry">'.$titulos["pais"].'</span>
											</li>
											<li>
												<span itemprop="telephone"><a>'.$titulos["telefono"].': +34 958 215 273. </a></span>					 
											</li>
											<li>
												 <span itemprop="telephone"><a>'.$titulos["fax"].': +34 958 225 765</a></span>
											</li>
											<li class="mail" itemprop="email"><a id="email_loc" href="mailto:info@hotel-plazanueva.com  ">info@hotel-plazanueva.com  </a></li>
										</ul>
					</div>
				<div id="map_localizacion">
				</div>
			</section>
		';
	}
}

?>
