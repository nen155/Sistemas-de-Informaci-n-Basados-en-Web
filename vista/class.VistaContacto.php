<?php
 include_once "modelo/class.MenuFooterContacto.php";
class VistaContacto {

	private $menu = null;
    //constructor se le pasa la variable menu
    function __construct($menu) {
		$this->menu = $menu;
    }
    function muestraContacto() {
                    $titulos = $this->menu->getTitulos();
                    echo '<section class="secciones">
							<h1 class="titulos_seccion">'.$titulos["contacto"]["titulo"].'</h1>				
                            <div itemscope="" itemtype="http://schema.org/Hotel"><span itemprop="name">Hotel Plaza Nueva</span></div>
                                <ul itemprop="address" itemscope="" itemtype="http://schema.org/PostalAddress">
                                    <li>
                                        <span itemprop="streetAddress">Imprenta, nº 2. </span>
                                        <span itemprop="postalCode">18010 </span>
                                       
                                    </li>
                                    <li>
                                    	 <span itemprop="addressLocality">Granada, </span>
                                        <span>Granada, </span>
                                        <span itemprop="addressCountry">'.$titulos["contacto"]["pais"].'</span>
                                    </li>
                                    <li>
                                        <span itemprop="telephone"><a>'.$titulos["contacto"]["telefono"].': +34 958 215 273. </a></span>					 
                                    </li>
                                    <li>
                                    	 <span itemprop="telephone"><a>'.$titulos["contacto"]["fax"].': +34 958 225 765</a></span>
                                    </li>
                                    <li class="mail" itemprop="email"><a href="mailto:info@hotel-plazanueva.com  ">info@hotel-plazanueva.com  </a></li>
                                </ul>
                        </div>';
    }
	function muestraFormulario(){
		$titulosContact = $this->menu->getTitulosContact();
		echo '<form action="enviar.php" method="post" class="contact-form-box" onsubmit="return validar();" >
				<input id="idioma" name="idioma" value="'.$_GET["lang"].'" type="hidden">
					<fieldset class="campos-form">
						<h3 class="page-subheading">'.$titulosContact["enviarmensaje"].'</h3>
						<div class="grupo-form">
							<div class="form-group">
								<label for="nombre">'.$titulosContact["nombre"].':</label>
								<input onFocus="limpiarN();"  onblur="return validarNombre();" class="form-control" id="nombre" name="nombre" value="" type="text">
								<div id="errorN"></div>
							</div>
							<div class="form-group">
								<label for="apellidos">'.$titulosContact["apellidos"].':</label>
								
								<input onFocus="limpiarA();"  onblur="return validarApellidos();" class="form-control" id="apellidos" name="apellidos" value="" type="text">
								<div id="errorA"></div>
							</div>
							<div class="form-group">
								<label for="email">'.$titulosContact["email"].':</label>
                                
								<input onFocus="limpiarC();" onblur="return validarCorreo();" class="form-control" id="email" name="email" value="" type="text">
								<div id="errorE"></div>
							</div>
							<div class="form-group">
								<label>'.$titulosContact["telefono"].':</label>
                                
								<input onFocus="limpiarT();" onblur="return validarTelefono();" class="form-control" name="telef" id="telef" value="" type="text">
								<div id="errorT"></div>
							</div>
								<div class="form-group">
									<label for="mensaje">'.$titulosContact["mensaje"].'</label>
                                    
									<textarea class="form-control" id="mensaje" name="mensaje"></textarea>
									<div id="errorM"></div>
								</div>
						</div>
						<div class="submit">
							<button type="submit" name="submitMessage" id="submitMessage" class="boton_env color1" onclick="enviar()">
								<span class="boton_link">'.$titulosContact["enviarmensaje"].'</span>
							</button>
						</div>
					</fieldset>
				</form>';
	}
	function muestraFormGracias(){
		echo '<h1>GRACIAS POR ENVIAR SU MENSAJE</h1>';
		muestraFormulario();
	}
	function muestraFormError(){
		echo '<h1>ERROR COMPRUEBE LOS DATOS DEL FORMULARIO</h1>';
		muestraFormulario();
	}
}

?>