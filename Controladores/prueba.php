<?php
require_once('../Modelo/puntoTuristico.php');
require_once('../Modelo/crudPuntoTuristico.php');
require_once('../ConeccionBD/conexion.php');

//crear objeto
$punto = new PuntoTuristico();
$crudPunto = new crudPuntoTuristico();

if (isset($_POST['registrar'])) {
    $punto->setNombre($_POST['nombre']);
	$punto->setDescripcion($_POST['descripcion']);
	$punto->setLatitud($_POST['latitud']);
    $punto->setLonguitud($_POST['longuitud']);
    $punto->setCreador($_POST['ceador']); 
    $punto->setCategoriaId($_POST['categoriaId']);
    $punto->setSubCategoriaId($_POST['subCategoriaId']);
    $punto->setCosto($_POST['costo']);
    $punto->setIdParroquia($_POST['idParroquia']);
	$punto->setTiempoEstimado($_POST['tiempoEstimado']);
	
	
	if ($crudPunto->buscarPuntoTuristico($_POST['nombre'])) {
		$crudPunto->insertar($punto);
		header('Location: ../Vista/PuntosAdmin.php');
	} else {
		echo '<script language="javascript">
		alert("El punto turistico ya Existe");
		window.location.href="../Vista/PuntosAdmin.php";
		</script>
		';
	}
}



?>