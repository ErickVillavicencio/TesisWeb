<?php 

	class PuntoTuristico{
		private $id;
		private $nombre;
		private $descripcion;
        private $latitud;
		private $longuitud;
		private $creador;
		private $categoriaId;
		private $subCategoriaId;
		private $costo;
		private $costoN;
		private $idParroquia;
		private $tiempoEstimado;
		private $facebook;
		private $twitter;
		private $instagram;
        private $estado;

		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
		}

		public function getNombre(){
			return $this->nombre;
		}

		public function setNombre($nombre){
			$this->nombre = $nombre;
		}

		public function getDescripcion(){
			return $this->descripcion;
		}

		public function setDescripcion($descripcion){
			$this->descripcion = $descripcion;
		}
        
        public function getLatitud(){
			return $this->latitud;
		}

		public function setLatitud($latitud){
			$this->latitud = $latitud;
        }

		public function getLonguitud(){
			return $this->longuitud;
		}

		public function setLonguitud($longuitud){
			$this->longuitud = $longuitud;
		}
		
		public function setCreador($creador){
			$this->creador = $creador;
		}
		
        public function getCreador(){
			return $this->creador;
		} 

		public function setCategoriaId($categoriaId){
			$this->categoriaId = $categoriaId;
		}
		
        public function getCategoriaId(){
			return $this->categoriaId;
		} 
		
		public function setSubCategoriaId($subCategoriaId){
			$this->subCategoriaId = $subCategoriaId;
		}
		
        public function getSubCategoriaId(){
			return $this->subCategoriaId;
		} 

		public function setCosto($costo){
			$this->costo = $costo;
		}
		
        public function getCosto(){
			return $this->costo;
		}
		
		public function setCostoN($costoN){
			$this->costoN = $costoN;
		}
		
        public function getCostoN(){
			return $this->costoN; 
		}

		public function setIdParroquia($idParroquia){
			$this->idParroquia = $idParroquia;
		}
		
        public function getIdParroquia(){
			return $this->idParroquia;
		} 

		public function setTiempoEstimado($tiempoEstimado){
			$this->tiempoEstimado = $tiempoEstimado;
		}
		
        public function getTiempoEstimado(){
			return $this->tiempoEstimado;
		} 

		public function setFacebook($facebook){
			$this->facebook = $facebook;
		}
		
        public function getFacebook(){
			return $this->facebook;
		} 

		public function setTwitter($twitter){
			$this->twitter = $twitter;
		}
		
        public function getTwitter(){
			return $this->twitter;
		} 

		public function setInstagram($instagram){
			$this->instagram = $instagram;
		}
		
        public function getInstagram(){
			return $this->instagram;
		} 
	 
		public function getEstado(){
			return $this->estado;
		}

		public function setEstado($estado){
			$this->estado = $estado;
        }
    }
    ?>