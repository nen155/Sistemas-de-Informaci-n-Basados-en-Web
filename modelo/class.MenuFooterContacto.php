<?php
class MenuFooterContacto{
				private $menu;
				private $titulos;
				private $titulosContact;
                
                function __construct($menu=null,$titulos=null,$titulosContact=null) {
                    $this->menu = $menu;
					$this->titulos=$titulos;
					$this->titulosContact=$titulosContact;
                }
				
                public function getMenu() {
                    return $this->menu;
                }

                public function setMenu($menu) {
                    $this->menu = $menu;
                }
				 public function getTitulos() {
                    return $this->titulos;
                }

                public function setTitulos($titulos) {
                    $this->titulos = $titulos;
                }
				 public function getTitulosContact() {
                    return $this->titulosContact;
                }

                public function setTitulosContact($titulosContact) {
                    $this->titulosContact = $titulosContact;
                }
                
	}
?>