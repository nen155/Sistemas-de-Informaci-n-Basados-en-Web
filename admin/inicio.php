<?php
	function __autoload($class){
		if(file_exists('../modelo/class.'.$class.'.php'))
			include_once '../modelo/class.'.$class.'.php';
		if(file_exists('../dao/class.'.$class.'.php'))
			include_once '../dao/class.'.$class.'.php';
	}
	$login="No iniciado";
	$sesion = new Sesion();
	if($sesion->get("usuario")!=null)
		$login = trim(unserialize($sesion->get("usuario"))->getNombre());
	else
		header("Location:index.php");
?>
<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Hotel</title>

	<link href="./css/app.css" rel="stylesheet">
	<link href="./css/style.css" rel="stylesheet">
	<link href="./css/fileinput.css" rel="stylesheet">

	<link media="all" type="text/css" rel="stylesheet" href="./bootstrap/css/bootstrap-datetimepicker.min.css">


	<!-- Fonts -->
	<link href="./css/css" rel="stylesheet" type="text/css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script src="./javascript/fileinput.js"></script>


</head>
<body>
	<?php include_once("include/navegacion.php"); ?>
	<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Menú Rapido</div>

				<div class="panel-body">
					<a href="gestionPrecios.php">
						<div class="col-md-2 botonInicio">
         					<img src="./img/empresa.png">
         					<br>
         					Precios Habitaciones
         				</div>
         			</a>

                    <a href="gestionRegimenes.php">
						<div class="col-md-2 botonInicio">
         					<img src="./img/ciudad.png">
         					<br>
         					Regimenes
         				</div>
         			</a>
         			<a href="gestionTipoHabitaciones.php">
						<div class="col-md-2 botonInicio">
         					<img src="../img/categoria.png">
         					<br>
         					Tipos de Habitaciones
         				</div>
         			</a>
         			<a href="gestionHabitaciones.php">
						<div class="col-md-2 botonInicio">
         					<img src="./img/noticias.png">
         					<br>
         					Habitaciones
         				</div>
         			</a>
         			<a href="gestionReservas.php">
						<div class="col-md-2 botonInicio">
         					<img src="./img/subcategoria.png">
         					<br>
         					Reservas
         				</div>
         			</a>

                 
            	</div>
			</div>
		</div>
	</div>
</div>
	
	<!-- Scripts -->
	<script src="./javascript/jquery.min.js"></script>
	<script src="./bootstrap/js/bootstrap.min.js"></script>


</body></html>