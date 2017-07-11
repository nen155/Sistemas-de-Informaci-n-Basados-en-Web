<?php
class VistaPasosReserva{
	private $reserva;
	private $cliente;
	
	function __construct($reserva,$cliente=null){
		$this->reserva=$reserva;
		$this->cliente=$cliente;
	}
	function muestraPasos($actual){
		$current="current";
		$previos="previous";
		$undone="undone";
		switch($actual){
			case 1:
				$paso1=$current;
				$paso2=$undone;
				$paso3=$undone;
				break;
			case 2:
				$paso1=$previos;
				$paso2=$current;
				$paso3=$undone;
				break;
			case 3:
				$paso1=$previos;
				$paso2=$previos;
				$paso3=$current;
			break;
		}
		
		echo '<form id="pasoss" action="controladorReservas.php" method="POST">
		<ul id="steps" class="threeStep">
			<input id="paso-steps" type="hidden" name="paso" value="'.$actual.'"/>
          <li class="step-1 '. $paso1 .'" onclick="goToStep(1)">
            <strong>Paso <span class="number">1</span></strong>
            <span class="title">Selección de fechas y habitaciones</span>
          </li>
          <li class="step-2 '.$paso2.'" '; if($actual==2 || $actual==3) echo 'onclick="goToStep(2)"'; echo '>
            <strong>Paso <span class="number">2</span></strong>
            <span class="title">Datos personales</span>
          </li>
          <li class="step-3 '.$paso3.' last" '; if($actual==3) echo 'onclick="goToStep(3)"'; echo '>
            <strong>Paso <span class="number">3</span></strong>
            <span class="title">Pago / Confirmación</span>
          </li>
        </ul>
		</form>';
	}
	function muestraPaso1(){
		echo '<h2>Modificar Reserva</h2>
		<form id="continuarpaso2" action="controladorReservas.php" method="POST">
		<div id="ribbon-fechas"> 
				<label class="ribbon-buscador">Entrada:</label><input class="llegada ribbon-buscador" id="checkin" name="checkin" type="text" value="'. $this->reserva->getCheckIn()    .'" />
				<label class="ribbon-buscador">Salida:</label><input class="salida ribbon-buscador" type="text" id="checkout" name="checkout" value="'. $this->reserva->getCheckOut()   .'" />
				<span class="selector ribbon-buscador">
                     Adultos:
                </span>
                <div class="select ribbon-buscador">
                 <select id="adultos-buscador" name="adultos">';
						for ($i = 0; $i <= max(8,$this->reserva->getNumPersonas()); $i++) {
							if($this->reserva->getNumPersonas()==$i)
								$selecidonada="selected='selected'";
							else
								$selecidonada="";
							echo "<option " .$selecidonada. ">" . $i . "</option>";
						}
                 echo '</select>
				</div>
				 <span class="selector ribbon-buscador">
                     Niños:
                 </span>
                <div class="select ribbon-buscador">
                    <select id="ninos-buscador" name="ninos">';
						for ($i = 0; $i <= max(8,$this->reserva->getNumNinos()); $i++) {
							if($this->reserva->getNumNinos()==$i)
								$selecidonada="selected='selected'";
							else
								$selecidonada="";
							echo "<option " .$selecidonada. ">" . $i . "</option>";
						}
                    echo '</select>
                 </div>
				 <a id="boton-ribbon-buscador" class="ribbon-buscador boton color1 boton_link" onclick="construirUrlABuscar()">
                       <span class="titulo">
                          	Buscar
                      </span>
                </a>
			
		</div>
		<h2>Habitaciones Disponibles</h2>
		<input type="hidden" name="paso" value="2"/>
		<ul id="habitaciones"></ul>
		<script type="text/javascript">
		cargaHabitacionesDisponibles("controlador/gestionReservas.php","ninos='.$this->reserva->getNumNinos().'&adultos='.$this->reserva->getNumPersonas().'&checkin='.$this->reserva->getCheckIn().'&checkout='.$this->reserva->getCheckOut().'",
	\'{"ninos":"'.$this->reserva->getNumNinos().'","adultos":"'.$this->reserva->getNumPersonas().'","checkin":"'.$this->reserva->getCheckIn().'","checkout":"'.$this->reserva->getCheckOut().'"}\');
		</script>
		<div id="total">Total: <div id="total-reserva">0€</div></div>
		<input type="submit" class="boton boton_link color1" value="CONTINUAR" />
		</form>';
		
	}
	function muestraPaso2(){
			$nombre="";
			$apellidos="";
			$email="";
			$pasaporte="";
			$direccion="";
			$ciudad="";
			$codigoPostal="";
			$pais="";
			$telefono="";
		if(isset($this->cliente)){
			$nombre=$this->cliente->getNombre();
			$apellidos=$this->cliente->getApellidos();
			$email=$this->cliente->getEmail();
			$pasaporte=$this->cliente->getDniPasaporte();
			$direccion=$this->cliente->getDireccion();
			$ciudad=$this->cliente->getCiudad();
			$codigoPostal=$this->cliente->getCodigoPostal();
			$pais=$this->cliente->getPais();
			$telefono=$this->cliente->getTelefono();
		}
		echo '<h2>Datos Personales</h2>
		<form id="form-datos-usuario" action="controladorReservas.php" method="post">
		<input type="hidden" value="3" name="paso" />
			<ul>
                <li id="li_firstname">
                  <label for="firstname" class="fb-field">Nombre</label>
                  <input class="text invalid" type="text" id="firstname" name="nombre" value="'.$nombre. '" autocomplete="given-name">
                </li>
                <li id="li_surname">
                  <label for="surname" class="fb-field">Apellidos</label>
                  <input class="text invalid" type="text" id="surname" name="apellidos" value="'.$apellidos. '" autocomplete="family-name">
                </li>
                <li id="li_email">
                  <label for="email" class="fb-field">E-mail</label>
                  <input class="text invalid" type="text" id="email" name="email" value="'. $email. '" autocomplete="email">
                </li>
                <li id="li_passport">
                  <label for="passport" class="fb-field">DNI o Pasaporte</label>
                  <input class="text invalid" type="text" id="passport" name="pasaporte" value="'.$pasaporte.'">
                </li>
                <li id="li_address">
                  <label for="address">Dirección</label>
                  <input class="text invalid" type="text" id="address" name="direccion" value="'. $direccion.'" autocomplete="street-address">
                </li>
                <li id="li_city">
                  <label for="city" class="fb-field">Ciudad</label>
                  <input class="text invalid" type="text" id="city" name="ciudad" value="'.  $ciudad.'" autocomplete="locality">
                </li>
                <li id="li_postcode">
                  <label for="postcode">Código postal</label>
                  <input class="text invalid" type="text" id="postcode" name="codigopostal" value="'. $codigoPostal. '" autocomplete="postal-code">
                </li>
                <li id="li_country">
                  <label for="country" class="fb-field">País</label>
                  <select id="country" name="pais" autocomplete="country" class="">
                    <option value="AF">Afganistán</option>
                    <option value="AL">Albania</option>
                    <option value="DE">Alemania</option>
                    <option value="AD">Andorra</option>
                    <option value="AO">Angola</option>
                    <option value="AI">Anguila</option>
                    <option value="AG">Antigua y Barbuda</option>
                    <option value="AN">Antillas Neerlandesas</option>
                    <option value="AQ">Antártida</option>
                    <option value="SA">Arabia Saudí</option>
                    <option value="DZ">Argelia</option>
                    <option value="AR">Argentina</option>
                    <option value="AM">Armenia</option>
                    <option value="AW">Aruba</option>
                    <option value="AU">Australia</option>
                    <option value="AT">Austria</option>
                    <option value="AZ">Azerbaiyán</option>
                    <option value="BS">Bahamas</option>
                    <option value="BH">Bahréin</option>
                    <option value="BD">Bangladesh</option>
                    <option value="BB">Barbados</option>
                    <option value="BZ">Belice</option>
                    <option value="BJ">Benín</option>
                    <option value="BM">Bermudas</option>
                    <option value="BY">Bielorrusia</option>
                    <option value="BO">Bolivia</option>
                    <option value="BA">Bosnia-Herzegovina</option>
                    <option value="BW">Botsuana</option>
                    <option value="BR">Brasil</option>
                    <option value="BN">Brunéi</option>
                    <option value="BG">Bulgaria</option>
                    <option value="BF">Burkina Faso</option>
                    <option value="BI">Burundi</option>
                    <option value="BT">Bután</option>
                    <option value="BE">Bélgica</option>
                    <option value="CV">Cabo Verde</option>
                    <option value="KH">Camboya</option>
                    <option value="CM">Camerún</option>
                    <option value="CA">Canadá</option>
                    <option value="TD">Chad</option>
                    <option value="CL">Chile</option>
                    <option value="CN">China</option>
                    <option value="CY">Chipre</option>
                    <option value="VA">Ciudad del Vaticano</option>
                    <option value="CO">Colombia</option>
                    <option value="KM">Comoras</option>
                    <option value="CG">Congo</option>
                    <option value="KP">Corea del Norte</option>
                    <option value="KR">Corea del Sur</option>
                    <option value="CR">Costa Rica</option>
                    <option value="CI">Costa de Marfil</option>
                    <option value="HR">Croacia</option>
                    <option value="CU">Cuba</option>
                    <option value="DK">Dinamarca</option>
                    <option value="DM">Dominica</option>
                    <option value="EC">Ecuador</option>
                    <option value="EG">Egipto</option>
                    <option value="SV">El Salvador</option>
                    <option value="AE">Emiratos Árabes Unidos</option>
                    <option value="ER">Eritrea</option>
                    <option value="SK">Eslovaquia</option>
                    <option value="SI">Eslovenia</option>
                    <option value="ES" selected="selected">España</option>
                    <option value="US">Estados Unidos</option>
                    <option value="EE">Estonia</option>
                    <option value="ET">Etiopía</option>
                    <option value="PH">Filipinas</option>
                    <option value="FI">Finlandia</option>
                    <option value="FJ">Fiyi</option>
                    <option value="FR">Francia</option>
                    <option value="GA">Gabón</option>
                    <option value="GM">Gambia</option>
                    <option value="GE">Georgia</option>
                    <option value="GH">Ghana</option>
                    <option value="GI">Gibraltar</option>
                    <option value="GD">Granada</option>
                    <option value="GR">Grecia</option>
                    <option value="GL">Groenlandia</option>
                    <option value="GP">Guadalupe</option>
                    <option value="GU">Guam</option>
                    <option value="GT">Guatemala</option>
                    <option value="GF">Guayana Francesa</option>
                    <option value="GG">Guernsey</option>
                    <option value="GN">Guinea</option>
                    <option value="GQ">Guinea Ecuatorial</option>
                    <option value="GW">Guinea-Bissau</option>
                    <option value="GY">Guyana</option>
                    <option value="HT">Haití</option>
                    <option value="HN">Honduras</option>
                    <option value="HU">Hungría</option>
                    <option value="IN">India</option>
                    <option value="ID">Indonesia</option>
                    <option value="IQ">Iraq</option>
                    <option value="IE">Irlanda</option>
                    <option value="IR">Irán</option>
                    <option value="BV">Isla Bouvet</option>
                    <option value="CX">Isla Christmas</option>
                    <option value="NU">Isla Niue</option>
                    <option value="NF">Isla Norfolk</option>
                    <option value="IM">Isla de Man</option>
                    <option value="IS">Islandia</option>
                    <option value="KY">Islas Caimán</option>
                    <option value="CC">Islas Cocos</option>
                    <option value="CK">Islas Cook</option>
                    <option value="FO">Islas Feroe</option>
                    <option value="GS">Islas Georgia del Sur y Sandwich del Sur</option>
                    <option value="HM">Islas Heard y McDonald</option>
                    <option value="FK">Islas Malvinas</option>
                    <option value="MP">Islas Marianas del Norte</option>
                    <option value="MH">Islas Marshall</option>
                    <option value="SB">Islas Salomón</option>
                    <option value="TC">Islas Turcas y Caicos</option>
                    <option value="VG">Islas Vírgenes Británicas</option>
                    <option value="VI">Islas Vírgenes de los Estados Unidos</option>
                    <option value="UM">Islas menores alejadas de los Estados Unidos</option>
                    <option value="AX">Islas Åland</option>
                    <option value="IL">Israel</option>
                    <option value="IT">Italia</option>
                    <option value="JM">Jamaica</option>
                    <option value="JP">Japón</option>
                    <option value="JE">Jersey</option>
                    <option value="JO">Jordania</option>
                    <option value="KZ">Kazajistán</option>
                    <option value="KE">Kenia</option>
                    <option value="KG">Kirguistán</option>
                    <option value="KI">Kiribati</option>
                    <option value="KW">Kuwait</option>
                    <option value="LA">Laos</option>
                    <option value="LS">Lesoto</option>
                    <option value="LV">Letonia</option>
                    <option value="LR">Liberia</option>
                    <option value="LY">Libia</option>
                    <option value="LI">Liechtenstein</option>
                    <option value="LT">Lituania</option>
                    <option value="LU">Luxemburgo</option>
                    <option value="LB">Líbano</option>
                    <option value="MK">Macedonia</option>
                    <option value="MG">Madagascar</option>
                    <option value="MY">Malasia</option>
                    <option value="MW">Malaui</option>
                    <option value="MV">Maldivas</option>
                    <option value="ML">Mali</option>
                    <option value="MT">Malta</option>
                    <option value="MA">Marruecos</option>
                    <option value="MQ">Martinica</option>
                    <option value="MU">Mauricio</option>
                    <option value="MR">Mauritania</option>
                    <option value="YT">Mayotte</option>
                    <option value="FM">Micronesia</option>
                    <option value="MD">Moldavia</option>
                    <option value="MN">Mongolia</option>
                    <option value="ME">Montenegro</option>
                    <option value="MS">Montserrat</option>
                    <option value="MZ">Mozambique</option>
                    <option value="MM">Myanmar</option>
                    <option value="MX">México</option>
                    <option value="MC">Mónaco</option>
                    <option value="NA">Namibia</option>
                    <option value="NR">Nauru</option>
                    <option value="NP">Nepal</option>
                    <option value="NI">Nicaragua</option>
                    <option value="NG">Nigeria</option>
                    <option value="NO">Noruega</option>
                    <option value="NC">Nueva Caledonia</option>
                    <option value="NZ">Nueva Zelanda</option>
                    <option value="NE">Níger</option>
                    <option value="OM">Omán</option>
                    <option value="PK">Pakistán</option>
                    <option value="PW">Palau</option>
                    <option value="PS">Palestina</option>
                    <option value="PA">Panamá</option>
                    <option value="PG">Papúa Nueva Guinea</option>
                    <option value="PY">Paraguay</option>
                    <option value="NL">Países Bajos</option>
                    <option value="PE">Perú</option>
                    <option value="PN">Pitcairn</option>
                    <option value="PF">Polinesia Francesa</option>
                    <option value="PL">Polonia</option>
                    <option value="PT">Portugal</option>
                    <option value="PR">Puerto Rico</option>
                    <option value="QA">Qatar</option>
                    <option value="HK">Región Administrativa Especial de Hong Kong de la República Popular China</option>
                    <option value="MO">Región Administrativa Especial de Macao de la República Popular China</option>
                    <option value="ZZ">Región desconocida o no válida</option>
                    <option value="GB">Reino Unido</option>
                    <option value="CF">República Centroafricana</option>
                    <option value="CZ">República Checa</option>
                    <option value="CD">República Democrática del Congo</option>
                    <option value="DO">República Dominicana</option>
                    <option value="RE">Reunión</option>
                    <option value="RW">Ruanda</option>
                    <option value="RO">Rumanía</option>
                    <option value="RU">Rusia</option>
                    <option value="WS">Samoa</option>
                    <option value="AS">Samoa Americana</option>
                    <option value="BL">San Bartolomé</option>
                    <option value="KN">San Cristóbal y Nieves</option>
                    <option value="SM">San Marino</option>
                    <option value="MF">San Martín</option>
                    <option value="PM">San Pedro y Miquelón</option>
                    <option value="VC">San Vicente y las Granadinas</option>
                    <option value="SH">Santa Elena</option>
                    <option value="LC">Santa Lucía</option>
                    <option value="ST">Santo Tomé y Príncipe</option>
                    <option value="SN">Senegal</option>
                    <option value="RS">Serbia</option>
                    <option value="CS">Serbia y Montenegro</option>
                    <option value="SC">Seychelles</option>
                    <option value="SL">Sierra Leona</option>
                    <option value="SG">Singapur</option>
                    <option value="SY">Siria</option>
                    <option value="SO">Somalia</option>
                    <option value="LK">Sri Lanka</option>
                    <option value="SZ">Suazilandia</option>
                    <option value="ZA">Sudáfrica</option>
                    <option value="SD">Sudán</option>
                    <option value="SE">Suecia</option>
                    <option value="CH">Suiza</option>
                    <option value="SR">Surinam</option>
                    <option value="SJ">Svalbard y Jan Mayen</option>
                    <option value="EH">Sáhara Occidental</option>
                    <option value="TH">Tailandia</option>
                    <option value="TW">Taiwán</option>
                    <option value="TZ">Tanzania</option>
                    <option value="TJ">Tayikistán</option>
                    <option value="IO">Territorio Británico del Océano Índico</option>
                    <option value="TF">Territorios Australes Franceses</option>
                    <option value="TL">Timor Oriental</option>
                    <option value="TG">Togo</option>
                    <option value="TK">Tokelau</option>
                    <option value="TO">Tonga</option>
                    <option value="TT">Trinidad y Tobago</option>
                    <option value="TM">Turkmenistán</option>
                    <option value="TR">Turquía</option>
                    <option value="TV">Tuvalu</option>
                    <option value="TN">Túnez</option>
                    <option value="UA">Ucrania</option>
                    <option value="UG">Uganda</option>
                    <option value="UY">Uruguay</option>
                    <option value="UZ">Uzbekistán</option>
                    <option value="VU">Vanuatu</option>
                    <option value="VE">Venezuela</option>
                    <option value="VN">Vietnam</option>
                    <option value="WF">Wallis y Futuna</option>
                    <option value="YE">Yemen</option>
                    <option value="DJ">Yibuti</option>
                    <option value="ZM">Zambia</option>
                    <option value="ZW">Zimbabue</option>
                  </select>
                </li>
                <li id="li_phone">
                  <label for="phone">Teléfono</label>
                  <input class="text invalid" type="text" id="phone" name="telefono" value="'. $telefono.'" autocomplete="tel">
                </li>
              </ul> 
			  <ul>
                <li id="li_special_requests">
                  <label for="special_requests">Peticiones especiales</label>
                  <textarea class="textarea" id="special_requests" name="observaciones" rows="4" cols="20"></textarea>
                </li>
              </ul>
			  <h2>Datos de Pago</h2>
			  <div id="payment-methods">
                  <div id="info_creditCard">
                    <div>
                      <p>Complete y compruebe cuidadosamente todos los campos. Recuerde que toda la información se transmite de forma segura. Su reserva quedará confirmada una vez efectuemos el cobro en su tarjeta en las próximas horas.</p>
                      <ul>
                        <li>
                          <label for="cc_owner">Titular de la Tarjeta</label>
                          <input class="text cc_owner invalid" type="text" id="cc_owner" name="titularTarjeta" value="" autocomplete="cc-name">
                        </li>
                        <li class="cc_wrapper">
                          <label class="cc_item_type">Tipo de tarjeta</label>
                          <select class="cc_type text" id="cc_type" name="tipoTarjeta" autocomplete="cc-type" >
                            <option value="visa" selected="selected">
																	VISA / VISA Electron
																</option>
                            <option value="mastercard">
																	MasterCard
																</option>
                            <option value="amex">
																	American Express
																</option>
                          </select>
                        </li>
                        <li>
                          <label for="cc_number">Número de tarjeta</label>
                          <input class="text cc_number invalid" type="text" id="cc_number" name="numTarjeta" maxlength="20" value="" autocomplete="off">
                        </li>
                        <li>
                          <label for="cc_expiry_month">Fecha caducidad</label>
                          <select class="cc_expiry numeric invalid" id="cc_expiry_month" name="caducidadMesTarjeta" autocomplete="off" >
                            <option value="">&nbsp;</option>
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">06</option>
                            <option value="07">07</option>
                            <option value="08">08</option>
                            <option value="09">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                          </select>
                          <select class="cc_expiry numeric invalid" id="cc_expiry_year" name="caducidadAnioTarjeta" autocomplete="off">
                            <option value="">&nbsp;</option>
                            <option value="2016">2016</option>
                            <option value="2017">2017</option>
                            <option value="2018">2018</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                            <option value="2027">2027</option>
                            <option value="2028">2028</option>
                            <option value="2029">2029</option>
                            <option value="2030">2030</option>
                            <option value="2031">2031</option>
                          </select>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <span class="cards">
                    <ul>
                      <li class="electron">VISA Electron</li>
                      <li class="visa">VISA</li>
                      <li class="mastercard">MasterCard</li>
                      <li class="amex">American Express</li>
                    </ul>
                  </span>
                </div>
				<input type="submit" class="boton color1 boton_link" value="CONTINUAR" />
		</form>';
	}
	function muestraPaso3(){
				echo'
				<form id="resumen" action="controladorReservas.php" method="POST">
						<input type="hidden" value="4" name="paso" />
						<h2>Resumen de su Reserva</h2>
						<div>
							<h3>Fechas</h3>
							<div class="relleno-fecha">
							<span>Fecha Entrada : '. $this->reserva->getCheckIn().'</span><span>Fecha Salida : '. $this->reserva->getCheckOut().'</span>
							</div>
							<ul id="resumen-reserva">
								<li class="head">
									<div class="col1r"><span>Habitación</span></div>
									<div class="col2r"><span>Cantidad</span></div>
									<div class="col3r"><span>Regimen</span></div>
									<div class="col4r"><span>Precio</span></div>
								</li>';
								
								$checkin = DateTime::createFromFormat('d/m/Y',$this->reserva->getCheckIn());
								$checkout = DateTime::createFromFormat('d/m/Y',$this->reserva->getCheckOut());
								
								$dif = date_diff($checkout,$checkin);
								$dias = $dif->format("%a");
								$total=0;
								$cantidad=array();
								$lineasReserva = $this->reserva->getLineasReserva();
								$cantidad = array_fill(0,count($lineasReserva),0);
								$cont=0;
								$j=0;
								
								if(isset($lineasReserva)){
									$anteriorR=$lineasReserva[0]->getRegimen()->getId();
									$anteriorT=$lineasReserva[0]->getTipo()->getId();
									while($j<count($lineasReserva)){
										if($lineasReserva[$j]->getRegimen()->getId()==$anteriorR && $lineasReserva[$j]->getTipo()->getId()==$anteriorT)
										{
											$cantidad[$cont]++;
											$j++;
										}else{
											$cont++;
											$anteriorR=$lineasReserva[$j]->getRegimen()->getId();
											$anteriorT=$lineasReserva[$j]->getTipo()->getId();
										}
									}
									$anteriorR="";
									$anteriorT="";
									$h=0;
									for($i=0;$i<count($lineasReserva);++$i)
									{
										if(($anteriorR=="" || $anteriorT=="") || ($lineasReserva[$i]->getRegimen()->getId()!=$anteriorR || $lineasReserva[$i]->getTipo()->getId()!=$anteriorT)){
											$precioLinea= $lineasReserva[$i]->getTipo()->getPrecio()+($lineasReserva[$i]->getRegimen()->getPrecio()*$dias) ;
											$total += $precioLinea*$cantidad[$h];
											echo '<li class="relleno-lineareserva">';
											echo '<div class="col1r"><span>' .$lineasReserva[$i]->getTipo()->getNombre().'</span></div>';
											echo '<div class="col2r"><span>'.$cantidad[$h++].'</span></div>';
											echo '<div class="col3r"><span>'. $lineasReserva[$i]->getRegimen()->getNombre() .'</span></div>';	
											echo '<div class="col4r"><span>'.$precioLinea .'</span></div>';	
											echo '</li>';
											$anteriorR=$lineasReserva[$i]->getRegimen()->getId();
											$anteriorT=$lineasReserva[$i]->getTipo()->getId();
										}
									}
								}
								echo '
							</ul>
						</div>
						<div id="total">Total: <div id="total-reserva">'.$total.'€</div></div>
						
						<h2>Resumen de sus Datos</h2>
						<div>
							<ul id="resumen-datos">
								<li><label>Nombre:</label> <label>'. $this->cliente->getNombre(). '</label></li>
								<li><label>Teléfono:</label> <label>'. $this->cliente->getTelefono(). '</label></li>
								<li><label>E-mail:</label> <label>'. $this->cliente->getEmail().'</label></li>
							</ul>
						</div>
						<input type="submit" class="boton color1 boton_link" value="CONFIRMAR" />
		</form>';
	}
	function muestraPaso4(){
		echo '<h2>Reserva Confirmada</h2>
			<p>En breve recibirá un email de confirmación con todos los datos, vaya a recepción del hotel y diga su nombre para confirmar su reserva</p>';
	}
}
?>