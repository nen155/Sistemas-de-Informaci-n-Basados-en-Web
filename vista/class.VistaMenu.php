<?php
 include_once "modelo/class.MenuFooterContacto.php";
class VistaMenu	 {

	private $menu = null;
	private $lang;
    //constructor se le pasa el modelo menu
    function __construct($menu,$lang) {
		$this->menu = $menu;
		$this->lang = $lang;
    }
    function muestraMenu() {
		echo '<nav id="menu"><ul>';
			$itemsMenu=$this->menu->getMenu();
			//print_r(array_values($itemsMenu));
			foreach($itemsMenu as $item){
				echo '<li>';
				 echo '<a href="index.php?seccion='.$item["seccion"].'&lang='.$this->lang.'" class="enlacesmenu">'.$item["titulo_seccion"].'</a>';
				 	$submenu= $item["submenu"];
					//print_r(array_values($submenu));
					if(isset($submenu) && sizeof($submenu)>0){
						echo '<section class="submenu">';
							echo '<ul>';
							foreach($submenu as $itemSub){
								
										echo '<li>';
											echo '<div class="sec_menu">';
												echo '<img class="img_sec" src="'.$itemSub["imagen"].'" />';
												echo '<div class="titulo_sec"><p>'.$itemSub["titulo"].'</p></div>';
												echo '<a href="index.php?seccion='.$itemSub["seccion"].'&lang='.$this->lang.'" class="oferta_menu"></a>';
											echo '</div>';
										echo '</li>';
							}
						echo '</ul>';
						echo '</section>';
					}
				echo '</li>';
			}
				
		echo '</ul>';
		echo '</nav>';
    }
}

?>
