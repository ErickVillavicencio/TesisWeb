<?php 
	require_once('../ConeccionBD/conexion.php');
	require_once('../Modelo/puntoTuristico.php');
	
	class crudPuntoTuristico{

		public function __construct(){}

		//inserta los datos del usuario
		public function insertar($puntoTuristico){
			$db=DB::conectar();
			$insert=$db->prepare('INSERT INTO puntoturistico (nombre, descripcion, latitud,
			 longuitud, creador, categoriaId, subCategoriaId, costo, idParroquia, tiempoEstimado, 
			 estado,costoN,facebook,twitter,instagram) 
			VALUES(:nombre, :descripcion, :latitud, :longuitud, :creador, :categoriaId, :subCategoriaId, 
			:costo, :idParroquia, :tiempoEstimado,1,:costoN,:facebook,:twitter,:instagram)');
			$insert->bindValue('nombre',$puntoTuristico->getNombre());
			$insert->bindValue('descripcion',$puntoTuristico->getDescripcion());
			$insert->bindValue('latitud',$puntoTuristico->getLatitud());
			$insert->bindValue('longuitud',$puntoTuristico->getLonguitud());
			$insert->bindValue('creador',$puntoTuristico->getCreador());
			$insert->bindValue('categoriaId',$puntoTuristico->getCategoriaId());
			$insert->bindValue('subCategoriaId',$puntoTuristico->getSubCategoriaId());
			$insert->bindValue('costo',$puntoTuristico->getCosto());
			$insert->bindValue('costoN',$puntoTuristico->getCostoN());
			$insert->bindValue('idParroquia',$puntoTuristico->getIdParroquia());
			$insert->bindValue('tiempoEstimado',$puntoTuristico->getTiempoEstimado());
			$insert->bindValue('facebook',$puntoTuristico->getFacebook());
			$insert->bindValue('twitter',$puntoTuristico->getTwitter());
			$insert->bindValue('instagram',$puntoTuristico->getInstagram());
			$insert->execute();			
			
		}

		//busca el nombre del punto si existe
		public function buscarPuntoTuristico($nombre){
			$db=Db::conectar();
			$select=$db->prepare('SELECT * FROM puntoturistico WHERE nombre=:nombre');
			$select->bindValue('nombre',$nombre);
			$select->execute();
			$registro=$select->fetch();
			if($registro['id']!=NULL){
				$usado=False;
			}else{
				$usado=True;
			}	
			return $usado;
		}

				//actualiza los datos del punto turistico
				public function actualizar($puntoTuristico){				
					$db=DB::conectar();
					$update=$db->prepare('UPDATE puntoturistico SET nombre= :nombre, descripcion = :descripcion 
					, latitud = :latitud, longuitud = :longuitud, creador = :creador, categoriaId = :categoriaId,
					subCategoriaId = :subCategoriaId, costo = :costo, idParroquia = :idParroquia, tiempoEstimado = :tiempoEstimado, 
					costoN = :costoN ,facebook = :facebook,twitter = :twitter,instagram= :instagram
					 WHERE id = :id;');
					$update->bindValue('id',$puntoTuristico->getId()); 
					$update->bindValue('nombre',$puntoTuristico->getNombre());
					$update->bindValue('descripcion',$puntoTuristico->getDescripcion());
					$update->bindValue('latitud',$puntoTuristico->getLatitud());
					$update->bindValue('longuitud',$puntoTuristico->getLonguitud());
					$update->bindValue('creador',$puntoTuristico->getCreador());
					$update->bindValue('categoriaId',$puntoTuristico->getCategoriaId());
					$update->bindValue('subCategoriaId',$puntoTuristico->getSubCategoriaId());
					$update->bindValue('costo',$puntoTuristico->getCosto());
					$update->bindValue('costoN',$puntoTuristico->getCostoN());
					$update->bindValue('idParroquia',$puntoTuristico->getIdParroquia());
					$update->bindValue('tiempoEstimado',$puntoTuristico->getTiempoEstimado());
					$update->bindValue('facebook',$puntoTuristico->getFacebook());
					$update->bindValue('twitter',$puntoTuristico->getTwitter());
					$update->bindValue('instagram',$puntoTuristico->getInstagram());
					$update->execute();				
				}
				
				//Eliminar los datos del puntoTuristico
				public function eliminar($puntoTuristico){
					$db=DB::conectar();
					$update=$db->prepare('UPDATE puntoturistico SET estado = 0 WHERE id = :id;');
					$update->bindValue('id',$puntoTuristico->getId());
					$update->execute();	
					
				}
				//Activar los datos del puntoTuristico
				public function activar($puntoTuristico){
					$db=DB::conectar();
					$update=$db->prepare('UPDATE puntoturistico SET estado = 1 WHERE id = :id;');
					$update->bindValue('id',$puntoTuristico->getId());
					$update->execute();		
				}
				

}
