<?php 

	class SubCategoria{
		private $id;
		private $descripcion;
        private $idCategoria;
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

		public function getidCategoria(){
			return $this->idCategoria;
		}

		public function setidCategoria($idCategoria){
			$this->idCategoria = $idCategoria;
		}

		public function getEstado(){
			return $this->estado;
		}

		public function setEstado($estado){
			$this->estado = $estado;
		}

	}
?>