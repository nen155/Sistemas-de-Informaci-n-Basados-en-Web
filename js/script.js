window.onload=function(){
	compruebaFormulario();
	sliderP();
	slider();
	cargarmapa();
	jQuery("#gallery").unitegallery();
	
	
	
}
function compruebaFormulario(){
	var cont=0;
	var maxSelect=0;
	$("#continuarpaso2").on("submit",function(event){
		$("select[id*='hab_disp']").each(function (i, el) {
			maxSelect++;
         	if($(this).val()=="0")
				cont++;
     	});
		if(cont==maxSelect){
			event.preventDefault();
			alert("No has seleccionado ninguna habitacion");
		}
	});
}
var regimenes =[];
//Funcion para el selector de fechas para restringir los rangos
$( document ).ready(function() {
  	$("#checkin").datepicker({dateFormat: "dd/mm/yy",
	 onClose: function(selectedDate) {
        var date2 = $('#checkin').datepicker('getDate');
        date2.setDate(date2.getDate()+1);
        $("#checkout").datepicker("option", "minDate", date2);
    }});
	
	$("#checkout").datepicker({dateFormat: "dd/mm/yy",
	onClose: function(selectedDate) {
        var date2 = $('#checkout').datepicker('getDate');
		if(date2<$("#checkin").datepicker('getDate')){
        	date2.setDate(date2.getDate()-1);
        	$("#checkin").datepicker("setDate", date2);
		}
    }});
});
function goToStep(paso){
	$("#paso-steps").attr("value",paso);
	$("#pasoss").submit();
}
function construirUrlABuscar(){
	var checkin =$("#checkin").val();
	var checkout =$("#checkout").val();
	var adultos =$("#adultos-buscador").val();
	var ninos =$("#ninos-buscador").val();
	var datosJson = '{"ninos":"'+ninos+'","adultos":"'+adultos+'","checkin":"'+checkin+'","checkout":"'+checkout+'"}';
	cargaHabitacionesDisponibles("controlador/gestionReservas.php","adultos="+adultos+"&checkin="+checkin+"&checkout="+checkout+"&ninos="+ninos,datosJson);
}

function cargaHabitacionesDisponibles(url,datos,datosJSON){
	$.ajax({ 
    type: 'POST', 
    url: url,
	data: datos,  
    dataType: 'xml',
	converters: {"text xml": jQuery.parseXML},
    success: function(data) { 
		var i=0;
		$("#habitaciones").empty();
		$("#habitaciones").append("<li class='head'><div class='col1h'><span>Tipo de habitación</span></div>"+
		"<div class='col2h'><span>Número de habitaciones</span></div>"+
		"<div class='col3h'><span>Adultos</span></div>"+
		"<div class='col4h'><span>Niños</span></div>"+
		"<div class='col5h'><span>Regimen</span></div>"+
		"<div class='col6h'><span>Precio</span></div></li>");
        $(data.documentElement).find('habitacion').each(function(){
			var id = $(this).find('id').text();
		  var nombre = $(this).find('nombre').text().replace(/\s+/g, '-');;
		  var descripcion = $(this).find('descripcion').text();
		  var ocupacionMaxima = $(this).find('ocupacionMaxima').text();
		  var numHabDisponibles = $(this).find('numHabDisponibles').text();
		  var precio = $(this).find('precioTotal').text();
		  var regimenesXML = $(data.documentElement).find('regimenes');
		  var j=0;
		  var regimen = [];
		  $(regimenesXML).find('regimen').each(function(){
			  regimen[j] = [];
			  regimenes[j] = [];
			  regimenes[j]["nombre"] = regimen[j][0] =$(this).find("nombre").text();
			  regimenes[j]["id"] = regimen[j][1] =$(this).find("id").text();
			  regimenes[j]["precio"] =regimen[j][2] =$(this).find("precio").text();
		  	++j;
		  });
			vistaHabitacionDisponible(id,nombre,descripcion,ocupacionMaxima,numHabDisponibles,precio,regimen,i,datosJSON);
    	});
	updatePrecio();
	},error: function(){
		alert("No se han encontrado coincidencias en la base de datos");
	}
	});
}
function updateRows(data){
	var id = data.id;
	var nombre = id.split("_")[2];
	var numeroHabitaciones = data.value;
		//Obtengo el  select con id empezando con adultos_nombre
	if(numeroHabitaciones==0){
		numeroHabitaciones=1;
	}
	var $select_adultos = $('#adultos_'+nombre+'_0');
	var $select_ninos = $('#ninos_'+nombre+'_0');
	var $select_regimen = $('#regimen_'+nombre+'_0');
	var $precio = $('#precio_total_'+nombre+'_0');
	var $precio_h = $('#precio_total_h_'+nombre+'_0');
	var $precio_base = $('#precio_base_'+nombre+'_0');
	var $clones_adultos = [];
	var $clones_ninos = [];
	var $clones_regimen = [];
	var $clones_precio = [];
	var $clones_precio_h = [];
	var $clones_precio_base = [];
	
	for(i=0;i<numeroHabitaciones;++i){
			$clones_adultos[i] = $select_adultos.clone().prop({ id: "adultos_"+nombre+"_"+i, name: "adultos_"+nombre+"_"+i});
			$clones_ninos[i] = $select_ninos.clone().prop({ id: "ninos_"+nombre+"_"+i, name: "ninos_"+nombre+"_"+i});
			$clones_regimen[i] = $select_regimen.clone().prop({ id: "regimen_"+nombre+"_"+i, name: "regimen_"+nombre+"_"+i} );
			$clones_precio[i] = $precio.clone().prop({ id: "precio_total_"+nombre+"_"+i, name: "precio_total_"+nombre+"_"+i});
			$clones_precio_base[i] = $precio_base.clone().prop({ id: "precio_base_"+nombre+"_"+i, name: "precio_base_"+nombre+"_"+i});
	}
	$("#col3_"+nombre).empty();
	$("#col4_"+nombre).empty();
	$("#col5_"+nombre).empty();
	$("#col6_"+nombre).empty();
	for(i=0;i<numeroHabitaciones;++i){
		$("#col3_"+nombre).append($clones_adultos[i]);
		$("#col4_"+nombre).append($clones_ninos[i]);
		$("#col5_"+nombre).append($clones_regimen[i]);
		$("#col6_"+nombre).append($clones_precio[i]);
		$("#col6_"+nombre).append($clones_precio_base[i]);
	}
	$(".relleno").css("height",Math.max($(".relleno").height(),(parseInt(numeroHabitaciones,10)+1)*28));
	updatePrecio();
}
function updatePrecio(){
	var start = $('#checkin').val();
	var end = $('#checkout').val();
	var partsS = start.split("/");
	var partsE = end.split("/");
	var endP = new Date(parseInt(partsE[2], 10),
                  parseInt(partsE[1], 10),
                  parseInt(partsE[0], 10));
				 
	var startP =new Date(parseInt(partsS[2], 10),
                  parseInt(partsS[1], 10),
                  parseInt(partsS[0], 10));
				  
	// end - start returns difference in milliseconds 
	var diff = new Date( endP - startP );
	// get days
	var days = diff/1000/60/60/24;
	var total_reserva =$('#total-reserva');
	total_reserva.html("0");
	$("[id*=hab_disp]").each(function(index, element) {
        var numeroHab = parseInt($(this).val(),10);
		if(numeroHab>0){
			for(i=0;i<numeroHab;++i)
			{	
				var precioRegimen=0;
				var name = $(this).prop("id").split("_")[2];
				var precio = $('#precio_total_'+name+'_'+i);
				var precio_base =$('#precio_base_'+name+'_'+i);
				var regimen = $('#regimen_'+name+'_'+i).val().split("_")[0];
				for(j=0;j<regimenes.length;++j)
					if(regimen==regimenes[j]["id"]){
						precioRegimen=parseInt(regimenes[j]["precio"]);
						var regimenPorDia = precioRegimen*days;
						precio.html(precio_base.val());
						precio.html(parseInt($('#precio_total_'+name+'_'+i).html())+regimenPorDia);
					}
				total_reserva.html(parseInt(total_reserva.html())+(parseInt(precio.html())));
			}
		}else{
			var precioRegimen=0;
			var name = $(this).prop("id").split("_")[2];
			var precio = $('#precio_total_'+name+'_0');
			var precio_base =$('#precio_base_'+name+'_0');
			var regimen = $('#regimen_'+name+'_0').val().split("_")[0];
			for(j=0;j<regimenes.length;++j)
				if(regimen==regimenes[j]["id"]){
					precioRegimen=parseInt(regimenes[j]["precio"]);
					var regimenPorDia = precioRegimen*days;
					precio.html(precio_base.val());
					precio.html(parseInt($('#precio_total_'+name+'_0').html())+regimenPorDia);
				}
		}
			
    });		
}
function vistaHabitacionDisponible(id,nombre,descripcion,ocupacionMaxima,numHabDisponibles,precio,regimen,i,datosJSON){
	//Compruebo si la ocupacionMaxima de la habitacion a mostrar es mayor que los adultos introducidos
	//si es así la muestro
	var datos = jQuery.parseJSON(datosJSON);
	var numHabNecesarias = Math.ceil(parseInt(datos.adultos,10)/parseInt(ocupacionMaxima,10));
	if(numHabNecesarias<=numHabDisponibles){
		if(!(datos.adultos>1 && ocupacionMaxima==1)){
			$("#habitaciones").append("<li class='relleno'><input type='hidden' name='tipo_"+nombre+"' value='"+id+"'/>"+
					"<div class='col1'><img class='img_hab' src='images/"+nombre+".jpg'/>"+
					"<p><strong>"+nombre.replace(/\-+/g, ' ')+"</strong></p><p>"+descripcion+"</p></div>"+
					"<div class='col2'><select onchange='updateRows(this)' id='hab_disp_"+nombre+"' name='hab_disp_"+nombre+"'></select></div>"+
					"<div id='col3_"+nombre+"' class='col3'><select class='select-reservas' id='adultos_"+nombre+"_"+i+"' name='adultos_"+nombre+"_"+i+"'></select></div>"+
					"<div id='col4_"+nombre+"' class='col4'><select class='select-reservas' id='ninos_"+nombre+"_"+i+"' name='ninos_"+nombre+"_"+i+"'></select></div>"+
					"<div id='col5_"+nombre+"' class='col5'><select class='select-regimen'  onchange='updatePrecio(this)' id='regimen_"+nombre+"_"+i+"' name='regimen_"+nombre+"_"+i+"'></select></div>"+
					"<div id='col6_"+nombre+"' class='col6'><input type='hidden' id='precio_base_"+nombre+"_"+i+"' value='"+precio+"'/>"+
					"<p id='precio_total_"+nombre+"_"+i+"' >"+precio+"</p>"+
					"</li>");
					//El +1 es debido a que empezamos en 0 y como el 0 es para ver que no quiere esa habitación pues
					//no cuenta
					var maxHab = parseInt(numHabDisponibles,10);
					for(j=0;j<maxHab+1;++j){
						$("#hab_disp_"+nombre).append($('<option>', {
							value: j,
							text: j
						}));
					}
					//Lo mismo pasa en la ocupación que hay que añadir 1
					var ocuMax =parseInt(ocupacionMaxima,10);
					for(j=0;j< ocuMax+1;++j){
						$("#adultos_"+nombre+"_"+i).append($('<option>', {
							value: j,
							text: j
						}));
						
						$("#ninos_"+nombre+"_"+i).append($('<option>', {
							value: j,
							text: j
						}));
						
						
						
					}
					//var numHabNecesarias = Math.ceil(parseInt(datos.adultos,10)/parseInt(ocupacionMaxima,10));
					//$("#hab_disp_"+nombre+" option[value='"+numHabNecesarias+"']").prop('selected',true);
					$("#adultos_"+nombre+"_"+i+" option[value='"+datos.adultos+"']").prop('selected',true);
					$("#ninos_"+nombre+"_"+i+" option[value='"+datos.ninos+"']").prop('selected',true);
					//Con lo regimenes no pasa que haya que añadir +1 porque no empiezo en 0 sino con el nombre.
					for(j=0;j<regimen.length;++j){
						$("#regimen_"+nombre+"_"+i).append($('<option>', {
							value: regimen[j][1]+"_"+regimen[j][2]+"_"+regimen[j][0],
							text: regimen[j][0]
						}));
					}
		}
	}		
}



function validar(){
	if(!validarCorreo()){
		return false;
	}
	if(!validarTelefono()){
		return false;
	}
	if(!validarNombre()){
		return false;
	}
	if(!validarApellidos()){
		return false;
	}
	return true;
}
function enviar(){
	if(validar())
		alert("Mensaje enviado correctamente");
}
function limpiarC(){
	var correo;
    correo=document.getElementById("email");
	correo.className=correo.className.replace(" error", "");
	var mensaje_error=document.getElementById("errorE");
	mensaje_error.innerHTML="";
}
function limpiarT(){
	var telef;
    telef=document.getElementById("telef");
	telef.className=telef.className.replace(" error", "");
	var mensaje_error=document.getElementById("errorT");
	mensaje_error.innerHTML="";
}
function limpiarA(){
	var apellidos;
    apellidos=document.getElementById("apellidos");
	apellidos.className=apellidos.className.replace(" error", "");
	var mensaje_error=document.getElementById("errorA");
	mensaje_error.innerHTML="";
}
function limpiarN(){
	var nombre;
    nombre=document.getElementById("nombre");
	nombre.className=nombre.className.replace(" error", "");
	var mensaje_error=document.getElementById("errorN");
	mensaje_error.innerHTML="";
}
function validarCorreo(){
    var correo;
    correo=document.getElementById("email");
    var er2=/^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/;
    var er=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
    if(!er2.test(correo.value)){
		correo.className=correo.className + " error"; 
		var mensaje_error=document.getElementById("errorE");
		mensaje_error.innerHTML="Incorrecto";
        return false;
    }
	
	return true;
}
function validarTelefono(){
    var telef;
    telef=document.getElementById("telef");
	var er=/^((\+?34([ \t|\-])?)?[9|6|7|8]((\d{1}([ \t|\-])?[0-9]{3})|(\d{2}([ \t|\-])?[0-9]{2}))([ \t|\-])?[0-9]{2}([ \t|\-])?[0-9]{2})$/ ;
    if(!er.test(telef.value)){
		telef.className=telef.className + " error";
		var mensaje_error=document.getElementById("errorT");
		mensaje_error.innerHTML="Incorrecto";
        return false;
    }
    return true;
}
function validarNombre(){
    var nombre;
    nombre=document.getElementById("nombre");
    
    var er=/^[a-zA-Z]+$/;
    if(!er.test(nombre.value) || nombre.value.length<2){
		nombre.className=nombre.className + " error"; 
		var mensaje_error=document.getElementById("errorN");
		mensaje_error.innerHTML="Incorrecto";
        return false;
    }
	
	return true;
}
function validarApellidos(){
    var apellidos;
    apellidos=document.getElementById("apellidos");
    
    var er=/^[a-zA-Z]+$/;
    if(!er.test(apellidos.value) || apellidos.value.length<2){
		apellidos.className=apellidos.className + " error"; 
		var mensaje_error=document.getElementById("errorA");
		mensaje_error.innerHTML="Incorrecto";
        return false;
    }
	
	return true;
}
function cargarmapa()
{
	var contenedor=document.getElementById("map_localizacion");
	if(contenedor!=null){
		var coordenada =new google.maps.LatLng(37.1721173,-3.59879);
		var opciones={
			zoom:16,
			center: coordenada,
			mapTypeId: google.maps.MapTypeId.ROADMAP
			};
		mapa= new google.maps.Map(contenedor, opciones);
		rellena();
	}
}
function rellena(){

	   var marca;
	   var icono = "images/logo.png";
	   var desInfo =" <div itemscope='' itemtype='http://schema.org/Hotel'><span class='contact_name_l' itemprop='name'>Hotel Plaza Nueva</span></div>"
                               + "<ul class='contacto_hotel' itemprop='address' itemscope='' itemtype='http://schema.org/PostalAddress'>"
                               +     "<li>"
                                +        "<span itemprop='streetAddress'>Imprenta, nº 2. </span>"
                                +        "<span itemprop='postalCode'>18010 </span>"
                                +    "</li>"
                                +    "<li>"
                                 +   	 "<span itemprop='addressLocality'>Granada, </span>"
                                 +       "<span>Granada, </span>"
                                  +      "<span itemprop='addressCountry'>España</span>"
                                  +  "</li>"
                                 +   "<li>"
                                 +       "<span itemprop='telephone'><a>Teléfono: +34 958 215 273. </a></span>"
                                 +   "</li>"
                                 +   "<li>"
                                 +   	 "<span itemprop='telephone'><a>Fax: +34 958 225 765</a></span>"
                                 +   "</li>"
                                +    "<li class='mail' itemprop='email'><a id='email_loc' class='mail' href='mailto:info@hotel-plazanueva.com'>info@hotel-plazanueva.com  </a></li>"
                               + "</ul>	";
	   var logoInfo ="images/logo.png";
	   var posicion = new google.maps.LatLng(37.1721173,-3.59879);
	   marca=creaMarcas(icono,posicion);
	   anadeEventos(marca,desInfo,logoInfo);
	  
}
function anadeEventos(marca,desInfo,logoInfo){
	var mensaje="<div class='logo_map'><img style='float:left' src='"+logoInfo+"'/><div class='hotel_name_map'>HOTEL PLAZA NUEVA</div><div class='hotel_stars_map'>***</div></div><p><b>Descripcion:</b></p><p> "+desInfo+"</p>";
		var muestraMensaje= new google.maps.InfoWindow({
			content: mensaje
		});
	google.maps.event.addListener(marca,"click",function(){
			muestraMensaje.open(mapa,marca);
		});
}
function creaMarcas(icono,posicion){
	var marc= new google.maps.Marker(
	{
		position:posicion,
		map:mapa,
		icon:icono
	});
	return marc;
}

function cargarImagen(_imageSrc)
{
	this.imageSrc = _imageSrc;
}
var counter_slider = 0;
var imagenes = new Array();
function sliderP()
{
	imagenes.push(new cargarImagen("images/slider/0.jpg"));
	imagenes.push(new cargarImagen("images/slider/1.jpg"));
	imagenes.push(new cargarImagen("images/slider/2.jpg"));
	document.getElementById("slider").innerHTML = "<img id='images_slider' src=''/>";
	document.getElementById("images_slider").src = imagenes[counter_slider].imageSrc;
	setInterval(function(){
		counter_slider = (counter_slider + 1) % imagenes.length;
		document.getElementById("images_slider").src = imagenes[counter_slider].imageSrc;
	},5000);
}

////SLIDER///////////////
/*FUNCIONA PERFECTAMENTE SOLO PROBARLO EN OMISIÓN DE CSS3*/
function rotarIzq(slide){
	var cont=0;
	var id = setInterval(frame, 50);
    function frame() {
        if (cont == 30) {
            clearInterval(id);
        } else {
            cont++; 
			if(slide!=null)
            slide.style.marginLeft="-"+cont+"%";
        }
    }
}
function resetSlider(slide){
	var cont=30;
	var id = setInterval(frame, 5);
    function frame() {
        if (cont == 0) {
            clearInterval(id);
        } else {
            cont--; 
			if(slide!=null)
            slide.style.marginLeft="-"+cont+"%";
        }
    }
}
function retroceder(arraySlides){
	var cont=2;
	var id = setInterval(frame, 200);
	function frame() {
        if (cont == -1) {
            clearInterval(id);
			slider();
        } else {
            resetSlider(arraySlides[cont]);
			cont--; 
        }
    }	

}
function slider(){
	var slide1 = document.getElementById("slide_item1");
	var slide2 = document.getElementById("slide_item2");
	var slide3 = document.getElementById("slide_item3");
	var arraySlides = new Array();
	arraySlides.push(slide1);
	arraySlides.push(slide2);
	arraySlides.push(slide3);
	var cont=0;
	var id = setInterval(frame, 3500);
    function frame() {
        if (cont == 2) {
			clearInterval(id);
            retroceder(arraySlides);
        } else {
            rotarIzq(arraySlides[cont]);
			cont++; 
        }
    }	
}
