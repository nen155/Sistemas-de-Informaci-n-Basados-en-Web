<?php
class ControladorSidebar{
	private $bd = null;
	private $lang;
	private $seccion;
	function __construct($bd,$lang,$sec) {
        $this->bd = $bd;
		$this->lang = $lang;
		$this->seccion = $sec;
	}
	function mostrarSidebar(){
		$habs = false;
		$promos = false;
		$selec = array(0 => '', 1 => '', 2 => '');
		switch($this->seccion)
		{
				case "habitaciones":
					$habs = true;
					break;
				case "promociones":
					$promos = true;
					break;
				case "promo_sierra":
					$selec[0]='> ';
					$promos = true;
					break;
				case "promo_alhambra":
					$selec[1]='> ';
					$promos = true;
					break;
				case "promo_noches":
					$selec[2]='> ';
					$promos = true;
					break;
				case "hab_doble":
					$selec[0]='> ';
					$habs = true;
					break;
				case "hab_doble_sup":
					$selec[1]='> ';
					$habs = true;
					break;
				case "hab_triple":
					$selec[2]='> ';
					$habs = true;
					break;
		}
		if($habs){
			$habitacion = $this->bd["habitaciones"];
			echo'
			<div id="sidebar">
				<h3>'.$habitacion["titulo"].'</h3>';
			$i=0;
			foreach($habitacion["habs"] as $item){
				echo'<a href="'.$item["link"].'&?lang='.$this->lang.'" class="siderbar_text">'.$selec[$i].''.$item["titulo"].'</a>
				';
				$i = $i + 1;
			}
			echo'</div>';
		}else{
			$promocion = $this->bd["promociones"];
			echo'
			<div id="sidebar">
				<h3>'.$promocion["titulo"].'</h3>';
			$i=0;
			foreach($promocion["promos"] as $item){
				echo'<a href="'.$item["link"].'&?lang='.$this->lang.'" class="siderbar_text">'.$selec[$i].''.$item["titulo"].'</a>
				';
				$i = $i + 1;
			}
			echo'</div>';
		}
	}
}
?>