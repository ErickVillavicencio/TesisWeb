<?php 

	class Usuario{
		private $id;
		private $nombres;
		private $apellidos;
		private $usuario;
		private $clave;
		private $correo;
		private $idRol;

		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
		}

		public function getNombres(){
			return $this->nombres;
		}

		public function setNombres($nombres){
			$this->nombres = $nombres;
		}

		public function getApellidos(){
			return $this->apellidos;
		}

		public function setApellidos($apellidos){
			$this->apellidos = $apellidos;
		}

		public function getUsuario(){
			return $this->usuario;
		}

		public function setUsuario($usuario){
			$this->usuario = $usuario;
		}

		public function getClave(){
			return $this->clave;
		}

		public function setClave($clave){
			$this->clave = $clave;
		}

		public function getCorreo(){
			return $this->correo;
		}

		public function setCorreo($correo){
			$this->correo = $correo;
		}

		public function getRol(){
			return $this->idRol;
		}

		public function setRol($rol){
			$this->idRol = $rol;
		}

	}
?>