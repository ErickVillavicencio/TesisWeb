<?php
require_once('../Modelo/usuario.php');
require_once('../Modelo/crudUsuario.php');
require_once('../ConeccionBD/conexion.php');

//inicio de sesion
session_start();
$_SESSION['prueba'] = '1';
//crear objeto
$usuario = new Usuario(); 
$crud = new CrudUsuario();

//Variables para registar
if (isset($_POST['registrarse'])) {
	$usuario->setUsuario($_POST['usuario']);
	$usuario->setClave($_POST['pas']);
	$usuario->setNombres($_POST['nombres']);
	$usuario->setApellidos($_POST['apellidos']);
	$usuario->setCorreo($_POST['correo']);
	$usuario->setRol($_POST['rol']);

	//valido si el correo es correcto
	$correo = $_POST['correo'];
	// filter_var regresa los datos filtrados
	$correo = filter_var($correo, FILTER_VALIDATE_EMAIL);
	// regresa false si no son válidos
	if ($correo !== false) {
		//La dirección $correo es válida
		if ($crud->buscarUsuario($_POST['usuario'])) {
			$crud->insertar($usuario);
			header('Location: ../Vista/index.php');
		} else {
			header('Location: ../Vista/error.php?mensaje=El nombre de usuario ya existe');
		}

	} else {
		header('Location: ../Vista/error.php?mensaje=El correo no es válido');
	}

} elseif (isset($_POST['entrar'])) { //verifica si la variable entrar está definida
	$usuario = $crud->obtenerUsuario($_POST['usuario'], $_POST['pas']);
	// si el id del objeto retornado no es null, quiere decir que encontro un registro en la base
	if ($usuario->getId() != NULL) {
		$_SESSION['usuario'] = $usuario; //si el usuario se encuentra, crea la sesión de usuario
		if ($usuario->getRol() == 1) {
			header('Location: ../Vista/RolesAdmin.php');
		}
		if ($usuario->getRol() == 2) {
			header('Location: ../Vista/ParroquiasAdmin.php');
		}
		if ($usuario->getRol() == 3) {
			header('Location: ../Vista/inicioTurista.php');
		}
	} else {
		header('Location: ../Vista/errorLogin.php?mensaje=Tus nombre de usuario o clave son incorrectos'); // cuando los datos son incorrectos envia a la página de error
	}
} elseif (isset($_POST['salir'])) { // cuando presiona el botòn salir
	header('Location: ../Vista/index.php');
	unset($_SESSION['usuario']); //destruye la sesión
}
