<?php
require_once('../ConeccionBD/conexion.php');
require_once('../Modelo/puntosRuta.php');


class CrudPuntosRuta
{

	public function __construct()
	{
	}


	//inserta los datos de los puntosruta
	public function insertar($puntosRuta)
	{
		$db = DB::conectar();
		$insert = $db->prepare('INSERT INTO puntosruta (idPunto , idRuta) 
			VALUES(:idPunto , :idRuta)');
		$insert->bindValue('idPunto', $puntosRuta->getIdPunto());
		$insert->bindValue('idRuta', $puntosRuta->getIdRuta());
		$insert->execute();
	}

	//Eliminar el punto ruta
	public function eliminar($puntosRuta)
	{
		$db = DB::conectar();
		$delete = $db->prepare('DELETE FROM puntosruta WHERE idRuta = :idRuta AND idPunto = :idPunto');
		$delete->bindValue('idRuta', $puntosRuta->getIdRuta());
		$delete->bindValue('idPunto', $puntosRuta->getIdPunto());
		$delete->execute();
	}



	//busca el id del punto ruta si existe
	public function buscarPuntosRuta($idPunto, $idRuta)
	{
		$db = Db::conectar();
		$select = $db->prepare('SELECT * FROM puntosruta WHERE idPunto=:idPunto AND idRuta=:idRuta');
		$select->bindValue('idPunto', $idPunto);
		$select->bindValue('idRuta', $idRuta);
		$select->execute();
		$registro = $select->fetch();
		if ($registro['id'] != NULL) {
			$usado = False;
		} else {
			$usado = True;
		}
		return $usado;
	}

	//Eliminar todos los  punto  de la ruta
	public function eliminartodo($puntosRuta)
	{
		$db = DB::conectar();
		$delete = $db->prepare('DELETE FROM puntosruta WHERE idRuta = :idRuta');
		$delete->bindValue('idRuta', $puntosRuta->getIdRuta());
		$delete->execute();
	}

}
