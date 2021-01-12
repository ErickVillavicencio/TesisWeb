<?php
require_once('../ConeccionBD/conexion.php');
require_once('../Modelo/ruta.php');

class CrudRuta
{

	public function __construct()
	{
	}

	//inserta los datos del ruta
	public function insertar($ruta)
	{
		$db = DB::conectar();
		$insert = $db->prepare('INSERT INTO ruta (nombre,numeroAdultos,numeroNinios , horaInicio, idUsuario) 
			VALUES(:nombre, :numeroAdultos, :numeroNinios , :horaInicio, :idUsuario)');
		$insert->bindValue('nombre', $ruta->getNombre());
		$insert->bindValue('numeroAdultos', $ruta->getNumeroAdultos());
		$insert->bindValue('numeroNinios', $ruta->getNumeroNinios());
		$insert->bindValue('horaInicio', $ruta->getHoraInicio());
		$insert->bindValue('idUsuario', $ruta->getidUsuario());
		$insert->execute();
	}

	//busca el nombre y el id del usuario de la ruta si existe
	public function buscarRuta($nombre, $idUsuario)
	{
		$db = Db::conectar();
		$select = $db->prepare('SELECT * FROM ruta WHERE nombre=:nombre AND idUsuario=:idUsuario');
		$select->bindValue('nombre', $nombre);
		$select->bindValue('idUsuario', $idUsuario);
		$select->execute();
		$registro = $select->fetch();
		if ($registro['id'] != NULL) {
			$usado = False;
		} else {
			$usado = True;
		}
		return $usado;
	}

	//actualiza los datos de la ruta
	public function actualizar($ruta)
	{
		$db = DB::conectar();
		$update = $db->prepare('UPDATE ruta SET nombre = :nombre, horaInicio= :horaInicio,
					 horaFin = :horaFin, costoTotal = :costoTotal
					 WHERE id = :id;');
		$update->bindValue('id', $ruta->getId());
		$update->bindValue('nombre', $ruta->getNombre());
		$update->bindValue('horaInicio', $ruta->getHoraInicio());
		$update->bindValue('horaFin', $ruta->getHoraFin());
		$update->bindValue('costoTotal', $ruta->getCostoTotal());
		$update->execute();
	}


	//Eliminar los datos del rol
	public function eliminar($ruta)
	{
		$db = DB::conectar();
		$delete = $db->prepare('DELETE from ruta WHERE id = :id ');
		$delete->bindValue('id', $ruta->getId());
		$delete->execute();
	}

}
