<?php

if (isset($_POST['salir'])) { // cuando presiona el botòn salir
	header('Location: ../Vista/index.php');
	session_destroy();
	unset($_SESSION['usuario']); //destruye la sesión
}  

?>
