<?php 

	class Imagen{
		private $id;
		private $nombre;
		private $direccion;
		private $extencion;
        private $idPuntoTuristico;
        private $categoria;

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
        
        public function getDireccion(){
			return $this->direccion;
		}

		public function setDireccion($direccion){
			$this->direccion = $direccion;
		}
		public function getExtencion(){
			return $this->extencion;
		}

		public function setExtencion($extencion){
			$this->extencion = $extencion;
        }


        public function getIdPuntoTuristico(){
			return $this->idPuntoTuristico;
		}

		public function setIdPuntoTuristico($idPuntoTuristico){
			$this->idPuntoTuristico = $idPuntoTuristico;
        }
        
		public function getCategoria(){
			return $this->categoria;
		}

		public function setCategoria($categoria){
			$this->categoria = $categoria;
        }
    }
    ?>