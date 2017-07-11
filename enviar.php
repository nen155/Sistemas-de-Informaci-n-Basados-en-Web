<?php
date_default_timezone_set("Europe/Madrid");
include ('funciones/funciones.php');
if(isset($_POST["email"]) && validarCorreo($_POST["email"]) ){
	include("correo/class.phpmailer.php");
	include("correo/class.smtp.php");
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
	$mail -> FromName = $_POST["nombre"] . $_POST["apellidos"];
	$mail -> Subject = "Contacto";
	$mail -> AltBody = "Este es un mensaje de prueba";
	$mail -> MsgHTML($_POST["mensaje"]);
	$mail -> AddAddress($_POST["email"], "Destinatario");
	$mail -> AddBCC("emiliocj@correo.ugr.es"); // Copia oculta 
	$mail -> IsHTML(true);
	if (!$mail -> Send()){
		echo "Error: " . $mail -> ErrorInfo;
	}else {
		header("Location:index.php?seccion=contacto&lang=".$_POST["idioma"]."&enviado=true");
	}
}else{
	header("Location:index.php?seccion=contacto&lang=".$_POST["idioma"]."&enviado=false");
}
?>