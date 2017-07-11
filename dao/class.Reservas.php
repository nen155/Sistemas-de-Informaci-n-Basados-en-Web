<?php
class Reservas{
	private $bd;
	
	function __construct($bd){
		$this->bd=$bd;
	}
	
	function comprobarReserva($reserva){
		$checkIn = $reserva->getCheckIn();
		$checkOut = $reserva->getCheckOut();
		echo '<?xml version="1.0" encoding="utf-8"?>';
        echo '<habitaciones>';
		$this->bd->setConsulta("SELECT t.id,t.nombre,t.descripcion,t.numPersonas,(SELECT t.numTotalHab - (count(l.id)) FROM 
						reserva as r INNER JOIN lineareserva as l 
						ON r.id=l.id_reserva  
						WHERE l.id_tipo=t.id AND r.cancelada=0 AND (r.checkout between STR_TO_DATE('$checkIn','%d/%m/%Y') and STR_TO_DATE('$checkOut','%d/%m/%Y') OR 
						r.checkin between STR_TO_DATE('$checkIn','%d/%m/%Y') AND STR_TO_DATE('$checkOut','%d/%m/%Y')) ) as diponibles 
						FROM tipo t 
						group by t.id");
			
		while ($fila = $this->bd->getFila()){
			echo "<habitacion>";
			$precio = $this->getPrecioTotal($fila[0],$reserva);
			echo "<id>". $fila[0] ."</id>";
			echo "<nombre>". $fila[1] ."</nombre>";
			echo "<descripcion>". $fila[2] ."</descripcion>";
			echo "<ocupacionMaxima>". $fila[3] ."</ocupacionMaxima>";
			echo "<numHabDisponibles>". $fila[4] ."</numHabDisponibles>";
			echo "<precioTotal>". $precio ."</precioTotal>";
			echo "</habitacion>";
		}
			echo '<regimenes>';
			$regimen = new Regimenes($this->bd);
			$regimenes = $regimen->getRegimenes();
			for($i = 0; $i<count($regimenes); $i++){
				echo "<regimen>";
				echo "<id>". $regimenes[$i]->getId() ."</id>";
				echo "<nombre>". $regimenes[$i]->getNombre() ."</nombre>";
				echo "<precio>". $regimenes[$i]->getPrecio() ."</precio>";
				echo "</regimen>";
			}
			echo '</regimenes>';
		echo '</habitaciones>';
	}
	
	function getPrecioTotal($id_tipo,$reserva){
		$checkin = DateTime::createFromFormat('d/m/Y',$reserva->getCheckIn());
		$checkout = DateTime::createFromFormat('d/m/Y',$reserva->getCheckOut());
		
		$dif = date_diff($checkout,$checkin);
		$fecha = $checkin;
		$total = 0;
		$max = $dif->format("%a");
		for($i = 0; $i<$max; $i++){
			
			$this->bd->setSubConsulta("select t.precio, (select porcentaje from precio p WHERE p.id_tipo=t.id AND '".$fecha->format('Y-m-d')."' between fechainicio and fechafin) as porcentaje from tipo t WHERE t.id=".$id_tipo);
			$fecha->add(new DateInterval("P1D"));
			$fila = $this->bd->getSubFila();
			$total += $fila[0]+$fila[1];
		}
		return $total;
	}
	
	function getReservasBD(){
		$this->bd->setConsulta("select * from reservas");
		$reservas = array();
		$i=0;
		while ($fila = $this->bd->getFila()){
			$reservas[$i] = new Reserva($fila[0], $fila[1], $fila[2], $fila[3], $fila[4], $fila[5], $fila[6], $fila[7]);
			$i++;
		}
		return $reservas;
	}
	
	function setCancelado($id_reserva, $estado){
		$this->bd->setConsulta("update reserva SET cancelada=$estado where id_reserva=$id_reserva");
	}
	
	function addReserva($reserva){
		$checkin=$reserva->getCheckIn();
		$checkout=$reserva->getCheckOut();
		$observaciones=$reserva->getObservaciones();
		$cancelada=$reserva->getCancelada();
		$numPersonas=$reserva->getNumPersonas();
		$idCliente = $reserva->getCliente();
		if(!isset($checkin)) 
		 $checkin="";
		if(!isset($checkout)) 
		 $checkout="";
		 if(!isset($observaciones)) 
		 $observaciones="NULL";
		 if(!isset($cancelada)) 
		 $cancelada="0";
		  if(!isset($numPersonas)) 
		 $numPersonas="1";
		 if(!isset($idCliente)) 
		 $idCliente="0";
		$this->bd->setConsulta("insert into `reserva` (`id`, `checkin`, `checkout`, `observaciones`, `cancelada`, `numPersonas`, `id_cliente`) values (NULL, STR_TO_DATE('". $checkin  ."','%d/%m/%Y'), STR_TO_DATE('".$checkout."','%d/%m/%Y'),". $observaciones.",". $cancelada.",". $numPersonas.",". $idCliente.")");
		$idReserva = $this->bd->getLastId();
		foreach($reserva->getLineasReserva() as $linea){
			$this->bd->setConsulta("insert into `lineareserva` (`id`,`id_regimen`, `id_tipo`, `numHab`,`id_reserva`)  values(NULL,".$linea->getRegimen()->getId().",".$linea->getTipo()->getId().",0,".$idReserva.")");
		}
	}
	function udpateLineaReserva($id_reserva,$id_tipo,$id_regimen,$numHab){
		$this->bd->setConsulta("update lineareserva SET numHab=".$numHab." where id_reserva=".$id_reserva. " AND id_tipo=".$id_tipo." AND id_regimen=".$id_regimen);
	}

}
?>