<?php 
	require_once('../ConeccionBD/conexion.php');
	require_once('../Modelo/parroquia.php');
	
	class crudParroquia{

		public function __construct(){}

		//inserta los datos del usuario
		public function insertar($parroquia){
			$db=DB::conectar();
			$insert=$db->prepare('INSERT INTO parroquia (descripcion, latitud, longuitud, estado) 
			VALUES(:descripcion, :latitud, :longuitud,1)');
			$insert->bindValue('descripcion',$parroquia->getDescripcion());
			$insert->bindValue('latitud',$parroquia->getLatitud());
			$insert->bindValue('longuitud',$parroquia->getLonguitud());
			$insert->execute();					
		}

		//busca el nombre del usuario si existe
		public function buscarParroquia($descripcion){
			$db=Db::conectar();
			$select=$db->prepare('SELECT * FROM parroquia WHERE descripcion=:descripcion');
			$select->bindValue('descripcion',$descripcion);
			$select->execute();
			$registro=$select->fetch();
			if($registro['id']!=NULL){
				$usado=False;
			}else{
				$usado=True;
			}	
			return $usado;
		}

				//actualiza los datos del usuario
				public function actualizar($parroquia){
					$db=DB::conectar();
					$update=$db->prepare('UPDATE parroquia SET descripcion = :descripcion , latitud = :latitud 
					, longuitud = :longuitud WHERE id = :id;');
					$update->bindValue('id',$parroquia->getId());
					$update->bindValue('descripcion',$parroquia->getDescripcion());
					$update->bindValue('latitud',$parroquia->getLatitud());
					$update->bindValue('longuitud',$parroquia->getLonguitud());
					$update->execute();	
				}
				//Eliminar los datos del usuario
				public function eliminar($parroquia){
					$db=DB::conectar();
					$update=$db->prepare('UPDATE parroquia SET estado = 0 WHERE id = :id;');
					$update->bindValue('id',$parroquia->getId());
					$update->execute();	
					
				}
								//Activar los datos del usuario
								public function activar($parroquia){
									$db=DB::conectar();
									$update=$db->prepare('UPDATE parroquia SET estado = 1 WHERE id = :id;');
									$update->bindValue('id',$parroquia->getId());
									$update->execute();	
									
								}
				

}
?>