<?php
class Contenido{
	private $descripcion;
	private $servicios;
	private $galeria;
	private $habitacion;
	private $promo;
	private $opinion;
	private $localizacion;
	
	function __construct($descripcion=null, $servicios=null, $galeria=null, $habitacion=null, $promo=null ,$opinion=null, $localizacion=null){
		$this->descripcion = $descripcion;
		$this->servicios = $servicios;
		$this->galeria = $galeria;
		$this->habitacion = $habitacion;
		$this->promo = $promo;
		$this->opinion = $opinion;
		$this->localizacion = $localizacion;
	}
	//Descripcion
	public function getDescripcionT()
	{
		return $this->descripcion["titulo"];
	}
	
	public function getDescripcionC()
	{
		return $this->descripcion["contenido"];
	}
	
	public function getDescripcionI()
	{
		return $this->descripcion["imagen"];
	}
	//Servicios
	public function getServiciosT()
	{
		return $this->servicios["titulo"];
	}
	
	public function getServicios()
	{
		return $this->servicios["lista"];
	}
	//Habitaciones
	public function getHabitacion()
	{
		return $this->habitacion["habits"];
	}
	public function getHabitacionT()
	{
		return $this->habitacion["titulo"];
	}
	public function getHabitacionB()
	{
		return $this->habitacion["boton"];
	}
	//Galeria
	public function getGaleria()
	{
		return $this->galeria;
	}
	public function getGaleriaT()
	{
		return $this->galeria["titulo"];
	}
	//Promociones
	public function getPromo()
	{
		return $this->promo["promos"];
	}
	public function getPromoT()
	{
		return $this->promo["titulo"];
	}
	public function getPromoB()
	{
		return $this->promo["boton"];
	}
	//Opiniones
	public function getOpinion()
	{
		return $this->opinion["opiniones"];
	}
	public function getOpinionT()
	{
		return $this->opinion["titulo"];
	}
	public function getOpinionNombre()
	{
		return $this->opinion["nombre"];
	}
	public function getOpinionLugar()
	{
		return $this->opinion["lugar"];
	}
	public function getOpinionFecha()
	{
		return $this->opinion["fecha"];
	}
	public function getOpinionComentario()
	{
		return $this->opinion["comentario"];
	}
	public function getOpinionLimpieza()
	{
		return $this->opinion["limpieza"];
	}
	public function getOpinionAtencion()
	{
		return $this->opinion["atencion"];
	}
	public function getOpinionConfort()
	{
		return $this->opinion["confort"];
	}
	public function getOpinionUbicacion()
	{
		return $this->opinion["ubicacion"];
	}
	public function getOpinionInstalaciones()
	{
		return $this->opinion["instalaciones"];
	}
	public function getOpinionDesayuno()
	{
		return $this->opinion["desayuno"];
	}
	public function getOpinionTotal()
	{
		return $this->opinion["total"];
	}
	//Localizacion
	public function getLocalizacion()
	{
		return $this->localizacion;
	}
	public function getLocalizacionT()
	{
		return $this->localizacion["titulo"];
	}
}
?>