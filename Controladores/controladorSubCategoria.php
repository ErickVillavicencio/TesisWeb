<?php
require_once('../Modelo/subCategoria.php');
require_once('../Modelo/crudSubCategoria.php');
require_once('../ConeccionBD/conexion.php');

//crear objeto
$subcategoria = new SubCategoria();
$crudSubCategoria = new CrudSubCategoria();

//registro de sub categoria 
if (isset($_POST['registrar'])) {
	$subcategoria->setDescripcion($_POST['descripcion']);
	$subcategoria->setidCategoria($_POST['idCategoria']);
	if ($crudSubCategoria->buscarSubCategoria($_POST['descripcion'])) {
		$crudSubCategoria->insertar($subcategoria);
		header('Location: ../Vista/subCategoriasAdmin.php');
	} else {
		echo '<script language="javascript">
		alert("la succategoria ya Existe");
		window.location.href="../Vista/subCategoriasAdmin.php";
		</script>
		';
	}
}

//actualizar subcategoria 
if (isset($_POST['actualizar'])) {
	$subcategoria->setId($_POST['id']);
	$subcategoria->setDescripcion($_POST['descripcion']);	
	$subcategoria->setidCategoria($_POST['idCategoria']);
	$crudSubCategoria->actualizar($subcategoria);
	header('Location: ../Vista/subCategoriasAdmin.php');
}

//eliminar subcategoria
if (isset($_POST['eliminar'])) {
	$subcategoria->setId($_POST['id']);
	$crudSubCategoria->eliminar($subcategoria);
	header('Location: ../Vista/subCategoriasAdmin.php');
} 

//activar subcategoria
if (isset($_POST['activar'])) {
	$subcategoria->setId($_POST['id']);
	$crudSubCategoria->activar($subcategoria);
	header('Location: ../Vista/subCategoriasAdmin.php');
} 

?>