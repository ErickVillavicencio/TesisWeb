<?php
require_once('../Modelo/rol.php');
require_once('../Modelo/crudRol.php');
require_once('../ConeccionBD/conexion.php');

$rol = new Rol();
$crudRol = new CrudRol();

//registro rol 
if (isset($_POST['registrar'])) {
	$rol->setDescripcion($_POST['descripcion']);
	if ($crudRol->buscarRol($_POST['descripcion'])) {
		$crudRol->insertar($rol);
		header('Location: ../Vista/RolesAdmin.php');
	} else {
		echo '<script language="javascript">
		alert("El Rol ya Existe");
		window.location.href="../Vista/UsuariosAdmin.php";
		</script>
		';
	}
}

//actualizar rol 
if (isset($_POST['actualizar'])) {
	$rol->setId($_POST['id']);
	$rol->setDescripcion($_POST['descripcion']);
	$crudRol->actualizar($rol);
	header('Location: ../Vista/RolesAdmin.php');
}

//eliminar rol
if (isset($_POST['eliminar'])) {
	$rol->setId($_POST['id']);
	$crudRol->eliminar($rol);
	header('Location: ../Vista/RolesAdmin.php');
}

//activar rol
if (isset($_POST['activar'])) {
	$rol->setId($_POST['id']);
	$crudRol->activar($rol);
	header('Location: ../Vista/RolesAdmin.php');
}

?>