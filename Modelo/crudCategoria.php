<?php 
	require_once('../ConeccionBD/conexion.php');
	require_once('../Modelo/categoria.php');
	
	class CrudCategoria{

		public function __construct(){}

		//inserta los datos de la categoria
		public function insertar($categoria){
			$db=DB::conectar();
			$insert=$db->prepare('INSERT INTO categoria (descripcion , estado) 
			VALUES(:descripcion , 1)');
			$insert->bindValue('descripcion',$categoria->getDescripcion());
			$insert->execute();					
		}

		//busca el nombre de la parroquia si existe
		public function buscarCategoria($descripcion){
			$db=Db::conectar();
			$select=$db->prepare('SELECT * FROM categoria WHERE descripcion=:descripcion');
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

				//actualiza los datos de la categoria
				public function actualizar($categoria){
					$db=DB::conectar();
                    $update=$db->prepare('UPDATE categoria SET descripcion = :descripcion WHERE id = :id;');
                    $update->bindValue('id',$categoria->getId());
					$update->bindValue('descripcion',$categoria->getDescripcion());
					$update->execute();	
				}
				//Eliminar los datos de la categoria
				public function eliminar($categoria){
					$db=DB::conectar();
					$update=$db->prepare('UPDATE categoria SET estado = 0 WHERE id = :id;');
					$update->bindValue('id',$categoria->getId());
					$update->execute();	
					
				}
								//EliActivarminar los datos de la categoria
								public function activar($categoria){
									$db=DB::conectar();
									$update=$db->prepare('UPDATE categoria SET estado = 1 WHERE id = :id;');
									$update->bindValue('id',$categoria->getId());
									$update->execute();	
									
								}

}
?>