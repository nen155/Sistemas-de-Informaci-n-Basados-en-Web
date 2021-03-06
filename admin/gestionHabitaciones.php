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
        <div class="panel-heading">Habitaciones</div>
       
        <div class="panel-body">

                <div class="col-md-12">

                			<table class="headerIndex">
                                <tbody><tr> 
                                    <td class="botonNuevo">
                                     <a href="addEditHabitacion.php" class="btn btn-default btn-sm">Añadir Habitacion</a>
                                    </td>
                                </tr>
                            </tbody></table>

                            <table class="table table-striped">
                                <tbody id="filasProductos"><tr>
                                    <th align="left" scope="col">Numero</th>
                                    <th align="left" scope="col">Tipo</th>
                                    <th align="center" scope="col" style="width:50px;">Editar</th>
                                    <th align="center" scope="col" style="width:50px;">Eliminar</th>
                                </tr>
                                
                               <tr>

                                                      
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            </tbody></table>
                           
                    
                        </div>
                </div>
        </div>

    </div>
</div>


	<script type="text/javascript">
	
	$( document ).ready(function() {
		cargaDatos();
		$('button').click(function(){
			var idBoton = $(this).attr("id");
			var elementos = idBoton.split("_");
			eliminaProducto(elementos[1]);
		});
	});
	   function cargaDatos(){
		   $.ajax({
					type: "GET",
					url: "habitacion/habitaciones.php",
					async:false,
					success: function(response){
						$.each(response, function (i, item) {
							$('#filasProductos').append('<tr id="fila_'+item.id+'">'+
							'<td><a href="addEditHabitacion.php?id='+ item.id +'">'+item.numero+'</a></td>'+ 
							'<td>'+item.nombre+'</td>'+ 
							'<td align="center">'+
	                                '<a title="Editar" href="addEditHabitacion.php?id='+ item.id +'">'+
	                                '<img src="./img/icono_editar.png" alt="Editar Habitacion" style="width:25px;"></a>'+
	                            '</td>'+
	                            '<td align="right">'+
	                        '<button id="boton_'+item.id+'" class="btn btn-link btn-xs" title="Eliminar" onclick="if(!confirm(&quot;Â¿Desea realmente eliminar el registro?&quot;)){return false;};"><img src="./img/icono_eliminar.png" alt="Eliminar Habitacion" style="width:25px;"></button>'+
	                        '</form>'+
	                    '</td></tr>');
						});
						
						  
					},
					error: function() {
						 alert('fail');
					}
			});
	   }
	   function eliminaProducto(id){
		   $.ajax({
		       type: "DELETE",
		       url: "habitacion/delhabitacion.php",
		       success: function(response){
		       	alert("Eliminado");
		       	$('#fila_'+id).remove();
		       },
		       error: function() {
		           alert('fail');
		       }
		   });
	   }
	
	</script>
	<!-- Scripts -->
	<script src="./javascript/jquery.min.js"></script>
	<script src="./bootstrap/js/bootstrap.min.js"></script>


</body></html>