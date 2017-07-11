<?php
 include_once "modelo/class.MenuFooterContacto.php";
class VistaFooter {

	private $menu = null;
    //constructor se le pasa el footer relleno
    function __construct($menu) {
		$this->menu = $menu;
    }
    function muestraFooter() {
		$titulos = $this->menu->getTitulos();
		 echo '<!-- PIE -->
					<footer>
						<div class="three_columns">
							<div class="column1_three">
								<nav class="menu_footer">
									<h2 class="titulos_footer">'.$titulos["menu"].'</h2>
									<ul>';
									foreach($this->menu->getMenu() as $item){
											echo '<li>';
											 echo '<a href="?seccion='. $item["seccion"] .'" class="enlacesmenu">'.$item["titulo_seccion"].'</a>';
											 	$submenu= $item["submenu"];
												if(isset($submenu) && sizeof($submenu)>0){
													echo '<ul>';
														foreach($submenu as $itemSub){
															echo '<section class="submenu">';
																	echo '<li>';
																		echo '<div class="sec_menu">';
																			echo '<img class="img_sec" src="'.$itemSub["imagen"].'" />';
																			echo '<div class="titulo_sec"><p>'.$itemSub["titulo"].'</p></div>';
																			echo '<a href="?seccion='.$itemSub["seccion"].'" class="oferta_menu"></a>';
																		echo '</div>';
																	echo '</li>';
															echo '</section>';
														}
													echo '</ul>';
												}
											echo '</li>';
										}
											
									echo '</ul>';
									echo '</nav>';
									   
							echo '</div>';
							
							echo '<div class="column2_three">
								<div class="contact_footer">
									<h2 class="titulos_footer">'.$titulos["contacto"]["titulo"].'</h2>					
									<div itemscope="" itemtype="http://schema.org/Hotel"><span itemprop="name">Hotel Plaza Nueva</span></div>
										<ul itemprop="address" itemscope="" itemtype="http://schema.org/PostalAddress">
											<li>
												<span itemprop="streetAddress">Imprenta, nº 2. </span>
												<span itemprop="postalCode">18010 </span>
											   
											</li>
											<li>
												 <span itemprop="addressLocality">Granada, </span>
												<span>Granada, </span>
												<span itemprop="addressCountry">'.$titulos["contacto"]["pais"].'</span>
											</li>
											<li>
												<span itemprop="telephone"><a>'.$titulos["contacto"]["telefono"].': +34 958 215 273. </a></span>					 
											</li>
											<li>
												 <span itemprop="telephone"><a>'.$titulos["contacto"]["fax"].': +34 958 225 765</a></span>
											</li>
											<li class="mail" itemprop="email"><a href="mailto:info@hotel-plazanueva.com  ">info@hotel-plazanueva.com  </a></li>
										</ul>
								</div>
							</div>
							<div class="column3_three">
								<div class="mapa_footer">
									<h2 class="titulos_footer">'.$titulos["localizacion"].'</h2>
									<img style="float: left;height: 220px;" src="images/mapa.png" />
								</div>
							</div>
						</div>
					</footer>
				</div>
			<!-- /CUERPO DE LA PÁGINA -->
		 </body>';
    }
}

?>