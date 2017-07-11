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
<!-- saved from url=(0035)http://admin.guiapueblo.es/empresas -->
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

	<script src="./bootstrap/js/bootstrap-datetimepicker.js"></script>

	<script src="./bootstrap/js/bootstrap-datetimepicker.es.js"></script>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

<style type="text/css"></style></head>
<body>
	<?php include_once("include/navegacion.php"); ?>
<div class="container">
	<div class="row">

	
    
     <div class="panel panel-default">
        <div class="panel-heading">Reservas</div>
       
        <div class="panel-body">
		         <div class="col-md-12">
                 <table class="headerIndex">
                                <tbody><tr> 
                                    <td class="busquedaIndex" style="width:30%;">
                                        <form action="#" method="GET">
                                            <input id="valor" class="hidden" name="valor" type="text" value="desc">
                                            <div class="input-group input-group-sm">
                                                <input id="clave" class="form-control" name="clave" type="text" value="">
                                                <span class="input-group-btn">
                                                    <input id="buscar" name="buscar" class="btn btn-default" type="submit" value="Buscar">
                                                </span>
                                            </div>
                                    </form></td>
                                </tr>
                            </tbody></table>
								<h3>Reservas</h3>
	                            <table class="table table-striped">
	                                <tbody id="filasItems">
	                                <tr>
	                                    <th align="left" scope="col" >Nombre</th>
	                                    <th align="center" scope="col" >Apellidos</th>
	                                    <th align="center" scope="col" >Dni</th>
	                                    <th align="center" scope="col" >Fecha Entrada</th>
										<th align="center" scope="col" >Fecha Salida</th>
                                        <th align="center" scope="col" >Observaciones</th>
                                        <th align="center" scope="col" >Estado</th>
                                        <th align="center" scope="col" >Numero de Personas</th>
	                                </tr>


	                            </tbody></table>
	                    
	                        </div>
	                   </div>
	                </div>
	        </div>

    </div>
</div>

	<script type="text/javascript">
	
	 
	$( document ).ready(function() {
		cargaDatos(0);
		buscar();
	});  

		function cargaDatos(dato){
		   $.ajax({
					type: "GET",
					url: "reserva/reserva.php?dato="+dato,
					success: function(response){
						var datosJson = jQuery.parseJSON(response);
						$.each(datosJson, function (i, item) {
							 var cancel = '<td>Activa</td>';
							 if(item.cancelada!=0)
							 	cancel='<td>Cancelada</td>';
							 
							$('#filasItems').append('<tr>'+
							'<td>'+item.nombre+'</td>'+ 
							'<td >'+item.apellidos+'</td>'+ 
							'<td>'+item.dni+'</td>'+
							 '<td>'+item.checkin+'</td>'+
							 '<td>'+item.checkout+'</td>'+
							 '<td>'+item.observaciones+'</td>'+
							 cancel+
							 '<td>'+item.numPersonas+'</td>'+
							'</tr>');
						});
						
						  
					},
					error: function() {
						 alert('fail');
					}
			});
	   }
	   function buscar(){
	   		$("#clave").on("keyup",function(event){
				var clienteABuscar=$("#clave").val();
				if(clienteABuscar.length>=3){
					$('#filasItems').empty();
					cargaDatos(clienteABuscar);
					
				}else{
					$('#filasItems').empty();
					cargaDatos(0);
				}
			});
	   }
	</script>
	
	<!-- Scripts -->
	<script src="./javascript/jquery.min.js"></script>
	<script src="./bootstrap/js/bootstrap.min.js"></script>


</body></html>