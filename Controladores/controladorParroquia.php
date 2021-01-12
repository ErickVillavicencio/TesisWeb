<?php
require_once('../Modelo/parroquia.php');
require_once('../Modelo/crudParroquia.php');
require_once('../ConeccionBD/conexion.php');

//crear objeto
$parroquia = new Parroquia();
$crudParroquia = new crudParroquia();

//registro de parroquia
if (isset($_POST['registrar'])) {
	$parroquia->setDescripcion($_POST['descripcion']);
	$parroquia->setLatitud($_POST['latitud']);
	$parroquia->setLonguitud($_POST['longuitud']);
	if ($crudParroquia->buscarParroquia($_POST['descripcion'])) {
		$crudParroquia->insertar($parroquia);
		header('Location: ../Vista/ParroquiasAdmin.php');
	} else {
		echo '<script language="javascript">
		alert("La parroquia ya Existe");
		window.location.href="../Vista/ParroquiasAdmin.php";
		</script>
		';
	}
}

//actualizar parroquia
if (isset($_POST['actualizar'])) {
	$parroquia->setId($_POST['id']);
	$parroquia->setDescripcion($_POST['descripcion']);
	$parroquia->setLatitud($_POST['latitud']);
	$parroquia->setLonguitud($_POST['longuitud']);
	$crudParroquia->actualizar($parroquia);
	header('Location: ../Vista/ParroquiasAdmin.php');
}

//eliminar parroquia
if (isset($_POST['eliminar'])) {
	$parroquia->setId($_POST['id']);
	$crudParroquia->eliminar($parroquia);
	header('Location: ../Vista/ParroquiasAdmin.php');
}

//activar parroquia
if (isset($_POST['activar'])) {
	$parroquia->setId($_POST['id']);
	$crudParroquia->activar($parroquia);
	header('Location: ../Vista/ParroquiasAdmin.php');
}
?>