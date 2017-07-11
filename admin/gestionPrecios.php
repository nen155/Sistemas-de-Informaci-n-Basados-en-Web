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
	
<style type="text/css"></style></head>
<body>
	<?php include_once("include/navegacion.php"); ?>

	

<div class="container">
	<div class="row">

	
    
       <div class="panel panel-default">
        <div class="panel-heading">Precios por Fechas</div>
       
        <div class="panel-body">
		         <div class="col-md-12">
								<h3>Precios por Fechas</h3>
	                            <table class="table table-striped">
	                                <tbody id="filasItems">
	                                <tr>
	                                    <th align="left" scope="col" class="col-md-6">Nombre</th>
										<th align="left" scope="col" class="col-md-2">Precio</th>
										<th align="left" scope="col" class="col-md-2">Fecha Inicial</th>
										<th align="left" scope="col" class="col-md-2">Fecha Final</th>
	                                    <th align="center" scope="col" style="width:20px;">Precio</th>
	                                </tr>


	                            </tbody></table>
	                    
	                        </div>
	                   </div>
	                </div>
    </div>
</div>

	<script type="text/javascript">
	$(document).ready(function() {
		cargaDatos();
		$('button').click(function(){
			var idBoton = $(this).attr("id");
			var elementos = idBoton.split("_");
			eliminarDepartamento(elementos[1]);
		});
	});
		 function cargaDatos(){
			   $.ajax({
						type: "GET",
						url: "rest/servicioD/Departamentos/"+<%=id_usuario %>,
						async:false,
						success: function(response){
							$.each(response, function (i, item) {
								$('#filasDepartamentos').append('<tr id="fila_'+item.id+'">'+
								'<td><a href="addEditDepartamento.jsp?id='+ item.id +'">'+item.nombre+'</a></td>'+ 
								'<td align="center">'+
		                                '<a title="Editar" href="addEditDepartamento.jsp?id='+ item.id +'">'+
		                                '<img src="./img/icono_editar.png" alt="Editar Farmacia" style="width:25px;"></a>'+
		                            '</td>'+
		                            '<td align="right">'+
		                        '<button id="boton_'+item.id+'" class="btn btn-link btn-xs" title="Eliminar" onclick="if(!confirm("¿Desea realmente eliminar el registro?")){return false;};"><img src="./img/icono_eliminar.png" alt="Eliminar Departamento" style="width:25px;"></button>'+
		                        '</form>'+
		                    '</td></tr>');
							});
							
							  
						},
						error: function() {
							 alert('fail');
						}
				});
		   }
		   function eliminarDepartamento(id){
			   $.ajax({
			       type: "DELETE",
			       url: "rest/servicioD/Departamento/"+id,
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