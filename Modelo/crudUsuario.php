<?php 
	require_once('../ConeccionBD/conexion.php');
	require_once('../Modelo/usuario.php');
	
	class CrudUsuario{

		public function __construct(){}

		//inserta los datos del usuario
		public function insertar($usuario){

			$db=DB::conectar();
			$insert=$db->prepare('INSERT INTO usuario (nombres, apellidos, correo, usuario, clave, idRol, estado) 
			VALUES(:nombres, :apellidos, :correo, :usuario, :clave, :idRol, 1)');
			$insert->bindValue('nombres',$usuario->getNombres());
			$insert->bindValue('apellidos',$usuario->getApellidos());
			$insert->bindValue('usuario',$usuario->getUsuario());
			$insert->bindValue('correo',$usuario->getCorreo());
			$insert->bindValue('idRol',$usuario->getRol());
			//encripta la clave
			$pass=password_hash($usuario->getClave(),PASSWORD_DEFAULT);
			$insert->bindValue('clave',$pass);
			$insert->execute();					
		}


		//obtiene el usuario para el login
		public function obtenerUsuario($usuario, $clave){
			$db=Db::conectar();
			$select=$db->prepare('SELECT * FROM usuario WHERE usuario=:usuario');
			$select->bindValue('usuario',$usuario);
			$select->execute();
			$registro=$select->fetch();
			$usuario=new Usuario();
			//verifica si la clave es correcta
			if (password_verify($clave, $registro['clave'])) {				
				//si es correcta, asigna los valores que trae desde la base de datos
				$usuario->setId($registro['id']);
				$usuario->setNombres($registro['nombres']);
				$usuario->setApellidos($registro['apellidos']);
				$usuario->setUsuario($registro['usuario']);
				$usuario->setCorreo($registro['correo']);
				$usuario->setClave($registro['clave']);
				$usuario->setRol($registro['idRol']); 
			}			
			return $usuario;
		}

		//busca el nombre del usuario si existe
		public function buscarUsuario($nombres){
			$db=Db::conectar();
			$select=$db->prepare('SELECT * FROM usuario WHERE usuario=:usuario');
			$select->bindValue('usuario',$nombres);
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
				public function actualizar($usuario){
					$db=DB::conectar();
					$update=$db->prepare('UPDATE usuario SET nombres = :nombres , apellidos = :apellidos 
					, usuario = :usuario , idRol = :rol , correo = :correo WHERE id = :id;');
					$update->bindValue('id',$usuario->getId());
					$update->bindValue('nombres',$usuario->getNombres());
					$update->bindValue('apellidos',$usuario->getApellidos());
					$update->bindValue('usuario',$usuario->getUsuario());
					$update->bindValue('correo',$usuario->getCorreo());
					$update->bindValue('rol',$usuario->getRol());
					$update->execute();	
				}

				//Eliminar los datos del usuario
				public function eliminar($usuario){
					$db=DB::conectar();
					$update=$db->prepare('UPDATE usuario SET estado = 0 WHERE id = :id;');
					$update->bindValue('id',$usuario->getId());
					$update->execute();	
					
				}

				//activar los datos del usuario
				public function activar($usuario){
					$db=DB::conectar();
					$update=$db->prepare('UPDATE usuario SET estado = 1 WHERE id = :id;');
					$update->bindValue('id',$usuario->getId());
					$update->execute();	
					
				}
				public function actuaizarpass($usuario){

					$db=DB::conectar();
					$update=$db->prepare('UPDATE usuario SET clave = :clave WHERE id = :id;');
					$update->bindValue('id',$usuario->getId());
					//encripta la clave
					$pass=password_hash($usuario->getClave(),PASSWORD_DEFAULT);
					$update->bindValue('clave',$pass);
					$update->execute();	
				}
				

}
?>