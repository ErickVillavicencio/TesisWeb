<?php 
	require_once('../ConeccionBD/conexion.php');
	require_once('../Modelo/subCategoria.php');
	
	class CrudSubCategoria{

		public function __construct(){}

		//inserta los datos de la categoria
		public function insertar($subCategoria){
			$db=DB::conectar();
			$insert=$db->prepare('INSERT INTO subcategoria (descripcion, idCategoria, estado) 
			VALUES(:descripcion ,:idCategoria , 1)');
			$insert->bindValue('descripcion',$subCategoria->getDescripcion());
			$insert->bindValue('idCategoria',$subCategoria->getidCategoria());
			$insert->execute();					
		}

		//busca el nombre de la sub categoria si existe
		public function buscarSubCategoria($descripcion){
			$db=Db::conectar();
			$select=$db->prepare('SELECT * FROM subcategoria WHERE descripcion=:descripcion');
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

				//actualiza los datos de la sucategoria
				public function actualizar($subCategoria){
					$db=DB::conectar();
                    $update=$db->prepare('UPDATE subcategoria SET descripcion = :descripcion , idCategoria = :idCategoria
					 WHERE id = :id;');
                    $update->bindValue('id',$subCategoria->getId());
					$update->bindValue('descripcion',$subCategoria->getDescripcion());
					$update->bindValue('idCategoria',$subCategoria->getidCategoria());
					$update->execute();	
				}
				//Eliminar los datos de la categoria
				public function eliminar($subCategoria){
					$db=DB::conectar();
					$update=$db->prepare('UPDATE subcategoria SET estado = 0 WHERE id = :id;');
					$update->bindValue('id',$subCategoria->getId());
					$update->execute();	
					
				}

								//Activar los datos de la categoria
								public function activar($subCategoria){
									$db=DB::conectar();
									$update=$db->prepare('UPDATE subcategoria SET estado = 1 WHERE id = :id;');
									$update->bindValue('id',$subCategoria->getId());
									$update->execute();	
									
								}

}
?>