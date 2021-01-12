<?php

require_once('../Modelo/puntosRuta.php');
require_once('../Modelo/crudPuntosRuta.php');
require_once('../ConeccionBD/conexion.php');

$ruta=$_POST['idRuta'];
$punto=$_POST['idPunto'];


$puntosRuta = new PuntosRuta();
$crudPuntosRuta = new CrudPuntosRuta(); 

if (isset($_POST['registrar'])) {
	$puntosRuta->setIdPunto($punto);
	$puntosRuta->setIdRuta($ruta);  
	if ($crudPuntosRuta->buscarPuntosRuta($punto, $ruta)) {
		$crudPuntosRuta->insertar($puntosRuta);       
		echo json_encode(array('success' => 1));        
	}
	else {
		echo json_encode(array('success' => 0));
	}
}


//eliminar punto ruta
if (isset($_POST['eliminar'])) {
	$puntosRuta->setIdPunto($punto);
	$puntosRuta->setIdRuta($ruta);
	$crudPuntosRuta->eliminar($puntosRuta);
	echo json_encode(array('success' => 2));
}


?>