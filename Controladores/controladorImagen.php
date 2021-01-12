<?php
require_once('../Modelo/imagen.php');
require_once('../Modelo/crudImagen.php');
require_once('../ConeccionBD/conexion.php');

//crear objeto
$imagen = new Imagen();
$crudImagen = new crudImagen();

if (isset($_POST['actualizar'])) {


		$idPunto = $_POST['idPuntoTuristico'];
		$file = $_FILES['imagen']; //Asignamos el contenido del parametro a una variable para su mejor manejo		
		$temName = $file['tmp_name']; //Obtenemos el directorio temporal en donde se ha almacenado el archivo;
		$fileName = $file['name']; //Obtenemos el nombre del archivo
		$fileExtension = substr(strrchr($fileName, '.'), 1); //Obtenemos la extensiÃ³n del archivo.
		$fp = fopen($temName, "rb");//abrimos el archivo con permiso de lectura
		$contenido = fread($fp, filesize($temName));//leemos el contenido del archivo
		$contenido = addslashes($contenido);//se escapan los caracteres especiales
		fclose($fp);//Cerramos el archivo

		//direccionde la imagen actual para remplazar
		$direccionActual=$_POST['direccion'];

		$direccion="../Vista/imagenes/".$fileName;
		$direccionG="imagenes/".$fileName;
		$imagen->setId($_POST['id']);
        $imagen->setNombre($fileName);
        $imagen->setDireccion($direccionG);
        $imagen->setExtencion($fileExtension);
		$imagen->setCategoria($_POST['categoria']);		


		//borro el archivo actual para remplazarlo xon el nuevo
		unlink("../Vista/".$direccionActual);
		move_uploaded_file($temName,$direccion);

$crudImagen->actualizar($imagen);

	
	header("Location: ../Vista/imagenesAdmin.php?id='$idPunto'");	

	
}
