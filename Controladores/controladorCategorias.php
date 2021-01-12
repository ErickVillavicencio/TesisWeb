<?php
require_once('../Modelo/categoria.php');
require_once('../Modelo/crudCategoria.php');
require_once('../ConeccionBD/conexion.php');

//crear objeto
$categoria = new Categoria();
$crudCategoria = new crudCategoria();

//registro categoria 
if (isset($_POST['registrar'])) {
	$categoria->setDescripcion($_POST['descripcion']);
	if ($crudCategoria->buscarCategoria($_POST['descripcion'])) {
		$crudCategoria->insertar($categoria);
		header('Location: ../Vista/categoriasAdmin.php');
	} else {
		echo '<script language="javascript">
		alert("la catogoria  ya Existe");
		window.location.href="../Vista/categoriasAdmin.php";
		</script>
		';
	}
}

//actualizar categoria 
if (isset($_POST['actualizar'])) {
	$categoria->setId($_POST['id']);
	$categoria->setDescripcion($_POST['descripcion']);
	$crudCategoria->actualizar($categoria);
	header('Location: ../Vista/categoriasAdmin.php');
}

//eliminar categoria
if (isset($_POST['eliminar'])) {
	$categoria->setId($_POST['id']);
	$crudCategoria->eliminar($categoria);
	header('Location: ../Vista/categoriasAdmin.php');
}

//eliminar categoria
if (isset($_POST['activar'])) {
	$categoria->setId($_POST['id']);
	$crudCategoria->activar($categoria);
	header('Location: ../Vista/categoriasAdmin.php');
}

?>