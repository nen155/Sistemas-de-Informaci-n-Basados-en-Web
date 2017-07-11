<?php
 include_once 'modelo/class.Header.php';
class VistaHeader	 {

	private $cabecera = null;
	private $lang;
    //constructor se le pasa el modelo cabecera
    function __construct($cabecera,$lang) {
		$this->cabecera = $cabecera;
		$this->lang = $lang;
    }
    function muestraCabecera() {
		echo '
			<head>
					<title>'.$this->cabecera->getTitulo().'</title>
					<meta charset="UTF-8">
					<meta name="description" content="'.$this->cabecera->getDescripcion().'">
					<meta name="keywords" content="'.$this->cabecera->getKeywords().'">
					<meta name="author" content="Emilio Chica Jimenez, Julian Torices Hernandez">
					<link href="css/style.css" rel="stylesheet" type="text/css"/>
					<link rel="shortcut icon" href="images/logo.ico">
					<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
					<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
					<script src="js/script.js" type="text/javascript"></script>
					<script type="text/javascript" src="js/unitegallery.min.js"></script> 
                    <link rel="stylesheet" href="css/unite-gallery.css" type="text/css" /> 
                    <script type="text/javascript" src="themes/default/ug-theme-default.js"></script> 
                    <link rel="stylesheet" href="themes/default/ug-theme-default.css" type="text/css" /> 

			</head>
			<!-- CUERPO -->
			<body>
			';
    }
	function muestraHeader(){
		echo'
			<!-- CABECERA -->
			<header id="cabecera">
					<!-- RIBBON SUPERIOR -->
					<div id="ribbon_superior">
						<a href="mailto:info@hotel-plazanueva.com" id="email_superior" class="head_text text_ribbon">
							info@hotel-plazanueva.com
						</a>
						<select id="idiomas" class="head_text">
							<option selected="selected">ESPAÑOL</option>
							<option>ENGLISH</option>
						</select>
						<span class="head_text text_ribbon">
							 +34 958 215 273
						</span>
					</div>
					<div id="logo_completo">
						<a href="index.php?lang='.$this->lang.'" title="'.$this->cabecera->getIndexTitle().'"> 
							<img src="css/img/logo.png" id="logo"/>
							<h2 id="hotel_name">HOTEL PLAZA NUEVA</h2>
							<h1 id="hotel_stars">***</h1>
						</a>
					</div>
					<div id="mis_reservas" class="boton">
						<a href="#" id="boton_mis_reservas" class="boton_link">+ '.$this->cabecera->getMisReservas().'</a>
					</div>
					<!-- RIBBON REDES SOCIALES -->
					<div id="ribbon_sociales">
						<a href="#" class="redes_sociales"><img src="css/img/twitter.png" /></a>
						<a href="#" class="redes_sociales"><img src="css/img/facebook.png"/></a>
						<a href="#" class="redes_sociales"><img src="css/img/youtube.png"/></a>
					</div>
			</header>
			 
        <!-- CUERPO DE LA PÁGINA -->
		<div id="cuerpo">
		';
	}
	function muestraSlider(){
		echo ' <!-- SLIDER PRINCIPAL -->
			<div id="slider"></div>';
	}
	function muestraFormReserva(){
		$arrayVariables=$this->cabecera->getVariablesFormReserva();
		echo '<!-- FORMULARIO RESERVA -->
            <form id="formularioreserva" name="formularioreserva" action="controladorReservas.php" method="POST">
                <div id="formulario">
                    <header>
                        <div id="cab_reserva">
                            '.$arrayVariables["reservaAhora"].'
                        </div>
                        <span class="plus_top">+</span>
                    </header>
                    <section style="display: block;">
                        <div class="calendario titulo">
                            '.$arrayVariables["fecha"].'
                        </div>
                        <div>
							<div class="calendario input">
								<input class="llegada" id="checkin" name="checkin" type="text" value="'. date("d/m/Y")    .'" />
							</div>
                            <div class="calendario input">
                                <input class="salida" type="text" id="checkout" name="checkout" value="'. date("d/m/Y" , mktime(0, 0, 0, date("m")  , date("d")+1, date("Y")) )    .'" />
							</div>
                        </div>
                        <div class="hab titulo">
							'.$arrayVariables["habitaciones"].'
                        </div>
                        <div>
                                <div class="hab content">
                                    <span class="selector">
                                        '.$arrayVariables["aldutos"].':
                                    </span>
                                    <div class="select">
                                        <select name="adultos">
                                            <option>1</option>
                                            <option selected="selected">2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                            <option>6</option>
                                            <option>7</option>
                                            <option>8</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="hab content">
                                    <span class="selector">
                                        '.$arrayVariables["ninos"].':
                                    </span>
                                    <div class="select">
                                        <select name="ninos">
                                            <option>1</option>
                                            <option selected="selected">2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                            <option>6</option>
                                            <option>7</option>
                                            <option>8</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit">
                                    <span class="titulo">
                                        '.$arrayVariables["buscar"].'
                                    </span>
                                    <span class="precio_gara">
                                         '.$arrayVariables["mejorPrecio"].'
                                    </span>
                                </button>
						</div>
						
                    </section>
                </div>
            </form>';
		
	}
	
	
}

?>
