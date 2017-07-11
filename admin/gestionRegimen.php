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
        <div class="panel-heading">Regimenes</div>
       
        <div class="panel-body">
		         <div class="col-md-12">
								<h3>Regimenes</h3>
	                            <table class="table table-striped">
	                                <tbody id="filasItems">
	                                <tr>
	                                    <th align="left" scope="col" class="col-md-6">Nombre</th>
	                                    <th align="center" scope="col" style="width:20px;">Precio</th>
	                                </tr>


	                            </tbody></table>
	                    
	                        </div>
	                   </div>
	                </div>

    </div>
</div>

	<script type="text/javascript">
	
	 
	$( document ).ready(function() {
		cargaFarmaciasSelect();
		$("#id_farmacia").change( function () {
			var idFarm=$(this).val();
			$("#id_departamento").empty();
			$("#id_producto").empty();
			$("#id_departamento").append($('<option>', {
			    value: "",
			    text: 'Seleccionar...'
			}));
			$("#id_producto").append($('<option>', {
			    value: "",
			    text: 'Seleccionar...'
			}));
			 cargaItemsInventario(idFarm);
			 cargaSelect("rest/servicioD/DepartamentosF/"+idFarm,"id_departamento");
			 cargaSelect("rest/servicioP/ProductosN/"+idFarm+"/"+<%=id_usuario %>,"id_producto");
		   });
		$('#botonA').click(function(){
			var id_producto=$("#id_producto").val();
			var id_farmacia=$("#id_farmacia").val();
			var id_departamento = $("#id_departamento").val();
			addProductoInventario(id_producto,id_farmacia,id_departamento);
		});
	});  

		function cargaSelect(urlRest,select){
			   $.ajax({
				   type: "GET",
					url: urlRest,
					success: function(response){
						$.each(response, function (i, item) {
							
						    $('#'+select).append($('<option>', { 
						        value: item.id,
						        text : item.nombre 
						    }));
						});
					},
					error: function() {
						 alert('fail');
					}
			   });
		   }
		function cargaItemsInventario(id){
			$('#filasItems').empty();
			$('#filasItems').append('<tr>'+
                    '<th align="left" scope="col" class="col-md-6">Producto</th>'+
                    '<th align="center" scope="col" style="width:20px;" >Departamento</th>'+
                    '<th align="center" scope="col" style="width:20px;">Stock</th>'+
                    '<th align="center" scope="col" style="width:20px;">Precio</th>'+
                    '<th align="center" scope="col" style="width:20px;">Guardar</th>'+
                    '<th align="center" scope="col" style="width:50px;">Eliminar</th>'+
                '</tr>');
			
			 $.ajax({
					type: "GET",
					url: "rest/servicioI/Items/"+id,
					success: function(response){
						$.each(response, function (i, item) {
							$('#filasItems').append(	
							'<tr id="fila_'+item.id+'">'+
							'<td>'+item.producto.nombre+'<input id="prod_'+item.id+'" type="hidden" value="'+item.producto.id+'"></td>'+ 
							'<td>'+item.departamento.nombre+'<input id="dpto_'+item.id+'" type="hidden" value="'+item.departamento.id+'"></td>'+ 
							'<td align="center">'+
	                                '<input type="number" id="stock_'+item.id+'" name="stock" value="'+item.stock +'" style="width:50px;">'+
	                            '</td>'+
	                            '<td align="center">'+
                               	'<input type="number" name="precio" id="precio_'+item.id+'" value="'+item.precio +'" style="width:50px;">'+
                            	'</td>'+
	                            '<td align="right">'+
	                        		'<button id="botonG_'+item.id+'" class="btn btn-link btn-xs botonesGuardar" title="Guardar" onclick="guardarItem(this)"><img src="./img/guardar.png" alt="Guardar Stock Precio" style="width:25px;"></button>'+
		                    	'</td>'+
	                           	'</td>'+
		                            '<td align="right">'+
		                        		'<button id="botonE_'+item.id+'" class="btn btn-link btn-xs botonesEliminar" title="Eliminar" onclick="eliminarItem(this)" ><img src="./img/icono_eliminar.png" alt="Eliminar Farmacia" style="width:25px;"></button>'+
		                    	'</td>'+
	                        '</tr>');
						});
						
						  
					},
					error: function() {
						 alert('fail');
					}
			});
		}
	   function cargaFarmaciasSelect(){
		   $.ajax({
					type: "GET",
					url: "rest/servicioF/Farmacias/"+<%=id_usuario %>,
					async:false,
					success: function(response){
						$.each(response, function (i, item) {
							
						    $('#id_farmacia').append($('<option>', { 
						        value: item.id,
						        text : item.nombre 
						    }));
						});
						  
					},
					error: function() {
						 alert('fail');
					}
			});
	   }
	   function addProductoInventario(id_producto,id_farmacia,id_departamento){
		   var obj = jQuery.parseJSON( '{"id_producto":"'+id_producto+'","id_farmacia":"'+id_farmacia+'","id_departamento":"'+id_departamento+'"}' );
		   $.ajax({
			   
		       type: "POST",
		       url: "ServletInventario",
		       data:JSON.stringify(obj),
		       success: function(response){
		    	   var estado = jQuery.parseJSON(response);
		    	   if(estado.status!="not"){
			    	   $('#id_producto').find('option:selected').remove().end();
			    	   cargaItemsInventario(id_farmacia);
		    	   }
		       },
		       error: function() {
		           alert('fail');
		       }
		   });
		   
	   }
	   function guardarItem(ele){
			var idBoton = $(ele).attr("id");
			var elementos = idBoton.split("_");
			var id=elementos[1];
			var id_producto=0;
			var id_departamento=0;
			var id_farmacia=0;
			var precio=0;
			var stock=0;
			id_producto = $("#prod_"+id).val(); 
			precio = $("#precio_"+id).val();
			stock = $("#stock_"+id).val();
			id_farmacia=$("#id_farmacia").val();
			id_departamento=$("#dpto_"+id).val();
			
		   var obj=jQuery.parseJSON( '{"id":"'+ id+ '", "id_producto":"'+id_producto+'","id_farmacia":"'+id_farmacia+'","id_departamento":"'+id_departamento+'","stock":"'+stock+ '","precio":"'+precio+'"}' );
 		 	$.ajax({
			   
		       type: "POST",
		       url: "ServletInventario",
		       data:JSON.stringify(obj),
		       success: function(response){
		    	   alert("stock y precio guardados");
		       },
		       error: function() {
		           alert('fail');
		       }
		   });
	   }
	   function eliminarItem(ele){
		   if(!confirm("¿Desea realmente eliminar el registro?")){
				return false;
				};
		   var idBoton = $(ele).attr("id");
			var elementos = idBoton.split("_");
			var idFarm=elementos[1];
		   $.ajax({
		       type: "DELETE",
		       url: "rest/servicioI/Inventario/"+id,
		       success: function(response){
		       	alert("Eliminado");
		       	$('#fila_'+id).remove();
		       	$("#id_producto").empty();
		       	cargaSelect("rest/servicioP/ProductosN/"+idFarm,"id_producto");
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