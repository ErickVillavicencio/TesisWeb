<?php 
require_once('../Modelo/usuario.php');
require_once('../Modelo/crudUsuario.php');
require_once('../ConeccionBD/conexion.php');

//crear objeto
$usuario = new Usuario(); 
$crud = new CrudUsuario();

//registro por parte del admin
if (isset($_POST['registrar'])) {
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
		header('Location: ../Vista/UsuariosAdmin.php');
	} else {
		echo '<script language="javascript">
		alert("El Usuario ya Existe");
		window.location.href="../Vista/UsuariosAdmin.php";
		</script>
		';
	}
} else {
	header('Location: ../Vista/error.php?mensaje=El correo no es válido');
}
}

//actualizar por parte del admin
if (isset($_POST['actualizar'])) {
	$usuario->setId($_POST['id']);
	$usuario->setNombres($_POST['nombres']);
	$usuario->setApellidos($_POST['apellidos']);
	$usuario->setUsuario($_POST['usuario']);
	$usuario->setCorreo($_POST['correo']);
	$usuario->setRol($_POST['rol']);
	$crud->actualizar($usuario);
	header('Location: ../Vista/UsuariosAdmin.php');
}

//eliminar usuario
if (isset($_POST['eliminar'])) {
	$usuario->setId($_POST['id']);
	$crud->eliminar($usuario);
	header('Location: ../Vista/UsuariosAdmin.php');
}

//activar usuario
if (isset($_POST['activar'])) {
	$usuario->setId($_POST['id']);
	$crud->eliminar($usuario);
	header('Location: ../Vista/UsuariosAdmin.php');
}


//actualizar la contrasenia
if (isset($_POST['actualizarContrasenia'])) {

	$usuario->setId($_POST['id']);
	$usuario->setClave($_POST['clave']);
	$crud->actuaizarpass($usuario);
	header('Location: ../Vista/index.php');
}


?>