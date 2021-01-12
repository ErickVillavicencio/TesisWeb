<?php
require_once('../ConeccionBD/conexion.php');
require_once('../Modelo/imagen.php');

class crudImagen
{

	public function __construct()
	{
	}

	//inserta los datos de la imagen
	public function insertar($imagen, $imagen2, $imagen3, $nombre)
	{
		$db = DB::conectar();

		$select = $db->prepare('SELECT * FROM puntoturistico WHERE nombre=:nombre');
		$select->bindValue('nombre', $nombre);
		$select->execute();
		$registro = $select->fetch();
		$id = $registro['id'];

		echo $id;


		$insert = $db->prepare("INSERT INTO imagen (nombre, direccion, extencion,idPuntoTuristico,categoria) 
			VALUES(:nombre, :direccion, :extencion, $id , 1),			
				  (:nombre2, :direccion2, :extencion2, $id , 2),
				  (:nombre3, :direccion3, :extencion3, $id , 2)");
		$insert->bindValue('nombre', $imagen->getNombre());
		$insert->bindValue('direccion', $imagen->getDireccion());
		$insert->bindValue('extencion', $imagen->getExtencion());

		$insert->bindValue('nombre2', $imagen2->getNombre());
		$insert->bindValue('direccion2', $imagen2->getDireccion());
		$insert->bindValue('extencion2', $imagen2->getExtencion());

		$insert->bindValue('nombre3', $imagen3->getNombre());
		$insert->bindValue('direccion3', $imagen3->getDireccion());
		$insert->bindValue('extencion3', $imagen3->getExtencion());

		$insert->execute();
	}

	//busca el nombre de las imagenes

	public function buscarImagen($direccion, $direccion2, $direccion3)
	{
		$db = Db::conectar();
		$select = $db->prepare('SELECT * FROM imagen WHERE extencion=:imagen || :imagen2 || :imagen3');
		$select->bindValue('imagen', $direccion);
		$select->bindValue('imagen2', $direccion2);
		$select->bindValue('imagen3', $direccion3);
		$select->execute();
		$registro = $select->fetch();
		if ($registro['id'] != NULL) {
			$usado = False;
		} else {
			$usado = True;
		}
		return $usado;
	}

	//actualiza los datos de la imagen
	public function actualizar($imagen)
	{
		$db = DB::conectar();
		$update = $db->prepare('UPDATE imagen SET nombre = :nombre, 
							direccion = :direccion, extencion = :extencion, 
							categoria = :categoria   WHERE id = :id;');

		$update->bindValue('id', $imagen->getId());
		$update->bindValue('nombre', $imagen->getNombre());
		$update->bindValue('direccion', $imagen->getDireccion());
		$update->bindValue('extencion', $imagen->getExtencion());
		$update->bindValue('categoria', $imagen->getCategoria());
		$update->execute();
	}
}
