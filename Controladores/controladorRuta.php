<?php
require_once('../Modelo/ruta.php');
require_once('../Modelo/crudRuta.php');
require_once('../Modelo/puntosRuta.php');
require_once('../Modelo/crudPuntosRuta.php');
require_once('../ConeccionBD/conexion.php');

$ruta = new Ruta();
$crudRuta = new crudRuta();
$puntosRuta = new PuntosRuta();
$crudPuntosRuta = new CrudPuntosRuta();

//registro ruta
if (isset($_POST['registrar'])) {

	$hora = $_POST['horaInicio'];
	$fecha = $_POST['fecha'];
	$horaInicio = $fecha . " " . $hora . ":00";

	$ruta->setNombre($_POST['nombre']);
	$ruta->setNumeroAdultos($_POST['numeroAdultos']);
	$ruta->setNumeroNinios($_POST['numeroNinios']);
	$ruta->setHoraInicio($horaInicio);
	$ruta->setIdUsuario($_POST['idUsuario']);
	if ($crudRuta->buscarRuta($_POST['nombre'], $_POST['idUsuario'])) {
		$crudRuta->insertar($ruta);
		$nombre = $_POST['nombre'];
		header("Location: ../Vista/TuristaAdmin.php?nombre='$nombre'");
	} else {
		echo '<script language="javascript">
		alert("La ruta ya existe");
		window.location.href="../Vista/InicioTurista.php";
		</script>
		';
	}
}


//actualizar ruta 
if (isset($_POST['actualizar'])) {

$segundosL = $_POST['segundos']; 
$minutosL = $_POST['minutos']; 
$horasL = $_POST['horas']; 

//echo('recibe horas = '.$horasL.'  minutos='.$minutosL.'   segundos = '.$segundosL);

$idRuta = $_POST['idRuta']; 
//obtener fecha y hora de la ruta
$db = Db::conectar();
$select = $db->prepare("SELECT * FROM ruta WHERE id = '$idRuta' ");
$select->execute();
while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
  $idruta = $row['id'];
  $nombreRuta = $row['nombre'];
  $fecha = $row['horaInicio'];
  $idUsuario = $row['idUsuario'];
  $nAdultos = $row['numeroAdultos'];
  $nNinio= $row['numeroNinios']; 
}

//____________________________________________//
//obtener la suma del tiempo estimado de los puntos segun la ruta //
$select = $db->prepare("SELECT 
SEC_TO_TIME(SUM(TIME_TO_SEC(puntoturistico.tiempoEstimado))) suma,
 sum(costo) as totalCostoA, sum(costoN) as totalCostoN
FROM puntoturistico INNER JOIN puntosruta
on puntoturistico.id = puntosruta.idPunto
WHERE puntosruta.idRuta=$idRuta");
$select->execute();
while ($row = $select->fetch(PDO::FETCH_ASSOC)) {

  $total = $row['suma'];
  $costoA = $row['totalCostoA'] * $nAdultos;
  $costoN = $row['totalCostoN'] * $nNinio;
  $costo = $costoA + $costoN;
}
unset($pdo);


//separa en horas minutos y segundos de la  consulta de todaos los tiempos de los puntos seleccioandos para poder sumarla correctamente
$obj_fecha = date_create_from_format('Y-m-d', $total);
$date2 = date_create($total);
$horas = date_format($date2, "H ");
$minutos = date_format($date2, "i ");
$segundos = date_format($date2, "s ");

/*transformo a tipo date par apoder usarlas
$horasL = DateTime::createFromFormat('H', $horasL);
$minutosL = DateTime::createFromFormat('i', $minutosL);
*/

//suma la fecha inicio con las horas totales de la ruta
$mifecha = new DateTime($fecha); 
$mifecha->modify('+'.$horas.' hours'); 
$mifecha->modify('+'.$minutos.' minute'); 
$mifecha->modify('+'.$segundos.' second'); 
//sumo el tiempo entre puntos a la fecha
$mifecha->modify('+'.$horasL.' hours'); 
$mifecha->modify('+'.$minutosL.' minute'); 
$mifecha->modify('+'.$segundosL.' second'); 


$horafin = $mifecha->format('Y-m-d H:i:s');
$ruta->setId($idRuta);
$ruta->setNombre($nombreRuta);
$ruta->setHoraInicio($fecha);
$ruta->setIdUsuario($idUsuario);
$ruta->setHoraFin($horafin);
$ruta->setCostoTotal($costo);
$crudRuta->actualizar($ruta);
header("Location:../Vista/ruta.php?id='$idRuta'");
}

//eliminar ruta

if (isset($_POST['eliminar'])) {
	$puntosRuta->setIdRuta($_POST['id']);
	$ruta->setId($_POST['id']);

	$crudPuntosRuta->eliminartodo($puntosRuta);
	$crudRuta->eliminar($ruta);
	header('Location: ../Vista/rutasTurista.php');
}