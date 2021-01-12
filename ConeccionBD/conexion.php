<?php 
	class Db{
		private static $conexion=null;
		private function __construct(){}

		public static function conectar(){
			$pdo_options[PDO::ATTR_ERRMODE]=PDO::ERRMODE_EXCEPTION;
			
			//coneccion local
			//self::$conexion=new PDO('mysql:host=localhost;dbname=tesis','root','',$pdo_options);
						
			//coneccion a servidor de pruebas bd clever cloud
			self::$conexion=new PDO('mysql:host=bpopjxgh19ams8bq1vn7-mysql.services.clever-cloud.com;
			dbname=bpopjxgh19ams8bq1vn7',
			'ung6dsqxitu3s8fi','IjUDwNmG4tAkaoU28YmC',$pdo_options);


			
			return self::$conexion;
		}
	}
?>