<?php 

	class Parroquia{
		private $id;
		private $descripcion;
        private $latitud;
        private $longuitud;
        private $estado;

		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
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
        
		public function getEstado(){
			return $this->estado;
		}

		public function setEstado($estado){
			$this->estado = $estado;
        }
    }
    ?>