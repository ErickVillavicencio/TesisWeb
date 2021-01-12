<?php 

	class Ruta{
        private $id;
        private $nombre;
        private $horaInicio ; 
        private $horaFin;
        private $costoTotal;
		private $idUsuario;
		private $numeroAdultos;
		private $numeroNinios;
    
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
        
        public function getHoraInicio(){
			return $this->horaInicio;
		}

		public function setHoraInicio($horaInicio){
			$this->horaInicio = $horaInicio;
        }
        
        public function getHoraFin(){
			return $this->horaFin;
		}

		public function setHoraFin($horaFin){
			$this->horaFin = $horaFin;
        }
        
        public function getCostoTotal(){
			return $this->costoTotal;
		}

		public function setCostoTotal($costoTotal){
			$this->costoTotal = $costoTotal;
        }
		

		public function getNumeroAdultos(){
			return $this->numeroAdultos;
		}

		public function setNumeroAdultos($numeroAdultos){
			$this->numeroAdultos = $numeroAdultos;
		}
		
		public function getNumeroNinios(){
			return $this->numeroNinios;
		}

		public function setNumeroNinios($numeroNinios){
			$this->numeroNinios = $numeroNinios;
        }


        public function getIdUsuario(){
			return $this->idUsuario;
		}

		public function setIdUsuario($idUsuario){
			$this->idUsuario = $idUsuario;
		}

    }
    ?>