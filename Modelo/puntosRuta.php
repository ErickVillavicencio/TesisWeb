<?php 

	class PuntosRuta{ 
		private $id;
		private $idPunto;
        private $idRuta;

		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
		}

		public function getIdPunto(){
			return $this->idPunto;
		}

		public function setIdPunto($idPunto){
			$this->idPunto = $idPunto;
		}
        
        public function getIdRuta(){
			return $this->idRuta;
		}

		public function setIdRuta($idRuta){
			$this->idRuta = $idRuta;
        }
       
    }
    ?>