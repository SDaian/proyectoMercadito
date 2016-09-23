<?php 
	namespace clases;

	class producto{
		private $id;
		private $idCategoria;
		private $idUsuario;
		private $nombre;
		private $descripcion;
		private $precio;
		private $publicacion;
		private $caducidad;
		private $contenidoimagen;
		private $tipoimagen;


		public function setContenidoImagen($contenidoimagen){
			$this->contenidoimagen = $contenidoimagen;
		}
		public function setTipoImagen($tipoimagen){
			$this->tipoimagen = $tipoimagen;
		}
		public function getContenidoImagen(){
			return $this->contenidoimagen;
		}
		public function getTipoImagen(){
			return $this->tipoimagen;
		}
		public function getDescripcion(){
			return $this->descripcion;
		}
		public function setDescripcion($descripcion){
			$this->descripcion = $descripcion;
		}


		public function setId($id){
			$this->id = $id;
		}
		public function getId(){
			return $this->id;
		}

		public function setIdCategoria($idCategoria){
			$this->idCategoria = $idCategoria;}
		public function getIdCategoria(){
			return $this->idCategoria;
		}

		public function setIdUsuario($idUsuario){
			$this->idUsuario = $idUsuario;
		}
		public function getIdUsuario(){
			return $this->idUsuario;
		}

		public function setNombre($nombre){
			$this->nombre = $nombre;
		}
		public function getNombre(){
			return $this->nombre;
		}

		public function setPrecio($precio){
			$this->precio = $precio;
		}

		public function getPrecio(){
			return $this->precio;
		}

		public function setCaducidad($caducidad){
			$this->caducidad = $caducidad;
		}
		public function getCaducidad(){
			return $this->caducidad;
		}

		public function setPublicacion($publicacion){
			$this->publicacion = $publicacion;
		}
		public function getPublicacion(){
			return $this->publicacion;
		}

	}


 ?>