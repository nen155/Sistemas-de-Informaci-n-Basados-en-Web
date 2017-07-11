<?php
include_once ('funciones/funciones.php');
include_once("correo/class.phpmailer.php");
include_once("correo/class.smtp.php");
date_default_timezone_set("Europe/Madrid");
class EnvioEmail{
	private $reserva;
	private $cliente;
	private $mensaje;
	
	function __construct($reserva=null,$cliente=null){
		$this->cliente=$cliente;
		$this->reserva=$reserva;	
	}
	function enviaEmail(){
		$email_c = $this->cliente->getEmail();
		$this->crearMensaje();
		if(isset($email_c) && validarCorreo($email_c) ){
			
			$mail = new PHPMailer();
			//$mail -> isSendMail();
			$mail -> IsSMTP();
			$mail -> SMTPAuth = true;
			$mail -> SMTPSecure = "ssl";
			$mail -> Host = "smtp.gmail.com";
			$mail -> Port = 465;
			$mail -> Username = "theatrumcinema@gmail.com";
			$mail -> Password = "modesuperprofe";
			$mail -> From = "theatrumcinema@gmail.com";
			$mail -> FromName = $this->cliente->getNombre() . $this->cliente->getApellidos();
			$mail -> Subject = "Reserva Confirmada";
			$mail -> AltBody = "Su reserva ha sido realizada correctamente";
			$mail -> MsgHTML($this->mensaje);
			$mail -> AddAddress($this->cliente->getEmail(), "Destinatario");
			$mail -> AddBCC("emiliocj@correo.ugr.es"); // Copia oculta 
			$mail -> IsHTML(true);
			if (!$mail -> Send()){
				echo "Error: " . $mail -> ErrorInfo;
			}else {
				
			}
		}else{
			
		}
	}
	function crearMensaje(){
		$this->mensaje = '<h2>Resumen de su Reserva</h2>
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
											$this->mensaje = $this->mensaje. '<li class="relleno-lineareserva">';
											$this->mensaje = $this->mensaje. '<div class="col1r"><span>' .$lineasReserva[$i]->getTipo()->getNombre().'</span></div>';
											$this->mensaje = $this->mensaje. '<div class="col2r"><span>'.$cantidad[$h++].'</span></div>';
											$this->mensaje = $this->mensaje. '<div class="col3r"><span>'. $lineasReserva[$i]->getRegimen()->getNombre() .'</span></div>';	
											$this->mensaje = $this->mensaje. '<div class="col4r"><span>'.$precioLinea .'</span></div>';	
											$this->mensaje = $this->mensaje. '</li>';
											$anteriorR=$lineasReserva[$i]->getRegimen()->getId();
											$anteriorT=$lineasReserva[$i]->getTipo()->getId();
										}
									}
								}
								$this->mensaje = $this->mensaje. '
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
						</div>';
	}
}
?>