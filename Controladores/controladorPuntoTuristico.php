<?php
require_once('../Modelo/puntoTuristico.php');
require_once('../Modelo/imagen.php');
require_once('../Modelo/crudPuntoTuristico.php');
require_once('../Modelo/crudImagen.php');
require_once('../ConeccionBD/conexion.php');

//crear objeto
$punto = new PuntoTuristico();
$imagen = new Imagen();
$imagen2 = new Imagen();
$imagen3 = new Imagen();
$crudPunto = new crudPuntoTuristico();
$crudImagen = new crudImagen();

if (isset($_POST['registrar'])) {



    $punto->setNombre($_POST['nombre']);
	$punto->setDescripcion($_POST['descripcion']);
	$punto->setLatitud($_POST['latitud']);
    $punto->setLonguitud($_POST['longuitud']);
    $punto->setCreador($_POST['ceador']); 
    $punto->setCategoriaId($_POST['categoriaId']);
    $punto->setSubCategoriaId($_POST['subCategoriaId']);
	$punto->setCosto($_POST['costo']);
	$punto->setCostoN($_POST['costoN']);
	$punto->setIdParroquia($_POST['idParroquia']);
	$punto->setFacebook($_POST['facebook']);
	$punto->setTwitter($_POST['twitter']);
	$punto->setInstagram($_POST['instagram']);
	$punto->setTiempoEstimado($_POST['tiempoEstimado']);

	$file = $_FILES['imagen']; //Asignamos el contenido del parametro a una variable para su mejor manejo		
		$temName = $file['tmp_name']; //Obtenemos el directorio temporal en donde se ha almacenado el archivo;
		$fileName = $file['name']; //Obtenemos el nombre del archivo
		$fileExtension = substr(strrchr($fileName, '.'), 1); //Obtenemos la extensiÃ³n del archivo.
		$fp = fopen($temName, "rb");//abrimos el archivo con permiso de lectura
		$contenido = fread($fp, filesize($temName));//leemos el contenido del archivo
		$contenido = addslashes($contenido);//se escapan los caracteres especiales
		fclose($fp);//Cerramos el archivo

		$file2 = $_FILES['imagen2'];
		$temName2 = $file2['tmp_name'];
		$fileName2 = $file2['name'];
		$fileExtension2 = substr(strrchr($fileName2, '.'), 1); 
		$fp2 = fopen($temName2, "rb");
		$contenido2 = fread($fp2, filesize($temName2));
		$contenido2 = addslashes($contenido2);
		fclose($fp2);

		$file3 = $_FILES['imagen3'];	
		$temName3 = $file3['tmp_name']; 
		$fileName3 = $file3['name']; 
		$fileExtension3 = substr(strrchr($fileName3, '.'), 1); 
		$fp3 = fopen($temName3, "rb");
		$contenido3 = fread($fp3, filesize($temName3));
		$contenido3 = addslashes($contenido3);
		fclose($fp3);
	
	//nombre del punto turistico
	$nombre=$_POST['nombre'];
	//=========================//

	$direccion="../Vista/imagenes/".$fileName;
	$direccionG="imagenes/".$fileName;
	$imagen->setNombre($fileName);
	$imagen->setDireccion($direccionG);
	$imagen->setExtencion($fileExtension);
	
	$direccion2="../Vista/imagenes/".$fileName2;
	$direccionG2="imagenes/".$fileName2;
	$imagen2->setNombre($fileName2);
	$imagen2->setDireccion($direccionG2);
	$imagen2->setExtencion($fileExtension2);

	$direccion3="../Vista/imagenes/".$fileName3;
	$direccionG3="imagenes/".$fileName3;
	$imagen3->setNombre($fileName3);
	$imagen3->setDireccion($direccionG3);
	$imagen3->setExtencion($fileExtension3);
	

	if ($crudPunto->buscarPuntoTuristico($_POST['nombre'])) {
		move_uploaded_file($temName,$direccion);
		move_uploaded_file($temName2,$direccion2);
		move_uploaded_file($temName3,$direccion3);
		$crudPunto->insertar($punto);
		if ($crudImagen->buscarImagen($direccionG , $direccionG2 , $direccionG3 )) {
			$crudImagen->insertar($imagen,$imagen2,$imagen3,$nombre);
			
			echo '<script language="javascript">
			alert("Registrado exitosamente");
			window.location.href="../Vista/PuntosAdmin.php";
			</script>';
			
		}else{
			echo '<script language="javascript">
			alert("La imagen ya existe");
			window.location.href="../Vista/PuntosAdmin.php";
			</script>
			';
		}

	} else {
		echo '<script language="javascript">
		alert("El punto turistico ya Existe");
		window.location.href="../Vista/PuntosAdmin.php";
		</script>
		';
	}
		
}
	
//actualizar punto turistico
if (isset($_POST['actualizar'])) {

	$punto->setId($_POST['id']);
    $punto->setNombre($_POST['nombre']);
	$punto->setDescripcion($_POST['descripcion']);
	$punto->setLatitud($_POST['latitud']);
    $punto->setLonguitud($_POST['longuitud']);
    $punto->setCreador($_POST['ceador']); 
    $punto->setCategoriaId($_POST['categoriaId']);
    $punto->setSubCategoriaId($_POST['subCategoriaId']);
	$punto->setCosto($_POST['costo']);
	$punto->setCostoN($_POST['costoN']);
	$punto->setIdParroquia($_POST['idParroquia']);
	$punto->setFacebook($_POST['facebook']);
	$punto->setTwitter($_POST['twitter']);
	$punto->setInstagram($_POST['instagram']);
	$punto->setTiempoEstimado($_POST['tiempoEstimado']);
	$crudPunto->actualizar($punto);
	header('Location: ../Vista/PuntosAdmin.php');
}


//eliminar punto turistico
if (isset($_POST['eliminar'])) {
	$punto->setId($_POST['id']);
	$crudPunto->eliminar($punto);
	header('Location: ../Vista/PuntosAdmin.php');
}

//activar punto turistico
if (isset($_POST['activar'])) {
	$punto->setId($_POST['id']);
	$crudPunto->activar($punto);
	header('Location: ../Vista/PuntosAdmin.php');
}


?>