<?php 
	require_once('../ConeccionBD/conexion.php');
	require_once('../Modelo/rol.php');
	
	class CrudRol{

		public function __construct(){}

		//inserta los datos del rol
		public function insertar($rol){
			$db=DB::conectar();
			$insert=$db->prepare('INSERT INTO rol (descripcion , estado) 
			VALUES(:descripcion , 1)');
			$insert->bindValue('descripcion',$rol->getDescripcion());
			$insert->execute();					
		}

		//busca el nombre del rol si existe
		public function buscarRol($descripcion){
			$db=Db::conectar();
			$select=$db->prepare('SELECT * FROM rol WHERE descripcion=:descripcion');
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

				//actualiza los datos del rol
				public function actualizar($rol){
					$db=DB::conectar();
                    $update=$db->prepare('UPDATE rol SET descripcion = :descripcion WHERE id = :id;');
                    $update->bindValue('id',$rol->getId());
					$update->bindValue('descripcion',$rol->getDescripcion());
					$update->execute();	
				}
				//Eliminar los datos del rol
				public function eliminar($rol){
					$db=DB::conectar();
					$update=$db->prepare('UPDATE rol SET estado = 0 WHERE id = :id;');
					$update->bindValue('id',$rol->getId());
					$update->execute();	
					
				}

								//activar los datos del rol
								public function activar($rol){
									$db=DB::conectar();
									$update=$db->prepare('UPDATE rol SET estado = 1 WHERE id = :id;');
									$update->bindValue('id',$rol->getId());
									$update->execute();	
									
								}

}
?>